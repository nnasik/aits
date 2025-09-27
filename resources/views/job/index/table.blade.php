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
                        <td><span class="badge text-bg-danger">{{$job->status}}</span></td>
                        <td>{{$job->date}}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{route('job.edit', $job->id)}}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

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