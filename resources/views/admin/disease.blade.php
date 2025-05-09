@extends('mainapp')

@section('title', 'Disease Library')

@section('content')
<div class="container mt-4">
    <h2>Disease Library</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3 d-flex justify-content-end" data-bs-toggle="modal" data-bs-target="#addDiseaseModal">Add New Disease</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Disease Name</th>
                <th>Description</th>
                <th>Cause</th>
                <th>Prevention</th>
                <th>Remedy</th>
                <th>Credit URL</th>
                <th>Actions</th> <!-- Added Actions column for Edit and Delete -->
            </tr>
        </thead>
        <tbody>
            @foreach ($diseases as $name => $info)
                <tr>
                    <td>{{ $name }}</td>

                    <!-- Description -->
                    <td>
                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#viewDescriptionModal{{ \Str::slug($name) }}">
                            {{ \Str::limit($info['des'] ?? '', 50) }}
                        </button>
                    </td>

                    <!-- Cause -->
                    <td>
                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#viewCauseModal{{ \Str::slug($name) }}">
                            {{ \Str::limit($info['cause'] ?? '', 50) }}
                        </button>
                    </td>

                    <!-- Prevention -->
                    <td>
                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#viewPreventionModal{{ \Str::slug($name) }}">
                            {{ \Str::limit($info['prev'] ?? '', 50) }}
                        </button>
                    </td>

                    <!-- Remedy -->
                    <td>
                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#viewRemedyModal{{ \Str::slug($name) }}">
                            {{ \Str::limit($info['rem'] ?? '', 50) }}
                        </button>
                    </td>

                    <!-- Credit URL -->
                    <td>
                        @if (!empty($info['creditURL']))
                            <a href="{{ $info['creditURL'] }}" target="_blank">Source</a>
                        @else
                            N/A
                        @endif
                    </td>

                    <td>
                        <!-- Edit button -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDiseaseModal{{ \Str::slug($name) }}">Edit</button>

                        <!-- Delete button -->
                        <form action="{{ route('disease.destroy', ['name' => $name]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal for Description -->
                <div class="modal fade" id="viewDescriptionModal{{ \Str::slug($name) }}" tabindex="-1" aria-labelledby="viewDescriptionModalLabel{{ \Str::slug($name) }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Description: {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $info['des'] ?? 'No description available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Cause -->
                <div class="modal fade" id="viewCauseModal{{ \Str::slug($name) }}" tabindex="-1" aria-labelledby="viewCauseModalLabel{{ \Str::slug($name) }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cause: {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $info['cause'] ?? 'No cause information available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Prevention -->
                <div class="modal fade" id="viewPreventionModal{{ \Str::slug($name) }}" tabindex="-1" aria-labelledby="viewPreventionModalLabel{{ \Str::slug($name) }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Prevention: {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $info['prev'] ?? 'No prevention information available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Remedy -->
                <div class="modal fade" id="viewRemedyModal{{ \Str::slug($name) }}" tabindex="-1" aria-labelledby="viewRemedyModalLabel{{ \Str::slug($name) }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Remedy: {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $info['rem'] ?? 'No remedy information available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal for each disease -->
                <div class="modal fade" id="editDiseaseModal{{ \Str::slug($name) }}" tabindex="-1" aria-labelledby="editDiseaseModalLabel{{ \Str::slug($name) }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('disease.update', ['name' => $name]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit: {{ $name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Description</label>
                                        <textarea name="des" class="form-control" required>{{ $info['des'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Cause</label>
                                        <textarea name="cause" class="form-control" required>{{ $info['cause'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Prevention</label>
                                        <textarea name="prev" class="form-control" required>{{ $info['prev'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Remedy</label>
                                        <textarea name="rem" class="form-control" required>{{ $info['rem'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Credit URL</label>
                                        <input type="url" name="creditURL" class="form-control" value="{{ $info['creditURL'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success" type="submit">Update Disease</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal to add a new disease -->
<div class="modal fade" id="addDiseaseModal" tabindex="-1" aria-labelledby="addDiseaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('disease.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Disease</h5>
                <button type
                ="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <!-- Form fields for disease info -->
            <div class="mb-2">
            <label>Disease Name</label>
            <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-2">
            <label>Description</label>
            <textarea name="des" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
            <label>Cause</label>
            <textarea name="cause" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
            <label>Prevention</label>
            <textarea name="prev" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
            <label>Remedy</label>
            <textarea name="rem" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
            <label>Credit URL</label>
            <input type="url" name="creditURL" class="form-control">
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-success" type="submit">Add Disease</button>
            </div>
            </div>
            </form>
            </div> </div>
            
            @endsection