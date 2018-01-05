@extends('frontend.layouts.app')

@section('title', 'People')

@section('content')
<section id="learn-section">
    <div class="container">
        <div class="col-md-12 learn-search-box">
            <h2 class="text-center">Search People in {{ JobCallMe::countryName(JobCallMe::getHomeCountry()) }}</h2>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="ls-box">
                        <form role="form" action="{{ url('account/people') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-fields">
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="Keywords" name="keyword">
                                </div>
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="City" name="city">
                                <button type="submit" class="search-btn" style="width:9% !important">
                                    <i class="fa fa-search"></i>
                                </button>
                                </div>
                                
				<button  type="button" data-toggle="modal" data-target="#myModal" style="margin-left: 9px;width: 21px;height: 33px;background: transparent;">
                                <span class="caret" style="color:white"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			
			 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title text-center">Search People in {{ JobCallMe::countryName(JobCallMe::getHomeCountry()) }}</h4>
          
        </div>
      <form role="form" action="{{ url('account/peoples') }}" method="post">
        <div class="modal-body">
		<div class="row">
              
		<div class="col-md-6">
                <div class="form-group">
                                 <div class=" pnj-form-field">
                                   <input type="text" class="form-control" name="keyword" placeholder="Keywords">
                                 </div>
                                </div>
						      </div>
								 <div class="col-md-6">
								  <div class="form-group">
                                   <div class=" pnj-form-field">
                                  <input type="text" class="form-control" name="city" placeholder="City">
                              </div>
                           </div>
					   </div>
					   	 <div class="col-md-6">
								  <div class="form-group">
                                   <div class=" pnj-form-field">
                                  <input type="text" class="form-control" name="name" placeholder="Name">
                              </div>
                           </div>
					   </div>
				    <div class="col-md-6">
                       <div class="form-group">
                       
                        <select class="form-control" name="category" >
						 <option value="">Select Industry</option>
                           @foreach(JobCallMe::getCategories() as $cat)
                                <option value="{!! $cat->categoryId !!}">{!! $cat->name !!}</option>
                             @endforeach
                          </select>
                             
                              </div>
						        </div>
								<div class="col-md-6">
								   <div class="form-group">
                                    <select class="form-control" name="degreeLevel">
									<option value="">Select Degree Level</option>
                                        <option value="High School">High School</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Master">Master</option>
                                        <option value="PhD">PhD</option>
                                    </select>
                                </div>
                            </div>
								 <div class="col-md-6">
								  <div class="form-group">
                                   <div class=" pnj-form-field">
                                   <input type="text" class="form-control" name="degree" placeholder="Degree" >
                                 </div>
                               </div>
						    </div>
							<div class="col-md-6">
								  <div class="form-group">
                                   <div class=" pnj-form-field">
                                   <input type="text" class="form-control" name="minsalary" placeholder="Min Salary">
                                 </div>
                               </div>
						    </div>
							<div class="col-md-6">
								  <div class="form-group">
                                   <div class=" pnj-form-field">
                                   <input type="text" class="form-control" name="maxsalary" placeholder="Max Salary">
                                 </div>
                               </div>
						    </div>
						<div class="col-md-6">
							<div class="form-group">
                                    <select class="form-control" name="gender">
									<option value="">Select Gender</option>
                                        <option value="Male" >Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-6">
							 <div class="form-group">
                                    <select class="form-control" name="maritalStatus">
									<option value="">Select Marital Status</option>
                                        <option value="Single" >Single</option>
                                        <option value="Engaged" >Engaged</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>
                            </div>
							
							
			<div class="col-md-6">
                          <div class="form-group">
                                <select class="form-control select2 job-country" name="country">
                                    @foreach(JobCallMe::getJobCountries() as $cntry)
                                        <option value="{{ $cntry->id }}" {{ Session()->get('jcmUser')->country == $cntry->id ? 'selected="selected"' : '' }}>{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="col-md-6 pnj-form-field">
                        <div class="form-group">
                                <select class="form-control select2 job-state" name="state">
                                </select>
                               </div>
                        </div>
						 
                            <div class="col-md-6 pnj-form-field">
                             <div class="form-group">
                                <select class="form-control select2 job-city" name="citys">
                                </select>
                            </div>
                        </div>
                  
							
			</div>
                   </div>
        <div class="modal-footer">
          <button type="submit" style="float:left" class="btn btn-success" >Search</button>   <button type="button" style="float:left" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>	
      </div>
    </div>
  </div>
  
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <?php $colorArr = array('purple','green','darkred','orangered','blueviolet','#122b40'); $i=0; ?>
                    <div class="job-locations-box">
                        @foreach(JobCallMe::getCategories() as $cat)
                            <a  href="{{ url('account/people?industry='.$cat->categoryId) }}" style="background-color: {{ $colorArr[$i++] }};box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    /* width: 9.5%; */
    padding: 5px 5px;
    color: #ffffff;
    font-size: 12px;
    margin-bottom: 10px;
    /* display: block; */
    position: relative;
    /* float: left; */
    margin-right: 0.5%;
    overflow: hidden;
    text-decoration: none;"><span class="text">{!! $cat->name !!}</span></a>
                        @endforeach
                    </div>
                    <div class="job-schedule-box">
                        @foreach(JobCallMe::getHomeCities() as $loca)
                            <a href="{{ url('account/people?city='.$loca->id) }}">{{ $loca->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="fp-box">
            <div class="col-md-12">
                <!--FP item Row-->
                <div class="row">
                    @foreach($peoples as $people)
                        <?php
                        $pImage = url('profile-photos/profile-logo.jpg');
                        if($people->profilePhoto != '' && $people->profilePhoto != NULL){
                            $pImage = url('profile-photos/'.$people->profilePhoto);
                        }
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="fp-item">
                                <a href="{{ url('account/employer/application/applicant/'.$people->userId) }}">
                                    <img src="{{ $pImage }}">
                                    <div class="fp-item-details">
                                        <p>{!! $people->firstName.' '.$people->lastName !!}</p>
                                        <p>{!! $people->designation !!}</p>
                                        <p>{{ JobCallMe::cityName($people->city).', '.JobCallMe::countryName($people->country)}}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--FP item Row End-->
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">

$(document).ready(function(){
    getStates($('.job-country option:selected:selected').val());
    getSubCategories($('.job-category option:selected:selected').val());
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
</script>
@endsection