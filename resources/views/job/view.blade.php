@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Job - {{$job->id}}</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item active" aria-current="page">Job - {{$job->id}}</li>
          <li class="breadcrumb-item"><a href="{{route('job.index')}}">Jobs (All)</a></li>
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
        <h3 class="text-center">Training Work Permit</h3>
      </div>
    </div>

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Job No</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job->id}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Date</span>
          <input type="date" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="{{$job->date}}">
        </div>
      </div>
    </div>

    <!-- ROW-2 -->
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Client / Company</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job->company->name}}" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Issued By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job->issued->name}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Authorized By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job->authorized->name}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Sales By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$job->sales->name}}" readonly>
        </div>
      </div>
    </div>

    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-6">
        <a class="btn btn-dark" target="_blank" href="{{route('job.pdf',$job->id)}}">
          <i class="bi bi-file-earmark-pdf-fill"></i> Work Permit
        </a>
      </div>
      <div class="col-sm-6 text-end">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#addRow">
          <i class="bi bi-plus-lg"></i> Training
        </button>
      </div>
    </div>



    <!-- Table -->
    @include('job.view.table')

    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @include('job.modals.new_training')
  @endsection()