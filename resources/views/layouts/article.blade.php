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



   {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
   <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
   <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
   <!-- jquery.vectormap css -->
   <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
       rel="stylesheet" type="text/css" />

   <!-- DataTables -->
   <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
       type="text/css" />

   <!-- Responsive datatable examples -->
   <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
       rel="stylesheet" type="text/css" />
       <link href="{{ asset('css/tablecom.css') }}" rel="stylesheet">
   <!-- Bootstrap Css -->
   <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

   <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">

    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 13px;

        }

        label {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;

        }

        @media only screen and (min-width: 1200px) {
            label {
                /* float:right; */
            }

        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);


        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    </style>
    <body data-topbar="light" data-layout="horizontal">

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

      <header id="page-topbar" >
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item"
                    data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>

                <div class="dropdown dropdown-mega d-none d-lg-block ">
                    <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                        aria-haspopup="false" aria-expanded="false">
                        <h4 style="color:rgb(109, 14, 172)" class="mt-3">PK-OFFICE</h4>

                    </button>
                </div>

            </div>
            <?php
                    $datadetail = DB::connection('mysql')->select(                                                            '
                            select * from orginfo
                            where orginfo_id = 1                                                                                                                      ',
                    );
                ?>


            <div class="d-flex">
              <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line" style="color: rgb(170, 7, 97)"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago
                                        </p>
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
                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.
                                        </p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago
                                        </p>
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

        <div class="topnav" style="background-color: rgba(7, 59, 119, 0.952)">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">



                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav ">
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('article/article_dashboard') }}">
                                    <i class="ri-dashboard-line me-2"></i> Dashboard
                                </a>
                            </li> --}}
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('land/land_index')}}" id="topnav-apps"
                                    role="button">
                                    <i class="fa-brands fa-slack me-2 text-warning"></i>

                                    ข้อมูลที่ดิน </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('building/building_index')}}" id="topnav-apps"
                                    role="button">
                                    <i class="fa-regular fa-building me-2 text-info"></i>
                                    ข้อมูลอาคาร
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('article/article_index')}}" id="topnav-apps"
                                    role="button">
                                    <i class="fa-regular fa-clipboard me-2 text-danger"></i>
                                    ข้อมูลครุภัณฑ์
                                </a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps"
                                    role="button">
                                    <i class="ri-apps-2-line me-2"></i>ข้อมูลค่าเสื่อม
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps"
                                  role="button">
                                  <i class="ri-apps-2-line me-2"></i>ขายทอดตลาด
                              </a>
                          </li> --}}

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button">
                                    <i class="ri-apps-2-line me-2"></i>รายงาน<div class="arrow-down"></div>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-apps-2-line me-2"></i>ตั่งค่า <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{url("warehouse/warehouse_inven")}}" class="dropdown-item">คลังวัสดุ</a>
                                    <a href="{{url("warehouse/warehouse_vendor")}}" class="dropdown-item">ตัวแทนจำหน่าย</a>
                                </div>
                            </li>  --}}
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
            <!-- End Page-content -->

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
                                Created with <i class="mdi mdi-heart text-danger"></i> By หน่วยงานประกัน
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


    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- apexcharts -->
    {{-- <script src="{{ asset('pkclaim/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

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

    <!-- Datatable init js -->
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>

    <script src="{{ asset('pkclaim/js/app.js') }}"></script>

    @yield('footer')

    <script type="text/javascript">
      $(document).ready(function () {
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();
          $('#table_id').DataTable();

          $('#building_userid').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#article_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_tonnage_number').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_decline_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_buy_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_method_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_budget_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });


          $('#article_deb_subsub_id').select2({
              placeholder:"--หน่วยงาน--",
              allowClear:true
          });
          $('#article_categoryid').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });

          $('#article_decline_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_typeid').select2({
              placeholder:"ประเภทวัสดุ",
              allowClear:true
          });
          $('#article_unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_spypriceid').select2({
              placeholder:"ราคาสืบ",
              allowClear:true
          });
          $('#product_groupid').select2({
              placeholder:"ชนิดวัสดุ",
              allowClear:true
          });
          $('#article_buy_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#vendor_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#article_status_id').select2({
              placeholder:"--สถานะ--",
              allowClear:true
          });
          $('#article_brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#room_type').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_type_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_province').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_province_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_district_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_tumbon_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_user_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });

      });


      $(document).ready(function(){
          $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });

          $('#insert_landForm').on('submit',function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                  url:$(form).attr('action'),
                  method:$(form).attr('method'),
                  data:new FormData(form),
                  processData:false,
                  dataType:'json',
                  contentType:false,
                  beforeSend:function(){
                    $(form).find('span.error-text').text('');
                  },
                  success:function(data){
                    if (data.status == 0 ) {

                    } else {
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
                          window.location="{{url('land/land_index')}}";
                        }
                      })
                    }
                  }
                });
          });

          $('#update_landForm').on('submit',function(e){
                  e.preventDefault();
                  var form = this;
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {

                      } else {
                        Swal.fire({
                          title: 'แก้ไขข้อมูลสำเร็จ',
                          text: "You edit data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location="{{url('land/land_index')}}";
                          }
                        })
                      }
                    }
                  });
          });

      });

      //********** Building  ********************//
      $(document).ready(function(){
            $('#insert_buildingForm').on('submit',function(e){
              e.preventDefault();

                  var form = this;
                  // alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {

                      } else {
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
                            window.location="{{url('building/building_index')}}";
                          }
                        })
                      }
                    }
                  });
            });

            $('#update_buildingForm').on('submit',function(e){
              e.preventDefault();

              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {

                  } else {
                    Swal.fire({
                      title: 'แก้ไขข้อมูลสำเร็จ',
                      text: "You edit data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177',
                      // cancelButtonColor: '#d33',
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location="{{url('building/building_index')}}";
                      }
                    })
                  }
                }
              });
            });

            $('#insert_leveloneForm').on('submit',function(e){
              e.preventDefault();

              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {
                    Swal.fire({
                      icon: 'error',
                      title: 'มีข้อมูลนี้แล้ว...',
                      text: 'ข้อมูลนี้ได้ถูกเพิ่มไปแล้ว!',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.reload();
                      }
                    })

                  } else {
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
                        window.location.reload();
                      }
                    })
                  }
                }
              });
            });

            $('#insert_levelForm').on('submit',function(e){
              e.preventDefault();

              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {
                    Swal.fire({
                      icon: 'error',
                      title: 'มีข้อมูลนี้แล้ว...',
                      text: 'ข้อมูลนี้ได้ถูกเพิ่มไปแล้ว!',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.reload();
                      }
                    })
                  } else {
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
                        window.location.reload();
                      }
                    })
                  }
                }
              });
            });

            $('#insert_levelroomForm').on('submit',function(e){
              e.preventDefault();

              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {
                    Swal.fire({
                      icon: 'error',
                      title: 'มีข้อมูลนี้แล้ว...',
                      text: 'ข้อมูลนี้ได้ถูกเพิ่มไปแล้ว!',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.reload();
                      }
                    })
                  } else {
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
                        window.location.reload();
                      }
                    })
                  }
                }
              });
            });

      });

      //********** Article  ********************//
      $(document).ready(function(){
            $('#insert_articleForm').on('submit',function(e){
                  e.preventDefault();

                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {

                      } else {
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
                            window.location="{{url('article/article_index')}}";
                          }
                        })
                      }
                    }
                  });
            });

            $('#update_articleForm').on('submit',function(e){
              e.preventDefault();

              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {

                  } else {
                    Swal.fire({
                      title: 'แก้ไขข้อมูลสำเร็จ',
                      text: "You edit data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177',
                      // cancelButtonColor: '#d33',
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location="{{url('article/article_index')}}";
                      }
                    })
                  }
                }
              });
            });
      });

      function addunit() {
          var unitnew = document.getElementById("UNIT_INSERT").value;
          // alert(unitnew);
          var _token = $('input[name="_token"]').val();
          $.ajax({
              url: "{{url('article/addunit')}}",
              method: "GET",
              data: {
                unitnew: unitnew,
                  _token: _token
              },
              success: function (result) {
                  $('.show_unit').html(result);
              }
          })
      }

      function addbrand() {
          var brandnew = document.getElementById("BRAND_INSERT").value;
          var _token = $('input[name="_token"]').val();
          $.ajax({
              url: "{{url('article/addbrand')}}",
              method: "GET",
              data: {
                brandnew: brandnew,
                  _token: _token
              },
              success: function (result) {
                  $('.show_brand').html(result);
              }
          })
      }
   
  </script>
</body>

</html>
