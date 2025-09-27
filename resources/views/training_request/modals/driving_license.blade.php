<!-- Driving License Modal -->
<div class="modal fade" id="uploadDlModal" tabindex="-1" aria-labelledby="uploadDlModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadDlModalLabel">Upload Driving License</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('training-requests.updateDl')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="trainee_request_id" id="dlTraineeId">
          <div id="dlDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images / PDF allowed)</p>
            <input type="file" name="dl_pic" class="d-none" id="dlInput">
          </div>
          <div id="dlPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="dlFileName"></div>
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
const dlDropZone = document.getElementById('dlDropZone');
const dlInput = document.getElementById('dlInput');
const dlPreview = document.getElementById('dlPreview');
const dlFileName = document.getElementById('dlFileName');

dlDropZone.addEventListener('click', ()=>dlInput.click());
dlInput.addEventListener('change', ()=>{
  if(dlInput.files.length>0){
    dlPreview.classList.remove('d-none');
    dlFileName.textContent = dlInput.files[0].name;
  }
});
dlDropZone.addEventListener('dragover', e=>{e.preventDefault(); dlDropZone.classList.add('bg-white');});
dlDropZone.addEventListener('dragleave', ()=>dlDropZone.classList.remove('bg-white'));
dlDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  dlInput.files = e.dataTransfer.files;
  dlInput.dispatchEvent(new Event('change'));
  dlDropZone.classList.remove('bg-white');
});
</script>

<script>
// Example function to open modal and set trainee_request_id
function changeDl(traineeId){
    document.getElementById('dlTraineeId').value = traineeId;
}
</script>