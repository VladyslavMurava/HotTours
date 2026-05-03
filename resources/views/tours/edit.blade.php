@extends('layout')

@section('title', 'Редагування туру')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-outline-secondary rounded-pill px-3">← Назад</a>
    <h1 class="fw-bold mb-0">Редагування туру</h1>
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

        <form method="POST" action="{{ route('tours.update', $tour->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label fw-semibold">Назва туру</label>
                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $tour->title) }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Опис туру</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $tour->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ціна (грн)</label>
                    <input name="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $tour->price) }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Тривалість (днів)</label>
                    <input name="duration" type="number" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', $tour->duration) }}">
                    @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Дата вильоту</label>
                    <input name="departure_date" type="date" class="form-control" value="{{ old('departure_date', $tour->departure_date) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Напрямок</label>
                <select name="destination_id" class="form-select @error('destination_id') is-invalid @enderror">
                    <option value="">-- Оберіть напрямок --</option>
                    @foreach($destinations as $dest)
                        <option value="{{ $dest->id }}" {{ old('destination_id', $tour->destination_id) == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                    @endforeach
                </select>
                @error('destination_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Нове зображення (необов'язково)</label>
                <input name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if($tour->image)
                    <div class="mt-2">
                        <small class="text-muted">Поточне фото:</small><br>
                        <img src="/assets/tours/{{ $tour->image }}" class="img-thumbnail mt-1" style="max-height:120px;" alt="{{ $tour->title }}">
                    </div>
                @endif
            </div>

            <div class="mb-4 form-check">
                <input name="is_hot" type="checkbox" class="form-check-input" id="is_hot" {{ old('is_hot', $tour->is_hot) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="is_hot">🔥 Гарячий тур</label>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Видалити тур
                </button>
                <button type="submit" class="btn btn-danger rounded-pill px-5">Зберегти зміни</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Підтвердіть видалення</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-muted">
                Видалити тур <strong>«{{ $tour->title }}»</strong>? Цю дію неможливо скасувати.
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Скасувати</button>
                <form action="{{ route('tours.destroy', $tour->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Видалити</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
