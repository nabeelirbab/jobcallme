<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;

class Cms extends Controller{
    
    public function viewCategories(Request $request){
    	$startI = $request->input('page',1);
    	$startI = ($startI - 1) * 25;
    	if($request->isMethod('post')){
    		$request->session()->put('categorySearch',$request->all());
    	}

    	if($request->input('reset') && $request->input('reset') == 'true'){
    		$request->session()->forget('categorySearch');
    		return redirect('admin/cms/category');
    	}

    	/* category query*/
        $s_app = $request->session()->get('categorySearch');
    	$categories = DB::table('jcm_categories')
                    ->where(function ($query) use ($s_app) {
                        if(count($s_app) > 0){
                            if($s_app['search'] != ''){
                                $query->where('name', 'like', '%'.$s_app['search'].'%');
                            }
                        }
                    })->orderBy('categoryId','desc')->paginate(25);
    	/* end */
    	return view('admin.cms.categories',compact('categories','startI'));
    }

    public function saveCategory(Request $request){
    	if(!$request->ajax()){
    		exit('Directory access is forbidden');
    	}
		$categoryId = trim($request->input('categoryId'));
		$name = trim($request->input('name'));

		if($name == ''){
			exit('Please enter category name.');
		}
		$cat = DB::table('jcm_categories')->where('name','=',$name)->where('categoryId','<>',$categoryId)->first();
		if(count($cat) > 0){
			exit('Category with name <b>'.$name.'</b> already exist.');
		}

		$input = array('name' => $name, 'modifiedTime' => date('Y-m-d H:i:s'));
		if($categoryId != '0'){
			DB::table('jcm_categories')->where('categoryId','=',$categoryId)->update($input);
			$sMsg = 'Category Updated';
		}else{
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_categories')->insert($input);
			$sMsg = 'New Category Added';
		}
		$request->session()->flash('alert',['message' => $sMsg, 'type' => 'success']);
		exit('1');
    }

    public function getCategory(Request $request){
    	if(!$request->ajax()){
    		exit('Directory access is forbidden');
    	}
    	$categoryId = $request->segment(5);
    	$cat = DB::table('jcm_categories')->where('categoryId',$categoryId)->first();
    	echo @json_encode($cat);
    }

    public function deleteCategory(Request $request){
    	if($request->isMethod('delete')){
            $categoryId = trim($request->input('categoryId'));
            
            DB::table('jcm_sub_categories')->where('categoryId',$categoryId)->delete();
            DB::table('jcm_categories')->where('categoryId',$categoryId)->delete();
            $request->session()->flash('alert',['message' => 'Category Deleted','type' => 'success']);
        }
        return redirect(url()->previous());
    }

    public function viewSubCategories(Request $request){
    	$categoryId = $request->segment(4);
    	$cat = DB::table('jcm_categories')->where('categoryId',$categoryId)->first();
    	if(count($cat) == 0){
    		$request->session()->flash('alert',['message' => 'No Record Found', 'type' => 'danger']);
            return redirect('admin/cms/category');
    	}

    	$startI = $request->input('page',1);
    	$startI = ($startI - 1) * 25;
    	if($request->isMethod('post')){
    		$request->session()->put('subcategorySearch',$request->all());
    	}

    	if($request->input('reset') && $request->input('reset') == 'true'){
    		$request->session()->forget('subcategorySearch');
    		return redirect('admin/cms/category/'.$categoryId);
    	}

    	/* category query*/
        $s_app = $request->session()->get('subcategorySearch');
    	$subCategories = DB::table('jcm_sub_categories')
    				->where('categoryId','=',$categoryId)
                    ->where(function ($query) use ($s_app) {
                        if(count($s_app) > 0){
                            if($s_app['search'] != ''){
                                $query->where('subName', 'like', '%'.$s_app['search'].'%');
                            }
                        }
                    })->orderBy('subCategoryId','desc')->paginate(25);
    	/* end */
    	return view('admin.cms.sub-categories',compact('subCategories','cat','startI'));
    }

    public function saveSubCategory(Request $request){
    	if(!$request->ajax()){
    		exit('Directory access is forbidden');
    	}
		$categoryId = trim($request->input('categoryId'));
		$subCategoryId = trim($request->input('subCategoryId'));
		$name = trim($request->input('name'));

		if($name == ''){
			exit('Please enter sub category name.');
		}
		$cat = DB::table('jcm_sub_categories')->where('subName','=',$name)->where('categoryId','=',$categoryId)->where('subCategoryId','<>',$subCategoryId)->first();
		if(count($cat) > 0){
			exit('Sub Category with name <b>'.$name.'</b> already exist.');
		}

		$input = array('categoryId' => $categoryId, 'subName' => $name, 'modifiedTime' => date('Y-m-d H:i:s'));
		if($subCategoryId != '0'){
			DB::table('jcm_sub_categories')->where('subCategoryId','=',$subCategoryId)->update($input);
			$sMsg = 'Sub Category Updated';
		}else{
			$input['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_sub_categories')->insert($input);
			$sMsg = 'New Sub Category Added';
		}
		$request->session()->flash('alert',['message' => $sMsg, 'type' => 'success']);
		exit('1');
    }

