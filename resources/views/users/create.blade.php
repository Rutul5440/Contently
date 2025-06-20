<x-layout>
    <h2>{{ isset($user) ? 'Edit' : 'Create' }} User</h2>

    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <input name="name" class="form-control mb-2" value="{{ old('name', $user->name ?? '') }}" placeholder="Name" required>
        <input name="email" class="form-control mb-2" value="{{ old('email', $user->email ?? '') }}" placeholder="Email" required>
        <input name="phone" class="form-control mb-2" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Phone" required>

        <select name="status" class="form-control mb-2" required>
            <option value="active" {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button class="btn btn-success mt-2">Save</button>
    </form>

</x-layout>