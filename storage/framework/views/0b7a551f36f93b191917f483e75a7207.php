<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('job.change_status_acc')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="work_order_id" id="modal_work_order_id">

        <div class="modal-header">
          <h5 class="modal-title" id="changeStatusModalLabel">Update Work Order Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row g-3">
          <!-- Invoice Status -->
          <div class="col-md-6">
            <label class="form-label">Invoice Status</label>
            <select class="form-select" name="invoice_status" id="modal_invoice_status" required>
              <option value="Waiting">Waiting</option>
              <option value="On Going">On Going</option>
              <option value="Completed">Completed</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Delivery Note Status -->
          <div class="col-md-6">
            <label class="form-label">Delivery Note Status</label>
            <select class="form-select" name="delivery_note_status" id="modal_delivery_note_status" required>
              <option value="Waiting">Waiting</option>
              <option value="On Going">On Going</option>
              <option value="Completed">Completed</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Invoice No -->
          <div class="col-md-6">
            <label class="form-label">Invoice No</label>
            <input type="text" class="form-control" name="invoice_no" id="modal_invoice_no">
          </div>

          <!-- Invoice Date -->
          <div class="col-md-6">
            <label class="form-label">Invoice Date</label>
            <input type="date" class="form-control" name="invoice_date" id="modal_invoice_date">
          </div>

          <!-- Invoice Amount -->
          <div class="col-md-6">
            <label class="form-label">Invoice Amount</label>
            <input type="number" step="0.01" class="form-control" name="invoice_amount" id="modal_invoice_amount">
          </div>

          <!-- Invoice Due Date -->
          <div class="col-md-6">
            <label class="form-label">Invoice Due Date</label>
            <input type="date" class="form-control" name="invoice_due_date" id="modal_invoice_due_date">
          </div>

          <!-- Payment Status -->
          <div class="col-md-6">
            <label class="form-label">Payment Status</label>
            <select class="form-select" name="payment_status" id="modal_payment_status" required>
              <option value="Unpaid">Unpaid</option>
              <option value="Paid">Paid</option>
              <option value="Partial">Partial</option>
            </select>
          </div>

          <!-- Delivery Note No -->
          <div class="col-md-6">
            <label class="form-label">Delivery Note No</label>
            <input type="text" class="form-control" name="delivery_note_no" id="modal_delivery_note_no">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openChangeStatusModal(id, invoiceStatus, deliveryStatus, invoiceNo, invoiceDate, invoiceAmount, invoiceDueDate, paymentStatus, deliveryNoteNo) {
    document.getElementById('modal_work_order_id').value = id;
    document.getElementById('modal_invoice_status').value = invoiceStatus || 'Waiting';
    document.getElementById('modal_delivery_note_status').value = deliveryStatus || 'Waiting';
    document.getElementById('modal_invoice_no').value = invoiceNo || '';
    document.getElementById('modal_invoice_date').value = invoiceDate || '';
    document.getElementById('modal_invoice_amount').value = invoiceAmount || '';
    document.getElementById('modal_invoice_due_date').value = invoiceDueDate || '';
    document.getElementById('modal_payment_status').value = paymentStatus || 'Unpaid';
    document.getElementById('modal_delivery_note_no').value = deliveryNoteNo || '';
}
</script><?php /**PATH D:\xampp\htdocs\aits\resources\views/job_acc/modal/change_status.blade.php ENDPATH**/ ?>