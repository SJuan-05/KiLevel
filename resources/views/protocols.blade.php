@extends('layouts.app')

@section('content')
    <style>
        /* FONDO Y ESTRUCTURA GLOBAL (Coincide con Entrenamiento) */
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
        }

        .protocols-header {
            font-weight: 900;
            text-transform: uppercase;
            font-style: italic;
            letter-spacing: 3px;
            color: #fff;
            text-shadow: 0 0 20px rgba(255, 193, 7, 0.6);
            position: relative;
            display: inline-block;
        }

        .protocols-header::after {
            content: '';
            display: block;
            width: 60%;
            height: 4px;
            background: #ffc107;
            margin: 10px auto 0;
            box-shadow: 0 0 15px #ffc107;
        }

        /* TARJETA MAESTRA (Estilo Scouter/Premium) */
        .protocol-card {
            height: 520px;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #000;
            transform: skewX(-3deg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .protocol-card-inner {
            transform: skewX(3deg);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px;
            position: relative;
            z-index: 5;
        }

        /* IMAGEN DE FONDO */
        .card-img-bg {
            position: absolute;
            top: -5%;
            left: -5%;
            width: 110%;
            height: 110%;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease, filter 0.6s ease;
            z-index: 1;
            filter: grayscale(80%) brightness(0.4);
            transform: skewX(3deg);
        }

        .protocol-card:hover .card-img-bg {
            transform: skewX(3deg) scale(1.05);
            filter: grayscale(20%) brightness(0.8);
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, #000 15%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0) 100%);
            z-index: 2;
            pointer-events: none;
        }

        /* ESTADOS ESPECIALES */
        .protocol-active {
            border-color: #ffc107 !important;
            box-shadow: 0 0 40px rgba(255, 193, 7, 0.4) !important;
            z-index: 10;
        }

        .protocol-active .card-img-bg {
            filter: grayscale(0%) brightness(0.9) !important;
        }

        .protocol-locked {
            filter: grayscale(1) opacity(0.4);
            pointer-events: none;
        }

        /* TEXTOS */
        .diff-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 2px;
            padding: 4px 12px;
            border-radius: 4px;
            margin-bottom: 8px;
            backdrop-filter: blur(4px);
        }

        .proto-title {
            font-family: 'Arial Black', sans-serif;
            font-size: 2.2rem;
            text-transform: uppercase;
            line-height: 0.95;
            margin-bottom: 12px;
            color: #fff;
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.8));
        }

        .proto-desc {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            line-height: 1.4;
        }

        /* RECOMPENSAS BOX */
        .reward-info {
            background: rgba(0, 0, 0, 0.8);
            border-left: 3px solid #fff;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 0 8px 8px 0;
            font-family: 'Courier New', monospace;
        }

        .reward-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .reward-tag { font-size: 0.7rem; color: #888; text-transform: uppercase; }
        .reward-val { font-weight: bold; font-size: 1rem; color: #fff; }

        /* COLORES DINÁMICOS */
        .border-easy { border-left-color: #00ff41 !important; }
        .text-easy { color: #00ff41; }
        .border-medium { border-left-color: #ffc107 !important; }
        .text-medium { color: #ffc107; }
        .border-hard { border-left-color: #ff003c !important; }
        .text-hard { color: #ff003c; }

        /* BOTONES CYBER */
        .btn-proto {
            width: 100%;
            padding: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 92% 100%, 0 100%);
            transition: all 0.3s;
            position: relative;
        }

        .btn-proto-easy { border-color: #00ff41; color: #00ff41; }
        .btn-proto-easy:hover { background: #00ff41; color: #000; box-shadow: 0 0 15px #00ff41; }
        
        .btn-proto-medium { border-color: #ffc107; color: #ffc107; }
        .btn-proto-medium:hover { background: #ffc107; color: #000; box-shadow: 0 0 15px #ffc107; }

        .btn-proto-hard { border-color: #ff003c; color: #ff003c; }
        .btn-proto-hard:hover { background: #ff003c; color: #000; box-shadow: 0 0 15px #ff003c; }

        .btn-active { 
            background: #ffc107 !important; 
            color: #000 !important; 
            border-color: #fff !important;
            animation: pulse-active-btn 2s infinite;
        }

        @keyframes pulse-active-btn {
            0% { box-shadow: 0 0 10px #ffc107; }
            50% { box-shadow: 0 0 25px #ffc107; }
            100% { box-shadow: 0 0 10px #ffc107; }
        }

        /* TIMER */
        .proto-timer {
            font-family: 'Courier New', monospace;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.4);
            padding: 8px;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
        }

        .timer-nums { font-size: 1.4rem; font-weight: 900; color: #ffc107; text-shadow: 0 0 10px rgba(255, 193, 7, 0.5); }
    </style>

    <div class="container py-5">
        
        @if(session('success'))
            <div class="alert alert-dark border-warning text-warning text-center mb-5" style="background: rgba(0,0,0,0.8); border-radius: 0; border-left: 5px solid #ffc107;">
                <i class="bi bi-lightning-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="text-center mb-5">
            <h2 class="protocols-header display-5">Protocolos Diarios</h2>
            <p class="text-white-50 mt-3 letter-spacing-1">SELECCIONA TU DESAFÍO DE LAS PRÓXIMAS 24 HORAS</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($missions as $mission)
                @php
                    $isActive = $activeMission && $activeMission->id === $mission->id;
                    $isLocked = $activeMission && !$isActive;
                    
                    $diffClass = match($mission->difficulty) {
                        'medium' => 'medium',
                        'hard' => 'hard',
                        default => 'easy'
                    };

                    $bgImage = match($mission->difficulty) {
                        'medium' => 'https://i.imgur.com/GisXU6P.jpeg', // Scenery or something else
                        'hard' => 'https://i.imgur.com/vHqLh75.jpeg', 
                        default => 'https://i.imgur.com/NAtu0kX.jpeg'
                    };
                    
                    // Fallback to generic if links break
                @endphp

                <div class="col-md-4">
                    <div class="protocol-card @if($isActive) protocol-active @elseif($isLocked) protocol-locked @endif">
                        <div class="card-img-bg" style="background-image: url('{{ $bgImage }}');"></div>
                        <div class="card-overlay"></div>

                        <div class="protocol-card-inner">
                            <span class="diff-badge border-{{ $diffClass }} text-{{ $diffClass }}">
                                {{ strtoupper($mission->difficulty) }}
                            </span>
                            
                            <h3 class="proto-title">{{ $mission->title }}</h3>
                            <p class="proto-desc">{{ Str::limit($mission->description, 100) }}</p>

                            <div class="reward-info border-{{ $diffClass }}">
                                <div class="reward-row">
                                    <span class="reward-tag">Recompensa</span>
                                    <span class="reward-val text-{{ $diffClass }}">+{{ $mission->xp_reward }} XP</span>
                                </div>
                                <div class="reward-row">
                                    <span class="reward-tag">Zenis Est.</span>
                                    <span class="reward-val text-warning">+{{ Auth::user()->calculateZeniReward($mission->difficulty) }} Z</span>
                                </div>
                            </div>

                            @if($isActive)
                                <div class="text-center w-100">
                                     @if($activeMission->pivot->training_id)
                                        <a href="{{ route('training.show', $activeMission->pivot->training_id) }}" class="btn-proto btn-active mb-3 d-block text-decoration-none text-center">
                                            CONTINUAR
                                        </a>
                                    @endif
                                    
                                    <div class="proto-timer">
                                        <div class="reward-tag mb-1">Tiempo de Expiración</div>
                                        <div id="timer-{{ $mission->id }}" class="timer-nums">--:--:--</div>
                                    </div>
                                </div>

                                <script>
                                    (function() {
                                        const expiresAt = new Date("{{ $activeMission->pivot->expires_at }}").getTime();
                                        const timerElement = document.getElementById('timer-{{ $mission->id }}');
                                        const update = () => {
                                            const now = new Date().getTime();
                                            const distance = expiresAt - now;
                                            if (distance < 0) {
                                                timerElement.innerHTML = "EXPIRADO";
                                                return;
                                            }
                                            const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            const s = Math.floor((distance % (1000 * 60)) / 1000);
                                            timerElement.innerHTML = `${h < 10 ? '0'+h : h}:${m < 10 ? '0'+m : m}:${s < 10 ? '0'+s : s}`;
                                        };
                                        update();
                                        setInterval(update, 1000);
                                    })();
                                </script>
                            @elseif($isLocked)
                                <button class="btn-proto text-white-50" style="border-color: #333;" disabled>BLOQUEADO</button>
                            @else
                                <form action="{{ route('protocols.start', $mission->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-proto btn-proto-{{ $diffClass }}">
                                        INICIAR PROTOCOLO
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
