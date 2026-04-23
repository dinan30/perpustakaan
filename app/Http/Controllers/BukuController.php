<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Buku::query();

       
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }

       
        $buku = $query->latest()->get();
        return view('admin.buku.index', compact('buku'));
    }

   
    public function create()
    {
        return view('admin.buku.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'    => 'required|string|max:50|unique:buku,kode_buku',
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'kategori'     => 'required|string|max:100', 
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'kode_buku.unique' => 'Kode buku ini sudah ada di dalam database. Silakan gunakan kode buku yang lain.',
            'cover.image'      => 'File harus berupa gambar.',
            'cover.max'        => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

       
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $coverPath;
        }

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

   
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

   
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'cover.image' => 'File harus berupa gambar.',
            'cover.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
           
            $coverPath = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $coverPath;
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    
    public function destroy(Buku $buku)
    {
        
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }
        
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}