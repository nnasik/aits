<!-- index.blade.php -->


<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Quotations</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item" aria-current="page">All</li>
            <li class="breadcrumb-item">Quotations</li>
        </ol>
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <h5 class="mb-0">Qutations by <?php echo e(auth::user()->name); ?></h5>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#quotationModal">
          <i class="bi bi-plus-lg"></i> Quotation
        </button>
      </div>
    </div>
    <!--end::Row-->
    <div class="row mt-3">
      <?php echo $__env->make('quotations.index.quotations', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  </div>
  
  <?php echo $__env->make('quotations.modals.new_quotation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/index.blade.php ENDPATH**/ ?>