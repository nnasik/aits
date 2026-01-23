<!-- Duplicate Request Modal -->
<div class="modal fade" id="duplicateRequestModal" tabindex="-1" aria-labelledby="duplicateRequestModalLabel" aria-hidden="true">
  <form action="<?php echo e(route('job-request.duplicate')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="duplicateRequestModalLabel">Duplicate Request</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="job_request_id" id="duplicateJobRequestId">

          <div class="input-group mb-3">
            <span class="input-group-text">Priority</span>
            <select class="form-control" name="priority" id="duplicatePriority">
              <option value="low">Low</option>
              <option value="normal" selected>Normal</option>
              <option value="urgent">Urgent</option>
            </select>
          </div>

          <!-- Company Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Company</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="duplicateCompanyDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Company
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="duplicateCompanyDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">
                <li>
                  <input type="text" class="form-control" id="duplicateCompanySearch" placeholder="Search...">
                </li>
                <li><hr class="dropdown-divider"></li>

                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="dropdown-item duplicate-company-item" href="#" data-value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="company_id" id="duplicateSelectedCompanyId">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Company Name</span>
            <input type="text" class="form-control" name="company_name" id="duplicateSelectedCompanyName">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Training Mode</span>
            <select class="form-control" name="training_mode" id="duplicateTrainingMode">
              <option value="Certification" selected>Certification</option>
              <option value="Online">Online</option>
              <option value="In-Class">In Class</option>
              <option value="On-Site">On Site</option>
            </select>
          </div>

          <!-- Hidden Zoom Link Group -->
          <div class="input-group mb-3 d-none" id="duplicateZoomLinkGroup">
            <span class="input-group-text">Zoom Link</span>
            <div class="form-control">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="duplicateZoomLink" name="zoom_link">
                <label class="form-check-label" for="duplicateZoomLink">Required</label>
              </div>
            </div>
          </div>

          <script>
            // Toggle zoom link visibility
            document.getElementById('duplicateTrainingMode').addEventListener('change', function () {
              const zoomGroup = document.getElementById('duplicateZoomLinkGroup');
              if (this.value.toLowerCase() === 'online') {
                zoomGroup.classList.remove('d-none');
              } else {
                zoomGroup.classList.add('d-none');
              }
            });

            // Reusable search for duplicate modal
            function setupDuplicateSearch(searchInputId, itemClass) {
              document.getElementById(searchInputId).addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                document.querySelectorAll('.' + itemClass).forEach(function (item) {
                  let text = item.textContent.toLowerCase();
                  item.style.display = text.includes(filter) ? '' : 'none';
                });
              });
            }

            // Reusable dropdown selection for duplicate modal
            function setupDuplicateSelection(itemClass, buttonId, hiddenInputId, textInputId = null) {
              document.querySelectorAll('.' + itemClass).forEach(function (item) {
                item.addEventListener('click', function (e) {
                  e.preventDefault();
                  document.getElementById(buttonId).textContent = this.textContent;
                  document.getElementById(hiddenInputId).value = this.dataset.value;

                  if (textInputId) {
                    document.getElementById(textInputId).value = this.textContent.trim();
                  }
                });
              });
            }

            // Initialize dropdown and search for duplicate modal
            setupDuplicateSearch('duplicateCompanySearch', 'duplicate-company-item');
            setupDuplicateSelection('duplicate-company-item', 'duplicateCompanyDropdown', 'duplicateSelectedCompanyId', 'duplicateSelectedCompanyName');
          </script>

          <script>
  function openDuplicateModal(jobRequestId, priority, companyId, companyName, trainingMode, zoomRequired) {
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('duplicateRequestModal'));
    modal.show();

    // Set hidden job request ID
    document.getElementById('duplicateJobRequestId').value = jobRequestId;

    // Set priority
    const prioritySelect = document.getElementById('duplicatePriority');
    if (prioritySelect) prioritySelect.value = priority.toLowerCase();

    // Set company dropdown and hidden input
    const companyButton = document.getElementById('duplicateCompanyDropdown');
    const companyHidden = document.getElementById('duplicateSelectedCompanyId');
    const companyInput = document.getElementById('duplicateSelectedCompanyName');
    if (companyButton && companyHidden && companyInput) {
      companyButton.textContent = companyName;
      companyHidden.value = companyId;
      companyInput.value = companyName;
    }

    // Set training mode
    const trainingModeSelect = document.getElementById('duplicateTrainingMode');
    const zoomGroup = document.getElementById('duplicateZoomLinkGroup');
    const zoomCheckbox = document.getElementById('duplicateZoomLink');
    if (trainingModeSelect) trainingModeSelect.value = trainingMode;

    // Toggle Zoom group visibility
    if (trainingMode.toLowerCase() === 'online') {
      zoomGroup.classList.remove('d-none');
      if (zoomCheckbox) zoomCheckbox.checked = zoomRequired;
    } else {
      zoomGroup.classList.add('d-none');
      if (zoomCheckbox) zoomCheckbox.checked = false;
    }
  }
</script>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-success" value="Duplicate">
        </div>
      </div>
    </div>
  </form>
</div>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job_request/modals/duplicate_request.blade.php ENDPATH**/ ?>