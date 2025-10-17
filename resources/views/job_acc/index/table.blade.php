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
                                  - {{$training->course_title_in_certificate}} ({{$training->quantity}})
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
                            <table>
                                <tr>
                                    <td>Invoice :
                                        <br>
                                        @if($job->invoice_status=='Waiting')
                                            <span class="badge bg-warning text-dark">
                                        @elseif($job->invoice_status=='On Going')
                                            <span class="badge bg-primary">
                                        @elseif($job->invoice_status=='Completed')
                                            <span class="badge bg-success">
                                        @elseif($job->invoice_status=='Cancelled')
                                            <span class="badge bg-danger">
                                        @else
                                            <span class="badge text-dark">
                                        @endif
                                            {{$job->invoice_status}}</span>
                                    </td>
                                    <td>
                                        @if($job->invoice_date)
                                            <i class="bi bi-hash"></i> {{$job->invoice_no}}
                                        @endif
                                         <br>
                                        @if($job->invoice_date)
                                            <i class="bi bi-calendar3"></i> {{$job->invoice_date}}
                                        @endif
                                        <br>
                                        <i class="bi bi-receipt"></i> Invoice
                                    </td>
                                </tr>
                                
                                <tr class="border-top">
                                    <td>Delivery Note :
                                        <br>
                                        @if($job->delivery_note_status=='Waiting')
                                            <span class="badge bg-warning text-dark">
                                        @elseif($job->delivery_note_status=='On Going')
                                            <span class="badge bg-primary">
                                        @elseif($job->delivery_note_status=='Completed')
                                            <span class="badge bg-success">
                                        @elseif($job->delivery_note_status=='Cancelled')
                                            <span class="badge bg-danger">
                                        @else
                                            <span class="badge text-dark">
                                        @endif
                                            {{$job->delivery_note_status}}</span>
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
                            <button class="btn btn-sm btn-outline-warning text-dark"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changeStatusModal"
                                    onclick="openChangeStatusModal(
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
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>