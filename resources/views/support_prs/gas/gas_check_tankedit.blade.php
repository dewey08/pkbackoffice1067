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
                <h4 style="color:rgb(255, 255, 255)">ตรวจสอบออกซิเจนเหลว(Main)</h4> 
            </div>
          
        </div>
    </div>  
        
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body"> 

                        <div class="row">
                            <div class="col text-center"> 
                                <p style="color:rgb(19, 154, 233);font-size:19px">เช็คระดับปริมาณออกซิเจนเหลว</p>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-4 text-end"> 
                                <p style="color:rgb(19, 154, 233);font-size:16px">วันที่ตรวจ</p>
                            </div>
                            <div class="col text-start">  
                                <p style="color:rgb(19, 154, 233);font-size:16px">{{Datethai($date_now)}}</p>
                                <input type="hidden" id="check_date" name="check_date" value="{{$date_now}}">
                                <input type="hidden" id="gas_type" name="gas_type" value="{{$gas_type}}">
                                <input type="hidden" id="gas_list_id" name="gas_list_id" value="{{$gas_list_id}}">
                                <input type="hidden" id="standard_value" name="standard_value" value="124">
                                <input type="hidden" id="standard_value_min" name="standard_value_min" value="50">
                                <input type="hidden" id="gas_check_id" name="gas_check_id" value="{{$data_edit->gas_check_id}}">
                                
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-4 text-end"> 
                                <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ระดับ O2</p>
                            </div>
                            <div class="col text-start">  
                                <input type="text" class="form-control" id="pariman_value" name="pariman_value" style="color:rgb(19, 154, 233);font-size:16px;background-color: white" value="{{$data_edit->pariman_value}}"> 
                            </div> 
                            <div class="col-3 text-start"> 
                                <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">inH2O</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-end"> 
                                <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ค่าแรงดัน</p>
                            </div>
                            <div class="col text-start">  
                                <input type="text" class="form-control" id="pressure_value" name="pressure_value" style="color:rgb(19, 154, 233);font-size:16px;background-color: white" value="{{$data_edit->pressure_value}}"> 
                            </div> 
                            <div class="col-3 text-start"> 
                                <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            {{-- <div class="col"></div> --}}
                            <div class="col text-center">
                                <button class="ladda-button me-2 btn-pill btn btn-success bt_prs" id="Update_data"> 
                                    <i class="fa-regular fa-pen-to-square me-2"></i>
                                    แก้ไขข้อมูล
                                </button>  
                                <a href="{{url('gas_check_tank')}}" class="ladda-button me-2 btn-pill btn btn-danger bt_prs">  
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>  
                            </div>
                            {{-- <div class="col"></div> --}}
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
 
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
            
            $('#Update_data').click(function() {
                // var check_date         = $('#check_date').val(); 
                // var gas_type           = $('#gas_type').val(); 
                // var standard_value     = $('#standard_value').val(); 
                // var standard_value_min = $('#standard_value_min').val(); 
                var pressure_value     = $('#pressure_value').val(); 
                var pariman_value      = $('#pariman_value').val(); 
                var gas_check_id       = $('#gas_check_id').val();
                
                Swal.fire({ position: "top-end",
                        title: 'ต้องการแก้ไขข้อมูลใช่ไหม ?',
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
                                    url: "{{ route('prs.gas_check_tank_update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {pressure_value,pariman_value,gas_check_id},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'แก้ไขข้อมูลสำเร็จ',
                                                text: "You Update data success",
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
