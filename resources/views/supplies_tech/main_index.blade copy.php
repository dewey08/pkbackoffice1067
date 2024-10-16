@extends('layouts.suppliesnew')
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
        <form action="{{ url('home_supplies') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-4"> 
                <h4 style="color:green">รายการซ่อมตามใบแจ้งซ่อม</h4> 
            </div>
            <div class="col"></div> 
            <div class="col-md-4 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                    
                </div> 
            </div>
        </div>
    </form>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_audit_4c">
                    <div class="card-body">    
                        <div class="row mb-3">
                           
                            <div class="col"></div>
                            <div class="col-md-5 text-end">
                               
                            </div>
                        </div>
        
                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                    <thead>
                                        <tr style="font-size:13px">
                                          
                                            <th width="3%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="3%">สถานะ</th>  
                                            <th class="text-center" width="5%">วันที่ซ่อม</th>  
                                            <th class="text-center" width="5%">เวลา</th>
                                            <th class="text-center" width="5%">เลขที่แจ้งซ่อม</th>   
                                            <th class="text-center" width="5%">รหัส</th>  
                                            <th class="text-center" >รายการ</th>  
                                            <th class="text-center" >สถานที่ตั้ง</th>  
                                            <th class="text-center" >ช่างนอก</th> 
                                            <th class="text-center" >เจ้าหน้าที่</th>  
                                            <th class="text-center" >ช่าง รพ.</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->air_repaire_id}}" style="font-size:13px">                                                  
                                                <td class="text-center" width="3%">{{ $i++ }}</td>  
                                                <td class="text-center" width="3%" style="font-size: 12px">
                                                    @if ($item->active == 'Y') 
                                                            <span class="badge bg-success">พร้อมใช้งาน</span> 
                                                    @else
                                                    <span class="badge bg-danger">ไม่พร้อมใช้งาน</span> 
                                                    @endif
                                                </td> 
                                                <td class="text-center" width="8%">{{ DateThai($item->repaire_date )}}</td>  
                                                <td class="text-center" width="5%">{{ $item->repaire_time }}</td> 
                                                <td class="text-center" width="7%">{{ $item->air_repaire_no }}</td>   
                                                <td class="text-center" width="7%">{{ $item->air_list_num }}</td>  
                                                <td class="p-2">{{ $item->air_list_name }}</td>   
                                                <td class="p-2" width="20%">{{ $item->air_location_name }}</td> 
                                                <td class="p-2" width="10%">{{ $item->air_techout_name }}</td>   
                                                <td class="p-2" width="10%">{{ $item->ptname }}</td>  
                                                <td class="p-2" width="10%">{{ $item->tectname }}</td>  
                                                
        
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
    </div>


    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-3">
            
        </div>
        <div class="col-md-3">
            
        </div>
        <div class="col-md-3">
            
        </div>
    </div>


@endsection
@section('footer') 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#Tabledit').Tabledit({
                url:'{{route("d.nurse_index_editable")}}',
                dataType:"json",
                // editButton: true,
                removeButton: false,
                columns:{
                    identifier:[1,'ward'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3']]
                    editable: [[4, 'np_a'], [7, 'np_b'], [10, 'np_c']]
                },
                // restoreButton:false,
                deleteButton: false,
                saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        class: 'btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square"></i>',
                        action: 'Edit'
                    }
                },
                // onSuccess:function(data,textStatus,jqXHR)
                // {
                //     if (data.action == 'delete') 
                //     {
                //         $('#'+data.icode).remove();
                //     }
                // }

            });
 
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
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
 
 
        });
    </script>

@endsection
