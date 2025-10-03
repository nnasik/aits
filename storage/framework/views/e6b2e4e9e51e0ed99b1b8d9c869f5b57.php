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
                        <td><?php echo e($trainee->name); ?></td>
                        <td><?php echo e($trainee->eid_no ?? $trainee->passport); ?></td>
                        <td>
                            <?php if($trainee->pivot->signature): ?>
                            <img src="<?php echo e('/storage/'.$trainee->pivot->signature); ?>" alt="Signature" height="100">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning">
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