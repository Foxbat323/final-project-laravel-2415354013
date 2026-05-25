<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ERPSystem')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">E</div>
            <div class="brand-text">ERPSystem</div>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Customers
            </a>
            <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Services
            </a>
            <a href="{{ route('subscriptions.index') }}" class="nav-link {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Subscriptions
            </a>
        </nav>
        <div class="bottom-action">
            <a href="#" class="nav-link">Dark Mode</a>
        </div>
    </aside>

    <main class="main-wrapper">
        <header class="top-header">
            <div class="user-profile">
                <div class="user-info">
                    <div class="user-name">Andi</div>
                    <div class="user-role">Admin</div>
                </div>
                <div class="avatar">A</div>
            </div>
        </header>

        <section class="content">
            @yield('content')
        </section>
    </main>

    <script>
        function openModal(id) { 
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('active'); 
        }
        function closeModal(id) { 
            const modal = document.getElementById(id);
            if (modal) modal.classList.remove('active'); 
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
            }
        });
    </script>
    <style>
        .modal-content {
            padding: 0;
        }
        .modal-content form {
            padding: 20px;
        }
    </style>
</body>
</html>