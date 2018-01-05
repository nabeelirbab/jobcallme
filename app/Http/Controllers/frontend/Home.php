<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;

class Home extends Controller{

	public function home(){
		/* job shift query */
		$jobShifts = DB::table('jcm_job_shift')->get();

		/* companies query */
		$companies = DB::table('jcm_companies')->limit(12)->get();

		/* jobs query */
		$Gallery = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyId','jcm_companies.companyName','jcm_companies.companyLogo')->leftJoin('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')->where('jcm_jobs.p_Category','=','Gallery')->where('jcm_jobs.expiryDate','>',date('Y-m-d'))->orderBy('jcm_jobs.jobId','desc')->limit(12)->get();
		$hot = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyId','jcm_companies.companyName','jcm_companies.companyLogo')->leftJoin('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')->where('jcm_jobs.p_Category','=','Hot')->where('jcm_jobs.expiryDate','>',date('Y-m-d'))->orderBy('jcm_jobs.jobId','desc')->limit(12)->get();
		$jobs = DB::table('jcm_jobs')->select('jcm_jobs.*','jcm_companies.companyId','jcm_companies.companyName','jcm_companies.companyLogo')->leftJoin('jcm_companies','jcm_companies.companyId','=','jcm_jobs.companyId')->where('jcm_jobs.p_Category','=','Premium')->where('jcm_jobs.expiryDate','>',date('Y-m-d'))->orderBy('jcm_jobs.jobId','desc')->limit(12)->get();
//return $companies;
		return view('frontend.home-page',compact('jobShifts','companies','jobs','Gallery','hot'));
	}
	public function nicepay(Request $request){
		//return $request->all();
		return "hello";
	}

	public function contactUs(Request $request){
		if($request->isMethod('post')){
			print_r($request->all());exit;
		}
		return view('frontend.contact-us');
	}

	public function aboutUs(){
		$record = DB::table('jcm_cms_pages')->where('slug','about')->first();
		return view('frontend.about-us',compact('record'));
	}

	public function termConditions(){
		$record = DB::table('jcm_cms_pages')->where('slug','term-conditions')->first();
		return view('frontend.term-conditions',compact('record'));
	}

	public function privacyPolicy(){
		$record = DB::table('jcm_cms_pages')->where('slug','privacy-policy')->first();
		return view('frontend.privacy-policy',compact('record'));
	}

	public function accountLogin(Request $request){
		if($request->session()->has('jcmUser')){
			$type = $request->session()->get('jcmUser')->type == 'Employer' ? 'employer' : 'jobseeker';
			return redirect('account/'.$type);
		}
		$next = $request->input('next');
		if($request->isMethod('post')){
			$email = $request->input('email');
			$password = $request->input('password');

			$error = '';
			if(trim($email) == ''){
				$error .= 'Email field is required';
			}
			if(trim($password) == ''){
				$error .= 'Password field is required';
			}
			if($error != ''){
				$request->session()->flash('loginAlert', $error);
				redirect('account/login');
			}

			$user = $this->doLogin($email,$password);
			if($user == 'invalid'){
				$request->session()->flash('loginAlert', 'Invalid email/password');
				if($next != ''){
					return redirect('account/login?next='.$next);
				}else{
					return redirect('account/login');
				}
			}else{
				if(JobCallMe::isResumeBuild($user->userId) == false){
					$fNotice = 'To apply on jobs please build your resume. <a href="'.url('account/jobseeker/resume').'">Click Here</a> To create your resume';
					$request->session()->put('fNotice',$fNotice);
				}
				$request->session()->put('jcmUser', $user);
				if($next != ''){
					return redirect($next);
				}else{
					return redirect('account/jobseeker');
				}
			}
		}
		$pageType = \Request::segment('2');
		return view('frontend.login-registration',compact('pageType'));
	}

	public function doLogin($email,$password){
		/* do login */
		$user = DB::table('jcm_users')->where('email','=',$email)->where('password','=',md5($password))->where('status','Active')->where('type','<>','Admin')->first();
		if(count($user) == 0){
			return 'invalid';
		}else{
			return $user;
		}
		/* end */
	}

