@extends('layouts.dentals')
@section('title', 'PK-OFFICER || ทันตกรรม')
@section('content')
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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;


$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();

?>

@section('content')



{{-- <div class="container" style="width: 97%"> --}}
    <div class="row ">
        <div class="col-md-12">
            <div class="card card_prs_4">

                <div class="card-header">
                    <div class="d-flex">
                        <div class="">
                            <label for="">เพิ่มรายการนัด </label>
                        </div>
                        <div class="ms-auto">

                        </div>
                    </div>
                </div>

                <div class="card-body shadow-lg">
                    <form class="custom-validation" action="{{ route('den.dental_appointment_save') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <div class="row">

                            <div class="col-md-12">
                                <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->

                                <div class="row">
                                    <div class="col-md-1 text-end">
                                        <label for="dent_hn">HN :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="dent_hn" name="dent_hn" class="form-control-sm d12font input_new" style="width: 100%" onchange="hnDent()">
                                                <option value="">--เลือก--</option>
                                                @foreach ($hn as $ph)
                                                    
                                                    <option value="{{ $ph->hn }}"> {{ $ph->hn }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <label for="" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:13px">ข้อมูลคนไข้ :</label>
                                    </div>
                                    <div class="col-md-6">                          
                                        <div id="show_detailpatient" ></div>                                     
                                    </div>
                                                                        
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-1 text-end">
                                        <label for="dent_date">วันที่นัด :</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            {{-- <div class="form-group"> --}}
                                                {{-- <input id="dent_date" type="date" class="form-control form-control-sm" name="dent_date"> --}}
                                                <input type="text" class="form-control-sm input_new" name="datepicker" id="datepicker" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $date_now }}"/>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 text-end">
                                        <label for="dent_time">เวลานัด :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="time" id="dent_time" name="dent_time" class="form-control-sm input_new" placeholder="" value="{{$mm}}" style="width: 100%" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 text-end">
                                            <label for="dent_doctor">ทันตแพทย์ผู้นัด :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="dent_doctor" name="dent_doctor" class="form-control-sm d12font input_new" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($users as $ue)
                                                        @if ($iduser == $ue->id)
                                                        <option value="{{ $ue->id }}" selected> {{ $ue->fname }} {{ $ue->lname }}</option>
                                                        @else
                                                        <option value="{{ $ue->id }}"> {{ $ue->fname }} {{ $ue->lname }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>    
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-1 text-end">
                                        <label for="appointment">ประเภทการนัด :</label>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select id="appointment" name="appointment" class="form-control-sm d12font input_new" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($appointment as $ap)                                                    
                                                    <option value="{{ $ap->appointment_id }}"> {{ $ap->appointment_name }}</option>                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-md-1 text-end">
                                        <label for="dent_work">งาน :</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <input id="dent_work" type="text" class="form-control-sm d12font input_new" name="dent_work" style="width: 100%">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>                             


                            </div>
                        </div>
                </div>

                <div class="card-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{-- <i class="fa-solid fa-floppy-disk me-2"></i> --}}
                                <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                บันทึกข้อมูล
                            </button>

                            <a href="{{ url('env_trash') }}" class="btn btn-danger btn-sm">
                                {{-- <i class="fa-solid fa-xmark me-2"></i> --}}
                                <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                ยกเลิก
                            </a>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>

</div>
{{-- </div> --}}


@endsection
@section('footer')
<script>
     function hnDent() {

        // alert('ใส่ข้อความที่ต้องการ');
            var denthn = document.getElementById("dent_hn").value;
                // var supplies_tax = document.getElementById("supplies_tax").value;
                // alert(denthn);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('dental_detail_patient')}}",
                    method: "GET",
                    data: {
                        denthn: denthn,
                        _token: _token
                    },
                    success: function (result) {
                        
                        $('#show_detailpatient').html(result);
                    }
                })
        }
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

       

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
        // ช่องค้นหาชื่อทันตแพทย์
        $('#dent_doctor').select2({
            placeholder: "--เลือก--",
            allowClear: true
            });

        // ช่องค้นหาHN
            $('#dent_hn').select2({
            placeholder: "--ค้นหา HN--",
            allowClear: true
            });
            
        // ช่องค้นหาประเภทการนัด
        $('#appointment').select2({
            placeholder: "--เลือกประเภทการนัด--",
            allowClear: true
        }); 

        $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
       
       
    });
</script>

@endsection