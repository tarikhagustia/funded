<div>
    <button {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
        <i class="{{ $attributes->has('icon') ? $attributes->get('icon') : 'far fa-save' }}"></i> {{ __($label) }}
    </button>
</div>
