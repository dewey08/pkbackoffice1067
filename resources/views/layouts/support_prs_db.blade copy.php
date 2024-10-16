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
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Srisakdi&display=swap" rel="stylesheet"> --}}
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

        
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> --}}

 
    {{-- <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />  
    <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}"> 
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}"> --}}


       <!-- App favicon -->
   

       <!-- jquery.vectormap css -->
       <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

       <!-- DataTables -->
       <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

       <!-- Responsive datatable examples -->
       <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  

       <!-- Bootstrap Css -->
       <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
       <!-- Icons Css -->
       <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
       <!-- App Css-->
       <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
       {{-- <link href="{{ asset('assets/css/app-dark.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
 
</head>
 

<style>
    body {
        /* background: */
        /* url(/pkbackoffice/public/images/bg7.png);  */
        /* -webkit-background-size: cover; */
        /* background-color: rgb(245, 240, 240); */
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* background-size: cover; */
        background-size: 100% 100%;
        /* display: flex; */
        /* align-items: center; */
        /* justify-content: center; */
        /* width: 100vw;   ให้เต็มพอดี */
        /* height: 100vh; ให้เต็มพอดี  */
        font-size: 13px;
    }

    .Bgsidebar {
        background-image: url('/pkbackoffice/public/images/bgside.jpg');
        background-repeat: no-repeat;
    }

    .Bgheader {
        background-image: url('/pkbackoffice/public/images/bgheader.jpg');
        background-repeat: no-repeat;
    }

    .fonts13{
        font-size: 13px";
    }
 
    .card_prs_2b{
        border-radius: 0em 0em 2em 2em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        border:solid 1px #0583cc;
    }
    .card_prs_4{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 25px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
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
 {{-- <body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed"> --}}
{{-- <body data-topbar="dark"> --}}
    <body data-layout="horizontal" data-topbar="dark">
        {{-- <body data-topbar="dark" data-layout="horizontal"> --}}
    {{-- <body style="background-image: url('my_bg.jpg');"> --}}
    <!-- Begin page -->
    <div id="layout-wrapper">

        {{-- <header id="page-topbar"> 
                <div class="navbar-header shadow" style="background-color: #37d4cf">

                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{url('support_system_dashboard')}}" class="logo logo-dark">
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
                                    <img src="{{ asset('images/officer5.png') }}" class="" alt="logo-sm-light" height="30">
                                   
                                </span>
                                
                            </a>
                        </div>
    
                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle" style="color: black"></i>
                        </button>
                        <?php
                            $org = DB::connection('mysql')->select(                                                            '
                                    select * from orginfo
                                    where orginfo_id = 1                                                                                                                      ',
                            );
                        ?>
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                @foreach ($org as $item)
                                <h3 style="color:rgb(255, 255, 255)" class="mt-2 noto-sans-thai-looped-light">Support-System</h3>
                                @endforeach
    
                            </div>
                        </form>
                    </div>
     
                    <div class="d-flex">                    
                      
                            <div class="header-btn-lg"> 
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="ri-fullscreen-line" style="color: rgb(9, 75, 129);font-size:30px;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Fullscreen"></i>
                                </button>
                            </div> 
                            <div class="header-btn-lg">
                                <div class="dropdown">
                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                            <span class="icon-wrapper-bg bg-danger"></span>
                                         
                                            <i class="fa-regular fa-bell text-danger"></i>
                                        </span>  
                                    </button>
                                </div> 
                            </div>
                          
                            <div class="header-btn-lg pe-0">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="btn-group"> 
                                                <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn"> 
                                                    @if (Auth::user()->img == null)
                                                        <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle loadingIcon" alt="">
                                                    @else
                                                        <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle loadingIcon" alt="">
                                                    @endif 
                                                    <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                                </a>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                                    <div class="dropdown-menu-header">
                                                        <div class="dropdown-menu-header-inner bg-primary">
                                                          
                                                            <div class="menu-header-content text-start">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="widget-content-left me-3"> 
                                                                                @if (Auth::user()->img == null)
                                                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle" alt="">
                                                                                @else
                                                                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle" alt="">
                                                                                @endif
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                                                            <div class="widget-subheading opacity-8">{{ Auth::user()->position_name }}</div>
                                                                        </div>
                                                                        <div class="widget-content-right me-2"> 
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="scroll-area-xs" style="height: 100px;">
                                                        <div class="scrollbar-container ps">
                                                            <ul class="nav flex-column"> 
                                                                <li class="nav-item">
                                                                    <a href="javascript:void(0);" class="nav-link">
                                                                        Messages
                                                                        <div class="ms-auto badge rounded-pill bg-primary">2</div>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="javascript:void(0);" class="nav-link" data-bs-toggle="modal" data-bs-target="#Keypassword">
                                                                        Change Password<i class="fa-solid fa-key ms-4" style="color: rgb(207, 34, 115)"></i>
                                                                        <div class="ms-auto badge rounded-pill bg-info">1</div>
                                                                    </a>
                                                                </li>
                                                              
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-divider mb-0 nav-item"></li>
                                                    </ul>
                                                    <div class="grid-menu grid-menu-2col">
                                                        <div class="g-0 row">
                                                            <div class="col-sm-6">
                                                               
                                                                <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-warning"  href="{{ url('admin_profile_edit/' . Auth::user()->id) }}"> 
                                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-warning">
                                                                        <i class="ri-user-line btn-icon-wrapper mb-2"></i>
                                                                        Profile
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                    @csrf
                                                                </form>
                                                                <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-danger">
                                                                        <i class="ri-shut-down-line align-middle btn-icon-wrapper mb-2"></i>
                                                                        Logout
                                                                    </button>
                                                                </a>
                                                             
                                                            </div>
                                                            
    
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left  ms-3 header-user-info">
                                            <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                            <div class="widget-subheading"> {{ Auth::user()->position_name }}</div>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="header-btn-lg">
                                <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
    
                    </div>
            </div>
        </header> --}}

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                      
                        <a href="{{url('support_main')}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/p.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        {{-- <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="logo-light" height="20">
                            </span>
                        </a> --}}
                        <a href="{{url('support_main')}}" class="logo logo-light">
                            <span class="logo-sm me-2">
                                <img src="{{ asset('images/pk_smal.png') }}" alt="logo-sm-light" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/officer5.png') }}" class="" alt="logo-sm-light" height="30">
                               
                            </span>
                            
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle" style="color: rgb(255, 252, 252)"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>

                    {{-- <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                            Mega Menu
                            <i class="mdi mdi-chevron-down"></i> 
                        </button>
                        <div class="dropdown-menu dropdown-megamenu">
                            <div class="row">
                                <div class="col-sm-8">
            
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="font-size-14">UI Components</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="javascript:void(0);">Lightbox</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Range Slider</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Sweet Alert</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Rating</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Forms</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Tables</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Charts</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="font-size-14">Applications</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="javascript:void(0);">Ecommerce</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Calendar</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Email</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Projects</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Tasks</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Contacts</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="font-size-14">Extra Pages</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="javascript:void(0);">Light Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Compact Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Horizontal layout</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Maintenance</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Coming Soon</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Timeline</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">FAQs</a>
                                                </li>
                                    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h5 class="font-size-14">UI Components</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="javascript:void(0);">Lightbox</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Range Slider</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Sweetalert 2</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Rating</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Forms</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Tables</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Charts</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-sm-5">
                                            <div>
                                                <img src="assets/images/megamenu-img.png" alt="megamenu-img" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}
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

                    {{-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">                                    
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                            </a>                     
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                            </a>                   
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                            </a>                 
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>
                        </div>
                    </div> --}}

                    {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <div class="px-lg-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                            <span>Mail Chimp</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="left" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255);font-size:30px;"></i>
                        </button>
                    </div>
                    
                    {{-- <div class="header-btn-lg"> 
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(9, 75, 129);font-size:30px;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Fullscreen"></i>
                        </button>
                    </div>  --}}
                    {{-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                              data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-shopping-cart-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-3.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="mb-1">James Lemire</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="ri-checkbox-circle-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-4.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="mb-1">Salena Layfield</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

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
                            <!-- item-->
                            <a class="dropdown-item" href="{{ url('admin_profile_edit/'. Auth::user()->id) }}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div> 
                            {{-- <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a> --}}
                            {{-- <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="ri-lock-unlock-line align-middle me-1" data-bs-toggle="modal" data-bs-target=".Keypassword"></i> Chang Password</a> --}}
                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Chang Password</button> --}}
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"><i class="ri-lock-unlock-line align-middle me-1"></i> Chang Password</a>
                            <div class="dropdown-divider"></div> 
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                  
                     
                   
                    {{-- <div class="header-btn-lg">
                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-danger"></span>
                                 
                                    <i class="fa-regular fa-bell text-danger"></i>
                                </span>  
                            </button>
                        </div> 
                    </div> --}}
                  
                    {{-- <div class="header-btn-lg pe-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group"> 
                                        <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn"> 
                                            @if (Auth::user()->img == null)
                                                <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle loadingIcon" alt="">
                                            @else
                                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle loadingIcon" alt="">
                                            @endif 
                                            <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-primary">
                                                  
                                                    <div class="menu-header-content text-start">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left me-3"> 
                                                                        @if (Auth::user()->img == null)
                                                                            <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle" alt="">
                                                                        @else
                                                                            <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle" alt="">
                                                                        @endif
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                                                    <div class="widget-subheading opacity-8">{{ Auth::user()->position_name }}</div>
                                                                </div>
                                                                <div class="widget-content-right me-2"> 
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scroll-area-xs" style="height: 100px;">
                                                <div class="scrollbar-container ps">
                                                    <ul class="nav flex-column"> 
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                Messages
                                                                <div class="ms-auto badge rounded-pill bg-primary">2</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link" data-bs-toggle="modal" data-bs-target="#Keypassword">
                                                                Change Password<i class="fa-solid fa-key ms-4" style="color: rgb(207, 34, 115)"></i>
                                                                <div class="ms-auto badge rounded-pill bg-info">1</div>
                                                            </a>
                                                        </li>
                                                      
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider mb-0 nav-item"></li>
                                            </ul>
                                            <div class="grid-menu grid-menu-2col">
                                                <div class="g-0 row">
                                                    <div class="col-sm-6">
                                                       
                                                        <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-warning"  href="{{ url('admin_profile_edit/' . Auth::user()->id) }}"> 
                                                            <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-warning">
                                                                <i class="ri-user-line btn-icon-wrapper mb-2"></i>
                                                                Profile
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                        <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                                                            <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-danger">
                                                                <i class="ri-shut-down-line align-middle btn-icon-wrapper mb-2"></i>
                                                                Logout
                                                            </button>
                                                        </a>
                                                     
                                                    </div>
                                                    

                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left ms-3 header-user-info">
                                    <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                    <div class="widget-subheading"> {{ Auth::user()->position_name }}</div>
                                </div>
                                 
                            </div>
                        </div>
                    </div> --}}
                   

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="ri-settings-2-line"></i>
                        </button>
                    </div>
        
                </div>
            </div>
        </header>
   
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link" href="index.html">
                                    <i class="ri-dashboard-line me-2"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                                >
                                    <i class="ri-pencil-ruler-2-line me-2"></i>UI Elements <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                    aria-labelledby="topnav-uielement">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-alerts.html" class="dropdown-item">Alerts</a>
                                                <a href="ui-buttons.html" class="dropdown-item">Buttons</a>
                                                <a href="ui-cards.html" class="dropdown-item">Cards</a>
                                                <a href="ui-carousel.html" class="dropdown-item">Carousel</a>
                                                <a href="ui-dropdowns.html" class="dropdown-item">Dropdowns</a>
                                                <a href="ui-grid.html" class="dropdown-item">Grid</a>
                                                <a href="ui-images.html" class="dropdown-item">Images</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-lightbox.html" class="dropdown-item">Lightbox</a>
                                                <a href="ui-modals.html" class="dropdown-item">Modals</a>
                                                <a href="ui-offcanvas.html" class="dropdown-item">Offcanvas</a>
                                                <a href="ui-rangeslider.html" class="dropdown-item">Range Slider</a>
                                                <a href="ui-roundslider.html" class="dropdown-item">Round slider</a>
                                                <a href="ui-session-timeout.html" class="dropdown-item">Session Timeout</a>
                                                <a href="ui-progressbars.html" class="dropdown-item">Progress Bars</a>                                           
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-sweet-alert.html" class="dropdown-item">Sweetalert 2</a>
                                                <a href="ui-tabs-accordions.html" class="dropdown-item">Tabs & Accordions</a>
                                                <a href="ui-typography.html" class="dropdown-item">Typography</a>
                                                <a href="ui-video.html" class="dropdown-item">Video</a>
                                                <a href="ui-general.html" class="dropdown-item">General</a>
                                                <a href="ui-rating.html" class="dropdown-item">Rating</a>
                                                <a href="ui-notifications.html" class="dropdown-item">Notifications</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                
               

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-apps-2-line me-2"></i>Apps <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <a href="calendar.html" class="dropdown-item">Calendar</a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                            role="button">
                                            Email <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox.html" class="dropdown-item">Inbox</a>
                                            <a href="email-read.html" class="dropdown-item">Read Email</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                >
                                    <i class="ri-stack-line me-2"></i>Components <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            Advance UI <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="advance-rangeslider.html" class="dropdown-item">Range Slider</a>
                                            <a href="advance-roundslider.html" class="dropdown-item">Round Slider</a>
                                            <a href="advance-session-timeout.html" class="dropdown-item">Session Timeout</a>
                                            <a href="advance-sweet-alert.html" class="dropdown-item">Sweetalert 2</a>
                                            <a href="advance-rating.html" class="dropdown-item">Rating</a>
                                            <a href="advance-notification.html" class="dropdown-item">Notification</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            Forms <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="form-elements.html" class="dropdown-item">Elements</a>
                                            <a href="form-validation.html" class="dropdown-item">Validation</a>
                                            <a href="form-advanced.html" class="dropdown-item">Advanced Plugins</a>
                                            <a href="form-editors.html" class="dropdown-item">Editors</a>
                                            <a href="form-uploads.html" class="dropdown-item">File Upload</a>
                                            <a href="form-xeditable.html" class="dropdown-item">Xeditable</a>
                                            <a href="form-wizard.html" class="dropdown-item">Wizard</a>
                                            <a href="form-mask.html" class="dropdown-item">Mask</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                            role="button">
                                            Tables <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-table">
                                            <a href="tables-basic.html" class="dropdown-item">Basic Tables</a>
                                            <a href="tables-datatable.html" class="dropdown-item">Data Tables</a>
                                            <a href="tables-responsive.html" class="dropdown-item">Responsive Table</a>
                                            <a href="tables-editable.html" class="dropdown-item">Editable Table</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                            role="button">
                                            Charts <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                            <a href="charts-apex.html" class="dropdown-item">Apex charts</a>
                                            <a href="charts-chartjs.html" class="dropdown-item">Chartjs</a>
                                            <a href="charts-flot.html" class="dropdown-item">Flot Chart</a>
                                            <a href="charts-knob.html" class="dropdown-item">Jquery Knob Chart</a>
                                            <a href="charts-sparkline.html" class="dropdown-item">Sparkline Chart</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                            role="button">
                                            Icons <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                            <a href="icons-remix.html" class="dropdown-item">Remix Icons</a>
                                            <a href="icons-materialdesign.html" class="dropdown-item">Material Design</a>
                                            <a href="icons-dripicons.html" class="dropdown-item">Dripicons</a>
                                            <a href="icons-fontawesome.html" class="dropdown-item">Font awesome 5</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                            role="button">
                                            Maps <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-map">
                                            <a href="maps-google.html" class="dropdown-item">Google Maps</a>
                                            <a href="maps-vector.html" class="dropdown-item">Vector Maps</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button"
                                >
                                    <i class="ri-file-copy-2-line me-2"></i>Pages <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-more">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                            role="button">
                                            Authentication <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                            <a href="auth-login.html" class="dropdown-item">Login</a>
                                            <a href="auth-register.html" class="dropdown-item">Register</a>
                                            <a href="auth-recoverpw.html" class="dropdown-item">Recover Password</a>
                                            <a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"
                                            role="button">
                                            Utility <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                            <a href="pages-starter.html" class="dropdown-item">Starter Page</a>
                                            <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                            <a href="pages-directory.html" class="dropdown-item">Directory</a>
                                            <a href="pages-invoice.html" class="dropdown-item">Invoice</a>
                                            <a href="pages-404.html" class="dropdown-item">Error 404</a>
                                            <a href="pages-500.html" class="dropdown-item">Error 500</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="ri-layout-3-line me-2"></i><span key="t-layouts">Layouts</span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Vertical</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                            <a href="layouts-dark-sidebar.html" class="dropdown-item" key="t-dark-sidebar">Dark Sidebar</a>
                                            <a href="layouts-compact-sidebar.html" class="dropdown-item" key="t-compact-sidebar">Compact Sidebar</a>
                                            <a href="layouts-icon-sidebar.html" class="dropdown-item" key="t-icon-sidebar">Icon Sidebar</a>
                                            <a href="layouts-boxed.html" class="dropdown-item" key="t-boxed-width">Boxed Width</a>
                                            <a href="layouts-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                            <a href="layouts-colored-sidebar.html" class="dropdown-item" key="t-colored-sidebar">Colored Sidebar</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                            role="button">
                                            <span key="t-horizontal">Horizontal</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                            <a href="layouts-horizontal.html" class="dropdown-item" key="t-horizontal">Horizontal</a>
                                            <a href="layouts-hori-topbar-light.html" class="dropdown-item" key="t-topbar-light">Topbar light</a>
                                            <a href="layouts-hori-boxed-width.html" class="dropdown-item" key="t-boxed-width">Boxed width</a>
                                            <a href="layouts-hori-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                            <a href="layouts-hori-colored-header.html" class="dropdown-item" key="t-colored-topbar">Colored Header</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ========== Left Sidebar Start ========== --> 
        {{-- <div class="vertical-menu"> 
                <div data-simplebar class="h-100 nom6">                
                <div id="sidebar-menu">                  
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>                         
                        @if ($per_fire != 0) 
                        <li><a href="javascript: void(0);" class="has-arrow">  
                            <i class="fa-solid fa-fire-extinguisher" style="color: #1699f0"></i>
                                <span>ถังดับเพลิง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true"> 
                                <li><a href="{{ url('fire_main') }}">รายการถังดับเพลิง</a></li>
                                <li><a href="{{ url('fire_report_day') }}">report รายวัน</a></li>
                                <li><a href="{{ url('fire_pramuan_admin') }}">แบบประเมิน</a></li>
                            </ul>
                        </li>
                        @endif
                        @if ($per_air != 0) 
                            <li><a href="javascript: void(0);" class="has-arrow">   
                                <i class="fa-solid fa-fan" style="color: #B216F0"></i>
                                    <span>เครื่องปรับอากาศ</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="{{ url('air_main') }}">ทะเบียนเครื่องปรับอากาศ</a></li>
                                    <li><a href="{{ url('air_main_repaire') }}">ทะเบียนแจ้งซ่อม</a></li>
                                    <li><a href="{{ url('air_report_type') }}">รายงานแยกตามประเภท</a></li> 
                                    <li><a href="{{ url('air_report_building') }}">รายงานแยกตามอาคาร</a></li> 
                                    <li><a href="{{ url('air_report_problems') }}">รายงานแยกตามปัญหา</a></li> 
                                </ul>
                            </li>
                        @endif                  
                        @if ($per_cctv != 0) 
                            <li><a href="javascript: void(0);" class="has-arrow"> 
                                <i class="fa-solid fa-video" style="color: #55595a"></i>
                                    <span>กล้อง CCTV </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="{{ url('cctv_list') }}">รายการกล้อง</a></li>
                                    <li><a href="{{ url('cctv_list_check') }}">บันทึกกล้องวงจรปิด</a></li>
                                    <li><a href="{{ url('cctv_report') }}">report รายวัน</a></li>
                                
                                </ul>
                            </li>  
                        @endif                  
                    </ul>
                </div>                
            </div>
        </div> --}}
        <!-- Left Sidebar End -->

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
            <div class="page-content Backgroupbody"> 
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

        <script src="{{ asset('pkclaim/js/pages/dashboard.init.js') }}"></script>

        <script src="{{ asset('pkclaim/js/app.js') }}"></script>

    <!-- JAVASCRIPT -->
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script> 
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
    <script type="text/javascript" src="{{ asset('acccph/vendors/jquery-circle-progress/dist/circle-progress.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('acccph/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/toastr/build/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script> 
    <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script> 
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script> 
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script> 
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('acccph/vendors/daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script> 
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
    <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>  --}}

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
