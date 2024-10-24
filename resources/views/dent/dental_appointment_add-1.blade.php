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



<div class="container-fluid" style="width: 97%">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow">                 
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="">
                                    <label for="">เพิ่มการนัด</label>
                                </div>
                                <div class="ms-auto">
    
                                </div>
                            </div>
                        </div>

                        <div class="card-body shadow-lg">
                            <form class="custom-validation" action="{{ route('den.dental_appointment_save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                    <div class="row">                           
                                        <div class="col-md-8">
    
                                            <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->
    
                                            <div class="row">
                                                <div class="col-md-2 text-end">
                                                    <label for="dent_date">วันที่นัด :</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {{-- <input id="water_date" type="date" class="form-control form-control-sm" name="water_date" value="{{$datenow}}"> --}}
                                                        <input id="dent_date" type="text" class="form-control form-control-sm" name="dent_date" value="{{$datenow}}">
                                                    </div>
                                                </div>                                            
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2 text-end">
                                                    <label for="dent_time">เวลาที่นัด :</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {{-- <input id="water_date" type="date" class="form-control form-control-sm" name="water_date" value="{{$datenow}}"> --}}
                                                        <input id="dent_time" type="text" class="form-control form-control-sm" name="dent_time" value="{{$starttime}}">
                                                    </div>
                                                </div>                                            
                                            </div>

                                            <div class="col-md-1 text-end">
                                                <label for="water_user">ผู้บันทึก :</label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select id="water_user1" name="water_user" class="form-control form-control-sm" style="width: 100%">
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
                                    </div>
                            </div>

                                <div class="card-footer">
                                    <div class="col-md-12 text-end">
                                        <div class="form-group">
            
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                                บันทึกข้อมูล
                                            </button>
            
                                            <a href="{{ url('dental_setting_type') }}" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-xmark me-2"></i>
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
</div>
{{-- </div> --}}


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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        // ช่องค้นหาชื่อ
        $('#water_user2').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        // ช่องค้นหาชื่อ
            $('#trash_sub').select2({
            placeholder: "--เลือก--",
            allowClear: true
        }); 
       
       
    });
</script>

@endsection