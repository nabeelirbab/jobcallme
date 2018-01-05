@extends('frontend.layouts.app')

@section('title','Organization')

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
?>
<section id="edit-organization">
    <div class="container">
        <div class="eo-box">
            <div class="eo-timeline">
                <img src="{{ $cCover }}" class="eo-timeline-cover">
                <input type="file" id="eo-timeline" class="compnay-cover">
                <div class="eo-timeline-toolkit">
                    <label for="eo-timeline"><i class="fa fa-camera"></i> &nbsp;Change</label>
                </div>
            </div>
            <div class="col-md-12">
               <div class="row">
                   <div class="col-md-2 eo-dp-box">
                       <img src="{{ $cLogo }}" class="eo-dp eo-c-logo">
                       <div class="eo-dp-toolkit">
                           <input type="file" id="eo-dp" class="compnay-logo">
                           <label for="eo-dp"><i class="fa fa-camera"></i> Change</label>
                       </div>
                   </div>
                   <div class="col-md-10 eo-timeline-details">
                       <h1><a href="">{{ $company->companyName }}</a></h1>
                       <div class="col-md-6 eo-section">
                           <h4>Basic Information</h4>
                           <div class="eo-details">
                               <span>Designation:</span> HR
                           </div>
                           <div class="eo-details">
                               <span>Industry:</span> {{ JobCallMe::categoryName($company->category) }}
                           </div>
                           <div class="eo-details">
                               <span>Address:</span> {{ $company->companyAddress.' '.JobCallMe::cityName($company->companyCity).' , '.JobCallMe::countryName($company->companyCountry) }}
                           </div>
                           <div class="eo-details">
                               <span>Email:</span> {{ $company->companyEmail }}
                           </div>
                           <div class="eo-details">
                               <span>Phone:</span> {{ $company->companyPhoneNumber }}
                           </div>
                           <div class="eo-details">
                               <span>Website:</span> <a href="{{ $company->companyWebsite }}">{{ $company->companyWebsite }}</a>
                           </div>
                           <div class="eo-details">
                               <span>Established In:</span> {{ date('M Y',strtotime($company->companyEstablishDate)) }}
                           </div>
                           <div class="eo-details">
                               <span>No. of Employees:</span> {{ $company->companyNoOfUsers }}
                           </div>
                       </div>
                       <div class="col-md-6 eo-section">
                           <a class="btn btn-primary eo-edit-btn" onClick="$('.eo-section').hide(); $('.eo-edit-section').show()"><i class="fa fa-edit"></i> </a>
                           <h4>Operation Hours</h4>
                           <?php $opHour = json_decode($company->companyOperationalHour,true); ?>
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
                                   <tr>
                                       <td>SUN</td>
                                       <td>{!! $opHour['sun']['from'] !!} - {!! $opHour['sun']['to'] !!}</td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                       <div class="eo-edit-section">
                           <form id="pnj-form" action="" method="post" class="organization-form">
                                <input type="hidden" name="_token" class="token">
                               <div class="pnj-form-section">
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Company</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyName" name="companyName" id="companyName" placeholder="Company Title" value="{{ $company->companyName }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Industry</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <select class="form-control select2" name="industry">
                                               <option value="">Select Industry</option>
                                               @foreach(JobCallMe::getCategories() as $cat)
                                                <option value="{{ $cat->categoryId }}" {{ $cat->categoryId == $company->category ? 'selected="selected"' : '' }}>{{ $cat->name }}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Address</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <textarea class="form-control companyAddress" placeholder="Address" name="companyAddress" style="resize: vertical">{{ $company->companyAddress }}</textarea>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Country</label>
                                       <div class="col-sm-9 pnj-form-field">
                                            <select class="form-control input-sm select2 job-country companyCountry" name="companyCountry">
                                                @foreach(JobCallMe::getJobCountries() as $cntry)
                                                    <option value="{{ $cntry->id }}" {{ $company->companyCountry == $cntry->id ? 'selected="selected"' : '' }}>{{ $cntry->name }}</option>
                                                @endforeach
                                            </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">State</label>
                                       <div class="col-sm-9 pnj-form-field">
                                            <select class="form-control input-sm select2 job-state companyState" name="companyState" data-state="{{ $company->companyState }}"></select>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">City</label>
                                       <div class="col-sm-9 pnj-form-field">
                                            <select class="form-control input-sm select2 job-city companyCity" name="companyCity" data-city="{{ $company->companyCity }}"></select>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Phone</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyPhoneNumber" name="companyPhoneNumber" id="companyPhoneNumber" placeholder="Phone" value="{{ $company->companyPhoneNumber }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Email</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyEmail" name="companyEmail" id="companyEmail" placeholder="Email" value="{{ $company->companyEmail }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Website</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyWebsite" name="companyWebsite" id="companyWebsite" placeholder="https://www.example.com" value="{{ $company->companyWebsite }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Facebook</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyFb" name="companyFb" id="companyFb" placeholder="Facebook" value="{{ $company->companyFb }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Linkedin</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyLinkedin" name="companyLinkedin" id="companyLinkedin" placeholder="Linkedin" value="{{ $company->companyLinkedin }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Twitter</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyTwitter" name="companyTwitter" id="twitter" placeholder="Twitter" value="{{ $company->companyTwitter }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Total Employees</label>
                                       <div class="col-sm-9 pnj-form-field">
                                           <input type="text" class="form-control companyNoOfUsers" name="companyNoOfUsers" id="companyNoOfUsers" placeholder="Total Employees" value="{{ $company->companyNoOfUsers }}">
                                       </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Establish In</label>
                                        <div class="col-sm-9 pnj-form-field">
                                            <input class="form-control date-picker companyEstablishDate" type="text" name="companyEstablishDate" value="{{ $company->companyEstablishDate }}">
                                        </div>
                                   </div>

                                   <hr>
                                   <!--Monday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Monday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[mon][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['mon']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[mon][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['mon']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Tuesday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Tuesday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[tue][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['tue']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[tue][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['tue']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Wednesday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Wednesday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[wed][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['wed']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[wed][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['wed']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Thursday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Thursday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[thu][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['thu']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[thu][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['thu']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Friday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Friday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[fri][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['fri']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[fri][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['fri']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Saturday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Saturday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[sat][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['sat']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours[sat][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['sat']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <hr>

                                   <!--Sunday Schedule-->
                                   <div class="form-group">
                                       <label class="control-label col-sm-3">Sunday</label>
                                       <div class="col-sm-4 pnj-form-field">
                                           <select name="opHours[sun][]" class="form-control">
                                                <option value="">From</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['sun']['from'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                       <div class="col-sm-4 pnj-form-field ">
                                           <select name="opHours['sun'][]" class="form-control">
                                                <option value="">To</option>
                                                @foreach(JobCallMe::timeArray() as $time)
                                                    <option value="{!! $time !!}" {!! $time == $opHour['sun']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                                @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <div class="col-md-12">
                                       <div class="row">
                                           <div class="col-md-offset-3 col-md-9">
                                               <button type="submit" class="btn btn-primary col-md-3" name="save" style="margin-right:5px">SAVE</button>
                                               <button type="button" class="btn btn-default col-md-3" onClick="$('.eo-edit-section').hide(); $('.eo-section').show()">CANCEL</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
            </div>
        </div>

        <div class="eo-box eo-about">
            <a class="btn btn-primary r-add-btn hideThis" onClick="$('.eo-about-org').hide(); $('.hideThis').hide();$('.eo-about-editor').show(); "><i class="fa fa-edit"></i> </a>
            <h3 class="eo-about-heading">About Organization</h3>
            <div class="eo-about-org">
                <p>{!! $company->companyAbout !!}</p>
            </div>
            <div class="eo-about-editor">
                <form action="" id="pnj-form" method="post" class="organization-desc-form">
                    <input type="hidden" name="_token" class="token">
                    <div class="form-group">
                        <label class="control-label col-sm-3">&nbsp;</label>
                        <div class="col-sm-7 pnj-form-field">
                            <textarea class="form-control tex-editor" name="companyAbout" rows="10" style="resize: vertical;">{!! $company->companyAbout !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-primary col-md-3" name="save" style="margin-right:5px">SAVE</button>
                                <button type="button" class="btn btn-default col-md-3" onClick="$('.eo-about-org').show(); $('.hideThis').show();$('.eo-about-editor').hide();">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </form>
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
    getStates($('.job-country option:selected:selected').val());
})
$('.job-country').on('change',function(){
    var countryId = $(this).val();
    getStates(countryId)
})
function getStates(countryId){
    if(countryId == 0){
        var newOption = new Option('Select State', '0', true, false);
        $(".job-state").append(newOption).trigger('change');
        return false;
    }
    $.ajax({
        url: "{{ url('account/get-state') }}/"+countryId,
        success: function(response){
            var currentState = $('.job-state').attr('data-state');
            var obj = $.parseJSON(response);
            $(".job-state").html('');
            var newOption = new Option('Select State', '0', true, false);
            $(".job-state").append(newOption);
            $.each(obj,function(i,k){
                var vOption = k.id == currentState ? true : false;
                var newOption = new Option(k.name, k.id, true, vOption);
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
    if(stateId == 0){
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
$('form.organization-form').submit(function(e){
    $('.organization-form .token').val(token);
    $('.organization-form button[name="save"]').prop('disabled',true);
    $.ajax({
        type: 'post',
        data: $('.organization-form').serialize(),
        url: "{{ url('account/employer/organization/save') }}",
        success: function(response){
            if(response == '1'){
                window.location.reload();
            }else{
                $('.organization-form button[name="save"]').prop('disabled',false);
                toastr.error(response, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
        },
        error: function(data){
            var errors = data.responseJSON;
            var x = 1;
            var vError = '';
            $.each(errors, function(i,k){
                var vParent = $('.organization-form .'+i+'').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
                if(x == 1){
                    vError = k;
                }
                x++;
            })
            toastr.error(vError, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            $('.organization-form button[name="save"]').prop('disabled',false);
        }
    })
    e.preventDefault();
})
tinymce.init({
    selector: '.tex-editor',
    height: 200,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | link'
});
var formOp = 1;
$('form.organization-desc-form').submit(function(e){
    if(formOp == 1){
        formOp++
        return false;
    }
    $('.organization-desc-form .token').val(token);
    $('.organization-desc-form button[name="save"]').prop('disabled',true);
    $.ajax({
        type: 'post',
        data: $('.organization-desc-form').serialize(),
        url: "{{ url('account/employer/organization/about') }}",
        success: function(response){
            if($.trim(response) == '1'){
                window.location.reload();
            }else{
                toastr.error(response, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
        }
    })
    e.preventDefault();
})
$('.compnay-logo').on('change',function(){
    var formData = new FormData();
    formData.append('cLogo', $(this)[0].files[0]);
    formData.append('_token', token);

    $.ajax({
        url : "{{ url('account/employer/company/logo') }}",
        type : 'POST',
        data : formData,
        processData: false,
        contentType: false,
        timeout: 30000000,
        success : function(response) {
            if($.trim(response) != '1'){
                $('img.eo-c-logo').attr('src',response);
            }else{
                toastr.error('Following format allowed (PNG/JPG/JPEG)', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
        }
    });
})
$('.compnay-cover').on('change',function(){
    var formData = new FormData();
    formData.append('cLogo', $(this)[0].files[0]);
    formData.append('_token', token);

    $.ajax({
        url : "{{ url('account/employer/company/cover') }}",
        type : 'POST',
        data : formData,
        processData: false,
        contentType: false,
        timeout: 30000000,
        success : function(response) {
            if($.trim(response) != '1'){
                $('img.eo-timeline-cover').attr('src',response);
            }else{
                toastr.error('Following format allowed (PNG/JPG/JPEG)', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            }
        }
    });
})
</script>
@endsection