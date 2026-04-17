<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index()
    {
        // Mengambil data buku terbaru
        $buku = Buku::latest()->get();
        return view('admin.buku.index', compact('buku'));
    }

    /**
     * Form tambah buku.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Simpan buku baru.
     */
    public function store(Request $request)
{
    $request->validate([
        'kode_buku'    => 'required|string|max:50|unique:buku,kode_buku',
        'judul'        => 'required|string|max:255',
        'penulis'      => 'required|string|max:255',
        'penerbit'     => 'required|string|max:255',
        'kategori'     => 'required|string|max:100', // Pastikan ini ada
        'tahun_terbit' => 'required|integer',
        'stok'         => 'required|integer|min:0',
    ], [
        'kode_buku.unique' => 'Kode buku ini sudah ada di dalam database. Silakan gunakan kode buku yang lain.',
    ]);

    Buku::create($request->all());

    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
}

    /**
     * Form edit buku.
     * Menggunakan Route Model Binding (langsung memanggil Model Buku)
     */
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Update data buku.
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Hapus buku.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}