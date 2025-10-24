@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Certificates</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Certificate</a></li>
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

    <!--begin::Row-->
    <div class="row">
      <h3 class="mb-0">Waiting Certificates</h3>
      @include('certificate.index.trainee_table')
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row">
      <h3 class="mb-0">Certificates</h3>
      @include('certificate.index.certificate_table')
    </div>
    <!--end::Row-->

    <!--end::Container-->
  </div>
  <!--end::App Content-->
</div>

  @endsection()