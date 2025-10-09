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
                        <td class="text-start">
                            @if($request->request_status=='Requested')
                            <span class="badge bg-warning text-dark">Awaiting</span>
                            @elseif($request->request_status=='Accepted')
                                @if($request->job->status=='Open')
                                <i class="bi bi-briefcase-fill text-dark"></i> : <span class="badge bg-primary">
                                    {{$request->job->status}}
                                </span>
                                <br>
                                <i class="bi bi-file-earmark-ruled-fill text-dark"></i> : <span class="badge bg-dark">
                                    {{$request->job->id}}
                                </span>
                                    <br>
                                <i class="bi bi-person-fill"></i> : <span class="badge bg-dark">{{$request->job->issued->name}}</span>
                                    <br>
                                <i class="bi bi-clock-fill"></i> : <span class="badge bg-dark">{{$request->job->updated_at}}</span>
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
                                @elseif($request->job->training_status=='On Going')
                                <span class="badge bg-primary">{{$request->job->training_status}}</span>
                                @elseif($request->job->training_status=='Cancelled')
                                <span class="badge bg-danger">{{$request->job->training_status}}</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($request->request_status=='Requested')
                            <span class="badge bg-warning text-dark">Awaiting</span>
                            @elseif($request->request_status=='Accepted')
                                @if($request->job->certificate_status=='Waiting')
                                <span class="badge bg-warning text-dark">{{$request->job->certificate_status}}</span>
                                @elseif($request->job->certificate_status=='On Going')
                                <span class="badge bg-primary">{{$request->job->certificate_status}}</span>
                                @elseif($request->job->certificate_status=='Completed')
                                <span class="badge bg-success">{{$request->job->certificate_status}}</span>
                                @elseif($request->job->certificate_status=='Cancelled')
                                <span class="badge bg-danger">{{$request->job->certificate_status}}</span>
                                @endif
                            @endif

                        </td>
                        <td>
                            @if($request->request_status=='Requested')
                            Invoice : <span class="badge bg-warning text-dark">Waiting</span>
                            <br>
                            Delivery Note : <span class="badge bg-warning text-dark">Waiting</span>
                            @elseif($request->request_status=='Accepted')
                                @if($request->job->invoice_status=='Waiting')
                                Invoice : <span class="badge bg-warning text-dark">{{$request->job->invoice_status}}</span>
                                <br>
                                Delivery Note : <span
                                    class="badge bg-warning text-dark">{{$request->job->delivery_note_status}}</span>
                                @elseif($request->job->invoice_status=='Completed')
                                Invoice : <span class="badge bg-success">{{$request->job->invoice_status}}</span>
                                <br>
                                Delivery Note : <span
                                    class="badge bg-success">{{$request->job->delivery_note_status}}</span>
                                @elseif($request->job->certificate_status=='Cancelled')
                                Invoice : <span class="badge bg-danger">{{$request->job->invoice_status}}</span>
                                <br>
                                Delivery Note : <span class="badge bg-danger">{{$request->job->delivery_note_status}}</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            

                            <div class="dropdown">
                                <a class="btn btn-primary" href="{{route('jobrequest.show',$request->id)}}"><i
                                    class="bi bi-eye-fill"></i></a>
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" onclick="">Duplicate</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>