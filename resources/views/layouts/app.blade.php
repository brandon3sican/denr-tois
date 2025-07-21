<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Travel Order System')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>
    @auth
        <div class="sidebar">
            <div class="logo">
                <span><img src="{{ asset('assets/img/denr-logo.png') }}" alt="DENR Logo" height="50" width="50"> TOS</span>
            </div>
            <nav>

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                
                @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> Employees
                    </a>
                    @endif
                @endauth

                <a href="{{ route('travel-orders.index') }}" class="{{ request()->routeIs('travel-orders.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Travel Orders
                </a>

                @auth
                    @if(auth()->user()->is_admin)

                    <hr>
                    
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">User Management</div>
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Location Management</div>
                        <a href="{{ route('regions.index') }}" class="{{ request()->routeIs('regions.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marker-alt"></i> Regions
                        </a>
                        <a href="{{ route('official-stations.index') }}" class="{{ request()->routeIs('official-stations.*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i> Official Stations
                        </a>
                    </div>
                    
                    @endif
                @endauth

            </nav>
        </div>

        <div class="main-content">
            <header class="bg-white shadow-sm py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="welcome-message">
                        <p class="mb-0 text-muted">
                            <i class="fas fa-user-circle me-2" style="color: var(--denr-primary);"></i>
                            Welcome back, 
                            <span class="fw-bold" style="color: var(--denr-primary);">{{ Auth::user()->username }}</span>
                        </p>
                    </div>
                </div>
                <div class="user-actions" style="position: relative;">
                    <div class="dropdown">
                        <button class="btn btn-light rounded-pill px-3 py-1 dropdown-toggle d-flex align-items-center" 
                                type="button" 
                                id="userDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false" 
                                style="position: relative; z-index: 1;">
                            <i class="fas fa-user-circle me-2" style="color: var(--denr-primary);"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                            aria-labelledby="userDropdown"
                            style="min-width: 200px; position: fixed; z-index: 99999;">
                            <li class="text-center">
                                <span class="fw-bold d-block px-3 py-1" style="color: var(--denr-primary);">
                                    {{ Auth::user()->employee->full_name ?? Auth::user()->username }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li class="text-center">
                                <a class="dropdown-item text-danger d-flex align-items-center justify-content-center" 
                                   href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
    @else
        <div class="login-container">
            <div class="login-content">
                @yield('content')
            </div>
        </div>
    @endauth

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
            });
        });
    </script>
    
    <script src="{{ asset('script.js') }}"></script>
    <script src="{{ asset('js/dropdown-fix.js') }}"></script>
    @stack('scripts')
</body>
</html>
