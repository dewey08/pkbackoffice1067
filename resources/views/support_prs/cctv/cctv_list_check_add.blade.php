@extends('layouts.support_prs_cctv')
@section('title', 'PK-OFFICE || CCTV')

<style>
    .btn {
        font-size: 15px;
    }

    .bgc {
        background-color: #264886;
    }

    .bga {
        background-color: #fbff7d;
    }
</style>
<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_land = StaticController::count_land();
$count_building = StaticController::count_building();
$count_article = StaticController::count_article();
?>


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

    date_default_timezone_set('Asia/Bangkok');
$date = date('Y') + 543;
$datefull = date('Y-m-d H:i:s');
$time = date("H:i:s");
$loter = $date.''.$time
    
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
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div>
   
    <div class="row"> 
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(10, 151, 85)">CHECK CCTV</h4>
            <p class="card-title-desc" style="font-size: 15px;">บันทึกข้อมูลกล้องวงจรปิด</p>
        </div>
        <div class="col"></div>
        <div class="col-md-2 text-end">
            <button type="button" class="adda-button me-2 btn-pill btn btn-sm btn-primary bt_prs" id="Pulldata"> 
                <i class="fa-solid fa-floppy-disk text-white me-2"></i>
                บันทึกข้อมูล
            </button> 
         </div>
    </div> 
   
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4">
                    
                        <div class="card-body">
                            <div class="table-responsive">  
                                    <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px">                                        
                                            <th class="text-center" style="background: #fdf7e4">รหัสกล้อง</th>
                                            <th class="text-center" width="15%" style="background: #fdf7e4">สถานที่ติดตั้ง</th> 
                                            <th class="text-center" style="background: #e4fdfc">สถานะการตรวจเช็ค</th> 
                                            <th class="text-center" style="background: #e4fdfc">จอกล้อง</th> 
                                            <th class="text-center" style="background: #e4fdfc">มุมกล้อง</th>
                                            <th class="text-center" style="background: #e4fdfc">สิ่งกีดขวาง</th>
                                            {{-- <th class="text-center" style="background: #dadffa">การบันทึก</th>  --}}
                                            {{-- <th class="text-center" style="background: #dadffa">การสำรองไฟ</th>  --}}
                                        </tr>
                                       
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                            $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0;
                                            $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;
                                        ?>
                                        @foreach ($datashow as $item) 
                                        <?php
                                                $lastday_   = DB::table('cctv_check')->orderBy('cctv_check_date', 'DESC')->latest()->first();
                                                $lastday    = $lastday_->cctv_check_date;
                                                $datenow    = date('Y-m-d');
                                                $newweek    = date('Y-m-d', strtotime($lastday . ' +1 week')); //เพิ่ม 1 สัปดาห์
                                                $newDate    = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
                                                $newyear    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
                                                // $dashboard_ = DB::select(
                                                //     'SELECT * FROM cctv_check WHERE article_num = "'.$item->cctv_list_num.'"  
                                                // ');  
                                                // foreach ($dashboard_ as $key => $value) {
                                                //    $cctv_camera_screen       = $value->cctv_camera_screen;
                                                //    $cctv_camera_corner       = $value->cctv_camera_corner;
                                                //    $cctv_camera_drawback     = $value->cctv_camera_drawback;
                                                //    $cctv_camera_save         = $value->cctv_camera_save;
                                                //    $cctv_camera_power_backup = $value->cctv_camera_power_backup;
                                                // }
                                                // $dataedit = DB::table('cctv_check')->where('article_num', '=', $item->cctv_list_num)->first();
                                                //     $cctv_camera_screen       = $dataedit->cctv_camera_screen;
                                                //     $cctv_camera_corner       = $dataedit->cctv_camera_corner;
                                                //     $cctv_camera_drawback     = $dataedit->cctv_camera_drawback;
                                                //     $cctv_camera_save         = $dataedit->cctv_camera_save;
                                                //     $cctv_camera_power_backup = $dataedit->cctv_camera_power_backup;
                                        ?>
                                        @if ($datenow == $newweek)
                                            <tr style="font-size:13px"> 
                                                <td class="text-center" width="7%" >{{ $item->cctv_list_num }}</td>
                                                <td class="p-2"> {{ $item->cctv_location }}</td>  
                                                <td class="text-center" width="7%">{{$item->cctv_check}}</td>  
                                                <td class="text-center" width="7%">{{$item->cctv_camera_screen}}</td> 
                                                <td class="text-center" width="7%">{{$item->cctv_camera_corner}}</td> 
                                                <td class="text-center" width="7%">{{$item->cctv_camera_drawback}}</td>  
                                            </tr> 
                                        @else
                                            
                                        @endif
                                            
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                         
                </div>
            </div>
        </div>
          
    </div>
 
@endsection
@section('footer')
<script>
     $(document).ready(function () {
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();  
          $('#table_id').DataTable();
         
          $('#building_userid').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#article_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $('#Tabledit').Tabledit({
                url:'{{route("tec.cctv_list_editcheck")}}',
                dataType:"json",
                // editButton: true,
                removeButton: false,
                columns:{
                    identifier:[0,'cctv_list_num'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3'], [9, 'gender', '{"1":"Male", "2":"Female"}']]
                    // editable: [[3, 'cctv_camera_screen', '{"0":"ปกติ", "1":"ชำรุด"}'], [4, 'cctv_camera_corner', '{"0":"ปกติ", "1":"ชำรุด"}'], [5, 'cctv_camera_drawback', '{"0":"ปกติ", "1":"ชำรุด"}'], [6, 'cctv_camera_save', '{"0":"ปกติ", "1":"ชำรุด"}'], [7, 'cctv_camera_power_backup', '{"0":"ปกติ", "1":"ชำรุด"}']]
                    editable: [[3, 'cctv_camera_screen', '{"0":"ปกติ", "1":"ชำรุด"}'], [4, 'cctv_camera_corner', '{"0":"ปกติ", "1":"ชำรุด"}'], [5, 'cctv_camera_drawback', '{"0":"ปกติ", "1":"ชำรุด"}']]
                },
                // restoreButton:false,
                deleteButton: false,
                // saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        // class: 'btn-icon btn-shadow btn-dashed btn btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
                        action: 'Edit'
                    }
                },
                onSuccess:function(data)
                {
                    if (data.status == 200) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Edit Success",
                            showConfirmButton: false,
                            timer: 1500
                            });
                            window.location.reload();
                   } else {
                    
                   }
                    
                } 
            });
            $('#Pulldata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Insert Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Insert it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('tec.cctv_list_check_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Insert data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    // window.location.reload();
                                                    window.location="{{url('cctv_list_check')}}"; 
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