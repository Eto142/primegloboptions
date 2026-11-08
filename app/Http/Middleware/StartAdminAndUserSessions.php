<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\Store;

class StartAdminAndUserSessions extends StartSession
{
    public function getSession(Request $request)
    {
        /** @var Store $session */
        $session = $this->manager->driver();
        $cookieName = $request->is('admin', 'admin/*')
            ? config('session.admin_cookie')
            : config('session.cookie');

        $session->flush();
        $session->setName($cookieName);
        $session->setId($request->cookies->get($session->getName()));

        return $session;
    }
}
