<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="icon" href="/images/icon.ico">
	<link href="/css/app.css" rel="stylesheet">
	<link href= "/js/select2/select2.css" rel = "stylesheet">
	<link rel="stylesheet" href="/js/jqueryDatatable/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="/toaster/toastr.css">
	<link rel="stylesheet" href="/js/jqueryUI/jquery-ui.css">
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href="/sidebar/css/simple-sidebar.css" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-fixed-top" id="navtop">
			<div class="navbar-header">
				<!-- Branding Image -->
				<a class="navbar-brand toggled" id="menu-toggle" href="#menu-toggle">
					<img src="/images/burger.png">
				</a>
				<a class="navbar-brand" style="color: #fff;"><img src="/images/pilotlogo.png" id="logo"></a>
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
					@if ($user == null)
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
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="jumbotron">
				<br />
				<br />
				<h1>Oops! Sorry but you have no permission to access this page.</h1> 

				<br />
				<p> <a href="{{ route('dashboard.index') }}">Go to dashboard.</a></p> 
			</div>
		</div>
		
	</div>
	<script type="text/javascript">
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
	</script>
</body>
</html>