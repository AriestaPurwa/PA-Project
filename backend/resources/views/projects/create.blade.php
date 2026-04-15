@extends('layouts.app')

@section('content')

<div class="mb-3">
    <a href="{{ route('projects.index') }}"
       class="btn btn-secondary">
        ← Back
    </a>
</div>

<h2>Tambah Project</h2>

<form action="{{ route('projects.store') }}" method="POST">
    @csrf

    <input type="text" name="nama_project" placeholder="Nama Project">
    <br><br>

    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
    <br><br>

    <button type="submit" class="btn app-btn">Simpan</button>
</form>

@endsection