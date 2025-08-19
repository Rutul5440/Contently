<x-layout>
    <h2>
        Users List
    </h2>
    @can('user.add')
        <a href="{{ route('users.create')}}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Add User
        </a>
    @endcan

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                     <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th width="180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + $users->firstItem() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ ucfirst($user->status) }}</td>
                                <td>
                                    <select class="form-select select-role" data-user-id="{{ $user->id }}" style="width: 150px;">
                                        <option disabled {{ $user->roles->isEmpty() ? 'selected' : '' }}>-</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @can('user.update')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('user.delete')
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                console.log('Role changesdfd');
                $('.select-role').select2();
                console.log("Select2 Initialized");

                $('.select-role').on('change', function () {
                    const userId = $(this).data('user-id');
                    const selectedRole = $(this).val();
                    console.log("Role Changed");

                    $.ajax({
                        url: '{{ route("users.update-role") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId,
                            role: selectedRole
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Role updated successfully!');
                            }
                        },
                        error: function () {
                            alert('Failed to update role.');
                        }
                    });
                });
            });
        </script>
    @endpush

</x-layout>
