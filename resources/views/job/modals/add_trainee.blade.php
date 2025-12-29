<!-- Create Training Trainee Modal -->
<div class="modal fade" id="createTraineeModal" tabindex="-1" aria-labelledby="createTraineeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="createTraineeModalLabel">New Trainee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('trainee.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="training_id" value="{{$training->id}}">

        <div class="modal-body row g-3">
          

          <div class="col-md-6">
            <label class="form-label">Candidate Name</label>
            <input type="text" class="form-control" name="candidate_name_in_certificate" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name_in_certificate" value="{{$training->company_name_in_certificate}}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Course Name</label>
            <input type="text" class="form-control" name="course_name_in_certificate" value="{{$training->course_title_in_certificate}}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Live Photo</label>
            <input type="file" class="form-control" name="live_photo" accept=".jpg,.jpeg,.png,.pdf">
          </div>

          <div class="col-md-6">
            <label class="form-label">EID No</label>
            <input type="text" class="form-control" name="eid_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{$training->scheduled_date}}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Passport No</label>
            <input type="text" class="form-control" name="passport_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL No</label>
            <input type="text" class="form-control" name="dl_no">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL Issued</label>
            <input type="date" class="form-control" name="dl_issued">
          </div>

          <div class="col-md-6">
            <label class="form-label">DL Expiry</label>
            <input type="date" class="form-control" name="dl_expiry">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add Trainee</button>
        </div>
      </form>

    </div>
  </div>
</div>