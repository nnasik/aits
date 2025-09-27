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
          <li class="breadcrumb-item"><a href="#">Jobs</a></li>
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

    {{--@include('job.index.counts')--}}
    

    <div class="row">
      <div class="col-6">
        <h3 class="mb-0">Requests</h3>
      </div>
    </div>

    @include('job.index.table_request')

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


    @include('job.index.table')
    <!--end::Row-->
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job.modals.new_job')
  @endsection()