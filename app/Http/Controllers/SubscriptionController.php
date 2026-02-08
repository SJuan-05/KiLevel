<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function checkout(Request $request) {
        $plan = $request->query('plan');
        $prices = [
            'roshi' => 0,
            'kaio' => 5,
            'whis' => 10
        ];

        if (!array_key_exists($plan, $prices)) {
            return redirect()->route('register.plans')->with('error', 'Plan no válido');
        }

        // Si el usuario ya tiene ese plan
        if (Auth::user()->plan === $plan) {
            return redirect()->route('dashboard'); // O mostrar un mensaje flash
        }

        // Guardar en sesión el plan que se intenta comprar
        session([
            'plan_waiting_payment' => $plan,
            'plan_price' => $prices[$plan]
        ]);

        return redirect()->route('payment.show');
    }

    public function process(Request $request) {
        $plan = session('plan_waiting_payment');
        
        if (!$plan) {
            return redirect()->route('dashboard');
        }

        /** @var User $user */
        $user = Auth::user();
        $user->plan = $plan;
        $user->syncPlanMultiplier(); // Sincroniza el multiplicador de XP
        $user->save();

        // Limpiar sesión
        session()->forget(['plan_waiting_payment', 'plan_price']);

        return response()->json(['success' => true]);
    }
}
