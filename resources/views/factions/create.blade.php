@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-black border border-secondary text-white p-4" style="border-radius: 15px;">
                <h2 class="text-center text-uppercase fw-bold text-warning mb-4">Fundar Nueva Facción</h2>

                <form action="{{ route('factions.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label text-white-50">Nombre de la Facción</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="name" name="name" required placeholder="Ej: Ejército de Freezer">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label text-white-50">Lema / Descripción</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="description" name="description" rows="3" placeholder="Describe el propósito de tu facción..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold text-uppercase">
                            <i class="bi bi-flag-fill me-2"></i> Crear Facción
                        </button>
                        <a href="{{ route('factions.index') }}" class="btn btn-outline-light">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
