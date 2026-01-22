<!-- Modal -->
<div class="modal fade" id="addRow" tabindex="-1" aria-labelledby="addRowLabel" aria-hidden="true">
  <form action="<?php echo e(route('training.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="work_order_id" value="<?php echo e($job->id); ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRowLabel">Add Training</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          
          <!-- Training Courses Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Course</span>
            <select class="form-select" name="course_id" id="course_id" required>
              <option value="" selected disabled>Select Course</option>
              <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($course->id); ?>"><?php echo e($course->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <!-- Quantity -->
          <div class="input-group mb-3">
            <span class="input-group-text">Course Name</span>
            <input type="text" class="form-control" name="course_title_in_certificate" id="course_title_in_certificate" placeholder="Course Title in Certificate" required>
          </div>

          <!-- Quantity -->
          <div class="input-group mb-3">
            <span class="input-group-text">Company Name</span>
            <input type="text" class="form-control" name="company_name_in_certificate" value="<?php echo e($job->company_name_in_work_order); ?>" required>
          </div>

          <!-- Quantity -->
          <div class="input-group mb-3">
            <span class="input-group-text">Qty</span>
            <input type="number" class="form-control" name="qty" min="1" placeholder="Enter quantity" required>
          </div>

          <!-- Training Mode Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Training Mode</span>
            <select class="form-control" id="trainingMode" name="training_mode">
              <option selected="" disabled="" value="">Choose...</option>
              <option value="In-Class">In-Class</option>
              <option value="Online">Online</option>
              <option value="On-Site">On-Site</option>
            </select>
            <span class="input-group-text" id="basic-addon1">
              <input type="checkbox" name="zoom" id="">Schedule Zoom</span>

          </div>

          <!-- Scheduled Date -->
          <div class="input-group mb-3">
            <span class="input-group-text">Scheduled Date</span>
            <input type="date" class="form-control" name="scheduled_date" placeholder="Scheduled Date">
          </div>

          <!-- Shceduled Time -->
          <div class="input-group mb-3">
            <span class="input-group-text">Scheduled Time</span>
            <input type="time" class="form-control" name="scheduled_time" placeholder="Scheduled Time">
          </div>

          

          <!-- Remark -->
          <div class="input-group mb-3">
            <span class="input-group-text">Remark</span>
            <input type="text" class="form-control" name="remark" placeholder="Optional remark">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>

      </div>
    </div>
  </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('course_id');
    const titleInput = document.getElementById('course_title_in_certificate');

    courseSelect.addEventListener('change', function () {
        const selectedOption = courseSelect.options[courseSelect.selectedIndex];
        titleInput.value = selectedOption.text;
    });
});
</script><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/new_training.blade.php ENDPATH**/ ?>