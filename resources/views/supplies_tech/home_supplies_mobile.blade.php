@extends('layouts.mobile')
@section('title', 'PK-OFFICE || Suplieser')
@section('content')
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
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

       
    </script>

    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    $countpermiss_ot = StaticController::countpermiss_ot($iduser);
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
        <div class="row mt-4 ms-3 me-3 text-center"> 
            <div class="col-4"> 
                <a href="{{ url('home_supplies') }}" class="ladda-button btn-pill btn btn-info cardair" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-desktop text-white me-2"></i>PC</span> 
                </a>
            </div>
            <div class="col-4"> 
                <a href="{{ url('home_supplies_mobile') }}" class="ladda-button btn-pill btn btn-info cardair" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-mobile-screen text-white me-2"></i>MOBILE</span> 
                </a> 
            </div>
            <div class="col-4"> 
                {{-- <a href="{{ url('home_supplies_mobile') }}" class="ladda-button btn-pill btn btn-info cardair" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-mobile-screen text-white me-2"></i>MOBILE</span> 
                </a>  --}}
                <a class="ladda-button btn-pill btn btn-danger cardair" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ri-shut-down-line align-middle me-1 text-white"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <div class="row mt-3 ms-3 me-3 text-center"> 
            <div class="col"> 
                <h4 style="color:green">รายการซ่อมตามใบแจ้งซ่อม <br>
                    บริษัท {{$sup_name}}
                </h4> 
            </div>
        </div>
        <form action="{{ url('home_supplies_mobile') }}" method="GET">
            @csrf
       
        <div class="row mt-3 ms-3 me-3"> 
            <div class="col">
                <select class="form-control cardair" id="air_repaire_type" name="air_repaire_type" style="width: 100%">
                    <option value="" class="text-center">เลือกประเภททั้งหมด</option>
                        @foreach ($air_repaire_type as $item_t)
                        @if ($repaire_type == $item_t->air_repaire_type_code)
                            <option value="{{ $item_t->air_repaire_type_code }}" class="text-center" selected> {{ $item_t->air_repaire_typename }}</option>
                        @else
                            <option value="{{ $item_t->air_repaire_type_code }}" class="text-center"> {{ $item_t->air_repaire_typename }}</option>
                        @endif 
                        @endforeach 
                </select>
            </div>
        </div> 
        <div class="row mt-3 ms-3 me-3"> 
            <div class="col"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control cardair" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control cardair" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary cardair" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                      
                </div> 
            </div> 
        </div>
    </form>
        <div class="row mt-3 ms-3 me-3">
            <div class="col">
              
                    <div class="card-body cardair">    
                        
                      
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width: 100%;"> 
                                    <thead>
                                        <tr style="font-size:13px">
                                          
                                            {{-- <th width="5%" class="text-center">ลำดับ</th>    --}}
                                            <th class="text-center" width="15%">วันที่</th>  
                                            <th class="text-center" width="10%">เวลา</th>
                                            <th class="text-center" width="10%">เลขที่</th>
                                            <th class="text-center">รหัส</th>   
                                            {{-- <th class="text-center">รายการ</th>    --}}
                                            {{-- <th class="text-center" width="12%">เจ้าหน้าที่</th>  --}}
                                            {{-- <th class="text-center" width="12%">ช่าง รพ.</th>  --}}
                                            {{-- <th class="text-center" width="12%">ช่างนอก</th>   --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->air_repaire_id}}" style="font-size:13px">                                                  
                                                {{-- <td class="text-center" width="5%">{{ $i++ }}</td>    --}}
                                                <td class="text-center" width="15%">{{ DateThai($item->repaire_date )}}</td>  
                                                <td class="text-center">{{ $item->repaire_time }}</td> 
                                                <td class="text-center">{{ $item->air_repaire_no }}</td> 
                                                <td class="text-start">
                                                    
                                                    <button type="button" class="ladda-button btn-pill btn btn-secondary cardair btn-sm maintenance1Modal" value="{{ $item->air_repaire_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                        <h7 class="text-start">{{$item->air_list_num}}</h7>
                                                    </button> 
                                                    {{-- <button type="button" class="btn btn-sm maintenance1Modal" style="background: transparent" value="{{ $item->air_repaire_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                        <h7 class="text-start">{{$item->air_list_num}} รายการ</h7>
                                                    </button> --}}
                                                </td>  
                                                {{-- <td class="text-start" width="10%">{{ $item->staff_name }}</td>  --}}
                                                {{-- <td class="text-start" width="10%">{{ $item->tect_name }}</td>  --}}
                                                {{-- <td class="text-start" width="10%">{{ $item->air_techout_name }}</td>  --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                      

                    </div>
              
            </div>
        </div>

    </div> 
    </div>
 

     <!-- maintenance1Modal Modal --> 
     <div class="modal fade" id="maintenance1Modal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">รายการซ่อม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">  
                        <div class="row">
                            <div class="col-md-12">
                                <div style='overflow:scroll; height:300px;'>
                                    <div id="detail_maintenance1Modal"></div>                                                
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

            $(document).on('click', '#printBtn', function() {
                var month_id = $(this).val();
                alert(month_id);

            });

            $("#spinner-div").hide(); //Request is complete so hide spinner
         
         $('#Pulldata').click(function() {
             var data_insert = $('#data_insert').val(); 
            //  var datepicker2 = $('#datepicker2').val(); 
             Swal.fire({
                 position: "top-end",
                     title: 'ต้องการประมวลผลใช่ไหม ?',
                     text: "You Warn Process Data!",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, Process it!'
                     }).then((result) => {
                         if (result.isConfirmed) {
                             $("#overlay").fadeIn(300);　
                             $("#spinner").show(); //Load button clicked show spinner 
                             
                             $.ajax({
                                 url: "{{ route('d.nurse_index_process') }}",
                                 type: "POST",
                                 dataType: 'json',
                                 data: {
                                    data_insert                       
                                 },
                                 success: function(data) {
                                     if (data.status == 200) { 
                                         Swal.fire({
                                             position: "top-end",
                                             title: 'ประมวลผลสำเร็จ',
                                    text: "You Process data success",
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

         $(document).on('click', '.maintenance1Modal', function() {
                var air_repaire_id = $(this).val(); 
                // var maintenance_list_num = '1';
                $('#maintenance1Modal').modal('show'); 
                $.ajax({
                    type: "GET",
                    url:"{{ url('detail_repaire_sup') }}",
                    data: { air_repaire_id: air_repaire_id},
                    success: function(result) { 
                        $('#detail_maintenance1Modal').html(result);
                    },
                });
            });
 
 
        });
    </script>

@endsection
