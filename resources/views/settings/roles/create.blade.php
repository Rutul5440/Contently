<x-layout>
    <h2>{{ isset($role) ? 'Edit' : 'Create' }} Role</h2>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ isset($role) ? route('settings.roles.update', $role) : route('settings.roles.store') }}">
        @csrf
        @if(isset($role))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $role->name ?? '') }}" required>
        </div>

        <button class="btn btn-success">{{ isset($role) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('settings.roles.index') }}" class="btn btn-secondary">Back</a>
    </form>
</x-layout>
