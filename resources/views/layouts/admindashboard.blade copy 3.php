<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />



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
    <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet"
   href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
<!-- Plugins css -->
<link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/loginheader.css') }}" rel="stylesheet" />
<link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet">
</head>
 <style>
    body{
        background:
            /* url(/pkbackoffice/public/images/bg2.jpg); */
            /* -webkit-background-size: cover; */
        background-repeat: no-repeat;
		background-attachment: fixed;
		/* background-size: cover; */
        background-size: 100% 100%;
        }
 </style>


<style>

    *{
        margin: 0;
        padding: 0;
    }
    .headerZ{
        z-index: 1;
        background:linear-gradient(-45deg,red,rgb(201, 241, 154),rgb(184, 230, 226),rgb(238, 238, 107));
        background-size: 400% 400%;
        width: 100%;
        height: 100vh;
        animation: animate 5s ease infinite;
    }
    @keyframes animate{
        0%{
            background-position: 0 50%;
        }
        50%{
            background-position: 100% 50%;
        }
        0%{
            background-position: 0 50%;
        }
    }


</style>

 <body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

         <header id="page-topbar">
            <div class="navbar-header" style="background-color: rgb(247, 244, 244)" >


                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{url('admin/home')}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/p.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="{{url('admin/home')}}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('images/p.png') }}" alt="logo-sm-light" height="40">
                            </span>
                            <span class="logo-lg">
                                <h4 style="color:rgb(41, 41, 41)" class="mt-4">PK-OFFICE</h4>
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
                            <h4 style="color:rgb(48, 46, 46)" class="mt-2">{{$item->orginfo_name}}</h4>
                            @endforeach

                        </div>
                    </form>
                </div>



                <div class="d-flex">
                    
                    {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                        <a href="{{url("admin/home")}}">
                            <i class="fa-solid fa-gauge-high text-success ms-4" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Dashboard"></i>
                          </a>
                          <a href="{{url("backups")}}">
                            <i class="fas fa-database text-secondary ms-4" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Backup Database"></i>
                          </a>
                        <a href="{{url("setting/setting_index")}}" target="_blank">
                            <i class="fa-solid fa-gear text-danger ms-4" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ตั้งค่า"></i>
                          </a>
                          <a href="{{url("user/home")}}" target="_blank">
                            <i class="fa-solid fa-user-group text-info ms-4 me-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผู้ใช้งานทั่วไป"></i>
                          </a>

                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(9, 75, 129)"></i>
                        </button>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="modal" data-bs-target="#Keypassword">
                                <i class="fa-solid fa-key" style="color: rgb(207, 34, 115)"></i>
                            </button>
                        </div> 
                    </div> --}}

                    {{-- <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->img == null)
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px"
                                        width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                                        width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                @endif
                                <span class="d-none d-xl-inline-block ms-1 " style="color: rgb(9, 75, 129)">
                                    {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"
                                    style="color: rgb(9, 75, 129)"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"> 
                                <a class="dropdown-item " style="color: rgb(9, 75, 129)"
                                    href="{{ url('admin_profile_edit/' . Auth::user()->id) }}"><i
                                        class="ri-user-line align-middle me-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    class="text-reset notification-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    --}}
                        {{-- <div class="dropdown d-inline-block user-dropdown">
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
                        </div> --}}
                        <div class="header-btn-lg"> 
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line" style="color: rgb(9, 75, 129);font-size:30px;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Fullscreen"></i>
                            </button>
                        </div>
                        <div class="header-btn-lg"> 
                            <a href="{{url("user/home")}}" id="TooltipDemo" class="btn-open-options btn hamburger hamburger--elastic open-right-drawer text-danger" target="_blank">
                                {{-- <i class="fa-solid fa-user-group fa-w-16 fa-spin fa-2x"></i> --}}
                                {{-- <i class="fa-solid fa-user-check fa-w-16 fa-spin fa-2x text-danger"></i> --}}
                                <i class="fa-solid fa-universal-access fa-w-16 fa-spin fa-2x text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผู้ใช้งานทั่วไป"></i>
                            </a>  
                        </div>
                        {{-- <a href="{{url("user/home")}}" target="_blank">
                            <i class="fa-solid fa-user-group text-info ms-4 me-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผู้ใช้งานทั่วไป"></i>
                          </a> --}}
                        <div class="header-btn-lg"> 
                            <a href="{{url("setting/setting_index")}}" id="TooltipDemo" class="btn-open-options btn hamburger hamburger--elastic open-right-drawer text-danger" target="_blank">
                                <i class="fa fa-cog fa-w-16 fa-spin fa-2x" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Setting"></i>
                            </a>  
                        </div>
                        <div class="header-btn-lg">
                            <div class="dropdown">
                                <button type="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                                    <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                        <span class="icon-wrapper-bg bg-danger"></span>
                                        {{-- <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i> --}}
                                        <i class="fa-regular fa-bell text-danger"></i>
                                        {{-- <span class="badge badge-dot badge-dot-sm bg-danger">Notifications</span> --}}
                                    </span>  
                                </button>
                            </div> 
                        </div>
                        {{-- <button type="button" class="btn btn-primary position-relative">
                            Profile
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                              <span class="visually-hidden">New alerts</span>
                            </span>
                          </button> --}}
                        <div class="header-btn-lg pe-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group"> 
                                            <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn"> 
                                                @if (Auth::user()->img == null)
                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle" alt="">
                                                @else
                                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle" alt="">
                                                @endif 
                                                <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner bg-primary">
                                                        {{-- <div class="menu-header-image opacity-2" style="background-image: url('images/dropdown-header/city3.jpg');"></div> --}}
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
                                                                        <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('logout') }}"
                                                                            class="text-reset notification-item"
                                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                                                class="ri-shut-down-line align-middle me-2 text-white"></i> Logout
                                                                        </a>
                                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                            @csrf
                                                                        </form>
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
                                                                    <div class="ms-auto badge rounded-pill bg-info">8</div>
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
                                                            <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                                <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                                Message Inbox
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                                <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                                <b>Support Tickets</b>
                                                            </button>
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

                        {{-- <div class="dropdown">
                            <button type="button" aria-haspopup="true" data-bs-toggle="dropdown" data-bs-placement="bottom"
                                title="Tooltip on bottom" aria-expanded="false" class="p-0 btn btn-link dd-chart-btn">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-success"></span>
                                    <i class="icon text-success ion-ios-analytics"></i>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-premium-dark">
                                        <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract4.jpg');"></div>
                                        <div class="menu-header-content text-white">
                                            <h5 class="menu-header-title">Users Online</h5>
                                            <h6 class="menu-header-subtitle">Recent Account Activity Overview</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-chart">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-9 bg-focus"></div>
                                            <i class="lnr-users text-white"></i>
                                        </div>
                                        <div class="widget-numbers">
                                            <span>344k</span>
                                        </div>
                                        <div class="widget-subheading pt-2">
                                            Profile views since last login
                                        </div>
                                        <div class="widget-description text-danger">
                                            <span class="pe-1">
                                                <span>176%</span>
                                            </span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                    </div>
                                    <div class="widget-chart-wrapper">
                                        <div id="dashboard-sparkline-carousel-3-pop"></div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="nav-item-divider mt-0 nav-item"></li>
                                    <li class="nav-item-btn text-center nav-item">
                                        <button class="btn-shine btn-wide btn-pill btn btn-warning btn-sm">
                                            <i class="fa fa-cog fa-spin me-2"></i>
                                            View Details
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}

                </div>
            </div>
        </header>

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

         <div class="mt-5">
            {{-- <div class="mt-5 headerZ"> --}}
            @yield('content')
         </div>



        {{-- <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Created with <i class="mdi mdi-heart text-danger"></i> by ประดิษฐ์ ระหา - งานประกันสุขภาพ
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}


    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script> --}}
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

    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
 
    @yield('footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example_user').DataTable();
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
