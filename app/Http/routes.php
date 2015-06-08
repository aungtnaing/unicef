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
Route::get('school_informations', array('as' => 'TypeReport', 'uses' => 'TypeReportController@create'));

Route::post('school_informations', array('as' => 'TypeReportList', 'uses' => 'TypeReportController@index'));

/** School Type Report Detail **/
Route::get('school_information_detail', array('as' => 'TypeReportDetail', 'uses' => 'TypeReportDetailController@create'));

Route::post('school_information_detail', array('as' => 'TypeReportDetailList', 'uses' => 'TypeReportDetailController@index'));

/** Perminent/Temporary Classroom **/
Route::get('perminent_temporary_classroom', array('as' => 'calssroom', 'uses' => 'PermenantTemporaryController@create'));

Route::post('perminent_temporary_classroom', array('as' => 'calssroom_list', 'uses' => 'PermenantTemporaryController@index'));

/** Perminent/Temporary Classroom Detail **/
Route::get('perminent_temporary_classroom_detail', array('as' => 'calssroom_detail', 'uses' => 'PerminentTemporaryDetailController@create'));

Route::post('perminent_temporary_classroom_detail', array('as' => 'calssroom_detail_list', 'uses' => 'PerminentTemporaryDetailController@index'));

/** Transition rate from primary to middle **/
Route::get('transition_rate_primary_middle', array('as' => 'transition_rate_primary_to_middle', 'uses' => 'TransitionRatePrimaryToMiddleController@create'));

Route::post('transition_rate_primary_middle', array('as' => 'transition_rate_primary_to_middle_list', 'uses' => 'TransitionRatePrimaryToMiddleController@index'));

/** Transition rate from middle to high **/
Route::get('transition_rate_middle_to_high', array('as' => 'transition_rate_middle_to_high', 'uses' => 'TransitionRateMiddleToHighController@create'));

Route::post('transition_rate_middle_to_high', array('as' => 'transition_rate_midlle_to_high_list', 'uses' => 'TransitionRateMiddleToHighController@index'));

/** high school level retention rate **/
Route::get('high_school_level_retention_rate', array('as' => 'high_school_level_retention_rate', 'uses' => 'HighSchoolLevelController@create'));

Route::post('high_school_level_retention_rate', array('as' => 'high_school_level_retention_rate_list', 'uses' => 'HighSchoolLevelController@index'));

/** completion rate high school level **/
Route::get('high_school_level_completion_rate', array('as' => 'high_school_level_completion_rate', 'uses' => 'HighSchoolLevelCompletionRateController@create'));

Route::post('high_school_level_completion_rate', array('as' => 'high_school_level_completion_rate_list', 'uses' => 'HighSchoolLevelCompletionRateController@index'));

/** Promotion Rate for Grade 5, 9, 11 **/
Route::get('promotion_rate_for_grade_5_or_9_or_11', array('as' => 'promotion_rate_for_grade_5_or_9_or_11', 'uses' => 'PromotionRateGrade5911Controller@create'));

Route::post('promotion_rate_for_grade_5_or_9_or_11', array('as' => 'promotion_rate_for_grade_5_or_9_or_11_list', 'uses' => 'PromotionRateGrade5911Controller@index'));

/** Pupil Class Ratio By Grade **/
Route::get('pupil_class_ratio_by_grade', array('as' => 'pupil_class_ratio_by_grade', 'uses' => 'PupilClassRatioByGradeController@create'));

Route::post('pupil_class_ratio_by_grade', array('as' => 'pupil_class_ratio_by_grade_list', 'uses' => 'PupilClassRatioByGradeController@index'));

/** Percentage of Oversized Classes **/
Route::get('percentage_of_oversized_classes', array('as' => 'percentage_of_oversized_classes', 'uses' => 'PercentageOfOversizedClassController@create'));

Route::post('percentage_of_oversized_classes', array('as' => 'percentage_of_oversized_classes_list', 'uses' => 'PercentageOfOversizedClassController@index'));

/** Student Sanitation **/
Route::get('sanitationfrm', array('as' => 'StdSanitation', 'uses' => 'SanitationStudentRatioController@create'));

Route::post('sanitationfrm', array('as' => 'SearchStdSanitation', 'uses' => 'SanitationStudentRatioController@search'));

/** Student Enrollment **/
Route::get('enrollmentfrm', array('as' => 'StdEnrollment', 'uses' => 'StudentEnrollmentController@create'));

Route::post('enrollmentfrm', array('as' => 'SearchStdEnrollment', 'uses' => 'StudentEnrollmentController@search'));

/** get township **/
Route::post('townships', 'SearchFormController@index');
/** Teacher Ratio **/
Route::get('teacher_ratio', array('as' => 'TeacherRatio', 'uses' => 'TeacherRatioCpntroller@create'));

Route::post('teacher_ratio', array('as' => 'TeacherRatioSearch', 'uses' => 'TeacherRatioCpntroller@Search'));

/** Teacher Ratio By Township **/
Route::get('teacher_ratio_by_township', array('as' => 'TeacherRatioByTownship', 'uses' => 'TeacherRatioByTownshipController@create'));

Route::post('teacher_ratio_by_township', array('as' => 'TeacherRatioByTownshipSearch', 'uses' => 'TeacherRatioByTownshipCpntroller@Search'));
/** Gross Enrollment Ratio **/
Route::get('grade_one_per',array('as' => 'GradeOnePer','uses' => 'PercentGradeOneIntakeController@create'));

Route::post('grade_one_per',array('as' => 'SearchGradeOnePer','uses' => 'PercentGradeOneIntakeController@search'));

Route::get('percent_girls', array('as' => 'PercentGrilLevel','uses' => 'PercentGirlLevelController@create'));

Route::post('percent_girls', array('as' => 'SearchPercentGrilLevel','uses' => 'PercentGirlLevelController@search'));

Route::get('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRation','uses' => 'GrossEntrollmentRationLevelsController@create'));

Route::post('gross_enrollment_ratio', array('as' => 'GrossEnrollmentRationLevels','uses' => 'GrossEntrollmentRationLevelsController@search'));

Route::get('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatio','uses' => 'CombinedEnrollmentRatioController@create'));

Route::post('combined_enrollment_ratio', array('as' => 'CombinedGrossEnrollmentRatioLevels','uses' => 'CombinedEnrollmentRatioController@search'));

/*** Student Flow Rates ***/
Route::get('promotion_rate', array('as' => 'PromotionRate','uses' => 'PromotionRateGradeController@create'));

Route::post('promotion_rate', array('as' => 'PromotionRateGrade','uses' => 'PromotionRateGradeController@search'));

Route::get('net_intake_rate', array('as' => 'NetIntakeRate','uses' => 'NetIntakeRateController@create'));

Route::post('net_intake_rate', array('as' => 'NetIntakeRateNIR','uses' => 'NetIntakeRateController@search'));