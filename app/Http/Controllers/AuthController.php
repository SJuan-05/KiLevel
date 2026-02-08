<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- 1. LOGIN (NUEVO) ---

    // Mostrar formulario de Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar datos del Login
    public function login(Request $request)
    {
        // Validamos datos básicos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos loguear (Auth::attempt encripta la pass y compara sola)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Si entra, lo mandamos al Dashboard
            return redirect()->intended('dashboard');
        }

        // Si falla, volvemos atrás con error
        return back()->withErrors([
            'email' => 'Las credenciales de combate son incorrectas.',
        ])->onlyInput('email');
    }

    // --- 2. LOGOUT (NUEVO) ---
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ANTES: return redirect('/login');
        // AHORA: Redirige a la ruta con nombre 'home'
        return redirect()->route('home');
    }
    // --- 3. REGISTRO (TU CÓDIGO EXISTENTE + Mostrar vista) ---

    // Mostrar formulario de Registro (necesario para la ruta GET)
    public function showRegister()
    {
        return view('auth.register');
    }

    // TU FUNCIÓN ORIGINAL (INTACTA)
    public function register(Request $request)
    {
        // 1. Validamos que lleguen los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            'plan' => 'required'
        ]);

        // 2. Creamos el usuario en la base de datos
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'plan'     => $request->plan,
            'level'    => 1,
            'xp'       => 0,
            'current_title' => $this->asignarTitulo($request->plan),
            'xp_multiplier' => ($request->plan == 'whis') ? 2.0 : (($request->plan == 'kaio') ? 1.5 : 1.0),
        ]);

        // 3. Logueamos al usuario automáticamente
        Auth::login($user);

        // 4. Lógica de redirección
        if ($request->plan == 'roshi') {
            return redirect()->route('dashboard');
        }

        session([
            'plan_price' => ($request->plan == 'kaio' ? 5 : 10),
            'plan_waiting_payment' => $request->plan
        ]);
        return view('auth.payment');
    }

    // TU FUNCIÓN PRIVADA AUXILIAR
    private function asignarTitulo($plan)
    {
        if ($plan == 'whis') return 'Ki Divino';
        if ($plan == 'kaio') return 'Maestro del Ki';
        return 'Aprendiz Tortuga';
    }
}
