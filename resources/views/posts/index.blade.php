<x-layout>
    <h1 class="h3 mb-4">All Posts</h1>

    @can('post.add')
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3"> <i class="fas fa-plus"></i> Add Post</a>
    @endcan
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><span class="badge badge-info">{{ $post->status }}</span></td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->created_at->format('d M, Y h:i A') }}</td>
                        <td>
                            @can('post.view')
                                <button class="btn btn-sm btn-info" onclick="viewPost({{ $post->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            @endcan
                            @can('post.update')
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('post.delete')
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete post?')" class="btn btn-sm btn-danger">
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
                {{ $posts->links() }}
            </div>
            
            <div class="modal fade" id="postViewModal" tabindex="-1" role="dialog" aria-labelledby="postViewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Post Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Title:</strong> <span id="postTitle"></span></p>
                        <p><strong>Status:</strong> <span id="postStatus"></span></p>
                        <p><strong>Author:</strong> <span id="postAuthor"></span></p>
                        <p><strong>Excerpt:</strong></p>
                        <div id="postExcerpt" class="border p-2 rounded bg-light"></div>
                        <p><strong>Image:</strong></p>
                        <img id="postImage" src="" class="img-fluid rounded" style="max-width: 300px;">
                        <p><strong>Created At:</strong> <span id="postCreated"></span></p>
                        <p><strong>Description:</strong></p>
                        <div id="postDescription" class="border p-2 rounded bg-light"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function viewPost(id) {
            fetch(`/posts/${id}`)
                .then(res => res.json())
                .then(post => {
                    document.getElementById('postTitle').innerText = post.title;
                    document.getElementById('postStatus').innerText = post.status;
                    document.getElementById('postAuthor').innerText = post.user.name;
                    document.getElementById('postCreated').innerText = new Date(post.created_at).toLocaleString();
                    document.getElementById('postDescription').innerHTML = post.description;

                    // ✅ Set excerpt
                    document.getElementById('postExcerpt').innerHTML = post.excerpt;

                    // ✅ Set image (if present)
                    const imageTag = document.getElementById('postImage');
                    if (post.image) {
                        imageTag.src = `/storage/${post.image}`;
                        imageTag.style.display = 'block';
                    } else {
                        imageTag.style.display = 'none';
                    }

                    $('#postViewModal').modal('show');
                })
                .catch(err => {
                    alert('Something went wrong');
                    console.error(err);
                });
        }
    </script>
    @endpush
</x-layout>
