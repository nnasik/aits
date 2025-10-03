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
    function setJobRequestId(id) {
        document.getElementById('job_request_id').value = id;
    }
</script>

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