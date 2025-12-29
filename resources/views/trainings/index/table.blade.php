<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Training ID</th>
                        <th scope="col">Training Course</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Scheduled Date & Time</th>
                        <th scope="col">Mode</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainings as $training)
                    <tr>
                        <td>
                            @if($training->job)
                                <form action="{{route('training.destroy',$training->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{$training->id}}">
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-primary" type="button" onclick="openLinkTrainingModal('{{$training->id}}')"><i class="bi bi-link-45deg"></i></button>
                            @endif
                            
                        </td>
                        <td>{{$training->id}}</td>
                        <td><a href="{{route('training.show',$training->id)}}">{{$training->course->name}}</a></td>
                        <td>{{$training->quantity}}</td>
                        <td>{{$training->scheduled_date}} {{$training->scheduled_time}}</td>
                        <td>{{$training->training_mode}}</td>
                        <td>{{$training->remarks}}</td>
                        <td>
                            <div class="badge text-bg-warning">{{$training->status}}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Script -->
</div>