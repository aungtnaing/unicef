<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="" />
	<title>Township Education Report Management System | Admin Panel</title>
	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	  .finished {
	  	border: 1px solid #F00 !important;
	  	margin: 2px;
	  }
	  .pending {
	  	border: 1px solid #0F0 !important;
	  	margin: 2px;
	  }
	</style>
  
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="assets/css/charisma-app.css" rel="stylesheet">
	<link href="assets/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='assets/css/opa-icons.css' rel='stylesheet'>

    <link href='assets/css/bootstrap-spacelab.css' rel='stylesheet'>
    <link href='assets/css/mystyle.css' rel='stylesheet'>
    
	<link href='assets/css/colorbox.css' rel='stylesheet'>
	<link href='assets/css/jquery.noty.css' rel='stylesheet'>
	<link href='assets/css/noty_theme_default.css' rel='stylesheet'>
	<link href='assets/css/elfinder.min.css' rel='stylesheet'>
	<link href='assets/css/elfinder.theme.css' rel='stylesheet'>
	<link href='assets/css/jquery.iphone.toggle.css' rel='stylesheet'>
    
	<link rel="shortcut icon" href="images/fav-icon.png">
    
    <!-- jQuery -->
	<script type="text/javascript" language="javascript" src="assets/js/jquery-1.7.2.min.js" charset="utf-8"></script>
	<!-- jQuery UI -->
	<script src="assets/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="assets/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="assets/js/bootstrap-alert.js"></script>
	<!-- custom dropdown library -->
	<script src="assets/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="assets/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="assets/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="assets/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="assets/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="assets/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="assets/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="assets/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="assets/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="assets/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="assets/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='assets/js/fullcalendar.min.js'></script>
	<!-- data table plugin --> 
	<script src='assets/js/jquery.dataTables.min.js'></script>

	<!-- select or dropdown enhancer -->
	<script src="assets/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler 
	<script src="js/jquery.uniform.min.js"></script> -->
	<!-- plugin for gallery image view -->
	<script src="assets/js/jquery.colorbox.min.js"></script> 
	<!-- notification plugin -->
	<script src="assets/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="assets/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="assets/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="assets/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="assets/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<!--<script src="js/jquery.uploadify-3.1.min.js"></script>-->
	<!-- history.js for cross-browser state change on ajax -->
	<script src="assets/js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="assets/js/charisma.js"></script>		
	
	
	<script type="text/javascript">
		var base_url = "<?php echo url(); ?>/";
	</script>
    		
