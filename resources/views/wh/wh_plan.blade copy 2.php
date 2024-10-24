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
                
                <div class="mb-3 card card_audit_4c">
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
                                        ข้อมูลรายวัน
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-minimal-2" data-bs-toggle="tab" class="nav-link minimal-tab-btn-2">
                                    {{-- <div class="widget-number">
                                        <span class="pe-2 text-success">
                                            <i class="fa fa-angle-up"></i>
                                        </span>
                                        <span>$ {{ number_format($data_total, 2) }}</span>
                                    </div> --}}
                                    <div class="widget-number text-danger">
                                        <span>$ 3,000</span>
                                    </div>
                                    <div class="tab-subheading">
                                        <span class="pe-2 opactiy-6">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </span>
                                        ข้อมูลรายเดือน
                                    </div>
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
                                        ข้อมูลรายปี
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-minimal-1">
                            <div class="card-body">
                                <form action="{{ URL('wh_plan') }}" method="GET">
                                    @csrf

                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <h5 class="card-title" style="color:green">แผนปฎิบัติการจัดซื้อวัสดุทั่วไป</h5>
                                        <p class="card-title-desc">หน่วยงาน  กลุ่มงานพัสดุ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัด ชัยภูมิ ประจำปีงบประมาณ 2568</p>
                                    </div>
                                    <div class="col"></div>
                                    {{-- <div class="col-md-1 text-end mt-2">วันที่</div>
                                    <div class="col-md-4 text-end">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            <input type="text" class="form-control cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $startdate }}" required/>
                                            <input type="text" class="form-control cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $enddate }}"/>  
                                                <button type="submit" class="ladda-button btn-pill btn btn-info cardacc" data-style="expand-left">
                                                    <span class="ladda-label"><i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                                                    <span class="ladda-spinner"></span>
                                                </button>
                                               
                                        </div> 
                                    </div> --}}
                                </div>

                                </form>
                                <div class="row"> 
                                    <div class="col-xl-12">
                                        {{-- <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered"> --}}
                                            {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;"> --}}
                                            {{-- <table id="scroll-vertical-datatable" class="table table-striped table-bordered" style="width: 100%;"> --}}
                                                {{-- <div class="table-rep-plugin"> --}}
                                                    {{-- <div class="table-responsive mb-0" data-pattern="priority-columns"> --}}
                                                        {{-- <table id="tech-companies-1" class="table" style="width: 100%;"> --}}
                                                            {{-- <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                                            {{-- <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100"> --}}
                                                                
                                                                {{-- <div class="table-rep-plugin"> --}}
                                                                    {{-- <div class="table-responsive mb-0" data-pattern="priority-columns"> --}}
                                                                        {{-- <table id="tech-companies-1" class="table"> --}}
                                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                        
                                                            <tr style="font-size: 10px;">
                                                                <th data-priority="1" rowspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ลำดับ</th>
                                                                <th data-priority="3" rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">รายการ</th>
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ประเภท</th>
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ขนาดบรรจุ /<br>หน่วยนับ</th>
                                                                <th colspan="3" class="text-center" style="background-color: rgb(255, 237, 117);font-size: 11px;">อัตราการใช้ย้อนหลัง 3 ปี</th> 
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ประมาณ<br>การใช้ใน<br>ปี2568</th>
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ปริมาณยอด<br>คงคลัง<br>ยกมา</th> 
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;"> ประมาณ<br>การจัดซื้อ<br>ในปี 2568(หน่วย)</th>
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;"> ราคา<br>ต่อหน่วย<br>(บาท)</th>
                                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;"> ประมาณ<br>การจัดซื้อ<br>ปี 2568(บาท)</th>
                                                                <th rowspan="2" colspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;width:6%">ไตรมาสที่1<br>(ต.ค.-ธ.ค.)</th>
                                                                <th rowspan="2" colspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;;width:6%">ไตรมาสที่2<br>(ม.ค.-มี.ค.)</th>
                                                                <th rowspan="2" colspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;;width:6%">ไตรมาสที่3<br>(เม.ย.-มิ.ย.)</th>
                                                                <th rowspan="2" colspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;;width:6%">ไตรมาสที่4<br>(ก.ค.-ก.ย.)</th>
                                                                <th rowspan="2" colspan="2" class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;;width:6%">ยอดรวมจัดซื้อ</th>
                                                            </tr>
                                                            <tr>  
                                                                
                                                                <th rowspan="2" class="text-center" style="background-color: rgb(255, 176, 157);font-size: 11px;">ปี (2565)</th>
                                                                <th rowspan="2" class="text-center" style="background-color: rgb(139, 247, 211);font-size: 11px;">ปี (2566)</th>
                                                                <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247);font-size: 11px;">ปี (2567)</th>   
                                                            </tr>
                                                            <tr> 
                                                                <th class="text-center" style="background-color: rgb(255, 251, 228)"></th> 
                                                                <th class="text-center" style="background-color: rgb(240, 255, 228);font-size: 10px;">จำนวน</th>
                                                                <th class="text-center" style="background-color: rgb(255, 175, 209);font-size: 10px;">มูลค่า(บาท)</th>
                                                                <th class="text-center" style="background-color: rgb(240, 255, 228);font-size: 10px;">จำนวน</th>
                                                                <th class="text-center" style="background-color: rgb(255, 175, 209);font-size: 10px;">มูลค่า(บาท)</th>
                                                                <th class="text-center" style="background-color: rgb(240, 255, 228);font-size: 10px;">จำนวน</th>
                                                                <th class="text-center" style="background-color: rgb(255, 175, 209);font-size: 10px;">มูลค่า(บาท)</th>
                                                                <th class="text-center" style="background-color: rgb(240, 255, 228);font-size: 10px;">จำนวน</th>
                                                                <th class="text-center" style="background-color: rgb(255, 175, 209);font-size: 10px;">มูลค่า(บาท)</th>
                                                                <th class="text-center" style="background-color: rgb(240, 255, 228);font-size: 10px;">จำนวน</th>
                                                                <th class="text-center" style="background-color: rgb(255, 175, 209);font-size: 10px;">มูลค่า(บาท)</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($wh_product as $item)
                                                            <?php $i++ ?>
                                                            <tr>
                                                                <td class="text-center">{{$i}}</td>
                                                                <td class="text-start" width="10%">{{$item->pro_name}}</td>
                                                                <td class="text-center">{{$item->wh_type_name}}</td>
                                                                <td class="text-center">{{$item->wh_unit_pack_qty}}/{{$item->unit_name}}</td>
                                                                <td class="text-center">{{number_format($item->plan_65, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->plan_66, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->plan_67, 0)}}</td>
                                                                <td class="text-center"> {{number_format($item->praman_chay, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->wh_total, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->praman_buy, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->one_price, 2)}}</td>
                                                                <td class="text-center">{{number_format($item->total_price, 2)}}</td>
                                                                <td class="text-center">{{number_format($item->trimat_one, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->trimat_one_price, 2)}}</td>
                                                                <td class="text-center">{{number_format($item->trimat_two, 0)}}</td>
                                                                <td class="text-center">{{number_format($item->trimat_two_price, 2)}}</td>
                                                                <td class="text-center">{{number_format($item->trimat_tree, 0)}}</td>
                                                                <td class="text-center" width="5%">{{number_format($item->trimat_tree_price, 2)}}</td>
                                                                <td class="text-center" width="5%">{{number_format($item->trimat_four, 0)}}</td>
                                                                <td class="text-center" width="5%">{{number_format($item->trimat_four_price, 2)}}</td>
                                                                <td class="text-center" width="5%">{{number_format($item->total_plan, 0)}}</td>
                                                                <td class="text-center" width="5%">{{number_format($item->total_plan_price, 2)}}</td>  
                                                            </tr>
                                                                
                                                            @endforeach                                                
                                                        </tbody>
                                                </table>  
                                    </div>
                                </div>  
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
                                <div class="tab-content">
                                     
                                </div>
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
            var table = $('#example21').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
            });
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
  
        });
    </script>
  

@endsection
