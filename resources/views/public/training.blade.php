<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AITS{{ $training->job->id }} - Attendance of {{ $training->course_title_in_certificate }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Photo button */
        .photo-btn-wrapper { position: relative; display: inline-block; }
        .photo-btn-wrapper input[type="file"] {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }

        /* Signature canvas */
        #signatureCanvas {
            background-color: #fff8b0;
            border: 2px solid #ccc;
            width: 100%;
            height: 400px;
            touch-action: none;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <table class="table table-bordered mt-3" style="font-size:1.5em">
        <tr>
            <td colspan="2" class="text-center">
                <img src="{{asset('assets/images/logo.png')}}" alt="" height="100">
                <h4 class="h4">American International Training Services LLC, Abu DHabi, UAE</h4>
                <hr>
                <p>
                    Training Attendance Record: {{ $training->course_title_in_certificate }} - {{ $training->scheduled_date }} - {{$training->company_name_in_certificate}}</p>
            </td>
        </tr>
        <tr>
            <td>AITS Job</td>
            <td><b>{{ $training->job->id }}</b></td>
        </tr>
        <tr>
            <td>Training</td>
            <td>{{ $training->course->name }} as <b>{{ $training->course_title_in_certificate }}</td>
        </tr>
        <tr>
            <td>Date </td>
            <td><b>{{ $training->scheduled_date }}</b></td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td>{{ $training->job->company->name }} as <b>{{$training->company_name_in_certificate}}</td>
        </tr>
    </table>
        
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th class="text-center" colspan="4">Trainee Details</th>
            </tr>
            <tr>
                <th>S.No</th>
                <th>Trainee</th>
                <th>Photo <br>(Not Mandatory)</th>
                <th>Signature <br>(Required)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($training->trainees as $index => $trainee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>Name : {{ $trainee->candidate_name_in_certificate }}<br>Emirates ID : {{ $trainee->eid_no }}<br> <span class="text-muted">Company : {{$trainee->company_name_in_certificate}}</span></td>

                {{-- Photo --}}
                <td>
                    @if($trainee->live_photo)
                        <img src="{{ asset('storage/'.$trainee->live_photo) }}" height="150">
                    @else
                        <form action="{{ route('public.trainee.photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="training_hash" value="{{ $training->hash }}">
                            <input type="hidden" name="trainee_id" value="{{ $trainee->id }}">
                            <input type="file" name="photo" onchange="this.form.submit()" style="display:none;" id="photoInput{{ $trainee->id }}">
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('photoInput{{ $trainee->id }}').click();">
                                Add Photo
                            </button>
                        </form>
                    @endif
                </td>

                {{-- Signature --}}
                <td>
                    @if($trainee->signature)
                        <img src="{{ asset('storage/'.$trainee->signature) }}" height="100">
                    @else
                        <button class="btn btn-sm btn-success"
                                onclick="openSignatureModal('{{ $trainee->id }}','{{ $trainee->candidate_name_in_certificate }}')">
                            Add Sign
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Signature Modal --}}
<div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign: <span id="traineeName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <canvas id="signatureCanvas"></canvas>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="clearBtn">Clear</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="saveBtn">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden form to submit signature --}}
<form id="sigForm" method="POST" action="{{ route('public.trainee.signature') }}" style="display:none;">
    @csrf
    <input type="hidden" name="signature" id="signatureInput">
    <input type="hidden" name="trainee_id" id="signatureTraineeId">
    <input type="hidden" name="training_hash" value="{{ $training->hash }}">
</form>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let canvas, ctx, drawing=false, currentTraineeId=null;

function openSignatureModal(traineeId, name){
    currentTraineeId = traineeId;
    document.getElementById('traineeName').textContent = name;

    const modalEl = document.getElementById('signatureModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    modalEl.addEventListener('shown.bs.modal', function(){
        canvas = document.getElementById('signatureCanvas');
        ctx = canvas.getContext('2d');
        ctx.clearRect(0,0,canvas.width,canvas.height);

        canvas.width = canvas.offsetWidth;
        canvas.height = 400;

        ctx.lineWidth = 4;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        // Mouse events
        canvas.onmousedown = ()=>drawing=true;
        canvas.onmouseup = ()=>{drawing=false; ctx.beginPath();};
        canvas.onmousemove = draw;

        // Touch events
        canvas.ontouchstart = (e)=>{drawing=true; draw(e.touches[0]);};
        canvas.ontouchend = ()=>{drawing=false; ctx.beginPath();};
        canvas.ontouchmove = (e)=>{draw(e.touches[0]); e.preventDefault();};
    }, {once:true});
}

function draw(e){
    if(!drawing) return;
    const rect = canvas.getBoundingClientRect();
    ctx.lineTo(e.clientX-rect.left, e.clientY-rect.top);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(e.clientX-rect.left, e.clientY-rect.top);
}

// Clear canvas
document.getElementById('clearBtn').addEventListener('click', ()=>{
    if(ctx) ctx.clearRect(0,0,canvas.width,canvas.height);
});

// Save signature
document.getElementById('saveBtn').addEventListener('click', ()=>{
    if(!currentTraineeId) return alert('Trainee not selected!');
    document.getElementById('signatureInput').value = canvas.toDataURL('image/png');
    document.getElementById('signatureTraineeId').value = currentTraineeId;
    document.getElementById('sigForm').submit();
});
</script>
</body>
</html>
