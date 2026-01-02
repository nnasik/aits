

<?php $__env->startSection('content'); ?>

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Certificates</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item active" aria-current="page">Issued</li>
          <li class="breadcrumb-item">Certificates</li>
        </ol>
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">

    <!--begin::Row-->
    <div class="row">
      <h3 class="mb-0">Certificates Issued</h3>
      <div class="row mt-3">

        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="key" value="certificate_bg">

            <div class="btn-group mb-2" role="group" aria-label="Background selector">
              <label class="btn btn-outline-primary">Background</label>

              <input type="radio" class="btn-check" name="value" id="bg_white" value="0" onchange="this.form.submit()"
                <?php echo e((isset($user_settings['certificate_bg']) && $user_settings['certificate_bg']==0) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="bg_white">White</label>

              <input type="radio" class="btn-check" name="value" id="bg_v1" value="1" onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_bg']) && $user_settings['certificate_bg']==1) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="bg_v1">V1</label>

              <input type="radio" class="btn-check" name="value" id="bg_v2" value="2" onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_bg']) && $user_settings['certificate_bg']==2) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="bg_v2">V2</label>

              <input type="radio" class="btn-check" name="value" id="bg_v3" value="3" onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_bg']) && $user_settings['certificate_bg']==3) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="bg_v3">V3</label>
            </div>
          </form>


        </div>

        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="key" value="certificate_quality_option">

    <div class="btn-group mb-2" role="group" aria-label="Quality options">
        <label class="btn btn-outline-primary">Quality</label>

        <input type="radio" class="btn-check" name="value" id="quality_print" value="0" autocomplete="off"
            onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_quality_option']) && $user_settings['certificate_quality_option']==0 ) ? 'checked' : ''); ?>>
        <label class="btn btn-outline-primary" for="quality_print">Print</label>

        <input type="radio" class="btn-check" name="value" id="quality_digital" value="1" autocomplete="off"
            onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_quality_option']) && $user_settings['certificate_quality_option']==1 ) ? 'checked' : ''); ?>>
        <label class="btn btn-outline-primary" for="quality_digital">Digital</label>
    </div>
</form>
        </div>


        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="key" value="certificate_signature_option">

            <div class="btn-group mb-2" role="group" aria-label="Signature options">
              <label class="btn btn-outline-primary">Signature</label>

              <input type="radio" class="btn-check" name="value" id="signature_empty" value="0" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_signature_option']) &&
                $user_settings['certificate_signature_option']==0 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="signature_empty">Empty</label>

              <input type="radio" class="btn-check" name="value" id="signature_v1" value="1" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_signature_option']) &&
                $user_settings['certificate_signature_option']==1 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="signature_v1">V1</label>

              <input type="radio" class="btn-check" name="value" id="signature_v2" value="2" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_signature_option']) &&
                $user_settings['certificate_signature_option']==2 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="signature_v2">V2</label>

              <input type="radio" class="btn-check" name="value" id="signature_v3" value="3" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_signature_option']) &&
                $user_settings['certificate_signature_option']==3 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="signature_v3">V3</label>
            </div>
          </form>
        </div>

        

        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="key" value="certificate_stamp_option">

            <div class="btn-group mb-2" role="group" aria-label="Stamp options">
              <label class="btn btn-outline-primary">AITS Stamp</label>

              <input type="radio" class="btn-check" name="value" id="stamp_off" value="0" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_stamp_option']) &&
                $user_settings['certificate_stamp_option']==0 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="stamp_off">Off</label>

              <input type="radio" class="btn-check" name="value" id="stamp_on" value="1" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_stamp_option']) &&
                $user_settings['certificate_stamp_option']==1 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="stamp_on">On</label>
            </div>
          </form>
        </div>

        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="key" value="certificate_qr_option">

            <div class="btn-group mb-2" role="group" aria-label="QR options">
                <label class="btn btn-outline-primary">QR</label>

                <input type="radio" class="btn-check" name="value" id="qr_off" value="0" autocomplete="off"
                    onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_qr_option']) && $user_settings['certificate_qr_option']==0 ) ? 'checked' : ''); ?>>
                <label class="btn btn-outline-primary" for="qr_off">Off</label>

                <input type="radio" class="btn-check" name="value" id="qr_left" value="1" autocomplete="off"
                    onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_qr_option']) && $user_settings['certificate_qr_option']==1 ) ? 'checked' : ''); ?>>
                <label class="btn btn-outline-primary" for="qr_left">Left</label>

                <input type="radio" class="btn-check" name="value" id="qr_right" value="2" autocomplete="off"
                    onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_qr_option']) && $user_settings['certificate_qr_option']==2 ) ? 'checked' : ''); ?>>
                <label class="btn btn-outline-primary" for="qr_right">Right</label>
            </div>
        </form>

        </div>

        <div class="col">
          <form method="POST" action="<?php echo e(route('change.user.settings')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="key" value="certificate_idcard_option">

            <div class="btn-group mb-2" role="group" aria-label="ID Card options">
              <label class="btn btn-outline-primary">Card</label>

              <input type="radio" class="btn-check" name="value" id="idcard_v1" value="1" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_idcard_option']) &&
                $user_settings['certificate_idcard_option']==1 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="idcard_v1">V1</label>

              <input type="radio" class="btn-check" name="value" id="idcard_v2" value="2" autocomplete="off"
                onchange="this.form.submit()" <?php echo e((isset($user_settings['certificate_idcard_option']) &&
                $user_settings['certificate_idcard_option']==2 ) ? 'checked' : ''); ?>>
              <label class="btn btn-outline-primary" for="idcard_v2">V2</label>
            </div>
          </form>
        </div>






      </div>

      <?php echo $__env->make('certificate.index.certificate_table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <!--end::Row-->

    <!--end::Container-->
  </div>
  <!--end::App Content-->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\aits\resources\views/certificate/index.blade.php ENDPATH**/ ?>