    public function getSubCategory(Request $request){
    	if(!$request->ajax()){
    		exit('Directory access is forbidden');
    	}
    	$subCategoryId = $request->segment(5);
    	$cat = DB::table('jcm_sub_categories')->where('subCategoryId',$subCategoryId)->first();
    	echo @json_encode($cat);
    }

    public function deleteSubCategory(Request $request){
    	if($request->isMethod('delete')){
            $subCategoryId = trim($request->input('subCategoryId'));
            
            DB::table('jcm_sub_categories')->where('subCategoryId',$subCategoryId)->delete();
            $request->session()->flash('alert',['message' => 'Sub Category Deleted','type' => 'success']);
        }
        return redirect(url()->previous());
    }

    public function viewJobShift(Request $request){
        $startI = $request->input('page',1);
        $startI = ($startI - 1) * 25;
        if($request->isMethod('post')){
            $request->session()->put('shiftSearch',$request->all());
        }

        if($request->input('reset') && $request->input('reset') == 'true'){
            $request->session()->forget('shiftSearch');
            return redirect('admin/cms/shift');
        }

        /* category query*/
        $s_app = $request->session()->get('shiftSearch');
        $jobShift = DB::table('jcm_job_shift')
                    ->where(function ($query) use ($s_app) {
                        if(count($s_app) > 0){
                            if($s_app['search'] != ''){
                                $query->where('name', 'like', '%'.$s_app['search'].'%');
                            }
                        }
                    })->orderBy('shiftId','desc')->paginate(25);
        /* end */

        return view('admin.cms.job-shifts',compact('jobShift','startI'));
    }

    public function saveJobShift(Request $request){
        if(!$request->ajax()){
            exit('Directory access is forbidden');
        }
        $shiftId = trim($request->input('shiftId'));
        $name = trim($request->input('name'));

        if($name == ''){
            exit('Please enter job shift.');
        }
        $cat = DB::table('jcm_job_shift')->where('name','=',$name)->where('shiftId','<>',$shiftId)->first();
        if(count($cat) > 0){
            exit('Job Shift <b>'.$name.'</b> already exist.');
        }

        $input = array('name' => $name, 'modifiedTime' => date('Y-m-d H:i:s'));
        if($shiftId != '0'){
            DB::table('jcm_job_shift')->where('shiftId','=',$shiftId)->update($input);
            $sMsg = 'Job Shift Updated';
        }else{
            $input['createdTime'] = date('Y-m-d H:i:s');
            DB::table('jcm_job_shift')->insert($input);
            $sMsg = 'New Job Shift Added';
        }
        $request->session()->flash('alert',['message' => $sMsg, 'type' => 'success']);
        exit('1');
    }

    public function getJobShift(Request $request){
        if(!$request->ajax()){
            exit('Directory access is forbidden');
        }
        $shiftId = $request->segment(5);
        $cat = DB::table('jcm_job_shift')->where('shiftId',$shiftId)->first();
        echo @json_encode($cat);
    }

    public function deleteJobShift(Request $request){
        if($request->isMethod('delete')){
            $shiftId = $request->input('shiftId');
            DB::table('jcm_job_shift')->where('shiftId','=',$shiftId)->delete();
            $request->session()->flash('alert',['message' => 'Job Shift Deleted','type' => 'success']);
        }
        return redirect(url()->previous());
    }

    public function viewJobType(Request $request){
        $startI = $request->input('page',1);
        $startI = ($startI - 1) * 25;
        if($request->isMethod('post')){
            $request->session()->put('jobtypeSearch',$request->all());
        }

        if($request->input('reset') && $request->input('reset') == 'true'){
            $request->session()->forget('jobtypeSearch');
            return redirect('admin/cms/jobtype');
        }

        /* category query*/
        $s_app = $request->session()->get('jobtypeSearch');
        $jobType = DB::table('jcm_job_types')
                    ->where(function ($query) use ($s_app) {
                        if(count($s_app) > 0){
                            if($s_app['search'] != ''){
                                $query->where('name', 'like', '%'.$s_app['search'].'%');
                            }
                        }
                    })->orderBy('typeId','desc')->paginate(25);
        /* end */

        return view('admin.cms.job-type',compact('jobType','startI'));
    }

