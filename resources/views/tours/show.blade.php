@extends('layout')

@section('title', $tour->title)

@section('content')

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Головна</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Каталог турів</a></li>
        <li class="breadcrumb-item active">{{ $tour->title }}</li>
    </ol>
</nav>

<div class="row g-4">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            @if($tour->image && file_exists(public_path('assets/tours/' . $tour->image)))
                <img class="card-img-top" alt="{{ $tour->title }}" src="{{ asset('assets/tours/' . $tour->image) }}" style="max-height:420px;object-fit:cover;">
            @else
                <div class="bg-dark text-white-50 d-flex justify-content-center align-items-center" style="height:280px;">
                    <span class="fs-1">✈️</span>
                </div>
            @endif
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-danger rounded-pill px-3 py-2 mb-2">{{ $tour->destination->name ?? 'Без напрямку' }}</span>
                        @if($tour->is_hot)
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-2 ms-1">🔥 Гарячий</span>
                        @endif
                        <h1 class="fw-bold mb-0">{{ $tour->title }}</h1>
                    </div>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-outline-secondary rounded-pill px-3 flex-shrink-0">Редагувати</a>
                        @endif
                    @endauth
                </div>

                <p class="text-muted mb-4">{{ $tour->description }}</p>

                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="fs-5">🌙</div>
                            <div class="fw-bold">{{ $tour->duration }}</div>
                            <div class="text-muted small">ночей</div>
                        </div>
                    </div>
                    @if($tour->departure_date)
                    <div class="col-6 col-md-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="fs-5">📅</div>
                            <div class="fw-bold">{{ date('d.m', strtotime($tour->departure_date)) }}</div>
                            <div class="text-muted small">{{ date('Y', strtotime($tour->departure_date)) }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="col-6 col-md-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="fs-5">📍</div>
                            <div class="fw-bold small">{{ $tour->destination->name ?? '—' }}</div>
                            <div class="text-muted small">напрямок</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mb-3">Фотогалерея</h4>
        @auth
            @if(Auth::user()->isAdmin())
            <a href="{{ route('tours.images.create', $tour->id) }}" class="btn btn-outline-secondary rounded-pill mb-3">+ Додати фото</a>
            @endif
        @endauth

        @if($tour->photos->isEmpty())
            <p class="text-muted">Фотографій ще немає.</p>
        @else
        <div class="row row-cols-1 row-cols-md-2 g-3">
            @foreach($tour->photos as $photo)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <img class="card-img-top" alt="{{ $photo->description }}" src="{{ asset('assets/images/' . $photo->image) }}" style="height:200px;object-fit:cover;">
                    @if($photo->description || Auth::check() && Auth::user()->isAdmin())
                    <div class="card-body p-3">
                        @if($photo->description)
                            <p class="text-muted small mb-2">{{ $photo->description }}</p>
                        @endif
                        @auth
                            @if(Auth::user()->isAdmin())
                            <div class="d-flex gap-2 flex-wrap">
                                <form action="{{ route('images.move', $photo->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select class="form-select form-select-sm" name="new_tour">
                                            @foreach($tours as $t)
                                                <option @if($photo->tour->id == $t->id) selected @endif value="{{ $t->id }}">{{ $t->title }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Перемістити</button>
                                    </div>
                                </form>
                                <form action="{{ route('images.destroy', $photo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">Видалити</button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow rounded-3 sticky-top" style="top:20px;">
            <div class="card-body p-4">
                <div class="text-center mb-3">
                    <div class="fs-2 fw-bold text-danger">{{ number_format($tour->price, 0, '', ' ') }} грн</div>
                    <div class="text-muted small">за одну особу</div>
                </div>

                @if(session('order_success'))
                    <div class="alert alert-success rounded-3">
                        ✅ Дякуємо! Заявку прийнято. Менеджер зв'яжеться з вами найближчим часом.
                    </div>
                @endif

                <form action="{{ route('tours.order', $tour->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ваше ім'я</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Номер телефону</label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Кількість осіб</label>
                        <input type="number" name="persons" class="form-control" value="{{ old('persons', 1) }}" min="1" max="10" required>
                    </div>
                    <button type="submit" class="btn btn-danger rounded-pill w-100 btn-lg">Залишити заявку</button>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">Менеджер зв'яжеться з вами протягом 15 хвилин</p>
            </div>
        </div>
    </div>
</div>

@endsection
