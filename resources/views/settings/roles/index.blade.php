<x-layout>
    <h2>Roles & Permissions</h2>

    <a href="{{ route('settings.roles.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Role
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">Role Name</th>
                            <th style="width: 75%;">Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="d-flex justify-content-between align-items-center">
                                    <strong>{{ ucfirst($role->name) }}</strong>
                                    <div class="d-flex">
                                        <a href="{{ route('settings.roles.edit', $role) }}" class="btn btn-sm btn-warning me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('settings.roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('settings.roles.update-permissions', $role->id) }}">
                                        @csrf @method('PUT')
                                        <div class="row">
                                            @foreach($permissions as $permission)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               id="perm-{{ $role->id }}-{{ $permission->id }}"
                                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-gray-700 small"
                                                               for="perm-{{ $role->id }}-{{ $permission->id }}">
                                                            {{ ucwords(str_replace(['.', '_'], [' ', ' '], $permission->name)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-save me-1"></i> Update Permissions
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
