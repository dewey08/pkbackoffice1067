@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Support-System')

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

    {{-- <style>
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
    </style> --}}

    <div class="tabs-animation">
        {{-- <div class="row text-center">
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
        </div> --}}
         
        <div id="preloader" class="center">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="3.5" 
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>
    
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                {{-- <div class="page-title-head center-elem">
                                    <span class="d-inline-block pe-2">
                                        <i class="lnr-apartment opacity-6" style="color:rgb(228, 8, 129)"></i>
                                    </span>
                                    <span class="d-inline-block"><h3>รายงานผลการตรวจสอบสภาพถังดับเพลิง  โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</h3></span>
                                </div>  --}}
                                <div class="row">
                                    <div class="col-md-10"> 
                                            <h4 style="color: rgb(255, 255, 255)">รายงานผลการตรวจสอบสภาพถังดับเพลิง  โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</h4> 
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                            {{-- <a href="{{url('support_system_excel')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success bt_prs">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                Export To Excel
                                            </a>  --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions"> 
                            
                        </div>
                    </div>
                </div>
           
 
            
  
                <div class="card card_prs_4 mt-2">
                    <div class="card-body">
                        {{-- <div class="row">
                            <div class="col-md-10"> 
                                    <h4 style="color: rgb(7, 121, 106)">รายงานผลการตรวจสอบสภาพถังดับเพลิง  โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</h4> 
                            </div>
                            <div class="col-md-2 text-end"> 
                                    <a href="{{url('support_system_excel')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success bt_prs">
                                        <i class="fa-solid fa-file-excel me-2"></i>
                                        Export To Excel
                                    </a> 
                            </div>
                        </div> --}}
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                   
                                <div class="table-responsive">
                                    {{-- <table class="align-middle text-truncate mb-0 table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                                        <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">ลำดับ</th>
                                                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">เดือนที่ตรวจ</th>
                                                <th colspan="6" class="text-center" style="background-color: rgb(255, 237, 117)">ถังดับเพลิงทั้งหมดที่มี (ถัง)</th>
                                                <th colspan="6" class="text-center" style="background-color: rgb(117, 216, 255)">ถังดับเพลิงที่ได้รับการตรวจสอบ (ถัง)</th>
                                                <th rowspan="3" class="text-center" style="background-color: rgb(247, 157, 151)">จำนวน<br>ที่ไม่ได้ตรวจ<br>รวม(ถัง)</th>
                                                <th rowspan="3" class="text-center" style="background-color: rgb(250, 211, 226)">จำนวน<br>ที่ชำรุด<br>รวม(ถัง)</th>
                                                <th colspan="2" class="text-center" style="background-color: rgb(253, 185, 211)">ร้อยละ</th> 
                                            </tr>
                                            <tr> 
                                                <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                                <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                                <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด / เปลี่ยน</th> 
                                                <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                                <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                                <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด</th>   
                                                <th rowspan="2" class="text-center" style="background-color: rgb(255, 251, 228)">ที่ตรวจ<br> รวม(ถัง)</th> 
                                                <th rowspan="2" class="text-center" style="background-color: rgb(228, 253, 255)">ที่ชำรุด<br> รวม(ถัง)</th> 
                                            </tr>
                                            <tr> 
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์/สำรอง</th>
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์/สำรอง</th>
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์/สำรอง</th>
                                                <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th> 
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์</th>
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์</th>
                                                <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์</th>
                                                <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datareport as $itemreport) 
                                                <?php $i++ ?>
                                                <?php 
                                                        $dashboard_ = DB::select(
                                                            'SELECT (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_year = "'.$itemreport->yearsthai.'" ) as red_all
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redten
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redfifteen
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redtwenty 
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as greenten
                                                                
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") total_all
                                                                
                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redten
                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redfifteen
                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redtwenty
                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_greenten

                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Checktotal_all_old
                                                                ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'" AND f.active = "N") as camroot

                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                                                                ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                                                                ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                                                                ,(SELECT COUNT(DISTINCT fire_id) FROM fire_check WHERE month(check_date) = "'.$itemreport->months.'" AND fire_year = "'.$itemreport->yearsthai.'") as Checktotal_all
                                                            FROM fire_check f
                                                            WHERE month(f.check_date) = "'.$itemreport->months.'"
                                                            AND f.fire_year = "'.$itemreport->yearsthai.'" 
                                                            GROUP BY month(f.check_date)
                                                        ');  
                                                        // ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot   
                                                        
                                                    //    dd($counts_);
                                                        foreach ($dashboard_ as $key => $value) {
                                                            // $red_all               = $value->red_all;
                                                            $counts_ = DB::select('SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'"');                                 
                                                            // if ($counts_ < 1) {
                                                            //     $redten                = '0';
                                                            //     $redfifteen            = '0';
                                                            //     $redtwenty             ='0';
                                                            //     $greenten              ='0';
                                                            //     $total_all             = '0';
                                                            //     $Check_redten          = '0';
                                                            //     $Check_redfifteen      = '0';
                                                            //     $Check_redtwenty       = '0';
                                                            //     $Check_greenten        ='0';
                                                            //     $Checktotal_all        = '0';
                                                            //     $camroot               ='0';
                                                            //     $green_all             = '0';
                                                            //     $Checkgreen_all        = '0';
                                                            // } else {
                                                                $redten                = $value->redten;
                                                                $redfifteen            = $value->redfifteen;
                                                                $redtwenty             = $value->redtwenty;
                                                                $greenten              = $value->greenten;
                                                                $total_all             = $value->total_all;
                                                                $Check_redten          = $value->Check_redten;
                                                                $Check_redfifteen      = $value->Check_redfifteen;
                                                                $Check_redtwenty       = $value->Check_redtwenty;
                                                                $Check_greenten        = $value->Check_greenten;
                                                                $Checktotal_all        = $value->Checktotal_all;
                                                                $camroot               = $value->camroot;
                                                                $green_all             = $value->green_all;
                                                                $Checkgreen_all        = $value->Checkgreen_all;
                                                            // }
                                                            
                                                            
                                                        } 
                                                        $sumyokma_all_ = DB::select(
                                                            'SELECT COUNT(f.fire_id) as cfire 
                                                                FROM fire_check fc  
                                                                LEFT OUTER JOIN fire f ON f.fire_id = fc.fire_id
                                                                WHERE month(fc.check_date) = "'.$itemreport->months.'" 
                                                                AND year(fc.check_date) = "'.$itemreport->years.'" 
                                                        '); 
                                                        // $trut          = 100 / $itemreport->total_all_qty * ($Check_redten+$Check_redfifteen+$Check_redtwenty+$Check_greenten);
                                                        // $chamrootcount = 100 / $itemreport->total_all_qty * $camroot;

                                                        $trut          = 100 / $itemreport->total_all_qty * $Checktotal_all;
                                                        $chamrootcount = 100 / $itemreport->total_all_qty * $camroot;

                                                        $count_check_ = DB::select('SELECT COUNT(fire_id) as checkfire FROM fire_report WHERE check_status = "N" AND months = "'.$itemreport->months.'" AND years = "'.$itemreport->years.'" '); 
                                                        foreach ($count_check_ as $key => $v_check) {
                                                            $count_nocheck   = $v_check->checkfire;
                                                        }
                                                        $m       = date('m');
                                                        $chang_ = DB::select(
                                                            'SELECT COUNT(DISTINCT fc.fire_id) as firechang
                                                            FROM fire f
                                                            INNER JOIN fire_chang fc ON fc.fire_id = f.fire_id
                                                            WHERE MONTH(fc.fire_chang_date) = "'.$itemreport->months.'" AND year(fc.fire_chang_date) = "'.$itemreport->years.'"  
                                                        '); 
                                                        foreach ($chang_ as $key => $vc) {
                                                            $chang = $vc->firechang;
                                                        }
                                                ?>
                                                <tr> 
                                                    <td class="text-center text-muted" style="width: 5%;background-color: rgb(2255, 251, 228)">{{$i}}</td>
                                                    <td class="text-start" style="width: 10%;background-color: rgb(2255, 251, 228)">
                                                        {{$itemreport->month_name}} พ.ศ.{{$itemreport->yearsthai}}
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                            {{$itemreport->total_red10}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red10}}</span> /
                                                        <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r10}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                            {{$itemreport->total_red15}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red15}}</span> /
                                                        <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r15}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                            {{$itemreport->total_red20}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red20}}</span> /
                                                        <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r20}}</span>
                                                    </td>
                                                    <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">
                                                            {{$itemreport->total_green10}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-success p-2">{{$itemreport->total_green10}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">                                                    
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-info me-2 ms-2">
                                                            {{$itemreport->total_all_qty}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_all_qty}}</span> /
                                                        <a href="{{url('fire_report_month_chang/'.$itemreport->months.'/'.$itemreport->years)}}" target="_blank" class="badge rounded-pill bg-warning p-2 text-danger">
                                                            {{$chang}}
                                                        </a>
                                                        {{-- <span class="badge rounded-pill bg-warning p-2 text-danger">{{$chang}}</span>  --}}
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                            {{$Check_redten}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redten}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                            {{$Check_redfifteen}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redfifteen}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                            {{$Check_redtwenty}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redtwenty}}</span>
                                                    </td>
                                                    <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">
                                                            {{$Check_greenten}}
                                                            
                                                        </a> --}}
                                                        <span class="badge rounded-pill bg-success p-2">{{$Check_greenten}}</span>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(219, 243, 252)">
                                                        @if ($itemreport->months == $m)
                                                            <a href="{{url('support_system_check/'.$itemreport->months.'/'.$itemreport->yearsthai)}}" target="_blank" class="badge rounded-pill bg-primary p-2">
                                                                {{$Checktotal_all}}
                                                            </a> 
                                                        @else
                                                        <span class="badge rounded-pill bg-primary p-2">{{$Checktotal_all}}</span> 
                                                       
                                                        @endif
                                                        
                                                    </td> 

                                                    <td class="text-center" style="background-color: rgb(253, 202, 198)">
                                                        <a href="{{url('support_system_nocheck/'.$itemreport->months.'/'.$itemreport->yearsthai)}}" target="_blank" class="badge rounded-pill p-2" style="background-color: rgb(252, 123, 114)">
                                                        {{-- <a href="" target="_blank" class="badge rounded-pill p-2" style="background-color: rgb(253, 80, 68)"> --}}
                                                            {{-- {{$count_nocheck}} --}}
                                                            {{$itemreport->total_all_qty-$Checktotal_all}}
                                                        </a>
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill p-2" style="background-color: #da0d06">
                                                            {{$camroot}}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: #da0d06">{{$camroot}}</span> 
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill p-2" style="background-color: #4becd1">
                                                            {{ number_format($trut, 2) }}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: #4becd1"> {{ number_format($trut, 2) }}</span> 
                                                    </td>
                                                    <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                        {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-warning p-2">
                                                            {{ number_format($chamrootcount, 2) }}
                                                        </a> --}}
                                                        <span class="badge rounded-pill p-2" style="background-color: #d6413c"> {{ number_format($chamrootcount, 2) }}</span> 
                                                    </td>
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

    <!-- aircountModal Modal --> 
    <div class="modal fade" id="aircountModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">จำนวนเครื่องที่แจ้งซ่อม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div style='overflow:scroll; height:500px;'>

                                    <div id="detail"></div>
                                       
                                  </div>
                            </div> 
                        </div>  
                </div>
               
            </div>
        </div>
    </div>

     <!-- น้ำหยด Modal --> 
     <div class="modal fade" id="problems_1Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">จำนวนเครื่องที่แจ้งซ่อมรายการน้ำหยด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div style='overflow:scroll; height:500px;'>

                                    <div id="detail_ploblem_1"></div>
                                       
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
        
     $(document).ready(function() {
             
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example2').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });

            var xmlhttp = new XMLHttpRequest();
            var url = "{{ url('support_dashboard_chart') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas); 
                    
                    count_red = datas.Dataset1.map(function(e) {
                        return e.count_red;
                    });
                    count_color_red_qty = datas.Dataset1.map(function(e) {
                        return e.count_color_red_qty;
                    });
                    count_red_all= datas.Dataset1.map(function(e) {
                        return e.count_red_all;
                    });
                    console.log(count_red_all); 

                    count_green = datas.Dataset1.map(function(e) {
                        return e.count_green;
                    });
                    count_green_percent= datas.Dataset1.map(function(e) {
                        return e.count_green_percent;
                    });
                      
                            // Radial 
                            var options_red = {
                                series: count_red,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#f80707'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials"), options_red);
                            chart.render();

                            // // **************************************

                            var options_green = {
                                series: count_green_percent,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#ABE5A1'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials_green"), options_green);
                            chart.render();

                }
             }

             $("#spinner-div").hide(); //Request is complete so hide spinner
         
            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate   = $('#datepicker2').val(); 
                Swal.fire({
                        position: "top-end",
                        title: 'ต้องการประมวลผลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.support_system_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 2000) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ประมวลผลสำเร็จ',
                                                text: "You Process data success",
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
                                    },
                                });
                                
                            }
                })
            });

        });

        $(document).on('click', '.aircountModal', function() {
            var air_location_id = $(this).val(); 
            $('#aircountModal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('support_detail') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail').html(result);
                },
            });
        });

        $(document).on('click', '.problems_1Modal', function() {
            var air_location_id = $(this).val(); 
            $('#problems_1Modal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('detail_ploblem_1') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail_ploblem_1').html(result);
                },
            });
        });

        

    </script>

@endsection

