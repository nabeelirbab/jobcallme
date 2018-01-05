@extends('frontend.layouts.app')

@if($pageType == 'register')
    @section('title', 'Register')
@else
    @section('title','Login')
@endif

@section('content')
<?php
$next = Request::input('next') != '' ? '?next='.Request::input('next') : '';
?>
<section id="loginRegistration">
    <div class="container">
        <div id="loginBox" class="col-md-6 col-md-offset-3 loginBox" style="display:{{ $pageType != 'register' ? 'block' : 'none' }}">
            <h3>Login to Account</h3>
            <form id="loginForm" action="{{ url('account/login'.$next) }}" method="post">
                @if(Session::has('loginAlert'))
                    <div class="alert alert-danger">
                        {{Session::get('loginAlert')}} 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{ csrf_field() }}
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="login-username" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                </div>
                <div class="input-group">
                    <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block login-btn" name="login">LOGIN</button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-default btn-block" onClick="switchPage('register')">REGISTRATION</button>
                    </div>
                </div>
               
            </form>
			 <div class="col-md-12 sns-box">
                    <p>Login using</p>
                    <button class="fb-btn"><a style="color:white" href="{{url('/redirect')}}">FACEBOOK</a></button>
					
                    <button class="google-btn">GOOGLE</button>
                    <button class="in-btn">LINKEDIN</button>
                </div>
        </div>
        <div id="signupBox" class="col-md-6 col-md-offset-3 signupBox" style="display:{{ $pageType == 'register' ? 'block' : 'none' }}">
            <h3>Create New Account</h3>
            <form id="signUpForm" action="{{ url('account/register') }}" method="post">
                @if(Session::has('registerAlert'))
                    <div class="alert alert-danger">
                        {{Session::get('registerAlert')}} 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" placeholder="First Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select class="form-control select2 job-country" name="country">
                        @foreach(JobCallMe::getJobCountries() as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control select2 job-state" name="state"></select>
                </div>
                <div class="form-group">
                    <select class="form-control select2 job-city" name="city"></select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phoneNumber" value="{{ old('phoneNumber') }}" placeholder="Phone Number">
                </div>
                <div class="input-group">
                    <div class="checkbox">
                        <label>
                            <input id="job-alert" type="checkbox" name="remember" value="1"> Job alert
                        </label>
                    </div>
                </div>
                <p class="terms-condition">You agree to accept <a href="{{ url('terms-conditions') }}">Terms of Services</a> (TOS) and <a href="{{ url('privacy-policy') }}">Privacy Policy</a> of the website.</p>
                <button type="submit" class="btn btn-primary btn-block" name="register">REGISTER</button>
                <p class="text-center show-loginBox">Already have account? <a href="javascript:;" onclick="switchPage('login')">Login here</a></p>
            </form>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
.select2-selection__rendered {background-color: #fff;}
</style>
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function(){
        getStates($('.job-country option:selected:selected').val());
    },700);
})
$('.job-country').on('change',function(){
    var countryId = $(this).val();
    getStates(countryId)
})
function getStates(countryId){
    $.ajax({
        url: "{{ url('account/get-state') }}/"+countryId,
        success: function(response){
            var obj = $.parseJSON(response);
            $(".job-state").html('');
            var newOption = new Option('Select State', '0', true, false);
            $(".job-state").append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var newOption = new Option(k.name, k.id, true, false);
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
function getCities(countryId){
    $.ajax({
        url: "{{ url('account/get-city') }}/"+countryId,
        success: function(response){
            var obj = $.parseJSON(response);
            $(".job-city").html('').trigger('change');
            var newOption = new Option('Select City', '0', true, false);
            $(".job-city").append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var newOption = new Option(k.name, k.id, true, false);
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
function switchPage(page){
    if(page == 'login'){
        $('#signupBox').hide(); 
        $('#loginBox').show();
        var href = "{{ url('account/login'.$next) }}";
    }else{
        $('#loginBox').hide(); 
        $('#signupBox').show();
        var href = "{{ url('account/register') }}";
    }
    window.parent.history.pushState({path:href},'',href);
}
</script>
@endsection