<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* admin panel */

Route::group(['prefix' => 'admin'], function () {
	Auth::routes();
    Route::match(['get','post'],'/','admin\Home@login');
    Route::match(['get','post'],'','admin\Home@login');
	Route::match(['get','post'],'login','admin\Home@login');
	Route::get('logout','admin\Home@logout');
	Route::match(['get','post'],'register','admin\Home@register');

	Route::get('dashboard','admin\Dashboard@index');
	Route::get('orders','admin\Dashboard@home');

	/* setting */
	Route::match(['get','post'],'settings/profile','admin\Setting@profile');
	Route::match(['get','post'],'settings/website','admin\Setting@website');
	Route::get('settings/accounts','admin\Setting@accounts');
	Route::post('settings/mailgun/save','admin\Setting@saveMailgun');
	Route::post('settings/paypal/save','admin\Setting@savePaypal');

	/* user management */
	Route::match(['get','post'],'users/view','admin\Users@viewUsers');
	Route::match(['get','post'],'users/add','admin\Users@addEditUser');
	Route::match(['get','post'],'users/edit/{id}','admin\Users@addEditUser');
	Route::get('users/view/{id}','admin\Users@viewSingleUser');

	Route::delete('user/delete','admin\Users@deleteUser');
	
	Route::match(['get','post'],'users/company','admin\Users@companies');
	Route::match(['get','post'],'users/company/add','admin\Users@addEditCompany');
	Route::match(['get','post'],'users/company/edit/{id}','admin\Users@addEditCompany');
	Route::get('users/company/{id}','admin\Users@viewCompany');
	Route::delete('company/delete','admin\Users@deleteCompany');

	/* cms */
	/* job categories */
	Route::match(['get','post'],'cms/category','admin\Cms@viewCategories');
	Route::post('cms/category/save','admin\Cms@saveCategory');
	Route::get('cms/category/get/{id}','admin\Cms@getCategory');
	Route::delete('cms/category/delete','admin\Cms@deleteCategory');
	Route::match(['get','post'],'cms/category/{id}','admin\Cms@viewSubCategories');
	Route::post('cms/sub-category/save','admin\Cms@saveSubCategory');
	Route::get('cms/sub-category/get/{id}','admin\Cms@getSubCategory');
	Route::delete('cms/sub-category/delete','admin\Cms@deleteSubCategory');

	/* job shift */
	Route::match(['get','post'],'cms/shift','admin\Cms@viewJobShift');
	Route::post('cms/shift/save','admin\Cms@saveJobShift');
	Route::get('cms/shift/get/{id}','admin\Cms@getJobShift');
	Route::delete('cms/shift/delete','admin\Cms@deleteJobShift');

	/* job type */
	Route::match(['get','post'],'cms/jobtype','admin\Cms@viewJobType');
	Route::post('cms/jobtype/save','admin\Cms@saveJobType');
	Route::get('cms/jobtype/get/{id}','admin\Cms@getJobType');
	Route::delete('cms/jobtype/delete','admin\Cms@deleteJobType');

	/* pages */
	Route::get('cms/pages','admin\Cms@viewPages');
	Route::match(['get','post'],'cms/pages/new','admin\Cms@addEditPage');
	Route::match(['get','post'],'cms/pages/edit/{id}','admin\Cms@addEditPage');
	Route::delete('cms/pages/delete','admin\Cms@deletePage');

});

/* frontend */

