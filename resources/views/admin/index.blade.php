@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-2">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Accounts</p>
                    <p class="lead text-center">2</p>
                </div>
            </a>
            </div>
            <div class="col-md-2">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-sign-in fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Sign In's</p>
                    <p class="lead text-center">2</p>
                </div>
            </a>
            </div>
            <div class="col-md-2">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-sign-out fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Sign Out's</p>
                    <p class="lead text-center">2</p>
                </div>
            </a>
            </div>
            <div class="col-md-2">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-times fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Denied</p>
                    <p class="lead text-center">2</p>
                </div>
            </a>
            </div>
            <div class="col-md-2">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-id-card-o fa-3x"></i>
                    <p class="card-text mb-4">trakr ID's</p>
                    <p class="lead text-center">2</p>
                </div>
            </a>
            </div>
        </div>
    </div>
@endsection