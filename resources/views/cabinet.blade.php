@extends('layout')

@section('title', 'Мій кабінет')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">👤 Кабінет</span>
        <h1 class="display-5 fw-bold mb-2">Мій кабінет</h1>
        <p class="fs-5 text-white-50">Вітаємо, <strong>{{ Auth::user()->name }}</strong>! Тут відображаються ваші заявки.</p>
    </div>
</div>

@if($orders->isEmpty())
    <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
        <div class="fs-1 mb-3">📭</div>
        <h5 class="fw-bold mb-2">У вас ще немає заявок</h5>
        <p class="text-muted mb-4">Оберіть тур та залиште першу заявку</p>
        <div>
            <a href="{{ route('tours.index') }}" class="btn btn-danger rounded-pill px-4">Переглянути тури</a>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="px-4">#</th>
                            <th>Тур</th>
                            <th>Кількість осіб</th>
                            <th>Дата заявки</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="px-4 text-muted">{{ $order->id }}</td>
                            <td>
                                @if($order->tour)
                                    <a href="{{ route('tours.show', $order->tour_id) }}" class="fw-semibold text-decoration-none">{{ $order->tour->title }}</a>
                                @else
                                    <span class="text-muted">Тур видалено</span>
                                @endif
                            </td>
                            <td>{{ $order->persons }} ос.</td>
                            <td class="text-muted small">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($order->status === 'confirmed')
                                    <span class="badge bg-success rounded-pill px-3">✅ Підтверджено</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger rounded-pill px-3">❌ Скасовано</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">⏳ На розгляді</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection
