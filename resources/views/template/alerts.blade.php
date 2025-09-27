{{-- Global Alerts (fixed at top) --}}
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080; width: 100%; max-width: 600px;">
    @if (session('success'))
        <div class="alert alert-close alert-success alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-close alert-danger alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-close alert-warning alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            document.querySelectorAll('.alert-close').forEach(el => {
                let alert = new bootstrap.Alert(el);
                alert.close();
            });
        }, 10000); // auto close after 5s
    });
</script>
