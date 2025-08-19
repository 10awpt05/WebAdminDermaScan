<table class="table table-bordered table-hover mt-3">
    <thead class="table-info">
        <tr>      
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Clinic Contact</th>
            <th>Verification Images</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ Str::limit($user->name ?? '', 20) }}</td>
                <td>{{ Str::limit($user->email ?? '', 20) }}</td>
                <td>{{ Str::limit($user->clinicAddress ?? '', 20) }}</td>
                <td>{{ Str::limit($user->clinicPhone ?? '', 20) }}</td>

                <!-- Show Verification Images Button -->
                <td>
                    <button type="button" class="btn btn-info btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#verificationModal-{{ $user->uid }}">
                        Show Verification Images
                    </button>
                </td>

                <td>{{ $user->rating ?? 'N/A' }}</td>
                <td>{{ $user->status ?? 'N/A' }}</td>

                <td>
                    <div class="d-flex flex-column gap-1">
                        <!-- Verify -->
                        <form action="{{ route('admin.verify-user', $user->uid) }}" method="POST" onsubmit="return confirm('Verify this user?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Verify</button>
                        </form>

                        <!-- Reject -->
                        <button type="button" class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectModal-{{ $user->uid }}">
                            Reject
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Verification Images Modal (FULLSCREEN) -->
           
            <div class="modal fade" id="verificationModal-{{ $user->uid }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Verification Images for {{ $user->name ?? 'User' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="carousel-{{ $user->uid }}" class="carousel slide" data-bs-ride="false" data-bs-interval="false" data-bs-touch="false">
                                <div class="carousel-inner text-center">
                                    @foreach (['businessPermitImage', 'birImage', 'validIdImage'] as $index => $imageType)
                                        <div class="carousel-item @if($index == 0) active @endif">
                                            @if(!empty($user->$imageType))
                                                <img src="{{ route('admin.get-image', ['uid' => $user->uid, 'type' => $imageType]) }}" 
                                                    class="d-block mx-auto"
                                                    style="max-height: 80vh; max-width: 100%; object-fit: contain;" 
                                                    alt="{{ $imageType }}">
                                            @else
                                                <p>No Image</p>
                                            @endif
                                            <div class="mt-2">
                                                <strong>{{ ucfirst(str_replace('Image', '', $imageType)) }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $user->uid }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $user->uid }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                <!-- Thumbnails with labels -->
                                <div class="mt-3 d-flex justify-content-center gap-4">
                                    @foreach (['businessPermitImage', 'birImage', 'validIdImage'] as $index => $imageType)
                                        @if(!empty($user->$imageType))
                                            <div class="text-center" style="cursor: pointer;">
                                                <img src="{{ route('admin.get-image', ['uid' => $user->uid, 'type' => $imageType]) }}"
                                                    class="img-thumbnail"
                                                    style="height: 75px; width: auto;"
                                                    data-bs-target="#carousel-{{ $user->uid }}"
                                                    data-bs-slide-to="{{ $index }}"
                                                    aria-label="Go to slide {{ $index + 1 }}">
                                                <div style="font-size: 0.85rem; margin-top: 4px;">
                                                    {{ ucfirst(str_replace('Image', '', $imageType)) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal-{{ $user->uid }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.reject-user', $user->uid) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject {{ $user->name ?? 'User' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label for="reason">Reason for rejection:</label>
                                <textarea name="reason" class="form-control" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Send Rejection</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
