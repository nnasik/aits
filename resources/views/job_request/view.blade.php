@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job Request</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item active" aria-current="page">Job Request ({{$job_request->id}})</li>
          <li class="breadcrumb-item active" aria-current="page"><a href="{{route('jobrequest.index')}}">All</a></li>
          <li class="breadcrumb-item">Job Request</li>
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
    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Job Request - {{$job_request->id}}</h3>
      </div>
    </div>

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request No</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->id}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->requester->name}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Requested On</span>
          <input type="text" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="{{$job_request->requested_on}}">
        </div>
      </div>
    </div>

    <!-- ROW-2 -->
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Client / Company</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->company->name}}" readonly>
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Training Mode</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->training_mode}}" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Company Name in Job</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->company_name_in_work_order}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request Status</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job_request->request_status}}" readonly>
        </div>
      </div>
    </div>

    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Trainings</h3>
      </div>
    </div>
    <!-- Table -->

    <!-- ROW-5 -->
    <div class="row">
      <div class="col-sm-12 text-end">
        <button type="button"
          class="btn btn-sm btn-outline-success float-end mx-1 @if($job_request->request_status!='Created') disabled @endif"
          data-bs-toggle="modal" data-bs-target="#addRow">
          <i class="bi bi-plus-lg"></i> Training Requests
        </button>
      </div>
    </div>


    @include('job_request.view.table')

    <!-- ROW-6 -->
    <div class="row">
      <div class="col-sm-12 text-end">
        @if($is_request_submittable==false)
        <div class="alert alert-warning mx-1 text-start" role="alert">
          {{$submit_error_message}}
        </div>
        @endif
        <form action="{{ route('job-request.markAsRequested', $job_request->id) }}" method="POST" class="d-inline">
          @csrf
          <button type="submit"
            class="btn btn-sm btn-success float-end mx-1 {{ $is_request_submittable ? '' : 'disabled' }}">
            <i class="bi bi-arrow-up-circle"></i> Submit Request
          </button>
        </form>
        <button type="button"
          class="btn btn-sm btn-danger float-end mx-2 @if($job_request->request_status=='Cancelled') disabled @endif"
          data-bs-toggle="modal" data-bs-target="#cancelRequestModal">
          <i class="bi bi-x-circle"></i> Cencel Request
        </button>
      </div>
    </div>

    <!-- ROW-7 -->
    <div class="row mx-1 mt-3">
      @include('template.history')
    </div>

    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job_request.modals.new_training')
  @include('job_request.modals.cancel_request')
  @include('job_request.modals.duplicate')
  @endsection()