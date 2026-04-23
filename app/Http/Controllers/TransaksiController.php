<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'buku'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $users = User::all(); 
        $buku = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('users', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $dataBuku = Buku::findOrFail($request->buku_id);

        if ($dataBuku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaksi::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tgl_pinjam,
            'tanggal_kembali' => $request->tgl_kembali,
            'status' => 'pinjam',
            'denda' => 0,
        ]);

        $dataBuku->decrement('stok');

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function kembali(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (in_array($transaksi->status, ['pinjam', 'menunggu_kembali'])) {
            // Ambil tanggal pengembalian aktual dari form admin, atau gunakan hari ini jika tidak ada
            $tanggalDikembalikan = $request->input('tanggal_dikembalikan', date('Y-m-d'));

            // Hitung denda jika tanggal dikembalikan melebihi batas tanggal kembali
            $denda = 0;
            $tglBatasKembali = \Carbon\Carbon::parse($transaksi->tanggal_kembali);
            $tglAktualKembali = \Carbon\Carbon::parse($tanggalDikembalikan);

            if ($tglAktualKembali->gt($tglBatasKembali)) {
                // Hitung selisih hari keterlambatan
                $selisihHari = $tglAktualKembali->diffInDays($tglBatasKembali);
                // Denda misalnya Rp 1000 per hari keterlambatan
                $denda = $selisihHari * 10000;
            }

            $transaksi->update([
                'status' => 'kembali',
                'denda' => $denda,
            ]);

            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }

            $pesan = 'Buku berhasil dikembalikan pada tanggal ' . $tanggalDikembalikan . '.';
            if ($denda > 0) {
                $pesan .= ' Terkena denda keterlambatan sebesar Rp ' . number_format($denda, 0, ',', '.') . '.';
            }

            return redirect()->route('transaksi.index')->with('success', $pesan);
        }

        return redirect()->route('transaksi.index')->with('error', 'Buku sudah dikembalikan.');
    }

    public function setujui($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'menunggu') {
            $buku = Buku::find($transaksi->buku_id);
            
            if ($buku && $buku->stok > 0) {
                $buku->decrement('stok');
                $transaksi->update(['status' => 'pinjam']);
                return redirect()->route('transaksi.index')->with('success', 'Peminjaman disetujui. Stok buku telah dikurangi.');
            } else {
                // Jika stok habis saat admin akan menyetujui
                $transaksi->update(['status' => 'ditolak']);
                return redirect()->route('transaksi.index')->with('error', 'Peminjaman ditolak otomatis karena stok buku habis.');
            }
        }

        return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak dapat disetujui.');
    }

    public function tolak($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'menunggu') {
            $transaksi->update(['status' => 'ditolak']);

            // Karena stok tidak dikurangi saat 'menunggu', maka kita tidak perlu menambahkannya (increment) lagi saat ditolak.
            
            return redirect()->route('transaksi.index')->with('success', 'Peminjaman ditolak.');
        }

        return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak dapat ditolak.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Jika transaksi masih berstatus "pinjam" atau "menunggu_kembali", kita harus mengembalikan stok bukunya terlebih dahulu.
        // Status "menunggu" tidak perlu mengembalikan stok karena belum dikurangi.
        if (in_array($transaksi->status, ['pinjam', 'menunggu_kembali'])) {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with(['user', 'buku'])->findOrFail($id);
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:menunggu,pinjam,menunggu_kembali,kembali,ditolak',
        ]);

        // Simpan status lama untuk mengecek perubahan stok buku
        $statusLama = $transaksi->status;
        $statusBaru = $request->status;

        $transaksi->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $statusBaru,
        ]);

        // Logika sederhana untuk manajemen stok jika status berubah
        if ($statusLama != $statusBaru) {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                // Daftar status yang mana stok SUDAH dikurangi di database
                $statusMemotongStok = ['pinjam', 'menunggu_kembali'];
                // Daftar status yang mana stok BELUM/TIDAK dikurangi di database
                $statusTidakMemotongStok = ['menunggu', 'kembali', 'ditolak'];

                // Jika berubah dari status yang memotong stok menjadi status yang tidak memotong stok -> stok bertambah
                if (in_array($statusLama, $statusMemotongStok) && in_array($statusBaru, $statusTidakMemotongStok)) {
                    $buku->increment('stok');
                }
                // Jika berubah dari status yang tidak memotong stok menjadi status yang memotong stok -> stok berkurang
                elseif (in_array($statusLama, $statusTidakMemotongStok) && in_array($statusBaru, $statusMemotongStok)) {
                    if ($buku->stok > 0) {
                        $buku->decrement('stok');
                    } else {
                        // Batalkan update jika stok habis
                        $transaksi->update(['status' => $statusLama]);
                        return back()->with('error', 'Stok buku habis! Tidak bisa mengubah status menjadi Pinjam / Menunggu Kembali.');
                    }
                }
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }
}