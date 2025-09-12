<!DOCTYPE html>
<html>
<head>
    <title>Upload Photo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <h3>Upload Photo for {{ $trainee->name }}</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo" class="form-control" required>
        <button type="submit" class="btn btn-success mt-2">Upload</button>
    </form>
</div>
</body>
</html>
