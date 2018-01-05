@extends('frontend.layouts.app')

@section('title', 'Find Job')

@section('content')
<section id="jobs">
    <div class="container">
        <div class="col-md-12">
		
            <div class="col-md-3 job-search-box">
			<span>Refine Your Search</span>
			<br>
                <form action="" method="post" class="search-job" style="padding-top:13px">
                	<input type="hidden" name="_token" class="token">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ Request::input('keyword') }}" placeholder="Keyword">
                    </div>
                    <div class="form-group">
                       <select class="form-control" name="categoryId">
                       		<option value="">Select Category</option>
                       		@foreach(JobCallMe::getCategories() as $cat)
                                <option value="{!! $cat->categoryId !!}" {{ $cat->categoryId == Request::input('category') ? 'selected="selected"' : '' }}>{!! $cat->name !!}</option>
                            @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="jobType">
                            <option value="">Select Type</option>
                            @foreach(JobCallMe::getJobType() as $jtype)
                                <option value="{!! $jtype->name !!}" {{ $jtype->name == Request::input('type') ? 'selected="selected"' : '' }}>{!! $jtype->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="jobShift">
                            <option value="">Select Shift</option>
                            @foreach(JobCallMe::getJobShifts() as $jshift)
                                <option value="{!! $jshift->name !!}" {{ $jshift->name == Request::input('shift') ? 'selected="selected"' : '' }}>{!! $jshift->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="careerLevel">
                            <option value="">Select Career level</option>
                            @foreach(JobCallMe::getCareerLevel() as $career)
                                <option value="{!! $career !!}" {{ $career == Request::input('career') ? 'selected="selected"' : '' }}>{!! $career !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="experience">
                            <option value="">Select Experience</option>
                            @foreach(JobCallMe::getExperienceLevel() as $experience)
                                <option value="{!! $experience !!}" {{ $experience == Request::input('experience') ? 'selected="selected"' : '' }}>{!! $experience !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="minSalary" value="" placeholder="Minimum Salary ">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="maxSalary" value="" placeholder="Maximum Salary">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="currency">
                            <option value="">Select Currency</option>
                            @foreach(JobCallMe::siteCurrency() as $currency)
                                <option value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control job-country" name="country">
                            <option value="0">Select Country</option>
                            @foreach(JobCallMe::getJobCountries() as $country)
                                <option value="{{ $country->id }}" {{ $country->id == trim(Request::input('country')) ? 'selected="selected"' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control job-state" name="state" data-state="{{ Request::input('state') }}">
                            <option value="0">Select City</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control job-city" name="city" data-city="{{ Request::input('city') }}">
                            <option value="0">Select City</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit" name="save">SEARCH</button>
                    </div>
                </form>
            </div>
            <div class="col-md-9 show-jobs">
                <p style="text-align:center;">Loading ....</p>
            </div>
        </div>
     </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
.jobs-suggestions:hover {background-color: #f9f9f9;}
.jobs-suggestions img {
    position: absolute;
    right: 24px;
    top: 54%;
    vertical-align: top;
	width:7%;
	border-radius: 50%;
    height: 70px;
}
</style>
<script type="text/javascript">
var isFirst = 0;
var token = "{{ csrf_token() }}";
$(document).ready(function(){
	$('.search-job').submit();
    getStates($('.job-country option:selected:selected').val());
})
$('.job-country').on('change',function(){
    var countryId = $(this).val();
    getStates(countryId)
})
function getStates(countryId){
    $.ajax({
        url: "{{ url('account/get-state') }}/"+countryId,
        success: function(response){
            var currentState = $('.job-state').attr('data-state');
            var obj = $.parseJSON(response);
            $(".job-state").html('');
            var newOption = new Option('Select State', '0', true, false);
            $(".job-state").append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var vOption = k.id == currentState ? true : false;
                var newOption = new Option(firstCapital(k.name), k.id, true, vOption);
                $(".job-state").append(newOption);
            })
            $(".job-state").trigger('change');
        }
    })
}
$('.job-state').on('change',function(){
    var stateId = $(this).val();
    getCities(stateId)
})
function getCities(stateId){
    if(stateId == '0'){
        $(".job-city").html('').trigger('change');
        var newOption = new Option('Select City', '0', true, false);
        $(".job-city").append(newOption).trigger('change');
        return false;
    }
    $.ajax({
        url: "{{ url('account/get-city') }}/"+stateId,
        success: function(response){
            var currentCity = $('.job-city').attr('data-city');
            var obj = $.parseJSON(response);
            $(".job-city").html('').trigger('change');
            var newOption = new Option('Select City', '0', true, false);
            $(".job-city").append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var vOption = k.id == currentCity ? true : false;
                var newOption = new Option(k.name, k.id, true, vOption);
                $(".job-city").append(newOption).trigger('change');
            })
        }
    })
}
function firstCapital(myString){
    firstChar = myString.substring( 0, 1 );
    firstChar = firstChar.toUpperCase();
    tail = myString.substring( 1 );
    return firstChar + tail;
}
$('form.search-job').submit(function(e){
	//$('.search-job button[name="save"]').prop('disabled',true);
    $('.search-job .token').val(token);
	$.ajax({
		type: 'post',
		data: $('.search-job').serialize(),
		url: "{{ url('jobs/search') }}?_find="+isFirst,
		success: function(response){
			$('.show-jobs').html(response);
			$('.search-job button[name="save"]').prop('disabled',false);

			$('.jobs-suggestions').hover(function () {
		        $(this).children(".js-action").fadeIn('slow');

		    });
		    $('.jobs-suggestions').mouseleave(function () {
		        $(this).children(".js-action").fadeOut('fast');
		    });

            $('.search-job select option[value=""]').prop('selected',true);
            $('.search-job input').val('');
            $('.search-job .job-city').html('<option value="">Select City</option>');
		}
	})
	isFirst = 1;
	e.preventDefault();
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
</script>
@endsection