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
        
       
        <div class="app-main__outer">
            <div class="app-main__inner">

                
                    <div class="row"> 
                      
                        <div class="col-md-10">
                            <h3 style="color:rgb(247, 103, 68)">ตัวแทนจำหน่าย</h3>
                            <p style="font-size: 15px">รายละเอียดข้อมูลตัวแทนจำหน่ายทั้งหมด</p>
                        </div> 
                                             
                        <div class="col-md-2 text-start">  
                            <a href="javascript:void(0);" class="ladda-button btn-pill btn btn-sm btn-primary card_audit_4c" data-bs-toggle="modal" data-bs-target="#Request">
                                {{-- <i class="fa-solid fa-address-book text-white me-2 ms-2"></i>  --}}
                                <img src="{{ asset('images/HumanResources.png') }}" class="ms-2 me-2" height="23px" width="23px">
                                เพิ่มตัวแทนจำหน่าย  
                            </a>   
                        </div>     
                    </div>              
                         
                <div class="row">  
                                   
                        <div class="col-xl-12">
                            <div class="card card_audit_4c" style="background-color: rgb(248, 241, 237)">   
                                <div class="table-responsive p-3">                                
                                    <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th> 
                                                <th class="text-center" style="background-color: rgb(219, 247, 232)">ชื่อตัวแทนจำหน่าย</th> 
                                                <th class="text-center" style="background-color: rgb(192, 220, 252)">เบอร์โทร</th> 
                                                <th class="text-center" style="background-color: rgb(192, 220, 252)">FAX</th>  
                                                <th class="text-center" style="background-color: rgb(252, 204, 185)">เลขผู้เสียภาษี</th> 
                                                <th class="text-center" style="background-color: rgb(252, 204, 185)">ที่อยู่</th>  
                                                <th class="text-center" style="background-color: rgb(252, 144, 185)">เลขที่บัญชี</th> 
                                                <th class="text-center" style="background-color: rgb(252, 144, 185)">ชื่อบัญชี</th> 
                                                <th class="text-center" style="background-color: rgb(252, 144, 185)">ธนาคาร</th>  
                                                <th class="text-center" style="background-color: rgb(252, 144, 185)">สาขา</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                            ?>
                                            @foreach ($air_supplies as $item)
                                                <?php $number++; ?>                                        
                                                    <tr style="font-size: 13px;">
                                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                        <td class="text-start" style="font-size: 13px;color:#022f57">{{$item->supplies_name}}</td>    
                                                        <td class="text-start" style="color:rgb(29, 102, 185)" width="10%"> {{ $item->supplies_tel}}</td>     
                                                        <td class="text-start" style="color:rgb(29, 102, 185)" width="8%"> {{ $item->fax}}</td> 
                                                        <td class="text-start" style="color:rgb(241, 83, 21)" width="8%"> {{ $item->supplies_tax}}</td>     
                                                        <td class="text-start" style="color:rgb(241, 83, 21)" width="10%"> {{ $item->supplies_address}}</td> 
                                                        <td class="text-start" style="color:rgb(202, 9, 83)" width="10%">{{ $item->account_no}}</td>     
                                                        <td class="text-start" style="color:rgb(202, 9, 83)" width="10%"> {{ $item->account_name}}</td>
                                                        <td class="text-start" style="color:rgb(202, 9, 83)" width="10%"> {{ $item->bank_name}}</td>                                      
                                                        <td class="text-start" style="color:rgb(202, 9, 83)" width="10%"> {{ $item->bank_location}}</td>
                                                    </tr>                                                
                                            @endforeach
        
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                                       
                </div>

                 <!--  Modal content forRecieve -->
        <div class="modal fade" id="Request" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-center" style="color:rgb(236, 105, 18);">เพิ่มตัวแทนจำหน่าย </h4>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2 text-end">ชื่อตัวแทนจำหน่าย</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="supplies_name" name="supplies_name" style="width: 100%">
                                </div>
                            </div> 
                            <div class="col-md-2 text-end">เลขผู้เสียภาษี</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="supplies_tax" name="supplies_tax" style="width: 100%">
                                </div>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 text-end">เบอร์โทร</div>
                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <input type="text" class="form-control-sm d12font input_border" id="supplies_tel" name="supplies_tel" style="width: 100%">
                                </div>
                            </div>
                            <div class="col-md-2 text-end">แฟก</div>
                            <div class="col-md-4 text-start">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="fax" name="fax" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        

                        <div class="row mt-2">
                           
                            <div class="col-md-2 text-end">เลขที่บัญชี</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="account_no" name="account_no" style="width: 100%">
                                </div>
                            </div> 
                            <div class="col-md-2 text-end">ธนาคาร</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="bank_name" name="bank_name" style="width: 100%">
                                </div>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 text-end">ชื่อบัญชี</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="account_name" name="account_name" style="width: 100%">
                                </div>
                            </div> 
                            <div class="col-md-2 text-end">สาขา</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="bank_location" name="bank_location" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                             
                            <div class="col-md-2 text-end">ที่อยู่</div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <textarea class="form-control-sm d12font input_border" id="supplies_address" name="supplies_address" style="width: 100%" rows="5"></textarea>
                                    
                                </div>
                            </div> 
                        </div>

                        <input type="hidden" id="bg_yearnow" name="bg_yearnow">
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <button type="button" id="AddSupplies" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                                     {{-- <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i> --}}
                                     <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    บันทึก
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    {{-- <i class="fa-solid fa-xmark text-white me-2 ms-2"></i> --}}
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    Close
                                </button>

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
 
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        var Linechart;
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
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
  
            $('#AddSupplies').click(function() {
                var supplies_name           = $('#supplies_name').val(); 
                var supplies_tax              = $('#supplies_tax').val(); 
                var supplies_tel        = $('#supplies_tel').val(); 
                var fax           = $('#fax').val(); 
                var account_no    = $('#account_no').val(); 
                var account_name    = $('#account_name').val();  
                var bank_name    = $('#bank_name').val(); 
                var bank_location        = $('#bank_location').val();  
                 var supplies_address        = $('#supplies_address').val();  
                            
                        $.ajax({
                            url: "{{ route('wh.wh_supplies_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {supplies_name,supplies_tax,supplies_tel,fax,account_no,account_name,bank_name,bank_location,supplies_address},
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
                                                    window.location.reload();
                                                    // window.location="{{url('wh_sub_main_rp')}}"; 
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
                            
                    // }
                // })
            });
            // 

        });
    </script>
  

@endsection
