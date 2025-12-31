

<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job - <?php echo e($job->id); ?></h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item active" aria-current="page">Job - <?php echo e($job->id); ?></li>
          <li class="breadcrumb-item"><a href="<?php echo e(route('job.index')); ?>">Jobs (All)</a></li>
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
    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Training Work Permit</h3>
      </div>
    </div>

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Job No</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job->id); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Date</span>
          <input type="date" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="<?php echo e($job->date); ?>">
        </div>
      </div>
    </div>

    <!-- ROW-2 -->
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Client / Company</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job->company->name); ?>" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Issued By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job->issued->name); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Authorized By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job->authorized->name); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Sales By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job->sales->name); ?>" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-6">
        <a class="btn btn-dark" target="_blank" href="<?php echo e(route('job.pdf',$job->id)); ?>">
          <i class="bi bi-file-earmark-pdf-fill"></i> Work Permit
        </a>
      </div>
      <div class="col-sm-6 text-end">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#addRow">
          <i class="bi bi-plus-lg"></i> Training
        </button>
      </div>
    </div>



    <!-- Table -->
    <?php echo $__env->make('job.view.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!--end::Container-->
  </div>
  <!--end::App Content-->
  <?php echo $__env->make('job.modals.new_training', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view.blade.php ENDPATH**/ ?>