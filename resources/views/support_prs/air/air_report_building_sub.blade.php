@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function air_destroy(air_list_id) {
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
                        url: "{{ url('air_destroy') }}" + '/' + air_list_id,
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
                                        $("#sid" + air_list_id).remove();
                                        // window.location.reload();
                                        window.location = "{{ url('air_main') }}";
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
   
    <div class="row"> 
        <div class="col-md-4">
            <h4 class="card-title" style="color:rgb(10, 151, 85)">Register Air</h4>
            <p class="card-title-desc">ทะเบียนครุภัณฑ์เครื่องปรับอากาศ</p>
        </div>
        <div class="col"></div>
      
        <div class="col-md-7 text-end">
            <a href="{{url('air_report_building')}}" class="ladda-button me-2 btn-pill btn btn-warning cardacc"> 
                <i class="fa-solid fa-arrow-left me-2"></i> 
               ย้อนกลับ
            </a> 
             
        </div>
</div> 

<div class="row">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">  

                <p class="mb-0">
                    <div class="table-responsive">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                  
                                    <th width="3%" class="text-center">ลำดับ</th>  
                                    <th class="text-center" width="3%">สถานะ</th> 
                                    {{-- <th class="text-center" width="3%">รูปภาพ</th>  --}}
                                    {{-- <th class="text-center" width="5%">QRcode</th>   --}}
                                    <th class="text-center" width="5%">รหัส</th>  
                                    <th class="text-center" >รายการ</th> 
                                    <th class="text-center">ขนาด(BTU)</th> 
                                    <th class="text-center" >สถานที่ตั้ง</th>  
                                    <th class="text-center" >หน่วยงาน</th> 
                                    <th class="text-center" >ชั้น</th>  
                                    {{-- <th class="text-center">จัดการ</th>  --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow_sub as $item) 
                                    <tr id="tr_{{$item->air_list_id}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        <td class="text-center" width="3%">
                                            @if ($item->active == 'Y') 
                                                <span class="badge bg-success">พร้อมใช้งาน</span> 
                                            @else 
                                                <span class="badge bg-danger">ไม่พร้อมใช้งาน</span>
                                            @endif
                                        </td>
                                      
                                        {{-- @if ( $item->air_imgname == Null )
                                        <td class="text-center" width="3%"><img src="{{asset('assets/images/defailt_img.jpg')}}" height="20px" width="20px" alt="Image" class="img-thumbnail"></td> 
                                        @else
                                        <td class="text-center" width="3%"><img src="{{asset('storage/air/'.$item->air_imgname)}}" height="20px" width="20px" alt="Image" class="img-thumbnail">  </td>                                
                                        @endif 
                                        <td class="text-center" width="5%">  
                                            {!! QrCode::size(20)->style('round')->generate('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/air_repaire/' . $item->air_list_id) !!} 
                                        </td>  --}}

                                        <td class="text-center" width="7%">{{ $item->air_list_num }}</td>  
                                        <td class="p-2">{{ $item->air_list_name }}</td>  
                                        <td class="text-center" width="5%">{{ $item->btu }}</td>    
                                        <td class="p-2" width="20%">{{ $item->air_location_id }} - {{ $item->air_location_name }}</td>  
                                        <td class="p-2" width="20%">{{ $item->detail }}</td> 
                                        <td class="text-center" width="5%">{{ $item->air_room_class }}</td> 
                                      
                                        {{-- <td class="text-center" width="5%">

                                            <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-bs-toggle="dropdown"
                                                    class="dropdown-toggle btn btn-outline-secondary btn-sm">
                                                    ทำรายการ
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu"> 
                                                    <a class="dropdown-item text-primary" href="{{ url('air_qrcode/'.$item->air_list_id) }}" style="font-size:13px" target="_blank"> 
                                                        <i class="fa-solid fa-print me-2 text-primary" style="font-size:13px"></i>
                                                        <span>Print QR</span>
                                                    </a> 
                                                     
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-warning" href="{{ url('air_edit/' . $item->air_list_id) }}" style="font-size:13px" target="blank">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                        <span>แก้ไข</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="air_destroy({{ $item->air_list_id }})"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                        <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                    </a>
                                                </div>
                                            </div>

                                        </td> --}}

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
