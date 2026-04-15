@extends('layouts.app')

@section('content')

<div class="mb-3">
    <a href="{{ route('projects.show', $project->id) }}"
       class="btn btn-secondary">
        ← Back
    </a>
</div>

<h2>Add Risk</h2>

<form action="{{ route('projects.risks.store', $project->id) }}" method="POST">
@csrf

<label>Risk Name</label>
<input type="text" name="nama_risiko" required>

<br><br>

<label>Category</label>
<select name="category_id">
@foreach($categories as $category)
    <option value="{{ $category->id }}"
        {{ $selectedCategory == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
    </option>
@endforeach
</select>

<br><br>

<label>Probability (1-5)</label>
<input type="number" name="probability" min="1" max="5">

<br><br>

<label>Impact (1-5)</label>
<input type="number" name="impact" min="1" max="5">

<br><br>

<input type="hidden" name="project_id" value="{{ $project->id }}">
<!-- <input type="hidden" name="risk_category_id" value="{{ $selectedCategory->id ?? '' }}"> -->

<br><br>

<button class="btn app-btn">Save Risk</button>

</form>

@endsection