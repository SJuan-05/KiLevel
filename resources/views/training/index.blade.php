@extends('layouts.app')

@section('content')
    <style>
        /* FONDO Y ESTRUCTURA GLOBAL */
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
        }

        .training-header {
            font-weight: 900;
            text-transform: uppercase;
            font-style: italic;
            letter-spacing: 3px;
            color: #fff;
            text-shadow: 0 0 20px rgba(255, 193, 7, 0.6);
            position: relative;
            display: inline-block;
        }

        .training-header::after {
            content: '';
            display: block;
            width: 60%;
            height: 4px;
            background: #ffc107;
            margin: 10px auto 0;
            box-shadow: 0 0 15px #ffc107;
        }

        /* TARJETA MAESTRA */
        .race-card {
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

        /* CONTENIDO INTERNO */
        .race-card-inner {
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
            top: -10%;
            left: -10%;
            width: 120%;
            height: 120%;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease, filter 0.6s ease;
            z-index: 1;
            filter: grayscale(80%) brightness(0.5);
            transform: skewX(3deg);
        }

        .race-card:hover .card-img-bg {
            transform: skewX(3deg) scale(1.1);
            filter: grayscale(0%) brightness(0.9);
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, #000 10%, rgba(0, 0, 0, 0.8) 40%, rgba(0, 0, 0, 0) 100%);
            z-index: 2;
            pointer-events: none;
        }

        /* ESTILOS DE TEXTO */
        .race-subtitle {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 2px;
            padding: 4px 10px;
            border-radius: 4px;
            margin-bottom: 5px;
            backdrop-filter: blur(4px);
            text-shadow: 0 1px 2px #000;
        }

        .race-title {
            font-family: 'Arial Black', sans-serif;
            font-size: 2.6rem;
            text-transform: uppercase;
            line-height: 0.9;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.8));
        }

        /* Stats Box */
        .race-stats {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            background: rgba(0, 0, 0, 0.85);
            border-left: 3px solid #fff;
            /* Borde izquierdo blanco por defecto */
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .stat-focus {
            display: block;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: #e0e0e0;
            font-style: italic;
            font-size: 0.8rem;
        }

        /* COLORES ESPECÍFICOS Y BRILLOS */
        /* Saiyan */
        .saiyan-card:hover {
            border-color: #ffc107;
            box-shadow: 0 0 35px rgba(255, 193, 7, 0.5);
        }

        .saiyan-text {
            color: #ffc107;
            text-shadow: 0 0 15px rgba(255, 193, 7, 0.8);
        }

        /* Namek */
        .namek-card:hover {
            border-color: #00ff41;
            box-shadow: 0 0 35px rgba(0, 255, 65, 0.5);
        }

        .namek-text {
            color: #00ff41;
            text-shadow: 0 0 15px rgba(0, 255, 65, 0.8);
        }

        /* Freezer */
        .freezer-card:hover {
            border-color: #d500f9;
            box-shadow: 0 0 35px rgba(213, 0, 249, 0.5);
        }

        .freezer-text {
            color: #d500f9;
            text-shadow: 0 0 15px rgba(213, 0, 249, 0.8);
        }

        /* Humano */
        .human-card:hover {
            border-color: #00e5ff;
            box-shadow: 0 0 35px rgba(0, 229, 255, 0.5);
        }

        .human-text {
            color: #00e5ff;
            text-shadow: 0 0 15px rgba(0, 229, 255, 0.8);
        }


        /* --- NUEVO BOTÓN KILEVEL (UNIFICADO) --- */
        .btn-kilevel {
            width: 100%;
            padding: 14px;

            /* Estética KiLevel: Negro y Amarillo */
            background: #ffc107;
            color: #000;

            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #ffc107;

            /* Forma poligonal de combate */
            clip-path: polygon(0 0, 100% 0, 100% 70%, 90% 100%, 0 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        /* Efecto Hover Potente */
        .btn-kilevel:hover {
            background: #000;
            color: #ffc107;
            border-color: #ffc107;
            box-shadow: 0 0 25px rgba(255, 193, 7, 0.6);
            /* Resplandor dorado */
            transform: translateY(-3px) scale(1.02);
        }

        .btn-kilevel:active {
            transform: scale(0.98);
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="training-header display-4">CÁMARA DE GRAVEDAD</h1>
            <p class="text-white mt-3 fw-bold" style="letter-spacing: 1px; opacity: 0.9;">
                SISTEMA KILEVEL v.12.0 // SELECCIONA TU PROTOCOLO
            </p>
        </div>

        <div class="row g-4 px-2">

            <div class="col-md-3">
                <div class="race-card saiyan-card">
                    <div class="card-img-bg"
                        style="background-image: url('https://static.wikia.nocookie.net/c8f7437e-640a-4491-b092-840db7776ddb/scale-to-width/755');">
                    </div>
                    <div class="card-overlay"></div>

                    <div class="race-card-inner">
                        <div><span class="race-subtitle">CLASE GUERRERA</span></div>

                        <h2 class="race-title saiyan-text">SAIYAN</h2>

                        <div class="race-stats" style="border-color: #ffc107;">
                            <div class="text-white fw-bold">FUERZA: <span class="saiyan-text">S+</span></div>
                            <div class="text-white fw-bold">ZENKAI: <span class="saiyan-text">ACTIVO</span></div>
                            <div class="stat-focus">Enfoque: Hipertrofia y Potencia</div>
                            <div class="mt-2 text-warning small fw-bold"><i class="bi bi-coin me-1"></i> Recompensa: +{{ Auth::user()->calculateZeniReward('hard') }} Z</div>
                        </div>

                        <form action="{{ route('training.select') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race" value="saiyan">
                            <button type="submit" class="btn-kilevel">INICIAR</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="race-card namek-card">
                    <div class="card-img-bg"
                        style="background-image: url('https://i.pinimg.com/originals/56/45/0c/56450cca9bd76cd6311171cd9b00fb7e.gif');">
                    </div>
                    <div class="card-overlay"></div>

                    <div class="race-card-inner">
                        <div><span class="race-subtitle">CLASE MÍSTICA</span></div>

                        <h2 class="race-title namek-text">NAMEK</h2>

                        <div class="race-stats" style="border-color: #00ff41;">
                            <div class="text-white fw-bold">MENTE: <span class="namek-text">S+</span></div>
                            <div class="text-white fw-bold">REGEN: <span class="namek-text">ACTIVO</span></div>
                            <div class="stat-focus">Enfoque: Flexibilidad y Core</div>
                            <div class="mt-2 text-warning small fw-bold"><i class="bi bi-coin me-1"></i> Recompensa: +{{ Auth::user()->calculateZeniReward('medium') }} Z</div>
                        </div>

                        <form action="{{ route('training.select') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race" value="namek">
                            <button type="submit" class="btn-kilevel">INICIAR</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="race-card freezer-card">
                    <div class="card-img-bg"
                        style="background-image: url('https://media1.tenor.com/m/aVoijGGAnyUAAAAC/dokkan-dokkan-battle.gif');">
                    </div>
                    <div class="card-overlay"></div>

                    <div class="race-card-inner">
                        <div><span class="race-subtitle">EMPERADOR</span></div>

                        <h2 class="race-title freezer-text">FROST</h2>

                        <div class="race-stats" style="border-color: #d500f9;">
                            <div class="text-white fw-bold">VELOCIDAD: <span class="freezer-text">SS</span></div>
                            <div class="text-white fw-bold">RESISTENCIA: <span class="freezer-text">A+</span></div>
                            <div class="stat-focus">Enfoque: HIIT y Cardio</div>
                            <div class="mt-2 text-warning small fw-bold"><i class="bi bi-coin me-1"></i> Recompensa: +{{ Auth::user()->calculateZeniReward('hard') }} Z</div>
                        </div>

                        <form action="{{ route('training.select') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race" value="frost">
                            <button type="submit" class="btn-kilevel">INICIAR</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="race-card human-card">
                    <div class="card-img-bg"
                        style="background-image: url('https://media1.tenor.com/m/xv0k73ZUFIMAAAAC/muten-roshi-peace.gif');">
                    </div>
                    <div class="card-overlay"></div>

                    <div class="race-card-inner">
                        <div><span class="race-subtitle">DEFENSOR</span></div>

                        <h2 class="race-title human-text">HUMANO</h2>

                        <div class="race-stats" style="border-color: #00e5ff;">
                            <div class="text-white fw-bold">TÉCNICA: <span class="human-text">S</span></div>
                            <div class="text-white fw-bold">KI: <span class="human-text">100%</span></div>
                            <div class="stat-focus">Enfoque: Calistenia y Resistencia</div>
                            <div class="mt-2 text-warning small fw-bold"><i class="bi bi-coin me-1"></i> Recompensa: +{{ Auth::user()->calculateZeniReward('easy') }} Z</div>
                        </div>

                        <form action="{{ route('training.select') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race" value="human">
                            <button type="submit" class="btn-kilevel">INICIAR</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-warning rounded-pill px-4 fw-bold"
                style="border-width: 2px;">
                <i class="bi bi-arrow-return-left me-2"></i> ABORTAR MISIÓN
            </a>
        </div>
    </div>
@endsection
