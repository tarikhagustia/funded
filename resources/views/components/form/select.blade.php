<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }}</label>
    <select
        id="{{ $id }}"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}">
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" @if (old($name) == $option['value'] || $value == $option['value']) selected @endif>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
