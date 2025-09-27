<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th></th>
                        <th>S.No</th>
                        <th>Training Course</th>
                        <th>Qty</th>
                        <th>Training Requested <br>Date & Time</th>
                        <th>Mode</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job_request->training_requests as $training_request)
                        <tr>
                            <td class="text-center">
                                <form action="{{route('trainingrequest.destroy',$training_request->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="1">
                                    <button class="btn btn-sm btn-danger @if($job_request->request_status!='Created') disabled @endif type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>
                                {{$training_request->course->name}}
                                <br>
                                as {{$training_request->course_title_in_certificate}}
                                <br>
                                @if($training_request->status=='Created')
                                    Staus : <span class="badge bg-secondary">{{$training_request->status}}</span>
                                @elseif($training_request->status=='Requested')
                                    Staus : <span class="badge bg-primary">{{$training_request->status}}</span>
                                @elseif($training_request->status=='Cancelled')
                                    Staus : <span class="badge bg-danger">{{$training_request->status}}</span>
                                @endif
                            </td>
                            <td class="text-center">{{$training_request->quantity}}</td>
                            <td class="text-center">{{$training_request->requesting_date}} @ {{$training_request->requesting_time}}</td>
                            <td class="text-center">{{$training_request->training_mode}}</td>
                            <td class="text-center">{{$training_request->remarks}}</td>
                            <td class="text-center">
                            <a class="btn btn-primary" href="{{route('trainingrequest.show',$training_request->id)}}"><i class="bi bi-eye-fill"></i></a>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>