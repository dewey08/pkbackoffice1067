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
    <form action="{{ url('air_report_department') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h5 style="color:rgb(255, 255, 255)">รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามหน่วยงานรายเดือน</h5> 
            </div>
            <div class="col-md-2 text-center mb-2">
                <select class="form-control bt_prs" id="air_location_id" name="air_location_id" style="width: 100%">
                    <option value="" class="text-center">เลือกอาคาร</option>
                        @foreach ($air_location as $item_t)
                        @if ($air_location_id == $item_t->air_location_id)
                            <option value="{{ $item_t->air_location_id }}" class="text-start" selected> {{ $item_t->air_location_name }}</option>
                        @else
                            <option value="{{ $item_t->air_location_id }}" class="text-start"> {{ $item_t->air_location_name }}</option>
                        @endif 
                        @endforeach 
                </select>
            </div>
         
            <div class="col-md-2 text-end"> 
                <select class="form-control bt_prs" id="air_plan_month" name="air_plan_month" style="width: 100%" required>
                    {{-- <option value="" class="text-center">เดือน / ปี</option> --}}
                        @foreach ($air_plan_month as $item_m)
                        @if ($air_planmonth == $item_m->air_plan_month && $air_planyears == $item_m->air_plan_year)
                            <option value="{{ $item_m->air_plan_month_id }}" class="text-center" selected> {{ $item_m->air_plan_name }} {{$item_m->years}}</option>
                        @else
                            <option value="{{ $item_m->air_plan_month_id }}" class="text-center"> {{ $item_m->air_plan_name }} {{$item_m->years}}</option>
                        @endif 
                        @endforeach 
                </select>
            </div>
            <div class="col-md-2 text-start"> 
                <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                </button> 
                <a href="{{url('air_report_department_excel')}}" class="ladda-button btn-pill btn btn-success bt_prs">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel me-2"></i>Export</span>  
                </a>
            </div>
                {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bt_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control bt_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button>                       
                        <a href="{{url('air_report_department_excel')}}" class="ladda-button btn-pill btn btn-success bt_prs">
                            <span class="ladda-label"> <i class="fa-solid fa-file-excel me-2"></i>Export</span>  
                        </a>
                </div>  --}}
            </div>
        </div>  
    </form>
<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                <div class="row mb-3">
                    <div class="col"></div> 
                   
                    
                </div>

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">  --}}
                            <thead>
                              
                                    <tr style="font-size:13px">  
                                        <th class="text-center" width="5%">ลำดับ</th>  
                                        <th class="text-center" >รายการ (รหัส : ยี่ห้อ : BTU)</th>   
                                        <th class="text-center" >อาคารที่ตั้ง (ชื่ออาคาร : เลขอาคาร : ชั้นอาคาร)</th>  
                                        <th class="text-center" >หน่วยงาน</th>  
                                        <th class="text-center" >แผนบำรุงรักษาครั้ง 1</th>   
                                        <th class="text-center">แผนบำรุงรักษาครั้ง 2</th>
                                        <th class="text-center">บริษัทผู้ดำเนินการ</th> 
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    
                                    <tr>                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>    
                                        <td class="p-2">{{ $item->air_list_name }} BTU </td> 
                                        <td class="p-2">{{ $item->air_location_name }}</td>  
                                        <td class="p-2" >{{ $item->debsubsub }}</td>                                          
                                        <td class="text-center" width="7%">{{ $item->plan_one }}</td> 
                                        <td class="text-center" width="7%">{{ $item->plan_two }}</td> 
                                        <td class="p-2" width="7%">{{ $item->supplies_name }}</td>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </p>
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

            $('.exportExcel').on('click', function(e) {
                var air_repaire_type = $('#air_repaire_type').val(); 
                var datepicker       = $('#datepicker').val(); 
                var datepicker2      = $('#datepicker2').val(); 
                
                    Swal.fire({
                        position: "top-end",
                        title: 'Are you sure?',
                        text: "คุณต้องการส่งออก EXCEL ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Export it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                  
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: {air_repaire_type,datepicker,datepicker2},
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    
                                                    Swal.fire({
                                                        position: "top-end",
                                                        title: 'ส่งออก Excel สำเร็จ',
                                                        text: "You Export Excel success",
                                                        icon: 'success',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#06D177',
                                                        confirmButtonText: 'เรียบร้อย'
                                                    }).then((result) => {
                                                        if (result
                                                            .isConfirmed) {
                                                            console.log(
                                                                data);
                                                                window.location = "{{ url('air_report_type_excel') }}";
                                                            // window.location.reload();
                                                            $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                        }
                                                    })
                                                } else {
                                                    Swal.fire({
                                                        position: "top-end",
                                                        icon: "warning",
                                                        title: "กรุณาเลือกวันที่และประเภท",
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                 
                                                }
                                                 
                                        }
                                    });
                                   
                             
                            }
                        }) 
                   
            });

        });
    </script>

@endsection
