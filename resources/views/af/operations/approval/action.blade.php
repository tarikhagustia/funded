<div>
    <a href="{{ route('costs-operation.view', $id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-eye" data-tooltip="View"></i>
    </a>

    <button class="btn btn-sm btn-success" onclick="return confirm('Are u sure to Approve this?') ? $('#form-approve-{{$id}}').submit() : null">
        <i class="fas fa-check" data-tooltip="Approve"></i>
    </button>
    <form id="form-approve-{{$id}}" action="{{ route('costs-operation.update.status', $id) }}" method="post">@csrf <input type="hidden" name="status" value="Approved"></form>

    <button class="btn btn-sm btn-danger" onclick="return confirm('Are u sure to Reject this?') ? $('#form-reject-{{$id}}').submit() : null">
        <i class="fas fa-times" data-tooltip="Reject"></i>
    </button>
    <form id="form-reject-{{$id}}" action="{{ route('costs-operation.update.status', $id) }}" method="post">@csrf <input type="hidden" name="status" value="Rejected"></form>
</div>
