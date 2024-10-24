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
{{-- <link href="{{ asset('css/loginheader.css') }}" rel="stylesheet" /> --}}
 
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
        background-color: rgb(233, 233, 233);
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
        border-radius: 100%;
        animation: 6s infinite linear spin;
    }
    .loadingIcon2 {
        width: 40px;
        height: 40px;
        border: 2px solid rgb(255, 255, 255); 
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
            .inputplan{
                border-radius: 2em 2em 2em 2em;
                border: none;
                box-shadow: 0 0 15px rgb(255, 83, 120);
                border:solid 1px #7b28e7;
            }
            .inputmedsalt{
                border-radius: 2em 2em 2em 2em;
                border: none;
                box-shadow: 0 0 15px rgb(255, 83, 120);
                border:solid 1px #7b28e7;
            }
            
            .cardfinan{
                border-radius: 2em 2em 2em 2em;
                /* border: none; */
                box-shadow: 0 0 15px rgb(255, 83, 120);
                /* box-shadow: 0 0 10px rgb(247, 198, 176); */
                border:solid 1px #7b28e7;
            } 
            .input_new{
                border-radius: 2em 2em 2em 2em;
                box-shadow: 0 0 15px rgb(255, 83, 120);
                border:solid 1px #f80d6f;
            }
            .input_border{
                /* border-radius: 2em 2em 2em 2em; */
                box-shadow: 0 0 15px rgb(255, 83, 120);
                border:solid 1px #f80d6f;
            }
            .card_pink{
                border-radius: 3em 3em 3em 3em;
                box-shadow: 0 0 15px rgb(255, 83, 120);
            }
            .card_audit_2b{
                border-radius: 0em 0em 3em 3em;
                box-shadow: 0 0 15px rgb(255, 83, 120);
            }
            .card_audit_4c{
                border-radius: 2em 2em 2em 2em;
                box-shadow: 0 0 15px rgb(255, 83, 120);
                border:solid 1px #f80d6f;
            }
            .card_audit_4{
                border-radius: 3em 3em 3em 3em;
                box-shadow: 0 0 15px rgb(255, 83, 120);
            }
            .dcheckbox_{         
                width: 20px;
                height: 20px;      
                border: 10px solid rgb(252, 101, 1); 
                box-shadow: 0 0 15px rgb(255, 83, 120);
            }
            .select2-selection {
                border-color: green; /* example */
                }
            .select2-drop.select2-drop-above.select2-drop-active {
                border-top: 1px solid #ffff80;
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
        $permiss_account    = StaticController::permiss_account($iduser);
        $permiss_setting_upstm = StaticController::permiss_setting_upstm($iduser);
        $permiss_ucs        = StaticController::permiss_ucs($iduser);
        $permiss_sss        = StaticController::permiss_sss($iduser);
        $permiss_ofc        = StaticController::permiss_ofc($iduser);
        $permiss_lgo        = StaticController::permiss_lgo($iduser);
        $permiss_prb        = StaticController::permiss_prb($iduser);
        $permiss_ti         = StaticController::permiss_ti($iduser);
        $permiss_rep_money  = StaticController::permiss_rep_money($iduser);
        $bgs_year           = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow         = $bgs_year->leave_year_id;
        $wh_stock_list_only = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $wh_stock_dep_only  = DB::select(
            'SELECT b.stock_year,a.DEPARTMENT_SUB_SUB_ID,a.DEPARTMENT_SUB_SUB_NAME 
                FROM department_sub_sub a
                LEFT JOIN wh_stock_sub b ON b.stock_list_subid = a.DEPARTMENT_SUB_SUB_ID
                WHERE b.stock_year = "'.$bg_yearnow.'"
                GROUP BY a.DEPARTMENT_SUB_SUB_ID  
            ');
?>
 
 <body data-topbar="dark" data-layout="horizontal">
    {{-- <body data-topbar="light" data-layout="horizontal"> --}}
{{-- <body data-topbar="colored" data-layout="horizontal"> --}}
    {{-- <body data-topbar="dark" data-layout="horizontal"> --}}
    <div id="layout-wrapper">
        
        <header id="page-topbar" style="background-color: rgb(255, 83, 120)">
      
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" >
                      
                        <a href="{{url('wh_dashboard')}}" class="logo logo-dark"> 
                            <span class="logo-sm me-2"> 
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">  --}}
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="30"> 
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30">  --}}
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="30"> 
                            </span>
                        </a>
 
                        <a href="{{url('wh_dashboard')}}" class="logo logo-light">
                            <span class="logo-sm me-2"> 
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> --}}
                                <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110"> 
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> --}}
                                {{-- <img src="{{ asset('images/officer5.png') }}" class="" alt="logo-sm-light" height="30"> --}}
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
                            {{-- <input type="text" class="form-control" placeholder="Search..."> --}}
                            {{-- <span class="ri-search-line"></span> --}}
                            <h3 style="color:rgb(255, 255, 255)" class="mt-2 noto-sans-thai-looped-light" >F I N A N C E </h3>
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
      
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
 
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="fa-solid fa-chart-pie me-2" style="font-size: 20px;color:rgb(4, 194, 169)"></i>Dashboard <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('account_info') }}" class="dropdown-item">dashboard</a> 
                                    {{-- <a href="{{ url('account_monitor') }}" class="dropdown-item">Monitor</a>  --}}
                                </div> 
                                
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                    <i class="fa-solid fa-diagram-project me-2" style="font-size: 20px;color:rgb(252, 101, 1)"></i>แผนโครงการ<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('account_plane') }}" class="dropdown-item">เบิกเงินโครงการ</a>  
                                </div>  
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('account_info') }}"> 
                                     <i class="fa-solid fa-clipboard-check me-2" style="font-size: 20px;color:rgb(248, 51, 126)"></i> Approve Code
                                </a> 
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('wh_pay') }}">
                                     <i class="fa-brands fa-btc me-2" style="font-size: 20px;color:rgb(9, 188, 201)"></i>ไม่ได้ชำระเงิน
                                </a> 
                            </li> --}}
                          
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fa-brands fa-btc me-2" style="font-size: 20px;color:rgb(204, 26, 56)"></i>ไม่ได้ชำระเงิน <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('account_nopaid') }}" class="dropdown-item">ข้อมูลทั้งปี OPD</a>  
                                    <a href="{{ url('account_nopaid_ip') }}" class="dropdown-item">ข้อมูลทั้งปี IPD</a> 
                                </div>                                
                            </li> 

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fa-brands fa-btc me-2" style="font-size: 20px;color:rgb(204, 26, 56)"></i>เงินเดือนค่าตอบแทน <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('account_money_hosrep') }}" class="dropdown-item">บัญชีรับ</a>  
                                    <a href="{{ url('account_money_hospay') }}" class="dropdown-item">บัญชีจ่าย</a> 
                                    <a href="{{ url('account_money_monthlydebthos') }}" class="dropdown-item">ข้อมูลหนี้รายเดือน</a>
                                </div>                                
                            </li> 
                           

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fa-solid fa-chart-line me-2" style="font-size: 20px;color:rgb(134, 3, 117)"></i><span key="t-layouts">รายงาน</span> <div class="arrow-down"></div> 
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('account_money_report')}}" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">รายงานประจำเดือน</span>  
                                        </a> 
                                    </div> 
                                </div>
                                
                            </li>
                               
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="fas fa-tools me-2" style="font-size: 20px;color:rgb(168, 25, 6)"></i><span key="t-layouts">Setting</span> <div class="arrow-down"></div>                              
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    {{-- <div class="dropdown"> --}}
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('account_money_setting')}}" id="topnav-layout-verti" role="button">
                                            <span key="t-vertical">ตั้งค่า</span>  
                                        </a> 
                                        {{-- <a class="dropdown-item dropdown-toggle arrow-none" href="{{url('account_money_report')}}" id="topnav-layout-verti" role="button">
                                            <span key="t-vertical">รายงาน</span>  
                                        </a>  --}}

                                    {{-- </div>  --}}
                                </div>
                            </li>
                            {{-- @if ($permiss_ucs != 0) --}}
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                             
                                    <i class="fa-solid fa-diagram-project me-2" style="font-size: 20px;color:rgb(245, 96, 121)"></i>แผนจัดซื้อพัสดุ-ครุภัณฑ์ <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">                                     
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            แผนจัดซื้อ<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="{{ url('wh_plan') }}" class="dropdown-item">dashboard</a> 
                                        </div>
                                    </div>                                     
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            209-ลูกหนี้ค่ารักษา OP(P&P) <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form"> 
                                            <a href="{{ url('account_pkucs209_dash') }}" class="dropdown-item">dashboard</a>                                        
                                        </div>
                                    </div>                                     
                                </div>
                            </li> --}}
                            {{-- @endif --}}
 
                          
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
     
            <div class="container-fluid fixed-bottom mb-4">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Created with <i class="mdi mdi-heart text-danger"></i> by ประดิษฐ์ ระหา - งานสุขภาพดิจิทัล
                        </div>
                    </div>
                </div>
            </div>

        </div>  

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
