<html xmlns="http://www.w3.org/1999/html">
	<head>
		<title>Township Education Report Management System</title>
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<!--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/animate.min.css" type="text/css">
-->

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/creative.css" type="text/css">
</head>

<body id="page-top">
<nav id="mainNav">
    <div class="container-fluid"  style="background-color:lightcyan;border-bottom:1px solid #CCC;" >
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand page-scroll" href="#page-top">Township Education Report Management System</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('/auth/register') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
            		@include('auth/login');
            </div>
        </div>
    </div>
</section>

</body>
</html>