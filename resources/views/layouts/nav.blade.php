<nav class="navbar navbar-expand navbar-fixed-top navbar-dark bg-dark shadow">
    <div class="container">
    <div class="collapse navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="/products">Produkte</a></li>
            <li class="nav-item"><a class="nav-link" href="/about">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="/service">Service</a></li>
        </ul>
    </div>
    <div class="collapse navbar-collapse">

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item">
                <form action="/admin/search" method="post">
                    @csrf
                    <div class="input-group">
                    <input name="search" id="search" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />&nbsp;
                    {{-- <button type="button" class="btn btn-outline-primary">search</button> --}}
                    <input type="submit" class="btn btn-outline-primary" value="Suchen">
                    </div>
                </form>
            </li>
            <li class="nav-item"><a class="nav-link" href="/admin">Administration</a></li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            @else
            <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
            @endauth
        </ul>
    </div>
    </div>
</nav>