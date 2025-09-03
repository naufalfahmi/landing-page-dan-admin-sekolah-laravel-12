<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>@yield('title', 'Admin Dashboard') - Portal Islam</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{ asset('template/assets/vendors/core/core.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	@stack('plugin-css')
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('template/assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('template/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="{{ asset('template/assets/css/demo1/style.css') }}">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.png') }}" />
</head>
@php
    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
    $routeClass = str_replace(['.', ':'], ['-', '-'], $routeName ?? '');
    $extraClass = $routeName === 'admin.articles.create' ? ' createArticle' : '';
@endphp
<body class="{{ $routeClass }}{{ $extraClass }}">
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
		<nav class="sidebar">
			<div class="sidebar-header">
				<a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
					Portal<span>Islam</span>
				</a>
				<div class="sidebar-toggler not-active">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
			<div class="sidebar-body">
				<ul class="nav">
					<li class="nav-item nav-category">Main</li>
					<li class="nav-item">
						<a href="{{ route('admin.dashboard') }}" class="nav-link">
							<i class="link-icon" data-feather="box"></i>
							<span class="link-title">Dashboard</span>
						</a>
					</li>
					@php $isAuthorOnly = auth()->check() && \App\Models\Author::where('email', auth()->user()->email)->exists(); @endphp
					<li class="nav-item nav-category">Content Management</li>
					<li class="nav-item">
						@php $articlesOpen = request()->routeIs('admin.articles.*'); @endphp
						<a class="nav-link" data-bs-toggle="collapse" href="#articles" role="button" aria-expanded="{{ $articlesOpen ? 'true' : 'false' }}" aria-controls="articles">
							<i class="link-icon" data-feather="book"></i>
							<span class="link-title">Artikel</span>
							<i class="link-arrow" data-feather="chevron-down"></i>
						</a>
						<div class="collapse {{ $articlesOpen ? 'show' : '' }}" id="articles">
							<ul class="nav sub-menu">
								<li class="nav-item">
									<a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.index') ? 'active' : '' }}">Daftar Artikel</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.articles.create') }}" class="nav-link {{ request()->routeIs('admin.articles.create') ? 'active' : '' }}">Tambah Artikel</a>
								</li>
							</ul>
						</div>
					</li>
					@php
						$isAuthor = Auth::user()->email === 'author@example.com'; // Replace with your actual author email
					@endphp
					@if (!$isAuthor)
					@if(!$isAuthorOnly)
					<li class="nav-item">
						@php $categoriesOpen = request()->routeIs('admin.categories.*'); @endphp
						<a class="nav-link" data-bs-toggle="collapse" href="#categories" role="button" aria-expanded="{{ $categoriesOpen ? 'true' : 'false' }}" aria-controls="categories">
							<i class="link-icon" data-feather="tag"></i>
							<span class="link-title">Kategori</span>
							<i class="link-arrow" data-feather="chevron-down"></i>
						</a>
						<div class="collapse {{ $categoriesOpen ? 'show' : '' }}" id="categories">
							<ul class="nav sub-menu">
								<li class="nav-item">
									<a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">Daftar Kategori</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.categories.create') }}" class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">Tambah Kategori</a>
								</li>
							</ul>
						</div>
					</li>
					<li class="nav-item">
						@php $authorsOpen = request()->routeIs('admin.authors.*'); @endphp
						<a class="nav-link" data-bs-toggle="collapse" href="#authors" role="button" aria-expanded="{{ $authorsOpen ? 'true' : 'false' }}" aria-controls="authors">
							<i class="link-icon" data-feather="user"></i>
							<span class="link-title">Penulis</span>
							<i class="link-arrow" data-feather="chevron-down"></i>
						</a>
						<div class="collapse {{ $authorsOpen ? 'show' : '' }}" id="authors">
							<ul class="nav sub-menu">
								<li class="nav-item">
									<a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.index') ? 'active' : '' }}">Daftar Penulis</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.authors.create') }}" class="nav-link {{ request()->routeIs('admin.authors.create') ? 'active' : '' }}">Tambah Penulis</a>
								</li>
							</ul>
						</div>
					</li>
					@endif
					@endif
					<li class="nav-item">
						<a href="{{ route('admin.shortlinks.index') }}" class="nav-link">
							<i class="link-icon" data-feather="link"></i>
							<span class="link-title">Shortlink</span>
						</a>
					</li>
					<li class="nav-item nav-category">Settings</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="settings">
							<i class="link-icon" data-feather="settings"></i>
							<span class="link-title">Pengaturan</span>
							<i class="link-arrow" data-feather="chevron-down"></i>
						</a>
						<div class="collapse" id="settings">
							<ul class="nav sub-menu">
								<li class="nav-item">
									<a href="{{ route('profile.edit') }}" class="nav-link">Profil</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.settings.index') }}" class="nav-link">SEO & Website</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!-- partial -->

		<div class="page-wrapper">
			<!-- partial:partials/_navbar.html -->
			<nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form">
						<div class="input-group">
							<div class="input-group-text">
								<i data-feather="search"></i>
							</div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							@php
								$name = Auth::user()->name ?? 'User';
								$parts = preg_split('/\s+/', trim($name));
								$initials = '';
								foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
							@endphp
							<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: .9rem; font-weight: bold;">
									{{ $initials }}
								</div>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
								<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
									<div class="mb-3">
										<div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 2rem; font-weight: bold;">
											{{ $initials }}
										</div>
									</div>
									<div class="text-center">
										<p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
										<p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
									</div>
								</div>
								<ul class="list-unstyled p-1">
									<li class="dropdown-item py-2">
										<a href="{{ route('profile.edit') }}" class="text-body ms-0">
											<i class="me-2 icon-md" data-feather="user"></i>
											<span>Profile</span>
										</a>
									</li>
									<li class="dropdown-item py-2">
										<a href="#" class="text-body ms-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											<i class="me-2 icon-md" data-feather="log-out"></i>
											<span>Log Out</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<!-- partial -->

			<div class="page-content">
				@if (session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<i data-feather="check-circle" class="me-2"></i>
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				@if (session('error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i data-feather="alert-triangle" class="me-2"></i>
						{{ session('error') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				@if (session('status'))
					<div class="alert alert-info alert-dismissible fade show" role="alert">
						<i data-feather="info" class="me-2"></i>
						{{ session('status') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				@yield('content')
			</div>

			<!-- partial:partials/_footer.html -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
				<p class="text-muted mb-1 mb-md-0">Copyright © 2025 <a href="{{ route('home') }}" target="_blank">Portal Islam</a>.</p>
				<p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
			</footer>
			<!-- partial -->

		</div>
	</div>

	<!-- core:js -->
	<script src="{{ asset('template/assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	@stack('plugin-js')
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{ asset('template/assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('template/assets/js/template.js') }}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	@stack('custom-js')
	<!-- End custom js for this page -->

	<!-- Logout Form -->
	<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
		@csrf
	</form>

</body>
</html>
