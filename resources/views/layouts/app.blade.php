<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiLevel | Eleva tu Poder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@300;500;700;900&display=swap');

        :root {
            --ki-gold: #FFD700;
            --ki-gold-bright: #ffffbf;
            --ki-orange: #ff8c00;
            --ki-red: #ff4500;
            --ki-dark-warm: #1a1205; /* Warm dark brown/black */
            --ki-glass: rgba(255, 230, 0, 0.05); /* Golden Tint Glass */
        }

        body {
            background-color: #050300;
            color: #fff;
            font-family: 'Exo 2', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* --- GOLDEN SUPERNOVA BACKGROUND --- */
        .supernova-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -50;
            background: linear-gradient(to bottom, #2b1d00 0%, #050300 100%);
            overflow: hidden;
        }

        /* The Main Burst */
        .supernova-core {
            position: absolute;
            top: -30%;
            left: 10%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.4) 0%, rgba(255, 140, 0, 0.2) 40%, transparent 70%);
            filter: blur(80px);
            animation: pulseLight 8s infinite alternate ease-in-out;
        }

        /* Secondary Warm Glow */
        .supernova-glow {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(255, 69, 0, 0.15) 0%, transparent 60%);
            filter: blur(60px);
            animation: pulseLight 12s infinite alternate-reverse ease-in-out;
        }

        /* Vibrant Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #fff, var(--ki-gold) 30%, var(--ki-orange) 70%);
            box-shadow: 0 0 40px var(--ki-gold);
            filter: blur(2px);
            opacity: 0.9; /* Much brighter */
            animation: floatOrb 6s infinite ease-in-out alternate;
        }

        .orb-1 {
            width: 120px;
            height: 120px;
            top: 15%;
            left: 5%;
            animation-duration: 8s;
        }

        .orb-2 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            right: 5%;
            background: radial-gradient(circle at 30% 30%, #fff, var(--ki-orange) 40%, var(--ki-red) 80%);
            box-shadow: 0 0 50px var(--ki-orange);
            animation-duration: 12s;
            animation-delay: -2s;
        }

        .orb-3 {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 80%;
            animation-duration: 15s;
        }

        .orb-4 {
            width: 40px;
            height: 40px;
            top: 30%;
            left: 30%;
            animation-duration: 5s;
            opacity: 0.7;
        }

        /* Shooting Energy Rays */
        .ray {
            position: absolute;
            width: 2px;
            height: 200px;
            background: linear-gradient(to bottom, transparent, #fff, transparent);
            opacity: 0.5;
            transform: rotate(45deg);
            animation: shootRay 4s infinite linear;
        }

        .ray-1 { top: 0; left: 20%; animation-delay: 0s; }
        .ray-2 { top: 20%; left: 80%; animation-delay: 2s; height: 300px; }
        .ray-3 { top: 60%; left: 10%; animation-delay: 1s; width: 3px; }

        @keyframes pulseLight {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        @keyframes floatOrb {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-20px) scale(1.05); }
        }

        @keyframes shootRay {
            0% { transform: translateY(-100px) rotate(45deg); opacity: 0; }
            50% { opacity: 0.8; }
            100% { transform: translateY(800px) rotate(45deg); opacity: 0; }
        }

        /* --- VIBRANT NAVBAR --- */
        .navbar {
            background: rgba(30, 20, 5, 0.8) !important; /* Richer, warmer background */
            backdrop-filter: blur(15px);
            border-bottom: 2px solid var(--ki-gold);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.2);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Glowing Top Line */
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.8rem;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 20px var(--ki-gold);
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: #fff;
            background: var(--ki-gold);
            border-radius: 50%;
            padding: 5px;
            font-size: 1.2rem;
            margin-right: 12px;
            box-shadow: 0 0 15px var(--ki-gold);
            color: #000;
        }

        .nav-link {
            color: #ffecd2 !important; /* Warm white */
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            margin: 0 4px;
            padding: 10px 15px !important;
            border-radius: 4px;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #000 !important;
            background: var(--ki-gold);
            box-shadow: 0 0 20px var(--ki-gold);
            transform: scale(1.05);
        }

        .nav-link.active {
            color: var(--ki-gold) !important;
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid var(--ki-gold);
            box-shadow: inset 0 0 10px var(--ki-gold);
        }

        /* Dropdown Vibrant */
        .dropdown-menu {
            background: rgba(20, 15, 5, 0.95);
            border: 2px solid var(--ki-gold);
            border-radius: 8px;
            box-shadow: 0 0 40px rgba(255, 140, 0, 0.3);
            margin-top: 20px;
        }

        .dropdown-item {
            color: #fff;
            font-weight: 600;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.2s;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--ki-gold);
            color: #000;
            padding-left: 25px;
        }

        /* Avatar Glowing Frame */
        .profile-nav-item {
            border: 2px solid var(--ki-gold);
            padding: 4px 15px;
            border-radius: 50px;
            background: rgba(0,0,0,0.3);
            box-shadow: 0 0 10px var(--ki-gold);
            transition: 0.3s;
        }

        .profile-nav-item:hover {
             background: var(--ki-gold);
             color: #000 !important;
             box-shadow: 0 0 30px var(--ki-gold);
        }
        
        /* CTA Button Vibrant */
        .btn-supernova {
            background: #fff;
            color: #000;
            font-weight: 900;
            text-transform: uppercase;
            padding: 10px 35px;
            border-radius: 50px;
            box-shadow: 0 0 20px #fff;
            transition: 0.3s;
            border: none;
        }

        .btn-supernova:hover {
             transform: scale(1.1);
             background: var(--ki-gold);
             box-shadow: 0 0 40px var(--ki-gold);
        }

        footer {
            background: #0f0a00;
            border-top: 2px solid var(--ki-gold);
            padding: 60px 0;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <!-- GOLDEN SUPERNOVA BACKGROUND -->
    <div class="supernova-container">
        <div class="supernova-core"></div>
        <div class="supernova-glow"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
        <div class="ray ray-1"></div>
        <div class="ray ray-2"></div>
        <div class="ray ray-3"></div>
    </div>

    <!-- VIBRANT NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-fill"></i> KILEVEL
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="bi bi-list text-white fs-2" style="filter: drop-shadow(0 0 5px gold);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('protocols.index') ? 'active' : '' }}"
                                href="{{ route('protocols.index') }}">
                                Protocolos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('training.index') ? 'active' : '' }}"
                                href="{{ route('training.index') }}">
                                Entrenamiento
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }} text-warning d-flex align-items-center gap-2"
                                href="{{ route('shop.index') }}" style="text-shadow: 0 0 5px gold;">
                                <i class="bi bi-cart4"></i> Tienda
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('factions.*') ? 'active' : '' }}" 
                               href="#" id="factionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-flag-fill"></i> Facciones
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="factionsDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('factions.index') }}">
                                        <i class="bi bi-list-ul me-2"></i> Todas las Facciones
                                    </a>
                                </li>
                                @if(Auth::user()->faction_id)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('factions.show', Auth::user()->faction_id) }}">
                                            <i class="bi bi-shield-shaded me-2"></i> Mi Facción
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <!-- ZENI DISPLAY -->
                        <li class="nav-item d-none d-lg-block mx-lg-2">
                             <span class="badge bg-warning text-dark border border-white rounded-pill px-3 py-2">
                                <i class="bi bi-coin me-1"></i> {{ number_format(Auth::user()->zeni ?? 0) }} Z
                             </span>
                        </li>

                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle profile-nav-item d-flex align-items-center gap-2" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown">
                                @php
                                    $navAvatar = Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.imgur.com/8K6hS9p.png';
                                @endphp
                                <img src="{{ $navAvatar }}" class="rounded-circle border border-warning" style="width: 25px; height: 25px; object-fit: cover;">
                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('social.index') }}">
                                        <span><i class="bi bi-people-fill me-2"></i> Amigos</span>
                                        @php $reqCount = Auth::user()->pendingRequestsReceived()->count(); @endphp
                                        @if($reqCount > 0)
                                            <span class="badge bg-danger rounded-pill">{{ $reqCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person-fill me-2"></i> Perfil</a></li>
                                <li><hr class="dropdown-divider border-secondary opacity-25"></li>
                                <li><a class="dropdown-item" href="{{ route('register.plans') }}"><i class="bi bi-stars me-2"></i> Mejorar Plan</a></li>
                                <li><a class="dropdown-item" href="{{ route('support.index') }}"><i class="bi bi-headset me-2 text-warning"></i> Soporte</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item fw-bold text-danger transition-03">
                                            <i class="bi bi-power me-2"></i> Salir
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Acceso</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register.plans') }}" class="btn btn-supernova">
                                ¡Poder!
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        @yield('content')
    </main>

    <footer>
        <div class="container text-center">
            <p class="text-white mb-0 fw-bold fs-5">KILEVEL SUPERNOVA</p>
            <p class="small text-warning opacity-75">NIVEL DE PODER: MÁXIMO</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
