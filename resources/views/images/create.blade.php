@extends('layout')

@section('title', 'Завантажити зображення')

@section('content')
    <h4>Завантажити зображення</h4>

    <form method="POST" action="{{ route('tours.images.store', $tour_id) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="image" class="form-label">Файл:</label>
            <input name="image" type="file" id="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Опис зображення</label>
            <textarea name="description" class="form-control" id="description" placeholder="Опис зображення">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary float-end">Додати</button>
    </form>
@endsection
