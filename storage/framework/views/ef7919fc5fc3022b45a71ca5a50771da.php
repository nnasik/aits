<div class="row m-3">
    <div class="col-12">
        <table>
            <tr>
                <td>Prepared By :</td>
                <td><strong><?php echo e(auth()->user()->name); ?></strong></td>
            </tr>
            <tr>
                <td>Email :</td>
                <td><strong><?php echo e(auth()->user()->email); ?></strong></td>
            </tr>
            <tr>
                <td>Phone :</td>
                <td><strong><?php echo e(auth()->user()->phone_no); ?></strong></td>
            </tr>
        </table>
    </div>
</div>

<div class="row m-3 text-muted">
    <div class="col text-start">Doc No : <span class="fst-italic">QHSE/FS-AITS-CQ-001</span></div>
    <div class="col text-center">REV : <span class="fst-italic">00</span></div>
    <div class="col text-end">Date : <span class="fst-italic">2025-12-16</span></div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/view/footer.blade.php ENDPATH**/ ?>