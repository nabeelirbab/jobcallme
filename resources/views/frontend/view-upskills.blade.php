@extends('frontend.layouts.app')

@section('title', 'Upskills')

@section('content')
<section id="postNewJob">
    <div class="container">
        @if(count($upskills) > 0)
            <div class="col-md-12">
                <div class="pnj-box">
                    <h3>
                        Promote Your Offerings
                        <a class="btn btn-primary pull-right" href="{{ url('account/upskill/add') }}" style="border-radius: 50%;margin-top: -5px;">
                            <i class="fa fa-plus"></i>
                        </a>
                    </h3>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($upskills as $skill)
                                        <tr id="upskill-{{ $skill->skillId }}">
                                            <td><a href="{{ url('learn/'.strtolower($skill->type).'/'.$skill->skillId ) }}">{!! $skill->title !!}</a></td>
                                            <td>{!! $skill->type !!}</td>
                                            <td>{!! $skill->address !!}</td>
                                            <td>{!! date('M d, Y',strtotime($skill->createdTime)) !!}</td>
                                            <td>
                                                <a href="{{ url('account/upskill/edit/'.$skill->skillId) }}"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                                <a href="javascript:;" onclick="deleteUpskill('{{ $skill->skillId }}')"><i class="fa fa-remove"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-9">
                <div class="pnj-box">
                    <h3>Promote Your Offerings</h3>
                    <div class="upskill-box">
                        <p>Advertise Your Courses, Conferences, Trainings, Workshops and Seminars</p>
                        <a href="{{ url('account/upskill/add') }}" class="btn btn-primary">ADVERTISE NOW</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
@section('page-footer')
<script type="text/javascript">
function deleteUpskill(skillId){
    if(confirm('Are you sure?')){
        $.ajax({
            url: "{{ url('account/upskill/delete') }}/"+skillId,
            success: function(response){
                if($.trim(response) != '1'){
                    toastr.error(response, '', {timeOut: 5000, positionClass: "toast-top-center"});
                }else{
                    $('#upskill-'+skillId).remove();
                    toastr.success('Upskill Deleted', '', {timeOut: 5000, positionClass: "toast-top-center"});
                }
            }
        })
    }
}
</script>
@endsection