@extends('layouts.nurse')
@section('title', 'PK-OFFICE || nurse')
@section('content')
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
            border-top: 10px #d22cf3 solid;
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
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function otone_destroy(ot_one_id) {
            Swal.fire({
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
                        url: "{{ url('otone_destroy') }}" + '/' + ot_one_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + ot_one_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
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
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    $countpermiss_ot = StaticController::countpermiss_ot($iduser);
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
        
        <div class="row"> 
            <div class="col-md-8"> 
                <h3 style="color:green">จำนวนอัตรากำลังกลุ่มภารกิจด้านการพยาบาล</h3> 
            </div>
            <div class="col"></div> 
            <div class="col-md-3 text-end">
                <input type="hidden" name="data_insert" id="data_insert" value="1">
                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary card_audit_4c" id="Pulldata">
                    <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                    <span class="ladda-spinner"></span>
                </button>
                <a href="{{url('nurse_index_excel')}}" class="ladda-button btn-pill btn btn-success card_audit_4c">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Export To Excel</span>  
                </a>
            </div>
        </div>
         
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_audit_4c">
                    <div class="card-body">
                        <div class="table-responsive">  
                                <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 13px">                                        
                                        <th class="text-center" rowspan="2" style="background: #fdf7e4">ward</th>
                                        <th class="text-center" width="15%" rowspan="2" style="background: #fdf7e4">ward name</th> 
                                        <th class="text-center" style="background: #e4fdfc">ยอดผู้ป่วย</th> 
                                        <th class="text-center" style="background: #e4fdfc" colspan="2">จำนวนพยาบาลเวรเช้า</th>
                                        <th class="text-center" style="background: #e4fdfc" rowspan="2">Nursing <br> product</th>

                                        <th class="text-center" style="background: #dadffa">ยอดผู้ป่วย</th> 
                                        <th class="text-center" style="background: #dadffa" colspan="2">จำนวนพยาบาลเวรบ่าย</th>
                                        <th class="text-center" style="background: #dadffa" rowspan="2">Nursing<br> product</th>

                                        <th class="text-center" style="background: #fadbda">ยอดผู้ป่วย</th> 
                                        <th class="text-center" style="background: #fadbda" colspan="2">จำนวนพยาบาลเวรดึก</th> 
                                        <th class="text-center" style="background: #fadbda" rowspan="2">Nursing<br> product</th>  
                                    </tr>
                                    <tr style="font-size: 13px"> 
                                        <th class="text-center" style="background: #fde4f8">8.00</th>
                                        <th class="text-center" style="background: #fde4f8">ควรจะเป็น</th>
                                        <th class="text-center" style="background: #fde4f8">ขึ้นจริง</th> 

                                        <th class="text-center" style="background: #fde4f8">16.00</th>
                                        <th class="text-center" style="background: #fde4f8">ควรจะเป็น</th>
                                        <th class="text-center" style="background: #fde4f8">ขึ้นจริง</th> 

                                        <th class="text-center" style="background: #fde4f8">24.00</th>
                                        <th class="text-center" style="background: #fde4f8">ควรจะเป็น</th>
                                        <th class="text-center" style="background: #fde4f8">ขึ้นจริง</th>                                          
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                        $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0;
                                        $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;
                                    ?>
                                    @foreach ($datashow as $item) 
                                        <tr style="font-size:13px"> 
                                            <td class="text-center" width="5%" >{{ $item->ward }} </td>
                                            <td class="p-2"> {{ $item->ward_name }}</td>

                                            <td class="text-center" width="7%">{{ $item->count_an1 }} </td> 
                                            <td class="text-center" width="7%">{{$item->soot_a}} </td> 
                                            <td class="text-center" width="7%">{{ $item->np_a }} </td>
                                            <td class="text-center" width="7%"> {{number_format($item->soot_a_total, 2) }}</td>

                                            <td class="text-center" width="7%">{{ $item->count_an2 }} </td>  
                                            <td class="text-center" width="7%">{{ $item->soot_b }} </td>  
                                                <td class="text-center" width="7%"> {{$item->np_b}} </td>                                          
                                            <td class="text-center" width="7%">{{number_format($item->soot_b_total, 2) }}</td>

                                            <td class="text-center" width="7%">{{ $item->count_an3 }} </td>  
                                            <td class="text-center" width="7%">{{ $item->soot_c}} </td>  
                                            <td class="text-center" width="7%"> {{$item->np_c}} </td>                                          
                                            <td class="text-center" width="7%">{{number_format($item->soot_c_total, 2) }}</td>
                                        </tr>
                                        <?php 
                                        $total1 = $total1 + $item->count_an1;
                                        $total2 = $total2 + $item->soot_a;
                                        $total3 = $total3 + $item->np_a;
                                        $total4 = $total4 + $item->soot_a_total;
                                        $total5 = $total5 + $item->count_an2;
                                        $total6 = $total6 + $item->soot_b;
                                        $total7 = $total7 + $item->np_b;
                                        $total8 = $total8 + $item->soot_b_total;
                                        $total9 = $total9 + $item->count_an3;
                                        $total10 = $total10 + $item->soot_c;
                                        $total11 = $total11 + $item->np_c;
                                        $total12 = $total12 + $item->soot_c_total;
                                    ?>
                                    @endforeach
                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #f7e0e0"></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{$total1 }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total2}}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total3}}</label> </td>
                                    <td class="text-center" style="background-color: #ace2fc"><label for="">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total5 }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total6 }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{$total7 }}</label></td>
                                    <td class="text-center" style="background-color: #65ccfc"><label for="">{{ number_format($total8, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total9 }}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total10}}</label></td>
                                    <td class="text-center" style="background-color: #fadbda"><label for="">{{ $total11 }}</label></td>
                                    <td class="text-center" style="background-color: #f8b6b4"><label for="">{{ number_format($total12, 2) }}</label></td> 
                                </tr>  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      

    </div>
