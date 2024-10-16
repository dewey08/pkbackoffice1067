@extends('layouts.admindashboard')
@section('title', 'PK-OFFICE || ผู้ดูแลระบบ')

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

    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber                = UsersuppliesController::refnumber();
    $checkhn                  = StaticController::checkhn($iduser);
    $checkhnshow              = StaticController::checkhnshow($iduser);
    $count_suprephn           = StaticController::count_suprephn($iduser);
    $count_bookrep_rong       = StaticController::count_bookrep_rong();
    $count_bookrep_po         = StaticController::count_bookrep_po();
    $countpesmiss_per         = StaticController::countpesmiss_per($iduser);
    $countpesmiss_book        = StaticController::countpesmiss_book($iduser);
    $countpesmiss_car         = StaticController::countpesmiss_car($iduser);
    $countpesmiss_meetting    = StaticController::countpesmiss_meetting($iduser);
    $countpesmiss_repair      = StaticController::countpesmiss_repair($iduser);
    $countpesmiss_com         = StaticController::countpesmiss_com($iduser);
    $countpesmiss_medical     = StaticController::countpesmiss_medical($iduser);
    $countpesmiss_hosing      = StaticController::countpesmiss_hosing($iduser);
    $countpesmiss_plan        = StaticController::countpesmiss_plan($iduser);
    $countpesmiss_asset       = StaticController::countpesmiss_asset($iduser);
    $countpesmiss_supplies    = StaticController::countpesmiss_supplies($iduser);
    $countpesmiss_store       = StaticController::countpesmiss_store($iduser);
    $countpesmiss_store_dug   = StaticController::countpesmiss_store_dug($iduser);
    $countpesmiss_pay         = StaticController::countpesmiss_pay($iduser);
    $countpesmiss_money       = StaticController::countpesmiss_money($iduser);
    $countpesmiss_claim       = StaticController::countpesmiss_claim($iduser);
    $countpermiss_gleave      = StaticController::countpermiss_gleave($iduser);
    $countpermiss_ot          = StaticController::countpermiss_ot($iduser);
    $countpermiss_medicine    = StaticController::countpermiss_medicine($iduser);
    $countpermiss_p4p         = StaticController::countpermiss_p4p($iduser);
    $countpermiss_time        = StaticController::countpermiss_time($iduser);
    $countpermiss_env         = StaticController::countpermiss_env($iduser);
    $permiss_account          = StaticController::permiss_account($iduser);
    $permiss_report_all       = StaticController::permiss_report_all($iduser);
    $permiss_sot              = StaticController::permiss_sot($iduser);
    $permiss_clinic_tb        = StaticController::permiss_clinic_tb($iduser);
    $permiss_medicine_salt    = StaticController::permiss_medicine_salt($iduser);
    $pesmiss_ct               = StaticController::pesmiss_ct($iduser);
    $per_prs                  = StaticController::per_prs($iduser);
    $per_cctv                 = StaticController::per_cctv($iduser);
    $per_fire                 = StaticController::per_fire($iduser);
    $per_air                  = StaticController::per_air($iduser);
    // $per_prs                  = StaticController::per_prs($iduser);
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
               border: 5px #ddd solid;
               border-top: 10px #e92cf0 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
               .popic {
                    position: absolute;
                    width: 180px;
                    height: 170px;
                    /* background:
                        url(/pkbackoffice/public/images/ponews.png)no-repeat 100%; */
                    /* url(/sky16/images/logo250.png)no-repeat 25%; */
                    /* background-size: cover; */
                    top: 70%;
                    right: 1%;
                    z-index: -1;
                    animation: float 2s ease-in-out infinite;
                }
    </style>
 
    <br>

    <div class="container-fluid mt-3 mb-4">
        <div class="popic hover-shadow"> <img src="{{ asset('storage/person/' . Auth::user()->img) }}" width="150"
                height="150" alt="" style="border-radius: 50%;"></div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('pre_audit') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(250, 128, 124)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('pre_audit') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">PRE-AUDIT</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('pre_audit') }}" target="_blank"> --}}
                                                    <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill"> 
                                                            <img src="{{ asset('images/user.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            @if ($countpesmiss_per != 0)   
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('person/person_index') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(236, 188, 198)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('person/person_index') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">PERSONNEL</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('person/person_index') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25"
                                                            style="color: rgb(234, 157, 172)"></i> --}}
                                                            <img src="{{ asset('images/user.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            @if ($countpermiss_ot != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('otone') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(199, 181, 240)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('otone') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">OT</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('otone') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        <img src="{{ asset('images/otnew.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                        {{-- <i class="fa-solid fa-3x fa-clock-rotate-left font-size-25"
                                                            style="color: rgb(171, 149, 223)"></i> --}}
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            @if ($countpermiss_time != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('time_dashboard') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(152, 226, 224)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('time_dashboard') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">TIME</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('time_dashboard') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        <img src="{{ asset('images/time.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                        {{-- <i class="fa-solid fa-3x fa-clock font-size-25 ms-2"
                                                            style="color: rgb(119, 218, 215)"></i> --}}
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            {{-- @if ($countpesmiss_book != 0)  
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(245, 176, 250)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <h5 class="text-start mb-2">DOCUMENT</h5>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('book/bookmake_index') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                   
                                                        <img src="{{ asset('images/document.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}
            
            @if ($countpesmiss_plan != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('plan') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(247, 217, 217)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('plan') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">PLAN</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('plan') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-clipboard font-size-25"
                                                            style="color: rgb(248, 182, 182)"></i> --}}
                                                            <img src="{{ asset('images/plan2.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            {{-- <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill"
                    style="background-color: rgba(174, 180, 177, 0.781)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <a href="{{ url('article/article_index') }}" target="_blank">
                                                <h5 class="text-start mb-2">ASSET</h5>
                                            </a>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('article/article_index') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                    <i class="fa-solid fa-2x fa-building-shield font-size-22"
                                                        style="color: rgba(131, 150, 140, 0.692)" ></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  --}}
             
            {{-- @if ($countpesmiss_supplies != 0)  
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(255, 222, 161)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <a href="{{ url('supplies/supplies_index') }}" target="_blank">
                                                <h5 class="text-start mb-2">SUPPLIES</h5>
                                            </a>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('supplies/supplies_index') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill"> 
                                                        <img src="{{ asset('images/list1.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}
    
            {{-- @if ($countpesmiss_com != 0)  
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(171, 175, 173)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <a href="{{ url('computer/com_staff_calenda') }}" target="_blank">
                                                <h5 class="text-start mb-2">COMPUTER</h5>
                                            </a>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('computer/com_staff_calenda') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                   
                                                        <img src="{{ asset('images/computer.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}
    
            @if ($countpesmiss_medical != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('medical/med_calenda') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(170, 167, 250)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('medical/med_calenda') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">MEDICAL</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('medical/med_calenda') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-notes-medical font-size-25"
                                                            style="color: rgb(137, 134, 236)"></i> --}}
                                                            <img src="{{ asset('images/medical.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
             @if ($countpesmiss_store != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('warehouse/warehouse_index') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(145, 220, 231)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('warehouse/warehouse_index') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">WAREHOUSE</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('warehouse/warehouse_index') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-warehouse font-size-25"
                                                            style="color: rgb(107, 189, 202)"></i> --}}
                                                            {{-- <img src="{{ asset('images/warehouse.png') }}" height="70px" width="70px" class="rounded-circle me-3">  --}}
                                                            <img src="{{ asset('images/store.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            @if ($countpesmiss_money != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('account_info') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(252, 177, 210)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('account_info') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">FINANCE</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('account_info') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-money-check-dollar font-size-25"
                                                            style="color: rgb(223, 136, 173)"></i> --}}
                                                            <img src="{{ asset('images/finace.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            @if ($permiss_account != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('account_pk_dash') }}" target="_blank">
                    <div class="main-card mb-2 card shadow-lg rounded-pill" style="background-color: pink">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('account_pk_dash') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">ACCOUNT</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('account_pk_dash') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-file-invoice-dollar font-size-26"
                                                            style="color: pink"></i> --}}
                                                            <img src="{{ asset('images/accountnew.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
    
            @if ($countpermiss_p4p != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('p4p') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(235, 104, 247, 0.781)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('p4p') }}" target="_blank"> --}}
                                                    <h5 class="text-start">P4P</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('p4p') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-p fa-3x text-danger font-size-25 ms-3"></i> --}}
                                                        <img src="{{ asset('images/clipboard.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                        
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
     
            @if ($countpermiss_env != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('env_dashboard') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(93, 218, 114)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('env_dashboard') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">ENV</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ">
                                                {{-- <a href="{{ url('env_dashboard') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-hand-holding-droplet font-size-25"
                                                            style="color: rgb(90, 197, 215)"></i> --}}
                                                            <img src="{{ asset('images/env.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                    </span>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
      
            {{-- @if ($countpesmiss_per != 0)   --}}
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('prenatal_care_db') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(209, 180, 255)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-12 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('prenatal_care_db') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">PEDIATRICS</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('prenatal_care_db') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-person-breastfeeding font-size-25"
                                                            style="color: rgb(209, 180, 255)"></i> --}}
                                                            <img src="{{ asset('images/pediatrics.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- @endif --}}
    
            @if ($permiss_medicine_salt != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('medicine_salt') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(106, 218, 190, 0.884)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('medicine_salt') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">แพทย์แผนไทย</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('medicine_salt') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-square-person-confined font-size-25 "
                                                            style="color: rgba(22, 145, 114, 0.74)"></i> --}}
                                                            <img src="{{ asset('images/thai_medical.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                    </span>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
     
            @if ($countpesmiss_claim != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('pkclaim_info') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(247, 198, 176)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('pkclaim_info') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">CLAIM </h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar">
                                                {{-- <a href="{{ url('pkclaim_info') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                        {{-- <i class="fa-solid fa-3x fa-sack-dollar font-size-25 ms-2"
                                                            style="color: rgb(245, 180, 150)"></i> --}}
                                                            <img src="{{ asset('images/claim2.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a> 
            </div>
            @endif
     
            @if ($pesmiss_ct != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('ct_rep') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(23, 189, 147, 0.74)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('ct_rep') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">DIALYSIS CT</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('ct_rep') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill"> 
                                                            {{-- <i class="fa-regular fa-heart fa-3x font-size-25" style="color: rgba(23, 189, 147, 0.74)"></i> --}}
                                                            <img src="{{ asset('images/ct_scan_2.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a> 
            </div>
            @endif
    
            @if ($permiss_report_all != 0)  
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('report_db') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(209, 180, 255, 0.74)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('report_db') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">REPORT ALL</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('report_db') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill"> 
                                                            {{-- <i class="fa-solid fa-chart-line fa-3x font-size-25" style="color: rgba(209, 180, 255, 0.74)"></i>  --}}
                                                            <img src="{{ asset('images/report.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a>
            </div>
            @endif

            
            @if ($permiss_sot != 0) 
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('audiovisual_admin') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(125, 148, 252, 0.74)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('audiovisual_admin') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">งานโสต</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('audiovisual_admin') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill"> 
                                                            
                                                            <img src="{{ asset('images/camerasot.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a>
            </div>
            @endif

            @if ($permiss_clinic_tb != 0) 
            <div class="col-xl-3 col-md-3">
                <a href="{{ url('tb_main') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(93, 199, 241, 0.74)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('tb_main') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">CLINIC TB</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('tb_main') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                            <img src="{{ asset('images/protective.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a> 
            </div>
            @endif

            {{-- <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill"
                    style="background-color: rgba(241, 188, 90, 0.74)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <a href="" target="_blank">
                                                <h5 class="text-start mb-2">DENTAL</h5>
                                            </a>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('dental') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                        <img src="{{ asset('images/dental.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> --}}

            @if ($per_prs != 0) 
          
                <div class="col-xl-3 col-md-6">
                    <a href="{{ url('support_main') }}" target="_blank">
                        <div class="main-card mb-3 card shadow-lg rounded-pill"
                            style="background-color: rgba(147, 204, 248, 0.871)">
                            <div class="grid-menu-col">
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover rounded-pill">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                    {{-- <a href="{{ url('support_main') }}" target="_blank"> --}}
                                                        {{-- <h5 class="text-start mb-2">Support System</h5> --}}
                                                        <h6 class="text-start mb-2">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ</h6> 
                                                    {{-- </a> --}}
                                                </div>
                                                <div class="avatar ms-2">
                                                    {{-- <a href="{{ url('support_main') }}" target="_blank"> --}}
                                                        <button
                                                            class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                                <img src="{{ asset('images/support.png') }}" height="40px" width="40px" class="rounded-circle me-3"> 
                                                        </button>
                                                    {{-- </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </a>
                </div>
      
            @endif
            {{-- <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card shadow-lg rounded-pill"
                    style="background-color: rgba(147, 204, 248, 0.871)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                            <a href="" target="_blank">
                                                <h5 class="text-start mb-2">CCTV</h5>
                                            </a>
                                        </div>
                                        <div class="avatar ms-2">
                                            <a href="{{ url('cctv') }}" target="_blank">
                                                <button
                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                        <img src="{{ asset('images/cctv1.png') }}" height="70px" width="90px" class="rounded-circle me-3"> 
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> --}}

            <div class="col-xl-3 col-md-3">
                <a href="{{ url('fdh_dashboard') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(21, 177, 164, 0.871)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('fdh_dashboard') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">FDH</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('fdh_dashboard') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                            <img src="{{ asset('images/LOGO-FDH.png') }}" height="40px" width="80px" class="rounded-circle"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a>
            </div>


            <div class="col-xl-3 col-md-3">
                <a href="{{ url('nurse_index') }}" target="_blank">
                    <div class="main-card mb-3 card shadow-lg rounded-pill"
                        style="background-color: rgba(242, 205, 252, 0.871)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICE</p>
                                                {{-- <a href="{{ url('nurse_index') }}" target="_blank"> --}}
                                                    <h5 class="text-start mb-2">NURSE</h5>
                                                {{-- </a> --}}
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a href="{{ url('nurse_index') }}" target="_blank"> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                                            <img src="{{ asset('images/nurse.png') }}" height="40px" width="40px" class="rounded-circle"> 
                                                    </button>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </a> 
            </div>
 


    </div>


    <?php
        $datadetail = DB::connection('mysql')->select('select * from orginfo where orginfo_id = 1');
    ?>

@endsection
