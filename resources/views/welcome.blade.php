<!-- resources/views/users/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Firebase Users</title>
</head>
<body>
    <h1>Firebase Users</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Add User</button>
    </form>

    <ul>
        @foreach($users as $id => $user)
            <li>
                {{ $user['name'] ?? 'No Name' }} - {{ $user['email'] ?? 'No Email' }}
                <form method="POST" action="{{ route('users.update', $id) }}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="New Name">
                    <input type="email" name="email" placeholder="New Email">
                    <button type="submit">Update</button>
                </form>
                <form method="POST" action="{{ route('users.destroy', $id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
