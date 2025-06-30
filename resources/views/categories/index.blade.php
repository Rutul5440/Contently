<x-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        {{-- <th>Slug</th> --}}
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td>
                            @if($cat->image)
                                <img src="{{ asset('storage/' . $cat->image) }}" width="60" height="60" class="rounded">
                            @endif
                        </td>
                        <td>{{ $cat->name }}</td>
                        {{-- <td>{{ $cat->slug }}</td> --}}
                        <td>
                            <span class="badge badge-{{ $cat->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($cat->status) }}
                            </span>
                        </td>
                        <td>{{ $cat->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
