<table class="table table-bordered table-hover">
    <thead class="table-info">
        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Quote</th>
            <th>Bio</th>
            <th>Validation Type</th> <!-- NEW COLUMN -->
            <th>Validation Image</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($users as $user)
        @php
            $userJson = htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8');
        @endphp
        <tr>
            @foreach([
                'profileImage', 'name', 'email', 'role', 'status', 'birthday', 'gender',
                'contact', 'address', 'quote', 'bio', 'uploadType', 'verificationImg', 'rating', 'feedback'
            ] as $field)
                @php
                    $value = $user[$field] ?? 'N/A';

                    if ($field === 'address') {
                        $value = ($user['province'] ?? '') . ', ' . ($user['city'] ?? '') . ', ' . ($user['barangay'] ?? '');
                    }
                @endphp
                <td class="user-cell" data-user="{{ $userJson }}">
                    @if($field === 'profileImage' || $field === 'verificationImg')
                        @if(!empty($value))
                            <img src="data:image/png;base64,{{ $value }}" width="50" height="50" class="rounded-circle">
                        @else
                            <span>No Image</span>
                        @endif
                    @else
                        {{ \Illuminate\Support\Str::limit($value, 20) }}
                    @endif
                </td>
            @endforeach
            <td>
                <div class="d-flex flex-column gap-1">
                    <form action="{{ route('admin.verify-user', $user['uid']) }}" method="POST" onsubmit="return confirm('Are you sure you want to Verify this user?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Verify</button>
                    </form>
                    <form action="{{ route('admin.reject-user', $user['uid']) }}" method="POST" onsubmit="return confirm('Are you sure you want to Reject the verification of this user?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">Reject</button>
                    </form>
                    <form action="{{ route('admin.delete-user', $user['uid']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="16" class="text-center">No users found.</td>
        </tr>
    @endforelse
    </tbody>
</table>
