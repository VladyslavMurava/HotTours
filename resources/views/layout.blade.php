<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'Туристичне агентство гарячих турів. Найкращі пропозиції для відпочинку.')">
    <title>@yield('title', 'Гарячі Тури') | Туристичне агентство</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.15) !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">HotTours</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Головна</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('tours.*') ? 'active' : '' }}" href="{{ route('tours.index') }}">Каталог турів</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Послуги</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Про нас</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакти</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Увійти</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Зареєструватися</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.orders') }}">⚙️ Заявки</a>
                                    <a class="dropdown-item" href="{{ route('admin.messages') }}">📩 Повідомлення</a>
                                    <a class="dropdown-item" href="{{ route('admin.stats') }}">📊 Статистика</a>
                                    <hr class="dropdown-divider">
                                @endif
                                <a class="dropdown-item" href="{{ route('cabinet') }}">Мій кабінет</a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Вийти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-4 bg-dark text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>HotTours</h5>
                    <p class="small text-muted">Ваш надійний партнер у світі подорожей.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Навігація</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('tours.index') }}" class="text-white text-decoration-none">Усі тури</a></li>
                        <li><a href="{{ route('services') }}" class="text-white text-decoration-none">Послуги</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Контакти</h5>
                    <p class="small text-muted mb-0">+380 00 000 00 00<br>info@hottours.com.ua</p>
                </div>
            </div>
            <hr class="border-secondary">
            <span class="text-muted small">&copy; 2026 Туристичне агентство. Усі права захищено.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('custom-scripts')
</body>
</html>
