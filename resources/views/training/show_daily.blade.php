@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #0d0d0d;
            color: #fff;
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)), url('https://w.wallhaven.cc/full/wy/wallhaven-wy2j6r.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .daily-hero {
            text-align: center;
            padding: 60px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
        }

        .difficulty-badge {
            display: inline-block;
            padding: 5px 15px;
            border: 1px solid #fff;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .mission-title {
            font-size: 3rem;
            font-weight: 800;
            text-transform: uppercase;
            text-shadow: 0 0 20px rgba(255,255,255,0.2);
            margin-bottom: 10px;
        }

        .exercise-list {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .exercise-row {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 4px;
            border-left: 3px solid #666;
            transition: 0.3s;
        }

        .exercise-row:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .exercise-info {
            flex-grow: 1;
        }

        .exercise-name {
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .exercise-meta {
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .check-circle {
            width: 24px;
            height: 24px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            margin-right: 20px;
            transition: 0.3s;
            cursor: pointer;
        }

        .exercise-row.completed .check-circle {
            background: #00ff41;
            border-color: #00ff41;
            box-shadow: 0 0 10px #00ff41;
        }
        
        .exercise-row.completed {
            border-left-color: #00ff41;
            background: rgba(0, 255, 65, 0.05);
        }

        .btn-finish {
            background: #fff;
            color: #000;
            padding: 15px 40px;
            font-weight: 900;
            text-transform: uppercase;
            border: none;
            font-size: 1.2rem;
            display: block;
            margin: 50px auto;
            opacity: 0.5;
            cursor: not-allowed;
            transition: 0.3s;
        }

        .btn-finish.active {
            background: #00ff41;
            opacity: 1;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
        }
    </style>

    <div class="daily-hero">
        <div class="d-flex justify-content-between px-4 pt-3">
        <div class="d-flex justify-content-between px-4 pt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-house-door"></i> REGRESAR AL INICIO
            </a>
            <div class="difficulty-badge border rounded px-2">{{ $training->difficulty }}</div>
            <div style="width: 100px;"></div> <!-- Spacer -->
        </div>
        
        <div class="mt-4">
            <h1 class="mission-title">{{ $training->title }}</h1>
            <p class="text-white-50">{{ $training->description }}</p>
        </div>
    </div>

    <form action="{{ route('training.complete', $training->id) }}" method="POST">
        @csrf
        <div class="exercise-list">
            @if(is_array($training->exercises))
                @foreach($training->exercises as $index => $exercise)
                    @php $isCompleted = in_array((string)$index, $currentProgress) || in_array((int)$index, $currentProgress); @endphp
                    <div class="exercise-row {{ $isCompleted ? 'completed' : '' }}" id="row-{{ $index }}" onclick="toggleCheck({{ $index }})">
                        <div class="check-circle"></div>
                        <div class="exercise-info">
                            <div class="exercise-name">{{ $exercise['name'] }}</div>
                            <div class="exercise-meta">
                                <i class="bi bi-repeat"></i> {{ $exercise['reps'] }} &nbsp;|&nbsp; 
                                <i class="bi bi-stopwatch"></i> {{ $exercise['rest'] }}
                            </div>
                        </div>
                        <input type="checkbox" name="exercises[]" value="{{ $exercise['name'] }}" id="check-{{ $index }}" class="d-none ex-check" {{ $isCompleted ? 'checked' : '' }}>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="d-grid gap-2 col-8 mx-auto mt-5 mb-5 pb-5">
            <button type="submit" id="btn-finish" class="btn-finish w-100" disabled>COMPLETAR PROTOCOLO</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light py-3 text-uppercase fw-bold shadow-sm" style="border-radius: 4px;">
                <i class="bi bi-house-door"></i> Regresar al Inicio
            </a>
        </div>
    </form>

        document.addEventListener('DOMContentLoaded', () => {
            validate(false); // Check initial state without confetti
        });

        function toggleCheck(index) {
            const row = document.getElementById('row-' + index);
            const check = document.getElementById('check-' + index);
            
            check.checked = !check.checked;
            
            if(check.checked) {
                row.classList.add('completed');
            } else {
                row.classList.remove('completed');
            }
            
            // Save progress via AJAX
            fetch("{{ route('training.toggle', $training->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ index: index })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Progress saved:', data);
            })
            .catch(error => console.error('Error saving progress:', error));

            validate(true);
        }

        function validate(triggerEffects = true) {
            const checks = document.querySelectorAll('.ex-check');
            let all = true;
            checks.forEach(c => { if(!c.checked) all = false; });
            
            const btn = document.getElementById('btn-finish');
            if(all) {
                btn.disabled = false;
                btn.classList.add('active');
                if (triggerEffects && typeof confetti !== 'undefined') {
                    confetti({
                        particleCount: 40,
                        spread: 60,
                        origin: { y: 0.8 }
                    });
                }
            } else {
                btn.disabled = true;
                btn.classList.remove('active');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
@endsection
