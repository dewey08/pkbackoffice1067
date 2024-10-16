@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
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
?>
 
<?php
 
$datenow = date('Y-m-d');
?>

 
 

<div class="container-fluid" style="width: 100%">
    <div class="row ">
        <div class="col-md-4">
            <h3 style="color:green ">บ่อปรับเสถียร</h3>
            <p class="card-title-desc">ข้อมูลตรวจวัดค่าพารามิเตอร์</p>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-2 text-end">
            <label for="water_date">วันที่บันทึก :</label>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="water_date" type="date"
                    class="form-control form-control-sm" name="water_date" value="{{$datenow}}">
            </div>
        </div>
        <div class="col-md-2 text-end">
            <label for="water_user">ผู้บันทึก :</label>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                    <select id="water_user1" name="water_user"
                    class="form-control form-control-sm" style="width: 100%">
                    <option value="">--เลือก--</option>
                    @foreach ($users as $ue) 
                        @if ($iduser == $ue->id )
                        <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option>  
                        @else
                        <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>  
                        @endif                                     
                    @endforeach
                </select>
            </div>
        </div>        
    </div>

    {{-- <label for=""></label>  --}}

    <div class="row">        
        {{-- <div class="col"></div>       --}}
        <div class="col-md-12">            
        
                {{-- <table id="example" class="table table-bordered" border="1px">
                    <thead>
                        <tr >
                            <th width="3%">ลำดับ</td>
                            <th width="15%">รายการพารามิเตอร์</th>     
                            <th width="10%">ผลการวิเคราะห์</th>
                            <th width="7%">หน่วย</th>   
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 1; ?>
                        @foreach($env_pond_sub as $items) 
                            <tr height="20">                                             
                                <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>                                           
                                <td>
                                    <input type="hidden" value="{{ $items->pond_id }}" name="pond_id[]" id="pond_id[]" class="form-control input-sm fo13" >
                                    <input value="{{ $items->water_parameter_name }}" name="" id="" class="form-control input-sm fo13" readonly>
                                </td> 
                                <td><input style="text-align: center" name="water_qty[]" id="water_qty[]" class="form-control input-sm fo13" type="text" required></td> 
                                <td>
                                    <input style="text-align: center" value="{{ $items->water_parameter_unit }}" name="water_parameter_unit[]" id="water_parameter_unit[]" class="form-control input-sm fo13" readonly > 
                                </td> 
                            </tr>
                        
                        @endforeach 
                    </tbody>
                </table>  --}}
                {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap"> --}}
                {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                          
                            <th width="5%" class="text-center">ลำดับ</th>  
                            <th class="text-center" width="5%">vn</th> 
                            <th class="text-center">an</th>
                            <th class="text-center" >hn</th>
                            <th class="text-center" >cid</th>
                            <th class="text-center">ptname</th>
                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($env_pond_sub as $item) 
                            <tr>                                                  
                                <td class="text-center" width="5%">{{ $i++ }}</td>    
                                <td class="text-center" width="5%">{{ $item->water_parameter_name }}</td> 
                                <td class="text-center" width="5%"></td>  
                                <td class="text-center" width="10%">{{ $item->water_parameter_unit }}</td>   
                                <td class="text-center" width="10%">{{ $item->water_parameter_unit }}</td>   
                                <td class="text-center" width="10%">{{ $item->water_parameter_unit }}</td>   
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
                <div class="table-responsive">
                    <table id="example5"
                        class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="3%">ลำดับ</td>
                                <th width="15%">รายการพารามิเตอร์</th>     
                                <th width="10%">ผลการวิเคราะห์</th>
                                <th width="7%">หน่วย</th>   
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <?php $jj = 1; ?>
                            @foreach ($env_pond_sub as $item)
                           
                                <tr>
                                    <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                    <td class="text-center" width="10%"> f</td> 
                                   
                                    <td class="text-center" width="15%">ตุลาคม</td> 
                                 
                                    <td class="text-center text-primary" width="15%">
                                        f                                                           
                                    </td>
                                    <td class="text-center" width="15%" style="color:rgb(23, 121, 233)">00</td> 
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
        </div> 
    </div>
    {{-- <div class="card-footer">
        <div class="col-md-11 text-end">
            <div class="form-group">

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    บันทึกข้อมูล
                </button>

                <a href="{{ url('env_water') }}" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ยกเลิก
                </a>
            </div>    
        </div>
        <div class="col"></div>
    </div> --}}

    <div class="row mt-3">  
        <div class="col-md-12 text-end">
            <div class="form-group"> 
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    บันทึกข้อมูล
                </button>

                <a href="{{ url('env_water') }}" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ยกเลิก
                </a>
            </div>    
        </div>  
    </div>

</div>

@endsection
@section('footer')
<script>
    
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        // $('#datepicker').datepicker({
        //     format: 'yyyy-mm-dd'
        // });
        // $('#datepicker2').datepicker({
        //     format: 'yyyy-mm-dd'
        // });

        // $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        // });
        // ช่องค้นหาชื่อ
        // $('#water_user1').select2({
        //         placeholder: "--เลือก--",
        //         allowClear: true
        //     });
        // ช่องค้นหาชื่อ
        //     $('#env_pond').select2({
        //     placeholder: "--เลือก--",
        //     allowClear: true
        // }); 
       
       
    });
</script>

@endsection
