<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v3.8.5">
	<title>{{ env('APP_NAME') }} Login</title>


	<!-- Bootstrap core CSS -->
	<link href="{{ pkg_asset('dash', 'dependencies/bootstrap/css/bootstrap-4.5.0.min.css') }}" rel="stylesheet" crossorigin="anonymous">


	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
	<!-- Custom styles for this template -->
	<link href="{{ pkg_asset('dash', 'dependencies/bootstrap/components/floating-labels.css') }}" rel="stylesheet">
</head>

<body>
	<form class="form-signin" action="{{ route('dash.login') }}" method="POST">
		@csrf
		<div class="text-center mb-4">
			<img class="mb-4" src="{{ pkg_asset('isms', 'images/logo_isms.png') }}" alt=""
				width="auto" height="52">
			<!-- <h1 class="h3 mb-3 font-weight-normal">ISMS Login</h1> -->
			<p>
				Masukkan Email dan Password anda untuk login
			</p>
			@include('dash::components.messages')
		</div>

		<div class="form-label-group">
			<input type="text" name="email" id="email" class="form-control" placeholder="Username / Email address" required autofocus>
			<label for="email">Username / Email address</label>
		</div>

		<div class="form-label-group">
			<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
			<label for="password">Password</label>
		</div>

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" name="remember" value="remember-me"> Remember me
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2019</p>
	</form>
</body>

</html>