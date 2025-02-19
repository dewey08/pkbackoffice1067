@extends('layouts.checkup')
@section('title', 'PK-OFFICE || ระบบตรวจสุขภาพ')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
            border-top: 10px rgb(250, 128, 124) solid;
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
    <?php
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    
    
    $refnumber = SuppliesController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    
    ?>



    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="card-header">
                        <div class="d-flex">                            
                            <div class="">
                                <label for="">ค้นหาผลตรวจสุขภาพ</label>
                            </div>
                            <div class="ms-auto"></div>
                        </div>
                    </div>

                    <div class="col-md-12 ">

                        <div class="card-body">
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
    
                            <div class="row">
                                
                                <div class="col-md-1 text-end">
                                    <label for="chackup_date">วันที่ :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            <input type="text" class="form-control-sm input_new" name="datepicker" id="datepicker" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1 text-center">
                                    <label for="chackup_hn">HN :</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input id="chackup_hn" type="text" class="form-control-sm d12font input_new" name="chackup_hn" style="width: 25%">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col">
                                    <button type="button" class="btn btn-primary btn-sm GethnDent">
                                        <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                        ค้นหา
                                    </button>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                    
                </div> 
            </div>
        </div>

    </div>


@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        var Linechart;
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });


            var xmlhttp = new XMLHttpRequest();
            var url = "{{ route('acc.account_dashline') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas);
                    label = datas.Dataset1.map(function(e) {
                        return e.label;
                    });

                    count_vn = datas.Dataset1.map(function(e) {
                        return e.count_vn;
                    });
                    income = datas.Dataset1.map(function(e) {
                        return e.income;
                    });
                    rcpt_money = datas.Dataset1.map(function(e) {
                        return e.rcpt_money;
                    });
                    debit = datas.Dataset1.map(function(e) {
                        return e.debit;
                    });
                     // setup
                    const data = {
                        // labels: ["ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"] ,
                        labels: label ,
                        datasets: [
                            {
                                label: ['income'],
                                data: income,
                                fill: false,
                                borderColor: 'rgba(75, 192, 192)',
                                lineTension: 0.4
                            },
                            {
                                label: ['rcpt_money'],
                                data: rcpt_money,
                                fill: false,
                                borderColor: 'rgba(255, 99, 132)',
                                lineTension: 0.4
                            },

                        ]
                    };

                    const config = {
                        type: 'line',
                        data:data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins:[ChartDataLabels],
                    };
                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChartNew'),
                        config
                    );

                }
             }

        });
    </script>


@endsection
