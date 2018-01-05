@extends('frontend.layouts.app')

@section('title', "$job->title")

@section('content')
<section id="jobs">
    <div class="container">
        <div class="col-md-10">
            <div class="jobs-suggestions">
            	@include('frontend.includes.alerts')
                <h4>{{ $job->title }}</h4>
                <p class="text-success">Almost done, few questions before your resume is accepted for this job.</p>
                <hr>
                <form action="" method="post">
                	{{ csrf_field() }}
                	<input type="hidden" name="jobId" value="{{ $job->jobId }}">
                    <div class="ja-question-box">
                        <div class="pull-right ja-check">
                            <input type="checkbox" id="qualification" class="switch-field" name="qualification" value="yes"/>
                            <label for="qualification" class="switch-label"><span class="ui"></span></label>
                        </div>
                        <p class="ja-question">Q: Do you have any of the following or equivalent qualification?</p>
                        <div class="ja-specification">
                            {{ $job->qualification }}
                        </div>
                    </div>
                    <div class="ja-question-box">
                        <div class="pull-right ja-check">
                            <input type="checkbox" id="experience" class="switch-field" name="experience" value="yes" />
                            <label for="experience" class="switch-label"><span class="ui"></span></label>
                        </div>
                        <p class="ja-question">Q: Do you have work experience of {{ $job->experience }}?</p>
                    </div>
                    <div class="ja-question-box">
                        <div class="pull-right ja-check">
                            <input type="checkbox" id="skills" class="switch-field" name="skills" value="yes" />
                            <label for="skills" class="switch-label"><span class="ui"></span></label>
                        </div>
                        <p class="ja-question">Q: Do you have the following skills?</p>
                        <p>{!! $job->skills !!}</p>
                    </div>
                    <div class="ja-question-box">
                        <div class="pull-right ja-check">
                            <input type="checkbox" id="location" class="switch-field" name="location"/>
                            <label for="location" class="switch-label"><span class="ui"></span></label>
                        </div>
                        <p class="ja-question">Q: Are you located in one of the following cities or willing to relocate?</p>
                        <div class="ja-specification">
                            {!! JobCallMe::cityName($job->city) !!}, {!! JobCallMe::countryName($job->country) !!}
                        </div>
                    </div>
                    @if(strtotime($job->expiryDate) < strtotime(date('Y-m-d')))
                        <button type="button" class="btn btn-danger" disabled="disabled">This job has been closed</button>
                    @elseif($jobApplied == true)
                        <button type="button" class="btn btn-success">You have already applied to this job</button>
                        <a href="{{ url('jobs/'.$job->jobId) }}" class="btn btn-default">CANCEL</a>
                    @else
                        <button type="submit" class="btn btn-primary" id="submitbutton" disabled="disabled">APPLY</button>
                        <a href="{{ url('jobs/'.$job->jobId) }}" class="btn btn-default">CANCEL</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
$(document).ready(function(){
})
$('.switch-field').click(function(){
	var totalLength = $('.switch-field').length;
	var checkedLength = $('.switch-field:checked:checked').length;
	if(totalLength == checkedLength){
		$('#submitbutton').prop('disabled',false);
	}else{
		$('#submitbutton').prop('disabled',true);
	}
})
</script>
@endsection