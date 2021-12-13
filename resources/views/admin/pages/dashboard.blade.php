@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Asset Type', 'Assets Available'],
            <?php
            if ($pieChart) {
                echo $pieChart;
            }
            ?>
        ]);

        var options = {
            title: 'Assets'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
            ['Status', 'Asset'],
            <?php
            if ($barChart) {
                echo $barChart;
            }
            ?>
        ]);

        var options = {
            width: 500,

            bars: 'horizontal', // Required for Material Bar Charts.
            series: {
                0: {
                    axis: 'distance'
                }, // Bind series 0 to an axis named 'distance'.
                1: {
                    axis: 'brightness'
                } // Bind series 1 to an axis named 'brightness'.
            },
            axes: {
                x: {
                    distance: {
                        label: 'Quantity'
                    }, // Bottom x-axis.
                    brightness: {
                        side: 'top',
                        label: 'apparent magnitude'
                    } // Top x-axis.
                }
            }
        };

        var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
        chart.draw(data, options);
    };
</script>

<!-- Header content -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Assets in Asset Types</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $total }}</span>
                                <span>Assets Available</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="piechart" style="width: 100%; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Active & Inactive Assets</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $total }}</span>
                                <span>Total Assets</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="dual_x_div" style="width: 100px; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>
</div>
<!-- /Main content -->

@stop
<!-- yield section end -->