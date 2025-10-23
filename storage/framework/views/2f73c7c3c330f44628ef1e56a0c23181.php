<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>
</head>
<body>
    <h1>Certificate Verified</h1>
    <p><strong>Certificate No:</strong> <?php echo e($certificate->id); ?></p>
    <p><strong>Job No:</strong> <?php echo e($certificate->trainee->training->job->id); ?></p>
    <p><strong>Candidate Name:</strong> <?php echo e($certificate->candidate_name_in_certificate); ?></p>
    <p><strong>Course Name:</strong> <?php echo e($certificate->course_name); ?></p>
    <p><strong>Company Name:</strong> <?php echo e($certificate->company_name_in_certificate); ?></p>
    <p><strong>Issued Date:</strong> <?php echo e($certificate->issued_date); ?></p>
    <p><strong>Valid Until:</strong> <?php echo e($certificate->issued_date); ?></p>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\aits\resources\views/public/verification.blade.php ENDPATH**/ ?>