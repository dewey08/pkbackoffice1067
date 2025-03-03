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
   <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}">

   

   {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
   <link href="{{ asset('apkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
   <link href="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
   <!-- jquery.vectormap css -->
   <link href="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
       rel="stylesheet" type="text/css" />

   <!-- DataTables -->
   <link href="{{ asset('apkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
       type="text/css" />

   <!-- Responsive datatable examples -->
   <link href="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
       rel="stylesheet" type="text/css" />
       <link href="{{ asset('css/tableuser_new.css') }}" rel="stylesheet">
   <!-- Bootstrap Css -->
   <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
   {{-- <link href="{{ asset('apkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
   <!-- Icons Css -->
   <link href="{{ asset('apkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('apkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
   {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> --}}
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
   {{-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> --}}
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body data-topbar="dark" data-layout="horizontal">

         <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar" style="background-color: rgba(9, 165, 165, 0.952)">
                <div class="navbar-header">
                    <div class="d-flex">
                         <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href=" " class="logo logo-dark">

                        </a>

                        <a href=" " class="logo" style="background-color: rgb(9, 165, 165, 0.952)">
                            <span class="logo-sm mb-2">
                                <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40"> --}}
                                <label for="" style="color: white;font-size:25px;"
                                    class="ms-1 mt-2">PK-OFFICE</label>
                                    
                            </span>
                        </a>
                    </div>
                    <?php  
                    $datadetail = DB::connection('mysql')->select(                                                            '   
                            select * from orginfo 
                            where orginfo_id = 1                                                                                                                      ',
                    ); 
                ?>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                        </button>
                        {{-- @foreach ($datadetail as $item)
                        <h4 style="color: white;font-size:22px;" class="ms-2 mt-4">{{$item->orginfo_name}}</h4>
                    @endforeach --}}

                        <!-- App Search-->
                        {{-- <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="ri-search-line"></span>
                            </div>
                        </form> --}}

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

                      
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255)"></i>
                            </button>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->img == null)
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px" width="32px"
                                        alt="Header Avatar" class="rounded-circle header-profile-user">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                                        width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                @endif
                                <span class="d-none d-xl-inline-block ms-1">
                                    {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('user/profile_edit/' . Auth::user()->id) }}"><i
                                        class="ri-user-line align-middle me-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    class="text-reset notification-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
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
                                    <a class="nav-link" href="">
                                        <i class="ri-dashboard-line me-2"></i> Dashboard
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                        <i class="ri-layout-3-line me-2"></i><span key="t-layouts">งานบริหารบุคคล</span>  
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                                role="button">
                                                <span key="t-vertical">ข้อมูลการลา</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                                <a href="{{ url('user/gleave_data_sick') }}" class="dropdown-item" key="t-dark-sidebar">ลาป่วย</a>
                                                <a href="{{ url('user/gleave_data_leave') }}" class="dropdown-item" key="t-compact-sidebar">ลากิจ</a>
                                                <a href="{{ url('user/gleave_data_vacation') }}" class="dropdown-item" key="t-icon-sidebar">ลาพักผ่อน</a>
                                                <a href="{{ url('user/gleave_data_study') }}" class="dropdown-item" key="t-boxed-width">ลาศึกษา ฝึกอบรม</a>
                                                <a href="{{ url('user/gleave_data_work') }}" class="dropdown-item" key="t-preloader">ลาทำงานต่างประเทศ</a>
                                                <a href="{{ url('user/gleave_data_occupation') }}" class="dropdown-item" key="t-colored-sidebar">ลาฟื้นฟูอาชีพ</a>
                                                <a href="{{ url('user/gleave_data_soldier') }}" class="dropdown-item" key="t-boxed-width">ลาเกณฑ์ทหาร</a>
                                                <a href="{{ url('user/gleave_data_helpmaternity') }}" class="dropdown-item" key="t-boxed-width">ลาช่วยภริยาคลอด</a>
                                                <a href="{{ url('user/gleave_data_maternity') }}" class="dropdown-item" key="t-boxed-width">ลาคลอดบุตร</a>
                                                <a href="{{ url('user/gleave_data_spouse') }}" class="dropdown-item" key="t-boxed-width">ลาติดตามคู่สมรส</a>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">ประชุม/อบรม/ดูงาน</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{ url('user/persondev_index/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ประชุมภายนอก</a>
                                                <a href="{{ url('user/persondev_inside/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ประชุมภายใน</a>                                                    
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">บ้านพัก</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{ url('user/house_detail/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ข้อมูลบ้านพัก</a>
                                                <a href="{{ url('user/house_petition/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ยื่นคำร้อง</a>   
                                                <a href="{{ url('user/house_problem/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">แจ้งปัญหา</a>                                                   
                                            </div>
                                        </div>

                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                        <i class="ri-layout-3-line me-2"></i><span key="t-layouts">งานบริหารทั่วไป</span> 
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                            
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">สารบรรณ</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{ url('user/book_inside/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">หนังสือเข้า</a>
                                                <a href="{{ url('user/book_send/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">หนังสือส่ง</a>                                                    
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">ห้องประชุม</span> 
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{ url('user_meetting/meetting_calenda') }}" class="dropdown-item" key="t-horizontal">ปฎิทินการใช้ห้องประชุม</a>
                                                <a href="{{url('user_meetting/meetting_index')}}" class="dropdown-item" key="t-topbar-light">ช้อมูลการจองห้องประชุม</a>                                                    
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">แจ้งซ่อม</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                {{-- <a href="{{url('user_com/com_calenda')}}" class="dropdown-item" key="t-horizontal">ปฎิทินการแจ้งซ่อม</a>
                                                <a href="{{url('com_calendanew')}}" class="dropdown-item" key="t-horizontal">ปฎิทินการแจ้งซ่อม2</a> --}}
                                                <a href="{{url('user_com/repair_com_calenda')}}" class="dropdown-item" key="t-horizontal">ปฎิทินการแจ้งซ่อม</a>
                                                <a href="{{url('user_com/repair_com')}}" class="dropdown-item" key="t-topbar-light">ทะเบียนซ่อมคอมพิวเตอร์</a>  
                                                <a href="{{url('user_com/repair_com_add')}}" class="dropdown-item" key="t-topbar-light">แจ้งซ่อมคอมพิวเตอร์</a>                                                   
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">งานทรัพย์สิน</span> 
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{url('user/article_index/'.Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ทะเบียนทรัพย์สิน</a>
                                                <a href="{{url('user/article_borrow/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ทะเบียนยืม</a>  
                                                <a href="{{url('user/article_return/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ทะเบียนคืน</a>                                                   
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">งานพัสดุ</span> 
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{url('user/supplies_data/'.Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">รายการจัดซื้อ-จัดจ้าง</a>
                                                <a href="{{url('user/supplies_data_add/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ขอจัดซื้อ-จัดจ้าง</a>                                               
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">คลังวัสดุ</span> 
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{url('user_ware/warehouse_stock_sub')}}" class="dropdown-item" key="t-horizontal">รายการคลังวัสดุ</a>
                                                <a href="{{url('user_ware/warehouse_stock_sub_add')}}" class="dropdown-item" key="t-topbar-light">ขอเบิกคลังวัสดุ</a>                                               
                                            </div>
                                        </div>

                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                        <i class="ri-layout-3-line me-2"></i><span key="t-layouts">รายงาน</span> 
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                                role="button">
                                                <span key="t-vertical">REFER</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                                <a href="{{ url('report_refer_main') }}" class="dropdown-item" key="t-dark-sidebar">การลงข้อมูล REFER</a>
                                                <a href="{{ url('report_refer_main_repback') }}" class="dropdown-item" key="t-compact-sidebar">การลงข้อมูลรับกลับ REFER</a>
                                                <a href="{{ url('report_refer_main_rep') }}" class="dropdown-item" key="t-icon-sidebar">การลงข้อมูลรับ REFER</a>
                                                <a href="{{ url('report_ipopd') }}" class="dropdown-item" key="t-boxed-width">Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD</a>
                                                <a href="{{ url('report_refer_out') }}" class="dropdown-item" key="t-preloader">Refer out ทะเบียนผู้ป่วยส่งต่อทั้งหมด</a>
                                                <a href="{{ url('report_refer_outipd') }}" class="dropdown-item" key="t-colored-sidebar">Refer out ทะเบียนผู้ป่วยส่งต่อประเภท IPD</a>
                                                <a href="{{ url('report_refer_outopd') }}" class="dropdown-item" key="t-boxed-width">Refer out ทะเบียนผู้ป่วยส่งต่อประเภท OPD</a>
                                                <a href="{{ url('report_refer_outmonth') }}" class="dropdown-item" key="t-boxed-width">Refer out สรุปการส่งต่อรายเดือนแบบเลือกสาขา</a>  
                                            </div>
                                        </div>
                                            
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">งานจิตเวชและยาเสพติด</span>  
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="{{ url('equipment')}}" class="dropdown-item" key="t-horizontal">อุปกรณ์</a>
                                                <a href="{{ url('restore')}}" class="dropdown-item" key="t-topbar-light">ฟื้นฟู</a>                                                    
                                            </div>
                                        </div>

                                    </div>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
 
                    <div class="page-content">

                        @yield('content')
        
                    </div>
                  
                    
            </div>
        </div>
                <!-- End Page-content -->
{{--                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                @foreach ($datadetail as $item)
                                <script>document.write(new Date().getFullYear())</script> © {{$item->orginfo_name}}.
                       
                                @endforeach 
                                
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Dekbanbanproject
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> --}}
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        {{-- <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>


            </div>  
        </div> --}}
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
    <!-- JAVASCRIPT -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
    {{-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>  --}}
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/node-waves/waves.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>  --}}
    {{-- <script src="{{ asset('apkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('apkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('apkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

      <!-- Buttons examples -->
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/jszip/jszip.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
  
      <script src="{{ asset('apkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

     <!-- Datatable init js -->
     {{-- <script src="{{ asset('apkclaim/js/pages/datatables.init.js') }}"></script> --}}
     <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script> 
     <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
 
 
     <script src="{{ asset('apkclaim/js/pages/form-wizard.init.js') }}"></script>
    {{-- <script src="{{ asset('apkclaim/js/pages/dashboard.init.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/select2.min.js') }}"></script> --}}
    <script src="{{asset('asset/js/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    {{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="{{ asset('apkclaim/js/app.js') }}"></script>

        @yield('footer')

        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $('#example4').DataTable();
                $('#example5').DataTable();
                $('#example_user').DataTable();
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
            });
    
            $(document).ready(function() {
                $('#book_saveForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    // alert('OJJJJOL');
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'บันทึกข้อมูลสำเร็จ',
                                    text: "You Insert data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location =
                                            "{{ url('book/bookmake_index') }}"; // กรณี add page new  
                                    }
                                })
                            } else {
    
                            }
                        }
                    });
                });
            });
    
            $(document).ready(function() {
                $('#update_personForm').on('submit', function(e) {
                    e.preventDefault();
                    //   alert('Person');
                    var form = this;
    
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Username...!!',
                                    text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
    
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Edit data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = "{{ url('user/home') }}"; //
                                    }
                                })
                            }
                        }
                    });
                });
            });
    
            $(document).ready(function() {

                $('#article_id').select2({
                    placeholder: "==เลือก== ",
                    allowClear: true
                });
    
                $('#bookrep_import_fam').select2({
                    placeholder: "นำเข้าไว้ในแฟ้ม ",
                    allowClear: true
                });
    
                $('#bookrep_speed_class_id').select2({
                    placeholder: "ชั้นความเร็ว",
                    allowClear: true
                });
                $('#bookrep_secret_class_id').select2({
                    placeholder: "ชั้นความลับ",
                    allowClear: true
                });
                $('#bookrep_type_id').select2({
                    placeholder: "ประเภทหนังสือ",
                    allowClear: true
                });
                $('#sendperson_user_id').select2({
                    placeholder: "ชื่อ-นามสกุล",
                    allowClear: true
                });
                $('#DEPARTMENT_SUB_ID').select2({
                    placeholder: "ฝ่าย/แผนก",
                    allowClear: true
                });
                $('#dep').select2({
                    placeholder: "กลุ่มงาน",
                    allowClear: true
                });
                $('#depsub').select2({
                    placeholder: "ฝ่าย/แผนก",
                    allowClear: true
                });
                $('#depsubsub').select2({
                    placeholder: "หน่วยงาน",
                    allowClear: true
                });
                $('#team').select2({
                    placeholder: "ทีมนำองค์กร",
                    allowClear: true
                });
                $('#depsubsubtrue').select2({
                    placeholder: "หน่วยงานที่ปฎิบัติจริง",
                    allowClear: true
                });
                $('#book_objective').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective2').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective3').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective4').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective5').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#org_team_id').select2({
                    placeholder: "ทีมนำองค์กร",
                    allowClear: true
                });
                $('#com_repaire_speed').select2({
                    placeholder: "==เลือก==",
                    allowClear: true
                });
                $('#com_repaire_year').select2({
                    placeholder: "ปีงบประมาณ",
                    allowClear: true
                });
    
                $('#warehouse_deb_req_year').select2({
                placeholder: "-เลือก-",
                allowClear: true
                });
                $('#warehouse_deb_req_userid').select2({
                    placeholder: "-เลือก-",
                    allowClear: true
                });
                $('#warehouse_deb_req_hnid').select2({
                    placeholder: "-เลือก-",
                    allowClear: true
                });
    
            });
        </script>
    </body>
</html>
