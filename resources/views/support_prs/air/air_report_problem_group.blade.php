@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

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

    <?php
        $ynow = date('Y') + 543;
        $yb = date('Y') + 542;
    ?>

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
            <div class="col-md-6">
                <h4 style="color:rgb(10, 151, 85)">เครื่องปรับอากาศที่มีปัญหาเรื่อง {{$dataname}}
                    {{-- @if ($id == '1')
                        ( น้ำหยด ) 
                    @elseif ($id == '2')
                        ( ไม่เย็นมีแต่ลม )
                    @elseif ($id == '3')
                        ( มีกลิ่นเหม็น )
                    @elseif ($id == '4')
                        ( เสียงดัง )
                    @elseif ($id == '5')
                        ( ไม่ติด/ติดๆดับๆ )
                    @else
                        ( อื่นๆ )
                    @endif --}}

                </h4> 
            </div>
            <div class="col"></div>
            <div class="col-md-2 text-end">
                <a href="{{ url('air_report_problems') }}" class="ladda-button me-2 btn-pill btn btn-warning bt_prs bt_prs">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    ย้อนกลับ
                </a>
            </div>
            
        </div>
    
         

<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                <div class="row mb-3">
                   
                    <div class="col"></div>
                    <div class="col-md-5 text-end">
                       
                    </div>
                </div>

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                <tr style="font-size:13px">
                                  
                                    <th width="3%" class="text-center">ลำดับ</th>  
                                    <th class="text-center" width="5%">วันที่ซ่อม</th>  
                                    <th class="text-center" width="5%">เวลา</th> 
                                    <th class="text-center" width="5%">ใบแจ้งซ่อม</th> 
                                    <th class="text-center" width="5%">รหัส</th>  
                                    <th class="text-center" >รายการ</th>   
                                    <th class="text-center" >สถานที่ตั้ง</th>  
                                    <th class="text-center" >เจ้าหน้าที่</th>  
                                    <th class="text-center" >ช่าง รพ.</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    <tr id="tr_{{$item->air_repaire_id}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        
                                        <td class="text-center" width="8%">{{ DateThai($item->repaire_date )}}</td>  
                                        <td class="text-center" width="8%">{{ $item->repaire_time }}</td> 
                                        <td class="text-center" width="7%">{{ $item->air_repaire_no }}</td>   
                                        <td class="text-center" width="7%">{{ $item->air_list_num }}</td>  
                                        <td class="p-2">{{ $item->air_list_name }} {{ $item->btu }} btu</td>   
                                        <td class="p-2" width="20%">{{ $item->air_location_name }}</td>  
                                        <td class="p-2" width="10%">{{ $item->ptname }}</td>  
                                        <td class="p-2" width="10%">{{ $item->tectname }}</td>  
                                         

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </p>
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

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
