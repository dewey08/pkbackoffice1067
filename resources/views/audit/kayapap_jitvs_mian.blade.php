@extends('layouts.audit')
@section('title', 'PK-OFFICE || งานจิตเวชและยาเสพติด')
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
 
    <form action="{{ route('pt.kayapap_jitvs_mian') }}" method="GET">
                 
        @csrf
    <div class="row">
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(250, 128, 124)">รายงานจำนวนผู้ป่วยนอกที่ได้รับให้บริการฟื้นฟู</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit</p>
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
            <button type="submit" class="ladda-button btn-pill btn btn-primary card_audit_4" data-style="expand-left">
                <span class="ladda-label"><i class="fa-solid fa-magnifying-glass text-white me-2"></i></i>ค้นหา</span>
                <span class="ladda-spinner"></span>
            </button>
            
        </div>
        </div>
    </div>
</form>
        
    </div>

    <div class="row">
        <div class="col-xl-12">
            {{-- <h5>รายงานจำนวนผู้ป่วยนอกที่ได้รับให้บริการฟื้นฟู</h5> --}}
            <div class="card card_audit_4">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">ครั้ง</th>
                                    <th class="text-center">ข้อมูลการคีย์ เบิก สปสช</th>
                                    <th class="text-center">ยังไม่คีย์ เบิก สปสช</th>
                                    <th class="text-center">ค่ารักษา HOSxP</th> 
                                    <th class="text-center">ชดเชยจาก สปสช</th> 
                                    <th class="text-center">ร้อยละ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($kayapap_jitvs as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->year}}</td>

                                        @if ($item->months == '1')
                                                <td width="15%" class="text-center">มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td width="15%" class="text-center">กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td width="15%" class="text-center">มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td width="15%" class="text-center">เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td width="15%" class="text-center">พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td width="15%" class="text-center">มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td width="15%" class="text-center">กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td width="15%" class="text-center">สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td width="15%" class="text-center">กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td width="15%" class="text-center">ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td width="15%" class="text-center">พฤษจิกายน</td>
                                            @else
                                                <td width="15%" class="text-center">ธันวาคม</td>
                                            @endif  
                                       
                                        <td class="text-center">
                                            <a href="{{url('kayapap_jitvs_vn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->VN}}</a>  
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('kayapap_jitvs_spsch/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->spsch}}</a>  
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('kayapap_jitvs_nokey/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->nokey}}</a> 
                                        </td>
                                        <td class="text-center">{{ $item->incomhos}}</td>
                                        <td class="text-center">{{ $item->chod}}</td>
                                        <td class="text-center">{{ $item->percen}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                                @foreach ($total as $item2)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-end">รวมทั้งหมด</td>
                                        <td class="text-center">{{$item2->VNN}}</td>
                                        <td class="text-center">{{$item2->spschh}}</td>
                                        <td class="text-center">{{$item2->nokeyy}}</td>
                                        <td class="text-center">{{$item2->incomhoss}}</td>
                                        <td class="text-center">{{$item2->chodd}}</td>
                                        <td class="text-center">{{$item2->percenn}}</td>
                                    </tr>
                                @endforeach
                        </table>
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

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#checkBtn').click(function() {

                var pang_id = $('#pang_id').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                // alert(enddate);
                $.ajax({
                    url: "{{ route('acc.checksit_admit_spsch') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        pang_id,
                        startdate,
                        enddate
                    },
                    success: function(data) {
                        // if (data.status == 200) { 
                        //     Swal.fire({
                        //         title: 'บันทึกข้อมูลสำเร็จ',
                        //         text: "You Insert data success",
                        //         icon: 'success',
                        //         showCancelButton: false,
                        //         confirmButtonColor: '#06D177',
                        //         confirmButtonText: 'เรียบร้อย'
                        //     }).then((result) => {
                        //         if (result
                        //             .isConfirmed) {
                        //             console.log(
                        //                 data);

                        //             window.location
                        //                 .reload();
                        //         }
                        //     })
                        // } else {

                        // }

                    },
                });
            });

        });
    </script>

@endsection
