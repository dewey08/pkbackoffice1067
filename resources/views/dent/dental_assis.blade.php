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
    {{-- <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div> --}}
    <form action="{{ url('dental_assis/'.$id) }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-4">
            
                <h4 style="color:rgb(206, 29, 147)">ค่าภาระงาน ทันตแพทย์</h4> 
            </div>
            <div class="col"></div>
            {{-- <input type="hidden" name="iduser" id="iduser" value="{{$id}}"> --}}
            <div class="col-md-4 text-end">
                          
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bg_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{$startdate}}" required/>
                    <input type="text" class="form-control bg_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{$enddate}}"/>  
                      
                        <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs"> 
                            <i class="fa-solid fa-magnifying-glass me-2"></i> ค้นหา
                        </button>
                        <button type="button" class="ladda-button btn-pill btn btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> 
                            <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                        </button>
                        
                </div> 
        
        </div>
            {{-- <div class="col-md-2 text-end">
            
                <a href="{{url('')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs"> 
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                เพิ่มรายการ
                </a>  

                <button type="button" class="ladda-button btn-pill btn btn-sm btn-secondary bt_prs me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> 
                    <i class="fa-solid fa-book-open-reader text-white me-2"></i>คู่มือ 
                </button>
            
            </div> --}}
        </div> 

    </form>
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_prs_4" style="background-color: #f8e7f8">
                    <div class="card-body">    
                        <div class="row mb-3">
                           
                            <div class="col"></div>
                            
                        </div>
        
                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;"> --}}
                                {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;"> --}}
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
                            </div>
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
