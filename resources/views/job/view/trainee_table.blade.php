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
                        <td>{{$trainee->name}}</td>
                        <td>{{$trainee->eid_no ?? $trainee->passport}}</td>
                        <td>
                            @if($trainee->pivot->signature)
                            <img src="{{ '/storage/'.$trainee->pivot->signature}}" alt="Signature" height="100">
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning">
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