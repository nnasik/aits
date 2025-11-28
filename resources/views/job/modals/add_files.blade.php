<!-- Upload File Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="uploadFileForm" action="{{ route('workorders.files.upload', $workOrder->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <!-- Drag & Drop Zone -->
                    <div id="dropzone" 
                         class="border border-2 border-primary rounded p-5 text-center"
                         style="cursor: pointer; background:#f8f9fa;">
                        <p class="mb-2 fw-bold">Drag & Drop File Here</p>
                        <p class="text-muted">or click to browse • you can also paste file directly</p>
                        <input type="file" name="files" id="fileInput" class="d-none" required>
                    </div>

                    <!-- Preview -->
                    <div id="filePreview" class="mt-3 d-none">
                        <p class="fw-semibold mb-1">Selected File:</p>
                        <div class="alert alert-secondary py-2" id="previewName"></div>
                    </div>

                    <!-- Description -->
                    <div class="mt-3">
                        <label class="form-label">Description (Optional)</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                    <!-- Document Type -->
                    <div class="mt-3">
                        <label class="form-label">Document Type</label>
                        <select name="document_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Invoice">Invoice</option>
                            <option value="Delivery Note">Delivery Note</option>
                            <option value="Certificates & Ids">Certificates & Ids</option>
                            <option value="Training Feedback">Training Feedback</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const previewBox = document.getElementById('filePreview');
    const previewName = document.getElementById('previewName');

    // Click to open file dialog
    dropzone.addEventListener('click', () => fileInput.click());

    // Preview function
    function showPreview(file) {
        previewName.textContent = file.name;
        previewBox.classList.remove('d-none');
    }

    // File selected manually
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            showPreview(fileInput.files[0]);
        }
    });

    // Drag over
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('bg-light');
    });

    // Drag leave
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('bg-light');
    });

    // Drop file
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('bg-light');

        const file = e.dataTransfer.files[0];
        if (!file) return;

        fileInput.files = e.dataTransfer.files;
        showPreview(file);
    });

    // Paste support
    document.addEventListener('paste', (e) => {
        if (!e.clipboardData.files.length) return;

        const file = e.clipboardData.files[0];
        fileInput.files = e.clipboardData.files;
        showPreview(file);
    });
</script>
