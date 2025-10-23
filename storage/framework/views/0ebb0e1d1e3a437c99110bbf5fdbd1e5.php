<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" role="table">
                <thead>
                    <tr class="text-center">
                        <th>Certificate No</th>
                        <th>Job No</th>
                        <th>Candidate Name</th>
                        <th>Training Course</th>
                        <th>Issued Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($certificate->id); ?></td>
                        <td><?php echo e($certificate->trainee->training->job->id); ?></td>
                        <td><strong><?php echo e($certificate->candidate_name_in_certificate); ?></strong>
                            <br>
                            <?php echo e($certificate->company_name_in_certificate); ?>

                            <br>
                            <?php echo e($certificate->company_location); ?>

                        </td>
                        <td><?php echo e($certificate->course_name_in_certificate); ?></td>
                        <td><?php echo e($certificate->date); ?></td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Certificate :
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary" target="_blank" href="<?php echo e(route('certificate.pdf.v1',$certificate->id)); ?>">V1</a>
                                        <button class="btn btn-outline-primary">V2</button>
                                        <button class="btn btn-outline-primary">V3</button>
                                        <button class="btn btn-outline-primary">V4</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Card :
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary">V1</button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/certificate/index/certificate_table.blade.php ENDPATH**/ ?>