	public function accountRegister(Request $request){
		if($request->session()->has('jcmUser')){
			return redirect('account/jobseeker');
		}
		if($request->isMethod('post')){
			$this->validate($request,[
				'email' => 'required|email|unique:jcm_users,email',
				'password' => 'required|min:6|max:16',
				'firstName' => 'required|min:2|max:50',
				'lastName' => 'required|min:2|max:50',
				'country' => 'required',
				'state' => 'required',
				'phoneNumber' => 'required|digits_between:10,12',
			]);

			$input['companyId'] = '0';
			$input['type'] = 'User';
			$input['secretId'] = JobCallMe::randomString();
			$input['firstName'] = $request->input('firstName');
			$input['lastName'] = $request->input('lastName');
			$input['email'] = $request->input('email');
			$input['username'] = strtolower($request->input('firstName').$request->input('lastName').rand(00,99));
			$input['password'] = md5($request->input('password'));
			$input['phoneNumber'] = $request->input('phoneNumber');
			$input['country'] = $request->input('country');
			$input['state'] = $request->input('state');
			$input['city'] = $request->input('city');
			$input['profilePhoto'] = '';
			$input['about'] = '';
			$input['createdTime'] = date('Y-m-d H:i:s');
			$input['modifiedTime'] = date('Y-m-d H:i:s');

			$userId = DB::table('jcm_users')->insertGetId($input);

			extract($request->all());
			$cInput = array('companyName' => $firstName.' '.$lastName, 'companyEmail' => $email, 'companyPhoneNumber' => $phoneNumber, 'companyCountry' => $country, 'companyState' => $state, 'companyCity' => $city, 'category' => '0', 'companyCreatedTime' => date('Y-m-d H:i:s'), 'companyModifiedTime' => date('Y-m-d H:i:s'));
			$companyId = DB::table('jcm_companies')->insertGetId($cInput);

			DB::table('jcm_users')->where('userId','=',$userId)->update(array('companyId' => $companyId));
			/* end */

			$user = $this->doLogin($request->input('email'),$request->input('password'));
			$request->session()->put('jcmUser', $user);
			$fNotice = 'To apply on jobs please build your resume. <a href="'.url('account/jobseeker/resume').'">Click Here</a> To create your resume';
			$request->session()->put('fNotice',$fNotice);
			return redirect('account/jobseeker');
		}
		$pageType = \Request::segment('2');
		return view('frontend.login-registration',compact('pageType'));
	}

	public function logout(Request $request){
    	$request->session()->flush('jcmUser');
    	//$request->session()->destroy();
    	return redirect('');
    }

    public function manageUser(Request $request){
    	if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}
    	
    	$app = $request->session()->get('jcmUser');
    	$user = JobCallMe::getUser($app->userId);
    	$meta = JobCallMe::getUserMeta($app->userId);
    	$noti = JobCallMe::getAccountNotification($app->userId);
    	$privacy = JobCallMe::getPrivacySetting($app->userId);

