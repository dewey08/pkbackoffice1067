@extends('layouts.dentals')
@section('title', 'PK-OFFICER || ทันตกรรม')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #fcdcf5 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
           }
</style>
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<?php
if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน 
?>
  
<div class="tabs-animation">
    
        <div class="row text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-header">   
                <form action="{{ route('den.dental_report_appointment') }}" method="GET">
                    @csrf
                    <div class="row mb-2">
                        <div class="col"></div>
                        <div class="col-md-2">
                            <select name="appointment_id" id="appointment_id" class="form-control" style="width: 100%" required>
                                <option class="text-center" value="">-เลือกประเภทการนัด-</option>
                                @foreach ($den_app as $item_app)                                    
                                        <option value="{{$item_app->appointment_id}}">{{$item_app->appointment_name}}</option>                                       
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">                            
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $enddate }}"/>
                                
                                <button type="submit" class="btn btn-primary">
                                    <img src="{{ asset('images/Search02.png') }}" class="ms-2 me-2" height="23px" width="23px"> 
                                    ค้นหา
                                </button>
                            </div> 
                        </div>
                        <div class="col"></div>
                    </div>
                </form>                           
                
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('t.time_nurs_dep') }}" method="POST">
                                @csrf
                            </form>  
                            <div class="table-responsive mt-3">
                                <div class="col-md-12 text-center" >  
                                    <h4 style="color:rgb(206, 29, 147)">รายงานการนัดคนไข้ แยกประเภทการนัด</h4>  
                                </div>
                                <table class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%; id="example2">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="5%">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">HN</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">เลขบัตรประชาชน</th> 
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">ชื่อ - นามสกุล</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">เบอร์โทร</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">วันที่นัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">เวลานัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">ประเภทการนัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 15px;" width="10%">ชื่อทันตแพทย์</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;$total1 = 0;  ?>
                                        @foreach ($datashow as $item)                                                        
                                            <tr>
                                                <th class="text-center"width="1%">{{ $i++ }}</th>
                                                <td class="text-center"width="5%">{{$item->dent_hn}}</td>
                                                <td class="text-center"width="5%">{{$item->dent_patient_cid}}</td>
                                                <td class="text-center"width="5%">{{$item->dent_patient_name}}</td>
                                                <td class="text-center"width="5%">{{$item->dent_tel}}</td>
                                                <td class="text-center"width="2%">{{DateThai($item->dent_date)}}</td>
                                                <td class="text-center"width="3%">{{$item->dent_time}}</td> 
                                                <td class="text-center"width="5%">{{$item->appointment_name}}</td>
                                                <td class="text-center"width="1%">{{$item->dent_doctor_name}}</td> 
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </p>
                    </div>
                     
                </div>
            </div>
            
        </div>
</div> 
      
@endsection
@section('footer')
<script>
    function switchactive(idfunc){
            // var nameVar = document.getElementById("name").value;
            var checkBox = document.getElementById(idfunc);
            var onoff;
            
            if (checkBox.checked == true){
                onoff = "Y";
            } else {
                onoff = "N";
            }
 
            var _token=$('input[name="_token"]').val();
                $.ajax({
                        url:"{{route('den.dental_switchactive')}}",
                        method:"GET",
                        data:{onoff:onoff,idfunc:idfunc,_token:_token}
                })
       }
</script>
<script>
    
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#datepicker3').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker4').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        // $('#HR_DEPARTMENT_ID').select2({
        //         placeholder: "--เลือก--",
        //         allowClear: true
        //     });
        // $('#HR_DEPARTMENT_SUB_ID').select2({
        //         placeholder: "--เลือก--",
        //         allowClear: true
        //     });
        // $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
        //     placeholder: "--เลือก--",
        //     allowClear: true
        // });

        // $("#spinner-div").hide(); //Request is complete so hide spinner

        // $('#Savetime').click(function() {
        //     var startdate = $('#datepicker').val();
        //     var enddate = $('#datepicker2').val();
        //     var HR_DEPARTMENT_SUB_ID = $('#HR_DEPARTMENT_SUB_ID').val();
        //     var HR_DEPARTMENT_SUB_SUB_ID = $('#HR_DEPARTMENT_SUB_SUB_ID').val(); 
        //     $.ajax({
        //         url: "{{ route('t.time_index_excel') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             startdate,
        //             enddate,
        //             HR_DEPARTMENT_SUB_ID,
        //             HR_DEPARTMENT_SUB_SUB_ID
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

        //                         window.location
        //                             .reload();
        //                     }
        //                 })
        //             } else {

        //             }

        //         },
        //     });
        // });  
    });
</script>
{{-- <script>
    $('.department').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.department')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });

    $('.department_sub').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.departmenthsub')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });
</script> --}}
@endsection
 
 