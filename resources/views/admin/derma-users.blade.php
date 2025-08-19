@extends('mainapp')

@section('title', 'Derma Users')

@section('content')
    <h2 class="mb-4">Clinic List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#all-users">All Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#not-verified">Not Verified</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pending">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#verified">Verified</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="all-users">
            @include('admin.partials.user-table', ['users' => $allUsers])
        </div>
        <div class="tab-pane fade" id="not-verified">
            @include('admin.partials.user-table', ['users' => $notVerifiedUsers])
        </div>
        <div class="tab-pane fade" id="pending">
            @include('admin.partials.user-table', ['users' => $pendingUsers])
        </div>
        <div class="tab-pane fade" id="verified">
            @include('admin.partials.user-table', ['users' => $verifiedUsers])
        </div>
    </div>
@endsection
