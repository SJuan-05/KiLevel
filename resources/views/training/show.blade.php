@extends('layouts.app')

@section('content')
    @php
        // Detect Race colors again
        $title = strtoupper($training->title);
        $raceColor = 'warning'; // Default Gold for daily/generic
        
        if (str_contains($title, 'SAIYAN')) { $raceColor = 'warning'; }
        elseif (str_contains($title, 'NAMEK')) { $raceColor = 'success'; }
        elseif (str_contains($title, 'FROST')) { $raceColor = 'info'; }
        elseif (str_contains($title, 'HUMAN') || str_contains($title, 'HUMANA')) { $raceColor = 'primary'; }

        $accent = "var(--bs-$raceColor)";
    @endphp

    <style>
        body {
            background-color: #050505;
            color: #fff;
            background-image: linear-gradient(rgba(0,0,0,0.9), rgba(0,0,0,0.95)), url('https://w.wallhaven.cc/full/wy/wallhaven-wy2j6r.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .program-hero {
            padding: 80px 20px 60px;
            background: radial-gradient(circle at top, rgba(var(--bs-{{$raceColor}}-rgb), 0.15), transparent 70%);
            text-align: center;
        }

        .program-title {
            font-size: 3.5rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-shadow: 0 0 40px rgba(var(--bs-{{$raceColor}}-rgb), 0.5);
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* --- PRETTY CARD DESIGN --- */
        .exercise-card {
            background: rgba(20,20,20,0.85);
            border: 1px solid rgba(255,255,255,0.05);
            border-left: 4px solid {{ $accent }};
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .exercise-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border-color: rgba(255, 255, 255, 0.3);
            border-left-color: {{ $accent }};
        }

        .exercise-card.completed {
            background: rgba(var(--bs-{{$raceColor}}-rgb), 0.1);
            border: 1px solid {{ $accent }};
            border-left: 4px solid {{ $accent }};
        }

        .exercise-name {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 15px;
            text-transform: uppercase;
            padding-right: 30px; /* Space for circle */
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

        /* CIRCLE INDICATOR */
        .check-circle {
            width: 24px;
            height: 24px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: absolute;
            top: 25px;
            right: 25px;
            transition: all 0.3s;
        }

        .exercise-card.completed .check-circle {
            background: {{ $accent }};
            border-color: {{ $accent }};
            box-shadow: 0 0 10px {{ $accent }};
        }

        /* --- BUTTONS --- */
        .finish-area {
            text-align: center;
            padding: 60px 0 100px;
        }

        .btn-finish-lg {
            background: linear-gradient(45deg, {{ $accent }}, #fff);
            color: #000;
            border: none;
            padding: 20px 80px;
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            border-radius: 50px;
            box-shadow: 0 0 20px rgba(var(--bs-{{$raceColor}}-rgb), 0.3);
            transition: all 0.4s;
            cursor: pointer;
            opacity: 0.5;
            pointer-events: none;
            transform: scale(0.95);
        }
        
        .btn-finish-lg.ready {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
            animation: pulseBtn 2s infinite;
        }

        @keyframes pulseBtn {
            0% { box-shadow: 0 0 0 0 rgba(var(--bs-{{$raceColor}}-rgb), 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(var(--bs-{{$raceColor}}-rgb), 0); }
            100% { box-shadow: 0 0 0 0 rgba(var(--bs-{{$raceColor}}-rgb), 0); }
        }

    </style>

    <div class="program-hero">
        <h1 class="program-title" style="margin-top: 20px;">{{ $training->title }}</h1>
        <p class="lead text-white-50">{{ $training->description }}</p>
    </div>

    <form action="{{ route('training.complete', $training->id) }}" method="POST">
        @csrf
        <div class="grid-container">
            @if(is_array($training->exercises))
                @foreach($training->exercises as $index => $exercise)
                    @php $isCompleted = in_array((string)$index, $currentProgress) || in_array((int)$index, $currentProgress); @endphp
                    <div class="exercise-card {{ $isCompleted ? 'completed' : '' }}" id="card-{{$index}}" onclick="toggleCard({{$index}})">
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
                        <input type="checkbox" name="exercises[]" value="{{ $exercise['name'] }}" id="chk-{{$index}}" class="d-none card-check" {{ $isCompleted ? 'checked' : '' }}>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="finish-area">
            <button type="submit" id="main-finish-btn" class="btn-finish-lg mb-5">FINALIZAR ENTRENAMIENTO</button>
            
            <div class="d-flex justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg px-5 shadow-lg" style="border-radius: 50px; background: rgba(255,255,255,0.05); backdrop-filter: blur(5px);">
                    <i class="bi bi-house-door"></i> REGRESAR AL INICIO
                </a>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            checkAll(false); // Check initial state without confetti
        });

        function toggleCard(id) {
            const card = document.getElementById('card-' + id);
            const chk = document.getElementById('chk-' + id);
            
            chk.checked = !chk.checked;
            
            if(chk.checked) {
                card.classList.add('completed');
            } else {
                card.classList.remove('completed');
            }
            
            // Save progress via AJAX
            fetch("{{ route('training.toggle', $training->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ index: id })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Progress saved:', data);
            })
            .catch(error => console.error('Error saving progress:', error));

            checkAll(true);
        }

        function checkAll(triggerConfetti = true) {
            const all = document.querySelectorAll('.card-check');
            let complete = true;
            all.forEach(c => { if(!c.checked) complete = false; });
            
            const btn = document.getElementById('main-finish-btn');
            
            if(complete) {
                btn.classList.add('ready');
                if (triggerConfetti) {
                    confetti({
                        particleCount: 50,
                        spread: 70,
                        origin: { y: 0.9 }
                    });
                }
            } else {
                btn.classList.remove('ready');
            }
        }
    </script>
@endsection
