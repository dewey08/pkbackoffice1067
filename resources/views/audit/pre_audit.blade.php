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
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4 class="card-title" style="color:rgb(241, 137, 155)"">CHART APPROVE OFC</h4>
                                </div>
                                <div class="col-md-9 text-end">
                                    {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
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

                                        <button type="button"
                                            class="ladda-button me-2 btn-pill btn btn-primary cardacc Process_A"
                                            data-url="{{ url('pre_audit_process_a') }}">
                                            <i class="fa-solid fa-sack-dolla"></i>
                                            ประมวลผลใหม่
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12"> 
                                    <div class="table-responsive">
                                        {{-- <table id="example4"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">Year</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Visit ทั้งหมด</th>
                                                    <th class="text-center">Debit-Approve</th>
                                                    <th class="text-center">Debit-ไม่ Approve</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $jj = 1; ?>
                                                @foreach ($fdh_ofc as $item)
                                                <?php 
                                                $no_app = DB::connection('mysql')->select(
                                                    'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                                                        ,count(DISTINCT vn) as countvn,sum(debit) as sum_total_no  
                                                        FROM d_fdh WHERE month(vstdate) = "'.$item->months.'" AND year(vstdate) = "'.$item->years.'" 
                                                        AND projectcode ="OFC" AND an IS NULL AND authen IS NULL
                                                        GROUP BY month(vstdate)
                                                    ');  
                                                    foreach ($no_app as $key => $value) {
                                                        $sum_total_no_ = $value->sum_total_no;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                        <td class="text-center" width="10%">{{ $item->years }}</td> 
                                                        @if ($item->months == '1')
                                                        <td class="text-center" width="15%">มกราคม</td> 
                                                        @elseif ($item->months == '2')
                                                            <td class="text-center" width="15%">กุมภาพันธ์</td> 
                                                        @elseif ($item->months == '3')
                                                            <td class="text-center" width="15%">มีนาคม</td> 
                                                        @elseif ($item->months == '4')
                                                            <td class="text-center" width="15%">เมษายน</td> 
                                                        @elseif ($item->months == '5')
                                                            <td class="text-center" width="15%">พฤษภาคม</td> 
                                                        @elseif ($item->months == '6')
                                                            <td class="text-center" width="15%">มิถุนายน</td> 
                                                        @elseif ($item->months == '7')
                                                            <td class="text-center" width="15%">กรกฎาคม</td> 
                                                        @elseif ($item->months == '8')
                                                            <td class="text-center" width="15%">สิงหาคม</td> 
                                                        @elseif ($item->months == '9')
                                                            <td class="text-center" width="15%">กันยายน</td> 
                                                        @elseif ($item->months == '10')
                                                            <td class="text-center" width="15%">ตุลาคม</td> 
                                                        @elseif ($item->months == '11')
                                                            <td class="text-center" width="15%">พฤษจิกายน</td> 
                                                        @else
                                                            <td class="text-center" width="15%">ธันวาคม</td> 
                                                        @endif
                                                        <td class="text-center text-success" width="20%">
                                                            {{ $item->countvn }} Visit
                                                           
                                                        </td>
                                                        <td class="text-center" width="20%" style="color:rgb(22, 168, 132)">{{ number_format($item->sum_total, 2) }}</td> 
                                                        <td class="text-center" width="20%" style="color:rgb(252, 73, 42)">
                                                            <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-danger"
                                                            href="{{ url('pre_audit_approve_detail/' . $item->months . '/' . $item->years) }}" >
                                                            {{ number_format($sum_total_no_, 2) }}
                                                        </a>
                                                           
                                                        </td> 
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table> --}}
                                    </div>
                                </div>
                            </div>
 
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">CHART รายการที่ไม่ลง Approve เดือนนี้</h4>  
                                <div class="table-responsive">                           
                                     
                                </div>

                        </div>
                    </div>
                </div> 
            </div>
            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body">
                          
                        </div>
                    </div>
                </div> 
            </div> --}}
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

            $('.Process_A').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val();
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
                            url: "{{ route('audit.pre_audit_process_a') }}",
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
                                            $('#spinner')
                                        .hide(); //Request is complete so hide spinner
                                            setTimeout(function() {
                                                $("#overlay").fadeOut(
                                                    300);
                                            }, 500);
                                        }
                                    })
                                } else {
                                   
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "warning",
                                        title: "ยังไม่ได้เลือกวันที่",
                                        showCancelButton: false,
                                        confirmButtonColor: '#ed8d29',
                                        confirmButtonText: 'เลือกใหม่'
                                        // timer: 1500
                                    }).then((result) => {
                                        if (result
                                            .isConfirmed) {
                                            window.location.reload();
                                        }
                                    })

                                }
                            },
                        });

                    }
                })
            });

           


        });
    </script>
@endsection
