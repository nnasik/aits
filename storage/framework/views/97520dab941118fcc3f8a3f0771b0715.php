<!-- Certificate Date Modal -->
<div class="modal fade" id="editCertificateDateModal" tabindex="-1" aria-labelledby="editCertificateDateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCertificateDateModalLabel">Edit Certificate Date</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?php echo e(route('trainee.updateCertificateDate')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="trainee_id" id="certificateDateTraineeId">
        <div class="modal-body">
          <label for="certificate_date" class="form-label">Certificate Date</label>
          <input type="date" class="form-control" name="certificate_date" id="certificateDateInput">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    function changeCertificateDate(id, date) {
    document.getElementById('certificateDateTraineeId').value = id;
    document.getElementById('certificateDateInput').value = date || '';
}

</script><?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/change_date.blade.php ENDPATH**/ ?>