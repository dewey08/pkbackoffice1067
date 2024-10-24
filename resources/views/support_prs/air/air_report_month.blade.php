@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

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
    <form action="{{ url('air_report_month') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(255, 255, 255)">รายงานปัญหาที่มีการแจ้งซ่อมเครื่องปรับอากาศรายเดือน </h4> 
            </div> 
            <div class="col"></div>
            <div class="col-md-2 text-center mb-2">
                <select name="month_id" id="month_id" class="form-control bt_prs form-control-sm" width="100%">
                    <option value="" class="text-center">--ทั้งหมด--</option>
                    @foreach ($air_plan_month as $item_m)
                        @if ($month_id_ == $item_m->air_plan_month_id)
                            <option value="{{$item_m->air_plan_month_id}}" class="text-center" selected>{{$item_m->air_plan_name}} {{$item_m->years}}</option>
                        @else
                            <option value="{{$item_m->air_plan_month_id}}" class="text-center">{{$item_m->air_plan_name}} {{$item_m->years}}</option>
                        @endif 
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-center"> 
                {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'> --}}
                    {{-- <input type="text" class="form-control bt_prs" name="startdate" value="{{$startdate}}" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" required/> --}}
                    {{-- <input type="text" class="form-control bt_prs" name="enddate" value="{{$enddate}}" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" />   --}}
                        <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info bt_prs me-2" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                        <a href="{{URL('air_report_monthpdf')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs">  
                            <i class="fa-solid fa-print me-2 text-white" style="font-size:13px"></i>
                            <span>Print</span> 
                        </a> 
                {{-- </div>  --}}
            </div> 
            {{-- <div class="col-md-1"> 
                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs">  
                    <i class="fa-solid fa-print me-2 text-white" style="font-size:13px"></i>
                    <span>Print</span> 
                </button> 
            </div>  --}}
        </div>  
    </form>
 
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">  
                       @if ($startdate != '')
                            <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th class="text-center" width="5%">ลำดับ</th>  
                                                    <th class="text-center">เดือน</th>  
                                                    <th class="text-center" width="8%">AIR ทั้งหมด(เครื่อง)</th> 
                                                    <th class="text-center" width="8%">AIR ที่ซ่อม(เครื่อง)</th>   
                                                    <th class="text-center" width="8%">ปัญหาซ่อม AIR(รายการ)</th> 
                                                    <th class="text-center" width="8%">แผนการบำรุงรักษา(ครั้ง)</th> 
                                                    <th class="text-center" width="8%">ผลการบำรุงรักษา(ครั้ง)</th> 
                                                    <th class="text-center" width="8%">ร้อยละ AIR ที่ซ่อม</th> 
                                                    <th class="text-center" width="8%">ร้อยละ AIR ที่บำรุงรักษา</th>  
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?>
                                            <?php   
                                                    $budget_year = DB::select('SELECT leave_year_id FROM budget_year WHERE years_now = "Y"');
                                                    foreach ($budget_year as $key => $va_y) {
                                                        $budgetyear   = $va_y->leave_year_id;
                                                    }
                                                    $plan_count = DB::select(
                                                        'SELECT COUNT(a.air_plan_id) as air_plan_id 
                                                            FROM air_plan a
                                                            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                            WHERE a.air_plan_year = "'.$budgetyear.'" AND b.air_plan_month = "'.$item->months.'"
                                                            AND b.air_plan_year = "'.$item->years.'"
                                                        ');
                                                    foreach ($plan_count as $key => $val_count) {
                                                        $plan_s   = $val_count->air_plan_id;
                                                    }                                          

                                                    $repaire_air = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_problems FROM air_repaire WHERE repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"');                                     
                                                    foreach ($repaire_air as $key => $rep_air) {$airproblems = $rep_air->air_problems;}

                                                    $repaire_air_pro = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems04 FROM air_repaire a 
                                                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                    WHERE repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_type_code ="04"');                                     
                                                    foreach ($repaire_air_pro as $key => $rep_air_pro) {$airproblems04 = $rep_air_pro->air_problems04;}
                                                    
                                                    $repaire_air_plan = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems_plan FROM air_repaire a 
                                                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                    WHERE repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_type_code IN("01","02","03")');                                     
                                                    foreach ($repaire_air_plan as $key => $rep_air_plan) {
                                                        $airproblems_plan = $rep_air_plan->air_problems_plan;
                                                    }
                                                    // แผนการบำรุงรักษา
                                                    if ($plan_s < 1) {
                                                        $plan = "0";
                                                        $percent_ploblames =  "0";
                                                        $percent_plan      =  "0";
                                                    } else {
                                                        $plan = $plan_s ;
                                                        $percent_ploblames =  (100 / $plan) * $airproblems;
                                                        $percent_plan      =  (100 / $plan) * $airproblems_plan;
                                                    }
                                                    
                                            ?>                    
                                                 <tr>                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->MONTH_NAME}} พ.ศ. {{$item->years_ps}}</td> 
                                                    <td class="text-center" style="font-size:13px;color: rgb(112, 5, 98)" width="12%"> 
                                                            {{$count_air}}   
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(253, 65, 81)" width="10%"> 
                                                             {{$airproblems}}  
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(252, 90, 203)" width="12%"> 
                                                            {{$airproblems04}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(5, 179, 170)" width="12%">  
                                                            {{$plan}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(253, 102, 15)" width="12%"> 
                                                            {{$airproblems_plan}}  
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(10, 132, 231)" width="10%"> 
                                                            {{number_format($percent_ploblames, 2)}} % 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(250, 128, 138)" width="12%"> 
                                                            {{number_format($percent_plan, 2)}} %
                                                    </td>
                                                     
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                       @else 
                            <p class="mb-0">
                                <div class="table-responsive">
                                    {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">  --}}
                                    <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th class="text-center" width="5%">ลำดับ</th>  
                                                    <th class="text-center">เดือน</th>  
                                                    <th class="text-center" width="8%">AIR ทั้งหมด(เครื่อง)</th> 
                                                    <th class="text-center" width="8%">AIR ที่ซ่อม(เครื่อง)</th>   
                                                    <th class="text-center" width="8%">ปัญหาซ่อม AIR(รายการ)</th> 
                                                    <th class="text-center" width="8%">แผนการบำรุงรักษา(ครั้ง)</th> 
                                                    <th class="text-center" width="8%">ผลการบำรุงรักษา(ครั้ง)</th> 
                                                    <th class="text-center" width="8%">ร้อยละ AIR ที่ซ่อม</th> 
                                                    <th class="text-center" width="8%">ร้อยละ AIR ที่บำรุงรักษา</th>  
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?>
                                            <?php 
                                                    // $budget_year = DB::select('SELECT leave_year_id FROM budget_year WHERE years_now = "Y"');
                                                    // foreach ($budget_year as $key => $va_y) {
                                                    //     $budgetyear   = $va_y->leave_year_id;
                                                    // }
                                                    $plan_count = DB::select(
                                                        'SELECT COUNT(a.air_plan_id) as air_plan_id 
                                                            FROM air_plan a
                                                            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                            WHERE a.air_plan_year = "'.$item->bg_yearnow.'" AND b.air_plan_month = "'.$item->months.'"  
                                                        ');
                                                    foreach ($plan_count as $key => $val_count) {
                                                        $plan_s   = $val_count->air_plan_id;
                                                    }                                            

                                                    $repaire_air = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_problems FROM air_repaire 
                                                    WHERE YEAR(repaire_date) = "'.$item->years.'" AND MONTH(repaire_date) = "'.$item->months.'"');                                     
                                                    foreach ($repaire_air as $key => $rep_air) {$airproblems = $rep_air->air_problems;}

                                                    $repaire_air_pro = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems04 FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                        WHERE YEAR(a.repaire_date) = "'.$item->years.'" AND MONTH(a.repaire_date) = "'.$item->months.'" AND b.air_repaire_type_code ="04"');                                     
                                                    foreach ($repaire_air_pro as $key => $rep_air_pro) {$airproblems04 = $rep_air_pro->air_problems04;}
                                                    
                                                    $repaire_air_plan = DB::select(
                                                        'SELECT COUNT(DISTINCT a.air_list_num) as air_problems_plan 
                                                            FROM air_repaire a 
                                                            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                            WHERE a.budget_year= "'.$item->bg_yearnow.'"
                                                            AND MONTH(a.repaire_date) = "'.$item->months.'" 
                                                            AND b.air_repaire_type_code IN("01","02","03") 
                                                    ');                                     
                                                    foreach ($repaire_air_plan as $key => $rep_air_plan) {
                                                        $airproblems_plan = $rep_air_plan->air_problems_plan;
                                                    }

                                                    // แผนการบำรุงรักษา
                                                    if ($plan_s < 1) {
                                                        $plan = "0";
                                                        $percent_ploblames =  "0";
                                                        $percent_plan      =  "0";
                                                    } else {
                                                        $plan = $plan_s ;
                                                        $percent_ploblames =  (100 / $item->total_qty) * $airproblems;
                                                        $percent_plan      =  (100 / $plan) * $airproblems_plan;
                                                    }  
                                            ?>                    
                                                <tr>                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->MONTH_NAME}} พ.ศ. {{$item->years_ps}}</td> 
                                                    <td class="text-center" style="font-size:13px;color: rgb(112, 5, 98)" width="12%"> 
                                                            {{$item->total_qty}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(253, 65, 81)" width="10%"> 
                                                             {{$airproblems}}  
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(252, 90, 203)" width="15%"> 
                                                            {{$airproblems04}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(5, 179, 170)" width="12%">  
                                                            {{$plan}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(253, 102, 15)" width="12%"> 
                                                            {{$airproblems_plan}}  
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(10, 132, 231)" width="10%"> 
                                                            {{number_format($percent_ploblames, 2)}} % 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;color: rgb(250, 128, 138)" width="12%"> 
                                                            {{number_format($percent_plan, 2)}} %
                                                    </td>
                                                     
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        @endif 
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
                  
            $('#Processdata').click(function() {
                var startdate    = $('#datepicker').val(); 
                var enddate      = $('#datepicker2').val(); 
                Swal.fire({
                        position: "top-end",
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.air_report_problem_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ประมวลผลข้อมูลสำเร็จ',
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
    </script>

@endsection
