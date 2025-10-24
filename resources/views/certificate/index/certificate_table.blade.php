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
                        <td>{{$certificate->id}}</td>
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
                            <table>
                                <tr>
                                    <td>
                                        Certificate :
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary" target="_blank" href="{{route('certificate.pdf.v1',$certificate->id)}}">V1</a>
                                        <a class="btn btn-outline-primary" target="_blank" href="{{route('certificate.pdf.v2',$certificate->id)}}">V2</a>
                                        <button class="btn btn-outline-primary">V3</button>
                                        <button class="btn btn-outline-primary">V4</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Card :
                                    </td>
                                    <td>
                                        <a href="{{route('id.pdf.v1',$certificate->id)}}" target="_blank" class="btn btn-outline-primary">V1</a>
                                        <a href="{{route('id.pdf.v2',$certificate->id)}}" target="_blank" class="btn btn-outline-primary">V2</a>
                                    </td>
                                </tr>
                            </table>
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