<h1>Login</h1>

<form method="POST" action="{{ route('loginsubmit') }}">
    @csrf
    <p>Name</p>
    <input type="text" name="name" required>

    <p>Email</p>
    <input type="email" name="email" required>

    <button type="submit">Login</button>
</form>
