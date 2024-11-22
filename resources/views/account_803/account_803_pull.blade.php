@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')
 
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
        <form action="{{ URL('account_803_pull') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-4">
                <h4 class="card-title" style="color:rgb(247, 31, 95)">Detail Account ผัง 1102050102.803</h4>
                <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control-sm cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-sm btn-sm btn-info cardacc" data-style="expand-left">
                            <span class="ladda-label">
                                {{-- <i class="fa-solid fa-magnifying-glass text-white me-2"></i> --}}
                                <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                ค้นหา</span>
                            {{-- <span class="ladda-spinner"></span> --}}
                        </button>
                    </form> 
                        <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc" data-style="expand-left" id="Pulldata">
                            <span class="ladda-label">
                                 {{-- <i class="fa-solid fa-file-circle-plus text-white me-2"></i> --}}
                                 <img src="{{ asset('images/pull_datawhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                 ดึงข้อมูล</span>
                            {{-- <span class="ladda-spinner"></span> --}}
                        </button>
                {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" id="Pulldata">
                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                    ดึงข้อมูล</button>     --}}
                  
            </div>
        </div>
        </div>
             
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                                             
                        <div class="row mb-3">
                            <div class="col-md-5 text-start"> 
                                @if ($activeclaim == 'Y')
                                  <button class="ladda-button me-2 btn-pill btn btn-info btn-sm cardacc" onclick="check()">Check</button>
                                  <input type="checkbox" id="myCheck" class="dcheckbox_ me-2" checked> 
                                  <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                                @else
                                  <button class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new" onclick="check()">Check</button>
                                  <input type="checkbox" id="myCheck" class="dcheckbox_ me-2"> 
                                  <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                                @endif 
                                  <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-warning input_new Claim" data-url="{{url('account_803_claim')}}">
                                      {{-- <i class="fa-solid fa-spinner me-2"></i> --}}
                                      <img src="{{ asset('images/loading_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                     ประมวลผล
                                 </button>
                                 <a href="{{url('account_803_zip')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new">
                                          {{-- <i class="fa-regular fa-file-zipper text-white me-2"></i>  --}}
                                          <img src="{{ asset('images/zipwhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                      Zip
                                  </a> 
                                  <button type="button" class="ladda-button me-2 btn-pill btn btn-sm input_new" style="background-color: rgb(241, 7, 136);color:#ffffff">
                                      {{-- <i class="fa-solid fa-cloud-arrow-up text-white me-2"></i> --}}
                                      <img src="{{ asset('images/Apiwhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                      API NHSO
                                  </button>
                                 
                              </div>
                            <div class="col"></div>
                            <div class="col-md-5 text-end">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-info cardacc Check_sit" data-url="{{url('account_803_checksit')}}">
                                    {{-- <i class="fa-solid fa-user me-2"></i> --}}
                                    <img src="{{ asset('images/Check_sitwhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    ตรวจสอบสิทธิ์
                                </button>
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-warning cardacc Claim" data-url="{{url('account_401_claim')}}">
                                     <i class="fa-solid fa-sack-dollar me-2"></i>
                                    Claim
                                </button>
                                <a href="{{url('account_401_claim_export')}}" class="ladda-button me-2 btn-pill btn btn-success cardacc">
                                    <i class="fa-solid fa-file-export text-white me-2"></i>
                                    Export Txt
                                </a>    --}}
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc Savestamp" data-url="{{url('account_803_stam')}}">
                                    {{-- <i class="fa-solid fa-file-waveform me-2"></i> --}}
                                    <img src="{{ asset('images/Stam_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    ตั้งลูกหนี้
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc Destroystamp" data-url="{{url('account_803_destroy')}}">
                                    {{-- <i class="fa-solid fa-trash-can me-2"></i> --}}
                                    <img src="{{ asset('images/removewhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    ลบ
                                </button>
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info Savestamp" data-url="{{url('account_803_stam')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button> --}}
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                style=" border-spacing: 0; width: 100%;"> --}}
                                <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                          
                                            <th width="5%" class="text-center">ลำดับ</th> 
                                            <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                                            <th class="text-center">ตั้งลูกหนี้</th>
                                            <th class="text-center">                                                                 
                                                <span class="bg-success badge">{{ $count_claim }}</span> เคลม
                                                <span class="bg-danger badge">{{ $count_noclaim }}</span>  
                                            </th> 
                                            <th class="text-center" style="background-color: #fad6b8">pdx</th>
                                            <th class="text-center" width="5%">vn</th> 
                                            {{-- <th class="text-center">an</th> --}}
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th> 
                                            <th class="text-center">vstdate</th>  
                                            {{-- <th class="text-center">pdx</th>  --}}
                                            <th class="text-center">pttype</th> 
                                            <th class="text-center">spsch</th>  
                                            <th class="text-center">ลูกหนี้</th>  
                                            <th class="text-center">Rep</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($acc_debtor as $item) 
                                            <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                         
                                                @if ($activeclaim == 'Y')
                                                    @if ($item->debit_total == '' || $item->pdx =='')
                                                        <td class="text-center" width="5%">
                                                            <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                        </td> 
                                                    @else
                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                    @endif  
                                                @else
                                                    <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                @endif
                                                
                                                <td class="text-center" width="5%">
                                                    @if ($item->stamp =='N')
                                                        <span class="bg-danger badge me-2">{{ $item->stamp }}</span> 
                                                    @else
                                                        <span class="bg-success badge me-2">{{ $item->stamp }}</span> 
                                                    @endif
                                                </td>  
                                                <td class="text-center" width="5%">
                                                    @if ($item->active_claim =='N')
                                                        <span class="bg-danger badge me-2">{{ $item->active_claim }}</span> 
                                                    @else
                                                        <span class="bg-success badge me-2">{{ $item->active_claim }}</span> 
                                                    @endif 
                                                </td> 
                                                <td class="text-start" width="5%">
                                                    @if ($item->pdx != NULL)
                                                        <span class="bg-info badge">{{ $item->pdx }}</span> 
                                                    @else
                                                        <span class="bg-warning badge">-</span> 
                                                    @endif 
                                                </td>
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                {{-- <td class="text-center" width="5%">{{ $item->an }}</td>  --}}
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
                                                
                                                <td class="text-center" width="10%">{{ $item->vstdate }}</td>  
                                                {{-- <td class="text-start" width="5%">{{ $item->pdx }}</td>   --}}
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td> 
                                                
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td> 
                                                
                                                {{-- <td class="text-center" width="10%">{{ number_format($item->income, 2) }}</td>  --}}
                                                <td class="text-center" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
                                                <td class="text-center" width="6%">
                                                    @if ($item->rep_pay =='')
                                                        <span class="bg-danger badge me-2">*-*</span> 
                                                    @else
                                                        <span class="bg-success badge me-2">{{ number_format($item->rep_pay, 2) }}</span> 
                                                    @endif  
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
    </div>
  

    @endsection
    @section('footer')
    <script>
        function check() {
        var onoff; 
        document.getElementById("myCheck").checked = true;
        onoff = "Y";
          var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_803_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token},
                    success:function(data){ 
                        if (data.status == 200) { 
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your open function success",
                            showConfirmButton: false,
                            timer: 1500
                            });
                            
                            window.location.reload(); 
                                
                        } else {
                            
                        }  
                }
            });  
           
        }

        function uncheck() {
            document.getElementById("myCheck").checked = false;
            onoff = "N";
            var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_803_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token},
                    success:function(data){ 
                        if (data.status == 200) { 
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Close function success",
                            showConfirmButton: false,
                            timer: 1500
                            });
                            
                            window.location.reload(); 
                                
                        } else {
                            
                        }  
                }
            }); 
            
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
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
            
            $('.Savestamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({position: "top-end",
                        title: 'Are you sure?',
                        text: "คุณต้องการตั้งลูกหนี้รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Debtor it.!'
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
                                                    Swal.fire({position: "top-end",
                                                        title: 'ตั้งลูกหนี้สำเร็จ',
                                                        text: "You Debtor data success",
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
                                                

                                            // } else {
                                            //     alert("Whoops Something went worng all"); 
                                            // }
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
             

            $("#spinner-div").hide(); //Request is complete so hide spinner

         
            $('#Pulldata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({position: "top-end",
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.account_803_pulldata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({position: "top-end",
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
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

            $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({position: "top-end",
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการลบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it.!'
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
                                                    Swal.fire({position: "top-end",
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
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

            // $('#Check_sit').click(function() {
            //     var datepicker = $('#datepicker').val(); 
            //     var datepicker2 = $('#datepicker2').val(); 
            //     //    alert(datepicker);
            //     Swal.fire({
            //             title: 'ต้องการตรวจสอบสอทธิ์ใช่ไหม ?',
            //             text: "You Check Sit Data!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, pull it!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $("#overlay").fadeIn(300);　
            //                     $("#spinner-div").show(); //Load button clicked show spinner 
            //                 $.ajax({
            //                     url: "{{ route('acc.account_803_checksit') }}",
            //                     type: "POST",
            //                     dataType: 'json',
            //                     data: {
            //                         datepicker,
            //                         datepicker2                        
            //                     },
            //                     success: function(data) {
            //                         if (data.status == 200) { 
            //                             Swal.fire({
            //                                 title: 'เช็คสิทธิ์สำเร็จ',
            //                                 text: "You Check sit success",
            //                                 icon: 'success',
            //                                 showCancelButton: false,
            //                                 confirmButtonColor: '#06D177',
            //                                 confirmButtonText: 'เรียบร้อย'
            //                             }).then((result) => {
            //                                 if (result
            //                                     .isConfirmed) {
            //                                     console.log(
            //                                         data);
            //                                     window.location.reload();
            //                                     $('#spinner-div').hide();//Request is complete so hide spinner
            //                                         setTimeout(function(){
            //                                             $("#overlay").fadeOut(300);
            //                                         },500);
            //                                 }
            //                             })
            //                         } else {
                                        
            //                         }

            //                     },
            //                 });
            //             }
            //     })
            // });

            $('.Claim').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({position: "top-end",
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการ Claim รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Claim it.!'
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
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({position: "top-end",
                                                        title: 'ประมวลผลข้อมูลเคลมสำเร็จ',
                                                        text: "You Process Claim data success",
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

            $('.Check_sit').click(function() {
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {

                    Swal.fire({position: "top-end",
                        title: 'Are you sure?',
                        text: "ต้องการตรวจสอบสอทธิ์ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'You Check Sit Data!.!'
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
                                                    Swal.fire({position: "top-end",
                                                        title: 'เช็คสิทธิ์สำเร็จ',
                                                        text: "You Check sit success",
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
                                                

                                            // } else {
                                            //     alert("Whoops Something went worng all"); 
                                            // }
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
 
                    }
            });
            
        });
    </script>
    @endsection
