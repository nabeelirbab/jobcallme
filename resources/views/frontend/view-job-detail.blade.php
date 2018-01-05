@extends('frontend.layouts.app')

@section('title', "$job->title")

@section('content')
<section id="jobs">
    <div class="container">
        <div class="col-md-10">
            <div class="jobs-suggestions">
			@if($job->userId == $userId )
                <div class="jd-action-btn">

                </div>
			
			@else
				  <div class="jd-action-btn">
                    @if(strtotime($job->expiryDate) < strtotime(date('Y-m-d')))
                        <button class="btn btn-danger">Closed</button>
                    @else
                        <a href="{{ url('jobs/apply/'.$job->jobId) }}" class="btn btn-primary">Applied</a>
                        @if(in_array($job->jobId, $savedJobArr))
                            <a href="javascript:;" onclick="saveJob({{ $job->jobId }},this)" class="btn btn-success" style="margin-left: 10px;">Saved</a>
                        @else
                            <a href="javascript:;" onclick="saveJob({{ $job->jobId }},this)" class="btn btn-default" style="margin-left: 10px;">Save</a>
                        @endif
                    @endif
                </div>
			@endif
			<?php $colorArr = array('purple','green','darkred','orangered','blueviolet') ?>
                <h4>{{ $job->title }} <span class="label" style="background-color: {{ $colorArr[array_rand($colorArr)] }}"> {!! $job->p_Category !!}</span></h4>
                <p>{{ JobCallMe::cityName($job->city) }}, {{ JobCallMe::countryName($job->country) }} </p>
                <div class="jd-share-btn">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('jobs/'.$job->jobId) }}">
                    	<i class="fa fa-facebook" style="background: #2e6da4;"></i> 
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('jobs/'.$job->jobId) }}&title=&summary=&source=">
                    	<i class="fa fa-linkedin" style=" background: #007BB6;"></i> 
                    </a>
                    <a href="https://twitter.com/home?status={{ url('jobs/'.$job->jobId) }}">
                    	<i class="fa fa-twitter" style="background: #15B4FD;"></i> 
                    </a>
                    <a href="https://plus.google.com/share?url={{ url('jobs/'.$job->jobId) }}">
                    	<i class="fa fa-google-plus" style="background: #F63E28;"></i> 
                    </a>
                </div>
                <ul class="js-listing">
                    <li>
                        <p class="js-title">Job Type</p>
                        <p>{{ $job->jobType }}</p>
                    </li>
                    <li>
                        <p class="js-title">Shift</p>
                        <p>{{ $job->jobShift }}</p>
                    </li>
                    <li>
                        <p class="js-title">Experience</p>
                        <p>{{ $job->experience }}</p>
                    </li>
                    <li>
                        <p class="js-title">Salary</p>
                        <p>{{ number_format($job->minSalary) }} - {{ number_format($job->maxSalary) }} {{ $job->currency }}</p>
                    </li>
					<li>
                        <p class="js-title">Post On</p>
                        <p>{{ date('M d, Y',strtotime($job->createdTime))}}</p>
                    </li>
					<li>
                        <p class="js-title">Last Date</p>
                        <p>{{ date('M d, Y',strtotime($job->expiryDate))}}</p>
                    </li>
                </ul>
            </div>

            <!--JOB Details-->
            <div class="jd-job-details">
                <h4>{{ $job->title }} at {{ JobCallMe::cityName($job->city) }}, {{ JobCallMe::countryName($job->country) }}</h4>

                <!--Large Screen-->
                <table class="table table-bordered hidden-xs hidden-sm">
                    <tbody>
                    <tr>
                        <td class="active">Category</td>
                        <td>{{ JobCallMe::categoryTitle($job->category) }}</td>
                        <td class="active">Career Level</td>
                        <td>{{ $job->careerLevel }}</td>
                    </tr>
                    <tr>
                        <td class="active">Qualification</td>
                        <td>{{ $job->qualification }}</td>
                        <td class="active">Total Vacancies</td>
                        <td>{{ $job->vacancies }}</td>
                    </tr>
                    <tr>
                        <td class="active">Post on</td>
                        <td>{{ date('M d, Y',strtotime($job->createdTime))}}</td>
                        <td class="active">Last Date</td>
                        <td>{{ date('M d, Y',strtotime($job->expiryDate))}}</td>
                    </tr>
                    <tr>
                        <td class="active">Location</td>
                        <td colspan="3">{{ JobCallMe::cityName($job->city) }}, {{ JobCallMe::countryName($job->country) }}</td>
                    </tr>
                    </tbody>
                </table>

                <!--Small Screen-->
                <table class="table table-bordered table-responsive hidden-md hidden-lg">
                    <tbody>
                    <tr>
                        <td class="active">Category</td>
                        <td>{{ JobCallMe::categoryTitle($job->category) }}</td>
                    </tr>
                    <tr>
                        <td class="active">Career Level</td>
                        <td>{{ $job->careerLevel }}</td>
                    </tr>
                    <tr>
                        <td class="active">Qualification</td>
                        <td>{{ $job->qualification }}</td>
                    </tr>
                    <tr>
                        <td class="active">Post on</td>
                        <td>{{ date('M d, Y',strtotime($job->createdTime))}}</td>
                    </tr>
                    <tr>
                        <td class="active">Last Date</td>
                        <td>{{ date('M d, Y',strtotime($job->expiryDate))}}</td>
                    </tr>
                    <tr>
                        <td class="active">Location</td>
                        <td>{{ JobCallMe::cityName($job->city) }}, {{ JobCallMe::countryName($job->country) }}</td>
                    </tr>
                    </tbody>
                </table>
                <h4>Description</h4>
                <p><strong>We are conveniently located in {{ JobCallMe::getCompany($job->companyId)->companyAddress }}.</strong></p>
                <p>{!! $job->description !!}</p>
                <h4>Skills</h4>
                <p>{!! $job->skills !!}</p>
                <h4>Rewards and Benefits</h4>
                @if($job->benefits != '')
	                <ul class="jd-rewards">
	                	@foreach(@explode(',',$job->benefits) as $benefits)
	                		<li><i class="fa fa-check-circle"></i> {{ $benefits }}</li>
	                	@endforeach
	                </ul>
                @endif
            </div>

            <!--ABOUT Organization-->
            <div class="jobs-suggestions">
                <div class="jd-action-btn">
                    @if(in_array($job->companyId,$followArr))
                        <a href="javascript:;" onclick="followCompany({{ $job->companyId }},this)" class="btn btn-success">Following</a>
                    @else
                        <a href="javascript:;" onclick="followCompany({{ $job->companyId }},this)" class="btn btn-primary">Follow</a>
                    @endif
                </div>
                <h4>{{ $job->companyName }} </h4>
                <p>{{ JobCallMe::cityName($job->companyCity) }}, {{ JobCallMe::countryName($job->companyCountry) }}</p>
                <div class="jd-about-organization">
                    <p>{!! $job->companyAbout !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
$(document).ready(function(){
})
function saveJob(jobId,obj){
    if($(obj).hasClass('btn-default')){
        var type = 'save';
    }else{
        var type = 'remove';
    }
    $.ajax({
        url: "{{ url('account/jobseeker/job/action') }}?jobId="+jobId+"&type="+type,
        success: function(response){
            if($.trim(response) == 'redirect'){
                window.location.href = "{{ url('account/login?next='.Request::route()->uri) }}";
            }else if($.trim(response) == 'done'){
                if($(obj).hasClass('btn-default')){
                    $(obj).removeClass('btn-default');
                    $(obj).addClass('btn-success');
                    $(obj).text('Saved');
                }else{
                    $(obj).removeClass('btn-success');
                    $(obj).addClass('btn-default');
                    $(obj).text('Save');
                }
            }
        }
    })
}
function followCompany(companyId,obj){
    if($(obj).hasClass('btn-primary')){
        var type = 'follow';
    }else{
        var type = 'remove';
    }
    if($(obj).hasClass('btn-primary')){
        $(obj).removeClass('btn-primary');
        $(obj).addClass('btn-success');
        $(obj).text('Following');
    }else{
        $(obj).removeClass('btn-success');
        $(obj).addClass('btn-primary');
        $(obj).text('Follow');
    }
    $.ajax({
        url: "{{ url('account/jobseeker/company/action') }}?companyId="+companyId+"&type="+type,
        success: function(response){
            if($.trim(response) == 'redirect'){
                window.location.href = "{{ url('account/login?next='.Request::route()->uri) }}";
            }else if($.trim(response) == 'done'){
            }
        }
    })
}
</script>
@endsection