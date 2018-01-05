<!DOCTYPE html>
<html>
<body>

 <section class="personal-info-section" id="personal-information">
                 
                        <div class="row">
                            <div class="col-md-3 personal-info-left">
                                <div class="re-img-box">
                                    <img src="{{ $userImage }}" class="img-circle">
                                   
                                </div>
                                <h3 class="hidden-md hidden-lg" style="font-weight: 600">{{ $user->firstName.' '.$user->lastName }}</h3>
                                <p><span class="pi-title">Father Name:</span> {{ $meta->fatherName }}</p>
                                <p><span class="pi-title">Email:</span> {{ $user->email }}</p>
                                <p><span class="pi-title">Mobile:</span> {{ $user->phoneNumber }}</p>
                                <p><span class="pi-title">CNIC:</span> {{ $meta->cnicNumber }}</p>
                                <p><span class="pi-title">Address:</span> {!! $meta->address.' ,'.JobCallMe::cityName($user->city).' ,'.JobCallMe::countryName($user->country) !!}</p>
                            </div>
                            <div class="col-md-9 personal-info-right">
                               
                               
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

</body>
</html>