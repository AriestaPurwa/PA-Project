@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Add Risk
        </h2>

        <form action="/guest/risk/store"
              method="POST">

            @csrf

            <input type="hidden"
                   name="category_id"
                   value="{{ $categoryId }}">

            <div class="form-group">

                <label class="form-label">
                    Risk Name
                </label>

                <input type="text"
                       name="nama_risiko"
                       class="form-input"
                       required>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Probability
                </label>

                <select name="probability"
                        class="form-input"
                        required>

                    @for($i = 1; $i <= 5; $i++)

                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Impact
                </label>

                <select name="impact"
                        class="form-input"
                        required>

                    @for($i = 1; $i <= 5; $i++)

                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

            <button type="submit"
                    class="btn app-btn">

                Save Risk

            </button>

        </form>

    </div>

</div>

@endsection