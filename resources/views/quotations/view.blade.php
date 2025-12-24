<!-- view.blade.php -->
@extends('layouts.app')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Quotation : AITS-{{$quotation->reference}} Rev: {{ str_pad($quotation->revision, 2,'0',
                    STR_PAD_LEFT) }}</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item">{{$quotation->reference}}:{{ str_pad($quotation->revision, 2,'0',
                        STR_PAD_LEFT) }}</li>
                    <li class="breadcrumb-item"><a href="{{route('quotation.index')}}">Quotations</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <!-- HEADER DETAILS -->
    @include('quotations.view.header')

    <!-- ADD ROW BUTTON -->
    <div class="row mb-2 px-3">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-success" id="addRow">
                <i class="bi bi-plus-lg"></i> Row
            </button>
        </div>
    </div>
    <div class="row p-3">
        <form id="quotationForm" action="{{ route('quotation_rows.store') }}" method="POST">
            @csrf
            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">

            @include('quotations.view.table')

            <div class="row mt-2">
                <div class="col-6">
                    <!-- Trigger Button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#finalizeQuotationModal">
                        Finalize Quotation
                    </button>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#discountModal">
                        Change Discount
                    </button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
    @include('quotations.view.footer')
</div>

@include('quotations.view.row_template')
@include('quotations.modals.finalize_quotation')

@include('quotations.modals.change_discount')
@include('quotations.view.script')
@endsection