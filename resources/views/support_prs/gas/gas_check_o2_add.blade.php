@extends('layouts.support_prs_gas')
@section('title', 'PK-OFFICE || ก๊าซทางการแพทย์')
 
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

    $date_now   = date('Y-m-d');

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
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>

       
        <div class="row"> 
            <div class="col text-center"> 
                <h4 style="color:rgb(255, 255, 255)">ตรวจสอบก๊าซอ๊อกซิเจน (2Q-6Q)</h4>   
            </div>
          
        </div>
        <div class="row"> 
            <div class="col text-center">   
                <p style="color:rgb(255, 255, 255);font-size:18px">วันที่ {{Datethai($date_now)}} เวลา:{{$mm}}</p>
            </div>
          
        </div>
    </div>  
        
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card card_prs_4">
                    <div class="card-body"> 
 
                        <div class="row">
                            <div class="col-4 text-end"> 
                                {{-- <p style="color:rgb(19, 154, 233);font-size:16px">วันที่ตรวจ</p> --}}
                            </div>
                            <div class="col text-start">  
                                {{-- <p style="color:rgb(19, 154, 233);font-size:16px">{{Datethai($date_now)}}</p> --}}
                                <input type="hidden" id="check_date" name="check_date" value="{{$date_now}}">
                                {{-- <input type="hidden" id="gas_type" name="gas_type" value="2"> --}}
                                
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="card-body">
                                <div class="table-responsive">  
                                    <table id="Tabledit" class="table table-bordered border-info table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">                                        
                                                <th class="text-center" style="background: #fdf7e4">รหัส</th>
                                                {{-- <th class="text-center" width="15%" style="background: #fdf7e4">รายการ</th>  --}}
                                                <th class="text-center" style="background: #e4fdfc">ขนาด</th> 
                                                <th class="text-center" style="background: #e4fdfc">วันที่ตรวจ</th>                                              
                                                <th class="text-center" style="background: #e4fdfc">สถานะ</th> 
                                                {{-- <th class="text-center" style="background: #e4fdfc">หัววาล์ว</th> --}}
                                                {{-- <th class="text-center" style="background: #e4fdfc">แรงดัน</th>  --}}
                                            </tr>
                                        
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                                $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; 
                                                
                                            ?>
                                            @foreach ($datashow as $item) 
                                            <?php 
                                                // if ($item->gas_list_id != '' || $item->gas_list_id != NULL) {
                                                    // $value    = DB::table('gas_check')->whereMonth('check_date',$month)->where('gas_type',"2")->where('gas_list_id',$item->gas_list_id)->first();
                                                    $checkdate   = DB::table('gas_check')->where('check_date',$item->check_date)->where('gas_list_id',$item->gas_list_id)->count();
                                                    if ( $checkdate > 0) {
                                                        $checkdate_  = DB::table('gas_check')->where('check_date',$item->check_date)->where('gas_list_id',$item->gas_list_id)->first();
                                                        $checkdate_s  = $checkdate_->check_date;
                                                    } else {
                                                        # code...
                                                    }
                                                    
                                                // $datashow_sub = DB::select(
                                                //     'SELECT gas_check_body,gas_check_body_name,gas_check_valve,gas_check_valve_name,gas_check_pressure,gas_check_pressure_name
                                                //      FROM gas_check WHERE month(check_date) = "'.$month.'"
                                                //      AND gas_list_num = "'.$item->gas_list_num.'" AND gas_type ="2"
                                                // '); 
                                                // foreach ($datashow_sub as $key => $value) {
                                                    // $gas_check_body_name      = $value->gas_check_body_name;
                                                    // $gas_check_valve_name     = $value->gas_check_valve_name;
                                                    // $gas_check_pressure_name  = $value->gas_check_pressure_name;
                                                // }
                                                // } else {
                                                    // $gas_check_body_name      = '';
                                                    // $gas_check_valve_name     = '';
                                                    // $gas_check_pressure_name  = '';
                                                // }
                                                if ($item->active == 'Ready') {
                                                    $active = 'พร้อมใช้';
                                                }
                                                
                                           
                                            ?>
                                            @if ($item->check_date_b == $datenow )
                                                <tr style="font-size:13px">                                                   
                                                    <td class="text-center" width="7%" >{{ $item->gas_list_num }} </td> 
                                                    <td class="text-center" width="7%">{{$item->size}}</td> 
                                                    <td class="text-center" width="7%" >{{$item->check_date_b}} </td> 
                                                    <td class="text-center" width="7%">{{$active}}</td>  
                                                </tr>
                                            @else
                                                <tr style="font-size:13px">                                             
                                                    <td class="text-center" width="7%" >{{ $item->gas_list_num }}</td> 
                                                    <td class="text-center" width="7%">{{$item->size}}</td> 
                                                   
                                                    <td class="text-center" width="7%"></td> 
                                                    <td class="text-center" width="7%"></td>  
                                                </tr>
                                            @endif
                                                
                                            @endforeach
                                        </tbody> 
                                    </table>
                                </div>
                            </div> 
                        </div>
                        <div class="row mt-4 mb-4">
                         
                            <div class="col text-center">
                                {{-- <button class="ladda-button me-2 btn-pill btn btn-success bt_prs" id="Insert_data"> 
                                    <i class="fa-solid fa-floppy-disk text-white me-2"></i>
                                   บันทึกข้อมูล
                                </button>   --}}
                                <a href="{{url('gas_check_o2')}}" class="ladda-button me-2 btn-pill btn btn-warning bt_prs">  
                                    {{-- <i class="fa-solid fa-xmark me-2"></i> --}}
                                    <i class="fa-solid fa-rotate-left me-2"></i>
                                    ย้อนกลับ
                                </a> 
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
    
    <script>
        $(document).ready(function() {
            $('#Tabledit').Tabledit({
                url:'{{route("prs.gas_check_o2_save")}}',
                dataType:"json",
                // editButton: true,
                removeButton: false,
                columns:{
                    identifier:[0,'gas_list_num'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3'], [9, 'gender', '{"1":"Male", "2":"Female"}']] 
                    // editable: [[3, 'active', '{"0":"Ready", "1":"NotReady"},"2":"Borrow"},"3":"Back"}']]
                    editable: [[3, 'active', '{"Ready":"พร้อมใช้", "NotReady":"ไม่พร้อมใช้", "Wait":"รอเติม", "Borrow":"ยืมคืน"}']]
                },
                // restoreButton:false,
                deleteButton: false,
                // saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        // class: 'btn-icon btn-shadow btn-dashed btn btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
                        action: 'Edit'
                    }
                },
                onSuccess:function(data)
                {
                    if (data.status == 200) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Edit Success",
                            showConfirmButton: false,
                            timer: 1500
                            });
                            window.location.reload();
                   } else {
                    
                   }
                    
                } 
            });
 
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
            
            $('#Insert_data').click(function() {
                var check_date         = $('#check_date').val(); 
                // var gas_type           = $('#gas_type').val(); 
                // var standard_value     = $('#standard_value').val(); 
                // var standard_value_min = $('#standard_value_min').val(); 
                // var pressure_value     = $('#pressure_value').val(); 
                // var pariman_value      = $('#pariman_value').val(); 
                // var gas_list_id        = $('#gas_list_id').val();
                
                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Insert Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Insert it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.gas_check_tanksub_saveall') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {check_date},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Insert data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    // window.location.reload();
                                                    window.location="{{url('gas_check_tank')}}"; 
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
