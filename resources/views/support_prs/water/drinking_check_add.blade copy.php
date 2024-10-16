@extends('layouts.support_prs_water')
@section('title', 'PK-OFFICE || Fire')

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
            var fileInput = document.getElementById('water_img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);

                    // var wrapper = document.getElementById("signature-pad");
                    // // var clearButton = wrapper.querySelector("[data-action=clear]");
                    // var savePNGButton = fileInput.querySelector("[data-action=save-png]");
                    // var canvas = fileInput.querySelector("canvas");

                    // // var wrapper = document.getElementById("signature-pad"); 
                    // // var savePNGButton = wrapper.querySelector("[data-action=save-png]");
                    // var signaturePad;
                    // signaturePad = new SignaturePad(canvas);
                    // savePNGButton.addEventListener("click", function(event) {
                    // if (signaturePad.isEmpty()) {
                    //     // alert("Please provide signature first.");
                    //     Swal.fire(
                    //         'กรุณาลงลายเซนต์ก่อน !',
                    //         'You clicked the button !',
                    //         'warning'
                    //     )
                    //     event.preventDefault();
                    // } else {
                    //     var canvas = document.getElementById("fire_imgname");
                    //     var dataUrl = canvas.toDataURL();
                    //     document.getElementById("signature").value = dataUrl;

                    //     // ข้อความแจ้ง
                    //     Swal.fire({
                    //         title: 'สร้างสำเร็จ',
                    //         text: "You create success",
                    //         icon: 'success',
                    //         showCancelButton: false,
                    //         confirmButtonColor: '#06D177',
                    //         confirmButtonText: 'เรียบร้อย'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {}
                    //     })
                    // }
                    // });


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

    <form class="custom-validation" action="{{ route('prs.drinking_check_save') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col text-center"> 
            <h4 style="color:rgb(255, 255, 255)">ตรวจสอบเครื่องผลิตน้ำดื่ม</h4> 
        </div>
    </div> 
    <div class="row"> 
        <div class="col text-center">
            <div class="form-group">
                <button type="button" class="mb-2 me-2 ladda-button me-2 btn-pill btn btn-info bt_prs" id="Save_data"> 
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                        บันทึกข้อมูล
                </button>
                <a href="{{ url('drinking_water_list') }}" class="mb-2 me-2 ladda-button me-2 btn-pill btn btn-danger bt_prs">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ยกเลิก
                </a>
            </div>
        </div>
       
        
    </div> 
   
    <div class="row mt-2">
        <div class="col-xl-12">
            <div class="card card_prs_4">
                <div class="card-body"> 
 
                    {{-- <input type="hidden" id="check_date" name="check_date" value="{{$date_now}}">
                    <input type="hidden" id="gas_list_id" name="gas_list_id" value="{{$gas_list_id}}"> 
                    <input type="hidden" id="gas_list_num" name="gas_list_num" value="{{$gas_list_num}}">
                    <input type="hidden" id="gas_list_name" name="gas_list_name" value="{{$gas_list_name}}">
                    <input type="hidden" id="class_edit" name="class_edit" value="{{$class}}">
                    <input type="hidden" id="dot_name" name="dot_name" value="{{$dot_name}}">                   
                     <input type="hidden" id="location_name" name="location_name" value="{{$location_name}}"> --}}
                  
                    <div class="row">
                        <div class="col text-center"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">222</p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col text-center"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2"> ชั้น 222 จุดตรวจ 222</p>
                        </div> 
                    </div>

                   
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ไส้กรอง</p>
                        </div>
                        <div class="col text-start">   
                            <select name="filter" id="filter" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">inH2O</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ถังกรองน้ำ</p>
                        </div>
                        <div class="col text-start">  
                            <select name="filter_tank" id="filter_tank" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">หลอด UV</p>
                        </div>
                        <div class="col text-start">   
                            <select name="tube" id="tube" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div> 
                        {{-- <div class="col-2 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">bar</p>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">โซลินอยวาล</p>
                        </div>
                        <div class="col text-start">  
                            <select name="solinoi_vaw" id="solinoi_vaw" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">โลเพรสเซอร์สวิส</p>
                        </div>
                        <div class="col text-start">   
                            <select name="lowplessor_swith" id="lowplessor_swith" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ไฮเพรสเซอร์สวิส</p>
                        </div>
                        <div class="col text-start">   
                            <select name="hiplessor_swith" id="hiplessor_swith" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">สายน้ำเข้า</p>
                        </div>
                        <div class="col text-start">  
                            <select name="water_in" id="water_in" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ก๊อกน้ำร้อน-เย็น</p>
                        </div>
                        <div class="col text-start">   
                            <select name="hot_clod" id="hot_clod" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6 text-start"> 
                            <p style="color:rgb(19, 154, 233);font-size:16px" class="mt-2">ถังเก็บน้ำกรอง</p>
                        </div>
                        <div class="col text-start">   
                            <select name="storage_tank" id="storage_tank" class="form-control" style="color:rgb(19, 154, 233);font-size:16px;background-color: white">
                                <option value="Y">พร้อมใช้งาน</option>
                                <option value="N">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>  
                    </div>
                    
                    {{-- <div class="row mt-4 mb-4">                         
                        <div class="col text-center">
                            <button type="button" class="ladda-button me-2 btn-pill btn btn-success bt_prs" id="Save_data"> 
                                <i class="fa-solid fa-floppy-disk text-white me-2"></i>
                               บันทึกข้อมูล
                            </button>  
                            <a href="{{url('gas_control_add')}}" class="ladda-button me-2 btn-pill btn btn-danger bt_prs">  
                                <i class="fa-solid fa-xmark me-2"></i>
                                ยกเลิก
                            </a> 
                        </div>                
                    </div> --}}
                    
                </div>
            </div> 
        </div>
    </div>
       
    </div>
    </div>

    </div>
</form>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>

<script>
     $(document).ready(function () {
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();  
          $('#table_id').DataTable();
         
          $('#unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#water_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#active').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
          $('#brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#location_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
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
                          title: 'บันทึกข้อมูลสำเร็จ',
                          text: "You Insert data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            // window.location.reload();  
                            window.location="{{url('drinking_water_list')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            
          
      });
</script>
@endsection