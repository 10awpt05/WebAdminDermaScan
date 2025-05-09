<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">User List</h2>
    
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
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
            @forelse ($users as $id => $user)
                <tr>
                    <td>
                        @if(!empty($user['profileImage']))
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
                        <button type="button" class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $id }}">
                            Edit
                        </button>
                        <a href="{{ route('user.delete', $id) }}"
                           onclick="return confirm('Are you sure you want to delete this user?')"
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
    
                <!-- Modal -->
                <div class="modal fade" id="editModal{{ $id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('user.update', $id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $id }}">Edit User: {{ $user['name'] ?? '' }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <div class="col-md-6">
                                        <label>Name:</label>
                                        <input name="name" value="{{ $user['name'] ?? '' }}" class="form-control">
                                    </div>
                                    <!-- Additional Fields go here -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="11" class="text-center">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    
        <!-- Pagination -->
        @if(count($users) > 10)
            <div class="d-flex justify-content-end">
                <!-- Add logic to show "Next" button based on page -->
                <a href="{{ route('users.index', ['page' => 2]) }}" class="btn btn-primary">Next</a>
            </div>
        @endif
    </div>

    <div class="container mt-5">
        <!-- Blog Post -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $post['fullName'] }}</strong> - {{ date('Y-m-d', $post['timestamp']) }}
            </div>
            <div class="card-body">
                <p>{{ $post['content'] }}</p>
                @if(!empty($post['postImageBase64']))
                    <img src="data:image/png;base64,{{ $post['postImageBase64'] }}" width="200" />
                @endif
                <br>
    
                <!-- Edit and Delete buttons for the blog post -->
                <a href="{{ route('blog.edit', $post['postId']) }}" class="btn btn-primary">Edit</a>
    
                <form action="{{ route('blog.delete', $post['postId']) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                </form>
            </div>
        </div>
    
        <!-- Comments Section -->
        <div class="comments">
            <h4>Comments</h4>
    
            @if ($comments)
                @foreach ($comments as $comment)
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{{ $comment['userName'] }}</strong> - {{ date('Y-m-d', $comment['timestamp']) }}
                        </div>
                        <div class="card-body">
                            <p>{{ $comment['comment'] }}</p>
                            @if(!empty($comment['userProfileImageBase64']))
                                <img src="data:image/png;base64,{{ $comment['userProfileImageBase64'] }}" width="50" />
                            @endif
                            <br>
                            
                            <!-- Edit and Delete buttons for the comment -->
                            <a href="{{ route('comment.edit', $comment['commentId']) }}" class="btn btn-warning btn-sm">Edit</a>
    
                            <form action="{{ route('comment.delete', $comment['commentId']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No comments yet.</p>
            @endif
    
            <!-- Comment Form -->
            <h5>Add a Comment</h5>
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <input type="hidden" name="postId" value="{{ $post['postId'] }}">
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>
    </div>
</body>
</body>
</html>
