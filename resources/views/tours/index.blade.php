@extends('layout')

@section('title', 'Каталог турів')
@section('meta-description', 'Повний перелік доступних гарячих турів та путівок.')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">✈️ Каталог</span>
        <h1 class="display-5 fw-bold mb-2">{{ $pageTitle }}</h1>
        <p class="fs-5 text-white-50 col-md-7">Оберіть тур та вирушайте у незабутню подорож.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3">🔍 Пошук та фільтрація</h6>
        <form method="GET" action="{{ route('tours.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Напрямок</label>
                    <select name="destination_id" class="form-select">
                        <option value="">Усі напрямки</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Ціна від (грн)</label>
                    <input type="number" name="price_min" class="form-control" min="0" value="{{ request('price_min') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Ціна до (грн)</label>
                    <input type="number" name="price_max" class="form-control" min="0" value="{{ request('price_max') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Тривалість (ночей)</label>
                    <input type="number" name="duration" class="form-control" min="1" value="{{ request('duration') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Виліт від</label>
                    <input type="date" name="departure_from" class="form-control" value="{{ request('departure_from') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-danger rounded-pill w-100">Знайти</button>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_hot" value="1" id="isHotCheck" {{ request('is_hot') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isHotCheck">
                            🔥 Тільки гарячі пропозиції
                        </label>
                    </div>
                </div>
            </div>
            @if(request()->hasAny(['destination_id', 'price_min', 'price_max', 'duration', 'departure_from', 'is_hot']))
                <div class="mt-2">
                    <a href="{{ route('tours.index') }}" class="btn btn-link p-0 text-muted small">✕ Скинути фільтри</a>
                </div>
            @endif
        </form>
    </div>
</div>

@auth
    @if(Auth::user()->isAdmin())
    <div class="mb-4">
        <a href="{{ route('tours.create') }}" class="btn btn-dark rounded-pill px-4">+ Додати тур</a>
    </div>
    @endif
@endauth

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse($tours as $tour)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
            @if($tour->image && file_exists(public_path('assets/tours/' . $tour->image)))
                <div class="position-relative">
                    <img src="{{ asset('assets/tours/' . $tour->image) }}" class="card-img-top" alt="{{ $tour->title }}" style="height:210px;object-fit:cover;">
                    @if($tour->is_hot)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2">🔥 Гарячий</span>
                    @endif
                </div>
            @else
                <div class="bg-dark text-white-50 d-flex justify-content-center align-items-center" style="height:210px;">
                    <span class="fs-1">✈️</span>
                </div>
            @endif
            <div class="card-body d-flex flex-column p-4">
                <p class="text-danger fw-semibold small text-uppercase mb-1">{{ $tour->destination->name ?? 'Без напрямку' }}</p>
                <h5 class="card-title fw-bold mb-2">{{ $tour->title }}</h5>
                <p class="text-muted small mb-3">
                    🌙 {{ $tour->duration }} ночей
                    @if($tour->departure_date)
                        &nbsp;·&nbsp; 📅 {{ date('d.m.Y', strtotime($tour->departure_date)) }}
                    @endif
                </p>
                <h4 class="text-danger fw-bold mt-auto mb-3">{{ number_format($tour->price, 0, '', ' ') }} <small class="fs-6 text-muted fw-normal">грн</small></h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-dark rounded-pill flex-grow-1">Детальніше</a>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-outline-secondary rounded-pill px-3">✏️</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning rounded-3 text-center">За вказаними фільтрами турів не знайдено.</div>
        </div>
    @endforelse
</div>

@endsection
