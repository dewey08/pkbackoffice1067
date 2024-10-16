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
            <div class="col-md-5"> 
                <h4 style="color:rgb(255, 255, 255)">บันทึกการตรวจสอบไนตรัสออกไซด์ (N2O-6Q)</h4> 
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end">
                <form action="{{ url('gas_check_nitrus') }}" method="GET">
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
              
                <a href="{{url('gas_check_nitrus_add')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-info bt_prs"> 
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                    Check
                </a> 
            </div>
        </div>
    </div>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body"> 
                        {{-- <div class="table-responsive">     --}}
                                <table id="example" class="table table-hover table-sm" style=" width: 100%;">
                       
                                    <thead>
                                        <tr> 
                                            <th class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="10%">วันที่ตรวจ</th>  
                                            <th class="text-center" width="10%">เวลา</th> 
                                            <th class="text-center" width="10%">รหัส</th> 
                                            <th class="text-center">รายการ</th>

                                            <th class="text-center" width="9%">ตัวถัง</th>
                                            <th class="text-center" width="9%">วาลว์</th> 
                                            <th class="text-center" width="9%">แรงดัน</th>  
                                            {{-- <th class="text-center" >รายการชำรุด</th>  --}}

                                            {{-- <th class="text-center" width="10%">ระดับ O2 </th> --}}
                                            {{-- <th class="text-center" width="10%">ค่าแรงดัน</th> --}}
                                            <th class="text-center" width="12%">ผู้ตรวจ</th> 
                                            {{-- <th class="text-center">จัดการ</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->gas_check_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ Datethai($item->check_date) }}</td> 
                                                <td class="text-center" width="5%" style="font-size: 12px">{{ $item->check_time }}</td> 
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ $item->gas_list_num }}</td>  
                                                <td class="text-start" style="font-size: 12px">{{ $item->gas_list_name }}</td>  
                                                <td class="text-center" width="9%"> 
                                                    @if ($item->gas_check_body == '0') 
                                                         <img src="{{asset('images/true_sm_50.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif
                                                </td> 
                                                {{-- <td class="text-center" width="10%" style="font-size: 12px">{{ $item->gas_check_body_name }}</td>   --}}
                                                <td class="text-center" width="10%" style="font-size: 12px">
                                                    @if ($item->gas_check_valve == '0') 
                                                            <img src="{{asset('images/true_sm_50.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif 
                                                </td> 
                                                <td class="text-center" width="10%" style="font-size: 12px">
                                                    @if ($item->gas_check_pressure == '0') 
                                                        <img src="{{asset('images/true_sm_50.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @else 
                                                        <img src="{{asset('images/false_smal.png')}}" height="20px" width="20px" alt="Image" class="img-thumbnail bg_prs">
                                                    @endif
                                                </td> 

                                                {{-- <td class="text-center" width="9%"> 
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
                                                </td>    --}}
                                               
                                                {{-- <td class="text-start" style="color:rgb(73, 147, 231)">
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
                                                      
                                                </td>    --}}

                                                <td class="text-start" width="12%">{{ $item->ptname }}</td>  
                                                {{-- <td class="text-center" width="5%">
 
                                                    <div class="btn-group me-1">
                                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            ทำรายการ <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu"> 
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-warning" href="{{ url('gas_check_tankedit/' . $item->gas_check_id) }}" style="font-size:13px"  
                                                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                                <span>แก้ไข</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="gas_check_destroy({{ $item->gas_check_id }})" style="font-size:13px"
                                                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2"></i>
                                                                <span style="color: rgb(255, 2, 2);font-size:13px">ลบ</span> 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>                                             --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- </div> --}}
                        {{-- </p> --}}
                        {{-- </div> --}}
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
            // var table = $('#example').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 10,
            //     "lengthMenu": [10,25,30,31,50,100,150,200,300],
            // });
        
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
              
            $("#spinner-div").hide(); //Request is complete so hide spinner 
        });
    </script>
    @endsection
