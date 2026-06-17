<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageSent;
use App\Models\ChatGroup;
use App\Models\ChatGroupMember;
use App\Models\ChatGroupMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatGroupController extends Controller
{
    /**
     * Daftar grup chat milik siswa
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->roles === 'guru') {
            // Guru lihat semua grup
            $groups = ChatGroup::with(['creator', 'members'])->get();
        } else {
            // Siswa lihat grup yang dia ikuti
            $groups = ChatGroup::with(['creator', 'members'])
                ->whereHas('members', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->get();
        }

        return view('pages.chat.group.index', compact('groups'));
    }

    /**
     * Form buat grup baru
     */
    public function create()
    {
        // Ambil semua siswa kecuali diri sendiri
        $siswaList = User::where('roles', 'siswa')
            ->where('id', '!=', Auth::id())
            ->get();

        return view('pages.chat.group.create', compact('siswaList'));
    }

    /**
     * Simpan grup baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_grup' => 'required|string|max:100',
            'members'   => 'required|array|min:1',
            'members.*' => 'exists:users,id',
        ]);

        $group = ChatGroup::create([
            'nama_grup'  => $request->nama_grup,
            'created_by' => Auth::id(),
        ]);

        // Tambah creator sebagai admin
        ChatGroupMember::create([
            'chat_group_id' => $group->id,
            'user_id'       => Auth::id(),
            'role'          => 'admin',
        ]);

        // Tambah member yang diinvite
        foreach ($request->members as $userId) {
            ChatGroupMember::create([
                'chat_group_id' => $group->id,
                'user_id'       => $userId,
                'role'          => 'member',
            ]);
        }

        return redirect()->route('chat.group.show', $group->id)
            ->with('success', 'Grup berhasil dibuat!');
    }

    /**
     * Halaman chat dalam grup
     */
    public function show($groupId)
    {
        $user  = Auth::user();
        $group = ChatGroup::with(['creator', 'members.user'])->findOrFail($groupId);

        // Cek akses: harus member atau guru
        if ($user->roles !== 'guru') {
            $isMember = $group->members->where('user_id', $user->id)->count();
            if (!$isMember) {
                abort(403, 'Kamu bukan anggota grup ini');
            }
        }

        $messages = ChatGroupMessage::with('user')
            ->where('chat_group_id', $groupId)
            ->orderBy('created_at', 'asc')
            ->get();

        $isAdmin = $group->members
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->count() > 0;

        return view('pages.chat.group.show', compact('group', 'messages', 'isAdmin'));
    }

    /**
     * Kirim pesan
     */
    public function send(Request $request, $groupId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if (Auth::user()->roles === 'guru') {
            return response()->json(['error' => 'Guru hanya bisa memantau'], 403);
        }

        $message = ChatGroupMessage::create([
            'chat_group_id' => $groupId,
            'user_id'       => Auth::id(),
            'message'       => $request->message,
        ]);

        broadcast(new GroupMessageSent($message))->toOthers();

        return response()->json([
            'id'         => $message->id,
            'message'    => $message->message,
            'user_id'    => $message->user_id,
            'user_name'  => Auth::user()->name,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    /**
     * Tambah member ke grup (oleh admin grup)
     */
    public function addMember(Request $request, $groupId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $group = ChatGroup::findOrFail($groupId);

        // Cek apakah yang request adalah admin grup
        $isAdmin = $group->members
            ->where('user_id', Auth::id())
            ->where('role', 'admin')
            ->count() > 0;

        if (!$isAdmin) {
            return back()->withErrors(['error' => 'Hanya admin grup yang bisa menambah member']);
        }

        // Cek udah member belum
        $exists = ChatGroupMember::where('chat_group_id', $groupId)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Siswa sudah menjadi anggota grup']);
        }

        ChatGroupMember::create([
            'chat_group_id' => $groupId,
            'user_id'       => $request->user_id,
            'role'          => 'member',
        ]);

        return back()->with('success', 'Member berhasil ditambahkan');
    }

    /**
     * Keluarkan member dari grup (oleh admin grup)
     */
    public function removeMember(Request $request, $groupId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $group = ChatGroup::findOrFail($groupId);

        $isAdmin = $group->members
            ->where('user_id', Auth::id())
            ->where('role', 'admin')
            ->count() > 0;

        if (!$isAdmin) {
            return back()->withErrors(['error' => 'Hanya admin grup yang bisa mengeluarkan member']);
        }

        ChatGroupMember::where('chat_group_id', $groupId)
            ->where('user_id', $request->user_id)
            ->delete();

        return back()->with('success', 'Member berhasil dikeluarkan');
    }

    /**
     * Hapus grup (oleh admin grup)
     */
    public function destroy($groupId)
    {
        $group = ChatGroup::findOrFail($groupId);

        $isAdmin = $group->members
            ->where('user_id', Auth::id())
            ->where('role', 'admin')
            ->count() > 0;

        if (!$isAdmin) {
            return back()->withErrors(['error' => 'Hanya admin grup yang bisa menghapus grup']);
        }

        $group->delete();

        return redirect()->route('chat.group.index')
            ->with('success', 'Grup berhasil dihapus');
    }
}