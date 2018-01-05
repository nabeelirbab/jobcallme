<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;

class Jobs extends Controller{
    public function home(){
		return view('frontend.view-jobs');
	}

	public function searchJobs(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$_find = trim($request->input('_find'));
		$keyword = trim($request->input('keyword'));
		$categoryId = trim($request->input('categoryId'));
		$jobType = trim($request->input('jobType'));
		$jobShift = trim($request->input('jobShift'));
		$careerLevel = trim($request->input('careerLevel'));
		$experience = trim($request->input('experience'));
		$minSalary = trim($request->input('minSalary'));
		$maxSalary = trim($request->input('maxSalary'));
		$country = trim($request->input('country'));
		$state = trim($request->input('state'));
		$city = trim($request->input('city'));
		$currency = trim($request->input('currency'));
		$userinfo=$request->session()->get('jcmUser')->userId;
		//dd($userinfo);

		$savedJobArr = array();
		if($request->session()->has('jcmUser')){
			$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
			$savedJobArr = @explode(',', $meta->saved);
		}

		$jobs = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyName','jcm_companies.companyLogo');
		$jobs->join('jcm_companies','jcm_jobs.companyId','=','jcm_companies.companyId');
		$jobs->where('jcm_jobs.expiryDate','>=',date('Y-m-d'));
		//$jobs->where('jcm_jobs.country','=',$country);
		/*if($_find == '0'){
			if($request->session()->has('jcmUser')){
				$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
				if($meta->industry != '0' && $meta->industry != ''){
					$jobs->where('jcm_jobs.category','=',$meta->industry);
				}
			}
		}*/
		if($country != '0') $jobs->where('jcm_jobs.country','=',$country);
		if($categoryId != '') $jobs->where('jcm_jobs.category','=',$categoryId);
		if($jobType != '') $jobs->where('jcm_jobs.jobType','=',$jobType);
		if($jobShift != '') $jobs->where('jcm_jobs.jobShift','=',$jobShift);
		if($careerLevel != '') $jobs->where('jcm_jobs.careerLevel','=',$careerLevel);
		if($experience != '') $jobs->where('jcm_jobs.experience','=',$experience);
		if($minSalary != '') $jobs->where('jcm_jobs.minSalary','<=',$minSalary);
		if($maxSalary != '') $jobs->where('jcm_jobs.maxSalary','>=',$maxSalary);
		if($state != '0') $jobs->where('jcm_jobs.state','=',$city);
		if($city != '0') $jobs->where('jcm_jobs.city','=',$city);
		if($currency != '') $jobs->where('jcm_jobs.currency','=',$currency);

		if($keyword != ''){
			$jobs->where(function ($query) use ($keyword) {
				$expl = @explode(' ', $keyword);
				foreach($expl as $kw){
					$query->orWhere('jcm_jobs.title','LIKE','%'.$kw.'%');
					$query->orWhere('jcm_jobs.skills','LIKE','%'.$kw.'%');
				}
			});
		}

		$result = $jobs->orderBy('jobId','desc')->limit(100)->get();
		//dd($result);

		$vhtml = '';
		if(count($result) > 0){
			foreach($result as $rec){
				$applyUrl = url('jobs/apply/'.$rec->jobId);
				$viewUrl = url('jobs/'.$rec->jobId);
				$vhtml .= '<div class="jobs-suggestions">';
				if($rec->userId == $userinfo ){
					$vhtml .= '<div class="js-action" style="display:none">';
                        //$vhtml .= '<a href="'.$applyUrl.'" class="btn btn-primary btn-xs"></a>';
                        if(in_array($rec->jobId, $savedJobArr)){
	                        //$vhtml .= '<a href="javascript:;" onclick="saveJob('.$rec->jobId.',this)" class="btn btn-success btn-xs" style="margin-left: 10px;"></a>';
	                    }else{
	                    	//$vhtml .= '<a href="javascript:;" onclick="saveJob('.$rec->jobId.',this)" class="btn btn-default btn-xs" style="margin-left: 10px;"></a>';
	                    }
                    $vhtml .= '</div>';
				}
				else{
					$vhtml .= '<div class="js-action">';
                        $vhtml .= '<a href="'.$applyUrl.'" class="btn btn-primary btn-xs">Applied</a>';
                        if(in_array($rec->jobId, $savedJobArr)){
	                        $vhtml .= '<a href="javascript:;" onclick="saveJob('.$rec->jobId.',this)" class="btn btn-success btn-xs" style="margin-left: 10px;">Saved</a>';
	                    }else{
	                    	$vhtml .= '<a href="javascript:;" onclick="saveJob('.$rec->jobId.',this)" class="btn btn-default btn-xs" style="margin-left: 10px;">Save</a>';
	                    }
                    $vhtml .= '</div>';
				}
				$colorArr = array('purple','green','darkred','orangered','blueviolet');
                    $vhtml .= '<h4><a href="'.$viewUrl.'">'.$rec->title.' <span class="label" style="background-color:'.$colorArr[array_rand($colorArr)].'">' .$rec->p_Category.'</span></a></h4>';
                    $vhtml .= '<p>'.$rec->companyName.'</p>';
                    $vhtml .= '<ul class="js-listing">';
                    	$vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Job Type</p>';
                            $vhtml .= '<p>'.$rec->jobType.'</p>';
                        $vhtml .= '</li>';
                        $vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Shift</p>';
                            $vhtml .= '<p>'.$rec->jobShift.'</p>';
                        $vhtml .= '</li>';
                        $vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Experience</p>';
                            $vhtml .= '<p>'.$rec->experience.'</p>';
                        $vhtml .= '</li>';
                        $vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Salary</p>';
                            $vhtml .= '<p>'.$rec->minSalary.' - '.$rec->maxSalary.' '.$rec->currency.'</p>';
                        $vhtml .= '</li>';
						$vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Post On</p>';
                            $vhtml .= '<p>'.date('M d, Y',strtotime($rec->createdTime)).'</p>';
                        $vhtml .= '</li>';
						$vhtml .= '<li>';
                            $vhtml .= '<p class="js-title">Last Date</p>';
                            $vhtml .= '<p>'.date('M d, Y',strtotime($rec->expiryDate)).'</p>';
                        $vhtml .= '</li>';
                    $vhtml .= '</ul>';
                    $cLogo = url('compnay-logo/default-logo.jpg');
                    if($rec->companyLogo != ''){
                    	$cLogo = url('compnay-logo/'.$rec->companyLogo);
                    }
                    $vhtml .= '<p class="js-note">'.$rec->description.'<img src="'.$cLogo.'" width="100"></p>';
                    $vhtml .= '<p class="js-location"><i class="fa fa-map-marker"></i> '.JobCallMe::cityName($rec->city).', '.JobCallMe::countryName($rec->country).'<span class="pull-right" style="color: #999999;">'.date('M d,Y',strtotime($rec->createdTime)).'</span></p>';
				$vhtml .= '</div>';
			}
		}else{
			$vhtml  = '<div class="jobs-suggestions">';
				$vhtml .= '<p class="js-note" style="text-align:center;">No Matching record found</p>';
			$vhtml .= '</div>';
		}
		echo $vhtml;
	}

