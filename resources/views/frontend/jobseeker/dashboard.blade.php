@extends('frontend.layouts.app')

@section('title','Job Seeker')

@section('inner-header')
    @include('frontend.includes.jobseeker-nav')
@endsection

@section('content')
<section id="relate-to-job">
    <div class="container">
       <div class="row">
           <!--RTJ- Left start-->
           <div class="col-md-6">
               <div class="rtj-box">
                   <ul class="nav nav-tabs ">
                       <li class="active">
                           <a href="#rtj_tab_suggested" data-toggle="tab"><i class="fa fa-info-circle"></i> Suggested</a>
                       </li>
                       <li>
                           <a href="#rtj_tab_saved" data-toggle="tab"><i class="fa fa-heart"></i> Saved Jobs </a>
                       </li>
                       <li>
                           <a href="#rtj_tab_application" data-toggle="tab"><i class="fa fa-file-text"></i> Applications </a>
                       </li>
                       <li>
                           <a href="#rtj_tab_interview" data-toggle="tab"><i class="fa fa-calendar"></i> Interviews</a>
                       </li>
                   </ul>
                   <div class="tab-content">
                       <div class="tab-pane active" id="rtj_tab_suggested">
                             @if(count($suggested) > 0)
                                @foreach($suggested as $sgJob)
                                    <div class="col-md-12 rtj-item" id="suggested-{{ $sgJob->jobId }}">
                                        <img src="{{ url('compnay-logo/'.$sgJob->companyLogo) }}" style="width: 50px">
                                        <div class="rtj-details">
                                            <p><strong><a href="{{ url('jobs/'.$sgJob->jobId) }}">{!! $sgJob->title !!}</a></strong></p>
                                            <p>{!! $sgJob->companyName !!}</p>
                                            <p>{{ JobCallMe::cityName($sgJob->city) }}, {{ JobCallMe::countryName($sgJob->country) }}</p>
                                            <span class="rtj-action">
                                                <a href="{{ url('jobs/apply/'.$sgJob->jobId) }}" title="Apply">
                                                    <i class="fa fa-paper-plane"></i>
                                                </a>&nbsp;
                                                <a href="{{ url('jobs/'.$sgJob->jobId) }}" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </span>
                                       </div>
                                    </div>
                                @endforeach
                            @endif
                           <div class="col-md-12">
                               <a href="{{ url('jobs') }}" class="pull-right" style="padding-top: 5px">View all</a>
                           </div>
                       </div>
                       <div class="tab-pane" id="rtj_tab_saved">
                            @if(count($savedJobs) > 0)
                                @foreach($savedJobs as $sJob)
                                    <?php 
                                        $cLogo = url('compnay-logo/default-logo.jpg');
                                        if($sJob->companyLogo != ''){
                                          $cLogo = url('compnay-logo/'.$sJob->companyLogo);
                                        }
                                    ?>
                                    <div class="col-md-12 rtj-item" id="saved-{{ $sJob->jobId }}">
                                       <img src="{{ $cLogo }}" style="width: 50px">
                                       <div class="rtj-details">
                                            <p><strong><a href="{{ url('jobs/'.$sJob->jobId) }}">{!! $sJob->title !!}</a></strong></p>
                                            <p>{!! $sJob->companyName !!}</p>
                                            <p>{{ JobCallMe::cityName($sJob->city) }}, {{ JobCallMe::countryName($sJob->country) }}</p>
                                            <span class="rtj-action">
                                                <a href="{{ url('jobs/apply/'.$sJob->jobId) }}" title="Apply">
                                                    <i class="fa fa-paper-plane"></i>
                                                </a>&nbsp;
                                                <a href="javascript:;" onclick="removeJob({{ $sJob->jobId }})" title="Remove" class="application-remove">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            </span>
                                       </div>
                                   </div>
                               @endforeach
                            @else
                                <p>No saved jobs</p>
                            @endif
                       </div>
                       <div class="tab-pane" id="rtj_tab_application">
                       		@if(count($application) > 0)
                       			@foreach($application as $appl)
                                    <?php 
                                        $cLogo = url('compnay-logo/default-logo.jpg');
                                        if($appl->companyLogo != ''){
                                          $cLogo = url('compnay-logo/'.$appl->companyLogo);
                                        }
                                    ?>
                       				<div class="col-md-12 rtj-item" id="app-{{ $sJob->appl }}">
                                       <img src="{{ $cLogo }}" style="width: 50px">
                                       <div class="rtj-details">
                                            <p><strong><a href="{{ url('jobs/'.$appl->jobId) }}">{!! $appl->title !!}</a></strong></p>
                                            <p>{!! $appl->companyName !!}</p>
                                            <p>{{ JobCallMe::cityName($appl->city) }}, {{ JobCallMe::countryName($appl->country) }}</p>
                                            <span class="rtj-action">
                                                <a href="javascript:;" title="Applied On">
                                                    {{ date('M d Y, h:i A',strtotime($appl->applyTime))}}
                                                </a>
                                            </span>
                                       </div>
                                   </div>
                       			@endforeach
                       		@else
                       			<p>No job applications</p>
                       		@endif
                       </div>
                       <div class="tab-pane" id="rtj_tab_interview">
                          @if(count($interview) > 0)
                                @foreach($interview as $interv)
                                    <?php 
                                        $cLogo = url('compnay-logo/default-logo.jpg');
                                        if($interv->companyLogo != ''){
                                          $cLogo = url('compnay-logo/'.$interv->companyLogo);
                                        }
                                        $getInterview = JobCallMe::getJobInterview($interv->jobId,$interv->userId);
                                        $interviewUrl = url('account/jobseeker/interview/'.$getInterview->interviewId);
                                    ?>
                                    <div class="col-md-12 rtj-item">
                                       <img src="{{ $cLogo }}" style="width: 50px">
                                       <div class="rtj-details">
                                            <p><strong><a href="{{ $interviewUrl }}">{!! $interv->title !!}</a></strong></p>
                                            <p>{!! $interv->companyName !!}</p>
                                            <p>{{ JobCallMe::cityName($interv->city) }}, {{ JobCallMe::countryName($interv->country) }}</p>
                                            <span class="rtj-action">
                                                <a href="javascript:;" title="Applied On">
                                                    {{ date('M d Y, h:i A',strtotime($interv->applyTime))}}
                                                </a>
                                            </span>
                                       </div>
                                   </div>
                                @endforeach
                            @else
                                <p>No Interview schedule</p>
                            @endif
                       </div>
                   </div>
               </div>
           </div>
           <!--RTJ- Left end-->

           <!--RTJ- Right start-->
           <div class="col-md-6">
               <!--Follow Companies - Start -->
               <div class="follow-companies">
                   <h4>Companies to follow</h4>
                   <hr>
                   <div class="row">
                        @foreach($companies as $comp)
                            <?php
                            //print_r($company);exit;
                            $cLogo = url('compnay-logo/default-logo.jpg');
                            if($comp->companyLogo != ''){
                              $cLogo = url('compnay-logo/'.$comp->companyLogo);
                            }
                            ?>
                           <div class="col-md-3 col-xs-6 fc-item">
                               <img src="{{ $cLogo }}">
                               <p><a href="{{ url('companies/company/'.$comp->companyId) }}">{!! $company->companyName !!}</a></p>
                               @if(in_array($comp->companyId,$followArr))
                                    <a href="javascript:;" onclick="followCompany({{ $comp->companyId }},this)" class="btn btn-success btn-xs">Following</a>
                                @else
                                    <a href="javascript:;" onclick="followCompany({{ $comp->companyId }},this)" class="btn btn-primary btn-xs">Follow</a>
                                @endif
                           </div>
                       @endforeach
                       <hr>
                       <div class="col-md-12">
                           <a href="{{ url('companies') }}" class="pull-right" style="padding-top: 5px">View all</a>
                       </div>
                   </div>
               </div>
           </div>
           <!--RTJ- Right end-->
       </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
function removeJob(jobId){
    var type = 'remove';
    $('#saved-'+jobId).remove();
    $.ajax({ url: "{{ url('account/jobseeker/job/action') }}?jobId="+jobId+"&type="+type });
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
                window.location.href = "{{ url('account/login?next=companies/company/'.Request()->segment(3)) }}";
            }else if($.trim(response) == 'done'){
            }
        }
    })
}
</script>
@endsection