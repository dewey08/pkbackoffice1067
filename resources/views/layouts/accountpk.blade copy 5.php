<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- <link href="{{ asset('pkclaim/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}">
 
</head>
<style>
        .noto-sans-thai-looped-thin {
            font-family: "Noto Sans Thai Looped", sans-serif;
            font-weight: 100;
            font-style: normal;
            }

        .noto-sans-thai-looped-extralight {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 200;
        font-style: normal;
        }

        .noto-sans-thai-looped-light {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 300;
        font-style: normal;
        }

        .noto-sans-thai-looped-regular {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 400;
        font-style: normal;
        }

        .noto-sans-thai-looped-medium {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 500;
        font-style: normal;
        }

        .noto-sans-thai-looped-semibold {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 600;
        font-style: normal;
        }

        .noto-sans-thai-looped-bold {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 700;
        font-style: normal;
        }

        .noto-sans-thai-looped-extrabold {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 800;
        font-style: normal;
        }

        .noto-sans-thai-looped-black {
        font-family: "Noto Sans Thai Looped", sans-serif;
        font-weight: 900;
        font-style: normal;
        }
</style>
<style>
    body {
        /* background: */
        /* url(/pkbackoffice/public/images/bg7.png);  */
        /* -webkit-background-size: cover; */
        background-color: rgb(245, 240, 240);
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* background-size: cover; */
        background-size: 100% 100%;
        /* display: flex; */
        /* align-items: center; */
        /* justify-content: center; */
        /* width: 100vw;   ให้เต็มพอดี */
        /* height: 100vh; ให้เต็มพอดี  */
    }

    .Bgsidebar {
        background-image: url('/pkbackoffice/public/images/bgside.jpg');
        background-repeat: no-repeat;
    }

    .Bgheader {
        background-image: url('/pkbackoffice/public/images/bgheader.jpg');
        background-repeat: no-repeat;
    }
    .myTable tbody tr{
        font-size:13px;
        height: 13px;
    }
    .card_pink{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px pink;
    }
    .card_audit_2b{
        border-radius: 0em 0em 3em 3em;
        box-shadow: 0 0 10px rgb(250, 128, 124);
    }
    .card_audit_4c{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 15px rgb(250, 128, 124);
        border:solid 1px #80acfd;
    }
    .card_audit_4{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(250, 128, 124);
    }
    .dcheckbox_{         
        width: 20px;
        height: 20px;       
        /* border-radius: 2em 2em 2em 2em; */
        border: 10px solid rgb(250, 128, 124);
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 10px rgb(250, 128, 124);
        /* box-shadow: 0 0 10px teal; */
    }
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
use App\Models\Products_request_sub;
$permiss_account = StaticController::permiss_account($iduser);
$permiss_setting_upstm = StaticController::permiss_setting_upstm($iduser);
$permiss_ucs = StaticController::permiss_ucs($iduser);
$permiss_sss = StaticController::permiss_sss($iduser);
$permiss_ofc = StaticController::permiss_ofc($iduser);
$permiss_lgo = StaticController::permiss_lgo($iduser);
$permiss_prb = StaticController::permiss_prb($iduser);
$permiss_ti = StaticController::permiss_ti($iduser);
$permiss_rep_money = StaticController::permiss_rep_money($iduser);

