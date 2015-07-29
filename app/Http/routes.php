<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/** Student Attendacne **/
Route::get('attendancelist', array('as' => 'StdAttendance', 'uses' => 'StudentAttendanceController@create'));

Route::post('attendancelist', array('as' => 'StdAttendanceList', 'uses' => 'StudentAttendanceController@index'));

/** School Type Report **/
Route::post('type_report_list',array('as' => 'TypeReportList', 'uses' => 'TypeReportsController@index'));

Route::get('school_informations', array('as' => 'TypeReport', 'uses' => 'TypeReportsController@create'));

Route::post('type_export_excel', array('as' => 'type_report_export', 'uses' => 'TypeReportsController@show'));

/** School Type Report Detail **/
Route::get('school_information_detail', array('as' => 'TypeReportDetail', 'uses' => 'TypeReportDetailController@create'));

Route::post('school_information_detail', array('as' => 'TypeReportDetailList', 'uses' => 'TypeReportDetailController@index'));

Route::post('school_information_detail_export', array('as' => 'TypeReportDetailListExport', 'uses' => 'TypeReportDetailController@export'));

/** Perminent/Temporary Classroom **/
Route::get('perminent_temporary_classroom', array('as' => 'calssroom', 'uses' => 'PermenantTemporaryController@create'));

Route::post('perminent_temporary_classroom_list', array('as' => 'calssroom_list', 'uses' => 'PermenantTemporaryController@index'));

Route::post('perminent_temporary_classroom_export', array('as' => 'calssroom_list_export', 'uses' => 'PermenantTemporaryController@show'));

/** Perminent/Temporary Classroom Detail **/
Route::get('perminent_temporary_classroom_detail', array('as' => 'calssroom_detail', 'uses' => 'PerminentTemporaryDetailController@create'));

Route::post('perminent_temporary_classroom_detail', array('as' => 'calssroom_detail_list', 'uses' => 'PerminentTemporaryDetailController@index'));

Route::post('perminent_temporary_classroom_detail_export', array('as' => 'calssroom_detail_export', 'uses' => 'PerminentTemporaryDetailController@show'));


/** Transition rate from primary to middle **/
Route::get('transition_rate_primary_middle', array('as' => 'transition_rate_primary_to_middle', 'uses' => 'TransitionRatePrimaryToMiddleController@create'));

Route::post('transition_rate_primary_middle', array('as' => 'transition_rate_primary_to_middle_list', 'uses' => 'TransitionRatePrimaryToMiddleController@index'));

Route::post('transition_rate_primary_middle_excel', array('as' => 'transition_rate_primary_to_middle_list_export', 'uses' => 'TransitionRatePrimaryToMiddleController@show'));


/** Transition rate from middle to high **/
Route::get('transition_rate_middle_to_high', array('as' => 'transition_rate_middle_to_high', 'uses' => 'TransitionRateMiddleToHighController@create'));

Route::post('transition_rate_middle_to_high', array('as' => 'transition_rate_midlle_to_high_list', 'uses' => 'TransitionRateMiddleToHighController@index'));

Route::post('transition_rate_middle_to_high_export', array('as' => 'transition_rate_midlle_to_high_list_export', 'uses' => 'TransitionRateMiddleToHighController@show'));


/** high school level retention rate **/
Route::get('high_school_level_retention_rate', array('as' => 'high_school_level_retention_rate', 'uses' => 'HighSchoolLevelController@create'));

Route::post('high_school_level_retention_rate', array('as' => 'high_school_level_retention_rate_list', 'uses' => 'HighSchoolLevelController@index'));

Route::post('high_school_level_retention_rate_excel', array('as' => 'high_school_level_retention_rate_list_export', 'uses' => 'HighSchoolLevelController@show'));

/** completion rate high school level **/
Route::get('high_school_level_completion_rate', array('as' => 'high_school_level_completion_rate', 'uses' => 'HighSchoolLevelCompletionRateController@create'));

Route::post('high_school_level_completion_rate', array('as' => 'high_school_level_completion_rate_list', 'uses' => 'HighSchoolLevelCompletionRateController@index'));

Route::post('high_school_level_completion_rate_export', array('as' => 'high_school_level_completion_rate_list_export_excel', 'uses' => 'HighSchoolLevelCompletionRateController@show'));

/** Promotion Rate for Grade 5, 9, 11 **/
Route::get('promotion_rate_for_grade_5_or_9_or_11', array('as' => 'promotion_rate_for_grade_5_or_9_or_11', 'uses' => 'PromotionRateGrade5911Controller@create'));

Route::post('promotion_rate_for_grade_5_or_9_or_11', array('as' => 'promotion_rate_for_grade_5_or_9_or_11_list', 'uses' => 'PromotionRateGrade5911Controller@index'));

