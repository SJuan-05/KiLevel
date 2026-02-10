@extends('layouts.app')

@section('content')
    <style>
        /* --- ANIMACIONES DE ENTRADA --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.2); border-color: rgba(255, 193, 7, 0.3); }
            50% { box-shadow: 0 0 50px rgba(255, 193, 7, 0.5); border-color: rgba(255, 193, 7, 0.8); }
            100% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.2); border-color: rgba(255, 193, 7, 0.3); }
        }

        @keyframes scan {
            0% { background-position: 0% 0%; }
            100% { background-position: 0% 100%; }
        }

        .fade-in-1 { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; animation-delay: 0.1s; }
        .fade-in-2 { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; animation-delay: 0.2s; }
        .fade-in-3 { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; animation-delay: 0.3s; }

        /* --- DASHBOARD HEADER --- */
        .dashboard-header {
            padding: 40px 0;
            text-align: center;
            position: relative;
        }

        .dashboard-header::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: #ffc107;
            margin: 20px auto 0;
            box-shadow: 0 0 15px #ffc107;
            border-radius: 2px;
        }

        .welcome-text {
            font-size: 3rem;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
        }

        .welcome-subtext {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(255, 193, 7, 0.1);
            display: inline-block;
            padding: 5px 15px;
            border-radius: 4px;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        /* --- STATS GRID --- */
        .stat-card {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(20, 20, 20, 0.9);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .stat-bg-icon {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8rem;
            opacity: 0.05;
            color: #fff;
            transform: rotate(-15deg);
        }

        /* Tipografías Stats */
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .stat-subtext {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 10px;
        }

        /* Colores específicos */
        .streak-card { border-bottom: 4px solid #ffc107; }
        .streak-val { color: #ffc107; text-shadow: 0 0 15px rgba(255, 193, 7, 0.4); }
        
        .level-card { border-bottom: 4px solid #00ff41; }
        .level-val { color: #fff; }
        
        .plan-card { border-bottom: 4px solid #00e5ff; }
        .plan-val { color: #00e5ff; text-shadow: 0 0 15px rgba(0, 229, 255, 0.4); }

        /* Barra de Progreso Custom */
        .xp-bar-container {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            margin-top: 15px;
            overflow: hidden;
            position: relative;
        }
        
        .xp-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #00ff41, #00cb33);
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 255, 65, 0.5);
            width: 0%; /* Se anima inline */
            transition: width 1s ease-out;
        }

        /* --- ACTIVE PROTOCOL INNOVATOR --- */
        .active-protocol-container {
            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(20,20,20,0.95) 100%);
            border: 2px solid #ffc107;
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            animation: pulseGlow 3s infinite;
        }

        /* Scanning overlay effect */
        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 95%, rgba(255, 193, 7, 0.1) 100%);
            background-size: 100% 50px;
            animation: scan 4s linear infinite;
            pointer-events: none;
            z-index: 1;
        }

        .active-label {
            color: #ffc107;
            font-family: 'Courier New', monospace;
            font-weight: 900;
            letter-spacing: 5px;
            font-size: 1.2rem;
            border-bottom: 2px solid #ffc107;
            display: inline-block;
            margin-bottom: 20px;
            padding-bottom: 5px;
        }

        .active-title {
            font-size: 4rem;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            line-height: 0.9;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }

        .active-timer {
            font-family: 'Courier New', monospace;
            font-size: 3.5rem;
            color: #fff;
            text-shadow: 0 0 20px #ffc107;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 30px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: inline-block;
            margin-top: 20px;
            z-index: 2;
        }

        .active-desc {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 600px;
            margin: 0 auto 30px auto;
            z-index: 2;
            position: relative;
        }

        /* --- SECCIÓN PROTOCOLOS NORMAL --- */
        .protocols-section {
            margin-top: 60px;
        }
        
        .section-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modern-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            text-transform: uppercase;
        }

        .modern-link {
            color: #ffc107;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .modern-link:hover {
            color: #fff;
            transform: translateX(5px);
        }

        /* Lista de Protocolos */
        .modern-protocol-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .modern-protocol-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.01);
        }

        .protocol-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .difficulty-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 10px currentColor;
        }

        .diff-easy-dot { color: #00ff41; background: #00ff41; }
        .diff-medium-dot { color: #ffc107; background: #ffc107; }
        .diff-hard-dot { color: #ff003c; background: #ff003c; }

        .protocol-names h5 {
            margin: 0;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            font-size: 1.1rem;
        }

        .protocol-names p {
            margin: 3px 0 0;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .xp-pill {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

    </style>

    <div class="container pb-5">
        
        <!-- DASHBOARD HEADER & WELCOME -->
        <div class="dashboard-header d-flex flex-column align-items-center">
            <div class="avatar-header mb-3">
                @php
                    $dashAvatar = $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.imgur.com/8K6hS9p.png';
                @endphp
                <img src="{{ $dashAvatar }}" class="rounded-circle border border-warning shadow-lg" 
                     style="width: 100px; height: 100px; object-fit: cover; border-width: 3px !important; box-shadow: 0 0 20px rgba(255, 193, 7, 0.5);">
            </div>
            <div class="welcome-text">Hola, {{ explode(' ', trim($user->name))[0] }}</div>
            <div class="welcome-subtext">
                <i class="bi bi-shield-shaded me-2"></i>{{ $user->current_title }}
            </div>
            <div class="mt-3">
                @if($user->faction)
                    <a href="{{ route('factions.show', $user->faction_id) }}" class="text-decoration-none">
                        <span class="badge rounded-0 px-3 py-2" style="background: rgba(255,193,7,0.1); border: 1px solid #ffc107; color: #ffc107; letter-spacing: 2px;">
                            <i class="bi bi-flag-fill me-2"></i>FACCION: {{ strtoupper($user->faction->name) }}
                        </span>
                    </a>
                @else
                    <a href="{{ route('factions.index') }}" class="text-decoration-none">
                        <span class="badge rounded-0 px-3 py-2" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.6); letter-spacing: 2px;">
                            <i class="bi bi-slash-circle me-2"></i>SIN FACCIÓN
                        </span>
                    </a>
                @endif
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card streak-card">
                    <i class="bi bi-fire stat-bg-icon"></i>
                    <div class="stat-label">Racha Actual</div>
                    <div class="stat-value streak-val">{{ $user->streak }}</div>
                    <div class="stat-subtext">Días consecutivos entrenando</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card level-card">
                    <i class="bi bi-graph-up-arrow stat-bg-icon"></i>
                    <div class="d-flex justify-content-between align-items-baseline">
                        <div class="stat-label">Progreso Actual</div>
                    </div>
                    <div class="stat-value level-val">{{ $user->xp }} <span class="fs-6 text-white-50">XP</span></div>
                    @php 
                        $percent = $user->xpPercent(); 
                        $remaining = $user->xpToNextLevel();
                    @endphp
                    <div class="xp-bar-container">
                        <div class="xp-bar-fill" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="stat-subtext text-end">{{ number_format($remaining) }} XP para el siguiente nivel</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card" style="border-bottom: 4px solid #FFD700;">
                    <i class="bi bi-coin stat-bg-icon"></i>
                    <div class="stat-label">Billetera Z</div>
                    <div class="stat-value text-warning" style="text-shadow: 0 0 15px rgba(255, 215, 0, 0.4);">
                        {{ number_format($user->zeni ?? 0) }}
                    </div>
                    <div class="stat-subtext">Zenis acumulados</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card plan-card">
                    <i class="bi bi-gem stat-bg-icon"></i>
                    <div class="stat-label">Plan de Guerrero</div>
                    <div class="stat-value plan-val">{{ ucfirst($user->plan) }}</div>
                    <div class="stat-subtext">
                        <i class="bi bi-lightning-fill text-warning me-1"></i> Multiplicador: x{{ $user->xp_multiplier }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. SECCIÓN: PROTOCOLO DIARIO ACTIVO (Hero) -->
        <div class="mb-5">
            @if(isset($activeDaily) && $activeDaily)
                <div class="active-protocol-container p-0 overflow-hidden border-0 bg-transparent shadow-none" style="animation: none;">
                     <div class="h-100 p-4 position-relative overflow-hidden" 
                             style="background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(20,20,20,0.95) 100%); border: 2px solid #ffc107; border-radius: 20px; animation: pulseGlow 3s infinite;">
                            
                        <div class="scan-overlay"></div>
                        <div class="active-label">PROTOCOLO DIARIO ACTIVO</div>
                        
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="active-title" style="font-size: 3rem;">{{ $activeDaily->title }}</h1>
                                <p class="active-desc mx-0 text-start fs-5">{{ $activeDaily->description }}</p>
                                
                                <div class="d-flex gap-5 mt-4">
                                    <div>
                                        <small class="text-white-50 d-block mb-1">RECOMPENSA</small>
                                        <span class="fs-4 text-white fw-bold">+{{ $activeDaily->xp_reward }} XP</span>
                                    </div>
                                    <div>
                                        <small class="text-white-50 d-block mb-1">ZENI</small>
                                        <span class="fs-4 text-warning fw-bold text-shadow-gold">+{{ $user->calculateZeniReward($activeDaily->difficulty) }} Z</span>
                                    </div>
                                    <div>
                                        <small class="text-white-50 d-block mb-1">DIFICULTAD</small>
                                        <span class="fs-4 text-warning fw-bold">{{ strtoupper($activeDaily->difficulty) }}</span>
                                    </div>
                                    <div>
                                       <small class="text-white-50 d-block mb-1">TIEMPO RESTANTE</small>
                                       <span class="fs-4 text-white fw-bold timer-countdown" data-expires="{{ $activeDaily->pivot->expires_at }}">--:--:--</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center border-start border-secondary border-opacity-25">
                                 @if($activeDaily->pivot->training_id)
                                    @php
                                        $dTraining = \App\Models\Training::find($activeDaily->pivot->training_id);
                                        $dTotal = is_array($dTraining->exercises) ? count($dTraining->exercises) : 0;
                                        $dProg = $activeDaily->pivot->exercises_progress;
                                        $dCompleted = 0;
                                        if ($dProg) {
                                            $dDecoded = json_decode($dProg, true);
                                            $dCompleted = is_array($dDecoded) ? count($dDecoded) : 0;
                                        }
                                        $dPercent = $dTotal > 0 ? round(($dCompleted / $dTotal) * 100) : 0;
                                    @endphp

                                    <div class="mb-3 text-start">
                                        <div class="d-flex justify-content-between small text-white-50 mb-1">
                                            <span>PROGRESO DE MISIÓN</span>
                                            <span>{{ $dPercent }}%</span>
                                        </div>
                                        <div class="progress bg-secondary" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $dPercent }}%"></div>
                                        </div>
                                    </div>

                                    <a href="{{ route('training.show', $activeDaily->pivot->training_id) }}" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold w-100 mb-3 push-hover">
                                        <i class="bi bi-play-fill me-2"></i> CONTINUAR
                                    </a>
                                 @endif
                                 
                                <form action="{{ route('protocols.cancel', $activeDaily->id) }}" method="POST" onsubmit="return confirm('¿Abandonar el protocolo diario?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4">
                                        ABANDONAR
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>



        <!-- (Sección "Protocolos Disponibles" eliminada para mostrar solo Mis Entrenamientos) -->

        <!-- 3. SECCIÓN: MIS ENTRENAMIENTOS (MovidA al final) -->
        @if(isset($activeTrainings) && $activeTrainings->count() > 0)
        <div class="mb-5">
            <div class="section-header-modern mb-4">
                <h3 class="modern-title" style="border-left: 4px solid #00e5ff; padding-left: 15px;">Entrenamientos Iniciados</h3>
            </div>

            <div class="row g-4">
                @foreach($activeTrainings as $trainingMission)
                     @php
                        $training = \App\Models\Training::find($trainingMission->pivot->training_id);
                        if (!$training) continue;

                        $totalExercises = is_array($training->exercises) ? count($training->exercises) : 0;
                        $prog = $trainingMission->pivot->exercises_progress;
                        $completedExercises = 0;
                        if ($prog) {
                            $decoded = json_decode($prog, true);
                            $completedExercises = is_array($decoded) ? count($decoded) : 0;
                        }
                        
                        $percent = $totalExercises > 0 ? ($completedExercises / $totalExercises) * 100 : 0;
                        $percent = round($percent);

                        // Colors
                        $raceColor = 'secondary';
                        $raceName = 'ESTÁNDAR';
                        $tTitle = strtoupper($training->title);
                        if (str_contains($tTitle, 'SAIYAN')) { $raceColor = 'warning'; $raceName = 'CLASE SAIYAN'; }
                        elseif (str_contains($tTitle, 'NAMEK')) { $raceColor = 'success'; $raceName = 'CLASE NAMEK'; }
                        elseif (str_contains($tTitle, 'FROST')) { $raceColor = 'info'; $raceName = 'CLASE FROST'; }
                        elseif (str_contains($tTitle, 'HUMAN') || str_contains($tTitle, 'HUMANA')) { $raceColor = 'primary'; $raceName = 'CLASE HUMANA'; }
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="h-100 p-4 d-flex flex-column justify-content-between position-relative overflow-hidden" 
                                style="background: rgba(15, 15, 15, 0.95); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; transition: transform 0.3s;">
                            
                            <!-- Background Accent -->
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--bs-{{ $raceColor }}); box-shadow: 0 0 10px var(--bs-{{ $raceColor }});"></div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                                <span class="badge bg-{{ $raceColor }} text-black fw-bold">{{ $raceName }}</span>
                                <span class="badge bg-transparent border border-white text-white-50" style="font-size: 0.75rem;">∞ ILIMITADO</span>
                            </div>

                            <h4 class="text-white fw-bold mb-2">{{ $training->title }}</h4>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small text-white-50 mb-1">
                                    <span>Progreso</span>
                                    <span>{{ $percent }}%</span>
                                </div>
                                <div class="progress bg-secondary" style="height: 6px;">
                                    <div class="progress-bar bg-{{ $raceColor }}" role="progressbar" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between small text-white-50 mb-3">
                                 <span>Recompensa Estimada:</span>
                                 <span class="text-warning fw-bold">+{{ $user->calculateZeniReward($training->difficulty ?? 'easy') }} Z</span>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('training.show', $trainingMission->pivot->training_id) }}" class="btn btn-outline-{{ $raceColor }} w-100 fw-bold">
                                    {{ $percent > 0 ? 'CONTINUAR' : 'INICIAR' }}
                                </a>
                                <form action="{{ route('protocols.cancel', $trainingMission->id) }}" method="POST" onsubmit="return confirm('¿Abandonar entrenamiento?');" style="width: 40px;">
                                    @csrf
                                    <button type="submit" class="btn btn-dark border border-secondary text-danger w-100 px-0" title="Abandonar">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- 4. SECCIÓN: RECOMENDADOS DE LA TIENDA -->
        <div class="mt-5 pt-4">
            <div class="section-header-modern mb-4">
                <h3 class="modern-title" style="border-left: 4px solid #ffc107; padding-left: 15px;">Objetos Recomendados</h3>
                <a href="{{ route('shop.index') }}" class="modern-link">Ir a la tienda <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="row g-4">
                @foreach($recommendedItems as $item)
                    <div class="col-md-6">
                        <div class="stat-card d-flex align-items-center gap-4 py-4" style="border-bottom: 2px solid {{ $item['owned'] ? '#28a745' : '#ffc107' }};">
                            <div class="shop-icon-box fs-1 text-warning">
                                <i class="bi {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="text-white fw-black text-uppercase m-0">{{ $item['name'] }}</h5>
                                    @if($item['owned'])
                                        <span class="badge bg-success text-uppercase" style="font-size: 0.6rem;">Ya en posesión</span>
                                    @else
                                        <span class="text-warning fw-bold">{{ number_format($item['price']) }} Z</span>
                                    @endif
                                </div>
                                <p class="text-white-50 small mb-0 mt-1">{{ $item['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SCRIPT PARA TEMPORIZADORES -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const timers = document.querySelectorAll('.timer-countdown');
                timers.forEach(function(timer) {
                    const expiresAt = new Date(timer.dataset.expires).getTime();
                    const interval = setInterval(function() {
                        const now = new Date().getTime();
                        const distance = expiresAt - now;
                        if (distance < 0) {
                            clearInterval(interval);
                            timer.innerHTML = "EXPIRADO";
                            return;
                        }
                        const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const s = Math.floor((distance % (1000 * 60)) / 1000);
                        timer.innerHTML = (h<10?"0"+h:h) + ":" + (m<10?"0"+m:m) + ":" + (s<10?"0"+s:s);
                    }, 1000);
                });
            });
        </script>

        <!-- (Sección "Protocolos Disponibles" eliminada a petición del usuario para mostrar solo Mis Entrenamientos) -->
        </div>

    </div>
@endsection
