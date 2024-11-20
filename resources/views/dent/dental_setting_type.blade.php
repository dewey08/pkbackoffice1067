@extends('layouts.dentals')
@section('title', 'PK-OFFICER || ทันตกรรม')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #fcdcf5 1px;
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
                <div class="btn-actions-pane-right">
                    <div class="col-md-12 text-end">
                        <a href="{{ url('dental_setting_type_add') }}" class="mb-1 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูล</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('t.time_nurs_dep') }}" method="POST">
                                @csrf
                            </form>  
                            <div class="table-responsive mt-3">
                                <div class="col-md-4">  
                                    <h4 style="color:rgb(206, 29, 147)">ประเภทการนัดคนไข้</h4>  
                                </div>
                                <table class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%; id="example2">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 16px;" width="5%">ลำดับ</th> 
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 16px;" width="10%">ชื่อประเภท</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 16px;" width="10%">สถานะ</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 16px;" width="10%">ตั้งค่า</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $date = date('Y');
                                        ?>
                                        @foreach ($dent_appointment_type as $item)
                                            <tr id="sid{{ $item->appointment_id }}">
                                                <td class="text-center" width="3%">{{ $i++ }}</td>
                                                <td class="p-2" width="18%">{{ $item->appointment_name }} </td>
                                                <td class="text-center" width="5%">
                                                    @if($item-> status == 'Y' )
                                                        <input type="checkbox" id="{{ $item-> appointment_id }}" name="{{ $item-> appointment_id }}" switch="none" onchange="switchactive({{ $item-> appointment_id }});" checked />
                                                        @else
                                                        <input type="checkbox" id="{{ $item-> appointment_id }}" name="{{ $item-> appointment_id }}" switch="none" onchange="switchactive({{ $item-> appointment_id }});" />
                                                        @endif
                                                        <label for="{{ $item-> appointment_id }}" data-on-label="On" data-off-label="Off"></label>
                                                </td>

                                                <td class="text-center" width="7%">
                                                    <a href="{{url('dental_setting_type_edit/'.$item->appointment_id)}}">
                                                        {{-- <i class="fa-solid fa-pen-to-square fa-xl" style="color: #068e0f;"></i> --}}
                                                        <img src="{{ asset('images/Edit.png') }}" height="25px" width="25px">
                                                    </a>
                                                    
                                                    <a href="{{url('dental_setting_type_delete/'.$item->appointment_id)}}">
                                                        {{-- <i class="fa-solid fa-trash fa-square fa-xl" style="color: #e60f24;"></i> --}}
                                                        <img src="{{ asset('images/remove.png') }}" height="25px" width="25px">
                                                    </a>                                                                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    function switchactive(idfunc){
            // var nameVar = document.getElementById("name").value;
            var checkBox = document.getElementById(idfunc);
            var onoff;
            
            if (checkBox.checked == true){
                onoff = "Y";
            } else {
                onoff = "N";
            }
 
            var _token=$('input[name="_token"]').val();
                $.ajax({
                        url:"{{route('den.dental_switchactive')}}",
                        method:"GET",
                        data:{onoff:onoff,idfunc:idfunc,_token:_token}
                })
       }
</script>
{{-- <script>
    
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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('#HR_DEPARTMENT_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Savetime').click(function() {
            var startdate = $('#datepicker').val();
            var enddate = $('#datepicker2').val();
            var HR_DEPARTMENT_SUB_ID = $('#HR_DEPARTMENT_SUB_ID').val();
            var HR_DEPARTMENT_SUB_SUB_ID = $('#HR_DEPARTMENT_SUB_SUB_ID').val(); 
            $.ajax({
                url: "{{ route('t.time_index_excel') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    startdate,
                    enddate,
                    HR_DEPARTMENT_SUB_ID,
                    HR_DEPARTMENT_SUB_SUB_ID
                },
                success: function(data) {
                    if (data.status == 200) { 
                        Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else {

                    }

                },
            });
        });  
    });
</script>
<script>
    $('.department').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.department')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });

    $('.department_sub').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.departmenthsub')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });
</script> --}}
@endsection
 
 