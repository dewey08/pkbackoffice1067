@extends('layouts.dentals')
@section('title', 'PK-OFFICE || ทันตกรรม')
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
{{-- <style>
    .btn {
        font-size: 15px;
    }
    .bgc {
        background-color: #264886;
    }
    .bga {
        background-color: #fbff7d;
    }
</style> --}}
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
        border-top: 10px #d22cf3 solid;
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


        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card cardot">
                    <div class="card-header">                         
                        <div class="btn-actions-pane-right">
                            <div class="col-md-12 text-end">
                                <a href="{{ url('dental_appointment_add') }}" class="mb-1 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูลนัดหมาย</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="card">
                            
                            <div class="panel-body bg-white">

                                <div id='calendar'> </div>

                            </div>
                            
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ShowData -->
    {{-- <div class="modal fade" id="showDocumentModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <div class="row"> 
                        <div class="col-md-8">
                            <h4 class="modal-title" id="editModalLabel" style="color:rgb(248, 28, 83)">คู่มือการใช้งาน</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="form-group"> 
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark me-2"></i>Close
                                </button> 
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-body"> 
                    <img src="{{ asset('images/doc/doc_01.png') }}" class="rounded" alt="Image" width="auto" height="700px"> 
                    <br><br><br> 
                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
                    <br><br><br> 
                    <img src="{{ asset('images/doc/doc_02.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>
                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_03.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>

                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_04.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>

                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_05.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>

                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_06.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>

                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_07.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>

                    <hr style="color: red;border: blueviolet">
                    <hr style="color: red;border: blueviolet">
        
                    <img src="{{ asset('images/doc/doc_08.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                    <br><br><br>
                    
                </div>              
                <div class="modal-footer">                   
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="appointmentModal{{ $item->dent_appointment_id }}" tabindex="-1" aria-labelledby="appointmentModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModal">
                        รายละเอียดข้อมูลการนัดคนไข้ทันตกรรม
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2 ">
                            <p for=""><b>วันที่นัด :</b></p>
                        </div>
                        <div class="col-md-4">
                            <p for="dent_date">{{ DateThai($item->dent_date) }}</p>
                        </div>                                                               
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label for=""><b>เวลานัด :</b></label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p
                                    for="dent_time">{{ $item->dent_time }}</p>
                            </div>
                        </div>

                        <div class="col-md-2 ">
                            <label for=""><b>HN :</b></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label
                                    for="dent_hn">{{ $item->dent_hn }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label for=""><b>ชื่อ-นามสกุล :</b></label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label
                                    for="dent_patient_name">{{ $item->dent_patient_name }}</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for=""><b>เบอร์โทร :</b></label>
                        </div>                                                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label
                                    for="dent_tel">{{ $item->dent_tel }}</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="row  mt-3">
                        <div class="col-md-12">
                       
                                    <?php   
                                            $j = 1;
                                            $data_ = DB::connection('mysql')->select('
                                                    SELECT *
                                                    FROM dent_appointment
                                                    WHERE dent_appointment_id = "'.$item->dent_appointment_id.'"
                                            ');
                                    ?>
                                  
                            <div class="row ">
                                <div class="col-md-1 text-center">ลำดับ</div>
                                <div class="col-md-4 text-center">รายการพารามิเตอร์</div>
                                <div class="col-md-1 text-center">หน่วย</div>
                                <div class="col-md-2 text-center">ผลการวิเคราะห์</div>                                                                       
                                <div class="col-md-2 text-center">ค่ามาตรฐาน</div>
                            </div>
                            @foreach ($data_ as $item2)
                            <hr>
                            <div class="row">
                                <div class="col-md-1 text-center">{{$j++}}</div>
                                <div class="col-md-4">{{$item2->water_list_detail}}</div>
                                <div class="col-md-1 text-center">{{$item2->water_list_unit}}</div>
                                <div class="col-md-2 text-center">{{$item2->water_qty}}</div>
                                <div class="col-md-2 ">{{$item2->water_results}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

         
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger btn-sm"
                        data-bs-dismiss="modal" id="closebtn">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ปิด
                    </button>
                </div>

            </div>
        </div>
    </div>  --}}
    {{-- <div class="modal fade" id="dentalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        ลงเวลาโอที
                    </h5>
                    <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-circle-info text-white"></i>
                        รายละเอียด
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Collapsed content -->
                    <div class="collapse mt-1 mb-2" id="collapseExample">
                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_detail">เหตุผล </label>
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="form-outline">
                                    <input id="ot_one_detail" type="text" class="form-control input-rounded"
                                        name="ot_one_detail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_starttime">ตั้งแต่เวลา </label>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <input id="ot_one_starttime" type="time" class="form-control input-rounded" name="ot_one_starttime">
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_endtime">ถึงเวลา </label>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <input id="ot_one_endtime" type="time" class="form-control input-rounded"
                                        name="ot_one_endtime">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="saveBtn" class="btn btn-info btn-sm me-2">
                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-danger btn-sm me-2" data-bs-dismiss="modal" id="closebtn">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ปิด
                    </button>
                </div>

            </div>
        </div>
    </div> --}}
    
    </div>

@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {

                var showcalendar = @json($events);

                $('#calendar').fullCalendar({
                    // timeZone: 'Asia/Bangkok',                    

                    header: {
                        left: 'prev,next today', //  prevYear nextYea
                        
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },

                    // editable: true,
                    selectable: true,
                    selectHelper: true,
                    
                    events: showcalendar,
                    select: function(start, end, allDays) {
                        $('#dentalModal').modal('toggle');
                        

                        var start_date = moment(start).format('YYYY-MM-DD HH:mm','Asia/Bangkok')
                        var end_date = moment(end).format('YYYY-MM-DD HH:mm', 'Asia/Bangkok');                        

                        // $('#saveBtn').click(function() {

                        //     var ot_one_detail    = $('#ot_one_detail').val();
                        //     var ot_one_starttime = $('#ot_one_starttime').val();
                        //     var ot_one_endtime   = $('#ot_one_endtime').val();
                        //     var start_date       = moment(start).format('YYYY-MM-DD', 'UTC');
                        //     var end_date         = moment(end).format('YYYY-MM-DD');
                        //     var signature        = $('#signature').val();
                        //     var user_id          = $('#user_id').val();
                            
                        //     $.ajax({
                        //         url: "{{ route('den.dental_calendarsave') }}",
                        //         type: "POST",
                        //         dataType: 'json',
                        //         data: {
                        //             ot_one_detail,
                        //             ot_one_starttime,
                        //             ot_one_endtime,
                        //             start_date,
                        //             end_date,
                        //             signature,
                        //             user_id

                        //         },
                        //         success: function(data) {

                        //             if (data.status == 200) {
                        //                 Swal.fire({
                        //                     title: 'บันทึกข้อมูลสำเร็จ',
                        //                     text: "You Insert data success",
                        //                     icon: 'success',
                        //                     showCancelButton: false,
                        //                     confirmButtonColor: '#06D177',
                        //                     confirmButtonText: 'เรียบร้อย'
                        //                 }).then((result) => {
                        //                     if (result
                        //                         .isConfirmed) {
                        //                         console.log(
                        //                             data);
                        //                         $('#calendar')
                        //                             .fullCalendar(
                        //                                 'renderEvent', {
                        //                                     'title': data.title,
                        //                                     'start': data .start,
                        //                                     'end': data .end,
                        //                                     'color': data .color
                        //                                 });
                        //                         window.location.reload();
                        //                     }
                        //                 })
                        //             } else {
                                        
                        //             }

                        //             // if (data.status == 100) {
                        //             //     Swal.fire({
                        //             //         title: 'วันนี้ได้ลงไปเรียบร้อยแล้ว',
                        //             //         text: "You have data success",
                        //             //         icon: 'warning',
                        //             //         showCancelButton: false,
                        //             //         confirmButtonColor: '#ff0606',
                        //             //         // cancelButtonColor: '#d33',
                        //             //         confirmButtonText: 'Close'
                        //             //     }).then((result) => {
                        //             //         if (result
                        //             //             .isConfirmed) {
                        //             //             window.location
                        //             //                 .reload();
                        //             //         }
                        //             //     })

                        //             // } else {
                                        
                        //             //     Swal.fire({
                        //             //         title: 'บันทึกข้อมูลสำเร็จ',
                        //             //         text: "You Insert data success",
                        //             //         icon: 'success',
                        //             //         showCancelButton: false,
                        //             //         confirmButtonColor: '#06D177',
                        //             //         confirmButtonText: 'เรียบร้อย'
                        //             //     }).then((result) => {
                        //             //         if (result
                        //             //             .isConfirmed) {
                        //             //             console.log(
                        //             //                 data);
                        //             //             $('#calendar')
                        //             //                 .fullCalendar(
                        //             //                     'renderEvent', {
                        //             //                         'title': data
                        //             //                             .title,
                        //             //                         'start': data
                        //             //                             .start,
                        //             //                         'end': data
                        //             //                             .end,
                        //             //                         'color': data
                        //             //                             .color
                        //             //                     });
                        //             //             window.location
                        //             //                 .reload();
                        //             //         }
                        //             //     })
                        //             // }
                                   

                        //         },
                        //     });
                        // });

                    },
                    

                    
                    selectAllow: function(event) {
                    
                            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
                                
                    },
                });
                $('.fc-event').css('font-size', '12px');
                
            });

        });
    </script>

@endsection