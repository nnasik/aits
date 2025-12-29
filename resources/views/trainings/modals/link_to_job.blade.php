<!-- Link Training to Job Modal -->
<div class="modal fade" id="linkTrainingModal" tabindex="-1" aria-labelledby="linkTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('training.linkjob') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="linkTrainingModalLabel">Link Training to Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Hidden Readonly Field -->
                        <div class="col-md-12">
                             <label class="form-label">Training ID <span class="text-danger">*</span></label>
                            <input type="text" name="training_id" id="training_id" class="form-control" readonly>
                        </div>

                        <!-- Select Job (required, searchable dropdown) -->
                        <div class="col-md-12">
                            <label class="form-label">Job <span class="text-danger">*</span></label>
                            <select name="job_id" class="form-select select2" required>
                                <option value="">Select Job</option>
                                @foreach($jobs as $job)
                                    <option value="{{ $job->id }}">AITS-{{$job->id}} : {{$job->company_name_in_work_order}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Link Training</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Initialize Select2 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.select2').select2({
        dropdownParent: $('#linkTrainingModal')
    });
});

// Function to open modal and set readonly field
function openLinkTrainingModal(value) {
    document.getElementById('training_id').value = value;
    var linkModal = new bootstrap.Modal(document.getElementById('linkTrainingModal'));
    linkModal.show();
}
</script>