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
				<a data-rel="tooltip" title="School Type Report" class="well span3 top-block" href="{{ URL::route('TypeReport') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>School Type Report</div>
				</a>

				<a data-rel="tooltip" title="School Type Report Detail" class="well span3 top-block" href="{{ URL::route('TypeReportDetail') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>School Type Report Detail</div>
				</a>

				<a data-rel="tooltip" title="Sanitation Reports" class="well span3 top-block" href="{{ URL::route('StdSanitation') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Sanitation Reports</div>
				</a>
			</div>
			<br/>
			
			<div>
				<ul class="breadcrumb">
					<li>
						Students/Teacher
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Student/Permanent Classroom ratio" class="well span3 top-block" href="{{ URL::route('calssroom') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Student/Permanent Classroom ratio</div>
				</a>

				<a data-rel="tooltip" title="Student/Temporary Classroom ratio" class="well span3 top-block" href="{{ URL::route('calssroom_detail') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Student/Temporary Classroom ratio</div>
				</a>
				
				<a data-rel="tooltip" title="Percentage of Oversize Classes (Over 40 Pupils)" class="well span3 top-block" href="{{ URL::route('percentage_of_oversized_classes') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Oversize Classes (Over 40 Pupils)</div>
				</a>
								
				<a data-rel="tooltip" title="Pupil/Teacher Ratio" class="well span3 top-block" href="{{ URL::route('TeacherRatio') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Pupil/Teacher Ratio</div>
					<div>&nbsp;</div>
				</a>
				</div>
				
				<div class="sortable row-fluid">	
				<a data-rel="tooltip" title="Pupil/Teacher Ratio By Township" class="well span3 top-block" href="{{ URL::route('TeacherRatioByTownship') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Pupil/Teacher Ratio By Township</div>
				</a>
				
				<a data-rel="tooltip" title="Attendance < 75%" class="well span3 top-block" href="{{ URL::route('StdAttendance') }}">
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
						Intake
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Net Intake Rate (NIR)" class="well span3 top-block" href="{{ URL::route('GradeOnePer') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>% of Grade 1 intakes With Preschool Experiences</div>
				</a>
				
				<a data-rel="tooltip" title="Net Intake Rate (NIR)" class="well span3 top-block" href="{{ URL::route('NetIntakeRate')}}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Net Intake Rate (NIR)</div>
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
				
				<a data-rel="tooltip" title="Gross Enrolment Ratio: Primary,Middle and High School Level" class="well span3 top-block" href="{{ URL::route('GrossEnrollmentRation') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Gross Enrolment Ratio: Primary,Middle and High School Level</div>
				</a>
				
				<a data-rel="tooltip" title="Gross Enrollment Ratio: Combined (Primary and Middle School Levels)" class="well span3 top-block" href="{{ URL::route('CombinedGrossEnrollmentRatio') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Gross Enrollment Ratio: Combined (Primary and Middle School Levels)</div>
				</a>
				
				<a data-rel="tooltip" title="Percentage of Girls in Primary, Middle, High level" class="well span3 top-block" href="{{ URL::route('PercentGrilLevel') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Girls in Primary, Middle, High level</div>
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
				<a data-rel="tooltip" title="Promotion Rate for Grade (Grade 1 to Grade 10)" class="well span3 top-block" href="{{URL::route('PromotionRate')}}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Promotion Rate for Grade (Grade 1 to Grade 10)</div>
				</a>

				<a data-rel="tooltip" title="Promotion Rate for Grade 5 or 9 or 11" class="well span3 top-block" href="{{ URL::route('promotion_rate_for_grade_5_or_9_or_11') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Promotion Rate for Grade 5 or 9 or 11</div>
				</a>

				<a data-rel="tooltip" title="Repetition Rate" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Repetition Rate</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Dropout Rate" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Dropout Rate</div>
					<div>&nbsp;</div>
				</a>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Completion Rate: High School Level" class="well span3 top-block" href="{{ URL::route('high_school_level_completion_rate') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Completion Rate: High School Level</div>
					<div>&nbsp;</div>
				</a>

				<a data-rel="tooltip" title="Transition Rate from Primary to Middle School Level" class="well span3 top-block" href="{{ URL::route('transition_rate_primary_to_middle') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Transition Rate from Primary to Middle School Level</div>
				</a>

				<a data-rel="tooltip" title="Transition Rate from Middle to High School Level" class="well span3 top-block" href="{{ URL::route('transition_rate_middle_to_high') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Transition Rate from Middle to High School Level</div>
				</a>
			</div><br/>

			<div>
				<ul class="breadcrumb">
					<li>
						General Rate Reports
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="Retention Rate" class="well span3 top-block" href="{{ URL::route('high_school_level_retention_rate') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Retention Rate</div>
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
				
				<a data-rel="tooltip" title="Percentage of Schools with Library" class="well span3 top-block" href="{{ URL::route('pupil_class_ratio_by_grade') }}">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Percentage of Schools with Library</div>
				</a>
				
				<a data-rel="tooltip" title="Sanitation Facilities" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-copy"></span>
					<div>&nbsp;</div>
					<div>Sanitation Facilities</div>
					<div>&nbsp;</div>
				</a>
			</div>
			<br/>
@stop			