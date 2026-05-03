@extends('layout')

@section('title', 'Про нас')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">🏢 Про компанію</span>
        <h1 class="display-5 fw-bold mb-2">Туристичне агентство HotTours</h1>
        <p class="fs-5 text-white-50 col-md-7">Більше 10 років допомагаємо тисячам клієнтів відкривати нові країни та отримувати незабутні враження.</p>
    </div>
</div>

<div class="row align-items-center mb-5 g-5">
    <div class="col-lg-6">
        <h2 class="fw-bold mb-3">Наша місія</h2>
        <p class="lead text-muted">Зробити якісний відпочинок доступним для кожного.</p>
        <p class="text-muted">Ми співпрацюємо лише з перевіреними туроператорами та авіакомпаніями, щоб гарантувати безпеку та високий рівень сервісу під час ваших подорожей.</p>
        <a href="{{ route('tours.index') }}" class="btn btn-danger rounded-pill px-4 mt-2">Переглянути тури</a>
    </div>
    <div class="col-lg-6">
        @if($photo)
            <img src="{{ asset($photo) }}?{{ filemtime(public_path($photo)) }}" class="img-fluid rounded-3 shadow" alt="Фото офісу">
        @else
            <div class="bg-light p-5 text-center rounded-3 text-muted border">
                <span class="fs-1">🏢</span>
                <p class="mt-3 mb-0">Фотографія офісу або команди</p>
            </div>
        @endif

        @auth
            @if(Auth::user()->isAdmin())
                <form action="{{ route('about.photo') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                        <button type="submit" class="btn btn-outline-primary">Завантажити</button>
                    </div>
                </form>
            @endif
        @endauth
    </div>
</div>

<div class="row g-3 text-center mb-5">
    <div class="col-md-4">
        <div class="border rounded-3 py-4 shadow-sm">
            <div class="display-5 fw-bold text-primary">10+</div>
            <div class="text-muted text-uppercase small mt-1">Років досвіду</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded-3 py-4 shadow-sm">
            <div class="display-5 fw-bold text-primary">50+</div>
            <div class="text-muted text-uppercase small mt-1">Країн світу</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded-3 py-4 shadow-sm">
            <div class="display-5 fw-bold text-primary">15k</div>
            <div class="text-muted text-uppercase small mt-1">Задоволених клієнтів</div>
        </div>
    </div>
</div>

@endsection
