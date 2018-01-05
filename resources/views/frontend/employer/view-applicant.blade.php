@extends('frontend.layouts.app')

@section('title','Applicant')

@section('content')
<section id="myResume">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    <!--Personal Info Start-->
                    <section class="personal-info-section" id="personal-information">
                        <div class="row">
                            <div class="col-md-3">
                                <div>
                                    <img src="{{ url('profile-photos/'.$applicant->profilePhoto) }}" class="img-circle" style="width: 100%">
                                </div>
                                <h3 class="text-center hidden-md hidden-lg" style="font-weight: 600">$applicant->firstName Smith</h3>
                                <p class="text-center hidden-md hidden-lg jp-profession-heading">Web Developer and Designer</p>
                                <a href="#" class="btn btn-primary btn-block jp-contact-btn">CONTACT DETAILS</a>
                            </div>
                            <div class="col-md-9 personal-info-right">
                                <h3 class="hidden-sm hidden-xs">{{$applicant->firstName}} {{$applicant->lastName}}</h3>
                                <p class="jp-profession-heading hidden-sm hidden-xs">Web Developer and Designer</p>
                                <p><span class="pi-title">Experiance:</span>{{$applicant->experiance}}</p>
                                <p><span class="pi-title">Industry:</span> {{ JobCallMe::categoryTitle($applicant->industry) }}</p>
                                <p><span class="pi-title">Salary:</span> {{ number_format($applicant->currentSalary != '' ? $applicant->currentSalary : '0',2).' '.$applicant->currency }}</p>
                                <div class="professional-summary">
                                    <h4>Professional Summary</h4>
                                    <p>{{$applicant->about}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--Personal Info End-->

                    <!--Academic Section Start-->
                    <section class="resume-box" id="academic">
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  Academic</h4>
                        <ul class="resume-details">
                           @if(count($resume['academic']) > 0)
                                @foreach($resume['academic'] as $resumeId => $academic)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                            
                                            <p class="rd-date">{!! date('M, Y',strtotime($academic->completionDate)) !!}</p>
                                            <p class="rd-title">{!! $academic->degree !!}</p>
                                            <p class="rd-organization">{!! $academic->institution !!}</p>
                                            <p class="rd-location">{!! ucfirst($academic->country) !!}</p>
                                            <p class="rd-grade">Grade/GPA : {!! $academic->grade !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <!--Academic Section End-->

                    <!--Academic Section Start-->
                    <section class="resume-box" id="experience">
                        <h4><i class="fa fa-star r-icon bg-primary"></i>  Experience</h4>
                        <ul class="resume-details">
                         @if(count($resume['experience']) > 0)
                                @foreach($resume['experience'] as $resumeId => $experience)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                         
                                            <p class="rd-date">{!! date('M, Y',strtotime($experience->startDate)) !!} - {{ $experience->currently == 'yes' ? 'Currently Working' : date('M, Y',strtotime($experience->endDate)) }}</p>
                                            <p class="rd-title">{!! $experience->jobTitle !!}</p>
                                            <p class="rd-organization">{!! $experience->organization !!}</p>
                                            <p class="rd-location">{!! ucfirst($experience->country) !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <!--Academic Section End-->

                    <!--Academic Section Start-->
                    <section class="resume-box" id="projects">
                        <h4><i class="fa fa-edit r-icon bg-primary"></i>  Projects</h4>
                        <ul class="resume-details">
                            <li>
                                <div class="col-md-12">
                                    <p class="rd-title">Job Call Me</p>
                                    <p class="rd-date">May,2017 - Currently Working</p>
                                    <p class="rd-organization">Nexus Enterprises</p>
                                    <p class="rd-location">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam porta vitae mauris ac elementum.
                                        Morbi ut semper odio. Proin velit odio, auctor ut pulvinar nec, porttitor sed ligula. Curabitur semper iaculis ullamcorper.
                                        Vestibulum dignissim a mauris a pulvinar. Morbi placerat quis orci sit amet varius. Praesent suscipit pretium felis vel tempor.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <!--Academic Section End-->

                    <!--Academic Section Start-->
                    <section class="resume-box" id="certification">
                        <h4><i class="fa fa-certificate r-icon bg-primary"></i>  Certification</h4>
                        <ul class="resume-details">
                            @if(count($resume['certification']) > 0)
                                @foreach($resume['certification'] as $resumeId => $certification)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                         
                                            <p class="rd-date">{!! date('M, Y',strtotime($certification->completionDate)) !!}</p>
                                            <p class="rd-title">{!! $certification->certificate !!}</p>
                                            <p class="rd-organization">{!! $certification->institution !!}</p>
                                            <p class="rd-location">{!! ucfirst($certification->country) !!}</p>
                                            <p class="rd-grade">Score : {!! $certification->score !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <!--Academic Section End-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
.input-error{color: red;}
</style>
<script type="text/javascript">
var token = "{{ csrf_token() }}";
$(document).ready(function(){
    $('button[data-toggle="tooltip"],a[data-toggle="tooltip"]').tooltip();
})
</script>
@endsection