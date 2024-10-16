@extends('layouts.mobile')
@section('title', 'PK-OFFICE || Air-Service')

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
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
        }

        .cardfire {
            border-radius: 1em 1em 1em 1em;
            box-shadow: 0 0 15px pink;
            border: solid 1px #80acfd;
            /* box-shadow: 0 0 10px rgb(232, 187, 243); */
        }
    </style>
    <?php
    
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
        
    ?>



    <div class="container-fluid mt-3">
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
        <div class="row text-center">
            <div class="col"></div>
            <div class="col-md-6 text-center">
                <h2>ทะเบียนเครื่องปรับอากาศ</h2>
            </div>
            <div class="col"></div>
            
        </div>

        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card cardfire">
                    <div class="card-body">
 
                                        <div class="row">
                                            <div class="col text-start">
                                                @if ($data_detail_->air_imgname == null)
                                                    <img src="{{ asset('assets/images/defailt_img.jpg') }}" height="190px" width="220px"
                                                        alt="Image" class="img-thumbnail">
                                                @else
                                                    <img src="{{ asset('storage/air/' . $data_detail_->air_imgname) }}" height="170px"
                                                        width="220px" alt="Image" class="img-thumbnail">
                                                @endif
                                            </div>
                                            <div class="col-7">
                                                <p>รหัส : {{ $data_detail_->air_list_num }}</p>
                                                <p>ชื่อ : {{ $data_detail_->air_list_name }}</p>
                                                <p>Btu : {{ $data_detail_->btu }}</p>
                                                <p>serial_no : {{ $data_detail_->serial_no }}</p>
                                            
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-start"> <p>ที่ตั้ง : {{ $data_detail_->air_location_name }}</p> </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-start"> <p>หน่วยงาน : {{ $data_detail_->detail }}</p> </div>
                                        </div>   
                                        <div class="row justify-content-center mt-3">
                                            {{-- <div class="col"></div> --}}
                                            {{-- <div class="col-4">  --}}
                                                {{-- <div class="card" style="width: auto;height: 100px;"> --}}
                                                    {{-- <div class="row"> --}}
                                                        <div class="col-6 text-center">
                                                            <a href="http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/air_detail/{{$data_detail_->air_list_num}}" class="ladda-button me-2 btn-pill btn btn-primary cardfire">
                                                                <i class="fa-regular fa-square-check me-2"></i>เพื่อตรวจสอบ
                                                                {{-- <h5 style="color: white">เพื่อตรวจสอบ</h5> --}}
                                                            </a> 
                                                        </div> 
                                                    {{-- </div> --}}
                                                {{-- </div> --}}  
                                            {{-- </div> --}}
                                                        <div class="col-6 text-center"> 
                                                {{-- <div class="card" style="width: auto;height: 100px;"> --}}
                                                    {{-- <div class="row"> --}}
                                                        {{-- <div class="col text-center"> --}}
                                                            <a href="{{url('air_repaire_add/'.$id)}}" class="ladda-button me-2 btn-pill btn btn-info cardfire">
                                                                <i class="fa-regular fa-floppy-disk me-2"></i>ลงบันทึกซ่อม
                                                                {{-- <h5 style="color: white">บันทึกซ่อม</h5> --}} 
                                                            </a> 
                                                        {{-- </div>  --}}
                                                    {{-- </div> --}}
                                                {{-- </div> --}}
                                                        </div>
                                            {{-- <div class="col"></div> --}}
                                        </div> 

                                        <div class="row justify-content-center mt-3 mb-4">
                                            {{-- <div class="col-6">   --}}
                                                    {{-- <div class="row"> --}}
                                                        <div class="col-6 text-center">
                                                            {{-- <a href="http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/air_edit/{{$data_detail_->air_list_id}}" class="ladda-button btn-pill btn btn-warning cardfire mt-3 mb-2 ms-2 me-2"> --}}
                                                            <a href="http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/air_edit_mobile/{{$data_detail_->air_list_id}}" class="ladda-button me-2 btn-pill btn btn-warning cardfire">
                                                                {{-- <a href="#" class="ladda-button me-2 btn-pill btn btn-warning cardfire"> --}}
                                                                <i class="fa-regular fa-pen-to-square me-2"></i>
                                                               แก้ไขข้อมูล 
                                                                
                                                                {{-- <h6 style="color: white">แก้ไขข้อมูล</h6> --}}
                                                            </a> 
                                                        </div> 
                                                    {{-- </div>  --}}
                                            {{-- </div> --}}
                                                        <div class="col-6 text-center">  
                                                    {{-- <div class="row justify-content-center"> --}}
                                                        {{-- <div class="col text-center"> --}}
                                                            {{-- <a href="{{url('air_repaire_add/'.$id)}}" class="ladda-button btn-pill btn btn-secondary cardfire mt-3 mb-2 ms-3 me-3"> --}}
                                                            <a href="#" class="ladda-button me-2 btn-pill btn btn-secondary cardfire">
                                                                <i class="fa-solid fa-screwdriver-wrench me-2"></i>แจ้งซ่อม
                                                                {{-- <h5 style="color: white">แจ้งซ่อม</h5> --}}
                                                            </a> 
                                                        {{-- </div>  --}}
                                                    {{-- </div>  --}}
                                                        </div>
                                        </div> 
                                        
                                      
                                        <input type="hidden" name="air_list_id" id="air_list_id" value="{{ $data_detail_->air_list_id}}">
                                        <input type="hidden" name="air_list_num" id="air_list_num" value="{{ $data_detail_->air_list_num}}">
                                        <input type="hidden" name="air_list_name" id="air_list_name" value="{{ $data_detail_->air_list_name}}">
                                        <input type="hidden" name="btu" id="btu" value="{{ $data_detail_->btu}}">
                                        <input type="hidden" name="serial_no" id="serial_no" value="{{ $data_detail_->serial_no}}">
                                        <input type="hidden" name="air_location_id" id="air_location_id" value="{{ $data_detail_->air_location_id}}">
                                        <input type="hidden" name="air_location_name" id="air_location_name" value="{{ $data_detail_->air_location_name}}">
                                        <input type="hidden" name="detail" id="detail" value="{{ $data_detail_->detail}}">
                                     
                       

 
                    </div>
                </div>

            </div>
        </div>


    </div>

