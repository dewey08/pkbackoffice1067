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

  
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="2.5" 
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-8">
                <h4 style="color:rgb(255, 255, 255)"> รายงานผลการตรวจสอบสภาพถังดับเพลิง โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</h4>
                <p style="font-size: 17px"> รายการถังดับเพลิงที่เช็คไปแล้ว ในเดือน {{$month_name}}</p>
            </div>
            <div class="col"></div>
            {{-- <div class="col-md-3"> 
                รายละเอียดถังดับเพลิง ที่เช็คไปแล้ว
            </div> --}}
    </div> 

        <div class="row">
            <div class="col-xl-12">
                <div class="card card_prs_4 p-3">
                    {{-- <div class="card-header">
                        <div class="card-header-title font-size-lg text-capitalize fw-normal">
                            รายละเอียดถังดับเพลิง ที่เช็คไปแล้ว
                        </div> 
                    </div> --}}
                    <div class="table-responsive mt-2">
                        {{-- <table id="example" class="table table-striped table-bordered" style="width: 100%;"> --}}
                            <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="align-middle text-truncate mb-0 table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">รหัส</th>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">ขนาดถัง (ปอนด์)</th>
                                    <th class="text-center">สี</th>
                                    <th class="text-center">สถานที่ตั้ง</th> 
                                    <th class="text-center">วันที่ตรวจสอบ</th> 
                                    <th class="text-center">ผู้ตรวจสอบ</th> 
                                </tr>
                                
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>  
                                    @foreach ($datafire as $item_sub)
                                        <?php $i++ ?> 
                                            <tr> 
                                                <td class="text-center text-muted" style="width: 5%;">{{$i}}</td>
                                                <td class="text-center" style="width: 7%;"> {{$item_sub->fire_num}} </td> 
                                                <td class="text-center" style="width: 20%;"> {{$item_sub->fire_name}} </td> 
                                                <td class="text-center" style="width: 7%;"> {{$item_sub->fire_size}} </td> 
                                                <td class="text-center" style="width: 5%;"> {{$item_sub->fire_color}} </td> 
                                                <td class="text-start"> {{$item_sub->fire_location}} </td> 
                                                <td class="text-center" style="width: 7%;"> {{DateThai($item_sub->check_date)}} </td> 
                                                <td class="text-center" style="width: 10%;"> {{$item_sub->fname}} {{$item_sub->lname}} </td> 
                                            </tr> 
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div> 
        </div>

    </div>

@endsection
@section('footer')
 
    <script>
     $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
 

        });
    </script>

@endsection
