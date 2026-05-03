@extends('layout')

@section('title', 'Адмін-панель — Статистика')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">📊 Адмін-панель</span>
        <h1 class="display-5 fw-bold mb-2">Статистика</h1>
        <p class="fs-5 text-white-50">Аналітика турів та замовлень</p>
    </div>
</div>

{{-- Зведені картки --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center p-4">
                <div class="fs-1 mb-2">✈️</div>
                <div class="display-6 fw-bold text-primary">{{ $totalTours }}</div>
                <div class="text-muted small mt-1">Турів у каталозі</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center p-4">
                <div class="fs-1 mb-2">📋</div>
                <div class="display-6 fw-bold text-warning">{{ $totalOrders }}</div>
                <div class="text-muted small mt-1">Заявок всього</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center p-4">
                <div class="fs-1 mb-2">👤</div>
                <div class="display-6 fw-bold text-success">{{ $totalUsers }}</div>
                <div class="text-muted small mt-1">Користувачів</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center p-4">
                <div class="fs-1 mb-2">💰</div>
                <div class="display-6 fw-bold text-danger">{{ number_format($confirmedRevenue, 0, '', ' ') }}</div>
                <div class="text-muted small mt-1">грн підтверджено</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">

    {{-- Статус заявок --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Заявки за статусом</h5>

                @php
                    $total = $ordersByStatus['new'] + $ordersByStatus['confirmed'] + $ordersByStatus['cancelled'];
                    $pctNew       = $total > 0 ? round($ordersByStatus['new']       / $total * 100) : 0;
                    $pctConfirmed = $total > 0 ? round($ordersByStatus['confirmed'] / $total * 100) : 0;
                    $pctCancelled = $total > 0 ? round($ordersByStatus['cancelled'] / $total * 100) : 0;
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">⏳ Нових</span>
                        <span class="badge bg-warning text-dark rounded-pill px-3">{{ $ordersByStatus['new'] }}</span>
                    </div>
                    <div class="progress rounded-pill" style="height:12px;">
                        <div class="progress-bar bg-warning" style="width:{{ $pctNew }}%"></div>
                    </div>
                    <div class="text-muted small mt-1">{{ $pctNew }}% від усіх</div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">✅ Підтверджено</span>
                        <span class="badge bg-success rounded-pill px-3">{{ $ordersByStatus['confirmed'] }}</span>
                    </div>
                    <div class="progress rounded-pill" style="height:12px;">
                        <div class="progress-bar bg-success" style="width:{{ $pctConfirmed }}%"></div>
                    </div>
                    <div class="text-muted small mt-1">{{ $pctConfirmed }}% від усіх</div>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold">❌ Скасовано</span>
                        <span class="badge bg-danger rounded-pill px-3">{{ $ordersByStatus['cancelled'] }}</span>
                    </div>
                    <div class="progress rounded-pill" style="height:12px;">
                        <div class="progress-bar bg-danger" style="width:{{ $pctCancelled }}%"></div>
                    </div>
                    <div class="text-muted small mt-1">{{ $pctCancelled }}% від усіх</div>
                </div>

                <hr class="mt-4">
                <div class="d-flex justify-content-between fw-bold">
                    <span>Всього заявок</span>
                    <span>{{ $total }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Топ-5 турів --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Топ-5 турів за кількістю заявок</h5>
                @if($topTours->isEmpty())
                    <p class="text-muted">Заявок ще немає.</p>
                @else
                    @php $maxOrders = $topTours->first()->orders_count ?: 1; @endphp
                    @foreach($topTours as $i => $tour)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-dark rounded-pill" style="min-width:28px;">{{ $i + 1 }}</span>
                                <span class="fw-semibold small">{{ $tour->title }}</span>
                            </div>
                            <span class="text-muted small fw-bold ms-2 flex-shrink-0">{{ $tour->orders_count }} зав.</span>
                        </div>
                        <div class="progress rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-primary" style="width:{{ round($tour->orders_count / $maxOrders * 100) }}%"></div>
                        </div>
                        <div class="text-muted small mt-1">{{ $tour->destination->name ?? '—' }} · {{ number_format($tour->price, 0, '', ' ') }} грн</div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Заявки по напрямках --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Заявки по напрямках</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="px-4">Напрямок</th>
                        <th>Турів</th>
                        <th>Заявок</th>
                        <th>Популярність</th>
                    </tr>
                </thead>
                <tbody>
                    @php $maxDest = $byDestination->first()?->orders_total ?: 1; @endphp
                    @forelse($byDestination as $dest)
                    <tr>
                        <td class="px-4 fw-semibold">{{ $dest->name }}</td>
                        <td class="text-muted">{{ $dest->tours_count }}</td>
                        <td>
                            <span class="badge bg-primary rounded-pill px-3">{{ $dest->orders_total }}</span>
                        </td>
                        <td style="width:35%;">
                            <div class="progress rounded-pill" style="height:10px;">
                                <div class="progress-bar bg-danger" style="width:{{ round($dest->orders_total / $maxDest * 100) }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted px-4 py-3">Даних немає</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Додаткова інфо --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="fs-2">🔥</div>
                <div>
                    <div class="fw-bold fs-5">{{ $hotTours }} гарячих турів</div>
                    <div class="text-muted small">із {{ $totalTours }} у каталозі ({{ $totalTours > 0 ? round($hotTours / $totalTours * 100) : 0 }}%)</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="fs-2">📬</div>
                <div>
                    <div class="fw-bold fs-5">{{ $ordersByStatus['new'] }} нових заявок</div>
                    <div class="text-muted small">очікують на опрацювання менеджером</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
