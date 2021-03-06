@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /Header content -->

@if(Session::has('Success'))
<div class="alert alert-success">
    {{Session::get('Success')}}
</div>
@endif
@if(Session::has('Error'))
<div class="alert alert-danger">
    {{Session::get('Error')}}
</div>
@endif

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- card -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form method="post" action="{{url('/editprofilevalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ Auth::user()->name }}">
                                    @if($errors->has('name'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('name')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mail" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Email" value="{{ Auth::user()->email }}">
                                    @if($errors->has('mail'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('mail')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
                            <input type="submit" class="btn btn-primary btn-large" name="updateProfile" value="Update Profile">
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /Main content -->

@stop
<!-- yield section end -->