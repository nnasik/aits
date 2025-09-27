<!-- Profile Picture Modal -->
<div class="modal fade" id="editProfilePicModal" tabindex="-1" aria-labelledby="editProfilePicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfilePicModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="profilePicForm" action="{{route('trainee-requests.updateProfilePic')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="trainee_request_id">
          <div id="profilePicDropZone" class="border border-2 border-dashed rounded-3 p-5 text-center bg-light" style="cursor:pointer;">
            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
            <p class="mt-2 mb-0 fw-bold">Drag & Drop your file here</p>
            <p class="text-muted small">or click to browse (Images allowed)</p>
            <input type="file" name="profile_pic" class="d-none" id="profilePicInput">
          </div>
          <div id="profilePicPreview" class="mt-3 d-none">
            <p class="fw-bold">Selected File:</p>
            <div class="alert alert-info py-2 px-3 mb-0" id="profilePicFileName"></div>
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
const profilePicDropZone = document.getElementById('profilePicDropZone');
const profilePicInput = document.getElementById('profilePicInput');
const profilePicPreview = document.getElementById('profilePicPreview');
const profilePicFileName = document.getElementById('profilePicFileName');

profilePicDropZone.addEventListener('click', () => profilePicInput.click());
profilePicInput.addEventListener('change', () => {
  if(profilePicInput.files.length>0){
    profilePicPreview.classList.remove('d-none');
    profilePicFileName.textContent = profilePicInput.files[0].name;
  }
});
profilePicDropZone.addEventListener('dragover', e=>{e.preventDefault(); profilePicDropZone.classList.add('bg-white');});
profilePicDropZone.addEventListener('dragleave', ()=>profilePicDropZone.classList.remove('bg-white'));
profilePicDropZone.addEventListener('drop', e=>{
  e.preventDefault();
  profilePicInput.files = e.dataTransfer.files;
  profilePicInput.dispatchEvent(new Event('change'));
  profilePicDropZone.classList.remove('bg-white');
});

function changeProfilePic(traineeId){
    document.querySelector('#profilePicForm input[name="trainee_request_id"]').value = traineeId;
}

</script>