Route::post('promotion_rate_for_grade_5_or_9_or_11_export', array('as' => 'promotion_rate_for_grade_5_or_9_or_11_list_exports', 'uses' => 'PromotionRateGrade5911Controller@show'));

/** Pupil Class Ratio By Grade **/
Route::get('pupil_class_ratio_by_grade', array('as' => 'pupil_class_ratio_by_grade', 'uses' => 'PupilClassRatioByGradeController@create'));

Route::post('pupil_class_ratio_by_grade', array('as' => 'pupil_class_ratio_by_grade_list', 'uses' => 'PupilClassRatioByGradeController@index'));

Route::post('pupil_class_ratio_by_grade_export', array('as' => 'pupil_class_ratio_by_grade_exports', 'uses' => 'PupilClassRatioByGradeController@show'));

/** Percentage of Oversized Classes **/
Route::get('percentage_of_oversized_classes', array('as' => 'percentage_of_oversized_classes', 'uses' => 'PercentageOfOversizedClassController@create'));

Route::post('percentage_of_oversized_classes', array('as' => 'percentage_of_oversized_classes_list', 'uses' => 'PercentageOfOversizedClassController@index'));

Route::post('percentage_of_oversized_classes_export', array('as' => 'percentage_of_oversized_classes_list_export', 'uses' => 'PercentageOfOversizedClassController@show'));

/** Student Sanitation **/
Route::get('sanitationfrm', array('as' => 'StdSanitation', 'uses' => 'SanitationStudentRatioController@create'));

Route::post('sanitationfrm', array('as' => 'SearchStdSanitation', 'uses' => 'SanitationStudentRatioController@search'));

Route::post('sanitationfrm_export', array('as' => 'SearchStdSanitation_excel', 'uses' => 'SanitationStudentRatioController@export'));

/** Student Enrollment **/
Route::get('enrollmentfrm', array('as' => 'StdEnrollment', 'uses' => 'StudentEnrollmentController@create'));

Route::post('enrollmentfrm', array('as' => 'SearchStdEnrollment', 'uses' => 'StudentEnrollmentController@search'));

Route::post('enrollmentfrm_excel',array('as' => 'ExportStdEnrollment', 'uses' => 'StudentEnrollmentController@export'));

/** get township **/
Route::post('townships', 'SearchFormController@index');

/** Teacher Ratio **/
Route::get('teacher_ratio', array('as' => 'TeacherRatio', 'uses' => 'TeacherRatioController@create'));

Route::post('teacher_ratio', array('as' => 'TeacherRatioSearch', 'uses' => 'TeacherRatioController@Search'));

Route::post('teacher_ratio_export', array('as' => 'TeacherRatioExport', 'uses' => 'TeacherRatioController@show'));

/** Teacher Ratio By Township **/
Route::get('teacher_ratio_by_township', array('as' => 'TeacherRatioByTownship', 'uses' => 'TeacherRatioByTownshipController@create'));

Route::post('teacher_ratio_by_township', array('as' => 'TeacherRatioByTownshipSearch', 'uses' => 'TeacherRatioByTownshipController@Search'));

Route::post('teacher_ratio_by_township_export', array('as' => 'TeacherRatioByTownshipExport', 'uses' => 'TeacherRatioByTownshipController@show'));

/** Gross Enrollment Ratio **/
Route::get('grade_one_per',array('as' => 'GradeOnePer','uses' => 'PercentGradeOneIntakeController@create'));

Route::post('grade_one_per',array('as' => 'SearchGradeOnePer','uses' => 'PercentGradeOneIntakeController@search'));

Route::post('grade_one_per_excel',array('as' => 'ExcelGradeOnePer','uses' => 'PercentGradeOneIntakeController@show'));


Route::get('percent_girls', array('as' => 'PercentGrilLevel','uses' => 'PercentGirlLevelController@create'));

Route::post('percent_girls', array('as' => 'SearchPercentGrilLevel','uses' => 'PercentGirlLevelController@search'));

Route::post('percent_girls_export', array('as' => 'ExportPercentGrilLevel','uses' => 'PercentGirlLevelController@show'));

Route::get('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRation','uses' => 'GrossEntrollmentRationLevelsController@create'));

Route::post('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRationLevels','uses' => 'GrossEntrollmentRationLevelsController@search'));

Route::get('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatio','uses' => 'CombinedEnrollmentRatioController@create'));

Route::post('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatioLevels','uses' => 'CombinedEnrollmentRatioController@search'));

/*** Student Flow Rates ***/
Route::get('promotion_rate', array('as' => 'PromotionRate','uses' => 'PromotionRateGradeController@create'));

Route::post('promotion_rate', array('as' => 'PromotionRateGrade','uses' => 'PromotionRateGradeController@search'));

Route::post('promotion_rate_export', array('as' => 'PromotionRateGradeExport','uses' => 'PromotionRateGradeController@show'));


