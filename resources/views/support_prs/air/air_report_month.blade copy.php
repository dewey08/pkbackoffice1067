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
    
    ?>

    
    <?php
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
                <h4 style="color:rgb(10, 151, 85)">รายงานปัญหาที่มีการแจ้งซ่อมเครื่องปรับอากาศ รายเดือน </h4> 
            </div>
             
            <div class="col"></div>
            <div class="col-md-4 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bt_prs" name="startdate" value="{{$startdate}}" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" required/>
                    <input type="text" class="form-control bt_prs" name="enddate" value="{{$enddate}}" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" />  
                        <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                        {{-- <button type="button" class="ladda-button btn-pill btn btn-success bt_prs" id="Processdata"> 
                            <i class="fa-solid fa-spinner text-white me-2"></i>ประมวลผล
                        </button>
                        <button type="button" class="ladda-button btn-pill btn btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> 
                            <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                        </button> --}}
                   
                </div> 
            </div> 
        </div>  
    </form>
 
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4" style="background-color: rgb(229, 253, 245)">
                    <div class="card-body">  
                       @if ($startdate != '')
                            <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">                     
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th width="3%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">เดือน</th>  
                                                    <th class="text-center">จำนวน(เครื่อง)</th> 
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
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?>
                                            <?php 
                                                    $namyod_air = DB::select('SELECT COUNT(b.repaire_sub_id) as namyod FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "1" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($namyod_air as $key => $value_air) {$namyod = $value_air->namyod;} 

                                                    $lom_air = DB::select('SELECT COUNT(b.repaire_sub_id) as lomair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "2" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($lom_air as $key => $lom_air) {$lomair = $lom_air->lomair;} 

                                                    $men_air = DB::select('SELECT COUNT(b.repaire_sub_id) as menair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "3" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($men_air as $key => $air_men) {$menair = $air_men->menair;} 

                                                    $valumn_air = DB::select('SELECT COUNT(b.repaire_sub_id) as valumnair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "4" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($valumn_air as $key => $air_valumn) {$valumnair = $air_valumn->valumnair;}

                                                    $dap_air = DB::select('SELECT COUNT(b.repaire_sub_id) as dapair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "5" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($dap_air as $key => $air_dap) {$dapair = $air_dap->dapair;}

                                                    $aeun_air = DB::select('SELECT COUNT(b.repaire_sub_id) as aeunair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "6" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($aeun_air as $key => $air_auen) {$aeunair = $air_auen->aeunair;}
                                                    
                                            ?>                    
                                                <tr>                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->MONTH_NAME}} พ.ศ. {{$item->years_ps}}</td> 
                                                    <td class="text-center" style="font-size:13px;width: 10%;color: rgb(112, 5, 98)">
                                                        {{-- <a href="{{url('air_report_problem_group/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(209, 181, 236);width: 70%;" target="_blank">
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2" style="color: #8c07c0"></i>{{$item->count_ploblems}}</span>  
                                                        </a>  --}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(247, 209, 212)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank">
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2" style="color: rgb(253, 65, 81)"></i>{{$item->more_one}}</span>  
                                                        </a> --}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(252, 90, 203)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-droplet me-2"></i>{{$namyod}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(5, 179, 170)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2"></i>{{$lomair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(253, 102, 15)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fas fa-soap me-2"></i>{{$menair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(10, 132, 231)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-volume-high me-2"></i>{{$valumnair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(250, 128, 138)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-tenge-sign me-2"></i>{{$dapair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(8, 184, 228)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fab fa-slack me-2"></i>{{$aeunair}}</span>  
                                                        {{-- </a>  --}}
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
                                    <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th width="3%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">เดือน</th>  
                                                    <th class="text-center">จำนวน(เครื่อง)</th> 
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
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?>
                                            <?php 
                                                    $namyod_air = DB::select('SELECT COUNT(b.repaire_sub_id) as namyod FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "1" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($namyod_air as $key => $value_air) {$namyod = $value_air->namyod;} 

                                                    $lom_air = DB::select('SELECT COUNT(b.repaire_sub_id) as lomair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "2" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($lom_air as $key => $lom_air) {$lomair = $lom_air->lomair;} 

                                                    $men_air = DB::select('SELECT COUNT(b.repaire_sub_id) as menair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "3" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($men_air as $key => $air_men) {$menair = $air_men->menair;} 

                                                    $valumn_air = DB::select('SELECT COUNT(b.repaire_sub_id) as valumnair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "4" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($valumn_air as $key => $air_valumn) {$valumnair = $air_valumn->valumnair;}

                                                    $dap_air = DB::select('SELECT COUNT(b.repaire_sub_id) as dapair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "5" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($dap_air as $key => $air_dap) {$dapair = $air_dap->dapair;}

                                                    $aeun_air = DB::select('SELECT COUNT(b.repaire_sub_id) as aeunair FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                        WHERE MONTH(a.repaire_date) = "'.$item->months.'" AND YEAR(a.repaire_date) = "'.$item->years.'" AND b.air_repaire_ploblem_id = "6" AND b.air_repaire_type_code ="04"  
                                                    ');                                     
                                                    foreach ($aeun_air as $key => $air_auen) {$aeunair = $air_auen->aeunair;}
                                                    
                                            ?>                    
                                                <tr>                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->MONTH_NAME}} พ.ศ. {{$item->years_ps}}</td> 
                                                    <td class="text-center" style="font-size:13px;width: 10%;color: rgb(112, 5, 98)">
                                                        {{-- <a href="{{url('air_report_problem_group/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(209, 181, 236);width: 70%;" target="_blank">
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2" style="color: #8c07c0"></i>{{$item->count_ploblems}}</span>  
                                                        </a>  --}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(247, 209, 212)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank">
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2" style="color: rgb(253, 65, 81)"></i>{{$item->more_one}}</span>  
                                                        </a> --}} 
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(252, 90, 203)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-droplet me-2"></i>{{$namyod}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(5, 179, 170)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-fan me-2"></i>{{$lomair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(253, 102, 15)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fas fa-soap me-2"></i>{{$menair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(10, 132, 231)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-volume-high me-2"></i>{{$valumnair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(250, 128, 138)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fa-solid fa-tenge-sign me-2"></i>{{$dapair}}</span>  
                                                        {{-- </a>  --}}
                                                    </td>
                                                    <td class="text-center" style="font-size:13px;width: 8%;color: rgb(8, 184, 228)">
                                                        {{-- <a href="{{url('air_report_problem_morone/'.$item->repaire_date_start.'/'.$item->repaire_date_end)}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="background-color: rgb(250, 195, 200);width: 50%;" target="_blank"> --}}
                                                            <span class="ladda-label"> <i class="fab fa-slack me-2"></i>{{$aeunair}}</span>  
                                                        {{-- </a>  --}}
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
           
            // $('select').select2();
     
        
            // $('#example2').DataTable();
            // var table = $('#example').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 10,
            //     "lengthMenu": [10,25,30,31,50,100,150,200,300],
            // });
        
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
