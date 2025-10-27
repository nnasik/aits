<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verified Certificate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add this once in your layout (if not already included) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .certificate-container {
      max-width: 1100px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .certificate-image {
      background: #eee;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .certificate-image img {
      width: 100%;
      height: auto;
      display: block;
    }

    .certificate-details {
      padding: 40px;
    }

    .certificate-details h2 {
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .certificate-details p {
      margin-bottom: 8px;
    }

    .label {
      font-weight: 500;
      color: #555;
    }

    .value {
      font-weight: 600;
      color: #000;
    }
  </style>
</head>

<body>

  <div class="certificate-container row g-0">
    <div class="col-md-6 certificate-image">
      <!-- Left side: certificate image -->
      <iframe src="<?php echo e(route('certificate.preview', $certificate->id)); ?>" width="100%"
        style="width:100%; height:100vh; border:none;">
      </iframe>
    </div>
    <div class="col-md-6 certificate-details">
      <h2>
        <span class="<?php echo e(now()->gt($certificate->valid_unit) ? 'text-danger' : 'text-success'); ?>">
          <?php if(now()->gt($certificate->valid_unit)): ?>
          <i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>
          Expired Certificate
          <?php else: ?>
          <i class="fa-solid fa-circle-check" style="color: #28a745;"></i>
          Verified Certificate
          <?php endif; ?>
        </span>
      </h2>
      <p><span class="label">This certificate was issued by:</span><br>
        <span class="value">AMERICAN INTERNATIONAL TRAINING SERVICES L.L.C</span>
      </p>
      <div class="row">
        <div class="col-3">
          <img src="<?php echo e(asset('storage/'.$certificate->live_photo)); ?>" alt="Candidate Photo" width="100">
        </div>
        <div class="col-8">
          <div class="row">
            <div class="row">
              <p><span class="label">Certificate Title:</span><br>
                <span class="value"><?php echo e($certificate->course_name_in_certificate); ?></span>
              </p>
            </div>
            <div class="row">
              <p><span class="label">Name of Recipient:</span><br>
                <span class="value"><?php echo e($certificate->candidate_name_in_certificate); ?></span>
              </p>
            </div>
          </div>
        </div>
      </div>




      <p><span class="label">Company / Employer:</span><br>
        <span class="value"><?php echo e($certificate->company_name_in_certificate); ?></span>
      </p>

      <div class="row">
        <div class="col">
          <p><span class="label">Issue Date:</span><br>
            <span class="value"><?php echo e($certificate->date); ?></span>
          </p>
        </div>
        <div class="col">
          <p><span class="label">Valid Until:</span><br>
            <span class="value"><?php echo e($certificate->valid_unit); ?></span>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <p><span class="label">Certificate ID:</span><br>
            <span class="value"><?php echo e($certificate->id); ?></span>
          </p>
        </div>
        <div class="col">
          <p><span class="label">Status:</span><br>
            <span class="value">
              <?php if(now()->gt($certificate->valid_unit)): ?>
              <span class="badge bg-danger">Expired</span>
              <?php else: ?>
              <span class="badge bg-success">Active</span>
              <?php endif; ?>
            </span>
          </p>
        </div>
      </div>

      <div class="row">
        <p class="text-muted small">
          Note : This certificate confirms that the recipient has successfully met the required standards and
          competencies for
          the
          designated certification. The validity of this certification remains in effect until the date specified above,
          unless
          revoked or suspended by the issuing authority.
        </p>

      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH D:\xampp\htdocs\aits\resources\views/public/verification.blade.php ENDPATH**/ ?>