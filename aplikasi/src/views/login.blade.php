<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <link href="{{ pkg_asset('dash', 'dependencies/bootstrap/css/bootstrap-4.5.0.min.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/Font-Awesome/css/all.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/style.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/components.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'css/custom.css') }}" rel="stylesheet">

    <!-- Additional -->
    <!-- <link href="{{ pkg_asset('dash', 'dependencies/metisMenu/metisMenu.min.css') }}" rel="stylesheet"> -->
    <link href="{{ pkg_asset('dash', 'css/sb-admin-2.css') }}" rel="stylesheet">
</head>

<body style="
background: url('https://disk.mediaindonesia.com/thumbs/1800x1200/news/2019/10/ed378f7b2218592bc293825899394c3f.jpg');
background-size: cover;
">
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">


                            <div class="card card-primary">


                                <div class="card-body">
                                    <div class="login-brand">
                                        <img src="https://apps.paninbanksyariah.co.id/cms/templates/images/logo_pbs.png"
                                            alt="logo" width="200">
                                    </div>
                                    <form action="{{ route('actionlogin') }}" method="POST" class="needs-validation"
                                        novalidate="">
                                        <div class="form-group">
                                            <label for="email">Username</label>
                                            <input id="email" type="email"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" tabindex="1">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    Username harus di isi
                                                </div>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="password" class="control-label">Password</label>
                                                <div class="float-right">
                                                    <a href="auth-forgot-password.html" class="text-small">
                                                        Forgot Password?
                                                    </a>
                                                </div>
                                            </div>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" tabindex="1">
                                            @error('password') <div class="invalid-feedback">
                                                    password harus di isi
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="remember" class="custom-control-input"
                                                    tabindex="3" id="remember-me">
                                                <label class="custom-control-label" for="remember-me">Remember
                                                    Me</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                    @if (Session::has('message'))
                                        {!! session('message') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2 class="section-title" style="color: #ffff">Aplikasi Tabungan ZAM - ZAM
                                {{ date('Y') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('template/stisla') }}/assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('template/stisla') }}/assets/js/scripts.js"></script>
    <script src="{{ asset('template/stisla') }}/assets/js/custom.js"></script>


    <!-- Page Specific JS File -->
</body>

</html>
