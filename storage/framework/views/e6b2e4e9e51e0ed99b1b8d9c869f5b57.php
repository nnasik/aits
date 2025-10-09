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
                        <td><?php echo e($trainee->candidate_name_in_certificate); ?></td>
                        <td><?php echo e($trainee->eid_no ?? $trainee->passport); ?><br>
                            <?php if($trainee->traineeRequest->eid_front_pic): ?>
                            <a href="<?php echo e('/storage/'.$trainee->traineeRequest->eid_front_pic); ?>" target="_blank">
                                <span>📄 EID Front Pic</span>
                            </a>
                            <?php else: ?>
                            <span>📄 EID Front Pic</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($trainee->signature): ?>
                            <img src="<?php echo e('/storage/'.$trainee->signature); ?>" alt="Signature" height="100">
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
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view/trainee_table.blade.php ENDPATH**/ ?>