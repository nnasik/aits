<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Job No</th>
                        <th scope="col">Job Date</th>
                        <th scope="col">Company Name & Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Ops Status</th>
                        <th scope="col">Acc Status</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>{{$job->id}}</td>
                        <td>{{$job->date}}</td>
                        <td>{{$job->company->name}}
                            @foreach($job->trainings as $training)
                            <br>
                            <span class="text-muted">
                                  - <a href="http://">{{$training->course_title_in_certificate}}
                                    ({{$training->quantity}})</a>
                            </span>
                            @endforeach
                        </td>

                        <td>
                            @php
                            $totalTrainees = $job->trainings->sum(function($training) {
                            return $training->trainees->count();
                            });
                            @endphp
                            {{ $totalTrainees }}
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Request : </td>

                                    <td>
                                        @if($job->request->request_status=='Cancelled')
                                        <span class="badge bg-danger">
                                            @elseif($job->request->request_status=='Accepted')
                                            <span class="badge bg-success">
                                                @else
                                                <span class="badge text-dark">
                                                    @endif
                                                    {{$job->request->request_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job : </td>
                                    <td>
                                        @if($job->status=='Open')
                                        <span class="badge bg-primary">
                                            @elseif($job->status=='Closed')
                                            <span class="badge bg-success">
                                                @elseif($job->status=='Cancelled')
                                                <span class="badge bg-danger">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Training : </td>
                                    <td>
                                        @if($job->training_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->training_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->training_status=='Completed')
                                                <span class="badge bg-success">
                                                    @elseif($job->training_status=='Cancelled')
                                                    <span class="badge bg-danger">
                                                        @else
                                                        <span class="badge text-dark">
                                                            @endif
                                                            {{$job->training_status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Certificate : </td>
                                    <td>
                                        @if($job->certificate_status=='Waiting')
                                        <span class="badge bg-warning text-dark">
                                            @elseif($job->certificate_status=='On Going')
                                            <span class="badge bg-primary">
                                                @elseif($job->certificate_status=='Completed')
                                                <span class="badge bg-success">
                                                    @elseif($job->certificate_status=='Cancelled')
                                                    <span class="badge bg-danger">
                                                        @else
                                                        <span class="badge text-dark">
                                                            @endif
                                                            {{$job->certificate_status}}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td>
                            @include('job_acc.partials.invoice')
                            </td>
                        <td>


                            <br>
                            @if($job->delivery_note_no)
                            <i class="bi bi-hash"></i> {{$job->delivery_note_no}}
                            @endif
                            <br>
                            @if($job->delivery_note_no)
                            <i class="bi bi-file-earmark-text"></i> Delivery Note
                            @endif
                                                    </td>
                                                </tr>
                                            </table>
                        </td>
                        <td>
                            <table>


                                <tr>
                                    <td>Due On :</td>
                                    <td>{{$job->invoice_date}}</td>
                                </tr>
                                <tr>
                                    <td>Due On :</td>
                                    <td>{{$job->invoice_due_date}}</td>
                                </tr>
                                <tr>
                                    <td>Payment Status :</td>
                                    <td>
                                        @if($job->payment_status=='Unpaid')
                                        <span class="badge bg-danger">
                                            @elseif($job->payment_status=='Paid')
                                            <span class="badge bg-success">
                                                @elseif($job->payment_statuss=='partial')
                                                <span class="badge bg-warning text-dark">
                                                    @else
                                                    <span class="badge text-dark">
                                                        @endif
                                                        {{$job->payment_status}}
                                                    </span>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-warning text-dark" data-bs-toggle="modal"
                                data-bs-target="#changeStatusModal" onclick="openChangeStatusModal(
                                        {{ $job->id }},
                                        '{{ $job->invoice_status }}',
                                        '{{ $job->delivery_note_status }}',
                                        '{{ $job->invoice_no }}',
                                        '{{ $job->invoice_date }}',
                                        '{{ $job->invoice_amount }}',
                                        '{{ $job->invoice_due_date }}',
                                        '{{ $job->payment_status }}',
                                        '{{ $job->delivery_note_no }}'
                                    )">
                                <i class="bi bi-pencil"></i> Update Status
                            </button>
                            <br>

                            <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#uploadFileModal" onclick="setWorkOrderId({{ $job->id }})">
                                <i class="bi bi-cloud-arrow-up"></i> Upload File
                            </button>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="bg-light">
                            <a class="btn btn-sm btn-outline-success mb-2 me-2 d-inline-flex align-items-center"
                                target="_blank" href="{{route('job.pdf',$job->id)}}">
                                <i class="bi bi-file-earmark-pdf"></i>  Work Permit
                            </a>

                            @foreach ($job->files as $file)
                            @php
                            $exists = Storage::disk($file->storage_disk)->exists($file->path);

                            $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));

                            $icon = match($extension) {
                            'pdf' => 'bi-file-earmark-pdf',
                            'doc', 'docx' => 'bi-file-earmark-word',
                            'xls', 'xlsx' => 'bi-file-earmark-excel',
                            'png', 'jpg', 'jpeg', 'gif', 'webp' => 'bi-file-earmark-image',
                            'txt' => 'bi-file-earmark-text',
                            default => 'bi-file-earmark'
                            };

                            $url = $exists ? Storage::disk($file->storage_disk)->url($file->path) : '#';
                            @endphp

                            <a href="{{ $url }}" target="_blank"
                                class="btn btn-outline-primary btn-sm mb-2 me-2 d-inline-flex align-items-center"
                                @if(!$exists) disabled @endif>
                                <i class="bi {{ $icon }} me-2"></i>
                                {{$file->document_type}}
                            </a>

                            @endforeach
                        </td>
                    </tr>


                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $jobs->links()}}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>