@extends('layout')

@section('title', 'Адмін-панель — Заявки')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">⚙️ Адмін-панель</span>
        <h1 class="display-5 fw-bold mb-2">Заявки на тури</h1>
        <p class="fs-5 text-white-50">Керування замовленнями клієнтів</p>
    </div>
</div>

@if($orders->isEmpty())
    <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
        <div class="fs-1 mb-3">📭</div>
        <h5 class="fw-bold">Заявок поки немає</h5>
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
                            <th>Ім'я</th>
                            <th>Телефон</th>
                            <th>Осіб</th>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="px-4 text-muted">{{ $order->id }}</td>
                            <td>
                                <a href="{{ route('tours.show', $order->tour_id) }}" class="fw-semibold text-decoration-none">
                                    {{ $order->tour->title ?? 'Тур видалено' }}
                                </a>
                            </td>
                            <td>{{ $order->name }}</td>
                            <td class="text-muted small">{{ $order->phone }}</td>
                            <td>{{ $order->persons }}</td>
                            <td class="text-muted small">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($order->status === 'confirmed')
                                    <span class="badge bg-success rounded-pill px-3">✅ Підтверджено</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger rounded-pill px-3">❌ Скасовано</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">⏳ Нова</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @if($order->status !== 'confirmed')
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <button class="btn btn-success btn-sm rounded-pill px-3">Підтвердити</button>
                                    </form>
                                    @endif
                                    @if($order->status !== 'cancelled')
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <button class="btn btn-danger btn-sm rounded-pill px-3">Скасувати</button>
                                    </form>
                                    @endif
                                    @if($order->status !== 'new')
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="new">
                                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3">Нова</button>
                                    </form>
                                    @endif
                                </div>
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
