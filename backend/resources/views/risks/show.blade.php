@extends('layouts.app')

@section('content')

<h2>Risk Detail</h2>

<div class="card app-card">
    <p><b>Name:</b> {{ $risk->nama_risiko }}</p>
    <p><b>Probability:</b> {{ $risk->probability }}</p>
    <p><b>Impact:</b> {{ $risk->impact }}</p>
    <p><b>Risk Score:</b> {{ $risk->risk_score }}</p>
</div>

<a href="{{ url()->previous() }}" class="btn app-btn">Back</a>

@endsection