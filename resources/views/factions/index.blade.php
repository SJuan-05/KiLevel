@extends('layouts.app')

@section('content')
<style>
    /* ESTILOS CYBER/TECH DE LISTADO */
    .faction-card {
        background: rgba(10, 10, 10, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .faction-card:hover {
        transform: translateY(-5px);
        border-color: #ffc107;
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
    }

    .faction-header {
        background: rgba(255, 193, 7, 0.1);
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
    }

    .faction-name {
        font-weight: 900;
        text-transform: uppercase;
        color: #fff;
        margin: 0;
        letter-spacing: 1px;
        flex: 1;
        min-width: 200px;
    }

    .faction-body {
        padding: 20px;
    }

    .faction-stat {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 5px;
    }

    .btn-create-faction {
        background: #ffc107;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        border: none;
        padding: 15px 30px;
        clip-path: polygon(10% 0, 100% 0, 100% 70%, 90% 100%, 0 100%, 0 30%);
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-create-faction:hover {
        background: #fff;
        color: #000;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.6);
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h1 class="display-4 fw-bold text-white text-uppercase" style="text-shadow: 0 0 20px rgba(255, 193, 7, 0.5);">
                Facciones Aliadas
            </h1>
            <p class="text-white-50">Únete a un ejército o lidera el tuyo propio.</p>
        </div>
        <a href="{{ route('factions.create') }}" class="btn-create-faction">
            <i class="bi bi-flag-fill me-2"></i> Crear Facción
        </a>
    </div>

    <div class="row g-4">
        @foreach($factions as $faction)
            <div class="col-md-4">
                <div class="faction-card h-100">
                    <div class="faction-header">
                        <h3 class="faction-name">{{ $faction->name }}</h3>
                        <div>
                            @if(Auth::user()->faction_id === $faction->id)
                                <span class="badge bg-success text-white me-2"><i class="bi bi-check-lg"></i> TU FACCION</span>
                            @endif
                            <span class="badge bg-warning text-dark">{{ $faction->members_count }} Miembros</span>
                        </div>
                    </div>
                    <div class="faction-body">
                        <p class="text-white-50 small mb-4">{{ Str::limit($faction->description ?? 'Sin descripción.', 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="faction-stat">
                                <i class="bi bi-lightning-charge text-warning"></i> Poder: {{ number_format($faction->total_power) }}
                            </div>
                            <a href="{{ route('factions.show', $faction->id) }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                                Ver Detalles <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
