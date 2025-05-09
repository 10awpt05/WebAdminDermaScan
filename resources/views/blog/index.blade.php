@extends('mainapp')

@section('title', 'Blog Table')

@section('content')
    <div class="container">
        <h2 class="mb-4">Blog Posts</h2>
    
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Post Image</th>
                    <th>Profile Pic</th>
                    <th>Likes</th>
                    <th>Comments</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $postId => $post)
                    <tr>
                        <td>{{ $postId }}</td>
                        <td>{{ $post['fullName'] ?? 'N/A' }}</td>
                        <td>{{ $post['content'] ?? '' }}</td>
                        <td>
                            @if (!empty($post['postImageBase64']))
                                <img src="data:image/jpeg;base64,{{ $post['postImageBase64'] }}" alt="Post Image" width="70">
                            @endif
                        </td>
                        <td>
                            @if (!empty($post['profilePicBase64']))
                                <img src="data:image/jpeg;base64,{{ $post['profilePicBase64'] }}" alt="Profile Image" width="50" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $post['likeCount'] ?? 0 }}</td>
                        <td>{{ $post['commentCount'] ?? 0 }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestampMs($post['timestamp'] ?? 0)->toDateTimeString() }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $postId }}">
                                Edit
                            </button>
    
                            <!-- Delete Form -->
                            <form action="{{ route('blog.destroy', $postId) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</button>
                            </form>
    
                            <!-- Modal -->
                            <div class="modal fade" id="editModal{{ $postId }}" tabindex="-1" aria-labelledby="editModalLabel{{ $postId }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('blog.update', $postId) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Blog Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Content</label>
                                                    <textarea name="content" class="form-control" rows="3">{{ $post['content'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection