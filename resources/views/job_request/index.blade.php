@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job Request Dashboard</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Job Request</a></li>
          <li class="breadcrumb-item active" aria-current="page">All</li>
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

    @include('job_request.index.counts')
    <!--begin::Row-->
    <div class="row">
      <div class="col-6">
        <h3 class="mb-0">All Requests</h3>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#newRequestModal">
          <i class="bi bi-plus-lg"></i> Job Request
        </button>
      </div>
    </div>

    <div class="row">
      <!-- Button trigger modal -->

    </div>

    @include('job_request.index.table')
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job_request.modals.new_request')
  @endsection()