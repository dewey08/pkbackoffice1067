@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')
{{-- <link href="{{ asset('css/loading_1.css') }}" rel="stylesheet"> --}}
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
            border: 10px #ddd solid;
            border-top: 10px #1fdab1 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
    {{-- <style>
        body {
            margin: 0;
            padding: 0;
            background: #262626;
        }

        .ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            background: transparent;
            border: 3px solid #3c3c3c;
            border-radius: 50%;
            text-align: center;
            line-height: 150px;
            font-family: sans-serif;
            font-size: 20px;
            color: #fff000;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 0 0 10px #fff000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .ring:before {
            content: "";
            position: absolute;
            top: -3px;
            left: -3px;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top: 3px solid #fff000;
            border-right: 3px solid #fff000;
            border-radius: 50%;
            animation: animateC 2s linear infinite;
        }

        span {
            display: block;
            position: absolute;
            top: calc(50% - 2px);
            left: 50%;
            width: 50%;
            height: 4px;
            background: transparent;
            transform-origin: left;
            animation: animate 2s linear infinite;
        }

        span:before {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff000;
            top: -6px;
            right: -8px;
            box-shadow: 0 0 20px #fff000;
        }

        @keyframes animateC {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate {
            0% {
                transform: rotate(45deg);
            }

            100% {
                transform: rotate(405deg);
            }
        }
    </style> --}}

    <div class="tabs-animation">
        {{-- <div class="row text-center">
        <div class="ring">Loading
            <span></span>
          </div>
        </div> --}}
        <div class="row text-center">
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
        </div>

        <form action="{{ url('account_301_detail_date') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h5 class="card-title">Detail 1102050101.301</h5>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.301</p>
                </div>
                <div class="col"></div>
                {{-- <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control d-shadow" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control d-shadow" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
               
                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary d-shadow" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button>  
                    
                </div> 
            </div> --}}

            </div>
        </form>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c">
                    {{-- <div class="card-header">
                    รายละเอียด 1102050101.301
                        <div class="btn-actions-pane-right">

                        </div>
                    </div> --}}
                    <div class="card-body">
                        {{-- <h4 class="card-title" style="color:rgb(10, 151, 85)">รายละเอียด 1102050101.301</h4> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="4%">ลำดับ</th>
                                        <th class="text-center">vn</th>
                                        <th class="text-center">hn</th>
                                        <th class="text-center">cid</th>
                                        <th class="text-center">ptname</th>

                                        <th class="text-center" width="10%">vstdate</th>
                                        <th class="text-center" width="7%">pttype</th>
                                        <th class="text-center">income</th>
                                        <th class="text-center">rcpt_money</th>
                                        <th class="text-center">ลูกหนี้</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0;
                                    $total1 = 0;
                                    $total2 = 0;
                                    $total3 = 0;
                                    $total4 = 0;
                                    $total5 = 0;
                                    $total6 = 0;
                                    $total7 = 0;
                                    $total8 = 0;
                                    $total9 = 0; ?>
                                    @foreach ($datashow as $item)
                                        <?php $number++; ?>

                                        <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">
                                                {{ $number }}</td>
                                            <td class="text-center" width="7%">{{ $item->vn }}</td>
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>
                                            <td class="p-2">{{ $item->ptname }}</td>
                                            <td class="text-center" width="10%">{{ $item->vstdate }}</td>
                                            <td class="text-center" width="7%">{{ $item->pttype }}</td>
                                            <td class="text-end" style="color:rgb(6, 83, 170)" width="7%">
                                                {{ number_format($item->income, 2) }}</td>
                                            <td class="text-end" style="color:rgb(131, 6, 93)" width="7%">
                                                {{ number_format($item->rcpt_money, 2) }}</td>
                                            <td class="text-end" style="color:rgb(10, 117, 150)" width="7%">
                                                {{ number_format($item->debit_total, 2) }}</td>

                                            </td>
                                        </tr>
                                        <?php
                                        $total1 = $total1 + $item->income;
                                        $total2 = $total2 + $item->rcpt_money;
                                        $total3 = $total3 + $item->debit_total;
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="7" class="text-end" style="background-color: #ff9d9d"></td>
                                    <td class="text-end" style="background-color: #04346b;color:white">
                                        {{ number_format($total1, 2) }}</td>
                                    <td class="text-end" style="background-color: #8f0c63;color:white">
                                        {{ number_format($total2, 2) }}</td>
                                    <td class="text-end" style="background-color: #096894;color:white">
                                        {{ number_format($total3, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
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

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
