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
        {{-- <div class="container">  --}}
    
            <div class="row mt-5"> 
                <div class="col-md-8"> 
                    <h5 style="color:rgb(236, 105, 18)">ตัดจ่ายรายการพัสดุ || เลขที่บิล {{ $data_edit->pay_no }} </h5> 
                </div>
                <div class="col"></div>   
                <div class="col-md-3 text-end">
                    {{-- <a href="{{url('wh_recieve_add')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" target="_blank">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> 
                        ตรวจรับ
                    </a>  --}}
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                       บันทึก
                   </button>
                   <a href="{{url('wh_sub_main_pay')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                </div>
            </div> 

           
        
        <form action="{{ route('wh.wh_sub_main_paysub_save') }}" method="POST">
            @csrf
            <div class="row mt-3">
                <div class="col-md-12">                
                    <div class="card card_prs_4">   
                        <div class="card-body"> 
                             
                            <div class="row mt-2">
                                <div class="col-md-1 text-end">รายการ</div>
                                <div class="col-md-8">
                                    <select name="wh_stock_dep_sub_id" id="wh_stock_dep_sub_id"  class="custom-select custom-select-sm" style="width: 100%">
                                            <option value="">--เลือก--</option>
                                            @foreach ($wh_product as $item_sup) 
                                                <?php 
                                                    $count_proid = DB::select('SELECT COUNT(pro_id) Cpro_id FROM wh_pay_sub WHERE pro_id = "'.$item_sup->pro_id.'" AND lot_no = "'.$item_sup->lot_no.'"');
                                                    foreach ($count_proid as $key => $value) {
                                                        $countproid   =  $value->Cpro_id;
                                                    }
                                                    $count_ = DB::select('SELECT COUNT(pro_id) Cpro_id FROM wh_pay_sub WHERE pro_id = "'.$item_sup->pro_id.'" AND wh_pay_id = "'.$wh_pay_id.'" AND lot_no = "'.$item_sup->lot_no.'"');
                                                    foreach ($count_ as $key => $value_c) {
                                                        $count_check   =  $value_c->Cpro_id;
                                                    }
                                                ?>
                                                @if ($count_check < 1 || $countproid == '')  
                                                <option value="{{$item_sup->wh_stock_dep_sub_id}}">{{$item_sup->pro_code}} || {{$item_sup->pro_name}} || {{$item_sup->wh_unit_name}} || LOT {{$item_sup->lot_no}} || => จำนวนคลังคงเหลือ {{$item_sup->qty_reppay-$countproid}}</option>
                                               @else                                                    
                                                @endif 
                                            @endforeach
                                    </select>
                                </div> 
                                <div class="col-md-1 text-start">
                                    <input type="text" class="form-control form-control-sm" id="qty" name="qty" placeholder="จำนวน">
                                </div>
                              
                                <div class="col-md-2 text-start">
                                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                                          <i class="fa-regular fa-square-plus text-white me-2 ms-2"></i>
                                   </button>
                                   <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4 Destroystamp" data-url="{{url('wh_request_destroy')}}">
                                        <i class="fa-solid fa-trash-can text-white ms-2"></i> 
                                    </button>
                                </div>
                            </div> 

                            <input type="hidden" id="wh_pay_id" name="wh_pay_id" value="{{$wh_pay_id}}"> 
                            {{-- <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}">  --}}
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                            {{-- <input type="hidden" id="supsup_id" name="supsup_id" value="{{$supsup_id}}">   --}}
                            
                    </form>
                    <hr>
                            <div class="row mt-3">
                                <div class="col-md-12">   
                                    <div class="row"> 
                                        <div class="col-xl-12">
                                           
                                                <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                                <thead> 
                                                    <tr>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th> 
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th> 
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>  
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th> 
                                                        <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">lot_no</th> 
                                                        <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">ตัดจ่าย(จำนวน)</th>  
                                                        <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox" name="stamp" id="stamp"> </th> 
                                                    </tr> 
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                    @foreach ($wh_pay_sub as $item)
                                                    <?php $i++ ?>
                                                    <tr id="tr_{{$item->wh_pay_sub_id}}">
                                                        <td class="text-center" width="5%">{{$i}}</td>   
                                                        <td class="text-start" style="color:rgb(3, 93, 145)" width="3%">{{$item->wh_pay_sub_id}}</td>  
                                                        <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_code}} {{$item->pro_name}}</td>                                                     
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->unit_name}}</td> 
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="13%">{{$item->lot_no}}</td>  
                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->qty}}</td> 
                                                              
                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox sub_chk" data-id="{{$item->wh_pay_sub_id}}"> </td>                                                         
                                                    </tr>
                                                    <?php
                                                            $total1 = $total1 + $item->qty;
                                                            // $total2 = $total2 + $item->one_price;
                                                            // $total3 = $total3 + $item->total_price; 
                                                    ?>
                                                        
                                                    @endforeach                                                
                                                </tbody>
                                                <tr style="font-size:20px">
                                                    <td colspan="5" class="text-end" style="background-color: #fca1a1"></td>
                                                    <td class="text-center" style="background-color: #ffffff"><label for="" style="color: #0c4da1">{{ $total1 }}</label></td>  
                                                    <td class="text-end" style="background-color: #fca1a1"></td>
                                                </tr> 
                                                
                                            </table>
    
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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            }); 
            $("#spinner-div").hide(); //Request is complete so hide spinner
            
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
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 

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
                                                    Swal.fire({ position: "top-end",
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
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
                // var supsup_id     = $('#supsup_id').val(); 
                // var stock_list_id    = $('#stock_list_id').val(); 
                // var data_year        = $('#data_year').val();  
                var wh_pay_id    = $('#wh_pay_id').val();  

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
                                    url: "{{ route('wh.wh_sub_main_paysub_update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {wh_pay_id},
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
                                                    window.location="{{url('wh_sub_main_pay')}}"; 
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

            $('#Tabledit').Tabledit({
                url:'{{route("wh.wh_sub_main_payedittable")}}',
                
                dataType:"json", 
                removeButton: false,
                columns:{
                    identifier:[1,'wh_pay_sub_id'], 
                    editable: [ [5, 'qty']]
                }, 
                deleteButton: false,
                saveButton: true,
                autoFocus: false,
                buttons: {
                    edit: {
                        class:'btn btn-sm btn-default', 
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
  
        });
    </script>
  

@endsection
