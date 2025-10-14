<div class="modal fade" id="modal-user-permission" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">User Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo e(route('user.addRole')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">

                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="role" class="col-md-4 col-form-label text-md-end">Select Role</label>
                        <div class="col-md-8">
                            <select class="form-select" name="role" id="role">
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Permission</button>
                </div>
            </form>
            
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/user/modals/user_role_modal.blade.php ENDPATH**/ ?>