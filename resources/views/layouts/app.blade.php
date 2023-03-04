<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Custom fonts for this template-->
    <link href="{{ asset('sb2admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb2admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

    <!--Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">



</head>
<body>

    <div>
        @yield('container')
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sb2admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('sb2admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb2admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sb2admin/js/sb-admin-2.min.js')}}"></script>

    <script>
        function edit_partner(el) {
        var link = $(el) //refer `a` tag which is clicked
        var modal = $("#edit_partner") //your modal
        var tanggal = link.data('tanggal')
        var serialnumber = link.data('serialnumber')
        var device = link.data('device')
        var customer = link.data('customer')
        var telp = link.data('telp')
        var pengiriman = link.data('pengiriman')
        var kelengkapanpengiriman = link.data('kelengkapanpengiriman')
        modal.find('#full_name').val(tanggal);
        modal.find('#code').val(serialnumber);
        modal.find('#code').val(device);
        modal.find('#code').val(customer);
        modal.find('#code').val(telp);
        modal.find('#code').val(pengiriman);
        modal.find('#code').val(kelengkapanpengiriman);
        }
    </script>

</body>
</html>
