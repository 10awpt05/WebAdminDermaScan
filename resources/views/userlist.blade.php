@extends('mainapp')

@section('title', 'User List')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 class="mb-4">User Table</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Quote</th>
                <th>Bio</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>
                    @if (!empty($user['profileImage']))
                        <img src="data:image/png;base64,{{ $user['profileImage'] }}" width="50" height="50" class="rounded-circle">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>{{ $user['name'] ?? 'N/A' }}</td>
                <td>{{ $user['email'] ?? 'N/A' }}</td>
                <td>{{ $user['role'] ?? 'N/A' }}</td>
                <td>{{ $user['birthday'] ?? 'N/A' }}</td>
                <td>{{ $user['gender'] ?? 'N/A' }}</td>
                <td>{{ $user['contact'] ?? 'N/A' }}</td>
                <td>{{ $user['province'] ?? '' }}, {{ $user['city'] ?? '' }}, {{ $user['barangay'] ?? '' }}</td>
                <td>{{ $user['quote'] ?? 'N/A' }}</td>
                <td>{{ $user['bio'] ?? 'N/A' }}</td>
                <td>
                    <form action="{{ route('user.delete', $user['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this user?')">
                            Delete
                        </button>
                    </form>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">No users found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Pagination Controls --}}
    <div class="d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
@endsection
    
