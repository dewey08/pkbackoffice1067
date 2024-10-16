@extends('layouts.admin_profile')

@section('title', 'PK-OFFICE || Profile')


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function addpre() {
            var prenew = document.getElementById("PRE_INSERT").value;
            // alert(prenew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('person/addpre') }}",
                method: "GET",
                data: {
                    prenew: prenew,
                    _token: _token
                },
                success: function(result) {
                    $('.show_pre').html(result);
                }
            })
        }

        function editpic(input) {
        var fileInput = document.getElementById('img');
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#edit_upload_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
            fileInput.value = '';
            return false;
        }
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
<br>
    <div class="container mt-5">
        <div class="row ">
            <div class="col-md-12">
                <div class="card card_prs_2b">
                    <div class="card-header ">
                        {{-- <div class="d-flex">
                            <div class=""> --}}
                        <label for="">แก้ไข Profile</label>
                        {{-- </div> --}}
                        {{-- <div class="ms-auto">

                            </div> --}}
                        {{-- </div> --}}
                    </div>
                    <div class="card-body">
                       
                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <span class="step-number">01</span>
                                        <span class="step-title ">ข้อมูลส่วนตัว</span>
                                    </a>
                                </li>
                              

                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number">03</span>
                                        <span class="step-title">รูปภาพ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number">04</span>
                                        <span class="step-title">Confirm Detail</span>
                                    </a>
                                </li>

                            </ul>

                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">

                                    <form action="{{ route('user.profile_update') }}" method="POST" id="update_profileForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input id="id" type="hidden" class="form-control" name="id"
                                        value="{{ $dataedits->id }}">

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="pname">คำนำหน้า :</label>
                                                    <select id="pname" name="pname"
                                                        class="form-control select2 show_pre" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach ($users_prefix as $pre)
                                                        @if ($dataedits->pname == $pre->prefix_id)
                                                            <option value="{{ $pre->prefix_id }}" selected>
                                                                {{ $pre->prefix_name }} </option>
                                                        @else
                                                            <option value="{{ $pre->prefix_id }}">{{ $pre->prefix_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="fname" style="color: red">ชื่อ :</label>
                                                    <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" value="{{$dataedits->fname }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="lname" style="color: red">นามสกุล :</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="lname" name="lname" value="{{ $dataedits->lname }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="cid" >บัตรประชาชน</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="cid" name="cid" value="{{ $dataedits->cid }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="username"  style="color: red">ชื่อผู้ใช้งาน</label>
                                                    <input type="text" class="form-control form-control-sm" id="username" name="username" value="{{ $dataedits->username }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="password"  style="color: red">Password</label>
                                                    <input type="password" class="form-control form-control-sm" id="password" name="password" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="line_token">Line Token</label>
                                                    <textarea id="line_token" name="line_token" class="form-control" rows="2">{{ $dataedits->line_token }}</textarea>
                                                </div>
                                            </div>
                                        </div>


                                </div>
                                
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6"> 
                                            @if ($dataedits->img == null)
                                                <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                    id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                    class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('storage/person/' . $dataedits->img) }}"
                                                    id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                    class="img-thumbnail">
                                            @endif
                                            <br>
                                            <div class="input-group mb-3 mt-3">

                                                <input type="file" class="form-control" id="img" name="img"
                                                onchange="editpic(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </div> 
                                        </div>
                                        <div class="col-lg-6">  
                                            <div class="form-group text-center mt-2"> <img src="{{ $dataedits->signature }}" alt="" height="150px" width="auto"> </div>
                                            <div id="signature-pad2" class="mt-2 text-center">
                                                    <div style="border:solid 1px teal;height:150px;width: auto">
                                                        <div id="note2" onmouseover="my_function2();" class="text-center">The
                                                            signature should be inside box</div>
                                                        <canvas id="the_canvas2" width="320px" height="150px"> </canvas>
                                                        </div>

                                                        <input type="hidden" id="signature2" name="signature2">
                                                        <button type="button" id="clear_btn2"
                                                            class="btn btn-secondary btn-sm mt-3 ms-3 me-3" data-action="clear2"><span
                                                                class="glyphicon glyphicon-remove"></span>
                                                            Clear</button>

                                                        <button type="button" id="save_btn2"
                                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png2"
                                                            onclick="create2()"><span class="glyphicon glyphicon-ok"></span>
                                                            Create
                                                        </button>
                                                    </div>  
                                            </div>
                                           
                                           
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-confirm-detail">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <div class="mb-4">
                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                </div>
                                                <div>
                                                    <h5>Confirm Detail</h5> 
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                        แก้ไขข้อมูล
                                                    </button>
                                                    <a href="{{ url('person/person_index') }}"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa-solid fa-xmark me-2"></i>
                                                        ยกเลิก
                                                    </a>
                                                    <p class="text-muted">ยืนยันการแก้ไขข้อมูลบุคลากร</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                            </ul>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>



@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script>
    <script>
        // เจ้าหน้าที่
        var wrapper = document.getElementById("signature-pad2");
        var clearButton2 = wrapper.querySelector("[data-action=clear2]");
        var savePNGButton2 = wrapper.querySelector("[data-action=save-png2]");
        var canvas2 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note2");
        var signaturePad2;

        signaturePad2 = new SignaturePad(canvas2, {
            minWidth: 1,
            maxWidth: 2,
            penColor: "rgb(15, 82, 191)"   // เพิ่มสีและขนาดเส้นลายเซนต์
        });
       
        clearButton2.addEventListener("click", function(event) {
            document.getElementById("note2").innerHTML = "The signature should be inside box";
            // signaturePad2.penColor = 'white'
            signaturePad2.clear();  // Clears the canvas
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
                var dataUrl = canvas.toDataURL();   // save image as PNG
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
        $(document).ready(function() {            
            $('#pname').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });   
        });

        $(document).ready(function(){
            $('#update_profileForm').on('submit',function(e){
                e.preventDefault();
                    //   alert('Person');
                var form = this;
                
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                    $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                    if (data.status == 0 ) {  
                    Swal.fire({
                    icon: 'error',
                    title: 'Username...!!',
                    text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                    }).then((result) => {
                    if (result.isConfirmed) {                  
                    
                    }
                    })   
                } else {                         
                    Swal.fire({
                    title: 'แก้ไขข้อมูลสำเร็จ',
                    text: "You Edit data success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177', 
                    confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                    if (result.isConfirmed) {                  
                    //   window.location="{{route('person.person_index')}}"; //
                        window.location
                                        .reload();
                    }
                    })      
                }
                    }
                });
            }); 
        });
    </script>

