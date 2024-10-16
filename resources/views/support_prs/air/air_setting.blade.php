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
            <div class="col-md-3">
                <h4 style="color:rgb(255, 255, 255)">Import Data Plan</h4> 
            </div>
             
            <div class="col"></div>               
            <div class="col-md-2"> 
                <select name="air_plan_month_id" id="air_plan_month_id" class="form-control form-control-sm inputmedsalt text-center bt_prs" style="width: 100%;font-size:13px">
                    @foreach ($years_show as $item_y) 
                        @if ($data_months == $item_y->air_plan_month && $data_years == $item_y->air_plan_year)
                            <option value="{{$item_y->air_plan_month_id}}" selected>{{$item_y->air_plan_name}} {{$item_y->air_plan_year}} ปีงบประมาณ {{$item_y->years}}</option>
                        @else
                            <option value="{{$item_y->air_plan_month_id}}">{{$item_y->air_plan_name}} {{$item_y->air_plan_year}} ปีงบประมาณ {{$item_y->years}}</option>
                        @endif                         
                    @endforeach
                </select>
            </div>                     
            <div class="col-md-1 text-start">  
                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-primary bt_prs me-2" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                    <span class="ladda-spinner"></span>
                </button>  
            </div>  
            <div class="col"></div> 
            <div class="col-md-4 text-end">   
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-info bt_prs" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">   
                    <i class="fas fa-file-excel text-white me-2" style="font-size:13px"></i>
                    <span>Import</span> 
                </button> 
                {{-- <a href="{{url('importplan_send')}}" class="ladda-button btn-pill btn btn-success bt_prs">   
                    <i class="fa-solid fa-file-import text-white me-2" style="font-size:13px"></i>
                    <span>Send</span> 
                </a>   --}}
                {{-- <button type="button" class="ladda-button btn-pill btn btn-success bt_prs Sendata" data-url="{{url('importplan_send')}}">  --}}
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-success bt_prs" id="Sendata">   
                    <i class="fa-solid fa-file-import text-white me-2" style="font-size:13px"></i>
                    <span>Send</span> 
                </button> 
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#documentModal"> 
                    <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                </button>
            </div> 
        </div>  
    </form>
 
        <div class="row mt-2">
            <div class="col-xl-7">
                <div class="card card_prs_4">
                    <div class="card-body">  
                       
                            <p class="mb-0">
                                <div class="table-responsive">
                                   
                                    <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th class="text-center" width="5%">ลำดับ</th>  
                                                    <th class="text-center" width="10%">ปีงบประมาณ</th> 
                                                    <th class="text-center" width="12%">เดือน</th> 
                                                    <th class="text-center">รายการเครื่องปรับอากาศ</th>   
                                                    <th class="text-center" width="25%">แผนการบำรุงรักษา</th>   
                                                    {{-- <th class="text-center" width="10%">active</th>   --}}
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($datashow as $item) 
                                            <?php $i++  ?> 
                                                <tr id="sid{{ $item->air_plan_month_id }}">                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="10%">{{$item->years}}</td> 
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="12%">{{$item->air_plan_name}}</td> 
                                                    <td class="text-start" style="font-size:13px;color: rgb(112, 5, 98)" > {{$item->air_list_num}}</td>
                                                    <td class="text-start" style="font-size:13px;color: rgb(253, 65, 81)" width="25%">{{$item->air_repaire_typename}} </td>
                                                    {{-- <td class="text-center" style="font-size:13px;color: rgb(252, 90, 203)" width="10%">
                                                        @if($item->active == 'Y' )
                                                        <input type="checkbox" id="{{ $item->air_plan_month_id }}" name="{{ $item->air_plan_month_id }}" switch="none" onchange="switchactive({{ $item->air_plan_month_id }});" checked />
                                                        @else
                                                        <input type="checkbox" id="{{ $item->air_plan_month_id }}" name="{{ $item->air_plan_month_id }}" switch="none" onchange="switchactive({{ $item->air_plan_month_id }});" />
                                                        @endif
                                                        <label for="{{ $item-> air_plan_month_id }}" data-on-label="On" data-off-label="Off"></label>
                                                    </td>  --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                  
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card card_prs_4">
                    <div class="card-body">  
                       
                            <p class="mb-0">
                                <div class="table-responsive">
                                   
                                    <table id="example2" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">                       
                                        <thead>                             
                                                <tr style="font-size:13px"> 
                                                    <th class="text-center" width="5%">ลำดับ</th>  
                                                    <th class="text-center" width="10%">ปีงบประมาณ</th>  
                                                    <th class="text-center">รายการเครื่องปรับอากาศ</th>   
                                                    <th class="text-center" width="40%">แผนการบำรุงรักษา</th>    
                                                </tr>  
                                        </thead>
                                        <tbody>
                                            <?php $ii = 0; ?>
                                            @foreach ($air_plan_excel as $item2) 
                                            <?php $ii++  ?> 
                                                <tr id="sid{{ $item2->air_plan_excel_id }}">                                                  
                                                    <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$ii}}</td>
                                                    <td class="text-center" style="font-size:14px;color: rgb(2, 95, 182)" width="10%">{{$item2->air_plan_year}}</td>  
                                                    <td class="text-start" style="font-size:13px;color: rgb(112, 5, 98)" > {{$item2->air_list_num}}</td>
                                                    <td class="text-start" style="font-size:13px;color: rgb(253, 65, 81)" width="40%">{{$item2->air_repaire_typename}} </td>
                                                    
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
                        <form method="POST" action="{{ route('prs.importplan_excel') }}" id="insert_Form" enctype="multipart/form-data">
                            @csrf
                            <br>                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <i class="fas fa-7x fa-file-excel text-white me-2"></i>
                                                <br>
                                                <div class="input-group mt-3"> 
                                                    <input type="file" class="form-control" id="PlanDOC" name="PlanDOC" onchange="addimg(this)" required>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="row mt-4">
                                        <div class="col"></div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <button type="submit" class="ladda-button btn-pill btn btn-success">
                                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                                    บันทึกข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col"></div>
                                    </div> 
                                </div>   
                            <br> 
                        </form>   
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
                    <p style="color: rgb(255, 255, 255);font-size: 17px;">คู่มือการนำเข้าแผนการบำรุงรักษา</p><br><br>
                    <img src="{{ asset('images/doc/p1.jpg') }}" class="rounded" alt="Image" width="auto" height="520px"> 
                    <br><br><br> 
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <br><br><br> 
                    
                    <img src="{{ asset('images/doc/p2.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">

                    <img src="{{ asset('images/doc/p3.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">

                    <img src="{{ asset('images/doc/p4.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">

                    <img src="{{ asset('images/doc/p5.jpg') }}" class="rounded" alt="Image" width="auto" height="520px">
                    <br><br><br>
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">
                    <hr style="color: rgb(255, 255, 255);border: blueviolet">

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
    function switchactive(idfunc){
            // var nameVar = document.getElementById("name").value;
            var checkBox = document.getElementById(idfunc);
            var onoff;
            
            if (checkBox.checked == true){
                onoff = "TRUE";
            } else {
                onoff = "FALSE";
            }
 
            var _token=$('input[name="_token"]').val();
                // $.ajax({
                        // url:"{{route('env.env_water_parameter_switchactive')}}",
                        // method:"GET",
                        // data:{onoff:onoff,idfunc:idfunc,_token:_token}
                // })
       }
</script>
    <script>
        $(document).ready(function() {
                  
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

        });
    </script>

@endsection


