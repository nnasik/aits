<!-- script.blade.php -->
<script>
let rowsBody;
let rowTemplate;
let discountModal;

// --- Functions ---

function calcRow(row) {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const discount = parseFloat(row.querySelector('.discount').value) || 0;
    row.querySelector('.total').value = (qty * price - discount).toFixed(2);
    calcSummary();
}

function calcSummary() {
    let sub = 0;
    document.querySelectorAll('.total').forEach(t => sub += parseFloat(t.value) || 0);
    const overall = parseFloat(document.getElementById('overall_discount').value) || 0;
    const vat = (sub - overall) * 0.05;
    const grand = (sub - overall) + vat;
    document.getElementById('sub_total').textContent = sub.toFixed(2);
    document.getElementById('vat').textContent = vat.toFixed(2);
    document.getElementById('grand_total').textContent = grand.toFixed(2);
    document.getElementById('overall_discount_display').textContent = overall.toFixed(2);
}

function addRow() {
    const clone = rowTemplate.cloneNode(true);
    clone.removeAttribute('id');
    clone.classList.remove('d-none');

    // Initialize empty fields
    clone.querySelector('.trainingSelect').selectedIndex = 0;
    clone.querySelector('.trainingName').value = '';
    clone.querySelector('.duration').value = '';
    clone.querySelector('.price').value = 0;
    clone.querySelector('.qty').value = 1;
    clone.querySelector('.discount').value = 0;
    clone.querySelector('.total').value = 0;
    clone.querySelector('.delivery').value = 'In-Class';

    rowsBody.appendChild(clone);
    calcRow(clone);
}

function handleInput(e) {
    const row = e.target.closest('tr');
    if (!row) return;

    if (e.target.classList.contains('trainingSelect')) {
        const opt = e.target.selectedOptions[0];
        row.querySelector('.trainingName').value = opt.dataset.name || '';
        row.querySelector('.duration').value = opt.dataset.duration || '';
        row.querySelector('.price').value = opt.dataset.price || 0;
        row.querySelector('.discount').value = 0;
        calcRow(row);
    }

    if (['qty', 'price', 'discount'].some(c => e.target.classList.contains(c))) {
        calcRow(row);
    }
}

function removeRow(e) {
    if (e.target.closest('.removeRow')) {
        e.target.closest('tr').remove();
        calcSummary();
    }
}

function saveDiscount() {
    const value = parseFloat(document.getElementById('modal_discount').value) || 0;
    document.getElementById('overall_discount').value = value;
    calcSummary();
    discountModal.hide();
}

// --- Initialize on DOM load ---
function initQuotationScript() {
    rowsBody = document.getElementById('rowsBody');
    rowTemplate = document.getElementById('rowTemplate');
    discountModal = new bootstrap.Modal(document.getElementById('discountModal'));

    // Calculate totals for existing rows
    if (rowsBody.querySelectorAll('tr').length > 0) {
        rowsBody.querySelectorAll('tr').forEach(row => calcRow(row));
    }

    // Event listeners
    document.getElementById('addRow').addEventListener('click', addRow);
    document.addEventListener('input', handleInput);
    document.addEventListener('click', removeRow);
    document.getElementById('saveDiscount').addEventListener('click', saveDiscount);
}

// --- Run on DOMContentLoaded ---
document.addEventListener('DOMContentLoaded', initQuotationScript);
</script>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/view/script.blade.php ENDPATH**/ ?>