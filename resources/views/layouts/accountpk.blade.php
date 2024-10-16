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
    <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
 
      
       <!-- DataTables --> 
       <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
 
       <!-- Responsive datatable examples -->
       <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
       <!-- Bootstrap Css -->
       {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
       <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
       <!-- Icons Css -->
       <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
      
       <link rel="stylesheet" href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
       <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
       <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
       <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
       <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

         <!-- App Css-->
       <link href="{{ asset('assets_ubi/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
       {{-- <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet"> --}}
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
        background-color: rgb(255, 255, 255);
        background-repeat: no-repeat;
        background-attachment: fixed; 
        background-size: 100% 100%; 
        font-size: 13px;
    }
    /* Logo หมุน Start */
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
        width: 250px;
        height: 250px;
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
    /* Logo หมุน END */

            
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
 
<body data-topbar="colored" data-layout="horizontal">
    {{-- <body data-topbar="dark" data-layout="horizontal"> --}}
    <div id="layout-wrapper">
        
        <header id="page-topbar" style="background-color: pink">
      
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" >
                      
                        <a href="{{url('account_monitor_main')}}" class="logo logo-dark"> 
                            <span class="logo-sm me-2"> 
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> 
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> 
                            </span>
                        </a>
 
                        <a href="{{url('account_monitor_main')}}" class="logo logo-light">
                            <span class="logo-sm me-2"> 
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">
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

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>

                   
                </div>

                <div class="d-flex">
                    

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                  
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                            @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle header-profile-user" alt="Header Avatar">
                            @else
                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle header-profile-user" alt="Header Avatar">
                            @endif 
                            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                             
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ url('admin_profile_edit/' . Auth::user()->id) }}"><i class="ri-user-line align-middle me-2"></i> Profile</a> 
 
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Keypassword"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ri-shut-down-line align-middle me-2 text-danger"></i> Logout</a>
                        </div>
                    </div>

                   
        
                </div>
            </div>
        </header>
        {{-- <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
 
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('air_dashboard') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-chart-pie me-2"></i>Dashboard  
                                </a> 
                            </li>

                            <li class="nav-item dropdown"> 

                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('air_main') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-fan me-2"></i>ทะเบียนเครื่องปรับอากาศ  <span class="badge bg-danger me-2 ms-2">1</span>
                                </a>
                              
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('air_main_repaire') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-fan me-2"></i>ทะเบียนแจ้งซ่อม  <span class="badge bg-danger me-2 ms-2">2</span>
                                </a>
                            </li>

                           
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('air_plan_year') }}" id="topnav-more" role="button">
                                    <i class="fa-solid fa-diagram-project me-2"></i>แผนการบำรุงรักษา  
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fa-solid fa-chart-line me-2"></i><span key="t-layouts">รายงาน</span> <div class="arrow-down"></div> 
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_type')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานแยกตามประเภท</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_building')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานแยกตามอาคาร</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_problems')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานแยกตามปัญหา</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_month')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานประจำเดือน</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_company')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานบริษัท</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_report_department')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานแยกตามหน่วยงาน</span>  
                                        </a> 
                                    </div>
                                </div>
                                
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fas fa-tools me-2"></i><span key="t-layouts">Setting</span> <div class="arrow-down"></div>                              
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting_yearnow')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ตั้งค่าปีงบประมาณ</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting_year')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ตั้งค่าทะเบียนเครื่องปรับอากาศ(ปีงบประมาณ)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting_month')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">ยกยอด(รายเดือน)</span>  
                                        </a> 
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Import แผนการบำรุงรักษารายปี</span>  
                                        </a> 
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('air_setting_type')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">กำหนดประเภท/ปีงบประมาณ</span>  
                                        </a> 
                                    </div>
                                 
                                </div>
                            </li>
 

                        </ul>
                    </div>
                    
                </nav>
            </div>
        </div> --}}

        {{-- <header id="page-topbar" style="background-color: pink">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="logo-light" height="20">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>

                    <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
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
                    </div>
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

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
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
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
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
                    </div>


                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">Julia</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="ri-settings-2-line"></i>
                        </button>
                    </div>
        
                </div>
            </div>
        </header> --}}
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('account_pk_dash') }}">
                                    <i class="ri-dashboard-line me-2"></i> Dashboard
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(110, 21, 252)"></i>Monitor<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">     --}}

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-dashboard-line me-2" style="font-size: 20px;color:pink"></i>Monitor <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('account_pk_dash') }}" class="dropdown-item">dashboard</a> 
                                    <a href="{{ url('account_monitor') }}" class="dropdown-item">Monitor</a> 
                                </div>
                                
                            </li>

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                                >
                                    <i class="ri-pencil-ruler-2-line me-2"></i>UCS <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                    aria-labelledby="topnav-uielement">
                                    <div class="row">
                                        <div class="col-lg-6">
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
                                        <div class="col-lg-6">
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
                                         
                                    </div>

                                </div>
                            </li> --}}
                               
                            @if ($permiss_ucs != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                {{-- <i class="ri-apps-2-line"></i> --}}
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(245, 96, 121)"></i>UCS <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    {{-- <a href="calendar.html" class="dropdown-item">Calendar</a> --}}
                                    
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            201-ลูกหนี้ค่ารักษา UC-OP <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_201_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_201_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_201_detaildate') }}" class="dropdown-item">ตั้งลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            202-ลูกหนี้ค่ารักษา UC-IP <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_pkucs202_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkucs202_pull') }}" class="dropdown-item">ดึงลูกหนี้</a> 
                                            <a href="{{ url('account_pkucs202_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            203-ลูกหนี้ค่ารักษา UC-OP นอก CUP(ในจังหวัด)<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_203_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_203_pull') }}" class="dropdown-item">ดึงลูกหนี้</a> 
                                            <a href="{{ url('account_203_form') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            209-ลูกหนี้ค่ารักษา OP(P&P) <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_pkucs209_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkucs209_pull') }}" class="dropdown-item">ดึงลูกหนี้</a> 
                                            
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            216-ลูกหนี้ค่ารักษา UC-OP บริการเฉพาะ(CR)<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_pkucs216_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkucs216_pull') }}" class="dropdown-item">ดึงลูกหนี้</a> 
                                            <a href="{{ url('account_pkucs216_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            217-ลูกหนี้ค่ารักษา UC-IP บริการเฉพาะ(CR)<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_pkucs217_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkucs217_pull') }}" class="dropdown-item">ดึงลูกหนี้</a> 
                                            <a href="{{ url('account_pkucs217_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif

                            @if ($permiss_sss != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:pink"></i>SSS <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            301-OPเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_301_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_301_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_301_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            302-IPเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_302_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_302_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_302_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    {{-- <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            3012-อุปกรณ์เบิก New-Eclaim<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_3012_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_3012_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_3012_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div> --}}
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            3013-OP-CT<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">                                            
                                            <a href="{{ url('account_3013_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_3013_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            303-OPนอกเครือข่าย สังกัด สป.สธ.<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_303_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_303_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_303_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            304-IPเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_304_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_304_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_304_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            307-กองทุนทดแทน<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_307_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_307_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_307_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            308-72ชั่วโมงแรก<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_308_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_308_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_308_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            309-ค่าใช้จ่ายสูง/อุบัติเหตุ/ฉุกเฉิน OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_309_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_309_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_309_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            310-ค่าใช้จ่ายสูง IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">      
                                            <a href="{{ url('account_310_dash') }}" class="dropdown-item">dashboard</a>                                      
                                            <a href="{{ url('account_310_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_310_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                            @endif

                            @if ($permiss_ofc != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(235, 94, 248)"></i>OFC <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            401-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_401_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_401_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_401_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                            <a href="{{ url('account_401_rep') }}" class="dropdown-item">Rep</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            402-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_402_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_402_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_402_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                            {{-- <a href="{{ url('account_401_rep') }}" class="dropdown-item">Rep</a> --}}
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                            @endif

                            @if ($permiss_lgo != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(6, 192, 176)"></i>LGO<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            801-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_801_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_801_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_801_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            802-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_802_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_802_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_802_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            803-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_803_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_803_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_803_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            804-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_804_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_804_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_804_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                            @endif

                            @if ($permiss_prb != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(252, 55, 88)"></i>พรบ<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            602-ลูกหนี้ค่ารักษา-พรบ.รถ OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_602_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_602_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_801_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            603-ลูกหนี้ค่ารักษา-พรบ.รถ IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_603_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_603_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_802_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </li>
                            @endif

                            @if ($permiss_ti != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(135, 214, 7)"></i>ไต<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            4011-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง.OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_pkti4011_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkti4011_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_pkti4011_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            4022-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง.IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_pkti4022_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkti4022_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_pkti4022_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            8011-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงอปท.รูปแบบพิเศษ.OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_pkti8011_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkti8011_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_pkti8011_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            2166-ลูกหนี้ค่ารักษา-บริการเฉพาะ(CR)(ฟอกไต) OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_pkti2166_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkti2166_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_pkti2166_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            3099-ลูกหนี้ค่ารักษา-ประกันสังคม(ค่าใช้จ่ายสูง)(ฟอกไต) OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_pkti3099_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_pkti3099_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_pkti3099_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>                                    
                                </div>
                                
                            </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(248, 113, 22)"></i>คนต่างด้าว<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            501-คนต่างด้าวและแรงงานต่างด้าว OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_501_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_501_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_501_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            502-คนต่างด้าวและแรงงานต่างด้าว OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_502_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_502_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_502_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            503-คนต่างด้าวและแรงงานต่างด้าว OP นอก CUP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_503_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_503_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_pkti8011_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            504-คนต่างด้าวและแรงงานต่างด้าว IP นอก CUP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_504_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_504_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_pkti2166_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>                            
                                </div>
                                
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(248, 214, 22)"></i>สถานะสิทธิ<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            701-บุคคลที่มีปัญหาสถานะและสิทธิ OP ใน CUP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_701_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_701_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_501_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            702-บุคคลที่มีปัญหาสถานะและสิทธิ OP นอก CUP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_702_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_702_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_502_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            704-บุคคลที่มีปัญหาสถานะและสิทธิ เบิกจากส่วนกลาง IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_704_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_704_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            {{-- <a href="{{ url('account_pkti8011_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>  --}}
                                        </div>
                                    </div>
                                                             
                                </div>
                                
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(143, 3, 3)"></i>อื่น ๆ<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            106-ลูกหนี้ค่ารักษา-ขำระเงิน OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('acc_106_dashboard') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('acc_106_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('acc_106_file') }}" class="dropdown-item">แนบไฟล์</a> 
                                            <a href="{{ url('acc_106_debt') }}" class="dropdown-item">ทวงหนี้</a> 
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            107-ลูกหนี้ค่ารักษา-ขำระเงิน IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('acc_107_dashboard') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('acc_107_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('acc_107_file') }}" class="dropdown-item">แนบไฟล์</a> 
                                            <a href="{{ url('acc_107_debt') }}" class="dropdown-item">ทวงหนี้</a> 
                                        </div>
                                    </div> 

                                    @if ($permiss_rep_money != 0)
                                    <a href="{{ url('chang_pttype_OPD') }}" class="dropdown-item">เปลี่ยนสิทธิ-ปรับผัง</a>
                                    <a href="{{ url('uprep_money') }}" class="dropdown-item">ลงใบเสร็จรับเงิน</a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            ลงใบเสร็จรับเงินรายตัว<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('uprep_sss_all') }}" class="dropdown-item">ประกันสังคม</a>
                                            <a href="{{ url('uprep_money_plbop_all') }}" class="dropdown-item">พรบ.-OPIP</a> 
                                        </div>
                                    </div> 
                                    @endif

                                </div>                                
                            </li>

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(2, 107, 177)"></i>ทะเบียนเปลี่ยนสิทธิ<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('chang_pttype_OPD') }}" class="dropdown-item">เปลี่ยนสิทธิ-ปรับผัง</a>
                                   
                                </div>                                
                            </li> --}}

                            {{-- @if ($permiss_rep_money != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(7, 189, 235)"></i>ใบเสร็จรับเงิน<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('chang_pttype_OPD') }}" class="dropdown-item">เปลี่ยนสิทธิ-ปรับผัง</a>
                                    <a href="{{ url('uprep_money') }}" class="dropdown-item">ลงใบเสร็จรับเงิน</a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            ลงใบเสร็จรับเงินรายตัว<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('uprep_sss_all') }}" class="dropdown-item">ประกันสังคม</a>
                                            <a href="{{ url('uprep_money_plbop_all') }}" class="dropdown-item">พรบ.-OPIP</a> 
                                        </div>
                                    </div>                  
                                </div>                                
                            </li>
                            @endif --}}

                            @if ($permiss_setting_upstm != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(110, 21, 252)"></i>UP STM<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps"> 
                                    <a href="{{ url('tree_document') }}" class="dropdown-item">Document</a> 
                                    <a href="{{ url('stm_oneid_opd') }}" class="dropdown-item">UCS(ONEID-OPD)</a> 
                                    <a href="{{ url('upstm_ucsopd') }}" class="dropdown-item">UCS(Excel-OPD)</a> 
                                    <a href="{{ url('upstm_ucs') }}" class="dropdown-item">UCS(Excel-IPD)OK</a> 
                                    <a href="{{ url('upstm_ofcexcel') }}" class="dropdown-item">OFC(Excel)OK</a> 
                                    <a href="{{ url('upstm_bkkexcel') }}" class="dropdown-item">BKK(Excel)OK</a> 
                                    <a href="{{ url('upstm_lgoexcel') }}" class="dropdown-item">LGO(Excel)OK</a> 
                                    <a href="{{ url('upstm_ti') }}" class="dropdown-item">UCS(Excel-ไต)OK</a> 
                                    <a href="{{ url('upstm_tixml') }}" class="dropdown-item">OFC(Xml-ไต)OK</a>
                                    <a href="{{ url('upstm_lgotiexcel') }}" class="dropdown-item">LGO(Excel-ไต)OK</a>
                                    <a href="{{ url('upstm_tixml_sss') }}" class="dropdown-item">SSS(Xml-ไต)OK</a>
                                    {{-- <a href="{{ url('upstm_sss_xml') }}" class="dropdown-item">SSS(Xml)</a>  --}}
                                    <a href="{{ url('upstm_sss_excel') }}" class="dropdown-item">SSS(Excel)</a> 
                                    {{-- <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            REPORT STM ALL<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('upstm_ucs_ipd') }}" class="dropdown-item">UCS IPD 202</a>
                                            <a href="{{ url('upstm_ucs_opd216') }}" class="dropdown-item">UCS OPD 216</a>
                                            <a href="{{ url('upstm_ucs_ipd217') }}" class="dropdown-item">UCS IPD 217</a> 
                                            <a href="{{ url('upstm_ucs_ti') }}" class="dropdown-item">UCS ไต 2166</a> 
                                            <a href="{{ url('upstm_sss_ti') }}" class="dropdown-item">SSS ไต 3099</a> 
                                            <a href="{{ url('upstm_ofc_ti') }}" class="dropdown-item">OFC ไต 4011</a> 
                                            <a href="{{ url('upstm_lgo_ti') }}" class="dropdown-item">LGO ไต 8011</a> 
                                            <a href="{{ url('upstm_ofc_opd') }}" class="dropdown-item">OFC OPD 401</a> 
                                            <a href="{{ url('upstm_ofc_ipd') }}" class="dropdown-item">OFC IPD 402</a> 
                                            <a href="{{ url('upstm_lgo_opd') }}" class="dropdown-item">LGO OPD 801</a> 
                                            <a href="{{ url('upstm_lgo_ipd') }}" class="dropdown-item">LGO IPD 802</a> 
                                            <a href="{{ url('upstm_bkk_opd') }}" class="dropdown-item">BKK OPD 803</a> 
                                            <a href="{{ url('upstm_bkk_ipd') }}" class="dropdown-item">BKK IPD 804</a>  
                                        </div>
                                    </div> --}}

                                </div>

                                
                            </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(110, 21, 252)"></i>REPORT<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">           
                                            <a href="{{ url('upstm_ucs_ipd') }}" class="dropdown-item">UCS IPD 202</a>
                                            <a href="{{ url('upstm_ucs_opd216') }}" class="dropdown-item">UCS OPD 216</a>
                                            <a href="{{ url('upstm_ucs_ipd217') }}" class="dropdown-item">UCS IPD 217</a> 
                                            <a href="{{ url('upstm_ucs_ti') }}" class="dropdown-item">UCS ไต 2166</a> 
                                            <a href="{{ url('upstm_sss_ti') }}" class="dropdown-item">SSS ไต 3099</a> 
                                            <a href="{{ url('upstm_ofc_ti') }}" class="dropdown-item">OFC ไต 4011</a> 
                                            <a href="{{ url('upstm_lgo_ti') }}" class="dropdown-item">LGO ไต 8011</a> 
                                            <a href="{{ url('upstm_ofc_opd') }}" class="dropdown-item">OFC OPD 401</a> 
                                            <a href="{{ url('upstm_ofc_ipd') }}" class="dropdown-item">OFC IPD 402</a> 
                                            <a href="{{ url('upstm_lgo_opd') }}" class="dropdown-item">LGO OPD 801</a> 
                                            <a href="{{ url('upstm_lgo_ipd') }}" class="dropdown-item">LGO IPD 802</a> 
                                            <a href="{{ url('upstm_bkk_opd') }}" class="dropdown-item">BKK OPD 803</a> 
                                            <a href="{{ url('upstm_bkk_ipd') }}" class="dropdown-item">BKK IPD 804</a>  
                                </div> 
                            </li>
                            {{-- <li class="nav-item dropdown">
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
 
        <div class="main-content">
            <div class="page-content">               
                    @yield('content') 
            </div>

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

    </div>
    <!-- END layout-wrapper -->

 
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets_ubi/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>       
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
    <!-- jquery.vectormap map -->
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>
    <!-- Required datatable js -->
    {{-- <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="{{ asset('assets_ubi/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>    
    <!-- Responsive examples -->
    <script src="{{ asset('assets_ubi/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    {{-- <script src="assets/js/pages/datatables.init.js"></script> --}}
    {{-- <script src="assets/js/app.js"></script> --}}
      <!-- Datatable init js -->
      <script src="{{ asset('assets_ubi/js/pages/datatables.init.js') }}"></script>
      <script src="{{ asset('assets_ubi/js/app.js') }}"></script> 
      {{-- <script src="{{ asset('pkclaim/js/app.js') }}"></script>  --}}

    {{-- <!-- JAVASCRIPT -->
    <script src="{{ asset('assets_ubi/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/node-waves/waves.min.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('assets_ubi/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>    
    <!-- Responsive examples -->
    <script src="{{ asset('assets_ubi/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets_ubi/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('assets_ubi/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('assets_ubi/js/app.js') }}"></script> --}}

                {{-- <!-- JAVASCRIPT --> 
                <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>
                <script src="{{ asset('js/select2.min.js') }}"></script>       
                <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
                <!-- jquery.vectormap map -->
                <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>
        
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
                <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
                <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>      
                <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>            
                <!-- App js -->
                <script src="{{ asset('pkclaim/js/app.js') }}"></script> --}}
 
 

    @yield('footer')


    <script type="text/javascript">
        $(document).ready(function() {
            // $('#example').DataTable();
            // $('#example2').DataTable();
            // $('#example3').DataTable();
            // var table = $('#example24').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 10,
            //     "lengthMenu": [10,25,50,100,150,200,300,400,500],
            // });
            // var table = $('#example25').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 10,
            //     "lengthMenu": [10,25,50,100,150,200,300,400,500],
            // });

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
