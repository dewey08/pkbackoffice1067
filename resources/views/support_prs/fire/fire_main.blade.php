@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Fire-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function fire_destroy(fire_id) {
            Swal.fire({
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
                        url: "{{ url('fire_destroy') }}" + '/' + fire_id,
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
                                        $("#sid" + fire_id).remove();
                                        // window.location.reload();
                                        window.location = "{{ url('fire_main') }}";
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
        <div class="col-md-4">
          
            <h4 style="color:rgb(255, 255, 255)">ทะเบียนถังดับเพลิง</h4>
            {{-- <p class="card-title-desc" style="font-size: 17px;">ทะเบียนถังดับเพลิง</p> --}}
        </div>
        <div class="col"></div>
      
        <div class="col-md-6 text-end">
            <a href="{{url('fire_qrcode_all')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-info bt_prs">  
                <i class="fa-solid fa-print me-2 text-white me-2" style="font-size:13px"></i>
                <span>Print QRCODE All</span> 
            </a> 
            <a href="{{url('fire_qrcode_detail_all')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-secondary bt_prs">  
                <i class="fa-solid fa-print me-2 text-white me-2" style="font-size:13px"></i>
                <span>Print QRCODE Detail All</span>
                
            </a> 
            <a href="{{url('fire_add')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs"> 
                <i class="fa-solid fa-circle-plus text-white me-2"></i>
               เพิ่มรายการ
            </a>  
           
        </div>
</div> 

<div class="row mt-2">
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
                                    <th class="text-center" width="3%">รูปภาพ</th> 
                                    <th class="text-center" width="5%">QRcode</th>  
                                    <th class="text-center" width="5%">รหัส</th>  
                                    <th class="text-center" >รายการ</th> 
                                    <th class="text-center">ขนาด(ปอนด์)</th> 
                                    <th class="text-center" >สถานที่ตั้ง</th>  
                                    <th class="text-center" >วันผลิต</th> 
                                    <th class="text-center" >วันหมดอายุ</th> 
                                    <th class="text-center">จัดการ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    <tr id="tr_{{$item->fire_id}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        <td class="text-center" width="3%">
                                            @if ($item->active == 'Y')
                                                {{-- <span class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">ปกติ</span> --}}
                                                <span class="badge bg-success">ปกติ</span>  
                                            @else
                                                {{-- <span class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">ชำรุด</span> --}}
                                                <span class="badge bg-danger">ชำรุด</span>
                                            @endif
                                        </td>
                                      
                                        @if ( $item->fire_imgname == Null )
                                        <td class="text-center" width="3%"><img src="{{asset('assets/images/defailt_img.jpg')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs"></td> 
                                        @else
                                        <td class="text-center" width="3%"><img src="{{asset('storage/fire/'.$item->fire_imgname)}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">  </td>                                
                                        @endif

                                        <td class="text-center" width="5%"> 
                                          
                                            {!!QrCode::size(20)->generate(" $item->fire_id ")!!}  

                                        </td> 

                                        <td class="text-center" width="7%">{{ $item->fire_num }}</td>  
                                        <td class="p-2">{{ $item->fire_name }}</td>  
                                        <td class="text-center" width="5%">{{ $item->fire_size }}</td>    
                                        <td class="p-2" width="20%">{{ $item->fire_location }}</td>  
                                        <td class="text-center" width="7%">{{ DateThai($item->fire_date_pdd) }}</td> 
                                        <td class="text-center" width="7%">{{ DateThai($item->fire_date_exp) }}</td> 
                                        <td class="text-center" width="5%">

                                            {{-- <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-bs-toggle="dropdown"
                                                    class="dropdown-toggle btn btn-outline-secondary btn-sm">
                                                    ทำรายการ
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu"> 
                                                    <a class="dropdown-item text-primary" href="{{ url('fire_qrcode/'.$item->fire_id) }}" style="font-size:13px"> 
                                                        <i class="fa-solid fa-print me-2 text-primary" style="font-size:13px"></i>
                                                        <span>Print QR</span>
                                                    </a>                                                     
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-info" href="{{ url('fire_qrcode_detail/'.$item->fire_id) }}" style="font-size:13px"> 
                                                        <i class="fa-solid fa-print me-2 text-info" style="font-size:13px"></i>
                                                        <span>Print QR Detail</span>
                                                    </a> 
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-warning" href="{{ url('fire_edit/' . $item->fire_id) }}" style="font-size:13px" target="blank">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                        <span>แก้ไข</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="fire_destroy({{ $item->fire_id }})"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                        <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                    </a>
                                                </div>
                                            </div> --}}

                                            <div class="btn-group me-1">
                                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    ทำรายการ <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                   
                                                    <a class="dropdown-item text-primary" href="{{ url('fire_qrcode_detail/'.$item->fire_id) }}" style="font-size:13px" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="Print QR"> 
                                                        <i class="fa-solid fa-print me-2 text-primary" style="font-size:13px"></i>
                                                        <span>Print QR Detail</span>
                                                    </a> 
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-warning" href="{{ url('fire_edit/' . $item->fire_id) }}" style="font-size:13px" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                        <span>แก้ไข</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="fire_destroy({{ $item->fire_id }})" style="font-size:13px"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can me-2"></i>
                                                        <span style="color: rgb(255, 2, 2);font-size:13px">ลบ</span> 
                                                    </a>
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
