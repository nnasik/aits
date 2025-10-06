<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Job No</th>
                        <th scope="col">Company Name</th>
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
                        <td>{{$job->company->name}}</td>
                        <td>{{$job->quantity}}0</td>
                        <td>
                            Job : <span class="badge text-dark">{{$job->status}}</span>
                            <br>
                            Training : <span class="badge text-dark">{{$job->training_status}}</span>
                            <br>
                            Certificate : <span class="badge text-dark">{{$job->certificate_status}}</span>
                        </td>
                        <td>{{$job->date}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" 
        onclick="openUpdateWorkOrderModal({ 
            id: {{$job->id}}, 
            training_status: '{{$job->training_status}}', 
            certificate_status: '{{$job->certificate_status}}' 
        })" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i> Update
</button>

                            <!-- View Button -->
                            <a href="{{route('job.show', $job->id)}}" class="btn btn-primary btn-sm" title="View">
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