<!-- Edit Certificate Title Modal -->
<div class="modal fade" id="editCertificateTitle" tabindex="-1" aria-labelledby="editCertificateTitleLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCertificateTitleForm" action="{{route('trainee.updateCertificateTitle')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCertificateTitleLabel">Edit Certificate Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="certificateTitleTraineeId" name="trainee_request_id">
                    <div class="mb-3">
                        <label for="certificate_title_in_certificate" class="form-label">Certificate Title</label>
                        <input type="text" class="form-control" id="certificate_title_in_certificate"
                            name="course_title_in_certificate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function editCertificateTitle(traineeId, currentTitle) {
    document.getElementById('certificateTitleTraineeId').value = traineeId;
    document.getElementById('certificate_title_in_certificate').value = currentTitle || '';
}

</script>
