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
    <link href= "/js/select2/select2.css" rel = "stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/jqueryDatatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/toaster/toastr.css">
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
                    <a href="Dashboard.html"><img src="/images/dashboard.png">&nbsp;&nbsp;Dashboard</a>
                </li>
                <li>
                    <a data-toggle="collapse" href="#collapse1"><img src="/images/so.png">&nbsp;&nbsp;Transactions</a>
                </li>
                <div id="collapse1" class="pane;-collapse collapse">
                    <ul class="list-group">
                        <li>
                            <a href = "{{ route('brokerage.index') }}" class = "brokerage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/so.png">&nbsp;&nbsp;Brokerage</a>
                        </li>
                        <li>
                            <a href="{{ route('contracts.index') }}" class = "contracts">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/billing.png">&nbsp;&nbsp;Contract</a>
                        </li>
                        <li>
                            <a href="{{ route('trucking.index') }}" class="delivery">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/delivery.png">&nbsp;&nbsp;Delivery</a>
                        </li>
                        <li>
                            <a href="{{ route('view.index') }}" class = "class-billing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/billing.png">&nbsp;&nbsp;Billing</a>
                        </li>
                        <li id ="frstgrp">
                            <a href="{{ route('payment.index') }}" class = "class-payment">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/payment.png">&nbsp;&nbsp;Payments</a>
                        </li>
                    </ul>
                </div>
                <li>
                    <a href="{{ route('shipment.index') }}"><img src="/images/reports.png">&nbsp;&nbsp;Reports</a>
                </li>
                <li>
                    <a href="{{ route('service_ordertype.index') }}" class = "maintenance"><img src="/images/maintenance.png">&nbsp;&nbsp;Maintenance</a>
                </li>
                <li>
                    <a href="{{ route('shipment.index') }}"><img src="/images/reports.png">&nbsp;&nbsp;Queries</a>
                </li>
                <li>
                    <a href="{{ route('sot.utilities_index') }}" class="utilities"><img src="/images/utilities.png">&nbsp;&nbsp;Utilities</a>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <ul class="nav nav-tabs">
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Brokerage <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                       <li><a href="{{ route('service_ordertype.index') }}" class = "class-service-order">Service Order Type</a></li>
                       <li><a href="{{ route('exchange_rate.index') }}" class = "class-exchange-rate">Exchange Rate</a></li>
                       <li><a href="{{ route('brokerage_fee.index') }}">Brokerage Fee</a></li>
                       <li><a href="{{ route('cds_fee.index') }}">Container Delivery System Fee</a></li>
                       <li><a href = "{{ route('ipf_fee.index') }}">Import Processing Fee</a></li>
                   </ul>
               </li>
               <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Delivery <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('area.index') }}">Area</a></li>
                  <li><a href="{{ route('vehicletype.index') }}" class = "class-vehicle-type">Vehicle Type</a></li>
                  <li><a href="{{ route('vehicle.index') }}" class = "class-vehicle">Vehicle</a></li>
                  <li><a href="{{ route('container_type.index') }}" class = "class-container-type">Container Volume</a></li>
              </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Biling <span class="caret"></span></a>
            <ul class="dropdown-menu">
               <li><a href="{{ route('charge.index') }}" class = "class-charge">Charges</a></li>
               <li class="active"><a href="{{ route('billing.index') }}" class="class-billing">Bills </a></li>

           </ul>
       </li>
   </ul>
   <div class="row">
    @yield('content')
</div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>



<!-- Scripts -->
<script src="/js/app.js"></script>
<script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/jqueryValidate/jquery.validate.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/jqueryValidate/additional-methods.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/inputMask/jquery.inputmask.bundle.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>


<script type="text/javascript">

    



    $('.money').inputmask("numeric", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        autoGroup: true,
        rightAlign: true,
        removeMaskOnSubmit:true,



    });

    $('.money_er').inputmask("numeric", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 7,
        autoGroup: true,
        rightAlign: true,


    });


    function formatNumber(n) {
        var currency = "Php ";
        return currency +  n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    function formatNumber_s(n) {
        var currency = "$ ";
        return currency +  n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    function format_container_maxweight(n) {
        var unit = " kgs";
        return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + unit;
    }
    function format_container_size(n) {
        var unit = "-footer";
        return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + unit;
    }




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
