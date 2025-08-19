<x-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
        @can('category.add')
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary"> <i class="fas fa-plus"></i> Add Category</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        {{-- <th>Slug</th> --}}
                        <th>Status</th>
                        <th>Image</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        {{-- <td>{{ $cat->slug }}</td> --}}
                        <td>
                            <span class="badge badge-{{ $cat->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($cat->status) }}
                            </span>
                        </td>
                        <td>
                            @if($cat->image)
                                <img src="{{ asset('storage/' . $cat->image) }}" width="60" height="60" class="rounded">
                            @endif
                        </td>
                        <td>{{ $cat->created_at->diffForHumans() }}</td>
                        <td>
                            @can('category.update')
                                <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('category.delete')
                                <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-layout>
