@extends('mainapp')
@section('title', 'Daily Tips Management')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daily Tips Management</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTipModal">
            <i class="fas fa-plus me-1"></i> Add New Tip
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
    @if($tips)
    <table class="table table-bordered text-center">
        <thead class="table-info">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Text</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tips as $key => $tip)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    @if(isset($tip['image_base64']))
                        <img src="data:image/jpeg;base64,{{ $tip['image_base64'] }}" width="100">
                    @endif
                </td>
                <td>{{ $tip['text'] ?? 'No text' }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $key }}">Edit</button>

                    <form action="{{ url('/daily_tips/'.$key.'/delete') }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this tip?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $key }}" tabindex="-1" aria-labelledby="editModalLabel{{ $key }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ url('/daily_tips/'.$key.'/edit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Tip #{{ $key }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Text</label>
                                    <input type="text" name="text" class="form-control" value="{{ $tip['text'] ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Replace Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <small class="text-muted">Leave image empty if not changing.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No tips found.</p>
    @endif
</div>

<!-- Add Modal -->
<div class="modal fade" id="addTipModal" tabindex="-1" aria-labelledby="addTipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ url('/daily_tips') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Tip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Text</label>
                        <input type="text" name="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Tip</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
