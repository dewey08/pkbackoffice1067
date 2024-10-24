@extends('layouts.mobile')
@section('title', 'PK-OFFICE || Air-Service')

@section('content')

 
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
        }

        .cardfire {
            border-radius: 1em 1em 1em 1em;
            box-shadow: 0 0 15px pink;
            border: solid 1px #80acfd;
            /* box-shadow: 0 0 10px rgb(232, 187, 243); */
        }
    </style>
    <?php
    
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
        
    ?>



    <div class="container-fluid mt-4 mb-5">
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
        <div class="row text-center">
            <div class="col"></div>
            <div class="col-md-8 text-center">
                {{-- <h2>ประวัติการแจ้งซ่อมเครื่องปรับอากาศ</h2> --}}
                <h2 style="color: rgb(162, 69, 248)">แผนการบำรุงรักษาประจำปีและประวัติการซ่อม</h2>
            </div>
            <div class="col"></div>
            
        </div>

        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card cardfire">
                    <div class="card-body">

                     
                                        <div class="row">
                                            <div class="col text-start"> 
                                                <p style="color:rgb(6, 184, 160)">ส่วนที่ 1 : รายละเอียด </p>
                                            </div>
                                            <div class="col-6 text-end"> 
                                                <?php 
                                                    $countqti_ = DB::select(
                                                        'SELECT COUNT(a.air_list_num) as air_list_num 
                                                        FROM air_repaire a 
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                        WHERE a.air_list_num = "'.$data_detail_->air_list_num.'"
                                                        AND b.air_repaire_type_code = "04" 
                                                    ');
                                                    foreach ($countqti_ as $key => $value) {
                                                        $countqti = $value->air_list_num;
                                                    }
                                                ?>
                                                <p style="color:red">ซ่อมไปแล้ว {{$countqti}} ครั้ง</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                           
                                            <div class="col-8">
                                                <p style="color:rgb(8, 103, 228)">รหัส : {{ $data_detail_->air_list_num }}</p>
                                                <p style="color:rgb(8, 103, 228)">ชื่อ : {{ $data_detail_->air_list_name }}</p>
                                                <p style="color:rgb(8, 103, 228)">Btu : {{ $data_detail_->btu }}</p> 
                                            </div>
                                            <div class="col text-center">
                                                @if ($data_detail_->air_imgname == null)
                                                    <img src="{{ asset('assets/images/defailt_img.jpg') }}" height="180px" width="200px"
                                                        alt="Image" class="img-thumbnail">
                                                @else
                                                    <img src="{{ asset('storage/air/' . $data_detail_->air_imgname) }}" height="180px"
                                                        width="200px" alt="Image" class="img-thumbnail">
                                                @endif 
                                                {{-- <p style="color:rgb(8, 103, 228)" class="mt-2">สถานะ : {{ $data_detail_->btu }}</p>  --}}
                                                @if ($data_detail_->active == 'Y') 
                                                    <span class="badge bg-success mt-2">พร้อมใช้งาน</span> 
                                                @else 
                                                    <span class="badge bg-danger mt-2">ไม่พร้อมใช้งาน</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-start"> 
                                                <p style="color:rgb(8, 103, 228)">serial_no : {{ $data_detail_->serial_no }}</p> 
                                                <p style="color:rgb(8, 103, 228)">ที่ตั้ง : {{ $data_detail_->air_location_name }}</p>
                                                <p style="color:rgb(8, 103, 228)">หน่วยงาน : {{ $data_detail_->detail }}</p>
                                            </div>
                                        </div>

                                        <hr style="color:red">
                                        <div class="row">
                                            <div class="col text-start">
                                                <p style="color:rgb(6, 184, 160)">ส่วนที่ 2 : แผนการบำรุงรักษาประจำปี</p>
                                            </div>
                                            <div class="col-1 text-start me-4">
                                                <div class="input-group">    
                                                    <p style="color:rgb(253, 253, 253)">  <span class="badge bg-success">5</span></p> 
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            @foreach ($plan as $item_plan)
                                            <?php 
                                                $plan_count1 = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire_sub WHERE air_list_num = "'.$item_plan->air_list_num.'" AND air_repaire_type_code = "01" AND air_repaire_ploblem_id IN("1")');
                                                foreach ($plan_count1 as $key => $val_1) {
                                                    $plan_s1   = $val_1->air_list_num;
                                                }  
                                                $plan_count2 = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire_sub WHERE air_list_num = "'.$item_plan->air_list_num.'" AND air_repaire_type_code = "01" AND air_repaire_ploblem_id IN("2")');
                                                foreach ($plan_count2 as $key => $val_2) {
                                                    $plan_s2   = $val_2->air_list_num;
                                                } 
                                                $plan_count3 = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire_sub WHERE air_list_num = "'.$item_plan->air_list_num.'" AND air_repaire_type_code = "01" AND air_repaire_ploblem_id IN("3")');
                                                foreach ($plan_count3 as $key => $val_3) {
                                                    $plan_s3   = $val_3->air_list_num;
                                                } 
                                                $plan_count4 = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire_sub WHERE air_list_num = "'.$item_plan->air_list_num.'" AND air_repaire_type_code = "01" AND air_repaire_ploblem_id IN("4")');
                                                foreach ($plan_count4 as $key => $val_4) {
                                                    $plan_s4   = $val_4->air_list_num;
                                                } 
                                                $plan_count5 = DB::select('SELECT COUNT(air_list_num) as air_list_num FROM air_repaire_sub WHERE air_list_num = "'.$item_plan->air_list_num.'" AND air_repaire_type_code = "01" AND air_repaire_ploblem_id IN("5")');
                                                foreach ($plan_count5 as $key => $val_5) {
                                                    $plan_s5   = $val_5->air_list_num;
                                                } 

                                                // $plan_maint = DB::select(
                                                //     'SELECT COUNT(a.air_list_num) as air_list_num 
                                                //         FROM air_repaire_sub a
                                                //         LEFT JOIN air_plan b ON b.air_list_num = a.air_list_num
                                                //         LEFT JOIN air_plan_month c ON c.air_plan_month_id = b.air_plan_month_id
                                                //         LEFT JOIN air_repaire_type d ON d.air_repaire_type_id = c.air_repaire_type_id
                                                //     WHERE a.air_list_num = "'.$item_plan->air_list_num.'" 
                                                //         AND a.air_repaire_type_code = "'.$item_plan->air_repaire_type_code.'"
                                                //         AND b.air_plan_year = "'.$item_plan->years_en.'" 
                                                //         AND c.air_plan_month = "'.$item_plan->air_plan_month.'"
                                                //         AND c.years = "'.$item_plan->years.'"
                                                // ');
                                                // foreach ($plan_maint as $key => $val_ma) {
                                                //     $plan_maint_count   = $val_ma->air_list_num;
                                                // }     
                                            ?>
                                                <div class="col-6 text-start">
                                                    <div class="input-group"> 
                                                        {{-- @if ($plan_s1 > 0 && $plan_s2 > 0 && $plan_s3 > 0 && $plan_s4 > 0 && $plan_s5 > 0 )
                                                            <img src="{{ asset('images/true.png') }}" width="30px" height="30px">
                                                        @else
                                                        <img src="{{ asset('images/false.png') }}" width="30px" height="30px">
                                                        @endif   --}}
                                                        <p class="mt-2" style="color:rgb(9, 119, 209)"> {{ $item_plan->air_repaire_typename }}</p>
                                                       
                                                    </div> 
                                                </div> 
                                                <div class="col text-start">
                                                    <div class="input-group">    
                                                        <p class="mt-2" style="color:rgb(243, 65, 21)"> {{ $item_plan->air_plan_name }} {{$item_plan->years_en}}</p> 
                                                    </div> 
                                                </div> 
                                                <div class="col-1 text-start me-4">
                                                    <div class="input-group">   
                                                        @if ($item_plan->count_mt < '5')
                                                        <p class="mt-2" style="color:rgb(253, 253, 253)">  <span class="badge bg-danger">{{$item_plan->count_mt}}</span></p> 
                                                        @else
                                                        <p class="mt-2" style="color:rgb(253, 253, 253)">  <span class="badge bg-success">{{$item_plan->count_mt}}</span></p> 
                                                        @endif 
                                                       
                                                    </div> 
                                                </div> 
                                            @endforeach 
                                        </div>


                                        <hr style="color:red">
                                        <div class="row">
                                            <div class="col text-start">
                                                <p style="color:rgb(6, 184, 160)">ส่วนที่ 3 : ประวัติการบำรุงรักษาประจำปี </p>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            @foreach ($data_detail_sub_mai as $item_mai)
                                                <div class="col-8 text-start">
                                                    <div class="input-group">   
                                                        <img src="{{ asset('images/true.png') }}" width="20px" height="20px"> 
                                                        <p class="ms-2" style="color:rgb(9, 119, 209)"> {{ $item_mai->maintenance_list_name }}ครั้งที่{{ $item_mai->repaire_no }}</p>
                                                        {{-- <p class="mt-2" style="color:rgb(247, 135, 61)"> {{ Datethai($item_mai->repaire_date) }}</p> --}}
                                                        {{-- maintenance_list_name  repaire_sub_name--}}
                                                    </div> 
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="input-group">   
                                                        <p style="color:rgb(247, 135, 61)"> {{ Datethai($item_mai->repaire_date) }}</p>
                                                    </div> 
                                                </div>
                                          
                                                {{-- <div class="col-3 text-end">
                                                    <div class="input-group">  
                                                        <p class="mt-2" style="color:rgb(247, 135, 61)"> {{ Datethai($item_mai->repaire_date) }} </p>
                                                    </div> 
                                                </div> --}}
                                            @endforeach 
                                        </div>


                                        <hr style="color:red">
                                        <div class="row">
                                            <div class="col text-start">
                                                <p style="color:rgb(6, 184, 160)">ส่วนที่ 4 : ประวัติการซ่อม(ซ่อมตามปัญหา)</p>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            @foreach ($data_detail_sub_plo as $item_plo)
                                                <div class="col-7 text-start">
                                                    <div class="input-group">   
                                                        <img src="{{ asset('images/true.png') }}" width="20px" height="20px"> 
                                                        &nbsp;&nbsp;<p class="mt-1" style="color:rgb(9, 119, 209)"> {{ $item_plo->repaire_sub_name }}</p>
                                                    </div> 
                                                </div>
                                                {{-- <div class="col"></div> --}}
                                                <div class="col-4 text-end">
                                                    <div class="input-group">  
                                                        <p class="mt-1" style="color:rgb(247, 135, 61)"> {{ Datethai($item_plo->repaire_date) }} </p>
                                                    </div> 
                                                </div>
                                            @endforeach 
                                        </div>
 
 
 
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
@section('footer')
  
@endsection
