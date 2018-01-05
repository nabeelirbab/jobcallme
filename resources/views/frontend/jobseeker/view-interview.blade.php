@extends('frontend.layouts.app')

@section('title','Job Interview');

@section('content')
<section id="jobs">
    <div class="container">
        <div class="col-md-12 view-venue">
            <div class="panel panel-default">
                <div class="panel-heading">Job Interview</div>
                <div class="panel-body">
                    <?php
                    $venue = JobCallMe::getVeneue($interview->venueId);
                    $user = JobCallMe::getUser($interview->userId);
                    $company = JobCallMe::getCompany($user->companyId);
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="50%">Job</th>
                                    <td width="50%"><a href="{{ url('jobs/'.$interview->jobId) }}">{!! $interview->title !!}</a></td>
                                </tr>
                                <tr>
                                    <th width="50%">Company</th>
                                    <td width="50%">{!! $company->companyName !!}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Location</th>
                                    <td width="50%"><a href="http://maps.google.com/?q={!! $venue->address !!}" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;{!! $venue->address !!}</a></td>
                                </tr>
                                <tr>
                                    <th width="50%">Contact Person</th>
                                    <td width="50%">{!! $venue->contact !!}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Email</th>
                                    <td width="50%">{!! $venue->email !!}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Phone Number</th>
                                    <td width="50%">{!! $venue->phone !!}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Mobile Number</th>
                                    <td width="50%">{!! $venue->mobile !!}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Interview Date / Time</th>
                                    <td width="50%">
                                        <b>Date</b> <i>{{ $interview->fromDate }}</i> To <i>{{ $interview->toDate }}</i><br>
                                        <b>Timing</b> <i>09:00 AM</i> To <i>05:00 PM</i>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%">Instruction</th>
                                    <td width="50%">{!! $venue->instruction !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<style type="text/css">
</style>
<script type="text/javascript">
var token = "{{ csrf_token() }}";
</script>
@endsection