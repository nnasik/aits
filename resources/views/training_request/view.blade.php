@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Training Request</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item active" aria-current="page">Training Request ({{$training_request->id}})</li>
          <li class="breadcrumb-item active" aria-current="page"><a href="{{route('jobrequest.show',$training_request->job_request->id)}}">Job Request ({{$training_request->job_request->id}})</a></li>
          <li class="breadcrumb-item"><a href="{{route('jobrequest.index')}}">All</a></li>
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
        <h3 class="text-center">Training Request - {{$training_request->id}}</h3>
      </div>
    </div>

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request No</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$training_request->id}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Request By</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$training_request->requested_by->name}}" readonly>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Date & Time</span>
          <input type="text" class="form-control" aria-label="Date" aria-describedby="basic-addon1"
            value="{{$training_request->requesting_date}} {{$training_request->requesting_time}}">
        </div>
      </div>
    </div>

    <!-- ROW-2 -->
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Client / Company</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$training_request->company_name_in_certificate}}" readonly>
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Training Mode</span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$training_request->training_mode}}" readonly>
        </div>
      </div>
    </div>



    <!-- ROW-3 -->
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Title </span>
          <input type="text" class="form-control" aria-label="Job No" aria-describedby="basic-addon1"
            value="{{$training_request->course_title_in_certificate}}" readonly>
        </div>
      </div>
    </div>

    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <h3 class="text-center">Trainees</h3>
      </div>
    </div>
    <!-- Table -->

    <div class="row p-3 m-3">
    @foreach($training_request->trainee_requests as $trainee_request)
      @include('training_request.trainee_card')
    @endforeach
    <div>

    <!-- ROW-7 -->
    <div class="row mt-3">
      @include('training_request.history')
    </div>

    @if($training_request->job_request->request_status=='Created')
      @include('training_request.modals.change_name')
      @include('training_request.modals.change_eid')
      @include('training_request.modals.change_company')
      @include('training_request.modals.change_date')
      @include('training_request.modals.certificate_for')
      @include('training_request.modals.eid_front')
      @include('training_request.modals.eid_back')
      @include('training_request.modals.visa')
      @include('training_request.modals.passport')
      @include('training_request.modals.driving_license')
      @include('training_request.modals.profile_picture')
    @endif
    <!--end::Container-->
   
  </div>
  <!--end::App Content-->
  <style>
    <style>
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    .camera-overlay {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 100%; /* creates chord effect */
        background: rgba(0, 0, 0, 0.75);
        border-radius:100px;
        opacity: 0;
        transition: opacity 1s ease;
        cursor: pointer;
    }
    .profile-avatar:hover .camera-overlay {
        opacity: 1;
    }
</style>
  </style>
  @endsection()