@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });
    </script>
    <script>
        //ช่างซ่อมนอก
        var wrapper = document.getElementById("signature-pad");
        var clearButton = wrapper.querySelector("[data-action=clear]");
        var savePNGButton = wrapper.querySelector("[data-action=save-png]");
        var canvas = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note");
        var signaturePad;
        signaturePad = new SignaturePad(canvas);
        clearButton.addEventListener("click", function(event) {
            document.getElementById("note").innerHTML = "The signature should be inside box";
            signaturePad.clear();
        });
        savePNGButton.addEventListener("click", function(event) {
            if (signaturePad.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function() {
            document.getElementById("note").innerHTML = "";
        }

        // เจ้าหน้าที่
        var wrapper = document.getElementById("signature-pad2");
        var clearButton2 = wrapper.querySelector("[data-action=clear2]");
        var savePNGButton2 = wrapper.querySelector("[data-action=save-png2]");
        var canvas2 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note2");
        var signaturePad2;
        signaturePad2 = new SignaturePad(canvas2);
        clearButton2.addEventListener("click", function(event) {
            document.getElementById("note2").innerHTML = "The signature should be inside box";
            signaturePad2.clear();
        });
        savePNGButton2.addEventListener("click", function(event) {
            if (signaturePad2.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas2");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature2").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function2() {
            document.getElementById("note2").innerHTML = "";
        }

        // ช่างซ่อมใน รพ 
        var wrapper = document.getElementById("signature-pad3");
        var clearButton3 = wrapper.querySelector("[data-action=clear3]");
        var savePNGButton3 = wrapper.querySelector("[data-action=save-png3]");
        var canvas3 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note3");
        var signaturePad3;
        signaturePad3 = new SignaturePad(canvas3);
        clearButton3.addEventListener("click", function(event) {
            document.getElementById("note3").innerHTML = "The signature should be inside box";
            signaturePad3.clear();
        });
        savePNGButton3.addEventListener("click", function(event) {
            if (signaturePad3.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas3");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature3").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function3() {
            document.getElementById("note3").innerHTML = "";
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#saveBtn').click(function() {
                // alert('okkkkk'); 
                var air_problems_1     = $('#air_problems_1').val();
                var air_problems_2     = $('#air_problems_2').val();
                var air_problems_3     = $('#air_problems_3').val();
                var air_problems_4     = $('#air_problems_4').val();
                var air_problems_5     = $('#air_problems_5').val();
                var air_problems_6     = $('#air_problems_6').val();
                var air_problems_7     = $('#air_problems_7').val();
                var air_problems_8     = $('#air_problems_8').val();
                var air_problems_9     = $('#air_problems_9').val();
                var air_problems_10    = $('#air_problems_10').val();
                var air_problems_11    = $('#air_problems_11').val();
                var air_problems_12    = $('#air_problems_12').val();
                var air_problems_13    = $('#air_problems_13').val();
                var air_problems_14    = $('#air_problems_14').val();
                var air_problems_15    = $('#air_problems_15').val();
                var air_problems_16    = $('#air_problems_16').val();
                var air_problems_17    = $('#air_problems_17').val();
                var air_problems_18    = $('#air_problems_18').val();
                var air_problems_19    = $('#air_problems_19').val();
                var air_problems_20    = $('#air_problems_20').val();
                var air_status_techout = $('#air_status_techout').val();
                var air_techout_name   = $('#air_techout_name').val();
                var air_status_staff   = $('#air_status_staff').val();
                var air_staff_id       = $('#air_staff_id').val();
                var air_status_tech    = $('#air_status_tech').val();
                var air_tech_id        = $('#air_tech_id').val(); 
                var signature          = $('#signature').val(); //ช่างนอก
                var signature2         = $('#signature2').val(); //เจ้าหน้าที่
                var signature3         = $('#signature3').val(); //ช่าง รพ
                var air_list_id        = $('#air_list_id').val();
                var air_list_num       = $('#air_list_num').val();
                var air_list_name      = $('#air_list_name').val();
                var btu                = $('#btu').val();
                var serial_no          = $('#serial_no').val();
                var air_location_id    = $('#air_location_id').val();
                var air_location_name  = $('#air_location_name').val();
                var air_repaire_no     = $('#air_repaire_no').val();
                var air_problems_orther     = $('#air_problems_orther').val();
                var air_problems_orthersub  = $('#air_problems_orthersub').val();
                var air_num            = $('#air_num').val();
                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Save Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 

                                $.ajax({ 
                                    url: "{{ route('prs.air_repiare_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                       air_problems_1,air_problems_2,air_problems_3,air_problems_4,air_problems_5,air_problems_6,air_problems_7,air_problems_8
                                        ,air_problems_9,air_problems_10,air_problems_11,air_problems_12,air_problems_13,air_problems_14,air_problems_15,air_problems_16
                                        ,air_problems_17,air_problems_18,air_problems_19,air_problems_20,air_status_techout,air_techout_name,air_status_staff,air_staff_id
                                        ,air_status_tech,air_tech_id,signature,signature2,signature3,air_list_id,air_list_num,air_list_name,btu,serial_no,air_location_id,air_location_name,air_repaire_no,air_problems_orther,air_problems_orthersub,air_num
                                    },
                                    success: function(data) {
                                        if (data.status == 0) {

                                        } else if (data.status == 50) {
                                            Swal.fire(
                                                'กรุณาลงลายชื่อช่างภายนอก !',
                                                'You clicked the button !',
                                                'warning'
                                            )
                                        } else if (data.status == 60) {
                                            Swal.fire(
                                                'กรุณาลงลายชื่อเจ้าหน้าที่ !',
                                                'You clicked the button !',
                                                'warning'
                                            )
                                        } else if (data.status == 70) {
                                            Swal.fire(
                                                'กรุณาลงลายชื่อช่าง รพ !',
                                                'You clicked the button !',
                                                'warning'
                                            )
                                        } else {
                                            Swal.fire({
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Insert data success",
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
                                        }
                                    },
                                });
                        }
                }) 
            });

            $('#update_Form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) { 

                        if (data.status == 0) {

                        } else if (data.status == 50) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่างภายนอก !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 60) {
                            Swal.fire(
                                'กรุณาลงลายชื่อเจ้าหน้าที่ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 70) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่าง รพ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
                            Swal.fire({
                                position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    // window.location.reload();
                                    window.location = "{{ url('home_supplies') }}";
                                    $('#spinner')
                                .hide(); //Request is complete so hide spinner
                                    setTimeout(function() {
                                        $("#overlay").fadeOut(300);
                                    }, 500);
                                }
                            })
                        }
                    }
                });
            });

        });
    </script>
@endsection
