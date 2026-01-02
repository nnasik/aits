<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>Certificate No</th>
                        <th>Job No</th>
                        <th>Candidate Name</th>
                        <th>Training Course</th>
                        <th>Issued Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                    <tr>
                        <td>{{$certificate->id}}
                            <br>
                            
                        </td>
                        <td>{{$certificate->trainee->training->job->id}}</td>
                        <td><strong>{{$certificate->candidate_name_in_certificate}}</strong>
                            <br>
                            {{$certificate->company_name_in_certificate}}
                            <br>
                            {{$certificate->company_location}}
                        </td>
                        <td>{{$certificate->course_name_in_certificate}}</td>
                        <td>{{$certificate->date}}</td>
                        <td>
                            <a class="btn btn-outline-primary" target="_blank" href="{{route('certificate.pdf',$certificate->id)}}">Certificate</a>
                            <a class="btn btn-outline-primary" target="_blank" href="{{route('card.pdf',$certificate->id)}}">ID</a>
                            <a class="btn btn-outline-primary" target="_blank" href="{{route('scan.pdf',$certificate->id)}}">Scan</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row mt-3">
                {{ $certificates->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>