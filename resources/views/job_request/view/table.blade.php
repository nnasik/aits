<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>S.No</th>
                        <th>Training Course</th>
                        <th>Qty</th>
                        <th>Request Date & Time</th>
                        <th>Mode</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job_request->training_requests() as $training_request)
                    <tr>
                        <td class="text-center">{{$training_request->id}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>