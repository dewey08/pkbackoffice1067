@extends('layouts.support_prs_water')
@section('title', 'PK-OFFICE || Water-Service')

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
           
            <h4 style="color:rgb(255, 255, 255)">ทะเบียนเครื่องผลิตน้ำดื่ม</h4>
            {{-- <p class="card-title-desc" style="font-size: 17px;">ทะเบียนเครื่องปรับอากาศ</p> --}}
        </div>
        <div class="col"></div>
      
        <div class="col-md-7 text-end">
         
            {{-- <a href="{{url('air_qrcode_detail_all')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-secondary bt_prs">  
                <i class="fa-solid fa-print text-white me-2" style="font-size:13px"></i>
                <span>Detail All</span> 
            </a>  --}}
            <a href="{{url('drinking_qrcode')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-warning bt_prs">  
                <i class="fa-solid fa-print text-white me-2" style="font-size:13px"></i>
                <span>qrcode</span> 
            </a> 
            <a href="{{url('drinking_water_add')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs"> 
                <i class="fa-solid fa-circle-plus text-white me-2"></i>
               เพิ่มรายการ
            </a>  
            <a href="{{url('drinking_water_mobileadd')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs"> 
                <i class="fa-solid fa-mobile-screen-button text-white me-2"></i>
               เพิ่มรายการ
            </a> 
     
            {{-- <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> 
                <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
            </button> --}}
           
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
                      
                            <thead>
                                <tr>
                                  
                                    <th width="3%" class="text-center">ลำดับ</th>  
                                    <th class="text-center" width="3%">สถานะ</th> 
                                    <th class="text-center" width="3%">รูปภาพ</th> 
                                    <th class="text-center" width="5%">รหัสเครื่อง</th>  
                                    <th class="text-center" width="5%">รหัสครุภัณฑ์</th>  
                                    <th class="text-center" >รายการ</th> 
                                    <th class="text-center" >อาคาร/ชั้น</th> 
                                    <th class="text-center" >หน่วยงาน</th> 
                                    {{-- <th class="text-center">size(Q)</th>   --}}
                                    <th class="text-center">จัดการ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    <tr id="tr_{{$item->water_filter_id}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        <td class="text-center" width="3%">
                                            @if ($item->active == 'Y') 
                                                <span class="badge bg-success">พร้อมใช้งาน</span> 
                                            @else 
                                                <span class="badge bg-danger">ไม่พร้อมใช้งาน</span>
                                            @endif
                                        </td>
                                      
                                        @if ( $item->water_img == Null )
                                        <td class="text-center" width="3%"><img src="{{asset('assets/images/defailt_img.jpg')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bt_prs" style="background: white"></td> 
                                        @else
                                        <td class="text-center" width="3%"><img src="{{asset('storage/water/'.$item->water_img)}}" height="20px" width="20px" alt="Image" class="img-thumbnail bt_prs" style="background: white">  </td>                                
                                        @endif

                                        {{-- <td class="text-center" width="5%">  
                                            {!! QrCode::size(20)->style('round')->generate('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/water_check/' . $item->water_filter_id) !!} 
                                        </td>   --}}
                                        <td class="text-center" width="7%" style="font-size: 12px">{{ $item->water_code }}</td>  
                                        <td class="text-center" width="7%" style="font-size: 12px">{{ $item->water_num }}</td>  
                                        <td class="p-2">{{ $item->water_name }}</td>  
                                        <td class="p-2">{{ $item->location_name }} / ชั้น {{ $item->class }}</td>  
                                        <td class="p-2">{{ $item->detail }}</td>  
                                        {{-- <td class="text-center" width="5%" style="font-size: 12px">{{ $item->size }}</td>     --}}
                                       
                                        <td class="text-center" width="5%">
 
                                            <div class="btn-group me-1">
                                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    ทำรายการ <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                   
                                                    <a class="dropdown-item text-primary" href="{{ url('drinking_water_qrcode_only/'.$item->water_filter_id) }}" style="font-size:13px" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="Print QR"> 
                                                        <i class="fa-solid fa-print me-2 text-primary" style="font-size:13px"></i>
                                                        <span>Print QR</span>
                                                    </a> 
                                                    <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-warning" href="{{ url('drinking_water_edit/' . $item->water_filter_id) }}" style="font-size:13px" target="_blank"
                                                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                            <span>แก้ไข</span>
                                                        </a> 
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-primary" href="{{ url('drinking_water_mobileedit/' . $item->water_filter_id) }}" style="font-size:13px" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                        {{-- <i class="fa-solid fa-pen-to-square me-2 text-primary" style="font-size:13px"></i> --}}
                                                        <i class="fa-solid fa-mobile-screen-button text-primary me-2"></i>
                                                        <span>แก้ไข</span>
                                                        
                                                    </a>
                                                <div class="dropdown-divider"></div>
                                                    
                                                </div>
                                            </div>
                                        </td>

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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">คู่มือการใช้งาน</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center"> 
            <p style="color: red;font-size: 17px;">คู่มือการเพิ่มรายการแอร์</p><br><br>
            <img src="{{ asset('images/doc/add_air_01.jpg') }}" class="rounded" alt="Image" width="auto" height="520px"> 
            <br><br><br> 
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">
            <br><br><br> 
            <img src="{{ asset('images/doc/add_air_02.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
            <br><br><br>
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">



            <p style="color: red;font-size: 17px;">คู่มือการแก้ไขรายการแอร์</p><br><br> 
            <img src="{{ asset('images/doc/edit_air_01.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
            <br><br><br>
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">
            <img src="{{ asset('images/doc/edit_air_02.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">


            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">  <i class="fa-solid fa-xmark me-2"></i>Close</button> 
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
