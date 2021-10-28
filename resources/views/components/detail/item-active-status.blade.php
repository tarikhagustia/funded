<div class="detail--item mb-2">
    @if ($label)
        <label>{{ $label }}</label>
    @endif

    <div>
        @if (
            strtoupper($value) == strtoupper(\App\Constants\StatusConstant::ACTIVE) ||
            strtoupper($value) == strtoupper(\App\Constants\StatusConstant::APPROVED)
        )
            <span class="text-success">{{ $value }}</span>
        @elseif (
            strtoupper($value) == strtoupper(\App\Constants\StatusConstant::INACTIVE) ||
            strtoupper($value) == strtoupper(\App\Constants\StatusConstant::REJECTED)
        )
            <span class="text-danger">{{ $value }}</span>
        @else
            <span class="text-warning">{{ $value }}</span>
        @endif
    </div>
</div>
