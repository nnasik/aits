<!-- Change Name Modal -->
<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNameModalLabel">Change Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="nameForm" action="<?php echo e(route('training-requests.updateName')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="trainee_request_id">
          <div class="mb-3">
            <label for="changeNameInput" class="form-label">Name</label>
            <input type="text" class="form-control" id="changeNameInput" name="trainee_name" placeholder="Enter Name">
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
  function changeName(id) {
    document.querySelector('#nameForm input[name="trainee_request_id"]').value = id;
  }
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/change_name.blade.php ENDPATH**/ ?>