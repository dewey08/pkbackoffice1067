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
               .inputaccs{
                 
                    border: none;
                    box-shadow: 0 0 10px pink;
                    border:solid 1px #80acfd;
                    border-radius: 40px;
                }  
                .add{
                    width: 60%;
                    height: 25px;
                    margin: 0 auto;
               
                    border:solid 1px #ccc;
                    border-radius: 10px;
                }    */
    
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
        <form action="{{ URL('account_301_pull') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-4">
                <h5 class="card-title" style="color:rgb(247, 31, 95)">Detail 1102050101.301</h5>
                <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.301</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control-sm cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc" data-style="expand-left">
                            <span class="ladda-label">
                                {{-- <i class="fa-solid fa-magnifying-glass text-white me-2"></i> --}}
                                <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                ค้นหา</span>
                            {{-- <span class="ladda-spinner"></span> --}}
                        </button>
                {{-- <button type="button" class="btn-icon btn-rounded btn-shadow btn-dashed btn btn-outline-primary" id="Pulldata">
                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                    ดึงข้อมูล
                </button>   --}}

            </form>
                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc" data-style="expand-left" id="Pulldata">
                    <span class="ladda-label"> 
                        {{-- <i class="fa-solid fa-file-circle-plus text-white me-2"></i> --}}
                        <img src="{{ asset('images/pull_datawhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                        ดึงข้อมูล</span>
                    {{-- <span class="ladda-spinner"></span> --}}
                </button>  
                </div>  
            </div>
            {{-- <div class="col"></div> --}}
        </div>
             
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                       
                      
                        <div class="row">
                            <div class="col-md-6">
                                 <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-warning input_new Claim" data-url="{{url('account_301_claim')}}">
                                    <img src="{{ asset('images/loading_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                   ประมวลผล
                               </button>
                               <button type="button" class="ladda-button me-2 btn-pill btn btn-sm input_new text-white Updateprescb" style="background-color: #07dfc2" data-url="{{url('account_301_prescb_update')}}">
                                    {{-- <i class="fa-solid fa-pen-to-square me-2 text-white"></i> --}}
                                    <img src="{{ asset('images/update_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    Update Prescb
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm input_new text-white Updatesvpid" style="background-color: #f82185" data-url="{{url('account_301_svpid_update')}}">
                                    {{-- <i class="fa-solid fa-pen-to-square me-2 text-white"></i> --}}
                                    <img src="{{ asset('images/update_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    Update SvPID
                                </button>
                                <a href="{{url('account_301_export')}}" class="ladda-button me-2 btn-pill btn btn-sm input_new text-white" style="background-color: #07a1df">
                                    {{-- <i class="fa-solid fa-file-export text-white me-2"></i> --}}
                                    <img src="{{ asset('images/export_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    Export
                                </a>
                               <a href="{{url('account_301_zip')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new">
                                <img src="{{ asset('images/zipwhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    Zip
                                </a> 
                                
                            </div>  
                            <div class="col"></div>
                            <div class="col-md-3 text-end mb-2">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new Check_sit" data-url="{{url('account_301_checksit')}}">
                                    <img src="{{ asset('images/Check_sitwhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    ตรวจสอบสิทธิ์ 
                                </button>
                            
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc Savestamp" data-url="{{url('account_301_stam')}}">
                                    <img src="{{ asset('images/Stam_white.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ตั้งลูกหนี้
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc Destroystamp" data-url="{{url('account_301_destroy_all')}}">
                                    <img src="{{ asset('images/removewhite.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                                    ลบ
                                </button>
                                
                            </div>
                        </div>

                        <p class="mb-0">
                             <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#ssop" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">SSOP</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#BillTran" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">BillTran</span>    
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Dispensing" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Dispensing</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#DispensedItem" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">DispensedItem</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPServices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPServices</span>    
                                </a>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPDX" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPDX</span>    
                                </a>
                            </li>
                        </ul>

                         <!-- Tab panes -->
                         <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="ssop" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100"> 
                                            <thead>
                                                <tr>
                                                  
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                                                    <th width="5%" class="text-center">ตั้งลูกหนี้</th>
                                                    <th width="5%" class="text-center">                                                                 
                                                        <span class="bg-success badge">{{ $count_claim }}</span> เคลม
                                                        <span class="bg-danger badge">{{ $count_noclaim }}</span>  
                                                    </th> 
                                                    <th width="5%" class="text-center">pdx</th> 
                                                    <th class="text-center">vn</th>  
                                                    <th class="text-center" width="5%">hn</th> 
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center" width="10%">vstdate</th>  
                                                    <th class="text-center" width="5%">pttype</th> 
                                                    <th class="text-center" width="5%">spsch</th>  
                                                    <th class="text-center" width="10%">income</th>  
                                                    <th class="text-center" width="10%">301</th>  
                                                    <th class="text-center" width="10%">ins-3011</th> 
                                                    <th class="text-center" width="10%">ct-3013</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($acc_debtor as $item) 
                                                    <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                        @if ($item->debit_total == '')
                                                            <td class="text-start" width="5%">
                                                                <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                            </td> 
                                                        @else
                                                            <td class="text-start" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                        @endif
                                                       
                                                        <td class="text-start" width="5%">
                                                            @if ($item->stamp =='N')
                                                                <span class="bg-danger badge me-2">{{ $item->stamp }}</span> 
                                                            @else
                                                                <span class="bg-success badge me-2">{{ $item->stamp }}</span> 
                                                            @endif
                                                        </td>  
                                                        <td class="text-start" width="5%">
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
        
                                                        <td class="text-start">{{ $item->vn }}</td>  
                                                        <td class="text-start" width="5%">{{ $item->hn }}</td>   
                                                        <td class="p-2">{{ $item->ptname }}</td> 
                                                        <td class="text-start" width="10%">{{ $item->vstdate }}</td>   
                                                        <td class="text-start" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>  
                                                        <td class="text-start" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td>  
                                                        <td class="text-start" width="10%">{{ number_format($item->income, 2) }}</td> 
                                                        <td class="text-start" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
                                                        <td class="text-start" width="10%">{{ number_format($item->debit_ins_sss, 2) }}</td> 
                                                        <td class="text-start" width="10%">{{ number_format($item->debit_ct_sss, 2) }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="BillTran" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                        {{-- <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" width="5%">Station</th> 
                                                    <th class="text-center">DTtran</th>
                                                    <th class="text-center" >Hcode</th>
                                                    <th class="text-center" >Invno</th>
                                                    <th class="text-center">VerCode</th>
                                                    <th class="text-center">HN</th> 
                                                    <th class="text-center">Tflag</th>
                                                    <th class="text-center" width="7%">HMain</th>
                                                    <th class="text-center">Pid</th>
                                                    <th class="text-center">ชื่อ-สกุล </th>
                                                    <th class="text-center" width="8%">Amount</th>
                                                    <th class="text-center" width="8%">Paid</th> 
                                                    <th class="text-center" width="10%">ClaimAmt</th> 
                                                    <th class="text-center">PayPlan</th>
                                                    <th class="text-center">OtherPay</th>
                                                    <th class="text-center">pttype</th>
                                                    <th class="text-center">Diag</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_billtran as $item) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center" width="5%">{{ $item->Station }}</td> 
                                                        <td class="text-center">{{ $item->DTtran }}</td> 
                                                        <td class="text-center">{{ $item->Hcode }}</td>  
                                                        <td class="text-center">{{ $item->Invno }}</td>  
                                                        <td class="text-center">{{ $item->VerCode }}</td> 
                                                        <td class="text-center">{{ $item->HN }}</td>  
                                                        <td class="text-center">{{ $item->Tflag }}</td> 
                                                        <td class="text-center">{{ $item->HMain }}</td> 
                                                        <td class="text-center">{{ $item->Pid }}</td> 
                                                        <td class="p-2">{{ $item->Name }}</td> 
                                                        <td class="text-center">{{ number_format($item->Amount, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->Paid, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->ClaimAmt, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->PayPlan, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->OtherPay, 2) }}</td> 
                                                        <td class="text-center">{{ $item->pttype }}</td> 
                                                        <td class="text-center">{{ $item->Diag }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                           
                            <div class="tab-pane" id="BillItems" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                            <table id="example2" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">SvDate</th>
                                                    <th class="text-center">BillMuad</th>
                                                    <th class="text-center">LCCode</th>
                                                    <th class="text-center">STDCode</th>   
                                                    <th class="text-center">Desc</th> 
                                                    <th class="text-center">QTY</th> 
                                                    <th class="text-center">UnitPrice</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ClaimUP</th> 
                                                    <th class="text-center">ClaimAmount</th> 
                                                    <th class="text-center">SvRefID</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                    <th class="text-center">paidst</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_billitems as $item2) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item2->Invno }} </td>
                                                        <td class="text-center">{{ $item2->SvDate }}</td>
                                                        <td class="text-center">{{ $item2->BillMuad }} </td>
                                                        <td class="text-center">{{ $item2->LCCode }} </td>
                                                        <td class="text-center">{{ $item2->STDCode }} </td>
                                                        <td class="p-2">{{ $item2->Desc }}</td>   
                                                        <td class="text-center">{{ $item2->QTY }}</td>
                                                        <td class="text-center">{{ number_format($item2->UnitPrice, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ChargeAmt, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimUP, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimAmount, 2) }}</td>
                                                        <td class="text-center">{{ $item2->SvRefID }}</td>
                                                        <td class="text-center">{{ $item2->ClaimCat }}</td>
                                                        <td class="text-center">{{ $item2->paidst }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="Dispensing" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                            <table id="example3" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">ProviderID</th>
                                                    <th class="text-center">DispID</th>
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">PID</th>   
                                                    <th class="text-center">Prescdt</th> 
                                                    <th class="text-center">Dispdt</th> 
                                                    <th class="text-center">
                                                        {{-- <input type="checkbox" name="stamp" id="stamp" class="dcheckbox_ me-2"> --}}
                                                        Prescb</th> 
                                                    <th class="text-center">Itemcnt</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ClaimAmt</th> 
                                                    <th class="text-center">Paid</th> 
                                                    <th class="text-center">OtherPay</th> 
                                                    <th class="text-center">Reimburser</th>  
                                                    <th class="text-center">BenefitPlan</th> 
                                                    <th class="text-center">DispeStat</th> 
                                                    <th class="text-center">SvID</th> 
                                                    <th class="text-center">DayCover</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_dispensing as $item3) 
                                                    <tr id="prescbid{{$item3->ssop_dispensing_id}}">   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item3->ProviderID }} </td>
                                                        <td class="text-center">{{ $item3->DispID }}</td>
                                                        <td class="text-center" >{{ $item3->Invno }} </td>
                                                        <td class="text-center" >{{ $item3->HN }} </td>
                                                        <td class="text-center" >{{ $item3->PID }} </td>
                                                        <td class="text-center" >{{ $item3->Prescdt }}</td>   
                                                        <td class="text-center" >{{ $item3->Dispdt }}</td> 
                                                        <td class="p-2" >
                                                            <input type="checkbox" class="sub_chk_prescb dcheckbox_ me-2" data-id="{{$item3->ssop_dispensing_id}}">
                                                            <button type="button"class="ladda-button me-2 btn-pill btn btn-sm input_new text-danger" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-danger"></i>
                                                                {{-- <label for="" class="text-danger" style="font-size:13px;">  --}}
                                                                    {{ $item3->Prescb }}
                                                                {{-- </label> --}}
                                                            </button>
                                                        </td> 
                                                        <td class="text-center" >{{ $item3->Itemcnt }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->ChargeAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->ClaimAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->Paid, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->OtherPay, 2) }}</td> 
                                                        <td class="text-center" >{{ $item3->Reimburser }}</td> 
                                                        <td class="text-center" >{{ $item3->BenefitPlan }}</td> 
                                                        <td class="text-center" >{{ $item3->DispeStat }}</td> 
                                                        <td class="text-center" >{{ $item3->SvID }}</td> 
                                                        <td class="text-center" >{{ $item3->DayCover }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="DispensedItem" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                            <table id="example4" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">DispID</th>
                                                    <th class="text-center">PrdCat</th>
                                                    <th class="text-center">HospDrgID</th>
                                                    <th class="text-center">DrgID</th>   
                                                    <th class="text-center">dfsText</th> 
                                                    <th class="text-center">Packsize</th> 
                                                    <th class="text-center">sigCode</th> 
                                                    <th class="text-center">sigText</th> 
                                                    <th class="text-center">Quantity</th> 
                                                    <th class="text-center">UnitPrice</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ReimbPrice</th> 
                                                    <th class="text-center">ReimbAmt</th>  
                                                    <th class="text-center">PrdSeCode</th> 
                                                    <th class="text-center">Claimcont</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                    <th class="text-center">paidst</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_dispenseditems as $item4) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item4->DispID }}</td>
                                                        <td class="text-center" >{{ $item4->PrdCat }} </td>
                                                        <td class="text-center" >{{ $item4->HospDrgID }} </td>
                                                        <td class="text-center" >{{ $item4->DrgID }} </td>
                                                        <td class="p-2" >{{ $item4->dfsText }}</td>   
                                                        <td class="p-2" >{{ $item4->Packsize }}</td> 
                                                        <td class="text-center" >{{ $item4->sigCode }}</td> 
                                                        <td class="p-2" width="15%">{{ $item4->sigText }}</td> 
                                                        <td class="text-center" >{{ $item4->Quantity }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->UnitPrice, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ChargeAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ReimbPrice, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ReimbAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ $item4->PrdSeCode }}</td> 
                                                        <td class="text-center" >{{ $item4->Claimcont }}</td> 
                                                        <td class="text-center" >{{ $item4->ClaimCat }}</td> 
                                                        <td class="text-center" >{{ $item4->paidst }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="OPServices" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                            <table id="example5" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">SvID</th>
                                                    <th class="text-center">Class</th>
                                                    <th class="text-center">Hcode</th>   
                                                    <th class="text-center">HN</th> 
                                                    <th class="text-center">PID</th> 
                                                    <th class="text-center">CareAccount</th> 
                                                    <th class="text-center">TypeServ</th> 
                                                    <th class="text-center">TypeIn</th> 
                                                    <th class="text-center">TypeOut</th> 
                                                    <th class="text-center">DTAppoint</th> 
                                                    <th class="p-2">
                                                        {{-- <input type="checkbox" name="stamp2" id="stamp2" class="me-2"> --}}
                                                        SvPID
                                                    </th> 
                                                    <th class="text-center">Clinic</th>  
                                                    <th class="text-center">BegDT</th> 
                                                    <th class="text-center">EndDT</th> 
                                                    <th class="text-center">LcCode</th> 
                                                    <th class="text-center">CodeSet</th> 
                                                    <th class="text-center">STDCode</th> 
                                                    <th class="text-center">SvCharge</th> 
                                                    <th class="text-center">Completion</th> 
                                                    <th class="text-center">SvTxCode</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_opservices as $item5) 
                                                    <tr id="prescbid{{$item5->ssop_opservices_id}}">   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item5->Invno }}</td>
                                                        <td class="text-center" >{{ $item5->SvID }} </td>
                                                        <td class="text-center" >{{ $item5->Class }} </td>
                                                        <td class="text-center" >{{ $item5->Hcode }} </td>
                                                        <td class="p-2" >{{ $item5->HN }}</td>   
                                                        <td class="p-2" >{{ $item5->PID }}</td> 
                                                        <td class="text-center" >{{ $item5->CareAccount }}</td> 
                                                        <td class="p-2">{{ $item5->TypeServ }}</td> 
                                                        <td class="text-center" >{{ $item5->TypeIn }}</td>  
                                                        <td class="text-center" >{{ $item5->TypeOut }}</td> 
                                                        <td class="text-center" >{{ $item5->DTAppoint }}</td> 
                                                        <td class="p-2" > 
                                                            <input type="checkbox" class="sub_chk_svpid dcheckbox_ me-2" data-id="{{$item5->ssop_opservices_id}}">
                                                            <button type="button"class="ladda-button me-2 btn-pill btn btn-sm input_new text-danger" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-danger"></i>
                                                                 {{ $item5->SvPID }} 
                                                            </button>
                                                        </td> 
                                                        <td class="text-center" >{{ $item5->Clinic }}</td> 
                                                        <td class="text-center" width="15%">{{ $item5->BegDT }}</td> 
                                                        <td class="text-center" width="15%">{{ $item5->EndDT }}</td> 
                                                        <td class="text-center" >{{ $item5->LcCode }}</td> 
                                                        <td class="text-center" >{{ $item5->CodeSet }}</td> 
                                                        <td class="text-center" >{{ $item5->STDCode }}</td> 
                                                        <td class="text-center" >{{ $item5->SvCharge }}</td> 
                                                        <td class="text-center" >{{ $item5->Completion }}</td> 
                                                        <td class="text-center" >{{ $item5->SvTxCode }}</td> 
                                                        <td class="text-center" >{{ $item5->ClaimCat }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="OPDX" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">  --}}
                                            <table id="example6" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="example3" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Class</th>
                                                    <th class="text-center">SvID</th>
                                                    <th class="text-center" width="15%">SL</th>
                                                    <th class="text-center" width="15%">CodeSet</th>
                                                    <th class="text-center">code</th>   
                                                    <th class="text-center" >Desc</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_opdx as $item6) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item6->Class }}</td>
                                                        <td class="text-center" >{{ $item6->SvID }} </td>
                                                        <td class="text-center" >{{ $item6->SL }} </td>
                                                        <td class="text-center" >{{ $item6->CodeSet }} </td>                                                       
                                                        <td class="text-center" >{{ $item6->code }}</td>  
                                                        <td class="text-center" >{{ $item6->Desc }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                             
                                        </table>
                                    </div>
                                </p>
                            </div>
                             
                        </div>


                            {{-- <div class="table-responsive">
                                <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100"> 
                                    <thead>
                                        <tr>
                                          
                                            <th width="5%" class="text-center">ลำดับ</th> 
                                            <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                                            <th width="5%" class="text-center">ตั้งลูกหนี้</th>
                                            <th width="5%" class="text-center">                                                                 
                                                <span class="bg-success badge">{{ $count_claim }}</span> เคลม
                                                <span class="bg-danger badge">{{ $count_noclaim }}</span>  
                                            </th> 
                                            <th width="5%" class="text-center">pdx</th> 
                                            <th class="text-center">vn</th>  
                                            <th class="text-center" width="5%">hn</th> 
                                            <th class="text-center">ptname</th>
                                            <th class="text-center" width="10%">vstdate</th>  
                                            <th class="text-center" width="5%">pttype</th> 
                                            <th class="text-center" width="5%">spsch</th>  
                                            <th class="text-center" width="10%">income</th>  
                                            <th class="text-center" width="10%">301</th>  
                                            <th class="text-center" width="10%">ins-3011</th> 
                                            <th class="text-center" width="10%">ct-3013</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($acc_debtor as $item) 
                                            <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                @if ($item->debit_total == '')
                                                    <td class="text-start" width="5%">
                                                        <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                    </td> 
                                                @else
                                                    <td class="text-start" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                @endif
                                               
                                                <td class="text-start" width="5%">
                                                    @if ($item->stamp =='N')
                                                        <span class="bg-danger badge me-2">{{ $item->stamp }}</span> 
                                                    @else
                                                        <span class="bg-success badge me-2">{{ $item->stamp }}</span> 
                                                    @endif
                                                </td>  
                                                <td class="text-start" width="5%">
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

                                                <td class="text-start">{{ $item->vn }}</td>  
                                                <td class="text-start" width="5%">{{ $item->hn }}</td>   
                                                <td class="p-2">{{ $item->ptname }}</td> 
                                                <td class="text-start" width="10%">{{ $item->vstdate }}</td>   
                                                <td class="text-start" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>  
                                                <td class="text-start" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td>  
                                                <td class="text-start" width="10%">{{ number_format($item->income, 2) }}</td> 
                                                <td class="text-start" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
                                                <td class="text-start" width="10%">{{ number_format($item->debit_ins_sss, 2) }}</td> 
                                                <td class="text-start" width="10%">{{ number_format($item->debit_ct_sss, 2) }}</td>  
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
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
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example6').DataTable();

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

            $('#destroy').on('click', function(e) {           
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_destroy").prop('checked', true);  
                    } else {  
                        $(".sub_destroy").prop('checked',false);  
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
                                    url: "{{ route('acc.account_301_pulldata') }}",
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

            // $('#Check_sit').click(function() {
            //     var datepicker = $('#datepicker').val(); 
            //     var datepicker2 = $('#datepicker2').val(); 
            //     //    alert(datepicker);
            //     Swal.fire({position: "top-end",
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
            //                     url: "{{ route('acc.account_301_checksit') }}",
            //                     type: "POST",
            //                     dataType: 'json',
            //                     data: {
            //                         datepicker,
            //                         datepicker2                        
            //                     },
            //                     success: function(data) {
            //                         if (data.status == 200) { 
            //                             Swal.fire({position: "top-end",
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
            $('.Check_sit').click(function() {
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
                                                    Swal.fire({
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

            $('#Check_sitipd').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                //    alert(datepicker);
                Swal.fire({position: "top-end",
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

            $('.Updateprescb').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk_prescb:checked").each(function () {
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
                            text: "คุณต้องการปรับรายการที่เลือกใช่ไหม!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, UPdate it.!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var check = true;
                                    if (check == true) {
                                        var join_selected_values = allValls.join(","); 
                                        $.ajax({
                                            url:$(this).data('url'),
                                            type: 'POST',
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            data: 'ids='+join_selected_values,
                                            success:function(data){ 
                                                if (data.status == 200) {
                                                    $(".sub_chk_prescb:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ปรับ Prescbสำเร็จ',
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
                                                            // window.location="{{url('warehouse/warehouse_index')}}";
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

                }
            }); 

            $('.Updatesvpid').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk_svpid:checked").each(function () {
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
                            text: "คุณต้องการปรับรายการที่เลือกใช่ไหม!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, UPdate it.!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var check = true;
                                    if (check == true) {
                                        var join_selected_values = allValls.join(","); 
                                        $.ajax({
                                            url:$(this).data('url'),
                                            type: 'POST',
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            data: 'ids2='+join_selected_values,
                                            success:function(data){ 
                                                if (data.status == 200) {
                                                    $(".sub_chk_svpid:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ปรับ SvPID สำเร็จ',
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
                                                            // window.location="{{url('warehouse/warehouse_index')}}";
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

                }
            }); 
        });
    </script>
    @endsection
