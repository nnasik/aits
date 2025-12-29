<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Training ID</th>
                        <th scope="col">Training Course</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Scheduled Date & Time</th>
                        <th scope="col">Mode</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if($training->job): ?>
                                <form action="<?php echo e(route('training.destroy',$training->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <input type="hidden" name="id" value="<?php echo e($training->id); ?>">
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-primary" type="button" onclick="openLinkTrainingModal('<?php echo e($training->id); ?>')"><i class="bi bi-link-45deg"></i></button>
                            <?php endif; ?>
                            
                        </td>
                        <td><?php echo e($training->id); ?></td>
                        <td><a href="<?php echo e(route('training.show',$training->id)); ?>"><?php echo e($training->course->name); ?></a></td>
                        <td><?php echo e($training->quantity); ?></td>
                        <td><?php echo e($training->scheduled_date); ?> <?php echo e($training->scheduled_time); ?></td>
                        <td><?php echo e($training->training_mode); ?></td>
                        <td><?php echo e($training->remarks); ?></td>
                        <td>
                            <div class="badge text-bg-warning"><?php echo e($training->status); ?></div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Script -->
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/trainings/index/table.blade.php ENDPATH**/ ?>