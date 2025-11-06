<!-- Bootstrap 5 Modal -->
<div class="modal fade" id="deleteSignatureModal" tabindex="-1" aria-labelledby="deleteSignatureModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteSignatureForm" method="POST" action="{{ route('trainee.signature.delete') }}">
        @csrf
        <input type="hidden" id="signature_trainee_id" name="trainee_id">

        <div class="modal-header">
          <h5 class="modal-title" id="deleteSignatureModalLabel">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          Are you sure you want to remove this trainee’s signature?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes, Remove</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
function confirmDeleteSignature(id) {
    document.getElementById('signature_trainee_id').value = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteSignatureModal'));
    modal.show();
}
</script>