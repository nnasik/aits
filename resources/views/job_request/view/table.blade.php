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
                                <button
                                    class="btn btn-sm btn-danger @if($job_request->request_status!='Created') disabled @endif type="
                                    submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>
                            <i>{{$training_request->course->name}}</i> as
                            <br>
                            <b>{{$training_request->course_title_in_certificate}}</b> -
                            {{$training_request->training_mode}}
                            <br>
                            @if($training_request->status=='Created')
                            Staus : <span class="badge bg-secondary">{{$training_request->status}}</span>
                            @elseif($training_request->status=='Requested')
                            Staus : <span class="badge bg-primary">{{$training_request->status}}</span>
                            @elseif($training_request->status=='Job Accepted')
                            Staus : <span class="badge bg-dark">{{$training_request->status}}</span>
                            @elseif($training_request->status=='Completed')
                            Staus : <span class="badge bg-success">{{$training_request->status}}</span>
                            @elseif($training_request->status=='Cancelled')
                            Staus : <span class="badge bg-danger">{{$training_request->status}}</span>
                            @endif
                            <br>
                            @if($training_request->status=='Job Accepted')
                            <button class="btn btn-sm btn-primary mt-2"
                                onClick="copyToClipboard('{{route('public.training.show',$training_request->training->hash)}}')">
                                <i class="bi bi-link-45deg"></i>Attendance</button>
                            @endif


                        </td>
                        <td class="text-center">{{$training_request->quantity}}</td>
                        <td class="text-center">{{$training_request->requesting_date}} @
                            {{$training_request->requesting_time}}</td>

                        <td class="text-center">{{$training_request->training_mode}}</td>
                        <td class="text-center">{{$training_request->remarks}}</td>
                        <td class="text-center">


                            <!-- Dropdown with three-dot icon -->
                            <div class="dropdown">
                                <a class="btn btn-primary"
                                    href="{{route('trainingrequest.show',$training_request->id)}}"><i
                                        class="bi bi-eye-fill"></i></a>
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">Duplicate Trainees</a></li>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                function copyToClipboard(value) {
                    // Create a temporary input
                    const tempInput = document.createElement("input");
                    tempInput.value = value;
                    document.body.appendChild(tempInput);

                    // Select and copy
                    tempInput.select();
                    document.execCommand("copy");

                    // Remove the temp input
                    document.body.removeChild(tempInput);

                    // Optional: Show confirmation
                    alert("Copied: " + value);
                }
            </script>
        </div>
        <!-- /.card-body -->
    </div>
</div>