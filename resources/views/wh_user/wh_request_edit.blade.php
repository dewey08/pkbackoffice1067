@extends('layouts.user_layout')
@section('title', 'PK-OFFICE || Where House')

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

    <style>
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
            border-top: 10px rgb(252, 101, 1) solid;
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
    </style>

<div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div> 
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <div class="container mt-5"> 
    
            <div class="row"> 
                <div class="col-md-6"> 
                    <h4 class="text-start" style="color:rgb(5, 113, 185);">แก้ไขใบเบิกพัสดุ </h4>
                </div>
                <div class="col"></div>   
                <div class="col-md-4 text-end">
                    {{-- <a href="{{url('wh_recieve_add')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" target="_blank">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> 
                        ตรวจรับ
                    </a>  --}}
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_border" >
                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                       บันทึก
                   </button>
                   <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_border"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                </div>
            </div> 
        
            <div class="row mt-3">
                <div class="col-md-12">                
                    <div class="card card_prs_4" style="background-color: rgb(238, 252, 255)">
                        <div class="card-body"> 
                            <div class="row mt-3">
                                <div class="col-md-2 text-end">เลขที่บิล</div>
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <input type="text" class="form-control-sm input_border" id="request_no" name="request_no" value="{{ $data_edit->request_no }}" readonly style="font-size:13px;width: 100%">
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">วันที่เบิกพัสดุ</div>
                                <div class="col-md-2">
                                    <div class="form-group text-center"> 
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            <input type="text" class="form-control-sm input_border" name="datepicker" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $data_edit->request_date }}" style="font-size:13px"/>
                                                 
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group text-center">
                                        <input type="time" class="form-control-sm input_border" id="request_time" name="request_time" value="{{$data_edit->request_time}}" style="font-size:13px;width: 100%">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 mb-3">
                                <div class="col-md-2 text-end">ผู้เบิก</div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm input_border" id="user_request" name="user_request" value="{{$data_edit->fname}} {{$data_edit->lname}}" style="font-size:13px;width: 100%" readonly>
                                    </div>
                                </div> 
                            </div>
                            
                            <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{ $data_edit->year }}"> 
                            <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$data_edit->wh_request_id}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">   
                </div>
            </div>
        </div>

</div>


 
 
@endsection
@section('footer')
 
    <script>
        var Linechart;
        $(document).ready(function() {
            $('select').select2();
            $('#example').DataTable();
            $('#example2').DataTable();
            
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#UpdateData').click(function() {
                var request_no    = $('#request_no').val(); 
                var request_date  = $('#datepicker').val(); 
                var request_time  = $('#request_time').val();  
                var wh_request_id = $('#wh_request_id').val(); 
                var bg_yearnow    = $('#bg_yearnow').val();  

                Swal.fire({ position: "top-end",
                        title: 'ต้องการแก้ไขใบเบิกพัสดุใช่ไหม ?',
                        text: "You Warn EDIT Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, EDIT it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('wh.wh_request_update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    // data: {request_no,request_date,request_time,stock_list_id,bg_yearnow},
                                    data: {request_no,request_date,request_time,bg_yearnow,wh_request_id},
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
                                                    window.location = "{{url('wh_sub_main_rp')}}"; 
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