Route::get('/', 'frontend\Home@home');
Route::match(['get','post'],'contact','frontend\Home@contactUs');
Route::get('about','frontend\Home@aboutUs');
Route::get('terms-conditions','frontend\Home@termConditions');
Route::get('privacy-policy','frontend\Home@privacyPolicy');
Route::match(['get','post'],'account/login','frontend\Home@accountLogin');
Route::match(['get','post'],'account/register','frontend\Home@accountRegister');
Route::get('account/logout','frontend\Home@logout');
Route::get('account/manage','frontend\Home@manageUser');
Route::match(['get','post'],'account/people','frontend\Home@people');Route::match(['get','post'],'account/peoples','frontend\Home@peoples');
Route::get('learn','frontend\Home@learn');
Route::match(['get','post'],'read','frontend\Home@read');
Route::get('read/article/{id}','frontend\Home@viewArticle');
Route::get('learn/conference/{id}','frontend\Home@viewUpskill');
Route::get('learn/course/{id}','frontend\Home@viewUpskill');
Route::get('learn/seminar/{id}','frontend\Home@viewUpskill');
Route::get('learn/training/{id}','frontend\Home@viewUpskill');
Route::get('learn/webinar/{id}','frontend\Home@viewUpskill');
Route::get('learn/workshop/{id}','frontend\Home@viewUpskill');
Route::match(['get','post'],'learn/search','frontend\Home@searchSkills');
Route::match(['get','post'],'companies','frontend\Home@companies');
Route::get('companies/company/{id}','frontend\Home@viewCompany');

Route::group(['prefix' => 'account'], function () {
	/* generals */
	Route::get('writings','frontend\ExtraSkills@writings');
	Route::match(['get','post'],'writings/article/add','frontend\ExtraSkills@addEditArticle');
	Route::match(['get','post'],'writings/article/edit/{id}','frontend\ExtraSkills@addEditArticle');
	Route::get('writings/article/delete/{id}','frontend\ExtraSkills@deleteArticle');

	Route::get('upskill','frontend\ExtraSkills@upskill');
	Route::match(['get','post'],'upskill/add','frontend\ExtraSkills@addEditUpskill');
	Route::match(['get','post'],'upskill/edit/{id}','frontend\ExtraSkills@addEditUpskill');
	Route::get('upskill/delete/{id}','frontend\ExtraSkills@deleteUpskill');

	/* job seeker */
    Route::get('jobseeker','frontend\Jobseeker@home');
    Route::get('jobseeker/resume','frontend\Jobseeker@resume');
    Route::post('jobseeker/resume/personal/save','frontend\Jobseeker@savePersonalInfo');
    Route::get('get-state/{id}','frontend\Jobseeker@getState');
    Route::get('get-city/{id}','frontend\Jobseeker@getCity');
    Route::get('get-subCategory/{id}','frontend\Jobseeker@getSubCategory');
    Route::post('jobseeker/resume/academic/save','frontend\Jobseeker@saveAcademic');
    Route::get('jobseeker/resume/get/{id}','frontend\Jobseeker@getResume');
    Route::get('jobseeker/resume/delete/{id}','frontend\Jobseeker@deleteResume');
    Route::post('jobseeker/resume/certification/save','frontend\Jobseeker@saveCertification');
    Route::post('jobseeker/resume/experience/save','frontend\Jobseeker@saveExperience');
    Route::post('jobseeker/resume/skills/save','frontend\Jobseeker@saveSkills');
    Route::post('jobseeker/profile/picture','frontend\Jobseeker@profilePicture');
    Route::post('password/save','frontend\Jobseeker@savePassword');
    Route::post('profile/save','frontend\Jobseeker@saveProfile');
    Route::get('jobseeker/job/action','frontend\Jobseeker@jobAction');
    Route::get('jobseeker/company/action','frontend\Jobseeker@followAction');
    Route::get('jobseeker/application','frontend\Jobseeker@application');
    Route::get('jobseeker/application/{id}','frontend\Jobseeker@getApplication');
    Route::get('jobseeker/application/remove/{id}','frontend\Jobseeker@removeApplication');
    Route::get('jobseeker/interview/{id}', 'frontend\Jobseeker@showInterview');

    /* employer */
    Route::get('employer','frontend\Employer@home');
    Route::match(['get','post'],'employer/job/new','frontend\Employer@jobPost');
    Route::post('employer/job/save','frontend\Employer@saveJob');
    Route::get('employer/job/share/{id}','frontend\Employer@shareJob');
    Route::get('employer/application','frontend\Employer@application');
    Route::get('employer/application/{id}','frontend\Employer@getApplication');
	Route::get('employer/jobupdate/{id}','frontend\Employer@jobupdate');
	
    Route::post('employer/update/application','frontend\Employer@updateApplication');
    Route::get('employer/interview-venues','frontend\Employer@interviewVenues');
    Route::post('employer/interview-venues/save','frontend\Employer@saveInterviewVeneu');
    Route::get('employer/interview-venues/get/{id}','frontend\Employer@getInterviewVenue');
    Route::get('employer/interview-venues/delete/{id}','frontend\Employer@deleteInterviewVenue');
    Route::get('employer/interview-venues/detail/{id}', 'frontend\Employer@viewInterviewVeneu');
    Route::get('employer/application/applicant/{id}','frontend\Employer@viewApplicant');
	Route::get('employer/application/candidate/{id}','frontend\Employer@viewApplicants');
    Route::get('employer/organization', 'frontend\Employer@organization');
    Route::post('employer/organization/save', 'frontend\Employer@savdOrganization');
    Route::post('employer/organization/about', 'frontend\Employer@aboutOrganization');
    Route::post('employer/company/logo', 'frontend\Employer@companyLogo');
    Route::post('employer/company/cover', 'frontend\Employer@companyCover');
    Route::post('employer/application/interview/save', 'frontend\Employer@saveJobInterview');
    Route::get('employer/departments','frontend\Employer@departments');
    Route::post('employer/department/save','frontend\Employer@saveDepartment');
    Route::get('employer/department/get/{id}','frontend\Employer@getDepartment');
    Route::get('employer/department/delete/{id}','frontend\Employer@deleteDepartment');
	Route::post('post','frontend\Employer@post');
	Route::post('nicepay', 'frontend\Employer@getresponse');
	
	Route::get('employer/nice', function () {
    return view('frontend.employer.nice');
});

Route::get('employer/nicerequest', function () {
    return view('frontend.employer.nicerequest');
});

Route::get('employer/niceresult', function () {
    return view('frontend.employer.niceresult');
});

    Route::post('notification/save','frontend\Employer@saveNotification');
    Route::post('privacy/save','frontend\Employer@savePrivacy');
});

