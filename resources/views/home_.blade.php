<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Township Education Management System | Admin Panel</title>
    <!-- The styles -->
    <link id="bs-css" href="admin_css/bootstrap-cerulean.css" rel="stylesheet">
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
  
    <link href="assets/admin_css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/admin_css/charisma-app.css" rel="stylesheet">
    <link href="assets/admin_css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href='assets/admin_css/opa-icons.css' rel='stylesheet'>

    <link href='assets/admin_css/bootstrap-spacelab.css' rel='stylesheet'>
    <link href='assets/admin_css/mystyle.css' rel='stylesheet'>
    
    <link href='assets/admin_css/colorbox.css' rel='stylesheet'>
    <link href='assets/admin_css/jquery.noty.css' rel='stylesheet'>
    <link href='assets/admin_css/noty_theme_default.css' rel='stylesheet'>
    <link href='assets/admin_css/elfinder.min.css' rel='stylesheet'>
    <link href='assets/admin_css/elfinder.theme.css' rel='stylesheet'>
    <link href='assets/admin_css/jquery.iphone.toggle.css' rel='stylesheet'>
    
    <link rel="shortcut icon" href="images/fav-icon.png">
    
    <!-- jQuery -->
    <script type="text/javascript" language="javascript" src="assets/admin_js/jquery-1.7.2.min.js" charset="utf-8"></script>
    <!-- jQuery UI -->
    <script src="assets/admin_js/jquery-ui-1.8.21.custom.min.js"></script>
    <!-- transition / effect library -->
    <script src="assets/admin_js/bootstrap-transition.js"></script>
    <!-- alert enhancer library -->
    <script src="assets/admin_js/bootstrap-alert.js"></script>
    <!-- custom dropdown library -->
    <script src="assets/admin_js/bootstrap-dropdown.js"></script>
    <!-- scrolspy library -->
    <script src="assets/admin_js/bootstrap-scrollspy.js"></script>
    <!-- library for creating tabs -->
    <script src="assets/admin_js/bootstrap-tab.js"></script>
    <!-- library for advanced tooltip -->
    <script src="assets/admin_js/bootstrap-tooltip.js"></script>
    <!-- popover effect library -->
    <script src="assets/admin_js/bootstrap-popover.js"></script>
    <!-- button enhancer library -->
    <script src="assets/admin_js/bootstrap-button.js"></script>
    <!-- accordion library (optional, not used in demo) -->
    <script src="assets/admin_js/bootstrap-collapse.js"></script>
    <!-- carousel slideshow library (optional, not used in demo) -->
    <script src="assets/admin_js/bootstrap-carousel.js"></script>
    <!-- autocomplete library -->
    <script src="assets/admin_js/bootstrap-typeahead.js"></script>
    <!-- tour library -->
    <script src="assets/admin_js/bootstrap-tour.js"></script>
    <!-- library for cookie management -->
    <script src="assets/admin_js/jquery.cookie.js"></script>
    <!-- calander plugin -->
    <script src='assets/admin_js/fullcalendar.min.js'></script>
    <!-- data table plugin --> 
    <script src='assets/admin_js/jquery.dataTables.min.js'></script>

    <!-- select or dropdown enhancer -->
    <script src="assets/admin_js/jquery.chosen.min.js"></script>
    <!-- checkbox, radio, and file input styler 
    <script src="js/jquery.uniform.min.js"></script> -->
    <!-- plugin for gallery image view -->
    <script src="assets/admin_js/jquery.colorbox.min.js"></script> 
    <!-- notification plugin -->
    <script src="assets/admin_js/jquery.noty.js"></script>
    <!-- file manager library -->
    <script src="assets/admin_js/jquery.elfinder.min.js"></script>
    <!-- star rating plugin -->
    <script src="assets/admin_js/jquery.raty.min.js"></script>
    <!-- for iOS style toggle switch -->
    <script src="assets/admin_js/jquery.iphone.toggle.js"></script>
    <!-- autogrowing textarea plugin -->
    <script src="assets/admin_js/jquery.autogrow-textarea.js"></script>
    <!-- multiple file upload plugin -->
    <!--<script src="js/jquery.uploadify-3.1.min.js"></script>-->
    <!-- history.js for cross-browser state change on ajax -->
    <script src="assets/admin_js/jquery.history.js"></script>
    <!-- application script for Charisma demo -->
    <script src="assets/admin_js/charisma.js"></script>       
    
    
    <script type="text/javascript">
        var base_url = "http://localhost/unicef_5/public/";
    </script>
            
