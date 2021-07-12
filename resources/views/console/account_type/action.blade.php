<div class="d-flex justify-content-between">
    <a href="{{ route('console.account-types.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-pencil-alt" data-tooltip="Edit"></i>
    </a>

    <button class="btn btn-sm btn-danger" onclick="return confirm('Are u sur') ? $('#form-delete-{{$id}}').submit() : null">
        <i class="fas fa-trash" data-tooltip="Delete"></i>
    </button>
    <form id="form-delete-{{$id}}" action="{{ route('console.account-types.destroy', $id) }}" method="post">@csrf @method('DELETE')</form>
</div>
