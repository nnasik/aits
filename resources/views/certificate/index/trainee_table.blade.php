<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>Job No</th>
                        <th>Training Course</th>
                        <th>Company Name</th>
                        <th>Candidate Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainees as $trainee)
                    <tr>
                        <td class="text-center">{{$trainee->training->job->id}}</td>
                        <td>{{$trainee->course_name_in_certificate}}</td>
                        <td>{{$trainee->company_name_in_certificate}}</td>
                        <td>{{$trainee->candidate_name_in_certificate}}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm"
    onclick="openCertificateModal(
        {{ $trainee->id }},
        {{ $trainee->training->work_order_id }},
        '{{ $trainee->candidate_name_in_certificate }}',
        '{{ $trainee->company_name_in_certificate }}',
        '{{ $trainee->company_location ?? '' }}',
        '{{ $trainee->course_name_in_certificate }}',
        '{{ $trainee->eid_no }}',
        '{{ $trainee->passport_no }}',
        '{{ $trainee->date }}',
        '{{ $trainee->live_photo }}'
    )">
    <i class='bi bi-award-fill'></i> Certificate
</button>

                            <a href="{{route('certificate.pdf',$trainee->id)}}" target="_blank">{{$trainee->name}}</a>
                           <button class="btn btn-outline-primary"><i class="bi bi-check"></i> Make Certificate</button>
                           <button class="btn btn-outline-primary"><i class="bi bi-check"></i> Card</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@include('certificate.modals.certificate_confirmation')