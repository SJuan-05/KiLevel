<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - KiLevel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            /* Blanco puro para el texto general */
        }

        .card-register {
            background: #0a0a0a;
            /* Negro profundo */
            border: 2px solid #ffc107;
            /* Borde amarillo más grueso para que destaque */
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
            /* Brillo sutil amarillo */
        }

        .form-label {
            color: #fff;
            /* Etiquetas en blanco brillante */
            font-weight: 600;
        }

        .form-control {
            background: #1a1a1a;
            border: 1px solid #ffc107;
            /* Borde de inputs en amarillo */
            color: #fff;
            font-weight: bold;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
            /* Placeholder blanco semi-transparente */
        }

        .form-control:focus {
            background: #222;
            border-color: #fff;
            /* Cambia a blanco al escribir */
            color: #fff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .btn-gold {
            background: #ffc107;
            color: #000;
            font-weight: 800;
            /* Texto bien grueso */
            text-transform: uppercase;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: #fff;
            color: #000;
            transform: translateY(-2px);
        }

        .text-warning {
            color: #ffc107 !important;
            text-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        }

        /* Quitamos el text-muted gris y lo hacemos blanco suave */
        .custom-subtitle {
            color: #e0e0e0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-5">
            <div class="card card-register p-4 shadow-lg">
                <h2 class="text-center text-warning fw-bold mb-2 display-6">Únete a la Orden</h2>
                <p class="text-center custom-subtitle mb-4">Plan seleccionado:
                    <span class="text-warning fw-bold text-uppercase">{{ request('plan', 'Roshi') }}</span>
                </p>

                <form action="{{ route('register.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="{{ request('plan', 'roshi') }}">

                    <div class="mb-3">
                        <label class="form-label">Nombre de Guerrero</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            placeholder="Ej: Vegeta777" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            placeholder="tu@ki.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-3 mt-3">
                        Siguiente: Método de Pago
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
