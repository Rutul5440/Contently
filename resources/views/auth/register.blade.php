<x-guest-layout>
    <h2>Register</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="text" name="phone" placeholder="Phone" class="form-control mb-2" required>

        <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control mb-2" required>

        <button class="btn btn-success">Register</button>

        <p class="mt-2">Already have an account?
            <a href="{{ route('login') }}">Login here</a>
        </p>
    </form>
</x-guest-layout>
