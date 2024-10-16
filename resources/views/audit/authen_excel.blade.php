@extends('layouts.audit')
@section('title', 'PK-OFFICE || Audit')
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
            border: 10px #ddd solid;
            border-top: 10px #0dc79f solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }

        .modal-dis {
            width: 1350px;
            margin: auto;
        }

        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
        }
    </style>

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
        {{-- <form action="{{ route('audit.authen_excel') }}" method="POST" enctype="multipart/form-data"> 
            @csrf --}}
            <div class="row">
                <div class="col-md-2">
                    <h4 class="card-title" style="color:rgb(250, 128, 124)">Detail Pre-Audit Authen</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit Authen</p>
                </div>
                <div class="col-md-1 text-start"> 
                    <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> 
                        <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                    </button>
                </div>
                <div class="col"></div>
                <div class="col-md-6 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control card_audit_4" name="startdate" id="datepicker"
                            placeholder="Start Date" data-date-container='#datepicker1'
                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required />
                        <input type="text" class="form-control card_audit_4" name="enddate"
                            placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" />
                            <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardacc" id="Pulldata">
                                <i class="fa-solid fa-1 text-white me-2"></i><i class="fa-solid fa-magnifying-glass text-white me-2"></i>
                                {{-- <i class="fa-solid fa-spinner text-white me-2"></i> --}}
                                ค้นหา
                           </button>
                        {{-- <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-url="{{ url('pre_audit_process_a') }}">
                            <i class="fa-solid fa-sack-dolla"></i>
                            ค้นหา
                        </button> --}}
                    </div>
                </div>
            </div>
        {{-- </form>  --}}
        <div class="row">
            <div class="col"></div>
            <div class="col-xl-6">
                <div class="card card_audit_4">
                    <div class="card-body text-center">
                        <form action="{{ route('audit.authen_excel_save') }}" method="POST" enctype="multipart/form-data"> 
                            @csrf
                                <div class="mb-3 mt-2">
                                    <label for="formFileLg" class="form-label">UP AUTHEN EXCEL => ส่งข้อมูล</label>
                                    <input class="form-control form-control-lg" id="formFileLg" name="file"
                                        type="file" required>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-warning cardacc" data-style="expand-left">
                                    <span class="ladda-label"> <i class="fa-solid fa-2 text-white me-2"></i><i class="fa-solid fa-upload text-white me-2"></i>Import</span>
                                    <span class="ladda-spinner"></span>
                                </button> 
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-warning cardacc mb-3" data-style="expand-left">
                                    <span class="ladda-label"> <i class="fa-solid fa-upload text-white me-2"></i>Update Hos</span>
                                    <span class="ladda-spinner"></span>
                                </button>  --}}
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-success card_fdh_4" id="Updatedata">
                                    <i class="fa-solid fa-3 text-white me-2"></i><i class="fa-solid fa-spinner text-white me-2"></i>
                                    Update Authen 
                                </button>
                        </form>    
                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">รายการที่ไม่ลง Authen Code วันนี้ทั้งหมด</h4>  
                                <div class="table-responsive"> 
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">    
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับ</th> 
                                                <th class="text-center">HN</th> 
                                                <th class="text-center">VN</th>
                                                <th class="text-center">CID</th>
                                                <th class="text-center">vstdate</th>
                                                <th class="text-center">pttype</th>
                                                <th class="text-center">ชื่อ-สกุล</th>
                                                <th class="text-center">claimcode</th> 
                                                <th class="text-center">debit</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $jj = 1; ?>
                                            @foreach ($authen_excel as $item_n) 
                                                <tr > <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->hn }}</td>
                                                    <td class="text-center" style="width: 7%">{{ $item_n->vn }}</td>
                                                    <td class="text-center" style="width: 7%">{{ $item_n->cid }}</td>
                                                    <td class="text-center" style="width: 10%">{{ $item_n->vstdate }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->pttype }}</td>
                                                    <td class="p-2">{{ $item_n->ptname }}</td>  
                                                    <td class="text-center" style="width: 15%">
                                                        @if ($item_n->claim_code =='')
                                                            <span class="bg-danger badge me-2">*_*</span> 
                                                        @else
                                                            <span class="bg-success badge me-2">{{ $item_n->claim_code }}</span> 
                                                        @endif 
                                                    </td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->debit }}</td> 
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">คู่มือการใช้งาน</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center"> 
            <p style="color: red;font-size: 17px;">คู่มือการนำเข้า Authen Code</p> 
            <p style="color: red;font-size: 17px;"> <a href="https://authenservice.nhso.go.th/authencode/#/login" target="_blank">เข้าสู่ระบบ สปสช</a></p><br> 
            <img src="{{ asset('images/doc/Authen_1.jpg') }}" class="rounded" alt="Image" width="auto" height="520px"> 
            <br><br><br> 
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">
            <br><br><br> 
            <img src="{{ asset('images/doc/Authen_2.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
            <br><br><br>
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">
            <br><br><br> 
            <img src="{{ asset('images/doc/Authen_3.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
            <br><br><br>
            <hr style="color: red;border: blueviolet">
            <hr style="color: red;border: blueviolet">



          
            
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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
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
            var table = $('#example3').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#stamp').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#Updatedata').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val();
                Swal.fire({
                    title: 'ต้องการอัพเดทข้อมูลใช่ไหม ?',
                    text: "You Warn Update Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#overlay").fadeIn(300);
                        $("#spinner").show(); //Load button clicked show spinner 

                        $.ajax({
                            url: "{{ route('audit.authen_update') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                startdate,
                                enddate
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        position: "top-end",
                                        title: 'อัพเดทข้อมูลสำเร็จ',
                                        text: "You Update data success",
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
                                            $('#spinner')
                                                .hide(); //Request is complete so hide spinner
                                            setTimeout(function() {
                                                $("#overlay").fadeOut(
                                                    300);
                                            }, 500);
                                        }
                                    })
                                } else {

                                    // Swal.fire({
                                    //     position: "top-end",
                                    //     icon: "warning",
                                    //     title: "ยังไม่ได้เลือกวันที่",
                                    //     showCancelButton: false,
                                    //     confirmButtonColor: '#ed8d29',
                                    //     confirmButtonText: 'เลือกใหม่'
                                    //     // timer: 1500
                                    // }).then((result) => {
                                    //     if (result
                                    //         .isConfirmed) {
                                    //         window.location.reload();
                                    //     }
                                    // })

                                }
                            },
                        });

                    }
                })
            });

            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate   = $('#datepicker2').val(); 
                Swal.fire({ position: "top-end",
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('claim.authen_excel_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
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




   
    </script>
@endsection
