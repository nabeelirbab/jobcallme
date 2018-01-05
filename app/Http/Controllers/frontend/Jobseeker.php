<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;
use PDF;

class Jobseeker extends Controller{

	public function home(Request $request){
		if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}
    	$app = $request->session()->get('jcmUser');

		$meta = JobCallMe::getUserMeta($app->userId);
		$savedJobArr = @explode(',', $meta->saved);
		$followArr = @explode(',', $meta->follow);

		/* Saved Jobs*/
		$savedJobs = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyName','jcm_companies.companyLogo')
						->join('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')
						->whereIn('jcm_jobs.jobId',$savedJobArr)
						->get();

		/* suggested jobs */
		$suggested = $this->suggestedJob($meta);
		/* job application */
		$application = $this->jobApplication();

		/* job interviews */
		$interview = $this->jobInterviews();

		/* companies */
		$company = DB::table('jcm_companies');
    	$company->orderBy('companyId','desc');
    	$company->limit(8);
    	$companies = $company->get();

    	$followArr = array();
		if($request->session()->has('jcmUser')){
			$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
			$savedJobArr = @explode(',', $meta->saved);
			$followArr = @explode(',', $meta->follow);
		}

		return view('frontend.jobseeker.dashboard',compact('savedJobs','suggested','application','interview','companies','followArr'));
	}

	public function suggestedJob($meta){
		$app = Session()->get('jcmUser');
		$country = $app->country;

		$jobs = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyName','jcm_companies.companyLogo');
		$jobs->join('jcm_companies','jcm_jobs.companyId','=','jcm_companies.companyId');
		$jobs->where('jcm_jobs.country','=',$country);
		if(count($meta) > 0){
			$jobs->where('jcm_jobs.category','=',$meta->industry);
		}
		$jobs->orderBy('jobId','desc')->limit(20);
		return $jobs->get();
	}

	public function jobApplication(){
		$app = Session()->get('jcmUser');

		$appl = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyName','jcm_companies.companyLogo','jcm_job_applied.applyTime')
					->join('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')
					->join('jcm_job_applied','jcm_job_applied.jobId','=','jcm_jobs.jobId')
					->where('jcm_job_applied.userId','=',$app->userId)
					->orderBy('jcm_job_applied.applyId','desc')
					->get();

		return $appl;
	}

	public function jobInterviews(){
		$app = Session()->get('jcmUser');

		$appl = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyName','jcm_companies.companyLogo','jcm_job_applied.applyTime')
					->join('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')
					->join('jcm_job_applied','jcm_job_applied.jobId','=','jcm_jobs.jobId')
					->where('jcm_job_applied.userId','=',$app->userId)
					->where('jcm_job_applied.applicationStatus','Interview')
					->orderBy('jcm_job_applied.applyId','desc')
					->get();

		return $appl;
	}

	public function resume(Request $request){
		if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}

		$app = $request->session()->get('jcmUser');
		$user = DB::table('jcm_users')->where('userId',$app->userId)->first();
		$meta = DB::table('jcm_users_meta')->where('userId',$app->userId)->first();
		$resume = $this->userResume($app->userId);
		//print_r($user);exit;
		return view('frontend.jobseeker.resume',compact('user','meta','resume'));
	}

	public function userResume($userId){
		$record = DB::table('jcm_resume')->where('userId','=',$userId)->orderBy('resumeId','asc')->get();
		$return = array();
		foreach($record as $rec){
			$return[$rec->type][$rec->resumeId] = @json_decode($rec->resumeData);
		}
		return $return;
	}

	public function getState(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$countryId = $request->segment(3);
		$cities = JobCallMe::getJobStates($countryId);
		echo @json_encode($cities);
	}

	public function getCity(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$stateId = $request->segment(3);
		$cities = JobCallMe::getJobCities($stateId);
		echo @json_encode($cities);
	}

	public function getSubCategory(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$categoryId = $request->segment(3);
		$result = JobCallMe::getSubCategories($categoryId);
		echo @json_encode($result);
	}

	public function savePersonalInfo(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'firstName' => 'required|min:2|max:50',
				'lastName' => 'required|min:2|max:50',
				'fatherName' => 'required|min:2|max:50',
				'cnicNumber' => 'required|max:15',
				'gender' => 'required',
				'maritalStatus' => 'required',
				'dateOfBirth' => 'required|date',
				'email' => 'required|email',
				'phoneNumber' => 'required|numeric',
				'address' => 'required|max:255',
				'country' => 'required',
				'city' => 'required',
				'state' => 'required',
				'education' => 'required',
				'industry' => 'required',
				'experiance' => 'required',
				'currentSalary' => 'required|numeric',
				'expectedSalary' => 'required|numeric',
				'currency' => 'required',
				'expertise' => 'required',
				'about' => 'required',
				'facebook' => 'nullable|url',
				'linkedin' => 'nullable|url',
				'twitter' => 'nullable|url',
				'website' => 'nullable|url',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','<>',$app->userId)->where('email','=',$email)->first();
		if(count($isUser) > 0){
			exit('User with give email already exist');
		}

		$userQry = array('firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phoneNumber' => $phoneNumber, 'country' => $country, 'state' => $state, 'city' => $city, 'about' => $about);
		DB::table('jcm_users')->where('userId',$app->userId)->update($userQry);

		$metaQry = array('fatherName' => $fatherName, 'dateOfBirth' => $dateOfBirth, 'gender' => $gender, 'maritalStatus' => $maritalStatus, 'experiance' => $experiance, 'education' => $education, 'industry' => $industry, 'currency' => $currency, 'currentSalary' => $currentSalary, 'expectedSalary' => $expectedSalary, 'cnicNumber' => $cnicNumber, 'address' => $address, 'expertise' => $expertise, 'facebook' => '', 'linkedin' => '', 'twitter' => '', 'website' => '');
		if($facebook != '') $metaQry['facebook'] = $facebook;
		if($linkedin != '') $metaQry['linkedin'] = $linkedin;
		if($twitter != '') $metaQry['twitter'] = $twitter;
		if($website != '') $metaQry['website'] = $website;

		if($metaId != '' && $metaId != '0' && $metaId != NULL){
			DB::table('jcm_users_meta')->where('metaId','=',$metaId)->update($metaQry);
		}else{
			$metaQry['follow'] = '';
			$metaQry['saved'] = '';
			$metaQry['userId'] = $app->userId;
			$metaQry['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_users_meta')->insert($metaQry);
		}
		exit('1');
	}

	public function saveAcademic(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'degreeLevel' => 'required',
				'degree' => 'required|max:100',
				'completionDate' => 'required|date',
				'grade' => 'required|max:10',
				'institution' => 'required|max:150',
				'country' => 'required'
			]);

		extract(array_map('trim', $request->all()));

		$academicQry = array('degreeLevel' => $degreeLevel, 'degree' => $degree, 'completionDate' => $completionDate, 'grade' => $grade, 'institution' => $institution, 'country' => $country, 'details' => $details);

		$input = array('type' => 'academic', 'resumeData' => @json_encode($academicQry));

		if($resumeId != '' && $resumeId != '0' && $resumeId != NULL){
			DB::table('jcm_resume')->where('resumeId','=',$resumeId)->update($input);
		}else{
			$input['userId'] = $app->userId;
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_resume')->insert($input);
		}
		exit('1');
	}

	public function getResume(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$resumeId = $request->segment(5);
		$record = DB::table('jcm_resume')->select('resumeData')->where('resumeId','=',$resumeId)->first();
		echo $record->resumeData;
	}

	public function deleteResume(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$resumeId = $request->segment(5);
		DB::table('jcm_resume')->where('resumeId','=',$resumeId)->delete();
	}

	public function saveCertification(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'certificate' => 'required|max:100',
				'completionDate' => 'required|date',
				'score' => 'required|max:10',
				'institution' => 'required|max:150',
				'country' => 'required'
			]);

		extract(array_map('trim', $request->all()));

		$certificationQry = array('certificate' => $certificate, 'completionDate' => $completionDate, 'score' => $score, 'institution' => $institution, 'country' => $country, 'details' => $details);

		$input = array('type' => 'certification', 'resumeData' => @json_encode($certificationQry));

		if($resumeId != '' && $resumeId != '0' && $resumeId != NULL){
			DB::table('jcm_resume')->where('resumeId','=',$resumeId)->update($input);
		}else{
			$input['userId'] = $app->userId;
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_resume')->insert($input);
		}
		exit('1');
	}

	public function saveExperience(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'jobTitle' => 'required|max:255',
				'organization' => 'required|max:255',
				'startDate' => 'required|date',
				'country' => 'required'
			]);

		extract(array_map('trim', $request->all()));

		if($currently != 'yes'){
			$this->validate($request, ['endDate' => 'required|date']);
			$currently = 'no';
		}

		$experienceQry = array('jobTitle' => $jobTitle, 'organization' => $organization, 'currently' => $currently, 'startDate' => $startDate, 'country' => $country, 'details' => $details);
		if($currently == 'no'){
			$experienceQry['endDate'] = $endDate;
		}

		$input = array('type' => 'experience', 'resumeData' => @json_encode($experienceQry));

		if($resumeId != '' && $resumeId != '0' && $resumeId != NULL){
			DB::table('jcm_resume')->where('resumeId','=',$resumeId)->update($input);
		}else{
			$input['userId'] = $app->userId;
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_resume')->insert($input);
		}
		exit('1');
	}

	public function saveSkills(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'skill' => 'required|max:255',
				'level' => 'required'
			]);

		extract(array_map('trim', $request->all()));

		$skillsQry = array('skill' => $skill, 'level' => $level);

		$input = array('type' => 'skills', 'resumeData' => @json_encode($skillsQry));

		if($resumeId != '' && $resumeId != '0' && $resumeId != NULL){
			DB::table('jcm_resume')->where('resumeId','=',$resumeId)->update($input);
		}else{
			$input['userId'] = $app->userId;
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_resume')->insert($input);
		}
		exit('1');
	}

	public function savePassword(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'oldPassword' => 'required|max:16',
				'password' => 'required|min:6|max:16|confirmed',
				'password_confirmation' => 'required|min:6|max:16',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','=',$app->userId)->where('password','=',md5($oldPassword))->first();
		if(count($isUser) == 0){
			exit('Exisitng password is not valid');
		}

		$input = array('password' => md5($password));
		DB::table('jcm_users')->where('userId','=',$app->userId)->update($input);
		exit('1');
	}

	public function saveProfile(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'firstName' => 'required|max:50',
				'lastName' => 'required|max:50',
				'email' => 'required|max:255|email',
				'phoneNumber' => 'required|numeric',
				'city' => 'required',
				'state' => 'required',
				'address' => 'required',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','<>',$app->userId)->where('email','=',$email)->first();
		if(count($isUser) > 0){
			exit('Email alrady exist');
		}

		$input = array('firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phoneNumber' => $phoneNumber, 'city' => $city, 'state' => $state, 'country' => $country);
		DB::table('jcm_users')->where('userId','=',$app->userId)->update($input);

		if(count(JobCallMe::getUserMeta($app->userId)) > 0){
			DB::table('jcm_users_meta')->where('userId','=',$app->userId)->update(array('address' => $address));
		}else{
			$input = array('userId' => $app->userId, 'address' => $address, 'createdTime' => date('Y-m-d H:i:s'));
			DB::table('jcm_users_meta')->insert($input);
		}
		exit('1');
	}

	public function profilePicture(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');

		$fName = $_FILES['profilePicture']['name'];
		$ext = @end(@explode('.', $fName));
		if(!in_array(strtolower($ext), array('png','jpg','jpeg'))){
			exit('1');
		}
		$user = DB::table('jcm_users')->where('userId',$app->userId)->first();
		
		$pImage = '';
		if($user->profilePhoto != ''){
			$pImage = $user->profilePhoto;
		}

		$image = $request->file('profilePicture');
		$profilePicture = 'profile-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();       
        $destinationPath = public_path('/profile-photos');
        $image->move($destinationPath, $profilePicture);

        if($pImage != ''){
            @unlink(public_path('/profile-photos/'.$pImage));
        }
        DB::table('jcm_users')->where('userId',$app->userId)->update(array('profilePhoto' => $profilePicture));
        echo url('profile-photos/'.$profilePicture);
	}

	public function jobAction(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$jobId = $request->input('jobId');
		$type = $request->input('type');

		if(!$request->session()->has('jcmUser')){
    		exit('redirect');
    	}
    	
    	$meta = JobCallMe::getUserMeta($app->userId);
    	if(count($meta) > 0){
    		$savedJobs = array();
    		if($meta->saved != ''){
    			$savedJobs = @explode(',', $meta->saved);
    		}
    		$savedJobs = JobCallMe::doArrayAction($type,$jobId,$savedJobs);
    		$input['saved'] = @implode(',', $savedJobs);
    		DB::table('jcm_users_meta')->where('metaId','=',$meta->metaId)->update($input);
    	}else{
    		$savedJobs = array($jobId);
    		$input = array('userId' => $app->userId, 'saved' => @implode(',', $savedJobs), 'createdTime' => date('Y-m-d H:i:s'), 'fatherName' => '', 'dateOfBirth' => '1979-12-31', 'gender' => '', 'maritalStatus' => '', 'experiance' => '', 'education' => '', 'industry' => '0', 'currentSalary' => '', 'expectedSalary' => '', 'currency' => '', 'cnicNumber' => '', 'address' => '', 'expertise' => '', 'facebook' => '', 'linkedIn' => '', 'twitter' => '', 'website' => '', 'follow' => '');
    		DB::table('jcm_users_meta')->insert($input);
    	}
    	exit('done');
	}

	public function followAction(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$companyId = $request->input('companyId');
		$type = $request->input('type');

		if(!$request->session()->has('jcmUser')){
    		exit('redirect');
    	}
    	
    	$meta = JobCallMe::getUserMeta($app->userId);
    	if(count($meta) > 0){
    		$followArr = array();
    		if($meta->follow != ''){
    			$followArr = @explode(',', $meta->follow);
    		}
    		$followArr = JobCallMe::doArrayAction($type,$companyId,$followArr);
    		$input['follow'] = @implode(',', $followArr);
    		DB::table('jcm_users_meta')->where('metaId','=',$meta->metaId)->update($input);
    	}else{
    		$followArr = array($companyId);
    		$input = array('userId' => $app->userId, 'follow' => @implode(',', $followArr), 'createdTime' => date('Y-m-d H:i:s'), 'fatherName' => '', 'dateOfBirth' => '1979-12-31', 'gender' => '', 'maritalStatus' => '', 'experiance' => '', 'education' => '', 'industry' => '0', 'currentSalary' => '', 'expectedSalary' => '', 'currency' => '', 'cnicNumber' => '', 'address' => '', 'expertise' => '', 'facebook' => '', 'linkedIn' => '', 'twitter' => '', 'website' => '', 'saved' => '');
    		DB::table('jcm_users_meta')->insert($input);
    	}
    	exit('done');
	}

	public function application(Request $request){
		if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}

		$app = $request->session()->get('jcmUser');
		$user_name = $app->firstName.' '.$app->lastName;

		return view('frontend.jobseeker.view-application',compact('user_name'));
	}

	public function getApplication(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$type = $request->segment(4);

		switch ($type) {
			case 'delivered':
				$record = DB::table('jcm_job_applied')
					->select('jcm_jobs.title','jcm_job_applied.applyId','jcm_job_applied.applyTime','jcm_job_applied.jobId','jcm_users.*','jcm_users_meta.*','jcm_jobs.companyId')
					->join('jcm_users','jcm_users.userId','=','jcm_job_applied.userId')
					->join('jcm_users_meta','jcm_users_meta.userId','=','jcm_job_applied.userId')
					->join('jcm_jobs','jcm_jobs.jobId','=','jcm_job_applied.jobId')
					->where('jcm_job_applied.userId','=',$app->userId)
					->orderBy('jcm_job_applied.applyId','desc')
					->get();
			break;
			
			default:
				$record = DB::table('jcm_job_applied')
					->select('jcm_jobs.title','jcm_job_applied.applyId','jcm_job_applied.applyTime','jcm_job_applied.jobId','jcm_users.*','jcm_users_meta.*','jcm_jobs.companyId')
					->join('jcm_users','jcm_users.userId','=','jcm_job_applied.userId')
					->join('jcm_users_meta','jcm_users_meta.userId','=','jcm_job_applied.userId')
					->join('jcm_jobs','jcm_jobs.jobId','=','jcm_job_applied.jobId')
					->where('jcm_job_applied.userId','=',$app->userId)
					->where('jcm_job_applied.applicationStatus','=',ucfirst($type))
					->orderBy('jcm_job_applied.applyId','desc')
					->get();
		}
		

		if(count($record) > 0){
			$appType = $type;
			if($appType == 'reject') $appType = 'unsuccessful';
			$vhtml  = '<ul>';


			switch ($type) {
				case 'shortlist':
					$fontIcon = 'thumbs-o-up';
				break;

				case 'interview':
					$fontIcon = 'car';
				break;

				case 'offer':
					$fontIcon = 'thumbs-up';
				break;

				case 'reject':
					$fontIcon = 'thumbs-down';
				break;
				
				default:
					$fontIcon = 'check';
				break;
			}
			foreach($record as $rec){
				$company = JobCallMe::getCompany($rec->companyId);
				$companyPhoto = url('compnay-logo/'.$company->companyLogo);

				$vhtml .= '<li id="apply-'.$rec->applyId.'">';
					$vhtml .= '<span class="ja-applyDate">'.date('M d, Y',strtotime($rec->applyTime)).' <a href="javascript:;" class="application-remove" title="Remove/Cancel Application" onclick="removeApplication('.$rec->applyId.')">&times;</a></span>';
					$vhtml .= '<img src="'.$companyPhoto.'" class="ja-item-img">';
					$vhtml .= '<div class="ja-item-details">';
						$vhtml .= '<p class="ja-item-title"><a href="'.url('jobs/'.$rec->jobId).'" >'.$rec->title.'</a></p>';
						$vhtml .= '<p class="ja-item-organization">'.$company->companyName.'</p>';
						if($type == 'interview'){
							$getInterview = JobCallMe::getJobInterview($rec->jobId,$rec->userId);
							$interviewUrl = url('account/jobseeker/interview/'.$getInterview->interviewId);
							$vhtml .= '<p class="ja-item-status"><a href="'.$interviewUrl.'"><i class="fa fa-'.$fontIcon.'"></i> '.ucfirst($appType).'</a></p>';
						}else{
							$vhtml .= '<p class="ja-item-status"><i class="fa fa-'.$fontIcon.'"></i> '.ucfirst($appType).'</p>';
						}
					$vhtml .= '</div>';
				$vhtml .= '</li>';
			}
			$vhtml .= '</ul>';
		}else{
			$vhtml = '<div class="col-md-12 ea-no-record">No records found.</div>';
		}
		echo $vhtml;
	}

	public function removeApplication(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$applyId = $request->segment(5);
		//echo $applyId;

		DB::table('jcm_job_applied')->where('applyId','=',$applyId)->delete();
	}

	public function showInterview(Request $request, $interviewId){
		$app = $request->session()->get('jcmUser');
		/* get interview */
		$interview = DB::table('jcm_job_interviews')
						->select('jcm_job_interviews.*','jcm_jobs.title')
						->join('jcm_jobs','jcm_jobs.jobId','=','jcm_job_interviews.jobId')
						->where('jcm_job_interviews.interviewId','=',$interviewId)
						->where('jcm_job_interviews.jobseekerId','=',$app->userId)
						->first();
		/* end */

		if(count($interview) != 1){
			return redirect('account/jobseeker/application');
		}
		return view('frontend.jobseeker.view-interview',compact('interview'));
	}
	public function convertpdf(Request $request){
		$app = $request->session()->get('jcmUser');
		
		$user = DB::table('jcm_users')->where('userId',$app->userId)->first();
		$name= $user->firstName;
		//return $name;
		$meta = DB::table('jcm_users_meta')->where('userId',$app->userId)->first();
		$resume = $this->userResume($app->userId);
	//return view('frontend.jobseeker.resume');
    	  $pdf = PDF::loadView('frontend.cv',compact('user','meta','resume'));
          return $pdf->download($name.'_cv.pdf');
	}
}
