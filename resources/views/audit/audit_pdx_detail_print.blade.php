 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 </head>
 <?php
 
    if ($month == 1) {
        $mm = 'มกราคม';
    } elseif ($month == 2) {
        $mm = 'กุมภาพันธ์';
    } elseif ($month == 3) {
        $mm = 'มีนาคม';
    } elseif ($month == 4) {
        $mm = 'เมษายน';
    } elseif ($month == 5) {
        $mm = 'พฤษภาคม';
    } elseif ($month == 6) {
        $mm = 'มิถุนายน';
    } elseif ($month == 7) {
        $mm = 'กรกฎาคม';
    } elseif ($month == 8) {
        $mm = 'สิงหาคม';
    } elseif ($month == 9) {
        $mm = 'กันยายน';
    } elseif ($month == 10) {
        $mm = 'ตุลาคม';
    } elseif ($month == 11) {
        $mm = 'พฤษจิกายน';
    } else {
        $mm = 'ธันวาคม';
    }
    
    ?>
<body onload="window.print()">
       
    <div class="container-fluid"> 
 
        <div class="row">
        
            <div class="col-xl-12">
                <div class="card card_audit_4">
                    <div class="card-body">
                        <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">รายการที่ไม่ลง DIAG เดือน {{ $mm }}</h4>
                        
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 14px">
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">hn</th>
                                        <th class="text-center">cid</th>
                                        <th class="text-center">vstdate</th>
                                        <th class="text-center">income</th>
                                        <th class="text-center">Approve Code</th>
                                        <th class="text-center">EDC</th>
                                        {{-- <th class="text-center">Ap KTB</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $jj = 1;
                                    $total1 = 0;
                                    $total2 = 0;
                                    $total3 = 0;
                                    $total4 = 0;
                                    ?>
                                    @foreach ($fdh_ofc_momth as $item_m)
                                        <?php ?>
                                        <tr style="font-size: 13px">
                                            <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                            <td class="text-center" width="8%">{{ $item_m->hn }} </td>
                                            <td class="text-center" width="10%">{{ $item_m->cid }} </td>
                                            <td class="text-center" width="12%">{{ $item_m->vstdate }} </td>
                                            <td class="text-center" width="8%">{{ $item_m->debit }} </td>
                                            <td class="text-center" width="10%">{{ $item_m->authen }} </td>
                                            <td class="text-center" width="8%">{{ $item_m->edc }} </td>
                                            {{-- <td class="text-center" width="10%">{{ $item_m->AppKTB }} </td> --}}
                                        </tr>
                                        <?php
                                            $total1 = $total1 + $item_m->debit;
                                            $total2 = $total2 + $item_m->edc;
                                            // $total3 = $total3 + $item_m->AppKTB; 
                                    ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="4" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                    <td colspan="1" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-center" style="background-color: #FCA533"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                    {{-- <td class="text-center" style="background-color: #44E952"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label> </td> --}}
                                  
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

 </body>
 </html>