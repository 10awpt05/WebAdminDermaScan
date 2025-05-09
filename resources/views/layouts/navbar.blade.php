<nav class="navbar navbar-expand-lg fixed-top custom-navbar">
    <div class="container">
      
       
        <a class="navbar-brand" href="{{ route('mainapp') }}"><b>
        
                @yield('navtitle', 'Welcome Admin')
       
        </b></a>

    
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link custom-link" href="/">Home</a></li>
            
                
            </ul>

            
            <ul class="navbar-nav">
                @if(Auth::check())
                <li class="nav-item">
                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Logout
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link text-danger custom-link" href="{{ route('login') }}">
                        Login
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
