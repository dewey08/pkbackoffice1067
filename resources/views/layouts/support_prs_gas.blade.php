<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

        <!-- Font Awesome -->
        <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">    
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
        <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
   
       <!-- jquery.vectormap css -->
       <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

       <!-- DataTables -->
       <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

       <!-- Responsive datatable examples -->
       <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  

       <!-- Bootstrap Css -->
       {{-- <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
       <link href="{{ asset('pkclaim/css/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" />
       <!-- Icons Css -->
       <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
       <!-- App Css-->
       {{-- <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
       <link href="{{ asset('pkclaim/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" />
       
       <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}"> 
       <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


           {{-- <!-- jquery.vectormap css -->
           <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

           <!-- DataTables -->
           <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
   
           <!-- Responsive datatable examples -->
           <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
   
           <!-- Bootstrap Css -->
           <link href="assets/css/bootstrap-dark.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
           <!-- Icons Css -->
           <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
           <!-- App Css-->
           <link href="assets/css/app-dark.min.css" id="app-style" rel="stylesheet" type="text/css" /> --}}
</head>
 

<style>
    body { 
        /* background-color: rgb(44, 47, 51); */
        background-color: rgb(37, 38, 39);
        background-repeat: no-repeat;
        background-attachment: fixed; 
        background-size: 100% 100%; 
        font-size: 13px;
       
    }
    /* Logo หมุน */
    @keyframes colorShift {
        0% {
            background-color: #22dcdf
        }
        50% {
            background-color: #2ed82e
        }
        100% {
            background-color: #e95a5a
        }
    }
    .loadingIcon {
        width: 40px;
        height: 40px;
        border: 2px solid rgb(255, 255, 255);
        /* border-bottom: 4px solid transparent; */
        border-radius: 100%;
        animation: 6s infinite linear spin;
    }
    .loadingIcon2 {
        width: 40px;
        height: 40px;
        border: 2px solid rgb(255, 255, 255);
        /* border-bottom: 4px solid transparent; */
        border-radius: 100%;
        animation: 3s infinite linear spin;
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    #container_spin { 
        position: relative;
        /* top: 0; */
        /* left: 0; */
        /* right: 0; */
        /* bottom: 0; */
        text-align: center;
        width: 250px;
        height: 250px;
        /* left: 40%; */
        /* margin-left: -4em; */
    }

    @keyframes animation {
        0% {
            stroke-dasharray: 1 98;
            stroke-dashoffset: -105;
        }
        50% {
            stroke-dasharray: 80 10;
            stroke-dashoffset: -160;
        }
        100% {
            stroke-dasharray: 1 98;
            stroke-dashoffset: -300;
        }
    }

    #spinner {
        transform-origin: center;
        animation-name: animation;
        animation-duration: 2.5s;
        animation-timing-function: cubic-bezier;
        animation-iteration-count: infinite;
    }
 
    .card_prs_2b{
        border-radius: 0em 0em 2em 2em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        border:solid 1px #0583cc;
    }
    .bt_prs{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 25px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
        /* background-color: aliceblue; */
    }
    .bg_prs{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 25px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
        background-color: rgb(255, 255, 255);
    }
    .card_prs_4{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 25px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
        background-color: aliceblue;
    }
    .prscheckbox{         
        width: 20px;
        height: 20px;       
        /* border-radius: 2em 2em 2em 2em; */
        border: 10px solid rgb(250, 128, 124);
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 10px rgb(250, 128, 124);
        /* box-shadow: 0 0 10px teal; */
    }
    .dcheckbox{         
        width: 25px;
        height: 25px;       
        /* border-radius: 2em 2em 2em 2em; */
        border: 2px solid rgb(250, 128, 124);
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 5px rgb(250, 128, 124);
        /* box-shadow: 0 0 10px teal; */
    }
    .bg_prs{
        background-color: rgb(255, 255, 255);
    }
     
</style>
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
    use App\Http\Controllers\UsersuppliesController;
    use App\Models\Products_request_sub;
    $permiss_account         = StaticController::permiss_account($iduser);
    $permiss_setting_upstm   = StaticController::permiss_setting_upstm($iduser);
    $permiss_ucs             = StaticController::permiss_ucs($iduser);
    $permiss_sss             = StaticController::permiss_sss($iduser);
    $permiss_ofc             = StaticController::permiss_ofc($iduser);
    $permiss_lgo             = StaticController::permiss_lgo($iduser);
    $permiss_prb             = StaticController::permiss_prb($iduser);
    $permiss_ti              = StaticController::permiss_ti($iduser);
    $permiss_rep_money       = StaticController::permiss_rep_money($iduser);

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

?>
 
 <body data-topbar="dark" data-layout="horizontal">
     
    <div id="layout-wrapper">

        
 
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
            
                    <div class="navbar-brand-box">
                      
                        {{-- <a href="{{url('support_system_dashboard')}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/p.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>
 
                        <a href="{{url('support_system_dashboard')}}" class="logo logo-light">
                            <span class="logo-sm me-2">
                                <img src="{{ asset('images/pk_smal.png') }}" alt="logo-sm-light" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/officer_g.png') }}" class="" alt="logo-sm-light" height="30"> 
                            </span>
                            
                        </a> --}}
                        <a href="{{url('support_main')}}" class="logo logo-dark"> 
                            <span class="logo-sm me-2"> 
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">  --}}
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">  --}}
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">
                            </span>
                        </a>
 
                        <a href="{{url('support_main')}}" class="logo logo-light">
                            <span class="logo-sm me-2">
                                {{-- <img src="{{ asset('images/pk_smal.png') }}" alt="logo-sm-light" height="40"> --}}
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> --}}
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/officer_g.png') }}" class="" alt="logo-sm-light" height="30"> --}}
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            
                        </a>
                        
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item mt-3" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-sm font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button> --}}
                    {{-- <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle" style="color: rgb(255, 252, 252)"></i>
                    </button> --}}

                
                    <form class="app-search d-none d-lg-block mt-3 ms-3">
                        <div class="position-relative">
                            <h3 style="color:rgb(255, 255, 255)" class="mt-1 noto-sans-thai-looped-light">M E D I C A L - G A S</h3> 
                        </div>
                    </form> 
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
 
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="left" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255);font-size:30px;"></i>
                        </button>
                    </div>
                   

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle loadingIcon" alt="">
                            @else
                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle loadingIcon" alt="">
                            @endif 
                            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                     
                            <a class="dropdown-item" href="{{ url('admin_profile_edit/'. Auth::user()->id) }}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div> 
                            
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"><i class="ri-lock-unlock-line align-middle me-1"></i> Chang Password</a>
                            <div class="dropdown-divider"></div> 
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
 
                    <button type="button" class="btn btn-sm font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    {{-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="ri-settings-2-line"></i>
                        </button>
                    </div> --}}
                    
        
                </div>
            </div>
        </header>
   
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('medicalgas_db') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-chart-pie me-2"></i>Dashboard  
                                </a> 
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('medicalgas_list') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-fire-extinguisher me-2"></i>ทะเบียนก๊าซทางการแพทย์ 
                                </a>
                                
                            </li>

 

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('gas_check_list') }}" id="topnav-more" role="button">
                                   <i class="fa-solid fa-fire-flame-simple me-2"></i> บันทึกการตรวจสอบ
                                </a>
                            </li> --}}

                             <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fa-solid fa-fire-flame-simple me-2"></i><span key="t-layouts">บันทึกการตรวจสอบ</span> <div class="arrow-down"></div>
                              
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('gas_check_tank')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Tank Liquid Oxygen(Main)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('gas_check_tanksub')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Tank Liquid Oxygen(Sub)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('gas_check_nitrus')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ไนตรัสออกไซด์ (N2O-6Q)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('gas_check_o2')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ก๊าซอ๊อกซิเจน (2Q-6Q)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('gas_control')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Control Gas</span>  
                                        </a> 
                                    </div>
                                    {{-- <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting_year')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ตั้งค่าทะเบียนเครื่องปรับอากาศ(ปีงบประมาณ)</span>  
                                        </a> 
                                    </div> --}}
                                </div>
                            </li>

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('fire_report_ploblems') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-chart-line me-2"></i>รายงานปัญหา/ชำรุด  
                                </a>
                            </li> --}}
                  
                       

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('fire_report_month') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-chart-line me-2"></i>รายงานรวมรายเดือน 
                                </a>
                            </li> --}}
 
                          
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fas fa-tools me-2"></i><span key="t-layouts">Setting</span> <div class="arrow-down"></div>
                              
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('fire_stock_month')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ยกยอดสต็อครายเดือน</span>  
                                        </a> 
                                    </div> 
                                </div>
                            </li> --}}

                         
                        </ul>
                    </div>
                    
                </nav>
            </div>
        </div>
        
         <!--  Modal content for the Keypassword example -->
         <div class="modal fade" id="Keypassword" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">เปลี่ยนรหัสผ่าน </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-end"><label for="">รหัสผ่าน New</label></div>
                            <div class="col-md-7">
                                <div class="form-group text-center">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="button" id="SaveChang" class="btn btn-outline-info btn-sm" >
                                    <i class="fa-solid fa-floppy-disk me-1 text-info"></i>
                                    เปลี่ยน
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark text-danger me-2"></i>ปิด</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <h5 class="modal-title" id="myExtraLargeModalLabel">เปลี่ยนรหัสผ่าน </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-end"><label for="">รหัสผ่าน New</label></div>
                            <div class="col-md-7">
                                <div class="form-group text-center">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content"> 
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content') 
                </div>
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Created with <i class="mdi mdi-heart text-danger"></i> by ทีมพัฒนา PK-OFFICE
                            </div>
                        </div>
                    </div>
                </div>
            </footer>


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        {{-- <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css"> --}}
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
                    

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                    </div>
                  

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
                    {{-- <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div> --}}

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->
 
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('js/select2.min.js') }}"></script> 
        <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script> 
        <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
            integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- apexcharts -->
        <script src="{{ asset('pkclaim/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- jquery.vectormap map -->
        <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        
        <!-- Responsive examples -->
        <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>

        
        {{-- <script src="{{ asset('pkclaim/js/pages/dashboard.init.js') }}"></script> --}}
        <script src="{{ asset('pkclaim/js/app.js') }}"></script>
 
    @yield('footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#SaveChang').click(function() {
                var password = $('#password').val();  
                $.ajax({
                    url: "{{ route('user.password_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { 
                        password                       
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                                text: "You Chang password success",
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
                                     
                                }
                            })
                        } else {
                             
                        }

                    },
                });
            });

        });

        
    </script>

</body>

</html>
