@extends('layouts.app')

@section('content')

<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Trainees</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Trainees</a></li>
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
            <div class="col-6">
                <h3 class="mb-0">All Trainees</h3>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="bi bi-plus-lg"></i> Trainee
                </button>
            </div>
        </div>

        <div class="row p-1">
            @foreach($trainees as $trainee)

            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>{{$trainee->name}}</b></h2>
                                <p class="text-muted text-sm">{{$trainee->designation}}</p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                        {{$trainee->company->name}}</li>
                                    <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                        Phone : </li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar"
                                    class="img-circle img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <a href="#" class="btn btn-sm btn-primary">
                                <i class="fas fa-certificate"></i> View Certificates
                            </a>
                            <a href="#" class="btn btn-sm btn-primary">
                                <i class="fas fa-user"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!--end::Row-->
        @include('trainee.modals.new_trainee')
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    @endsection()