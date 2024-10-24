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
        {{-- <div class="container">  --}}
    
            <div class="row"> 
                <div class="col-md-7"> 
                    <h5 style="color:rgb(236, 105, 18)">เพิ่มรายการพัสดุ || เลขที่บิล {{ $data_edit->recieve_no }} || บริษัท {{ $supplies_name }} || เลขประจำตัวผู้เสียภาษี {{ $supplies_tax }}</h5> 
                </div>
                <div class="col"></div>   
                <div class="col-md-4 text-end">
                
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="บันทึกรายการทั้งหมดเข้าคลัง">
                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                       บันทึก
                   </button>
                   <a href="{{url('wh_recieve')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                   <button type="button" style="background-color: #0a4ba0" class="ladda-button me-2 btn-pill btn btn-sm input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="คู่มือการใช้งาน">
                        <i class="fa-regular fa-file-video text-white me-2 ms-2"></i> 
                </button>
                </div>
            </div> 
            {{-- <div class="row">
                <div class="col-md-1 text-end">รายการวัสดุ</div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" id="scannerInput" name="scannerInput" placeholder="SCAN BARCODE" style="background-color: #d8f9fc" autofocus> 
                </div>
                <div class="col-md-1 text-end" id="data_code"></div>
            </div> --}}
        {{-- <form action="{{ route('wh.wh_recieve_addsub_save') }}" method="POST" id="addpost"> --}}
        {{-- <form action="{{ route('wh.wh_recieve_addsub_save') }}" method="POST"> --}}
            {{-- @csrf --}}
            <div class="row mt-2">
                <div class="col-md-12">                
                    <div class="card card_audit_4c">   
                        <div class="card-body">                              
                            <div class="row mt-2">
                                <div class="col-md-1 text-end">รายการวัสดุ</div>
                                <div class="col-md-4">
                                    <select name="pro_id" id="pro_id"  class="custom-select custom-select-sm show_pro" style="width: 100%"> 
                                        <option value="">--เลือก--</option>                                          
                                            @foreach ($wh_product as $item_sup) 
                                         
                                                <?php 
                                                    $count_proid = DB::select('SELECT COUNT(pro_id) Cpro_id FROM wh_recieve_sub WHERE pro_id = "'.$item_sup->pro_id.'" AND wh_recieve_id = "'.$data_edit->wh_recieve_id.'"');
                                                    foreach ($count_proid as $key => $value) {
                                                        $countproid   =  $value->Cpro_id;
                                                    }
                                                ?>
                                                @if ($countproid > 0)  
                                                @else
                                                    <option value="{{$item_sup->pro_id}}">{{$item_sup->pro_code}} || {{$item_sup->pro_name}} || {{$item_sup->wh_unit_pack_qty}} / {{$item_sup->unit_name}} || {{$item_sup->wh_type_name}}</option>
                                                @endif 
                                            @endforeach
                                    </select>
                                </div> 
                                <div class="col-md-1 text-start">
                                    <input type="text" class="form-control-sm input_border" id="qty" name="qty" placeholder="จำนวน" style="width: 100%">
                                </div>
                                <div class="col-md-2 text-start">
                                    <input type="text" class="form-control-sm input_border" id="one_price" name="one_price" placeholder="ราคา" style="width: 100%">
                                </div>
                                <div class="col-md-1 text-end">LOT</div>
                                <div class="col-md-2 text-start">
                                    <input type="text" class="form-control-sm input_border" id="lot_no" name="lot_no" placeholder="LOT" style="width: 100%">
                                    {{-- <input type="text" class="form-control-sm input_border" id="lot_no" name="lot_no" placeholder="LOT" value="{{$lot_no}}" style="width: 100%"> --}}
                                </div>   
                                <div class="col-md-1 text-start">
                                    {{-- <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                        <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                                    </button> --}}
                                    <button type="button" id="Addproduct" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                          <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                                   </button>
                                   <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new Destroystamp" data-url="{{url('wh_recieve_destroy')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="ลบรายการที่เลือก">
                                        <i class="fa-solid fa-trash-can text-white ms-2"></i> 
                                    </button>
                                </div> 
                            </div> 
                            <input type="hidden" id="wh_recieve_id" name="wh_recieve_id" value="{{$wh_recieve_id}}"> 
                            <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}"> 
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">                            
                    
                        {{-- </form> --}}
                        <hr>
                        <div class="row">
                            <div class="col-md-1 text-end">รายการวัสดุ</div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" id="PROS_NAME" name="PROS_NAME" placeholder="ถ้าไม่มีชื่อรายการวัสดุเพิ่มที่นี่" style="background-color: #d8f9fc"> 
                            </div>
                            <div class="col-md-1 text-end">หน่วยนับ</div>
                            <div class="col-md-1">
                                <select name="wh_unit_id" id="wh_unit_id"  class="custom-select custom-select-sm show_unit" style="width: 100%">
                                    @foreach ($wh_unit as $uni)
                                        <option value="{{ $uni->wh_unit_id }}">{{ $uni->wh_unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="text" class="form-control form-control-sm" id="UNIT_NAME" name="UNIT_NAME" placeholder="ถ้าไม่มีหน่วยนับ" style="background-color: #d8f9fc"> 
                            </div>
                            <div class="col-md-1 text-start">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-info input_new" onclick="addwh_unit();" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มหน่วยนับ">
                                      <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                               </button> 
                            </div> 
                            <div class="col-md-1 text-end">ประเภท</div>
                            <div class="col-md-2">
                                <select name="pro_type" id="pro_type"  class="custom-select custom-select-sm" style="width: 100%">
                                    @foreach ($product_category as $type)
                                        <option value="{{ $type->wh_type_id }}">{{ $type->wh_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 text-start">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-info input_new" onclick="add_product();" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุ">
                                      <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                               </button> 
                            </div> 
                        </div> 
                    <hr>

                    <div class="row">
                        <div class="col-md-1 text-end">รายการวัสดุ</div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm" id="scannerInput" name="scannerInput" placeholder="SCAN BARCODE" style="background-color: #d8f9fc;width: 100%" autofocus> 
                        </div>
                        <div class="col-md-1 text-end" id="data_code"></div>
                        <div class="col"></div>
                        <div class="col-md-1 text-end mt-2">Total</div>
                        <div class="col-md-1">
                            {{-- <button type="button" class="ladda-button btn-pill btn btn-white card_audit_4c"> --}}
                                <input type="text" class="form-control form-control-sm text-end input_new" id="gettotal_show" name="gettotal_show" style="background-color: #cafdec;color:rgb(238, 15, 89);font-size:15px;width: 100%">
                                {{-- <div id="gettotal_show" style="color:rgb(238, 15, 89);font-size:19px"></div>  --}}
                                {{-- ราคา {{number_format($total_price, 2)}} <i class="fa-solid fa-baht-sign me-2 ms-2" style="color:rgb(238, 15, 89);font-size:19px"></i> --}}
                             {{-- </button> --}}
                        </div>
                    </div>

                            <div class="row mt-3">
                                <div class="col-md-12">   
                                    <div class="row"> 
                                        <div class="col-xl-12"> 

                                            {{-- <div style='overflow:scroll; height:500px;'>
                                                <div id="getdata_show"></div> 
                                            </div> --}}
                                            <div id="getdata_show"></div> 
                                             
                                            {{-- <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">                                               
                                                <thead> 
                                                    <tr>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th> 
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th> 
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>  
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th> 
                                                        <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">LOT</th> 
                                                        <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">จำนวน</th> 
                                                        <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="10%">ราคา</th> 
                                                        <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="10%">ราคารวม</th>                                                       
                                                        <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                                                    </tr> 
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                    @foreach ($wh_recieve_sub as $item)
                                                    <?php $i++ ?>
                                                    <tr id="tr_{{$item->wh_recieve_sub_id}}">
                                                        <td class="text-center" width="5%">{{$i}}</td>   
                                                        <td class="text-start" style="color:rgb(3, 93, 145)" width="3%">{{$item->wh_recieve_sub_id}}</td>  
                                                        <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_name}}</td>                                                     
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->unit_name}}</td> 
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->lot_no}}</td>  
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->qty}}</td>  
                                                        <td class="text-end" style="color:rgb(4, 115, 180)" width="10%">{{number_format($item->one_price, 2)}}</td>  
                                                        <td class="text-end" style="color:rgb(4, 115, 180)" width="10%">{{number_format($item->total_price, 2)}}</td>   
                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->wh_recieve_sub_id}}"> </td>                                                         
                                                    </tr>
                                                    <?php
                                                            $total1 = $total1 + $item->qty;
                                                            $total2 = $total2 + $item->one_price;
                                                            $total3 = $total3 + $item->total_price; 
                                                    ?>                                                        
                                                    @endforeach                                                
                                                </tbody>
                                                <tr style="font-size:20px">
                                                    <td colspan="5" class="text-end" style="background-color: #fca1a1"></td>
                                                    <td class="text-center" style="background-color: #ffffff"><label for="" style="color: #0c4da1">{{ number_format($total1, 2) }}</label></td> 
                                                    <td class="text-end" style="background-color: #ffffff" ><label for="" style="color: #0c4da1">{{ number_format($total2, 2) }}</label></td>
                                                    <td class="text-end" style="background-color: #ffffff"><label for="" style="color: #0c4da1">{{ number_format($total3, 2) }}</label> </td>  
                                                    <td class="text-end" style="background-color: #fca1a1"></td>
                                                </tr>                                                 
                                            </table> --}}
    
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>
            </div>
       

           
        {{-- </div> --}}