</head>
<body>
    <!-- topbar starts -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="dashboard" style="width:400px;"> <span>Administration Panel</span></a>
                
                <!-- user dropdown starts -->
                <div class="btn-group pull-right">
                    
                    <!-- start menu -->
                    <div class="my_menu">
                        <a class="ajax-link" href="dashboard"><i class="icon icon-green icon-home"></i><span class="hidden-tablet"> Home</span></a> 
                        <a class="ajax-link" href="#"><i class="icon icon-green icon-edit"></i><span class="hidden-tablet"> Import</span></a> 
                    </div> 
                    <!-- end menu -->

                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-user"></i><span class="hidden-phone"> Admin</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="http://localhost/unicef/public/">Logout</a></li>
                    </ul>

                </div>
                <!-- user dropdown ends -->
            </div>
        </div>
    </div>

    <!-- topbar ends -->
        <div class="container-fluid">
        <a href="javascript:void(0)" id='clickme'><img src="{{ URL::to('img/s_fulltext.png') }}" /></a>
        
        <div class="row-fluid">
            <!-- left menu starts -->
            <div class="span3 main-menu-span" id="left_panel">
                <div class="well nav-collapse sidebar-nav">
                    <ul class="nav nav-tabs nav-stacked main-menu">
                        <li class="nav-header hidden-tablet">Main</li>
                        <li><a class="ajax-link" href="dashboard"><i class="icon icon-color icon-home"></i><span class="hidden-tablet"> Home</span></a></li>

                        <li class="nav-header hidden-tablet">School Info</li>
                        <li><a class="ajax-link finished" href="{{ URL::route('TypeReport') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Type Report</span></a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('TypeReportDetail') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Type Report Detail</span></a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('StdSanitation') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Sanitation</span></a></li>
                                                
                        <li class="nav-header hidden-tablet">Students</li>
                        <li><a class="ajax-link finished" href="{{ URL::route('calssroom') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Perminent/Temporary Classroom</span></a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('calssroom_detail') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Perminent/Temporary Classroom Detail</span></a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('StdEnrollment') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Enrollment</span></a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('StdAttendance') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Attendance < 75%</span></a></li>
                                                
                        <li class="nav-header hidden-tablet">Gross Enrolment Ratio Reports</li>
                        
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Gross Enrolment Ratio in Pre-primary/Preschool (ECCE) Programs</a></li>
                        <li><a class="ajax-link finished" href="{{ URL::route('GradeOnePer')}}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Grade 1 intakes With Pre-Primary / Preschool (ECCE) Experiences</span></a></li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Gross Intake Rate or Apparent Intake Rate(AIR) </span></a></li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Net Intake Rate (NIR)</span></a></li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Gross Enrolment Ratio: Primary,Middle and High School Level</span></a></li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Combined (Primary and Middle School Levels) Gross Enrolment Ratio</span></a></li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Net Enrolment Ratio Primary,Middle and High School Level</span></a></li>
                        <li><a class="ajax-link finished" href="{{URL::route('PercentGrilLevel')}}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Girls in Primary, Middle, High and 9-Year Basic Education Enrolment</span></a></li>

                        
                        

                        <li class="nav-header hidden-tablet"> Percentage of Teachers With School Level Reports</li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Teachers Having Required Academic Qualification : Primary Level and Middle School Level</span></a></li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentag of Certified (Professionally Trained) Teachers: Primary Level and Middle School Level </span></a></li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Public Teacher Ratio: Primary, Middle and High School Level</span></a></li><li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Female Teachers: Primary, Middle and High School Level</span></a></li>

                        <!-- Student flow rates --> 
                        <li class="nav-header hidden-tablet"> Student Flow Rate Reports</li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> (Grade 1 to Grade 10) Promotion Rate for Grade "g" of Year "t"</span></a></li><li><a class="ajax-link finished" href="{{ URL::route('promotion_rate_for_grade_5_or_9_or_11') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Promotion Rate for Grade 5 or 9 or 11 of Year "t" </span></ae></li><li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Repetition Rate for Grade "g" of Year "t"</span></a></li><li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Dropout Rate for Grade "g" of Year "t"</span></a></li><li><a class="ajax-link finished" href="{{ URL::route('high_school_level_completion_rate') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Completion Rate: High School Level</span></a></li><li><a class="ajax-link finished" href="{{ URL::route('transition_rate_primary_to_middle') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Transition Rate from Primary to Middle School Level(TRPMS) </span></a></li><li><a class="ajax-link finished" href="{{ URL::route('transition_rate_middle_to_high') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Transition Rate from Middle to High School Level(TRMHS) </span></a></li><li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Coefficient of Efficiency: Primary, Middle and High School Level Reports</span></a></li><li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Literacy Rate of 15-45 Years Old </span></a></li><li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Adult Literacy Rate (Aged 15+)</span></a></li>
 
                        <!-- Public class ratio Report -->
                        <li class="nav-header hidden-tablet"> Pupil Class Ratio Reports</li>
                        <li><a class="ajax-link finished" href="{{ URL::route('pupil_class_ratio_by_grade') }}" title="Total number of pupils enrolled in specified grade / Total number of classes or sections at the same grade"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Pupil Class Ratio by Grade</span></a></li><li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Public Class Ratio by Level </span></a></li>

                        <!--General Rate Reports -->
                        <li class="nav-header hidden-tablet"> General Rate Reports</li>
                        <li><a class="ajax-link finished" href="{{ URL::route('high_school_level_retention_rate') }}"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Retention Rate</span></a></li><li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Teacher Attrition Rate </span></a></li>

                        <!-- Oversized Classes -->
                        <li class="nav-header hidden-tablet"> Percentage of Classes, Classroom, School Libraray Reports</li>
                        <li><a class="ajax-link finished" href="{{ URL::route('percentage_of_oversized_classes') }}" title="(Number of oversized classes (classes with over 40 pupils) at the specified level / Total number of classes or sections at the same level) * 100"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Oversized Classes (Sections with Over 40 Pupils) </span></a></li><li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green
                         icon-document"></i><span class="hidden-tablet"> Percentage of Classrooms with Minimum Standard Quality Level </span></a></li><li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of School with Library </span></a></li><li>


                        <!-- Percentage with water and Sanitation -->   
                        <li class="nav-header hidden-tablet">Percentage of Schools with Proper Water & Sanitation Facilities Reports</li>
                        <li><a class="ajax-link pending" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Sanitation Facilities </span></a></li><li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green
                         icon-document"></i><span class="hidden-tablet"> Proper Water </span></a></li><li>
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Proper Water and Sanitation Facitilites </span></a></li><li> 
                        <li><a class="ajax-link" href="#"><i class="icon icon-green icon-document"></i><span class="hidden-tablet"> Percentage of Oversized Classes (Sections with Over 40 Pupils) </span></a></li><li>

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