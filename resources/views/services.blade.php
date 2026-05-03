@extends('layout')

@section('title', 'Наші послуги')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">🛎️ Послуги</span>
        <h1 class="display-5 fw-bold mb-2">Додаткові туристичні послуги</h1>
        <p class="fs-5 text-white-50 col-md-7">Забезпечуємо повний супровід вашої подорожі для максимального комфорту.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="fs-1 mb-3">🏥</div>
                <h5 class="fw-bold mb-2">Медичне страхування</h5>
                <p class="text-muted small mb-0">Оформлення полісів туристичного страхування, що покривають медичні витрати, нещасні випадки та втрату багажу.</p>
            </div>
            <div class="card-footer bg-transparent border-0 pb-4 px-4">
                <span class="badge bg-primary rounded-pill px-3">Надійний захист</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="fs-1 mb-3">🛂</div>
                <h5 class="fw-bold mb-2">Візова підтримка</h5>
                <p class="text-muted small mb-0">Консультації щодо збору документів, заповнення анкет та запис на подачу до консульств і візових центрів.</p>
            </div>
            <div class="card-footer bg-transparent border-0 pb-4 px-4">
                <span class="badge bg-success rounded-pill px-3">Допомога з документами</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="fs-1 mb-3">🚌</div>
                <h5 class="fw-bold mb-2">Трансфер</h5>
                <p class="text-muted small mb-0">Організація індивідуальних та групових трансферів з аеропорту до готелю та у зворотному напрямку.</p>
            </div>
            <div class="card-footer bg-transparent border-0 pb-4 px-4">
                <span class="badge bg-info rounded-pill px-3">Зручні переміщення</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-light rounded-3 p-5 text-center">
    <h4 class="fw-bold mb-2">Потрібна консультація?</h4>
    <p class="text-muted mb-4">Наші менеджери готові відповісти на всі ваші запитання</p>
    <a href="{{ route('contacts') }}" class="btn btn-danger rounded-pill px-4">Зв'язатися з нами</a>
</div>

@endsection
