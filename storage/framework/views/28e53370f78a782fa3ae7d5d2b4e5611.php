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
                            <a href="<?php echo e(route('certificate.pdf',$trainee->id)); ?>" target="_blank"><?php echo e($trainee->name); ?></a>
                           <button class="btn btn-outline-primary"><i class="bi bi-check"></i> Make Certificate</button>
                           <button class="btn btn-outline-primary"><i class="bi bi-check"></i> Card</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/certificate/index/trainee_table.blade.php ENDPATH**/ ?>