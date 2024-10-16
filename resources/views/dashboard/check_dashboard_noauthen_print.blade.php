 
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
            <div class="col-md-12">
                 <div class="card cardreport">
                    <div class="card-header">
                        Report check Authen
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-science btn-icon-wrapper"></i>Token
                                </button> --}}

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive mt-3">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 14px">
                                        <th>ลำดับ</th>
                                        {{-- <th>vn</th> --}}
                                        <th>hn</th>
                                        <th>cid</th>
                                        <th>tel</th>
                                        <th>vstdate</th>
                                        <th>vsttime</th>
                                        <th>fullname</th>
                                        <th>pttype Hos</th>
                                        <th>hmain Hos</th>
                                        <th>hsub Hos</th>
                                        <th>pttype สปสช</th>
                                        {{-- <th>hmainสปสช</th> --}}
                                        {{-- <th>hsubสปสช</th> --}}
                                        <th>claimtype</th>
                                        <th>staff</th>
                                        <th>main_dep</th>
                                        <th>pdx</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($data_sit as $item)
                                    <tr style="font-size: 13px">
                                            <td>{{ $ia++ }}</td>
                                            {{-- <td>{{ $item->vn }}</td> --}}
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->cid }}</td>
                                            <td>{{ $item->hometel }}</td>
                                            <td>{{ $item->vstdate }}</td>
                                            <td>{{ $item->vsttime }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->pttype }}</td>
                                            <td >{{ $item->hospmain }}</td>
                                            <td>{{ $item->hospsub }}</td>
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->subinscl }}</td>
                                            {{-- <td>{{ $item->hmain }}</td> --}}
                                            {{-- <td>{{ $item->hsub }}</td> --}}
                                            <td style="background-color: rgb(253, 150, 185)">{{ $item->claimtype }}</td>
                                            <td>{{ $item->staff }}</td>
                                            <td>{{ $item->department }}</td>
                                            <td>{{ $item->pdx }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
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