@extends('frontend.layouts.app')

@section('title', 'Manage')

@section('content')
<?php
$userImage = url('profile-photos/profile-logo.jpg');
if($user->profilePhoto != ''){
    $userImage = url('profile-photos/'.$user->profilePhoto);
}
?>
<section id="jobs">
    <div class="container">
        <h3>Settings</h3>
        <div class="col-md-2 jobApp-tabs">
            <h5 class="mtab-heading">Account</h5>
            <a id="password" class="btn btn-block jaTabBtn ja-tab-active">Change Password</a>
            <a id="profile" class="btn btn-block jaTabBtn">Edit Profile</a>
            <a id="notification" class="btn btn-block jaTabBtn">Notification</a>
            <a id="privacy" class="btn btn-block jaTabBtn">Privacy</a>
            <h5 class="mtab-heading">Organization</h5>
            <a href="{{ url('account/employer/departments') }}" class="btn btn-block jaTabBtn">Departments</a>
            <a href="{{ url('account/employer/organization') }}" class="btn btn-block jaTabBtn ext-link">Edit Organization</a>
            <a href="{{ url('account/employer/interview-venues/') }}" class="btn btn-block jaTabBtn ext-link">Interview Venues</a>
			<a href="#" class="btn btn-block jaTabBtn ext-link">Users</a>
			<a href="#" class="btn btn-block jaTabBtn ext-link">Evaluation Forms</a>
			<a href="#" class="btn btn-block jaTabBtn ext-link">Questionnaires</a>
            <!-- <a class="btn btn-block jaTabBtn">Users</a>
            <a class="btn btn-block jaTabBtn">Evaluation Form</a>
            <a class="btn btn-block jaTabBtn">Questionnaires</a> -->
			<h5 class="mtab-heading">Subscription </h5>
			<a href="#" class="btn btn-block jaTabBtn ext-link">Credits</a>
			<a href="#" class="btn btn-block jaTabBtn ext-link">Orders</a>
			
			
            <h5 class="mtab-heading">Deactivation</h5>
            <a class="btn btn-block" data-popup-open="popup-1">Deactivate Account</a>
        </div>
        <div class="col-md-10">
            <div class="ja-content">
                <!--Change Password-->
                <div id="password-show" class="ja-content-item mc-item">
                    <h4>Change Password</h4>
                    <form class="form-horizontal password-form" method="post" action="">
                        <input type="hidden" name="_token" value="">
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Old Password</label>
                            <div class="col-md-6">
                                <input type="password" name="oldPassword" class="form-control input-sm" placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">New Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control input-sm" placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">&nbsp;</label>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" name="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Edit Profile-->
                <div id="profile-show" class="ja-content-item mc-item" style="display: none">
                    <h4>Edit Profile</h4>
                    <form class="form-horizontal profile-form" method="post" action="">
                        <input type="hidden" name="_token" value="">
                        <div class="form-group">
                             <label class="control-label col-md-3 text-right">Profile Photo</label>
                            <div class="col-md-6">
                                <div class="re-img-box">
                                    <img src="{{ $userImage }}" class="img-circle">
                                    <div class="re-img-toolkit">
                                        <div class="mc-file-btn">
                                             <i class="fa fa-camera"></i> Change
                                            <input class="upload profile-pic" name="image" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Name</label>
                            <div class="col-md-6">
                                <div class="col-md-6 f-name" style="margin-bottom: 5px;padding-left: 0px;">
                                    <input type="text" class="form-control input-sm" name="firstName" value="{{ $user->firstName }}">
                                </div>
                                <div class="col-md-6 l-name" style="margin-bottom: 5px;padding-right: 0px;">
                                    <input type="text" class="form-control input-sm" name="lastName" value="{{ $user->lastName }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Email</label>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control input-sm" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Phone Number</label>
                            <div class="col-md-6">
                                <input type="text" name="phoneNumber" class="form-control input-sm" value="{{ $user->phoneNumber }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Address</label>
                            <div class="col-md-6">
                                <textarea name="address" class="form-control input-sm">{{ $meta->address }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Country</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-country" name="country">
                                    @foreach(JobCallMe::getJobCountries() as $cntry)
                                        <option value="{{ $cntry->id }}" {{ $user->country == $cntry->id ? 'selected="selected"' : ''}}>{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">State</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-state" name="state" data-state="{{ $user->state }}"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">City</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-city" name="city" data-city="{{ $user->city }}"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">&nbsp;</label>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" name="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Notification-->
                <div id="notification-show" class="ja-content-item mc-item" style="display: none;">
                    <form class="form-horizontal notification-form" method="post" action="">
                        <h4>Account</h4>
                        <input type="hidden" name="_token" value="">
                        <div class="form-group">
                            <div class="col-md-12 mc-notification">
                                <label class="col-md-3 control-label">Service Alerts</label>
                                <div class="col-md-9">
                                    <p style="margin-top: 4px">
                                        <input type="checkbox" id="service-alert" class="switch-field" name="serviceAlert" {{ $noti->serviceAlert == 'Yes' ? 'checked=""' : '' }} >
                                        <label for="service-alert" class="switch-label"><span class="ui"></span></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 mc-notification">
                                <label class="col-md-3 control-label">Messages</label>
                                <div class="col-md-9">
                                    <p style="margin-top: 4px">
                                        <input type="checkbox" id="message-alert" class="switch-field" name="messageAlert" {{ $noti->messageAlert == 'Yes' ? 'checked=""' : '' }}>
                                        <label for="message-alert" class="switch-label"><span class="ui"></span></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h4>Employer Account</h4>
                        <div class="form-group">
                            <div class="col-md-12 mc-notification">
                                <label class="col-md-3 control-label">Daily Job Alerts</label>
                                <div class="col-md-9">
                                    <p style="margin-top: 4px">
                                        <input type="checkbox" id="new-application" class="switch-field" name="newApplication" {{ $noti->newApplication == 'Yes' ? 'checked=""' : '' }}>
                                        <label for="new-application" class="switch-label"><span class="ui"></span></label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 mc-notification">
                                <label class="col-md-3 control-label">Closing Jobs</label>
                                <div class="col-md-9">
                                    <p style="margin-top: 4px">
                                        <input type="checkbox" id="closing-jobs" class="switch-field" name="closingJobs" {{ $noti->closingJobs == 'Yes' ? 'checked=""' : '' }}>
                                        <label for="closing-jobs" class="switch-label"><span class="ui"></span></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h4>Job Alerts</h4>
                        <div class="col-md-12 mc-notification">
                            <label class="col-md-3 control-label">Daily Job Alerts</label>
                            <div class="col-md-9">
                                <p style="margin-top: 4px">
                                    <input type="checkbox" id="job-alert" class="switch-field" name="jobAlert" {{ $noti->jobAlert == 'Yes' ? 'checked=""' : '' }}>
                                    <label for="job-alert" class="switch-label"><span class="ui"></span></label>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Country</label>
                            <div class="col-md-9">
                                <select class="form-control input-sm mc-field jjob-country" name="country">
                                    @foreach(JobCallMe::getJobCountries() as $cntry)
                                        <option value="{{ $cntry->id }}" {{ $noti->country == $cntry->id ? 'selected="selected"' : ''}}>{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">State</label>
                            <div class="col-md-9">
                                <select class="form-control input-sm mc-field jjob-state" name="state" data-state="{{ $noti->state }}">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">City</label>
                            <div class="col-md-9">
                                <select class="form-control input-sm mc-field jjob-city" name="city" data-city="{{ $noti->city }}">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-9">
                                <select class="form-control input-sm mc-field" name="category">
                                    @foreach(JobCallMe::getCategories() as $cat)
                                        <option value="{{ $cat->categoryId }}" {{ $noti->category == $cat->categoryId ? 'selected="selected"' : '' }}>{!! $cat->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">&nbsp;</label>
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit" name="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!--privacy-->
                <div id="privacy-show" class="ja-content-item mc-item" style="display: none;">
                    <form class="form-horizontal privacy-form" method="post" action="">
                        <input type="hidden" name="_token" value="">
                        <h4>Privacy Settings</h4>
                        <div class="col-md-12">
                            <p style="margin-top: 4px">
                                <input type="checkbox" id="profile-visible" class="switch-field" name="profile" {{ $privacy->profile != 'No' ? 'checked=""' : '' }}>
                                <label for="profile-visible" class="switch-label"></label> <span>Make Profile Visible</span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p style="margin-top: 4px">
                                <input type="checkbox" id="image-visible" class="switch-field" name="profileImage" {{ $privacy->profileImage != 'No' ? 'checked=""' : '' }}>
                                <label for="image-visible" class="switch-label"></label> <span>Make Profile Picture Visible</span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p style="margin-top: 4px">
                                <input type="checkbox" id="academic-visible" class="switch-field" name="academic" {{ $privacy->academic != 'No' ? 'checked=""' : '' }}>
                                <label for="academic-visible" class="switch-label"></label> <span>Make Academic Visible</span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p style="margin-top: 4px">
                                <input type="checkbox" id="experience-visible" class="switch-field" name="experience" {{ $privacy->experience != 'No' ? 'checked=""' : '' }}>
                                <label for="experience-visible" class="switch-label"></label> <span>Make Experience Visible</span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p style="margin-top: 4px">
                                <input type="checkbox" id="skills-visible" class="switch-field" name="skills" {{ $privacy->skills != 'No' ? 'checked=""' : '' }}>
                                <label for="skills-visible" class="switch-label"></label> <span>Make Skills Visible</span>
                            </p>
                        </div>
                    </form>
                </div>

                <!--Deactivate account-->
                <div class="popup" data-popup="popup-1">
                    <div class="popup-inner">
                        <h4>Deactivate Account</h4>
                        <p>Warning! Once deactivated you wont be able to login to your account, Are you sure you want to deactivate your account?</p>
                        <button href="#" class="btn btn-danger">YES DEACTIVATE MY ACCOUNT</button>
                        <button class="btn btn-default" data-popup-close="popup-1" >CLOSE</button>
                        <a class="popup-close" data-popup-close="popup-1" href="#">&times;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
.text-danger{color: #ff0000 !important;}
</style>
<script type="text/javascript">
var pageToken = '{{ csrf_token() }}';
$(document).ready(function(){
    getStates($('.job-country option:selected:selected').val(),'job-state');
    getStates($('.job-country option:selected:selected').val(),'jjob-state');
})
$(function() {
    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
});
$('.job-country').on('change',function(){
    var countryId = $(this).val();
    getStates(countryId,'job-state')
})
$('.jjob-country').on('change',function(){
    var countryId = $(this).val();
    getStates(countryId,'jjob-state')
})
function getStates(countryId,cType){
    $.ajax({
        url: "{{ url('account/get-state') }}/"+countryId,
        success: function(response){
            var currentState = $('.'+cType).attr('data-state');
            var obj = $.parseJSON(response);
            $('.'+cType).html('');
            var newOption = new Option('Select State', '0', true, false);
            $('.'+cType).append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var vOption = k.id == currentState ? true : false;
                var newOption = new Option(k.name, k.id, true, vOption);
                $('.'+cType).append(newOption);
            })
            $('.'+cType).trigger('change');
        }
    })
}
$('.job-state').on('change',function(){
    var stateId = $(this).val();
    getCities(stateId,'job-city');
})
$('.jjob-state').on('change',function(){
    var stateId = $(this).val();
    getCities(stateId,'jjob-city');
})
function getCities(stateId,cType){
    if(stateId == '0'){
        $('.'+cType).html('').trigger('change');
        var newOption = new Option('Select City', '0', true, false);
        $('.'+cType).append(newOption).trigger('change');
        return false;
    }
    $.ajax({
        url: "{{ url('account/get-city') }}/"+stateId,
        success: function(response){
            var currentCity = $('.'+cType).attr('data-city');
            var obj = $.parseJSON(response);
            $('.'+cType).html('').trigger('change');
            var newOption = new Option('Select City', '0', true, false);
            $('.'+cType).append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var vOption = k.id == currentCity ? true : false;
                var newOption = new Option(k.name, k.id, true, vOption);
                $('.'+cType).append(newOption).trigger('change');
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
$('.profile-pic').on('change',function(){
    var formData = new FormData();
    formData.append('profilePicture', $(this)[0].files[0]);
    formData.append('_token', pageToken);

    $.ajax({
        url : "{{ url('account/jobseeker/profile/picture') }}",
        type : 'POST',
        data : formData,
        processData: false,
        contentType: false,
        timeout: 30000000,
        success : function(response) {
            if($.trim(response) != '1'){
                $('img.img-circle').attr('src',response);
            }else{
                toastr.error('Following format allowed (PNG/JPG/JPEG)', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
        }
    });
});
$('.jaTabBtn').click(function () {
    $(this).addClass('ja-tab-active').siblings().removeClass('ja-tab-active');
    if($(this).hasClass('ext-link')){
    }else{
        $('.ja-content-item').hide();
        $("#"+$(this).attr("id")+"-show").fadeIn();
        if($(this).attr('id') == 'password'){
            $('.password-form').find('.text-danger').remove();
            $('.password-form input').val('');
        }
    }
});
$('form.password-form').submit(function(e){
    $('.password-form input[name="_token"]').val(pageToken);
    $('.password-form button[name="save"]').prop('disabled',true);
    $('.password-form').find('.text-danger').remove();
    $.ajax({
        type: 'post',
        data: $('.password-form').serialize(),
        url: "{{ url('account/password/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                var vParent = $('.password-form input[name="oldPassword"]').parent();
                vParent.append('<p class="text-danger">'+response+'</p>');
            }else{
                toastr.success('Password Updated', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
            $('.password-form button[name="save"]').prop('disabled',false);
        },
        error: function(data){
            var errors = data.responseJSON;
            $.each(errors, function(i,k){
                var vParent = $('.password-form input[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
            })
            $('.password-form button[name="save"]').prop('disabled',false);
        }
    })
    e.preventDefault();
})
$('form.profile-form').submit(function(e){
    $('.profile-form button[name="save"]').prop('disabled',true);
    $('.profile-form input[name="_token"]').val(pageToken);
    $('.profile-form').find('.text-danger').remove();
    $.ajax({
        type: 'post',
        data: $('.profile-form').serialize(),
        url: "{{ url('account/profile/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                var vParent = $('.profile-form input[name="email"]').parent();
                vParent.append('<p class="text-danger">'+response+'</p>');
            }else{
                toastr.success('Profile Updated', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
            $('.profile-form button[name="save"]').prop('disabled',false);
        },
        error: function(data){
            var errors = data.responseJSON;
            $.each(errors, function(i,k){
                if(i == 'city'){
                    var vParent = $('.profile-form select[name="'+i+'"]').parent();
                }else if(i == 'address'){
                    var vParent = $('.profile-form textarea[name="'+i+'"]').parent();
                }else{
                    var vParent = $('.profile-form input[name="'+i+'"]').parent();
                }
                vParent.append('<p class="text-danger">'+k+'</p>');
            })
            $('.profile-form button[name="save"]').prop('disabled',false);
        }
    })
    e.preventDefault();
})
$('form.notification-form').submit(function(e){
    $('.notification-form button[name="save"]').prop('disabled',true);
    $('.notification-form input[name="_token"]').val(pageToken);
    $.ajax({
        type: 'post',
        data: $('.notification-form').serialize(),
        url: "{{ url('account/notification/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                toastr.error(response, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }else{
                toastr.success('Updated', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
            $('.notification-form button[name="save"]').prop('disabled',false);
        }
    })
    e.preventDefault();
})
$('.privacy-form input[type="checkbox"]').click(function(){
    $('.privacy-form input[name="_token"]').val(pageToken);
    $.ajax({
        type: 'post',
        data: $('.privacy-form').serialize(),
        url: "{{ url('account/privacy/save') }}",
        success: function(response){
        }
    })
})
</script>
@endsection