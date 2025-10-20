<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2">Certificate No</th>
                        <th rowspan="2">Job No</th>
                        <th rowspan="2">Candidate Name</th>
                        <th rowspan="2">Training Course</th>
                        <th colspan="3">Status</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="text-center">
                        <th>Training</th>
                        <th>Certificate</th>
                        <th>ID Card</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><a href="<?php echo e(route('certificate.pdf',$trainee->id)); ?>" target="_blank"><?php echo e($trainee->name); ?></a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                           <button class="btn btn-outline-primary"><i class="bi bi-magic"></i> Certificate</button>
                           <button class="btn btn-outline-primary"><i class="bi bi-magic"></i> Card</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/certificate/index/table.blade.php ENDPATH**/ ?>