

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-12">
                    <form action="simple-results.html">
                        <div class="input-group">
                            <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mt-3">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead mb-0"><b><?php echo e($user->name); ?></b></h2>
                                    <p class="text-muted mt-0"><?php echo e($user->designation); ?></p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> email : <?php echo e($user->email); ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : <?php echo e($user->phone); ?></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <?php if($user && $user->user_dp && file_exists(storage_path('app/public/user_dp/' . $user->user_dp))): ?>

                                        <img class="rounded-circle me-3 " 
                                            src="<?php echo e(asset('storage/user_dp/' . $user->user_dp)); ?>" 
                                            alt="User profile picture" style="width:100px">

                                    <?php else: ?>
                                        <img src="<?php echo e(asset('assets/images/user_placeholder.jpg')); ?>" 
                                            alt="Profile Picture" 
                                            class="rounded-circle me-3" style="width:100px">
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="#" class="btn btn-sm bg-teal">
                                    <i class="fas fa-comments"></i>
                                </a>
                                <a href="<?php echo e(route('users.view',$user->id)); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> View User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </div>
            <!-- /.col -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/user/index.blade.php ENDPATH**/ ?>