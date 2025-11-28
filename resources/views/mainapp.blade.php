<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Derma Scan AI')</title>
  
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
        background-color: #06923E;
        color: white;
    }
    .sidebar a {
        color: white;
        display: block;
        padding: 10px;
        text-decoration: none;
    }
    .sidebar a:hover {
        background-color: #50D890;
    }
    .user-table td,
    .user-table th {
        text-align: center;
        vertical-align: middle;
    }
    .modal-backdrop {
        opacity: 0.5 !important;
    }
    .modal-stack .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal-stack .modal {
        overflow-y: auto;
    }
  </style>
</head>
<body>
  <!-- 🔔 Ding sound -->
  <audio id="dingSound" src="{{ asset('sounds/ding.mp3') }}" preload="auto"></audio>

  <!-- ✅ Toast -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">New update received!</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <div class="container-fluid p-0 m-0">
    <div class="row g-0">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 sidebar p-0">
        <h4 class="p-3">My Menu</h4>
        <a href="{{ route('users.index') }}">User Table</a>
        <a href="{{ route('admin.derma-users') }}">Clinic User Table</a>
        <a href="{{ route('blog.index') }}">Blog Table</a>
        <a href="{{ route('disease.index') }}">Disease Library</a>
        <a href="{{ route('admin.daily_tips') }}">Daily Tips</a>
        <a href="{{ route('admin.scan-reports') }}">Scan Reports</a>
      </div>

      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 p-3" style="height: 100vh; overflow-y: auto;">
        @section('content')
          <div class="text-center">
            <img src="{{ asset('images/logo_loading.gif') }}" alt="DermaScan Logo" class="img-fluid" style="max-width: 50%; max-height: 50%;">
          </div>
        @show
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
          <!-- Content will be injected -->
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Firebase (Modular v9) -->
  <script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
  import { getDatabase, ref, onChildAdded, onChildChanged } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-database.js";

  const firebaseConfig = {
    apiKey: "AIzaSyCp6DYZt1zT-qzdx6SZ5H5D9EZLme5kGE0",
    authDomain: "dermascan-web-admin.onrender.com",
    databaseURL: "https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "dermascanai-2d7a1",
    storageBucket: "dermascanai-2d7a1.appspot.com",
    messagingSenderId: "889758966173",
    appId: "1:889758966173:web:c1523dc49921e882f30f74",
    measurementId: "G-QBF39K0J8V"
  };

  const app = initializeApp(firebaseConfig);
  const db = getDatabase(app);

  function showNotification(type, uid, data) {
    // 🔔 Ding
    document.getElementById('dingSound').play();

    // Toast message
    document.getElementById('toastMessage').innerText = `New ${type} added! (ID: ${uid})`;
    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
    toast.show();

    // Modal
    const modalBody = document.getElementById('popupModalBody');
    modalBody.innerHTML = `
      <h5 class="text-success">New ${type} Added</h5>
      <p><strong>ID:</strong> ${uid}</p>
      <pre>${JSON.stringify(data, null, 2)}</pre>
    `;
    new bootstrap.Modal(document.getElementById('popupModal')).show();
  }

  function showUpdate(type, uid, data) {
    document.getElementById('toastMessage').innerText = `${type} updated (ID: ${uid})`;
    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
    toast.show();

    const modalBody = document.getElementById('popupModalBody');
    modalBody.innerHTML = `
      <h5 class="text-warning">${type} Updated</h5>
      <p><strong>ID:</strong> ${uid}</p>
      <pre>${JSON.stringify(data, null, 2)}</pre>
    `;
    new bootstrap.Modal(document.getElementById('popupModal')).show();
  }

  // ----------------------------------------------------
  // 🔹 NEW RECORDS (Triggers when a new child is added)
  // ----------------------------------------------------
  onChildAdded(ref(db, "userInfo"), (snapshot) => {
    showNotification("User Info", snapshot.key, snapshot.val());
  });

  onChildAdded(ref(db, "clinicInfo"), (snapshot) => {
    showNotification("Clinic Info", snapshot.key, snapshot.val());
  });

  onChildAdded(ref(db, "scanReports"), (snapshot) => {
    showNotification("Scan Report", snapshot.key, snapshot.val());
  });

  // ----------------------------------------------------
  // 🔹 EXISTING RECORDS UPDATED (Optional)
  // ----------------------------------------------------
  onChildChanged(ref(db, "userInfo"), (snapshot) => {
    showUpdate("User Info", snapshot.key, snapshot.val());
  });

  onChildChanged(ref(db, "clinicInfo"), (snapshot) => {
    showUpdate("Clinic Info", snapshot.key, snapshot.val());
  });

  onChildChanged(ref(db, "scanReports"), (snapshot) => {
    showUpdate("Scan Report", snapshot.key, snapshot.val());
  });
</script>

</body>
</html>
