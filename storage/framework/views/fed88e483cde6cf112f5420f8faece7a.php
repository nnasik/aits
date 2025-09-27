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
                        <th scope="col">Requested On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $job_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($request->id); ?></td>
                        <td><?php echo e($request->company->name); ?></td>
                        <td><?php echo e($request->quantity); ?>0</td>
                        <td><span class="badge text-bg-warning"><?php echo e($request->request_status); ?></span></td>
                        <td><?php echo e($request->requested_on); ?></td>
                        <td>
                            <!-- View Button -->
                            <a href="" class="btn btn-primary btn-sm" title="View">
                                <i class="bi bi-eye"></i> View
                            </a>

                            <!-- Accept Button -->
                            <a href="" class="btn btn-success btn-sm" title="Accept">
                                <i class="bi bi-check-circle"></i> Accept
                            </a>

                            <!-- Reject Button -->
                            <a href="" class="btn btn-danger btn-sm" title="Reject">
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