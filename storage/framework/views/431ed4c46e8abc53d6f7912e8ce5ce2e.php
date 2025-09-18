

<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job Request</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Job Request</a></li>
          <li class="breadcrumb-item">All</li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo e($job_request->id); ?></li>
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
        <h3 class="text-center">Job Request - <?php echo e($job_request->id); ?></h3>
      </div>
    </div>

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request No</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->id); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->requester->name); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Requested Date</span>
          <input type="date" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->requested_on); ?>">
        </div>
      </div>
    </div>

    <!-- ROW-2 -->
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Client / Company</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->company->name); ?>" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Company Name in Job</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->company_name_in_work_order); ?>" readonly>
        </div>
      </div>
    </div>

    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Training Information</h3>
      </div>
    </div>
    <!-- Table -->

    <!-- ROW-6 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Training Mode</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->training_mode); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Training Date</span>
          <input type="date" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->requesting_date); ?>" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Training Time</span>
          <input type="time" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="<?php echo e($job_request->requesting_time); ?>">
        </div>
      </div>
    </div>

    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Trainings</h3>
      </div>
    </div>
    <!-- Table -->

    <!-- ROW-5 -->
    <div class="row">
      <div class="col-sm-12 text-end">
        <button type="button" class="btn btn-sm btn-success float-end" data-bs-toggle="modal" data-bs-target="#addRow">
          <i class="bi bi-plus-lg"></i> Training Requests
        </button>
      </div>
    </div>
    
    <?php echo $__env->make('job_request.view.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!--end::Container-->
  </div>
  <!--end::App Content-->
<?php echo $__env->make('job_request.modals.new_training', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/view.blade.php ENDPATH**/ ?>