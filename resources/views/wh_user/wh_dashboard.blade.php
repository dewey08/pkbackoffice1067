@extends('layouts.wh')
@section('title', 'PK-OFFICE || Where House')

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
            border-top: 10px rgb(252, 101, 1) solid;
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
        
       
        <div class="app-main__outer">
            <div class="app-main__inner">
                
                <div class="mb-3 card">
                    <div class="tabs-lg-alternate card-header">
                        <ul class="nav nav-justified">
                            <li class="nav-item">
                                <a href="#tab-minimal-1" data-bs-toggle="tab" class="nav-link active minimal-tab-btn-1">
                                    <div class="widget-number">
                                        <span>$ 2000</span>
                                    </div>
                                    <div class="tab-subheading">
                                        <span class="pe-2 opactiy-6">
                                            <i class="fa fa-comment-dots"></i>
                                        </span>
                                        WWW
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-minimal-2" data-bs-toggle="tab" class="nav-link minimal-tab-btn-2">
                                    <div class="widget-number">
                                        <span class="pe-2 text-success">
                                            <i class="fa fa-angle-up"></i>
                                        </span>
                                        <span>45,311,2563</span>
                                    </div>
                                    <div class="tab-subheading">TTT</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-minimal-3" data-bs-toggle="tab" class="nav-link minimal-tab-btn-3">
                                    <div class="widget-number text-danger">
                                        <span>$6,784.0</span>
                                    </div>
                                    <div class="tab-subheading">
                                        <span class="pe-2 opactiy-6">
                                            <i class="fa fa-bullhorn"></i>
                                        </span>
                                        ABC
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-minimal-1">
                            <div class="card-body">
                       
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ผัง</th>
                                            <th>ผังลูกหนี้</th>
                                            <th>เงินลูกหนี้ปัจจุบัน</th>
                                            <th>เงินลูกหนี้สะสม</th>
                                            <th>เงินชดเชย</th>
                                            <th>คิดเป็นร้อยละของจัดเก็บรายได้</th>
                                        </tr>
                                    </thead>
                                   
                                </table>  

                            </div>
                        </div>
                        <div class="tab-pane " id="tab-minimal-2">
                            <div class="card-body">
                                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                    <div id="chart-apex-negative"></div>
                                </div>
                                <h5 class="card-title">Target Sales</h5>
                                <div class="mt-3 row">
                                  
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-minimal-3">
                            <div class="rm-border card-header">
                                <div>
                                    <h5 class="menu-header-title text-capitalize text-primary">Income Report</h5>
                                </div>
                                <div class="btn-actions-pane-right text-capitalize">
                                    <div class="btn-group dropdown">
                                        <button type="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            class="btn-wide me-1 dropdown-toggle btn btn-outline-focus btn-sm">
                                            Options
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-lg rm-pointers dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-primary">
                                                    <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract2.jpg');"></div>
                                                    <div class="menu-header-content">
                                                        <div>
                                                            <h5 class="menu-header-title">Settings</h5>
                                                            <h6 class="menu-header-subtitle">Example Dropdown Menu</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scroll-area-xs">
                                                <div class="scrollbar-container">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item">Activity</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                Chat
                                                                <div class="ms-auto badge rounded-pill bg-info">8</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Recover Password</a>
                                                        </li>
                                                        <li class="nav-item-header nav-item">My Account</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                Settings
                                                                <div class="ms-auto badge bg-success">New</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                Messages
                                                                <div class="ms-auto badge bg-warning">512</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Logs</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                    <div style="height: 274px;">
                                        <div id="chart-combined-tab-3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top bg-light card-header">
                                <div class="actions-icon-btn mx-auto">
                                    <div>
                                        <div role="group" class="btn-group-lg btn-group nav">
                                            <button type="button" data-bs-toggle="tab" href="#tab-content-income"
                                                class="btn-pill ps-3 active btn btn-focus">
                                                Income
                                            </button>
                                            <button type="button" data-bs-toggle="tab" href="#tab-content-expenses"
                                                class="btn-pill pe-3  btn btn-focus">
                                                Expenses
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                               
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
