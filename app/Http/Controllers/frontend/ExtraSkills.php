<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;

class ExtraSkills extends Controller{
    
    public function writings(Request $request){
    	if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}
    	$app = $request->session()->get('jcmUser');

    	/* writing query */
    	$writings = DB::table('jcm_writings')->where('userId','=',$app->userId);
    	$writings->orderBy('writingId','desc');
    	$writing = $writings->get();

    	return view('frontend.view-writings',compact('writing'));
    }

    public function addEditArticle(Request $request){
    	$app = $request->session()->get('jcmUser');
    	if($request->ajax()){
    		$this->validate($request,[
    				'title' => 'required',
    				'category' => 'required',
    				'description' => 'required',
    				'citation' => 'required'
    			]);

    		if($request->input('prevIcon') == '' || $request->hasFile('articleImage')){
    			$this->validate($request, [
                    'articleImage' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);
    		}
    		if($request->hasFile('articleImage')){
                $image = $request->file('articleImage');

                $input['wIcon'] = 'article-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/article-images');
                $image->move($destinationPath, $input['wIcon']);

                if($request->input('prevIcon') != ''){
                    @unlink(public_path('/article-images/'.$request->input('prevIcon')));
                }
            }else{
                $input['wIcon'] = $request->input('prevIcon');
            }

            $input['title'] = $request->input('title');
            $input['category'] = $request->input('category');
            $input['description'] = $request->input('description');
            $input['citation'] = $request->input('citation');
            $input['status'] = $request->input('option');
           // $input['title'] = $request->input('title');

            if($request->input('writingId') != '' && $request->input('writingId') != '0'){
            	DB::table('jcm_writings')->where('writingId','=',$request->input('writingId'))->update($input);
            }else{
            	$input['userId'] = $app->userId;
            	$input['createdTime'] = date('Y-m-d H:i:s');
            	DB::table('jcm_writings')->insert($input);
            }
            exit('1');
    	}
    	if(!$request->session()->has('jcmUser')){
    		return redirect('account/login?next='.$request->route()->uri);
    	}
    	$segment = $request->segment(4);
    	$article = (object) array();
    	if($segment == 'edit'){
    		$writingId = $request->segment(5);
    		$writings = DB::table('jcm_writings')->where('userId','=',$app->userId);
	    	$writings->where('writingId','=',$writingId);
	    	$article = $writings->first();
	    	if(count($article) == 0){
	    		return redirect('account/writings');
	    	}
    	}
    	return view('frontend.add-edit-writing',compact('article'));
    }

    public function deleteArticle(Request $request,$writingId){
    	if(!$request->ajax()){
    		exit('Directory access is forbidden');
    	}
    	$app = $request->session()->get('jcmUser');

    	DB::table('jcm_writings')->where('userId','=',$app->userId)->where('writingId','=',$writingId)->delete();
    	exit('1');
    }

    public function upskill(Request $request){
        if(!$request->session()->has('jcmUser')){
            return redirect('account/login?next='.$request->route()->uri);
        }
        $app = $request->session()->get('jcmUser');

        /* upskill query */
        $upskills = DB::table('jcm_upskills')->where('userId','=',$app->userId);
        $upskills->orderBy('skillId','desc');
        $upskills = $upskills->get();

    	return view('frontend.view-upskills',compact('upskills'));
    }

    public function addEditUpskill(Request $request){
        $app = $request->session()->get('jcmUser');
        if($request->ajax()){
            $this->validate($request,[
                    'title' => 'required',
                    'type' => 'required',
                    'description' => 'required',
                    'cost' => 'required|numeric',
                    'currency' => 'required',
                    'address' => 'required',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'contact' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required|numeric',
                    'mobile' => 'nullable|numeric',
                    'website' => 'nullable|url',
                    'facebook' => 'nullable|url',
                    'linkedin' => 'nullable|url',
                    'twitter' => 'nullable|url',
                    'google' => 'nullable|url',
                    'startDate' => 'required|date',
                    'endDate' => 'required|date',
                ]);

            if($request->input('oType') == 'other'){
                $this->validate($request, [
                    'organiser' => 'required',
                ]);
            }

            if($request->hasFile('upskillImage')){
                $this->validate($request, [
                    'upskillImage' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);
            }
            if($request->hasFile('upskillImage')){
                $image = $request->file('upskillImage');

                $input['upskillImage'] = 'upskill-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/upskill-images');
                $image->move($destinationPath, $input['upskillImage']);

                if($request->input('prevIcon') != ''){
                    @unlink(public_path('/upskill-images/'.$request->input('prevIcon')));
                }
            }

            $opHours = $request->input('opHours');
            $timing = array();
            foreach($opHours as $i => $k){
                $timing[$i] = array('from' => $k[0], 'to' => $k[1]);
            }

            $input['title'] = trim($request->input('title'));
            $input['type'] = trim($request->input('type'));
            $input['organiser'] = trim($request->input('organiser'));
            $input['description'] = trim($request->input('description'));
            $input['cost'] = trim($request->input('cost'));
            $input['currency'] = trim($request->input('currency'));
            $input['address'] = trim($request->input('address'));
            $input['country'] = trim($request->input('country'));
            $input['state'] = trim($request->input('state'));
            $input['city'] = trim($request->input('city'));
            $input['contact'] = trim($request->input('contact'));
            $input['email'] = trim($request->input('email'));
            $input['phone'] = trim($request->input('phone'));
            $input['mobile'] = trim($request->input('mobile'));
            $input['website'] = trim($request->input('website'));
            $input['facebook'] = trim($request->input('facebook'));
            $input['linkedin'] = trim($request->input('linkedin'));
            $input['twitter'] = trim($request->input('twitter'));
            $input['google'] = trim($request->input('google'));
            $input['startDate'] = trim($request->input('startDate'));
            $input['endDate'] = trim($request->input('endDate'));
            $input['timing'] = @json_encode($timing);

            if($request->input('accommodation') == 'on'){
                $input['cost'] = '0';
            }

            if($request->input('skillId') != '' && $request->input('skillId') != '0'){
                DB::table('jcm_upskills')->where('skillId','=',$request->input('skillId'))->update($input);
            }else{
                $input['userId'] = $app->userId;
                $input['createdTime'] = date('Y-m-d H:i:s');
                DB::table('jcm_upskills')->insert($input);
            }
            exit('1');
        }
        $segment = $request->segment(3);
        $upskill = (object) array();
        if($segment == 'edit'){
            $skillId = $request->segment(4);
            $upskills = DB::table('jcm_upskills')->where('userId','=',$app->userId);
            $upskills->where('skillId','=',$skillId);
            $upskill = $upskills->first();
            if(count($upskill) == 0){
                return redirect('account/upskill');
            }
        }
    	return view('frontend.add-edit-upskill',compact('upskill'));
    }

    public function deleteUpskill(Request $request,$skillId){
        if(!$request->ajax()){
            exit('Directory access is forbidden');
        }
        $app = $request->session()->get('jcmUser');

        DB::table('jcm_upskills')->where('userId','=',$app->userId)->where('skillId','=',$skillId)->delete();
        exit('1');
    }

}
