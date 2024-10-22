@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
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
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน 

    use Illuminate\Support\Facades\DB;
?>
  
<div class="tabs-animation">
    
        <div class="row text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
              
        </div> 

       

        <div class="main-card mb-3 card">
            <div class="card-header">
                รายระเอียดผลวิเคราะห์คุณภาพน้ำทิ้ง
                
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('env_water_add_pond') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูล</a>                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('env.env_water') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2 text-end">วันที่</div>
                                    <div class="col-md-4 text-center">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}" required/> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                                            ค้นหา
                                        </button>                                
                                    </div>
                                        
                                </div>
                            </form>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">บ่อปรับเสถียร</span>    
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                <span class="d-none d-sm-block">บ่อคลองวนเวียน</span>    
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                <span class="d-none d-sm-block">บ่อสัมผัสคลอลีน</span>    
                                            </a>
                                        </li>
                                       
                                       
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                     
                                            <div class="tab-pane active" id="home" role="tabpanel">
                                                <p class="mb-0">
                                                    <table class="table table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th class="text-center"width="1%">ลำดับ</th>
                                                            <th class="text-center"width="2%">วันที่บันทึก</th>
                                                            <th class="text-center"width="2%">สถานที่เก็บตัวอย่าง</th>
                                                            <th class="text-center"width="2%">ผู้บันทึก</th> 
                                                            <th class="text-center"width="3%">หมายเหตุ</th>
                                                            <th class="text-center"width="2%">คำสั่ง</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;$total1 = 0;  ?>
                                                            @foreach ($datashow_1 as $item)                                                        
                                                                <tr>
                                                                    <th class="text-center">{{ $i++ }}</th>
                                                                    <td class="text-center">{{$item->water_date}}</td>
                                                                    <td class="text-center">{{$item->water_location}}</td>
                                                                    <td class="text-center">{{$item->water_user}}</td> 
                                                                    <td class="text-center">{{$item->water_comment}}</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                ทำรายการ 
                                                                            </button>
                                                                                {{-- <div class="dropdown-menu">
                                                                                    <a class="dropdown-item menu" data-bs-toggle="modal"
                                                                                        data-bs-target="#waterModal{{ $item->water_id }}"
                                                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                                                        data-bs-custom-class="custom-tooltip" title="รายละเอียด">
                                                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                                        <label for=""style="color: rgb(33, 187, 248);font-size:13px">รายละเอียด</label>
                                                                                    </a>
                                                                                    <a class="dropdown-item text-warning"
                                                                                        href="{{ url('env_water_edit/' . $item->water_id) }}"
                                                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                                                        data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                                        <label for=""style="color: rgb(7191, 24, 224);font-size:13px">แก้ไข</label>
                                                                                    </a>
                                                                                    <a class="dropdown-item text-danger" href="{{url('env_water_delete/'.$item->water_id)}}"
                                                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                                                        data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                                        <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                                        <label for="" style="color: rgb(255, 22, 22);font-size:13px">ลบ</label>
                                                                                    </a>                                                                                    
                                                                                </div> --}}
                                                                        </div>
                                                                    </td> 
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                      </table>
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="profile" role="tabpanel">
                                                <p class="mb-0">
                                                    <table class="table table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">First</th> 
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $ii = 1;$total1 = 0;  ?>
                                                            @foreach ($datashow_2 as $item2)
                                                        
                                                                <tr>
                                                                    <th scope="row">{{ $ii++ }}</th>
                                                                    {{-- <td>{{$item2->water_date}}</td>  --}}
                                                                </tr>
                                                          @endforeach
                                                        </tbody>
                                                      </table>
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="messages" role="tabpanel">
                                                <p class="mb-0">
                                                    Etsy mixtape wayfarers, ethical wes anderson tofu before they
                                                    sold out mcsweeney's organic lomo retro fanny pack lo-fi
                                                    farm-to-table readymade. Messenger bag gentrify pitchfork
                                                    tattooed craft beer, iphone skateboard locavore carles etsy
                                                    salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                                    Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                                    mi whatever gluten yr.
                                                </p>
                                            </div>
                                      
                                        
                                        
                                    </div>
                                    {{-- @endforeach --}}

                                </div> 
                            </div> 
                        </p>
                    </div>
                     
                </div>
            </div>
            
        </div>
</div>  

      
@endsection
@section('footer')

<script>
    
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

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

        
        $("#spinner-div").hide(); 
    });
</script>
@endsection
 
 