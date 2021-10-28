<div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if ($footer)
        <div class="card-footer">{{ $footer }}</div>
    @endif
</div>
