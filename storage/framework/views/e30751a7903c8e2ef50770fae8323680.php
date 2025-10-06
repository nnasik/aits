<!-- Update Work Order Status Modal -->
<div class="modal fade" id="updateWorkOrderModal" tabindex="-1" aria-labelledby="updateWorkOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="updateWorkOrderModalLabel">Update Work Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="updateWorkOrderForm" method="POST" action="<?php echo e(route('job.update-status')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="work_order_id" id="work_order_id">

        <div class="modal-body">
          <div class="mb-3">
            <label for="training_status" class="form-label">Training Status</label>
            <select name="training_status" id="training_status" class="form-select">
              <option value="Waiting">Waiting</option>
              <option value="On Going">On Going</option>
              <option value="Completed">Completed</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="certificate_status" class="form-label">Certificate Status</label>
            <select name="certificate_status" id="certificate_status" class="form-select">
              <option value="Waiting">Waiting</option>
              <option value="On Going">On Going</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  function openUpdateWorkOrderModal(workOrder) {
    document.getElementById('work_order_id').value = workOrder.id;
    document.getElementById('training_status').value = workOrder.training_status ?? 'Waiting';
    document.getElementById('certificate_status').value = workOrder.certificate_status ?? 'Waiting';
    
    new bootstrap.Modal(document.getElementById('updateWorkOrderModal')).show();
  }
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/change_status.blade.php ENDPATH**/ ?>