@extends('layouts.wh')
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
        use App\Http\Controllers\WhController;
        use App\Models\Products_request_sub;
        $ref_nonumber = WhController::ref_nonumber();
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
        <div class="container"> 
    
           
        
            <div class="row mt-3">
                <div class="col-md-12">                
                    <div class="card card_audit_4c">   
                        <div class="card-header">
                            <div class="row"> 
                                <div class="col-md-6"> 
                                    <h4 class="text-start" style="color:rgb(8, 138, 120);">สร้างใบตรวจรับ </h4>
                                </div>
                                <div class="col"></div>   
                                <div class="col-md-4 text-end">
                                     
                                    <button type="button" id="SaveData" class="ladda-button me-2 btn-pill btn btn-sm btn-success buttom_border" >
                                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                                       บันทึก
                                   </button>
                                   <a href="{{url('wh_recieve')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger buttom_border"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                                </div>
                            </div> 
                        </div> 
                        <div class="card-body" style="height:500px;"> 
                            <div class="row mt-3 mb-3">
                                <div class="col-md-2 text-end">เลขที่บิล</div>
                                <div class="col-md-2">
                                    <div class="form-group text-start">
                                        <input type="text" class="form-control-sm input_new" id="recieve_no" name="recieve_no" value="{{$ref_nonumber}}" style="width: 100%" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group text-start">
                                        <input type="text" class="form-control-sm input_new" id="recieve_po_sup" name="recieve_po_sup" style="width: 100%" placeholder="เลขที่บิลบริษัท">
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">วันที่รับเข้าคลัง</div>
                                <div class="col-md-2">
                                    <div class="form-group text-center">  
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            <input type="text" class="form-control-sm d12font input_new" name="datepicker" id="datepicker" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $date_now }}"/> 
                                        </div> 
    
                                    </div>
                                </div>
                                {{-- <div class="col-md-1 text-end">เวลา</div> --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="time" class="form-control-sm input_new" id="recieve_time" name="recieve_time" value="{{$mm}}" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 text-end">รับจากบริษัท</div>
                                <div class="col-md-4">
                                    <select name="vendor_id" id="vendor_id"  class="form-control-sm show_supplies input_new" style="width: 100%;border: #f80d6f">
                                            <option value="">--เลือก--</option>
                                            @foreach ($air_supplies as $item_sup)
                                                <option value="{{$item_sup->air_supplies_id}}">{{$item_sup->supplies_name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 text-end">รับเข้าคลัง</div>
                                <div class="col-md-4">
                                    <select name="stock_list_id" id="insertstock_list_id"  class="form-control-sm input_new"  style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($wh_stock_list as $item_st)
                                            <option value="{{$item_st->stock_list_id}}">{{$item_st->stock_list_name}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
    
                            <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">

                            <hr class="mt-4 mb-4" style="color: #f80d6f;font-size:17px">

                            <div class="row">
                                <div class="col-md-2 text-end">ชื่อตัวแทนจำหน่าย</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="supplies_name" name="supplies_name" style="width: 100%">
                                    </div>
                                </div> 
                                <div class="col-md-2 text-end">เลขผู้เสียภาษี</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="supplies_tax" name="supplies_tax" style="width: 100%">
                                    </div>
                                </div> 
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 text-end">เบอร์โทร</div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <input type="text" class="form-control-sm d12font input_new" id="supplies_tel" name="supplies_tel" style="width: 100%">
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">แฟก</div>
                                <div class="col-md-4 text-start">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="fax" name="fax" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            
    
                            <div class="row mt-2">
                               
                                <div class="col-md-2 text-end">เลขที่บัญชี</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="account_no" name="account_no" style="width: 100%">
                                    </div>
                                </div> 
                                <div class="col-md-2 text-end">ธนาคาร</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="bank_name" name="bank_name" style="width: 100%">
                                    </div>
                                </div> 
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 text-end">ชื่อบัญชี</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="account_name" name="account_name" style="width: 100%">
                                    </div>
                                </div> 
                                <div class="col-md-2 text-end">สาขา</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm d12font input_new" id="bank_location" name="bank_location" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                 
                                <div class="col-md-2 text-end">ที่อยู่</div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <textarea class="form-control-sm d12font input_new" id="supplies_address" name="supplies_address" style="width: 100%" rows="5"></textarea> 
                                    </div>
                                </div> 
                            </div>
                            <div class="row mt-2 text-center">
                                <div class="col-md-12">
                                    <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-info input_new" onclick="addwh_supplies();" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มผู้แทนจำหน่าย">
                                        <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                                    </button>  
                                </div>
                            </div>
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
        function addwh_supplies() {
            var supplies_name = document.getElementById("supplies_name").value;
            var supplies_tax = document.getElementById("supplies_tax").value;
            var supplies_tel = document.getElementById("supplies_tel").value;
            var fax = document.getElementById("fax").value;
            var account_no = document.getElementById("account_no").value;
            var bank_name = document.getElementById("bank_name").value;
            var account_name = document.getElementById("account_name").value;
            var bank_location = document.getElementById("bank_location").value;
            var supplies_address = document.getElementById("supplies_address").value;
         
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('addwh_supplies')}}",
                method: "GET",
                data: {
                    supplies_name: supplies_name, supplies_tax: supplies_tax, supplies_tel: supplies_tel,
                    fax: fax, account_no: account_no, bank_name: bank_name,
                    account_name: account_name, bank_location: bank_location, supplies_address: supplies_address,
                    _token: _token
                },
                success: function (result) {
                    $('.show_supplies').html(result);
                }
            })
        }
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('select').select2();

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
            
            $('#SaveData').click(function() {
                var recieve_no    = $('#recieve_no').val(); 
                var recieve_date  = $('#datepicker').val(); 
                var recieve_time  = $('#recieve_time').val(); 
                var vendor_id     = $('#vendor_id').val(); 
                var stock_list_id = $('#insertstock_list_id').val(); 
                var bg_yearnow    = $('#bg_yearnow').val(); 
                var recieve_po_sup    = $('#recieve_po_sup').val(); 
                 

                Swal.fire({ position: "top-end",
                        title: 'ต้องการเพิ่มข้อมูลใช่ไหม ?',
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
                                    url: "{{ route('wh.wh_recieve_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {recieve_no,recieve_date,recieve_time,vendor_id,stock_list_id,bg_yearnow,recieve_po_sup},
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
                                                    // window.location.reload();
                                                    window.location = "{{url('wh_recieve')}}"; 
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
