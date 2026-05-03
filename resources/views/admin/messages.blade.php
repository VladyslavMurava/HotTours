@extends('layout')

@section('title', 'Адмін-панель — Повідомлення')

@section('content')

<div class="px-4 py-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="py-2">
        <span class="badge bg-danger mb-3 fs-6 px-3 py-2">⚙️ Адмін-панель</span>
        <h1 class="display-5 fw-bold mb-2">Повідомлення</h1>
        <p class="fs-5 text-white-50">Звернення з форми зворотного зв'язку</p>
    </div>
</div>

@if($messages->isEmpty())
    <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
        <div class="fs-1 mb-3">📭</div>
        <h5 class="fw-bold">Повідомлень поки немає</h5>
    </div>
@else
    @php $unread = $messages->where('is_read', false)->count(); @endphp
    @if($unread > 0)
        <div class="alert alert-warning rounded-3 mb-4">
            📬 Непрочитаних повідомлень: <strong>{{ $unread }}</strong>
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        @foreach($messages as $msg)
        <div class="card border-0 shadow-sm rounded-3 {{ $msg->is_read ? 'opacity-75' : '' }}">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            @if(!$msg->is_read)
                                <span class="badge bg-warning text-dark rounded-pill">🆕 Нове</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">✔ Прочитано</span>
                            @endif
                            <span class="fw-bold">{{ $msg->user->name ?? 'Видалений акаунт' }}</span>
                            <span class="text-muted small">{{ $msg->user->email ?? '' }}</span>
                        </div>
                        @if($msg->subject)
                            <div class="fw-semibold mb-2">{{ $msg->subject }}</div>
                        @endif
                        <p class="text-muted mb-0">{{ $msg->body }}</p>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                        <span class="text-muted small">{{ $msg->created_at->format('d.m.Y H:i') }}</span>
                        @if(!$msg->is_read)
                        <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3">Позначити прочитаним</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
