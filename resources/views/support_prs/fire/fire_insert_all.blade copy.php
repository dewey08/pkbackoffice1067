@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Report')
 
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

       
        <div class="row"> 
            <div class="col-md-4"> 
                <h4 style="color:rgb(255, 255, 255)">บันทึกการตรวจสอบถังดับเพลิง</h4> 
            </div>
            <div class="col"></div> 
    </div>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">   

                        <div class="row">
                            <div class="col text-start"> 
                                <p style="color:red">ส่วนที่ 1 : รายละเอียด </p>
                            </div>
                            <div class="col-6 text-end"> 
                                <?php 
                                    // $countqti_ = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire WHERE air_list_num = "'.$data_detail_->air_list_num.'"');
                                    // foreach ($countqti_ as $key => $value) {
                                    //     $countqti = $value->air_list_num;
                                    // }
                                ?>
                                <p style="color:red">เปลี่ยนไปแล้ว 
                                    {{-- {{$countqti}}  --}}
                                    ครั้ง
                                </p>
                            </div>
                        </div>
                        @foreach ($fire_main as $item) 
                        <div class="row"> 
                                <div class="col text-start">
                                    @if ($item->fire_img == null)
                                        <img src="{{ asset('assets/images/defailt_img.jpg') }}" height="30px" width="30px"
                                            alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/air/' . $item->fire_img) }}" height="30px"
                                            width="30px" alt="Image" class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <p>รหัส : {{ $item->fire_num }}</p>
                                    {{-- <p>ชื่อ : {{ $item->fire_name }}</p> --}}
                                    {{-- <p>ขนาด : {{ $item->fire_size }}</p> --}}
                                    {{-- <p>ที่ตั้ง : {{ $item->fire_location }}</p>  --}}
                                </div> 
                        </div>
                        @endforeach
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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            });             
            $('#Process').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                        text: "You Want Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Want Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(200);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('tec.cctv_report_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
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
                                                            $("#overlay").fadeOut(200);
                                                        },400);
                                                }
                                            })
                                        } else if (data.status == 100) {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                                });
                                                Toast.fire({
                                                icon: "error",
                                                title: "กรุณาเลือกวันที่"
                                                });
                                                $('#spinner').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(200);
                                                    },400);
                                        } else {
                                             
                                        }
                                    },
                                });
                                
                            }
                })
        });
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
         
            
        });
    </script>
    @endsection
