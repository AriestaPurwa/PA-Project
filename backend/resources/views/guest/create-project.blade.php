@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Guest Mode
        </h2>

        <p class="form-subtitle">
            This project will only be stored temporarily.
        </p>

        <form action="/guest-mode" method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Nama Project
                </label>

                <input
                    type="text"
                    name="nama_project"
                    class="form-input"
                    required
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-textarea"
                ></textarea>

            </div>

            <button
                type="submit"
                class="btn app-btn"
            >
                Start Guest Project
            </button>

        </form>

    </div>

</div>

@endsection