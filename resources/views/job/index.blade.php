@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Jobs Dashboard</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item">Jobs (All)</li>
          
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
    <div class="row">
      @include('job.index.counts')
    </div>
    
    <div class="row my-3 px-1">
      <div class="col-md-12">
          <form action="{{route('job.index')}}">
            @csrf
            <div class="input-group">
              <input type="search" class="form-control form-control-lg" placeholder="Job No | Company Name"
                name="search" @if(isset($search)) value="{{$search}}" @endif>
              <div class="input-group-append">
                <button type="submit" class="btn btn-outline-dark btn-lg btn-default">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
    </div>
<!--begin::Row-->
    <div class="row mx-0">
      <div class="col-6">
        <h3 class="mb-0">Jobs</h3>
      </div>
      <!-- <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="bi bi-plus-lg"></i> Job
        </button>
      </div> -->
</div>

<script>
    /**
     * Opens the Update Work Order Status modal and populates fields
     * @param {Object} workOrder - The work order object containing id and current statuses
     */
    function openUpdateWorkOrderModal(workOrder) {
        // Set dropdown values
        document.getElementById('training_status').value = workOrder.training_status ?? 'Waiting';
        document.getElementById('certificate_status').value = workOrder.certificate_status ?? 'Waiting';

        // Show modal
        new bootstrap.Modal(document.getElementById('updateWorkOrderModal')).show();
    }
</script>

    @include('job.index.table')
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job.modals.change_status')
  @include('job.modals.change_job_status')
  @endsection()