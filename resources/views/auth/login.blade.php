<x-guest-layout>
    <h2>Login</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>

        <button class="btn btn-primary">Login</button>
        <p class="mt-2">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </form>
</x-guest-layout>