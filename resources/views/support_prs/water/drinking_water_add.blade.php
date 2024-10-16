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

    <form class="custom-validation" action="{{ route('prs.drinking_water_save') }}" method="POST" id="insert_Form" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col-md-5"> 
            <h4 style="color:rgb(255, 255, 255)">เพิ่มข้อมูลทะเบียนเครื่องผลิตน้ำดื่ม</h4>
            {{-- <p class="card-title-desc" style="font-size: 17px;">เพิ่มข้อมูลถังดับเพลิง</p> --}}
        </div>
        <div class="col"></div>
        {{-- <div class="col-md-2 text-end">
            <a href="{{url('fire_main')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-warning bt_prs"> 
                <i class="fa-solid fa-arrow-left me-2"></i> 
               ย้อนกลับ
            </a> 
        </div> --}}
        <div class="col-md-4 text-end">
            <div class="form-group">
                <button type="submit" class="mb-2 me-2 ladda-button me-2 btn-pill btn btn-info bt_prs"> 
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
   
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4 p-3">
                   
                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                        alt="Image" class="img-thumbnail bg_prs" width="450px" height="350px">
                                    <br>
                                    <div class="input-group mt-3">
                                        {{-- <label class="input-group-text" for="fire_imgname">Upload</label> --}}
                                        {{-- <canvas> --}}
                                        <input type="file" class="form-control bg_prs" id="water_img" name="water_img"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      
                                    </div>
                                </div>
                            </div>
 

                            <div class="col-md-8">
                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="water_year">ปีงบประมาณ</label>
                                            </div>
                                            <select class="js-example-responsive" id="water_year" name="water_year" style="width: 65%">  
                                                @foreach ($budget_year as $ye)
                                                @if ($ye->leave_year_id == $date)
                                                    <option value="{{ $ye->leave_year_id }}" selected>
                                                        {{ $ye->leave_year_id }} </option>
                                                @else
                                                    <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}
                                                    </option>
                                                @endif
                                            @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">วันที่รับเข้า</span>
                                            </div>
                                            <input type="date" class="form-control bg_prs form-control-sm" id="water_recieve_date" name="water_recieve_date" aria-label="water_recieve_date" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div>
                                </div>
 

                                <div class="row mt-3"> 
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">รหัส</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="water_code" name="water_code" aria-label="water_code" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">รายการ</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="water_name" name="water_name" aria-label="water_name" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                                </div>

                               
                                <div class="row mt-3">
                                    <div class="col-md-5">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ราคา</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="water_price" name="water_price" aria-label="water_price" aria-describedby="inputGroup-sizing-sm">
                                        </div>  
                                    </div> 
                                    <div class="col-md-1 mt-2">
                                        <label for="fire_price">บาท</label>
                                    </div>
                                    <div class="col-md-6">  
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">เลขครุภัณฑ์</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="water_num" name="water_num" aria-label="water_num" aria-describedby="inputGroup-sizing-sm">
                                        </div>  
                                        
                                    </div> 
                                </div>


                                <div class="row mt-3">

                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">สถานที่ตั้ง</span>
                                            </div>
                                            <select class="js-example-responsive" id="location_id" name="location_id" style="width: 75%">  
                                                @foreach ($building_data as $lo)
                                                <option value="{{ $lo->building_id }}">
                                                    {{ $lo->building_name }}
                                                </option>
                                            @endforeach
                                            </select> 
                                            {{-- <input type="text" class="form-control bg_prs" id="location_id" name="location_id" aria-label="location_id" aria-describedby="inputGroup-sizing-sm"> --}}
                                        </div> 
                                    </div>
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ชั้น</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="class" name="class" aria-label="class" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
 
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">  
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">หน่วยงาน</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="detail" name="detail" aria-label="detail" aria-describedby="inputGroup-sizing-sm">
                                        </div>  
                                        
                                    </div> 
                                    
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ขนาด</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="size" name="size" aria-label="size" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                           
 
                                </div>
 

                                <div class="row mt-3"> 
                                    <div class="col-md-6"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="unit_id">หน่วยนับ</label>
                                            </div>
                                            <select class="js-example-responsive show_unit" id="unit_id" name="unit_id" style="width: 75%">  
                                                @foreach ($product_unit as $uni)
                                                <option value="{{ $uni->unit_id }}">
                                                    {{ $uni->unit_name }}
                                                </option>
                                            @endforeach
                                            </select> 
                                        </div> 
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="brand_id">ยี่ห้อ</label>
                                            </div>
                                            <select class="js-example-responsive show_brand" id="brand_id" name="brand_id" style="width: 75%">  
                                                @foreach ($product_brand as $bra)
                                                    <option value="{{ $bra->brand_id }}">
                                                        {{ $bra->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="UNIT_INSERT" name="UNIT_INSERT"
                                                class="form-control form-control-sm shadow bg_prs" /> 
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="ladda-button btn-pill btn btn-sm btn-info bt_prs" onclick="addunit();">
                                                <i class="fa-solid fa-square-plus me-2"></i>
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row mt-3">
                                
                                    <div class="col-md-6">  
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="active">สถานะ</label>
                                            </div>                                          
                                            <select id="active" name="active" class="js-example-responsive" style="width: 75%">
                                                <option value="Y">พร้อมใช้งาน</option>
                                                <option value="N">ไม่พร้อมใช้งาน</option> 
                                                <option value="C">ส่งซ่อม</option> 
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
 
                            </div>
                        </div>

                    </div>
                   
                    
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="ms-2 me-2 ladda-button btn-pill btn btn-info bt_prs"> 
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <a href="{{ url('fire_main') }}" class="ms-2 me-2 ladda-button btn-pill btn btn-danger bt_prs">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div> --}}

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