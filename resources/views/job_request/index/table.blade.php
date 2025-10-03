<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2">Request<br>No</th>
                        <th rowspan="2">Company Name</th>
                        <th colspan="4">Status</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="text-center">
                        <th>Job</th>
                        <th>Training</th>
                        <th>Certificate <br>& ID</th>
                        <th>Invoice & <br> Delivery Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td class="text-center">{{$request->id}}</td>
                        <td>Job for : {{$request->company->name}}
                            <br>
                        as : <b>{{$request->company_name_in_work_order}}</b>
                            <br>
                        @if($request->request_status=='Requested')
                            <span class="badge bg-warning text-dark">{{$request->request_status}}</span>
                            <span class="badge text-muted">{{$request->requested_on}}</span>
                        @elseif($request->request_status=='Created')
                            <span class="badge bg-secondary">{{$request->request_status}}</span>
                            <span class="badge text-muted">{{$request->updated_at}}</span>
                        @elseif($request->request_status=='Cancelled')
                            <span class="badge bg-danger">{{$request->request_status}}</span>
                            <span class="badge text-muted">{{$request->updated_at}}</span>
                        @elseif($request->request_status=='Accepted')
                            <span class="badge bg-primary">{{$request->request_status}}</span>
                            <span class="text-muted">by {{$request->accepted->name}} @ {{$request->accepted_on}}</span>
                        @endif
                        <br>
                        <span class="badge text-muted">Request by : {{$request->requester->name}}</span>
                        </td>
                        <td class="text-center">
                            @if($request->request_status=='Requested')
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            @elseif($request->request_status=='Accepted')
                                @if($request->job->status=='Open')
                                <span class="badge bg-primary">
                                    {{$request->job->status}}
                                </span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($request->request_status=='Requested')
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            @elseif($request->request_status=='Accepted')
                                @if($request->job->training_status=='Waiting')
                                    <span class="badge bg-warning text-dark">{{$request->job->training_status}}</span>
                                @elseif($request->job->training_status=='Completed')
                                    <span class="badge bg-success">{{$request->job->training_status}}</span>
                                @elseif($request->job->training_status=='Cancelled')
                                    <span class="badge bg-danger">{{$request->job->training_status}}</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($request->request_status=='Requested')
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            @else
                                {{$request->certificate_status}}
                            @endif
                            
                        </td>
                        <td>
                            <span class="badge text-dark">Invoice : </span>{{$request->invoice_status}}
                            <br>
                            <span class="badge text-dark">Delivery Note : </span>{{$request->delivery_note_status}}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-primary" href="{{route('jobrequest.show',$request->id)}}"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>