<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Job No</th>
                        <th scope="col">Company Name & Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>{{$job->id}}</td>
                        <td>Request By : <b> {{$job->sales->name}}</b>
                            <br>
                            For : <b>{{$job->company->name}}</b>
                            @foreach($job->trainings as $training)
                            <br>
                            <span class="text-muted">
                                  - {{$training->course_title_in_certificate}} : {{$training->quantity}}
                            </span>
                            @endforeach
                        </td>

                        <td>
                            @php
                            $totalTrainees = $job->trainings->sum(function($training) {
                            return $training->trainees->count();
                            });
                            @endphp
                            {{ $totalTrainees }}
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Request : </td>
                                    <td>
                                        @if($job->request->request_status=='Cancelled')
                                        <span class="badge bg-danger">
                                            @elseif($job->request->request_status=='Accepted')
                                            <span class="badge bg-success">
                                                @else
                                                <span class="badge text-dark">
                                                    @endif
                                                    {{$job->request->request_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job : </td>
                                    <td>
                                        @if($job->status=='Open')
                                        <span class="badge bg-primary">
                                            @elseif($job->status=='Closed')
                                            <span class="badge bg-success">
                                                @elseif($job->status=='Cancelled')
                                                <span class="badge bg-danger">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Training : </td>
                                    <td>
                                        @if($job->training_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->training_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->training_status=='Completed')
                                                <span class="badge bg-success">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->training_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Certificate : </td>
                                    <td>
                                        @if($job->certificate_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->certificate_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->certificate_status=='Completed')
                                                <span class="badge bg-success">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->certificate_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice :</td>
                                    <td>
                                        @if($job->invoice_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->invoice_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->invoice_status=='Completed')
                                                <span class="badge bg-success">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->invoice_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Delivery Note :</td>
                                    <td>
                                        @if($job->delivery_note_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->delivery_note_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->delivery_note_status=='Completed')
                                                <span class="badge bg-success">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->delivery_note_status}}</span>
                                    </td>
                                </tr>
                            </table>


                        </td>
                        <td>{{$job->date}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('job.show', $job->id) }}">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="openUpdateWorkOrderModal({ 
                                                id: {{ $job->id }}, 
                                                training_status: '{{ $job->training_status }}', 
                                                certificate_status: '{{ $job->certificate_status }}' 
                                            })">
                                            <i class="bi bi-pencil"></i> Update Status
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="openJobStatusModal({ 
                                                 id: {{ $job->id }}, 
                                                 status: '{{ $job->status }}' 
                                               })">
                                            <i class="bi bi-pencil-square"></i> Job Update
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $jobs->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>