<x-layout>
    <div class="card shadow">
        <div class="card-header">{{ isset($category) ? 'Edit' : 'Add' }} Category</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}">
                @csrf
                @if(isset($category)) @method('PUT') @endif

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" required>
                </div>

                {{-- <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="form-control" required>
                </div> --}}

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control-file">
                    @if(isset($category) && $category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" width="80" class="mt-2 rounded">
                    @endif
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ (old('status', $category->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (old('status', $category->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button class="btn btn-primary">{{ isset($category) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>
