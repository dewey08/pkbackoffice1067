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
                                <a href="{{ url('dental_appointment') }}" class="mb-1 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">แก้ไขข้อมูลการนัด</a>
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