@endsection
@section('footer') 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#Tabledit').Tabledit({
                url:'{{route("d.nurse_index_editable")}}',
                
                dataType:"json",
                // editButton: true,
                removeButton: false,
                columns:{
                    identifier:[0,'ward'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3']]
                    editable: [[4, 'np_a'], [8, 'np_b'], [12, 'np_c']]
                },
                // restoreButton:false,
                deleteButton: false,
                saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        class:'btn btn-sm btn-default',
                        // class: 'btn-icon btn-shadow btn-dashed btn btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
                        action: 'Edit'
                    }
                },
                // onSuccess:function(data,textStatus,jqXHR)
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
                    // if (data.action == 'Edit') 
                    // {
                    //     // $('#'+data.icode).remove();
                    //     window.location.reload();
                    // }
                }

            });
 
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

            $(document).on('click', '#printBtn', function() {
                var month_id = $(this).val();
                alert(month_id);

            });

            $("#spinner-div").hide(); //Request is complete so hide spinner
         
         $('#Pulldata').click(function() {
             var data_insert = $('#data_insert').val(); 
            //  var datepicker2 = $('#datepicker2').val(); 
             Swal.fire({
                 position: "top-end",
                     title: 'ต้องการประมวลผลใช่ไหม ?',
                     text: "You Warn Process Data!",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, Process it!'
                     }).then((result) => {
                         if (result.isConfirmed) {
                             $("#overlay").fadeIn(300);　
                             $("#spinner").show(); //Load button clicked show spinner 
                             
                             $.ajax({
                                 url: "{{ route('d.nurse_index_process') }}",
                                 type: "POST",
                                 dataType: 'json',
                                 data: {
                                    data_insert                       
                                 },
                                 success: function(data) {
                                     if (data.status == 200) { 
                                         Swal.fire({
                                             position: "top-end",
                                             title: 'ประมวลผลสำเร็จ',
                                            text: "You Process data success",
                                             icon: 'success',
                                             showCancelButton: false,
                                             confirmButtonColor: '#06D177',
                                             confirmButtonText: 'เรียบร้อย'
                                         }).then((result) => {
                                             if (result
                                                 .isConfirmed) {
                                                 console.log(
                                                     data);
                                                 window.location.reload();
                                                 $('#spinner').hide();//Request is complete so hide spinner
                                                     setTimeout(function(){
                                                         $("#overlay").fadeOut(300);
                                                     },500);
                                             }
                                         })
                                     } else {
                                         
                                     }
                                 },
                             });
                             
                         }
             })
         });
 
 
        });
    </script>

@endsection
