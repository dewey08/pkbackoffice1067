@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Report')
 
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
    
    
    <div class="tabs-animation">
         
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

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    {{-- <span class="spinner"></span> --}}
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </div>
            </div> 
        </div> 
        {{-- <div id="preloader_new">
            <div id="status">
                <div class="spinner"> </div>
                <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
            </div>
        </div> --}}

       
        <div class="row"> 
            <div class="col-md-4"> 
                <h4 style="color:rgb(255, 255, 255)">บันทึกการตรวจสอบถังดับเพลิง</h4> 
            </div>
            <div class="col"></div> 
    </div>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">   

                        <div class="row">
                            <div class="col text-start"> 
                                <p style="color:red;font-size:14px;">รายละเอียดถังดับเพลิง </p>
                            </div>
                            <div class="col-6 text-end">  
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-info btn-sm bt_prs Savestamp" data-url="{{url('fire_insert_stamall')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตรวจสอบ
                                </button>
                            </div>
                        </div>
                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center"><input type="checkbox" class="prscheckbox" name="stamp" id="stamp"> </th> 
                                            <th class="text-center" width="20%">รหัส</th> 
                                            <th class="text-center">รายการ</th>
                                            {{-- <th class="text-center" width="7%">dchdate</th>    --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_show as $item) 
                                            <tr>
                                                {{-- @if ($item->debit_total == '')
                                                    <td class="text-center" width="5%">
                                                        <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                    </td> 
                                                @else --}}
                                                    <td class="text-center" width="5%"><input type="checkbox" class="sub_chk prscheckbox" data-id="{{$item->fire_report_id}}"> </td> 
                                                {{-- @endif --}}
                                                <td class="text-center" width="20%">{{ $item->fire_num }}</td>   
                                                <td class="p-2" >{{ $item->fire_name }}</td> 
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </tbody>
                            </table>
                            </div>
                        </p>
                        {{-- @foreach ($fire_main as $item) 
                        <div class="row"> 
                                <div class="col text-start">
                                    @if ($item->fire_img == null)
                                        <img src="{{ asset('assets/images/defailt_img.jpg') }}" height="30px" width="30px"
                                            alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/air/' . $item->fire_img) }}" height="30px"
                                            width="30px" alt="Image" class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <p>รหัส : {{ $item->fire_num }}</p> 
                                </div> 
                        </div>
                        @endforeach --}}
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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#stamp').on('click', function(e) {
            if($(this).is(':checked',true))  
            {
                $(".sub_chk").prop('checked', true);  
            } else {  
                $(".sub_chk").prop('checked',false);  
            }  
            }); 
            
            $("#spinner-div").hide(); //Request is complete so hide spinner   
            $('.Savestamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการตรวจสอบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Check it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ตรวจสอบสำเร็จ',
                                                        text: "You Check data success",
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
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
                    // var check = confirm("Are you want ?");  
                }
            });      
            
            // $('#Process').click(function() {
            //     var startdate = $('#datepicker').val(); 
            //     var enddate = $('#datepicker2').val(); 
            //     Swal.fire({
            //             title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
            //             text: "You Want Process Data!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, Want Process it!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $("#overlay").fadeIn(200);　
            //                     $("#spinner").show(); //Load button clicked show spinner 
                                
            //                     $.ajax({
            //                         url: "{{ route('tec.cctv_report_process') }}",
            //                         type: "POST",
            //                         dataType: 'json',
            //                         data: {startdate,enddate},
            //                         success: function(data) {
            //                             if (data.status == 200) { 
            //                                 Swal.fire({
            //                                     title: 'ประมวลผลข้อมูลสำเร็จ',
            //                                     text: "You Process data success",
            //                                     icon: 'success',
            //                                     showCancelButton: false,
            //                                     confirmButtonColor: '#06D177',
            //                                     confirmButtonText: 'เรียบร้อย'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         window.location.reload();
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(200);
            //                                             },400);
            //                                     }
            //                                 })
            //                             } else if (data.status == 100) {
            //                                 const Toast = Swal.mixin({
            //                                     toast: true,
            //                                     position: "top-end",
            //                                     showConfirmButton: false,
            //                                     timer: 3000,
            //                                     timerProgressBar: true,
            //                                     didOpen: (toast) => {
            //                                         toast.onmouseenter = Swal.stopTimer;
            //                                         toast.onmouseleave = Swal.resumeTimer;
            //                                     }
            //                                     });
            //                                     Toast.fire({
            //                                     icon: "error",
            //                                     title: "กรุณาเลือกวันที่"
            //                                     });
            //                                     $('#spinner').hide();//Request is complete so hide spinner
            //                                         setTimeout(function(){
            //                                             $("#overlay").fadeOut(200);
            //                                         },400);
            //                             } else {
                                             
            //                             }
            //                         },
            //                     });
                                
            //                 }
            //     })
            //  });
             
           
         
            
        });
    </script>
    @endsection
