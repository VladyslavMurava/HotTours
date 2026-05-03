@extends('layout')

@section('title', 'Контакти')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">📞 Контакти</span>
        <h1 class="display-5 fw-bold mb-2">Зв'яжіться з нами</h1>
        <p class="fs-5 text-white-50 col-md-7">Ми завжди готові відповісти на ваші запитання та допомогти з вибором туру.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Наші координати</h4>
                <div class="d-flex gap-3 mb-4">
                    <div class="fs-4">📍</div>
                    <div>
                        <div class="fw-semibold">Адреса</div>
                        <div class="text-muted small">м. Хмельницький, вул. Проскурівська, 1</div>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-4">
                    <div class="fs-4">📞</div>
                    <div>
                        <div class="fw-semibold">Телефон</div>
                        <div class="text-muted small">+380 00 000 00 00<br>+380 00 111 11 11</div>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-4">
                    <div class="fs-4">✉️</div>
                    <div>
                        <div class="fw-semibold">Email</div>
                        <div class="text-muted small">info@hottours.com.ua</div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="fs-4">🕒</div>
                    <div>
                        <div class="fw-semibold">Графік роботи</div>
                        <div class="text-muted small">Пн-Пт: 09:00 – 19:00<br>Сб-Нд: 10:00 – 16:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Написати повідомлення</h4>

                @guest
                    <div class="text-center py-4">
                        <div class="fs-1 mb-3">🔒</div>
                        <p class="text-muted mb-4">Щоб надіслати повідомлення, потрібно увійти в акаунт.</p>
                        <a href="{{ route('login') }}" class="btn btn-danger rounded-pill px-4">Увійти</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary rounded-pill px-4 ms-2">Зареєструватися</a>
                    </div>
                @else
                    @if(session('message_sent'))
                        <div class="alert alert-success rounded-3">
                            ✅ Дякуємо! Ваше повідомлення відправлено. Ми зв'яжемось з вами найближчим часом.
                        </div>
                    @endif

                    <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-3">
                        <div class="fs-4">👤</div>
                        <div>
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Тема</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Повідомлення</label>
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="5" required>{{ old('body') }}</textarea>
                            @error('body') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 w-100">Відправити повідомлення</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>

@endsection
