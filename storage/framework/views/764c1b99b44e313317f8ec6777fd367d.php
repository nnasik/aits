<!-- Change EID Modal -->
<div class="modal fade" id="editEidModal" tabindex="-1" aria-labelledby="editEidModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEidModalLabel">Change EID</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="eidForm" action="<?php echo e(route('trainingrequest.updateEid')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="trainee_request_id">
          <div class="mb-3">
            <label for="changeEidInput" class="form-label">EID</label>
            <input type="text" class="form-control" id="changeEidInput" name="eid_no" placeholder="Enter EID">
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function changeIDinEID(id) {
    document.querySelector('#eidForm input[name="trainee_request_id"]').value = id;
  }
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/change_eid.blade.php ENDPATH**/ ?>