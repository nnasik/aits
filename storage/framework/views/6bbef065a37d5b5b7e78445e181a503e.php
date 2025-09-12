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
                            <form action="<?php echo e(route('training.destroy',$training->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <input type="hidden" name="id" value="<?php echo e($training->id); ?>">
                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><a href="<?php echo e(route('training.show',$training->id)); ?>"><?php echo e($training->course->name); ?></a></td>
                        <td><?php echo e($training->quantity); ?></td>
                        <td><?php echo e($training->scheduled_date); ?> <?php echo e($training->scheduled_time); ?></td>
                        <td><?php echo e($training->training_mode); ?>

                            <br>
                            <?php if($training->training_mode=='Online' && $training->training_link): ?>
                                <button class="btn btn-sm btn-primary" onclick="copyZoomLink('<?php echo e($training->training_link); ?>')">
                                    <i class="bi bi-link-45deg"></i> Zoom Link
                                </button>
                            <?php endif; ?>
                            <!-- Button -->
                        </td>
                        <td><?php echo e($training->remarks); ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary disabled" data-bs-toggle="modal">
                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                            </a>

                            <a class="btn btn-sm btn-primary disabled">
                                <i class="bi bi-whatsapp"></i> Link
                            </a>
                        </td>
                        <td>
                            <div class="badge text-bg-warning"><?php echo e($training->status); ?></div>
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
function copyZoomLink(link) {
    if (navigator.clipboard && window.isSecureContext) {
        // ✅ Modern API
        navigator.clipboard.writeText(link).then(() => {
            alert("✅ Zoom link copied to clipboard!");
        }).catch(err => {
            alert("❌ Failed to copy: " + err);
        });
    } else {
        // ⚡ Fallback for older browsers or non-HTTPS
        let textArea = document.createElement("textarea");
        textArea.value = link;
        textArea.style.position = "fixed"; // avoid scrolling to bottom
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            alert("✅ Zoom link copied to clipboard!");
        } catch (err) {
            alert("❌ Failed to copy: " + err);
        }
        document.body.removeChild(textArea);
    }
}
</script>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view/table.blade.php ENDPATH**/ ?>