<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar anggota (siswa).
     */
    public function index()
    {
        // Mengambil user dengan role siswa, diurutkan dari yang terbaru
        $users = User::where('role', 'siswa')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah anggota.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data anggota baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'min:8'],
            'alamat' => ['nullable', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Otomatis set sebagai siswa
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('users.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit anggota.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data anggota di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'alamat' => ['nullable', 'string'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->alamat = $request->alamat;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['min:8'],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Menghapus data anggota.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Anggota berhasil dihapus!');
    }
}