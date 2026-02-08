<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiLevel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            background-color: #000 !important;
        }

        .landing-container {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .btn-gold {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 10px;
            border: none;
        }

        .btn-gold:hover {
            background-color: #e0a800;
            color: #000;
        }

        .btn-outline-gold {
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
        }
    </style>

    <div class="landing-container">
        <h1 class="display-1 fw-bold text-warning mb-0">Bienvenid@ a KiLevel</h1>
        <p class="fs-4 text-warning opacity-75 mb-5">Entra y desafíate a ti mismo</p>

        <div class="d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn btn-gold">Iniciar Sesión</a>
            <a href="{{ route('register.plans') }}" class="btn btn-outline-gold">Registrarse</a>
        </div>
    </div>
</body>

</html>
