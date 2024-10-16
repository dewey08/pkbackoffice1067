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
    <form action="{{ url('air_setting') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(255, 255, 255)">ยกยอดทั้งหมด(รายเดือน)</h4> 
            </div>
             
            <div class="col"></div>               
           
            <div class="col-md-2 text-end mb-2">   
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-info bt_prs" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">   
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                    <span>ทำรายการ</span> 
                </button> 
              
                {{-- <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#documentModal"> 
                    <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                </button> --}}
            </div> 
        </div>  
    </form>
 
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
                                                    <th class="text-center" width="10%">ปี</th>  
                                                    <th class="text-center" width="10%">เดือน</th> 
                                                    <th class="text-center" width="15%">จำนวน</th>    
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?> 
                                                <tr id="sid{{ $item->air_stock_month_id }}">                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="10%">{{$item->years_th}}</td>  
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="10%">{{$item->month_name}}</td>  
                                                    <td class="text-center" style="font-size:13px;color: rgb(253, 65, 81)" width="15%">{{$item->total_qty}} </td>
                                                    
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

        <!-- exampleModal Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content"> 
                    <div class="modal-body">
                      
                            <br>                            
                                <div class="container"> 
                                    <div class="row">
                                        <h3 class="text-center">ยกยอดจำนวนทั้งหมด(รายเดือน)</h3><br>
                                        <h4 class="text-center">ปีงบประมาณ {{$bg_yearnow}}</h4>
                                        <div class="col-md-6">
                                            <p style="font-size: 14px">เดือน</p>
                                            <div class="form-group">  
                                                <div class="input-group mt-3"> 
                                                    <select name="month_no1" id="month_no1" class="form-control" style="width: 100%"> 
                                                        @foreach ($months_data as $itemm)
                                                        <option value="{{$itemm->month_no}}">{{$itemm->month_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <p style="font-size: 14px">ปี</p>
                                            <div class="form-group">  
                                                <div class="input-group mt-3"> 
                                                    <select name="leave_year_id1" id="leave_year_id1" class="form-control" style="width: 100%"> 
                                                        @foreach ($yearsshow as $item1)
                                                        @if ($bg_yearnow == $item1->leave_year_id)
                                                            <option value="{{$item1->leave_year_id}}" selected>{{$item1->leave_year_id}}</option>
                                                        @else
                                                            <option value="{{$item1->leave_year_id}}">{{$item1->leave_year_id}}</option>  
                                                        @endif 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="row mt-4">
                                        <div class="col"></div>
                                        <div class="col-md-4 text-center">
                                            <div class="form-group"> 
                                                <button type="button" class="ladda-button btn-pill btn btn-success bt_prs" id="Copydatato"> 
                                                    <i class="fa-regular fa-clone text-white me-2"></i>
                                                    ยกยอดไป
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col"></div>
                                    </div> 
                                    {{-- <div class="row">  
                                        <div class="col-md-6">
                                            <p style="font-size: 14px">เดือน</p>
                                            <div class="form-group">  
                                                <div class="input-group mt-3"> 
                                                    <select name="month_no2" id="month_no2" class="form-control" style="width: 100%"> 
                                                        @foreach ($months_data as $itemm)
                                                        <option value="{{$itemm->month_no}}">{{$itemm->month_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <p style="font-size: 14px">ปี</p>
                                            <div class="form-group">  
                                                <div class="input-group mt-3"> 
                                                    <select name="leave_year_id2" id="leave_year_id2" class="form-control" style="width: 100%"> 
                                                        @foreach ($yearsshow as $item1)
                                                        @if ($bg_yearnow == $item1->leave_year_id)
                                                            <option value="{{$item1->leave_year_id}}" selected>{{$item1->leave_year_id}}</option>
                                                        @else
                                                            <option value="{{$item1->leave_year_id}}">{{$item1->leave_year_id}}</option>  
                                                        @endif 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>  --}}
                                </div>   
                            <br> 
                    
                    </div>         
                </div>
            </div>
        </div>

        <!-- documentModal Modal -->
        {{-- <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="documentModalLabel">คู่มือการใช้งาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"> 
                    <p style="color: rgb(255, 255, 255);font-size: 17px;">คู่มือการตั้งค่าทะเบียนเครื่องปรับอากาศประจำปีงบประมาณ</p><br><br>
                    <img src="{{ asset('images/doc/settingair.jpg') }}" class="rounded" alt="Image" width="auto" height="520px"> 
                    <br><br><br> 
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <br><br><br> 
                    
       
 
                </div>
                <div class="modal-footer">
                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">  <i class="fa-solid fa-xmark me-2"></i>Close</button> 
                </div>
            </div>
            </div>
        </div> --}}


    </div>
</div>

 
@endsection
@section('footer')
<script>
    function switch_air_active(idfunc){
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
                    url:"{{route('prs.switch_air_active')}}",
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

            $('#Copydatato').click(function() {
                var month_no1      = $('#month_no1').val();  
                // var month_no2      = $('#month_no2').val();
                var leave_year_id1 = $('#leave_year_id1').val();
                // var leave_year_id2 = $('#leave_year_id2').val();
                Swal.fire({
                    position: "top-end",
                        title: 'คุณต้องการยกยอดใช่ไหม ?',
                        text: "You Carry Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Carry it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.air_setting_monthcopy') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {month_no1,leave_year_id1},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ยกยอดสำเร็จ',
                                                text: "You Carry data success",
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






 