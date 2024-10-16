@extends('layouts.fdh')
@section('title', 'PK-OFFICE || FDH')
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
        border-top: 10px #0ca886 solid;
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

    <form action="{{ url('fdh_mini_dataset_pull') }}" method="GET">
        @csrf
    <div class="row"> 
            <div class="col-md-3">
                <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">Detail Financial Data Hub</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล  FDH MINI DATASET</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-7 text-end">
                {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'> --}}
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control card_fdh_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control card_fdh_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}"/>  
    
                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา 
                </button>  
                    </form> 
                   
                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary card_fdh_4" id="Pulldata">
                        <i class="fa-solid fa-spinner text-primary me-2"></i>
                        ประมวลผล
                    </button>
                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-warning card_fdh_4 Claim" data-url="{{url('fdh_mini_dataset_apicliam')}}">
                        <i class="fa-solid fa-spinner text-warning me-2"></i>
                        Minidataset+EndPoint
                    </button>
                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success card_fdh_4 Claimfdh" data-url="{{url('mini_dataset')}}">
                        <i class="fa-solid fa-spinner text-success me-2"></i>
                        Minidataset
                    </button>
                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger card_fdh_4 Claim_endpoint" data-url="{{url('nhso_endpoint')}}">
                        <i class="fa-solid fa-spinner text-danger me-2"></i>
                        EndPoint
                    </button>
                   
                  
                </div> 
            </div>          
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card_fdh_4">
                     
                    <div class="card-body">
                        <div class="row mb-3">
                            {{-- <div class="col-md-4">
                                <h4 class="card-title">Detail Account</h4>
                                <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
                            </div> --}}
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                <a href="{{url('fdh_mini_dataset_line')}}" class="ladda-button me-2 btn-pill btn btn-info cardacc"><i class="fa-brands fa-line me-2 ms-2" style="font-size: 19px"></i></a>
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardacc Savestamp" data-url="{{url('account_402_stam')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button> --}}
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-danger cardacc Destroystamp" data-url="{{url('fdh_mini_dataset_destroy')}}">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    ลบ
                                </button>
                             
                            </div>
                        </div>
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th width="auto" class="text-center"><input type="checkbox" class="fdhcheckbox" name="stamp" id="stamp"> </th> 
                                    <th class="text-center" width="5%">
                                        <span class="bg-success badge">{{ $count_fdh_y }}</span> FDH
                                        <span class="bg-danger badge">{{ $count_fdh_n }}</span> 
                                    </th>
                                    <th class="text-center" width="5%">
                                        <span class="bg-success badge">{{ $count_nhso_y }}</span> NHSO
                                        <span class="bg-danger badge">{{ $count_nhso_n }}</span> 
                                    </th>
                                    {{-- <th class="text-center" width="7%">สถานะ NHSO</th> --}}
                                    {{-- <th class="text-center" width="7%">vstdate</th> --}}
                                    <th class="text-center" width="10%">service_date</th>
                                    <th class="text-center" width="7%">cid</th>
                                    {{-- <th class="text-center" width="7%">uid</th> --}}
                                    <th class="text-center" width="5%">hn</th>
                                    <th class="text-center" width="5%">pttype</th>
                                    <th class="text-center">ptname</th>
                                    {{-- <th class="text-center" width="5%">hcode</th> --}}
                                    {{-- <th class="text-center" width="5%">amout</th> --}}
                                    {{-- <th class="text-center" width="7%">invoice</th> --}}
                                    {{-- <th class="text-center" width="5%">paidAmount</th> --}}
                                    <th class="text-center" width="5%">totalAmount</th>
                                    <th class="text-center" width="5%">uc_money</th>
                                    <th class="text-center" width="5%">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($fdh_mini_dataset as $item)
                                    <?php $number++; ?>

                                        <tr height="20" >
                                            <td class="text-center" width="5%">{{ $number}}</td>
                                            @if ($item->invoice_number == '' )
                                            <td class="text-center" width="5%">
                                                <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                            </td> 
                                            @else
                                                <td class="text-center" width="5%"><input type="checkbox" class="fdhcheckbox sub_chk" data-id="{{$item->fdh_mini_dataset_id}}"> </td> 
                                            @endif 
                                            <td class="text-center" width="5%"> 
                                                @if ($item->active == 'Y')
                                                    <span class="bg-success badge">{{ $item->active }}</span> 
                                                @else
                                                    <span class="bg-danger badge">{{ $item->active }}</span> 
                                                @endif                                               
                                            </td>
                                            <td class="text-center" width="5%"> 
                                                @if ($item->active_nhso == 'Y')
                                                    <span class="bg-success badge">{{ $item->active_nhso }}</span> 
                                                @else
                                                    <span class="bg-danger badge">{{ $item->active_nhso }}</span> 
                                                @endif 
                                            </td>
                                            {{-- <td class="text-center" width="7%">{{ $item->dataError }}</td> --}}
                                           {{-- <td class="text-center" width="7%">{{ $item->vstdate }}</td> --}}
                                            <td class="text-center" width="10%">{{ $item->service_date_time }}</td>
                                            <td class="text-center" width="7%">{{ $item->cid }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item->transaction_uid }}</td> --}}
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                            <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                            <td class="p-2">{{ $item->ptname }}</td>
                                            {{-- <td class="text-center" width="5%">{{ $item->hcode }}</td> --}}
                                            {{-- <td class="text-center" width="7%">{{ $item->total_amout }}</td> --}}
                                            {{-- <td class="text-center" width="7%">{{ $item->invoice_number }}</td> --}}
                                            {{-- <td class="text-center" width="5%">{{ $item->rcpt_money }}</td> --}}
                                            <td class="text-center" width="5%">{{ $item->totalAmount }}</td>
                                            <td class="text-center" width="5%">{{ $item->uc_money}}</td>
                                            <td class="text-center" width="5%">{{ $item->ovstost}}</td>
                                        </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Check Auth</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">@Username</span>
                        </div>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <br>
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            <span class="">@Password</span>
                        </div>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="AuthSave">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
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
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
        });
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        // $('#example').DataTable();
        $('#hospcode').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
        });   
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#spinner-div").hide(); //Request is complete so hide spinner
       
        $('.Claim').on('click', function(e) {
            // alert('oo');
            var allValls = [];
            // $(".sub_destroy:checked").each(function () {
            $(".sub_chk:checked").each(function () {
                allValls.push($(this).attr('data-id'));
            });
            if (allValls.length <= 0) {
                // alert("SSSS");
                Swal.fire({
                    title: 'คุณยังไม่ได้เลือกรายการ ?',
                    text: "กรุณาเลือกรายการก่อน",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33', 
                    }).then((result) => {
                    
                    })
            } else {
                Swal.fire({
                    title: 'Are you Want Send sure?',
                    text: "คุณต้องการ Send รายการนี้ใช่ไหม!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Send it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                // alert(join_selected_values);
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 

                                $.ajax({
                                    url:$(this).data('url'),
                                    type: 'POST',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: 'ids='+join_selected_values,
                                    success:function(data){ 
                                            if (data.status == 200) {
                                               
                                                $(".sub_chk:checked").each(function () {
                                                    $(this).parents("tr").remove();
                                                });
                                                Swal.fire({
                                                    position: "top-end",
                                                    title: 'ส่งข้อมูลสำเร็จ',
                                                    text: "You Send data success",
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
                                            } else if (data.status == 100) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 400) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 900) {
                                                Swal.fire({
                                                    title: 'ข้อมูลในระบบไม่เจอ',
                                                    text: "Found information in the system.",
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
                                                    }
                                                })
                                            } else {
                                                
                                            } 
                                        } 
                                    
                                });
                                $.each(allValls,function (index,value) {
                                    $('table tr').filter("[data-row-id='"+value+"']").remove();
                                });
                            }
                        }
                    }) 
                // var check = confirm("Are you want ?");  
            }
        });


        // FDH
        $('.Claimfdh').on('click', function(e) {
            // alert('oo');
            var allValls = [];
            // $(".sub_destroy:checked").each(function () {
            $(".sub_chk:checked").each(function () {
                allValls.push($(this).attr('data-id'));
            });
            if (allValls.length <= 0) {
                // alert("SSSS");
                Swal.fire({
                    title: 'คุณยังไม่ได้เลือกรายการ ?',
                    text: "กรุณาเลือกรายการก่อน",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33', 
                    }).then((result) => {
                    
                    })
            } else {
                Swal.fire({
                    title: 'Are you Want Send sure?',
                    text: "คุณต้องการ Send รายการนี้ใช่ไหม!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Send it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                // alert(join_selected_values);
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 

                                $.ajax({
                                    url:$(this).data('url'),
                                    type: 'POST',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: 'ids='+join_selected_values,
                                    success:function(data){ 
                                            if (data.status == 200) {
                                               
                                                $(".sub_chk:checked").each(function () {
                                                    $(this).parents("tr").remove();
                                                });
                                                Swal.fire({
                                                    position: "top-end",
                                                    title: 'ส่งข้อมูลสำเร็จ',
                                                    text: "You Send data success",
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
                                            } else if (data.status == 100) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 400) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 900) {
                                                Swal.fire({
                                                    title: 'ข้อมูลในระบบไม่เจอ',
                                                    text: "Found information in the system.",
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
                                                    }
                                                })
                                            } else {
                                                
                                            } 
                                        } 
                                    
                                });
                                $.each(allValls,function (index,value) {
                                    $('table tr').filter("[data-row-id='"+value+"']").remove();
                                });
                            }
                        }
                    }) 
                // var check = confirm("Are you want ?");  
            }
        });

        // Claim_endpoint
        $('.Claim_endpoint').on('click', function(e) {
            // alert('oo');
            var allValls = [];
            // $(".sub_destroy:checked").each(function () {
            $(".sub_chk:checked").each(function () {
                allValls.push($(this).attr('data-id'));
            });
            if (allValls.length <= 0) {
                // alert("SSSS");
                Swal.fire({
                    title: 'คุณยังไม่ได้เลือกรายการ ?',
                    text: "กรุณาเลือกรายการก่อน",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33', 
                    }).then((result) => {
                    
                    })
            } else {
                Swal.fire({
                    title: 'Are you Want Send sure?',
                    text: "คุณต้องการ Send รายการนี้ใช่ไหม!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Send it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                // alert(join_selected_values);
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 

                                $.ajax({
                                    url:$(this).data('url'),
                                    type: 'POST',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: 'ids='+join_selected_values,
                                    success:function(data){ 
                                            if (data.status == 200) {
                                               
                                                $(".sub_chk:checked").each(function () {
                                                    $(this).parents("tr").remove();
                                                });
                                                Swal.fire({
                                                    position: "top-end",
                                                    title: 'ส่งข้อมูลสำเร็จ',
                                                    text: "You Send data success",
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
                                            } else if (data.status == 100) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 400) {
                                                Swal.fire({
                                                    title: 'พบข้อมูลการจองเคลมซ้ำในระบบ',
                                                    text: "Found duplicate claim booking information in the system.",
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
                                                    }
                                                })
                                            } else if (data.status == 900) {
                                                Swal.fire({
                                                    title: 'ข้อมูลในระบบไม่เจอ',
                                                    text: "Found information in the system.",
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
                                                    }
                                                })
                                            } else {
                                                
                                            } 
                                        } 
                                    
                                });
                                $.each(allValls,function (index,value) {
                                    $('table tr').filter("[data-row-id='"+value+"']").remove();
                                });
                            }
                        }
                    }) 
                // var check = confirm("Are you want ?");  
            }
        });

        $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
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
                                    url: "{{ route('fdh.fdh_mini_dataset_pullnoinv') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ประมวลผลสำเร็จ',
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



        });

        $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการลบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    // $("#overlay").fadeIn(500);　
                                    $("#spinner").show(); //Load button clicked show spinner 

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
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
                                                 
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
                    // var check = confirm("Are you want ?");  
                }
            });
 
    </script>
@endsection
