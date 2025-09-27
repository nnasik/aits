<!-- Cancel Request Modal -->
<div class="modal fade" id="cancelRequestModal" tabindex="-1" aria-labelledby="cancelRequestModalLabel" aria-hidden="true">
  <form action="<?php echo e(route('jobrequest.cencel',$job_request->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h1 class="modal-title fs-5" id="cancelRequestModalLabel">
            <i class="fas fa-times-circle"></i> Cancel Job Request
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="alert alert-warning">
            Are you sure you want to cancel this request?  
            Please provide a reason below:
          </div>

          <div class="mb-3">
            <label for="cancelReason" class="form-label">Reason</label>
            <textarea 
              class="form-control" 
              id="cancelReason" 
              name="reason" 
              rows="3" 
              placeholder="Reason for cancellation" 
              required
            ></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-times"></i> Cancel Request
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/modals/cancel_request.blade.php ENDPATH**/ ?>