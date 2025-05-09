    @extends('mainapp')

    @section('title', 'Derma Users')

    @section('content')
        <h2 class="mb-4">Derma User List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tabs for filtering users -->
        <ul class="nav nav-tabs" id="userTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="all-users-tab" data-bs-toggle="tab" href="#all-users" role="tab" aria-controls="all-users" aria-selected="true">All Users</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="not-verified-tab" data-bs-toggle="tab" href="#not-verified" role="tab" aria-controls="not-verified" aria-selected="false">Not Verified</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="verified-tab" data-bs-toggle="tab" href="#verified" role="tab" aria-controls="verified" aria-selected="false">Verified</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="userTabsContent">
            <!-- All Users Tab -->
            <div class="tab-pane fade show active" id="all-users" role="tabpanel" aria-labelledby="all-users-tab">
                @include('admin.partials.user-table', ['users' => $allUsers])
            </div>

            <!-- Not Verified Tab -->
            <div class="tab-pane fade" id="not-verified" role="tabpanel" aria-labelledby="not-verified-tab">
                @include('admin.partials.user-table', ['users' => $notVerifiedUsers])
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                @include('admin.partials.user-table', ['users' => $pendingUsers])
            </div>

            <!-- Verified Tab -->
            <div class="tab-pane fade" id="verified" role="tabpanel" aria-labelledby="verified-tab">
                @include('admin.partials.user-table', ['users' => $verifiedUsers])
            </div>
        </div>
    
        
    @endsection
