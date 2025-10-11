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
                        <td class="text-start">
                            <?php if($request->request_status=='Requested'): ?>
                            <span class="badge bg-warning text-dark">Awaiting</span>
                            <?php elseif($request->request_status=='Accepted'): ?>
                            <?php if($request->job->status=='Open'): ?>
                            <i class="bi bi-briefcase-fill text-dark"></i> : <span class="badge bg-primary">
                                <?php echo e($request->job->status); ?>

                            </span>
                            <br>
                            <i class="bi bi-file-earmark-ruled-fill text-dark"></i> : <span class="badge bg-dark">
                                <?php echo e($request->job->id); ?>

                            </span>
                            <br>
                            <i class="bi bi-person-fill"></i> : <span
                                class="badge bg-dark"><?php echo e($request->job->issued->name); ?></span>
                            <br>
                            <i class="bi bi-clock-fill"></i> : <span
                                class="badge bg-dark"><?php echo e($request->job->updated_at); ?></span>
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
                            <?php elseif($request->job->training_status=='On Going'): ?>
                            <span class="badge bg-primary"><?php echo e($request->job->training_status); ?></span>
                            <?php elseif($request->job->training_status=='Cancelled'): ?>
                            <span class="badge bg-danger"><?php echo e($request->job->training_status); ?></span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($request->request_status=='Requested'): ?>
                            <span class="badge bg-warning text-dark">Awaiting</span>
                            <?php elseif($request->request_status=='Accepted'): ?>
                            <?php if($request->job->certificate_status=='Waiting'): ?>
                            <span class="badge bg-warning text-dark"><?php echo e($request->job->certificate_status); ?></span>
                            <?php elseif($request->job->certificate_status=='On Going'): ?>
                            <span class="badge bg-primary"><?php echo e($request->job->certificate_status); ?></span>
                            <?php elseif($request->job->certificate_status=='Completed'): ?>
                            <span class="badge bg-success"><?php echo e($request->job->certificate_status); ?></span>
                            <?php elseif($request->job->certificate_status=='Cancelled'): ?>
                            <span class="badge bg-danger"><?php echo e($request->job->certificate_status); ?></span>
                            <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        <td>
                            <?php if($request->request_status=='Requested'): ?>
                            Invoice : <span class="badge bg-warning text-dark">Waiting</span>
                            <br>
                            Delivery Note : <span class="badge bg-warning text-dark">Waiting</span>
                            <?php elseif($request->request_status=='Accepted'): ?>
                            <?php if($request->job->invoice_status=='Waiting'): ?>
                            Invoice : <span class="badge bg-warning text-dark"><?php echo e($request->job->invoice_status); ?></span>
                            <br>
                            Delivery Note : <span
                                class="badge bg-warning text-dark"><?php echo e($request->job->delivery_note_status); ?></span>
                            <?php elseif($request->job->invoice_status=='Completed'): ?>
                            Invoice : <span class="badge bg-success"><?php echo e($request->job->invoice_status); ?></span>
                            <br>
                            Delivery Note : <span
                                class="badge bg-success"><?php echo e($request->job->delivery_note_status); ?></span>
                            <?php elseif($request->job->certificate_status=='Cancelled'): ?>
                            Invoice : <span class="badge bg-danger"><?php echo e($request->job->invoice_status); ?></span>
                            <br>
                            Delivery Note : <span class="badge bg-danger"><?php echo e($request->job->delivery_note_status); ?></span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">


                            <div class="dropdown">
                                <a class="btn btn-primary" href="<?php echo e(route('jobrequest.show',$request->id)); ?>"><i
                                        class="bi bi-eye-fill"></i></a>
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="openDuplicateModal(
                                                '<?php echo e($request->id); ?>',
                                                '<?php echo e($request->priority); ?>',
                                                '<?php echo e($request->company_id); ?>',
                                                '<?php echo e($request->company_name_in_work_order); ?>',
                                                '<?php echo e($request->training_mode); ?>',
                                                <?php echo e($request->is_zoom_link_required ? 'true' : 'false'); ?>

                                            )">
                                            Duplicate
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </td>
                    </tr>
                    <tr>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/index/table.blade.php ENDPATH**/ ?>