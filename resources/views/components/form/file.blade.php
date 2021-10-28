<div class="form-group">
    @if ($label != null || $label != '')
        <label for="{{ $id }}">{{ __($label) }}</label>
    @endif

    @if ($value != null | $value != '')
        <div class="mb-2">
            <img src="{{ url($value) }}" width="100">
        </div>
    @endif

    <div class="custom-file">
        <input id="{{ $id }}" class="custom-file-input" type="file" name="{{ $name }}">
        <label id="{{ $id }}-label" class="custom-file-label" for="{{ $id }}">{{ __('Choose file') }}</label>
    </div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@push('javascript')
<script>
    $('#{{ $id }}').change(function (e) {
        let filename = e.target.files[0].name;

        $('#{{ $id }}-label').text(filename);
    });
</script>
@endpush
