<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SessionCookieIsolationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'session.driver' => 'array',
            'session.admin_cookie' => 'primegloboptions_admin_session',
        ]);

        Route::middleware('web')->get('/session-cookie-probe', fn () => response('ok'));
        Route::middleware('web')->get('/admin/session-cookie-probe', function () {
            session(['session_probe' => 'admin-token']);

            return response(session()->token());
        });
        Route::middleware('web')->post('/admin/session-cookie-probe', function () {
            return response(
                session('session_probe') === 'admin-token'
                    && hash_equals(session()->token(), (string) request('_token'))
                    ? 'csrf-token-matched'
                    : 'csrf-token-mismatched'
            );
        });
    }

    public function test_admin_and_user_routes_issue_separate_session_cookies(): void
    {
        $userResponse = $this->get('/session-cookie-probe');
        $adminResponse = $this->get('/admin/session-cookie-probe');

        $userCookieNames = array_map(
            fn ($cookie) => $cookie->getName(),
            $userResponse->headers->getCookies()
        );
        $adminCookieNames = array_map(
            fn ($cookie) => $cookie->getName(),
            $adminResponse->headers->getCookies()
        );

        $this->assertContains(config('session.cookie'), $userCookieNames);
        $this->assertContains('primegloboptions_admin_session', $adminCookieNames);
        $this->assertNotSame(config('session.cookie'), 'primegloboptions_admin_session');

        $adminCookie = collect($adminResponse->headers->getCookies())
            ->first(fn ($cookie) => $cookie->getName() === 'primegloboptions_admin_session');

        $this->withUnencryptedCookie('primegloboptions_admin_session', $adminCookie->getValue())
            ->post('/admin/session-cookie-probe', ['_token' => $adminResponse->getContent()])
            ->assertContent('csrf-token-matched');
    }
}
