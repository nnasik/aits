<div class="row">
    <!--begin::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 1-->
        <div class="small-box <?php if($jobs_not_closed>0): ?> text-bg-danger <?php else: ?> text-bg-secondary <?php endif; ?>">
            <div class="inner">
                <h3><?php echo e($jobs_not_closed); ?></h3>

                <p>Jobs Not Closed</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true">
    <path d="M11.25 3.75a.75.75 0 011.5 0v12a.75.75 0 01-1.5 0v-12z"/>
    <circle cx="12" cy="19" r="1"/>
</svg>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View All <i class="bi bi-link-45deg"></i>
            </a>
        </div>
        <!--end::Small Box Widget 1-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 2-->
        <div class="small-box <?php if($jobs_open>0): ?> text-bg-warning <?php else: ?> text-bg-secondary <?php endif; ?> ">
            <div class="inner">
                <h3><?php echo e($jobs_open); ?></h3>

                <p>Jobs Open</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true">
    <path fill-rule="evenodd" clip-rule="evenodd"
        d="M6.75 2.25A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5A2.25 2.25 0 0019.5 19.5V8.56a2.25 2.25 0 00-.66-1.59l-3.56-3.56a2.25 2.25 0 00-1.59-.66H6.75zm6.75 1.94V8.25h4.06L13.5 4.19z"/>
</svg>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View All <i class="bi bi-link-45deg"></i>
            </a>
        </div>
        <!--end::Small Box Widget 2-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 3-->
        <div class="small-box  <?php if($jobs_pending>0): ?> text-bg-primary <?php else: ?> text-bg-secondary <?php endif; ?>">
            <div class="inner">
                <h3><?php echo e($jobs_pending); ?></h3>

                <p>Pending Jobs</p>
            </div>
            <svg class="small-box-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <!-- circular arrow -->
    <path d="M12 3a9 9 0 018.485 6h-2.06a.75.75 0 000 1.5h3.5a.75.75 0 00.75-.75V6.25a.75.75 0 00-1.5 0v1.87A10.5 10.5 0 1012 22.5a.75.75 0 000-1.5 9 9 0 010-18z"
        fill="currentColor"/>
    <!-- dotted arc -->
    <path d="M19.2 12.8a.9.9 0 110 1.8.9.9 0 010-1.8zm-1.2 2.9a.9.9 0 110 1.8.9.9 0 010-1.8zm-2.3 2.1a.9.9 0 110 1.8.9.9 0 010-1.8z"
        fill="currentColor"/>
    <!-- hourglass -->
    <path fill-rule="evenodd" clip-rule="evenodd"
        d="M9 6.25a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75c0 1.9-.95 2.9-1.95 3.7l-.55.45.55.45c1 .8 1.95 1.8 1.95 3.7a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75c0-1.9.95-2.9 1.95-3.7l.55-.45-.55-.45c-1-.8-1.95-1.8-1.95-3.7zm1.7.75c.2.6.7 1.05 1.3 1.55.6-.5 1.1-.95 1.3-1.55h-2.6zm2.6 8c-.2-.6-.7-1.05-1.3-1.55-.6.5-1.1.95-1.3 1.55h2.6z"
        fill="currentColor"/>
</svg>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View All <i class="bi bi-link-45deg"></i>
            </a>
        </div>
        <!--end::Small Box Widget 3-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
        <!--begin::Small Box Widget 4-->
        <div class="small-box <?php if($request_waiting>0): ?> text-bg-info <?php else: ?> text-bg-secondary <?php endif; ?> ">
            <div class="inner">
                <h3><?php echo e($request_waiting); ?></h3>

                <p>Waiting Request</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true">
    <path fill-rule="evenodd" clip-rule="evenodd"
        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm0 1.5a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z"/>
    <path fill-rule="evenodd" clip-rule="evenodd"
        d="M12 6a.75.75 0 01.75.75v5.25H16.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75V6.75A.75.75 0 0112 6z"/>
</svg>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View All <i class="bi bi-link-45deg"></i>
            </a>
        </div>
        <!--end::Small Box Widget 4-->
    </div>
    <!--end::Col-->
</div><?php /**PATH D:\xampp\htdocs\aits\resources\views/job/index/counts.blade.php ENDPATH**/ ?>