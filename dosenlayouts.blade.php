<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Hilangkan favicon -->
    <link rel="icon" href="data:,">

    <meta name="language" content="en-EN" />
    <meta name="keywords"
        content="bootstrap, bootstrap 4, bootstrap 4 template, bootstrap 4 admin, bootstrap 4 dashboard" />
    <meta name="description" content="@yield('description','Admin dashboard')" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap CSS (CDN) -->
    <link rel=" stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Lokal CSS -->
    <link rel="stylesheet" href="{{ asset('dist/main.css') }}">
    <style>
        .sidebar {
    position: fixed;
    top: 0;
    padding-top: 77px;
    left: 0;
    height: 100vh; /* tinggi layar penuh */
    width: 200px;  /* sesuaikan dengan layout */
    overflow-y: auto;
}
header.navbar {
    position: fixed; /* tetap di atas */
    top: 0;
    left: 0;
    width: 100%;
    height: 70px;   /* tinggi header */
    z-index: 1030;  /* pastikan di atas konten */
}
.footer {
    position: relative; /* tetap mengikuti flow halaman */
    z-index: 1050;      /* layer paling atas dibanding elemen lain */
}
.main-content {
    padding-top: 77px !important;
    margin-left: 190px !important;

}


    </style>
    @stack('head')
</head>

<body>

    <header class="navbar navbar-expand sticky-top bg-primary navbar-dark flex-column flex-md-row bd-navbar">
        <a class="navbar-brand mr-0 mr-md-2" href="{{ url('/') }}">
            <img class="navbar-brand--img img-thumbnail" src="" alt="" title="">
            {{ config('app.name','Dashboard') }}
        </a>

        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
           <li class="nav-item">
    <a class="nav-link p-3" id="liveClock">
        --
    </a>
</li>


            <li class="nav-item dropdown">
                <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
  @php
    $user = Auth::user();
    $profile = $user->profile;
@endphp


    @if($profile && $profile->foto_profil)
        <img src="{{ asset('storage/' . $profile->foto_profil) }}" 
             alt="Profile" 
             class="rounded-circle me-2" 
             width="40" height="40"
             style="object-fit: cover;">
    @else
       <span class="mr-2"><i class="fa fa-user-circle fa-2x text-secondary"></i></span>
    @endif

                  
                    @auth {{ Auth::user()->nama_user }} @else Guest @endauth
                  
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                    
                    @auth
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off pr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                    @else
                    <a class="dropdown-item" href="{{ route('login') }}">
                        <i class="fa fa-sign-in pr-2"></i> Login
                    </a>
                    @endauth
                </div>
            </li>

        </ul>

    </header>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h6 class="sidebar-heading"><span>Main Navigation</span></h6>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('dashboard')) active @endif"
                                href="{{ route('dashboard') }}">
                                <i class="fa fa-tachometer"></i> Dashboard
                                <span class="badge badge-primary">{{ $dashboardCount ?? '' }}</span>
                            </a>
                        </li>
                    <li class="nav-item">
    <a class="nav-link " href="{{ route('jadwal.index') }}">
        <i class="fa fa-calendar"></i><span> Jadwal Saya</span>
    </a>
</li>

                       <li class="nav-item">
    <a class="nav-link" href="{{ route('pengingat.index') }}">
        <i class="fa fa-bell"></i> Pengingat
    </a>
</li>

                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item has-child">
                            <a class="nav-link" href="{{ route('profile.view') }}">
                                <i class="fa fa-user-o"></i> Profile
                                </i>
                            </a>
                           
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <i class="fa fa-cog"></i> Settings</a>
                        </li>
                    </ul>
                </div>
            </aside>

            <main class="main-content col-md-10 ml-sm-auto col-lg-10 pt-3 px-4">
                @yield('content')
            </main>
        </div>
    </div>


    <!-- Scripts: jQuery, Popper, Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>

    <!-- Lokal JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    document.getElementById('liveClock').innerHTML = `
        <i class="fa fa-clock-o mr-1"></i> ${timeString}
    `;
}

setInterval(updateClock, 1000);
updateClock(); // first run
</script>


    @stack('scripts')
</body>

</html>