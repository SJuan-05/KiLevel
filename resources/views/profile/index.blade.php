@extends('layouts.app')

@section('content')
    <style>
        /* --- FONDO GLOBAL --- */
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
        }

        /* --- ESTILOS VISUALES TECH --- */
        .tech-header {
            font-weight: 900;
            text-transform: uppercase;
            font-style: italic;
            letter-spacing: 3px;
            color: #fff;
            text-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
            padding-left: 15px;
        }

        .cyber-card {
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transform: skewX(-3deg);
            padding: 30px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .cyber-inner {
            transform: skewX(3deg);
        }

        /* --- AVATAR --- */
        .avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .avatar-img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border: 3px solid #ffc107;
            box-shadow: 0 0 30px rgba(255, 193, 7, 0.4);
            /* Forma hexagonal tech */
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            background: #222;
        }


        /* --- BARRA XP --- */
        .xp-container {
            background: rgba(255, 255, 255, 0.05);
            height: 8px;
            width: 100%;
            margin: 15px auto;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .xp-fill {
            height: 100%;
            background: #ffc107;
            box-shadow: 0 0 15px #ffc107;
        }

        /* --- FORMULARIOS --- */
        .input-cyber,
        .select-cyber {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid #333;
            color: #fff;
            border-radius: 0;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .input-cyber:focus,
        .select-cyber:focus {
            background: rgba(0, 0, 0, 0.5);
            border-color: #ffc107;
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.1);
            outline: none;
        }

        .select-cyber option {
            background: #000;
            color: #fff;
        }

        /* --- BOTONES --- */
        .btn-kilevel-save {
            width: 100%;
            padding: 12px;
            background: #ffc107;
            color: #000;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #ffc107;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 90% 100%, 0 100%);
            transition: 0.3s;
        }

        .btn-kilevel-save:hover {
            background: #000;
            color: #ffc107;
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.5);
        }

        .btn-kilevel-outline {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #555;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 90% 100%, 0 100%);
            transition: 0.3s;
        }

        .btn-kilevel-outline:hover {
            border-color: #ffc107;
            color: #ffc107;
            background: rgba(255, 193, 7, 0.05);
        }

        /* --- DATOS --- */
        .data-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .data-value.gold {
            color: #ffc107;
            font-weight: bold;
        }
    </style>

    <div class="container py-5">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">

                <div class="avatar-container">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img" alt="Avatar">
                    @else
                        <img src="https://i.imgur.com/8K6hS9p.png" class="avatar-img" alt="Avatar Default">
                    @endif
                </div>

                <h1 class="display-5 fw-black text-white text-uppercase fst-italic mb-1">{{ $user->name }}</h1>
                <p class="text-warning fw-bold text-uppercase" style="letter-spacing: 3px;">{{ $user->current_title }}</p>

                {{-- ACCIONES RÁPIDAS (NUEVO) --}}
                <div class="mt-3 mb-4">
                    @if(Auth::id() != $user->id)
                        @if(Auth::user()->isAllyWith($user))
                            <a href="{{ route('social.index', ['chat' => $user->id]) }}" class="btn btn-sm btn-outline-warning rounded-0 px-4">
                                <i class="bi bi-chat-dots-fill me-2"></i> MENSAJE TÁCTICO
                            </a>
                        @else
                            @php
                                $sent = Auth::user()->pendingRequestsSent()->where('friend_id', $user->id)->exists();
                                $received = Auth::user()->pendingRequestsReceived()->where('user_id', $user->id)->exists();
                            @endphp
                            
                            @if(!$sent && !$received)
                                <form action="{{ route('social.add', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning rounded-0 px-4 fw-black">
                                        <i class="bi bi-person-plus-fill me-2"></i> SOLICITAR ALIANZA
                                    </button>
                                </form>
                            @elseif($sent)
                                <button class="btn btn-sm btn-outline-secondary disabled rounded-0 px-4" disabled>
                                    <i class="bi bi-clock-history me-2"></i> SOLICITUD ENVIADA
                                </button>
                            @elseif($received)
                                <form action="{{ route('social.accept', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success rounded-0 px-4 fw-black">
                                        <i class="bi bi-check-lg me-2"></i> ACEPTAR ALIANZA
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-end mb-1">
                            <div class="text-white-50 small font-monospace">NIVEL {{ $user->level ?? 1 }}</div>
                            @php $remaining = $user->xpToNextLevel(); @endphp
                            <div class="text-white-50 small font-monospace">{{ $remaining !== null ? number_format($remaining) . ' XP RESTANTE' : 'MÁXIMO NIVEL' }}</div>
                        </div>
                        <div class="xp-container">
                            <div class="xp-fill" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-white-50 font-monospace">
                            <span>XP TOTAL: {{ number_format($user->xp) }}</span>
                            <span>{{ round($progress, 1) }}%</span>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mt-4 p-2 text-success border border-success bg-black rounded"
                        style="display: inline-block;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-5">

            <div class="col-md-5">
                <h3 class="tech-header">Datos de Combate</h3>
                <div class="cyber-card">
                    <div class="cyber-inner">
                        @if(Auth::user()->isAllyWith($user))
                            <div class="data-row mt-2">
                                <span class="text-white-50 small">PLAN ACTIVO</span>
                                <span class="data-value gold text-uppercase">PROTOCOLO {{ $user->plan }}</span>
                            </div>
                            <div class="data-row">
                                <span class="text-white-50 small">BILLETERA Z</span>
                                <span class="text-warning fw-bold">{{ number_format($user->zeni ?? 0) }} Z</span>
                            </div>
                            <div class="data-row">
                                <span class="text-white-50 small">KI MULTIPLIER</span>
                                <span class="text-white fw-bold">x{{ number_format($user->xp_multiplier, 1) }}</span>
                            </div>

                            <div class="py-4 text-center">
                                <div class="display-3 fw-bold text-white">{{ $user->streak ?? 0 }}</div>
                                <span class="text-warning fw-bold text-uppercase">DÍAS CONSECUTIVOS 🔥</span>
                            </div>
                        @else
                            <div class="py-5 text-center px-3">
                                <i class="bi bi-eye-slash-fill text-warning opacity-25" style="font-size: 4rem;"></i>
                                <p class="text-white mt-3 text-uppercase fw-bold small">Datos de Combate Bloqueados</p>
                                <p class="small text-white-50">
                                    Necesitas ser **Aliado** o pertenecer a la misma **Facción** para sincronizar estos datos.
                                </p>
                                @php
                                    // Comprobar si hay solicitud enviada
                                    $sent = Auth::user()->pendingRequestsSent()->where('friend_id', $user->id)->exists();
                                @endphp
                                @if(!$sent)
                                    <form action="{{ route('social.add', $user->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button class="btn btn-sm btn-warning fw-black rounded-pill px-4">ENVIAR SOLICITUD</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary disabled rounded-pill px-4 mt-3">SOLICITUD PENDIENTE</button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <h3 class="tech-header">{{ Auth::id() == $user->id ? 'Configuración Neural' : 'Registro de Actividad' }}</h3>

                <div class="cyber-card">
                    <div class="cyber-inner">
                        @if(Auth::id() == $user->id)
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label class="text-white-50 small mb-2">IDENTIFICADOR (NOMBRE)</label>
                                    <input type="text" name="name" class="form-control input-cyber"
                                        value="{{ $user->name }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="text-white-50 small mb-2">TÍTULO DE GUERRERO</label>
                                    <select name="current_title" class="form-select select-cyber">
                                        @foreach($availableTitles as $title)
                                            <option value="{{ $title }}" {{ $user->current_title == $title ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="file" name="avatar" id="avatarInput" class="d-none" onchange="previewFile()">

                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <button type="button" class="btn-kilevel-outline"
                                            onclick="document.getElementById('avatarInput').click()">
                                            <i class="bi bi-camera me-2"></i> SUBIR FOTO
                                        </button>
                                        <div id="fileNameDisplay" class="text-warning small mt-2 fst-italic"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn-kilevel-save">GUARDAR DATOS</button>
                                    </div>
                                </div>
                            </form>

                            <div
                                class="mt-5 pt-4 border-top border-secondary d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-danger mb-0 fw-bold">DESCONEXIÓN</h6>
                                    <small class="text-white-50">Cerrar enlace neuronal.</small>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger text-uppercase">Cerrar
                                        Sesión</button>
                                </form>
                            </div>
                        @elseif(Auth::user()->isAllyWith($user))
                            <div class="activity-registry">
                                @forelse($recentActivity as $activity)
                                    <div class="data-row align-items-center">
                                        <div class="d-flex flex-column">
                                            <span class="text-white fw-bold">{{ $activity->name }}</span>
                                            <span class="text-white-50 small text-uppercase" style="font-size: 0.7rem;">
                                                {{ $activity->type }} • {{ $activity->difficulty }}
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-warning small font-monospace d-block" style="font-size: 0.75rem;">
                                                {{ $activity->pivot->updated_at->diffForHumans() }}
                                            </span>
                                            <span class="badge bg-success py-1 px-2 mt-1" style="font-size: 0.6rem; letter-spacing: 1px;">
                                                COMPLETADO
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-5 text-center text-white-50">
                                        <i class="bi bi-journal-x fs-1 mb-3 d-block opacity-25"></i>
                                        <p class="small text-uppercase fw-bold m-0" style="letter-spacing: 2px;">
                                            Sin registros recientes
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <i class="bi bi-shield-lock text-warning opacity-25" style="font-size: 5rem;"></i>
                                <p class="text-white-50 mt-3 text-uppercase fw-bold" style="letter-spacing: 2px;">
                                    Perfil Público de Guerrero
                                </p>
                                <p class="small text-white-50">
                                    Los datos sensibles del enlace neuronal están protegidos para terceros.
                                </p>
                                <a href="{{ route('factions.index') }}" class="btn btn-sm btn-outline-warning mt-4 px-4 rounded-pill">
                                    VOLVER A FACCIONES
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function previewFile() {
            const input = document.getElementById('avatarInput');
            const fileName = input.files[0] ? input.files[0].name : '';
            document.getElementById('fileNameDisplay').innerText = fileName ? '> Archivo seleccionado: ' + fileName : '';
        }
    </script>
@endsection
