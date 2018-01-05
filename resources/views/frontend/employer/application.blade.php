@extends('frontend.layouts.app')

@section('title','Application')

@section('content')
<?php
$inbox = 'ja-tab-active';
if(Request::input('show') != ''){
    $showTab = Request::input('show');
    $$showTab = 'ja-tab-active';
    $inbox = '';
}
?>
<section id="jobs">
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-2 ">
                <div class="row">
                    <div class="col-md-12 jobApp-tabs">
                        <a id="inbox" class="btn btn-block jaTabBtn {{ $inbox }}"><i class="fa fa-users"></i>  Inbox</a>
                        <a id="junk" class="btn btn-block jaTabBtn {{ $junk }}"><i class="fa fa-ban"></i>  Junks</a>
                        <a id="shortlist" class="btn btn-block jaTabBtn {{ $shortlist }}"><i class="fa fa-thumbs-up"></i>  Shortlists</a>
                        <a id="screened" class="btn btn-block jaTabBtn {{ $screened }}"><i class="fa fa-mobile"></i>  Screened</a>
                        <a id="interview" class="btn btn-block jaTabBtn {{ $interview }}"><i class="fa fa-calendar"></i>  interviews</a>
                        <a id="offer" class="btn btn-block jaTabBtn {{ $offer }}"><i class="fa fa-ticket"></i>  Offered</a>
                        <a id="hire" class="btn btn-block jaTabBtn {{ $hire }}"><i class="fa fa-archive"></i>  Hire</a>
                        <a id="reject" class="btn btn-block jaTabBtn {{ $reject }}"><i class="fa fa-thumbs-down"></i>  Reject</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="ja-content">
                    <div class="ea-top-panel">
                        <button type="button" class="ea-panel-btn hidden-sm hidden-xs" id="full-screen"><i class="fa fa-arrows-alt"></i>
                            <div class="ea-toolkit">Toggle Full screen</div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="shortlist">
                            <i class="fa fa-thumbs-up"></i>
                            <div class="ea-toolkit">Shortlist Selected Applicant</div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="reject">
                            <i class="fa fa-thumbs-down"></i>
                            <div class="ea-toolkit">Reject Selected Applicant</div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="screened">
                            <i class="fa fa-mobile"></i>
                            <div class="ea-toolkit"><p>Mark Selected as Phone Screened </p></div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="offer">
                            <i class="fa fa-ticket"></i>
                            <div class="ea-toolkit"><p>Send job offer to selected applicants </p></div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="hire">
                            <i class="fa fa-archive"></i>
                            <div class="ea-toolkit">Mark Selected as Hired</div>
                        </button>
                        <button type="button" class="ea-panel-btn ea-npm-click" data-type="junk">
                            <i class="fa fa-ban"></i>
                            <div class="ea-toolkit">Mark Selected as Junk</div>
                        </button>
                        <button type="button" class="ea-panel-btn" id="ea-showFrom" style="display: none;">
                            <i class="fa fa-envelope"></i>
                            <div class="ea-toolkit">Send Message to Selected Applicant</div>
                        </button>
                        <button type="button" class="ea-panel-btn" id="ea-scheduleInerview">
                            <i class="fa fa-briefcase"></i>
                            <div class="ea-toolkit">Schedule Interview of Selected Applicant</div>
                        </button>
                        <button type="button" class="ea-panel-btn"><i class="fa fa-download"></i>
                            <div class="ea-toolkit">Export Selected</div>
                        </button>
                        <select class="form-control pull-right select-jobs" style="width: 150px;height: 30px;" onchange="findApplication(this.value)">
                            <option value="0">All Jobs</option>
                            @foreach($jobs as $job)
                                <option value="{!! $job->jobId !!}">{!! $job->title !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--Toggle message box -->
                    <div class="col-md-12 ea-messageForm">
                        <div class="col-md-offset-3 col-md-6">
                            <form action="#" method="">
                                <div class="form-group">
                                    <select class="form-control select2" name="applicantMsg">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="applicant-msg"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- schedule interview -->
                    <div class="col-md-12 ea-scheduleInerview" style="display: none">
                        <div class="col-md-12" style="margin-top: 10px;">
                            <form action="#" method="" class="form-horizontal interview-form">
                                <input type="hidden" name="_token" class="token">
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right">Applicants</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 mul-appl" name="applicantInter[]" multiple="">
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
                                        <button type="button" class="btn btn-default" onclick="$('.ea-scheduleInerview').fadeOut()">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Application area -->
                    <div id="application-content" class="ja-content-item">
                        <div class="col-md-12 ea-no-record">Loading ...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
var isRunning = false;
var token = "{{ csrf_token() }}";
$(document).ready(function(){
    initialize();
    $('.jaTabBtn.ja-tab-active').click();
})
$('.jaTabBtn').click(function () {
    var type = $(this).attr('id');
    if(isRunning == true || $('#application-content').attr('data-application') == type){ return false; }

    var jobId = $('.select-jobs option:selected:selected').val();

    $(this).addClass('ja-tab-active').siblings().removeClass('ja-tab-active');
    isRunning = true;
    getApplications(type,jobId);
});
function getApplications(type,jobId){
    $.ajax({
        url: "{{ url('account/employer/application') }}/"+type+"?jobId="+jobId,
        success: function(response){
            isRunning = false;
            var obj = $.parseJSON(response);
            $('#application-content').html(obj.vhtml);
            $('#application-content').attr('data-application',type);

            var eApplicant = {};
            if($('input[name="applicant[]"]:checked:checked').length > 0){
                $('input[name="applicant[]"]:checked:checked').each(function(){
                    eApplicant.push($(this).val());
                })
            }
            $('.mul-appl').html('').trigger('change');
            $.each(obj.userArr,function(i,k){
                var vOption = $.inArray(i,eApplicant) != '-1' ? true : false;
                var newOption = new Option(k, i, true, vOption);
                $(".mul-appl").append(newOption).trigger('change');
            })
            initialize();
        }
    })
}
$('.ea-panel-btn').hover(function () {
    $(this).children(".ea-toolkit").show();
});
$('.ea-panel-btn').mouseleave(function () {
    $(this).children(".ea-toolkit").hide();
});
$("#ea-showFrom").click(function(){
    var vlength = $('input[name="applicant[]"]:checked:checked').length;
    if(vlength == 0){
        toastr.error('Please select some applicant first', '', {timeOut: 5000, positionClass: "toast-top-center"});
    }else{
        $(".ea-messageForm").slideToggle("slow");
    }
});
function initialize(){
    $(".cbx-field").prop("checked", false);
    $(".cbx-field").click(function () {
        if ($(this).is(":checked")) {
            //checked
            $(this).parent('td').parent().addClass("ea-record-selected");
        } else {
            //unchecked
            $(this).parent('td').parent().removeClass("ea-record-selected");
        }
    })
    $('#select-all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;

                $('.ea-single-record').addClass('ea-record-selected');
            });
        }
        else{
            $(':checkbox').each(function() {
                this.checked = false;
                $('table tr').removeClass('ea-record-selected');
            });
        }
    });
}
$('#full-screen').click(function(e){
    $('.ja-content').toggleClass('ea-fullscreen');
});
function findApplication(jobId){
    var type = $('.jaTabBtn.ja-tab-active').attr('id');
    getApplications(type,jobId);
}
$('.ea-npm-click').click(function(){
    var type = $(this).attr('data-type');
    var appString = '';
    if($('input[name="applicant[]"]:checked:checked').length > 0){
        $('input[name="applicant[]"]:checked:checked').each(function(){
            appString += $(this).val()+',';
        })
        $.ajax({
            type: 'post',
            data: {type:type,ids:appString,_token:token},
            url: "{{ url('account/employer/update/application') }}",
            success: function(response){
                toastr.success('Action successfully perform', '', {timeOut: 5000});
            }
        })
    }else{
        toastr.error('Please select some applicant', '', {timeOut: 5000, positionClass: "toast-top-center"});
    }
})
$('#ea-scheduleInerview').click(function(){
    if($('input[name="applicant[]"]:checked:checked').length > 0){
        $('.mul-appl > option').prop("selected",false);
        $('.mul-appl').trigger('change');
        $('input[name="applicant[]"]:checked:checked').each(function(){
            $('.mul-appl option[value="'+$(this).val()+'"]').prop('selected',true);
        });
        $('.mul-appl').trigger('change');
        $('.ea-scheduleInerview').fadeIn();
    }else{
        toastr.error('Please select some applicant', '', {timeOut: 5000, positionClass: "toast-top-center"});
    }
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