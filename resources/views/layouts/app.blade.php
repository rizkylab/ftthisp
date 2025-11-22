<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="FTTH ISP Management System">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<title>@yield('title', 'FTTH GIS System')</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
        }
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        .sidebar {
            min-width: 260px;
            max-width: 260px;
            background: #222e3c;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar-content {
            padding: 1rem;
        }
        .sidebar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 1rem;
            text-align: center;
        }
        .sidebar-nav {
            list-style: none;
            padding: 0;
        }
        .sidebar-item {
            margin-bottom: 0.25rem;
        }
        .sidebar-link {
            display: block;
            padding: 0.625rem 1.625rem;
            color: rgba(233, 236, 239, 0.5);
            text-decoration: none;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            border-left-color: #3b7ddd;
        }
        .main {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            padding: 2rem;
            flex: 1;
        }
        .card {
            box-shadow: 0 0 .875rem 0 rgba(33, 37, 41, .05);
            border: 0;
            margin-bottom: 24px;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 0 2rem 0 rgba(33, 37, 41, .1);
        }
    </style>
    @stack('styles')
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="/">
                    <span class="align-middle">FTTH GIS</span>
                </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>

					<li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
					</li>

					<li class="sidebar-item {{ request()->routeIs('map.index') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('map.index') }}">
                            <i class="align-middle" data-feather="map"></i> <span class="align-middle">GIS Map</span>
                        </a>
					</li>

                    <li class="sidebar-header">
						Network
					</li>

					<li class="sidebar-item {{ request()->routeIs('olts.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('olts.index') }}">
                            <i class="align-middle" data-feather="server"></i> <span class="align-middle">OLTs</span>
                        </a>
					</li>

					<li class="sidebar-item {{ request()->routeIs('odps.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('odps.index') }}">
                            <i class="align-middle" data-feather="box"></i> <span class="align-middle">ODPs</span>
                        </a>
					</li>

                    <li class="sidebar-item {{ request()->routeIs('fiber_cables.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('fiber_cables.index') }}">
                            <i class="align-middle" data-feather="activity"></i> <span class="align-middle">Fiber Cables</span>
                        </a>
					</li>

                    <li class="sidebar-header">
						Operations
					</li>

                    <li class="sidebar-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('customers.index') }}">
                            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Customers</span>
                        </a>
					</li>

                    <li class="sidebar-item {{ request()->routeIs('fault_logs.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('fault_logs.index') }}">
                            <i class="align-middle" data-feather="alert-triangle"></i> <span class="align-middle">Fault Logs</span>
                        </a>
					</li>

                    <li class="sidebar-header">
						Admin
					</li>

                    <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('users.index') }}">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                        </a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align ms-auto">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark">{{ Auth::user()->name ?? 'User' }}</span>
                            </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#">Profile</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log out</a>
                                </form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

					@yield('content')

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="#" target="_blank"><strong>FTTH GIS</strong></a> &copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>

</html>
