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
                                  - <a href="http://"><?php echo e($training->course_title_in_certificate); ?>

                                    (<?php echo e($training->quantity); ?>)</a>
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
                            <?php echo $__env->make('job_acc.partials.invoice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </td>
                        <td>


                            <br>
                            <?php if($job->delivery_note_no): ?>
                            <i class="bi bi-hash"></i> <?php echo e($job->delivery_note_no); ?>

                            <?php endif; ?>
                            <br>
                            <?php if($job->delivery_note_no): ?>
                            <i class="bi bi-file-earmark-text"></i> Delivery Note
                            <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </table>
                        </td>
                        <td>
                            <table>


                                <tr>
                                    <td>Due On :</td>
                                    <td><?php echo e($job->invoice_date); ?></td>
                                </tr>
                                <tr>
                                    <td>Due On :</td>
                                    <td><?php echo e($job->invoice_due_date); ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Status :</td>
                                    <td>
                                        <?php if($job->payment_status=='Unpaid'): ?>
                                        <span class="badge bg-danger">
                                            <?php elseif($job->payment_status=='Paid'): ?>
                                            <span class="badge bg-success">
                                                <?php elseif($job->payment_statuss=='partial'): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <?php else: ?>
                                                    <span class="badge text-dark">
                                                        <?php endif; ?>
                                                        <?php echo e($job->payment_status); ?>

                                                    </span>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-warning text-dark" data-bs-toggle="modal"
                                data-bs-target="#changeStatusModal" onclick="openChangeStatusModal(
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
                            <br>

                            <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#uploadFileModal" onclick="setWorkOrderId(<?php echo e($job->id); ?>)">
                                <i class="bi bi-cloud-arrow-up"></i> Upload File
                            </button>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="bg-light">
                            <a class="btn btn-sm btn-outline-success mb-2 me-2 d-inline-flex align-items-center"
                                target="_blank" href="<?php echo e(route('job.pdf',$job->id)); ?>">
                                <i class="bi bi-file-earmark-pdf"></i>  Work Permit
                            </a>

                            <?php $__currentLoopData = $job->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $exists = Storage::disk($file->storage_disk)->exists($file->path);

                            $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));

                            $icon = match($extension) {
                            'pdf' => 'bi-file-earmark-pdf',
                            'doc', 'docx' => 'bi-file-earmark-word',
                            'xls', 'xlsx' => 'bi-file-earmark-excel',
                            'png', 'jpg', 'jpeg', 'gif', 'webp' => 'bi-file-earmark-image',
                            'txt' => 'bi-file-earmark-text',
                            default => 'bi-file-earmark'
                            };

                            $url = $exists ? Storage::disk($file->storage_disk)->url($file->path) : '#';
                            ?>

                            <a href="<?php echo e($url); ?>" target="_blank"
                                class="btn btn-outline-primary btn-sm mb-2 me-2 d-inline-flex align-items-center"
                                <?php if(!$exists): ?> disabled <?php endif; ?>>
                                <i class="bi <?php echo e($icon); ?> me-2"></i>
                                <?php echo e($file->document_type); ?>

                            </a>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                    </tr>


                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($jobs->links()); ?>

            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_acc/index/table.blade.php ENDPATH**/ ?>