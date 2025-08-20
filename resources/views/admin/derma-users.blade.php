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

 <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-analytics.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCp6DYZt1zT-qzdx6SZ5H5D9EZLme5kGE0",
            authDomain: "dermascan-web-admin.onrender.com",
            databaseURL: "https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "dermascanai-2d7a1",
            storageBucket: "dermascanai-2d7a1.firebasestorage.app",
            messagingSenderId: "889758966173",
            appId: "1:889758966173:web:c1523dc49921e882f30f74",
            measurementId: "G-QBF39K0J8V"
        };

        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
    </script>
@endsection
