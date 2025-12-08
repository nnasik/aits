<!-- Upload File Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="uploadFileForm" action="<?php echo e(route('job.file.upload')); ?>" 
                  method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="modal-body">

                    <!-- Hidden field for WorkOrder ID -->
                    <input type="hidden" name="fileable_id" id="fileableIdInput">

                    <!-- Dropzone -->
                    <div id="dropzone"
                         class="border border-primary border-2 rounded p-5 text-center bg-light"
                         style="cursor:pointer;">
                        <p class="fw-bold mb-1">Drag & Drop File</p>
                        <p class="text-muted">Click to browse • Paste (Ctrl+V) also supported</p>
                        <input type="file" id="fileInput" name="file" class="d-none" required>
                    </div>

                    <!-- Preview -->
                    <div id="previewBox" class="mt-3 d-none">
                        <label class="fw-semibold">Selected File:</label>
                        <div class="alert alert-secondary py-2 px-3" id="previewName"></div>
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

                <!-- Footer -->
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
    const previewBox = document.getElementById('previewBox');
    const previewName = document.getElementById('previewName');
    const fileableIdInput = document.getElementById('fileableIdInput');

    // Function to set WorkOrder ID when modal is triggered
    function setWorkOrderId(workOrderId) {
        fileableIdInput.value = workOrderId;
    }

    // -----------------------------
    // SHOW PREVIEW
    // -----------------------------
    function showPreview(file) {
        previewName.textContent = file.name;
        previewBox.classList.remove('d-none');
    }

    // Click → Open file dialog
    dropzone.addEventListener('click', () => fileInput.click());

    // Manual select
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length === 1) {
            showPreview(fileInput.files[0]);
        }
    });

    // Drag enter
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('bg-white');
    });

    // Drag leave
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('bg-white');
    });

    // Drop
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('bg-white');

        const file = e.dataTransfer.files[0];
        if (!file) return;

        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;

        showPreview(file);
    });

    // Clipboard paste
    document.addEventListener('paste', (e) => {
        if (!e.clipboardData.files.length) return;

        const file = e.clipboardData.files[0];
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;

        showPreview(file);
    });
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/add_files.blade.php ENDPATH**/ ?>