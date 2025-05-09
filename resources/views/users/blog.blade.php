<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
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
</html>