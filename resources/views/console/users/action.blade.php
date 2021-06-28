<div class="d-flex justify-content-between">
    <a href="{{ route('console.users.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-pencil-alt" data-tooltip="Edit"></i>
    </a>

    @if(\Illuminate\Support\Facades\Auth::id() != $id)
        <button class="btn btn-sm btn-danger" onclick="return confirm('Are u sur') ? $('#form-delete-{{$id}}').submit() : null">
            <i class="fas fa-trash" data-tooltip="Delete"></i>
        </button>
        <form id="form-delete-{{$id}}" action="{{ route('console.users.destroy', $id) }}" method="post">@csrf @method('DELETE')</form>
    @endif
</div>
