<!-- Finalize Quotation Modal -->
<div class="modal fade" id="finalizeQuotationModal" tabindex="-1">
    <div class="modal-dialog">
         
        <form method="POST" action="<?php echo e(route('quotation.finalize')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="quotation_id" value="<?php echo e($quotation->id); ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Finalize Quotation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="fw-semibold text-danger">
                        Are you sure you want to finalize this quotation?
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Select Terms & Conditions</label>
                        <select name="tnc_id" class="form-select" required>
                            <option value="" disabled selected>-- Select T&C --</option>
                            <?php $__currentLoopData = $TnCs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tnc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tnc->id); ?>"><?php echo e($tnc->document_no .":". $tnc->rev_no ."-". $tnc->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        No, Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Yes, Finalize Quotation
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/modals/finalize_quotation.blade.php ENDPATH**/ ?>