@extends('layouts.support_prs_new')
@section('title', 'PK-OFFICE || Support-System')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
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
    
    ?>

 
    {{-- <div class="tabs-animation"> --}}
        {{-- <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div> --}}
        <div id="preloader">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="2.5" 
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>
       
        <ul class="menu">
            <div class="menuToggle">
                <i class="fa-solid fa-plus"></i>
            </div>
            <li style="--i: 0; --clr: #ff2971">
                <a href="#"> 
                    <i class="fa-solid fa-house-chimney-user"></i>
                </a>
            </li>
            <li style="--i: 1; --clr: #fee800">
                <a href="#">  
                    <i class="fa-solid fa-envelope-open-text"></i>
                </a>
            </li>
            <li style="--i: 2; --clr: #04fc43">
                <a href="#">  
                    <i class="fa-solid fa-user-gear"></i>
                </a>
            </li>
            <li style="--i: 3; --clr: #fe00f1">
                <a href="{{url('support_system_dashboard')}}"> 
                    <i class="fa-solid fa-fan"></i> 
                    <p style="font-size: 13px">เครื่องปรับอากาศ</p>
                </a>
               
            </li>
            <li style="--i: 4; --clr: #00b0fe">
                <a href="#"> 
                    <i class="fa-solid fa-fire-extinguisher"></i>
                    <p style="font-size: 13px">ถังดับเพลิง</p>
                </a>
            </li>
            <li style="--i: 5; --clr: #fea600">
                <a href="#"> 
                    <i class="fa-solid fa-video"></i>
                    <p style="font-size: 13px">กล้องวงจรปิด</p>
                </a>
            </li>
            <li style="--i: 6; --clr: #a529ff">
                <a href="#"> 
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                </a>
            </li>
            <li style="--i: 7; --clr: #01bdab">
                <a href="#"> 
                    <i class="fa-solid fa-desktop"></i>
                </a>
            </li> 
            
        </ul>

        
 
 
@endsection
@section('footer')
  

@endsection

