<!-- Modal -->
<div class="modal fade" id="newRequestModal" tabindex="-1" aria-labelledby="newRequestModalLabel" aria-hidden="true">
  <form action="{{route('jobrequest.store')}}" method="post">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="newRequestModalLabel">New Request</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Priority</span>
            <select class="form-control" name="priority">
              <option value="low">Low</option>
              <option value="normal" selected>Normal</option>
              <option value="urgent">Urgent</option>
            </select>
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
                @foreach($companies as $company)
                <li><a class="dropdown-item company-item" href="#" data-value="{{ $company->id }}">{{
                    $company->name}}</a></li>
                @endforeach
              </ul>
            </div>
            <input type="hidden" name="company_id" id="selectedCompanyId">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Company Name</span>
            <input type="text" class="form-control" name="company_name" id="selectedCompanyName">
          </div>


          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Training Mode</span>
            <select class="form-control" name="training_mode" id="training_mode">
              <option value="Certification" selected>Certification</option>
              <option value="Online">Online</option>
              <option value="In-Class">In Class</option>
              <option value="On-Site">On Site</option>
            </select>
          </div>

          <!-- Hidden checkbox group -->
          <div class="input-group mb-3 d-none" id="zoom_link_group">
            <span class="input-group-text">Zoom Link</span>
            <div class="form-control">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="zoom_link" name="zoom_link">
                <label class="form-check-label" for="zoom_link">Required</label>
              </div>
            </div>
          </div>

          <script>
            document.getElementById('training_mode').addEventListener('change', function () {
              const zoomGroup = document.getElementById('zoom_link_group');
              if (this.value === 'online') {
                zoomGroup.classList.remove('d-none');
              } else {
                zoomGroup.classList.add('d-none');
              }
            });
          </script>

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
          </script>
          <script>
            // Reusable function for selecting dropdown item
            function setupSelection(itemClass, buttonId, hiddenInputId, textInputId = null) {
              document.querySelectorAll('.' + itemClass).forEach(function (item) {
                item.addEventListener('click', function (e) {
                  e.preventDefault();
                  document.getElementById(buttonId).textContent = this.textContent;
                  document.getElementById(hiddenInputId).value = this.dataset.value;

                  // If a text input is provided, also update it with the selected name
                  if (textInputId) {
                    document.getElementById(textInputId).value = this.textContent.trim();
                  }
                });
              });
            }

            // Initialize dropdowns
            setupSearch('companySearch', 'company-item');
            setupSelection('company-item', 'companyDropdown', 'selectedCompanyId', 'selectedCompanyName');
          </script>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-success" value="Create">
        </div>
      </div>
    </div>
  </form>
</div>