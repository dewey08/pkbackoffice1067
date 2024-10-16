@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

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
        $ynow = date('Y') + 543;
        $yb = date('Y') + 542;
    ?>

<div class="tabs-animation">
 
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
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div>
    {{-- <form action="{{ url('air_setting') }}" method="GET">
        @csrf --}}
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(255, 255, 255)">ตั้งค่าปีงบประมาณ</h4> 
            </div>
             
            <div class="col"></div>               
           
            <div class="col-md-4 text-end">   
                {{-- <button type="button" class="ladda-button btn-pill btn btn-info bt_prs" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">   
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                    <span>เพิ่มรายการทะเบียนเครื่องปรับอากาศ</span> 
                </button> 
               --}}
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#documentModal"> 
                    <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                </button>
            </div> 
        </div>  
    {{-- </form> --}}
 
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">  
                       
                            <p class="mb-0">
                                <div class="table-responsive">
                                   
                                    <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th class="text-center" width="5%">ลำดับ</th>  
                                                    <th class="text-center" width="10%">ปีงบประมาณ</th> 
                                                    <th class="text-center" >รายการ</th> 
                                                    <th class="text-center" width="10%">วันที่เริ่ม</th> 
                                                    <th class="text-center" width="15%">วันที่สิ้นสุด</th>   
                                                     
                                                    <th class="text-center" width="8%">เปิดใช้งาน</th>  
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?> 
                                                <tr id="sid{{ $item->leave_year_id }}">                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="10%">{{$item->leave_year_id}}</td>  
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" >{{$item->leave_year_name}}</td>  
                                                    <td class="text-start" style="font-size:13px;color: rgb(253, 65, 81)" width="10%">{{$item->date_begin}} </td>
                                                    <td class="text-start" style="font-size:13px;color: rgb(112, 5, 98)" width="10%"> {{$item->date_end}}</td>                                                   
                                                    <td class="text-center" style="font-size:17px;color: rgb(252, 90, 203)" width="8%">
                                                        <div class="form-check form-switch">
                                                            @if ($item->years_now == 'Y')
                                                                <input type="checkbox" class="form-check-input" id="{{ $item->leave_year_id }}" name="{{ $item->leave_year_id }}" onchange="air_setting_yearnowswith({{ $item->leave_year_id }});" checked>
                                                            @else
                                                                <input type="checkbox" class="form-check-input" id="{{ $item->leave_year_id }}" name="{{ $item->leave_year_id }}" onchange="air_setting_yearnowswith({{ $item->leave_year_id }});">
                                                            @endif 
                                                            <label class="form-check-label" for="{{ $item->leave_year_id }}"></label>
                                                        </div> 
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

        

        <!-- documentModal Modal -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="documentModalLabel">คู่มือการใช้งาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"> 
                    <p style="color: rgb(255, 255, 255);font-size: 17px;">คู่มือการตั้งค่าปีงบประมาณ</p><br><br>
                    <img src="{{ asset('images/doc/settingair2.jpg') }}" class="rounded" alt="Image" width="auto" height="520px"> 
                    <br><br><br> 
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <br><br><br> 
                    
                    {{-- <img src="{{ asset('images/doc/t2.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet"> --}}

                    {{-- <img src="{{ asset('images/doc/t3.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet"> --}}
 
                </div>
                <div class="modal-footer">
                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">  <i class="fa-solid fa-xmark me-2"></i>Close</button> 
                </div>
            </div>
            </div>
        </div>


    </div>
</div>

 
@endsection
@section('footer')
<script>
    function air_setting_yearnowswith(idfunc){
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
                    url:"{{route('prs.air_setting_yearnowswith')}}",
                    method:"GET",
                    data:{onoff:onoff,idfunc:idfunc,_token:_token}
            })
       }
</script>
    <script>
        $(document).ready(function() {

            $('#air_plan_month_id').select2({
                dropdownParent: $('#exampleModal')
            });
                  
            $('#insert_Form').on('submit',function(e){
                  e.preventDefault();
              
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({ 
                          position: "top-end",
                          title: 'นำเข้าข้อมูลสำเร็จ',
                          text: "You Import data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location.reload();  
                            // window.location="{{url('air_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            $("#spinner-div").hide(); //Request is complete so hide spinner

            
            $('#Sendata').click(function() {
                // var datepicker = $('#datepicker').val(); 
                // var datepicker2 = $('#datepicker2').val(); 
                var datepicker = '1';
                var datepicker2 = '2';
                Swal.fire({
                    position: "top-end",
                        title: 'คุณต้องการนำเข้าข้อมูลใช่ไหม ?',
                        text: "You Import Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Import it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.importplan_send') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'นำเข้าข้อมูลสำเร็จ',
                                                text: "You Import data success",
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

            $('#Copydata').click(function() {
                var air_year = $('#air_year').val();  
                Swal.fire({
                    position: "top-end",
                        title: 'คุณต้องการคัดลอกข้อมูลใช่ไหม ?',
                        text: "You Copy Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Copy it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.air_setting_yearcopy') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {air_year},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'คัดลอกข้อมูลสำเร็จ',
                                                text: "You Copy data success",
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
    </script>

@endsection


