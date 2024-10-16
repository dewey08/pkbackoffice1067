@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')
 
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
            border-top: 10px #12c6fd solid;
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

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
        $strDate = date('Y-m-d');
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    // // $strDay= date("j",strtotime($strDate));

    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    // // return $strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear;
    $monthyear = $strMonthThai.'  พ.ศ. '.$strYear;
    ?>

<div class="tabs-animation">
     
        
   
        <div class="row">
            <div class="col-md-8">
                {{-- <div class="card card_audit_4c">
                    <div class="card-body"> --}}
                        <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.216</h4>
                        <p class="card-title-desc">
                            รายละเอียดข้อมูล ผัง 1102050101.216 เดือน {{$monthyear}}
                        </p>

                        {{-- <table id="example21" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr> 
                                    <th class="text-center">เดือน</th> 
                          
                                    <th class="text-center">ตั้งลูกหนี้</th>   
                                    <th class="text-center">Statement</th>
                                    <th class="text-center">ยกยอดไปเดือนนี้</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $number = 0; 
                                    $total1 = 0;
                                    $total2 = 0;
                                    $total3 = 0;
                                    $total4 = 0;
                                    $total5 = 0;$total6 = 0;
                                ?>
                                @foreach ($datashow as $item2)
                                    <?php
                                        $number++;
                                        $y = $item2->year;
                                            $ynew = $y + 543;
                                        // ลูกหนี้ทั้งหมด
                                       
                                    ?>
                            
                                        <tr> 
                                            <td class="p-2">{{$item2->MONTH_NAME}} {{$ynew}}</td>                 
                                            <td class="text-end" width="10%" style="color:rgb(186, 75, 250)"> {{ number_format($item2->debit_total, 2) }}</td>                                             
                                            <td class="text-end" style="color:rgb(4, 161, 135)" width="15%">{{ number_format($item2->stm_Total, 2) }}</td> 
                                            <td class="text-end" style="color:rgb(224, 128, 17)" width="15%">0.00</td> 
                                        </tr>
                                    <?php
                                            
                                            $total2 = $total2 + $debit_total;  
                                            $total4 = $total4 + $stm_Total; 
                                    ?>
                                @endforeach

                            </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="1" class="text-end" style="background-color: #fca1a1"></td> 
                                    <td class="text-end" style="background-color: #9f4efc" ><label for="" style="color: #000000">{{ number_format($total2, 2) }}</label></td>  
                                    <td class="text-end" style="background-color: #0ea080"><label for="" style="color: #000000">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #000000">0.00</label></td>  
                                
                                </tr>  
                        </table> --}}

                    {{-- </div> <!-- end card body--> --}}
                {{-- </div> <!-- end card --> --}}
            </div>
            <div class="col"></div>
        </div>
        
        
        <div class="row">
            <div class="col-xl-12">
                    <div class="card card_audit_4c">                   
                        <div class="card-body">                     
                            <div class="table-responsive">                                
                                {{-- <table id="scroll-vertical-datatable" class="table dt-responsive nowrap w-100"> --}}
                                 <table id="scroll-vertical-datatable" style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th> 
                                            <th class="text-center">vstdate</th>  
                                            <th class="text-center">hn</th>
                                            <th class="text-center">cid</th>
                                            <th class="text-center">ptname</th>                                       
                                            <th class="text-center">pttype</th>   
                                            <th class="text-center">income</th>
                                            <th class="text-center">ชำระเงินเอง</th> 
                                            <th class="text-center">ตั้งลูกหนี้</th> 
                                            {{-- <th class="text-center">Walkin</th>  --}}
                                            <th class="text-center">ส่วนต่าง</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $number = 0; 
                                        $total111 = 0;
                                        $total222 = 0;
                                        $total333 = 0;
                                        $total444 = 0;
                                        $total555 = 0; $total666 = 0;
                                        ?>
                                        @foreach ($data as $item)
                                        <?php $number++; ?> 
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td> 
                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                <td class="p-2">{{ $item->ptname }}</td>                                            
                                                <td class="text-center" width="5%">{{ $item->pttype }}</td>                                      
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income, 2) }}</td>  
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->rcpt_money, 2) }}</td> 
                                                <td class="text-center" style="color:rgb(207, 28, 37)" width="7%"> {{ number_format($item->debit_total, 2) }}</td> 
                                                {{-- <td class="text-center"  width="7%" style="color:#108A1A"> {{ number_format($item->debit_walkin, 2) }}</td>   --}}
                                                <td class="text-end"  width="7%" style="color:#E9540F"> {{ number_format(($item->income)-($item->rcpt_money)-($item->debit_total),2) }}</td>  
                                            </tr>
                                                <?php 
                                                    $total111 = $total111 + $item->income;
                                                    $total222 = $total222 + $item->rcpt_money; 
                                                    $total333 = $total333 + $item->debit_total;
                                                    // $total444 = $total444 + $item->debit_walkin;
                                                    $total555 = $total555 + (($item->income)-($item->rcpt_money)-($item->debit_total));
                                                ?>
                                    @endforeach

                                    </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="6" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #000000">{{ number_format($total111, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #9f4efc" ><label for="" style="color: #000000">{{ number_format($total222, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #c5224b"><label for="" style="color: #000000">{{ number_format($total333, 2) }}</label> </td>
                                        {{-- <td class="text-center" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">{{ number_format($total444, 2) }}</label></td> --}}
                                        <td class="text-center" style="background-color: #f89625"><label for="" style="color: #000000">{{ number_format($total555, 2) }}</label></td>  
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
 
@endsection
