<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Jobs</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Jobs</a></li>
          <li class="breadcrumb-item active" aria-current="page">All</li>
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
    <div class="row my-3 px-2">
      <div class="col-md-12">
          <form action="<?php echo e(route('job-acc.index')); ?>">
            <?php echo csrf_field(); ?>
            <div class="input-group">
              <input type="search" class="form-control form-control-lg" placeholder="Job No | Company Name"
                name="search" <?php if(isset($search)): ?> value="<?php echo e($search); ?>" <?php endif; ?>>
              <div class="input-group-append">
                <button type="submit" class="btn btn-outline-dark btn-lg btn-default">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
    </div>
    <?php echo $__env->make('job_acc.index.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  <?php echo $__env->make('job_acc.modal.change_status', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('job.modals.add_files', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_acc/index.blade.php ENDPATH**/ ?>