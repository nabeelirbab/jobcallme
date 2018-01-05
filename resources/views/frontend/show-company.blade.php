@extends('frontend.layouts.app')

@section('title', $company->companyName)

@section('content')
<?php
$cCover = url('compnay-logo/default-cover.jpg');
if($company->companyCover != ''){
  $cCover = url('compnay-logo/'.$company->companyCover);
}
$cLogo = url('compnay-logo/default-logo.jpg');
if($company->companyLogo != ''){
  $cLogo = url('compnay-logo/'.$company->companyLogo);
}
$opHour = json_decode($company->companyOperationalHour,true);
?>
<section id="edit-organization">
    <div class="container">
        <div class="eo-box">
            <div class="eo-timeline">
                <img src="{{ $cCover }}" class="eo-timeline-cover">
            </div>
            <div class="col-md-12">
               <div class="row">
                   <div class="col-md-2 eo-dp-box">
                       <img src="{{ $cLogo }}" class="eo-dp">
                   </div>
                   <div class="col-md-10 eo-timeline-details">
                       <h1><a href="{{ url('companies/company/'.$company->companyId) }}">{!! $company->companyName !!}</a></h1>
                       <div class="col-md-8 eo-section">
                           <div class="eo-details">
                               <span>Industry:</span> {!! JobCallMe::categoryName($company->category) !!}
                           </div>
                           <div class="eo-details">
                               <span>Established In:</span>  {!! date('M d, Y',strtotime($company->companyEstablishDate)) !!}
                           </div>
                           <div class="eo-details">
                               <span>No. of Employees:</span>  {!! $company->companyNoOfUsers !!}
                           </div>
                           <div class="eo-details">
                               <span>Location:</span>  {!! JobCallMe::cityName($company->companyCity).', '.JobCallMe::stateName($company->companyState).', '.JobCallMe::countryName($company->companyCountry) !!}
                           </div>
                           <div class="eo-details">
                               <span>Website:</span> <a href="{!! $company->companyWebsite !!}">{!! $company->companyWebsite !!}</a>
                           </div>
                       </div>
                       <div class="col-md-4 eo-section text-right">
                           <div class="row">
                                @if(in_array($company->companyId,$followArr))
                                    <a href="javascript:;" onclick="followCompany({{ $company->companyId }},this)" class="btn btn-success hvr-sweep-to-right">Following</a>
                                @else
                                    <a href="javascript:;" onclick="followCompany({{ $company->companyId }},this)" class="btn btn-primary hvr-sweep-to-right">Follow</a>
                                @endif
                               <div class="jd-share-btn cp-social">
                                   <a href="{!! $company->companyFb !!}"><i class="fa fa-facebook" style="background: #2e6da4;"></i> </a>
                                   <a href="{!! $company->companyLinkedin !!}"><i class="fa fa-linkedin" style=" background: #007BB6;"></i> </a>
                                   <a href="{!! $company->companyTwitter !!}"><i class="fa fa-twitter" style="background: #15B4FD;"></i> </a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
        </div>
        <div class="col-md-9 rtj-box">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#rtj_tab_about" data-toggle="tab"><i class="fa fa-list"></i> About</a>
                </li>
                <li>
                    <a href="#rtj_tab_jobs" data-toggle="tab"><i class="fa fa-briefcase"></i> Jobs </a>
                </li>
                <li>
                    <a href="#rtj_tab_operation" data-toggle="tab"><i class="fa fa-clock-o"></i> Operation Hours</a>
                </li>
            </ul>
            <div class="tab-content">
                <!--ABOUT-->
                <div class="tab-pane active" id="rtj_tab_about">
                    <div class="col-md-12">
                        <h4>About Us</h4>
                        <p>{!! $company->companyAbout !!}</p>
                    </div>
                </div>

                <!--JOBS-->
                <div class="tab-pane" id="rtj_tab_jobs">
                    @foreach($jobs as $job)
                        <div class="col-md-12 rtj-item">
                            <div class="rtj-details">
                                <p><strong><a href="{{ url('jobs/'.$job->jobId) }}">{{ $job->title }}</a></strong></p>
                                <p>{!! JobCallMe::cityName($company->companyCity).', '.JobCallMe::countryName($company->companyCountry) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!--OPERATION HOURS-->
                <div class="tab-pane" id="rtj_tab_operation">
                    <h4>Operation Hours</h4>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>MON</td>
                            <td>{!! $opHour['mon']['from'] !!} - {!! $opHour['mon']['to'] !!}</td>
                        </tr>
                        <tr>
                            <td>TUE</td>
                            <td>{!! $opHour['tue']['from'] !!} - {!! $opHour['thu']['to'] !!}</td>
                        </tr>
                        <tr>
                            <td>WED</td>
                            <td>{!! $opHour['wed']['from'] !!} - {!! $opHour['wed']['to'] !!}</td>
                        </tr>
                        <tr>
                            <td>THU</td>
                            <td>{!! $opHour['thu']['from'] !!} - {!! $opHour['thu']['to'] !!}</td>
                        </tr>
                        <tr>
                            <td>FRI</td>
                            <td>{!! $opHour['fri']['from'] !!} - {!! $opHour['fri']['to'] !!}</td>
                        </tr>
                        <tr>
                            <td>SAT</td>
                            <td>{!! $opHour['sat']['from'] !!} - {!! $opHour['sat']['to'] !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="rtj-box">

            </div>
        </div>
    </div>
</section>
<link href="{{ asset('frontend-assets/css/ihover.css') }}" rel="stylesheet">
<style type="text/css">
.ih-item.square.effect8 .info h3 {font-size: 13px;}
</style>
@endsection
@section('page-footer')
<script type="text/javascript">
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