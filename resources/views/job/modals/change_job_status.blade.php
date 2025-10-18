<!-- Job Status Modal -->
<div class="modal fade" id="jobStatusModal" tabindex="-1" aria-labelledby="jobStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('job.updateJobStatus') }}">
      @csrf
      <input type="hidden" name="job_id" id="job_status_update_job_id">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="jobStatusModalLabel">Update Job Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="job_status_update_status" class="form-label">Job Status</label>
            <select name="status" id="job_status_update_status" class="form-select" required>
              <option value="Open">Open</option>
              <option value="Closed">Closed</option>
              <option value="Cancelled">Cancelled</option>
              <option value="On Hold">On Hold</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
function openJobStatusModal(job) {
  document.getElementById('job_status_update_job_id').value = job.id;
  document.getElementById('job_status_update_status').value = job.status;
  const modal = new bootstrap.Modal(document.getElementById('jobStatusModal'));
  modal.show();
}
</script>
