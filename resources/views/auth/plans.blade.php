<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potenciador Kaio - KiLevel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #000;
            /* Fondo negro como la landing */
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .scale-up {
            transform: scale(1.05);
            z-index: 10;
        }

        .card {
            border-radius: 1.5rem;
            transition: transform 0.3s ease;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            font-weight: bold;
            color: #000;
        }

        .btn-outline-dark:hover {
            background-color: #000;
            color: #fff;
        }

        /* Estilo para que las cards se vean blancas y el texto oscuro como en tu imagen */
        .card-plan {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <h1 class="text-center text-warning mb-5 fw-bold display-4">Potenciador Kaio</h1>

        <div class="row g-4 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card card-plan h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Plan de Roshi</h5>
                        <p class="text-muted small">Para individuos</p>
                        <h2 class="display-5 fw-bold">$0<span class="fs-6 text-muted"> / mes</span></h2>
                        <ul class="list-unstyled my-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Misiones
                                diarias y semanales</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Título
                                "Aprendiz Tortuga"</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> x1 exp</li>
                        </ul>
                        @auth
                            @if(Auth::user()->plan === 'roshi')
                                <button class="btn btn-secondary w-100 rounded-pill py-2" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('payment.checkout', ['plan' => 'roshi']) }}" class="btn btn-outline-dark w-100 rounded-pill py-2">Cambiar a Roshi</a>
                            @endif
                        @else
                            <a href="{{ route('register', ['plan' => 'roshi']) }}" class="btn btn-outline-dark w-100 rounded-pill py-2">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-plan h-100 border-0 shadow-lg scale-up border-warning"
                    style="border-width: 2px !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="fw-bold">Plan Kaio del Norte</h5>
                            <span class="badge bg-warning text-dark rounded-pill">Popular</span>
                        </div>
                        <p class="text-muted small">Para equipos medianos</p>
                        <h2 class="display-5 fw-bold">$5<span class="fs-6 text-muted"> / mes</span></h2>
                        <ul class="list-unstyled my-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> El Plan
                                Anterior</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Gremios</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Título Único
                                "Maestro del Ki"</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> x1.5 exp</li>
                        </ul>
                        @auth
                            @if(Auth::user()->plan === 'kaio')
                                <button class="btn btn-secondary w-100 rounded-pill py-2" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('payment.checkout', ['plan' => 'kaio']) }}" class="btn btn-warning w-100 rounded-pill py-2 fw-bold text-dark">Activar Kaio</a>
                            @endif
                        @else
                            <a href="{{ route('register', ['plan' => 'kaio']) }}" class="btn btn-dark w-100 rounded-pill py-2 text-white">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-plan h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Plan Ángel Whis</h5>
                        <p class="text-muted small">Para grandes equipos</p>
                        <h2 class="display-5 fw-bold">$10<span class="fs-6 text-muted"> / mes</span></h2>
                        <ul class="list-unstyled my-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Los Dos Planes
                                Anteriores</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Nueva
                                dificultad "Hakaishin"</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Título Único
                                "Ki Divino"</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> x2 exp</li>
                        </ul>
                        @auth
                            @if(Auth::user()->plan === 'whis')
                                <button class="btn btn-secondary w-100 rounded-pill py-2" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('payment.checkout', ['plan' => 'whis']) }}" class="btn btn-outline-dark w-100 rounded-pill py-2">Ascender a Whis</a>
                            @endif
                        @else
                            <a href="{{ route('register', ['plan' => 'whis']) }}" class="btn btn-outline-dark w-100 rounded-pill py-2">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="index.html" class="text-warning text-decoration-none small">← Volver al inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
