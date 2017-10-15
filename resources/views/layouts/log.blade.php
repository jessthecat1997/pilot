<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pilot Cargo Chain</title>

    <!-- Styles -->
    <link rel="icon" href="/images/icon.ico">
    <link href="/css/app.css" rel="stylesheet">
    <link href= "/js/select2/select2.css" rel = "stylesheet">
    <link rel="stylesheet" href="/js/jqueryDatatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="/toaster/toastr.css">
    <link rel="stylesheet" href="/js/jqueryUI/jquery-ui.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/sidebar/css/simple-sidebar.css" rel="stylesheet">

    @stack('styles')

    <!-- Scripts -->

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            ]) !!};
        </script>

    </head>
    <body style="background-image: url('/images/bg.png');">
        <div id="app">
            <nav class="navbar navbar-default navbar-fixed-top" id="navtop">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <!-- <a class="navbar-brand" style="color: #fff;"><img src="/images/pilotlogo.png" id="logo"></a> -->
                    <a class="navbar-brand" style="color: #fff;">Hauling Services Management System</a>
                </div>
            </nav>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="container-fluid" style="opacity: none;">
            <div class="row">
                @yield('content')
            </div>
        </div>


        <!-- Scripts -->
        <script src="/js/app.js"></script>
        <script type="text/javascript" src = "/js/jquery.validate.js"></script>
        <script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>
        <script type="text/javascript" charset="utf8" src="/js/jqueryUI/jquery-ui.js"></script>
        <script  type = "text/javascript" charset = "utf8" src="/js/inputMask/jquery.inputmask.bundle.js"></script>
        <script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>
        <script type = "text/javascript" charset = "utf8" src="/js/Chart.js"></script>

        <script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>


        <script>

            $(document).on('show.bs.modal', '.modal', function () {
                var zIndex = 1040 + (10 * $('.modal:visible').length);
                $(this).css('z-index', zIndex);
                setTimeout(function() {
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                }, 0);
            });
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
            $('.money').inputmask("numeric",
            {
                radixPoint: ".",
                groupSeparator: ",",
                digits: 2,
                autoGroup: true,
                rightAlign: true,
                removeMaskOnSubmit:true,
            });
            function formatNumber(n) {
                var currency = "Php ";
                return currency +  n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }

        </script>
        @stack('scripts')
    </body>
    </html>
