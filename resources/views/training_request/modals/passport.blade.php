<!-- Passport Modal -->
<div class="modal fade" id="uploadPassportModal" tabindex="-1" aria-labelledby="uploadPassportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadPassportModalLabel">Upload Passport</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('training-requests.uploadPassport')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="trainee_request_id">

          <div id="passportDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="passport_pic" class="d-none" id="passportInput">
          </div>
          <div id="passportPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="passportFileName"></div>
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
const passportDropZone = document.getElementById('passportDropZone');
const passportInput = document.getElementById('passportInput');
const passportPreview = document.getElementById('passportPreview');
const passportFileName = document.getElementById('passportFileName');

passportDropZone.addEventListener('click', ()=>passportInput.click());
passportInput.addEventListener('change', ()=>{
  if(passportInput.files.length>0){
    passportPreview.classList.remove('d-none');
    passportFileName.textContent = passportInput.files[0].name;
  }
});
passportDropZone.addEventListener('dragover', e=>{e.preventDefault(); passportDropZone.classList.add('bg-white');});
passportDropZone.addEventListener('dragleave', ()=>passportDropZone.classList.remove('bg-white'));
passportDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  passportInput.files = e.dataTransfer.files;
  passportInput.dispatchEvent(new Event('change'));
  passportDropZone.classList.remove('bg-white');
});

function changePassport(traineeId) {
    document.querySelector('#uploadPassportModal input[name="trainee_request_id"]').value = traineeId;
}

</script>
