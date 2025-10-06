<!-- Edit Training Trainee Modal -->
<div class="modal fade" id="editTraineeModal" tabindex="-1" aria-labelledby="editTraineeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="editTraineeModalLabel">Edit Trainee Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editTraineeForm" method="POST" action="<?php echo e(route('trainee.update')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="trainee_id" id="trainee_id">

        <div class="modal-body row g-3">

          <div class="col-md-6">
            <label class="form-label">Candidate Name</label>
            <input type="text" class="form-control" name="candidate_name_in_certificate" id="candidate_name_in_certificate">
          </div>

          <div class="col-md-6">
            <label class="form-label">Company Name</label>
            <input type="text" class="form-control bg-light" id="company_name_in_certificate" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Course Name</label>
            <input type="text" class="form-control bg-light" id="course_name_in_certificate" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Live Photo</label>
            <input type="file" class="form-control" name="live_photo" id="live_photo" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted" id="live_photo_note"></small>
          </div>

          <div class="col-md-6">
            <label class="form-label">EID No</label>
            <input type="text" class="form-control" name="eid_no" id="eid_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="date" id="date">
          </div>

          <div class="col-md-6">
            <label class="form-label">Passport No</label>
            <input type="text" class="form-control" name="passport_no" id="passport_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL No</label>
            <input type="text" class="form-control" name="dl_no" id="dl_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL Issued</label>
            <input type="date" class="form-control" name="dl_issued" id="dl_issued">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL Expiry</label>
            <input type="date" class="form-control" name="dl_expiry" id="dl_expiry">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script>
  function openEditTraineeModal(data) {
    document.getElementById('trainee_id').value = data.id;
    document.getElementById('candidate_name_in_certificate').value = data.candidate_name_in_certificate ?? '';
    document.getElementById('company_name_in_certificate').value = data.company_name_in_certificate ?? '';
    document.getElementById('course_name_in_certificate').value = data.course_name_in_certificate ?? '';
    
    // Show file info if already uploaded
    if (data.live_photo) {
      document.getElementById('live_photo_note').innerHTML = `Current: <a href="/storage/${data.live_photo}" target="_blank">View File</a>`;
    } else {
      document.getElementById('live_photo_note').innerHTML = '';
    }

    document.getElementById('eid_no').value = data.eid_no ?? '';
    document.getElementById('date').value = data.date ?? '';
    document.getElementById('passport_no').value = data.passport_no ?? '';
    document.getElementById('dl_no').value = data.dl_no ?? '';
    document.getElementById('dl_issued').value = data.dl_issued ?? '';
    document.getElementById('dl_expiry').value = data.dl_expiry ?? '';

    new bootstrap.Modal(document.getElementById('editTraineeModal')).show();
  }
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/edit_trainee.blade.php ENDPATH**/ ?>