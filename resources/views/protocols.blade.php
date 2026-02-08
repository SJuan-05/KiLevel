@extends('layouts.app')

@section('content')
    <style>
        /* --- FONDO GLOBAL --- */
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
        }

        /* --- TÍTULO --- */
        .section-title {
            font-weight: 900;
            text-transform: uppercase;
            font-style: italic;
            letter-spacing: 4px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .section-title::before {
            content: '//';
            color: #ffc107;
            margin-right: 10px;
        }

        /* --- CARTAS (ESTRUCTURA & SKEW) --- */
        .mission-card {
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: skewX(-3deg);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .mission-inner {
            transform: skewX(3deg);
            padding: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            z-index: 2;
        }

        .mission-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background-size: cover;
            background-position: center;
            z-index: 1;
            transition: 0.4s;
            transform: skewX(3deg) scale(1);
        }

        .mission-card:hover .mission-bg {
            transform: skewX(3deg) scale(1.1);
            opacity: 0.15;
        }
        
        /* --- ESTADO ACTIVO (GLITCH & BORDER) --- */
        .mission-active {
            border-color: #ffc107 !important;
            box-shadow: 0 0 30px rgba(255, 193, 7, 0.3);
            animation: pulseActive 2s infinite;
        }

        .mission-locked {
            filter: grayscale(1) opacity(0.5);
            pointer-events: none;
        }

        @keyframes pulseActive {
            0% { box-shadow: 0 0 30px rgba(255, 193, 7, 0.3); border-color: #ffc107; }
            50% { box-shadow: 0 0 50px rgba(255, 193, 7, 0.6); border-color: #fff; }
            100% { box-shadow: 0 0 30px rgba(255, 193, 7, 0.3); border-color: #ffc107; }
        }

        /* --- CLASES DINÁMICAS --- */
        /* EASY */
        .card-easy:hover { border-color: #00ff41; box-shadow: 0 0 30px rgba(0, 255, 65, 0.2); }
        .icon-easy { color: #00ff41; filter: drop-shadow(0 0 10px rgba(0, 255, 65, 0.6)); }
        .badge-easy { border: 1px solid #00ff41; color: #00ff41; background: rgba(0, 255, 65, 0.1); }
        .btn-easy { border-color: #00ff41; color: #00ff41; }
        .btn-easy:hover { background: #00ff41; color: #000; box-shadow: 0 0 20px rgba(0, 255, 65, 0.6); }

        /* MEDIUM */
        .card-medium:hover { border-color: #ffc107; box-shadow: 0 0 30px rgba(255, 193, 7, 0.3); }
        .icon-medium { color: #ffc107; filter: drop-shadow(0 0 10px rgba(255, 193, 7, 0.6)); }
        .badge-medium { border: 1px solid #ffc107; color: #ffc107; background: rgba(255, 193, 7, 0.1); }
        .btn-medium { border-color: #ffc107; color: #ffc107; }
        .btn-medium:hover { background: #ffc107; color: #000; box-shadow: 0 0 20px rgba(255, 193, 7, 0.6); }

        /* HARD */
        .card-hard:hover { border-color: #ff003c; box-shadow: 0 0 30px rgba(255, 0, 60, 0.3); }
        .icon-hard { color: #ff003c; filter: drop-shadow(0 0 10px rgba(255, 0, 60, 0.6)); }
        .badge-hard { border: 1px solid #ff003c; color: #ff003c; background: rgba(255, 0, 60, 0.1); }
        .btn-hard { border-color: #ff003c; color: #ff003c; }
        .btn-hard:hover { background: #ff003c; color: #000; box-shadow: 0 0 20px rgba(255, 0, 60, 0.6); }


        /* --- ELEMENTOS COMUNES --- */
        .mission-icon { font-size: 3.5rem; margin-bottom: 20px; transition: 0.3s; }
        .mission-card:hover .mission-icon { transform: scale(1.1); }

        .mission-badge {
            font-family: 'Courier New', monospace;
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: bold;
            padding: 5px 10px;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .mission-title {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .reward-box {
            background: rgba(255, 255, 255, 0.05);
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            border-left: 2px solid #555;
        }

        .reward-label { font-size: 0.65rem; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .reward-value { font-weight: bold; font-size: 1.1rem; color: #fff; }

        /* --- BOTONES --- */
        .btn-cyber {
            width: 100%;
            padding: 12px;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 2px;
            background: transparent;
            border: 1px solid #555;
            color: #fff;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 90% 100%, 0 100%);
            transition: 0.3s;
            text-decoration: none;
            cursor: pointer;
        }

        /* --- TIMER --- */
        .countdown-timer {
            font-family: 'Courier New', monospace;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 10px #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.5);
            background: rgba(0,0,0,0.5);
            padding: 10px 20px;
            margin-top: 15px;
            display: inline-block;
            border-radius: 5px;
        }
        
        .timer-label {
            font-size: 0.7rem;
            color: #ffc107;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }

        /* ALERTA DE ERROR/SUCCESS */
        .alert-ki {
            background: rgba(20, 20, 20, 0.9);
            border: 1px solid #ffc107;
            color: #fff;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }
    </style>

    <div class="container py-5">
        
        @if(session('success'))
            <div class="alert alert-ki text-center">
                <i class="bi bi-check-circle-fill text-warning me-2"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-ki text-center" style="border-color: #ff003c;">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="text-center">
            <h2 class="section-title display-6">PROTOCOLOS DIARIOS</h2>
            @if($activeMission)
                <p class="text-warning mb-4 fw-bold">PROTOCOLO ACTIVO DETECTADO</p>
            @endif
        </div>

        <div class="row g-4 align-items-stretch justify-content-center">

            @foreach($missions as $mission)
                @php
                    $isActive = $activeMission && $activeMission->id === $mission->id;
                    $isLocked = $activeMission && !$isActive;
                    
                    // Clases dinámicas según dificultad
                    $cardClass = match($mission->difficulty) {
                        'medium' => 'card-medium',
                        'hard' => 'card-hard',
                        default => 'card-easy'
                    };
                    $badgeClass = match($mission->difficulty) {
                        'medium' => 'badge-medium',
                        'hard' => 'badge-hard',
                        default => 'badge-easy'
                    };
                    $iconClass = match($mission->difficulty) {
                        'medium' => 'icon-medium',
                        'hard' => 'icon-hard',
                        default => 'icon-easy'
                    };
                    $btnClass = match($mission->difficulty) {
                        'medium' => 'btn-medium',
                        'hard' => 'btn-hard',
                        default => 'btn-easy'
                    };
                    $iconName = match($mission->difficulty) {
                        'medium' => 'bi-fire',
                        'hard' => 'bi-radioactive',
                        default => 'bi-battery-charging'
                    };
                    $borderColor = match($mission->difficulty) {
                        'medium' => '#ffc107',
                        'hard' => '#ff003c',
                        default => '#00ff41'
                    };
                    
                    // Si está activo, forzamos clase especial
                    if($isActive) {
                        $cardClass .= ' mission-active';
                    }
                    if($isLocked) {
                        $cardClass .= ' mission-locked';
                    }
                @endphp

                <div class="col-md-4">
                    <div class="mission-card {{ $cardClass }}">
                        <div class="mission-bg" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

                        <div class="mission-inner">
                            <div class="text-center w-100">
                                <span class="mission-badge {{ $badgeClass }}">{{ strtoupper($mission->difficulty) }}</span>
                                <div class="mt-3"><i class="bi {{ $iconName }} mission-icon {{ $iconClass }}"></i></div>
                                <h4 class="mission-title">{{ $mission->title }}</h4>
                                <p class="text-white-50 small">{{ Str::limit($mission->description, 80) }}</p>
                            </div>

                            <div class="reward-box" style="border-left-color: {{ $borderColor }};">
                                <div class="d-flex justify-content-between align-items-center px-2 mb-2">
                                    <div>
                                        <div class="reward-label">EXP GAIN</div>
                                        <div class="reward-value" style="color: {{ $borderColor }}">+{{ $mission->xp_reward }} XP</div>
                                    </div>
                                    <i class="bi bi-caret-up-fill" style="color: {{ $borderColor }}"></i>
                                </div>
                                <div class="d-flex justify-content-between align-items-center px-2">
                                    <div>
                                        <div class="reward-label">ZENI REWARD</div>
                                        <div class="reward-value text-warning">+{{ Auth::user()->calculateZeniReward($mission->difficulty) }} Z</div>
                                    </div>
                                    <i class="bi bi-coin text-warning"></i>
                                </div>
                            </div>

                            @if($isActive)
                                <div class="text-center w-100">
                                    <span class="timer-label">TIEMPO RESTANTE</span>
                                    <div id="timer-{{ $mission->id }}" class="countdown-timer">
                                        --:--:--
                                    </div>
                                    <div class="mt-2 text-warning small fw-bold">EN PROGRESO</div>
                                    
                                    @if($activeMission->pivot->training_id)
                                        <a href="{{ route('training.show', $activeMission->pivot->training_id) }}" class="btn btn-outline-warning btn-sm mt-3 fw-bold rounded-pill">
                                            <i class="bi bi-eye"></i> VER ENTRENAMIENTO
                                        </a>
                                    @endif
                                </div>
                                <script>
                                    // Timer Script embedded specific for this card
                                    (function() {
                                        const expiresAt = new Date("{{ $activeMission->pivot->expires_at }}").getTime();
                                        const timerElement = document.getElementById('timer-{{ $mission->id }}');
                                        
                                        const cleanup = setInterval(function() {
                                            const now = new Date().getTime();
                                            const distance = expiresAt - now;
                                            
                                            if (distance < 0) {
                                                clearInterval(cleanup);
                                                timerElement.innerHTML = "EXPIRADO";
                                                return;
                                            }
                                            
                                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                            
                                            timerElement.innerHTML = 
                                                (hours < 10 ? "0" + hours : hours) + ":" + 
                                                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                                                (seconds < 10 ? "0" + seconds : seconds);
                                        }, 1000);
                                    })();
                                </script>
                            @elseif($isLocked)
                                <button class="btn-cyber text-secondary" disabled style="border-color: #333;">BLOQUEADO</button>
                            @else
                                <form action="{{ route('protocols.start', $mission->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn-cyber {{ $btnClass }} text-center">INICIAR</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
