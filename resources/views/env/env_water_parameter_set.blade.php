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
    function env_parameter_destroy(pond_sub_id) {
        Swal.fire({
            position: "top-end",
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('env_parameter_destroy') }}" + '/' + pond_sub_id,
                    type: 'POST',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                position: "top-end",
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + pond_sub_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //
                                }
                            })
                        } else {

                        }

                    }
                })
            }
        })
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

        <div class="row">
            <div class="col-md-3">
                <h4 style="color:#096825">รายละเอียดั้งค่าบ่อบำบัด</h4>
                <p ></p>
            </div>
            <div class="col"></div>
            <div class="col-md-2 text-end">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                    เพิ่มข้อมูลบ่อบำบัด
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6">
                <div class="main-card card p-3">
                    <table class="table table-sm" id="example" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อบ่อบำบัด</th>
                                <th class="text-center">เพิ่มพารามิเตอร์</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0;
                            $total1 = 0; ?>
                            @foreach ($datashow as $item)
                                <?php $number++; ?>
                                <tr id="#sid{{ $item->pond_id }}">
                                    <td class="text-center" width="5%">{{ $number }}</td>
                                    <td >
                                        <?php
                                             $data_sub_ = DB::connection('mysql')->select('
                                                SELECT * from env_pond_sub ps
                                                LEFT JOIN env_water_parameter w ON w.water_parameter_id = ps.water_parameter_id
                                                WHERE ps.pond_id = "'.$item->pond_id.'"');

                                        ?>
                                        <div id="headingTwo" class="b-radius-0 card-header">
                                                <button type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne2{{ $item->pond_id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                    <h5 style="color: rgb(3, 174, 180)">{{ $item->pond_name }} <label for="" style="color: rgb(84, 65, 250)"> !! รายละเอียด คลิก !!</label></h5>
                                                </button>


                                        </div>

                                        <div data-parent="#accordion" id="collapseOne2{{ $item->pond_id }}" class="collapse">
                                            <div class="card-body">
                                                <div class="row ms-2 me-2">
                                                    @foreach ($data_sub_ as $itemsub)
                                                        <div class="col-md-2">
                                                            @if ($itemsub->water_parameter_id != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" onclick="env_parameter_destroy({{ $itemsub->pond_sub_id }})">

                                                                    {{$itemsub->water_parameter_short_name}}
                                                                </button>
                                                            @endif

                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center" width="10%">
                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addparameterModal" value="{{ $item->pond_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="เพิ่ม Parameter">
                                            <i class="fa-solid fa-plus text-success"></i>
                                            Parameter
                                        </button>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>

<!-- Insert Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ตั้งค่าบ่อบำบัด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="pond_name" class="form-label">ชื่อบ่อบำบัด</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="pond_name" name="pond_name">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="user_id" id="user_id" value="{{$iduser}}">
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Savedata">
                    <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- addparameterModal Modal -->
<div class="modal fade" id="addparameterModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่ม Parameter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="editpond_id" class="form-label">รหัสบ่อบำบัด</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="editpond_id" name="editpond_id" readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="editpond_name" class="form-label">ชื่อบ่อบำบัด</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="editpond_name" name="editpond_name" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">

                        <div class="col-md-8">
                            <label for="editwater_parameter_id" class="form-label">เพิ่ม Parameter</label>
                            <div class="input-group input-group-sm">
                                <select name="editwater_parameter_id" id="editwater_parameter_id" class="form-control" style="width: 100%">
                                    <option value="">-Choose-</option>
                                    @foreach ($data_parameter as $item1)
                                        <option value="{{$item1->water_parameter_id}}">{{$item1->water_parameter_id}} {{$item1->water_parameter_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                <input type="hidden" name="user_id" id="adduser_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatetype">
                    <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>Save changes
                </button>
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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $('#addpttype').select2({
            dropdownParent: $('#addparameterModal')
        });



        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Updatetype').click(function() {
            var editpond_id       = $('#editpond_id').val();
            var editpond_name     = $('#editpond_name').val();
            var editwater_parameter_id = $('#editwater_parameter_id').val();
            // var editpond_sub_id   = $('#editpond_sub_id').val();
            // editwater_parameter_id
            $.ajax({
                url: "{{ route('env.env_parameter_save') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    editpond_id,
                    editpond_name,
                    editwater_parameter_id,
                    // editpond_sub_id
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            // position: "top-end",
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
                        Swal.fire({
                            // position: "top-end",
                            icon: "error",
                            title: 'อุ๊ยยย !!!',
                            text: "มีข้อมูลอยู่แล้ว",
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'OK เนาะ !!!'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    }

                },
            });
        });

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

         $('#Savedata').click(function() {
            // var pond_id = $('#pond_id').val();
            var pond_name = $('#pond_name').val();
            $.ajax({
                url: "{{ route('env.env_water_parameter_setsave') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    // pond_id,
                    pond_name
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

        $(document).on('click', '.addparameterModal', function() {
        var pondsub_id = $(this).val();
        // alert(pondsub_id);
        $('#addparameterModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('env_water_parameter_para_id') }}" + '/' + pondsub_id,
            success: function(response) {

                $('#editpond_id').val(response.data_main.pond_id)
                $('#editpond_name').val(response.data_main.pond_name)

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
</script>
@endsection

