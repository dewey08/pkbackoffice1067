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

        <!-- start page title -->
    
                    @foreach ($datashow as $item) 
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
                        <div class="col-xl-8 col-md-6">
                            <div class="row">
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">น้ำหยด</p> 
                                                    <button type="button" class="btn namyod_qtyModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$namyod}}</h3>
                                                    </button> 
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fa-solid fa-droplet" style="color: rgb(252, 90, 203);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                            
                                        </div> 
                                    </div> 
                                </div> 
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">มีกลิ่นเหม็น</p> 
                                                    <button type="button" class="btn menModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$menair}}</h3>
                                                    </button> 
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fas fa-soap" style="color: rgb(253, 102, 15);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                            
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">เสียงดัง</p>  
                                                    <button type="button" class="btn volumnModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$valumnair}}</h3>
                                                    </button>
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fa-solid fa-volume-high" style="color: rgb(10, 132, 231);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                            
                                        </div> 
                                    </div> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">ไม่เย็นมีแต่ลม</p> 
                                                    <button type="button" class="btn lomModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$lomair}}</h3>
                                                    </button> 
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fa-solid fa-fan" style="color:rgb(5, 179, 170);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                        </div> 
                                    </div> 
                                </div> 
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">ไม่ติด/ติดๆดับๆ</p> 
                                                    <button type="button" class="btn dapModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$dapair}}</h3>
                                                    </button> 
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fa-solid fa-tenge-sign" style="color:rgb(250, 128, 138);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                        </div> 
                                    </div> 
                                </div> 
                                <div class="col-xl-4 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">อื่นๆ</p> 
                                                    <button type="button" class="btn ortherModal" style="background: transparent" value="{{ $item->air_supplies_id }}">
                                                        <h3 class="text-start">{{$ortherair}}</h3>
                                                    </button>  
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fab fa-slack" style="color:rgb(8, 184, 228);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div> 
                        {{-- <div class="col-xl-3 col-md-6">
                            <div class="row">
                                <div class="col-xl-12 col-md-4">
                                    <div class="card widget-chart widget-chart-hover" style="height: 100px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"> 
                                                    <p class="text-start font-size-14">น้ำหยด</p> 
                                                    <h3 class="text-start">{{$namyod}}</h3> 
                                                </div> 
                                                <div class="avatar-sm" style="width: 40px;height:40px">
                                                    <span class="avatar-title bg-light text-success rounded-3"> 
                                                        <i class="fa-solid fa-droplet" style="color: rgb(252, 90, 203);font-size:30px"></i> 
                                                    </span>
                                                </div>
                                            </div>  
                                            
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                       </div> --}}  
                    </div> 
                    <div class="row">
                        <?php 
                            $repairetype = DB::select('SELECT * FROM air_repaire_type WHERE air_repaire_type_code IN("01","02","03")');   
                        ?>
                        @foreach ($repairetype as $item_type) 
                            <?php   
                                    $maintenance_1 = DB::select('SELECT COUNT(b.repaire_sub_id) as maintenance_1,COUNT(DISTINCT a.air_list_num) as air_qty FROM air_repaire a 
                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                                        WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND c.maintenance_list_num = "1" AND b.air_repaire_type_code ="01"  
                                    ');    
                                    // WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND b.air_repaire_ploblem_id = "'.$item_type->air_repaire_type_id.'" AND b.air_repaire_type_code ="01"                                 
                                    foreach ($maintenance_1 as $key => $nance_1) {$maintenance1 = $nance_1->maintenance_1;$qty1 = $nance_1->air_qty;}
                                    $maintenance_2 = DB::select('SELECT COUNT(b.repaire_sub_id) as maintenance_2,COUNT(DISTINCT a.air_list_num) as air_qty FROM air_repaire a 
                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id
                                        WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND c.maintenance_list_num = "2" AND b.air_repaire_type_code ="01"  
                                    ');                                 
                                    foreach ($maintenance_2 as $key => $nance_2) {$maintenance2 = $nance_2->maintenance_2;$qty2 = $nance_2->air_qty;}

                                    $maintenance_3 = DB::select('SELECT COUNT(b.repaire_sub_id) as maintenance_3,COUNT(DISTINCT a.air_list_num) as air_qty FROM air_repaire a 
                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id
                                        WHERE a.air_supplies_id = "'.$item->air_supplies_id.'" AND c.maintenance_list_num = "3" AND b.air_repaire_type_code ="01"  
                                    ');                                 
                                    foreach ($maintenance_3 as $key => $nance_3) {$maintenance3 = $nance_3->maintenance_3;$qty3 = $nance_3->air_qty;}
                            ?>

                            <div class="col-xl-4 col-md-4">
                                <div class="card widget-chart widget-chart-hover" style="height: 120px">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                 
                                                
                                                @if ($item_type->air_repaire_type_id == '1') 
                                                    @if ($qty1 > 0)                                                        
                                                        <button type="button" class="btn btn-sm maintenance1_qtyModal" style="background: transparent" value="{{ $item->air_supplies_id }}"> 
                                                            <p class="text-start font-size-14">{{$item_type->air_repaire_typename}} == >> ทั้งหมด {{$qty1}} เครื่อง</p> 
                                                        </button>
                                                        <button type="button" class="btn btn-sm maintenance1Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance1}} รายการ</h3>
                                                        </button>
                                                    @else
                                                        <p class="text-start font-size-14">{{$item_type->air_repaire_typename}}</p> 
                                                        <button type="button" class="btn btn-sm maintenance1Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance1}}</h3>
                                                        </button>
                                                    @endif
                                                   
                                                @elseif ($item_type->air_repaire_type_id == '2')
                                                    @if ($qty2 > 0)
                                                        {{-- <p class="text-start font-size-14">{{$item_type->air_repaire_typename}} == >> ทั้งหมด {{$qty2}} เครื่อง</p> --}}
                                                        <button type="button" class="btn btn-sm maintenance2_qtyModal" style="background: transparent" value="{{ $item->air_supplies_id }}"> 
                                                            <p class="text-start font-size-14">{{$item_type->air_repaire_typename}} == >> ทั้งหมด {{$qty2}} เครื่อง</p> 
                                                        </button> 
                                                        <button type="button" class="btn btn-sm maintenance2Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance2}} รายการ</h3>
                                                        </button>
                                                    @else
                                                        <p class="text-start font-size-14">{{$item_type->air_repaire_typename}}</p> 
                                                        <button type="button" class="btn btn-sm maintenance2Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance2}}</h3>
                                                        </button>
                                                    @endif
                                                     
                                                @else
                                                    @if ($qty3 > 0) 
                                                        <button type="button" class="btn btn-sm maintenance3_qtyModal" style="background: transparent" value="{{ $item->air_supplies_id }}"> 
                                                            <p class="text-start font-size-14">{{$item_type->air_repaire_typename}} == >> ทั้งหมด {{$qty3}} เครื่อง</p> 
                                                        </button>
                                                        <button type="button" class="btn btn-sm maintenance3Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance3}} รายการ</h3>
                                                        </button>
                                                    @else
                                                        <p class="text-start font-size-14">{{$item_type->air_repaire_typename}}</p> 
                                                        <button type="button" class="btn btn-sm maintenance3Modal" style="background: transparent" value="{{ $item->air_supplies_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                            <h3 class="text-start">{{$maintenance3}}</h3>
                                                        </button>
                                                    @endif
                                                      
                                                @endif
                                               
                                            </div> 
                                            <div class="avatar-sm" style="width: 40px;height:40px">
                                                <span class="avatar-title bg-light text-success rounded-3"> 
                                                    @if ($item->air_supplies_id == '2')
                                                        <i class="fas fa-toolbox" style="color: rgb(56, 235, 248);font-size:30px"></i> 
                                                    @else
                                                        <i class="fas fa-toolbox" style="color: rgb(255, 101, 135);font-size:30px"></i> 
                                                    @endif 
                                                    
                                                </span>
                                            </div>
                                        </div>  
                                        
                                    </div> 
                                </div> 
                            </div> 
                        @endforeach
                    </div> 
                    <hr style="color:#ffffff">

                    @endforeach
                    
                <!-- companyallModal Modal --> 
                <div class="modal fade" id="companyallModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อม</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body"> 
                                {{-- <div class="modal-body" style="background-color: #ffffff">  --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>

                                                <div id="detail_companyall"></div>
                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- namyod_qtyModal Modal น้ำหยด--> 
                <div class="modal fade" id="namyod_qtyModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(น้ำหยด)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body"> 
                                {{-- <div class="modal-body" style="background-color: #ffffff">  --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>

                                                <div id="detail_namyod"></div>
                                                <input type="hidden" name="startdate" id="startdate" value="{{$startdate}}">
                                                <input type="hidden" name="enddate" id="enddate" value="{{$enddate}}">
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                 <!-- menModal Modal มีกลิ่นเหม็น--> 
                 <div class="modal fade" id="menModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(มีกลิ่นเหม็น)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>

                                                <div id="detail_men"></div>
                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- volumnModal Modal เสียงดัง--> 
                <div class="modal fade" id="volumnModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(เสียงดัง)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_volumn"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- lomModal Modal ไม่เย็นมีแต่ลม--> 
                <div class="modal fade" id="lomModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(ไม่เย็นมีแต่ลม)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_lom"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- dapModal Modal ไม่ติด/ติดๆดับๆ--> 
                <div class="modal fade" id="dapModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(ไม่ติด/ติดๆดับๆ)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_dap"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- ortherModal Modal อื่นๆ--> 
                <div class="modal fade" id="ortherModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการซ่อมตามปัญหา(อื่นๆ)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_orther"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- maintenance1Modal Modal --> 
                <div class="modal fade" id="maintenance1Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการบำรุงรักษาประจำปีครั้งที่ 1</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance1Modal"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div> 
                <!-- maintenance2Modal Modal --> 
                <div class="modal fade" id="maintenance2Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการบำรุงรักษาประจำปีครั้งที่ 2</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance2Modal"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div> 
                <!-- maintenance3Modal Modal --> 
                <div class="modal fade" id="maintenance3Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการบำรุงรักษาประจำปีครั้งที่ 3</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance3Modal"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>


                <!-- maintenance1_qtyModal Modal --> 
                <div class="modal fade" id="maintenance1_qtyModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการเครื่องที่มีการบำรุงรักษาประจำปีครั้งที่ 1</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance1_qtyModal"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>
                <!-- maintenance2_qtyModal Modal --> 
                <div class="modal fade" id="maintenance2_qtyModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการเครื่องที่มีการบำรุงรักษาประจำปีครั้งที่ 2</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance2_qtyModal"></div>                                                
                                            </div>
                                        </div> 
                                    </div>  
                            </div>
                        
                        </div>
                    </div>
                </div>
                <!-- maintenance3_qtyModal Modal --> 
                <div class="modal fade" id="maintenance3_qtyModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">รายการเครื่องที่มีการบำรุงรักษาประจำปีครั้งที่ 3</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                            </div>
                            <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style='overflow:scroll; height:500px;'>
                                                <div id="detail_maintenance3_qtyModal"></div>                                                
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

            $(document).on('click', '.maintenance1_qtyModal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '1';
                $('#maintenance1_qtyModal').modal('show');   
                // alert(air_supplies_id);        
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance_qty') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance1_qtyModal').html(result);
                    },
                });
            });
            $(document).on('click', '.maintenance2_qtyModal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '2';
                $('#maintenance2_qtyModal').modal('show');   
                // alert(air_supplies_id);        
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance_qty') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance2_qtyModal').html(result);
                    },
                });
            });
            $(document).on('click', '.maintenance3_qtyModal', function() {
                var air_supplies_id = $(this).val(); 
                var maintenance_list_num = '3';
                $('#maintenance3_qtyModal').modal('show');   
                // alert(air_supplies_id);        
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_maintenance_qty') }}",
                    data: { air_supplies_id: air_supplies_id ,maintenance_list_num: maintenance_list_num},
                    success: function(result) { 
                        $('#detail_maintenance3_qtyModal').html(result);
                    },
                });
            });
            $(document).on('click', '.namyod_qtyModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#namyod_qtyModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_namyod') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_namyod').html(result);
                    },
                });
            });
            $(document).on('click', '.menModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#menModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_men') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_men').html(result);
                    },
                });
            });
            $(document).on('click', '.volumnModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#volumnModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_volumn') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_volumn').html(result);
                    },
                });
            });
            $(document).on('click', '.lomModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#lomModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_lom') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_lom').html(result);
                    },
                });
            });
            $(document).on('click', '.dapModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#dapModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_dap') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_dap').html(result);
                    },
                });
            });
            $(document).on('click', '.ortherModal', function() {
                var air_supplies_id = $(this).val(); 
                var startdate       = $('#startdate').val();
                var enddate         = $('#enddate').val();
                $('#ortherModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_orther') }}",
                    data: { air_supplies_id: air_supplies_id ,startdate: startdate,enddate: enddate},
                    success: function(result) { 
                        $('#detail_orther').html(result);
                    },
                });
            });
            
            
        </script>
@endsection

