<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - KiLevel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        .payment-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Tarjeta de crédito visual */
        .visual-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
            border: 1px solid #ffc107;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: -50px;
            position: relative;
            z-index: 2;
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);
            width: 100%;
            max-width: 350px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-main-body {
            background: #0a0a0a;
            border: 2px solid #ffc107;
            border-radius: 20px;
            padding: 70px 40px 40px 40px;
            z-index: 1;
        }

        .form-control {
            background: #1a1a1a;
            border: 1px solid #444;
            color: #fff;
            font-weight: bold;
        }

        .form-control:focus {
            background: #222;
            border-color: #ffc107;
            color: #fff;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.2);
        }

        .btn-pay {
            background: #ffc107;
            color: #000;
            font-weight: 800;
            text-transform: uppercase;
            padding: 15px;
            border-radius: 10px;
            border: none;
            transition: 0.3s;
            letter-spacing: 1px;
        }

        .btn-pay:hover {
            background: #fff;
            transform: scale(1.02);
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .chip {
            width: 40px;
            height: 30px;
            background: #444;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #loader {
            background: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>
</head>

<body>

    <div id="loader" class="d-none">
        <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status"></div>
        <h3 class="mt-4 text-warning fw-bold">CANALIZANDO KI...</h3>
        <p>Procesando suscripción segura</p>
    </div>

    <div class="payment-container">
        <div class="col-md-5 w-100" style="max-width: 500px;">

            <div class="visual-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="chip"></div>
                    <i class="text-warning fw-bold">KiCard</i>
                </div>
                <h4 id="display-num" class="mb-4 text-center" style="letter-spacing: 2px;">**** **** **** ****</h4>
                <div class="d-flex justify-content-between">
                    <small class="opacity-50 text-uppercase">Guerrero</small>
                    <small class="opacity-50 text-uppercase">Validez</small>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="small fw-bold">{{ Auth::user()->name }}</span>
                    <span id="display-date" class="small fw-bold">MM/YY</span>
                </div>
            </div>

            <div class="card-main-body shadow-lg">
                <h2 class="text-center text-warning fw-bold mb-4">Confirmar Suscripción</h2>

                <div class="d-flex justify-content-between align-items-center p-3 mb-4 rounded"
                    style="background: #1a1a1a; border: 1px dashed #ffc107;">
                    <div>
                        <p class="mb-0 small opacity-75 text-uppercase">Camino elegido</p>
                        <h5 class="mb-0 fw-bold">Plan {{ ucfirst(session('plan_waiting_payment', 'Desconocido')) }}</h5>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 small opacity-75 text-uppercase">Total</p>
                        <h5 class="mb-0 text-warning fw-bold">${{ session('plan_price', '0') }}</h5>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Número de Tarjeta</label>
                    <input type="text" class="form-control form-control-lg" maxlength="19"
                        placeholder="0000 0000 0000 0000" id="card-input" onkeyup="updateCard()">
                </div>

                <div class="row">
                    <div class="col-7 mb-3">
                        <label class="form-label small fw-bold">Expiración</label>
                        <input type="text" class="form-control form-control-lg" maxlength="5" placeholder="MM/YY"
                            id="date-input" onkeyup="updateCard()">
                    </div>
                    <div class="col-5 mb-3">
                        <label class="form-label small fw-bold">CVC</label>
                        <input type="text" class="form-control form-control-lg" maxlength="3" placeholder="123">
                    </div>
                </div>

                <button onclick="simulatePayment()" class="btn btn-pay w-100 mt-4">Activar mi Poder</button>
                <p class="text-center mt-3 small opacity-50">Pago 100% encriptado con Ki-Divino</p>
            </div>
        </div>
    </div>

    <script>
        function updateCard() {
            const num = document.getElementById('card-input').value;
            const date = document.getElementById('date-input').value;
            document.getElementById('display-num').innerText = num || "**** **** **** ****";
            document.getElementById('display-date').innerText = date || "MM/YY";
        }

        function simulatePayment() {
            const loader = document.getElementById('loader');
            loader.classList.remove('d-none');
            
            // Simular tiempo de proceso de red
            setTimeout(() => {
                fetch("{{ route('payment.process') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('¡Poder Aumentado! Tu nuevo plan ha sido activado.');
                        window.location.href = "{{ route('dashboard') }}";
                    } else {
                        alert('Error al procesar el pago. Inténtalo de nuevo.');
                        loader.classList.add('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión.');
                    loader.classList.add('d-none');
                });
            }, 2000);
        }
    </script>

</body>

</html>
