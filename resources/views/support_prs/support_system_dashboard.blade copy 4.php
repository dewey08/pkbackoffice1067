@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Support-System')

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
    
    ?>

    {{-- <style>
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
    </style> --}}

    <div class="tabs-animation">
        {{-- <div class="row text-center">
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
        </div> --}}


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
                                    <span class="d-inline-block">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ Dashboard</span>
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
                                                Inspection and maintenance Dashboard
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
          
                        {{-- <div class="grid-menu grid-menu-2col"> --}}
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                
                                <div class="card card_prs_4" style="background-color: rgb(229, 253, 245)">   
                                    <div class="table-responsive p-3">                                
                                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                        
                                            <thead>
                                                <tr >  
                                                    <th class="text-center">ลำดับ</th> 
                                                    <th class="text-center">อาคาร</th> 
                                                    <th class="text-center">จำนวน แอร์</th> 
                                                    <th class="text-center">จำนวนครั้งที่ซ่อม</th>   
                                                    <th class="text-center">น้ำหยด</th> 
                                                    <th class="text-center">ไม่เย็นมีแต่ลม</th> 
                                                    <th class="text-center">มีกลิ่นเหม็น</th> 
                                                    <th class="text-center">เสียงดัง</th> 
                                                    <th class="text-center">ไม่ติด/ติดๆดับๆ</th> 
                                                    <th class="text-center">อื่นๆ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; $total1 = 0; $total2 = 0; $total3 = 0;?>
                                                @foreach ($chart_location as $item)
                                                <?php $number++;?>
                                                <?php 
                                                        $namyod_air = DB::select('SELECT COUNT(b.repaire_sub_id) as namyod FROM air_repaire a 
                                                            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                            WHERE a.air_location_id = "'.$item->air_location_id.'" AND b.air_repaire_ploblem_id = "1" AND b.air_repaire_type_code ="04"  
                                                        ');                                     
                                                        foreach ($namyod_air as $key => $value_air) {$namyod = $value_air->namyod;} 

                                                        $lom_air = DB::select('SELECT COUNT(b.repaire_sub_id) as lomair FROM air_repaire a 
                                                            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                            WHERE a.air_location_id = "'.$item->air_location_id.'" AND b.air_repaire_ploblem_id = "2" AND b.air_repaire_type_code ="04"  
                                                        ');                                     
                                                        foreach ($lom_air as $key => $lom_air) {$lomair = $lom_air->lomair;} 

                                                        $men_air = DB::select('SELECT COUNT(b.repaire_sub_id) as menair FROM air_repaire a 
                                                            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                            WHERE a.air_location_id = "'.$item->air_location_id.'" AND b.air_repaire_ploblem_id = "3" AND b.air_repaire_type_code ="04"  
                                                        ');                                     
                                                        foreach ($men_air as $key => $air_men) {$menair = $air_men->menair;} 
                                                        
                                                ?>
                                                    <tr style="font-size: 13px;">
                                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td> 
                                                        <td class="text-font" style="text-align: left;">{{$item->air_location_name}}</td>
                                                        <td class="text-font" style="text-align: center;"> 
                                                            <button type="button" class="badge rounded-pill bg-warning aircountModal" value="{{ $item->air_location_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนแอร์ที่มีปัญหา">
                                                               {{$item->air_count_qty}}
                                                            </button>
                                                        </td>
                                                        
                                                        <td class="text-font" style="text-align: center;"> 
                                                             
                                                            <button type="button" class="badge rounded-pill bg-info" value="{{ $item->air_location_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนครั้งที่ซ่อม">
                                                                {{$item->air_count_rep}}
                                                             </button>
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;"> 
                                                           
                                                            <button type="button" class="badge rounded-pill bg-primary" value="{{ $item->air_location_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="น้ำหยด">
                                                                {{$namyod}}
                                                             </button>
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;">  
                                                            <button type="button" class="badge rounded-pill bg-success" value="{{ $item->air_location_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="ไม่เย็นมีแต่ลม">
                                                                {{$lomair}}
                                                             </button>
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;">  
                                                            <button type="button" class="badge rounded-pill bg-secondary" value="{{ $item->air_location_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="มีกลิ่นเหม็น">
                                                                {{$menair}}
                                                             </button>
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;"> 
                                                            <a href="{{url('air_count_ploblem_4/'.$item->air_location_id)}}">{{$item->air_count_rep}}</a> 
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;"> 
                                                            <a href="{{url('air_count_ploblem_5/'.$item->air_location_id)}}">{{$item->air_count_rep}}</a> 
                                                        </td> 
                                                        <td class="text-font" style="text-align: center;"> 
                                                            <a href="{{url('air_count_ploblem_orther/'.$item->air_location_id)}}">{{$item->air_count_rep}}</a> 
                                                        </td> 
                                                    </tr>
                                                   
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                {{-- <div class="col-md-3 col-lg-3 col-xl-3">
                                    <div class="card mb-3 widget-chart widget-chart2 text-start card-btm-border card-shadow-success border-success">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content pt-3 ps-3 pb-1">
                                                <div class="widget-chart-flex">
                                                    <div class="widget-numbers">
                                                        <div class="widget-chart-flex">
                                                            <div class="fsize-4">
                                                                <small class="opacity-5">$</small>
                                                                <span>874</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6 class="widget-subheading mb-0 opacity-5">sales last month</h6>
                                            </div>
                                            <div class="g-0 widget-chart-wrapper mt-3 mb-3 ps-2 he-auto row">
                                                <div class="col-md-9">
                                                    <div id="dashboard-sparklines-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                    {{-- <div class="col-md-2">
                                        <div class="widget-chart widget-chart-hover">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-danger"></div>
                                                <i class="lnr-apartment text-primary"></i>
                                            </div>
                                            <div class="widget-numbers">45.8k</div>
                                            <div class="widget-subheading">อาคาร </div>
                                            <div class="widget-description text-success">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">175.5%</span>
                                            </div>
                                        </div>
                                    </div>  --}}

                                    {{-- <div class="col-md-2">
                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="widget-chart-content">
                                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED)</div>
                                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                        <div class="widget-chart-flex align-items-center">
                                                            <div>
                                                                <span class="opacity-10 text-danger pe-2">
                                                                    <i class="fa fa-angle-left"></i>
                                                                </span>
                                                            1 
                                                            </div>
                                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted mt-3">
                                                                <small class="opacity-5 ps-1">พร้อมใช้งาน </small>
                                                            
                                                               02
                                                                <small class="opacity-5 ps-1">ถัง</small> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                                           
                                {{-- <div class="col-sm-6">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-info"></div>
                                            <i class="lnr-graduation-hat text-info"></i>
                                        </div>
                                        <div class="widget-numbers">63.2k</div>
                                        <div class="widget-subheading">Bugs Fixed</div>
                                        <div class="widget-description text-info">
                                            <i class="fa fa-arrow-right"></i>
                                            <span class="ps-1">175.5%</span>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-6">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-danger"></div>
                                            <i class="lnr-laptop-phone text-danger"></i>
                                        </div>
                                        <div class="widget-numbers">5.82k</div>
                                        <div class="widget-subheading">Reports Submitted</div>
                                        <div class="widget-description text-primary">
                                            <span class="pe-1">54.1%</span>
                                            <i class="fa fa-angle-up"></i>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-6">
                                    <div class="widget-chart widget-chart-hover br-br">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-success"></div>
                                            <i class="lnr-screen"></i>
                                        </div>
                                        <div class="widget-numbers">17.2k</div>
                                        <div class="widget-subheading">Profiles</div>
                                        <div class="widget-description text-warning">
                                            <span class="pe-1">175.5%</span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        {{-- </div> --}}
                   

                <div class="row">
                    <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content">
                                                <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED)</div>
                                                <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                    <div class="widget-chart-flex align-items-center">
                                                        <div>
                                                            <span class="opacity-10 text-danger pe-2">
                                                                <i class="fa fa-angle-left"></i>
                                                            </span>
                                                            {{ number_format($count_red_all, 0) }} 
                                                        </div>
                                                        <div class="widget-title ms-auto font-size-lg fw-normal text-muted mt-3">
                                                            <small class="opacity-5 ps-1">พร้อมใช้งาน </small>
                                                        
                                                            {{$count_red_allactive}} 
                                                            <small class="opacity-5 ps-1">ถัง</small> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content">
                                                <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN)</div>
                                                <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                    <div class="widget-chart-flex align-items-center">
                                                        <div>
                                                            <span class="opacity-10 text-success pe-2">
                                                                <i class="fa fa-angle-left"></i>
                                                            </span>
                                                        {{ number_format($count_green_all, 0) }} 
                                                        </div>
                                                        <div class="widget-title ms-auto font-size-lg fw-normal text-muted mt-3">
                                                            <small class="opacity-5 ps-1">พร้อมใช้งาน </small>
                                                        
                                                            {{$count_green_allactive}} 
                                                            <small class="opacity-5 ps-1">ถัง</small> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content">
                                                <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED สำรอง)</div>
                                                <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                    <div class="widget-chart-flex align-items-center">
                                                        <div>
                                                            <small class="text-danger pe-1">+</small>
                                                            {{ $count_red_back }} 
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                                        <div class="widget-chat-wrapper-outer">
                                            <div class="widget-chart-content">
                                                <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN สำรอง)</div>
                                                <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                    <div class="widget-chart-flex align-items-center">
                                                        <div>
                                                            <small class="text-success pe-1">+</small>
                                                            {{ $count_green_back }} 
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                   
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-sm text-capitalize fw-normal">ถังดับเพลิง (RED) Check ไปแล้วคิดเป็น( % ) ของทั้งหมดในเดือนนี้
                                        </div>
                                       
                                    </div>
                                    <div class="p-0 card-body">
                                        <div id="radials"></div>
        
                                        <div class="widget-content pt-0 w-100">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left pe-2 fsize-1">
                                                        <div class="widget-numbers mt-0 fsize-3 text-danger">{{ $count_color_red_qty }}ถัง</div> 
                                                    </div>
                                                    <div class="widget-content-right w-100">
                                                        <div class="progress-bar-xs progress">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                aria-valuenow="{{$count_color_red_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{$count_red_percent}}%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left fsize-1">
                                                    <div class="text-muted opacity-6">Check Qty</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-sm text-capitalize fw-normal">ถังดับเพลิง (GREEN) Check ไปแล้วคิดเป็น( % ) ของทั้งหมดในเดือนนี้
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                           
                                        </div>
                                    </div>
                                    <div class="p-0 card-body">
                                        <div id="radials_green"></div>
                                        <div class="widget-content pt-0 w-100">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left pe-2 fsize-1">
                                                        <div class="widget-numbers mt-0 fsize-3 text-success">{{$count_color_green_qty}}ถัง</div>
                                                    </div>
                                                    <div class="widget-content-right w-100">
                                                        <div class="progress-bar-xs progress">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                aria-valuenow="{{$count_color_green_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{$count_green_percent}}%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left fsize-1">
                                                    <div class="text-muted opacity-6">Check Qty</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
        
                        </div>

                    </div>
                    
                </div>

                <div class="row">
                    {{-- <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <span class="opacity-10 text-danger pe-2">
                                                    <i class="fa fa-angle-left"></i>
                                                </span>
                                                {{ number_format($count_red_all, 0) }} 
                                            </div>
                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted mt-3">
                                                <small class="opacity-5 ps-1">พร้อมใช้งาน </small>
                                            
                                                 {{$count_red_allactive}} 
                                                 <small class="opacity-5 ps-1">ถัง</small> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <span class="opacity-10 text-success pe-2">
                                                    <i class="fa fa-angle-left"></i>
                                                </span>
                                             {{ number_format($count_green_all, 0) }} 
                                            </div>
                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted mt-3">
                                                <small class="opacity-5 ps-1">พร้อมใช้งาน </small>
                                            
                                                {{$count_green_allactive}} 
                                                <small class="opacity-5 ps-1">ถัง</small> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED สำรอง)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <small class="text-danger pe-1">+</small>
                                                {{ $count_red_back }} 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN สำรอง)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <small class="text-success pe-1">+</small>
                                                {{ $count_green_back }} 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="row">                   
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">ถังดับเพลิง (RED) Check ไปแล้วคิดเป็น( % ) ของทั้งหมด
                                </div>
                               
                            </div>
                            <div class="p-0 card-body">
                                <div id="radials"></div>

                                <div class="widget-content pt-0 w-100">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left pe-2 fsize-1">
                                                <div class="widget-numbers mt-0 fsize-3 text-danger">{{ $count_color_red_qty }}ถัง</div> 
                                            </div>
                                            <div class="widget-content-right w-100">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        aria-valuenow="{{$count_color_red_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{$count_red_percent}}%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left fsize-1">
                                            <div class="text-muted opacity-6">Check Qty</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">ถังดับเพลิง (GREEN) Check ไปแล้วคิดเป็น( % ) ของทั้งหมด
                                </div>
                                <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                   
                                </div>
                            </div>
                            <div class="p-0 card-body">
                                <div id="radials_green"></div>
                                <div class="widget-content pt-0 w-100">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left pe-2 fsize-1">
                                                <div class="widget-numbers mt-0 fsize-3 text-success">{{$count_color_green_qty}}ถัง</div>
                                            </div>
                                            <div class="widget-content-right w-100">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        aria-valuenow="{{$count_color_green_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{$count_green_percent}}%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left fsize-1">
                                            <div class="text-muted opacity-6">Check Qty</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
  
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="card-header-title font-size-lg text-capitalize fw-normal">
                            รายงานผลการตรวจสอบสภาพถังดับเพลิง  โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ
                        </div>
                        <div class="btn-actions-pane-right">
                            <a href="{{url('support_system_excel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                <i class="fa-solid fa-file-excel me-2"></i>
                                Export To Excel
                            </a>
                        </div>
                       
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle text-truncate mb-0 table table-borderless table-hover table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">ลำดับ</th>
                                    <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">เดือนที่ตรวจ</th>
                                    <th colspan="6" class="text-center" style="background-color: rgb(255, 237, 117)">ถังดับเพลิงทั้งหมดที่มี (ถัง)</th>
                                    <th colspan="6" class="text-center" style="background-color: rgb(117, 216, 255)">ถังดับเพลิงที่ได้รับการตรวจสอบ (ถัง)</th>
                                    <th rowspan="3" class="text-center" style="background-color: rgb(247, 157, 151)">จำนวน<br>ที่ไม่ได้ตรวจ<br>รวม(ถัง)</th>
                                    <th rowspan="3" class="text-center" style="background-color: rgb(250, 211, 226)">จำนวน<br>ที่ชำรุด<br>รวม(ถัง)</th>
                                    <th colspan="2" class="text-center" style="background-color: rgb(253, 185, 211)">ร้อยละ</th> 
                                </tr>
                                <tr> 
                                    <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                    <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                    <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด</th> 
                                    <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                    <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                    <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด</th>   
                                    <th rowspan="2" class="text-center" style="background-color: rgb(255, 251, 228)">ที่ตรวจ<br> รวม(ถัง)</th> 
                                    <th rowspan="2" class="text-center" style="background-color: rgb(228, 253, 255)">ที่ชำรุด<br> รวม(ถัง)</th> 
                                </tr>
                                <tr> 
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์</th>
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์</th>
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์</th>
                                    <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th> 
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์</th>
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์</th>
                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์</th>
                                    <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($datareport as $itemreport) 
                                    <?php $i++ ?>
                                    <?php 
                                            $dashboard_ = DB::select(
                                                'SELECT (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal") as redten
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal") as redfifteen
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal") as redtwenty 
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal") as greenten
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal") total_all
                                                    
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redten
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redfifteen
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redtwenty
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_greenten

                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Checktotal_all

                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                                                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                                                FROM fire_check f
                                                WHERE month(f.check_date) = "'.$itemreport->months.'"
                                                AND year(f.check_date) = "'.$itemreport->years.'" 
 
                                            ');                                     
                                            foreach ($dashboard_ as $key => $value) {
                                                $red_all               = $value->red_all;
                                                $redten                = $value->redten;
                                                $redfifteen            = $value->redfifteen;
                                                $redtwenty             = $value->redtwenty;
                                                $greenten              = $value->greenten;
                                                $total_all             = $value->total_all;
                                                $Check_redten          = $value->Check_redten;
                                                $Check_redfifteen      = $value->Check_redfifteen;
                                                $Check_redtwenty       = $value->Check_redtwenty;
                                                $Check_greenten        = $value->Check_greenten;
                                                $Checktotal_all        = $value->Checktotal_all;
                                                $camroot               = $value->camroot;
                                                $green_all             = $value->green_all;
                                                $Checkgreen_all        = $value->Checkgreen_all;
                                            } 
                                            $sumyokma_all_ = DB::select(
                                                'SELECT COUNT(f.fire_id) as cfire 
                                                    FROM fire_check fc  
                                                    LEFT OUTER JOIN fire f ON f.fire_id = fc.fire_id
                                                    WHERE month(fc.check_date) = "'.$itemreport->months.'" 
                                                    AND year(fc.check_date) = "'.$itemreport->years.'" 
                                            '); 
                                            $trut          = 100 / $total_all * $Checktotal_all;
                                            $chamrootcount = 100 / $total_all * $camroot;
                                    ?>
                                    <tr> 
                                        <td class="text-center text-muted" style="width: 5%;background-color: rgb(2255, 251, 228)">{{$i}}</td>
                                        <td class="text-start" style="width: 10%;background-color: rgb(2255, 251, 228)">
                                            {{$itemreport->MONTH_NAME}} พ.ศ.{{$itemreport->yearsthai}}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">{{$redten}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">{{$redfifteen}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">{{$redtwenty}}</a>
                                        </td>
                                        <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">{{$greenten}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                           
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-info me-2 ms-2">{{$total_all}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">{{$Check_redten}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">{{$Check_redfifteen}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">{{$Check_redtwenty}}</a>
                                        </td>
                                        <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">{{$Check_greenten}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(219, 243, 252)">
                                            <a href="{{url('support_system_check/'.$itemreport->months.'/'.$itemreport->years)}}" target="_blank" class="badge rounded-pill bg-primary me-2 ms-2">{{$Checktotal_all}}</a>
                                        </td> 

                                        <td class="text-center" style="background-color: rgb(253, 202, 198)">
                                            <a href="{{url('support_system_nocheck/'.$itemreport->months.'/'.$itemreport->years)}}" target="_blank" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(253, 80, 68)">{{$total_all- $Checktotal_all}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-warning me-2 ms-2">{{$camroot}}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-warning me-2 ms-2">{{ number_format($trut, 2) }}</a>
                                        </td>
                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                            <a href="javascript:void(0)" class="badge rounded-pill bg-warning me-2 ms-2">{{ number_format($chamrootcount, 2) }}</a>
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block p-4 text-center card-footer">
                       
                    </div>
                </div>

            </div> 
        </div> 
    </div>

    <!-- aircountModal Modal --> 
    <div class="modal fade" id="aircountModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">จำนวนเครื่องที่แจ้งซ่อม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div style='overflow:scroll; height:500px;'>

                                    <div id="detail"></div>
                                       
                                  </div>
                            </div> 
                        </div>  
                </div>
               
            </div>
        </div>
    </div>

     <!-- น้ำหยด Modal --> 
     <div class="modal fade" id="problems_1Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">จำนวนเครื่องที่แจ้งซ่อมรายการน้ำหยด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div style='overflow:scroll; height:500px;'>

                                    <div id="detail_ploblem_1"></div>
                                       
                                  </div>
                            </div> 
                        </div>  
                </div>
               
            </div>
        </div>
    </div>

@endsection
@section('footer')
 
    <script>
        
     $(document).ready(function() {
             
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example2').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });

            var xmlhttp = new XMLHttpRequest();
            var url = "{{ url('support_dashboard_chart') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas); 
                    
                    count_red = datas.Dataset1.map(function(e) {
                        return e.count_red;
                    });
                    count_color_red_qty = datas.Dataset1.map(function(e) {
                        return e.count_color_red_qty;
                    });
                    count_red_all= datas.Dataset1.map(function(e) {
                        return e.count_red_all;
                    });
                    console.log(count_red_all); 

                    count_green = datas.Dataset1.map(function(e) {
                        return e.count_green;
                    });
                    count_green_percent= datas.Dataset1.map(function(e) {
                        return e.count_green_percent;
                    });
                      
                            // Radial 
                            var options_red = {
                                series: count_red,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#f80707'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials"), options_red);
                            chart.render();

                            // // **************************************

                            var options_green = {
                                series: count_green_percent,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#ABE5A1'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials_green"), options_green);
                            chart.render();

                }
             }

             $("#spinner-div").hide(); //Request is complete so hide spinner
         
            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate   = $('#datepicker2').val(); 
                Swal.fire({
                        position: "top-end",
                        title: 'ต้องการประมวลผลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.support_system_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 2000) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ประมวลผลสำเร็จ',
                                                text: "You Process data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

        });

        $(document).on('click', '.aircountModal', function() {
            var air_location_id = $(this).val(); 
            $('#aircountModal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('support_detail') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail').html(result);
                },
            });
        });

        $(document).on('click', '.problems_1Modal', function() {
            var air_location_id = $(this).val(); 
            $('#problems_1Modal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('detail_ploblem_1') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail_ploblem_1').html(result);
                },
            });
        });

        

    </script>

@endsection

