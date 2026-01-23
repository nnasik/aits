<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">S.No</th>
                        <th scope="col">Participant Name</th>
                        <th scope="col">Emirated ID / Passport No</th>
                        <th scope="col">Signature</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $training->trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <form action="<?php echo e(route('training.remove-trainee')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="training_id" value="<?php echo e($training->id); ?>">
                                <input type="hidden" name="trainee_id" value="<?php echo e($trainee->id); ?>">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td>
                            <?php if(isset($trainee->traineeRequest->profile_pic)): ?>
                            <img src="<?php echo e('/storage/'.$trainee->traineeRequest->profile_pic); ?>" alt="Live Photo"
                                height="100">
                            <?php endif; ?>

                            <?php if(isset($trainee->live_photo)): ?>
                            <img src="<?php echo e('/storage/'.$trainee->live_photo); ?>" alt="Live Photo" height="100">
                            <?php else: ?>
                            <form method="POST" action="<?php echo e(route('trainees.sync-live-photo')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="trainee_id" value="<?php echo e($trainee->id); ?>">
                                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                            <?php endif; ?>
                            <?php echo e($trainee->candidate_name_in_certificate); ?>



                        </td>
                        <td>
                            <?php if(isset($trainee->eid_no)): ?>
                                Emirates ID : <?php echo e($trainee->eid_no); ?>

                            <?php endif; ?>
                            <?php if(isset($trainee->passport_no)): ?>
                                Passport No : <?php echo e($trainee->passport_no); ?>

                            <?php endif; ?>
                            <br>
                            <?php if(isset($trainee->traineeRequest->eid_front_pic)): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->eid_front_pic); ?>" target="_blank">
                                <span>📄 EID Front</span>
                            </a>
                            <?php endif; ?>
                            <br>
                            <?php if(isset($trainee->traineeRequest->eid_back_pic)): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->eid_back_pic); ?>" target="_blank">
                                <span>📄 EID Back</span>
                            </a>
                            <?php endif; ?>
                            <br>
                            <?php if(isset($trainee->traineeRequest->visa_pic)): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->visa_pic); ?>" target="_blank">
                                <span>📄 Visa</span>
                            </a>
                            <?php endif; ?>
                            <br>
                            <?php if(isset($trainee->traineeRequest->passport_pic)): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->passport_pic); ?>" target="_blank">
                                <span>📄 Passport</span>
                            </a>
                            <?php endif; ?>
                            <br>
                            <?php if(isset($trainee->traineeRequest->dl_pic)): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->dl_pic); ?>" target="_blank">
                                <span>📄 Driving License</span>
                            </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($trainee->signature): ?>
                            <img src="<?php echo e('/storage/'.$trainee->signature); ?>" alt="Signature" height="100">
                            <br>
                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDeleteSignature(<?php echo e($trainee->id); ?>)">
                                <i class="bi bi-trash"></i> Signature
                            </button>
                            <?php else: ?>
                            <button type="button"
        class="btn btn-sm btn-primary"
        onclick="openSignatureModal(<?php echo e($training->id); ?>, <?php echo e($trainee->id); ?>)">
    Import
</button>

                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning" onclick="openEditTraineeModal({
                                id: '<?php echo e($trainee->id); ?>',
                                candidate_name_in_certificate: '<?php echo e($trainee->candidate_name_in_certificate); ?>',
                                company_name_in_certificate: '<?php echo e($trainee->company_name_in_certificate); ?>',
                                course_name_in_certificate: '<?php echo e($trainee->course_name_in_certificate); ?>',
                                live_photo: '<?php echo e($trainee->live_photo); ?>',
                                eid_no: '<?php echo e($trainee->eid_no); ?>',
                                date: '<?php echo e($trainee->date); ?>',
                                passport_no: '<?php echo e($trainee->passport_no); ?>',
                                dl_no: '<?php echo e($trainee->dl_no); ?>',
                                dl_issued: '<?php echo e($trainee->dl_issued); ?>',
                                dl_expiry: '<?php echo e($trainee->dl_expiry); ?>'
                            })">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view/trainee_table.blade.php ENDPATH**/ ?>