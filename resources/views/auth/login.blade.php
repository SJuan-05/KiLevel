<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso KiLevel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #000;
            background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #000 85%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: white;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .auth-card {
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: skewX(-3deg);
            padding: 40px;
            box-shadow: 0 0 40px rgba(255, 193, 7, 0.15);
            width: 100%;
        }

        .auth-inner {
            transform: skewX(3deg);
        }

        .input-cyber {
            background: #111;
            border: 1px solid #333;
            color: #fff;
            padding: 12px;
            border-radius: 0;
            width: 100%;
            font-weight: bold;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .input-cyber:focus {
            border-color: #ffc107;
            outline: none;
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.2);
            color: #fff;
        }

        .btn-auth {
            width: 100%;
            background: #ffc107;
            color: #000;
            font-weight: 900;
            padding: 14px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 95% 100%, 0 100%);
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-auth:hover {
            background: #fff;
            box-shadow: 0 0 25px #ffc107;
            transform: translateY(-2px);
        }

        .fw-black {
            font-weight: 900;
        }

        a:hover .text-warning {
            text-shadow: 0 0 10px #ffc107;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="text-center mb-4">
                    <h1 class="fw-black text-white fst-italic display-4">ACCESO KILEVEL</h1>
                    <p class="text-warning fw-bold small text-uppercase" style="letter-spacing: 4px;">Identificación de
                        Guerrero</p>
                </div>

                <div class="auth-card">
                    <div class="auth-inner">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <label class="text-white-50 small mb-1 fw-bold">CORREO ELECTRÓNICO</label>
                            <input type="email" name="email" class="input-cyber" placeholder="goku@kilevel.com"
                                required autofocus>

                            <label class="text-white-50 small mb-1 fw-bold">CONTRASEÑA</label>
                            <input type="password" name="password" class="input-cyber" placeholder="••••••••" required>

                            @error('email')
                                <div class="text-danger small mb-3 fw-bold border border-danger p-2 bg-dark">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn-auth mt-2">ENTRAR AL DOJO</button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('register.plans') }}"
                                class="text-white-50 small text-decoration-none hover-warning">
                                ¿Aún no tienes cuenta? <span class="text-warning fw-bold">Ver Planes de
                                    Entrenamiento</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
