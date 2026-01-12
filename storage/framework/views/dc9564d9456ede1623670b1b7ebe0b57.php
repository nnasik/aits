<!-- index.blade.php -->


<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Trainings</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item" aria-current="page">No Jobs</li>
            <li class="breadcrumb-item">Trainings</li>
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
        <h5 class="mb-0">Trainings (Without Jobs)</h5>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createTrainingModal">
          <i class="bi bi-plus-lg"></i> Training
        </button>
      </div>
    </div>
    <!--end::Row-->
    <div class="row mt-3">
      <?php echo $__env->make('trainings.index.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  </div>
  <?php echo $__env->make('trainings.modals.new_training', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('trainings.modals.link_to_job', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/trainings/withoutjob.blade.php ENDPATH**/ ?>