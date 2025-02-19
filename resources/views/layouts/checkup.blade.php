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

        {{-- <!-- DataTables -->
        <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
            <!-- DataTables -->
        <!-- Responsive datatable examples -->
        <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Css -->
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
        <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}">  --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
            /* font-family: "Noto Sans Thai", serif; */
            /* font-family: "Sarabun", serif;
            font-weight: 500;
            font-style: normal;
            font-size: 13px;

            /* font-family: "Noto Sans Thai", serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-variation-settings:"wdth" 100; */
            font-size: 13px;
            /* line-height: 0.8; */
            /* font-optical-sizing: auto; */
            /* font-weight: <weight>; */
            /* font-style: normal; */
            /* font-variation-settings:
                "width" 100; */
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
        .menufont{
            font-size: 13px;
            font-weight: 400;
            font-style: normal;
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

        .cardacc{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 20px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .input_new{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 20px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .inputmedsalt{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 20px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .card_pink{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 30px pink;
            border:solid 1px #fd134e;
        }
        .card_audit_2b{
            border-radius: 0em 0em 2em 2em;
            box-shadow: 0 0 30px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .card_audit_4c{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 30px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .card_audit_4{
            border-radius: 2em 2em 2em 2em;
            box-shadow: 0 0 30px rgb(250, 128, 124);
            border:solid 1px #fd134e;
        }
        .dcheckbox_{
            width: 20px;
            height: 20px;
            /* border-radius: 2em 2em 2em 2em; */
            border: 10px solid rgb(250, 128, 124);
            /* color: teal; */
            /* border-color: teal; */
            box-shadow: 0 0 10px rgb(247, 12, 71);
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
        table,td {
            font-size: 12px;
                /* border: 1px solid rgb(255, 255, 255); */
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
        $permiss_account       = StaticController::permiss_account($iduser);
        $permiss_setting_upstm = StaticController::permiss_setting_upstm($iduser);
        $permiss_ucs           = StaticController::permiss_ucs($iduser);
        $permiss_sss           = StaticController::permiss_sss($iduser);
        $permiss_ofc           = StaticController::permiss_ofc($iduser);
        $permiss_lgo           = StaticController::permiss_lgo($iduser);
        $permiss_prb           = StaticController::permiss_prb($iduser);
        $permiss_ti            = StaticController::permiss_ti($iduser);
        $permiss_rep_money     = StaticController::permiss_rep_money($iduser);
        $per_accb01            = StaticController::per_accb01($iduser);
        $kongthoon             = StaticController::kongthoon($iduser);
        $acc_106               = StaticController::acc_106($iduser);
        $acc_107               = StaticController::acc_107($iduser);
        $acc_report            = StaticController::acc_report($iduser);
        $acc_50x               = StaticController::acc_50x($iduser);
        $acc_70x               = StaticController::acc_70x($iduser);
        $acc_201               = StaticController::acc_201($iduser);
        $acc_202               = StaticController::acc_202($iduser);
        $acc_203               = StaticController::acc_203($iduser);
        $acc_209               = StaticController::acc_209($iduser);
        $acc_216               = StaticController::acc_216($iduser);
        $acc_217               = StaticController::acc_217($iduser);
        $acc_301               = StaticController::acc_301($iduser);
        $acc_302               = StaticController::acc_302($iduser);
        $acc_303               = StaticController::acc_303($iduser);
        $acc_304               = StaticController::acc_304($iduser);
        $acc_307               = StaticController::acc_307($iduser);
        $acc_308               = StaticController::acc_308($iduser);
        $acc_309               = StaticController::acc_309($iduser);
        $acc_310               = StaticController::acc_310($iduser);


?>

<body data-topbar="colored" data-layout="horizontal">
    {{-- <body data-topbar="dark" data-layout="horizontal"> --}}
    <div id="layout-wrapper">

        {{-- <header id="page-topbar" style="background-color: rgb(252, 76, 105)"> --}}
        <header id="page-topbar" style="background-color: rgba(176, 196, 4, 0.871)">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" >

                        <a href="{{url('account_monitor_main')}}" class="logo logo-dark">
                            <span class="logo-sm me-2">
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110">
                            </span>
                        </a>

                        <a href="{{url('account_monitor_main')}}" class="logo logo-light">
                            <span class="logo-sm me-2">
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item mt-3" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block mt-3">
                        <div class="position-relative">
                            <h3 style="color:rgb(31, 30, 30)" class="mt-2 noto-sans-thai-looped-light" >C H E C K - U P</h3>
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
        {{-- <div class="topnav" style="color: #e8f8d8"> --}}
        <div class="topnav" style="background-color: #e8f8d8;">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">



                                {{--
                            @if ($permiss_sss != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" >
                                    <img src="{{ asset('images/acc05.png') }}" height="27px" width="27px">
                                    <label for="" class="menufont">SSS</label>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    @if ($acc_301 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            301-OPเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_301_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_301_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_301_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                            <a href="{{ url('account_301_rep') }}" class="dropdown-item">Rep</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_302 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            302-IPเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_302_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_302_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_302_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            3012-อุปกรณ์เบิก New-Eclaim<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_3012_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_3012_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_3012_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div> -->
                                    @if ($acc_301 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            3013-OP-CT<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_3013_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_3013_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_303 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            303-OPนอกเครือข่าย สังกัด สป.สธ.<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_303_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_303_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_303_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_304 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            304-IPนอกเครือข่าย<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_304_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_304_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_304_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_307 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            307-กองทุนทดแทน<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_307_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_307_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_307_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_308 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            308-72ชั่วโมงแรก<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_308_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_308_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_308_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_309 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            309-ค่าใช้จ่ายสูง/อุบัติเหตุ/ฉุกเฉิน OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_309_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_309_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_309_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($acc_310 != 0)
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            310-ค่าใช้จ่ายสูง IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_310_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_310_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_310_detail_date') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </li>
                            @endif --}}

                            @if ($permiss_ofc != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('checkup_report') }}" id="topnav-more" role="button">
                                    <img src="{{ asset('images/check_trueinfo.png') }}" height="27px" width="27px" >
                                    </i>รายงานผลตรวจสุขภาพ
                                </a>                                
                            </li> 

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    {{-- <i class="ri-money-dollar-circle-fill me-2" style="font-size: 20px;color:rgb(235, 94, 248)"></i> --}}
                                    <img src="{{ asset('images/check_trueinfo2.png') }}" height="27px" width="27px">
                                    <label for="" class="menufont">OFC</label>
                                     <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            401-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง OP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_401_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_401_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_401_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                            <a href="{{ url('account_401_rep') }}" class="dropdown-item">Rep</a>
                                        </div>
                                    </div>
                                    <div class="dropdown menufont">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            402-ลูกหนี้ค่ารักษา-เบิกจ่ายตรงกรมบัญชีกลาง IP<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu menufont" aria-labelledby="topnav-form">
                                            <a href="{{ url('account_402_dash') }}" class="dropdown-item">dashboard</a>
                                            <a href="{{ url('account_402_pull') }}" class="dropdown-item">ดึงลูกหนี้</a>
                                            <a href="{{ url('account_402_search') }}" class="dropdown-item">ค้นหาลูกหนี้</a>
                                            <a href="{{ url('account_402_rep') }}" class="dropdown-item">Rep</a>
                                        </div>
                                    </div>
                                </div>

                            </li>
                            @endif


                            {{-- @if ($acc_report != 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                    <img src="{{ asset('images/acc10.png') }}" height="27px" width="27px">
                                    <label for="" class="menufont">Report</label>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu menufont" aria-labelledby="topnav-apps">
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
                            @endif --}}

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

            <footer class="footer" style="background-color: #e8f8d8">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6" style="color:#2e2d2d;font-size:17px;">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                        </div>
                        <div class="col-sm-6" style="color:#2e2d2d;font-size:17px;">
                            <div class="text-sm-end d-none d-sm-block">
                                {{-- Created with <i class="mdi mdi-heart text-danger"></i> by --}}
                                <p style="color:#2e2d2d;font-size:17px;">Created with <i class="mdi mdi-heart text-danger"></i> by เบญญดา ศิริวัลลภ - กลุ่มงานเทคโนโลยีสารสนเทศ</p>

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
    {{-- <script src="{{ asset('assets_ubi/libs/jquery/jquery.min.js') }}"></script>
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
      <!-- Datatable init js -->
      <script src="{{ asset('assets_ubi/js/pages/datatables.init.js') }}"></script>
      <script src="{{ asset('assets_ubi/js/app.js') }}"></script>   --}}

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
  <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>


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
