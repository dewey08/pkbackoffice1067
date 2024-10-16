{{-- @extends('layouts.support_prs_new') --}}
@extends('layouts.support_prs_airback')
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
          <style>
            .vl {
                border-left: 1px solid #ffffff;
                height: 225px;
                position: absolute;
                left: 50%;
                margin-left: -2px;
                top: 0;
                bottom: 0;
                }
          </style>
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
                                    <span class="d-inline-block"><h3>ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ Dashboard</h3></span>
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
            </div>
        </div>

        <div class="row">
            <div class="col"></div>
            <div class="col-xl-6 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 235px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1"> 
                                <p class="text-start font-size-18 mb-2">เครื่องปรับอากาศ(ทั้งหมด)</p>
                                <h1 class="text-start mb-2">{{$count_air}}</h1> 
                            </div> 
                            <div class="avatar-sm" style="width: 110px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3"> 
                                    <img src="{{ asset('images/air_conditioner_g.png') }}" height="80px" width="100px" class="text-danger"> 
                                </span>
                                
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span> 
                            </p>
                        </div> 
                    </div> 
                </div> 
                <hr style="color:#ffffff">  
            </div> 
            <div class="col-xl-2">
                <select name="edit_yeardb" id="edit_yeardb" class="from-control bt_prs" onchange="yeardb()">
                    <option value="">-- ปีงบประมาณ --</option>
                    @foreach ($budget_year as $item)
                        <option value="{{$item->leave_year_id}}">{{$item->leave_year_id}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="col"></div>
        </div> 
        {{-- <div class="row">
            <div class="col"></div>
            <div class="col-xl-6 col-md-6">
                <img src="{{ asset('images/down.png') }}" height="50px" width="100px"> 
            </div>
            <div class="col"></div>
        </div> --}}
        {{-- <div class="row"> 
            <div class="col-xl-5 col-md-6"></div> 
            <div class="col-xl-1 col-md-6">
                <div class="vl"></div> 
            </div> 
            <div class="col-xl-5 col-md-6"></div> 
        </div>  --}}
        <div class="row"> 
            <div class="col-xl-6 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 225px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1"> 
                                <p class="text-start font-size-18 mb-2">ซ่อมตามปัญหา(เครื่อง)</p>
                                <h1 class="text-start mb-2">{{$air_qty}}</h1> 
                            </div> 
                            <div class="avatar-sm" style="width: 110px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3"> 
                                    <img src="{{ asset('images/ploblems.png') }}" height="80px" width="100px" class="text-danger"> 
                                </span>
                                
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="w-bold font-size-20 me-2" style="color: #fd4c81">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($percent,2)}} %
                                </span> 
                            </p>
                        </div> 
                    </div> 
                </div> 
                {{-- <hr style="color:#ffffff"> --}}
            </div> 
            {{-- <div class="col-xl-2 col-md-6">
                <div class="vl"></div> 
            </div>   --}}
            <div class="col-xl-6 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 225px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1"> 
                                <p class="text-start font-size-18 mb-2">การบำรุงรักษาประจำปี(เครื่อง)</p>
                                <h1 class="text-start mb-2">{{$main_qty}}</h1> 
                            </div> 
                            <div class="avatar-sm" style="width: 110px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3"> 
                                    <img src="{{ asset('images/maintenance.png') }}" height="60px" width="75px" class="text-danger"> 
                                </span>
                                
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($main_percent,2)}} %
                                </span> 
                            </p>
                        </div> 
                    </div> 
                </div>  
            </div>  
        </div> 
        <hr style="color:#ffffff"> 
        @foreach ($datashow as $item) 
            <div class="row">  
                <h2 >บริษัท {{$item->supplies_name}}</h2>
                <div class="col-xl-6 col-md-6">
                    <div class="card widget-chart widget-chart-hover" style="height: 225px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1"> 
                                    <p class="text-start font-size-18 mb-2">ซ่อมตามปัญหา(ครั้ง)</p>
                                    <h1 class="text-start mb-2">0.00</h1> 
                                </div> 
                                @if ($item->air_supplies_id == '2') 
                                <div class="avatar-sm" style="width: 110px;height:100px">
                                    <span class="avatar-title bg-light rounded-3"> 
                                        <img src="{{ asset('images/ploblems.png') }}" height="80px" width="80px"> 
                                    </span> 
                                </div>
                                @else 
                                <div class="avatar-sm" style="width: 110px;height:100px">
                                    <span class="avatar-title bg-light rounded-3"> 
                                        <img src="{{ asset('images/ploblems.png') }}" height="80px" width="80px">  
                                    </span>
                                </div>
                                @endif                            
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">                                 
                                    @if ($item->air_supplies_id == '2')                                 
                                        <span class="w-bold font-size-20 me-2" style="color: #4cc5fd">
                                            <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($percent,2)}} %
                                        </span>                               
                                    @else 
                                        <span class="w-bold font-size-20 me-2" style="color: #fda14c">
                                            <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($percent,2)}} %
                                        </span>
                                    @endif 
                                </p>
                            </div> 
                        </div> 
                    </div>  
                </div> 
                <div class="col-xl-6 col-md-6">
                    <div class="card widget-chart widget-chart-hover" style="height: 225px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1"> 
                                    <p class="text-start font-size-18 mb-2">การบำรุงรักษาประจำปี(ครั้ง)</p>
                                    <h1 class="text-start mb-2">00</h1> 
                                </div> 
                                @if ($item->air_supplies_id == '2') 
                                <div class="avatar-sm" style="width: 110px;height:100px">
                                    <span class="avatar-title bg-light rounded-3"> 
                                        <img src="{{ asset('images/maintenance.png') }}" height="80px" width="80px"> 
                                    </span> 
                                </div>
                                @else 
                                <div class="avatar-sm" style="width: 110px;height:100px">
                                    <span class="avatar-title bg-light rounded-3"> 
                                        <img src="{{ asset('images/maintenance.png') }}" height="80px" width="80px">  
                                    </span>
                                </div>
                                @endif                            
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">                                 
                                    @if ($item->air_supplies_id == '2')                                 
                                        <span class="w-bold font-size-20 me-2" style="color: #4cc5fd">
                                            <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($percent,2)}} %
                                        </span>                               
                                    @else 
                                        <span class="w-bold font-size-20 me-2" style="color: #fda14c">
                                            <i class="ri-arrow-right-up-line me-1 align-middle"></i>คิดเป็น {{number_format($percent,2)}} %
                                        </span>
                                    @endif 
                                </p>
                            </div> 
                        </div> 
                    </div>  
                </div>  
            </div> 
            <hr style="color:#ffffff"> 
        @endforeach
    
                    {{-- @foreach ($datashow as $item) 
                        <?php 
                            // *********** ปีงบประมาณปัจบัน *******************
                            $yearnew     = date('Y');
                            $year_old    = date('Y')-1; 
                            $startdate   = (''.$year_old.'-10-01');
                            $enddate     = (''.$yearnew.'-09-30'); 

                            $namyod_air = DB::select('SELECT COUNT(b.repaire_sub_id) as namyod FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "1" AND b.air_repaire_type_code ="04" 
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                            ');                                     
                            foreach ($namyod_air as $key => $value_air) {$namyod = $value_air->namyod;}

                            $lom_air = DB::select('SELECT COUNT(b.repaire_sub_id) as lomair FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "2" AND b.air_repaire_type_code ="04" 
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                            ');                                     
                            foreach ($lom_air as $key => $lom_air) {$lomair = $lom_air->lomair;} 

                            $men_air = DB::select('SELECT COUNT(b.repaire_sub_id) as menair FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "3" AND b.air_repaire_type_code ="04"
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                            ');                                     
                            foreach ($men_air as $key => $air_men) {$menair = $air_men->menair;} 

                            $valumn_air = DB::select('SELECT COUNT(b.repaire_sub_id) as valumnair FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "4" AND b.air_repaire_type_code ="04"
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                            ');                                     
                            foreach ($valumn_air as $key => $air_valumn) {$valumnair = $air_valumn->valumnair;}

                            $dap_air = DB::select('SELECT COUNT(b.repaire_sub_id) as dapair FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "5" AND b.air_repaire_type_code ="04"  
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                            ');                                     
                            foreach ($dap_air as $key => $air_dap) {$dapair = $air_dap->dapair;}
                            $orther_air = DB::select('SELECT COUNT(b.repaire_sub_id) as aeunair FROM air_repaire a 
                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "6" AND b.air_repaire_type_code ="04"  
                                AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                            ');                                     
                            foreach ($orther_air as $key => $air_auen) {$ortherair = $air_auen->aeunair;}
 
                        ?>
                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <div class="card widget-chart widget-chart-hover" style="height: 265px">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1"> 
                                            <p class="text-start font-size-14 mb-2">บริษัท {{$item->supplies_name}} (ครั้ง)</p>
                                            <button type="button" class="btn companyallModal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                <h1 class="text-start">{{$item->c_repaire}}</h1> 
                                            </button>
                                        </div> 
                                        <div class="avatar-sm" style="width: 100px;height:100px">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                @if ($item->air_supplies_id == '2')
                                                    <img src="{{ asset('images/building_community.png') }}" height="80px" width="80px" class="text-danger"> 
                                                @else
                                                    <img src="{{ asset('images/building_community_p.png') }}" height="80px" width="80px" class="text-danger"> 
                                                @endif 
                                            </span>
                                        </div>
                                    </div>  
                                    <div class="d-flex align-content-center flex-wrap mt-4">
                                        <p class="text-muted mb-0">
                                            <span class="text-info fw-bold font-size-20 me-2">
                                                <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                            </span> 
                                        </p>
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        
                    </div> 
                   
                    <hr style="color:#ffffff">

                    @endforeach --}}
              
 
@endsection
@section('footer')   
        <script>
            $(document).ready(function() {
                // $('#select_2').hide();
                $('#edit_yeardb').change(function(){ 
                    // $('#select_2').show();
                var edit_yeardb = $(this).val();  
                 alert(edit_yeardb);         
                    $.ajax({
                        type: "GET",
                        url:"{{ url('air_dashboard_new') }}",
                        data: { edit_yeardb: edit_yeardb },
                        success: function(result) { 
                            // $('#detail_companyall').html(result);
                        },
                    });
                });
            });
            $(document).on('click', '.companyallModal', function() {
                var air_supplies_id = $(this).val();  
                $('#companyallModal').modal('show');           
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_companyall') }}",
                    data: { air_supplies_id: air_supplies_id },
                    success: function(result) { 
                        $('#detail_companyall').html(result);
                    },
                });
            });

            $(document).on('click', '.maintenance1Modal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '1';
                $('#maintenance1Modal').modal('show');   
                // alert(air_supplies_id);        
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance1Modal').html(result);
                    },
                });
            });
            $(document).on('click', '.maintenance2Modal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '2';
                $('#maintenance2Modal').modal('show');           
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance2Modal').html(result);
                    },
                });
            });
            $(document).on('click', '.maintenance3Modal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '3';
                $('#maintenance3Modal').modal('show');           
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance3Modal').html(result);
                    },
                });
            });
 
            
        </script>
@endsection

