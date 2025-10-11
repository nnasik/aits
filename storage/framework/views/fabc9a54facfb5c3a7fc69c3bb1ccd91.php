<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulkUploadModalLabel">Bulk Upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form action="<?php echo e(route('training-requests.bulkUpload')); ?>" method="POST" enctype="multipart/form-data" id="bulkUploadForm">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="document_type" id="bulkDocumentType">
          <input type="hidden" name="training_request_id" id="bulkTrainingRequestId">
          <input type="hidden" id="bulkMaxFiles" value="<?php echo e($training_request->quantity ?? 5); ?>"> <!-- Default to 5 if null -->

          <!-- Drop Zone -->
          <div id="bulkDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your files here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="files[]" multiple class="d-none" id="bulkInput">
          </div>

          <!-- File Preview -->
          <div id="bulkPreview" class="mt-3 d-none">
            <p class="fw-bold mb-2">Selected Files:</p>
            <ul class="list-group small" id="bulkFileList"></ul>
          </div>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// === Elements ===
const bulkDropZone = document.getElementById('bulkDropZone');
const bulkInput = document.getElementById('bulkInput');
const bulkPreview = document.getElementById('bulkPreview');
const bulkFileList = document.getElementById('bulkFileList');
const bulkForm = document.getElementById('bulkUploadForm'); // optional if you have it
const bulkMaxFilesElem = document.getElementById('bulkMaxFiles'); // optional if present

// existing handlers (keep as they are)
bulkDropZone.addEventListener('click', () => bulkInput.click());
bulkInput.addEventListener('change', () => updateFileList(bulkInput.files));
bulkDropZone.addEventListener('dragover', e => { e.preventDefault(); bulkDropZone.classList.add('bg-white'); });
bulkDropZone.addEventListener('dragleave', () => bulkDropZone.classList.remove('bg-white'));
bulkDropZone.addEventListener('drop', e => {
  e.preventDefault();
  bulkInput.files = e.dataTransfer.files;
  updateFileList(e.dataTransfer.files);
  bulkDropZone.classList.remove('bg-white');
});

function updateFileList(files) {
  const maxFiles = (bulkMaxFilesElem && parseInt(bulkMaxFilesElem.value, 10)) || 999;
  if (files.length > maxFiles) {
    alert(`There are ${maxFiles} trainess in this training. You can upload a maximum of ${maxFiles} files.`);
    bulkInput.value = '';
    bulkPreview.classList.add('d-none');
    bulkFileList.innerHTML = '';
    return;
  }

  if (files.length > 0) {
    bulkPreview.classList.remove('d-none');
    bulkFileList.innerHTML = '';
    Array.from(files).forEach(file => {
      const li = document.createElement('li');
      li.classList.add('list-group-item');
      li.textContent = `${file.name} (${Math.round(file.size / 1024)} KB)`;
      bulkFileList.appendChild(li);
    });
  } else {
    bulkPreview.classList.add('d-none');
    bulkFileList.innerHTML = '';
  }
}

// Expose the function to window so inline onclick can call it
window.openBulkUploadModal = function(documentType, trainingRequestId, maxFiles = null) {
  // set hidden inputs
  const docType = document.getElementById('bulkDocumentType');
  const trainId = document.getElementById('bulkTrainingRequestId');
  const maxFilesElem = document.getElementById('bulkMaxFiles'); // optional hidden input you added earlier

  if (docType) docType.value = documentType;
  if (trainId) trainId.value = trainingRequestId;
  if (maxFilesElem && maxFiles !== null) maxFilesElem.value = maxFiles;

  // update modal title
  const label = document.getElementById('bulkUploadModalLabel');
  if (label) label.textContent = `Upload - ${documentType}`;

  // reset previous selection/preview
  if (bulkInput) { bulkInput.value = ''; }
  if (bulkPreview) { bulkPreview.classList.add('d-none'); }
  if (bulkFileList) { bulkFileList.innerHTML = ''; }

  // show modal
  const modalEl = document.getElementById('bulkUploadModal');
  if (modalEl) {
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
};
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/bulk_upload.blade.php ENDPATH**/ ?>