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

    <div class="row">
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(250, 128, 124)">รายงานจำนวนผู้ป่วยนอกที่ได้รับให้บริการฟื้นฟู</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit</p>
        </div>
        <div class="col"></div>  
        </div>
    </div>
  
    <div class="row">
        <div class="col-xl-12">
            {{-- <h5>รายงานจำนวนผู้ป่วย</h5> --}}
                <div class="card card_audit_4">
                    <div class="card ">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">เลขบัตร</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">สิทธฺิ</th> 
                                    <th class="text-center">รายการ</th> 
                                    <th class="text-center">จำนวน</th>  
                                    <th class="text-center">ผู้เบิก</th>  
                                    <th class="text-center">ชดเชย</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($kayapap_jitvs_spsch as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->hn}}</td>                                     
                                        <td width="15%" class="text-center">{{ $item->vstdate}}</td>
                                        <td class="text-center"> {{$item->cid}}</td>
                                        <td class="p-2">{{ $item->fullname}}</td>
                                        <td class="text-center">{{ $item->pttype}}</td>
                                        <td class="text-center">{{ $item->detail}}</td> 
                                        <td class="text-center">{{ $item->qty}}</td>
                                        <td class="text-center">{{ $item->price}}</td> 
                                        <td class="text-center">{{ $item->nhso_ownright_name}}</td> 
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





@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();

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
