

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mx-1 mt-3">
                <div class="col-sm-6">
                    <h1>User : <?php echo e($user->name); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/users">Users</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if(isset($user->user_dp) && file_exists('storage/user_dp/'.$user->user_dp)): ?>
                            <img class="rounded-circle img-fluid" src="<?php echo e(asset('storage/user_dp/'.$user->user_dp)); ?>"
                                alt="User profile picture" width="100" height="100">
                            <?php else: ?>
                            <img src="<?php echo e(asset('assets/images/user_placeholder.jpg')); ?>" alt="Profile Picture"
                                class="rounded-circle" width="100" height="100">
                            <?php endif; ?>

                            <h3 class="mt-2 mb-0"><?php echo e($user->name); ?></h3>
                            <?php if($user->roles->isNotEmpty()): ?>
    <p class="text-muted mb-0"><?php echo e($user->roles->first()->name); ?></p>
<?php else: ?>
    <p class="text-muted mb-0">No role assigned</p>
<?php endif; ?>

                            <ul class="list-group mt-3">
                                <li class="list-group-item text-start"><b>User ID :</b> <?php echo e($user->id); ?></li>
                                <li class="list-group-item text-start"><b>Phone :</b> <?php echo e($user->phone_no); ?></li>
                                <li class="list-group-item text-start"><b>Email :</b> <?php echo e($user->email); ?></li>
                                <li class="list-group-item text-start"><b>Status :</b> <?php echo e($user->status); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="text-center">User Account Actions</h3>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Status</b>
                                    <form action="<?php echo e(route('users.updateStatus')); ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                        <button class="btn btn-sm btn-primary" type="submit" name="action"
                                            value="Active">Activate</button>
                                        <button class="btn btn-sm btn-danger" type="submit" name="action"
                                            value="Inactive">Deactivate</button>
                                    </form>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Password</b>
                                    <form action="<?php echo e(route('users.resetPassword')); ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                        <button class="btn btn-sm btn-warning" type="submit">Reset Password</button>
                                    </form>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Profile Picture</b>
                                    <form action="<?php echo e(route('users.updateDP')); ?>" method="post" id="form-dp"
                                        enctype="multipart/form-data" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                        <input type="file" name="dp" id="dp" class="d-none"
                                            accept="image/png, image/jpg, image/jpeg" onchange="uploadDP()">
                                        <button class="btn btn-sm btn-secondary" type="button"
                                            onclick="openDP()">Update</button>
                                    </form>
                                    <script>
                                        // Function to open the file dialog
                                        function openDP() {
                                            document.getElementById('dp').click();
                                        }

                                        // Function to submit the form when file is selected
                                        function uploadDP() {
                                            document.getElementById('form-dp').submit();
                                        }
                                    </script>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="card">
                        <div class="card-body row align-items-center">
                            <div class="col-11">
                                <h3 class="text-center">User Roles</h3>
                            </div>
                            <div class="col-1 text-end">
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modal-user-permission">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="d-flex flex-wrap">
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <form action="<?php echo e(route('user.removeRole')); ?>" method="post" class="m-1">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                    <input type="hidden" name="role" value="<?php echo e($role->name); ?>">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary"><?php echo e($role->name); ?></button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </form>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            function openDP() {
                document.getElementById('dp').click();
            }
            function uploadDP() {
                document.getElementById('form-dp').submit();
            }
        </script>
    </section>

    <?php echo $__env->make('user.modals.user_role_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/user/view.blade.php ENDPATH**/ ?>