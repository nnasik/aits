<div class="row mt-3 m-1">
    <div class="card mb-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped" role="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Item No</th>
                        <th scope="col">Training Course</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Scheduled Date & Time</th>
                        <th scope="col">Mode</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Attendance</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $job->trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <form action="<?php echo e(route('training.unlink')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="training_id" value="<?php echo e($training->id); ?>">
                                <button class="btn btn-sm btn-danger" type="submit"><i
                                        class="bi bi-dash-circle"></i></button>
                            </form>
                        </td>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><a href="<?php echo e(route('training.show',$training->id)); ?>"><?php echo e($training->course->name); ?></a> <br>
                            as <i><?php echo e($training->course_title_in_certificate); ?> </i> - (Training ID : <?php echo e($training->id); ?>)
                        </td>
                        <td><?php echo e($training->quantity); ?> (<?php echo e($training->trainees->count()); ?>)</td>
                        <td><?php echo e($training->scheduled_date); ?> <?php echo e($training->scheduled_time); ?></td>
                        <td><?php echo e($training->training_mode); ?></td>
                        <td><?php echo e($training->remarks); ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="javascript:void(0);"
                                data-link="<?php echo e(route('public.training.show', $training->hash)); ?>"
                                onclick="copyTrainingLink(this)">
                                <i class="bi bi-copy"></i> Link
                            </a>
                        </td>
                        <td>
                            <div class="badge text-bg-warning"><?php echo e($training->status); ?></div>
                            <?php echo e(isset($training->job)); ?>

                            <?php if(!isset($training->job)): ?>
                            <form action="" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="training_id" value="<?php echo e($training->id); ?>">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th><?php echo e($job->trainings->sum('quantity')); ?></th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Script -->
    <script>
        function copyTrainingLink(el) {
            const link = el.getAttribute('data-link');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(link)
                    .then(() => alert('Link copied to clipboard'))
                    .catch(() => alert('Failed to copy link'));
                return;
            }

            const textarea = document.createElement('textarea');
            textarea.value = link;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            alert('Link copied to clipboard');
        }
    </script>

</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view/table.blade.php ENDPATH**/ ?>