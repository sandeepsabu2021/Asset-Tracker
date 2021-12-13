@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Asset</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add Asset</li>
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
                <!-- jquery validation -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form method="post" action="{{url('/assetvalid')}}" enctype="multipart/form-data">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Asset Name">
                                    @if($errors->has('name'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('name')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Asset Type:</label>
                                <div class="col-sm-10">
                                    <select name="type" class="form-control">
                                        <option value="">Select Type</option>
                                        @foreach($typeData as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('type'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('type')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="filenames" class="col-sm-2 col-form-label">Images:</label>
                                <div class="col-sm-10">
                                    <input type="file" name="filenames[]" multiple>
                                    @if($errors->has('filenames'))
                                    <span class="alert-danger text-danger px-1">{{$errors->first('filenames')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Status:</label>
                                <!-- <div class="col-sm-3">
                                    <section class="form-control">
                                        <input class="ml-3 mr-1" type="radio" name="status" value="1">&nbsp;Active&nbsp;
                                        <input class="ml-4 mr-1" type="radio" name="status" value="0">&nbsp;Inactive&nbsp;
                                    </section>
                                    @if($errors->has('status'))
                                    <span class="alert-danger text-danger px-1">{{$errors->first('status')}}</span>
                                    @endif
                                </div> -->
                                <div class="col-sm-10">
                                    <select name="status" class="form-control">
                                        <option value="1">Select Type</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @if($errors->has('status'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('status')}}</span>
                                    </div>
                                    @endif
                                </div>
                                <!-- <section class="col-sm-7"></section> -->
                            </div>

                            <input type="submit" class="btn btn-primary btn-large" name="addAsset" value="Add Asset">

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
<!-- /.content -->

@stop
<!-- yield section end -->