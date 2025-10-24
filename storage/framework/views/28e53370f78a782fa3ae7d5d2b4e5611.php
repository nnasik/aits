<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>Job No</th>
                        <th>Training Course</th>
                        <th>Company Name</th>
                        <th>Candidate Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($trainee->training->job->id); ?></td>
                        <td><?php echo e($trainee->course_name_in_certificate); ?></td>
                        <td><?php echo e($trainee->company_name_in_certificate); ?></td>
                        <td><?php echo e($trainee->candidate_name_in_certificate); ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="openCertificateModal(
        <?php echo e($trainee->id); ?>,
        <?php echo e($trainee->training->work_order_id); ?>,
        '<?php echo e($trainee->candidate_name_in_certificate); ?>',
        '<?php echo e($trainee->company_name_in_certificate); ?>',
        '<?php echo e($trainee->company_location ?? ''); ?>',
        '<?php echo e($trainee->course_name_in_certificate); ?>',
        '<?php echo e($trainee->eid_no); ?>',
        '<?php echo e($trainee->passport_no); ?>',
        '<?php echo e($trainee->date); ?>',
        '<?php echo e($trainee->live_photo); ?>'
    )">
                                <i class='bi bi-award-fill'></i> Certificate
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="row mt-3">
                <?php echo e($trainees->links()); ?>

            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?php echo $__env->make('certificate.modals.certificate_confirmation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/certificate/index/trainee_table.blade.php ENDPATH**/ ?>