<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'default_title')</title>
  
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
    </style>

</head>
<body>

    <div class="container-fluid p-0 m-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <h4 class="p-3">My Menu</h4>
                <a href="{{ route('users.index') }}">User Table</a>
                <a href="{{ route('admin.derma-users') }}">Derma Table</a>
                <a href="{{ route('blog.index') }}">Blog Table</a>
                <a href="{{ route('disease.index') }}">Disease Library</a>
            </div>
    
            <!-- Main Content (scrollable) -->
            <div class="col-md-9 col-lg-10 p-3" style="height: 100vh; overflow-y: auto;">
                @yield('content')
            </div>
        </div>
    </div>
    

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255,255,255,0.8); z-index:9999; text-align:center;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-3 fw-bold">Please wait...</p>
    </div>
</div>

<!-- Global Popup Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="popupModalLabel">Detail View</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center" id="popupModalBody">
          <!-- Content will be injected here -->
        </div>
      </div>
    </div>
</div>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.clickable-cell').forEach(cell => {
            cell.addEventListener('click', function () {
                const content = this.getAttribute('data-content');
                const isImage = this.getAttribute('data-type') === 'image';

                const modalBody = document.getElementById('popupModalBody');
                modalBody.innerHTML = isImage
                    ? `<img src="${content}" class="img-fluid rounded">`
                    : `<p class="fs-5">${content}</p>`;

                const modal = new bootstrap.Modal(document.getElementById('popupModal'));
                modal.show();
            });
        });

        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function () {
                document.getElementById('loadingOverlay').style.display = 'block';
            });
        });
    });
</script>

</body>
</html>
