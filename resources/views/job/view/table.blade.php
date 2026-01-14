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
                        <th scope="col">Attendance</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job->trainings as $training)
                    <tr>
                        <td>
                            <form action="{{route('training.unlink')}}" method="POST">
                                @csrf
                                <input type="hidden" name="training_id" value="{{$training->id}}">
                                <button class="btn btn-sm btn-danger" type="submit"><i
                                        class="bi bi-dash-circle"></i></button>
                            </form>
                        </td>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="{{route('training.show',$training->id)}}">{{$training->course->name}}</a> <br>
                            as <i>{{$training->course_title_in_certificate}} </i> - (Training ID : {{$training->id}})
                        </td>
                        <td>{{$training->quantity}} ({{$training->trainees->count()}})</td>
                        <td>{{$training->scheduled_date}} {{$training->scheduled_time}}</td>
                        <td>{{$training->training_mode}}</td>
                        <td>{{$training->remarks}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="javascript:void(0);"
                                data-link="{{ route('public.training.show', $training->hash) }}"
                                onclick="copyTrainingLink(this)">
                                <i class="bi bi-copy"></i> Link
                            </a>
                        </td>
                        <td>
                            <div class="badge text-bg-warning">{{$training->status}}</div>
                            {{isset($training->job)}}
                            @if(!isset($training->job))
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="training_id" value="{{$training->id}}">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
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
        function copyTrainingLink(el) {
            const link = el.getAttribute('data-link');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(link)
                    .then(() => alert('Link copied to clipboard'))
                    .catch(() => alert('Failed to copy link'));
                return;
            }

            const textarea = document.createElement('textarea');
            textarea.value = link;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            alert('Link copied to clipboard');
        }
    </script>

</div>