<!-- EID Front Modal -->
<div class="modal fade" id="uploadEidFrontModal" tabindex="-1" aria-labelledby="uploadEidFrontModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadEidFrontModalLabel">Upload EID Front</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(route('training-requests.uploadEidFront')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="trainee_request_id">

          <div id="eidFrontDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="eid_front_pic" class="d-none" id="eidFrontInput">
          </div>
          <div id="eidFrontPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="eidFrontFileName"></div>
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
const eidFrontDropZone = document.getElementById('eidFrontDropZone');
const eidFrontInput = document.getElementById('eidFrontInput');
const eidFrontPreview = document.getElementById('eidFrontPreview');
const eidFrontFileName = document.getElementById('eidFrontFileName');

eidFrontDropZone.addEventListener('click', ()=>eidFrontInput.click());
eidFrontInput.addEventListener('change', ()=>{
  if(eidFrontInput.files.length>0){
    eidFrontPreview.classList.remove('d-none');
    eidFrontFileName.textContent = eidFrontInput.files[0].name;
  }
});
eidFrontDropZone.addEventListener('dragover', e=>{e.preventDefault(); eidFrontDropZone.classList.add('bg-white');});
eidFrontDropZone.addEventListener('dragleave', ()=>eidFrontDropZone.classList.remove('bg-white'));
eidFrontDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  eidFrontInput.files = e.dataTransfer.files;
  eidFrontInput.dispatchEvent(new Event('change'));
  eidFrontDropZone.classList.remove('bg-white');
});

function changeEidFront(traineeId) {
    console.log("Change EID Front clicked:", traineeId);
    document.querySelector('#uploadEidFrontModal input[name="trainee_request_id"]').value = traineeId;
}
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/eid_front.blade.php ENDPATH**/ ?>