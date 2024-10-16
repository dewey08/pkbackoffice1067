@extends('layouts.support_prs_water')
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

    {{-- <style>
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
    </style> --}}

    <div class="tabs-animation">
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
                                    <span class="d-inline-block"><h3>ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ Dashboard</h3></span>
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
                                                Inspection and maintenance Dashboard
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
           

                <div class="row">
                    <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                               
                                    <div class="card" style="height: 125px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">เครื่องผลิตน้ำดื่ม</p>
                                                    <h2 class="mb-2">00 </h2> 
                                                </div>
                                                <div class="avatar-sm" style="width: 70px;height:60px">
                                                    <span class="avatar-title bg-light text-primary rounded-3"> 
                                                        <img src="{{ asset('images/water_glass.png') }}" height="50px" width="50px" class="text-danger">  
                                                    </span>
                                                </div>
                                            </div>  
                                            <div class="d-flex align-content-center flex-wrap">
                                                <p class="text-muted mb-0">
                                                    <span class="text-success fw-bold font-size-20 me-2">
                                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>พร้อมใช้งาน 00
                                                    </span>
                                                    {{-- from previous period --}}
                                                </p>
                                            </div>                                           
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                     
                                    <div class="card" style="height: 125px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">เครื่องผลิตน้ำดื่ม</p>
                                                    <h2 class="mb-2">00 </h2> 
                                                </div>
                                                <div class="avatar-sm" style="width: 70px;height:60px">
                                                    <span class="avatar-title bg-light text-primary rounded-3"> 
                                                        <img src="{{ asset('images/water_glass.png') }}" height="50px" width="50px" class="text-danger"> 
                                                    </span>
                                                </div>
                                            </div>  
                                            <div class="d-flex align-content-center flex-wrap">
                                                <p class="text-muted mb-0">
                                                    <span class="text-success fw-bold font-size-20 me-2">
                                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>พร้อมใช้งาน 00
                                                    </span>
                                                    {{-- from previous period --}}
                                                </p>
                                            </div>                                           
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  
                                    <div class="card" style="height: 125px">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">เครื่องผลิตน้ำดื่ม</p>
                                                    <h2 class="mb-2">00 </h2> 
                                                </div>
                                                <div class="avatar-sm" style="width: 70px;height:60px">
                                                    <span class="avatar-title bg-light text-primary rounded-3"> 
                                                        <img src="{{ asset('images/water_glass.png') }}" height="50px" width="50px" class="text-danger">  
                                                    </span>
                                                </div>
                                            </div>  
                                            <div class="d-flex align-content-center flex-wrap">
                                                <p class="text-muted mb-0">
                                                    <span class="text-success fw-bold font-size-20 me-2">
                                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>พร้อมใช้งาน 00
                                                    </span>
                                                    {{-- from previous period --}}
                                                </p>
                                            </div>                                           
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        
                      
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                   
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-sm text-capitalize fw-normal">เครื่องผลิตน้ำดื่ม Check ไปแล้วคิดเป็น( % ) ของทั้งหมดในเดือนนี้
                                        </div>
                                       
                                    </div>
                                    <div class="p-0 card-body">
                                        <div id="radials"></div>
        
                                        <div class="widget-content pt-0 w-100">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left pe-2 fsize-1">
                                                        <div class="widget-numbers mt-0 fsize-3 text-danger ms-3">00 ถัง</div> 
                                                    </div>
                                                    <div class="widget-content-right w-100">
                                                        <div class="progress-bar-xs progress ms-3 me-3">
                                                            {{-- <div class="progress-bar bg-danger" role="progressbar"
                                                                aria-valuenow="{{$count_color_red_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{$count_red_percent}}%;">
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left fsize-1 ms-3">
                                                    <div class="text-muted opacity-6">Check Qty</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-sm text-capitalize fw-normal">เครื่องผลิตน้ำดื่ม Check ไปแล้วคิดเป็น( % ) ของทั้งหมดในเดือนนี้
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                           
                                        </div>
                                    </div>
                                    <div class="p-0 card-body">
                                        <div id="radials_green"></div>
                                        <div class="widget-content pt-0 w-100">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left pe-2 fsize-1">
                                                        <div class="widget-numbers mt-0 fsize-3 text-success ms-3">00 ถัง</div>
                                                    </div>
                                                    <div class="widget-content-right w-100">
                                                        <div class="progress-bar-xs progress ms-3 me-3">
                                                            {{-- <div class="progress-bar bg-success" role="progressbar"
                                                                aria-valuenow="{{$count_color_green_qty}}" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{$count_green_percent}}%;">
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left fsize-1 ms-3">
                                                    <div class="text-muted opacity-6">Check Qty</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example2').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });

            var xmlhttp = new XMLHttpRequest();
            var url = "{{ url('support_dashboard_chart') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas); 
                    
                    count_red = datas.Dataset1.map(function(e) {
                        return e.count_red;
                    });
                    count_color_red_qty = datas.Dataset1.map(function(e) {
                        return e.count_color_red_qty;
                    });
                    count_red_all= datas.Dataset1.map(function(e) {
                        return e.count_red_all;
                    });
                    console.log(count_red_all); 

                    count_green = datas.Dataset1.map(function(e) {
                        return e.count_green;
                    });
                    count_green_percent= datas.Dataset1.map(function(e) {
                        return e.count_green_percent;
                    });
                      
                            // Radial 
                            var options_red = {
                                series: count_red,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#f80707'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials"), options_red);
                            chart.render();

                            // // **************************************

                            var options_green = {
                                series: count_green_percent,
                                chart: {
                                    height: 350,
                                    type: 'radialBar',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 225,
                                        hollow: {
                                            margin: 0,
                                            size: '70%',
                                            background: '#fff',
                                            image: undefined,
                                            imageOffsetX: 0,
                                            imageOffsetY: 0,
                                            position: 'front',
                                            dropShadow: {
                                                enabled: true,
                                                top: 3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.24
                                            }
                                        },
                                        track: {
                                            background: '#fff',
                                            strokeWidth: '67%',
                                            margin: 0, // margin is in pixels
                                            dropShadow: {
                                                enabled: true,
                                                top: -3,
                                                left: 0,
                                                blur: 4,
                                                opacity: 0.35
                                            }
                                        },

                                        dataLabels: {
                                            show: true,
                                            name: {
                                                offsetY: -20,
                                                show: true,
                                                color: '#888',
                                                fontSize: '17px'
                                            },
                                            value: {
                                                formatter: function(val) {
                                                    return parseInt(val);
                                                },
                                                color: '#111',
                                                fontSize: '50px',
                                                show: true,
                                            }
                                        }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'dark',
                                        type: 'horizontal',
                                        shadeIntensity: 0.5,
                                        gradientToColors: ['#ABE5A1'],
                                        inverseColors: true,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 100]
                                    }
                                },
                                stroke: {
                                    lineCap: 'round'
                                },
                                labels: ['Percent'],
                            };
                            var chart = new ApexCharts(document.querySelector("#radials_green"), options_green);
                            chart.render();

                }
             }

             $("#spinner-div").hide(); //Request is complete so hide spinner
         
            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate   = $('#datepicker2').val(); 
                Swal.fire({
                        position: "top-end",
                        title: 'ต้องการประมวลผลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('prs.support_system_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 2000) { 
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ประมวลผลสำเร็จ',
                                                text: "You Process data success",
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
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

        });

        $(document).on('click', '.aircountModal', function() {
            var air_location_id = $(this).val(); 
            $('#aircountModal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('support_detail') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail').html(result);
                },
            });
        });

        $(document).on('click', '.problems_1Modal', function() {
            var air_location_id = $(this).val(); 
            $('#problems_1Modal').modal('show');           
            $.ajax({
                type: "GET",
                url:"{{ url('detail_ploblem_1') }}",
                data: { air_location_id: air_location_id },
                success: function(result) { 
                    $('#detail_ploblem_1').html(result);
                },
            });
        });

        

    </script>

@endsection

