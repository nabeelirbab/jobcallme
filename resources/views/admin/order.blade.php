@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="layout-content">
        <div class="layout-content-body">
            <div class="title-bar">
                <h1 class="title-bar-title">
                    <span class="d-ib">Orders</span>
                </h1>
            </div>
			<div class="row">
                <div class="col-md-12">
                    @include('admin.includes.alerts')
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <th>#</th>
										<th>Payer Id</th>
                                        <th>Company Name</th>
										<th>Job Tittle</th>
										<th>Email</th>
										<th>Amount</th>
										<th>Job Category</th>
										<th>Payment Status</th>
                                        <th>Payment Date</th>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $i => $job)
                                            <tr>
                                                <td>{{ ++$startI }}</td>
												<td>{!! $job->pay_id!!}</td>
                                                <td>{!! $job->companyName !!}</td>
                                                <td>{!! $job->title !!}</td>
												<td>{!! $job->email!!}</td>
                                                <td>${!! $job->amount!!}</td>
												<td>{!! $job->p_Category!!}</td>
												<td style="text-align: center;"><label class="label label-success">{!! $job->jType!!}</label></td>
												<td>{!! $job->createdTime!!}</td>
                                                   
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection