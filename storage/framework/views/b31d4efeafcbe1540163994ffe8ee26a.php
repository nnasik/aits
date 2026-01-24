<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if($training->job): ?>AITS<?php echo e($training->job->id); ?> - <?php endif; ?>
        Attendance of <?php echo e($training->course_title_in_certificate); ?>

    </title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #signatureCanvas {
            background-color: #fff8b0;
            border: 2px solid #ccc;
            width: 100%;
            aspect-ratio: 2 / 1;
            touch-action: none;
            display: block;
        }
    </style>
</head>
<body>

<div class="container my-4">

    
    <div class="card mb-4">
        <div class="card-body text-center">
            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" height="80">
            <h5 class="mt-2">American International Training Services LLC</h5>
            <p class="mb-1 small">
                <?php echo e($training->course_title_in_certificate); ?> |
                <?php echo e($training->scheduled_date); ?> |
                <?php echo e($training->company_name_in_certificate); ?>

            </p>
        </div>
    </div>

    

    
    <div class="d-none d-md-block">
        <table class="table table-bordered mt-3" style="font-size:1.1em">
            <tr>
                <td width="30%">AITS Job</td>
                <td>
                    <?php if($training->job): ?>
                        <b><?php echo e($training->job->id); ?></b>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Training</td>
                <td>
                    <?php echo e($training->course->name); ?> as
                    <b><?php echo e($training->course_title_in_certificate); ?></b>
                </td>
            </tr>
            <tr>
                <td>Date</td>
                <td><b><?php echo e($training->scheduled_date); ?></b></td>
            </tr>
            <tr>
                <td>Company</td>
                <td>
                    <?php if($training->job): ?>
                        <?php echo e($training->job->company->name); ?> as
                        <b><?php echo e($training->company_name_in_certificate); ?></b>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="d-block d-md-none">
        <div class="card mb-3">
            <div class="card-body">

                <div class="mb-3">
                    <span class="text-muted small">AITS Job</span><br>
                    <strong>
                        <?php if($training->job): ?>
                            <?php echo e($training->job->id); ?>

                        <?php endif; ?>
                    </strong>
                </div>

                <hr>

                <div class="mb-3">
                    <span class="text-muted small">Training</span><br>
                    <?php echo e($training->course->name); ?> as<br>
                    <strong><?php echo e($training->course_title_in_certificate); ?></strong>
                </div>

                <hr>

                <div class="mb-3">
                    <span class="text-muted small">Date</span><br>
                    <strong><?php echo e($training->scheduled_date); ?></strong>
                </div>

                <hr>

                <div>
                    <span class="text-muted small">Company</span><br>
                    <?php if($training->job): ?>
                        <?php echo e($training->job->company->name); ?> as<br>
                        <strong><?php echo e($training->company_name_in_certificate); ?></strong>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    

    
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
                <?php $__currentLoopData = $training->trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td>
                        <b><?php echo e($trainee->candidate_name_in_certificate); ?></b><br>
                        EID: <?php echo e($trainee->eid_no); ?><br>
                        <span class="text-muted"><?php echo e($trainee->company_name_in_certificate); ?></span>
                    </td>
                    <td>
                        <?php if($trainee->live_photo): ?>
                            <img src="<?php echo e(asset('storage/'.$trainee->live_photo)); ?>" height="120">
                        <?php else: ?>
                            <form action="<?php echo e(route('public.trainee.photo')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="training_hash" value="<?php echo e($training->hash); ?>">
                                <input type="hidden" name="trainee_id" value="<?php echo e($trainee->id); ?>">
                                <input type="file" name="photo" hidden
                                       onchange="this.form.submit()"
                                       id="photoInput<?php echo e($trainee->id); ?>">
                                <button type="button" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('photoInput<?php echo e($trainee->id); ?>').click();">
                                    Add Photo
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($trainee->signature): ?>
                            <img src="<?php echo e(asset('storage/'.$trainee->signature)); ?>" height="80">
                        <?php else: ?>
                            <button class="btn btn-sm btn-success"
                                    onclick="openSignatureModal('<?php echo e($trainee->id); ?>','<?php echo e($trainee->candidate_name_in_certificate); ?>')">
                                Add Sign
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    
    <div class="d-block d-md-none">
        <?php $__currentLoopData = $training->trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <span class="badge bg-secondary mb-2">#<?php echo e($index + 1); ?></span>

                <p>Name : <b><?php echo e($trainee->candidate_name_in_certificate); ?></b></p>
                <p>EID : <b><?php echo e($trainee->eid_no); ?></b></p>
                <p>Company : <b><?php echo e($trainee->company_name_in_certificate); ?></b></p>

                <div class="row g-2">
                    <div class="col-6">
                        <?php if($trainee->live_photo): ?>
                            <img src="<?php echo e(asset('storage/'.$trainee->live_photo)); ?>"
                                 class="img-fluid rounded border">
                        <?php else: ?>
                            <form action="<?php echo e(route('public.trainee.photo')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="training_hash" value="<?php echo e($training->hash); ?>">
                                <input type="hidden" name="trainee_id" value="<?php echo e($trainee->id); ?>">
                                <input type="file" name="photo" hidden
                                       onchange="this.form.submit()"
                                       id="photoInputMobile<?php echo e($trainee->id); ?>">
                                <button type="button"
                                        class="btn btn-outline-primary w-100"
                                        onclick="document.getElementById('photoInputMobile<?php echo e($trainee->id); ?>').click();">
                                    Add Photo
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <?php if($trainee->signature): ?>
                            <img src="<?php echo e(asset('storage/'.$trainee->signature)); ?>"
                                 class="img-fluid rounded border">
                        <?php else: ?>
                            <button class="btn btn-outline-success w-100"
                                    onclick="openSignatureModal('<?php echo e($trainee->id); ?>','<?php echo e($trainee->candidate_name_in_certificate); ?>')">
                                Add Signature
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>


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

<form id="sigForm" method="POST" action="<?php echo e(route('public.trainee.signature')); ?>" hidden>
    <?php echo csrf_field(); ?>
    <input type="hidden" name="signature" id="signatureInput">
    <input type="hidden" name="trainee_id" id="signatureTraineeId">
    <input type="hidden" name="training_hash" value="<?php echo e($training->hash); ?>">
</form>

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

        canvas.style.width = '100%';
        canvas.style.height = 'auto';

        ctx = canvas.getContext('2d');
        ctx.clearRect(0,0,canvas.width,canvas.height);

        canvas.width  = 400;
        canvas.height = 200;

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
<?php /**PATH D:\xampp\htdocs\aits\resources\views/public/training2.blade.php ENDPATH**/ ?>