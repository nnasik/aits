<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo e(route('company.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">New Company</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Company Name</span>
            <input type="text" class="form-control" name="name">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-success" value="Create">
        </div>
      </div>
    </div>
  </form>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/company/modals/new_company.blade.php ENDPATH**/ ?>