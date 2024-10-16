{{-- <!doctype html> --}}
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 
    <title>ธธธธ</title> 
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/menucir.css') }}" rel="stylesheet"> 
</head>
 
 <body>
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
                <a href="#"> 
                    <i class="fa-solid fa-fan"></i>
                </a>
            </li>
            <li style="--i: 4; --clr: #00b0fe">
                <a href="#"> 
                    <i class="fa-solid fa-fire-extinguisher"></i>
                </a>
            </li>
            <li style="--i: 5; --clr: #fea600">
                <a href="#"> 
                    <i class="fa-solid fa-video"></i>
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
     <script src="{{ asset('js/menucircle.js') }}"> </script>
</body>

</html>
