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

    use App\Http\Controllers\StaticController;
    use App\Models\Opitemrece217;

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
        <form action="{{ route('acc.account_402_pull') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-4">
                <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail Account ผัง 1102050101.402</h4>
                <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-info cardacc" data-style="expand-left">
                            <span class="ladda-label"><i class="fa-solid fa-magnifying-glass text-white"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-style="expand-left" id="Pulldata">
                            <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ดึงข้อมูล</span>
                            <span class="ladda-spinner"></span>
                        </button>
                {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" id="Pulldata">
                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                    ดึงข้อมูล</button>     --}}
                  
            </div>
        </div>
        </div>
             
    </form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c">
                    <div class="card-body"> 
                      
                        <div class="row mb-2">
                            {{-- <div class="col-md-4">
                                <h4 class="card-title">Detail Account</h4>
                                <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
                            </div> --}}
                            <div class="col-md-6 text-start"> 
                                @if ($activeclaim == 'Y')
                                  <button class="ladda-button me-2 btn-pill btn btn-sm btn-info cardacc" onclick="check()">Check</button>
                                  <input type="checkbox" id="myCheck" class="dcheckbox_ me-2" checked> 
                                  <button class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc" onclick="uncheck()">Uncheck</button>
                                @else
                                  <button class="ladda-button me-2 btn-pill btn btn-sm btn-info cardacc" onclick="check()">Check</button>
                                  <input type="checkbox" id="myCheck" class="dcheckbox_ me-2"> 
                                  <button class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc" onclick="uncheck()">Uncheck</button>
                                @endif
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-warning cardacc Claim" data-url="{{url('account_402_claim')}}">
                                    <i class="fa-solid fa-sack-dollar me-2"></i>
                                   ประมวลผล
                               </button>
                               {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-success cardacc" id="SenddataAPI">
                                   <i class="fa-solid fa-upload me-2"></i>
                                   ส่ง New Eclaim
                               </button> --}}
                               {{-- <a href="{{url('account_402_claim_export')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-secondary cardacc">
                                   <i class="fa-solid fa-file-export text-white me-2"></i>
                                   Export Txt
                               </a>    --}}
                               <a href="{{url('account_402_claim_zip')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success cardacc">
                                    <i class="fa-solid fa-file-export text-white me-2"></i>
                                    Zip
                                </a> 
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-success cardacc" id="Apinhso">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i>
                                    API NHSO
                                </button>
                                  {{-- <button class="ladda-button me-2 btn-pill btn btn-info cardacc" onclick="check()">Check</button>
                                  <input type="checkbox" id="myCheck" class="dcheckbox_ me-2"> 
                                  <button class="ladda-button me-2 btn-pill btn btn-danger cardacc" onclick="uncheck()">Uncheck</button> --}}
                              </div>
                            <div class="col"></div>
                            <div class="col-md-5 text-end">
                                
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc Savestamp" data-url="{{url('account_402_stam')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc Destroystamp" data-url="{{url('account_402_destroy_all')}}">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    ลบ
                                </button>
                                {{-- <a href="{{url('account_402_claim_zip')}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger card_fdh_4">
                                    <i class="fa-solid fa-file-export text-danger me-2"></i>
                                    Zip Txt
                                </a>  --}}
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info Savestamp" data-url="{{url('account_402_stam')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button> --}}
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable"
                                style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                          
                                            <th width="5%" class="text-center">ลำดับ</th> 
                                            <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                                            <th class="text-center" width="5%">vn</th> 
                                            <th class="text-center">an</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">ตั้งลูกหนี้</th>
                                            <th class="text-center"> 
                                                เคลม
                                                <span class="bg-success badge">{{ $count_claim }}</span> 
                                                <span class="bg-danger badge">{{ $count_noclaim }}</span>  
                                            </th>
                                            <th class="text-center">Adjrw</th> 
                                            <th class="text-center">Adjrw*9000</th>
                                            <th class="text-center">กายภาพ</th>
                                            <th class="text-center">Dent</th>
                                            <th class="text-center" style="background-color: #fad6b8">pdx</th> 
                                            <th class="text-center">dchdate</th> 
                                            <th class="text-center">pttype</th> 
                                            <th class="text-center">spsch</th>  
                                            <th class="text-center">debit</th>  
                                            <th class="text-center">ฟอกเลือด</th>
                                            <th class="text-center">ลูกหนี้</th>
                                            {{-- <th class="text-center"><input type="checkbox" class="dcheckbox" name="destroy" id="destroy"> </th>   --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($acc_debtor as $item) 
                                        <?php
                                                        $data_dent = Opitemrece217::where('an',$item->an)->where('income',"=","13")->sum('sum_price');
                                                            
                                                            $datas_kay = Opitemrece217::where('an',$item->an)->where('income',"=","14")->sum('sum_price');
                                                         
                                                            if ($datas_kay > 0) {
                                                                $kayas = $datas_kay;
                                                            } else {
                                                                $kayas = '';
                                                            }
                                            ?>
                                            <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                {{-- @if ($item->debit_total == '')
                                                    <td class="text-center" width="5%">
                                                        <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                    </td> 
                                                @else
                                                    <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                @endif --}}
                                                
                                                @if ($activeclaim == 'Y')
                                                    {{-- @if ($item->debit_total == '' || $item->pdx =='') --}}
                                                    @if ($item->debit_total == '')
                                                        <td class="text-center" width="5%">
                                                            <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                        </td> 
                                                    @else
                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                    @endif  
                                                @else
                                                    <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                @endif
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->an }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
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
                                                <td class="text-center" width="7%">{{ $item->adjrw }}</td>
                                                <td class="text-center" width="7%">{{ $item->total_adjrw_income }}</td>
                                                <td class="text-center" width="5%">
                                                    @if ($kayas > 0)
                                                        <span class="bg-success badge">{{ $kayas }}</span> 
                                                    @else
                                                        <span class="bg-danger badge">-</span> 
                                                    @endif 
                                                </td> 
                                                <td class="text-center" width="5%">
                                                    @if ($data_dent > 0)
                                                        <span class="bg-info badge">{{ $data_dent }}</span> 
                                                    @else
                                                        <span class="bg-danger badge">-</span> 
                                                    @endif 
                                                </td> 
                                                <td class="text-start" width="5%">
                                                    @if ($item->pdx != NULL)
                                                        <span class="bg-info badge">{{ $item->pdx }}</span> 
                                                    @else
                                                        <span class="bg-warning badge">-</span> 
                                                    @endif 
                                                </td>
                                                <td class="text-center" width="7%">{{ $item->dchdate }}</td> 
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>                                                 
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td>  
                                                <td class="text-center" width="10%">{{ number_format($item->debit, 2) }}</td> 
                                                <td class="text-center" width="8%">{{ number_format($item->fokliad, 2) }}</td> 
                                                <td class="text-center" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
                                                {{-- <td class="text-center" width="5%"> <input type="checkbox" class="dcheckbox sub_destroy" data-id="{{$item->acc_debtor_id}}"></td>  --}}
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
                    url:"{{route('acc.account_402_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token}
            })
        }

        function uncheck() {
            document.getElementById("myCheck").checked = false;
            onoff = "N";
            var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_402_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token}
            })
        }
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
                    Swal.fire({
                        position: "top-end",
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
                                                    Swal.fire({
                                                        position: "top-end",
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
                Swal.fire({
                    position: "top-end",
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
                                    url: "{{ route('acc.account_402_pulldata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
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

            $('#Check_sitipd').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                //    alert(datepicker);
                Swal.fire({
                    position: "top-end",
                        title: 'ต้องการตรวจสอบสอทธิ์ใช่ไหม ?',
                        text: "You Check Sit Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner 
                            $.ajax({
                                url: "{{ route('acc.account_pkCheck_sitipd') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    datepicker,
                                    datepicker2                        
                                },
                                success: function(data) {
                                    if (data.status == 200) { 
                                        Swal.fire({
                                            position: "top-end",
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
                                                $('#spinner-div').hide();//Request is complete so hide spinner
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

            $('.Claim').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({ position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({ position: "top-end",
                        title: 'Are you Want Process sure?',
                        text: "คุณต้องการ ประมวลผล รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it.!'
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
                                                    Swal.fire({ position: "top-end",
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
            
            $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
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
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
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

            $('#Apinhso').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 

                // url: "{{ route('acc.account_401_api') }}",
                // url: "{{ route('acc.account_401_send_api') }}",
                Swal.fire({
                    position: "top-end",
                        title: 'ต้องการส่งข้อมูล NHSO ใช่ไหม ?',
                        text: "You Warn Send NHSO Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.account_402_send_api') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ส่งข้อมูล NHSO สำเร็จ',
                                                text: "You Send data NHSO success",
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
