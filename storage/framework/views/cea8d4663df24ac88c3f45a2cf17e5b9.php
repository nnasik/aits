<!-- Create Training Modal -->
<div class="modal fade" id="createTrainingModal" tabindex="-1" aria-labelledby="createTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="<?php echo e(route('training.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="createTrainingModalLabel">Create Training</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Training Course (required, searchable dropdown) -->
                        <div class="col-md-12">
                            <label class="form-label">Training Course <span class="text-danger">*</span></label>
                            <select name="training_course_id" class="form-select select2" required>
                                
                                <option value="">Select Training Course</option>
                                <?php $__currentLoopData = $trainingCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Course Title in Certificate (nullable) -->
                        <div class="col-md-12">
                            <label class="form-label">Course Title (Certificate)</label>
                            <input type="text" name="course_title_in_certificate" class="form-control">
                        </div>

                        <!-- Training Mode (required) -->
                        <div class="col-md-3">
                            <label class="form-label">Training Mode <span class="text-danger">*</span></label>
                            <select name="training_mode" class="form-select" required>
                                <option value="">Select Mode</option>
                                <option value="Online">Online</option>
                                <option value="Onsite">Onsite</option>
                                <option value="In-Class">In-Class</option>
                            </select>
                        </div>

                        <!-- Scheduled Date (required) -->
                        <div class="col-md-3">
                            <label class="form-label">Scheduled Date <span class="text-danger">*</span></label>
                            <input type="date" name="scheduled_date" class="form-control" required>
                        </div>

                        <!-- Scheduled Time (required) -->
                        <div class="col-md-3">
                            <label class="form-label">Scheduled Time <span class="text-danger">*</span></label>
                            <input type="time" name="scheduled_time" class="form-control" required>
                        </div>

                        <!-- Quantity (required) -->
                        <div class="col-md-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="qty" class="form-control" min="1" required>
                        </div>

                        <!-- Remarks (nullable textarea) -->
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Training</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trainingCourseSelect = document.querySelector('select[name="training_course_id"]');
    const courseTitleInput = document.querySelector('input[name="course_title_in_certificate"]');

    trainingCourseSelect.addEventListener('change', function() {
        const selectedOption = trainingCourseSelect.options[trainingCourseSelect.selectedIndex];
        if (selectedOption.value) {
            courseTitleInput.value = selectedOption.text;
        } else {
            courseTitleInput.value = '';
        }
    });
});
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/trainings/modals/new_training.blade.php ENDPATH**/ ?>