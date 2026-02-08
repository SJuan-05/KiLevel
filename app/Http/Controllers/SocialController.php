<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SocialController extends Controller
{
    /**
     * Vista principal del Centro Social
     */
    public function index()
    {
        $user = Auth::user();
        
        // Cargamos amigos (ambas direcciones)
        $friends = $user->all_friends;
        
        // Solicitudes recibidas
        $requests = $user->pendingRequestsReceived;
        
        // Solicitudes enviadas (para control visual)
        $sentRequests = $user->pendingRequestsSent->pluck('id')->toArray();

        return view('social.index', compact('friends', 'requests', 'sentRequests'));
    }

    /**
     * Buscador de Guerreros
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = Auth::user();

        // Si no hay búsqueda, simplemente mostramos el hub vacío o con amigos
        if (empty($query)) {
            return redirect()->route('social.index');
        }

        // Buscamos usuarios excepto nosotros mismos
        $results = User::where('name', 'LIKE', "%{$query}%")
                        ->where('id', '!=', $user->id)
                        ->get();

        // Necesitamos saber el estado de relación con cada resultado
        $friendsIds = $user->all_friends->pluck('id')->toArray();
        $sentIds = $user->pendingRequestsSent->pluck('id')->toArray();
        $receivedIds = $user->pendingRequestsReceived->pluck('id')->toArray();

        return view('social.index', [
            'results' => $results,
            'friends' => $user->all_friends,
            'requests' => $user->pendingRequestsReceived,
            'friendsIds' => $friendsIds,
            'sentIds' => $sentIds,
            'receivedIds' => $receivedIds,
            'searchQuery' => $query
        ]);
    }

    /**
     * Enviar solicitud de amistad
     */
    public function addFriend($id)
    {
        $user = Auth::user();

        if ($user->id == $id) {
            return back()->with('error', 'No puedes ser tu propio amigo... aún.');
        }

        // Verificar si ya hay una relación
        $exists = DB::table('friendships')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('friend_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('friend_id', $user->id);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya existe un vínculo o solicitud pendiente.');
        }

        DB::table('friendships')->insert([
            'user_id' => $user->id,
            'friend_id' => $id,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Solicitud enviada al guerrero.');
    }

    /**
     * Aceptar solicitud
     */
    public function acceptFriend($id)
    {
        $user = Auth::user();

        $updated = DB::table('friendships')
            ->where('user_id', $id)
            ->where('friend_id', $user->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'accepted',
                'updated_at' => now()
            ]);

        if ($updated) {
            return back()->with('success', '¡Ahora sois aliados!');
        }

        return back()->with('error', 'No se pudo aceptar la solicitud.');
    }

    /**
     * Eliminar amigo o rechazar solicitud
     */
    public function removeFriend($id)
    {
        $user = Auth::user();

        DB::table('friendships')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('friend_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('friend_id', $user->id);
            })
            ->delete();

        return back()->with('success', 'Vínculo eliminado.');
    }
}
