@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">New Requests</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item">New Job Requests (All)</li>
          
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

    {{--@include('job.index.counts')--}}
    

    <div class="row">
      <div class="col-6">
        <h3 class="mb-0"></h3>
      </div>
    </div>

    @include('job.index.table_request')

<script>
    /**
     * Opens the Update Work Order Status modal and populates fields
     * @param {Object} workOrder - The work order object containing id and current statuses
     */
    function openUpdateWorkOrderModal(workOrder) {
        // Set hidden input
        document.getElementById('work_order_id').value = workOrder.id;

        // Set dropdown values
        document.getElementById('training_status').value = workOrder.training_status ?? 'Waiting';
        document.getElementById('certificate_status').value = workOrder.certificate_status ?? 'Waiting';

        // Show modal
        new bootstrap.Modal(document.getElementById('updateWorkOrderModal')).show();
    }
</script>
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job.modals.accept_request')
  @include('job.modals.change_status')
  @include('job.modals.change_job_status')
  @endsection()