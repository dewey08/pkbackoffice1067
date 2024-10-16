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

        function addarticle(input) {
            var fileInput = document.getElementById('article_img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
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
            <p class="card-title-desc" style="font-size: 15px;">รายการบันทึกข้อมูลกล้องวงจรปิด เดือนนี้</p>
        </div>
        <div class="col"></div>
         <div class="col-md-2 text-end">
            <a href="{{url('cctv_list_check_add')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs"> 
                <i class="fa-solid fa-circle-plus text-white me-2"></i>
                บันทึกข้อมูล
            </a> 
         </div>
    </div> 
   
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4">
                   
                    <div class="card-body">
                        <div class="card-body">
                            <div class="table-responsive">  
                                    <table id="example" class="table table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px">                                        
                                            <th class="text-center">รหัสกล้อง</th>
                                            <th class="text-center" width="15%">สถานที่ติดตั้ง</th> 
                                            <th class="text-center">Monitor</th> 
                                            <th class="text-center">วันที่เช็คล่าสุด</th> 
                                            <th class="text-center">สถานะ</th> 
                                            <th class="text-center">จอกล้อง</th> 
                                            <th class="text-center">มุมกล้อง</th>
                                            <th class="text-center">สิ่งกีดขวาง</th>
                                            {{-- <th class="text-center">การบันทึก</th>  --}}
                                            {{-- <th class="text-center">การสำรองไฟ</th>  --}}
                                        </tr>
                                       
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                            $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0;
                                            $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;
                                        ?>
                                        @foreach ($datashow as $item) 
                                        
                                            <tr style="font-size:13px"> 
                                                <td class="text-center" width="7%" >{{ $item->article_num }} </td>
                                                <td class="p-2"> {{ $item->cctv_location }}</td> 
                                                <td class="text-center" width="7%" >{{ $item->cctv_monitor }} </td> 
                                                <td class="text-center" width="10%">{{DateThai($item->cctv_check_date)}}</td> 
                                                <td class="text-center" width="10%"> 
                                                    @if ($item->cctv_status == '0')
                                                        {{-- <span class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">ปกติ</span> --}}
                                                        {{-- <span class="badge badge-pill badge-success">ปกติ</span>  --}}
                                                        <span class="badge bg-success">ปกติ</span> 
                                                    @else
                                                        <span class="badge bg-danger">ชำรุด</span>
                                                        {{-- <span class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">ชำรุด</span> --}}
                                                    @endif 
                                                </td>  
                                                <td class="text-center" width="7%">
                                                    @if ($item->cctv_camera_screen == '0') 
                                                        <span class="badge bg-success">ปกติ</span> 
                                                    @else
                                                        <span class="badge bg-danger">ชำรุด</span> 
                                                    @endif
                                                </td> 
                                                <td class="text-center" width="7%">
                                                    @if ($item->cctv_camera_corner == '0') 
                                                        <span class="badge bg-success">ปกติ</span> 
                                                    @else
                                                        <span class="badge bg-danger">ชำรุด</span> 
                                                    @endif
                                                </td> 
                                                <td class="text-center" width="7%">
                                                    @if ($item->cctv_camera_drawback == '0') 
                                                        <span class="badge bg-success">ปกติ</span> 
                                                    @else
                                                        <span class="badge bg-danger">ชำรุด</span> 
                                                    @endif
                                                </td> 
                                             
                                                {{-- <td class="text-center" width="7%">{{$item->cctv_camera_save}}</td>    --}}
                                                {{-- <td class="text-center" width="7%">{{$item->cctv_camera_power_backup}}</td>    --}}
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
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                // editButton: true,
                removeButton: false,
                processData: false,
                contentType: false,
                columns:{
                    identifier:[0,'cctv_list_num'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3'], [9, 'gender', '{"1":"Male", "2":"Female"}']]
                    editable: [[3, 'cctv_camera_screen', '{"0":"ปกติ", "1":"ชำรุด"}'], [4, 'cctv_camera_corner', '{"0":"ปกติ", "1":"ชำรุด"}'], [5, 'cctv_camera_drawback', '{"0":"ปกติ", "1":"ชำรุด"}'], [6, 'cctv_camera_save', '{"0":"ปกติ", "1":"ชำรุด"}'], [7, 'cctv_camera_power_backup', '{"0":"ปกติ", "1":"ชำรุด"}']]
                },
                // restoreButton:false,
                deleteButton: false,
                saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        // class: 'btn-icon btn-shadow btn-dashed btn btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
                        action: 'Edit'
                    }
                },
                onSuccess:function(data,textStatus,jqXHR)
                {
                   
                    if (data.action == 'Edit') 
                    {
                        // $('#'+data.icode).remove();
                        window.location.reload();
                    }
                }

            });

            
          
      });
</script>
@endsection