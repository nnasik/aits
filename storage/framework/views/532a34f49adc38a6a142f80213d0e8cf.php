<!-- Modal -->
<div class="modal fade" id="addTrainee" tabindex="-1" aria-labelledby="addTraineeLabel" aria-hidden="true">
  <form action="<?php echo e(route('training.add-trainee')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="training" value="<?php echo e($training->id); ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addTraineeLabel">Add Trainee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <!-- Training -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training</span>
            <input type="text" class="form-control" value="<?php echo e($training->course->name); ?>" readonly>
          </div>

          <!-- + Trainee Link -->
          <div class="mb-2 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
              + Trainee
            </a>
          </div>
          
          <!-- Trainee Dropdown (Searchable) -->
          <div class="input-group mb-3">
            <span class="input-group-text">Trainee</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="traineeDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Trainee
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="traineeDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">

                <!-- Search box -->
                <li>
                  <input type="text" class="form-control" id="traineeSearch" placeholder="Search by Name or EID...">
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <!-- Dynamic trainee list -->
                <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a class="dropdown-item trainee-item" href="#"
                       data-value="<?php echo e($trainee->id); ?>" 
                       data-eid="<?php echo e($trainee->eid_no); ?>"
                       data-photo="<?php echo e($trainee->live_photo ? asset('storage/'.$trainee->live_photo) : asset('images/placeholder.png')); ?>">
                      <?php echo e($trainee->name); ?>

                    </a>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="trainee_id" id="selectedTraineeId">
          </div>

          <!-- Auto-fill fields -->
          <div class="input-group mb-3">
            <span class="input-group-text">Company</span>
            <input type="text" class="form-control" id="trainee_company" name="company" readonly>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Emirates ID / Passport / Visa</span>
            <input type="text" class="form-control" id="trainee_eid" name="eid" readonly>
          </div>
        </div>

        <!-- Photo Preview -->
          <div class="text-center my-3">
            <img id="trainee_photo" 
                 src="<?php echo e(asset('images/placeholder.png')); ?>" 
                 alt="Trainee Photo" 
                 class="img-thumbnail" 
                 style="max-height: 150px;">
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>

      </div>
    </div>
  </form>
</div>

<script>
  // 🔎 Reusable function for filtering dropdowns
  function setupSearch(searchInputId, itemClass, searchByEid = false) {
    document.getElementById(searchInputId).addEventListener('keyup', function () {
      let filter = this.value.toLowerCase();
      document.querySelectorAll('.' + itemClass).forEach(function (item) {
        let text = item.textContent.toLowerCase();
        let eid = item.dataset.eid ? item.dataset.eid.toLowerCase() : "";
        // if searchByEid = true, match by name OR eid
        item.style.display = (text.includes(filter) || (searchByEid && eid.includes(filter))) ? '' : 'none';
      });
    });
  }

  // ✅ Reusable function for selecting dropdown item
  function setupSelection(itemClass, buttonId, hiddenInputId, extraCallback = null) {
    document.querySelectorAll('.' + itemClass).forEach(function (item) {
      item.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById(buttonId).textContent = this.textContent;
        document.getElementById(hiddenInputId).value = this.dataset.value;
        if (extraCallback) extraCallback(this); // custom handler
      });
    });
  }

  // 🟢 Initialize Trainee Dropdown (search by Name OR EID)
  setupSearch('traineeSearch', 'trainee-item', true);

  setupSelection('trainee-item', 'traineeDropdown', 'selectedTraineeId', function (item) {
    // Auto-fill company + EID when trainee selected
    document.getElementById('trainee_company').value = item.dataset.company;
    document.getElementById('trainee_eid').value = item.dataset.eid;

    // Set photo
    document.getElementById('trainee_photo').src = item.dataset.photo;
  });
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/add_trainee.blade.php ENDPATH**/ ?>