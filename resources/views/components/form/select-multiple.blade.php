<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }}</label>
    <select
        id="{{ $id }}"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}"
        data-coreui-selection-type="{{ $type }}"
        data-coreui-search="{{ $search }}"
        multiple>
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" @if (old($name) == $option['value'] || in_array($option['value'], $value)) selected @endif>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('/vendor/select2/css/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid;
            border-color: #d8dbe0;
            border-radius: 0.25em;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid;
            border-color: #d8dbe0;
            border-radius: 0.25em;
        }
    </style>
@endpush

@push('javascript')
    <script src="{{ asset('/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#{{ $id }}').select2();
        });
    </script>
@endpush
