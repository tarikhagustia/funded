<div>
    <a href="{{ route('costs-operation.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-pencil-alt" data-tooltip="Edit"></i>
    </a>

    <button class="btn btn-sm btn-danger" onclick="return confirm('Are u sure to Delete this?') ? $('#form-delete-{{$id}}').submit() : null">
        <i class="fas fa-trash" data-tooltip="Delete"></i>
    </button>
    <form id="form-delete-{{$id}}" action="{{ route('costs-operation.destroy', $id) }}" method="post">@csrf @method('DELETE')</form>
</div>
