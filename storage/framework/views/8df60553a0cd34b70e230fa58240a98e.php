<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo e(route('trainee.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">New Trainee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Name</span>
            <input type="text" class="form-control" name="name">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Emirates ID No</span>
            <input type="text" class="form-control" name="eid">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Passport No</span>
            <input type="text" class="form-control" name="passport_no">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Date of Birth</span>
            <input type="date" class="form-control" name="dob">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Nationality</span>
            <div class="dropdown flex-grow-1">
              <button class="form-control text-start dropdown-toggle" type="button" id="nationalityDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Nationality
              </button>
              <ul class="dropdown-menu p-2" aria-labelledby="nationalityDropdown"
                style="max-height: 200px; overflow-y:auto; min-width: 100%;">

                <!-- Search box -->
                <li>
                  <input type="text" class="form-control" id="nationalitySearch" placeholder="Search...">
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <!-- Static Nationality list -->
                <?php
                $nationalities = [
                'Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Argentine',
                'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahraini', 'Bangladeshi',
                'Belarusian', 'Belgian', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British',
                'Bulgarian', 'Cambodian', 'Cameroonian', 'Canadian', 'Chilean', 'Chinese', 'Colombian',
                'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Dominican', 'Dutch', 'Egyptian',
                'Emirati', 'English', 'Estonian', 'Ethiopian', 'Finnish', 'French', 'Georgian',
                'German', 'Ghanaian', 'Greek', 'Hungarian', 'Icelandic', 'Indian', 'Indonesian',
                'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Japanese', 'Jordanian', 'Kazakh',
                'Kenyan', 'Kuwaiti', 'Kyrgyz', 'Latvian', 'Lebanese', 'Libyan', 'Lithuanian',
                'Luxembourgish', 'Malaysian', 'Maltese', 'Mexican', 'Moldovan', 'Mongolian',
                'Montenegrin', 'Moroccan', 'Nepalese', 'New Zealander', 'Nigerian', 'North Korean',
                'Norwegian', 'Omani', 'Pakistani', 'Palestinian', 'Panamanian', 'Peruvian',
                'Philippine', 'Polish', 'Portuguese', 'Qatari', 'Romanian', 'Russian', 'Saudi',
                'Scottish', 'Serbian', 'Singaporean', 'Slovak', 'Slovenian', 'Somali', 'South African',
                'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Swedish', 'Swiss', 'Syrian',
                'Tajik', 'Tanzanian', 'Thai', 'Tunisian', 'Turkish', 'Ugandan', 'Ukrainian',
                'Uruguayan', 'Uzbek', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemeni', 'Zambian',
                'Zimbabwean'
                ];
                ?>

                <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nationality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a class="dropdown-item nationality-item" href="#" data-value="<?php echo e($nationality); ?>">
                    <?php echo e($nationality); ?>

                  </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <input type="hidden" name="nationality" id="selectedNationality">
          </div>

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

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Designation</span>
            <input type="text" class="form-control" name="designation">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-success" value="Create">
        </div>

      </div>
    </div>
  </form>

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

    // Nationality dropdown
    setupSearch('nationalitySearch', 'nationality-item');
    setupSelection('nationality-item', 'nationalityDropdown', 'selectedNationalityId');
  </script>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/trainee/modals/new_trainee.blade.php ENDPATH**/ ?>