</head>
<body>
	
	<?php 
		if(Input::get('btn_search')) {

			Session::forget('state_id');
			Session::forget('township_id');
			Session::forget('academic_year');
			
			Session::put('state_id', Input::get('state_id'));
			Session::put('township_id', Input::get('township_id'));
			Session::put('academic_year', Input::get('academic_year'));
			
		} 
	?>
	
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="dashboard" style="width:600px;"> <span>Township Education Report Management System</span></a>
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right">
					
					<!-- start menu -->
					<div class="my_menu">
						<a class="ajax-link" href="dashboard"><i class="icon icon-green icon-home"></i><span class="hidden-tablet"> Home</span></a> 
						<!-- <a class="ajax-link" href="#"><i class="icon icon-green icon-edit"></i><span class="hidden-tablet"> Import</span></a>  -->
					</div> 
					<!-- end menu -->

					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    	<i class="icon-user"></i><span class="hidden-phone"> {{ Auth::user()->name }}</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Profile</a></li>
						<li class="divider"></li>
						<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
					</ul>

				</div>
				<!-- user dropdown ends -->
			</div>
		</div>
	</div>

	<!-- topbar ends -->
		<div class="container-fluid">
		<a href="javascript:void(0)" id='clickme'><img src="{{ URL::TO('/') }}/assets/img/s_fulltext.png" /></a>
		
		<div class="row-fluid">
			<!-- left menu starts -->
			<div class="span3 main-menu-span" id="left_panel">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
                        <li class="nav-header hidden-tablet">Main</li>
                        <li><a class="ajax-link" href="<?php echo url(); ?>"><i class="icon icon-color icon-home"></i><span class="hidden-tablet"> Home</span></a></li>

                        <li class="nav-header hidden-tablet">School Info</li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('TypeReport') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> School Type Report</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('TypeReportDetail') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> School Type Report Detail</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('StdSanitation') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Sanitation Report</span></a></li>
                        
                        <li class="nav-header hidden-tablet">Students/Teacher</li>
                                                
                        <li><a class="ajax-link finished" href="{{ URL::route('calssroom') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Student/Permanent Classroom ratio</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('calssroom_detail') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Student/Temporary Classroom ratio</span></a></li>
                        
                        <!-- Oversized Classes -->
                       <li><a class="ajax-link finished" href="{{ URL::route('percentage_of_oversized_classes') }}" title="(Number of oversized classes (classes with over 40 pupils) at the specified level / Total number of classes or sections at the same level) * 100"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Oversize Classes (Over 40 Pupils) </span></a></li>
                        
                        <li><a class="ajax-link pending" href="{{ URL::route('TeacherRatio') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Pupil/Teacher Ratio</span></a></li>
                        
                        <li><a class="ajax-link pending" href="{{ URL::route('TeacherRatioByTownship') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Pupil/Teacher Ratio By Township</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('StdEnrollment') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Enrollment</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('StdAttendance') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Attendance < 75%</span></a></li>
                        
                        <li class="nav-header hidden-tablet">Intake</li>
                        
                         <li><a class="ajax-link finished" href="{{ URL::route('GradeOnePer')}}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> % of Grade 1 intakes With Preschool Experiences</span></a></li>
                         
                        <li><a class="ajax-link pending" href="{{ URL::route('NetIntakeRate') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Net Intake Rate (NIR)</span></a></li>
                        
                        <li class="nav-header hidden-tablet">Gross Enrolment Ratio Reports</li>
                        
                        <li><a class="ajax-link pending" href="{{ URL::route('GrossEnrollmentRation') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Gross Enrolment Ratio: Primary,Middle and High School Level</span></a></li>
                        
				<li><a class="ajax-link pending" href="{{ URL::route('CombinedGrossEnrollmentRatio') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Gross Enrollment Ratio: Combined (Primary and Middle School Levels) </span></a></li>
 
				<li><a class="ajax-link finished" href="{{URL::route('PercentGrilLevel')}}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Girls in Primary, Middle, High level</span></a></li>
                        
				<li class="nav-header hidden-tablet">Student Flow Rate Reports</li> 
				
				<li><a class="ajax-link finished" href="{{URL::route('PromotionRate')}}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Promotion Rate for Grade (Grade 1 to Grade 10) </span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('promotion_rate_for_grade_5_or_9_or_11') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Promotion Rate for Grade 5 or 9 or 11  </span></a></li>
                        
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Repetition Rate </span></a></li>
                        
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Dropout Rate</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('high_school_level_completion_rate') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Completion Rate: High School Level</span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('transition_rate_primary_to_middle') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Transition Rate from Primary to Middle School Level </span></a></li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('transition_rate_middle_to_high') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Transition Rate from Middle to High School Level </span></a></li>
                        
                        <li class="nav-header hidden-tablet">General Rate Reports</li>
                        
                        <li><a class="ajax-link finished" href="{{ URL::route('high_school_level_retention_rate') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Retention Rate </span></a></li>
				
				<li><a class="ajax-link pending" href="{{ URL::route('pupil_class_ratio_by_grade') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Schools with Library</span></a></li>
		</ul>
	</div><!--/.well -->
</div><!--/span-->
<!-- left menu ends -->
		
	<!-- content starts -->
	<div id="content" class="span9">
		@yield('content')
	</div><!-- content ends -->
	</div><!--/fluid-row-->
		
		<hr>
		<footer>
			<p class="pull-left">&copy; <a href="#" target="_blank">Unicef</a></p>
			<p class="pull-right">Powered by Bangoo Technology</p>
		</footer>
		
	</div><!--/.fluid-container-->

</body>
</html>

<script type="text/javascript">
	
	$("#clickme").click(function () {
		
		$("#left_panel").toggle(200);

		var name = $("#content").attr('class');

		if(name == "span9") {
			$("#content").attr('class', 'span11');
		} else {
			$("#content").attr('class', 'span9');
		}
	
	});

</script>       