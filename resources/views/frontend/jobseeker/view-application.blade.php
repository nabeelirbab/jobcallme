@extends('frontend.layouts.app')

@section('title',"Welcome $user_name")

@section('content')
<?php
$delivered = 'ja-tab-active';
if(Request::input('show') != ''){
    $showTab = Request::input('show');
    $$showTab = 'ja-tab-active';
    $delivered = '';
}
?>
<section id="jobsApplications">
    <div class="container">
        <div class="col-md-2 jobApp-tabs">
            <a id="delivered" class="btn btn-block jaTabBtn {{ $delivered }}">Delivered</a>
            <a id="shortlist" class="btn btn-block jaTabBtn {{ $shortlist }}">Shortlisted</a>
            <a id="interview" class="btn btn-block jaTabBtn {{ $interview }}">Interviews</a>
            <a id="offer" class="btn btn-block jaTabBtn {{ $offer }}">Offered</a>
            <a id="reject" class="btn btn-block jaTabBtn {{ $reject }}">Unsuccessful</a>
        </div>
        <div class="col-md-10">
            <div class="ja-content">
                <!--Application-->
                <div id="application-show" class="ja-content-item"></div>
                <!--Application End-->
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
    var firstSelect = $('.jaTabBtn.ja-tab-active');
    $(firstSelect).removeClass('ja-tab-active');
    $(firstSelect).click();
})
$('.jaTabBtn').click(function () {
    if($(this).hasClass('ja-tab-active')){
        return false;
    }
    $(this).addClass('ja-tab-active').siblings().removeClass('ja-tab-active');
    var type = $(this).attr('id');
    $.ajax({
        url: "{{ url('account/jobseeker/application') }}/"+type,
        success: function(response){
            $('#application-show').html(response);
        }
    })
});
function removeApplication(applyId){
    if(confirm('Are you sure?')){
        $.ajax({
            url: "{{ url('account/jobseeker/application/remove') }}/"+applyId,
            success: function(response){
                $('#apply-'+applyId).remove();
            }
        })
    }
}
</script>
@endsection