<x-layout>
    <h1 class="h3 mb-4">All Posts</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3"> <i class="fas fa-plus"></i> Add Post</a>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Excerpt</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ Str::limit($post->excerpt, 50) }}</td>
                        <td><span class="badge badge-info">{{ $post->status }}</span></td>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete post?')" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
