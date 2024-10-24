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
      
       <!-- DataTables --> 
       <!-- Responsive Table css -->
       <link href="{{ asset('pkclaim/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
       {{-- <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> --}}
       {{-- <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> --}}
       {{-- <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />   --}}
       <!-- Responsive datatable examples -->
       {{-- <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  --}}

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
       <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
       {{-- <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet"> --}}
       {{-- <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}">  --}}

 
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

            
            .card_pink{
                border-radius: 3em 3em 3em 3em;
                box-shadow: 0 0 10px rgb(252, 101, 1);
            }
            .card_audit_2b{
                border-radius: 0em 0em 3em 3em;
                box-shadow: 0 0 10px rgb(252, 101, 1);
            }
            .card_audit_4c{
                border-radius: 2em 2em 2em 2em;
                box-shadow: 0 0 15px rgb(252, 101, 1);
                border:solid 1px #80acfd;
            }
            .card_audit_4{
                border-radius: 3em 3em 3em 3em;
                box-shadow: 0 0 10px rgb(252, 101, 1);
            }
            .dcheckbox_{         
                width: 20px;
                height: 20px;      
                border: 10px solid rgb(252, 101, 1); 
                box-shadow: 0 0 10px rgb(252, 101, 1); 
            }
            @keyframes colorShift {
                0% {
                    background-color: #22dcdf
                }
                50% {
                    background-color: #2ed82e
                }
                100% {
                    background-color: #rgb(252, 101, 1)
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
        
        <header id="page-topbar" style="background-color: rgb(253, 139, 111)">
      
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" >
                      
                        <a href="{{url('wh_dashboard')}}" class="logo logo-dark"> 
                            <span class="logo-sm me-2"> 
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> 
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/p.png') }}" class="loadingIcon2" alt="logo-sm-light" height="30">
                                <img src="{{ asset('images/k.png') }}" class="loadingIcon" alt="logo-sm-light" height="30"> 
                            </span>
                        </a>
 
                        <a href="{{url('wh_dashboard')}}" class="logo logo-light">
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
                                    <a href="{{ url('wh_dashboard') }}" class="dropdown-item">dashboard</a> 
                                    {{-- <a href="{{ url('account_monitor') }}" class="dropdown-item">Monitor</a>  --}}
                                </div> 
                                
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="fa-solid fa-diagram-project me-2" style="font-size: 20px;color:rgb(252, 101, 1)"></i>แผนจัดซื้อพัสดุ-ครุภัณฑ์  <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('wh_plan') }}" class="dropdown-item">แผนจัดซื้อวัสดุสำนักงาน</a> 
                                    {{-- <a href="{{ url('account_monitor') }}" class="dropdown-item">Monitor</a>  --}}
                                </div> 
                                
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fa-solid fa-cubes me-2" style="font-size: 20px;color:rgb(204, 26, 56)"></i>คลังหลัก <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    @foreach ($wh_stock_list as $item)
                                        <a href="{{ url('wh_main/'.$item->stock_list_id) }}" class="dropdown-item">{{$item->stock_list_name}}</a> 
                                    @endforeach
                                    
                                </div>
                                
                            </li> 
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fa-solid fa-cubes-stacked me-2" style="font-size: 20px;color:rgb(10, 116, 187)"></i>คลังย่อย <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('wh_sub') }}" class="dropdown-item">คลัง</a> 
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
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

        
            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

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
    {{-- <script src="assets/js/app.js"></script> --}}
    
        <!-- Init js -->
        {{-- <script src="{{ asset('assets_ubi/js/pages/table-responsive.init.js') }}"></script> --}}
      <!-- Datatable init js -->
      <script src="{{ asset('js/pages/datatables.init.js') }}"></script>
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
