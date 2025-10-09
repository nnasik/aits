<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Jobs Dashboard</h3>
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

    
    

    <div class="row">
      <div class="col-6">
        <h3 class="mb-0">New Requests</h3>
      </div>
    </div>

    <?php echo $__env->make('job.index.table_request', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!--begin::Row-->
    <div class="row mx-0">
      <div class="col-6">
        <h3 class="mb-0">Jobs</h3>
      </div>
      <!-- <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="bi bi-plus-lg"></i> Job
        </button>
      </div> -->
</div>

<script>
    /**
     * Opens the Update Work Order Status modal and populates fields
     * @param {Object} workOrder - The work order object containing id and current statuses
     */
    function openUpdateWorkOrderModal(workOrder) {
        // Set hidden input
        document.getElementById('work_order_id').value = workOrder.id;

        // Set dropdown values
        document.getElementById('training_status').value = workOrder.training_status ?? 'Waiting';
        document.getElementById('certificate_status').value = workOrder.certificate_status ?? 'Waiting';

        // Show modal
        new bootstrap.Modal(document.getElementById('updateWorkOrderModal')).show();
    }
</script>


    <?php echo $__env->make('job.index.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  <?php echo $__env->make('job.modals.new_job', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('job.modals.accept_request', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('job.modals.change_status', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/index.blade.php ENDPATH**/ ?>