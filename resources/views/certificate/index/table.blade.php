<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2">Certificate No</th>
                        <th rowspan="2">Job No</th>
                        <th rowspan="2">Candidate Name</th>
                        <th rowspan="2">Training Course</th>
                        <th colspan="3">Status</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="text-center">
                        <th>Training</th>
                        <th>Certificate</th>
                        <th>ID Card</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$record->certificate_no}}</td>
                        <td>{{$record->training->job->id}}</td>
                        <td><a href="{{route('certificate.pdf',$record->id)}}" target="_blank">{{$record->trainee->name}}</a></td>
                        <td>{{$record->training->course->name}}</td>
                        <td>{{$record->training_status}}</td>
                        <td>{{$record->certificate_status}}</td>
                        <td>{{$record->id_card_status}}</td>
                        <td>
                           <button class="btn btn-outline-primary"><i class="bi bi-magic"></i> Certificate</button>
                           <button class="btn btn-outline-primary"><i class="bi bi-magic"></i> Card</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>