<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Item No</th>
                        <th scope="col">Training Course</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Scheduled Date & Time</th>
                        <th scope="col">Mode</th>
                        <th scope="col">Remarks</th>
                        <th scope="col" style="width: 20%;">Attendance</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job->trainings as $training)
                    <tr>
                        <td>
                            <form action="{{route('training.destroy',$training->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$training->id}}">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$training->course->name}}</td>
                        <td>{{$training->quantity}}</td>
                        <td>{{$training->scheduled_date}} {{$training->scheduled_time}}</td>
                        <td>{{$training->training_mode}}
                            <br>
                            @if($training->training_mode=='Online' && $training->training_link)
                                <button class="btn btn-sm btn-primary" onclick="copyZoomLink('{{ $training->training_link }}')">
                                    <i class="bi bi-link-45deg"></i> Zoom Link
                                </button>
                            @endif
                            <!-- Button -->
                        </td>
                        <td>{{$training->remarks}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary disabled" data-bs-toggle="modal">
                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                            </a>

                            <a class="btn btn-sm btn-primary disabled">
                                <i class="bi bi-whatsapp"></i> Link
                            </a>

                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal">
                                <i class="bi bi-eye"></i> view
                            </a>
                        </td>
                        <td>
                            <div class="badge text-bg-warning">{{$training->status}}</div>
                            
                            <button class="btn btn-sm btn-primary"> <i class="bi bi-arrow-repeat"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th>{{ $job->trainings->sum('quantity') }}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Script -->
    <script>
function copyZoomLink(link) {
    if (navigator.clipboard && window.isSecureContext) {
        // ✅ Modern API
        navigator.clipboard.writeText(link).then(() => {
            alert("✅ Zoom link copied to clipboard!");
        }).catch(err => {
            alert("❌ Failed to copy: " + err);
        });
    } else {
        // ⚡ Fallback for older browsers or non-HTTPS
        let textArea = document.createElement("textarea");
        textArea.value = link;
        textArea.style.position = "fixed"; // avoid scrolling to bottom
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            alert("✅ Zoom link copied to clipboard!");
        } catch (err) {
            alert("❌ Failed to copy: " + err);
        }
        document.body.removeChild(textArea);
    }
}
</script>
</div>