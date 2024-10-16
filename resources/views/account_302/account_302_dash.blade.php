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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
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
    ?>

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
        <form action="{{ url('account_302_dash') }}" method="GET">
            @csrf
            <div class="row mt-2"> 
                <div class="col"></div>
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.302</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.302</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-3 text-center">
                    <select name="acc_trimart_id" id="acc_trimart_id" class="form-control">
                        <option value="">--เลือก--</option>
                        @foreach ($trimart as $item) 
                            <option value="{{$item->acc_trimart_id}}">{{$item->acc_trimart_name}}( {{$item->acc_trimart_start_date}} ถึง {{$item->acc_trimart_end_date}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-start"> 
                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary d-shadow" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button>  
                </div>
            </div>
        </form>  
        {{-- <div class="row "> 
            @foreach ($data_trimart as $item)   
            <div class="col-xl-4 col-md-4">
                <div class="card cardacc" style="background-color: rgb(235, 242, 247)">  
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="d-flex text-start">
                                    <div class="flex-grow-1 ">
                                        <?php
                                           
                                            // ลูกหนี้ทั้งหมด
                                            $datas = DB::select('
                                                SELECT count(DISTINCT an) as Can
                                                    ,SUM(debit_total) as sumdebit
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.302"
                                                    AND stamp = "N"
                                                    AND dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                             $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(an) as Cvit
                                                from acc_1102050101_302
                                                where dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');   
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            
                                            //STM
                                            $sumapprove_ = DB::select('
                                                SELECT 
                                                    SUM(ar.acc_stm_repmoney_price302) as total                                                   
                                                    FROM acc_stm_repmoney ar 
                                                    LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
                                                    WHERE ar.acc_trimart_id = "'.$item->acc_trimart_id.'"  
                                            ');                                           
                                            foreach ($sumapprove_ as $key => $value3) {
                                                $total302 = $value3->total; 
                                            }

                                            if ( $sum_Y > $total302) {
                                                $yokpai = $sum_Y - $total302;
                                            } else {
                                                $yokpai = $total302 - $sum_Y;
                                            }
                                            

                                            
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5 > {{$item->acc_trimart_name}}</h5>  
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end mt-2 me-2">
                            
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{ $count_N}} Visit</h6>
                                                    </div>
                                  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0"> 
                                                    ลูกหนี้ที่ต้องตั้ง
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                      
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{ $count_N}} Visit" >
                                                                {{ number_format($sum_N, 2) }} 
                                                                <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                        </p>
                                                    </div>
                                          
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-danger"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0" >
                                                    ตั้งลูกหนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                               
                                                <a href="{{url('account_302_dashsub/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                {{ number_format($sum_Y, 2) }}
                                                                <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-success"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        Statement
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                         
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{number_format($total302, 2) }} บาท">
                                                                {{ number_format($total302, 2) }} 
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                           
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        ยกยอดไปเดือนนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                            
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                            {{ number_format($yokpai, 2) }} 
                                                                <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
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
            @endforeach
        </div> --}}

        <div class="row">  
            <div class="col"></div> 
    
                <div class="col-xl-10 col-md-10">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                        <div class="table-responsive p-3">                                
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th> 
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ไตรมาส</th> 
                                        <th class="text-center" style="background-color: rgb(219, 237, 247)">income</th> 
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ลูกหนี้ที่ต้องตั้ง</th>  
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้</th> 
                                        <th class="text-center" style="background-color: rgb(127, 235, 208)">Stm</th>
                                        <th class="text-center" style="background-color: rgb(250, 225, 234)">ยกยอดไป</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                    ?>
                                    @foreach ($data_trimart as $item)
                                        <?php
                                                $number++;

                                                // income 302
                                             $datas_income = DB::select('
                                                SELECT SUM(income) as income 
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.302" AND debit_total > 0
                                                    AND dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');
                                            foreach ($datas_income as $key => $va_income) { 
                                                $income  = $va_income->income;
                                            }
                                        
                                             // ลูกหนี้ที่ต้องตั้ง 302
                                             $datas = DB::select('
                                                SELECT count(DISTINCT an) as Can 
                                                    ,SUM(debit_total) as sumdebit
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.302"
                                                    AND stamp = "N" AND debit_total > 0
                                                    AND dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N   = $value->sumdebit;
                                            
                                            }
                                            //////// ตั้งลูกหนี้ IPD 302
                                            $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                from acc_1102050101_302
                                                where dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            
                                            ');   
                                            foreach ($datasum_ as $key => $value2) {
                                                $total_sumY = $value2->debit_total;
                                                $total_countY = $value2->Cvit;
                                            } 
                                           
                                            ////////// STM 302
                                            $stm_ = DB::select('
                                                SELECT 
                                                    SUM(ar.acc_stm_repmoney_price302) as total                                                   
                                                    FROM acc_stm_repmoney ar 
                                                    LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
                                                    WHERE ar.acc_trimart_id = "'.$item->acc_trimart_id.'"  
                                            ');                                           
                                            foreach ($stm_ as $key => $value3) {
                                                $total302 = $value3->total; 
                                            }

                                            if ( $total_sumY > $total302) {
                                                $yokpai = $total_sumY - $total302;
                                            } else {
                                                $yokpai = $total302 - $total_sumY;
                                            }

                                            ////////// STM 302
                                            // $stm_ = DB::select(
                                            //     'SELECT sum(recieve_true) as recieve_true,count(DISTINCT an) as Countvisit 
                                            //     FROM acc_1102050101_304 
                                            //     WHERE month(dchdate) = "'.$item->months.'" AND year(dchdate) = "'.$item->year.'" 
                                            //     AND (recieve_true IS NOT NULL OR recieve_true <> "")
                                            // ');                                           
                                            // foreach ($stm_ as $key => $value3) {
                                            //     $sum_recieve_true  = $value3->recieve_true; 
                                            //     $count_stm      = $value3->Countvisit; 
                                            // }

                                            /////////// ยกไป
                                            // $yokpai_ = DB::select('
                                            //         SELECT sum(debit_total) as debit_total,count(an) as Countvi
                                            //             from acc_1102050101_304
                                            //             where month(dchdate) = "'.$item->months.'"
                                            //             AND year(dchdate) = "'.$item->year.'"
                                            //             AND (recieve_true IS NULL OR recieve_true = "") 
                                            //     ');                                           
                                            //     foreach ($yokpai_ as $key => $valpai) {
                                            //         $sum_yokpai = $valpai->debit_total; 
                                            //         $count_yokpai = $valpai->Countvi; 
                                            //     }


                                        ?>
                                
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                <td class="p-2"> 
                                                    {{$item->acc_trimart_name}}
                                                </td>    
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($income, 2) }}</td>                                      
                                                <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('account_302_pull')}}" target="_blank" style="color:rgb(5, 58, 173);"> {{ number_format($sum_N, 2) }}</a>
                                                </td>                                                    
                                                <td class="text-end" style="color:rgb(231, 73, 139);background-color: rgb(203, 227, 255)" width="10%"> 
                                                    <a href="{{url('account_302_detail/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(231, 73, 139);"> {{ number_format($total_sumY, 2) }}</a> 
                                                </td> 
                                                <td class="text-end" style="color:rgb(2, 116, 63);background-color: rgb(203, 227, 255)" width="10%"> 
                                                     <a href="{{url('account_302_stm/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(2, 116, 63);"> {{ number_format($total302, 2) }}</a> 
                                                </td> 
                                              
                                                <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">  
                                                    <a href="{{url('account_302_yok/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(224, 128, 17);"> {{ number_format($yokpai, 2) }}</a> 
                                                </td>
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $income; 
                                                $total2 = $total2 + $sum_N;                                               
                                                $total3 = $total3 + $total_sumY; 
                                                $total4 = $total4 + $total302; 
                                                $total5 = $total5 + $yokpai; 
                                        ?> 
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #000000">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #033a6d"><label for="" style="color: #000000">{{ number_format($total2, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #000000">{{ number_format($total3, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #149966" ><label for="" style="color: #000000">{{ number_format($total4, 2) }}</label></td>  
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #000000">{{ number_format($total5, 2) }}</label></td>                                  
                                </tr>  
                            </table>
                        </div>
                    </div>
                </div>
           
            <div class="col"></div>
        </div>

    </div>

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#acc_trimart_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
