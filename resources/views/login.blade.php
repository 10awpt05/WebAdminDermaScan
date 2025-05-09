<!DOCTYPE html>
<html>
<head>
    <title>Firebase Login</title>
    <script src="https://www.gstatic.com/firebasejs/10.9.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.9.0/firebase-auth-compat.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4" style="max-width: 400px; margin: auto;">
        <h4 class="text-center">Login</h4>
        <div id="error" class="alert alert-danger d-none"></div>
        <form id="login-form">
            <div class="mb-3">
                <input type="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" id="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<script>
    const firebaseConfig = {
        apiKey: "AIzaSyCp6DYZt1zT-qzdx6SZ5H5D9EZLme5kGE0",
        authDomain: "dermascanai-2d7a1.firebaseapp.com",
        databaseURL: "https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "dermascanai-2d7a1",
        storageBucket: "dermascanai-2d7a1.appspot.com",
        messagingSenderId: "889758966173",
        appId: "1:889758966173:web:e6f0c3372aa55ae1f30f74",
        measurementId: "G-C8RRXYMLLT"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // Login handler
    document.getElementById("login-form").addEventListener("submit", async (e) => {
        e.preventDefault();
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const userCredential = await firebase.auth().signInWithEmailAndPassword(email, password);
            const idToken = await userCredential.user.getIdToken();

            const response = await fetch("/firebase-login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ idToken })
            });

            if (response.ok) {
                window.location.href = "/dashboard";
            } else {
                const data = await response.json();
                showError(data.message || "Login failed.");
            }
        } catch (error) {
            showError(error.message);
        }

        function showError(msg) {
            const errorDiv = document.getElementById("error");
            errorDiv.textContent = msg;
            errorDiv.classList.remove("d-none");
        }
    });
</script>
</body>
</html>
