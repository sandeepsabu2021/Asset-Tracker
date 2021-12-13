@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Welcome to Asset Tracker</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /Header content -->

<!-- Main content -->
<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- card -->
                    <div class="card">
                        <!-- card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Home</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- card-body -->
                        <div class="card-body">
                            <a href="dashboard" class="btn btn-primary btn-large mr-2">Dashboard</a>
                            <a href="asset-type" class="btn btn-danger btn-large mr-2">Asset Types</a>
                            <a href="asset" class="btn btn-warning btn-large">Assets</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</section>
<!-- /Main content -->

@stop
<!-- yield section end -->