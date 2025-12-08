@if($job->invoice_status=='Waiting')
<div class="card card-warning text-dark">
    @elseif($job->invoice_status=='On Going')
    <div class="card card-primary">
        @elseif($job->invoice_status=='Completed')
        <div class="card card-success">
            @elseif($job->invoice_status=='.')
            <div class="card card-danger">
                @else
                <div class="card card-dark">
                    @endif
                    <div class="card-header p-2">
                        <div class="col">
                            <h5 class="card-title">Invoice :<span class="badge ">({{$job->invoice_status}})</span></h5>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-2">
                        <table>
                            @if($job->invoice_no)
                            <tr>
                                <td>Invoice No </td>
                                <td>: {{$job->invoice_no}}</td>
                            </tr>
                            @endif

                            @if($job->invoice_date)
                            <tr>
                                <td>Invoice Date</td>
                                <td>: {{$job->invoice_date}}</td>
                            </tr>
                            @endif

                            <tr>
                                <td>
                                    Files
                                </td>
                                <td>
                                    :
                                    @foreach ($job->files as $file)

                                    @if ($file->document_type !== 'Invoice')
                                    @continue
                                    @endif

                                    @php
                                    // File existence
                                    $exists = Storage::disk($file->storage_disk)->exists($file->path);

                                    // Detect icon
                                    $extension = strtolower(pathinfo($file->original_name,
                                    PATHINFO_EXTENSION));
                                    $icon = match($extension) {
                                    'pdf' => 'bi-file-earmark-pdf',
                                    'doc', 'docx' => 'bi-file-earmark-word',
                                    'xls', 'xlsx' => 'bi-file-earmark-excel',
                                    'png', 'jpg', 'jpeg', 'gif', 'webp' => 'bi-file-earmark-image',
                                    'txt' => 'bi-file-earmark-text',
                                    default => 'bi-file-earmark'
                                    };

                                    // File URL
                                    $url = $exists ?
                                    Storage::disk($file->storage_disk)->url($file->path) : '#';

                                    // Tooltip (description)
                                    $tooltip = $file->description ? e($file->description) : '';
                                    @endphp

                                    <a href="{{ $url }}" target="_blank"
                                        class="btn btn-outline-dark btn-sm d-inline-flex align-items-center ml-2 px-1 py-0"
                                        @if(!$exists) disabled @endif @if($tooltip) data-bs-toggle="tooltip"
                                        title="{{ $tooltip }}" @endif>
                                        <i class="bi {{ $icon }} me-2"></i>
                                        Invoice
                                    </a>

                                    @endforeach
                                </td>

                            </tr>

                        </table>
                        <br>
                    </div>
                    <!-- /.card-body -->
                </div>
                <table>
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