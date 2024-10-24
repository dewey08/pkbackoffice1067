{{-- @extends('layouts.dentalnews') --}}
@extends('layouts.dentals')

@section('title', 'PK-OFFICE || ทันตกรรม')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;

    $refnumber = UsersuppliesController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    ?>

    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 250px;
            height: 250px;
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div id="container_spin">
                <svg viewBox="0 0 100 100">
                    <defs>
                        <filter id="shadow">
                        <feDropShadow dx="0" dy="0" stdDeviation="2.5" 
                            flood-color="#fc6767"/>
                        </filter>
                    </defs>
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-head center-elem">
                                <span class="d-inline-block pe-2">
                                    <i class="lnr-apartment opacity-6" style="color:rgb(228, 8, 129)"></i>
                                </span>
                                <span class="d-inline-block"><h3 style="color:rgb(228, 8, 129)">DENTAL Dashboard</h3></span>
                            </div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a>
                                                <i aria-hidden="true" class="fa fa-home" style="color:rgb(252, 52, 162)"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a>Dashboards</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            dantal
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions"> 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
   
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">    
                        <div class="float-end d-none d-md-inline-block">
                            <div class="dropdown">
                                <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="text-muted">This Years<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">วันนี้</a>
                                    <a class="dropdown-item" href="#">ย้อนหลัง 1 สัปดาห์</a>
                                    <a class="dropdown-item" href="#">ย้อนหลัง 1 เดือน</a>
                                    <a class="dropdown-item" href="#">ย้อนหลัง 1 ปี</a>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="card-title mb-4">จำนวนผู้มารับบริการคลินิกทันตกรรม ย้อนหลัง 1 ปี</h4>

                        <div class="card-body py-0 px-2">
                            <div class="chart-container-fluid">
                                <div id="chart_div" style="width: auto; height: 500px;"></div>
                                {{-- <canvas id="myChart" width="800" height="1200"></canvas> --}}
                            </div>
                        </div>
         
                    </div>
                </div>
            </div>
        </div> 

 
       
    @endsection
    @section('footer')

    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/dist-chart.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'คลินิก'],
                ['มกราคม', <?php echo $den_01; ?>],
                ['กุมภาพัน', <?php echo $den_02; ?>],
                ['มีนาคม', <?php echo $den_03; ?>],
                ['เมษายน', <?php echo $den_04; ?>],
                ['พฤษภาคม', <?php echo $den_05; ?>],
                ['มิถุนายน', <?php echo $den_06; ?>],
                ['กรกฎาคม', <?php echo $den_07; ?>],
                ['สิงหาคม', <?php echo $den_08; ?>],
                ['กันยายน', <?php echo $den_09; ?>],
                ['ตุลาคม', <?php echo $den_10; ?>],
                ['พฤษจิกายน', <?php echo $den_11; ?>],
                ['ธันวาคม', <?php echo $den_12; ?>],
            ]);


            var options = {
                title: '',
                vAxis: {
                    title: 'จำนวน'
                },
                hAxis: {
                    title: ''
                },
                seriesType: 'bars',
                //   series: {5: {type: 'line'}}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }


    </script>

<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    });
</script>


    @endsection
