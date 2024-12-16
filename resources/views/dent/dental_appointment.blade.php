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

        <div class="card input_new" style="background-color: #fce5f6">
            <div class="card-header ">   
                <form action="{{ route('den.dental_appointment') }}" method="GET">
                    @csrf
                    <div class="row mb-2 ">
                        <div class="col"></div>
                        {{-- <div class="col-md-2"> --}}
                            {{-- <select name="appointment_id" id="appointment_id" class="form-control" style="width: 100%" required>
                                <option class="text-center" value="">-เลือกประเภทการนัด-</option>
                                @foreach ($den_app as $item_app)                                    
                                        <option value="{{$item_app->appointment_id}}">{{$item_app->appointment_name}}</option>                                       
                                @endforeach
                            </select> --}}
                        {{-- </div> --}}

                        <div class="col-md-4 ">                            
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                <input type="text" class="form-control-sm input_new" name="startdate" id="datepicker" placeholder="Start Date"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                                <input type="text" class="form-control-sm input_new" name="enddate" placeholder="End Date" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $enddate }}"/>
                                
                                <button type="submit" class="btn btn-sm btn-primary input_new">
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
                                    <h4 style="color:rgb(206, 29, 147)">รายการนัดคนไข้</h4>  
                                </div>
                                <table class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="example2">
                                    <thead>
                                        <tr style="font-size: 15px;">
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="5%">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="5%">HN</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="10%">เลขบัตรประชาชน</th> 
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);">ชื่อ - นามสกุล</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="10%">เบอร์โทร</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="10%">วันที่นัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="5%">เวลานัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="10%">ประเภทการนัด</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);">ชื่อทันตแพทย์</th> 
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);" width="7%">จัดการ</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;$total1 = 0;  ?>
                                        @foreach ($datashow as $item)                                                        
                                            <tr style="font-size: 15px;">
                                                <th class="text-center"width="1%">{{ $i++ }}</th>
                                                <td class="text-center"width="5%">{{$item->dent_hn}}</td>
                                                <td class="text-center"width="10%">{{$item->dent_patient_cid}}</td>
                                                <td class="text-start">{{$item->dent_patient_name}}</td>
                                                <td class="text-center"width="10%">{{$item->dent_tel}}</td>
                                                <td class="text-center"width="10%">{{DateThai($item->dent_date)}}</td>
                                                <td class="text-center"width="5%">{{$item->dent_time}}</td> 
                                                <td class="text-start" style="color:#4993e7" width="10%">{{$item->appointment_name}}</td>
                                                <td class="text-start">{{$item->dent_doctor_name}}</td>
                                                <td class="text-center" width="7%">
                                                    <a href="{{url('dental_appointment_edit/'.$item->dent_appointment_id)}}" class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="แก้ไขใบตรวจรับ">
                                                        <img src="{{ asset('images/Edit.png') }}" height="25px" width="25px"> 
                                                    </a>
                                                </td>
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
        
    });
</script>

@endsection
 
 