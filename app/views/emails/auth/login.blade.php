
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Education Report Service</title>
<link href="assets/css/login.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" href="">
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
<link id="bs-css" href="assets/css/bootstrap-cerulean.css" rel="stylesheet">
<link href="assets/css/charisma-app.css" rel="stylesheet" type="text/css">
<link href="assets/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="assets/js/jquery-1.7.2.min.js" charset="utf-8"></script>
<script type="text/javascript" language="javascript" src="assets/js/loginscript.js" charset="utf-8"></script>
</head>
<body>
<div class="container-fluid">
		<div class="row-fluid">
		
		<div class='span12' id="login-form">
			
		<div class="row-fluid">	
			<div class="span4 center">	
				<p>	
					<a class="brand" href="javascript:void(0);"><span>Township Education Report Management System</span></a>
				</p>
			</div>
		</div><br/><br/>

		<div class="row-fluid">	
				<div class="well span5 center login-box" id="loginbox" style="clear:both;">
					<div class="alert alert-info">
						Please login with your Email and Password.
					</div>
					<form class="form-horizontal" action="{{URL::route('admin.login.post')}}" method="post">
						<fieldset>
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="login_name" id="login_user" type="text" placeholder="username" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="login_pwd" id="password" type="password" placeholder="password" />
							</div>
							<div class="clearfix"></div>

							<p class="center span5">
								<a href="dashboard" class="btn btn-success">Login</a>
								<!-- <input type="submit" class="btn btn-inverse" value="Login" /> -->
							</p>
						</fieldset>
					</form>
					<p align="right"><a href="javascript:void(0)" class="forgot-pwd">Forget Password?</a></p>
				</div><!--/span-->
		</div>	
<!---- start forget box ------------------------------------------------->

				<div class="well span5 center login-box" id="forgetbox"><br/>
					<p style="color:#A52A2A;">Please send us your email and we'll reset your password.</p><br/>
					<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=forgetpassword" method="post">
						<fieldset>
							<div class="input-prepend" title="Emal" data-rel="tooltip">
								<span class="add-on">@</span><input autofocus class="input-large span10" name="forgetemail" id="forget_email" type="text" placeholder="Email" />
							</div>
							<div class="clearfix"></div>

							<p class="center span5">
								<input type="submit" class="btn btn-success" value="Send" />
							</p>
						</fieldset>
					</form>
					<p align="right"><a href="javascript:void(0)" class="backlogin"><< Back to Login</a></p>
				</div><!--/span-->		
    	
		</div><!--/row-->
	</div><!--/fluid-row-->
</div><!--/.fluid-container-->

</body>
</html>