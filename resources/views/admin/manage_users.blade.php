@include('admin.header')
<!-- Main Content -->
<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">User Account Management</h2>
            <p class="text-muted small mb-0">Search, edit, verify, or manage customer banking accounts.</p>
        </div>
    </div>

    <!-- Customers Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Recent Users</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search...">
                <button class="btn btn-sm btn-outline-secondary text-nowrap">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
        
         @if(session('status') || session('message'))
    <div class="alert-container">
        <div class="alert alert-{{ session('status') ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            <div class="alert-content">
                <div class="alert-icon">
                    @if(session('status'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    @endif
                </div>
                <div class="alert-text">
                    {{ session('status') ?? session('message') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="alert-progress"></div>
        </div>
    </div>
@endif

      <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" id="users-table">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th class="d-none d-md-table-cell">Email</th>
                    <th class="d-none d-sm-table-cell">Registered Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>#CUS-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <img src="{{ $user->profile_image ?? 'https://randomuser.me/api/portraits/men/'.rand(1,100).'.jpg' }}" 
                                 class="rounded-circle me-2" width="32" height="32"> --}}
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted d-block d-md-none">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <div>{{ $user->email }}</div>
                        <small class="text-muted">{{ $user->phone ?? '(555) 345-6789' }}</small>
                    </td>
                    <td class="d-none d-sm-table-cell">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('admin.profile', $user->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                             <i class="fas fa-eye"></i>
                             <span class="d-none d-lg-inline"> View</span>
                             </a>
                            <button type="button" class="btn btn-sm btn-outline-success" title="Send Mail">
                                <i class="fas fa-envelope"></i>
                                <span class="d-none d-lg-inline"> Mail</span>
                            </button>
                             <form action="{{route('admin.delete', $user->id) }}" method="POST" class="d-inline mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="text-muted small">
            Showing <span class="fw-semibold">{{ $users->firstItem() }}</span> to 
            <span class="fw-semibold">{{ $users->lastItem() }}</span> of 
            <span class="fw-semibold">{{ $users->total() }}</span> entries
        </div>
        <div class="overflow-auto">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Mail Compose Modal -->
<div class="modal fade" id="mailModal" tabindex="-1" aria-labelledby="mailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mailModalLabel">Send Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mailForm">
                    @csrf
                    <input type="hidden" id="mail_user_id" name="user_id">
                    <div class="mb-3">
                        <label for="mail_subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="mail_subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="mail_message" class="form-label">Message</label>
                        <textarea class="form-control" id="mail_message" name="message" rows="8" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mail_attachments" class="form-label">Attachments</label>
                        <input class="form-control" type="file" id="mail_attachments" name="attachments[]" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendMailBtn">Send Email</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="mailToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Email sent successfully!
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const mailModal = new bootstrap.Modal(document.getElementById('mailModal'));
    const mailToast = new bootstrap.Toast(document.getElementById('mailToast'));
    
    // Handle mail button clicks
    document.querySelectorAll('.btn-outline-success').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const userId = row.querySelector('td:first-child').textContent.replace('#CUS-', '');
            const userName = row.querySelector('.fw-semibold').textContent;
            const userEmail = row.querySelector('.d-none.d-md-table-cell div')?.textContent || 
                             row.querySelector('.text-muted.d-block.d-md-none')?.textContent;
            
            document.getElementById('mailModalLabel').textContent = `Send Email to ${userName}`;
            document.getElementById('mail_user_id').value = userId;
            
            // Pre-fill some fields (optional)
            document.getElementById('mail_subject').value = `Regarding your account`;
            document.getElementById('mail_message').value = `Dear ${userName},\n\n`;
            
            mailModal.show();
        });
    });
    
    // Handle send email button
    document.getElementById('sendMailBtn').addEventListener('click', function() {
        const form = document.getElementById('mailForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.mail.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mailModal.hide();
                mailToast.querySelector('.toast-body').textContent = data.message;
                mailToast.show();
                form.reset();
            } else {
                alert('Error: ' + (data.message || 'Failed to send email'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the email');
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            fetchUsers(url);
        }
    });

    // Initial load
    function fetchUsers(url = null) {
        const fetchUrl = url || '';
        
        fetch(fetchUrl)
            .then(response => response.json())
            .then(data => {
                // Update table body
                document.querySelector('#users-table tbody').innerHTML = data.html;
                
                // Update pagination links
                document.querySelector('.card-footer').innerHTML = data.pagination;
            })
            .catch(error => console.error('Error:', error));
    }

   
});
</script>

@include('admin.footer')