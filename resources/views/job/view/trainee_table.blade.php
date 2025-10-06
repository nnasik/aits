<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">S.No</th>
                        <th scope="col">Participant Name</th>
                        <th scope="col">Emirated ID / Passport No</th>
                        <th scope="col">Signature</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($training->trainees as $trainee)
                    <tr>
                        <td>
                            <form action="{{route('training.remove-trainee')}}" method="POST">
                                @csrf
                                <input type="hidden" name="training_id" value="{{$training->id}}">
                                <input type="hidden" name="trainee_id" value="{{$trainee->id}}">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$trainee->candidate_name_in_certificate}}</td>
                        <td>{{$trainee->eid_no ?? $trainee->passport}}<br>
                            @if($trainee->traineeRequest->eid_front_pic)
                            <a href="{{ '/storage/'.$trainee->traineeRequest->eid_front_pic }}" target="_blank">
                                <span>📄 EID Front Pic</span>
                            </a>
                            @else
                            <span>📄 EID Front Pic</span>
                            @endif
                        </td>
                        <td>
                            @if($trainee->signature)
                            <img src="{{ '/storage/'.$trainee->signature}}" alt="Signature" height="100">
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning" onclick="openEditTraineeModal({
                                id: '{{ $trainee->id }}',
                                candidate_name_in_certificate: '{{ $trainee->candidate_name_in_certificate }}',
                                company_name_in_certificate: '{{ $trainee->company_name_in_certificate }}',
                                course_name_in_certificate: '{{ $trainee->course_name_in_certificate }}',
                                live_photo: '{{ $trainee->live_photo }}',
                                eid_no: '{{ $trainee->eid_no }}',
                                date: '{{ $trainee->date }}',
                                passport_no: '{{ $trainee->passport_no }}',
                                dl_no: '{{ $trainee->dl_no }}',
                                dl_issued: '{{ $trainee->dl_issued }}',
                                dl_expiry: '{{ $trainee->dl_expiry }}'
                            })">
                                <i class="bi bi-pencil"></i>
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