<!-- Edit Company Name Modal -->
<div class="modal fade" id="editCompanyNameModal" tabindex="-1" aria-labelledby="editCompanyNameModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCompanyNameModalLabel">Edit Company Name in Certificate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="companyNameForm" action="{{ route('trainee-requests.updateCompanyName') }}" method="POST">
          @csrf
          <input type="hidden" name="trainee_request_id" id="companyNameTraineeId">
          <div class="mb-3">
            <label for="company_name_in_certificate" class="form-label">Company Name</label>
            <input type="text" name="company_name_in_certificate" id="companyNameInput" class="form-control" required>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function editCompanyName(traineeId, currentName){
    document.getElementById('companyNameTraineeId').value = traineeId;
    document.getElementById('companyNameInput').value = currentName || '';
}

</script>