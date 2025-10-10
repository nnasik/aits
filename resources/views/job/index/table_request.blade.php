<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Request No</th>
                        <th scope="col">Company Name & Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Status</th>
                        <th scope="col">Requested On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job_requests as $request)
                    <tr>
                        <td>{{$request->id}}</td>
                        <td>{{$request->company->name}}
                            <span class="text-muted">
                            @foreach($request->training_requests as $training_request)
                            <br>
                              - {{$training_request->course_title_in_certificate}}
                            @endforeach
                            </span>
                        </td>
                        <td>
                            @php
                                $totalTrainees = $request->training_requests->sum(function($training_requests) {
                                    return $training_requests->trainee_requests->count();
                                });
                            @endphp
                            {{ $totalTrainees }}
                        </td>
                        <td><span class="badge text-bg-warning">{{$request->request_status}}</span></td>
                        <td>{{$request->requested_on}}</td>
                        <td>
                            <!-- View Button -->
                            <a href="" class="btn btn-outline-primary btn-sm" title="View">
                                <i class="bi bi-eye"></i> View
                            </a>

                            <button type="button" class="btn btn-outline-success btn-sm" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#acceptModal" 
                                    onclick="setJobRequestId({{ $request->id }}, {{ $request->work_order_id ?? 'null' }})">
                                <i class="bi bi-check-circle"></i> Accept
                            </button>

                            

                            <!-- Reject Button -->
                            <a href="" class="btn btn-outline-danger btn-sm" title="Reject">
                                <i class="bi bi-x-circle"></i> Reject
                            </a>



                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>