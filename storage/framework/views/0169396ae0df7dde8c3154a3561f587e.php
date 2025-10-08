<!-- Visa Modal -->
<div class="modal fade" id="uploadVisaModal" tabindex="-1" aria-labelledby="uploadVisaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadVisaModalLabel">Upload Visa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="visaForm" action="<?php echo e(route('trainee-requests.uploadVisa')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="trainee_request_id">
          <div id="visaDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="visa_pic" class="d-none" id="visaInput">
          </div>
          <div id="visaPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="visaFileName"></div>
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
const visaDropZone = document.getElementById('visaDropZone');
const visaInput = document.getElementById('visaInput');
const visaPreview = document.getElementById('visaPreview');
const visaFileName = document.getElementById('visaFileName');

visaDropZone.addEventListener('click', ()=>visaInput.click());
visaInput.addEventListener('change', ()=>{
  if(visaInput.files.length>0){
    visaPreview.classList.remove('d-none');
    visaFileName.textContent = visaInput.files[0].name;
  }
});
visaDropZone.addEventListener('dragover', e=>{e.preventDefault(); visaDropZone.classList.add('bg-white');});
visaDropZone.addEventListener('dragleave', ()=>visaDropZone.classList.remove('bg-white'));
visaDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  visaInput.files = e.dataTransfer.files;
  visaInput.dispatchEvent(new Event('change'));
  visaDropZone.classList.remove('bg-white');
});

function changeVisa(traineeId){
    document.querySelector('#visaForm input[name="trainee_request_id"]').value = traineeId;
}
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/training_request/modals/visa.blade.php ENDPATH**/ ?>