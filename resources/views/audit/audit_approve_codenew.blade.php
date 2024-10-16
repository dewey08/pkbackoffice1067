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
       
            <div class="row">
                <div class="col-md-3">
                    <h4 class="card-title" style="color:rgb(250, 128, 124)">Detail Pre-Audit OFC</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit OFC</p>
                </div>
                <div class="col"></div> 
                <div class="col-md-4">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                    data-date-autoclose="true" data-provide="datepicker"
                    data-date-container='#datepicker1'>
                    <input type="text" class="form-control card_audit_4" name="startdate"
                        id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required />
                    <input type="text" class="form-control card_audit_4" name="enddate"
                        placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}" />
                    <button type="button" class="ladda-button btn-pill btn btn-primary card_audit_4" data-style="expand-left" id="Pulldata">
                        <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                        <span class="ladda-spinner"></span>
                    </button>
                    <button type="button" class="ladda-button btn-pill btn btn-sm btn-success card_audit_4" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">   
                        <i class="fas fa-file-excel text-white me-2" style="font-size:13px"></i>
                        <span>Import</span> 
                    </button> 
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body">
                         
                            <div class="row mt-2">
                                <div class="col-md-12"> 
                                    <div class="table-responsive">
                                        <table id="example"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">vn</th>
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center">staff</th>
                                                    <th class="text-center">debt_date</th>
                                                    <th class="text-center">amount</th>
                                                    <th class="text-center">total_amount</th>
                                                    <th class="text-center">sss_approval_code</th>
                                                    <th class="text-center">sss_amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $jj = 1; ?>
                                                @foreach ($ofc_data as $item) 
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                        <td class="text-center" width="8%">{{ $item->vn }}</td>  
                                                        <td class="text-center text-primary" width="5%"> {{ $item->hn }} </td>
                                                        <td class="text-center text-primary" width="10%"> {{ $item->cid }} </td>
                                                        <td class="text-start text-primary"> {{ $item->ptname }} </td>
                                                        <td class="text-start text-success" width="5%"> {{ $item->staff }} </td>
                                                        <td class="text-center" width="8%"> {{ $item->vstdate }} </td>
                                                        <td class="text-center" width="10%" style="color:rgb(23, 121, 233)">{{ number_format($item->amount, 2) }}</td> 
                                                        <td class="text-center" width="10%" style="color:rgb(23, 121, 233)">{{ number_format($item->total_amount, 2) }}</td> 
                                                        <td class="text-center" width="10%" style="color:rgb(23, 121, 233)">{{ $item->sss_approval_code }}</td> 
                                                        <td class="text-center" width="10%" style="color:rgb(23, 121, 233)">{{ number_format($item->sss_amount, 2) }}</td> 
                                                      
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


             <!-- exampleModal Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content"> 
                    <div class="modal-body">
                        <form method="POST" action="{{ route('audit.audit_approve_codenew_excel') }}" id="insert_Form" enctype="multipart/form-data">
                            @csrf
                            <br>                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group"> 
                                                <i class="fas fa-file-excel fa-5x me-2"></i> 
                                                <br>
                                                <div class="input-group mt-3"> 
                                                    <input type="file" class="form-control" id="files" name="files" onchange="addimg(this)" required>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="row mt-4">
                                        <div class="col"></div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <button type="submit" class="ladda-button btn-pill btn btn-success">
                                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                                    บันทึกข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col"></div>
                                    </div> 
                                </div>   
                            <br> 
                        </form>   
                    </div>         
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

            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate   = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
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
                                    url: "{{ route('audit.audit_approve_codenew_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลข้อมูลสำเร็จ',
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


            $('#insert_Form').on('submit',function(e){
                  e.preventDefault();
              
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({ 
                          position: "top-end",
                          title: 'นำเข้าข้อมูลสำเร็จ',
                          text: "You Import data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location.reload();  
                            // window.location="{{url('air_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

           


        });
    </script>
@endsection
