<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AITS-Information System — Login</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --left-bg-1: #1f2aa6;
      --left-bg-2: #3e2bdc;
      --accent-white: #ffffff;
      --panel-radius: 12px;
    }

    html,body{height:100%;}
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:#f5f6f8;
    }

    .split {
      min-height:100vh;
      display:flex;
      flex-wrap:nowrap;
    }

    /* LEFT PANEL */
    .left {
      flex: 1 1 60%;
      min-width: 320px;
      padding: 56px;
      color: var(--accent-white);
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: radial-gradient(1200px 600px at 10% 10%, rgba(255,255,255,0.03), transparent),
                  linear-gradient(135deg, var(--left-bg-1) 0%, var(--left-bg-2) 100%);
      overflow: hidden;
    }
    /* decorative concentric arcs */
    .left svg.arcs{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      pointer-events:none;
      opacity:0.12;
    }

    .brand-star{
      width:64px;
      height:64px;
      background:rgba(255,255,255,0.12);
      display:inline-flex;
      align-items:center;
      justify-content:center;
      border-radius:10px;
      margin-bottom:24px;
    }
    .brand-star svg{fill: white; opacity:0.95;}

    .left h1{
      font-weight:700;
      font-size: clamp(2rem, 6vw, 4.4rem);
      line-height: 1.02;
      margin:0 0 18px 0;
      letter-spacing:-0.6px;
    }
    .left p.lead{
      font-size:1.05rem;
      opacity:0.95;
      max-width: 56ch;
      margin-bottom: 20px;
    }

    .left .footer-small{
      position:absolute;
      left:56px;
      bottom:20px;
      opacity:0.22;
      font-size:0.9rem;
    }

    /* RIGHT PANEL */
    .right {
      width: 420px;
      max-width: 42%;
      min-width: 300px;
      background: #fff;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:48px 36px;
      box-shadow: -60px 0 90px -60px rgba(46,47,67,0.08);
    }

    .login-box{
      width:100%;
      max-width:360px;
    }

    .app-name{
      font-weight:700;
      font-size:1.25rem;
    }
    .welcome-title{
      font-size:1.6rem;
      font-weight:700;
      margin-top:12px;
      margin-bottom:8px;
    }
    .muted-small{
      color:#6b7280;
      font-size:0.95rem;
      margin-bottom:18px;
    }

    .btn-login {
      background:#111111;
      color:#fff;
      border:none;
      height:44px;
      border-radius:8px;
      font-weight:600;
    }

    /* form controls styling similar to screenshot lines */
    .form-control {
      border-radius:6px;
      height:44px;
      box-shadow:none;
    }

    .line-input {
      border:0;
      border-bottom:1px solid #ddd;
      border-radius:0.25rem;
      padding-left:0.75rem;
      padding-right:0.75rem;
      background:transparent;
    }
    .line-input:focus{
      box-shadow:none;
      border-bottom-color:#9ca3ff;
    }

    /* responsive: stack on small */
    @media (max-width: 900px){
      .split {
        flex-direction: column;
      }
      .right{
        width:100%;
        max-width:100%;
        min-width:0;
        padding:36px 20px;
      }
      .left{
        min-height:40vh;
        padding:36px 20px;
      }
      .left .footer-small{left:20px;}
    }

  </style>
</head>
<body>

  <div class="split">

    <!-- LEFT: big blue area -->
    <div class="left">
      <div class="brand-star" aria-hidden="true">
        <!-- simple asterisk/star icon -->
        <svg viewBox="0 0 24 24" width="32" height="32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M12 2l1.9 4.75L19 8.1l-3.5 2.9L16 16l-4-2.1L8 16l.47-4.99L5 8.1l5.1-1.35L12 2z"/>
        </svg>
      </div>

      <h1>
        Hello AITS-Information System!
      </h1>

      <p class="lead">
        Skip repetitive administrative tasks and get highly productive through automation secure, fast, and designed for the organization.
      </p>

      <!-- optional small tagline or features -->
      <div style="opacity:0.9;">
        <ul style="padding-left:1.1rem; margin:0; list-style: none;">
          <li style="margin-bottom:6px;">• Smart CRM with client history tracking</li>
          <li style="margin-bottom:6px;">• Quick quotations & automated approvals</li>
          <li style="margin-bottom:6px;">• Streamlined job requests & assignments</li>
          <li style="margin-bottom:6px;">• Real-time job progress monitoring</li>
          <li style="margin-bottom:6px;">• Staff training & compliance management</li>
          <li style="margin-bottom:6px;">• Digital certificates & secure ID issuance</li>
          <li style="margin-bottom:6px;">• Simplified invoicing & payment tracking</li>
          <li style="margin-bottom:6px;">• Quality checks with audit-ready QC logs</li>
          <li style="margin-bottom:6px;">• Centralized records & access control</li>
          <li style="margin-bottom:6px;">• Comprehensive reporting & analytics</li>
        </ul>
      </div>


      <!-- decorative SVG arcs (concentric) -->
      <svg class="arcs" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
        <g fill="none" stroke="#ffffff" stroke-width="0.6">
          <path d="M0,100 C20,60 40,40 100,0" stroke-opacity="0.03"></path>
          <path d="M0,100 C30,70 50,50 100,10" stroke-opacity="0.035"></path>
          <path d="M0,100 C40,80 60,60 100,20" stroke-opacity="0.04"></path>
          <path d="M0,100 C50,90 70,70 100,30" stroke-opacity="0.045"></path>
        </g>
      </svg>

      <div class="footer-small">© 2025 AITS-Information System. All rights reserved.</div>
    </div>

    <!-- RIGHT: login form -->
    <div class="right">
      <div class="login-box">

        <div class="mb-3">
          <div class="app-name">AITS-Information System</div>
        </div>

        <h2 class="welcome-title">Welcome Back!</h2>
        <div class="muted-small">Please sign in to continue to the system.</div>

        <!-- Laravel alert/status & validation area -->
        <?php if(session('status')): ?>
          <div class="alert alert-success small" role="alert"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
          <div class="alert alert-danger small" role="alert"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
          <div class="alert alert-danger small" role="alert">
            <ul class="mb-0 ps-3">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
          <?php echo csrf_field(); ?>

          <!-- Username / Email (Laravel expects 'email' by default) -->
          <div class="mb-3">
            <label for="email" class="form-label small fw-semibold">Username / Email</label>
            <input
              type="email"
              id="email"
              name="email"
              value="<?php echo e(old('email')); ?>"
              required
              autofocus
              class="form-control line-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
              aria-describedby="emailHelp"
              placeholder="you@example.com">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label small fw-semibold">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              class="form-control line-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
              placeholder="Enter your password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <!-- Remember Me -->
          <div class="mb-3 form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="remember"
                   name="remember"
                   value="1" <?php echo e(old('remember') ? 'checked' : ''); ?>>
            <label class="form-check-label small" for="remember">Remember me</label>
          </div>

          <!-- Submit -->
          <div class="d-grid mb-2">
            <button type="submit" class="btn btn-login">Login</button>
          </div>

          <!-- space for potential generic auth error that Laravel might set -->
          <?php if(session('login_error')): ?>
            <div class="text-danger small mt-1"><?php echo e(session('login_error')); ?></div>
          <?php endif; ?>

        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/auth/login.blade.php ENDPATH**/ ?>