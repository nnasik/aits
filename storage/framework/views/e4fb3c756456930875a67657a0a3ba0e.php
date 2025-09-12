<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo e(route('job.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">New Job</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Date</span>
            <input type="date" class="form-control" name="date">
          </div>

          <!-- Company Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Company</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="companyDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Company
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="companyDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">

                <!-- Search box -->
                <li>
                  <input type="text" class="form-control" id="companySearch" placeholder="Search...">
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <!-- Dynamic company list from DB -->
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="dropdown-item company-item" href="#" data-value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="company_id" id="selectedCompanyId">
          </div>

          <!-- Authorized Person Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Authorized By</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="authorizedDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Authorized Person
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="authorizedDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">

                <!-- Search box -->
                <li>
                  <input type="text" class="form-control" id="authorizedSearch" placeholder="Search...">
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <!-- Dynamic users list -->
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="dropdown-item authorized-item" href="#" data-value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="authorized_user_id" id="selectedAuthorizedId">
          </div>

          <!-- Sales Person Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Sales By</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="salesDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Sales Person
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="salesDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">
                <!-- Search box -->
                <li>
                  <input type="text" class="form-control" id="salesSearch" placeholder="Search...">
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <!-- Dynamic users list -->
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="dropdown-item sales-item" href="#" data-value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="sales_user_id" id="selectedSalesId">
          </div>

          <!-- Training Mode Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Training Mode</span>
            <select class="form-control" id="trainingMode" name="training_mode">
              <option selected="" disabled="">Choose...</option>
              <option value="In-Class">In-Class</option>
              <option value="Online">Online</option>
              <option value="On-Site">On-Site</option>
            </select>
          </div>

          <script>
            // Reusable function for filtering dropdowns
            function setupSearch(searchInputId, itemClass) {
              document.getElementById(searchInputId).addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                document.querySelectorAll('.' + itemClass).forEach(function (item) {
                  let text = item.textContent.toLowerCase();
                  item.style.display = text.includes(filter) ? '' : 'none';
                });
              });
            }

            // Reusable function for selecting dropdown item
            function setupSelection(itemClass, buttonId, hiddenInputId) {
              document.querySelectorAll('.' + itemClass).forEach(function (item) {
                item.addEventListener('click', function (e) {
                  e.preventDefault();
                  document.getElementById(buttonId).textContent = this.textContent;
                  document.getElementById(hiddenInputId).value = this.dataset.value;
                });
              });
            }

            // Initialize dropdowns
            setupSearch('companySearch', 'company-item');
            setupSelection('company-item', 'companyDropdown', 'selectedCompanyId');

            setupSearch('authorizedSearch', 'authorized-item');
            setupSelection('authorized-item', 'authorizedDropdown', 'selectedAuthorizedId');

            setupSearch('salesSearch', 'sales-item');
            setupSelection('sales-item', 'salesDropdown', 'selectedSalesId');
          </script>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Create Job</button>
        </div>
      </div>
    </div>
  </form>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/modals/new_job.blade.php ENDPATH**/ ?>