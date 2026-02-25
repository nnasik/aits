<?php if($job->invoice_status=='Waiting'): ?>
<div class="card card-warning text-dark">
    <?php elseif($job->invoice_status=='On Going'): ?>
    <div class="card card-primary">
        <?php elseif($job->invoice_status=='Completed'): ?>
        <div class="card card-success">
            <?php elseif($job->invoice_status=='.'): ?>
            <div class="card card-danger">
                <?php else: ?>
                <div class="card card-dark">
                    <?php endif; ?>
                    <div class="card-header p-2">
                        <div class="col">
                            <h5 class="card-title">Invoice :<span class="badge ">(<?php echo e($job->invoice_status); ?>)</span></h5>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-2">
                        <table>
                            <?php if($job->invoice_no): ?>
                            <tr>
                                <td>Invoice No </td>
                                <td>: <?php echo e($job->invoice_no); ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if($job->invoice_date): ?>
                            <tr>
                                <td>Invoice Date</td>
                                <td>: <?php echo e($job->invoice_date); ?></td>
                            </tr>
                            <?php endif; ?>

                            <tr>
                                <td>
                                    Files
                                </td>
                                <td>
                                    :
                                    <?php $__currentLoopData = $job->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($file->document_type !== 'Invoice'): ?>
                                    <?php continue; ?>
                                    <?php endif; ?>

                                    <?php
                                    // File existence
                                    $exists = Storage::disk($file->storage_disk)->exists($file->path);

                                    // Detect icon
                                    $extension = strtolower(pathinfo($file->original_name,
                                    PATHINFO_EXTENSION));
                                    $icon = match($extension) {
                                    'pdf' => 'bi-file-earmark-pdf',
                                    'doc', 'docx' => 'bi-file-earmark-word',
                                    'xls', 'xlsx' => 'bi-file-earmark-excel',
                                    'png', 'jpg', 'jpeg', 'gif', 'webp' => 'bi-file-earmark-image',
                                    'txt' => 'bi-file-earmark-text',
                                    default => 'bi-file-earmark'
                                    };

                                    // File URL
                                    $url = $exists ?
                                    Storage::disk($file->storage_disk)->url($file->path) : '#';

                                    // Tooltip (description)
                                    $tooltip = $file->description ? e($file->description) : '';
                                    ?>

                                    <a href="<?php echo e($url); ?>" target="_blank"
                                        class="btn btn-outline-dark btn-sm d-inline-flex align-items-center ml-2 px-1 py-0"
                                        <?php if(!$exists): ?> disabled <?php endif; ?> <?php if($tooltip): ?> data-bs-toggle="tooltip"
                                        title="<?php echo e($tooltip); ?>" <?php endif; ?>>
                                        <i class="bi <?php echo e($icon); ?> me-2"></i>
                                        Invoice
                                    </a>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>

                            </tr>

                        </table>
                        <br>
                    </div>
                    <!-- /.card-body -->
                </div>
                <table>
                    <tr class="border-top">
                        <td>Delivery Note :
                            <br>
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
                                                <?php echo e($job->delivery_note_status); ?></span><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_acc/partials/invoice.blade.php ENDPATH**/ ?>