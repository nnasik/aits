<!-- Duplicate Training Modal -->
<div class="modal fade" id="duplicateTraining" tabindex="-1" aria-labelledby="duplicateTrainingLabel" aria-hidden="true">
  <form action="{{ route('trainingrequests.duplicate') }}" method="POST">
    @csrf
    <!-- Hidden Fields -->
    <input type="hidden" name="work_order_id" value="{{ $job_request->id }}">
    <input type="hidden" name="training_request_id" id="duplicate_training_request_id">

    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="duplicateTrainingLabel">Duplicate Training Request</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Course Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Course</span>
            <select class="form-select" name="course_id" id="duplicate-courseSelect" required>
              <option value="" selected disabled>Select Course</option>
              @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Certificate Title -->
          <div class="input-group mb-3">
            <span class="input-group-text">Certificate Title</span>
            <input type="text" class="form-control" name="course_title_in_certificate" id="duplicate-certificateTitle"
                   placeholder="Course name in certificate" required>
          </div>

          <!-- Company Name in Certificate -->
          <div class="input-group mb-3">
            <span class="input-group-text">Certificate For</span>
            <input type="text" class="form-control" name="company_name_in_certificate"
                   value="{{ $job_request->company_name_in_work_order }}" placeholder="Company name in certificate" required>
          </div>

          <!-- Training Mode -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training Mode</span>
            <select class="form-select" name="training_mode" required>
              <option value="Certification">Certification</option>
              <option value="In-Class">In-Class</option>
              <option value="Online">Online</option>
              <option value="On-Site">On-Site</option>
            </select>
            <span class="input-group-text">
              <input type="checkbox" name="zoom" id="duplicate-zoom"> Schedule Zoom
            </span>
          </div>

          <!-- Training Date -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training Date</span>
            <input type="date" class="form-control" name="requesting_date" required>
          </div>

          <!-- Training Time -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training Time</span>
            <input type="time" class="form-control" name="requesting_time">
          </div>

          <!-- Remarks -->
          <div class="input-group mb-3">
            <span class="input-group-text">Remarks</span>
            <input type="text" class="form-control" name="remarks" placeholder="Optional remark">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Duplicate</button>
        </div>

      </div>
    </div>
  </form>
</div>

<script>
  // Auto-fill course title from dropdown
  document.getElementById('duplicate-courseSelect').addEventListener('change', function () {
    let selectedText = this.options[this.selectedIndex].text;
    document.getElementById('duplicate-certificateTitle').value = selectedText;
  });

  // Function to open modal and set training_request_id dynamically
  function openDuplicateModal(trainingRequestId) {
    document.getElementById('duplicate_training_request_id').value = trainingRequestId;
    let modal = new bootstrap.Modal(document.getElementById('duplicateTraining'));
    modal.show();
  }
</script>

