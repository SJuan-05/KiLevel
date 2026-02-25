<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProtocolController;
use App\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes - KiLevel Project
|--------------------------------------------------------------------------
*/



// --- ZONA PÚBLICA / MIXTA ---
// Selección de Plan (Accesible para todos)
Route::get('/select-plan', function () {
    return view('auth.plans');
})->name('register.plans');


// --- ZONA DE INVITADOS (GUEST) ---
// Rutas accesibles SOLO si NO has iniciado sesión
Route::middleware('guest')->group(function () {

    // 2. Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // 3. Registro
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');

});


// --- ZONA DE GUERREROS (AUTH) ---
// Rutas accesibles SOLO si YA has iniciado sesión
Route::middleware('auth')->group(function () {

    // Cerrar Sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Principal (Nueva Home)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Protocolos (Antiguo Dashboard)
    Route::get('/protocols', [ProtocolController::class, 'index'])->name('protocols.index');
    Route::post('/protocols/{id}/start', [ProtocolController::class, 'start'])->name('protocols.start');
    Route::post('/protocols/{id}/cancel', [ProtocolController::class, 'cancel'])->name('protocols.cancel');

    // Detalles del Entrenamiento
    Route::get('/training/{id}', [App\Http\Controllers\TrainingController::class, 'show'])->name('training.show');

    // Entrenamiento (Vista de selección de Raza)
    Route::get('/training', function () {
        return view('training.index');
    })->name('training.index');
    
    // Guardar selección de raza
    Route::post('/training/select', [App\Http\Controllers\TrainingController::class, 'selectRace'])->name('training.select');
    
    // Toggle Exercise (AJAX)
    Route::post('/training/{id}/toggle', [App\Http\Controllers\TrainingController::class, 'toggleExercise'])->name('training.toggle');
    
    // Complete Training
    Route::post('/training/{id}/complete', [App\Http\Controllers\TrainingController::class, 'complete'])->name('training.complete');

    // Misiones (Placeholder)
    Route::get('/missions', function () {
        return "Lista de Misiones (En desarrollo)";
    })->name('missions.index');

    // Perfil del Usuario (Ver y Actualizar)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // 5. TIENDA ZENI
    Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
    Route::post('/shop/buy', [App\Http\Controllers\ShopController::class, 'buy'])->name('shop.buy');
    Route::post('/shop/equip', [App\Http\Controllers\ShopController::class, 'equipTitle'])->name('shop.equip');

    // --- RUTA RAÍZ (HOME) ---
    Route::get('/', [DashboardController::class, 'index'])->name('home'); 

    // 4. SUSCRIPCIONES Y PAGO
    // Preparar el pago (Checkout)
    Route::get('/payment/checkout', [App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('payment.checkout');
    
    // Vista de Pasarela
    Route::get('/payment', function () {
        return view('auth.payment');
    })->name('payment.show');

    // Procesar el pago (Simulación)
    Route::post('/payment/process', [App\Http\Controllers\SubscriptionController::class, 'process'])->name('payment.process');
    // 6. FACCIONES (CLANES)
    Route::get('/factions', [App\Http\Controllers\FactionController::class, 'index'])->name('factions.index');
    Route::get('/factions/create', [App\Http\Controllers\FactionController::class, 'create'])->name('factions.create');
    Route::post('/factions', [App\Http\Controllers\FactionController::class, 'store'])->name('factions.store');
    Route::get('/factions/{id}', [App\Http\Controllers\FactionController::class, 'show'])->name('factions.show');
    Route::post('/factions/{id}/join', [App\Http\Controllers\FactionController::class, 'join'])->name('factions.join');
    Route::post('/factions/{id}/leave', [App\Http\Controllers\FactionController::class, 'leave'])->name('factions.leave');
    Route::post('/factions/member/{user_id}/rank', [App\Http\Controllers\FactionController::class, 'updateRank'])->name('factions.updateRank');

    // 7. SISTEMA SOCIAL (AMIGOS)
    Route::get('/social', [SocialController::class, 'index'])->name('social.index');
    Route::get('/social/search', [SocialController::class, 'search'])->name('social.search');
    Route::post('/social/add/{id}', [SocialController::class, 'addFriend'])->name('social.add');
    Route::post('/social/accept/{id}', [SocialController::class, 'acceptFriend'])->name('social.accept');
    Route::post('/social/remove/{id}', [SocialController::class, 'removeFriend'])->name('social.remove');

    // SOPORTE / CONTACTO
    Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::post('/support/submit', [App\Http\Controllers\SupportController::class, 'submit'])->name('support.submit');

    // 8. SISTEMA DE CHAT
    Route::get('/chat/clan', [App\Http\Controllers\ChatController::class, 'fetchClanMessages'])->name('chat.clan.fetch');
    Route::post('/chat/clan', [App\Http\Controllers\ChatController::class, 'sendClanMessage'])->name('chat.clan.send');
    Route::get('/chat/direct/{id}', [App\Http\Controllers\ChatController::class, 'fetchDirectMessages'])->name('chat.direct.fetch');
    Route::post('/chat/direct/{id}', [App\Http\Controllers\ChatController::class, 'sendDirectMessage'])->name('chat.direct.send');
});
