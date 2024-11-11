


    <div class="timeline timeline-inverse">

@isset($job_status)
        @foreach($job_status as $row)
    <div class="time-label">
    <span class="bg-lightblue">
    {{App\Helpers\CommonHelper::DateFormat($row->created_at)}}
    </span>
    </div>

    <div>
    <i class="fas fa-comments bg-warning"></i>
    <div class="timeline-item">
    <span class="time"><i class="far fa-clock"></i> {{$row->created_at->diffForHumans()}}</span>
    <h3 class="timeline-header"><a href="#">{{$row->user->name}}</a> changed status to @isset($row->job_status)<span class="badge badge-warning">{{App\Helpers\CommonHelper::JobStatus($row->job_status)}}</span>@endisset</h3>
    <div class="timeline-body">
   {{$row->reason}}
    </div>
   {{--  <div class="timeline-footer">
    <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
    </div> --}}
    </div>
    </div>

@endforeach
@endisset

    </div>