    public function saveJobType(Request $request){
        if(!$request->ajax()){
            exit('Directory access is forbidden');
        }
        $typeId = trim($request->input('typeId'));
        $name = trim($request->input('name'));

        if($name == ''){
            exit('Please enter job type.');
        }
        $cat = DB::table('jcm_job_types')->where('name','=',$name)->where('typeId','<>',$typeId)->first();
        if(count($cat) > 0){
            exit('Job Type <b>'.$name.'</b> already exist.');
        }

        $input = array('name' => $name, 'modifiedTime' => date('Y-m-d H:i:s'));
        if($typeId != '0'){
            DB::table('jcm_job_types')->where('typeId','=',$typeId)->update($input);
            $sMsg = 'Job Type Updated';
        }else{
            $input['createdTime'] = date('Y-m-d H:i:s');
            DB::table('jcm_job_types')->insert($input);
            $sMsg = 'New Job Type Added';
        }
        $request->session()->flash('alert',['message' => $sMsg, 'type' => 'success']);
        exit('1');
    }

    public function getJobType(Request $request){
        if(!$request->ajax()){
            exit('Directory access is forbidden');
        }
        $typeId = $request->segment(5);
        $cat = DB::table('jcm_job_types')->where('typeId',$typeId)->first();
        echo @json_encode($cat);
    }

    public function deleteJobType(Request $request){
        if($request->isMethod('delete')){
            $typeId = $request->input('typeId');
            DB::table('jcm_job_types')->where('typeId','=',$typeId)->delete();
            $request->session()->flash('alert',['message' => 'Job Type Deleted','type' => 'success']);
        }
        return redirect(url()->previous());
    }

    public function viewPages(Request $request){
        JobCallMe::necessaryPages();
        $startI = $request->input('page',1);
        $startI = ($startI - 1) * 25;

        /* pages query*/
        $cmsPages = DB::table('jcm_cms_pages')->orderBy('pageId','desc')->paginate(25);
        /* end */
        return view('admin.cms.view-pages',compact('cmsPages','startI'));
    }

    public function addEditPage(Request $request){
        $pageId = 0;
        $rPath = $request->segment(4);
        if($request->isMethod('post')){
            $pageId = $request->input('pageId','0');
            //print_r($request->all());exit;
            $this->validate($request,[
                'title' => 'required|max:255',
                'pageData' => 'required',
                'featuredImage' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $input = array('featuredImage' => '');
            if($request->hasFile('featuredImage')){
                $image = $request->file('featuredImage');

                $input['featuredImage'] = 'featured-image-'.time().rand(000000,999999).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/featured-photos');
                $image->move($destinationPath, $input['featuredImage']);
            }
            $input['title'] = $request->input('title');
            if($request->input('slug') != ''){
                $input['slug'] = $request->input('slug');
            }else{
                $input['slug'] = JobCallMe::slugify($request->input('title'));
            }
            $input['pageData'] = $request->input('pageData');
            $input['modifiedTime'] = date('Y-m-d H:i:s');
            if($pageId != '0'){
                DB::table('jcm_cms_pages')->where('pageId','=',$pageId)->update($input);
                $rMsg = 'Page Updated';
            }else{
                $input['createdTime'] = date('Y-m-d H:i:s');
                DB::table('jcm_cms_pages')->insert($input);
                $rMsg = 'Page Added';
            }
            $request->session()->flash('alert',['message' => $rMsg, 'type' => 'success']);
            return redirect('admin/cms/pages');
        }else{
            $cpage = array();
            $pageId = '0';
            if($rPath == 'edit'){
                $pageId = $request->segment(5);
                $cpage = DB::table('jcm_cms_pages')->where('pageId','=',$pageId)->first();
                if(count($cpage) == 0){
                    $request->session()->flash('alert',['message' => 'No Record Found', 'type' => 'danger']);
                    return redirect('admin/cms/pages');
                }
                $cpage = (array) $cpage;
            }
            return view('admin.cms.add-edit-page',compact('cpage','pageId','rPath'));
        }
    }

    public function deletePage(Request $request){
        if($request->isMethod('delete')){
            $pageId = trim($request->input('pageId'));
            
            $cpage = DB::table('jcm_cms_pages')->where('pageId','=',$pageId)->first();
            @unlink(public_path('/featured-photos/'.$cpage->featuredImage));

            DB::table('jcm_cms_pages')->where('pageId','=',$pageId)->delete();
            $request->session()->flash('alert',['message' => 'Page Deleted','type' => 'success']);
        }
        return redirect(url()->previous());
    }

}