/* jobs */
Route::get('jobs','frontend\Jobs@home');
Route::post('jobs/search','frontend\Jobs@searchJobs');
Route::match(['get','post'],'jobs/{id}','frontend\Jobs@viewJob');
Route::match(['get','post'],'jobs/apply/{id}','frontend\Jobs@jobApply');

Route::get('/not-found','Home@notFound');
Route::get('/send-email','Home@sendEmail');
Route::get('send_test_email', function(){
	Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
	{
		$message->subject('Mailgun and Laravel are awesome!');
		$message->from('no-reply@peekinternational.com', 'Job Call Me');
		$message->to('mu.cp15@gmail.com');
	});
});
 Route::get('account/jobseeker/cv','frontend\Jobseeker@convertpdf');
Route::get('download', function () {
    return view('frontend.employer.download');
});
Route::get('career-tab', function () {
    return view('frontend.employer.career-tab');
});
Route::get('test', function () {
    return view('welcome');
});
Route::get('messages', function () {
    return view('frontend.employer.employerMessenger');
});
Route::get('account/employer/job/share', array('as' => 'addmoney.account/employer/job/share','uses' => 'frontend\Employer@jobupdate',));
Route::post('employer/update', array('as' => 'addmoney.paypal','uses' => 'frontend\Employer@update',));
Route::get('employer/update', array('as' => 'payment.edit','uses' => 'frontend\Employer@updateStatus',));

Route::get('account/employer/job/share', array('as' => 'addmoney.account/employer/job/share','uses' => 'frontend\Employer@payWithPaypal',));
Route::get('account/employer/payment', array('as' => 'addmoney.account/employer/payment','uses' => 'frontend\Employer@payWithPaypals',));
Route::post('paypals', array('as' => 'addmoney.paypals','uses' => 'frontend\Employer@postPaymentWithpaypals'));
Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'frontend\Employer@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status','uses' => 'frontend\Employer@getPaymentStatus',));


Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('nice', function () {
    return view('frontend.nice');
});