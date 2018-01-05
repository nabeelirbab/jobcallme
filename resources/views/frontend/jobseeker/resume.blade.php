@extends('frontend.layouts.app')

@section('title','Job Seeker')

@section('content')
<?php
$userImage = url('profile-photos/profile-logo.jpg');
if($user->profilePhoto != ''){
    $userImage = url('profile-photos/'.$user->profilePhoto);
}
?>
<section id="myResume">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    <!--Personal Info Start-->
                    <section class="personal-info-section" id="personal-information">
                        <a class="btn btn-primary edit-btn" title="Edit Personal Information" onclick="$('#personal-information').hide();$('#personal-information-edit').fadeIn()">
                            <i class="fa fa-edit"></i>
                        </a>
                        <div class="row">
                            <div class="col-md-3 personal-info-left">
                                <div class="re-img-box">
                                    <img src="{{ $userImage }}" class="img-circle">
                                    <div class="re-img-toolkit">
                                        <div class="re-file-btn">
                                            Change <i class="fa fa-camera"></i>
                                            <input type="file" class="upload profile-pic" name="image" />
                                        </div>
                                        <!-- <span id="remove-re-image">Remove <i class="fa fa-remove"></i></span> -->
                                    </div>
                                </div>
                                <h3 class="hidden-md hidden-lg" style="font-weight: 600">{{ $user->firstName.' '.$user->lastName }}</h3>
                                <p class="user-sns">
                                    <a href="{{ $meta->twitter }}"><i class="fa fa-twitter-square"></i></a>
                                    <a href="{{ $meta->linkedin }}"><i class="fa fa-linkedin-square"></i></a>
                                    <a href="{{ $meta->facebook }}"><i class="fa fa-facebook-square"></i></a>
                                </p>
                                <p><span class="pi-title">Email:</span> {{ $user->email }}</p>
                                <p><span class="pi-title">Mobile:</span> {{ $user->phoneNumber }}</p>
                                <p><span class="pi-title">CNIC:</span> {{ $meta->cnicNumber }}</p>
                                <p><span class="pi-title">Address:</span> {!! $meta->address.' ,'.JobCallMe::cityName($user->city).' ,'.JobCallMe::countryName($user->country) !!}</p>
                            </div>
                            <div class="col-md-9 personal-info-right">
                                <h3 class="hidden-sm hidden-xs">{{ $user->firstName.' '.$user->lastName }}</h3>
                                <p><span class="pi-title">Father Name:</span> {{ $meta->fatherName }}</p>
                                <p><span class="pi-title">Age:</span> {{ JobCallMe::timeInYear($meta->dateOfBirth) }}, <span class="pi-title">Gender:</span>{{ $meta->gender }},<span class="pi-title">Status:</span>{{ $meta->maritalStatus }}</p>
                                <p><span class="pi-title">Education:</span> {{ $meta->education }}</p>
                                <p><span class="pi-title">Experiance:</span> {{ $meta->experiance }}</p>
                                <p><span class="pi-title">Industry:</span> {{ JobCallMe::categoryTitle($meta->industry) }}</p>
                                <p><span class="pi-title">Salary:</span> {{ number_format($meta->currentSalary != '' ? $meta->currentSalary : '0',2).' '.$meta->currency }}</p>
                                <div class="professional-summary">
                                    <h4>Professional Summary</h4>
                                    <p>{!! $user->about !!}</p>
                                    <p><span class="pi-title">Further Expertise</span></p>
                                    <ul style="margin-left: 50px;padding-left: 0;">
                                        @if($meta->expertise != '')
                                            @foreach(@explode(',',$meta->expertise) as $exper)
                                                <li>{!! $exper !!}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="personal-info-section" id="personal-information-edit" style="display: none;">
                        <h4><i class="fa fa-edit r-icon bg-primary"></i>  Edit Personal Info</h4>
                        <form action="" method="post" class="form-horizontal form-personal-info">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="metaId" value="{{ $meta->metaId }}">
                            <div class="form-group error-group" style="display: none;">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6"><div class="alert alert-danger"></div></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Name</label>
                                <div class="col-md-6">
                                    <div class="col-md-6 f-name" style="margin-bottom: 5px;padding-left: 0;">
                                        <input type="text" class="form-control input-sm" name="firstName" value="{{ $user->firstName }}">
                                    </div>
                                    <div class="col-md-6 l-name" style="margin-bottom: 5px;padding-right: 0;">
                                        <input type="text" class="form-control input-sm" name="lastName" value="{{ $user->lastName }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Father Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="fatherName" value="{{ $meta->fatherName }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">CNIC Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="cnicNumber" value="{{ $meta->cnicNumber }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Gender</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="gender">
                                        <option value="Male" {{ $meta->gender == 'Male' ? 'selected="selected"' : '' }}>Male</option>
                                        <option value="Female" {{ $meta->gender == 'Female' ? 'selected="selected"' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Marital status</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="maritalStatus">
                                        <option value="Single" {{ $meta->maritalStatus == 'Single' ? 'selected="selected"' : '' }}>Single</option>
                                        <option value="Engaged" {{ $meta->maritalStatus == 'Engaged' ? 'selected="selected"' : '' }}>Engaged</option>
                                        <option value="Married" {{ $meta->maritalStatus == 'Married' ? 'selected="selected"' : '' }}>Married</option>
                                        <option value="Widowed" {{ $meta->maritalStatus == 'Widowed' ? 'selected="selected"' : '' }}>Widowed</option>
                                        <option value="Divorced" {{ $meta->maritalStatus == 'Divorced' ? 'selected="selected"' : '' }}>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Date Of Birth</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm date-picker" name="dateOfBirth" value="{{ $meta->dateOfBirth }}" onkeypress="return false">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="phoneNumber" value="{{ $user->phoneNumber }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Address</label>
                                <div class="col-md-6">
                                    <textarea class="form-control input-sm" name="address">{{ $meta->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Country</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2 job-country" name="country">
                                        @foreach(JobCallMe::getJobCountries() as $cntry)
                                            <option value="{{ $cntry->id }}" {{ $user->country == $cntry->id ? 'selected="selected"' : '' }}>{{ $cntry->name }}</option>
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
                                <label class="control-label col-md-3 text-right">Experiance level</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="experiance">
                                        @foreach(JobCallMe::getExperienceLevel() as $el)
                                            <option value="{{ $el }}" {{ $meta->experiance == $el ? 'selected="selected"' : '' }}>{{ $el }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-md-3 text-right">Education</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="education" value="{{ $meta->education }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Industry</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="industry">
                                        @foreach(JobCallMe::getCategories() as $cat)
                                            <option value="{{ $cat->categoryId }}" {{ $meta->industry == $cat->categoryId ? 'selected="selected"' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Current Salary</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="currentSalary" value="{{ $meta->currentSalary }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Eexpected Salary</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="expectedSalary" value="{{ $meta->expectedSalary }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Currency</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="currency">
                                        @foreach(JobCallMe::siteCurrency() as $currency)
                                            <option value="{{ $currency }}" {{ $meta->currency == $currency ? 'selected="selected"' : '' }}>{{ $currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Expertise</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="expertise" value="{{ $meta->expertise }}">
                                    <p class="help-block">Enter comma seperated expertise</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Professional Summary</label>
                                <div class="col-md-6">
                                    <textarea class="form-control input-sm" name="about">{{ $user->about }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Facebook</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="facebook" value="{{ $meta->facebook }}">
                                    <p class="help-block">https://facebook.com/user</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Linkedin</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="linkedin" value="{{ $meta->linkedin }}">
                                    <p class="help-block">https://linkedin.com/user</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Twitter</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="twitter" value="{{ $meta->twitter }}">
                                    <p class="help-block">https://twitter.com/user</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Website/Blog</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="website" value="{{ $meta->website }}">
                                    <p class="help-block">https://example.com</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit" name="save">Save</button>
                                    <button class="btn btn-default" type="button" onclick="cancelProfile()">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!--Personal Info End-->

                    <!--Academic Section Start-->
                    <section class="resume-box" id="academic">
                        <a class="btn btn-primary r-add-btn" onclick="addAcademic()"><i class="fa fa-plus"></i> </a>
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  Academic</h4>
                        <?php //print_r($resume); ?>
                        <ul class="resume-details">
                            @if(count($resume['academic']) > 0)
                                @foreach($resume['academic'] as $resumeId => $academic)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                            <span class="pull-right li-option">
                                                <a href="javascript:;" title="Edit" onclick="getAcademic('{{ $resumeId }}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;
                                                <a href="javascript:;" title="Delete" onclick="deleteElement('{{ $resumeId }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>&nbsp;
                                            </span>
                                            <p class="rd-date">{!! date('M, Y',strtotime($academic->completionDate)) !!}</p>
                                            <p class="rd-title">{!! $academic->degree !!}</p>
                                            <p class="rd-organization">{!! $academic->institution !!}</p>
                                            <p class="rd-location">{!! ucfirst($academic->country) !!}</p>
                                            <p class="rd-grade">Grade/GPA : {!! $academic->grade !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <section class="resume-box" id="academic-edit" style="display: none;">
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  <c>Add Academic</c></h4>
                        <form class="form-horizontal form-academic" method="post" action="">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="resumeId" value="">
                            <div class="form-group error-group" style="display: none;">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6"><div class="alert alert-danger"></div></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Degree Level</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="degreeLevel">
                                        <option value="High School">High School</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Master">Master</option>
                                        <option value="PhD">PhD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Degree</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="degree">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Completion Date</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control input-sm date-picker" name="completionDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Grade/GPA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="grade">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Institution</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="institution">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Country</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="country">
                                        @foreach(JobCallMe::getJobCountries() as $cntry)
                                            <option value="{{ $cntry->name }}" {{ $user->country == $cntry->id ? 'selected="selected"' : '' }}>{{ ucfirst($cntry->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Details</label>
                                <div class="col-md-6">
                                    <textarea class="form-control input-sm" name="details"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit" name="save">Save</button>
                                    <button class="btn btn-default" type="button" onclick="$('#academic').fadeIn();$('#academic-edit').hide();$('html, body').animate({scrollTop:$('#academic').position().top}, 700);">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!--Academic Section End-->

                    <!--Certification Section Start-->
                    <section class="resume-box" id="certification">
                        <a class="btn btn-primary r-add-btn" onclick="addCertification()"><i class="fa fa-plus"></i> </a>
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  Certification</h4>
                        <ul class="resume-details">
                            @if(count($resume['certification']) > 0)
                                @foreach($resume['certification'] as $resumeId => $certification)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                            <span class="pull-right li-option">
                                                <a href="javascript:;" title="Edit" onclick="getCertification('{{ $resumeId }}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;
                                                <a href="javascript:;" title="Delete" onclick="deleteElement('{{ $resumeId }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>&nbsp;
                                            </span>
                                            <p class="rd-date">{!! date('M, Y',strtotime($certification->completionDate)) !!}</p>
                                            <p class="rd-title">{!! $certification->certificate !!}</p>
                                            <p class="rd-organization">{!! $certification->institution !!}</p>
                                            <p class="rd-location">{!! ucfirst($certification->country) !!}</p>
                                            <p class="rd-grade">Score : {!! $certification->score !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <section class="resume-box" id="certification-edit" style="display: none;">
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  <c>Add Certification</c></h4>
                        <form class="form-horizontal form-certification" method="post" action="">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="resumeId" value="">
                            <div class="form-group error-group" style="display: none;">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6"><div class="alert alert-danger"></div></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Certification</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="certificate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Completion Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm date-picker" name="completionDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Score</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="score">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Institution</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="institution">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Country</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="country">
                                        @foreach(JobCallMe::getJobCountries() as $cntry)
                                            <option value="{{ $cntry->name }}" {{ $user->country == $cntry->id ? 'selected="selected"' : '' }}>{{ ucfirst($cntry->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Details</label>
                                <div class="col-md-6">
                                    <textarea class="form-control input-sm" name="details"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit" name="save">Save</button>
                                    <button class="btn btn-default" type="button" onclick="$('#certification').fadeIn();$('#certification-edit').hide();$('html, body').animate({scrollTop:$('#certification').position().top}, 700);">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!--Certification Section End-->

                    <!--Experience Section Start-->
                    <section class="resume-box" id="experience">
                        <a class="btn btn-primary r-add-btn" onclick="addExperience()"><i class="fa fa-plus"></i> </a>
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  Experiences</h4>
                        <ul class="resume-details">
                            @if(count($resume['experience']) > 0)
                                @foreach($resume['experience'] as $resumeId => $experience)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                            <span class="pull-right li-option">
                                                <a href="javascript:;" title="Edit" onclick="getExperience('{{ $resumeId }}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;
                                                <a href="javascript:;" title="Delete" onclick="deleteElement('{{ $resumeId }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>&nbsp;
                                            </span>
                                            <p class="rd-date">{!! date('M, Y',strtotime($experience->startDate)) !!} - {{ $experience->currently == 'yes' ? 'Currently Working' : date('M, Y',strtotime($experience->endDate)) }}</p>
                                            <p class="rd-title">{!! $experience->jobTitle !!}</p>
                                            <p class="rd-organization">{!! $experience->organization !!}</p>
                                            <p class="rd-location">{!! ucfirst($experience->country) !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <section class="resume-box" id="experience-edit" style="display: none;">
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  <c>Add Experience</c></h4>
                        <form class="form-horizontal form-experience" method="post" action="">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="resumeId" value="">
                            <div class="form-group error-group" style="display: none;">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6"><div class="alert alert-danger"></div></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Job Title</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="jobTitle">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Organization</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="organization">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Start Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm date-picker" name="startDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">End Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm date-picker" name="endDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <div class="cntr">
                                        <input id="Currently" type="checkbox" class="cbx-field" name="currently" value="yes">
                                        <label class="cbx" for="Currently"></label>
                                        <label class="lbl" for="Currently">Currently Working</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Country</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="country">
                                        @foreach(JobCallMe::getJobCountries() as $cntry)
                                            <option value="{{ $cntry->name }}" {{ $user->country == $cntry->id ? 'selected="selected"' : '' }}>{{ ucfirst($cntry->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Details</label>
                                <div class="col-md-6">
                                    <textarea class="form-control input-sm" name="details"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit" name="save">Save</button>
                                    <button class="btn btn-default" type="button" onclick="$('#experience').fadeIn();$('#experience-edit').hide();$('html, body').animate({scrollTop:$('#experience').position().top}, 700);">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!--Experience Section End-->

                    <!--Skills Section Start-->
                    <section class="resume-box" id="skills">
                        <a class="btn btn-primary r-add-btn" onclick="addSkills()"><i class="fa fa-plus"></i> </a>
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  Skills</h4>
                        <ul class="resume-details">
                            @if(count($resume['skills']) > 0)
                                @foreach($resume['skills'] as $resumeId => $skills)
                                    <li id="resume-{{ $resumeId }}">
                                        <div class="col-md-12">
                                            <span class="pull-right li-option">
                                                <a href="javascript:;" title="Edit" onclick="getSkills('{{ $resumeId }}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;
                                                <a href="javascript:;" title="Delete" onclick="deleteElement('{{ $resumeId }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>&nbsp;
                                            </span>
                                            <p class="rd-title">{!! $skills->skill !!}</p>
                                            <p class="rd-location">{!! $skills->level !!}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </section>
                    <section class="resume-box" id="skills-edit" style="display: none;">
                        <h4><i class="fa fa-book r-icon bg-primary"></i>  <c>Add Experience</c></h4>
                        <form class="form-horizontal form-skills" method="post" action="">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="resumeId" value="">
                            <div class="form-group error-group" style="display: none;">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6"><div class="alert alert-danger"></div></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Skill</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" name="skill">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">Level</label>
                                <div class="col-md-6">
                                    <select class="form-control input-sm select2" name="level">
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 text-right">&nbsp;</label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit" name="save">Save</button>
                                    <button class="btn btn-default" type="button" onclick="$('#skills').fadeIn();$('#skills-edit').hide();$('html, body').animate({scrollTop:$('#skills').position().top}, 700);">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!--Portfolio Section End-->
                </div>
                <div class="col-md-3">
                    <div class="resume-listing-section hidden-sm hidden-xs">
                        <h4>Resume Sections</h4>
                        <hr>
                        <ul class="rls" style="padding-left: 0;">
                            <li>
                                <a id="#" onclick="$('#personal-information').fadeIn();$('#personal-information-edit').hide();">Personal Information</a> 
                                <a id="#" onclick="$('#personal-information').hide();$('#personal-information-edit').fadeIn()"><i class="fa fa-edit pull-right"></i> </a> 
                            </li>
                            <li>
                                <a id="#" onclick="$('#academic').fadeIn();$('#academic-edit').hide();$('html, body').animate({scrollTop:$('#academic').position().top}, 700);">Academics</a> 
                                <a id="#" onclick="addAcademic();$('html, body').animate({scrollTop:$('#academic-edit').position().top}, 700);"><i class="fa fa-plus pull-right"></i> </a> 
                            </li>
                            <li>
                                <a id="#" onclick="$('#certification').fadeIn();$('#certification-edit').hide();$('html, body').animate({scrollTop:$('#certification').position().top}, 700);">Certifications</a> 
                                <a id="#" onclick="addCertification();$('html, body').animate({scrollTop:$('#certification-edit').position().top}, 700);"><i class="fa fa-plus pull-right"></i> </a> 
                            </li>
                            <li>
                                <a id="#" onclick="$('#experience').fadeIn();$('#experience-edit').hide();$('html, body').animate({scrollTop:$('#experience').position().top}, 700);">Experiences</a> 
                                <a id="#" onclick="addExperience();$('html, body').animate({scrollTop:$('#experience-edit').position().top}, 700);"><i class="fa fa-plus pull-right"></i> </a> 
                            </li>
                            <li>
                                <a id="#" onclick="$('#skills').fadeIn();$('#skills-edit').hide();$('html, body').animate({scrollTop:$('#skills').position().top}, 700);">Skills</a> 
                                <a id="#" onclick="addSkills();$('html, body').animate({scrollTop:$('#skills-edit').position().top}, 700);"><i class="fa fa-plus pull-right"></i> </a> 
                            </li>
                        </ul>
                    </div>
                    <div class="download-resume">
                        <a href="cv" class="btn btn-primary btn-block">DOWNLOAD RESUME</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
.edit-btn{z-index: 5;}
.li-option{display: none;}
.li-option a{color: #cccccc;text-decoration: none;}
.li-option a:hover{color: #286090;}
.resume-details li:hover .li-option{display:block;}
textarea.form-control{resize: vertical;}
.personal-info-left p {font-size: 12px;}
@media screen and (max-width: 992px){
    .f-name, .l-name{padding-left: 15px !important;padding-right: 15px !important;}
}
</style>
<script type="text/javascript">
var pageToken = '{{ csrf_token() }}';
$(document).ready(function(){
    getStates($('.job-country option:selected:selected').val());
    //$('.date-picker').datepicker({format:'yyyy-mm-dd'});
})
function cancelProfile(){
    $('#personal-information').fadeIn();
    $('#personal-information-edit').hide();
    $('html, body').animate({scrollTop:$('#personal-information').position().top}, 700);
}
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
$('form.form-personal-info').submit(function(e){
    $('.form-personal-info input[name="_token"]').val(pageToken);
    $('.form-personal-info button[name="save"]').prop('disabled',true);
    $('.form-personal-info .error-group').hide();
    $.ajax({
        type: 'post',
        data: $('.form-personal-info').serialize(),
        url: "{{ url('account/jobseeker/resume/personal/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                $('.form-personal-info .error-group').show();
                $('.form-personal-info .error-group .col-md-6 .alert-danger').html('<ul><li>'+response+'</li></ul>');
                $('html, body').animate({scrollTop:$('#personal-information-edit').position().top}, 1000);
                $('.form-personal-info button[name="save"]').prop('disabled',false);
            }else{
                window.location.href = "{{ url('account/jobseeker/resume') }}";
            }
            Pace.stop;
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            $.each(errors, function(i,k){
                vErrors += '<li>'+k+'</li>';
            })
            $('.form-personal-info .error-group').show();
            $('.form-personal-info .error-group .col-md-6 .alert-danger').html('<ul>'+vErrors+'</ul>');
            $('.form-personal-info button[name="save"]').prop('disabled',false);
            Pace.stop;
            $('html, body').animate({scrollTop:$('#personal-information-edit').position().top}, 1000);
        }
    })
    e.preventDefault();
})
function firstCapital(myString){
    firstChar = myString.substring( 0, 1 );
    firstChar = firstChar.toUpperCase();
    tail = myString.substring( 1 );
    return firstChar + tail;
}
function addAcademic(){
    $('.form-academic input').val('');
    $('#academic-edit h4 c').text('Add Academics');
    $('#academic').hide();
    $('#academic-edit').fadeIn();
}
$('form.form-academic').submit(function(e){
    $('.form-academic input[name="_token"]').val(pageToken);
    $('.form-academic button[name="save"]').prop('disabled',true);
    $('.form-academic .error-group').hide();
    $.ajax({
        type: 'post',
        data: $('.form-academic').serialize(),
        url: "{{ url('account/jobseeker/resume/academic/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                $('.form-academic .error-group').show();
                $('.form-academic .error-group .col-md-6 .alert-danger').html('<ul><li>'+response+'</li></ul>');
                $('html, body').animate({scrollTop:$('#academic-edit').position().top}, 1000);
                $('.form-academic button[name="save"]').prop('disabled',false);
            }else{
                window.location.href = "{{ url('account/jobseeker/resume') }}";
            }
            Pace.stop;
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            $.each(errors, function(i,k){
                vErrors += '<li>'+k+'</li>';
            })
            $('.form-academic .error-group').show();
            $('.form-academic .error-group .col-md-6 .alert-danger').html('<ul>'+vErrors+'</ul>');
            $('.form-academic button[name="save"]').prop('disabled',false);
            Pace.stop;
            $('html, body').animate({scrollTop:$('#academic-edit').position().top}, 1000);
        }
    })
    e.preventDefault();
})
function getAcademic(resumeId){
    $.ajax({
        url: "{{ url('account/jobseeker/resume/get') }}/"+resumeId,
        success: function(response){
            var obj = $.parseJSON(response);
            $('.form-academic input[name="resumeId"]').val(resumeId);
            $('.form-academic select[name="degreeLevel"]').val(obj.degreeLevel).trigger('change');
            $('.form-academic input[name="degree"]').val(obj.degree);
            $('.form-academic input[name="completionDate"]').val(obj.completionDate);
            $('.form-academic input[name="grade"]').val(obj.grade);
            $('.form-academic input[name="institution"]').val(obj.institution);
            $('.form-academic select[name="country"]').val(obj.country).trigger('change');
            $('.form-academic textarea[name="details"]').val(obj.details);
            $('#academic-edit h4 c').text('Edit Academics');
            $('#academic').hide();
            $('#academic-edit').fadeIn();
        }
    })
}
function deleteElement(resumeId){
    if(confirm('Are you sure to delete this?')){
        $.ajax({
            url: "{{ url('account/jobseeker/resume/delete') }}/"+resumeId,
            success: function(response){
                $('#resume-'+resumeId).remove();
            }
        })
    }
}
function addCertification(){
    $('.form-certification input').val('');
    $('#certification-edit h4 c').text('Add Certificate');
    $('#certification').hide();
    $('#certification-edit').fadeIn();
}
$('form.form-certification').submit(function(e){
    $('.form-certification input[name="_token"]').val(pageToken);
    $('.form-certification button[name="save"]').prop('disabled',true);
    $('.form-certification .error-group').hide();
    $.ajax({
        type: 'post',
        data: $('.form-certification').serialize(),
        url: "{{ url('account/jobseeker/resume/certification/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                $('.form-certification .error-group').show();
                $('.form-certification .error-group .col-md-6 .alert-danger').html('<ul><li>'+response+'</li></ul>');
                $('html, body').animate({scrollTop:$('#certification-edit').position().top}, 1000);
                $('.form-certification button[name="save"]').prop('disabled',false);
            }else{
                window.location.href = "{{ url('account/jobseeker/resume') }}";
            }
            Pace.stop;
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            $.each(errors, function(i,k){
                vErrors += '<li>'+k+'</li>';
            })
            $('.form-certification .error-group').show();
            $('.form-certification .error-group .col-md-6 .alert-danger').html('<ul>'+vErrors+'</ul>');
            $('.form-certification button[name="save"]').prop('disabled',false);
            Pace.stop;
            $('html, body').animate({scrollTop:$('#certification-edit').position().top}, 1000);
        }
    })
    e.preventDefault();
})
function getCertification(resumeId){
    $.ajax({
        url: "{{ url('account/jobseeker/resume/get') }}/"+resumeId,
        success: function(response){
            var obj = $.parseJSON(response);
            $('.form-certification input[name="resumeId"]').val(resumeId);
            $('.form-certification input[name="certificate"]').val(obj.certificate);
            $('.form-certification input[name="completionDate"]').val(obj.completionDate);
            $('.form-certification input[name="score"]').val(obj.score);
            $('.form-certification input[name="institution"]').val(obj.institution);
            $('.form-certification select[name="country"]').val(obj.country).trigger('change');
            $('.form-certification textarea[name="details"]').val(obj.details);
            $('#certification-edit h4 c').text('Edit Certificate');
            $('#certification').hide();
            $('#certification-edit').fadeIn();
        }
    })
}
function addExperience(){
    $('.form-experience input').val('');
    $('.form-experience input[name="currently"]').val('yes');
    $('#experience-edit h4 c').text('Add Experience');
    $('#experience').hide();
    $('#experience-edit').fadeIn();
}
$('form.form-experience').submit(function(e){
    $('.form-experience input[name="_token"]').val(pageToken);
    $('.form-experience button[name="save"]').prop('disabled',true);
    $('.form-experience .error-group').hide();
    $.ajax({
        type: 'post',
        data: $('.form-experience').serialize(),
        url: "{{ url('account/jobseeker/resume/experience/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                $('.form-experience .error-group').show();
                $('.form-experience .error-group .col-md-6 .alert-danger').html('<ul><li>'+response+'</li></ul>');
                $('html, body').animate({scrollTop:$('#experience-edit').position().top}, 1000);
                $('.form-experience button[name="save"]').prop('disabled',false);
            }else{
                window.location.href = "{{ url('account/jobseeker/resume') }}";
            }
            Pace.stop;
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            $.each(errors, function(i,k){
                vErrors += '<li>'+k+'</li>';
            })
            $('.form-experience .error-group').show();
            $('.form-experience .error-group .col-md-6 .alert-danger').html('<ul>'+vErrors+'</ul>');
            $('.form-experience button[name="save"]').prop('disabled',false);
            Pace.stop;
            $('html, body').animate({scrollTop:$('#experience-edit').position().top}, 1000);
        }
    })
    e.preventDefault();
})
function getExperience(resumeId){
    $.ajax({
        url: "{{ url('account/jobseeker/resume/get') }}/"+resumeId,
        success: function(response){
            var obj = $.parseJSON(response);
            $('.form-experience input[name="resumeId"]').val(resumeId);
            $('.form-experience input[name="jobTitle"]').val(obj.jobTitle);
            $('.form-experience input[name="organization"]').val(obj.organization);
            $('.form-experience input[name="startDate"]').val(obj.startDate);
            $('.form-experience input[name="currently"]').prop('checked',true);
            $('.form-experience input[name="endDate"]').val('');
            if(obj.currently == 'no'){
                $('.form-experience input[name="endDate"]').val(obj.endDate);
                $('.form-experience input[name="currently"]').prop('checked',false);
            }            
            $('.form-experience select[name="country"]').val(obj.country).trigger('change');
            $('.form-experience textarea[name="details"]').val(obj.details);
            $('#experience-edit h4 c').text('Edit Experience');
            $('#experience').hide();
            $('#experience-edit').fadeIn();
        }
    })
}
function addSkills(){
    $('.form-skills input').val('');
    $('#skills-edit h4 c').text('Add Skill');
    $('#skills').hide();
    $('#skills-edit').fadeIn();
}
$('form.form-skills').submit(function(e){
    $('.form-skills input[name="_token"]').val(pageToken);
    $('.form-skills button[name="save"]').prop('disabled',true);
    $('.form-skills .error-group').hide();
    $.ajax({
        type: 'post',
        data: $('.form-skills').serialize(),
        url: "{{ url('account/jobseeker/resume/skills/save') }}",
        success: function(response){
            if($.trim(response) != '1'){
                $('.form-skills .error-group').show();
                $('.form-skills .error-group .col-md-6 .alert-danger').html('<ul><li>'+response+'</li></ul>');
                $('html, body').animate({scrollTop:$('#skills-edit').position().top}, 1000);
                $('.form-skills button[name="save"]').prop('disabled',false);
            }else{
                window.location.href = "{{ url('account/jobseeker/resume') }}";
            }
            Pace.stop;
        },
        error: function(data){
            var errors = data.responseJSON;
            var vErrors = '';
            $.each(errors, function(i,k){
                vErrors += '<li>'+k+'</li>';
            })
            $('.form-skills .error-group').show();
            $('.form-skills .error-group .col-md-6 .alert-danger').html('<ul>'+vErrors+'</ul>');
            $('.form-skills button[name="save"]').prop('disabled',false);
            Pace.stop;
            $('html, body').animate({scrollTop:$('#skills-edit').position().top}, 1000);
        }
    })
    e.preventDefault();
})
function getSkills(resumeId){
    $.ajax({
        url: "{{ url('account/jobseeker/resume/get') }}/"+resumeId,
        success: function(response){
            var obj = $.parseJSON(response);
            $('.form-skills input[name="resumeId"]').val(resumeId);
            $('.form-skills input[name="skill"]').val(obj.skill);
            $('.form-skills select[name="level"]').val(obj.level).trigger('change');
            $('#skills-edit h4 c').text('Edit Skill');
            $('#skills').hide();
            $('#skills-edit').fadeIn();
        }
    })
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
                alert('Following format allowed (PNG/JPG/JPEG)');
            }
        }
    });
});
</script>
@endsection