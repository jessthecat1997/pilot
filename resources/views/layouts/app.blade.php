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

    <link rel="stylesheet" href="/js/jqueryDatatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/toaster/toastr.css">
    <link rel="stylesheet" href="/js/jqueryUI/jquery-ui.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
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
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-fixed-top" id="navtop">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" id="menu-toggle" href="#menu-toggle">
                        <img src="/images/burger.png">
                    </a>
                    <a class="navbar-brand" style="color: #fff;">
                        Hauling Services Management System
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ url('/login') }}" id="useracc">Login</a></li>
                        <li><a href="{{ url('/register') }}" id="useracc">Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <div id="wrapper" id="sidebar">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" id="sidebrand">
                    <a href="#">
                        <img src="/images/pilotlogo.png" id="logo">
                    </a>
                </li>
                <li>
                    <a href="Dashboard.html">&nbsp;&nbsp;Dashboard</a>
                </li>
                <li>
                    <a data-toggle="collapse" href="#collapse1">&nbsp;&nbsp;Transactions</a>
                </li>
                <div id="collapse1" class="pane;-collapse collapse">
                    <ul class="list-group">
                        <li>
<<<<<<< Updated upstream
                            <a href = "{{ route('brokerage.index') }}"  class = "brokerage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/so.png">&nbsp;&nbsp;Brokerage</a>
=======
                            <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Brokerage</a>
>>>>>>> Stashed changes
                        </li>
                        <li>
                            <a href="{{ route('contracts.index') }}" class = "contracts">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contract</a>
                        </li>
                        <li>
                            <a href="{{ route('trucking.index') }}" class="delivery">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delivery</a>
                        </li>
                        <li id ="frstgrp">
                            <a href="{{ route('payment.index') }}" class = "class-payment">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payments</a>
                        </li>
                    </ul>
                </div>
                <li>
                    <a href="{{ route('shipment.index') }}">&nbsp;&nbsp;Reports</a>
                </li>
                <li>
                    <a href="{{ route('service_ordertype.index') }}" class = "maintenance">&nbsp;&nbsp;Maintenance</a>
                </li>
                <li>
                    <a href="{{ route('shipment.index') }}">&nbsp;&nbsp;Queries</a>
                </li>
                <li>
                    <a href="{{ route('utilities.index') }}" class="utilities">&nbsp;&nbsp;Utilities</a>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>



    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script type="text/javascript" src = "/js/jquery.validate.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jqueryUI/jquery-ui.js"></script>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        $(document).on('show.bs.modal', '.modal', function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
    </script>
    @stack('scripts')
</body>
</html>