    	return view('frontend.manage-user',compact('user','meta','noti','privacy'));
    }

    public function people(Request $request){
    	/* peoples query */
    	$people = DB::table('jcm_users');
    	$people->select('jcm_users.*');
    	$people->leftJoin('jcm_users_meta','jcm_users_meta.userId','=','jcm_users.userId');
		//$people->leftJoin('jcm_resume','jcm_resume.userId','=','jcm_users.userId');

    	if($request->isMethod('post')){
    		if($request->input('keyword') != ''){
    			$people->where('jcm_users.firstName','like','%'.$request->input('keyword').'%');
    			$people->orWhere('jcm_users.lastName','like','%'.$request->input('keyword').'%');
    		}
    		if($request->input('city') != ''){
    			$cityId = JobCallMe::cityId($request->input('city'));
	    		if($cityId != '0'){
		    		$people->where('jcm_users.city','=',$cityId);
		    	}
    		}
    	}else{
	    	if($request->input('city') != ''){
	    		$people->where('jcm_users.city','=',$request->input('city'));
	    	}
	    	if($request->input('industry') != ''){
	    		$people->where('jcm_users_meta.industry','=',$request->input('industry'));
	    	}
	    }
    	$people->limit(30);
    	$people->orderBy('jcm_users.userId','desc');
    	$peoples = $people->get();
        //dd($peoples);

    	return view('frontend.people',compact('peoples'));
    }

 public function peoples(Request $request){
    	/* peoples query */
    	$people = DB::table('jcm_users');
    	$people->select('jcm_users.*');
    	$people->rightJoin('jcm_users_meta','jcm_users_meta.userId','=','jcm_users.userId');
        $people->rightJoin('jcm_resume','jcm_resume.userId','=','jcm_users.userId');

    	if($request->isMethod('post')){
    		if($request->input('keyword') != ''){
    			$people->where('jcm_users.firstName','like','%'.$request->input('keyword').'%');
    			$people->orWhere('jcm_users.lastName','like','%'.$request->input('keyword').'%');
    		}
    		if($request->input('city') != ''){
    			$cityId = JobCallMe::cityId($request->input('city'));
	    		if($cityId != '0'){
		    		$people->where('jcm_users.city','=',$cityId);
		    	}
    		}
			if($request->input('name') != ''){
    			$people->where('jcm_users.firstName','like','%'.$request->input('name').'%');
    			$people->orWhere('jcm_users.lastName','like','%'.$request->input('name').'%');
    		}
			if($request->input('category') != ''){
    			$people->where('jcm_users_meta.industry','=',$request->input('category'));
    		}
			if($request->input('degreeLevel') != ''){
    			$people->where('jcm_resume.resumeData','like','%'.$request->input('degreeLevel').'%');
    		}
			if($request->input('degree') != ''){
    			$people->where('jcm_resume.resumeData','like','%'.$request->input('degree').'%');
    		}
                        if($request->input('minsalary') != ''){
    			$people->where('jcm_users_meta.currentSalary','=>',$request->input('minsalary'));
    		}
                        if($request->input('maxsalary') != ''){
    			$people->where('jcm_users_meta.expectedSalary','<=',$request->input('maxsalary'));
    		}
                        if($request->input('gender') != ''){
    			$people->where('jcm_users_meta.gender','=',$request->input('gender'));
    		}
                        if($request->input('maritalStatus') != ''){
    			$people->where('jcm_users_meta.maritalStatus','=',$request->input('maritalStatus'));
    		}
            
               
               
    	}else{
	    	if($request->input('citys') != ''){
	    		$people->where('jcm_users.city','=',$request->input('citys'));
	    	}
	    	if($request->input('industry') != ''){
	    		$people->where('jcm_users_meta.industry','=',$request->input('industry'));
	    	}
	    }
    	$people->limit(12);
    	$people->orderBy('jcm_users.userId','desc');
         $people->distinct('jcm_users.firstName');
    	$peoples = $people->get();
        // dd($peoples);

    	return view('frontend.people',compact('peoples'));
    }

    public function learn(Request $request){
    	/* read query */
    	$lear_record = DB::table('jcm_upskills')->orderBy('skillId','desc')->limit(12)->get();

    	return view('frontend.learn',compact('lear_record'));
    }

    public function read(Request $request){
    	/* read query */
    	$readQry = DB::table('jcm_writings')->join('jcm_users','jcm_users.userId','=','jcm_writings.userId');
    	$readQry->leftJoin('jcm_categories','jcm_categories.categoryId','=','jcm_writings.category');
    	$readQry->select('jcm_writings.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto','jcm_categories.name');
    	if($request->input('category') != '0' && $request->input('category') != ''){
    		$readQry->where('jcm_writings.category','=',$request->input('category'));
    	}
    	if($request->input('keyword') != ''){
    		$readQry->where('jcm_writings.title','LIKE','%'.$request->input('keyword').'%');
    	}
    	$readQry->orderBy('jcm_writings.writingId','desc')->limit(12);
    	$read_record = $readQry->get();

    	return view('frontend.read',compact('read_record'));
    }

    public function viewArticle(Request $request,$writingId){
    	/* article query */
    	$readQry = DB::table('jcm_writings')->join('jcm_users','jcm_users.userId','=','jcm_writings.userId');
    	$readQry->leftJoin('jcm_categories','jcm_categories.categoryId','=','jcm_writings.category');
    	$readQry->select('jcm_writings.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto','jcm_categories.name');
    	$readQry->where('jcm_writings.writingId','=',$writingId);
    	$record = $readQry->first();

    	if(count($record) == 0){
    		return redirect('read');
    	}

    	return view('frontend.view-article',compact('record'));
    }

    public function viewUpskill(Request $request,$skillId){
    	$type = $request->segment(2);
    	/* upskill query */
    	$learnQry = DB::table('jcm_upskills')->where('type','=',ucfirst($type));
    	$learnQry->where('skillId','=',$skillId);
    	$record = $learnQry->first();

    	if(count($record) == 0){
    		return redirect('learn');
    	}

    	return view('frontend.view-course',compact('record'));
    }

    public function searchSkills(Request $request){
    	/* search upskills */
    	$learnQry = DB::table('jcm_upskills');
    	if($request->input('type') != ''){
    		$learnQry->where('type','=',ucfirst($request->input('type')));
    	}
    	if($request->input('keyword') != ''){
    		$learnQry->where('title','LIKE','%'.$request->input('keyword').'%');
    	}
    	if($request->input('city') != ''){
    		$cityId = JobCallMe::cityId($request->input('city'));
    		if($cityId != '0'){
	    		$learnQry->where('city','=',$cityId);
	    	}
    	}
    	$record = $learnQry->orderBy('skillId','desc')->paginate(30);

    	return view('frontend.search-learn',compact('record'));
    }

    public function companies(Request $request){
    	/* companies query */
    	$company = DB::table('jcm_companies');
    	if($request->isMethod('post')){
    		if($request->input('keyword') != ''){
    			$company->where('companyName','like','%'.$request->input('keyword').'%');
    		}
    		if($request->input('city') != ''){
    			$cityId = JobCallMe::cityId($request->input('city'));
	    		if($cityId != '0'){
		    		$company->where('companyCity','=',$cityId);
		    	}
    		}
    	}
    	if($request->input('in') != ''){
    		$company->where('category','=',$request->input('in'));
    	}
    	$company->orderBy('companyId','desc');
    	$company->limit(24);
    	$companies = $company->get();

    	return view('frontend.view-companies',compact('companies'));
    }

    public function viewCompany(Request $request,$companyId){
    	$company = DB::table('jcm_companies')->where('companyId','=',$companyId)->first();


    	$jobs = DB::table('jcm_jobs')->where('companyId','=',$companyId)->limit(10)->get();

    	$followArr = array();
		if($request->session()->has('jcmUser')){
			$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
			$savedJobArr = @explode(',', $meta->saved);
			$followArr = @explode(',', $meta->follow);
		}

    	return view('frontend.show-company',compact('company','jobs','followArr'));
    }

    public function sendFeedback(Request $request){
    	$message = trim($request->input('message'));
    	$type = trim($request->input('type'));
    	echo @json_encode(array('status' => 'success'));
    }
}
?>