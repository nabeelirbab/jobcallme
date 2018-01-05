@extends('frontend.layouts.app')

@section('title', 'Upskills')

@section('content')
<?php
$opHour = @json_decode($upskill->timing,true);
$gCountry = Session()->get('jcmUser')->country;
$gState = Session()->get('jcmUser')->state;
$gCity = Session()->get('jcmUser')->city;
$gEmail = Session()->get('jcmUser')->email;
$gPhone = Session()->get('jcmUser')->phoneNumber;
if($upskill->country != 0){
    $gCountry = $upskill->country;
    $gState = $upskill->state;
    $gCity = $upskill->city;
    $gEmail = $upskill->email;
    $gPhone = $upskill->phone;
}
?>
<section id="postNewJob">
    <div class="container">
        <div class="col-md-9">
            <h2>Advertise a Course, Seminar, Workshop You're Offering</h2>
            <div class="pnj-box">
                <form id="pnj-form" action="" method="post" class="upskill-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="skillId" value="{{ $upskill->skillId }}">
                    <input type="hidden" name="prevIcon" value="{{ $upskill->upskillImage }}">
                    <h3>Basic Information</h3>
                    <div class="pnj-form-section">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Title</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $upskill->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Type</label>
                            <div class="col-sm-9 pnj-form-field">
                                <select class="form-control select2" name="type" required="">
                                    <option value="">Select Type</option>
                                    @foreach(JobCallMe::getUpkillsType() as $skill)
                                        <option value="{!! $skill !!}" {{ $skill == $upskill->type ? 'selected="selected"' : '' }}>{!! $skill !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Organiser</label>
                            <div class="col-sm-9 pnj-form-field">
                                <select class="form-control" name="oType" onchange="orgFun(this.value)">
                                    <option value="user">{{ Session()->get('jcmUser')->firstName.' '.Session()->get('jcmUser')->lastName}}</option>
                                    <option value="other" {{ $upskill->organiser != '' ? 'selected="selected="' : ''}}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-organiser" style="display: none;">
                            <label class="control-label col-sm-3">Organiser</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="organiser" value="{{ $upskill->organiser }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Description</label>
                            <div class="col-sm-9 pnj-form-field">
                                <textarea name="description" class="form-control tex-editor">{{ $upskill->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Cost</label>
                            <div class="col-sm-9 pnj-form-field">
                                <div class="row">
                                    <div class="col-md-4 pnj-salary">
                                        <input type="number" class="form-control" name="cost" placeholder="Cost" value="{{ $upskill->cost }}">
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control col-md-4 select2" name="currency">
                                            @foreach(JobCallMe::siteCurrency() as $currency)
                                                <option value="{!! $currency !!}" {{ $currency == $upskill->currency ? 'selected="selected"' : '' }}>{!! $currency !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 pnj-salary">
                                        <div class=" benefits-checks">
                                            <input id="free" type="checkbox" class="cbx-field" name="accommodation" {{ $upskill->cost == '0' ? 'checked=""' : '' }}>
                                            <label class="cbx" for="free"></label>
                                            <label class="lbl" for="free">Free</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3>Venue</h3>
                    <div class="pnj-form-section">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Address</label>
                            <div class="col-sm-9 pnj-form-field">
                                <textarea name="address" class="form-control" placeholder="Address">{{ $upskill->address }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Country</label>
                            <div class="col-sm-9 pnj-form-field">
                                <select class="form-control select2 job-country" name="country">
                                    @foreach(JobCallMe::getJobCountries() as $cntry)
                                        <option value="{{ $cntry->id }}" {{ $gCountry == $cntry->id ? 'selected="selected"' : '' }}>{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">State</label>
                            <div class="col-sm-9 pnj-form-field">
                                <select class="form-control select2 job-state" name="state" data-state="{{ $gState }}">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">City</label>
                            <div class="col-sm-9 pnj-form-field">
                                <select class="form-control select2 job-city" name="city" data-city="{{ $gCity }}">
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3>Contact Information</h3>
                    <div class="pnj-form-section">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Contact Person</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" name="contact" class="form-control" placeholder="Contact Person" value="{{ $upskill->contact }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Email</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $gEmail }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Phone</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ $gPhone }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Mobile</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ $upskill->mobile }}">
                            </div>
                        </div>
                    </div>

                    <h3>Online Presence</h3>
                    <div class="pnj-form-section">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Website</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="website" id="website" placeholder="https://www.example.com" value="{{ $upskill->website }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Facebook</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook" value="{{ $upskill->facebook }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Linkedin</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Linkedin" value="{{ $upskill->linkedin }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Twitter</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter" value="{{ $upskill->twitter }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Google Plus</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="google" id="google" placeholder="Google+" value="{{ $upskill->google }}">
                            </div>
                        </div>
                    </div>

                    <h3>Duration & Schedule</h3>
                    <div class="pnj-form-section us-duration">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Start Date</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control date-picker" name="startDate" onkeypress="return false;" value="{{ $upskill->startDate }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">End Date</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control date-picker" name="endDate" onkeypress="return false;" value="{{ $upskill->endDate }}">
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
                                <select name="opHours[sun][]" class="form-control">
                                    <option value="">To</option>
                                    @foreach(JobCallMe::timeArray() as $time)
                                        <option value="{!! $time !!}" {!! $time == $opHour['sun']['to'] ? 'selected="selected"' : '' !!}>{!! $time !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3>Upskill Image</h3>
                    <div class="png-form-section us-duration">
                        <div class="form-group">
                            <label class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="file" name="upskillImage" class="form-control">
                            </div>
                        </div>
                        @if($upskill->upskillImage != '')
                        <div class="form-group">
                            <label class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-9 pnj-form-field">
                                <span style="background-color: #f8f8f8;padding: 10px;text-align: center;display: block;">
                                    <img src="{{ url('upskill-images/'.$upskill->upskillImage) }}" alt="" style="max-width: 200px;">
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-offset-4 col-md-8  pnj-btns">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                        <a href="{{ url('account/upskill') }}" class="btn btn-default">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
@section('page-footer')
<style type="text/css">
input[type="file"] {
    padding: 0;
}
.text-danger{color: #ff0000 !important;}
</style>
<script type="text/javascript">
$(document).ready(function(){
    getStates($('.job-country option:selected:selected').val());
    orgFun("{{ $upskill->organiser != '' ? 'other' : 'user'}}");
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
            var newOption = new Option('Select State', '', true, false);
            $(".job-state").append(newOption).trigger('change');
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
    if(stateId == '0' || stateId == ''){
        $(".job-city").html('').trigger('change');
        var newOption = new Option('Select City', '', true, false);
        $(".job-city").append(newOption).trigger('change');
        return false;
    }
    $.ajax({
        url: "{{ url('account/get-city') }}/"+stateId,
        success: function(response){
            var currentCity = $('.job-city').attr('data-city');
            var obj = $.parseJSON(response);
            $(".job-city").html('').trigger('change');
            var newOption = new Option('Select City', '', true, false);
            $(".job-city").append(newOption).trigger('change');
            $.each(obj,function(i,k){
                var vOption = k.id == currentCity ? true : false;
                var newOption = new Option(k.name, k.id, true, vOption);
                $(".job-city").append(newOption).trigger('change');
            })
        }
    })
}
tinymce.init({
    selector: '.tex-editor',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    },
    height: 200,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | link'
});
function orgFun(opValue){
    if(opValue == 'other'){
        $('.upskill-form .col-organiser').show();
    }else{
        $('.upskill-form .col-organiser').hide();
        $('.upskill-form input[name="organiser"]').val('');
    }
}
$('form.upskill-form').submit(function(e){
    var formData = new FormData($(this)[0]);
    $('.upskill-form .text-danger').remove();
    $('.upskill-form button[type="submit"]').prop('disabled',true);
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formData,
        async: false,
        success: function(response) {
            if($.trim(response) != '1'){
                toastr.error(response, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
                $('.upskill-form button[type="submit"]').prop('disabled',false);
            }else{
                toastr.success('Upskill successfully saved', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
                window.location.href = "{{ url('account/upskill') }}";
                $('.upskill-form button[type="submit"]').prop('disabled',false);
            }
        },
        error: function(data){
            isARunning = false;
            var errors = data.responseJSON;
            var j = 1;
            var vError = '';
            $.each(errors, function(i,k){
                var vParent = $('.upskill-form input[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');

                var vParent = $('.upskill-form select[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
                
                var vParent = $('.upskill-form textarea[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
                if(j == 1){
                    vError = k;
                }
                j++;
            });
            toastr.error(vError, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            $('.upskill-form button[type="submit"]').prop('disabled',false);
        },
        cache: false,
        contentType: false,
        processData: false
    });
    e.preventDefault();
})
</script>
@endsection