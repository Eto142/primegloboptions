@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
            <i class="fas fa-bullseye me-1"></i> SAVINGS
        </span>
        <h2 class="fw-bold text-dark mb-1">Savings Goals</h2>
        <p class="text-muted mb-0">Set a target and keep track of your progress.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3" role="alert">
            <strong>We could not update your savings goals.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info border-0 shadow-sm rounded-3" role="note">
        <i class="fas fa-info-circle me-2"></i>
        Contributions update this progress tracker only; they do not move money or change your account balance.
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                    <h5 class="fw-bold text-dark mb-0">Your goals</h5>
                    <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">{{ $goals->count() }}</span>
                </div>

                @forelse ($goals as $goal)
                    @php
                        $progress = min(100, ($goal->saved_amount / $goal->target_amount) * 100);
                        $remaining = max(0, $goal->target_amount - $goal->saved_amount);
                    @endphp
                    <div class="border rounded-4 p-3 p-md-4 mb-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $goal->name }}</h6>
                                @if ($goal->target_date)
                                    <span class="small text-muted">Target date: {{ $goal->target_date->format('M j, Y') }}</span>
                                @endif
                            </div>
                            @if ($remaining <= 0)
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success">Completed</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between small mt-3 mb-2">
                            <span class="fw-semibold text-dark">{{ Auth::user()->currency }}{{ number_format($goal->saved_amount, 2) }} saved</span>
                            <span class="text-muted">of {{ Auth::user()->currency }}{{ number_format($goal->target_amount, 2) }}</span>
                        </div>
                        <div class="progress rounded-pill mb-3" role="progressbar" aria-label="{{ $goal->name }} progress" aria-valuenow="{{ (int) $progress }}" aria-valuemin="0" aria-valuemax="100" style="height: 10px;">
                            <div class="progress-bar bg-primary rounded-pill" style="width: {{ $progress }}%"></div>
                        </div>

                        @if ($remaining > 0)
                            <form method="POST" action="{{ route('user.savings-goals.contributions.store', $goal) }}" class="row g-2 align-items-end">
                                @csrf
                                <div class="col">
                                    <label for="contribution-{{ $goal->id }}" class="form-label small fw-semibold mb-1">Add progress</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ Auth::user()->currency }}</span>
                                        <input
                                            id="contribution-{{ $goal->id }}"
                                            type="number"
                                            name="amount"
                                            class="form-control"
                                            min="0.01"
                                            max="{{ number_format($remaining, 2, '.', '') }}"
                                            step="0.01"
                                            placeholder="0.00"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                </div>
                            </form>
                            <div class="small text-muted mt-2">{{ Auth::user()->currency }}{{ number_format($remaining, 2) }} left to reach your target.</div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-bullseye fs-2 mb-2"></i>
                        <p class="mb-0">You haven’t created a savings goal yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4">
                <h5 class="fw-bold text-dark mb-3">Create a goal</h5>
                <form method="POST" action="{{ route('user.savings-goals.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="goal-name" class="form-label fw-semibold">Goal name</label>
                        <input id="goal-name" type="text" name="name" class="form-control" maxlength="100" value="{{ old('name') }}" placeholder="For example, Emergency fund" required>
                    </div>
                    <div class="mb-3">
                        <label for="goal-target" class="form-label fw-semibold">Target amount ({{ Auth::user()->currency }})</label>
                        <input id="goal-target" type="number" name="target_amount" class="form-control" min="0.01" max="9999999999999.99" step="0.01" value="{{ old('target_amount') }}" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label for="goal-date" class="form-label fw-semibold">Target date <span class="text-muted fw-normal">(optional)</span></label>
                        <input id="goal-date" type="date" name="target_date" class="form-control" min="{{ now()->toDateString() }}" value="{{ old('target_date') }}">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill w-100">
                        <i class="fas fa-plus me-1"></i> Create savings goal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.footer')
