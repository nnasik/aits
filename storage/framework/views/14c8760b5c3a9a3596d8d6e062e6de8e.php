<!-- view.blade.php -->


<?php $__env->startSection('content'); ?>

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Quotation : AITS-<?php echo e($quotation->reference); ?> Rev: <?php echo e(str_pad($quotation->revision, 2,'0',
                    STR_PAD_LEFT)); ?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><?php echo e($quotation->reference); ?>:<?php echo e(str_pad($quotation->revision, 2,'0',
                        STR_PAD_LEFT)); ?></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('quotation.index')); ?>">Quotations</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <!-- HEADER DETAILS -->
    <?php echo $__env->make('quotations.view.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- ADD ROW BUTTON -->
    <div class="row mb-2 px-3">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-success" id="addRow">
                <i class="bi bi-plus-lg"></i> Row
            </button>
        </div>
    </div>
    <div class="row p-3">
        <form id="quotationForm" action="<?php echo e(route('quotation_rows.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="quotation_id" value="<?php echo e($quotation->id); ?>">

            <?php echo $__env->make('quotations.view.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row mt-2">
                <div class="col-6">
                    <!-- Trigger Button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#finalizeQuotationModal">
                        Finalize Quotation
                    </button>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#discountModal">
                        Change Discount
                    </button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
    <?php echo $__env->make('quotations.view.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<?php echo $__env->make('quotations.view.row_template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('quotations.modals.finalize_quotation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('quotations.modals.change_discount', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('quotations.view.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/view.blade.php ENDPATH**/ ?>