</div>


 
 
@endsection
@section('footer')
    <script>
        // $(document).ready(function() {
                // load_data_table();
                // function load_data_table() { 
                //         var wh_recieve_id = document.getElementById("wh_recieve_id").value; 
                //         // alert(wh_recieve_id);
                //         var _token=$('input[name="_token"]').val();
                //         $.ajax({
                //                 url:"{{route('wh.load_data_table')}}",
                //                 method:"GET",
                //                 data:{wh_recieve_id:wh_recieve_id,_token:_token},
                //                 success:function(result){
                //                     $('#getdata_show').html(result);
                //                     // $('#getdata_show').append(result);
                //                 }
                //         });                     
                // }         
        //  });
        //  setInterval(function(){
        //     // $('#getdata_show').load().fadeIn("slow");
        //     load_data_table();
        // }, 1000);
       
  
    </script>
    <script>
        var Linechart;
        function add_product() {
            var pros_name     = document.getElementById("PROS_NAME").value;
            var stock_list_id = document.getElementById("stock_list_id").value;
            var data_year     = document.getElementById("data_year").value; 
            var pro_type      = document.getElementById("pro_type").value; 
            var wh_unit_id       = document.getElementById("wh_unit_id").value; 
            var _token        = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('add_product')}}",
                    method: "GET",
                    data: {
                        pros_name: pros_name,stock_list_id:stock_list_id,data_year:data_year,pro_type:pro_type,wh_unit_id:wh_unit_id,
                        _token: _token
                    },
                    success: function (result) {
                        $('.show_pro').html(result);
                    }
                })
        }
        function addwh_unit() {
            var unitnew = document.getElementById("UNIT_NAME").value;
            // alert(unitnew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('addwh_unitt')}}",
                method: "GET",
                data: {
                    unitnew: unitnew,
                    _token: _token
                },
                success: function (result) {
                    $('.show_unit').html(result);
                }
            })
        }
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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            }); 
            $("#spinner-div").hide(); //Request is complete so hide spinner
           
            load_data_table();
            load_data_lot_no();
            load_data_sum();

            function load_data_table() { 
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value; 
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_table')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#getdata_show').html(result);
                                // $('#getdata_show').append(result);
                                // $('#qty')[0].reset();
                                // $('#one_price')[0].reset();
                                // $('#qty').val("");
                                // $('#one_price').val("");
                            }
                    });                     
            }   
            function load_data_lot_no() { 
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value; 
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_lot_no')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#lot_no').val(result.lot_no) 
                            }
                    });                     
            }   
            function load_data_sum() { 
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value; 
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_sum')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#gettotal_show').val(result.total) 
                            }
                    });                     
            }       
           
            $('#Addproduct').click(function() {
                var pro_id           = $('#pro_id').val(); 
                var qty              = $('#qty').val(); 
                var one_price        = $('#one_price').val(); 
                var lot_no           = $('#lot_no').val(); 
                var stock_list_id    = $('#stock_list_id').val(); 
                var wh_recieve_id    = $('#wh_recieve_id').val();  
                // var wh_recieve_id    = $('#wh_recieve_id').val(); 
                var data_year        = $('#data_year').val();  

                // Swal.fire({ position: "top-end",
                //     title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                //     text: "You Warn Save Data!",
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Yes, Save it!'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $("#overlay").fadeIn(300);　
                //             $("#spinner").show(); //Load button clicked show spinner                             
                        $.ajax({
                            url: "{{ route('wh.wh_recieve_addsub_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {pro_id,qty,one_price,lot_no,wh_recieve_id,stock_list_id,data_year},
                            success: function(data) {
                                load_data_table();
                                load_data_lot_no();
                                load_data_sum();
                                $('#qty').val("");
                                $('#one_price').val("");
                                $('#pro_id').val("");
                                if (data.status == 200) { 
                                    // load_data_table();
                                    // window.location.reload();
                                    // Swal.fire({ position: "top-end",
                                    //     title: 'บันทึกข้อมูลสำเร็จ',
                                    //     text: "You Save data success",
                                    //     icon: 'success',
                                    //     showCancelButton: false,
                                    //     confirmButtonColor: '#06D177',
                                    //     confirmButtonText: 'เรียบร้อย'
                                    // }).then((result) => {
                                    //     if (result
                                    //         .isConfirmed) {
                                    //         console.log(
                                    //             data);
                                    //         // window.location.reload();
                                    //         window.location="{{url('wh_recieve')}}"; 
                                    //         $('#spinner').hide();//Request is complete so hide spinner
                                    //             setTimeout(function(){
                                    //                 $("#overlay").fadeOut(300);
                                    //             },500);
                                    //     }
                                    // })
                                } else {
                                    
                                }
                            },
                        });
                            
                    // }
                // })
            });
           
            // $('#addpost').on('submit',function (event) {
            //     event.preventDefault(); 
            //     jQuery.ajax({
            //         url: "{{ route('wh.wh_recieve_addsub_save') }}",
            //         data:jQuery('#addpost').serialize(),
            //         type: "POST",
            //         success: function(data) {
            //             jQuery('#addpost')[0].reset(); 
            //             window.location.reload();
            //         }
            //     });   
            // })
            $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({ position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({ position: "top-end",
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการลบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    // $("#overlay").fadeIn(300);　
                                    // $("#spinner").show(); //Load button clicked show spinner 

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    load_data_table();
                                                    load_data_lot_no();
                                                    load_data_sum();
                                                    $('#qty').val("");
                                                    $('#one_price').val("");
                                                    $('#pro_id').val("");
                                                    // Swal.fire({ position: "top-end",
                                                    //     title: 'ลบข้อมูลสำเร็จ',
                                                    //     text: "You Delete data success",
                                                    //     icon: 'success',
                                                    //     showCancelButton: false,
                                                    //     confirmButtonColor: '#06D177',
                                                    //     confirmButtonText: 'เรียบร้อย'
                                                    // }).then((result) => {
                                                    //     if (result
                                                    //         .isConfirmed) {
                                                    //         console.log(
                                                    //             data);
                                                    //         window.location.reload();
                                                    //         $('#spinner').hide();//Request is complete so hide spinner
                                                    //     setTimeout(function(){
                                                    //         $("#overlay").fadeOut(300);
                                                    //     },500);
                                                    //     }
                                                    // })
                                                } else {
                                                    
                                                }
                                                 
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
                    // var check = confirm("Are you want ?");  
                }
            });

            $('#UpdateData').click(function() {
                // var recieve_no    = $('#recieve_no').val(); 
                // var recieve_date  = $('#datepicker').val(); 
                // var recieve_time  = $('#recieve_time').val(); 
                // var vendor_id     = $('#vendor_id').val(); 
                var stock_list_id    = $('#stock_list_id').val(); 
                var data_year        = $('#data_year').val();  
                var wh_recieve_id    = $('#wh_recieve_id').val();  

                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Save Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('wh.wh_recieve_updatestock') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_recieve_id,stock_list_id},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Save data success",
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
                                                    window.location="{{url('wh_recieve')}}"; 
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

            // $('#Tabledit').Tabledit({
            //     url:'{{route("wh.wh_recieve_edittable")}}',                
            //     dataType:"json", 
            //     removeButton: false,
            //     columns:{
            //         identifier:[1,'wh_recieve_sub_id'], 
            //         editable: [[4, 'lot_no'], [5, 'qty'], [6, 'one_price']]
            //     }, 
            //     deleteButton: false,
            //     saveButton: false,
            //     autoFocus: false,
            //     buttons: {
            //         edit: {
            //             class:'btn btn-sm btn-default', 
            //             html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
            //             action: 'Edit'
            //         }
            //     }, 
            //     onSuccess:function(data)
            //     {
            //        if (data.status == 200) {
            //             Swal.fire({
            //                 position: "top-end",
            //                 icon: "success",
            //                 title: "Your Edit Success",
            //                 showConfirmButton: false,
            //                 timer: 1500
            //                 });
            //                 window.location.reload();
            //        } else { 
            //        } 
            //     }

            // });
  
        });
    </script>
  

