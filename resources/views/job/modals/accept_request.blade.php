<!-- Modal -->
<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('job-request.accept') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="acceptModalLabel">Accept Job Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">

          <!-- Hidden field for job_request_id -->
          <input type="hidden" name="job_request_id" id="job_request_id" value="">
          <script>
              function setJobRequestId(jobRequestId, jobNo = '') {
                  document.getElementById('job_request_id').value = jobRequestId;
                  document.getElementById('job_no').value = jobNo || ''; // prefill if available
              }
          </script>

          <!-- Job No (work_orders.id) -->
          <div class="mb-3">
            <label for="job_no" class="form-label">Job No</label>
            <input type="text" name="job_no" id="job_no" class="form-control" placeholder="Enter Job No" required>
          </div>

          <!-- Dropdown for authorized_by (users) -->
          <div class="mb-3">
            <label for="authorized_by" class="form-label">Authorized By</label>
            <select name="authorized_by" id="authorized_by" class="form-select" required>
              <option value="">-- Select User --</option>
              @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Accept</button>
        </div>
      </form>
    </div>
  </div>
</div>
