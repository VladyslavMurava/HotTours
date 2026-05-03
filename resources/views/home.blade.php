@extends('layout')

@section('title', 'Головна')
@section('meta-description', 'Найкращі гарячі тури за доступними цінами.')

@section('content')

<div class="px-4 py-5 mb-4 bg-dark text-white rounded-3 shadow">
    <div class="py-4">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">✈️ Гарячі тури 2026</span>
        <h1 class="display-5 fw-bold mb-3">Відпочинок про який ви мріяли —<br>вже доступний</h1>
        <p class="fs-5 text-white-50 mb-4 col-md-7">Ексклюзивні пропозиції зі знижками до 40%. Підберіть тур за кілька хвилин і вирушайте у подорож.</p>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('tours.index') }}" class="btn btn-danger btn-lg rounded-pill px-4">Переглянути тури</a>
            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">Про нас</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-5 text-center">
    <div class="col-6 col-md-3">
        <div class="border rounded-3 py-3 shadow-sm">
            <div class="fs-3 fw-bold text-primary">{{ \App\Models\Tour::count() }}+</div>
            <div class="text-muted small">Активних турів</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="border rounded-3 py-3 shadow-sm">
            <div class="fs-3 fw-bold text-primary">{{ \App\Models\Destination::count() }}+</div>
            <div class="text-muted small">Напрямків</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="border rounded-3 py-3 shadow-sm">
            <div class="fs-3 fw-bold text-primary">{{ \App\Models\Order::count() }}+</div>
            <div class="text-muted small">Бронювань</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="border rounded-3 py-3 shadow-sm">
            <div class="fs-3 fw-bold text-primary">40%</div>
            <div class="text-muted small">Макс. знижка</div>
        </div>
    </div>
</div>

<h2 class="fw-bold text-center mb-1">🔥 Топ гарячих пропозицій</h2>
<p class="text-center text-muted mb-4">Обмежені місця — встигніть забронювати</p>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
    @forelse($tours as $tour)
    <div class="col">
        <div class="card h-100 shadow border-0 rounded-3 overflow-hidden">
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
            <div class="card-body d-flex flex-column">
                <p class="text-danger fw-semibold small text-uppercase mb-1">{{ $tour->destination->name ?? 'Без напрямку' }}</p>
                <h5 class="card-title fw-bold">{{ $tour->title }}</h5>
                <p class="text-muted small mb-3">
                    🌙 {{ $tour->duration }} ночей
                    @if($tour->departure_date)
                        &nbsp;·&nbsp; 📅 {{ date('d.m.Y', strtotime($tour->departure_date)) }}
                    @endif
                </p>
                <h4 class="text-danger fw-bold mt-auto mb-3">{{ number_format($tour->price, 0, '', ' ') }} <small class="fs-6 text-muted fw-normal">грн / особу</small></h4>
                <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-dark rounded-pill w-100">Детальніше</a>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Поки що немає доступних турів.</div>
        </div>
    @endforelse
</div>

<div class="bg-light rounded-3 p-5 mb-4">
    <h2 class="fw-bold text-center mb-1">Чому обирають нас</h2>
    <p class="text-center text-muted mb-5">Понад 500 задоволених клієнтів довіряють HotTours</p>
    <div class="row g-4 text-center">
        <div class="col-md-3">
            <div class="fs-1 mb-3">💰</div>
            <h5 class="fw-bold">Найкращі ціни</h5>
            <p class="text-muted small">Знижки до 40% на гарячі тури. Гарантуємо найнижчу ціну.</p>
        </div>
        <div class="col-md-3">
            <div class="fs-1 mb-3">⚡</div>
            <h5 class="fw-bold">Швидке бронювання</h5>
            <p class="text-muted small">Залиште заявку за 2 хвилини — менеджер зв'яжеться за 15 хв.</p>
        </div>
        <div class="col-md-3">
            <div class="fs-1 mb-3">🛡️</div>
            <h5 class="fw-bold">Надійність</h5>
            <p class="text-muted small">Всі тури перевірені. Підтримка від бронювання до повернення.</p>
        </div>
        <div class="col-md-3">
            <div class="fs-1 mb-3">🌍</div>
            <h5 class="fw-bold">Широкий вибір</h5>
            <p class="text-muted small">Десятки напрямків по всьому світу для будь-якого бюджету.</p>
        </div>
    </div>
</div>

@endsection
