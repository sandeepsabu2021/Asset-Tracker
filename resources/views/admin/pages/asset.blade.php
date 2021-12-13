@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delasset").click(function() {
            var id = $(this).attr('aid')
            if (confirm('Do you want to delete this asset?')) {
                $.ajax({
                    url: "{{url('deleteasset')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        aid: id
                    },
                    success: function(response) {
                        alert(response)
                        window.location.reload();
                    }
                })
            }

        })

    })
</script>
<div class="container">

    <!-- Header content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Assets</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

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
    <!-- /Header content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assets with details.</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <section class="text-right my-2 mx-1">
                                <a class="btn btn-dark btn-large" href="downloadcsv">Download Assets CSV</a>
                            </section>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="text-center">
                                            <a href="add-asset" class="btn btn-primary btn-large text-white">Add New Asset</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">Name</th>
                                        <th class="col-2 text-center">Code</th>
                                        <th class="col-1 text-center">Type</th>
                                        <th class="col-1 text-center">Status</th>
                                        <th class="col-2 text-center">Images</th>
                                        <th class="col-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($assetData as $asset)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $asset->name }}</td>
                                        <td class="text-center">{{ $asset->code }}</td>
                                        @foreach($typeData as $type)
                                        @if($type->id == $asset->type_id)
                                        <td class="text-center">{{$type->name}}</td>
                                        @endif
                                        @endforeach
                                        @if($asset->status == '1')
                                        <td class="text-center">Active</td>
                                        @else
                                        <td class="text-center">Inactive</td>
                                        @endif
                                        @php
                                        $images = 0;
                                        @endphp
                                        @foreach($imgData as $img)
                                        @if($asset->id == $img->asset_id)
                                        @php
                                        $images++;
                                        @endphp
                                        @endif
                                        @endforeach
                                        <td class="text-center">{{ $images }} Images Available</td>
                                        <td class="text-center">
                                            <a href="view-asset-{{ $asset->id }}" class="btn btn-warning">View</a>
                                            <a href="edit-asset-{{ $asset->id }}" class="btn btn-info text-white">Edit</a>
                                            <a href="javascript:void(0)" aid="{{ $asset->id }}" class="btn btn-danger text-white delasset">Delete</a>
                                        </td>
                                    </tr>
                                    @php
                                    $sn++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-foot d-flex justify-content-center">
                            {{ $assetData->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

</div>
<!-- /Main content -->

@stop
<!-- yield section end -->