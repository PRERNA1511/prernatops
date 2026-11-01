<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Framework Assignment') - Sessions 1 to 25</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- jQuery for AJAX Session 21 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .badge-session {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }
        .card {
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border-radius: 8px;
        }
        .code-block {
            background: #212529;
            color: #f8f9fa;
            padding: 1rem;
            border-radius: 6px;
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.9rem;
            overflow-x: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand text-danger d-flex align-items-center" href="{{ route('assignment.home') }}">
                <i class="bi bi-box-seam me-2"></i> Laravel Assignment (Sessions 1-25)
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('assignment.home') ? 'active' : '' }}" href="{{ route('assignment.home') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-journal-code"></i> Sessions 1 - 10
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('session.01') }}">Session 1: Introduction & MVC</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.02') }}">Session 2: Routing & Parameters</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.03') }}">Session 3: Controllers & Views</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.04') }}">Session 4: Blade Templating</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.05') }}">Session 5: Forms & CSRF</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('session.06') }}">Session 6: Database Config</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.07') }}">Session 7: Migrations & Schema</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.08') }}">Session 8: Seeders & Factories</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.09') }}">Session 9: Eloquent CRUD & Debugbar</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.10') }}">Session 10: Relationships & N+1</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-check"></i> Sessions 11 - 20
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('session.11') }}">Session 11: Form Request Validation</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.12') }}">Session 12: File Uploads & Gallery</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.13') }}">Session 13: Auth Setup & Register</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.14') }}">Session 14: Login & Wishlist</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.15') }}">Session 15: Scopes, Accessors, SQL</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('session.16') }}">Session 16: Mail & Notifications</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.17') }}">Session 17: Events & Queues</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.18') }}">Session 18: Middleware & Security</a></li>
                            <li><a class="dropdown-item" href="{{ url('/api/playlists') }}" target="_blank">Session 19: RESTful API (JSON)</a></li>
                            <li><a class="dropdown-item" href="{{ route('assignment.home') }}#session-20">Session 20: Sanctum Tokens</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-cpu"></i> Sessions 21 - 25
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('session.21') }}">Session 21: jQuery AJAX Search</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.22') }}">Session 22: Performance & Caching</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.23') }}">Session 23: Deployment Audit</a></li>
                            <li><a class="dropdown-item text-primary fw-bold" href="{{ route('playlist.index') }}">Session 24: Mini Project</a></li>
                            <li><a class="dropdown-item" href="{{ route('session.25') }}">Session 25: Code Review & Docs</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger btn-sm text-white px-3 ms-lg-2" href="{{ route('playlist.index') }}">
                            <i class="bi bi-music-note-beamed"></i> Mini Project
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }} ({{ Auth::user()->role }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('session.14.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('session.14') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="main-content py-4">
        <div class="container">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-2"></i> Please correct the following errors:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-auto border-top">
        <div class="container text-center">
            <p class="mb-1"><strong>PHP & Laravel Framework Assignment Project</strong> — Comprehensive practical curriculum (Session 1 to 25).</p>
            <p class="text-secondary small mb-0">Built with Laravel {{ app()->version() }} &amp; PHP {{ PHP_VERSION }}. Clean code designed for academic review and student presentation.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
