@extends('layouts.support_prs_gas')
@section('title', 'PK-OFFICE || ก๊าซธรรมชาติ')
 
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
            <div class="col-12 text-center"> 
                <h4 style="color:rgb(255, 255, 255)">ตรวจสอบ Control Gas</h4> 
            </div> 
        </div>
        <div class="row"> 
            <div class="col text-center">   
                <p style="color:rgb(255, 255, 255);font-size:18px">วันที่ {{Datethai($date_now)}} เวลา:{{$mm}}</p>
            </div>
          
        </div>
    </div>  
        
    <div class="row mt-2">
        <div class="col-xl-12">
            <div class="card card_prs_4">
                <div class="card-body"> 
 
                    <input type="hidden" id="check_date" name="check_date" value="{{$date_now}}">

                    <input type="hidden" id="gas_list_id" name="gas_list_id" value="{{$gas_list_id}}"> 
                    <input type="hidden" id="gas_list_num" name="gas_list_num" value="{{$gas_list_num}}">
                    <input type="hidden" id="gas_list_name" name="gas_list_name" value="{{$gas_list_name}}">

                    <input type="hidden" id="class_edit" name="class_edit" value="{{$class}}">
                    <input type="hidden" id="dot_name" name="dot_name" value="{{$dot_name}}">                   
                     <input type="hidden" id="location_name" name="location_name" value="{{$location_name}}">
                      {{-- <input type="hidden" id="gas_list_id" name="gas_list_id" value="{{$gas_list_id}}"> --}}
                       {{-- <input type="hidden" id="gas_list_id" name="gas_list_id" value="{{$gas_list_id}}"> --}}


                    <div class="row">
                        <div class="col text-center"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">{{$location_name}}</p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col text-center"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2"> ชั้น {{ $class}} จุดตรวจ {{ $dot_name}}</p>
                        </div> 
                    </div>

                   
                    <div class="row">
                        <div class="col-8 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">Oxygen Control</p>
                        </div>
                        <div class="col text-start">  
                            <input type="text" class="form-control" id="oxygen_check" name="oxygen_check" style="color:rgb(19, 154, 233);font-size:16px;background-color: white"> 
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">inH2O</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-8 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">Nitrous oxide Control</p>
                        </div>
                        <div class="col text-start">  
                            <input type="text" class="form-control" id="nitrous_oxide_check" name="nitrous_oxide_check" style="color:rgb(19, 154, 233);font-size:16px;background-color: white"> 
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-8 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">Pneumatic Air Control</p>
                        </div>
                        <div class="col text-start">  
                            <input type="text" class="form-control" id="pneumatic_air_check" name="pneumatic_air_check" style="color:rgb(19, 154, 233);font-size:16px;background-color: white"> 
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-8 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">Vacuum Control</p>
                        </div>
                        <div class="col text-start">  
                            <input type="text" class="form-control" id="vacuum_check" name="vacuum_check" style="color:rgb(19, 154, 233);font-size:16px;background-color: white"> 
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-8 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">สถานะ</p>
                        </div>
                        <div class="col text-start">  
                            {{-- <input type="text" class="form-control" id="pneumatic_air_check" name="pneumatic_air_check" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">  --}}
                            <select name="active_edit" id="active_edit" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Ready">พร้อมใช้งาน</option>
                                <option value="NotReady">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div> 
                       
                    </div>
                    <div class="row mt-4 mb-4">                         
                        <div class="col text-center">
                            <button type="button" class="ladda-button me-2 btn-pill btn btn-success bt_prs" id="Save_data"> 
                                <i class="fa-solid fa-floppy-disk text-white me-2"></i>
                               บันทึกข้อมูล
                            </button>  
                            <a href="{{url('gas_control_add')}}" class="ladda-button me-2 btn-pill btn btn-danger bt_prs">  
                                <i class="fa-solid fa-xmark me-2"></i>
                                ยกเลิก
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
            $('#active_edit').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
            
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
            
            $('#Save_data').click(function() {
                var check_date           = $('#check_date').val(); 
                var gas_list_id          = $('#gas_list_id').val(); 
                var oxygen_check         = $('#oxygen_check').val(); 
                var nitrous_oxide_check  = $('#nitrous_oxide_check').val(); 
                var pneumatic_air_check  = $('#pneumatic_air_check').val(); 
                var vacuum_check         = $('#vacuum_check').val(); 

                var class_edit                = $('#class_edit').val(); 
                var dot_name             = $('#dot_name').val(); 
                var location_name        = $('#location_name').val(); 
                var active_edit          = $('#active_edit').val(); 
                
               
                
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
                                    url: "{{ route('prs.gas_control_addsub_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {check_date,oxygen_check,nitrous_oxide_check,pneumatic_air_check,vacuum_check,gas_list_id,class_edit,dot_name,location_name,active_edit},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ 
                                                position: "top-end",
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
                                                    window.location="{{url('gas_control_add')}}"; 
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            Swal.fire({ 
                                                position: "top-end",
                                                title: 'บันทึกข้อมูลไปแล้ว',
                                                text: "You Insert data success befor",
                                                icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, Insert data befor!'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    // window.location.reload();
                                                    window.location="{{url('gas_control_add')}}"; 
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        }
                                    },
                                });
                                
                            }
                })
            });
         
            
        });
    </script>
    @endsection
