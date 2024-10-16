@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function air_main_repaire_destroy(air_repaire_id) {
            Swal.fire({
                position: "top-end",
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('air_main_repaire_destroy') }}" + '/' + air_repaire_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + air_repaire_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
                        }
                    })
                }
            })
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

    
    <?php
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
    ?>

<div class="tabs-animation">
{{-- <div class="containner-fluid"> --}}
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
    {{-- <form action="{{ url('air_report_building') }}" method="GET">
        @csrf --}}
        <div class="row"> 
            <div class="col-md-7">
                <h4 style="color:rgb(255, 255, 255)">แผนการบำรุงรักษาเครื่องปรับอากาศโรงพยาบาลภูเขียวเฉลิมพะเกียรติ ปีงบประมาณ {{$bg_yearnow}} </h4>
   
            </div>
             
            {{-- <div class="col-md-1 text-end"> --}}
                {{-- <select class="form-control bt_prs" id="air_supplies_id" name="air_supplies_id" style="width: 100%"> --}}
                    {{-- <option value="" class="text-center">เลือกบริษัท</option> --}}
                        {{-- @foreach ($air_supplies as $item_t) --}}
                        {{-- @if ($supplies_id == $item_t->air_supplies_id) --}}
                            {{-- <option value="{{ $item_t->air_supplies_id }}" class="text-center" selected> {{ $item_t->supplies_name }}</option> --}}
                        {{-- @else --}}
                            {{-- <option value="{{ $item_t->air_supplies_id }}" class="text-center"> {{ $item_t->supplies_name }}</option> --}}
                        {{-- @endif  --}}
                        {{-- @endforeach  --}}
                {{-- </select> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-2 text-end">  --}}
                {{-- <select class="form-control bt_prs" id="air_plan_month" name="air_plan_month" style="width: 100%" required> --}}
                    {{-- <option value="" class="text-center">เดือน / ปี</option> --}}
                        {{-- @foreach ($air_plan_month as $item_m) --}}
                        {{-- @if ($air_planmonth == $item_m->air_plan_month && $air_planyears == $item_m->air_plan_year) --}}
                            {{-- <option value="{{ $item_m->air_plan_month_id }}" class="text-center" selected> {{ $item_m->air_plan_name }} {{$item_m->years}}</option> --}}
                        {{-- @else --}}
                            {{-- <option value="{{ $item_m->air_plan_month_id }}" class="text-center"> {{ $item_m->air_plan_name }} {{$item_m->years}}</option> --}}
                        {{-- @endif  --}}
                        {{-- @endforeach  --}}
                {{-- </select> --}}
            {{-- </div> --}}
            <div class="col"></div>
            <div class="col-md-2 text-end"> 
                {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                    <span class="ladda-label"><i class="fa-solid fa-print text-white me-2"></i>Print</span>  
                </a> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-2 text-end">  --}}
                <a href="{{url('air_plan_print/'.$bg_yearnow)}}" class="ladda-button btn-pill btn btn-primary bt_prs" target="_blank">
                    <span class="ladda-label"> <i class="fa-solid fa-print text-white me-2"></i>Print</span>  
                </a>
          
                <a href="{{url('air_plan_yearexcel')}}" class="ladda-button btn-pill btn btn-success bt_prs" target="_blank">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Excel</span>  
                </a>

            
            </div>
        </div>  
    {{-- </form> --}}
 
<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive" style="width: 100%;"> --}}
                            {{-- <table id="example" class="table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                                {{-- <table id="example" class="table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                            <thead>                             
                                    <tr style="font-size:13px"> 
                                        {{-- <th rowspan="2" width="3%" class="text-center" style="background-color: rgb(228, 255, 255);">ลำดับ</th>   --}}
                                        <th rowspan="2" class="text-center" style="background-color: rgb(255, 156, 110);color:#FFFFFF" width= "12%">อาคาร</th>  
                                        {{-- <th rowspan="2" class="text-center" style="background-color: rgb(228, 255, 255);width: 7%">อาคาร</th>   --}}
                                        <th rowspan="2" class="text-center" style="background-color: #06b78b;color:#FFFFFF;" width= "5%">จำนวน</th>  
                                        <th colspan="12" class="text-center" style="background-color: rgb(154, 86, 255);color:#FFFFFF">ระยะเวลาการดำเนินงาน</th>   
                                    </tr> 
                                    <tr style="font-size:11px">  
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ต.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ย</th>   
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ธ.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ม.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ก.พ</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">มี.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">เม.ย</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">มิ.ย</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ส.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ย</th>
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                    $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;$total13 = 0;  
                                    $total14 = 0; $total15 = 0; $total16 = 0;$total17 = 0; $total18 = 0; $total19 = 0; $total20 = 0;$total21 = 0;$total22 = 0;$total23 = 0;$total24 = 0;$total25 = 0;
                                ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>               
                                    <tr>     
                                        <td class="text-start" style="font-size:13px;color: rgb(2, 95, 182)">{{$item->building_name}}</td>
                                        {{-- <td class="text-center" style="font-size:13px;color: rgb(4, 117, 117)">{{$item->building_id}}</td> --}}
                                        <td class="text-center" style="font-size:13px;color: rgb(228, 15, 86)">
                                           {{-- <a href="{{url('air_report_building_sub/'.$item->building_id)}}" target="_blank">  --}}
                                                <span class="badge bg-success me-2"> {{$item->qtyall}}</span> 
                                                {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                                                    <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2"></i>{{$item->qtyall}}</span>  
                                                </a> --}}
                                                <span class="badge bg-danger"> {{$item->qty_noall}}</span>
                                            {{-- </a>  --}}
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->tula_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->tula_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                         <span class="badge bg-info me-2"> {{$item->plusji_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->plusji_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->tanwa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->tanwa_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                             <span class="badge bg-info me-2"> {{$item->makkara_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->makkara_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->gumpa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->gumpa_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->mena_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mena_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->mesa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mesa_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                             <span class="badge bg-info me-2"> {{$item->plussapa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->plussapa_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                             <span class="badge bg-info me-2"> {{$item->mituna_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mituna_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                             <span class="badge bg-info me-2"> {{$item->karakada_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->karakada_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                            <span class="badge bg-info me-2"> {{$item->singha_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->singha_bt}}</span>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                                             <span class="badge bg-info me-2"> {{$item->kanya_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->kanya_bt}}</span>
                                        </td>
                                    </tr>
                                    <?php
                                            $total1 = $total1 + $item->qtyall;

                                            $total2 = $total2 + $item->tula_saha;
                                            $total14 = $total14 + $item->tula_bt;
                                            $total3 = $total3 + $item->plusji_saha; 
                                            $total15 = $total15 + $item->plusji_bt; 
                                            $total4 = $total4 + $item->tanwa_saha; 
                                            $total16 = $total16 + $item->tanwa_bt; 
                                            $total5 = $total5 + $item->makkara_saha; 
                                            $total17 = $total17 + $item->makkara_bt; 
                                            $total6 = $total6 + $item->gumpa_saha; 
                                            $total18 = $total18 + $item->gumpa_bt; 
                                            $total7 = $total7 + $item->mena_saha; 
                                            $total19 = $total19 + $item->mena_bt; 
                                            $total8 = $total8 + $item->mesa_saha; 
                                            $total20 = $total20 + $item->mesa_bt;
                                            $total9 = $total9 + $item->plussapa_saha; 
                                            $total21 = $total21 + $item->plussapa_bt; 
                                            $total10 = $total10 + $item->mituna_saha; 
                                            $total22 = $total22 + $item->mituna_bt;
                                            $total11 = $total11 + $item->karakada_saha; 
                                            $total23 = $total23 + $item->karakada_bt; 
                                            $total12 = $total12 + $item->singha_saha; 
                                            $total24 = $total24 + $item->singha_bt;                                            
                                            $total13 = $total13 + $item->kanya_saha; 
                                            $total25 = $total25 + $item->kanya_bt;
                                            $Total_saha = $total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9+$total10+$total11+$total12+$total13;
                                            $Total_bt   = $total14+$total15+$total16+$total17+$total18+$total19+$total20+$total21+$total22+$total23+$total24+$total25;
                                    ?>
                                @endforeach
                            </tbody>
                           
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #fabcd7;font-size:16px">รวม</td>
                                {{-- <td class="text-center" style="background-color: #fcd3e5"><label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha+$Total_bt }}</label></td> --}}
                                <td class="text-center" style="background-color: #fcd3e5"><label for="" style="color: #b3064e;font-size:16px">{{$total1 }}</label></td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total2+$total14}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total2+$total14}}</span>  --}}
                                    </label>  
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total3+$total15}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total3+$total15}}</span>   --}}
                                    </label></td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total4+$total16}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total4+$total16}}</span>    --}}
                                    </label>
                                    </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total5+$total17}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total5+$total17}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total6+$total18}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total6+$total18}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total7+$total19}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total7+$total19}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total8+$total20}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total8+$total20}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total9+$total21}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total9+$total21}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total10+$total22}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total10+$total22}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total11+$total23}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total11+$total23}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total12+$total24}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total12+$total24}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total13+$total25}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total13+$total25}}</span>   --}}
                                    </label>
                                </td>
                                
                            </tr>  
                           
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #fc2783;color:#FFFFFF;font-size:16px"> 
                                    บริษัทบีทีแอร์
                                </td>
                                <td class="text-center" style="background-color: #fc85b9"> 
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_bt }}</label> --}}
                                    <a href="{{url('air_plan_year_print_sup/2/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$Total_bt }}</label></span>  
                                    </a>
                                    {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2"></i> <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_bt }}</label></span>  
                                    </a> --}}
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total14}}</label>   --}}
                                    <a href="{{url('air_plan_year_print/2/10/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total14 }}</label></span>  
                                    </a>
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total15}}</label> --}}
                                    <a href="{{url('air_plan_year_print/2/11/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total15 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total16}}</label> --}}
                                    <a href="{{url('air_plan_year_print/2/12/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total16 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total17}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/1/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total17 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total18}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/2/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total18 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total19}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/3/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total19 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total20}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/4/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total20 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total21}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/5/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total21 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total22}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/6/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total22 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total23}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/7/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total23 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total24}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/8/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total24 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    <a href="{{url('air_plan_year_print/2/9/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total25 }}</label></span>  
                                    </a> 
                                </td> 
                            </tr> 
                            
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #06b78b;color:#FFFFFF;font-size:16px"> 
                                    บริษัทสหรัตน์แอร์
                                </td>  
                                <td class="text-center" style="background-color: #68eecc">
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha }}</label>  --}}
                                    <a href="{{url('air_plan_year_print_sup/1/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$Total_saha }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total2}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/10/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total2 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total3}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/11/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total3 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total4}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/12/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total4 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total5}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/1/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total5 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total6}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/2/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total6 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total7}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/3/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total7 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total8}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/4/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total8 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total9}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/5/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total9 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total10}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/6/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total10 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total11}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/7/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total11 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total12}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/8/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total12 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #06b78b" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total13}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/9/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge bg-warning me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total13 }}</label></span>  
                                    </a> 
                                </td> 
                            </tr> 

                        </table>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-xl-1">
        <div class="card"> 
            <span class="badge bg-info me-2 p-2"> บริษัทสหรัตน์แอร์</span> 
        </div>
    </div>
    <div class="col-xl-1">
        <div class="card">
            <span class="badge p-2" style="background: #ba0890">บริษัทบีทีแอร์</span> 
        </div>
    </div>
    <div class="col"></div>
</div> --}}

</div>
</div>

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
           
            // $('select').select2();
     
        
            $('#example2').DataTable();
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
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

        });
    </script>

@endsection
