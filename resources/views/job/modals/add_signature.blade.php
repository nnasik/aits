<!-- Bootstrap 5 Modal -->
<div class="modal fade" id="sign-import-modal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form class="modal-content" 
          id="sign-import-form" 
          method="post" 
          action="{{ route('trainee.signature.import') }}"
          enctype="multipart/form-data">
      
      <div class="modal-header">
        <h5 class="modal-title">Import Signature</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        @csrf
        <input type="hidden" name="training_id" id="sign-import-training-id">
        <input type="hidden" name="trainee_id" id="sign-import-trainee-id">
        <input type="hidden" name="signature" id="sign-import-png-field">

        <input type="file"
               id="sign-import-input"
               accept="image/*"
               class="form-control mb-3">

        <div id="sign-import-dropzone"
             class="border border-2 border-dashed rounded p-4 text-center mb-3"
             style="cursor:pointer">
          Drag & Drop / Paste Signature Image Here
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="fw-bold">Original</p>
            <img id="sign-import-original-preview" class="img-fluid border">
          </div>
          <div class="col-md-6">
            <p class="fw-bold">Processed (PNG, transparent)</p>
            <img id="sign-import-preview" class="img-fluid border bg-light">
          </div>
        </div>

        <canvas id="sign-import-canvas" class="d-none"></canvas>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
          Save
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Elements
const signImportInput = document.getElementById('sign-import-input');
const signImportOriginalPreview = document.getElementById('sign-import-original-preview');
const signImportPreview = document.getElementById('sign-import-preview');
const signImportCanvas = document.getElementById('sign-import-canvas');
const signImportCtx = signImportCanvas.getContext('2d');
const signImportPngField = document.getElementById('sign-import-png-field');
const signImportDropZone = document.getElementById('sign-import-dropzone');
const signImportForm = document.getElementById('sign-import-form');

// Maximum signature dimensions
const MAX_WIDTH = 400;
const MAX_HEIGHT = 150;

// Reset modal previews when opened
document.getElementById('sign-import-modal').addEventListener('show.bs.modal', () => {
    signImportOriginalPreview.src = '';
    signImportPreview.src = '';
    signImportPngField.value = '';
});

// Process and convert image to transparent PNG
function signImportProcessImage(src) {
    const img = new Image();
    img.onload = () => {
        // Scale image to fit max dimensions
        let width = img.width;
        let height = img.height;
        const ratio = Math.min(MAX_WIDTH / width, MAX_HEIGHT / height, 1);
        width = width * ratio;
        height = height * ratio;

        // Set canvas size
        signImportCanvas.width = width;
        signImportCanvas.height = height;

        // Draw scaled image
        signImportCtx.clearRect(0, 0, width, height);
        signImportCtx.drawImage(img, 0, 0, width, height);

        // Make white pixels transparent
        const imgData = signImportCtx.getImageData(0, 0, width, height);
        const d = imgData.data;
        for (let i = 0; i < d.length; i += 4) {
            const brightness = (d[i] + d[i + 1] + d[i + 2]) / 3;
            if (brightness > 200) {
                d[i + 3] = 0;
            } else {
                d[i] = d[i + 1] = d[i + 2] = 0;
                d[i + 3] = 255;
            }
        }
        signImportCtx.putImageData(imgData, 0, 0);

        // Convert to PNG Base64 and set hidden field
        const png = signImportCanvas.toDataURL('image/png');
        signImportPreview.src = png;
        signImportPngField.value = png;
    };
    img.src = src;
}

// File input handling
signImportInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        signImportOriginalPreview.src = ev.target.result;
        signImportProcessImage(ev.target.result);
    };
    reader.readAsDataURL(file);
});

// Drag & drop
signImportDropZone.addEventListener('dragover', e => {
    e.preventDefault();
    signImportDropZone.classList.add('bg-light');
});

signImportDropZone.addEventListener('dragleave', () => {
    signImportDropZone.classList.remove('bg-light');
});

signImportDropZone.addEventListener('drop', e => {
    e.preventDefault();
    signImportDropZone.classList.remove('bg-light');
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        signImportOriginalPreview.src = ev.target.result;
        signImportProcessImage(ev.target.result);
    };
    reader.readAsDataURL(file);
});

// Paste from clipboard
document.addEventListener('paste', e => {
    const item = [...e.clipboardData.items].find(i => i.type.startsWith('image/'));
    if (!item) return;
    const file = item.getAsFile();
    const reader = new FileReader();
    reader.onload = ev => {
        signImportOriginalPreview.src = ev.target.result;
        signImportProcessImage(ev.target.result);
    };
    reader.readAsDataURL(file);
});

// Prevent form submit if no signature
signImportForm.addEventListener('submit', e => {
    if (!signImportPngField.value) {
        e.preventDefault();
        alert('Please upload or paste a signature before saving.');
    }
});

// Open modal function and fill hidden IDs
function openSignatureModal(trainingId, traineeId) {
    document.getElementById('sign-import-training-id').value = trainingId;
    document.getElementById('sign-import-trainee-id').value = traineeId;

    const modalEl = document.getElementById('sign-import-modal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

</script>
