<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Job No</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($job->id); ?></td>
                        <td><?php echo e($job->company->name); ?></td>
                        <td><?php echo e($job->quantity); ?>0</td>
                        <td>
                            Job : <span class="badge text-dark"><?php echo e($job->status); ?></span>
                            <br>
                            Training : <span class="badge text-dark"><?php echo e($job->training_status); ?></span>
                            <br>
                            Certificate : <span class="badge text-dark"><?php echo e($job->certificate_status); ?></span>
                        </td>
                        <td><?php echo e($job->date); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" 
        onclick="openUpdateWorkOrderModal({ 
            id: <?php echo e($job->id); ?>, 
            training_status: '<?php echo e($job->training_status); ?>', 
            certificate_status: '<?php echo e($job->certificate_status); ?>' 
        })" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i> Update
</button>

                            <!-- View Button -->
                            <a href="<?php echo e(route('job.show', $job->id)); ?>" class="btn btn-primary btn-sm" title="View">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/index/table.blade.php ENDPATH**/ ?>