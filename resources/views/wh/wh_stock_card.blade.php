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
    
        <div class="row"> 
            <div class="col-md-8"> 
                <h4 style="color:rgb(247, 103, 68)>คลัง{{$stock_name}} </h4>
                <p style="color:rgb(236, 11, 97);font-size:19px">รายการ {{$pro_name}} || รหัส {{$pro_code}}</p>
            </div>
            {{-- <div class="col"></div>    --}}
            <div class="col-md-4 text-end"> 
                <button type="button" class="ladda-button btn-pill btn btn-white card_audit_4c">
                   <i class="fa-regular fa-rectangle-list me-2 ms-2" style="color:rgb(4, 161, 148);font-size:19px"></i>คงเหลือ {{$total_qty}}
                </button>
                <button type="button" class="ladda-button btn-pill btn btn-white card_audit_4c">
                    ราคา {{number_format($total_price, 2)}} <i class="fa-solid fa-baht-sign me-2 ms-2" style="color:rgb(238, 15, 89);font-size:19px"></i>
                 </button>
            </div>
        </div> 
        {{-- <i class="fa-solid fa-money-check-dollar"></i> --}}
 
       
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card_audit_4c" style="background-color: rgb(248, 241, 237)">
   
                            <div class="card-body">
                               
                                <div class="row"> 
                                    <div class="col-xl-6">
                                        <p style="color: rgb(7, 125, 172);font-size:17px">รายละเอียดการรับเข้า</p>
                                        <table id="example" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;"> 
                                            {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">  --}}
                                        {{-- <table class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead> 
                                                <tr style="font-size: 10px;">
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="5%">ลำดับ</th>
                                                   
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">LOT</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="10%">วันที่รับ</th>
                                                    {{-- <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="10%">วันที่จ่าย</th> --}}
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">หน่วย</th> 
                                                    <th class="text-center" style="background-color: rgb(235, 160, 125);font-size: 11px;">รับเข้า</th> 
                                                    {{-- <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 11px;">จ่ายออก</th>  --}}
                                                    {{-- <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 11px;">คงเหลือ</th>   --}}
                                                      <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 11px;">ราคาต่อหน่วย</th> 
                                                    <th class="text-center" style="background-color: rgb(255, 228, 234);font-size: 11px;">ราคารวม</th> 
                                              
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($stock_card_recieve as $item)
                                                <?php $i++ ?>

                                                <tr>
                                                    <td class="text-center" width="5%">{{$i}}</td> 
                                                    <td class="text-center" style="color:rgb(216, 6, 76)">{{$item->lot_no}}</td>
                                                    <td class="text-center" width="10%">{{$item->recieve_date}}</td> 
                                                    <td class="text-center" width="8%">{{$item->wh_unit_name}}</td>  
                                                    <td class="text-center" style="color:rgb(224, 75, 6)">
                                                        @if ($item->qty =='') 0
                                                        @else {{$item->qty}}
                                                        @endif                                                       
                                                    </td> 
                                                    <td class="text-end" style="color:rgb(4, 115, 180)" width="15%">{{number_format($item->one_price, 2)}}</td> 
                                                    <td class="text-end" style="color:rgb(4, 115, 180)" width="15%">{{number_format($item->qty*$item->one_price, 2)}}</td> 
                                                   
                                                </tr>
                                                
                                                    
                                                @endforeach                                                
                                            </tbody>
                                           
                                        </table>

                                    </div>
                                    <div class="col-xl-6">
                                        <p style="color: rgb(7, 125, 172);font-size:17px">รายละเอียดการจ่ายออก</p>
                                        <table id="example2" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;"> 
                                            <thead> 
                                                <tr style="font-size: 10px;">
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="5%">ลำดับ</th>
                                                   
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">LOT</th> 
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="10%">วันที่จ่าย</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">หน่วย</th>  
                                                    <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 11px;">จ่ายออก</th>  
                                                      <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 11px;">ราคาต่อหน่วย</th> 
                                                    <th class="text-center" style="background-color: rgb(255, 228, 234);font-size: 11px;">ราคารวม</th> 
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $ii = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($stock_card_pay as $item_p)
                                                <?php $ii++ ?>

                                                <tr>
                                                    <td class="text-center" width="5%">{{$ii}}</td>
                                                    <td class="text-center" style="color:rgb(216, 6, 76)">{{$item_p->lot_no}}</td> 
                                                    <td class="text-center">{{$item_p->export_date}}</td>
                                                    <td class="text-center" width="8%">{{$item_p->wh_unit_name}}</td>                                                  
                                                    <td class="text-center" style="color:rgb(224, 75, 6)">
                                                        @if ($item_p->qty_pay =='') 0
                                                        @else {{$item_p->qty_pay}}
                                                        @endif                                                       
                                                    </td>      
                                                    <td class="text-end" style="color:rgb(4, 115, 180)" width="15%">{{number_format($item_p->one_price, 2)}}</td> 
                                                    <td class="text-end" style="color:rgb(4, 115, 180)" width="15%">{{number_format($item_p->qty_pay*$item_p->one_price, 2)}}</td>                                               
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

</div>


 
 
@endsection
@section('footer')
 
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
  
        });
    </script>
  

@endsection
