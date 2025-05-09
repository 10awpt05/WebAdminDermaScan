<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white sidebar">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
        {{-- <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;"> --}}
        <span class="mt-5 fs-5 fw-bold">Article</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#page1" class="nav-link">
                <i class="bi bi-newspaper"></i> News & Resources
            </a>
        </li>
        {{-- <li>
            <a href="#page2" class="nav-link"> 
                <i class="bi bi-file-text"></i> Article
            </a>
        </li> --}}
        <li>
            <a href="#page2" class="nav-link">
                <i class="bi bi-exclamation-triangle"></i> Types of Discrimination
            </a>
        </li>
        <li>
            <a href="#page3" class="nav-link">
                <i class="bi bi-question-circle"></i> Questions
            </a>
        </li>
            
    </ul>
    <hr>
    {{-- <a href="#" class="btn btn-danger w-100">Logout</a> --}}
</div>

<style>
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        background-color: #343a40;
    }

    .nav-link {
        color: white;
        transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: red;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
