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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Certificate :
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary">V1</button>
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