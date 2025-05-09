<!-- resources/views/users/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            padding: 30px;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #0d6efd;
        }
        .card {
            max-width: 600px;
            margin: auto;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>User Information</h3>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                @if(!empty($user['profileImage']))
                    <img src="{{ $user['profileImage'] }}" alt="Profile Image" class="profile-img">
                @else
                    <img src="https://via.placeholder.com/150" alt="No Profile" class="profile-img">
                @endif
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> {{ $user['name'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user['email'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Role:</strong> {{ $user['role'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Birthday:</strong> {{ $user['birthday'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Gender:</strong> {{ $user['gender'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Contact:</strong> {{ $user['contact'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Province:</strong> {{ $user['province'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>City:</strong> {{ $user['city'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Barangay:</strong> {{ $user['barangay'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Quote:</strong> {{ $user['quote'] ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Bio:</strong> {{ $user['bio'] ?? 'N/A' }}</li>
            </ul>
        </div>
    </div>
</body>
</html>
