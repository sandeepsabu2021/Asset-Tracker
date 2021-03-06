@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Asset Type</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add Asset Type</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /.Header content -->

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
                <div class="card card-primary">

                    <!-- form start -->
                    <form method="post" action="{{url('/assettypevalid')}}">
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
                                <label for="desc" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="desc" id="desc" placeholder="Asset Description"></textarea>
                                    @if($errors->has('desc'))
                                    <span class="alert-danger text-danger px-1">{{$errors->first('desc')}}</span>
                                    @endif
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary btn-large" name="addType" value="Add Asset Type">
                        
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