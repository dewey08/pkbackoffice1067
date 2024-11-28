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
            $type      = Auth::user()->type;
            $iduser    = Auth::user()->id;
            $subtrueid = Auth::user()->dep_subsubtrueid;
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
    
        <div class="row mt-5"> 
            <div class="col-md-6"> 
                <h5 class="card-title" style="color:rgb(2, 94, 148)">คลัง {{$stock_name}}</h5>
                <p class="card-title-desc">หน่วยงาน {{$stock_bigname}} ประจำปีงบประมาณ {{$bg_yearnow}}</p>
            </div>
            <div class="col"></div>  
            <div class="col-md-3 text-end">  
                <a href="{{url('wh_sub_report')}}" class="ladda-button btn-pill btn card_prs_4" style="color:rgb(3, 165, 124)" target="_blank"> 
                    <img src="{{ asset('images/report_new2.png') }}" class="me-2" height="23px" width="23px"> 
                     รายงานคลัง{{$stock_name}}
                </a>
                <a href="{{url('wh_sub_main_rp')}}" class="ladda-button btn-pill btn card_prs_4" style="color:rgb(12, 96, 207)" target="_blank"> 
                    <img src="{{ asset('images/recieve_store.png') }}" class="me-2" height="23px" width="23px"> 
                     เบิกพัสดุ
                </a>
                <a href="{{url('wh_sub_main_pay')}}" class="ladda-button btn-pill btn card_prs_4" style="color:rgb(255, 84, 149)" target="_blank"> 
                    <img src="{{ asset('images/pay_store.png') }}" class="me-2" height="23px" width="23px"> 
                    ตัดจ่าย
                </a>
        </div>
        </div>
 
       
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card_prs_4" style="background-color: rgb(238, 252, 255)">
   
                            <div class="card-body">
                               
                                <div class="row"> 
                                    <div class="col-xl-12">
                                        <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                       
                                            <thead> 
                                                <tr style="font-size: 10px;">
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="5%">ลำดับ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">รายการ</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="20%">ประเภท</th>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 11px;" width="10%">ขนาดบรรจุ / หน่วยนับ</th> 
                                                    <th class="text-center" style="background-color: rgb(250, 242, 187);font-size: 11px;" width="10%">รับเข้า</th> 
                                                    <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 11px;" width="10%">จ่ายออก</th> 
                                                    <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 11px;" width="10%">คงเหลือ</th>  
                                                    <th class="text-center" style="background-color: rgb(255, 228, 234);font-size: 11px;" width="10%">ราคา</th> 
                                                    <th class="text-center" style="background-color: rgb(255, 228, 234);font-size: 11px;" width="10%">ราคารวม</th> 
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($wh_stock_sub as $item)
                                                <?php $i++ ?>
                                                <tr style="font-size:12px;">
                                                    <td class="text-center" width="5%">{{$i}}</td>
                                                    <td class="text-start">{{$item->pro_code}} || {{$item->pro_name}}</td>
                                                    <td class="text-start" width="20%">{{$item->wh_type_name}}</td>
                                                    <td class="text-center" width="10%">{{$item->wh_unit_pack_qty}}/{{$item->unit_name}}</td> 
                                                    
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">
                                                        @if ($item->stock_rep =='')
                                                            0
                                                        @else
                                                        {{$item->stock_rep}}
                                                        @endif 
                                                    </td>
                                                    <td class="text-center" style="color:#f17006" width="10%">
                                                        @if ($item->stock_pay =='')
                                                            0
                                                        @else
                                                        {{$item->stock_pay}}
                                                        @endif 
                                                    </td>
                                                    @php
                                                        // $price_rep   = $item->stock_rep * $item->one_price;
                                                        // $price_pay   = $item->stock_pay * $item->one_price;
                                                        $total_price = ($item->stock_rep-$item->stock_pay) * $item->one_price;
                                                    @endphp
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->stock_rep-$item->stock_pay}} </td> 
                                                    <td class="text-end" width="10%" style="color:rgb(3, 155, 104)" width="10%">{{number_format($item->one_price, 2)}}</td> 
                                                    <td class="text-end" width="10%" style="color:rgb(3, 155, 104)" width="10%">{{number_format($total_price, 2)}}</td> 
                                                </tr>
                                                <?php
                                                    // $total1 = $total1 + $item->stock_qty;
                                                    $total2 = $total2 + $item->stock_rep;
                                                    $total3 = $total3 + $item->stock_pay;
                                                    $total4 = $total4 + $item->stock_rep-$item->stock_pay;
                                                    $total5 = $total5 + $item->one_price;        
                                                    // $total6 = $total6 + ($item->sum_stock_price)*($item->stock_rep-$item->stock_pay);  
                                                    $total6 = $total6 + $total_price;  
                                                ?>  
                                                    
                                                @endforeach                                                
                                            </tbody>
                                            <tr style="background-color: #f3fca1">
                                                <td colspan="4" class="text-end" style="background-color: #c7f2f8"></td>
                                                {{-- <td class="text-center" style="background-color: #f58d73;color: #065ca3">{{number_format($total1,0)}}</td>  --}}
                                                <td class="text-center" style="background-color: #faece9;color: #f71a51;font-size:17px;">{{number_format($total2,0)}}</td> 
                                                <td class="text-center" style="background-color: #faece9;color: #f71a51;font-size:17px;">{{number_format($total3,0)}}</td> 
                                                <td class="text-center" style="background-color: #faece9;color: #f71a51;font-size:17px;">{{number_format($total4,0)}}</td>    
                                                <td class="text-end" style="background-color: #faece9;color: #f71a51;font-size:17px;"></td>  
                                                <td class="text-end" style="background-color: #faece9;color: #f71a51;font-size:17px;">{{number_format($total6,2)}}</td> 
                                             
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
