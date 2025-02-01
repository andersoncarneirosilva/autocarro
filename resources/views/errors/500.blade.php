@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<div class="row justify-content-center">
    <div class="col-xxl-4 col-lg-5">
        <div class="card">
            <!-- Logo -->
            <div class="card-header py-4 text-center bg-primary">
                <a href="index.html">
                    <span><img src="assets/images/logo.png" alt="logo" height="22"></span>
                </a>
            </div>

            <div class="card-body p-4">

                <div class="text-center">
                    <img src="assets/images/svg/startman.svg" height="120" alt="File not found Image">

                    <h1 class="text-error mt-4">500</h1>
                    <h4 class="text-uppercase text-danger mt-3">Internal Server Error</h4>
                    <p class="text-muted mt-3">Why not try refreshing your page? or you can contact <a href="" class="text-muted"><b>Support</b></a></p>

                    <a class="btn btn-info mt-3" href="index.html"><i class="mdi mdi-reply"></i> Return Home</a>
                </div>

            </div> <!-- end card-body-->
        </div>
        <!-- end card-->

    </div> <!-- end col -->
</div>

@endsection