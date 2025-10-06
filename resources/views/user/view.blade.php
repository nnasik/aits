@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mx-1 mt-3">
                <div class="col-sm-6">
                    <h1>User : {{ $user->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/users">Users</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            @if(isset($user->user_dp) && file_exists('storage/user_dp/'.$user->user_dp))
                            <img class="rounded-circle img-fluid" src="{{ asset('storage/user_dp/'.$user->user_dp) }}"
                                alt="User profile picture" width="100" height="100">
                            @else
                            <img src="{{ asset('assets/images/user_placeholder.jpg') }}" alt="Profile Picture"
                                class="rounded-circle" width="100" height="100">
                            @endif

                            <h3 class="mt-2 mb-0">{{ $user->name }}</h3>
                            @if($user->roles->isNotEmpty())
    <p class="text-muted mb-0">{{ $user->roles->first()->name }}</p>
@else
    <p class="text-muted mb-0">No role assigned</p>
@endif

                            <ul class="list-group mt-3">
                                <li class="list-group-item text-start"><b>User ID :</b> {{ $user->id }}</li>
                                <li class="list-group-item text-start"><b>Phone :</b> {{ $user->phone_no }}</li>
                                <li class="list-group-item text-start"><b>Email :</b> {{ $user->email }}</li>
                                <li class="list-group-item text-start"><b>Status :</b> {{ $user->status }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="text-center">User Account Actions</h3>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Status</b>
                                    <form action="{{route('users.updateStatus')}}" method="post" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button class="btn btn-sm btn-primary" type="submit" name="action"
                                            value="Active">Activate</button>
                                        <button class="btn btn-sm btn-danger" type="submit" name="action"
                                            value="Inactive">Deactivate</button>
                                    </form>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Password</b>
                                    <form action="{{route('users.resetPassword')}}" method="post" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button class="btn btn-sm btn-warning" type="submit">Reset Password</button>
                                    </form>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Profile Picture</b>
                                    <form action="{{route('users.updateDP')}}" method="post" id="form-dp"
                                        enctype="multipart/form-data" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="file" name="dp" id="dp" class="d-none"
                                            accept="image/png, image/jpg, image/jpeg" onchange="uploadDP()">
                                        <button class="btn btn-sm btn-secondary" type="button"
                                            onclick="openDP()">Update</button>
                                    </form>
                                    <script>
                                        // Function to open the file dialog
                                        function openDP() {
                                            document.getElementById('dp').click();
                                        }

                                        // Function to submit the form when file is selected
                                        function uploadDP() {
                                            document.getElementById('form-dp').submit();
                                        }
                                    </script>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="card">
                        <div class="card-body row align-items-center">
                            <div class="col-11">
                                <h3 class="text-center">User Roles</h3>
                            </div>
                            <div class="col-1 text-end">
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modal-user-permission">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="d-flex flex-wrap">
                                @foreach($user->roles as $role)
                                <form action="{{ route('user.removeRole') }}" method="post" class="m-1">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="role" value="{{ $role->name }}">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary">{{ $role->name }}</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            function openDP() {
                document.getElementById('dp').click();
            }
            function uploadDP() {
                document.getElementById('form-dp').submit();
            }
        </script>
    </section>

    @include('user.modals.user_role_modal')
</div>
@endsection