@endsection


{{-- // var keybuffer = [];
// function press(event) {
// if (event.which === 13) {
//     return send();
// }
// var number = event.which - 48;
// if (number < 0 || number > 9) {
//     return;
// }
// keybuffer.push(number);
// }
// $(document).on("keypress", press);
// function send() {
// socket.emit('scan', keybuffer.join(""));
// keybuffer.length = 0;
// }
// window.onload = function() {
//     var input = document.getElementById("scannerInput").focus();
// }
// $(document).scannerDetection({	   
//     //https://github.com/kabachello/jQuery-Scanner-Detection     
//     timeBeforeScanTest: 200, // wait for the next character for upto 200ms
//     avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
//     preventDefault: true,        
//     endChar: [13],
//         onComplete: function(barcode, qty){
//     validScan = true;           
    
//         $('#scannerInput').val (barcode);
    
//     } // main callback function	,
//     ,
//     onError: function(string, qty) {        
//         // $('#userInput').val ($('#userInput').val()  + string);    
//     } 
// });

// on_scanner() // init function
// function on_scanner() {
//     let is_event = false; // for check just one event declaration
//     let input = document.getElementById("scanner");
//     input.addEventListener("focus", function () {
//         if (!is_event) {
//             is_event = true;
//             input.addEventListener("keypress", function (e) {
//                 setTimeout(function () {
//                     if (e.keyCode == 13) {
//                         scanner(input.value); // use value as you need
//                         input.select();
//                     }
//                 }, 500)
//             })
//         }
//     });
//     document.addEventListener("keypress", function (e) {
//         if (e.target.tagName !== "INPUT") {
//             input.focus();
//         }
//     });
// }
// function scanner(value) {
//     if (value == '') return;
//     console.log(value)
// }
// let barcodeInput = "";
// let reading = false;
// document.addEventListener('keypress', e => {
// //usually scanners throw an 'Enter' key at the end of read
// if (e.keyCode === 13) {
//         if(barcodeInput.length > 10) {
//             console.log(barcodeInput);
//             /// code ready to use                
//             barcodeInput = "";
//         }
//     } else {
//         barcodeInput += e.key; //while this is not an 'enter' it stores the every key            
//     }
//     //run a timeout of 200ms at the first read and clear everything
//     if(!reading) {
//         reading = true;
//         setTimeout(() => {
//             barcodeInput = "";
//             reading = false;
//         }, 200);  //200 works fine for me but you can adjust it
//     }
// });
// $(selector).scannerDetection({    
//     //https://github.com/kabachello/jQuery-Scanner-Detection  
//     ignoreIfFocusOn: 'input',      
//     timeBeforeScanTest: 200, // wait for the next character for upto 200ms
//     avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
//     preventDefault: true,            
//     endChar: [13],
//     onComplete: function(barcode, qty){
//     validScan = true;                        
//         $('#scannerInput').val (barcode);    
//     } 
//     ,
//     onError: function(string, qty) {
//     res = string.split("-");
//     var inward_id = res[0];
//     var per_id = res[2];
// timeBeforeScanTest: 200, // wait for the next character for upto 200ms
// avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
// preventDefault: true,
// endChar: [13],
//     onComplete: function(barcode, qty){
//     validScan = true;        
//     $('#barcodeInput').val (barcode);  
//     alert(barcode);          
// } // main callback function ,
// ,
// onError: function(string, qty) {
// $('#userInput').val ($('#userInput').val()  + string);            
// }
// }); --}}