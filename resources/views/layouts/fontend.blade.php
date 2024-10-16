 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PK-OFFICE</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{ asset('medical/assets/img/logo150.ico') }}" rel="icon">
    {{-- <link href="{{ asset('medical/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('medical/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Variables CSS Files. Uncomment your preferred color scheme -->
    <link href="{{ asset('medical/assets/css/variables.css') }}" rel="stylesheet">
 
    <!-- Template Main CSS File -->
    <link href="{{ asset('medical/assets/css/main.css') }}" rel="stylesheet"> 
    
    
    <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/css/main.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/dcss.css') }}"> --}}
   
</head>
<style>
    .modal-dialog2 {
            max-width: 100%;
        }
        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 auto;
            background: #fff;
        }
        /* .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        } */
        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .bgbody{
            /* width: 100%; */
            /* height: 100vh; */
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
                url(/pkbackoffice/public/assets/images/lg.png)no-repeat 50%; 
            /* background-size: cover; */
            /* background-attachment: fixed; */
            /* display: flex; */
            /* align-items: center; */
            /* justify-content: center; */
        }
        .dcheckbox{        
            border: 30px solid teal; 
            box-shadow: 0 0 10px teal; 
        }
        $position-values: (
            0: 0,
            50: 50%,
            100: 100%
        );
        .modal-loginflex {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flexbox;
            display: -o-flex;
            display: flex;
            flex-flow:column nowrap; /*Add this */
            justify-content: center;
            -ms-justify-content: center;
            -ms-flex-pack: center;
            align-items: center;
            }

</style>

<body onload="enableAutoplay();">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top" data-scrollto-offset="0">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <a href="" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                 <img src="{{ asset('medical/assets/img/logo150.png') }}" alt="" class="me-2">  
                <h2 class="mt-2">Phukieo Chalermprakiat Hospital<span></span></h2>
            </a>

            <nav id="navbar" class="navbar">
                <ul>   
                    <li><a class="nav-link scrollto" href="{{ url('/login') }}"><i class="fa-solid fa-house-chimney me-2"></i>Home</a></li> 
                    <li><a class="nav-link scrollto" href="#exsecutiva"><i class="fa-solid fa-person me-2"></i>คณะผู้บริหารงาน</a></li> 
                    <li><a class="nav-link scrollto" href="#vision"><i class="fa-solid fa-person me-2"></i>วิสัยทัศน์/พันธกิจ</a></li> 
                     {{-- <li class="dropdown "><a href="{{url('/login')}}">
                        <i class="fa-solid fa-house-chimney me-2"></i>
                        <span class="text-center">Home</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="#">
                        <i class="fa-solid fa-address-book me-2"></i>
                        <span class="text-center">เกี่ยวกับเรา</span>  
                        <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="">ประวัติโรงพยาบาล</a></li>
                            <li><a href="#exsecutiva">คณะผู้บริหารงาน</a></li>
                            <li><a href="#vision">วิสัยทัศน์/พันธกิจ</a></li> 
                            <li><a href="#department">หน่วยงาน</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown "><a href="#contact">
                        <i class="fa-regular fa-address-book me-2"></i>
                        <span class="text-center">Contact</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="{{url('report_dashboard')}}">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        <span class="text-center">Report</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    <li><a class="nav-link scrollto" href="#contact"><i class="fa-regular fa-address-book me-2"></i>Contact</a></li> 
                    <li><a href="{{ url('report_dashboard') }}" target="_blank"><i class="fa-solid fa-chart-line me-2"></i>Report</a></li> 
               
                    {{-- <li class="dropdown"><a href="#"> <i class="fa-solid fa-download me-2"></i><span>Download</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                    
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม รพ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม คปสอ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม คปสอ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li><a href="#">แบบฟอร์มต่างๆ</a></li> 
                        </ul>
                    </li> --}}

                    {{-- <li class="dropdown "><a data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-fingerprint me-2"></i>
                        <span class="text-center">Login</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="{{url('authen_main')}}">
                        <i class="fa-solid fa-person me-2"></i>
                        <span class="text-center">Authen</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li><a class="nav-link scrollto" href="#login"><i class="fa-solid fa-fingerprint me-2"></i>Login</a></li> --}}
                    <li> <a href="" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal"><i class="fa-solid fa-fingerprint me-2"></i>Login</a> </li> 
                    {{-- <li><a href="{{ url('authen_main') }}" target="_blank"><i class="fa-solid fa-person me-2" style="font-size: 15px"></i>Authen</a></li>  --}}
                </ul> 
                <i class="bi bi-list mobile-nav-toggle d-none"></i>
            </nav>
            <!-- .navbar -->
 
        </div>
    </header><!-- End Header -->
    <style>
        #overlay{
          background: #000;
          position: fixed;
          opacity:0.3;
          display:none;
          width: 100%;
          height: 100vh;
        }
      </style>
    <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
        <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
            <div id="overlay"></div> 
            <h2>Welcome to <span>Phukieo Chalermprakiat Hospital</span></h2>
            <p>เป็นโรงพยาบาลตัวอย่าง ด้านคุณภาพความปลอดภัยและประทับใจ.</p>
            <div class="d-flex">
                <a href="#about" class="btn-get-started scrollto">Get Started</a> 
                <a href="https://www.youtube.com/watch?v=7VTjCocVzFM"
                    class="btn btn-outline-info glightbox btn-watch-video d-flex align-items-center">
                    <i class="bi bi-play-circle"></i><span>Watch Video</span>
                </a>
            </div>
            {{-- <div id="overlay"></div> --}}
            {{-- <h1>The audio autoplay attribute</h1> --}}
              <br/>
            {{-- <audio controls class="mt-2"> --}}
                <audio id="mySong" controls="controls" class="mt-2">
                <source src="song/all_chiw_2019.m4a" type="audio/m4a" allow="autoplay;">
                <source src="song/all_chiw_2019.m4a" type="audio/mp3" allow="autoplay;"> 
            </audio>
        </div>
    </section>

    <main id="main">

        {{-- <div class="main-content"> --}}
           
                @yield('content')

            {{-- </div> --}}

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="footer-content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <h3>PHUKIEO CHALERMPRAKIAT HOSPITAL</h3>
                            <p>
                                149 หมู่ 4 ตำบล ผักปัง  <br>
                                อำเภอ ภูเขียว ชัยภูมิ 36110<br><br>
                                <strong>Phone:</strong> 044-861700-3<br>
                                <strong>Email:</strong> info@example.com<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Wb Pages</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="{{url('/')}}">Home</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#exsecutiva">คณะผู้บริหารงาน</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#vision">วิสัยทัศน์/พันธกิจ</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#department">หน่วยงาน</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="footer-legal text-center">
            <div
                class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div class="copyright">
                        &copy; Copyright <strong><span>PHUKIEO CHALERMPRAKIAT HOSPITAL</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                        Designed by <a href="">PK TAEM</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>

            </div>
        </div>

    </footer><!-- End Footer -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- <div class="modal-dialog modal-dialog-slideout"> --}}
            <div class="modal-dialog">
            <div class="modal-content"> 
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <br>
                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-center">
                                                <span>
                                                    <img src="{{ asset('images/logo_350.jpg') }}" width="200" height="200" alt="IMG"><br><br> 
                                                </span> 
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col"></div>
                                        {{-- <div class="col-md-1 text-end mt-2"><i class="fa-solid fa-user-large text-primary"></i></div> --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="wrap-input100 validate-input" data-validate = "กรุณาใส่ Username">
                                                    <input type="text" class="form-control input100" name="username" id="username" placeholder="Username" required> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"></div>
                                        {{-- <div class="col-md-1 text-end mt-2"><i class="fa-solid fa-key text-danger"></i></div> --}}
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="wrap-input100 validate-input" data-validate = "กรุณาใส่ Password">
                                                    <input type="password" class="form-control input100" name="password" id="password" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"></div>
                                        {{-- <div class="col-md-1 text-end"></div> --}}
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <button type="submit" class="login100-form-btn">
                                                    <i class="fa-solid fa-fingerprint me-3"></i>
                                                    Login
                                                </button>
                                              </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="text-center p-t-12">
                                        <span class="txt1">
                                            Forgot
                                        </span>
                                        <a class="txt2" href="#">
                                            Username / Password?
                                        </a>
                                    </div>
                                    <div class="text-center p-t-20">
                                        <a class="txt2" href="#">
                                            Create your Account
                                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                        </a>
                                    </div>

                                </div>   
                                <br> <br>
                                {{-- </div> --}}
                                        {{-- <span class="login100-form-title">
                                            <img src="{{ asset('images/logo_350.jpg') }}" width="120" height="120" alt="IMG"><br><br>
                                            เข้าสู่ระบบ
                                        </span> --}}
                    
                                        {{-- <div class="wrap-input100 validate-input" data-validate = "Username is required">
                                            <input class="input100" type="text" name="username" id="username" placeholder="Username">
                                            <span class="focus-input100"></span>
                                            <span class="symbol-input100">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </span>
                                        </div> --}}
                    
                                        {{-- <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                            <input class="input100" type="password" name="password" id="password" placeholder="Password">
                                            <span class="focus-input100"></span>
                                            <span class="symbol-input100">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </span>
                                        </div> --}}
                                        
                                        {{-- <div class="container-login100-form-btn">
                                            <button type="submit" class="login100-form-btn">
                                                Login
                                            </button>
                                        </div>
                     --}}
                                        {{-- <div class="text-center p-t-12">
                                            <span class="txt1">
                                                Forgot
                                            </span>
                                            <a class="txt2" href="#">
                                                Username / Password?
                                            </a>
                                        </div> --}}
                    
                                        {{-- <div class="text-center p-t-26">
                                            <a class="txt2" href="#">
                                                Create your Account
                                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    --}}



                                </form>     
                        </div>
                    

                    </div>         
            </div>
        </div>
    </div>



    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->

      <!--===============================================================================================-->	
	<script src="{{ asset('Login_v1/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('Login_v1/vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('Login_v1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

       
  
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('Login_v1/vendor/bootstrap/js/popper.js') }}"></script> --}}
    <script src="{{ asset('medical/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    {{-- <script src="{{ asset('medical/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}') }}"></script> --}}
    <script src="{{ asset('medical/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/php-email-form/validate.js') }}"></script> 
    <script src="{{ asset('medical/assets/js/main.js') }}"></script> 
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <!-- Required datatable js -->
   <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('Login_v1/vendor/select2/select2.min.js') }}"></script>
        <!--===============================================================================================-->
            <script src="{{ asset('Login_v1/vendor/tilt/tilt.jquery.min.js') }}"></script>
            <script >
                $('.js-tilt').tilt({
                    scale: 1.1
                })
            </script>
            <script src="{{ asset('Login_v1/js/main.js') }}"></script>
        <!--===============================================================================================-->
        {{-- <script>
            document.getElementById('autoplay').play();
            var auto = document.getElementById("autoplay");
            auto.play(); 
            let vid = document.getElementById("mySong");
            function enableAutoplay() { 
            vid.autoplay = true;
            vid.load();
            }
        </script> --}}
      <script>
        // audioElement.play();
        // document.querySelector('#music').play();
        var myaudio = document.querySelector('#mySong');
        var _overlay = document.querySelector('#overlay');
        // myaudio.play();
         _overlay.addEventListener('click', function(e) {
           myaudio.play();
           _overlay.remove();
         },false);  
       
         setTimeout(function(){
             _overlay.style.display = 'block';
         },1000);
          
        document.addEventListener('touchmove', function(e) {
          e.preventDefault();
        //  _overlay.style.display = 'block';
        }, false);
          
          
        </script>
    <script>
        
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
   
            $('#Sendmessage').on('submit',function(e){
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
                                window.location.reload();
                            }
                          })
                        }
                      }
                    });
            });   
            
            $('#Savedata').click(function() {
                    var patientpk_name = $('#patientpk_name').val();
                    var patientpk_email = $('#patientpk_email').val();
                    var patientpk_subject = $('#patientpk_subject').val();
                    var patientpk_message = $('#patientpk_message').val(); 
                alert(patientpk_name);
                    $.ajax({
                        url: "{{ route('Cus.contact_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            patientpk_name,patientpk_email,patientpk_subject,patientpk_message 
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ส่งข้อมูลสำเร็จ',
                                    text: "You Send data success",
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
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
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

 
