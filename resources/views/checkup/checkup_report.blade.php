@extends('layouts.checkup')
@section('title', 'PK-OFFICE || ระบบตรวจสุขภาพ')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
            border-top: 10px rgb(250, 128, 124) solid;
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
    <?php
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    
    
    $refnumber = SuppliesController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    
    ?>



    <div class="tabs-animation">

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

        <div class="row ">
            <div class="col-md-12">
                <div class="card card_prs_4" >
    
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="">
                                <label for=""style="font-size: 15px">ข้อมูลคนไข้</label>
                            </div>
                            <div class="ms-auto">    
                            </div>
                        </div>
                    </div>                  
    
                    <div class="card-body shadow-lg">
                        
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <div class="row">
    
                                <div class="col-md-12">
                                    
                                    <div class="row text-center">

                                        <div class="row mt-2">
                                            <div class="col-md-1 text-end">
                                                <label for="chackup_date" style="font-size: 15px">วันที่ :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                        <input type="text" class="form-control input_new" name="datepicker" id="datepicker" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                                        data-date-language="th-th" value="{{ $date_now }}"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 text-end">
                                                <label for="chackup_hn" style="font-size: 15px">HN :</label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">                                                
                                                    <input type="text" class="form-control" id="chackup_hn" name="chackup_hn">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary btn-sm Getchackup_hn">
                                                    <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                    ค้นหา
                                                </button>
                                            </div>
                                            {{-- onclick="Getchackup_hn()" --}}

                                        </div>  
                                                                                                                  
                                    </div>
                                </div>
                            </div>
                    </div> 
    
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-md-12">
                <div class="card card_prs_4" >
    
                    <div class="card-body shadow-lg">
                        
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                           
                            <div id="show_detailpatient">  </div>

                            {{-- <div class="row"> --}}
    
                                {{-- <div class="col-md-12"> --}}
                                    
                                {{-- <div class="row text-center">

                                            <div class="col-md-1 text-end">
                                                <label for="chackup_hn" style="font-size: 15px">HN :</label>
                                            </div>
                                            <div class="col-md-5">
                                       
                                                   
                                                 <div id="show_detailpatient">

                                                 </div>
                                                 
                                                </div>
                                            </div>  --}}

                                            {{-- <div class="col-md-1 text-end">
                                                <label for="chackup_name" style="font-size: 15px">ชื่อผู้ป่วย :</label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="chackup_name"></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1 text-end">
                                                <label for="chackup_sex" style="font-size: 15px">เพศ :</label>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="chackup_sex"></label>
                                                </div>
                                            </div>

                                            <div class="col-md-1 text-end">
                                                <label for="chackup_age_y" style="font-size: 15px">อายุ :</label>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="chackup_age_y"></label>
                                                </div>
                                            </div>

                                            <div class="col-md-1 text-end">
                                                <label for="chackup_age_y" style="font-size: 15px">เลขบัตรประชาชน :</label>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="chackup_age_y"></label>
                                                </div>
                                            </div> --}}

                                        {{-- </div>   --}}
                                                                                                                  
                                    {{-- </div> --}}

                                    {{-- <div class="row text-center">

                                        <div class="col-md-1 text-end">
                                            <label for="chackup_bw" style="font-size: 15px">น้ำหนัก :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_bw"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 text-end">
                                            <label for="chackup_height" style="font-size: 15px">ส่วนสูง :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_height"></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-1 text-end">
                                            <label for="chackup_waist" style="font-size: 15px">เส้นรอบเอว :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_waist"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 text-end">
                                            <label for="chackup_temperature" style="font-size: 15px">อุณหภูมิ :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_temperature"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 text-end">
                                            <label for="chackup_rr" style="font-size: 15px">อัตราการหายใจ :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_rr"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 text-end">
                                            <label for="chackup_pulse" style="font-size: 15px">ชีพจร :</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="chackup_pulse"></label>
                                            </div>
                                        </div>

                                    </div>   --}}
                                                                                                              
                                {{-- </div> --}}

                                    
                                {{-- </div> --}}
                            </div>
                    </div>     
    
                </div>
            </div>
        </div>

    </div>


@endsection
@section('footer')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script> --}}
    <script>
        // function Getchackup_hn() {

        // // alert('ใส่ข้อความที่ต้องการ');
        //     var chackup_hn = document.getElementById("chackup_hn").value;
        //         var datepicker = document.getElementById("datepicker").value;
        //         alert(datepicker);

        //         var _token = $('input[name="_token"]').val();
        //         $.ajax({
        //             url: "{{url('checkup_report_detail')}}",
        //             method: "GET",
        //             data: {
        //                 chackup_hn: chackup_hn, datepicker: datepicker,
        //                 _token: _token
        //             },
        //             success: function (data) {
        //                 console.log(data.data_show2.hn);
        //                 $('#hn_').val(data.data_show2.hn)
        //                 // $('#show_detailpatient').html(result);
        //             }
        //         })
        // }

        var Linechart;
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
 

        });
        $(document).on('click', '.Getchackup_hn', function() {
                // var chackup_hn = $(this).val();
                // var datepicker = $(this).val();
                     var chackup_hn = document.getElementById("chackup_hn").value;
                var datepicker = document.getElementById("datepicker").value;
                // $('#addicodeModal').modal('show');
                // alert(chackup_hn);
                $.ajax({
                    type: "GET",
                    url: "{{ url('checkup_report_detail') }}" + '/' + chackup_hn + '/' + datepicker,
                    success: function(data) {
                        $('#show_detailpatient').html(data);
                        // if (data.status == 200) {
                        //     alert(data.data_shows.hn);
                        //     $('#HN_NEW').val(data.data_shows.hn)
                        //     $('#hn_').val(data.data_shows.hn)
                        // } else {
                            
                        // }
                        // console.log(data.data_show2.hn);
                        // $('#HN_NEW').val(data.data_show2.hn)
                        // $('#hn_').val(data.data_show2.hn)
                        // $('#vn').val(data.data_pang.vn)
                        // $('#an').val(data.data_pang.an)
                        // $('#hn').val(data.data_pang.hn)
                        // $('#cid').val(data.data_pang.cid)
                        // $('#vstdate').val(data.data_pang.vstdate)
                        // $('#dchdate').val(data.data_pang.dchdate)
                        // $('#ptname').val(data.data_pang.ptname)
                        // $('#debit_total').val(data.data_pang.debit_total)
                        // $('#pttype').val(data.data_pang.pttype)
                        // $('#acc_debtor_id').val(data.data_pang.acc_debtor_id)

                        // $('#account_code_new').val(data.data_pang.account_code)
                        // $('#pttype_new').val(data.data_pang.pttype)
                        // $('#debit_total_new').val(data.data_pang.debit_total)
                    },
                });
            });

    </script>


@endsection
