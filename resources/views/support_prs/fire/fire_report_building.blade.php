@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Fire-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function air_main_repaire_destroy(air_repaire_id) {
            Swal.fire({
                position: "top-end",
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('air_main_repaire_destroy') }}" + '/' + air_repaire_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + air_repaire_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
                        }
                    })
                }
            })
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
    <form action="{{ url('air_report_building') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-7">
                <h4 style="color:rgb(255, 255, 255)">รายงานจำนวนถังดับเพลิงแยกตามสถานที่ตั้งและขนาด ปีงบประมาณ </h4>
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
            </div>
             
            <div class="col"></div>
            <div class="col-md-2 text-end"> 
                {{-- <a href="{{url('air_report_building_excel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    Export To Excel
                </a> --}}
                <a href="{{url('fire_report_building_excel')}}" class="ladda-button btn-pill btn btn-sm btn-success bt_prs">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Export To Excel</span>  
                </a>
            
            </div>
        </div>  
    </form>
 
<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                

                <p class="mb-0">
                    <div class="table-responsive">
                        {{-- <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;"> --}}
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                         --}}
                            <thead>                             
                                  
                                    <tr style="font-size:14px">  
                                        <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">ที่ตั้ง/อาคาร</th> 
                                        <th class="text-center">ถังแดง 10 ปอนด์</th> 
                                        <th class="text-center">ถังแดง 15 ปอนด์</th>   
                                        <th class="text-center">ถังแดง 20 ปอนด์</th> 
                                        <th class="text-center">ถังเขียว 10 ปอนด์</th>  
                                        <th class="text-center">รวม</th>
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>                               
                                    <tr>                                                  
                                        <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                        <td class="text-start" style="font-size:13px;color: rgb(2, 95, 182)">{{$item->building_name}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(4, 117, 117)">{{$item->red_10}}</td> 
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">{{$item->red_15}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">{{$item->red_20}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">{{$item->green_10}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">{{$item->total_all}}</td> 
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
           
            // $('select').select2();
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
            // $('#example2').DataTable();
            // var table = $('#example').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 10,
            //     "lengthMenu": [10,25,30,31,50,100,150,200,300],
            // });
        
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
