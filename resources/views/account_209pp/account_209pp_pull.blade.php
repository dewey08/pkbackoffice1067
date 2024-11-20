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
               border-top: 10px rgb(250, 128, 124) solid;
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
        <form action="{{ URL('account_209pp_pull') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-4"> 
                <h5 class="card-title" style="color:green">Process data 1102050101.209</h5>
                <p class="card-title-desc">ประมวลผลข้อมูล ตั้งลูกหนี้/เคลม การทดสอบการตั้งครรภ์</p>
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
                            <span class="ladda-label"><i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc" data-style="expand-left" id="Pulldata">
                            <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ดึงข้อมูล</span>
                            <span class="ladda-spinner"></span>
                        </button> 
            </div> 
        </div>
    </div>  
</form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">    
                        <div class="row mb-2">
                            <div class="col-md-6 text-start"> 
                              @if ($activeclaim == 'Y')
                                <button class="ladda-button me-2 btn-pill btn btn-info btn-sm cardacc" onclick="check()">Check</button>
                                <input type="checkbox" id="myCheck" class="dcheckbox_ me-2" checked> 
                                <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                              @else
                                <button class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new" onclick="check()">Check</button>
                                <input type="checkbox" id="myCheck" class="dcheckbox_ me-2"> 
                                <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                              @endif 
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-warning input_new Claim" data-url="{{url('account_209pp_claim')}}">
                                    <i class="fa-solid fa-spinner me-2"></i>
                                   ประมวลผล
                               </button>
                               <a href="{{url('account_401_claim_zip')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new">
                                        <i class="fa-regular fa-file-zipper text-white me-2"></i> 
                                    Zip
                                </a>  
                            </div>
                           
                            <div class="col"></div>
                            <div class="col-md-5 text-end"> 
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new Check_sit" data-url="{{url('account_209pp_checksit')}}">
                                    <i class="fa-solid fa-user me-2"></i>
                                    ตรวจสอบสิทธิ์ 
                                </button> 
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-primary btn-sm input_new Savestamp" data-url="{{url('account_209pp_stam')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button> --}}
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new Destroystamp" data-url="{{url('account_209pp_destroy')}}">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    ลบ
                                </button> 
                               
                            </div>
                        </div>
 
                        <div class="row">
                            <div class="col-md-12">
                                    <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#Main" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Detail OFC</span>    
                                        </a>
                                    </li>   
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#OPD" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OPD</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ORF" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ORF</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#OOP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OOP</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OOP</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IDX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IDX</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IPD" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IPD</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IRF" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IRF</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#AER" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">AER</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IOP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IOP</span>    
                                        </a>
                                    </li>                           
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ODX</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#PAT" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">PAT</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#CHT" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">CHT</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#CHA" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">CHA</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#INS" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">INS</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ADP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ADP</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#DRU" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">DRU</span>    
                                        </a>
                                    </li>                                
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
    
                                    <div class="tab-pane active" id="Main" role="tabpanel">
                                        <p class="mb-0">
                                            <div class="table-responsive"> 
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
                                                            <th class="text-center">กายภาพ</th>
                                                            <th class="text-center">Dent</th>
                                                            <th class="text-center">CT</th> 
                                                            <th class="text-center" >hn</th>
                                                            <th class="text-center" >cid</th>
                                                            <th class="text-center">ptname</th>                  
                                                            <th class="text-center">vstdate</th>  
                                                            <th class="text-center">pttype</th> 
                                                            <th class="text-center">spsch</th>   
                                                                                                                    
                                                            <th class="text-center">ลูกหนี้</th>  
                                                            <th class="text-center">Rep</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($acc_debtor as $item) 

                                                        <?php 
                                                            if ($item->vn != '') {
                                                                $datas = DB::connection('mysql10')->select(
                                                                'SELECT v.vn SEQ,oo.presc_reason as DRUGREMARK 
                                                                    FROM opitemrece v
                                                                    LEFT OUTER JOIN drugitems d on d.icode = v.icode
                                                                    LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                                                                    LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn  
                                                                    WHERE v.vn IN("'.$item->vn.'")
                                                                    AND d.did is not null  
                                                                    GROUP BY v.vn 
                                                            ');
                                                            foreach ($datas as $key => $value) {
                                                               $drugmark = $value->DRUGREMARK;
                                                            }
                                                            } else {
                                                                $drugmark = '';
                                                            }                                                           
                                                                                                                        
                                                            $data_dent = Opitemrece217::where('vn',$item->vn)->where('income',"=","13")->sum('sum_price');                                                            
                                                            $datas_kay = Opitemrece217::where('vn',$item->vn)->where('income',"=","14")->sum('sum_price');
                                                            $data_ct   = Opitemrece217::where('vn',$item->vn)->where('income',"=","08")->sum('sum_price');
                                                         
                                                            if ($datas_kay > 0) {
                                                                $kayas = $datas_kay;
                                                            } else {
                                                                $kayas = '';
                                                            }
                                                             
                                                            
                                                        ?>
                                                            <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                                @if ($activeclaim == 'Y')
                                                                    @if ($item->debit_total =='' || $item->pdx =='')
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
                                                                
                                                                <td class="text-center" width="5%">
                                                                    @if ($kayas > 0)
                                                                        <span class="bg-success badge text-center">{{ $kayas }}</span> 
                                                                    @else
                                                                        <span class="bg-danger badge text-center">-</span> 
                                                                    @endif 
                                                                </td> 
                                                                <td class="text-center" width="5%">
                                                                    @if ($data_dent > 0)
                                                                        <span class="bg-info badge text-center">{{ $data_dent }}</span> 
                                                                    @else
                                                                        <span class="bg-danger badge text-center">-</span> 
                                                                    @endif 
                                                                </td> 
                                                                <td class="text-center" width="5%">
                                                                    @if ($data_ct > 0)
                                                                        <span class="bg-info badge text-center">{{ $data_ct }}</span> 
                                                                    @else
                                                                        <span class="bg-danger badge text-center">-</span> 
                                                                    @endif 
                                                                </td>  
                                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                                <td class="p-2">{{ $item->ptname }}</td>  
                                                                <td class="text-center" width="8%">{{ $item->vstdate }}</td>   
                                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>                                                 
                                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td> 
                                                               
                                                                <td class="text-center" width="8%">
                                                                    @if ($item->debit_total < $item->rep_pay)
                                                                        <span class="bg-danger badge me-2"> {{ number_format($item->debit_total, 2) }}</span> 
                                                                    @elseif($item->debit_total == $item->rep_pay)
                                                                        <span class="bg-success badge me-2"> {{ number_format($item->debit_total, 2) }}</span> 
                                                                    @else
                                                                        <span class="bg-info badge me-2"> {{ number_format($item->debit_total, 2) }}</span> 
                                                                    @endif 
                                                                </td>  
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
                                    <div class="tab-pane" id="OPD" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">CLINIC</th>
                                                        <th class="text-center">DATEOPD</th>  
                                                        <th class="text-center">TIMEOPD</th> 
                                                        <th class="text-center">SEQ</th> 
                                                        <th class="text-center">UUC</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($data_opd as $itemo)
                                                    <?php $i++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $i }}</td>
                                                            <td class="text-center" width="10%">  {{ $itemo->HN }}  </td>
                                                            <td class="text-center" width="10%">{{ $itemo->CLINIC }}</td>
                                                            <td class="text-center" width="10%">{{ $itemo->DATEOPD }}</td>  
                                                            <td class="text-center" width="10%">{{ $itemo->TIMEOPD }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemo->SEQ }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemo->UUC }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="ORF" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example3" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">CLINIC</th>
                                                        <th class="text-center">DATEOPD</th>  
                                                        <th class="text-center">REFER</th> 
                                                        <th class="text-center">SEQ</th> 
                                                        <th class="text-center">REFERTYPE</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $a = 0; ?>
                                                    @foreach ($data_orf as $itemorf)
                                                    <?php $a++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $a }}</td>
                                                            <td class="text-center" width="10%"> {{ $itemorf->HN }}  </td>
                                                            <td class="text-center" width="10%">{{ $itemorf->CLINIC }}</td>
                                                            <td class="text-center" width="10%">{{ $itemorf->DATEOPD }}</td>  
                                                            <td class="text-center" width="10%">{{ $itemorf->REFER }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemorf->SEQ }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemorf->REFERTYPE }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="OOP" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example4" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">CLINIC</th>
                                                        <th class="text-center">DATEOPD</th>  
                                                        <th class="text-center">OPER</th> 
                                                        <th class="text-center">DROPID</th> 
                                                        <th class="text-center">PERSON_ID</th> 
                                                        <th class="text-center">SEQ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $b = 0; ?>
                                                    @foreach ($data_oop as $itemoop)
                                                    <?php $b++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $b }}</td>
                                                            <td class="text-center" width="10%">{{ $itemoop->HN }}</td>
                                                            <td class="text-center" width="10%">{{ $itemoop->CLINIC }}</td>
                                                            <td class="text-center" width="10%">{{ $itemoop->DATEOPD }}</td>  
                                                            <td class="text-center" width="10%">{{ $itemoop->OPER }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemoop->DROPID }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemoop->PERSON_ID }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemoop->SEQ }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="ODX" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example5" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">CLINIC</th>
                                                        <th class="text-center">DATEDX</th>  
                                                        <th class="text-center">DIAG</th> 
                                                        <th class="text-center">DXTYPE</th> 
                                                        <th class="text-center">DRDX</th> 
                                                        <th class="text-center">PERSON_ID</th>
                                                        <th class="text-center">SEQ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $c = 0; ?>
                                                    @foreach ($data_odx as $itemodx)
                                                    <?php $c++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $c }}</td>
                                                            <td class="text-center" width="10%">{{ $itemodx->HN }}</td>
                                                            <td class="text-center" width="10%">{{ $itemodx->CLINIC }}</td>
                                                            <td class="text-center" width="10%">{{ $itemodx->DATEDX }}</td>  
                                                            <td class="text-center" width="10%">{{ $itemodx->DIAG }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemodx->DXTYPE }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemodx->DRDX }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemodx->PERSON_ID }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemodx->SEQ }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="IDX" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example6" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">DIAG</th>
                                                        <th class="text-center">DXTYPE</th>
                                                        <th class="text-center">DRDX</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $d = 0; ?>
                                                    @foreach ($data_idx as $itemidx)
                                                    <?php $d++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $d }}</td>
                                                            <td class="text-center" width="10%">{{ $itemidx->AN }}</td>
                                                            <td class="text-center" width="10%">{{ $itemidx->DIAG }}</td>
                                                            <td class="text-center" width="10%">{{ $itemidx->DXTYPE }}</td>
                                                            <td class="text-center" width="10%">{{ $itemidx->DRDX }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="IPD" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example7" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">DATEADM</th>
                                                        <th class="text-center">TIMEADM</th>  
                                                        <th class="text-center">DATEDSC</th>
                                                        <th class="text-center">TIMEDSC</th>
                                                        <th class="text-center">DISCHS</th>
                                                        <th class="text-center">DISCHT</th>
                                                        <th class="text-center">DEPT</th>
                                                        <th class="text-center">ADM_W</th>
                                                        <th class="text-center">UUC</th>
                                                        <th class="text-center">SVCTYPE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $e = 0; ?>
                                                    @foreach ($data_ipd as $itemipd)
                                                    <?php $e++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $e }}</td>
                                                            <td class="text-center" width="10%">{{ $itemipd->AN }}</td>
                                                            <td class="text-center" width="10%">{{ $itemipd->HN }}</td>
                                                            <td class="text-center" width="5%">{{ $itemipd->DATEADM }}</td>
                                                            <td class="text-center" width="5%">{{ $itemipd->TIMEADM }}</td> 
                                                            <td class="text-center" width="5%">{{ $itemipd->DATEDSC }}</td>  
                                                            <td class="text-center" width="5%">{{ $itemipd->TIMEDSC }}</td> 
                                                            <td class="text-center" width="10%">{{ $itemipd->DISCHS }}</td> 
                                                            <td class="text-center" width="5%">{{ $itemipd->DISCHT }}</td> 
                                                            <td class="text-center" width="5%">{{ $itemipd->DEPT }}</td> 
                                                            <td class="text-center" width="5%">{{ $itemipd->ADM_W }}</td>
                                                            <td class="text-center" width="5%">{{ $itemipd->UUC }}</td>
                                                            <td class="text-center" width="5%">{{ $itemipd->SVCTYPE }}</td>
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="IRF" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example8" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">REFER</th>
                                                        <th class="text-center">REFERTYPE</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $f = 0; ?>
                                                    @foreach ($data_irf as $itemirf)
                                                    <?php $f++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $f }}</td>
                                                            <td class="text-center" width="10%">{{ $itemirf->AN }}</td>
                                                            <td class="text-center" width="10%">{{ $itemirf->REFER }}</td>
                                                            <td class="text-center" width="5%">{{ $itemirf->REFERTYPE }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="AER" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example9" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">DATEOPD</th>
                                                        <th class="text-center">AUTHAE</th> 
                                                        <th class="text-center">AEDATE</th> 
                                                        <th class="text-center">AETIME</th> 
                                                        <th class="text-center">AETYPE</th> 
                                                        <th class="text-center">REFER_NO</th> 
                                                        <th class="text-center">REFMAINI</th> 
                                                        <th class="text-center">IREFTYPE</th> 
                                                        <th class="text-center">REFMAINO</th> 
                                                        <th class="text-center">OREFTYPE</th> 
                                                        <th class="text-center">UCAE</th> 
                                                        <th class="text-center">EMTYPE</th> 
                                                        <th class="text-center">SEQ</th> 
                                                        <th class="text-center">AESTATUS</th> 
                                                        <th class="text-center">DALERT</th> 
                                                        <th class="text-center">TALERT</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $g = 0; ?>
                                                    @foreach ($data_aer as $itemaer)
                                                    <?php $g++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $g}}</td>
                                                            <td class="text-center" width="7%">{{ $itemaer->HN }}</td>
                                                            <td class="text-center" width="7%">{{ $itemaer->AN }}</td>
                                                            <td class="text-center" width="7%">{{ $itemaer->DATEOPD }}</td>
                                                            <td class="text-center" >{{ $itemaer->AUTHAE }}</td> 
                                                            <td class="text-center" >{{ $itemaer->AEDATE }}</td> 
                                                            <td class="text-center" >{{ $itemaer->AETIME }}</td> 
                                                            <td class="text-center" >{{ $itemaer->AETYPE }}</td> 
                                                            <td class="text-center">{{ $itemaer->REFER_NO }}</td> 
                                                            <td class="text-center" >{{ $itemaer->REFMAINI }}</td> 
                                                            <td class="text-center" >{{ $itemaer->IREFTYPE }}</td> 
                                                            <td class="text-center" >{{ $itemaer->REFMAINO }}</td> 
                                                            <td class="text-center" >{{ $itemaer->OREFTYPE }}</td> 
                                                            <td class="text-center" >{{ $itemaer->UCAE }}</td> 
                                                            <td class="text-center" >{{ $itemaer->EMTYPE }}</td> 
                                                            <td class="text-center" width="7%">{{ $itemaer->SEQ }}</td> 
                                                            <td class="text-center" >{{ $itemaer->AESTATUS }}</td> 
                                                            <td class="text-center" >{{ $itemaer->DALERT }}</td> 
                                                            <td class="text-center" >{{ $itemaer->TALERT }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="IOP" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example10" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">OPER</th>
                                                        <th class="text-center">OPTYPE</th> 
                                                        <th class="text-center">DROPID</th> 
                                                        <th class="text-center">DATEIN</th> 
                                                        <th class="text-center">TIMEIN</th> 
                                                        <th class="text-center">DATEOUT</th> 
                                                        <th class="text-center">TIMEOUT</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $e = 0; ?>
                                                    @foreach ($data_iop as $itemiop)
                                                    <?php $e++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $e }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->AN }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->OPER }}</td>
                                                            <td class="text-center" width="5%">{{ $itemiop->OPTYPE }}</td>  
                                                            <td class="text-center" width="10%">{{$itemiop->DROPID }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->DATEIN }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->TIMEIN }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->DATEOUT }}</td>
                                                            <td class="text-center" width="10%">{{$itemiop->TIMEOUT }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="PAT" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example12" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HCODE</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">CHANGWAT</th> 
                                                        <th class="text-center">AMPHUR</th> 
                                                        <th class="text-center">DOB</th> 
                                                        <th class="text-center">SEX</th> 
                                                        <th class="text-center">MARRIAGE</th> 
                                                        <th class="text-center">OCCUPA</th>  
                                                        <th class="text-center">NATION</th>  
                                                        <th class="text-center">PERSON_ID</th>  
                                                        <th class="text-center">NAMEPAT</th>  
                                                        <th class="text-center">TITLE</th>  
                                                        <th class="text-center">FNAME</th>  
                                                        <th class="text-center">LNAME</th>  
                                                        <th class="text-center">IDTYPE</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $f = 0; ?>
                                                    @foreach ($data_pat as $pat)
                                                    <?php $f++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-center" style="text-align: center;" width="5%">{{ $f }}</td>
                                                            <td class="text-center" width="5%">{{$pat->HCODE }}</td>
                                                            <td class="text-center" width="5%">{{$pat->HN }}</td>
                                                            <td class="text-center" width="5%">{{ $pat->CHANGWAT }}</td>  
                                                            <td class="text-center" width="5%">{{$pat->AMPHUR }}</td>
                                                            <td class="text-center" width="10%">{{$pat->DOB }}</td>
                                                            <td class="text-center" width="5%">{{$pat->SEX }}</td>
                                                            <td class="text-center" width="5%">{{$pat->MARRIAGE }}</td>
                                                            <td class="text-center" width="5%">{{$pat->OCCUPA }}</td> 
                                                            <td class="text-center" width="5%">{{$pat->NATION }}</td> 
                                                            <td class="text-center" width="5%">{{$pat->PERSON_ID }}</td> 
                                                            <td class="text-start" >{{$pat->NAMEPAT }}</td> 
                                                            <td class="text-center" width="5%">{{$pat->TITLE }}</td> 
                                                            <td class="text-start" width="5%">{{$pat->FNAME }}</td> 
                                                            <td class="text-start" width="5%">{{$pat->LNAME }}</td> 
                                                            <td class="text-center" width="5%">{{$pat->IDTYPE }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                    
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="CHT" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example13" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th> 
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">AN</th> 
                                                        <th class="text-center">DATE</th> 
                                                        <th class="text-center">TOTAL</th> 
                                                        <th class="text-center">PAID</th> 
                                                        <th class="text-center">PTTYPE</th> 
                                                        <th class="text-center">PERSON_ID</th>  
                                                        <th class="text-center">SEQ</th>  
                                                        <th class="text-center">OPD_MEMO</th>  
                                                        <th class="text-center">INVOICE_NO</th>  
                                                        <th class="text-center">INVOICE_LT</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $g = 0; ?>
                                                    @foreach ($data_cht as $cht)
                                                    <?php $g++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-center" style="text-align: center;" width="5%">{{ $g }}</td> 
                                                            <td class="text-center" width="10%">{{$cht->HN }}</td>
                                                            <td class="text-center" width="5%">{{ $cht->AN }}</td>  
                                                            <td class="text-center" width="10%">{{$cht->DATE }}</td>
                                                            <td class="text-center" width="10%">{{$cht->TOTAL }}</td>
                                                            <td class="text-center" width="5%">{{$cht->PAID }}</td>
                                                            <td class="text-center" width="5%">{{$cht->PTTYPE }}</td>
                                                            <td class="text-center" >{{$cht->PERSON_ID }}</td> 
                                                            <td class="text-center" width="10%">{{$cht->SEQ }}</td> 
                                                            <td class="text-center" width="5%">{{$cht->OPD_MEMO }}</td> 
                                                            <td class="text-start" width="5%">{{$cht->INVOICE_NO }}</td> 
                                                            <td class="text-center" width="5%">{{$cht->INVOICE_LT }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                    
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="CHA" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example14" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">DATE</th> 
                                                        <th class="text-center">CHRGITEM</th> 
                                                        <th class="text-center">AMOUNT</th> 
                                                        <th class="text-center">PERSON_ID</th> 
                                                        <th class="text-center">SEQ</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $h = 0; ?>
                                                    @foreach ($data_cha as $cha)
                                                    <?php $h++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-center" style="text-align: center;" width="5%">{{ $h}}</td> 
                                                            <td class="text-center" width="10%">{{$cha->HN }}</td>
                                                            <td class="text-center" width="10%">{{ $cha->AN }}</td>  
                                                            <td class="text-center" width="10%">{{$cha->DATE }}</td>
                                                            <td class="text-center" width="10%">{{$cha->CHRGITEM }}</td>
                                                            <td class="text-center" width="10%">{{$cha->AMOUNT }}</td>
                                                            <td class="text-center">{{$cha->PERSON_ID }}</td> 
                                                            <td class="text-center" >{{$cha->SEQ }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                    
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="INS" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example15" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">INSCL</th>
                                                        <th class="text-center">SUBTYPE</th> 
                                                        <th class="text-center">CID</th> 
                                                        <th class="text-center">DATEIN</th> 
                                                        <th class="text-center">DATEEXP</th> 
                                                        <th class="text-center">HOSPMAIN</th> 
                                                        <th class="text-center">HOSPSUB</th> 
                                                        <th class="text-center">PERMITNO</th> 
                                                        <th class="text-center">SEQ</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($data_ins as $ins)
                                                    <?php $i++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-center" style="text-align: center;" width="5%">{{ $i}}</td> 
                                                            <td class="text-center" width="10%">{{$ins->HN }}</td>
                                                            <td class="text-center" width="10%">{{$ins->INSCL }}</td>  
                                                            <td class="text-center" width="10%">{{$ins->SUBTYPE }}</td>
                                                            <td class="text-center" width="10%">{{$ins->CID }}</td>
                                                            <td class="text-center" width="10%">{{$ins->DATEIN }}</td>
                                                            <td class="text-center">{{$ins->DATEEXP }}</td> 
                                                            <td class="text-center" >{{$ins->HOSPMAIN }}</td>  
                                                            <td class="text-center" >{{$ins->HOSPSUB }}</td> 
                                                            <td class="text-center" >{{$ins->PERMITNO }}</td> 
                                                            <td class="text-center" >{{$ins->SEQ }}</td> 
                                                        </tr>  
                                                    @endforeach 
                                                    
                                                </tbody>
                                            </table>
                                        </p>
                                    </div> 
                                    <div class="tab-pane" id="ADP" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example16" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">DATEOPD</th> 
                                                        <th class="text-center">TYPE</th> 
                                                        <th class="text-center">CODE</th> 
                                                        <th class="text-center">QTY</th> 
                                                        <th class="text-center">RATE</th> 
                                                        <th class="text-center">SEQ</th> 
                                                        {{-- <th class="text-center">CAGCODE</th> --}}
                                                        {{-- <th class="text-center">DOSE</th> --}}
                                                        {{-- <th class="text-center">CA_TYPE</th> --}}
                                                        {{-- <th class="text-center">SERIALNO</th> --}}
                                                        <th class="text-center">TOTCOPAY</th>
                                                        {{-- <th class="text-center">USE_STATUS</th> --}}
                                                        <th class="text-center">TOTAL</th>
                                                        {{-- <th class="text-center">QTYDAY</th> --}}
                                                        {{-- <th class="text-center">TMLTCODE</th> --}}
                                                        {{-- <th class="text-center">STATUS1</th> --}}
                                                        {{-- <th class="text-center">BI</th> --}}
                                                        {{-- <th class="text-center">CLINIC</th> --}}
                                                        {{-- <th class="text-center">ITEMSRC</th> --}}
                                                        {{-- <th class="text-center">PROVIDER</th> --}}
                                                        <th class="text-center">GRAVIDA</th>
                                                        <th class="text-center">GA_WEEK</th>
                                                        <th class="text-center">DCIP</th>
                                                        <th class="text-center">LMP</th>
                                                        <th class="text-center">SP_ITEM</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $k = 0; ?>
                                                    @foreach ($data_adp as $itemadp)
                                                    <?php $k++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $k }}</td>
                                                            <td class="text-center" width="5%">{{$itemadp->HN }}</td>
                                                            <td class="text-center" width="7%">{{$itemadp->AN }}</td>
                                                            <td class="text-center" width="5%">{{ $itemadp->DATEOPD }}</td>  
                                                            <td class="text-center" >{{$itemadp->TYPE }}</td>
                                                            <td class="text-center" >{{$itemadp->CODE }}</td>
                                                            <td class="text-center" >{{$itemadp->QTY }}</td>
                                                            <td class="text-center" >{{$itemadp->RATE }}</td>
                                                            <td class="text-center" >{{$itemadp->SEQ }}</td> 
                                                            {{-- <td class="text-center" >{{$itemadp->CAGCODE }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->DOSE }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->CA_TYPE }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->SERIALNO }}</td>  --}}
                                                            <td class="text-center" >{{$itemadp->TOTCOPAY }}</td> 
                                                            {{-- <td class="text-center" >{{$itemadp->USE_STATUS }}</td>  --}}
                                                            <td class="text-center" >{{$itemadp->TOTAL }}</td> 
                                                            {{-- <td class="text-center" >{{$itemadp->QTYDAY }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->TMLTCODE }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->STATUS1 }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->BI }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->CLINIC }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->ITEMSRC }}</td>  --}}
                                                            {{-- <td class="text-center" >{{$itemadp->PROVIDER }}</td>  --}}
                                                            <td class="text-center">{{$itemadp->GRAVIDA }}</td> 
                                                            <td class="text-center" >{{$itemadp->GA_WEEK }}</td> 
                                                            <td class="text-center" >{{$itemadp->DCIP }}</td> 
                                                            <td class="text-center" >{{$itemadp->LMP }}</td> 
                                                            <td class="text-center" >{{$itemadp->SP_ITEM }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="DRU" role="tabpanel">
                                        <p class="mb-0">
                                            <table id="example17" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr style="font-size: 13px">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">HCODE</th>
                                                        <th class="text-center">HN</th>
                                                        <th class="text-center">AN</th>
                                                        <th class="text-center">CLINIC</th> 
                                                        <th class="text-center">DATE_SERV</th> 
                                                        <th class="text-center">DID</th> 
                                                        <th class="text-center">DIDNAME</th> 
                                                        <th class="text-center">AMOUNT</th> 
                                                        <th class="text-center">DRUGPRICE</th>  
                                                        <th class="text-center">DRUGCOST</th>
                                                        <th class="text-center">DIDSTD</th>
                                                        <th class="text-center">UNIT</th>
                                                        <th class="text-center">UNIT_PACK</th>
                                                        <th class="text-center">SEQ</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $k = 0; ?>
                                                    @foreach ($data_dru as $dru)
                                                    <?php $k++; ?> 
                                                        <tr height="20" style="font-size: 12px;">
                                                            <td class="text-font" style="text-align: center;" width="5%">{{ $k }}</td>
                                                            <td class="text-center" width="5%">{{$dru->HCODE }}</td>
                                                            <td class="text-center" width="5%">{{$dru->HN }}</td>
                                                            <td class="text-center" width="7%">{{$dru->AN }}</td>
                                                            <td class="text-center" width="5%">{{ $dru->CLINIC }}</td>  
                                                            <td class="text-center" >{{$dru->DATE_SERV }}</td>
                                                            <td class="text-center" >{{$dru->DID }}</td>
                                                            <td class="text-start" >{{$dru->DIDNAME }}</td>
                                                            <td class="text-center" >{{$dru->AMOUNT }}</td>
                                                            <td class="text-center" >{{$dru->DRUGPRICE }}</td>  
                                                            <td class="text-center">{{$dru->DRUGCOST }}</td> 
                                                            <td class="text-center" >{{$dru->DIDSTD }}</td> 
                                                            <td class="text-center" >{{$dru->UNIT }}</td> 
                                                            <td class="text-center" >{{$dru->UNIT_PACK }}</td> 
                                                            <td class="text-center" >{{$dru->SEQ }}</td>  
                                                        </tr>  
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
    
                                </div>
    
                            </div>
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
       function check() {
        var onoff; 
        document.getElementById("myCheck").checked = true;
        onoff = "Y";
          var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_209pp_claimswitch')}}",
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
                    url:"{{route('acc.account_209pp_claimswitch')}}",
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

        // function account_401_claimswitch(claim_active){
            // var nameVar = document.getElementById("claim_active").value;
            // var checkBox = document.getElementById(claim_active);
            // alert(checkBox);
            // var onoff;            
            // if (checkBox.checked == true){
            //     onoff = "Y";
            // } else {
            //     onoff = "N";
            // } 
            // var _token=$('input[name="_token"]').val();
            // $.ajax({
            //         url:"{{route('acc.account_401_claimswitch')}}",
            //         method:"GET",
            //         data:{onoff:onoff,claim_active:claim_active,_token:_token}
            // })
    //    }
        $(document).ready(function() {
            $('#example7').DataTable();
            $('#example8').DataTable();
            var table = $('#example21').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
            });
            var table = $('#example22').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
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
            $('.Savestamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
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
                                                    Swal.fire({ position: "top-end",
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
                Swal.fire({ position: "top-end",
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
                                    url: "{{ route('acc.account_209pp_pulldata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({ position: "top-end",
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

            $('#SenddataAPI').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการส่งข้อมูลไป New Eclaim ใช่ไหม ?',
                        text: "You Warn Send Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.account_401_send_api') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ส่งข้อมูลไป New Eclaim สำเร็จ',
                                                text: "You Send data New Eclaim success",
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

            $('#destroy').on('click', function(e) {           
                    if($(this).is(':checked',true))  
                        {
                            $(".sub_destroy").prop('checked', true);  
                        } else {  
                            $(".sub_destroy").prop('checked',false);  
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
                                                    Swal.fire({ position: "top-end",
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
 
        });
    </script>
    @endsection
