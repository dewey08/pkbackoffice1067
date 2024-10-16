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
        use App\Http\Controllers\StaticController;
        use App\Http\Controllers\WhUserController;
        use App\Models\Products_request_sub;
        $ref_request_number = WhUserController::ref_request_number();
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
    
        <div class="row mt-5">  
            <div class="col-md-6"> 
                <h4 style="color:rgb(238, 33, 111)">รายละเอียดการเบิกจ่าย</h4> 
            </div>
            <div class="col"></div>   
            <div class="col-md-2 text-end"> 
                    <a href="javascript:void(0);" class="ladda-button me-2 btn-pill btn btn-sm btn-primary input_new mb-3" data-bs-toggle="modal" data-bs-target="#Request">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> เปิดบิล  
                    </a>
                    {{-- <div id="headingTwo" class="b-radius-0">   
                        <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary mb-3" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em;color:white"> 
                            <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i>  ตรวจรับ
                        </button>  
                    </div>  --}}
            </div>
        </div>

        
 
        <div data-parent="#accordion" id="collapseOne2" class="collapse">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card_prs_4">    
                            <div class="card-body ">  
                                <div class="row">  
                                    <div class="col-md-12">         
                                           
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h4 class="card-title">ตรวจรับทั่วไป</h4>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-2 text-end">
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2" id="InsertData">
                                                        <i class="pe-7s-diskette btn-icon-wrapper text-info ms-2 me-2"></i>Save 
                                                    </button> 
                                                    
                                                
                                                </div>
                                            </div>
                                           
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">
                                                        <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                                        <span class="d-none d-sm-block">รายละเอียด</span>    
                                                    </a>
                                                </li>
                                               <!-- <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#trimart" role="tab">
                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                        <span class="d-none d-sm-block">ไตรมาส</span>    
                                                    </a>
                                                </li>  -->
                                            </ul>
    
                                            <!-- Tab panes -->
                                            <div class="tab-content p-3 text-muted">
                                                <div class="tab-pane active" id="detail" role="tabpanel">
                                                    {{-- <p class="mb-0">
                                                        <div class="row">
                                                            <div class="col-md-2 text-end">เลขที่บิล</div>
                                                            <div class="col-md-4">
                                                                <div class="form-group text-center">
                                                                    <input type="text" class="form-control form-control-sm" id="recieve_no" name="recieve_no">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-end">วันที่รับเข้าคลัง</div>
                                                            <div class="col-md-2">
                                                                <div class="form-group text-center"> 
                                                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                                        <input type="text" class="form-control form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                                            data-date-language="th-th" value="{{ $date_now }}" required/>
                                                                             
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group text-center">
                                                                    <input type="time" class="form-control form-control-sm" id="recieve_time" name="recieve_time" value="{{$mm}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-2 text-end">รับจากบริษัท</div>
                                                            <div class="col-md-4">
                                                                <select name="vendor_id" id="vendor_id"  class="custom-select custom-select-sm" style="width: 100%">
                                                                        <option value="">--เลือก--</option>
                                                                        @foreach ($air_supplies as $item_sup)
                                                                            <option value="{{$item_sup->air_supplies_id}}">{{$item_sup->supplies_name}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 text-end">รับเข้าคลัง</div>
                                                            <div class="col-md-4">
                                                                <select name="stock_list_id" id="stock_list_id"  class="custom-select custom-select-sm" style="width: 100%">
                                                                    <option value="">--เลือก--</option>
                                                                    @foreach ($wh_stock_list as $item_st)
                                                                        <option value="{{$item_st->stock_list_id}}">{{$item_st->stock_list_name}}</option>
                                                                    @endforeach
                                                            </select>
                                                            </div>
                                                        </div>                                
                                                        <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">
                                                       
                                                        </div> 
                                                    </p> --}}
                                                </div>
                                                <div class="tab-pane" id="trimart" role="tabpanel">
                                                    <p class="mb-0">
                                                        
                                                    </p>
                                                </div>
                                            
                                            </div> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>   
                </div>
            </div>
        </div> 
       
                <div class="row">
                    <div class="col-md-12">     
                        <div class="card card_prs_4">
        
                            <div class="card-body">
                                
                                <div class="row"> 
                                    <div class="col-xl-12">
                                        <table id="example" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">  
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">   --}}
                                            
                                            <thead> 
                                                <tr>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;">ลำดับ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="5%">สถานะ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="5%">ปีงบประมาณ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="8%">เลขที่บิล</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="10%">วันที่รับเข้าคลัง</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="7%">เวลา</th>
                                                    <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 13px;">คลังหลัก</th> 
                                                    <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 13px;">รับเข้าคลัง</th> 
                                                    <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 13px;" width="10%">ยอดรวม</th> 
                                                    <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 13px;" width="10%">ผู้ร้องขอ</th>  
                                                    <th class="text-center" width="5%">จัดการ</th> 
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($wh_request as $item)
                                                <?php $i++ ?>
                                                <tr >
                                                    <td class="text-center" width="5%">{{$i}}</td>
                                                    <td class="text-center" width="5%">
                                                        @if ($item->active == 'REQUEST')
                                                            <span class="bg-warning badge" style="font-size:12px">เปิดบิล</span> 
                                                        @elseif ($item->active == 'APPREQUEST')
                                                            <span class="bg-info badge" style="font-size:12px">รายการครบ</span> 
                                                        @elseif ($item->active == 'APPROVE')
                                                            <span class="bg-success badge" style="font-size:12px">เห็นชอบ</span> 
                                                        @elseif ($item->active == 'ALLOCATE')
                                                            <span class="bg-secondary badge" style="font-size:12px">กำลังดำเนิน</span> 
                                                        @elseif ($item->active == 'CONFIRM')
                                                            <span class="bg-success badge" style="font-size:12px">จ่ายพัสดุเรียบร้อย</span> 
                                                        @else
                                                            <span class="bg-primary badge" style="font-size:12px">รับเข้าคลัง</span> 
                                                        @endif                                                        
                                                    </td>
                                                    <td class="text-center" width="5%">{{$item->year}}</td>
                                                    <td class="text-center" width="8%">{{$item->request_no}}</td>
                                                    <td class="text-center" width="10%">{{$item->request_date}}</td>
                                                    <td class="text-center" width="7%">{{$item->request_time}}</td>                                                    
                                                                                                        
                                                    <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->stock_list_name}}</td>
                                                    <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->DEPARTMENT_SUB_SUB_NAME}}</td>  
                                                    
                                                    <td class="text-end" style="color:rgb(4, 115, 180)" width="10%">{{number_format($item->total_price, 2)}}</td>   
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->ptname}}</td> 
                                                    <td class="text-center" width="5%">                                                       
                                                     
                                                            {{-- <a href="{{url('wh_request_edit/'.$item->wh_request_id)}}">
                                                                <i class="fa-solid fa-file-pen" style="color: #f76e13;font-size:20px"></i>
                                                            </a> --}}
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditRequest{{$item->wh_request_id}}">
                                                                <i class="fa-solid fa-file-pen" style="color: #f76e13;font-size:20px"></i>
                                                            </a>
                                                            {{-- <a href="javascript:void(0);" class="ladda-button me-2 btn-pill btn btn-sm btn-primary input_new mb-3" data-bs-toggle="modal" data-bs-target="#Request">
                                                                <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> เปิดบิล  
                                                            </a> --}}
                                                            <a href="{{url('wh_request_addsub/'.$item->wh_request_id)}}" target="_blank">
                                                                <i class="fa-solid fa-cart-plus" style="color: #068fb9;font-size:20px"></i>
                                                            </a>                                                           
                                                       
                                                       
                                                    </td>                                                    
                                                </tr>

                                                 <!--  Modal content EditRequest -->
                                                    <div class="modal fade" id="EditRequest{{$item->wh_request_id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:rgb(236, 105, 18)">แก้ไขใบเบิก </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3 text-end">เลขที่บิล</div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group text-center">
                                                                                <input type="text" class="form-control form-control-sm" id="edit_request_no" name="edit_request_no" value="{{$item->request_no}}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-3 text-end">วันที่เบิกพัสดุ</div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group text-center"> 
                                                                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                                                    <input type="text" class="form-control form-control-sm cardacc" name="startdate" id="edit_datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                                                        data-date-language="th-th" value="{{$item->request_date}}" required/>
                                                                                        
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group text-center">
                                                                                <input type="time" class="form-control form-control-sm" id="edit_request_time" name="edit_request_time" value="{{$item->request_time}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-3 text-end">คลังที่ต้องการเบิก</div>
                                                                        <div class="col-md-8">
                                                                            <select name="editstock_list_id" id="editstock_list_id"  class="form-control form-control-sm" style="width: 100%">
                                                                                    <option value="">--เลือก--</option>
                                                                                    @foreach ($wh_stock_list as $item_sup)
                                                                                    @if ($item->stock_list_id == $item_sup->stock_list_id)
                                                                                        <option value="{{$item_sup->stock_list_id}}" selected>{{$item_sup->stock_list_name}}</option>
                                                                                    @else
                                                                                        <option value="{{$item_sup->stock_list_id}}">{{$item_sup->stock_list_name}}</option>
                                                                                    @endif
                                                                                       
                                                                                    @endforeach
                                                                            </select>
                                                                        </div> 
                                                                    </div>

                                                                    <input type="hidden" id="edit_bg_yearnow" name="edit_bg_yearnow" value="{{$item->year}}">
                                                                    <input type="hidden" id="edit_wh_request_id" name="edit_wh_request_id" value="{{$item->wh_request_id}}">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="col-md-12 text-center">
                                                                        <div class="form-group">
                                                                            <button type="button" id="UpdateRequest" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
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
                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:rgb(236, 105, 18)">เบิกพัสดุ </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 text-end">เลขที่บิล</div>
                            <div class="col-md-8">
                                <div class="form-group text-center">
                                    <input type="text" class="form-control form-control-sm" id="request_no" name="request_no" value="{{$ref_request_number}}" readonly>
                                </div>
                            </div>
                            {{-- <div class="col-md-2 text-end">วันที่รับเข้าคลัง</div>
                            <div class="col-md-2">
                                <div class="form-group text-center"> 
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                        <input type="text" class="form-control form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}" required/>
                                             
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group text-center">
                                    <input type="time" class="form-control form-control-sm" id="request_time" name="request_time" value="{{$mm}}">
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 text-end">วันที่เบิกพัสดุ</div>
                            <div class="col-md-6">
                                <div class="form-group text-center"> 
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                        <input type="text" class="form-control form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}" required/>
                                             
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group text-center">
                                    <input type="time" class="form-control form-control-sm" id="request_time" name="request_time" value="{{$mm}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 text-end">คลังที่ต้องการเบิก</div>
                            <div class="col-md-8">
                                <select name="stock_list_id" id="stock_list_id"  class="custom-select custom-select-sm" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($wh_stock_list as $item_sup)
                                            <option value="{{$item_sup->stock_list_id}}">{{$item_sup->stock_list_name}}</option>
                                        @endforeach
                                </select>
                            </div> 
                        </div>

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


 
 
@endsection
@section('footer')
 
    <script>
         $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#edit_datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            // $('select').select2();            
            
            $('#stock_list_id').select2({
                    dropdownParent: $('#Request')
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
                var request_no    = $('#request_no').val(); 
                var request_date  = $('#datepicker').val(); 
                var request_time  = $('#request_time').val();  
                var stock_list_id = $('#stock_list_id').val(); 
                var bg_yearnow    = $('#bg_yearnow').val();  

                Swal.fire({ position: "top-end",
                        title: 'ต้องการเพิ่มบิลใช่ไหม ?',
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
                                    url: "{{ route('wh.wh_request_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {request_no,request_date,request_time,stock_list_id,bg_yearnow},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'เพิ่มข้อมูลสำเร็จ',
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
                var request_date  = $('#edit_datepicker').val(); 
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
         
    </script>
  

@endsection
