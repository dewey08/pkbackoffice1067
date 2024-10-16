{{-- @extends('layouts.dentalnews') --}}
@extends('layouts.dentals')

@section('title', 'PK-OFFICE || ทันตกรรม')
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
    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;

    $refnumber = UsersuppliesController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    ?>

    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 250px;
            height: 250px;
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
<div class="tabs-animation">
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
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-head center-elem">
                                <span class="d-inline-block pe-2">
                                    <i class="lnr-apartment opacity-6" style="color:rgb(228, 8, 129)"></i>
                                </span>
                                <span class="d-inline-block"><h3 style="color:rgb(228, 8, 129)">DENTAL Dashboard</h3></span>
                            </div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a>
                                                <i aria-hidden="true" class="fa fa-home" style="color:rgb(252, 52, 162)"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a>Dashboards</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            dantal
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions"> 
                    </div>
                </div>
            </div>
        </div>
    </div>
   
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">    
                        <div class="row mb-3">
                           
                            <div class="col"></div>
                            
                        </div>
        
                        <p class="mb-0">
                            {{-- <div class="table-responsive">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                               
                                    <thead>
                                        <tr>
                                          
                                            <th width="3%" class="text-center">ลำดับ</th>   
                                            <th class="text-center" width="8%">vstdate</th>  
                                            <th class="text-center" >hn</th> 
                                            <th class="text-center">รายการ</th> 
                                            <th class="text-center" >ttcode</th>  
                                            <th class="text-center" >staff</th> 
                                            <th class="text-center" >dtcode</th>  
                                            <th class="text-center">dtname</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data_show as $item) 
                                            <tr id="tr_{{$item->hn}}">                                                  
                                                <td class="text-center" width="3%">{{ $i++ }}</td>   
                                                <td class="text-center" width="8%" style="font-size: 12px">{{ $item->vstdate }}</td>  
                                                <td class="text-center" width="5%" style="font-size: 12px">{{ $item->hn }}</td>  
                                                <td class="p-2">{{ $item->dmname }}</td>  
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ $item->ttcode }}</td>    
                                                <td class="p-2" width="7%">{{ $item->staff }}</td>  
                                                <td class="p-2" width="5%">{{ $item->dtcode }}</td> 
                                                <td class="text-center" width="10%">{{ $item->dtname }}</td>  
                                              
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                        </p>
                    </div>
                </div>
            </div>
        </div> 

 
       
    @endsection
    @section('footer')



<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    });
</script>


    @endsection
