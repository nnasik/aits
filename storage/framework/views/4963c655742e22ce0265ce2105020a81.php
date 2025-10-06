

<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job Information</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Jobs</a></li>
          <li class="breadcrumb-item">All</li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo e($job->id); ?></li>
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

    <!-- ROW-4 -->
    <div class="row">
      <div class="col-sm-12">
        <h3 class="">Training Information</h3>
      </div>
    </div>

    <!-- ROW-5 -->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="">Trainee Information</h3>
      </div>
      <div class="col-sm-6 text-end">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#addTrainee">
          <i class="bi bi-plus-lg"></i> Trainee
        </button>
      </div>
    </div>

    <!-- Table -->
    <?php echo $__env->make('job.view.trainee_table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <!-- ROW-5 -->
    <div class="row">
      <div class="col-sm-12">
        <a class="btn btn-dark" href="<?php echo e(route('attendance.pdf',$training->id)); ?>" target="_blank">
          <i class="bi bi-file-earmark-pdf-fill"></i> Attendance Sheet
        </a>
        <a class="btn btn-primary" href="<?php echo e(route('public.training.show',$training->hash)); ?>">
          <i class="bi bi-whatsapp"></i> Attendance Link
        </a>
      </div>
    </div>

    <!--end::Container-->
  </div>
  <!--end::App Content-->
  <?php echo $__env->make('job.modals.add_trainee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('trainee.modals.new_trainee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('job.modals.edit_trainee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/view_training.blade.php ENDPATH**/ ?>