?>
 {{-- <body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed"> --}}
<body data-topbar="dark">
    {{-- <body style="background-image: url('my_bg.jpg');"> --}}
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            {{-- <div class="navbar-header shadow-lg" style="background-color: rgb(252, 252, 252)"> --}}
                <div class="navbar-header shadow" style="background-color: pink">

                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{url('account_pk_dash')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/p.png" alt="logo-sm" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                                </span>
                            </a>
    
                            <a href="{{url('account_pk_dash')}}" class="logo logo-light">
                                <span class="logo-sm me-2">
                                    <img src="{{ asset('images/pk_smal.png') }}" alt="logo-sm-light" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                    <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">
                                    <img src="{{ asset('images/officer5.png') }}" class="" alt="logo-sm-light" height="30">
                                    {{-- <h4 style="color:rgb(41, 41, 41)" class="mt-4 loadingIcon">PK-OFFICE</h4> --}}
                                    {{-- <div class = "loadingIcon"></div> --}}
                                    {{-- <i class="fa-solid fa-p fa-w-16 fa-spin fa-2x text-info"></i> --}}
                                </span>
                                {{-- <div class="header-btn-lg"> 
                                    <a href="{{url("user/home")}}" id="TooltipDemo" class="btn-open-options btn hamburger hamburger--elastic open-right-drawer text-danger" target="_blank">
                                      
                                        <i class="fa-solid fa-universal-access fa-w-16 fa-spin fa-2x text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผู้ใช้งานทั่วไป"></i>
                                    </a>  
                                </div> --}}
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
                                <h3 style="color:rgb(255, 255, 255)" class="mt-2 noto-sans-thai-looped-light">ACCOUNT</h3> 
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
                                                                            {{-- <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('logout') }}"
                                                                                class="text-reset notification-item"
                                                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                                                    class="ri-shut-down-line align-middle me-2 text-white"></i> Logout
                                                                            </a>
                                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                                @csrf
                                                                            </form> --}}
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
                                                                {{-- <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                                    <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                                    Message Inbox
                                                                </button> --}}
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
                                                                
                                                                {{-- <button class="btn-icon-vertical btn-transition btn-transition-alt pt-3 pb-2 btn btn-outline-danger">
                                                                    <i class="ri-shut-down-line align-middle btn-icon-wrapper mb-2"></i>
                                                                    <b>Logout </b>
                                                                </button> --}}
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
        </header>
        {{-- <style>
            .nom6{ 
                background: linear-gradient(to right,#ffafbd);
              
            }
        </style> --}}

        <!-- ========== Left Sidebar Start ========== -->
        {{-- <div class="vertical-menu "> --}}
        <div class="vertical-menu">
            {{-- <div class="vertical-menu" style="background-color: rgb(128, 216, 209)"> --}}
            {{-- <div data-simplebar class="h-100"> --}}
                <div data-simplebar class="h-100 nom6">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar text-success"></i>
                                <span>New-Eclaim</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('check_auth') }}" target="_blank">Check User Api</a></li> 
                            </ul> 
                        </li> --}}
                        {{-- <li>
                            <a href="{{url('sit_acc_debtorauto')}}" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar text-success"></i>
                                <span>ตรวจสอบสิทธิ์</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('sit_accpull_auto') }}" target="_blank">ดึงข้อมูล Auto</a></li>
                                <li><a href="{{ url('sit_acc_debtorauto') }}" target="_blank">ตรวจสอบสิทธิ์ Auto</a></li>
                            </ul>

                        </li> --}}
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar text-success"></i>
                                <span>ดึงข้อมูล</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('account_pk') }}">ดึงลูกหนี้จาก Hos-opd</a></li>
                                <li><a href="{{ url('account_pk_ipd') }}">ดึงลูกหนี้จาก Hos-ipd</a></li>
                            </ul>
                        </li>  --}}
                        @if ($permiss_ucs != 0)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(250, 124, 187)"></i>
                                    <span>UCS</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">201-ลูกหนี้ค่ารักษา UC-OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_201_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_201_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_201_detaildate') }}">ตั้งลูกหนี้</a> </li>
                                            {{-- <li><a href="{{ url('account_201_stmdate') }}">STM</a> </li> --}}
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">202-ลูกหนี้ค่ารักษา UC-IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkucs202_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkucs202_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_pkucs202_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">203-ลูกหนี้ค่ารักษา UC-OP นอก CUP(ในจังหวัด)</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_203_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_203_pull') }}">ดึงลูกหนี้</a> </li>
                                            {{-- <li><a href="{{ url('account_203_form') }}">เรียกเก็บในจังหวัด</a> </li> --}}
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">209-ลูกหนี้ค่ารักษา OP(P&P)</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkucs209_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkucs209_pull') }}">ดึงลูกหนี้</a></li>
                                          
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">216-ลูกหนี้ค่ารักษา UC-OP บริการเฉพาะ(CR)</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkucs216_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkucs216_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_pkucs216_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">217-ลูกหนี้ค่ารักษา UC-IP บริการเฉพาะ(CR)</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkucs217_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkucs217_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_pkucs217_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>                             
                        @endif
                        
                        @if ($permiss_sss != 0)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(134, 216, 27)"></i>
                                    <span>SSS</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">301-OPเครือข่าย</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_301_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_301_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_301_detail_date') }}">ค้นหาลูกหนี้</a> </li>
                                            {{-- <li><a href="javascript: void(0);" class="has-arrow">3011-OP-อุปกรณ์เบิกเอกสาร</a>
                                                <ul class="sub-menu" aria-expanded="true">  
                                                    <li><a href="{{ url('account_3011_pull') }}">ดึงลูกหนี้</a> </li>
                                                    <li><a href="{{ url('account_3011_detail_date') }}">ค้นหาลูกหนี้</a> </li>
                                                </ul>
                                            </li> --}}
                                            <li><a href="javascript: void(0);" class="has-arrow">3013-OP-CT</a>
                                                <ul class="sub-menu" aria-expanded="true"> 
                                                    {{-- <li><a href="{{ url('account_3013_dash') }}">dashboard</a></li> --}}
                                                    <li><a href="{{ url('account_3013_pull') }}">ดึงลูกหนี้</a> </li>
                                                    <li><a href="{{ url('account_3013_search') }}">ค้นหาลูกหนี้</a> </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    {{-- <li><a href="javascript: void(0);" class="has-arrow">3011-OP-อุปกรณ์เบิกเอกสาร</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_3011_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_3011_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_3011_detail_date') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li><a href="javascript: void(0);" class="has-arrow">3012-อุปกรณ์เบิก New-Eclaim</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_3012_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_3012_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_3012_detail_date') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li> --}}
                                    
                                   
                                    <li><a href="javascript: void(0);" class="has-arrow">302-IPเครือข่าย</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_302_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_302_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_302_detail_date') }}">ค้นหาลูกหนี้</a></li>
                                            <li><a href="javascript: void(0);" class="has-arrow">3012-อุปกรณ์เบิก New-Eclaim</a>
                                                <ul class="sub-menu" aria-expanded="true"> 
                                                    <li><a href="{{ url('account_3012_dash') }}">dashboard</a></li>
                                                    {{-- <li><a href="{{ url('account_3012_pull') }}">ดึงลูกหนี้</a> </li> --}}
                                                    <li><a href="{{ url('account_3012_detail_date') }}">ค้นหาลูกหนี้</a> </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">303-OPนอกเครือข่าย สังกัด สป.สธ.</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_303_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_303_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_303_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">304-IPเครือข่าย</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_304_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_304_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_304_search') }}">ค้นหาลูกหนี้</a> </li>
                                       
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">307-กองทุนทดแทน</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_307_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_307_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_307_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">308-72ชั่วโมงแรก</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_308_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_308_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_308_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">309-ค่าใช้จ่ายสูง/อุบัติเหตุ/ฉุกเฉิน OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_309_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_309_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_309_search') }}">ค้นหาลูกหนี้</a> </li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">310-ค่าใช้จ่ายสูง IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_310_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_310_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_310_detail_date') }}">ค้นหาลูกหนี้</a></li>
                                            
                                        </ul>
                                    </li>
                                </ul>
                            </li>                            
                        @endif

                        @if ($permiss_ofc != 0)                           
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(39, 131, 236)"></i>
                                    <span>OFC</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">401-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_401_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_401_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_401_search') }}">ค้นหาลูกหนี้</a></li>
                                            <li><a href="{{ url('account_401_rep') }}">REP</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">402-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_402_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_402_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_402_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($permiss_lgo != 0) 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(253, 38, 85)"></i>
                                    <span>LGO</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">801-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_801_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_801_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_801_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">802-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_802_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_802_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_802_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">803-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_803_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_803_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_803_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">804-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_804_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_804_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_804_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($permiss_prb != 0) 
                           
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: #e42ad4"></i>
                                    <span>พรบ</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">602-ลูกหนี้ค่ารักษา-พรบ.รถ OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_602_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_602_pull') }}">ดึงลูกหนี้</a></li>
                                           
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">603-ลูกหนี้ค่ารักษา-พรบ.รถ IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_603_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_603_pull') }}">ดึงลูกหนี้</a></li>
                                       
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($permiss_ti != 0)
                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-brands fa-btc text-primary"></i> 
                                    <span>ไต</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('account_pkti4011_dash') }}">OFC-4011</a></li>
                                    <li><a href="{{ url('account_pkti4022_dash') }}">OFC-4022</a></li>
                                    <li><a href="{{ url('account_pkti8011_dash') }}">LGO-8011</a></li>
                                    <li><a href="{{ url('account_pkti2166_dash') }}">UCS-2166</a></li>
                                    <li><a href="{{ url('account_pkti3099_dash') }}">SSS-3099</a></li>
                                </ul>
                            </li> --}}
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(253, 124, 38)"></i>
                                    <span>ไต</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true"> 
                                    <li><a href="javascript: void(0);" class="has-arrow">4011-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง.OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkti4011_dash') }}">dashboard</a> </li>
                                            <li><a href="{{ url('account_pkti4011_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_pkti4011_search') }}">ค้นหาลูกหนี้</a></li>
                                        
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">4022-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง.IP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkti4022_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkti4022_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_pkti4022_search') }}">ค้นหาลูกหนี้</a></li>
                                            
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">8011-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ.OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkti8011_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkti8011_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_pkti8011_search') }}">ค้นหาลูกหนี้</a></li>
                                            
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">2166-ลูกหนี้ค่ารักษา-บริการเฉพาะ(CR)(ฟอกไต) OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkti2166_dash') }}">dashboard</a></li>
                                            <li><a href="{{ url('account_pkti2166_pull') }}">ดึงลูกหนี้</a></li>
                                            <li><a href="{{ url('account_pkti2166_search') }}">ค้นหาลูกหนี้</a></li>
                                           
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">3099-ลูกหนี้ค่ารักษา-ประกันสังคม(ค่าใช้จ่ายสูง)(ฟอกไต) OP</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('account_pkti3099_dash') }}">dashboard</a> </li>
                                            <li><a href="{{ url('account_pkti3099_pull') }}">ดึงลูกหนี้</a> </li>
                                            <li><a href="{{ url('account_pkti3099_search') }}">ค้นหาลูกหนี้</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar" style="color: #55595a"></i>
                                <span>คนต่างด้าว</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true"> 
                                <li><a href="javascript: void(0);" class="has-arrow">501-คนต่างด้าวและแรงงานต่างด้าว OP </a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_501_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_501_pull') }}">ดึงลูกหนี้</a></li>
                                        <li><a href="{{ url('account_501_search') }}">ค้นหาลูกหนี้</a> </li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">502-คนต่างด้าวและแรงงานต่างด้าว OP </a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_502_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_502_pull') }}">ดึงลูกหนี้</a></li>
                                        <li><a href="{{ url('account_502_search') }}">ค้นหาลูกหนี้</a> </li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">503-คนต่างด้าวและแรงงานต่างด้าว OP นอก CUP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_503_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_503_pull') }}">ดึงลูกหนี้</a></li>
                                       
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">504-คนต่างด้าวและแรงงานต่างด้าว IP นอก CUP </a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_504_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_504_pull') }}">ดึงลูกหนี้</a></li>
                                       
                                    </ul>
                                </li>
                                
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar" style="color: #28d9f8"></i>
                                <span>สถานะสิทธิ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true"> 
                                <li><a href="javascript: void(0);" class="has-arrow">701-บุคคลที่มีปัญหาสถานะและสิทธิ OP ใน CUP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_701_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_701_pull') }}">ดึงลูกหนี้</a></li>
                                       
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">702-บุคคลที่มีปัญหาสถานะและสิทธิ OP นอก CUP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_702_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_702_pull') }}">ดึงลูกหนี้</a></li>
                                       
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">704-บุคคลที่มีปัญหาสถานะและสิทธิ เบิกจากส่วนกลาง IP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('account_704_dash') }}">dashboard</a></li>
                                        <li><a href="{{ url('account_704_pull') }}">ดึงลูกหนี้</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                      
 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(150, 72, 240)"></i>
                                <span>รายการลงค้าง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true"> 
                                <li><a href="javascript: void(0);" class="has-arrow">106-ลูกหนี้ค่ารักษา-ขำระเงิน OP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('acc_106_dashboard') }}">dashboard</a> </li>
                                        <li><a href="{{ url('acc_106_pull') }}">ดึงลูกหนี้</a> </li>
                                        <li><a href="{{ url('acc_106_file') }}">แนบไฟล์</a> </li>
                                        <li><a href="{{ url('acc_106_debt') }}">ทวงหนี้</a> </li>
                                    </ul>
                                </li>
                                 <li><a href="javascript: void(0);" class="has-arrow">107-ลูกหนี้ค่ารักษา-ขำระเงิน IP</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('acc_107_dashboard') }}">dashboard</a> </li>
                                        <li><a href="{{ url('acc_107_pull') }}">ดึงลูกหนี้</a> </li>
                                        <li><a href="{{ url('acc_107_file') }}">แนบไฟล์</a> </li>
                                        <li><a href="{{ url('acc_107_debt') }}">ทวงหนี้</a> </li>
                                    </ul>
                                </li> 
                            </ul>
                        </li>

                        @if ($permiss_setting_upstm != 0)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                    <i class="fa-solid fa-cloud-arrow-up text-warning"></i>
                                    <span>UP STM</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('tree_document') }}">Document</a></li>
                                    <li><a href="javascript: void(0);" class="has-arrow">REPORT STM ALL</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            {{-- <li><a href="{{ url('upstm_all') }}">STM ALL</a></li> --}}
                                            {{-- <li><a href="{{ url('upstm_ucs_opd') }}">UCS OPD 201</a></li> --}}
                                            <li><a href="{{ url('upstm_ucs_ipd') }}">UCS IPD 202</a></li>
                                            <li><a href="{{ url('upstm_ucs_opd216') }}">UCS OPD 216</a></li>
                                            <li><a href="{{ url('upstm_ucs_ipd217') }}">UCS IPD 217</a></li>
                                            <li><a href="{{ url('upstm_ucs_ti') }}">UCS ไต 2166</a></li>
                                            <li><a href="{{ url('upstm_sss_ti') }}">SSS ไต 3099</a></li>
                                            <li><a href="{{ url('upstm_ofc_ti') }}">OFC ไต 4011</a></li>
                                            <li><a href="{{ url('upstm_ofc_ti_ipd') }}">OFC ไต 4022</a></li>
                                            <li><a href="{{ url('upstm_lgo_ti') }}">LGO ไต 8011</a></li>
                                            <li><a href="{{ url('upstm_ofc_opd') }}">OFC OPD 401</a></li>
                                            <li><a href="{{ url('upstm_ofc_ipd') }}">OFC IPD 402</a></li>
                                            <li><a href="{{ url('upstm_lgo_opd') }}">LGO OPD 801</a></li>
                                            <li><a href="{{ url('upstm_lgo_ipd') }}">LGO IPD 802</a></li>
                                            <li><a href="{{ url('upstm_bkk_opd') }}">BKK OPD 803</a></li>
                                            <li><a href="{{ url('upstm_bkk_ipd') }}">BKK IPD 804</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ url('stm_oneid_opd') }}">UCS(ONEID-OPD)</a></li>
                                    <li><a href="{{ url('upstm_ucsopd') }}">UCS(Excel-OPD)</a></li>
                                    <li><a href="{{ url('upstm_ucs') }}">UCS(Excel-IPD)OK</a></li>
                                    <li><a href="{{ url('upstm_ofcexcel') }}">OFC(Excel)OK</a></li> 
                                    <li><a href="{{ url('upstm_bkkexcel') }}">BKK(Excel)OK</a></li> 
                                    <li><a href="{{ url('upstm_lgoexcel') }}">LGO(Excel)OK</a></li>  
                                    <li><a href="{{ url('upstm_ti') }}">UCS(Excel-ไต)OK</a></li>
                                    <li><a href="{{ url('upstm_tixml') }}">OFC(Xml-ไต)OK</a></li>
                                    <li><a href="{{ url('upstm_lgotiexcel') }}">LGO(Excel-ไต)OK</a></li>
                                    <li><a href="{{ url('upstm_tixml_sss') }}">SSS(Xml-ไต)OK</a></li>
                                    <li><a href="{{ url('upstm_sss_xml') }}">SSS(Xml)</a></li>
                                </ul>
                            </li>
                        @endif
                        

                        @if ($permiss_rep_money != 0)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(250, 124, 187)"></i>
                                    <span>ใบเสร็จรับเงิน</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('uprep_money') }}">ลงใบเสร็จรับเงิน</a></li>
                                    
                                    <li><a href="javascript: void(0);" class="has-arrow">ลงใบเสร็จรับเงินรายตัว</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('uprep_sss_all') }}">ประกันสังคม</a></li>
                                            <li><a href="{{ url('uprep_money_plbop_all') }}">พรบ.-OPIP</a></li>
                                            {{-- <li><a href="javascript: void(0);" class="has-arrow">พรบ.</a> --}}
                                                    {{-- <ul class="sub-menu" aria-expanded="true"> --}}
                                                        {{-- <li><a href="{{ url('uprep_money_plbop_all') }}">พรบ.-OPIP</a></li>  --}}
                                                        {{-- <li><a href="{{ url('uprep_money_plbop') }}">พรบ.-OP</a></li>  --}}
                                                        {{-- <li><a href="{{ url('uprep_money_plbip') }}">พรบ.-IP</a></li>  --}}
                                                    {{-- </ul> --}}
                                                    
                                            {{-- </li> --}}
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-chart-line text-info"></i>
                                    <span>STM report</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('acc_stm_ct') }}">เทียบ stm มะเร็ง</a></li>
                                    <li><a href="{{ url('acc_stm') }}">เทียบ stm</a></li>
                                    <li><a href="{{ url('acc_repstm') }}">report stm ไต</a></li>
                                </ul>
                            </li> --}}
                        @endif

                        
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(28, 218, 161)"></i>
                                    <span>ทะเบียนเปลี่ยนสิทธิ</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('chang_pttype_OPD') }}">เปลี่ยนสิทธิ-ปรับผัง</a></li>
                                    {{-- <li><a href="{{ url('chang_pttype_IPD') }}">เปลี่ยนสิทธิ์ IP</a></li> --}}
                                    {{-- <li><a href="javascript: void(0);" class="has-arrow">ลงใบเสร็จรับเงินรายตัว</a>
                                        <ul class="sub-menu" aria-expanded="true"> 
                                            <li><a href="{{ url('uprep_sss_all') }}">ประกันสังคม</a></li>
                                            <li><a href="javascript: void(0);" class="has-arrow">พรบ.</a>
                                                    <ul class="sub-menu" aria-expanded="true">
                                                        <li><a href="{{ url('uprep_money_plbop') }}">พรบ.-OP</a></li> 
                                                        <li><a href="{{ url('uprep_money_plbip') }}">พรบ.-IP</a></li> 
                                                    </ul>
                                            
                                            </li>
                                        </ul>
                                    </li> --}}
                                </ul>
                            </li>
                            
                       
                        {{-- @if ($permiss_ucs != 0) --}}
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa-solid fa-sliders text-danger"></i>
                                    <span>ตั้งค่า</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ url('aset_trimart') }}">ไตรมาส</a></li>
                                    <li><a href="{{ url('acc_settingpang') }}">Map ผังบัญชี</a></li>
                                    <li><a href="{{ url('acc_setting') }}">Mapping Pttype</a></li>
                                </ul>
                            </li>
                        {{-- @endif --}}
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-line text-danger"></i>
                                <span>รายงาน</span>
                            </a>
                        </li>  --}}
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-gears text-danger"></i>
                                <span>ตั้งค่า</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('p4p_work_position') }}">ตำแหน่งสายงาน</a></li>
                                <li><a href="{{ url('p4p_workgroupset') }}">หมวดภาระงาน</a></li>
                            </ul>
                        </li> --}}



                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
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

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            {{-- background:url(/pkbackoffice/public/sky16/images/logo250.png)no-repeat 50%; --}}
            {{-- <div class="page-content Backgroupbody"> --}}
            <div class="page-content Backgroupbody">
                {{-- <div class="page-content"> --}}
                {{-- <div class="page-content" style="background-color: rgba(247, 244, 244, 0.911)"> --}}
                @yield('content')

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



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('pkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
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

    <!-- jquery.vectormap map -->
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons examples -->
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

    <!-- Responsive examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>


    <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('acccph/vendors/@chenfengyuan/datepicker/dist/datepicker.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('acccph/vendors/daterangepicker/daterangepicker.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>

    
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/form-components/toggle-switch.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/form-components/datepicker.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/circle-progress.js') }}"></script> --}}
    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
    {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}

    <script type="text/javascript" src="{{ asset('acccph/js/charts/apex-charts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/circle-progress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/toastr.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/treeview.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('acccph/js/form-components/toggle-switch.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/tables.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/carousel-slider.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('disacc/js/charts/chartjs.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('acccph/js/app.js') }}"></script> --}} 
    {{-- <script src="{{ asset('js/ladda.js') }}"></script>  --}}
    @yield('footer')


    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            var table = $('#example219').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
            });
            var table = $('#example20').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
            });

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
