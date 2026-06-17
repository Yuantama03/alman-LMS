<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Halaman chat per mapel (siswa & guru)
     */
    public function index($mapelId)
    {
        $mapel    = Mapel::findOrFail($mapelId);
        $messages = ChatMessage::with('user')
            ->where('mapel_id', $mapelId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.chat.index', compact('mapel', 'messages'));
    }

    /**
     * Kirim pesan baru
     */
    public function send(Request $request, $mapelId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Guru hanya bisa baca, tidak bisa kirim
        if (Auth::user()->roles === 'guru') {
            return response()->json(['error' => 'Guru hanya bisa memantau chat'], 403);
        }

        $message = ChatMessage::create([
            'mapel_id' => $mapelId,
            'user_id'  => Auth::id(),
            'message'  => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id'         => $message->id,
            'message'    => $message->message,
            'user_id'    => $message->user_id,
            'user_name'  => Auth::user()->name,
            'user_roles' => Auth::user()->roles,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }
}