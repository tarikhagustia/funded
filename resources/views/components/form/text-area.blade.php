<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }}</label>
    <textarea
        id="{{ $id }}"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}"
        {{ $attributes }}>{{ old($name) ?? $attributes->get('value') }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
