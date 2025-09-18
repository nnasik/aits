<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>S.No</th>
                        <th>Training Course</th>
                        <th>Qty</th>
                        <th>Request Date & Time</th>
                        <th>Mode</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $job_request->training_requests(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($training_request->id); ?></td>
                        
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/view/table.blade.php ENDPATH**/ ?>