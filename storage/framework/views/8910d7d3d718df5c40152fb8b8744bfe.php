<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2">Request<br>No</th>
                        <th rowspan="2">Company Name</th>
                        <th colspan="4">Status</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="text-center">
                        <th>Job</th>
                        <th>Training</th>
                        <th>Certificate <br>& ID</th>
                        <th>Invoice & <br> Delivery Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($request->id); ?></td>
                        <td>Job for : <?php echo e($request->company->name); ?>

                            <br>
                        as : <b><?php echo e($request->company_name_in_work_order); ?></b>
                            <br>
                        <?php if($request->request_status=='Requested'): ?>
                            <span class="badge bg-warning text-dark"><?php echo e($request->request_status); ?></span>
                            <span class="badge text-muted"><?php echo e($request->requested_on); ?></span>
                        <?php elseif($request->request_status=='Created'): ?>
                            <span class="badge bg-secondary"><?php echo e($request->request_status); ?></span>
                            <span class="badge text-muted"><?php echo e($request->updated_at); ?></span>
                        <?php elseif($request->request_status=='Cancelled'): ?>
                            <span class="badge bg-danger"><?php echo e($request->request_status); ?></span>
                            <span class="badge text-muted"><?php echo e($request->updated_at); ?></span>
                        <?php elseif($request->request_status=='Accepted'): ?>
                            <span class="badge bg-primary"><?php echo e($request->request_status); ?></span>
                            <span class="text-muted">by <?php echo e($request->accepted->name); ?> @ <?php echo e($request->accepted_on); ?></span>
                        <?php endif; ?>
                        <br>
                        <span class="badge text-muted">Request by : <?php echo e($request->requester->name); ?></span>
                        </td>
                        <td class="text-center">
                            <?php if($request->request_status=='Requested'): ?>
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            <?php elseif($request->request_status=='Accepted'): ?>
                                <?php if($request->job->status=='Open'): ?>
                                <span class="badge bg-primary">
                                    <?php echo e($request->job->status); ?>

                                </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($request->request_status=='Requested'): ?>
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            <?php elseif($request->request_status=='Accepted'): ?>
                                <?php if($request->job->training_status=='Waiting'): ?>
                                    <span class="badge bg-warning text-dark"><?php echo e($request->job->training_status); ?></span>
                                <?php elseif($request->job->training_status=='Completed'): ?>
                                    <span class="badge bg-success"><?php echo e($request->job->training_status); ?></span>
                                <?php elseif($request->job->training_status=='Cancelled'): ?>
                                    <span class="badge bg-danger"><?php echo e($request->job->training_status); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($request->request_status=='Requested'): ?>
                                <span class="badge bg-warning text-dark">Awaiting</span>
                            <?php else: ?>
                                <?php echo e($request->certificate_status); ?>

                            <?php endif; ?>
                            
                        </td>
                        <td>
                            <span class="badge text-dark">Invoice : </span><?php echo e($request->invoice_status); ?>

                            <br>
                            <span class="badge text-dark">Delivery Note : </span><?php echo e($request->delivery_note_status); ?>

                        </td>
                        <td class="text-center">
                            <a class="btn btn-primary" href="<?php echo e(route('jobrequest.show',$request->id)); ?>"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/index/table.blade.php ENDPATH**/ ?>