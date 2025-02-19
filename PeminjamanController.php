<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku; // Tambahkan ini agar bisa memilih buku
use App\Models\User; // Tambahkan ini agar bisa memilih user

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('buku', 'user')->get(); // Mengambil semua data peminjaman dengan relasi buku & user
        return view('user.pinjambuku', compact('peminjaman'));
    }

    public function create()
    {
        $buku = Buku::all();
        $user = User::all();
        return view('user.pinjambuku_create', compact('buku', 'user')); // Form tambah peminjaman
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tanggalpinjam' => 'required|date',
            'tanggalkembali' => 'required|date|after:tanggalpinjam',
            'Statuskembali' => 'required|in:tepatwaktu,terlambat',
            'kondisi' => 'required|in:baik,rusak,hilang',
        ]);

        Peminjaman::create($request->all()); // Simpan ke database
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = Buku::all();
        $user = User::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'buku', 'user')); // Form edit peminjaman
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tanggalpinjam' => 'required|date',
            'tanggalkembali' => 'required|date|after:tanggalpinjam',
            'Statuskembali' => 'required|in:tepatwaktu,terlambat',
            'kondisi' => 'required|in:baik,rusak,hilang',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all()); // Update peminjaman
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete(); // Hapus peminjaman dari database
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
