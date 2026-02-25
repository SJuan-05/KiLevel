<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Show the support contact form.
     */
    public function index()
    {
        $user = Auth::user();
        return view('support.index', compact('user'));
    }

    /**
     * Handle the support request submission.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'type' => 'required|in:bug,question,suggestion,other',
            'message' => 'required|string|min:20|max:1000',
        ]);

        \App\Models\SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'open'
        ]);

        return redirect()->route('dashboard')->with('success', '¡Mensaje enviado a los Dioses de la Creación! Analizaremos tu reporte lo antes posible.');
    }
}
