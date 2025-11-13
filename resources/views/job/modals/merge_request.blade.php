
<!-- Bootstrap 5 Modal -->
<div class="modal fade" id="mergeJobModal" tabindex="-1" aria-labelledby="mergeJobModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="mergeJobForm" method="POST" action="{{ route('jobrequest.merge') }}">
        @csrf
        <input type="hidden" name="job_request_id" id="merge_job_request_id">

        <div class="modal-header">
          <h5 class="modal-title" id="mergeJobModalLabel">Merge Job Request with Existing Work Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="work_order_id" class="form-label">Select Existing Work Order</label>
            <select name="work_order_id" id="work_order_id" class="form-select" required>
              <option value="" disabled selected>-- Choose Work Order --</option>
              @foreach($workOrders as $workOrder)
                <option value="{{ $workOrder->id }}">
                    #{{ $workOrder->id }} - {{ $workOrder->company_name_in_work_order }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="authorized_by" class="form-label">Authorized By</label>
            <input type="text" name="authorized_by" id="authorized_by" class="form-control" required>
          </div>

          <p class="text-muted small mb-0">
            ⚠️ This will attach all training and trainee requests from this Job Request to the selected Work Order.
          </p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Merge Now</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openMergeModal(jobRequestId) {
    document.getElementById('merge_job_request_id').value = jobRequestId;
    const modal = new bootstrap.Modal(document.getElementById('mergeJobModal'));
    modal.show();
}
</script>
