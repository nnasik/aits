<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="{{ route('certificate.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="certificateModalLabel">Create Certificate</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="job_id" id="job_id">
          <input type="hidden" name="trainee_id" id="trainee_id">

          <div class="row g-3">
            <!-- Editable Certificate Number -->
            <div class="col-md-6">
              <label class="form-label">Certificate No</label>
              <input type="number" class="form-control" name="id" id="certificate_id" placeholder="Enter Certificate Number" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Candidate Name</label>
              <input type="text" class="form-control" name="candidate_name_in_certificate" id="candidate_name_in_certificate" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Company Name</label>
              <input type="text" class="form-control" name="company_name_in_certificate" id="company_name_in_certificate" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Company Location</label>
              <input type="text" class="form-control" name="company_location" id="company_location" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Course Name</label>
              <input type="text" class="form-control" name="course_name_in_certificate" id="course_name_in_certificate" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">EID No</label>
              <input type="text" class="form-control" name="eid_no" id="eid_no" >
            </div>

            <div class="col-md-6">
              <label class="form-label">Passport No</label>
              <input type="text" class="form-control" name="passport_no" id="passport_no">
            </div>

            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" name="date" id="date" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Valid Until</label>
              <input type="date" class="form-control" name="valid_unit" id="valid_unit" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Text 1</label>
              <input type="text" class="form-control" name="text_1" value="CERTIFICATE" id="text_1" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Text 2</label>
              <input type="text" class="form-control" name="text_2" id="text_2" value="has successfully completed the safety awareness training on">
            </div>

            <div class="col-md-6">
              <label class="form-label">Text 3</label>
              <input type="text" class="form-control" name="text_3" id="text_3">
            </div>

            <div class="col-md-6 text-center">
              <label class="form-label">Live Photo</label><br>
              <img id="live_photo_preview" src="/images/default_avatar.png" alt="Live Photo" class="img-thumbnail mb-2" width="120" height="150">
              <input type="file" class="form-control" name="live_photo" id="live_photo_input" accept="image/*">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Certificate</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openCertificateModal(
    traineeId, jobId,
    candidateName, companyName, companyLocation, courseName,
    eidNo, passportNo, date, livePhoto
) {
    // Fill modal fields
    document.getElementById('trainee_id').value = traineeId;
    document.getElementById('job_id').value = jobId;
    document.getElementById('certificate_id').value = ''; // user enters manually
    document.getElementById('candidate_name_in_certificate').value = candidateName || '';
    document.getElementById('company_name_in_certificate').value = companyName || '';
    document.getElementById('company_location').value = companyLocation || '';
    document.getElementById('course_name_in_certificate').value = courseName || '';
    document.getElementById('eid_no').value = eidNo || '';
    document.getElementById('passport_no').value = passportNo || '';
    document.getElementById('date').value = date || '';

    // 🧮 Auto-calculate "Valid Until" = date + 1 year - 1 day
    if (date) {
        const selectedDate = new Date(date);
        selectedDate.setFullYear(selectedDate.getFullYear() + 1);
        selectedDate.setDate(selectedDate.getDate() - 1); // subtract 1 day

        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
        const day = String(selectedDate.getDate()).padStart(2, '0');
        document.getElementById('valid_unit').value = `${year}-${month}-${day}`;
    } else {
        document.getElementById('valid_unit').value = '';
    }

    // 🖼️ Load live photo
    document.getElementById('live_photo_preview').src = livePhoto
        ? `/storage/${livePhoto}`
        : '/images/default_avatar.png';

    // Show modal
    new bootstrap.Modal(document.getElementById('certificateModal')).show();
}

// 👁️‍🗨️ Preview new photo instantly
document.getElementById('live_photo_input').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('live_photo_preview').src = URL.createObjectURL(file);
    }
});
</script>


