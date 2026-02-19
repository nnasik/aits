<?php $__currentLoopData = $quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-4">
     
    <?php if($quotation->status=='Draft'): ?>
        <div class="card card-outline card-warning">
    <?php elseif($quotation->status=='Finalized'): ?>
        <div class="card card-outline card-primary">
    <?php else: ?>
        <div class="card card-outline card-dark">
    <?php endif; ?>
        <div class="card-header">
        <h3 class="card-title"> 
            <?php echo e($quotation->company_name); ?> : <i class="text-muted">AITS-<?php echo e($quotation->reference); ?></i></h3>
        <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <p>
                The body of the card
            </p>
            <div class="row">
                <div class="col">
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="row text-end">
                <div class="col">
                    
                    <?php if($quotation->status=='Draft'): ?>
                        <button class="btn btn-sm btn-success disabled">
                            <i class="bi bi-plus"></i> Revision
                        </button>
                        <a class="btn btn-sm btn-warning" href="<?php echo e(route('quotation.show',$quotation->id)); ?>">
                            <i class="bi bi-pencil-square"></i> Edit</a>
                        <button class="btn btn-sm btn-primary disabled">
                            <i class="bi bi-download"></i> Download
                        </button>
                    <?php elseif($quotation->status=='Finalized'): ?>
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-plus"></i> Revision
                        </button>
                        <a class="btn btn-sm btn-warning disabled">
                            <i class="bi bi-pencil-square"></i> Edit</a>
                        <a class="btn btn-sm btn-primary" href="<?php echo e(route('quotation.pdf.00',$quotation->id)); ?>">
                            <i class="bi bi-download"></i> Download</a>
                    <?php else: ?>
                        
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        
    </div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/index/quotations.blade.php ENDPATH**/ ?>