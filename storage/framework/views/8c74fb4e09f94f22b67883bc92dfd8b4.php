<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col">Job No</th>
                        <th scope="col">Job Date</th>
                        <th scope="col">Company Name & Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Ops Status</th>
                        <th scope="col">Acc Status</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($job->id); ?></td>
                        <td><?php echo e($job->date); ?></td>
                        <td><?php echo e($job->company->name); ?>

                            <?php $__currentLoopData = $job->trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br>
                            <span class="text-muted">
                                  - <?php echo e($training->course_title_in_certificate); ?> (<?php echo e($training->quantity); ?>)
                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>

                        <td>
                            <?php
                                $totalTrainees = $job->trainings->sum(function($training) {
                                    return $training->trainees->count();
                                });
                            ?>
                            <?php echo e($totalTrainees); ?>

                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Request : </td>
                                    
                                    <td>
                                        <?php if($job->request->request_status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php elseif($job->request->request_status=='Accepted'): ?>
                                            <span class="badge bg-success">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                        <?php echo e($job->request->request_status); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job : </td>
                                    <td>
                                        <?php if($job->status=='Open'): ?>
                                            <span class="badge bg-primary">
                                        <?php elseif($job->status=='Closed'): ?>
                                            <span class="badge bg-success">
                                        <?php elseif($job->status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                            <?php echo e($job->status); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Training : </td>
                                    <td>
                                        <?php if($job->training_status=='Waiting'): ?>
                                            <span class="badge bg-warning text-dark">
                                        <?php elseif($job->training_status=='On Going'): ?>
                                            <span class="badge bg-primary">
                                        <?php elseif($job->training_status=='Completed'): ?>
                                            <span class="badge bg-success">
                                        <?php elseif($job->training_status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                        <?php echo e($job->training_status); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Certificate : </td>
                                    <td>
                                        <?php if($job->certificate_status=='Waiting'): ?>
                                            <span class="badge bg-warning text-dark">
                                        <?php elseif($job->certificate_status=='On Going'): ?>
                                            <span class="badge bg-primary">
                                        <?php elseif($job->certificate_status=='Completed'): ?>
                                            <span class="badge bg-success">
                                        <?php elseif($job->certificate_status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                            <?php echo e($job->certificate_status); ?></span>
                                    </td>
                                </tr>
                            </table>
                            
                                
                        </td>

                        <td>
                            <table>
                                <tr>
                                    <td>Invoice :</td>
                                    <td>
                                        <?php if($job->invoice_date): ?>
                                            #<?php echo e($job->invoice_no); ?>

                                        <?php endif; ?>
                                         <br>
                                        <?php if($job->invoice_date): ?>
                                            <i class="bi bi-calendar3"></i> : <?php echo e($job->invoice_date); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice Status:</td>
                                    <td>
                                        <?php if($job->invoice_status=='Waiting'): ?>
                                            <span class="badge bg-warning text-dark">
                                        <?php elseif($job->invoice_status=='On Going'): ?>
                                            <span class="badge bg-primary">
                                        <?php elseif($job->invoice_status=='Completed'): ?>
                                            <span class="badge bg-success">
                                        <?php elseif($job->invoice_status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                            <?php echo e($job->invoice_status); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Delivery Note :</td>
                                    <td>
                                        <?php if($job->delivery_note_status=='Waiting'): ?>
                                            <span class="badge bg-warning text-dark">
                                        <?php elseif($job->delivery_note_status=='On Going'): ?>
                                            <span class="badge bg-primary">
                                        <?php elseif($job->delivery_note_status=='Completed'): ?>
                                            <span class="badge bg-success">
                                        <?php elseif($job->delivery_note_status=='Cancelled'): ?>
                                            <span class="badge bg-danger">
                                        <?php else: ?>
                                            <span class="badge text-dark">
                                        <?php endif; ?>
                                            <?php echo e($job->delivery_note_status); ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Invoiced On :</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Due On :</td>
                                    <td><?php echo e($job->invoice_date); ?></td>
                                </tr>
                                <tr>
                                    <td>Due On :</td>
                                    <td><?php echo e($job->invoice_date); ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Status :</td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        
                        <td>
                            <button class="btn btn-sm btn-outline-warning text-dark"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changeStatusModal"
                                    onclick="openChangeStatusModal(
                                        <?php echo e($job->id); ?>,
                                        '<?php echo e($job->invoice_status); ?>',
                                        '<?php echo e($job->delivery_note_status); ?>',
                                        '<?php echo e($job->invoice_no); ?>',
                                        '<?php echo e($job->invoice_date); ?>',
                                        '<?php echo e($job->invoice_amount); ?>',
                                        '<?php echo e($job->invoice_due_date); ?>',
                                        '<?php echo e($job->payment_status); ?>',
                                        '<?php echo e($job->delivery_note_no); ?>'
                                    )">
                                <i class="bi bi-pencil"></i> Update Status
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_acc/index/table.blade.php ENDPATH**/ ?>