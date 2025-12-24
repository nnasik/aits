<!-- index.blade.php -->
@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Quotations</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item" aria-current="page">All</li>
            <li class="breadcrumb-item">Quotations</li>
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
      <div class="col-6">
        <h5 class="mb-0">Qutations by {{auth::user()->name}}</h5>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#quotationModal">
          <i class="bi bi-plus-lg"></i> Quotation
        </button>
      </div>
    </div>
    <!--end::Row-->
    <div class="row mt-3">
      @include('quotations.index.quotations')
    </div>
    
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  </div>
  
  @include('quotations.modals.new_quotation')
  @endsection()
