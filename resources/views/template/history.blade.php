<div class="card card-outline card-primary collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Log History</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="box-sizing: border-box; display: none;">

        <div class="timeline timeline-inverse">

            @foreach($job_request->histories->reverse() as $history)
            <!-- timeline item -->
            <div>
                <div>
                    <img src="" alt="">
                    hi
                </div>

                <div class="timeline-item">
                    <span class="time text-muted"><i class="far fa-clock"></i> {{$history->updated_at}}</span>

                    <h3 class="timeline-header">
                        <a href="#">{{$history->user->name}}</a> {{$history->event}}
                    </h3>

                    <pre class="p-3">{{json_encode($history->changes, JSON_PRETTY_PRINT)}}</pre>
                </div>
            </div>
            <!-- END timeline item -->
            @endforeach
            <div>
                <i class="fa fa-2x fa-clock" style="height:30px;border-radius: 50%;
    left: 18px;
    line-height: 30px;
    position: absolute;
    text-align: center;
    top: 0;
    width: 30px;"></i>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>