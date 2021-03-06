@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $(".deltype").click(function(){
            var id = $(this).attr('tid')
            if(confirm('Asset type and all related assets will be deleted. Are you sure?')){
                $.ajax({
                    url:"{{url('deletetype')}}",
                    method: 'delete',
                    data: {_token:'{{csrf_token()}}' , tid:id},
                    success:function(response){
                        alert(response)
                        window.location.reload();
                    }
                })
            }
            
        })

    })
</script>

<div class="container">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asset Types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Asset Types</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Asset types with name and description.</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">
                                            <a href="add-asset-type" class="btn btn-primary btn-large text-white">Add New Asset Type</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">Name</th>
                                        <th class="col-5">Description</th>
                                        <th class="col-2 text-center">Assets</th>
                                        <th class="col-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($typeData as $type)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $type->name }}</td>
                                        <td>{{ $type->description }}</td>
                                        <td class="text-center">
                                            <a href="asset{{ $type->id }}" class="btn btn-warning">View</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit-asset-type-{{ $type->id }}" class="btn btn-info text-white">Edit</a>
                                            <a href="javascript:void(0)" tid="{{ $type->id }}" class="btn btn-danger text-white deltype">Delete</a>
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
                            {{ $typeData->links('pagination::bootstrap-4') }}
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