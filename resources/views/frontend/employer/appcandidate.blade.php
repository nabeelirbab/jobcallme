@extends('frontend.layouts.app')

@section('title','Applicant')

@section('content')
<section id="myResume">
    <div class="container">
		
  <ul class="nav nav-tabs" style="margin-top:20px">
    <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-user" aria-hidden="true"></i> Resume</a></li>
    <li><a data-toggle="tab" href="#menu1"><i class="fa fa-comments" aria-hidden="true"></i> Conversation</a></li>
    <li><a data-toggle="tab" href="#menu2"><i class="fa fa-clipboard" aria-hidden="true"></i> Questionnaire</a></li>
    <li><a data-toggle="tab" href="#menu3"><i class="fa fa-calendar" aria-hidden="true"></i> Interviews</a></li>
  </ul>
        <div class="row">
      <div class="col-md-12">
    <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        
                    <!--Personal Info Start-->
                    <section class="personal-info-section" id="personal-information">
                        <div class="row">
                            <div class="col-md-3">
                                <div>
                                    <img src="{{ url('profile-photos/'.$applicant->profilePhoto) }}" style="width: 100%;height:221px;">
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
    <div id="menu1" class="tab-pane fade">
          <section class="personal-info-section" id="personal-information">
                        <div class="row">
						<div class="col-md-12">
						<textarea class="form-control area"  placeholder="Message"></textarea>
						</div>
						<div class="col-md-2">
						<div class="checkbox">
  <label><input type="checkbox" value="">Send on enter
</label>
</div>
						</div>
						<div class="col-md-10">
						<button  type="button" class="btn btn-success pull-right" style="margin-top:12px">Send</button>
						</div>
						</div>
						</section>
    </div>
    <div id="menu2" class="tab-pane fade">
      <section class="personal-info-section" id="personal-information">
                        <div class="row">
						<div class="col-md-12">
						<p>No Questionnaire or Test scheduled yet.</p>
						</div>
						</div>
						</section>
    </div>
    <div id="menu3" class="tab-pane fade">
     <!-- schedule interview -->
                    <div class="col-md-12 ea-scheduleInerview">
                        <div class="col-md-12" style="margin-top: 10px;">
                            <form action="#" method="" class="form-horizontal interview-forms">
                                <input type="hidden" name="_token" class="token">
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">Applicants</label>
                                    <div class="col-md-6">
									 <input type="text" class="form-control date-picker" name="applicantInter[]" value="{{$applicant->firstName}} {{$applicant->lastName}}" onkeypress="return false">
                                       
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">From</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control date-picker" name="fromDate" value="{{ date('Y-m-d',strtotime('+1 Day')) }}" onkeypress="return false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">To</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control date-picker" name="toDate" value="{{ date('Y-m-d',strtotime('+2 Day')) }}" onkeypress="return false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">Time per interview</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="perInterview">
                                            @for($i = 1; $i < 10; $i++)
                                                <option value="{{ $i * 20 }}">{{ ($i * 20).' Minutes' }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">Interview Venue</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="venue">
                                            @foreach(JobCallMe::interviewVenue() as $venue)
                                                <option value="{{ $venue->venueId }}">{!! $venue->title !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">&nbsp;</label>
                                    <div class="col-md-6">
                                        <button type="submit" name="save" class="btn btn-primary pull-right">Save</button>
                                       <!-- <button type="button" class="btn btn-default" onclick="$('.ea-scheduleInerview').fadeOut()">Cancel</button> !-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
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
$('form.interview-form').submit(function(e){
    $('.interview-form button[name="save"]').prop('disabled',true);

    $('.interview-form .token').val(token);
    $.ajax({
        type: 'post',
        data: $('.interview-form').serialize(),
        url: "{{ url('account/employer/application/interview/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                toastr.error(response, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }else{
                toastr.success('Action perform successfully', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
                $('.ea-scheduleInerview').fadeOut();
            }
            $('.interview-form button[name="save"]').prop('disabled',false);
        }
    })
    e.preventDefault();
})

</script>
@endsection