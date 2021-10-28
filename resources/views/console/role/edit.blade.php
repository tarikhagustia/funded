@extends('layouts.main')

@section('content')
    <x-form-content.form
        title="{{ __('Roles Form') }}"
        action="{{ route('console.roles.update', ['role' => $role]) }}">
        @method('PUT')
        <x-form-content.input id="name" label="Name" name="name" value="{{ $role->name }}"></x-form-content.input>
        <div class="mb-4">
            <h6>Permissions</h6>
            @foreach ($permissionGroups as $group => $permissions)
                <div class="mb-2">
                    <div>{{ $group }}</div>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input
                                id="permission-{{ $permission->id }}"
                                class="form-check-input"
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                {{ ! in_array($permission->id, $role->permissionIDs) ?:  'checked' }}>
                            <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <x-form-content.submit></x-form-content.submit>
    </x-form-content.form>
@endsection
