@extends('frontend.layouts.app')

@section('title','Employer')

@section('inner-header')
    @include('frontend.includes.employer-nav')
@endsection

@section('content')
<!--Graph Section-->
<section id="employer-graph">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="eg-job-response">
                    <h4>Job Response</h4>
                    <canvas id="job-response"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="eg-job-response">
                    <h4>Experience Level</h4>
                    <canvas id="experience-level"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="eg-job-response">
                    <h4>Recruitment Activity</h4>
                    <canvas id="recruitment-activity"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<!--related-job-->
<section id="relate-to-job">
    <div class="container">
        <div class="row">
            <!--RTJ- Left start-->
            <div class="col-md-6">
                <div class="rtj-box">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#rtj_tab_posted_jobs" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Posted Jobs</a>
                        </li>
                        <li>
                            <a href="#rtj_tab_recent_application" data-toggle="tab"><i class="fa fa-address-book"></i> Recent Applicant</a>
                        </li>
                        <li>
                            <a href="#rtj_tab_interview" data-toggle="tab"><i class="fa fa-calendar"></i> Upcoming interviews </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="rtj_tab_posted_jobs">
						<?php $colorArr = array('purple','green','darkred','orangered','blueviolet') ?>
                            @foreach($postedJobs as $pjobs)
                                <div class="col-md-12 rtj-item">
                                    <div class="rtj-details">
                                        <p><strong><a href="{{ url('jobs/'.$pjobs->jobId) }}">{!! $pjobs->title !!}</a></strong> <i class="fa fa-check-circle-o"></i> </p>
                                        <p>{{ strtotime($pjobs->expiryDate) <= strtotime(date('Y-m-d')) ? 'Closed' : 'Open' }} <span class="label" style="background-color: {{ $colorArr[array_rand($colorArr)] }}"> {!! $pjobs->p_Category !!}</span>
										
										@if ($pjobs->p_Category =='Basic')
											<a href="{{ url('account/employer/jobupdate/'.$pjobs->jobId) }}">(Upgrade)</a>
                                         @else
											 @endif
										 </p>
										 <p><i class="fa fa-users"></i> {{ $pjobs->count}}</p>
                                    </div>
										
										
                                </div>
                            @endforeach
                        </div>
                        <!--Recent Applicant Start-->
                        <div class="tab-pane" id="rtj_tab_recent_application">
                            @foreach($applicant as $appl)
                                <div class="col-md-12 rtj-item">
                                    <img src="{{ url('profile-photos/'.$appl->profilePhoto) }}" style="width: 50px">
                                    <div class="rtj-details">
                                        <p><strong><a href="{{ url('account/employer/application/applicant/'.$appl->userId) }}">{!! $appl->firstName.' '.$appl->lastName !!}</a></strong></p>
                                        <p>{!! $appl->title !!}</p>
                                        <p>{{ date('d M',strtotime($appl->applyTime)) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--Recent Applicant End-->

                        <!--Upcoming Interviews Start-->
                        <div class="tab-pane" id="rtj_tab_interview">
                            <div class="col-md-12 rtj-item">
                                <img src="images/jobseekers/user-10.jpg" style="width: 50px">
                                <div class="rtj-details">
                                    <p><strong><a href="#">Ayesha Khan</a></strong></p>
                                    <p>Graphic Designing</p>
                                    <p><i class="fa fa-clock-o"></i>  June 10 - 3:00PM    <i class="fa fa-map-marker"></i>  Job Call Me, Rawalpindi</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <a href="#" class="pull-right" style="padding-top: 5px">View all</a>
                            </div>
                        </div>
                        <!--Upcoming Interviews End-->
                    </div>
                </div>
            </div>
            <!--RTJ- Left end-->

            <!--RTJ- Right start-->
            <div class="col-md-6">
                <!--Follow Companies - Start -->
                <div class="follow-companies">
                    <h4>Suggested People</h4>
                    <hr>
                    <div class="row">
					@foreach($applicants as $appl)
                        <div class="col-md-4 col-xs-6 sp-item">
                            <img src="images/jobseekers/user-10.jpg">
                            <p><a href="{{ url('account/employer/application/applicant/'.$appl->userId) }}">{!! $appl->firstName.' '.$appl->lastName !!}</a></p>
                            <p>{!! $appl->companyName !!}</p>
                            <p>{{ JobCallMe::cityName($appl->city) }}, {{ JobCallMe::countryName($appl->country) }}</p>
                        </div>
						 @endforeach

                      

                        <hr>
                        <div class="col-md-12">
                            <a href="people" class="pull-right" style="padding-top: 5px">View all</a>
                        </div>
                    </div>
                </div>
                <!--Follow Companies - End -->

                <!--Suggested Reading - Start -->
                <div class="suggested-reading">
                    <a href="{{ url('account/writings') }}" class="pull-right"><i class="fa fa-edit"></i> Write</a>
                    <h4>Suggested Reading</h4>
                    <hr>
					   @foreach($read_record as $rec)
                    <div class="col-md-6 sr-item">
                        <img src="{{ url('article-images/'.$rec->wIcon) }}" style="height:49px">
                        <div class="sr-details">
                            <p class="sr-title"><a href="{{ url('read') }}">{!! $rec->title !!} </a> </p>
                            <p class="sr-author"><a href="#"><span class="glyphicon glyphicon-user"></span> {{ $rec->name }}</a> </p>
                        </div>
                    </div>
					   @endforeach

                    <div class="col-md-12">
                        <a href="{{ url('read') }}" class="pull-right" style="padding-top: 5px">View all</a>
                    </div>
                </div>

            </div>
            <!--RTJ- Right end-->
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
    var ctx = document.getElementById('job-response').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: [{!! implode(',',$response[0]) !!}],
            datasets: [{
                label: "Job response",
                //backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [{!! implode(',',$response[1]) !!}],
            }]
        },

        // Configuration options go here
        options: {}
    });
    var ctx = document.getElementById("experience-level");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
           labels: [{!! implode(',',$experience[0]) !!}],
            datasets: [{
                label: '# of Votes',
                data: [{!! implode(',',$experience[1]) !!}],
                backgroundColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 170, 125, 1)',
                    'rgba(75, 120, 225, 1)',
                    'rgba(54, 120, 54, 1)',
                    'rgba(220,60,232,1)',
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 170, 64, 1)',
                    'rgba(75, 120, 225, 1)',
                    'rgba(54, 120, 54, 1)',
                    'rgba(220,60,232,1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById("recruitment-activity");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [{!! implode(',',$recruit[0]) !!}],
            datasets: [{
                label: 'Job Posted',
                data: [{!! implode(',',$recruit[1]) !!}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
@endsection