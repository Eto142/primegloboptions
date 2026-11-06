@include('admin.header')

<div class="main-content p-3 p-md-4" id="mainContent">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">Send Mail to Users</h2>
            <p class="text-muted small mb-0">Compose and send emails directly to any registered user.</p>
        </div>
    </div>

    @if(session('status') || session('message'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div>{{ session('status') ?? session('message') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Compose Panel --}}
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 bg-white rounded-top-4 p-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-pen me-2 text-primary"></i>Compose Email</h5>
                    <p class="text-muted small mb-0">Fill in the fields below and click send.</p>
                </div>
                <div class="card-body p-4">
                    <form id="composeForm">
                        @csrf

                        {{-- Recipient search --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Recipient</label>
                            <input type="hidden" name="user_id" id="selectedUserId">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                       id="userSearch" placeholder="Search by name or email…" autocomplete="off">
                            </div>
                            <div id="userSearchResults" class="list-group mt-1 shadow-sm" style="display:none;position:relative;z-index:50;max-height:200px;overflow-y:auto;"></div>
                            <div id="selectedUserBadge" class="mt-2" style="display:none;">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold" id="selectedUserLabel"></span>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" id="clearUser">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Subject</label>
                            <input type="text" class="form-control" name="subject" id="mailSubject"
                                   placeholder="e.g. Account Update" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Message</label>
                            <textarea class="form-control" name="message" id="mailMessage"
                                      rows="9" placeholder="Write your message here…" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Attachments <span class="text-muted fw-normal">(optional, max 5 MB each)</span></label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" id="sendBtn">
                                <i class="fas fa-paper-plane me-2"></i> Send Email
                            </button>
                            <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>

                        <div id="sendStatus" class="mt-3"></div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Quick-pick user list --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 bg-white rounded-top-4 p-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-success"></i>Quick Select</h5>
                    <p class="text-muted small mb-0">Click a user to pre-fill the recipient field.</p>
                </div>
                <div class="card-body p-0">
                    <div style="max-height:460px;overflow-y:auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small font-monospace">USER</th>
                                    <th class="py-3 text-muted small font-monospace">EMAIL</th>
                                    <th class="pe-4 py-3 text-muted small font-monospace"></th>
                                </tr>
                            </thead>
                            <tbody id="quickUserList">
                                @foreach(\App\Models\User::latest()->take(30)->get() as $u)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold text-dark small">{{ $u->first_name }} {{ $u->last_name }}</div>
                                    </td>
                                    <td class="text-muted small">{{ $u->email }}</td>
                                    <td class="pe-4 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 pick-user"
                                                data-id="{{ $u->id }}"
                                                data-name="{{ $u->first_name }} {{ $u->last_name }}"
                                                data-email="{{ $u->email }}">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── User quick-select ─────────────────────────────────────────────
    document.querySelectorAll('.pick-user').forEach(btn => {
        btn.addEventListener('click', function () {
            selectUser(this.dataset.id, this.dataset.name, this.dataset.email);
        });
    });

    function selectUser(id, name, email) {
        document.getElementById('selectedUserId').value = id;
        document.getElementById('selectedUserLabel').textContent = name + ' <' + email + '>';
        document.getElementById('selectedUserBadge').style.display = 'block';
        document.getElementById('userSearch').value = '';
        document.getElementById('userSearchResults').style.display = 'none';
    }

    document.getElementById('clearUser').addEventListener('click', function () {
        document.getElementById('selectedUserId').value = '';
        document.getElementById('selectedUserBadge').style.display = 'none';
    });

    // ── Live search ───────────────────────────────────────────────────
    let searchTimer;
    document.getElementById('userSearch').addEventListener('input', function () {
        clearTimeout(searchTimer);
        const q = this.value.trim();
        if (q.length < 2) {
            document.getElementById('userSearchResults').style.display = 'none';
            return;
        }
        searchTimer = setTimeout(() => {
            fetch(`/admin/users/search?q=${encodeURIComponent(q)}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => {
                const box = document.getElementById('userSearchResults');
                box.innerHTML = '';
                if (!data.length) {
                    box.innerHTML = '<div class="list-group-item text-muted small">No users found.</div>';
                } else {
                    data.forEach(u => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action small';
                        item.innerHTML = `<strong>${u.first_name} ${u.last_name}</strong> <span class="text-muted">${u.email}</span>`;
                        item.addEventListener('click', () => selectUser(u.id, u.first_name + ' ' + u.last_name, u.email));
                        box.appendChild(item);
                    });
                }
                box.style.display = 'block';
            })
            .catch(() => {});
        }, 300);
    });

    // ── Send form ─────────────────────────────────────────────────────
    document.getElementById('composeForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const userId = document.getElementById('selectedUserId').value;
        if (!userId) {
            showStatus('danger', 'Please select a recipient first.');
            return;
        }

        const btn = document.getElementById('sendBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending…';

        const formData = new FormData(this);
        formData.set('user_id', userId);

        fetch('{{ route("admin.mail.send") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showStatus('success', data.message || 'Email sent successfully!');
                document.getElementById('composeForm').reset();
                document.getElementById('selectedUserId').value = '';
                document.getElementById('selectedUserBadge').style.display = 'none';
            } else {
                showStatus('danger', data.message || 'Failed to send email.');
            }
        })
        .catch(() => showStatus('danger', 'A network error occurred. Please try again.'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Send Email';
        });
    });

    function showStatus(type, msg) {
        const el = document.getElementById('sendStatus');
        el.innerHTML = `<div class="alert alert-${type} border-0 rounded-3 py-2 small">${msg}</div>`;
        setTimeout(() => el.innerHTML = '', 6000);
    }
});
</script>

@include('admin.footer')
