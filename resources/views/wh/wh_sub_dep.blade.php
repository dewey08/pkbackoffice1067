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
            <div class="col-md-10"> 
                <h4 style="color:green">คลัง{{$stock_name}}</h4>
                <p class="card-title-desc">หน่วยงาน กลุ่มงานพัสดุโรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ประจำปีงบประมาณ {{$bgyearnow}}</p>
            </div>
            <div class="col"></div>   

        </div>
 
       
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card_audit_4c" style="background-color: rgb(247, 252, 255)">
   
                            <div class="card-body">
                               
                                <div class="row"> 
                                    <div class="col-xl-12"> 
                                                <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead> 
                                                <tr style="font-size: 10px;">
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="5%">ลำดับ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="10%">รายการ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ประเภท</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;">ขนาดบรรจุ / หน่วยนับ</th> 
                                                    <th class="text-center" style="background-color: rgb(250, 242, 187);font-size: 11px;">รับเข้า</th> 
                                                    <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 11px;">จ่ายออก</th> 
                                                    <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 11px;">คงเหลือ</th>  
                                                    <th class="text-center" style="background-color: rgb(255, 228, 234);font-size: 11px;">ราคารวม</th> 
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($wh_product as $item)
                                                <?php $i++ ?>
                                                <tr>
                                                    <td class="text-center" width="5%">{{$i}}</td>
                                                    <td class="text-start" width="10%">{{$item->pro_code}} || {{$item->pro_name}}</td>
                                                    <td class="text-center">{{$item->wh_type_name}}</td>
                                                    <td class="text-center">{{$item->wh_unit_pack_qty}}/{{$item->unit_name}}</td>  
                                                    <td class="text-center" style="color:rgb(3, 93, 145)">
                                                        @if ($item->stock_rep =='')
                                                            0
                                                        @else
                                                            {{$item->stock_rep}}
                                                        @endif 
                                                    </td>
                                                    <td class="text-center" style="color:rgb(3, 93, 145)">
                                                        @if ($item->stock_pay =='')
                                                            0
                                                        @else
                                                            {{$item->stock_pay}}
                                                        @endif 
                                                    </td> 
                                                    <td class="text-center" style="color:rgb(3, 93, 145)">{{$item->stock_rep-$item->stock_pay}} </td> 
                                                    <td class="text-end" width="10%" style="color:rgb(4, 115, 180)">{{number_format($item->sum_stock_price-$item->sum_stock_pricepay, 2)}}</td> 
                                                     
                                                </tr>
                                                <?php
                                                    // $total1 = $total1 + $item->stock_qty;
                                                    $total2 = $total2 + $item->stock_rep;
                                                    $total3 = $total3 + $item->stock_pay;
                                                    $total4 = $total4 + $item->stock_rep-$item->stock_pay;
                                                    // $total5 = $total5 + $item->sum_one_price;        
                                                    $total6 = $total6 + ($item->sum_stock_price-$item->sum_stock_pricepay);  
                                                ?>  
                                                    
                                                @endforeach                                                
                                            </tbody>
                                            <tr style="background-color: #f3fca1">
                                                <td colspan="4" class="text-end" style="background-color: #ff9d9d"></td>
                                                {{-- <td class="text-center" style="background-color: #f58d73;color: #065ca3">{{number_format($total1,0)}}</td>  --}}
                                                <td class="text-center" style="background-color: #f58d73;color: #065ca3">{{number_format($total2,0)}}</td> 
                                                <td class="text-center" style="background-color: #f58d73;color: #065ca3">{{number_format($total3,0)}}</td> 
                                                <td class="text-center" style="background-color: #f58d73;color: #065ca3">{{number_format($total4,0)}}</td>    
                                                {{-- <td class="text-end" style="background-color: #276ed8;color: #1da7e7">{{number_format($total5,2)}}</td>   --}}
                                                <td class="text-end" style="background-color: #276ed8;color: #019765">{{number_format($total6,2)}}</td> 
                                             
                                            </tr>  
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
