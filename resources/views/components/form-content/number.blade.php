<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }}</label>
    <input
        id="{{ $id }}"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}"
        value="{{ old($name) ?? $attributes->get('value') }}"
        type="number"
        {{ $attributes }}>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
