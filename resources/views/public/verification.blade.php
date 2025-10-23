<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>
</head>
<body>
    <h1>Certificate Verified</h1>
    <p><strong>Certificate No:</strong> {{ $certificate->id }}</p>
    <p><strong>Job No:</strong> {{ $certificate->trainee->training->job->id }}</p>
    <p><strong>Candidate Name:</strong> {{ $certificate->candidate_name_in_certificate }}</p>
    <p><strong>Course Name:</strong> {{ $certificate->course_name }}</p>
    <p><strong>Company Name:</strong> {{ $certificate->company_name_in_certificate }}</p>
    <p><strong>Issued Date:</strong> {{ $certificate->issued_date }}</p>
    <p><strong>Valid Until:</strong> {{ $certificate->issued_date }}</p>
</body>
</html>
