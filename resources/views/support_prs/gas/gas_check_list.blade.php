@extends('layouts.support_prs_gas')
@section('title', 'PK-OFFICE || ก๊าซทางการแพทย์')
 
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
    
    <div class="tabs-animation">
        {{-- <div class="row text-center">
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
        </div> --}}
        <div id="preloader">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="2.5" 
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>

       
        <div class="row"> 
            <div class="col-md-4">
                {{-- <h4 class="card-title" style="color:rgb(10, 151, 85)">REPORT FIRE </h4> --}}
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
                <h4 style="color:rgb(255, 255, 255)">บันทึกการตรวจสอบก๊าซทางการแพทย์</h4>
                {{-- <p class="card-title-desc" style="font-size: 17px;">บันทึกการตรวจสอบ</p> --}}
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end">
                <form action="{{ url('gas_check_list') }}" method="GET">
                    @csrf
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bt_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control bt_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary bt_prs" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                    </form> 
              
                {{-- <a href="{{url('fire_insert_all')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-info bt_prs"> 
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                    Check
                </a>  --}}
            </div>
        </div>
    </div>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body"> 
                        <div class="table-responsive">    
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                       
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center">วันที่ตรวจ</th>  
                                            <th class="text-center">เวลา</th> 
                                            <th class="text-center">รหัสถังก๊าซทางการแพทย์</th>  
                                            <th class="text-center">ตัวถัง</th>
                                            <th class="text-center">วาลว์</th> 
                                            <th class="text-center">แรงดัน</th>  

                                            <th class="text-center" >รายการชำรุด</th> 
                                            <th class="text-center" width="10%">ผู้ตรวจ</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->gas_list_num}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ Datethai($item->check_date) }}</td> 
                                                <td class="text-center" width="7%" style="font-size: 12px">{{ $item->check_time }}</td> 
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ $item->gas_list_num }}</td>  
                                                <td class="text-center" width="9%"> 
                                                    @if ($item->gas_check_body == '0') 
                                                         <img src="{{asset('images/true_sm_50.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif
                                                </td>  
                                                <td class="text-center" width="9%"> 
                                                    @if ($item->gas_check_valve == '0') 
                                                        <img src="{{asset('images/true_sm_50.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif
                                                </td>   
                                                <td class="text-center" width="9%"> 
                                                    @if ($item->gas_check_pressure == '0') 
                                                        <img src="{{asset('images/true_sm_50.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="25px" width="25px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif
                                                </td>   
                                               
                                                <td class="text-start" style="color:rgb(73, 147, 231)">
                                                    @if ($item->gas_check_body == '0' || $item->gas_check_valve == '0' || $item->gas_check_pressure == '0' ) 
                                                        - 
                                                    @else 
                                                        @if ($item->gas_check_body == '1')
                                                        ตัวถัง,                                                                                                 
                                                        @endif
                                                        @if ($item->gas_check_valve == '1')
                                                        วาลว์,
                                                        @endif
                                                        @if ($item->gas_check_pressure == '1')
                                                        แรงดัน, 
                                                        @endif 
                                                    @endif
                                                      
                                                </td>   
                                                <td class="text-center" width="10%">{{ $item->ptname }}</td>                                              
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- </div> --}}
                        {{-- </p> --}}
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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            });             
            // $('#Process').click(function() {
            //         var startdate = $('#datepicker').val(); 
            //         var enddate = $('#datepicker2').val(); 
            //         Swal.fire({
            //                 title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
            //                 text: "You Want Process Data!",
            //                 icon: 'warning',
            //                 showCancelButton: true,
            //                 confirmButtonColor: '#3085d6',
            //                 cancelButtonColor: '#d33',
            //                 confirmButtonText: 'Yes, Want Process it!'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                         $("#overlay").fadeIn(200);　
            //                         $("#spinner").show(); //Load button clicked show spinner 
                                    
            //                         $.ajax({
            //                             url: "{{ route('tec.cctv_report_process') }}",
            //                             type: "POST",
            //                             dataType: 'json',
            //                             data: {startdate,enddate},
            //                             success: function(data) {
            //                                 if (data.status == 200) { 
            //                                     Swal.fire({
            //                                         title: 'ประมวลผลข้อมูลสำเร็จ',
            //                                         text: "You Process data success",
            //                                         icon: 'success',
            //                                         showCancelButton: false,
            //                                         confirmButtonColor: '#06D177',
            //                                         confirmButtonText: 'เรียบร้อย'
            //                                     }).then((result) => {
            //                                         if (result
            //                                             .isConfirmed) {
            //                                             console.log(
            //                                                 data);
            //                                             window.location.reload();
            //                                             $('#spinner').hide();//Request is complete so hide spinner
            //                                                 setTimeout(function(){
            //                                                     $("#overlay").fadeOut(200);
            //                                                 },400);
            //                                         }
            //                                     })
            //                                 } else if (data.status == 100) {
            //                                     const Toast = Swal.mixin({
            //                                         toast: true,
            //                                         position: "top-end",
            //                                         showConfirmButton: false,
            //                                         timer: 3000,
            //                                         timerProgressBar: true,
            //                                         didOpen: (toast) => {
            //                                             toast.onmouseenter = Swal.stopTimer;
            //                                             toast.onmouseleave = Swal.resumeTimer;
            //                                         }
            //                                         });
            //                                         Toast.fire({
            //                                         icon: "error",
            //                                         title: "กรุณาเลือกวันที่"
            //                                         });
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(200);
            //                                             },400);
            //                                 } else {
                                                
            //                                 }
            //                             },
            //                         });
                                    
            //                     }
            //         })
            // });
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
         
            
        });
    </script>
    @endsection
