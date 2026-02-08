@extends('layouts.app')

@section('content')
    @php
        // Detect Race/Type
        // Detect Race/Type
        $title = $training->title;
        $isProgram = str_contains($title, 'CLASE');
        $raceColor = 'warning'; // Default
        $raceName = 'GUERRERO';
        
        if (str_contains($title, 'SAIYAN')) { $raceColor = 'warning'; $raceName = 'RAZA SAIYAN'; }
        elseif (str_contains($title, 'NAMEK')) { $raceColor = 'success'; $raceName = 'RAZA NAMEKIANA'; }
        elseif (str_contains($title, 'FROST')) { $raceColor = 'info'; $raceName = 'RAZA DE FROST'; }
        elseif (str_contains($title, 'HUMANA')) { $raceColor = 'primary'; $raceName = 'RAZA HUMANA'; }

        // Adjust accent color based on race
        $accent = "var(--bs-$raceColor)";
    @endphp

    <style>
        /* --- GLOBAL --- */
        body {
            background-color: #030303;
            background-image: 
                linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.95)),
                url('https://images.hdqwalls.com/download/hyperbolic-time-chamber-dragon-ball-z-4k-5y-1920x1080.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        /* --- HEADER --- */
        .training-hero {
            text-align: center;
            padding: 80px 20px 60px;
            background: radial-gradient(circle at center, rgba(var(--bs-{{ $raceColor }}-rgb), 0.1) 0%, rgba(0,0,0,0) 70%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 40px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            text-shadow: 0 0 30px {{ $accent }};
            color: #fff;
        }

        .hero-desc {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 700px;
            margin: 0 auto;
        }

        .race-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding: 8px 25px;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid {{ $accent }};
            color: {{ $accent }};
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 3px;
            border-radius: 50px;
            box-shadow: 0 0 15px rgba(var(--bs-{{ $raceColor }}-rgb), 0.3);
        }

        /* --- EXERCISES GRID --- */
        .exercise-card {
            background: rgba(20, 20, 20, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 4px solid {{ $accent }};
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .exercise-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .exercise-card.completed {
            background: rgba(var(--bs-{{ $raceColor }}-rgb), 0.1);
            border-color: {{ $accent }};
        }

        .exercise-card.completed .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        .exercise-name {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .exercise-meta {
            display: flex;
            gap: 20px;
            font-family: 'Courier New', monospace;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .meta-item i { color: {{ $accent }}; }

        /* Check Circle */
        .check-circle {
            width: 24px;
            height: 24px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: all 0.3s;
        }

        .exercise-card.completed .check-circle {
            background: {{ $accent }};
            border-color: {{ $accent }};
            box-shadow: 0 0 10px {{ $accent }};
        }

        /* --- FINISH BUTTON --- */
        .finish-container {
            text-align: center;
            margin-top: 60px;
            margin-bottom: 100px;
        }
        
        .btn-finish {
            background: linear-gradient(45deg, {{ $accent }}, #fff);
            color: #000;
            border: none;
            padding: 18px 60px;
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(var(--bs-{{ $raceColor }}-rgb), 0.4);
            transform: scale(0.95);
            opacity: 0.5;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-finish.active {
            transform: scale(1.1);
            opacity: 1;
            pointer-events: auto;
            animation: pulseBtn 2s infinite;
        }
        
        @keyframes pulseBtn {
            0% { box-shadow: 0 0 0 0 rgba(var(--bs-{{ $raceColor }}-rgb), 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(var(--bs-{{ $raceColor }}-rgb), 0); }
            100% { box-shadow: 0 0 0 0 rgba(var(--bs-{{ $raceColor }}-rgb), 0); }
        }

    </style>

    <!-- HERO SECTION -->
    <div class="training-hero">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill position-absolute start-0 top-0 m-4" style="z-index: 100;">
            <i class="bi bi-arrow-left me-2"></i> VOLVER AL INICIO
        </a>

        <div class="race-badge">
            <i class="bi bi-person-bounding-box"></i>
            {{ $isProgram ? $raceName : 'PROTOCOLO ' . strtoupper($training->difficulty) }}
        </div>
        <h1 class="hero-title">{{ $training->title }}</h1>
        <p class="hero-desc">{{ $training->description }}</p>
    </div>

    <div class="container">
        <!-- FORMULARIO OCULTO -->
        <form id="complete-form" action="{{ route('training.complete', $training->id) }}" method="POST">
            @csrf
            
            <!-- EJERCICIOS GRID -->
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @if(is_array($training->exercises))
                    @foreach($training->exercises as $index => $exercise)
                        <div class="col">
                            <div class="exercise-card" onclick="toggleExercise({{ $index }})" id="card-{{ $index }}">
                                <div class="check-circle"></div>
                                <h3 class="exercise-name">{{ $exercise['name'] }}</h3>
                                <div class="exercise-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-repeat"></i> {{ $exercise['reps'] }}
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-stopwatch"></i> {{ $exercise['rest'] }}
                                    </div>
                                </div>
                                <input type="checkbox" name="exercises[]" 
                                       value="{{ $exercise['name'] }}" 
                                       id="check-{{ $index }}" 
                                       class="d-none exercise-check">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted">No hay ejercicios listados.</div>
                @endif
            </div>

            <!-- ACTION BUTTON -->
            <div class="finish-container">
                <button type="submit" id="btn-finish" class="btn-finish">
                    <i class="bi bi-trophy-fill me-2"></i> COMPLETAR ENTRENAMIENTO
                </button>
            </div>
            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script>
        function toggleExercise(index) {
            const checkbox = document.getElementById('check-' + index);
            const card = document.getElementById('card-' + index);
            
            checkbox.checked = !checkbox.checked;
            
            if(checkbox.checked) {
                card.classList.add('completed');
            } else {
                card.classList.remove('completed');
            }
            
            checkCompletion();
        }
        
        function checkCompletion() {
            const checkboxes = document.querySelectorAll('.exercise-check');
            const total = checkboxes.length;
            let checked = 0;
            
            checkboxes.forEach(cb => { if(cb.checked) checked++; });
            
            const btn = document.getElementById('btn-finish');
            
            // Check if user has checked at least one (since logic currently requires ALL, let's keep it ALL)
            if(checked === total && total > 0) {
                btn.classList.add('active');
                
                // Mini conffeti al desbloquear
                confetti({
                    particleCount: 50,
                    spread: 60,
                    origin: { y: 0.8 },
                    colors: ['{{ $raceColor == "warning" ? "#ffc107" : ($raceColor == "success" ? "#00ff41" : "#00d2ff") }}']
                });
            } else {
                btn.classList.remove('active');
            }
        }
    </script>
@endsection
