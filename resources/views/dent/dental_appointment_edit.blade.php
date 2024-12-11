@extends('layouts.dentals')
@section('title', 'PK-OFFICER || ทันตกรรม')
@section('content')
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
        border-top: 10px #1fdab1 solid;
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
</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;


$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();

?>

@section('content')



{{-- <div class="container" style="width: 97%"> --}}
    <div class="row ">
        <div class="col-md-12">
            <div class="card card_prs_4" >

                <div class="card-header">
                    <div class="d-flex">
                        <div class="">
                            <label for="">เพิ่มรายการนัด </label>
                        </div>
                        <div class="ms-auto">

                        </div>
                    </div>
                </div>

                <div class="card-body shadow-lg">
                    {{-- <form class="custom-validation" action="{{ route('den.dental_appointment_save') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf --}}
                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <div class="row">

                            <div class="col-md-12">
                                <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->

                                <div class="row">
                                    <div class="col-md-1 text-end">
                                        <label for="dent_hn">HN :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">{{$dent_edit->dent_hn}}</label> 
                                            <input type="hidden" id="dent_hn" name="dent_hn" class="form-control" value="{{$dent_edit->dent_hn}}"/>
                                            {{-- <input type="text" class="form-control-sm input_border" id="dent_hn" name="dent_hn" value="{{ $dent_edit->dent_hn }}" style="width: 100%" readonly> --}}
                                            {{-- <select id="dent_hn" name="dent_hn" class="form-control-sm d12font input_new" style="width: 100%" onchange="hnDent()">
                                                <option value="">--เลือก--</option>
                                                @foreach ($hn as $ph)
                                                    
                                                    <option value="{{ $ph->hn }}"> {{ $ph->hn }}</option> 
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <label for="" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:13px">CID :</label>
                                    </div>
                                    <div class="col-md-2">       
                                        <label for="">{{$dent_edit->dent_patient_cid}}</label>                   
                                        {{-- <div id="show_detailpatient" ></div>  --}}
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <label for="" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:13px">ข้อมูลคนไข้ :</label>
                                    </div>
                                    <div class="col-md-2">       
                                        <label for="">{{$dent_edit->dent_patient_name}}</label>                   
                                        {{-- <div id="show_detailpatient" ></div>  --}}
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <label for="" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:13px">เบอร์โทร :</label>
                                    </div>
                                    <div class="col-md-2">       
                                        <label for="">{{$dent_edit->dent_tel}}</label>                   
                                        {{-- <div id="show_detailpatient" ></div>  --}}
                                    </div>
                                                                        
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-1 text-end">
                                        <label for="dent_date">วันที่นัด :</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control-sm input_new" name="datepicker" id="datepicker" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $dent_edit->dent_date }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 text-end">
                                        <label for="dent_time">เวลานัด :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="time" id="dent_time" name="dent_time" class="form-control-sm input_new" placeholder="" value="{{ $dent_edit->dent_time }}" style="width: 100%" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 text-end">
                                            <label for="dent_doctor">ทันตแพทย์ผู้นัด :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="dent_doctor" name="dent_doctor" class="form-control-sm d12font input_new" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($users as $ue)
                                                        @if ($dent_edit->dent_doctor == $ue->id)
                                                        <option value="{{ $ue->id }}" selected> {{ $ue->fname }} {{ $ue->lname }}</option>
                                                        @else
                                                        <option value="{{ $ue->id }}"> {{ $ue->fname }} {{ $ue->lname }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                <div class="row mt-2">
                                    <div class="col-md-1 text-end">
                                        <label for="appointment">ประเภทการนัด :</label>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select id="appointment" name="appointment" class="form-control-sm d12font input_new" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($appointment as $ap)
                                                @if ($dent_edit->appointment_id == $ap->appointment_id)
                                                    <option value="{{ $ap->appointment_id }}"selected>{{ $ap->appointment_name }}</option>
                                                @else
                                                    <option value="{{ $ap->appointment_id }}"> {{ $ap->appointment_name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  

                                    <div class="col-md-1 text-end">
                                        <label for="dent_work">งาน :</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <input id="dent_work" type="text" class="form-control-sm d12font input_new" name="dent_work" value="{{ $dent_edit->dent_work }}" style="width: 100%">
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <input type="hidden" id="dent_appointment_id" name="dent_appointment_id" value="{{$dent_edit->dent_appointment_id}}">                            

                            </div>
                        </div>
                </div>

                
                {{-- </form> --}}

                <div class="card-footer">
                    <div class="col-md-12 text-end">

                        <div class="form-group">

                            <button type="button" id="UpdateData" class="btn btn-primary btn-sm">
                                <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                บันทึกข้อมูล
                            </button>

                            <a href="{{ url('dental_appointment') }}" class="btn btn-danger btn-sm">
                                <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                ยกเลิก
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
{{-- </div> --}}


@endsection
@section('footer')
<script>
     function hnDent() {

        // alert('ใส่ข้อความที่ต้องการ');
            var denthn = document.getElementById("dent_hn").value;
                // var supplies_tax = document.getElementById("supplies_tax").value;
                // alert(denthn);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('dental_detail_patient')}}",
                    method: "GET",
                    data: {
                        denthn: denthn,
                        _token: _token
                    },
                    success: function (result) {
                        
                        $('#show_detailpatient').html(result);
                    }
                })
        }
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　       

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        // ช่องค้นหาชื่อทันตแพทย์
        $('#dent_doctor').select2({
            placeholder: "--เลือก--",
            allowClear: true
            });

        // ช่องค้นหาHN
            // $('#dent_hn').select2({
            // placeholder: "--ค้นหา HN--",
            // allowClear: true
            // });
            
        // ช่องค้นหาประเภทการนัด
        $('#appointment').select2({
            placeholder: "--เลือกประเภทการนัด--",
            allowClear: true
        }); 

        $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

        $('#UpdateData').click(function() {
            var dent_hn             = $('#dent_hn').val(); 
            var dent_date           = $('#datepicker').val(); 
            var dent_time           = $('#dent_time').val();                  
            var appointment_id      = $('#dent_appointment_id').val();
            var dent_doctor         = $('#dent_doctor').val();
            var dent_work           = $('#dent_work').val();
            var appointment         = $('#appointment').val();
            

            Swal.fire({ 
                    title: 'ต้องการแก้ไขข้อมูลแม่นบ่ ?',
                    // text: "You Warn Add Bill No!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'แม่น !!!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#overlay").fadeIn(300);　
                            $("#spinner").show(); //Load button clicked show spinner 
                            
                            $.ajax({
                                url: "{{ route('den.dental_appointment_update') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {dent_hn,dent_date,dent_time,dent_work,appointment_id,dent_doctor,appointment},
                                success: function(data) {
                                    if (data.status == 200) { 
                                        Swal.fire({ position: "top-center",
                                            title: 'แก้ไขข้อมูลสำเร็จ',
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
                                                // window.location.reload();
                                                window.location="{{url('dental_appointment')}}"; 
                                                $('#spinner').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                            }
                                        })
                                    } else {

                                        Swal.fire({
                                                title: "แก้ไขเรียบร้อย!",
                                                // text: "You clicked the button!",
                                                icon: "success"
                                                });


                                        
                                    }
                                },
                            });
                            
                        }
            })
        });
            
            // $('#SaveData').click(function() {
            //     var dent_hn             = $('#dent_hn').val();                 
            //     var dent_date           = $('#datepicker').val(); 
            //     var dent_time           = $('#dent_time').val(); 
            //     var appointment      = $('#appointment').val();
            //     // var appointment_name    = $('#appointment_name').val();  
            //     var dent_doctor         = $('#dent_doctor').val();
            //     var dent_work      = $('#dent_work').val();                  

            //     Swal.fire({ position: "center",
            //             title: 'ต้องการเพิ่มข้อมูลใช่ไหม ?',
            //             text: "You Warn Add Data !!!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'ตกลง, เพิ่มเลย!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $("#overlay").fadeIn(300);　
            //                     $("#spinner").show(); //Load button clicked show spinner 
                                
            //                     $.ajax({
            //                         url: "{{ route('den.dental_appointment_save') }}",
            //                         type: "POST",
            //                         dataType: 'json',
            //                         data: {dent_hn,dent_date,dent_time,appointment,dent_doctor,dent_work},
            //                         success: function(data) {
            //                             if (data.status == 200) { 
            //                                 Swal.fire({ position: "center",
            //                                     title: 'เพิ่มข้อมูลสำเร็จ',
            //                                     text: "คุณเพิ่มข้อมูลสำเร็จแล้ว",
            //                                     icon: 'success',
            //                                     showCancelButton: false,
            //                                     confirmButtonColor: '#06D177',
            //                                     confirmButtonText: 'เรียบร้อย'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         // window.location.reload();
            //                                         window.location = "{{url('dental_calendar')}}"; 
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                     }
            //                                 })
            //                             } else {
            //                                 Swal.fire({
            //                                     icon: "error",
            //                                     title: "Oops...บ่มี HN",
            //                                     text: "ใส่ HN ก่อนแหน่จ้า!",
            //                                     // footer: '<a href="#">Why do I have this issue?</a>'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         // window.location.reload();
            //                                         window.location = "{{url('dental_calendar')}}"; 
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                     }
            //                                 })
            //                             }
            //                         },
            //                     });
                                
            //                 }
            //     })
            // });
    });
</script>

@endsection