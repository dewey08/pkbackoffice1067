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
                <h4 style="color:rgb(10, 151, 85)">เครื่องปรับอากาศที่มีปัญหาเดิม 2 ครั้งขึ้นไป
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
                <a href="{{ url('air_report_problems') }}" class="ladda-button me-2 btn-pill btn btn-warning bt_prs">
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
                                    {{-- <th class="text-center" width="5%">วันที่ซ่อม</th>   --}}
                                    {{-- <th class="text-center" width="5%">เวลา</th>  --}}
                                    {{-- <th class="text-center" width="5%">ใบแจ้งซ่อม</th>  --}} 
                                    <th class="text-center" width="5%">รหัส</th>  
                                    <th class="text-center" width="10%">Detail</th> 
                                    <th class="text-center" >รายการ</th>   
                                    <th class="text-center" >สถานที่ตั้ง</th>  
                                    {{-- <th class="text-center" >เจ้าหน้าที่</th>   --}}
                                    {{-- <th class="text-center" >ช่าง รพ.</th>    --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    <tr id="tr_{{$item->air_repaire_id}}">     
                                        <?php 
                                            $count_air_detail = DB::select('SELECT COUNT(b.repaire_sub_id) as repaire_sub_id FROM air_repaire a 
                                                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                                                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                AND b.air_repaire_ploblem_id = "'.$air_repaire_ploblem_id.'"
                                                AND a.air_list_num = "'.$item->air_list_num.'" AND b.air_repaire_type_code = "04"
                                            ');                                     
                                            foreach ($count_air_detail as $key => $val2) {$countair = $val2->repaire_sub_id;}
                                        ?>
 
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        
                                        {{-- <td class="text-center" width="8%">{{ DateThai($item->repaire_date )}}</td>   --}}
                                        {{-- <td class="text-center" width="8%">{{ $item->repaire_time }}</td>  --}}
                                        {{-- <td class="text-center" width="7%">{{ $item->air_repaire_no }}</td>    --}}
                                        <td class="text-center" width="10%">{{ $item->air_list_num }}</td>  
                                        <td class="text-center" width="10%">
                                            <button type="button" class="ladda-button btn-pill btn btn-info bt_prs btn-sm detailModal" value="{{ $item->air_list_num }}">
                                                รายละเอียด <span class="badge bg-danger me-2 ms-2">{{$countair}}</span>
                                            </button>  
                                        </td>  
                                        <td class="text-start">{{ $item->air_list_name }} {{ $item->btu }} btu</td>   
                                        <td class="text-start" width="20%">{{ $item->air_location_name }}</td>  
                                        {{-- <td class="text-start" width="10%">{{ $item->ptname }}</td>   --}}
                                        {{-- <td class="text-start" width="10%">{{ $item->tectname }}</td>   --}}                                         
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

<!-- detailModal Modal --> 
<div class="modal fade" id="detailModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">รายการซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                    <div class="row">
                        <div class="col-md-12">
                            <div style='overflow:scroll; height:500px;'>
                                <div id="detail_moreModal"></div>  
                                <input type="hidden" name="startdate" id="startdate" value="{{$startdate}}">   
                                <input type="hidden" name="enddate" id="enddate" value="{{$enddate}}">
                                <input type="hidden" name="air_repaire_ploblem_id" id="air_repaire_ploblem_id" value="{{$air_repaire_ploblem_id}}">                                           
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

            $(document).on('click', '.detailModal', function() {
                var air_list_num            = $(this).val(); 
                var startdate               = $('#startdate').val();
                var enddate                 = $('#enddate').val();
                var air_repaire_ploblem_id  = $('#air_repaire_ploblem_id').val();
                $('#detailModal').modal('show');  
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_moreModal') }}",
                    data: { air_list_num: air_list_num ,startdate: startdate,enddate: enddate,air_repaire_ploblem_id: air_repaire_ploblem_id},
                    success: function(result) { 
                        $('#detail_moreModal').html(result);
                    },
                });
            });

        });
    </script>

@endsection
