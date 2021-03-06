<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hauling Services</title>

    <!-- Styles -->
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
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-fixed-top" id="navtop">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand toggled" id="menu-toggle" href="#menu-toggle">
                        <img src="/images/burger.png">
                    </a>
                    <!-- <a class="navbar-brand" style="color: #fff;"><img src="/images/pilotlogo.png" id="logo"></a> -->
                    <a class="navbar-brand" style="color: #fff;">Hauling Services Management System</a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li>
                            <form name="clockForm" style="margin-top: 15px;">
                                <input type="button" name="clockButton" style="background-color: transparent; border-style: none;" />
                            </form>
                        </li>
                        @if (Auth::guest())
                        <li><a href="{{ url('/login') }}" id="useracc">Login</a></li>
                        <li><a href="{{ url('/register') }}" id="useracc">Register</a></li>
                        @else
                        <li>
                            <a href="
                            #">&nbsp;</a>
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
                <!-- <li class="sidebar-brand" id="sidebrand">
                    <a href="#">
                        <img src="/images/pilotlogo.png" id="logo">
                    </a>
                </li> -->
                <li  style="height: 60px; border-bottom: 1px solid #8ffdcc; padding-top: 15px; padding-left: -20px; color: #fff;">
                    @if( Auth::user()->role_id == 1 )Admin<i class="fa fa-check-circle"></i>
                    @elseif( Auth::user()->role_id == 2 ){{ Auth::user()->name }} | Broker<i class="fa fa-check-circle"></i>
                    @elseif( Auth::user()->role_id == 3 ){{ Auth::user()->name }} | Trucking Manager<i class="fa fa-check-circle"></i>
                    @elseif( Auth::user()->role_id == 4 ){{ Auth::user()->name }} | Billing Manager<i class="fa fa-check-circle"></i>
                    @else{{ Auth::user()->name }}<i class="fa fa-check-circle"></i>
                    @endif
                </li>
                <li>
                    <a href="{{ route('dashboard.index') }}" class="dashboard"><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Dashboard</a>
                </li>
                <li>
                    <a data-toggle="collapse" href="#collapse1"><i class="fa fa-exchange"></i>&nbsp;&nbsp;Transactions</a>
                </li>
                <div id="collapse1" class="pane;-collapse collapse">
                    <ul class="list-group" style="list-style-type: circle;">
                        <li>
                            <a href = "{{ route('consignee.index') }}"  class = "consignee"><i class="fa fa-user"></i>&nbsp;&nbsp;Consignee</a>
                        </li>
                        <li>
                            <a href = "{{ route('orders.index') }}"  class = "order"><i class="fa fa-server"></i>&nbsp;&nbsp;Order</a>
                        </li>
                        <li>
                            <a href = "{{ route('brokerage.index') }}"  class = "brokerage"><i class="fa fa-table"></i>&nbsp;&nbsp;Brokerage</a>
                        </li>
                    </ul>
                </div>
                <li>
                    <a data-toggle="collapse" href="#collapse2" class="maintenance"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Maintenance</a>
                </li>
                <div id="collapse2" class="panel-collapse collapse">
                    <ul class="list-group" style="list-style-type: circle;">
                        <li>
                            <a href = "{{ route('container_type.index') }}"  class = "class-container-type"><i class="fa fa-circle"></i>&nbsp;&nbsp;Container Size</a>
                        </li>
                        <li>
                            <a href = "{{ route('location_province.index') }}"  class = "class-province"><i class="fa fa-circle"></i>&nbsp;&nbsp;Province</a>
                        </li>
                        <li>
                            <a href = "{{ route('location_city.index') }}"  class = "class-city"><i class="fa fa-circle"></i>&nbsp;&nbsp;City</a>
                        </li>
                        <li>
                            <a href = "{{ route('location.index') }}"  class = "location"><i class="fa fa-circle"></i>&nbsp;&nbsp;Location</a>
                        </li>
                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#brokeragecollapse" ><i class="fa fa-circle"></i>&nbsp;&nbsp;Brokerage</a>
                        </li>
                        <div id="brokeragecollapse" class="panel-collapse collapse">
                          <li>
                              <a href = "{{ route('dangerous_cargo_type.index') }}"  class = "class-dc-type">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Dangerous Cargo Types</a>

                          </li>
                          <li>
                            <a href = "{{ route('lcl_type.index') }}"  class = "class-lcl-type">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Less Cargo Load Types</a>
                        </li>
                        <li>
                            <a href = "{{ route('basis_type.index') }}"  class = "class-basis-type">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Basis Types</a>
                        </li>
                            
                            <li>
                                <a href = "{{ route('section.index') }}"  class = "class-section">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Section</a>
                            </li>
                            <li>
                                <a href = "{{ route('category.index') }}"  class = "class-category">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Category</a>
                            </li>
                            <li>
                                <a href = "{{ route('item.index') }}"  class = "class-item">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Item</a>
                            </li>
                            <li>
                                <a href = "{{ route('cds_fee.index') }}"  class = "class-cds-fee">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;CDS Fee</a>
                            </li>
                            <li>
                                <a href = "{{ route('exchange_rate.index') }}"  class = "class-exchange-rate">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Exchange Rate</a>
                            </li>
                            <li>
                                <a href = "{{ route('ipf_fee.index') }}"  class = "class-ipf-fee">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Import Processing Fee</a>
                            </li>
                            <li>
                                <a href = "{{ route('brokerage_fee.index') }}"  class = "class-brokerage-fee">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Brokerage Fee</a>
                            </li>
                            <li>
                                <a data-toggle="collapse" class="maintenance-group" href = "#arrastrecollapse" >&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Arrastre Fee</a>
                            </li>
                            <div id = "arrastrecollapse" class="panel-collapse collapse" >
                                <li>
                                    <a href = "{{ route('arrastre_fee.index') }}"  class = "class-af-fee">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>&nbsp;&nbsp;Containerized</a>
                                </li>
                            <!-- <li>
                                <a href = "{{ route('arrastre_fee_dc.index') }}"  class = "class-arrastre-dc"><i class="fa fa-circle"></i>&nbsp;&nbsp;Containerized Dangerous Cargo Arrastre</a>
                            </li> -->
                            <li>
                                <a href = "{{ route('arrastre_fee_lcl.index') }}"  class = "class-af-fee-lcl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>&nbsp;&nbsp;Less Cargo Load</a>
                            </li>
                        </div>
                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#wharfagecollapse" >&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Wharfage Fee</a>
                        </li>
                        <div id = "wharfagecollapse" class="panel-collapse collapse">
                            <li>
                                <a href = "{{ route('wharfage_fee.index') }}"  class = "class-wf-fee">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>&nbsp;&nbsp;Containerized</a>
                            </li>
                            <li>
                                <a href = "{{ route('wharfage_fee_lcl.index') }}"  class = "class-wf-fee-lcl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>&nbsp;&nbsp;Less Cargo Load</a>
                            </li>
                        </div>
                    </div>
                    <li>
                        <a data-toggle="collapse" class="maintenance-group" href = "#deliverycollapse"><i class="fa fa-circle"></i>&nbsp;&nbsp;Delivery</a>
                    </li>
                    <div id="deliverycollapse" class="panel-collapse collapse">

                        <li>
                            <a href = "{{ route('standard_arearates.index') }}"  class = "class-area-rates">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Area Rates </a>
                        </li>
                        <li>
                            <a href = "{{ route('vehicletype.index') }}"  class = "class-vehicle-type">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Vehicle Type</a>
                        </li>
                        <li>
                            <a href = "{{ route('vehicle.index') }}"  class = "class-vehicle">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Vehicle</a>
                        </li>

                    </div>
                    <li>
                        <a data-toggle="collapse" class="maintenance-group" href = "#billingcollapse"><i class="fa fa-circle" ></i>&nbsp;&nbsp;Billing</a>
                    </li>
                    <div id="billingcollapse" class="panel-collapse collapse">

                        <li>
                            <a href = "{{ route('charge.index') }}"  class = "class-charges">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Charges</a>
                        </li>
                    </div>

                </ul>
            </div>
            <li>
                <a href="{{ route('queries.index') }}"><i class="fa fa-list"></i>&nbsp;&nbsp;Queries</a>
            </li>
            <li>
                <a data-toggle="collapse" href="#collapse3" class="class-reports"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Reports</a>
            </li>
            <div id="collapse3" class="panel-collapse collapse">
                <ul class="list-group" style="list-style-type: circle;">
                    <li>
                        <a href = "{{ route('shipment.index') }}"  class = "class-shipment"><i class="fa fa-circle"></i>&nbsp;&nbsp;Shipment Report</a>
                    </li>
                    <li>
                        <a href = "{{ route('delivery.index') }}"  class = "class-del_rep"><i class="fa fa-circle"></i>&nbsp;&nbsp;Delivery Report</a>
                    </li>
                    <li>
                        <a href = "{{ route('billing_rep.index') }}"  class = "class-bill_rep"><i class="fa fa-circle"></i>&nbsp;&nbsp;Unpaid Billing Report</a>
                    </li>
                </ul>
            </div>
            <li>
                <a data-toggle="collapse" href="#collapse4" class="utilities"><i class="fa fa-gear"></i>&nbsp;&nbsp;Utilities</a>
            </li>
            <div id="collapse4" class ="panel-collapse collapse">
                <ul class="list-group" style="list-style-type: circle;">
                    <li>
                        <a href = "{{ route('settings.index') }}"  class = "class-utility-fee"><i class="fa fa-circle"></i>&nbsp;&nbsp;Settings</a>
                    </li>
                    <li>
                        <a data-toggle="collapse" class="maintenance-group" href = "#templatescollapse"><i class="fa fa-circle"></i>&nbsp;&nbsp;Templates</a>
                    </li>
                    <div id="templatescollapse" class="panel-collapse collapse">
                        <li>
                            <a href = "{{ route('contract_template.index') }}"  class = "class-contract-template">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Contract Agreements</a>
                        </li>
                        <li>
                            <a href = "{{ route('quotation_template.index') }}"  class = "class-quotation-template">&nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Quotation Terms</a>
                        </li>
                    </div>
                    <li>
                        <a data-toggle="collapse" class="maintenance-group" href = "#employeecollapse"><i class="fa fa-circle"></i>&nbsp;&nbsp;Employee</a>
                    </li>
                    <div id="employeecollapse" class="panel-collapse collapse">
                        <li>
                            <a href = "{{ route('employee_type.index') }}"  class = "class-vat-rate"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;Employee Type</a>
                        </li>
                        <li>
                            <a href = "{{ route('employee.index') }}"  class = "class-charges"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;Employee</a>
                        </li>
                    </div>
                    <li>
                        <a data-toggle="collapse" class="maintenance-group" href = "#archivecollapse"><i class="fa fa-circle"></i>&nbsp;&nbsp;Archive</a>
                    </li>
                    <div id="archivecollapse" class="panel-collapse collapse">

                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#archive_brokeragecollapse"><i></i>&nbsp;&nbsp;Brokerage</a>
                        </li>
                        <div id="archive_brokeragecollapse" class="panel-collapse collapse">

                            <li>
                                <a href = "{{ route('cds_fee.utilities_index') }}"  class = "class-cds-fee"><i class="fa fa-circle"></i>&nbsp;&nbsp;CDS Fee</a>
                            </li>
                            <li>
                                <a href = "{{ route('exchange_rate.utilities_index') }}"  class = "class-exchange-rate"><i class="fa fa-circle"></i>&nbsp;&nbsp;Exchange Rate</a>
                            </li>
                            <li>
                                <a href = "{{ route('ipf_fee.utilities_index') }}"  class = "class-ipf-fee"><i class="fa fa-circle"></i>&nbsp;&nbsp;Import Processing Fee</a>
                            </li>
                            <li>
                                <a href = "{{ route('brokerage_fee.utilities_index') }}"  class = "class-brokerage-fee"><i class="fa fa-circle"></i>&nbsp;&nbsp;Brokerage Fee</a>
                            </li>
                        </div>
                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#archive_deliverycollapse"><i></i>&nbsp;&nbsp;Delivery</a>
                        </li>
                        <div id="archive_deliverycollapse" class="panel-collapse collapse">
                            <li>
                                <a href = "{{ route('location_province.utilities_index') }}"  class = "class-province"><i class="fa fa-circle"></i>&nbsp;&nbsp;Province</a>
                            </li>
                            <li>
                                <a href = "{{ route('location_city.utilities_index') }}"  class = "class-city"><i class="fa fa-circle"></i>&nbsp;&nbsp;City</a>
                            </li>
                            <li>
                                <a href = "{{ route('location.utilities_index') }}"  class = "location"><i class="fa fa-circle"></i>&nbsp;&nbsp;Location</a>
                            </li>
                            <li>
                                <a href = "{{ route('standard_area_rate.utilities_index') }}"  class = "class-area-rates"><i class="fa fa-circle"></i>&nbsp;&nbsp;Area Rates </a>
                            </li>
                            <li>
                                <a href = "{{ route('vehicle_type.utilities_index') }}"  class = "class-vehicle-type"><i class="fa fa-circle"></i>&nbsp;&nbsp;Vehicle Type</a>
                            </li>
                            <li>
                                <a href = "{{ route('vehicle.utilities_index') }}"  class = "class-vehicle"><i class="fa fa-circle"></i>&nbsp;&nbsp;Vehicle</a>
                            </li>
                            <li>
                                <a href = "{{ route('container_type.utilities_index') }}"  class = "class-container-type"><i class="fa fa-circle"></i>&nbsp;&nbsp;Container Size</a>
                            </li>
                        </div>
                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#archive_billingcollapse"><i></i>&nbsp;&nbsp;Billing</a>
                        </li>
                        <div id="archive_billingcollapse" class="panel-collapse collapse">
                            <li>
                                <a href = "{{ route('vat_rate.index') }}"  class = "class-vat-rate"><i class="fa fa-circle"></i>&nbsp;&nbsp;VAT Rate</a>
                            </li>
                            <li>
                                <a href = "{{ route('charges.utilities_index') }}"  class = "class-charges"><i class="fa fa-circle"></i>&nbsp;&nbsp;Charges</a>
                            </li>
                        </div>
                        <li>
                            <a data-toggle="collapse" class="maintenance-group" href = "#archive_employeecollapse"><i></i>&nbsp;&nbsp;Employee</a>
                        </li>
                        <div id="archive_employeecollapse" class="panel-collapse collapse">
                            <li>
                                <a href = "{{ route('employee_type.utilities_index') }}"  class = "class-vat-rate"><i class="fa fa-circle"></i>&nbsp;&nbsp;Employee Type</a>
                            </li>
                            <li>
                                <a href = "{{ route('employee.index') }}"  class = "class-charges"><i class="fa fa-circle"></i>&nbsp;&nbsp;Employee</a>
                            </li>

                        </li>
                    </div>
                </div>
            </ul>
        </div>
        <br>
        <li>
            <a href="{{ url('/logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" style="display: none;">
            {{ csrf_field() }}
        </form>
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
<script  type = "text/javascript" charset = "utf8" src="/js/jqueryValidate/additional-methods.js"></script>
<script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>
<script type="text/javascript" charset="utf8" src="/js/jqueryUI/jquery-ui.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/inputMask/jquery.inputmask.bundle.js"></script>
<script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>
<script type = "text/javascript" charset = "utf8" src="/js/Chart.js"></script>

<script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="/toaster/toastr.js"></script>


<script>
    function clock(){
        var time = new Date()
        var hr = time.getHours()
        var min = time.getMinutes()
        var sec = time.getSeconds()
        var ampm = " PM "
        if (hr < 12){
            ampm = " AM "
        }
        if (hr > 12){
            hr -= 12
        }
        if (hr < 10){
            hr = " " + hr
        }
        if (min < 10){
            min = "0" + min
        }
        if (sec < 10){
            sec = "0" + sec
        }
        document.clockForm.clockButton.value = hr + ":" + min + ":" + sec + ampm
        setTimeout("clock()", 1000)
    }
    window.onload=clock;

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

    $('.myMoneyMask').inputmask("numeric", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        autoGroup: true,
    prefix: '$', //No Space, this will truncate the first character
    rightAlign: false,
    oncleared: function () { self.Value(''); }
});



    function formatNumber(n) {
        var currency = "Php ";
        return currency +  n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }


    function formatNumber_s(n) {
        var currency = "$ ";
        return currency +  n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }


</script>
@stack('scripts')
</body>
</html>
