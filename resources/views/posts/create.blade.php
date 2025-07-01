<x-layout>
    <h1 class="h3 mb-4">{{ isset($post) ? 'Edit' : 'Create' }} Post</h1>

    <form action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post)) @method('PUT') @endif

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Excerpt</label>
            <textarea name="excerpt" class="form-control">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $post->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach (['Draft', 'Published', 'Unpublished'] as $status)
                    <option value="{{ $status }}" {{ (old('status', $post->status ?? '') == $status) ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file">
            @if(isset($post) && $post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mt-2" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ isset($post) ? 'Update' : 'Create' }}</button>
    </form>
</x-layout>
