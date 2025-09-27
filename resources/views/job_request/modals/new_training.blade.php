<!-- Modal -->
<div class="modal fade" id="addRow" tabindex="-1" aria-labelledby="addRowLabel" aria-hidden="true">
  <form action="{{route('trainingrequest.store')}}" method="post">
    @csrf
    <input type="hidden" name="work_order_id" value="{{$job_request->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRowLabel">New Training Request</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          
          <!-- Training Courses Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text">Course</span>
            <select class="form-select" name="course_id" id="courseSelect" required>
              <option value="" selected disabled>Select Course</option>
              @foreach($courses as $course)
                <option value="{{$course->id}}">{{$course->name}}</option>
              @endforeach
            </select>
          </div>

          <!-- Course name certificate -->
          <div class="input-group mb-3">
            <span class="input-group-text">Certificate Title</span>
            <input type="text" class="form-control" name="course_title_in_certificate" id="certificateTitle" placeholder="Course name in certificate" required>
          </div>

          <!-- Course name certificate -->
          <div class="input-group mb-3">
            <span class="input-group-text">Certificate for</span>
            <input type="text" class="form-control" name="company_name_in_certificate" placeholder="Company name in certificate" required value="{{$job_request->company_name_in_work_order}}">
          </div>

          <script>
            document.getElementById('courseSelect').addEventListener('change', function () {
                let selectedText = this.options[this.selectedIndex].text;
                document.getElementById('certificateTitle').value = selectedText;
            });
          </script>

          <!-- Quantity -->
          <div class="input-group mb-3">
            <span class="input-group-text">Qty</span>
            <input type="number" class="form-control" name="quantity" min="1" value="1" placeholder="Enter quantity" required>
          </div>

          <!-- Training Mode Dropdown -->
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Training Mode</span>
            <select class="form-control" id="trainingMode" name="training_mode">
              <option value="Certification" @if($job_request->training_mode=='Certification') selected @endif>Certification</option>
              <option value="In-Class" @if($job_request->training_mode=='In-Class') selected @endif>In-Class</option>
              <option value="Online" @if($job_request->training_mode=='Online') selected @endif>Online</option>
              <option value="On-Site" @if($job_request->training_mode=='On-Site') selected @endif>On-Site</option>
            </select>
            <span class="input-group-text" id="basic-addon1">
              <input type="checkbox" name="zoom" id="">Schedule Zoom</span>
          </div>

          <!-- Scheduled Date -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training Date</span>
            <input type="date" class="form-control" name="requesting_date" placeholder="Scheduled Date" required>
          </div>

          <!-- Shceduled Time -->
          <div class="input-group mb-3">
            <span class="input-group-text">Training Time</span>
            <input type="time" class="form-control" name="requesting_time" placeholder="Scheduled Time">
          </div>

          <!-- Remark -->
          <div class="input-group mb-3">
            <span class="input-group-text">Remark</span>
            <input type="text" class="form-control" name="remarks" placeholder="Optional remark">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>
      </div>
    </div>
  </form>
</div>
