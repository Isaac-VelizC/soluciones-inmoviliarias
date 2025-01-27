@extends('layouts/layoutMaster')

@section('title', 'Citas / Graficas')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
{{--    @vite(['resources/assets/js/charts-apex.js'])--}}
    <script type="module">
        const options = {
            series: [{
                name: '{{ $preguntas1[0]->pregunta }}',
                data: {!! $textoSalida1[0] !!}
            }, {
                name: '{{ $preguntas1[1]->pregunta }}',
                data: {!! $textoSalida1[1] !!}
            }, {
                name: '{{ $preguntas1[2]->pregunta }}',
                data: {!! $textoSalida1[2] !!}
            }],
            chart: {
                type: 'bar',
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                shared: true,
                intersect: false
            },
            xaxis: {
                categories: {!! $meses !!}
            }
        };
        const chart = new ApexCharts(document.querySelector('#horizontalBarChart'), options);
        chart.render();
        //
        const options2 = {
            series: [{
                name: '{{ $preguntas2[0]->pregunta }}',
                data: {!! $textoSalida2[0] !!}
            }, {
                name: '{{ $preguntas2[1]->pregunta }}',
                data: {!! $textoSalida2[1] !!}
            }, {
                name: '{{ $preguntas2[2]->pregunta }}',
                data: {!! $textoSalida2[2] !!}
            }],
            chart: {
                type: 'bar',
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                shared: true,
                intersect: false
            },
            xaxis: {
                categories: {!! $meses !!}
            }
        };
        const chart2 = new ApexCharts(document.querySelector('#horizontalBarChart2'), options2);
        chart2.render();
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Citas /</span> Graficas
    </h4>

    <div class="row">

        <!-- Bar Chart -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-subtitle text-muted mb-1">{{ $encuestas[0]."?" }}</p>
{{--                        <h5 class="card-title mb-0">$74,382.72</h5>--}}
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-calendar-month-outline"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="horizontalBarChart"></div>
                </div>
            </div>
        </div>
        <!-- /Bar Chart -->

        <!-- Bar Chart -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-subtitle text-muted mb-1">{{ $encuestas[1]."?" }}</p>
{{--                        <h5 class="card-title mb-0">$74,382.72</h5>--}}
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-calendar-month-outline"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="horizontalBarChart2"></div>
                </div>
            </div>
        </div>
        <!-- /Bar Chart -->
    </div>
@endsection
