@extends('frontend.layouts.app')

@section('title','Interview Venues')

@section('content')
<section id="jobs">
    <div class="container">
        <div class="col-md-12 view-venue">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Interview Venues
                    <button class="btn btn-primary pull-right" style="margin-top: 10px;border-radius: 100%;" data-toggle="tooltip" data-original-title="Add New Interview Venue" data-placement="bottom" onclick="addVeneu()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>Venue</th>
                                <th>Location</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($venues as $venue)
                                    <tr id="venue-{{ $venue->venueId }}">
                                        <td><a href="{{ url('account/employer/interview-venues/detail/'.$venue->venueId) }}">{!! $venue->title !!}</a></td>
                                        <td>{!! $venue->address !!}</td>
                                        <td>
                                            <a href="javascript:;" onclick="editVenue({{ $venue->venueId }})"  data-toggle="tooltip" data-original-title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:;" onclick="deleteVenue({{ $venue->venueId }})"  data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 add-edit-venue" style="display: none">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Add Interview Venue</span>
                    <button class="btn btn-warning pull-right" style="margin-top: 10px;border-radius: 100%;" data-toggle="tooltip" data-original-title="Go Back" data-placement="bottom" onclick="goBack()">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>
                <div class="panel-body">
                    <form action="" method="post" class="form-horizontal venue-form">
                        <input type="hidden" name="_token" class="venue-token">
                        <input type="hidden" name="venueId" class="venueId" value="0">
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="title" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Address</label>
                            <div class="col-md-6">
                                <textarea class="form-control input-sm" name="address" style="resize: vertical;" required=""></textarea>
                            </div>
                        </div>
                        <?php
                        $vApp = Session()->get('jcmUser');
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Country</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-country" name="country">
                                    @foreach(JobCallMe::getJobCountries() as $cntry)
                                        <option value="{{ $cntry->id }}" {{ $vApp->country == $cntry->id ? 'selected="selected"' : '' }}>{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">State</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-state" name="state" data-state="{{ $vApp->state }}" required=""></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">City</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm select2 job-city" name="city" data-city="{{ $vApp->city }}" required=""></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Contact Person</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="contact_person" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Email</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Mobile</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Phone</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Fax</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="fax">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Instruction</label>
                            <div class="col-md-6">
                                <textarea class="form-control input-sm" name="instruction" style="resize: vertical;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">&nbsp;</label>
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit" name="save">Save</button>
                                <button class="btn btn-default" onclick="goBack()" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
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
function addVeneu(){
    $('.add-edit-venue .panel-title').text('Add Interview Venue');
    $('.venue-form input,.venue-form textarea').val('');
    $('.view-venue').hide();
    $('.add-edit-venue').fadeIn();
    $('.venue-form .venueId').val('0');
}
function goBack(){
    $('.view-venue').fadeIn();
    $('.add-edit-venue').hide();
}

function firstCapital(myString){
    firstChar = myString.substring( 0, 1 );
    firstChar = firstChar.toUpperCase();
    tail = myString.substring( 1 );
    return firstChar + tail;
}
$('form.venue-form').submit(function(e){
    $('.venue-form .venue-token').val(token);
    $('.venue-form button[name="save"]').prop('disabled',true);
    $('.venue-form .input-error').remove();
    $.ajax({
        type: 'post',
        data: $('.venue-form').serialize(),
        url: "{{ url('account/employer/interview-venues/save') }}",
        success: function(response){
            //$('.venue-form button[name="save"]').prop('disabled',false);
            toastr.success('Action perform successfully', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            window.location.href = "{{ url('account/employer/interview-venues') }}";
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            firstError = '';
            var z = 1;
            $.each(errors, function(i,k){
                if(z == 1){
                    firstError = k;
                }
                z++;
                $('.venue-form input[name="'+i+'"]').parent().append('<p class="input-error">'+k+'</p>');
                $('.venue-form textarea[name="'+i+'"]').parent().append('<p class="input-error">'+k+'</p>');
                $('.venue-form select[name="'+i+'"]').parent().append('<p class="input-error">'+k+'</p>');
            })
            $('.venue-form button[name="save"]').prop('disabled',false);
            Pace.stop;
            toastr.error(firstError, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
        }
    })
    e.preventDefault();
})
function editVenue(venueId){
    $.ajax({
        url: "{{ url('account/employer/interview-venues/get') }}/"+venueId,
        success: function(response){
            var obj = $.parseJSON(response);

            $('.add-edit-venue .panel-title').text('Edit Interview Venue');
            $('.venue-form .venueId').val(venueId);
            $('.venue-form input[name="title"]').val(obj.title);
            $('.venue-form textarea[name="address"]').val(obj.address);
            $('.venue-form select[name="city"]').attr('data-city',obj.city);
            $('.venue-form select[name="state"]').attr('data-state',obj.state);
            $('.venue-form select[name="country"]').val(obj.country).trigger('change');
            $('.venue-form input[name="contact_person"]').val(obj.contact);
            $('.venue-form input[name="email"]').val(obj.email);
            $('.venue-form input[name="phone"]').val(obj.phone);
            $('.venue-form input[name="mobile"]').val(obj.mobile);
            $('.venue-form input[name="fax"]').val(obj.fax);
            $('.venue-form textarea[name="instruction"]').val(obj.instruction);

            $('.view-venue').hide();
            $('.add-edit-venue').fadeIn();
        }
    })
}
function deleteVenue(venueId){
    if(confirm('Are you sure?')){
        $.ajax({
            url: "{{ url('account/employer/interview-venues/delete') }}/"+venueId,
            success: function(response){
                $('#venue-'+venueId).remove();
                toastr.success('Interview Venue Removed', '', {timeOut: 3000, positionClass: "toast-bottom-center"});
            }
        })
    }
}
</script>
@endsection