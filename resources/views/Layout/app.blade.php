<html>

<head>
    <title>BiTechX Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="https://bitechx.com/images/favicon/bitechx.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Data Table CSS & JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container" style="max-width: 700px;">
        <h2 class="text-center pt-3">BiTechX Test</h2>
        <hr>
        @if(session()->has('error') && session()->get('error'))
        <div class="mx-auto pt-5">
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        </div>
        @elseif(session()->has('error') && !session()->get('error'))
        <div class="mx-auto pt-5">
            <div class="alert alert-success" role="alert">
                {{ session()->get('message') }}
            </div>
        </div>
        @endif

        @yield('content')

        <hr>
        <div class="text-center pb-5 pt-3">
            Made with <font color="red"><i class="fa fa-heart"></i></font> by <a href="https://facebook.com/rafat.hossain.12">Md. Rafat Hossain</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    @yield('script')
</body>

</html>