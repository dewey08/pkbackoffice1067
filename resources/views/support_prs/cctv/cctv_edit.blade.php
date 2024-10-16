@extends('layouts.support_prs')
@section('title', 'PK-OFFICE || CCTV')

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
        border-top: 10px #1fdab1 solid;
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

        function editarticle(input) {
            var fileInput = document.getElementById('cctv_img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_upload_preview').attr('src', e.target.result);
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

        <form class="custom-validation" action="{{ route('tec.cctv_update') }}" method="POST" id="update_Form" enctype="multipart/form-data">
            @csrf
        <div class="row"> 
            <div class="col-md-3">
                <h4 class="card-title" style="color:rgb(10, 151, 85)">UPDATE CCTV</h4>
                <p class="card-title-desc">แก้ไขข้อมูลครุภัณฑ์กล้องวงจรปิด</p>
            </div>
             
        </div> 

        <div class="row">
            <div class="col-md-12">
              
                <div class="card card_prs_4">
                    
                    <div class="card-body">
 
                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> 
                        <input type="hidden" name="cctv_list_id" id="cctv_list_id" value="{{ $dataedits->cctv_list_id }}">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group"> 
                                    @if ($dataedits->cctv_img == null)
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                            height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/cctv/' . $dataedits->cctv_img) }}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @endif
                                    <br>
                                    <div class="input-group mt-3"> 
                                        <input type="file" class="form-control" id="cctv_img" name="cctv_img" onchange="editarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2 text-end">
                                        <label for="cctv_list_year">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="cctv_list_year" name="cctv_list_year" class="form-select form-select-lg" style="width: 100%">
                                                <option value="">ปีงบประมาณ</option> 
                                                    {{-- @foreach ($budget_year as $ye)
                                                        @if ($ye->leave_year_id == $date)
                                                            <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
                                                        @else
                                                            <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }} </option>
                                                        @endif
                                                    @endforeach --}}
                                                    @foreach ($budget_year as $year)
                                                    @if ($dataedits->cctv_list_year == $year->leave_year_id)
                                                        <option value="{{ $year->leave_year_id }}" selected> {{ $year->leave_year_id }} </option>
                                                    @else
                                                        <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="cctv_recive_date">วันที่รับเข้า</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="cctv_recive_date" type="date" class="form-control form-control-sm" name="cctv_recive_date" value="{{$dataedits->cctv_recive_date}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="cctv_list_num">รหัสกล้อง</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="cctv_list_num" type="text" class="form-control form-control-sm" name="cctv_list_num" value="{{$dataedits->cctv_list_num}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="cctv_list_name">ชื่อกล้อง</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="cctv_list_name" type="text" class="form-control form-control-sm" name="cctv_list_name" value="{{$dataedits->cctv_list_name}}">
                                        </div>
                                    </div>
                                </div>
 
 


                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="cctv_type">ประเภท </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="cctv_type" name="cctv_type" class="form-select form-select-lg" style="width: 100%">
                                                @if ($dataedits->cctv_type == 'OUT')
                                                    <option value="OUT" selected>-- OUT --</option>
                                                    <option value="IN">-- IN --</option>
                                                @else
                                                    <option value="OUT">-- OUT --</option>
                                                    <option value="IN" selected>-- IN --</option>    
                                                @endif
                                               
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <label for="article_deb_subsub_id">Monitor </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="cctv_monitor" type="text" class="form-control form-control-sm" name="cctv_monitor" value="{{$dataedits->cctv_monitor}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_decline_id">สถานที่ติดตั้ง </label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                             <textarea class="form-control" name="cctv_location" id="cctv_location" rows="3">{{$dataedits->cctv_location}}</textarea>
                                        </div>
                                    </div> 
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_decline_id">รายละเอียด </label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <textarea class="form-control" name="cctv_location_detail" id="cctv_location_detail" rows="3">{{$dataedits->cctv_location_detail}}</textarea>
                                        </div>
                                    </div>
 
                                </div>

                                
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        แก้ไขข้อมูล
                    </button>
                    <a href="{{ url('cctv_list') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>

</form>
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

            $('#cctv_list_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#cctv_type').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_tonnage_number').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_decline_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_buy_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_method_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_budget_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#medical_typecat_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
  
          $('#article_deb_subsub_id').select2({
              placeholder:"--หน่วยงาน--",
              allowClear:true
          });
          $('#article_categoryid').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
        
          $('#article_decline_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_typeid').select2({
              placeholder:"ประเภทวัสดุ",
              allowClear:true
          });
          $('#article_unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_spypriceid').select2({
              placeholder:"ราคาสืบ",
              allowClear:true
          });
          $('#product_groupid').select2({
              placeholder:"ชนิดวัสดุ",
              allowClear:true
          });
          $('#article_buy_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#vendor_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#cctv_status').select2({
              placeholder:"--สถานะ--",
              allowClear:true
          });  
          $('#article_brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#room_type').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#building_type_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          }); 
          $('#land_province').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_province_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_district_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_tumbon_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_user_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          }); 

          $('#update_Form').on('submit',function(e){
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
                          title: 'แก้ไขข้อมูลสำเร็จ',
                          text: "You Edit data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            // window.location.reload();
                            window.location="{{url('cctv_list')}}";  
                          }
                        })      
                      }
                    }
                  });
            }); 



        });
    </script>
@endsection
