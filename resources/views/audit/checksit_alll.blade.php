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
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(241, 137, 155)"">ข้อมูลกลุ่มผู้ป่วยวัคซีนไข้หวัดใหญ่</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit วัคซีนไข้หวัดใหญ่</p>
                </div>
                <div class="col"></div> 
                <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control inputaccs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control inputaccs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
               
                    <button type="button" class="ladda-button btn-pill btn btn-primary inputacc" data-style="expand-left" id="Pulldata">
                        <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                        <span class="ladda-spinner"></span>
                    </button>  
                    @if ($countc > 0)
                        <a href="{{ url('vaccine_big_send') }}" class="ladda-button btn-pill btn btn-danger inputacc">
                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                กระทบรายตัว
                        </a>
                    @else
                        <button type="button" class="ladda-button btn-pill btn btn-success inputacc" data-bs-toggle="modal" target="_blank" data-bs-target="#editModal"> 
                            <span class="ladda-label"> <i class="fa-regular fa-file-excel text-white me-2"></i>Import </span> 
                            <span class="ladda-spinner"></span>
                        </button>
                    @endif
                   
                </div>  
            </div>
          
            </div>

            <div class="row"> 
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body"> 
                                <div class="table-responsive">    
                                    {{-- <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                        --}}
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับ</th>
                                                <th class="text-center">vn</th>
                                                <th class="text-center">hn</th>
                                                <th class="text-center">cid</th>
                                                <th class="text-center">vstdate</th>
                                                <th class="text-center">ptname</th> 
                                                <th class="text-center">icode</th>
                                                <th class="text-center">income</th> 
                                                <th class="text-center">sum_price</th> 
                                                <th class="text-center">staff</th> 
                                                <th class="text-center">STMDoc</th>
                                                <th class="text-center">authen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $jj = 1; ?>
                                            @foreach ($datashow as $item_m)
                                            <?php  ?>
                                            <tr>
                                                <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                <td class="text-center" width="7%">{{ $item_m->vn }} </td>
                                                <td class="text-center" width="5%">{{ $item_m->hn }} </td> 
                                                <td class="text-center" width="7%">{{ $item_m->cid }} </td>
                                                <td class="text-center" width="10%">{{ $item_m->vstdate }} </td> 
                                                <td class="p-2">{{ $item_m->ptname }} </td> 
                                                <td class="text-center" width="7%">{{ $item_m->icode }} </td>
                                                <td class="text-center" width="7%">{{ number_format($item_m->income, 2) }} </td>
                                                <td class="text-center" width="7%">{{ number_format($item_m->sumprice, 2) }}</td>
                                                <td class="text-center" width="7%">{{ $item_m->staff }} </td>
                                                <td class="text-center" width="10%">{{ $item_m->STMDoc }} </td>  
                                                <td class="text-center" width="10%">{{ $item_m->authen }} </td>  
                                            </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row"> 
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body"> 
                           
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">hospname</th> 
                                                    <th class="text-center">vaccine</th> 
                                                    <th class="text-center">hipdata_code</th> 
                                                    <th class="text-center">hipdata_name</th> 
                                                    <th class="text-center">authen</th> 
                                                    <th class="text-center">vstdate_start</th> 
                                                    <th class="text-center">vstdate_end</th> 
                                                    <th class="text-center">staff</th> 
                                                    <th class="text-center">STMDoc</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $jj = 1; ?>
                                                @foreach ($data_import as $item)
                                                <?php  ?>
                                                <tr>
                                                    <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                    <td class="p-2">{{ $item->ptname }} </td> 
                                                    <td class="text-center" width="7%">{{ $item->cid }} </td>
                                                    <td class="text-center" width="10%">{{ $item->hospname }} </td> 
                                                    <td class="text-center" width="10%">{{ $item->vaccine }} </td>                                                    
                                                    <td class="text-center" width="10%">{{ $item->hipdata_code }} </td>  
                                                    <td class="text-center" width="10%">{{ $item->hipdata_name }} </td> 
                                                    <td class="text-center" width="7%">{{ $item->authen }} </td>
                                                    <td class="text-center" width="7%">{{ $item->vstdate_start }} </td>  
                                                    <td class="text-center" width="7%">{{ $item->vstdate_end }} </td> 
                                                    <td class="text-center" width="7%">{{ $item->staff }} </td> 
                                                    <td class="text-center" width="7%">{{ $item->STMDoc }} </td> 
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


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog">
            <div class="modal-content"> 
                    <div class="modal-body">
                   
                            <form action="{{ route('vac.vaccine_big_import') }}" id="update_Form" method="POST" enctype="multipart/form-data"> 
                                @csrf
                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">  
                                              
                                                    <label for="formFileLg" class="form-label">UP STM EXCEL => UP STM => ส่งข้อมูล</label><br>
                                                    <input class="form-control" id="formFileLg" name="file" type="file" required>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col"></div> 
                                        <div class="col-md-3 text-end"></div>
                                        <div class="col-md-6"> 
                                                <button type="submit" class="ladda-button btn-pill btn btn-info">
                                                    <i class="fa-regular fa-file-excel me-2"></i>
                                                    Import Excel
                                                </button> 
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
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        position: "top-end",
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
                                    url: "{{ route('vac.vaccine_big_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
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

            $('#update_Form').on('submit', function(e) {
                e.preventDefault();
                var form = this; 
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'Up Statment สำเร็จ',
                                text: "You Up Statment data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else {
                            Swal.fire({
                                title: 'UP Statment ซ้ำ',
                                text: "You Up Statment data success",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            });

           


        });
    </script>
@endsection
