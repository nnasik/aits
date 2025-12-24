<!-- Quotation Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="quotationModalLabel">Create / Edit Quotation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" tabindex="-1"></button>
      </div>

      <form id="quotationForm" autocomplete="off" method="POST" action="{{ route('quotation.store') }}">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <!-- Reference -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Reference</span>
                <input id="q_reference" type="text" class="form-control" value="{{$next_quotation_ref}}" name="reference" readonly/>
              </div>
            </div>

            <!-- Revision -->
            <div class="col-md-2">
              <div class="input-group">
                <span class="input-group-text">Revision</span>
                <input id="q_revision" type="integer" class="form-control" value="0" name="revision" readonly />
              </div>
            </div>

            <!-- Date of Quotation -->
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-text">Date</span>
                <input id="q_date" type="date" class="form-control" name="date" />
              </div>
            </div>

            <!-- Valid Until -->
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-text">Valid Until</span>
                <input id="q_valid_until" type="date" class="form-control" name="valid_until" />
              </div>
            </div>

            <hr class="mt-4">

            <!-- Company Dropdown -->
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-text">Company</span>
                <div class="dropdown flex-grow-1">
                  <button class="form-control text-start dropdown-toggle" type="button" id="companyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Company
                  </button>
                  <ul class="dropdown-menu p-2 w-100" aria-labelledby="companyDropdown" style="max-height:220px;overflow-y:auto;">
                    <li><input type="text" class="form-control" id="companySearch" placeholder="Search..."></li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach($companies as $company)
                    <li>
                      <a class="dropdown-item company-item" href="#" 
                         data-id="{{ $company->id }}"
                         data-name="{{ $company->name }}"
                         data-phone="{{ $company->phone }}"
                         data-email="{{ $company->email }}"
                         data-address="{{ $company->address }}"
                         data-quote_for="{{ $company->quote_for }}">
                        {{ $company->name }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="company_id" id="selectedCompanyId">
              </div>
            </div>

            <!-- Company Name -->
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-text">Company Name</span>
                <input id="q_company_name" type="text" class="form-control" name="company_name" />
              </div>
            </div>

            <!-- Company Phone -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Phone</span>
                <input id="q_company_phone" type="text" class="form-control" name="company_phone" />
              </div>
            </div>

            <!-- Company Email -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Email</span>
                <input id="q_company_email" type="email" class="form-control" name="company_email" />
              </div>
            </div>

            <!-- Quote For -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Quote For</span>
                <input id="q_quote_for" type="text" class="form-control" name="quote_for" />
              </div>
            </div>

            <!-- Company Address -->
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-text">Address</span>
                <textarea id="q_company_address" class="form-control" name="company_address" rows="2"></textarea>
              </div>
            </div>

            <hr class="mt-4">

            <!-- Prepared By Name -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Name</span>
                <input id="q_prepared_by_name" type="text" class="form-control" name="prepared_by_name" />
              </div>
            </div>

            <!-- Prepared By Email -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Email</span>
                <input id="q_prepared_by_email" type="email" class="form-control" name="prepared_by_email" />
              </div>
            </div>

            <!-- Prepared By Contact -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Contact</span>
                <input id="q_prepared_by_contact" type="text" class="form-control" name="prepared_by_contact" />
              </div>
            </div>

            <hr class="mt-4">

            <!-- Note -->
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-text">Note</span>
                <textarea id="q_note" class="form-control" name="note" rows="2"></textarea>
              </div>
            </div>

            <!-- Terms & Conditions Dropdown -->
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-text">Terms & Conditions</span>
                <select id="q_terms" class="form-control" name="terms_and_conditions">
                  <option value="" selected>Select Terms & Conditions</option>
                  @foreach($terms as $term)
                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Create</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

  // Filter company items
  document.getElementById('companySearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('.company-item').forEach(function(item) {
      let text = item.textContent.toLowerCase();
      item.style.display = text.includes(filter) ? '' : 'none';
    });
  });

  // Select company and auto-fill fields
  document.querySelectorAll('.company-item').forEach(function(item) {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('companyDropdown').textContent = this.dataset.name;
      document.getElementById('selectedCompanyId').value = this.dataset.id;

      document.getElementById('q_company_name').value = this.dataset.name || '';
      document.getElementById('q_company_phone').value = this.dataset.phone || '';
      document.getElementById('q_company_email').value = this.dataset.email || '';
      document.getElementById('q_company_address').value = this.dataset.address || '';
      document.getElementById('q_quote_for').value = this.dataset.quote_for || '';
    });
  });

  // Focus reference field and set default dates when modal opens
  var modalEl = document.getElementById('quotationModal');
  var modal = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false, focus: false });

  modalEl.addEventListener('shown.bs.modal', function() {
    // Focus reference
    setTimeout(function() {
      document.getElementById('q_reference').focus();
    }, 10);

    // Set today's date
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    document.getElementById('q_date').value = formattedToday;

    // Set valid until +30 days
    function setValidUntil(baseDate) {
      const validUntil = new Date(baseDate);
      validUntil.setDate(validUntil.getDate() + 30);
      const dd2 = String(validUntil.getDate()).padStart(2, '0');
      const mm2 = String(validUntil.getMonth() + 1).padStart(2, '0');
      const yyyy2 = validUntil.getFullYear();
      return `${yyyy2}-${mm2}-${dd2}`;
    }

    document.getElementById('q_valid_until').value = setValidUntil(today);

    // Update valid until if user edits date
    document.getElementById('q_date').addEventListener('change', function() {
      const newDate = new Date(this.value);
      document.getElementById('q_valid_until').value = setValidUntil(newDate);
    });
  });
});
</script>
