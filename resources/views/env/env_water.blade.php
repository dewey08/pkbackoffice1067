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
           border-top: 10px #2cc5a6 solid;
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
        {{-- <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>  --}}

       

        <div class="main-card card">
            <div class="card-header" >
                
                <form action="{{ route('env.env_water') }}" method="GET">
                    @csrf
                <div class="row"> 
                    <div class="col-md-4">
                        <h4 class="card-title"  style="color:rgba(21, 177, 60, 0.871)">รายระเอียดผลวิเคราะห์คุณภาพน้ำทิ้ง</h4>   
                    </div>
                    <div class="col"></div>
                    <div class="col-md-1 text-end">วันที่</div>
                    <div class="col-md-4 text-center">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $enddate }}" required/> 
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                                        ค้นหา
                                    </button> 
                                    
                                </form>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            ค้นหา
                        </button>                                
                    </div> --}}
                    <div class="col-md-1 text-end">
                        <a href="{{ url('env_water_add_pond') }}" class="btn btn-outline-success">เพิ่มข้อมูล</a> 
                    </div>
                </div>
            </div>

            <div class="card-body" >
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        {{-- <p>  --}}
                            {{-- <form action="{{ route('env.env_water') }}" method="GET">
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
                            </form> --}}
                            {{-- <div class="row"> --}}
                                <div class="row">
                                    <div class="card_audit_4">                                       
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs p-3" role="tablist">
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
                                                            <table id="example1" class="table table-striped">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(255, 251, 228);font-size: 14px;">ลำดับ</th>
                                                                        <th class="text-center" width="2%" style="background-color: rgb(222, 201, 248);font-size: 14px;">วันที่บันทึก</th>
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">สถานที่เก็บตัวอย่าง</th>
                                                                        <th class="text-center" width="3%" style="background-color: rgb(222, 201, 248);font-size: 14px;">ผู้บันทึก</th> 
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">หมายเหตุ</th>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(248, 252, 198);font-size: 14px;">คำสั่ง</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 1;$total1 = 0;  ?>
                                                                    @foreach ($datashow_1 as $item1)                                                        
                                                                        <tr>
                                                                            <th class="text-center"width="1%">{{ $i++ }}</th>
                                                                            <td class="text-center"width="2%">{{DateThai($item1->water_date)}}</td>
                                                                            <td class="text-center"width="5%">{{$item1->water_location}}</td>
                                                                            <td class="text-center"width="3%">{{$item1->water_user}}</td> 
                                                                            <td class="text-center"width="5%">{{$item1->water_comment}}</td>
                                                                            <td class="text-center"width="1%">
                                                                                <a href="{{url('env_water_edit/'.$item1->water_id)}}">
                                                                                    <i class="fa-regular fa-pen-to-square fa-2xl" style="color: #FFD43B;"></i>
                                                                                </a>
                                                                                {{-- <a href="{{url('wh_recieve_addsub/'.$item->water_id)}}" target="_blank">
                                                                                    <i class="fa-solid fa-cart-plus" style="color: #068fb9;font-size:20px"></i>
                                                                                </a> --}}                                                                        
                                                                            </td> 
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </p>
                                                    </div>

                                                    <div class="tab-pane" id="profile" role="tabpanel">
                                                        <p class="mb-0">
                                                            <table id="example2" class="table table-striped">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(255, 251, 228);font-size: 14px;">ลำดับ</th>
                                                                        <th class="text-center" width="2%" style="background-color: rgb(222, 201, 248);font-size: 14px;">วันที่บันทึก</th>
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">สถานที่เก็บตัวอย่าง</th>
                                                                        <th class="text-center" width="3%" style="background-color: rgb(222, 201, 248);font-size: 14px;">ผู้บันทึก</th> 
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">หมายเหตุ</th>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(248, 252, 198);font-size: 14px;">คำสั่ง</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 1;$total1 = 0;  ?>
                                                                    @foreach ($datashow_2 as $item2)                                                        
                                                                        <tr>
                                                                            <th class="text-center"width="2%">{{ $i++ }}</th>
                                                                            <td class="text-center"width="5%">{{DateThai($item2->water_date)}}</td>
                                                                            <td class="text-center"width="5%">{{$item2->water_location}}</td>
                                                                            <td class="text-center"width="5%">{{$item2->water_user}}</td> 
                                                                            <td class="text-center"width="5%">{{$item2->water_comment}}</td>
                                                                            <td class="text-center"width="5%">
                                                                                <a href="{{url('env_water_edit/'.$item2->water_id)}}">
                                                                                    <i class="fa-regular fa-pen-to-square fa-2xl" style="color: #FFD43B;"></i>
                                                                                </a>                                                                      
                                                                            </td> 
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="tab-pane" id="messages" role="tabpanel">
                                                        <p class="mb-0">
                                                            <table id="example3" class="table table-striped">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(255, 251, 228);font-size: 14px;">ลำดับ</th>
                                                                        <th class="text-center" width="2%" style="background-color: rgb(222, 201, 248);font-size: 14px;">วันที่บันทึก</th>
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">สถานที่เก็บตัวอย่าง</th>
                                                                        <th class="text-center" width="3%" style="background-color: rgb(222, 201, 248);font-size: 14px;">ผู้บันทึก</th> 
                                                                        <th class="text-center" width="5%" style="background-color: rgb(222, 201, 248);font-size: 14px;">หมายเหตุ</th>
                                                                        <th class="text-center" width="1%" style="background-color: rgb(248, 252, 198);font-size: 14px;">คำสั่ง</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 1;$total1 = 0;  ?>
                                                                    @foreach ($datashow_3 as $item3)                                                        
                                                                        <tr>
                                                                            <th class="text-center"width="1%">{{ $i++ }}</th>
                                                                            <td class="text-center"width="2%">{{DateThai($item3->water_date)}}</td>
                                                                            <td class="text-center"width="5%">{{$item3->water_location}}</td>
                                                                            <td class="text-center"width="3%">{{$item3->water_user}}</td> 
                                                                            <td class="text-center"width="5%">{{$item3->water_comment}}</td>
                                                                            <td class="text-center"width="1%">
                                                                                <a href="{{url('env_water_edit/'.$item3->water_id)}}">
                                                                                    <i class="fa-regular fa-pen-to-square fa-2xl" style="color: #FFD43B;"></i>
                                                                                </a>
                                                                                {{-- <a href="{{url('wh_recieve_addsub/'.$item->water_id)}}" target="_blank">
                                                                                    <i class="fa-solid fa-cart-plus" style="color: #068fb9;font-size:20px"></i>
                                                                                </a> --}}                                                                        
                                                                            </td> 
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </p>
                                                    </div>                                        
                                            </div>
                                            {{-- @endforeach --}}                                       

                                    </div>
                                </div> 

                            {{-- </div>  --}}
                        {{-- </p> --}}
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
        $('#example1').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();

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

        $('#Tabledit').Tabledit({
                url:'{{route("env.env_water_edittable")}}',                
                dataType:"json", 
                removeButton: false,
                columns:{
                    identifier:[1,'water_sub_id'], 
                    editable: [[2, 'water_list_idd'],[5, 'water_qty']]
                }, 
                deleteButton: false,
                saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        class:'btn btn-sm btn-default', 
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

        
        $("#spinner-div").hide(); 
    });
</script>
@endsection
 
 