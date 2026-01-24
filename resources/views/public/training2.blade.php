<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($training->job)AITS{{ $training->job->id }} - @endif
        Attendance of {{ $training->course_title_in_certificate }}
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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

    {{-- ================= HEADER ================= --}}
    <div class="card mb-4">
        <div class="card-body text-center">
            <img src="{{asset('assets/images/logo.png')}}" height="80">
            <h5 class="mt-2">American International Training Services LLC</h5>
            <p class="mb-1 small">
                {{ $training->course_title_in_certificate }} |
                {{ $training->scheduled_date }} |
                {{ $training->company_name_in_certificate }}
            </p>
        </div>
    </div>

    {{-- ================= DESKTOP TABLE ================= --}}
    <div class="d-none d-md-block">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Trainee</th>
                    <th>Photo</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($training->trainees as $index => $trainee)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        <b>{{ $trainee->candidate_name_in_certificate }}</b><br>
                        EID: {{ $trainee->eid_no }}<br>
                        <span class="text-muted">{{ $trainee->company_name_in_certificate }}</span>
                    </td>

                    <td>
                        @if($trainee->live_photo)
                            <img src="{{ asset('storage/'.$trainee->live_photo) }}" height="120">
                        @else
                            <form action="{{ route('public.trainee.photo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="training_hash" value="{{ $training->hash }}">
                                <input type="hidden" name="trainee_id" value="{{ $trainee->id }}">
                                <input type="file" name="photo" hidden
                                       onchange="this.form.submit()"
                                       id="photoInput{{ $trainee->id }}">
                                <button type="button" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('photoInput{{ $trainee->id }}').click();">
                                    Add Photo
                                </button>
                            </form>
                        @endif
                    </td>

                    <td>
                        @if($trainee->signature)
                            <img src="{{ asset('storage/'.$trainee->signature) }}" height="80">
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

    {{-- ================= MOBILE CARDS ================= --}}
    <div class="d-block d-md-none">

        @foreach($training->trainees as $index => $trainee)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <span class="badge bg-secondary mb-2">#{{ $index + 1 }}</span>

                <h6 class="fw-bold mb-1">
                    {{ $trainee->candidate_name_in_certificate }}
                </h6>

                <p class="small mb-1"><b>EID:</b> {{ $trainee->eid_no }}</p>
                <p class="small text-muted mb-3">{{ $trainee->company_name_in_certificate }}</p>

                <div class="row g-2">
                    <div class="col-6">
                        @if($trainee->live_photo)
                            <img src="{{ asset('storage/'.$trainee->live_photo) }}"
                                 class="img-fluid rounded border">
                        @else
                            <form action="{{ route('public.trainee.photo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="training_hash" value="{{ $training->hash }}">
                                <input type="hidden" name="trainee_id" value="{{ $trainee->id }}">
                                <input type="file" name="photo" hidden
                                       onchange="this.form.submit()"
                                       id="photoInputMobile{{ $trainee->id }}">
                                <button type="button"
                                        class="btn btn-outline-primary w-100"
                                        onclick="document.getElementById('photoInputMobile{{ $trainee->id }}').click();">
                                    Add Photo
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="col-6">
                        @if($trainee->signature)
                            <img src="{{ asset('storage/'.$trainee->signature) }}"
                                 class="img-fluid rounded border">
                        @else
                            <button class="btn btn-outline-success w-100"
                                    onclick="openSignatureModal('{{ $trainee->id }}','{{ $trainee->candidate_name_in_certificate }}')">
                                Add Signature
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

{{-- ================= SIGNATURE MODAL ================= --}}
<div class="modal fade" id="signatureModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign: <span id="traineeName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<form id="sigForm" method="POST" action="{{ route('public.trainee.signature') }}" hidden>
    @csrf
    <input type="hidden" name="signature" id="signatureInput">
    <input type="hidden" name="trainee_id" id="signatureTraineeId">
    <input type="hidden" name="training_hash" value="{{ $training->hash }}">
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- JS EXACTLY AS YOU GAVE — NOT TOUCHED --}}
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

        canvas.onmousedown = ()=>drawing=true;
        canvas.onmouseup = ()=>{drawing=false; ctx.beginPath();};
        canvas.onmousemove = draw;

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

document.getElementById('clearBtn').addEventListener('click', ()=>{
    if(ctx) ctx.clearRect(0,0,canvas.width,canvas.height);
});

document.getElementById('saveBtn').addEventListener('click', ()=>{
    if(!currentTraineeId) return alert('Trainee not selected!');
    document.getElementById('signatureInput').value = canvas.toDataURL('image/png');
    document.getElementById('signatureTraineeId').value = currentTraineeId;
    document.getElementById('sigForm').submit();
});
</script>

</body>
</html>

