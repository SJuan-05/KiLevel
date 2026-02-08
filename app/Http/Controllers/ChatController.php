<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Faction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Enviar un mensaje al chat del clan
     */
    public function sendClanMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        if (!$user->faction_id) {
            return response()->json(['error' => 'No perteneces a ninguna facción.'], 403);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'faction_id' => $user->faction_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    /**
     * Enviar un mensaje directo a un amigo
     */
    public function sendDirectMessage(Request $request, $friendId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Verificar si son amigos (opcional pero recomendado)
        // Por simplicidad ahora solo enviamos
        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $friendId,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    /**
     * Obtener mensajes del clan
     */
    public function fetchClanMessages()
    {
        $user = Auth::user();

        if (!$user->faction_id) {
            return response()->json([], 200);
        }

        $messages = Message::where('faction_id', $user->faction_id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get();

        return response()->json($messages);
    }

    /**
     * Obtener mensajes de chat directo
     */
    public function fetchDirectMessages($friendId)
    {
        $user = Auth::user();

        $messages = Message::where(function($q) use ($user, $friendId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $friendId);
            })
            ->orWhere(function($q) use ($user, $friendId) {
                $q->where('sender_id', $friendId)->where('receiver_id', $user->id);
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get();

        return response()->json($messages);
    }
}
