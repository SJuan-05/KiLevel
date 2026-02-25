@extends('layouts.app')

@section('content')
<style>
    .support-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }
    .support-header::after {
        content: '';
        display: block;
        width: 100px;
        height: 4px;
        background: #ffc107;
        margin: 15px auto 0;
        box-shadow: 0 0 15px #ffc107;
        border-radius: 2px;
    }
    .support-title {
        font-size: 3rem;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
        margin-bottom: 5px;
    }
    .support-subtitle {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.7);
        background: rgba(255, 193, 7, 0.1);
        display: inline-block;
        padding: 5px 15px;
        border-radius: 4px;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }
    
    .contact-card {
        background: rgba(10, 10, 10, 0.85);
        border: 1px solid rgba(255, 193, 7, 0.2);
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.9);
        position: relative;
        backdrop-filter: blur(10px);
    }
    .contact-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #ffc107, transparent);
    }

    .form-group-custom {
        margin-bottom: 25px;
        position: relative;
    }

    .form-control-custom, .form-select-custom {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control-custom:focus, .form-select-custom:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #ffc107;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.15);
        color: #fff;
        outline: none;
    }
    
    .form-control-custom:disabled, .form-control-custom[readonly] {
        background: rgba(0, 0, 0, 0.6);
        color: #ffc107 !important; /* Fix for visibility */
        border-color: rgba(255, 193, 7, 0.3);
        opacity: 0.8;
    }

    .form-label-custom {
        color: rgba(255, 255, 255, 0.6);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8rem;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-custom::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .btn-submit-support {
        display: inline-block;
        background: #ffc107;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        padding: 18px 45px;
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 20px rgba(255, 193, 7, 0.2);
        transition: all 0.3s ease;
        font-size: 1.1rem;
        width: 100%;
        margin-top: 15px;
    }
    .btn-submit-support:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 193, 7, 0.4);
        background: #ffcf33;
    }

    .info-box {
        background: rgba(255, 193, 7, 0.05);
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 0 8px 8px 0;
        margin-bottom: 30px;
    }

    /* Option styling for the select dropdown */
    .form-select-custom option {
        background: #111;
        color: #fff;
    }
</style>

<div class="container pb-5">
    
    <div class="support-header">
        <h1 class="support-title"><i class="bi bi-headset"></i> Comunicador</h1>
        <div class="support-subtitle">CONEXIÓN DIRECTA CON LOS DIOSES</div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="info-box">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle-fill text-warning fs-2"></i>
                    <div>
                        <h5 class="text-white fw-bold mb-1">¿Problemas en tu entrenamiento?</h5>
                        <p class="text-white-50 mb-0 small">Si has encontrado una anomalía en la Matrix (bug), tienes dudas sobre tus misiones, o quieres sugerir una nueva mejora para la plataforma, envía tu reporte. Estamos monitorizando el multiverso.</p>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                @if ($errors->any())
                    <div class="alert alert-danger border border-danger bg-dark text-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('support.submit') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 form-group-custom">
                            <label class="form-label-custom">TU CORREO (AUTOMÁTICO)</label>
                            <input type="email" class="form-control form-control-custom fw-bold text-warning" value="{{ $user->email }}" readonly disabled>
                        </div>
                        <div class="col-md-6 form-group-custom">
                            <label class="form-label-custom">TIPO DE REPORTE <span class="text-danger">*</span></label>
                            <select name="type" class="form-select form-select-custom" required>
                                <option value="" disabled selected>-- Selecciona el tipo --</option>
                                <option value="bug" {{ old('type') == 'bug' ? 'selected' : '' }}>Reportar un Error (Bug)</option>
                                <option value="question" {{ old('type') == 'question' ? 'selected' : '' }}>Duda / Pregunta</option>
                                <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>Sugerencia de Mejora</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">ASUNTO <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control form-control-custom" placeholder="Ej: Las misiones diarias no cargan correctamente..." value="{{ old('subject') }}" required maxlength="100">
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">MENSAJE DETALLADO <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control form-control-custom" rows="6" placeholder="Explica tu situación con el mayor detalle posible..." required minlength="20">{{ old('message') }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn-submit-support">
                            <i class="bi bi-send-fill me-2"></i> ENVIAR TRANSMISIÓN
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
