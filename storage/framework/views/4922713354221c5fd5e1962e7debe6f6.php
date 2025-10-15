<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
  data-accordion="false" id="navigation">

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="bi bi-speedometer"></i>
      <p>
        Dashboard
        <i class="nav-arrow bi bi-chevron-right"></i>
      </p>
    </a>
  </li>
  <div id="server-time" style="font-size:18px;font-family:monospace;color:#fff;text-align:center;"></div>
  <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Sales')): ?>
  <li class="nav-item  menu-open">
    <a href="#" class="nav-link">
      <i class="bi bi-bar-chart"></i>
      <p>
        Sales
        <i class="nav-arrow bi bi-chevron-right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-people-fill"></i>
          <p>CRM</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-file-earmark-ruled"></i>
          <p>RFQs</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('company.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-building"></i>
          <p>Companies</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('jobrequest.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-suitcase-lg"></i>
          <p>Job Requests</p>
        </a>
      </li>
    </ul>
  </li>
  <?php endif; ?>

  <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Operations')): ?>
  <li class="nav-item menu-open">
    <a href="#" class="nav-link">
      <i class="bi bi-gear-fill"></i>
      <p>
        Operations
        <i class="nav-arrow bi bi-chevron-right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

      <li class="nav-item">
        <a href="<?php echo e(route('job.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-suitcase-lg"></i>
          <p>Jobs</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-calendar3"></i>
          <p>Trainings</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo e(route('certificate.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-patch-check"></i>
          <p>Certificates</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo e(route('trainee.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-person-video"></i>
          <p>Trainees</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-book"></i>
          <p>Training Courses</p>
        </a>
      </li>
    </ul>
  </li>
  <?php endif; ?>

  <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Accounts')): ?>
  <li class="nav-item menu-open">
    <a href="#" class="nav-link">
      <i class="bi bi-cash-coin"></i>
      <p>
        Accounts
        <i class="nav-arrow bi bi-chevron-right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="<?php echo e(route('job-acc.index')); ?>" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-suitcase-lg"></i>
          <p>Jobs</p>
        </a>
      </li>
    </ul>
    <!-- <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <div>  </div>
          <i class="nav-icon bi bi-file-earmark-text"></i>
          <p>Invoices</p>
        </a>
      </li>
    </ul> -->
  </li>
  <?php endif; ?>

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="bi bi-exclamation-octagon"></i>
      <p>Violations</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="bi bi-x-octagon"></i>
      <p>Issues</p>
    </a>
  </li>


  <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Developer|Admin')): ?>
  <li class="nav-item">
    <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
      <i class="bi bi-person"></i>
      <p>Users</p>
    </a>
  </li>
  <?php endif; ?>


<script>
(function() {
    // Get server time from PHP
    <?php
        $serverTime = date("Y-m-d H:i:s");
    ?>
    const serverTimeStr = "<?php echo e($serverTime); ?>";
    let currentTime = new Date(serverTimeStr);

    function updateClock() {
        currentTime.setSeconds(currentTime.getSeconds() + 1);

        const formatted = currentTime.getFullYear() + '-' +
            String(currentTime.getMonth() + 1).padStart(2, '0') + '-' +
            String(currentTime.getDate()).padStart(2, '0') + ' ' +
            String(currentTime.getHours()).padStart(2, '0') + ':' +
            String(currentTime.getMinutes()).padStart(2, '0') + ':' +
            String(currentTime.getSeconds()).padStart(2, '0');

        document.getElementById("server-time").textContent = formatted;
    }

    // Initial display
    updateClock();

    // Update every 1 second
    setInterval(updateClock, 1000);
})();
</script>


  <!-- 
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>
                    Layout Options
                    <span class="nav-badge badge text-bg-secondary me-3">6</span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./layout/unfixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Default Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-footer.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Footer</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-complete.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Complete</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-custom-area.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout <small>+ Custom Area </small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/sidebar-mini.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/collapsed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Collapsed</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/logo-switch.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Logo Switch</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-rtl.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout RTL</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-tree-fill"></i>
                  <p>
                    UI Elements
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./UI/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/icons.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Icons</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/timeline.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Timeline</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>
                    Forms
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./forms/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General Elements</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Tables
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./tables/simple.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Simple Tables</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">EXAMPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right"></i>
                  <p>
                    Auth
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="./examples/lockscreen.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Lockscreen</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">DOCUMENTATIONS</li>
              <li class="nav-item">
                <a href="./docs/introduction.html" class="nav-link">
                  <i class="nav-icon bi bi-download"></i>
                  <p>Installation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Layout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Color Mode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-ui-checks-grid"></i>
                  <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Sidebar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-filetype-js"></i>
                  <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Treeview</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                  <i class="nav-icon bi bi-browser-edge"></i>
                  <p>Browser Support</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                  <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                  <p>How To Contribute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                  <i class="nav-icon bi bi-question-circle-fill"></i>
                  <p>FAQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/license.html" class="nav-link">
                  <i class="nav-icon bi bi-patch-check-fill"></i>
                  <p>License</p>
                </a>
              </li>
              <li class="nav-header">MULTI LEVEL EXAMPLE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>
                    Level 1
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Level 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-header">LABELS</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-danger"></i>
                  <p class="text">Important</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-warning"></i>
                  <p>Warning</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-info"></i>
                  <p>Informational</p>
                </a>
              </li> -->
</ul><?php /**PATH D:\xampp\htdocs\aits\resources\views/template/sidebar.blade.php ENDPATH**/ ?>