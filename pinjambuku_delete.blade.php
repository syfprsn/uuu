@extends('layouts.app')

@section('content')
    <h1>Edit Buku</h1>

    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul</label>
        <input type="text" name="judul" value="{{ $buku->judul }}" required>

        <label>Pengarang</label>
        <input type="text" name="pengarang" value="{{ $buku->pengarang }}" required>

        <label>Penerbit</label>
        <input type="text" name="penerbit" value="{{ $buku->penerbit }}" required>

        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" required>

        <label>Keterangan</label>
        <textarea name="keterangan">{{ $buku->keterangan }}</textarea>

        <button type="submit">Update</button>
    </form>

@endsection
