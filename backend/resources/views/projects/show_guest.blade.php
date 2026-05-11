@extends('layouts.app')

@section('content')

<div class="card app-card">

    <h2>Guest Project</h2>

    <p>
        <strong>Project Name:</strong>
        {{ $project['nama_project'] }}
    </p>

    <p>
        <strong>Description:</strong>
        {{ $project['deskripsi'] }}
    </p>

    <div style="margin-top:20px;">
        <strong>Guest Mode Active</strong><br>
        This project is temporary and will not be saved permanently.
    </div>

</div>

@endsection