@endsection


{{-- const canvas = document.querySelector("canvas");

const signaturePad = new SignaturePad(canvas);

// Returns signature image as data URL (see https://mdn.io/todataurl for the list of possible parameters)
signaturePad.toDataURL(); // save image as PNG
signaturePad.toDataURL("image/jpeg"); // save image as JPEG
signaturePad.toDataURL("image/jpeg", 0.5); // save image as JPEG with 0.5 image quality
signaturePad.toDataURL("image/svg+xml"); // save image as SVG data url

// Return svg string without converting to base64
signaturePad.toSVG(); // "<svg...</svg>"
signaturePad.toSVG({includeBackgroundColor: true}); // add background color to svg output

// Draws signature image from data URL (mostly uses https://mdn.io/drawImage under-the-hood)
// NOTE: This method does not populate internal data structure that represents drawn signature. Thus, after using #fromDataURL, #toData won't work properly.
signaturePad.fromDataURL("data:image/png;base64,iVBORw0K...");

// Draws signature image from data URL and alters it with the given options
signaturePad.fromDataURL("data:image/png;base64,iVBORw0K...", { ratio: 1, width: 400, height: 200, xOffset: 100, yOffset: 50 });

// Returns signature image as an array of point groups
const data = signaturePad.toData();

// Draws signature image from an array of point groups
signaturePad.fromData(data);

// Draws signature image from an array of point groups, without clearing your existing image (clear defaults to true if not provided)
signaturePad.fromData(data, { clear: false });

// Clears the canvas
signaturePad.clear();

// Returns true if canvas is empty, otherwise returns false
signaturePad.isEmpty();

// Unbinds all event handlers
signaturePad.off();

// Rebinds all event handlers
signaturePad.on(); --}}