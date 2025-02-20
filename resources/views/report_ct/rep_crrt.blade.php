@extends('layouts.pkclaim')
@section('title', 'PK-OFFICE || ACCOUNT')
@section('content')
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

    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div>
        <form action="{{ route('claim.rep_crrt') }}" method="GET">
            @csrf
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title">Detail CRRT </h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล CRRT</p>
                </div>
                {{-- <div class="col"></div> --}}
                <div class="col-md-1 text-center mt-1">ค่ารักษา</div>
                <div class="col-md-2 text-center mt-1">
                    <div class="input-group">
                        <select id="nhso_adp_code" name="nhso_adp_code" class="form-select form-select-lg" style="width: 100%">
                            @foreach ($days as $items)
                                @if ($nhso_adp_code == $items->nhso_adp_code)
                                    <option value="{{ $items->nhso_adp_code }}" selected> {{ $items->name }} </option>
                                @else
                                    <option value="{{ $items->nhso_adp_code }}"> {{ $items->name }} </option>
                                @endif
                            @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                    
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
                </div>
            </div>
        </form> 

        <div class="row ">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        รายละเอียด มะเร็งเทียบ STM
                        <div class="btn-actions-pane-right">
                            
                        </div>
                    </div>
                    <div class="card-body"> 
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    {{-- <th class="text-center">vn</th> --}}
                                    <th class="text-center">an</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">dchdate</th> 
                                    <th class="text-center">pttype</th>  
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">income</th> 
                                    <th class="text-center">rcpt_money</th> 
                                    <th class="text-center">debit</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1; ?>
                                @foreach ($datashow as $item) 

                                    <tr height="20" style="font-size: 14px;">
                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number++ }} </td> 
                                        {{-- <td class="text-center" width="8%">{{ $item->vn }}</td> --}}
                                        <td class="text-center" width="7%">{{ $item->an }}</td>
                                        <td class="text-center" width="5%">{{ $item->hn }}</td>
                                        <td class="text-center" width="8%">{{ $item->cid }}</td>
                                        <td class="p-2">{{ $item->ptname }}</td>
                                        <td class="text-center" width="7%">{{ $item->dchdate }}</td>
                                        <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                        <td class="p-2">{{ $item->nonname }}</td>
                                        <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income, 2) }}</td>  </td>
                                        <td class="text-end" style="color:rgb(243, 157, 27)" width="7%"> {{ number_format($item->rcpt_money, 2) }}</td>  </td>
                                        <td class="text-end" style="color:rgb(231, 73, 134)"  width="7%">{{ number_format($item->debit, 2) }}</td>  </td> 
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
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
            $('#nhso_adp_code').select2({
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
