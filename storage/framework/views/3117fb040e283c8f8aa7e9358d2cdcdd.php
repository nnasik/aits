<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th></th>
                        <th>S.No</th>
                        <th>Training Course</th>
                        <th>Qty</th>
                        <th>Training Requested <br>Date & Time</th>
                        <th>Mode</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $job_request->training_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center">
                                <form action="<?php echo e(route('trainingrequest.destroy',$training_request->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <input type="hidden" name="id" value="1">
                                    <button class="btn btn-sm btn-danger <?php if($job_request->request_status!='Created'): ?> disabled <?php endif; ?> type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php echo e($training_request->course->name); ?>

                                <br>
                                as <?php echo e($training_request->course_title_in_certificate); ?>

                                <br>
                                <?php if($training_request->status=='Created'): ?>
                                    Staus : <span class="badge bg-secondary"><?php echo e($training_request->status); ?></span>
                                <?php elseif($training_request->status=='Requested'): ?>
                                    Staus : <span class="badge bg-primary"><?php echo e($training_request->status); ?></span>
                                <?php elseif($training_request->status=='Cancelled'): ?>
                                    Staus : <span class="badge bg-danger"><?php echo e($training_request->status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?php echo e($training_request->quantity); ?></td>
                            <td class="text-center"><?php echo e($training_request->requesting_date); ?> @ <?php echo e($training_request->requesting_time); ?></td>
                            <td class="text-center"><?php echo e($training_request->training_mode); ?></td>
                            <td class="text-center"><?php echo e($training_request->remarks); ?></td>
                            <td class="text-center">
                            <a class="btn btn-primary" href="<?php echo e(route('trainingrequest.show',$training_request->id)); ?>"><i class="bi bi-eye-fill"></i></a>
                        </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/view/table.blade.php ENDPATH**/ ?>