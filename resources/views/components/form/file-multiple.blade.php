<div class="form-group">
    @if ($label != null || $label != '')
        <label for="{{ $id }}">{{ __($label) }}</label>
    @endif

    <div class="custom-file">
        <input id="{{ $id }}" class="custom-file-input" type="file" name="{{ $name }}" multiple {{ $attributes }}>
        <label id="{{ $id }}-label" class="custom-file-label" for="{{ $id }}">{{ __('Choose file') }}</label>
    </div>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@push('javascript')
<script>
    $('#{{ $id }}').change(function (e) {
        let files = e.target.files;

        console.log(files);

        if (files.length > 1) {
            $('#{{ $id }}-label').text(`${files.length} images selected`);

            return;
        }

        $('#{{ $id }}-label').text(`${files[0].name}`);
    });
</script>
@endpush
