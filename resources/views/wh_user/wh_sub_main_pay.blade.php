@extends('layouts.user_layout')
@section('title', 'PK-OFFICE || Where House')

@section('content')

    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function wh_approve_stock(wh_request_id) {
            // alert(bookrep_id);
            Swal.fire({
                title: 'ยืนยันการรับใช่ไหม?',
                text: "ถ้ากดยืนยันรายการพัสดุจะถูกรับเข้าคลังย่อย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, รับเข้าเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('wh_approve_stock') }}" + '/' + wh_request_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'รับเข้าเรียบร้อย!',
                                text: "You Confirm success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + wh_request_id).remove();
                                    window.location.reload();
                                    // window.location = "/book/bookmake_index"; //   

                                }
                            })
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
        $ynow = date('Y') + 543;
        $yb = date('Y') + 542;
            use App\Http\Controllers\StaticController;
            use App\Http\Controllers\WhUserController;
            use App\Models\Products_request_sub;
            $ref_pay_number = WhUserController::ref_pay_number();
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
        <form action="{{ URL('wh_sub_main_pay') }}" method="GET">
            @csrf
        <div class="row mt-5">  
            <div class="col-md-5"> 
                {{-- <h4 style="color:rgb(238, 33, 111)">รายละเอียดการเบิก</h4>  --}}
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-white card_prs_4">
                   <i class="fa-regular fa-rectangle-list me-2 ms-2"></i>รายละเอียดการตัดจ่าย
                </button>
            {{-- </div> --}}
            {{-- <div class="col-md-2">  --}}
                <a href="{{url('wh_sub_main')}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="color:rgb(255, 84, 149)">
                    <i class="fa-solid fa-clipboard-check me-2 ms-2" style="color:rgb(255, 84, 149)"></i> คลัง {{$stock_name}}  
                </a>
            </div>
            <div class="col"></div>  
            <div class="col-md-4 text-end mb-3">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                <input type="text" class="form-control-sm card_prs_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                    data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                <input type="text" class="form-control-sm card_prs_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                    data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $enddate }}" />
                        <button type="submit" class="ladda-button btn-pill btn btn-info cardacc" data-style="expand-left">
                            <span class="ladda-label"><i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </form>
                   
                        <a href="javascript:void(0);" class="ladda-button btn-pill btn btn-sm btn-primary card_prs_4" data-bs-toggle="modal" data-bs-target="#Request">
                            <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> สร้างใบเบิกจ่าย  
                        </a> 
            </div> 
        </div> 
             
            {{-- <div class="col-md-4 text-end"> 
                
                    <a href="{{url('wh_sub_main')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-info card_prs_4 mb-3">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> คลัง {{$stock_name}}  
                    </a>
                    <a href="javascript:void(0);" class="ladda-button me-2 btn-pill btn btn-sm btn-primary card_prs_4 mb-3" data-bs-toggle="modal" data-bs-target="#Request">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> เปิดบิล  
                    </a> 
            </div> --}}
        </div>
        
        <div class="row">
            <div class="col-md-12">     
                <div class="card card_prs_4" style="background-color: rgb(238, 252, 255)">

                    <div class="card-body">
                        
                        <div class="row"> 
                            <div class="col-xl-12">
                                {{-- <table id="example" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">   --}}
                                {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">   --}}
                                    <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">     
                                    <thead> 
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="5%">สถานะ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="5%">ปีงบประมาณ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="8%">เลขที่บิล</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="10%">วันที่ตัดจ่ายพัสดุ</th> 
                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 13px;">คลังย่อย</th>  
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 13px;" width="10%">ยอดรวม</th> 
                                            <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 13px;" width="10%">ผู้จ่าย</th>  
                                            <th class="text-center" width="5%">จัดการ</th> 
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                        @foreach ($wh_pay as $item)
                                        <?php $i++ ?>
                                        <tr id="sid{{ $item->wh_pay_id }}" style="font-size:12px;">
                                            <td class="text-center" width="5%">{{$i}}</td>
                                            <td class="text-center" width="5%"> 
                                                
                                                @if ($item->active == 'REQUEST')
                                                    <span class="bg-warning badge" style="font-size:10px">สร้างใบตัดจ่ายพัสดุ</span> 
                                                {{-- @elseif ($item->active == 'APPREQUEST')
                                                    <span class="badge" style="font-size:10px;background-color: #0dd6d6">รายการครบ</span> 
                                                @elseif ($item->active == 'APPROVE')
                                                    <span class="bg-info badge" style="font-size:10px">เห็นชอบ</span> 
                                                @elseif ($item->active == 'ALLOCATE')
                                                    <span class="bg-secondary badge" style="font-size:10px">กำลังดำเนิน</span> 
                                                @elseif ($item->active == 'CONFIRM')
                                                    <span class="badge" style="font-size:10px;background-color: #ff568e">รอยืนยันการจ่ายพัสดุ</span>  
                                                @elseif ($item->active == 'CONFIRMSEND')
                                                    <span class="badge" style="font-size:10px;background-color: #ae58ff">รอรับเข้าคลัง</span>  --}}
                                                @elseif ($item->active == 'APPROVE')
                                                    <span class="bg-success badge" style="font-size:10px">ตัดจ่ายคลังย่อยเรียบร้อย</span> 
                                                @else
                                                    {{-- <span class="bg-primary badge" style="font-size:10px">รับเข้าคลัง</span>  --}}
                                                @endif    

                                            </td>
                                            <td class="text-center" width="5%">{{$item->year}}</td>
                                            <td class="text-center" width="8%">{{$item->pay_no}}</td>
                                            <td class="text-center" width="8%">{{Datethai($item->pay_date)}}</td>  
                                            <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->DEPARTMENT_SUB_SUB_NAME}}</td>  
                                            
                                            <td class="text-end" style="color:rgb(4, 115, 180)" width="8%">{{number_format($item->total_price, 2)}}</td>   
                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname}}</td>  
                                            <td class="text-center" width="5%">                                                       
                                                
                                              
                                                    @if ($item->active == 'ALLOCATE')
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="กำลังดำเนินการ"
                                                        <i class="fa-solid fa-spinner text-success"></i>
                                                    </a> 
                                                    @elseif ($item->active == 'CONFIRM')
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="รอยืนยันการจ่ายพัสดุ"
                                                        <i class="fa-solid fa-check text-success"></i> 
                                                    </a> 
                                                        
                                                        @elseif ($item->active == 'CONFIRMSEND')
                                                        <a href="javascript:void(0)" onclick="wh_approve_stock({{ $item->wh_pay_id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip" title="ยืนยันการรับพัสดุเข้า"><i class="fa-solid fa-hand-point-up text-primary ms-2" style="color: #0776c0;font-size:20px"></i> 
                                                        </a> 
                                                 
                                                    @elseif ($item->active == 'REPEXPORT')
                                                       
                                                        <button type="button" class="btn detailModal" style="background: transparent" value="{{ $item->wh_pay_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="รายละเอียด"> 
                                                            <i class="fa-regular fa-rectangle-list" style="color: #079ecc;font-size:20px"></i>
                                                        </button>
                                                    @else
                                                        {{-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditRequest{{$item->wh_pay_id}}">
                                                            <i class="fa-solid fa-file-pen" style="color: #f76e13;font-size:20px"></i>
                                                        </a> --}}
                                                        <a href="{{url('wh_sub_main_payadd/'.$item->wh_pay_id)}}" target="_blank">
                                                            <i class="fa-solid fa-cart-plus" style="color: #068fb9;font-size:20px"></i>
                                                        </a> 
                                                    @endif                                                         
                                                
                                                
                                            </td> 
                                        </tr>

                                          
                                            
                                        @endforeach                                                
                                    </tbody>
                                    
                                </table>

                            </div>
                        </div>  
                    </div>
                        
                </div>  

            </div>
        </div> 

        <!--  Modal content forRecieve -->
        <div class="modal fade" id="Request" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:rgb(236, 105, 18)">สร้างใบตัดจ่าย </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 text-end">เลขที่บิล</div>
                            <div class="col-md-9">
                                <div class="form-group text-center">
                                    <input type="text" class="form-control form-control-sm" id="pay_no" name="pay_no" value="{{$ref_pay_number}}" readonly>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 text-end">วันที่ตัดจ่ายพัสดุ</div>
                            <div class="col-md-5">
                                <div class="form-group text-center"> 
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" >
                                        <input type="text" class="form-control form-control-sm cardacc" name="pay_date" id="pay_date" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}" readonly/>
                                             
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <input type="time" class="form-control form-control-sm" id="pay_time" name="pay_time" value="{{$mm}}" readonly>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-2">
                            <div class="col-md-3 text-end">คลังที่ต้องการเบิก</div>
                            <div class="col-md-9">
                                <select name="stock_list_id" id="stock_list_id"  class="custom-select custom-select-sm" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($wh_stock_list as $item_sup)
                                            <option value="{{$item_sup->stock_list_id}}">{{$item_sup->stock_list_name}}</option>
                                        @endforeach
                                </select>
                            </div> 
                        </div> --}}

                        <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <button type="button" id="InsertRequest" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
                                     <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                                    บันทึก
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- companymaintanantModal Modal --> 
         <div class="modal fade" id="detailModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">รายการที่ขอเบิก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">  
                            <div class="row">
                                <div class="col-md-12">
                                    <div style='overflow:scroll; height:500px;'>
                                        <div id="detail_showModal"></div> 
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
            $('#example').DataTable();
            $('#example2').DataTable();
            
           
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd' 
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#edit_datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            // $('select').select2();           
            
            $('#stock_list_id').select2({
                    dropdownParent: $('#Request')
            });
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            // $('#editstock_list_id').select2({
            //         dropdownParent: $('#EditRequest')
            // });
                        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#InsertRequest').click(function() {
                var pay_no        = $('#pay_no').val(); 
                var pay_date      = $('#pay_date').val(); 
                var pay_time      = $('#pay_time').val();  
                // var stock_list_id = $('#stock_list_id').val(); 
                var bg_yearnow    = $('#bg_yearnow').val();  

                Swal.fire({ position: "top-end",
                        title: 'ต้องการสร้างใบตัดจ่ายใช่ไหม ?',
                        text: "You Warn Add Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Add it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('wh.wh_sub_main_paysave') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {pay_no,pay_date,pay_time,bg_yearnow},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'สร้างใบตัดจ่ายสำเร็จ',
                                                text: "You Add data success",
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

            $('#UpdateRequest').click(function() {
                var request_no    = $('#edit_request_no').val(); 
                var request_date  = $('#edit_request_date').val(); 
                var request_time  = $('#edit_request_time').val(); 
                var stock_list_id = $('#editstock_list_id').val(); 
                var bg_yearnow    = $('#edit_bg_yearnow').val();  
                var wh_request_id = $('#edit_wh_request_id').val(); 

                Swal.fire({ position: "top-end",
                        title: 'ต้องการแก้ไขข้อมูลใช่ไหม ?',
                        text: "You Warn Edit Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Edit it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('wh.wh_request_update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {request_no,request_date,request_time,stock_list_id,bg_yearnow,wh_request_id},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'แก้ไขข้อมูลสำเร็จ',
                                                text: "You Edit data success",
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

        $(document).on('click', '.detailModal', function() {
                var wh_request_id = $(this).val(); 
                // var maintenance_list_num = '2';
                $('#detailModal').modal('show');           
                $.ajax({
                    type: "GET",
                    url:"{{ url('wh_sub_main_detail') }}",
                    data: { wh_request_id: wh_request_id},
                    success: function(result) { 
                        $('#detail_showModal').html(result);
                    },
                });
            });
         
    </script>
  

@endsection
