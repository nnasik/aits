<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Request No</th>
                        <th scope="col">Company Name & Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Status</th>
                        <th scope="col">Requested On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $job_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($request->id); ?></td>
                        <td>Request By : <b> <?php echo e($request->requester->name); ?></b>
                            <br>
                            For : <b><?php echo e($request->company->name); ?></b>
                            <span class="text-muted">
                            <?php $__currentLoopData = $request->training_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br>
                              - <?php echo e($training_request->course_title_in_certificate); ?> : <?php echo e($training_request->quantity); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                        </td>
                        <td>
                            <?php
                                $totalTrainees = $request->training_requests->sum(function($training_requests) {
                                    return $training_requests->trainee_requests->count();
                                });
                            ?>
                            <?php echo e($totalTrainees); ?>

                        </td>
                        <td><span class="badge text-bg-warning"><?php echo e($request->request_status); ?></span></td>
                        <td><?php echo e($request->requested_on); ?></td>
                        <td>
                            <!-- View Button -->
                            <!-- <a href="" class="btn btn-outline-primary btn-sm" title="View">
                                <i class="bi bi-eye"></i> View
                            </a> -->

                            <button type="button" class="btn btn-outline-success btn-sm m-1" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#acceptModal" 
                                    onclick="setJobRequestId(<?php echo e($request->id); ?>, <?php echo e($request->work_order_id ?? 'null'); ?>)">
                                <i class="bi bi-check-circle"></i> New Job
                            </button>
                            <br>
                            <button type="button" class="btn btn-outline-success btn-sm m-1" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#acceptModal" 
                                    onclick="setJobRequestId(<?php echo e($request->id); ?>, <?php echo e($request->work_order_id ?? 'null'); ?>)">
                                <i class="bi bi-check-circle"></i> Merge Job
                            </button>

                            <br>

                            <!-- Reject Button -->
                            <a href="" class="btn btn-outline-danger btn-sm m-1" title="Reject">
                                <i class="bi bi-x-circle"></i> Reject
                            </a>



                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/index/table_request.blade.php ENDPATH**/ ?>