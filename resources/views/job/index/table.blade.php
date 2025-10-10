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
                        <td>{{$job->company->name}}
                            @foreach($job->trainings as $training)
                            <br>
                            <span class="text-muted">
                                  - {{$training->course_title_in_certificate}}
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
                            </table>
                            
                                
                        </td>
                        <td>{{$job->date}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" 
        onclick="openUpdateWorkOrderModal({ 
            id: {{$job->id}}, 
            training_status: '{{$job->training_status}}', 
            certificate_status: '{{$job->certificate_status}}' 
        })" class="btn btn-outline-warning btn-sm text-dark" title="Edit">
                                <i class="bi bi-pencil"></i> Update
</button>

                            <!-- View Button -->
                            <a href="{{route('job.show', $job->id)}}" class="btn btn-outline-primary btn-sm" title="View">
                                <i class="bi bi-eye"></i> View
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