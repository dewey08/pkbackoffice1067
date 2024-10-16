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
    <form action="{{ url('air_report_company') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h5 style="color:rgb(255, 255, 255)">รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามบริษัท</h5>
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
            </div>
            <div class="col-md-2 text-center mb-2">
                <select class="form-control bt_prs" id="air_supplies_id" name="air_supplies_id" style="width: 100%">
                    <option value="" class="text-center">เลือกบริษัท</option>
                        @foreach ($air_supplies as $item_t)
                        @if ($supplies_id == $item_t->air_supplies_id)
                            <option value="{{ $item_t->air_supplies_id }}" class="text-center" selected> {{ $item_t->supplies_name }}</option>
                        @else
                            <option value="{{ $item_t->air_supplies_id }}" class="text-center"> {{ $item_t->supplies_name }}</option>
                        @endif 
                        @endforeach 
                </select>
            </div>
         
            <div class="col-md-4 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bt_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control bt_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                      
                        <a href="{{url('air_report_company_excel')}}" class="ladda-button btn-pill btn btn-success bt_prs">
                            <span class="ladda-label"> <i class="fa-solid fa-file-excel me-2"></i>Export</span>  
                        </a>
                </div> 
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
                                        <th class="text-center" width="5%">วันที่ซ่อม</th>   
                                        <th class="text-center" width="5%">เวลา</th>  
                                        <th class="text-center" width="5%">เลขที่แจ้งซ่อม</th> 
                                        <th class="text-center" >รายการ</th>  
                                        {{-- <th class="text-center" >ขนาด(btu)</th>   --}}
                                        <th class="text-center" >อาคารที่ตั้ง</th>  
                                        <th class="text-center" >หน่วยงาน</th>  
                                        <th class="text-center" >ซ่อม/บำรุงรักษา</th>   
                                        <th class="text-center">เจ้าหน้าที่</th>
                                        <th class="text-center">ช่างซ่อม(รพ)</th>
                                        <th class="text-center">ช่างแอร์</th>
                                        <th class="text-center">บริษัท</th>
                                    </tr>
                                
                               
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    
                                    <tr id="tr_{{$item->air_repaire_id}}">                                                  
                                        {{-- <td class="text-center" width="3%">{{ $i++ }}</td>    --}}
                                        <td class="text-center" width="7%">{{ DateThai($item->repaire_date )}}</td>  
                                        <td class="text-center" width="5%">{{ $item->repaire_time }}</td>   
                                        <td class="text-center" width="5%">{{ $item->air_repaire_no }}</td> 
                                        <td class="p-2">{{ $item->air_list_name }} - {{ $item->btu }} btu </td>  
                                        {{-- <td class="p-2" width="5%">{{ $item->btu }}</td>   --}}
                                        <td class="p-2" width="10%">{{ $item->air_location_name }}</td>  
                                        <td class="p-2" width="10%">{{ $item->debsubsub }}</td>  
                                        <td class="p-2" width="10%"> 
                                            @if ($supplies_id == '')
                                                <p class="mt-2" style="font-size: 13px;color:rgb(6, 149, 168)">
                                                    - {{$item->repaire_sub_name}}  
                                                </p>
                                            @else
                                                <?php 
                                                    $datas_sub_= DB::select(
                                                        'SELECT * FROM air_repaire_sub WHERE air_repaire_id = "'.$item->air_repaire_id.'" 
                                                    ');
                                                ?>
                                                @foreach ($datas_sub_ as $v_1)
                                                    @if ($v_1->air_repaire_type_code == '04')
                                                    <p class="mt-2" style="font-size: 13px;color:rgb(6, 149, 168)">
                                                        - {{$v_1->repaire_sub_name}} 
                                                    </p>
                                                    @else
                                                    <p class="mt-2" style="font-size: 13px;color:rgb(6, 149, 168)">
                                                        - {{$v_1->repaire_sub_name}} ครั้งที่ {{$v_1->repaire_no}}
                                                    </p>
                                                    @endif
                                                   
                                                @endforeach 
                                                <p class="mt-2" style="font-size: 13px;color:rgb(6, 149, 168)">
                                                    - {{$item->air_problems_orthersub}} 
                                                </p>
                                            @endif
                                            
                                        </td>  
                                        <td class="p-2" width="7%">{{ $item->staff_name }}</td> 
                                        <td class="p-2" width="7%">{{ $item->tect_name }}</td> 
                                        <td class="p-2" width="7%">{{ $item->air_techout_name }}</td> 
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
