@extends('layout')

@section('title', 'Додати тур')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('tours.index') }}" class="btn btn-outline-secondary rounded-pill px-3">← Назад</a>
    <h1 class="fw-bold mb-0">Створення нового туру</h1>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">

        @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('tours.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Назва туру</label>
                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Назва туру" value="{{ old('title') }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Опис туру</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Детальний опис туру">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ціна (грн)</label>
                    <input name="price" type="number" class="form-control @error('price') is-invalid @enderror" placeholder="0" value="{{ old('price') }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Тривалість (днів)</label>
                    <input name="duration" type="number" class="form-control @error('duration') is-invalid @enderror" placeholder="0" value="{{ old('duration') }}">
                    @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Дата вильоту</label>
                    <input name="departure_date" type="date" class="form-control" value="{{ old('departure_date') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Напрямок</label>
                <select name="destination_id" class="form-select @error('destination_id') is-invalid @enderror">
                    <option value="">-- Оберіть напрямок --</option>
                    @foreach($destinations as $dest)
                        <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                    @endforeach
                </select>
                @error('destination_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Зображення туру</label>
                <input name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4 form-check">
                <input name="is_hot" type="checkbox" class="form-check-input" id="is_hot" {{ old('is_hot') ? 'checked' : 'checked' }}>
                <label class="form-check-label fw-semibold" for="is_hot">🔥 Гарячий тур</label>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-danger rounded-pill px-5">Створити тур</button>
            </div>
        </form>
    </div>
</div>

@endsection
