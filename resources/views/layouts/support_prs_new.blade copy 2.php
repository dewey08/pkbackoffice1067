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
  
    <link href="{{ asset('fontawesome652/css/all.min.css') }}">

</head>
 <style>
    {
        margin:0;
        padding:0;
        box-sizing:border-box;
    }
    body{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background: black; 
    }
    .menu{
        position:relative;
        width: 260px;
        height: 260px;
        display: flex;
        justify-content: center;
        align-items: center; 
    }
    /* .menu li{
        position: absolute;
        left: 0;
        list-style: none;
        transform-origin: 130px;
        transition: 0.5s;
        transition-delay: calc(0.1s * var(--i));
        transform: rotate(0deg)translateX(100px);
    } */
    /* .menu.active li{
        transform: rotate(calc(360deg / 8 * var(--i)));
    } */
    /* .menu li a{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60px;
        height: 60px;
        font-size: 1.5em;
        border-radius: 50%;
        transform: rotate(calc(360deg / -8 * var(--i)));
        color: transparent;
        transition: 1s;
        transition-delay: 0.5s;
    } */
    /* .menu.active li a{
        contain: "";
        position: absolute;
        width: 20px;
        height: 2px;
        border-radius: 40%;
        background: var(--clr);
        transform: lotate(calc(var(--i) * 90deg)) translate(0,25px);
        transition: height 0.5s,width 0.5s,transform 0.5s;
    } */
 </style>
 <body>
        <ul class="menu">
            <div class="Toggle">
                <i class="fa-solid fa-plus"></i>
            </div>
            <li style="--i:0;--clr:#ff2971">
                <a href=""> 
                    <i class="fa-solid fa-house-chimney-user"></i>
                </a>
            </li>
            <li style="--i:1;--clr:#fee800">
                <a href="">  
                    <i class="fa-solid fa-envelope-open-text"></i>
                </a>
            </li>
            <li style="--i:2;--clr:#04fc43">
                <a href="">  
                    <i class="fa-solid fa-user-gear"></i>
                </a>
            </li>
            <li style="--i:3;--clr:#fe00f1">
                <a href=""> 
                    <i class="fa-solid fa-fan"></i>
                </a>
            </li>
            <li style="--i:4;--clr:#00b0fe">
                <a href=""> 
                    <i class="fa-solid fa-fire-extinguisher"></i>
                </a>
            </li>
            <li style="--i:5;--clr:#fea600">
                <a href=""> 
                    <i class="fa-solid fa-video"></i>
                </a>
            </li>
            <li style="--i:6;--clr:#a529ff">
                <a href=""> 
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                </a>
            </li>
            <li style="--i:7;--clr:#01bdab">
                <a href=""> 
                    <i class="fa-solid fa-desktop"></i>
                </a>
            </li>
            
        </ul>
</body>

</html>