	public function viewJob(Request $request){
		$jobId = $request->segment(2);
		$jobrs = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.*');
		$jobrs->join('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId');
		$jobrs->where('jcm_jobs.jobId','=',$jobId);
		$job = $jobrs->first();
		//dd($job);
		$userId = $request->session()->get('jcmUser')->userId;
		//dd($userId);

		if(count($job) == 0){
			return redirect('jobs');
		}

		$savedJobArr = array();
		$followArr = array();
		if($request->session()->has('jcmUser')){
			$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
			$savedJobArr = @explode(',', $meta->saved);
			$followArr = @explode(',', $meta->follow);
		}

		return view('frontend.view-job-detail',compact('job','savedJobArr','followArr','userId'));
		//print_r($job);
	}

	public function jobApply(Request $request){
		$app = $request->session()->get('jcmUser');

		if(JobCallMe::isResumeBuild($app->userId) == false){
			$fNotice = 'To apply on jobs please build your resume. <a href="'.url('account/jobseeker/resume').'">Click Here</a> To create your resume';
			$request->session()->put('fNotice',$fNotice);
			return redirect('account/jobseeker/resume');
		}
		if($request->isMethod('post')){
			if(!$request->session()->has('jcmUser')){
	    		return redirect('account/login?next='.$request->route()->uri);
	    	}

	    	$jobId = trim($request->input('jobId'));

	    	$input = array('userId' => $app->userId, 'jobId' => $jobId, 'applyTime' => date('Y-m-d H:i:s'));
	    	DB::table('jcm_job_applied')->insert($input);
	    	return redirect('account/jobseeker');
		}else{
			$jobId = $request->segment(3);
			$job = DB::table('jcm_jobs')->where('jobId','=',$jobId)->first();

			if(count($job) == 0){
				return redirect('jobs');
			}

			$jobApplied = JobCallMe::isAppliedToJob($app->userId,$jobId);

			return view('frontend.job-apply',compact('job','jobApplied'));
		}
	}
}
