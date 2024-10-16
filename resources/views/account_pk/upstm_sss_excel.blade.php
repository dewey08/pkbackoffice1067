@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')

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
            border: 10px #ddd solid;
            border-top: 10px #fd6812 solid;
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
        .bar{
            height: 50px;
            background-color: rgb(10, 218, 55);
        }
        .percent{
            position: absolute;
            left: 50%;
            color: black;
        }
    </style>

    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;
        $count_meettingroom = StaticController::count_meettingroom();
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

        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6">
                <div class="card card_audit_4c">
                    <div class="grid-menu-col">
                        <form method="POST" action="{{ route('acc.upstm_sss_excelsave') }}" id="Upstm" enctype="multipart/form-data"> 
                            @csrf
                            {{-- id="Upstm" --}}
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-md-8">
                                    <div class="mb-3 mt-3">
                                        <label for="file" class="form-label">UP STM SSS EXCEL => UP STM => ส่งข้อมูล</label>
                                        <input class="form-control form-control-lg" id="file_stm" name="file_stm" type="file" required>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                    @if ($countc > 0)
                                        <a href="{{ url('upstm_sss_excelsend') }}" class="ladda-button mb-3 me-2 btn-pill btn btn-primary cardacc">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                STM 304
                                        </a> 
                                        <a href="{{ url('upstm_sss_excelsend307') }}" class="ladda-button mb-3 me-2 btn-pill btn btn-warning cardacc">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                STM 307
                                        </a> 
                                        <a href="{{ url('upstm_sss_excelsend308') }}" class="ladda-button mb-3 me-2 btn-pill btn btn-info cardacc">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                STM 308
                                        </a> 
                                    @else
                                        <button type="submit" class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info cardacc">
                                            <i class="fa-solid fa-cloud-arrow-up me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="UP STM"></i>
                                            UP STM
                                        </button>
                                    @endif
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
              
                <div class="form-group">
                    <div class="progress" style="height: 50px;">
                       <div class="bar"></div>
                       <div class="percent" style="font-size: 30px">0%</div>
                       {{-- <div class="progress-bar progress-bar-striped progress-bar-animated bg-info percent" role="progressbar"
                       aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> </div> --}}
                    </div>
                </div> 

                <br> 
            </div>
            <div class="col"></div>

        </div>

        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6">
                <div class="card p-3 card_audit_4c">
                    <div class="grid-menu-col">

                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">stm</th>
                                    <th class="text-center">difference</th>
                                    <th class="text-center">stm_no</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>

                                    <tr height="20" style="font-size: 14px;color:rgb(235, 6, 6)">
                                        <td class="text-font" style="text-align: center;" width="5%" style="color:rgb(248, 12, 12)">{{ $number }}</td>
                                        <td class="text-center" style="color:rgb(248, 12, 12)"> {{ $item->vn }}</td>
                                        <td class="text-center" style="color:rgb(248, 12, 12)"> {{ $item->an }}</td>
                                        <td class="text-center" style="color:rgb(248, 12, 12)"> {{ $item->stm }}</td>
                                        <td class="text-center" style="color:rgb(248, 12, 12)"> {{ $item->difference }}</td>
                                        <td class="text-center" style="color:rgb(248, 12, 12)"> {{ $item->stm_no }}</td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col"></div>

        </div>
 
    </div>

@endsection
@section('footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

             $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            var bar = $('.bar');
            var percent = $('.percent');

            // $('form').ajaxForm({
            //     beforeSend: function() {
            //         var percentVal = '0%';
            //         bar.width(percentVal);
            //         percent.html(percentVal);
            //     },
            //     uploadProgress: function(event, position, total, percentComplete) {
            //         var percentVal = percentComplete+'%';
            //         bar.width(percentVal);
            //         percent.html(percentVal);
            //     },
            //     complete: function(data) { 
            //         if (data.status == 100) {
            //                 Swal.fire({
            //                 title: 'ไม่เจอไฟล์',
            //                 text: "File IS NULL",
            //                 icon: 'success',
            //                 showCancelButton: false,
            //                 confirmButtonColor: '#06D177',
            //                 // cancelButtonColor: '#d33', 
            //             })
            //         } else {
            //             Swal.fire({
            //                 title: 'UP STM สำเร็จ',
            //                 text: "You UP STM success",
            //                 icon: 'success',
            //                 showCancelButton: false,
            //                 confirmButtonColor: '#06D177',
            //                 // cancelButtonColor: '#d33',
            //                 confirmButtonText: 'เรียบร้อย'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     window.location = "{{ url('upstm_ucsopd') }}";
            //                 }
            //             })
            //         }
                    
            //     }
            // })

            $('#Upstm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                // alert('OJJJJOL');
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
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'Up Statment สำเร็จ',
                                text: "You Up Statment data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else {
                            Swal.fire({
                                title: 'UP Statment ซ้ำ',
                                text: "You Up Statment data success",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            });
 
        });
    </script>

@endsection
