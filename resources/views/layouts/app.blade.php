<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>PlayTime Manager</title>

    <!-- Fonts -->


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


    
</head>
<body>
    
    <div id="app">
        <!-- barra menu -->
        <nav class="navbar navbar-expand-md navbar-light custom-navbar bg-white">
            <div class="container">

            <!-- logo-->
            <a class="navbar-brand custom-navbar-brand" href="{{ url('/welcome') }}">
    <img src="{{ asset('images/playtimeLogo.png') }}" alt="Logo" style="height: 90px;">
</a>

<div class="d-flex gap-2">
    <a href="{{ route('servicos.index') }}" class="btn btn-primary opacity-100">Serviços</a>
    <a href="{{ route('clientes.index') }}" class="btn btn-primary opacity-100">Clientes</a>
    <a href="{{ route('relatorios.index') }}" class="btn btn-primary opacity-100">Relatórios</a>
    <a href="{{ route('home') }}" class="btn btn-primary opacity-100">Comandas</a>
</div>


                <!-- botão de alternancia para telas pequenas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- conteudo da barra do menu -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- lado direito -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-info fs-7" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-info fs-7" href="{{ route('register') }}">{{ __('Cadastre-se') }}</a>
                                </li>
                            @endif
                        @else

                        <!-- menu suspenso -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    {{ __('Gerenciamento de Usuários') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); 
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Sair') }}
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
        <!-- Mensagens de sucesso e erro -->
        <div class="container mt-4">
            @if (session('error'))
        <div id="error-notification" class="alert alert-danger">
            {{ session('error') }}
        </div>
            @endif

            @if (session('success'))
        <div id="success-notification" class="alert alert-success">
            {{ session('success') }}
        </div>
            @endif
        </div>

        <script>
        setTimeout(() => {
            const errorNotification = document.getElementById('error-notification');
            const successNotification = document.getElementById('success-notification');
            if (errorNotification) errorNotification.style.display = 'none';
            if (successNotification) successNotification.style.display = 'none';
        }, 5000);
        </script>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('js')

</footer>

</body>
</html>

