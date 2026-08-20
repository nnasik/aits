<!-- EID Back Modal -->
<div class="modal fade" id="uploadEidBackModal" tabindex="-1" aria-labelledby="uploadEidBackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadEidBackModalLabel">Upload EID Back</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(route('training-requests.uploadEidBack')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
           <input type="hidden" name="trainee_request_id">
          <div id="eidBackDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="eid_back_pic" class="d-none" id="eidBackInput">
          </div>
          <div id="eidBackPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="eidBackFileName"></div>
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
const eidBackDropZone = document.getElementById('eidBackDropZone');
const eidBackInput = document.getElementById('eidBackInput');
const eidBackPreview = document.getElementById('eidBackPreview');
const eidBackFileName = document.getElementById('eidBackFileName');

eidBackDropZone.addEventListener('click', ()=>eidBackInput.click());
eidBackInput.addEventListener('change', ()=>{
  if(eidBackInput.files.length>0){
    eidBackPreview.classList.remove('d-none');
    eidBackFileName.textContent = eidBackInput.files[0].name;
  }
});
eidBackDropZone.addEventListener('dragover', e=>{e.preventDefault(); eidBackDropZone.classList.add('bg-white');});
eidBackDropZone.addEventListener('dragleave', ()=>eidBackDropZone.classList.remove('bg-white'));
eidBackDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  eidBackInput.files = e.dataTransfer.files;
  eidBackInput.dispatchEvent(new Event('change'));
  eidBackDropZone.classList.remove('bg-white');
});
</script>

<script>
function changeEidBack(traineeId) {
  console.log("Change EID Back clicked:", traineeId);
  document.querySelector('#uploadEidBackModal input[name="trainee_request_id"]').value = traineeId;
}
</script>

<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/eid_back.blade.php ENDPATH**/ ?>