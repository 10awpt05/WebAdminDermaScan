<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
     
            <div class="col-12 col-md-4 text-center text-md-start">
                <img src="{{ asset('images/lg_group.png') }}" alt="Logo" class="footer-logo">
            </div>

      
            <div class="col-12 col-md-4 text-center mt-3 mt-md-0">
                <ul class="list-unstyled d-flex justify-content-center">
                    <li class="mx-3"><a href="{{ route('user.udashboard') }}" class="text-light text-decoration-none">Home</a></li>
                    <li class="mx-3"><a href="{{ route('blog.article') }}" class="text-light text-decoration-none">Article</a></li>
                    <li class="mx-3"><a href="{{ route('blog.forum') }}" class="text-light text-decoration-none">Forum</a></li>
                    <li class="mx-3"><a href="{{ route('child.aboutus') }}" class="text-light text-decoration-none">About Us</a></li>
                    <li class="mx-3"><a href="{{ route('child.profile') }}" class="text-light text-decoration-none">Profile</a></li>
                </ul>
            </div>

            <div class="col-12 col-md-4 text-center text-md-end mt-3 mt-md-0">
                <p class="mb-1"><i class="fas fa-envelope"></i> support@example.com</p>
                <p class="mb-0"><i class="fas fa-phone"></i> +1 234 567 890</p>
            </div>
        </div>

  
        <div class="text-center mt-4">
            <a href="https://www.facebook.com" class="text-light mx-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://www.twitter.com" class="text-light mx-2"><i class="fab fa-twitter fa-2x"></i></a>
            <a href="https://www.instagram.com" class="text-light mx-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://www.linkedin.com" class="text-light mx-2"><i class="fab fa-linkedin fa-2x"></i></a>
        </div>

        <div class="text-center mt-3">
            <small>&copy; 2025 JYN. All rights reserved.</small>
        </div>
    </div>
</footer>


<style>
    .footer-logo {
        max-width: 200px; 
    }

    footer i {
        color: #c51919; 
    }

    footer a:hover {
        color: #f8d7da;
    }

.content {
    padding: 20px;
    padding-bottom: 80px; 
    transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
}

</style>


<script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
