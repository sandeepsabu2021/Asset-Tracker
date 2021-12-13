@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery CDN -->

<script>
    $(document).ready(function() { //jQuery to delete asset
        $(".delasset").click(function() {
            var id = $(this).attr('aid')
            if (confirm('Do you want to delete this asset?')) {
                $.ajax({ //ajax
                    url: "{{url('deleteasset')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        aid: id
                    },
                    success: function(response) {
                        window.location.href = "{{url('/asset')}}";
                    }
                })
            }

        })

    })
</script>

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Asset - {{ $asset->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Asset</li>
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
                        <h3 class="card-title">{{ $asset->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- card-body -->
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">Code (UUID):</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" disabled readonly name="code" value="{{ $asset->code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-sm-2 col-form-label">Type:</label>
                            <div class="col-sm-10">
                                @foreach($type as $t)
                                @if($asset->type_id == $t->id)
                                <input type="text" class="form-control" disabled readonly name="type" value="{{ $t->name }}">
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                @if($asset->status == '0')
                                <input type="text" class="form-control" disabled readonly name="status" value="Inactive">
                                @else
                                <input type="text" class="form-control" disabled readonly name="status" value="Active">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Created at:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" disabled readonly name="date" value="{{ $asset->created_at }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">Images:</label>
                            <div class="col-sm-10">
                                @if(!$images == '0 Images Available')
                                <input type="text" class="form-control" disabled readonly name="img" value="{{ $images }}">
                                @else
                                <div class="row my-2">
                                    @foreach($images as $img)
                                    <img src="{{asset('/uploads/'.$img->image)}}" class="col-sm-3 mx-auto img-thumbnail">
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="text-right mr-4">
                            <a href="edit-asset-{{ $asset->id }}" class="btn btn-warning">Edit</a>
                            <a href="javascript:void(0)" aid="{{ $asset->id }}" class="btn btn-danger text-white delasset">Delete</a>
                        </div>

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