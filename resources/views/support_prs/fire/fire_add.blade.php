@extends('layouts.support_prs_fireback')
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
            var fileInput = document.getElementById('fire_imgname');
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

    <form class="custom-validation" action="{{ route('prs.fire_save') }}" method="POST" id="insert_Form" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col-md-3"> 
            <h4 style="color:rgb(10, 151, 85)">ถังดับเพลิง</h4>
            <p class="card-title-desc" style="font-size: 17px;">เพิ่มข้อมูลถังดับเพลิง</p>
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
                <a href="{{ url('fire_main') }}" class="mb-2 me-2 ladda-button me-2 btn-pill btn btn-danger bt_prs">
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
                                        <input type="file" class="form-control bg_prs" id="fire_imgname" name="fire_imgname"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        {{-- <input type="hidden" id="signature" name="signature"> --}}
                                    {{-- </canvas>
                                    <button type="button" id="save_btn"
                                    class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                    onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                    Create
                                </button> --}}
                                    </div>
                                </div>
                            </div>
 

                            <div class="col-md-8">
                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="fire_year">ปีงบประมาณ</label>
                                            </div>
                                            <select class="js-example-responsive" id="fire_year" name="fire_year" style="width: 65%">  
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
                                            <input type="date" class="form-control bg_prs form-control-sm" id="fire_date" name="fire_date" aria-label="fire_date" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div>
                                </div>

                                <div class="row mt-3">
                                  
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">วันที่ผลิต</span>
                                            </div>
                                            <input type="date" class="form-control bg_prs" id="fire_date_pdd" name="fire_date_pdd" aria-label="fire_date_pdd" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">วันที่หมดอายุ</span>
                                            </div>
                                            <input type="date" class="form-control bg_prs" id="fire_date_exp" name="fire_date_exp" aria-label="fire_date_exp" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row mt-3"> 
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">รหัสถังดับเพลิง</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="fire_num" name="fire_num" aria-label="fire_num" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ชื่อ</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="fire_name" name="fire_name" aria-label="fire_name" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
                                </div>

                               
                                <div class="row mt-3">
                                    <div class="col-md-5">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ราคา</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="fire_price" name="fire_price" aria-label="fire_price" aria-describedby="inputGroup-sizing-sm">
                                        </div>  
                                    </div> 
                                    <div class="col-md-1 mt-2">
                                        <label for="fire_price">บาท</label>
                                    </div>
                                    <div class="col-md-6">  
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="fire_year">สถานะ</label>
                                            </div>                                          
                                            <select id="active" name="active" class="js-example-responsive" style="width: 75%">
                                                <option value="Y">ปกติ</option>
                                                <option value="N">ชำรุด</option> 
                                            </select>
                                        </div> 
                                    </div> 
                                </div>


                                <div class="row mt-3">

                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">สถานที่ตั้ง</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="fire_location" name="fire_location" aria-label="fire_location" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="inputGroup-sizing-sm">ขนาด(ปอนด์)</span>
                                            </div>
                                            <input type="text" class="form-control bg_prs" id="fire_size" name="fire_size" aria-label="fire_size" aria-describedby="inputGroup-sizing-sm">
                                        </div> 
                                    </div> 
 
                                </div>
 

                                <div class="row mt-3">
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="article_unit_id">หน่วยนับ </label>
                                    </div> --}}
                                    <div class="col-md-6">
                                        {{-- <div class="form-group">
                                            <select id="article_unit_id" name="article_unit_id"
                                                class="form-select form-select-lg show_unit" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_unit as $uni)
                                                    <option value="{{ $uni->unit_id }}">
                                                        {{ $uni->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="fire_year">หน่วยนับ</label>
                                            </div>
                                            <select class="js-example-responsive show_unit" id="article_unit_id" name="article_unit_id" style="width: 75%">  
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
                                            <label class="input-group-text" for="article_brand_id">ยี่ห้อ</label>
                                            </div>
                                            <select class="js-example-responsive show_brand" id="article_brand_id" name="article_brand_id" style="width: 75%">  
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

                                {{-- <div class="row mt-3"> 
                                    <div class="col-md-6">
                                      
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="article_brand_id">ยี่ห้อ</label>
                                            </div>
                                            <select class="js-example-responsive show_brand" id="article_brand_id" name="article_brand_id" style="width: 75%">  
                                                @foreach ($product_brand as $bra)
                                                    <option value="{{ $bra->brand_id }}">
                                                        {{ $bra->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="BRAND_INSERT" name="BRAND_INSERT"
                                                class="form-control form-control-sm shadow bg_prs" /> 
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">

                                            <button type="button" class="ladda-button btn-pill btn btn-sm btn-info bt_prs" onclick="addbrand();">
                                                <i class="fa-solid fa-square-plus me-2"></i>
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row mt-3">
                                    
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="fire_color">ถังสี </label>
                                    </div> --}}
                                    <div class="col-md-6">
                                        {{-- <div class="form-group">
                                            
                                            <select id="fire_color" name="fire_color" class="form-select form-select-lg" style="width: 100%">
                                                <option value="green">เขียว</option>
                                                <option value="red">แดง</option> 
                                                <option value="yellow">เหลือง</option> 
                                            </select>                                            
                                        </div> --}}

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <label class="input-group-text" for="fire_color">ถังสี</label>
                                            </div>
                                            <select class="js-example-responsive " id="fire_color" name="fire_color" style="width: 75%">  
                                                <option value="green">เขียว</option>
                                                <option value="red">แดง</option> 
                                                <option value="yellow">เหลือง</option>
                                            </select> 
                                        </div>

                                    </div>
                                    <div class="col"></div>

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
         
          $('#article_unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#fire_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#active').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
          $('#article_brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#fire_color').select2({
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
                            window.location="{{url('fire_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            
          
      });
</script>
@endsection