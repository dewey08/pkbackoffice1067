@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Report')
 
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
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>

       
        <div class="row"> 
            <div class="col-md-4"> 
                <h4 style="color:rgb(255, 255, 255)">รายการถังดับเพลิงที่เปลี่ยน</h4> 
            </div>
            <div class="col"></div>
           
        </div>
    </div>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">    
                        
                        {{-- <p class="mb-0"> --}}
                            {{-- <div class="table-responsive"> --}}
                                {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                    {{-- <table id="example" class="table table-striped table-bordered nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                        <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">
                                    {{-- <table class="table table-striped mb-0 table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                                {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="8%">วันที่เปลี่ยน</th>  
                                            <th class="text-center" width="10%">รหัสถังที่ชำรุด</th>  
                                            <th class="text-center" width="10%">รหัสที่นำมาเปลี่ยน</th>
                                            <th class="text-center" width="5%">ขนาด</th> 
                                            <th class="text-center" width="5%">สี</th>  
                                            <th class="text-center">สถานที่ตั้ง</th>  
                                            <th class="text-center">อาคาร</th> 
                                            <th class="text-center" width="10%">ผู้เปลี่ยน</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datafire as $item) 
                                            <tr id="tr_{{$item->fire_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                <td class="text-center" width="8%" style="font-size: 12px">{{ Datethai($item->fire_chang_date) }}</td> 
                                                <td class="text-center" width="10%" style="font-size: 12px">{{ $item->fire_num }}</td>  
                                                <td class="text-center" width="10%" style="font-size: 12px"> {{ $item->chang }}</td>  
                                                <td class="text-center" width="5%" style="font-size: 12px"> {{ $item->fire_size }}</td>  
                                                <td class="text-center" width="5%" style="font-size: 12px"> {{ $item->fire_color }}</td>  
                                                <td class="text-center" style="font-size: 12px"> {{ $item->fire_location }}</td>  
                                                <td class="text-center" style="font-size: 12px"> {{ $item->building_name }}</td>  
                                                <td class="text-center" width="10%">{{ $item->ptname }}</td>                                              
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- </div> --}}
                        {{-- </p> --}}
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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            });             
            $('#Process').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                        text: "You Want Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Want Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(200);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('tec.cctv_report_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลข้อมูลสำเร็จ',
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
                                                            $("#overlay").fadeOut(200);
                                                        },400);
                                                }
                                            })
                                        } else if (data.status == 100) {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                                });
                                                Toast.fire({
                                                icon: "error",
                                                title: "กรุณาเลือกวันที่"
                                                });
                                                $('#spinner').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(200);
                                                    },400);
                                        } else {
                                             
                                        }
                                    },
                                });
                                
                            }
                })
        });
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
         
            
        });
    </script>
    @endsection
