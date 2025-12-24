<!-- Create Training Modal -->
<div class="modal fade" id="createTrainingModal" tabindex="-1" aria-labelledby="createTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('trainings.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createTrainingModalLabel">Create Training</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Work Order (nullable, searchable dropdown) -->
                        <div class="col-md-6">
                            <label class="form-label">Work Order</label>
                            <select name="work_order_id" class="form-select select2">
                                <option value="">Select Work Order</option>
                                @foreach($workOrders as $wo)
                                    <option value="{{ $wo->id }}">
                                        {{ $wo->reference ?? $wo->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Training Course (required, searchable dropdown) -->
                        <div class="col-md-6">
                            <label class="form-label">Training Course <span class="text-danger">*</span></label>
                            <select name="training_course_id" class="form-select select2" required>
                                <option value="">Select Training Course</option>
                                @foreach($trainingCourses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Company (nullable, searchable dropdown) -->
                        <div class="col-md-6">
                            <label class="form-label">Company</label>
                            <select name="company_id" class="form-select select2">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Training Mode (required) -->
                        <div class="col-md-6">
                            <label class="form-label">Training Mode <span class="text-danger">*</span></label>
                            <select name="training_mode" class="form-select" required>
                                <option value="">Select Mode</option>
                                <option value="Online">Online</option>
                                <option value="Onsite">Onsite</option>
                                <option value="In-Class">In-Class</option>
                            </select>
                        </div>

                        <!-- Quantity (required) -->
                        <div class="col-md-4">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <!-- Scheduled Date (required) -->
                        <div class="col-md-4">
                            <label class="form-label">Scheduled Date <span class="text-danger">*</span></label>
                            <input type="date" name="scheduled_date" class="form-control" required>
                        </div>

                        <!-- Company Name in Certificate (nullable) -->
                        <div class="col-md-6">
                            <label class="form-label">Company Name (Certificate)</label>
                            <input type="text" name="company_name_in_certificate" class="form-control">
                        </div>

                        <!-- Course Title in Certificate (nullable) -->
                        <div class="col-md-6">
                            <label class="form-label">Course Title (Certificate)</label>
                            <input type="text" name="course_title_in_certificate" class="form-control">
                        </div>

                        <!-- Remarks (nullable textarea) -->
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Training</button>
                </div>
            </form>
        </div>
    </div>
</div>