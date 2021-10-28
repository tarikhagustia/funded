<div class="d-flex justify-content-center">
    @if ($detail)
        <a href="{{ $detail }}" class="btn btn-sm btn-info text-light mr-2">
            <i class="fas fa-file-alt" data-tooltip="Show"></i>
        </a>
    @endif

    @if ($edit)
        <a href="{{ $edit }}" class="btn btn-sm btn-warning text-light mr-2">
            <i class="fas fa-pencil-alt" data-tooltip="Edit"></i>
        </a>
    @endif

    @if ($delete)
        <button class="btn btn-sm btn-danger mr-2" onclick="return confirm('Are you sure?') ? $('#form-delete-{{ $key }}').submit() : null">
            <i class="fas fa-trash" data-tooltip="Delete"></i>
        </button>
        <form id="form-delete-{{ $key }}" action="{{ $delete }}" method="post">@csrf @method('DELETE')</form>
    @endif
</div>
