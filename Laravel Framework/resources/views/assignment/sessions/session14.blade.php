@extends('layouts.assignment')

@section('title', 'Session 14: Login Customization & Wishlist Protection')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 14</span> Login Customization &amp; Wishlist Protection</h2>
    <p class="text-muted">Logging in via either username or email, session regeneration, logout invalidation, and protecting wishlist interactions with authentication.</p>
</div>

<div class="row g-4">
    <!-- Login Form -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-box-arrow-in-right text-primary me-2"></i> User Login (Username or Email)
            </div>
            <div class="card-body">
                @if($currentUser)
                    <div class="alert alert-info">
                        You are logged in as <strong>{{ $currentUser->name }}</strong> ({{ $currentUser->role }}).
                        <form action="{{ route('session.14.logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('session.14.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email or Username:</label>
                            <input type="text" name="login" class="form-control form-control-sm @error('login') is-invalid @enderror" value="{{ old('login', 'student') }}" required>
                            @error('login') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password:</label>
                            <input type="password" name="password" class="form-control form-control-sm" value="password123" required>
                            <div class="form-text">Default demo password: <code>password123</code></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Wishlist Protection Demonstration -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-heart-fill text-danger me-2"></i> Wishlist / Favorites Protection</span>
                <span class="badge {{ $currentUser ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $currentUser ? 'Auth Active' : 'Auth Required' }}
                </span>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    Only authenticated users can toggle items into their personal wishlist. Guests attempting to like will be prompted to log in.
                </p>
                <div class="list-group">
                    @foreach($playlists as $playlist)
                        @php $isLiked = in_array($playlist->id, $likedPlaylistIds); @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <div>
                                <div class="fw-bold">{{ $playlist->name }}</div>
                                <div class="small text-muted">Owner: {{ $playlist->user->name ?? 'System' }} | Genre: {{ $playlist->genre->name ?? 'General' }}</div>
                            </div>
                            <form action="{{ route('session.14.wishlist', $playlist->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $isLiked ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    {{ $isLiked ? 'Favorited' : 'Add to Wishlist' }}
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
