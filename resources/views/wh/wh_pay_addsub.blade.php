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
                <div class="col-md-8"> 
                    <h5 style="color:rgb(236, 105, 18)">รายการพัสดุที่ขอเบิก => เลขที่บิล {{ $data_edit->request_no }} || เบิกจากคลัง {{ $stock_name }} => เข้าคลัง {{ $supsup_name }}</h5> 
                </div>
                <div class="col"></div>   
                <div class="col-md-2 text-end">
                    {{-- <a href="{{url('wh_recieve_add')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" target="_blank">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> 
                        ตรวจรับ
                    </a>  --}}
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                       บันทึก
                   </button>
                   <a href="{{url('wh_pay')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                </div>
            </div> 

         
            <div class="row mt-3">
                <div class="col-md-12">                
                    <div class="card card_audit_4c">   
                        <div class="card-body"> 
                              
                            <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}"> 
                            <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}"> 
                            <input type="hidden" id="supsup_id" name="supsup_id" value="{{$supsup_id}}"> 
                            <input type="hidden" id="request_date" name="request_date" value="{{$request_date}}"> 
                            <input type="hidden" id="request_time" name="request_time" value="{{$request_time}}"> 
                            <input type="hidden" id="request_no" name="request_no" value="{{$request_no}}"> 
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}"> 
                            
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
                                                            <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">Stock</th> 
                                                            <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">จำนวนที่ขอเบิก</th> 
                                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="10%">จำนวนที่จ่าย</th> 
                                                            {{-- <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th>  --}}
                                                        </tr> 
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                        @foreach ($wh_request_sub as $item)
                                                        <?php $i++ ?>
                                                        <tr id="tr_{{$item->wh_request_sub_id}}">
                                                            <td class="text-center" width="5%">{{$i}}</td>   
                                                            <td class="text-start" style="color:rgb(3, 93, 145)" width="3%">{{$item->wh_request_sub_id}}</td>  
                                                            <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_code}} {{$item->pro_name}}</td>                                                     
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->unit_name}}</td> 
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{($item->stock_rep-$item->stock_pay)}}</td>  
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->qty}}</td>  
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->qty_pay}}</td>   
                                                            {{-- <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->wh_request_sub_id}}"> </td>                                                                                                               --}}
                                                        </tr>
                                                        <?php
                                                                $total1 = $total1 + $item->qty;
                                                                $total2 = $total2 + $item->qty_pay; 
                                                                $total3 = $total3 + $item->stock_rep-$item->stock_pay; 
                                                        ?>
                                                            
                                                        @endforeach                                                
                                                    </tbody>
                                                    <tr style="font-size:20px">
                                                        <td colspan="4" class="text-end" style="background-color: #fad4db"></td>
                                                        <td class="text-center" style="background-color: #ffffff"><label for="" style="color: #0c4da1">{{ $total3 }}</label></td> 
                                                        <td class="text-center" style="background-color: #ffffff" ><label for="" style="color: #0c4da1">{{ $total1 }}</label></td>
                                                        <td class="text-center" style="background-color: #ffffff" ><label for="" style="color: #0c4da1">{{ $total2 }}</label></td> 
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
            
            // $('.Destroystamp').on('click', function(e) {
            //     // alert('oo');
            //     var allValls = [];
            //     // $(".sub_destroy:checked").each(function () {
            //     $(".sub_chk:checked").each(function () {
            //         allValls.push($(this).attr('data-id'));
            //     });
            //     if (allValls.length <= 0) {
            //         // alert("SSSS");
            //         Swal.fire({ position: "top-end",
            //             title: 'คุณยังไม่ได้เลือกรายการ ?',
            //             text: "กรุณาเลือกรายการก่อน",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33', 
            //             }).then((result) => {
                        
            //             })
            //     } else {
            //         Swal.fire({ position: "top-end",
            //             title: 'Are you Want Delete sure?',
            //             text: "คุณต้องการลบรายการนี้ใช่ไหม!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, Delete it.!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     var check = true;
            //                     if (check == true) {
            //                         var join_selected_values = allValls.join(",");
            //                         // alert(join_selected_values);
            //                         $("#overlay").fadeIn(300);　
            //                         $("#spinner").show(); //Load button clicked show spinner 

            //                         $.ajax({
            //                             url:$(this).data('url'),
            //                             type: 'POST',
            //                             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //                             data: 'ids='+join_selected_values,
            //                             success:function(data){ 
            //                                     if (data.status == 200) {
            //                                         // $(".sub_destroy:checked").each(function () {
            //                                         $(".sub_chk:checked").each(function () {
            //                                             $(this).parents("tr").remove();
            //                                         });
            //                                         Swal.fire({ position: "top-end",
            //                                             title: 'ลบข้อมูลสำเร็จ',
            //                                             text: "You Delete data success",
            //                                             icon: 'success',
            //                                             showCancelButton: false,
            //                                             confirmButtonColor: '#06D177',
            //                                             confirmButtonText: 'เรียบร้อย'
            //                                         }).then((result) => {
            //                                             if (result
            //                                                 .isConfirmed) {
            //                                                 console.log(
            //                                                     data);
            //                                                 window.location.reload();
            //                                                 $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                             }
            //                                         })
            //                                     } else {
                                                    
            //                                     }
                                                 
            //                             }
            //                         });
            //                         $.each(allValls,function (index,value) {
            //                             $('table tr').filter("[data-row-id='"+value+"']").remove();
            //                         });
            //                     }
            //                 }
            //             }) 
            //         // var check = confirm("Are you want ?");  
            //     }
            // });

       
            $('#UpdateData').click(function() {
                var request_date     = $('#request_date').val(); 
                var request_time     = $('#request_time').val(); 
                var request_no       = $('#request_no').val(); 
                var supsup_id        = $('#supsup_id').val(); 
                var stock_list_id    = $('#stock_list_id').val(); 
                var data_year        = $('#data_year').val();  
                var wh_request_id    = $('#wh_request_id').val();  

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
                                    url: "{{ route('wh.wh_pay_addsub_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_request_id,stock_list_id,supsup_id,request_no,request_date,request_time},
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
                                                    window.location="{{url('wh_pay')}}"; 
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
                url:'{{route("wh.wh_pay_edittable")}}',
                
                dataType:"json", 
                removeButton: false,
                columns:{
                    identifier:[1,'wh_request_sub_id'], 
                    editable: [[6,'qty_pay']]
                }, 
                deleteButton: false,
                saveButton: false,
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
                    Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            title: "Stock ไม่เพียงพอ",
                            showConfirmButton: false,
                            timer: 3000
                            });
                            window.location.reload(); 
                   } 
                }

            });
  
        });
    </script>
  

@endsection