/** Sanitation Facilities **/
Route::get('sanitation_facilities', array('as' => 'sanitation_facilities','uses' => 'SanitationFacilitiesController@create'));

Route::post('sanitation_facilities_list', array('as' => 'sanitation_facilities_list','uses' => 'SanitationFacilitiesController@index'));

/** Repetition Rate **/
Route::get('repetition_rate', array('as' => 'repetition_rate', 'uses' => 'RepetitionRateController@create'));

Route::post('repetition_rate', array('as' => 'repetition_rate_list', 'uses' => 'RepetitionRateController@index'));

/** Dropout Rate **/
Route::get('dropout_rate', array('as' => 'dropout_rate', 'uses' => 'DropoutRateController@create'));

Route::post('dropout_rate_list', array('as' => 'dropout_rate_list', 'uses' => 'DropoutRateController@index'));

Route::post('dropout_rate_export', array('as' => 'dropout_rate_list_export', 'uses' => 'DropoutRateController@show'));

/** Percentage of Schools with Library **/
Route::get('percentage_school_library', array('as' => 'percentage_school_library', 'uses' => 'PercentageSchoolLibraryController@create'));

Route::post('percentage_school_library_list', array('as' => 'percentage_school_library_list', 'uses' => 'PercentageSchoolLibraryController@index'));

Route::get('lavachart_test', array('as' => 'lavachart_test', 'uses' => 'ChartController@index'));

/*** Permenant Temporary Classroom Chart ***/
Route::get('classroom_chart', array('as' => 'classroom_chart', 'uses' => 'PermenantTemporaryChartController@create'));

Route::post('classroom_chart_list', array('as' => 'classroom_chart_list', 'uses' => 'PermenantTemporaryChartController@index'));



/*** Net Intake Rate **/

Route::get('net_intake_rate', array('as' => 'NetIntakeRate','uses' => 'NetIntakeRateController@create'));

Route::post('net_intake_rate', array('as' => 'NetIntakeRateNIR','uses' => 'NetIntakeRateController@search'));

Route::post('net_intake_rate_export', array('as' => 'NetIntakeRateExport','uses' => 'NetIntakeRateController@export'));


///sanitation facilities
Route::post('sanitation_facilities_export', array('as' => 'sanitation_facilities_export_excel','uses' => 'SanitationFacilitiesController@show'));
///school library
Route::post('percentage_school_library_export', array('as' => 'percentage_school_library_export', 'uses' => 'PercentageSchoolLibraryController@show'));
/// Repetition Rate
Route::post('repetition_rate_export', array('as' => 'repetition_rate_export', 'uses' => 'RepetitionRateController@show'));
//Combined Enrollment Ratio

Route::get('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatio','uses' => 'CombinedEnrollmentRatioController@create'));

Route::post('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatioLevels','uses' => 'CombinedEnrollmentRatioController@search'));

Route::post('combined_enrollment_ratio_export', array('as' => 'CombinedGrossEnrollmentRatioLevelsExport','uses' => 'CombinedEnrollmentRatioController@export'));


//Gross Entrollemnt Ratio
Route::get('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRation','uses' => 'GrossEntrollmentRationLevelsController@create'));

Route::post('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRationLevels','uses' => 'GrossEntrollmentRationLevelsController@search'));

Route::post('gross_enrollment_ratio_export', array('as' => 'GrossEnrollmentRationLevelsExport','uses' => 'GrossEntrollmentRationLevelsController@export'));

/*** Pupil/Teacher Ratio by chart ***/
Route::get('teacher_chart_report', array('as' => 'teacher_chart_report', 'uses' => 'TeacherRatioChartController@create'));

Route::post('TeacherRatioChartList', array('as' => 'TeacherRatioChartList', 'uses' => 'TeacherRatioChartController@index'));

/*** Pupil/Teacher Ratio by chart ***/
Route::get('oversize_class_chart', array('as' => 'oversize_class_chart', 'uses' => 'OversizeClassChartController@create'));

Route::post('oversize_class_chart_list', array('as' => 'oversize_class_chart_list', 'uses' => 'OversizeClassChartController@index'));

/*** Attendance < 75% chart ***/
Route::get('StdAttendanceChart', array('as' => 'StdAttendanceChart', 'uses' => 'StudentAttendanceChartController@create'));

Route::post('StdAttendanceChartList', array('as' => 'StdAttendanceChartList', 'uses' => 'StudentAttendanceChartController@index'));

Route::post('attendancelist_export', array('as' => 'StdAttendanceList_export', 'uses' => 'StudentAttendanceController@show'));

/*** % of Grade 1 Intake ***/
Route::get('grade_one_intake', array('as' => 'grade_one_intake', 'uses' => 'PercentageGradeOneIntakeChartController@create'));

Route::post('grade_one_intake_list', array('as' => 'grade_one_intake_list', 'uses' => 'PercentageGradeOneIntakeChartController@index'));