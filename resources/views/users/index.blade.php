<x-layout>
    <h2>
        Users
    </h2>
    <a href="{{ route('users.create')}}" class="btn btn-primary mb-3">Add User</a>

    @foreach($users as $user)
        <div class="card mb-2 p-3">
            <strong>{{ $user->name }}</strong><br>
            {{ $user->email }} | {{ $user->phone}} | Status: {{ ucFirst($user->status)}}
            <div class="mt-2">
                <a href="{{ route('users.edit', $user )}}" class="btn btn-sm btn-warning">Edit</a>
                <form method="POST" action="{{ route('users.destroy', $user) }}" style="display: inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $users->links() }}
</x-layout>