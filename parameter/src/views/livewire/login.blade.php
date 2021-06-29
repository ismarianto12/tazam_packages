<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <link href="{{ pkg_asset('dash', 'dependencies/bootstrap/css/bootstrap-4.5.0.min.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/Font-Awesome/css/all.css') }}" rel="stylesheet" type="text/css">

    <!-- CSS Libraries -->
    <!-- Template CSS -->
    <!-- <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css"> -->
    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/style.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/components.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'css/custom.css') }}" rel="stylesheet">

    <!-- Additional -->
    <!-- <link href="{{ pkg_asset('dash', 'dependencies/metisMenu/metisMenu.min.css') }}" rel="stylesheet"> -->
    <link href="{{ pkg_asset('dash', 'css/sb-admin-2.css') }}" rel="stylesheet">


    @livewireStyles
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row" style="
                margin-top: -72px;
            ">
                    <div class="col-md-12">
                        <div class="col-md-12 col-md-8 col-lg-4">
                        </div>
                        <div class="col-md-12 col-md-4 col-lg-4">
                            {{ $slot }}
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

    @livewireScripts

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
