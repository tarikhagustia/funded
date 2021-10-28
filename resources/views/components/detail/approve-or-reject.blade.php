<div class="row justify-content-center">
    <div class="col-auto">
        <x-form.form :action="$reject">
            @method('put')
            <x-form.submit-no-margin
                class="btn-danger"
                icon="fas fa-times"
                label="Reject"
                type="button"
                onclick="return confirm('Are you sure?') ? $(this).closest('form').submit() : null">
            </x-form.submit-no-margin>
        </x-form.form>
    </div>
    <div class="col-auto">
        <x-form.form :action="$approve">
            @method('put')
            <x-form.submit-no-margin
                class="btn-success"
                icon="fas fa-check"
                label="Approve"
                type="button"
                onclick="return confirm('Are you sure?') ? $(this).closest('form').submit() : null">
            </x-form.submit-no-margin>
        </x-form.form>
    </div>
</div>