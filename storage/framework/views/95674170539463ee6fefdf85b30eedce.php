<!DOCTYPE html>
<html>
<head>
    <title>AITS Job Report - <?php echo e(auth::user()->name); ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <style>
        th, td { font-size: 13px; }
    </style>
</head>
<body>

<div class="container my-4">

    <h4 class="mb-3">AITS Job Report for <?php echo e(auth::user()->name); ?></h4>

    <!-- FILTERS -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">

            <!-- Job Status -->
            <select id="filter_job_status" class="form-select w-auto">
                <option value="">Job Status (All)</option>
                <?php $__currentLoopData = $workOrders->pluck('status')->unique()->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>"><?php echo e($s); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Payment Status -->
            <select id="filter_payment_status" class="form-select w-auto">
                <option value="">Payment Status (All)</option>
                <?php $__currentLoopData = $workOrders->pluck('payment_status')->unique()->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ps); ?>"><?php echo e($ps); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Invoice Filter Dropdown -->
            <select id="filter_invoice_null" class="form-select w-auto">
                <option value="">Unfiltered</option>
                <option value="null">No Invoice</option>
            </select>

            <!-- Invoice Search -->
            <input type="text" id="filter_invoice" class="form-control w-auto" placeholder="Invoice No">

        </div>
    </div>
</div>


    <!-- TABLE -->
    <table id="reportTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Company</th>
                <th>Job Status</th>
                <th>Training Status</th>
                <th>Certificate Status</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>Invoice Amount</th>
                <th>Invoice Due Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($wo->id); ?></td>
                <td><?php echo e($wo->date); ?></td>
                <td><?php echo e($wo->company_name_in_work_order); ?></td>
                <td><?php echo e($wo->status); ?></td>
                <td><?php echo e($wo->training_status); ?></td>
                <td><?php echo e($wo->certificate_status); ?></td>
                <td><?php echo e($wo->invoice_no); ?></td>
                <td><?php echo e($wo->invoice_date); ?></td>
                <td><?php echo e(number_format($wo->invoice_amount, 2)); ?></td>
                <td><?php echo e($wo->invoice_due_date); ?></td>
                <td><?php echo e($wo->payment_status); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- PDF export dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {

        let table = $('#reportTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 
                'excel', 
                'csv', 
                'print',
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ],
        });

        // JOB STATUS FILTER
        $('#filter_job_status').on('change', function () {
            table.column(3).search(this.value).draw();
        });

        // PAYMENT STATUS FILTER
        $('#filter_payment_status').on('change', function () {
            table.column(10).search(this.value).draw();
        });

        // INVOICE NUMBER SEARCH
        $('#filter_invoice').on('keyup', function () {
            table.column(6).search(this.value).draw();
        });

        // INVOICE NULL FILTER
        $('#filter_invoice_null').on('change', function () {
            if (this.value === 'null') {
                table.column(6).search("^$", true, false).draw(); // empty invoice
            } else {
                table.column(6).search("").draw();
            }
        });

    });
</script>

</body>
</html>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/reports/job.blade.php ENDPATH**/ ?>