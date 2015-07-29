@extends('layouts.base')
@section('content')
<div>
				<ul class="breadcrumb">
					<li>
						School Info
					</li>
					
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="{{ URL::route('TypeReport') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Type Report</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="{{ URL::route('TypeReportDetail') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Type Report Detail</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="{{ URL::route('StdSanitation') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Sanitation</div>
				</a>
			</div>
			<br/>
                
            <div>
				<ul class="breadcrumb">
					<li>
						Students
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="{{ URL::route('calssroom') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Perminent/Temporary Classroom</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="{{ URL::route('calssroom_detail') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Perminent/Temporary Classroom Detail</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="{{ URL::route('StdEnrollment') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Enrollment</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="{{ URL::route('StdAttendance') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Attendance < 75%</div>
					<div>&nbsp;</div>
				</a>
			</div>
            <br/>
            	
            <div>
				<ul class="breadcrumb">
					<li>
						Gross Enrolment Ratio Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Gross Enrolment Ratio in Pre-primary/Preschool (ECCE) Programs</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="{{ URL::route('GradeOnePer')}}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Grade 1 intakes With Pre-Primary / Preschool (ECCE) Experiences</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Gross Intake Rate or Apparent Intake Rate(AIR)</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Gross Enrolment Ratio: Primary,Middle and High School Level</div>
				</a>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Combined (Primary and Middle School Levels) Gross Enrolment Ratio</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Net Enrolment Ratio Primary,Middle and High School Level</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="{{ URL::route('PercentGrilLevel') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Girls in Primary, Middle, High and 9-Year Basic Education Enrolment</div>
				</a>
			</div>
			<br/>


			<div>
				<ul class="breadcrumb">
					<li>
						Percentage of Teachers With School Level Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Teachers Having Required Academic Qualification : Primary Level and Middle School Level</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentag of Certified (Professionally Trained) Teachers: Primary Level and Middle School Level</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Public Teacher Ratio: Primary, Middle and High School Level</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Female Teachers: Primary, Middle and High School Level</div>
					<div>&nbsp;</div>
				</a>
			</div>
			<br/>


			<div>
				<ul class="breadcrumb">
					<li>
						Student Flow Rate Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>(Grade 1 to Grade 10) Promotion Rate for Grade "g" of Year "t"</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Promotion Rate for Grade 5 or 9 or 11 of Year "t"</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Repetition Rate for Grade "g" of Year "t"</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Dropout Rate for Grade "g" of Year "t"</div>
					<div>&nbsp;</div>
				</a>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Completion Rate: Primary, Middle and High School</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Transition Rate from Primary to Middle School Level(TRPMS)</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Transition Rate from Middle to High School Level(TRMHS)</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Sanitation" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Coefficient of Efficiency: Primary, Middle and High School Level Reports</div>
				</a>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Literacy Rate of 15-45 Years Old</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Adult Literacy Rate (Aged 15+)</div>
					<div>&nbsp;</div>
				</a>
			</div>
			<br/>

			<div>
				<ul class="breadcrumb">
					<li>
						Public Class Ratio Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Public Class Ratio by Grade</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Public Class Ratio by Level</div>
				</a>
			</div>
			<br/>

			<div>
				<ul class="breadcrumb">
					<li>
						General Rate Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Retention Rate</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Teacher Attrition Rate</div>
				</a>
			</div>
			<br/>

			<div>
				<ul class="breadcrumb">
					<li>
						Percentage of Classes, Classroom, School Libraray Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Oversized Classes (Sections with Over 40 Pupils)</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Classrooms with Minimum Standard Quality Level</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of School with Library</div>
					<div>&nbsp;</div>
				</a>
			</div>
			<br/>

			<div>
				<ul class="breadcrumb">
					<li>
						Percentage of Schools with Proper Water & Sanitation Facilities Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Type Report" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Sanitation Facilities</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Proper Water</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Proper Water and Sanitation Facitilites</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Type Report Detail" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Oversized Classes (Sections with Over 40 Pupils)</div>
				</a>
			</div>
@stop			