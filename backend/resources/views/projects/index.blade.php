@extends('layouts.app')

@section('content')

<h2>Daftar Project</h2>

<a href="{{ route('projects.create') }}" class="btn app-btn">+ Tambah Project</a>

<br><br>

@foreach($projects as $project)
    <div class="card app-card">
        <h4>{{ $project->nama_project }}</h4>

        <a href="{{ route('projects.show', $project->id) }}" class="btn app-btn">
            Lihat Detail
        </a>
    </div>
@endforeach

@endsection