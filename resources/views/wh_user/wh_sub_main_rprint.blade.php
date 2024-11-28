<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>ใบเบิกพัสดุ</title>

{{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> --}}
{{-- <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"type='text/css'>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
</head>
<style>
  @font-face {
      font-family: 'THSarabunNew';
      src: url('fonts/thsarabunnew-webfont.eot');
      src: url('fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/thsarabunnew-webfont.woff') format('woff'),
          url('fonts/thsarabunnew-webfont.ttf') format('truetype');
      font-weight: normal;
      font-style: normal;
  }

  @font-face {
      font-family: 'THSarabunNew';
      src: url('fonts/thsarabunnew_bolditalic-webfont.eot');
      src: url('fonts/thsarabunnew_bolditalic-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/thsarabunnew_bolditalic-webfont.woff') format('woff'),
          url('fonts/thsarabunnew_bolditalic-webfont.ttf') format('truetype');
      font-weight: bold;
      font-style: italic;
  }

  @font-face {
      font-family: 'THSarabunNew';
      src: url('fonts/thsarabunnew_italic-webfont.eot');
      src: url('fonts/thsarabunnew_italic-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/thsarabunnew_italic-webfont.woff') format('woff'),
          url('fonts/thsarabunnew_italic-webfont.ttf') format('truetype');
      font-weight: normal;
      font-style: italic;
  }

  @font-face {
      font-family: 'THSarabunNew';
      src: url('fonts/thsarabunnew_bold-webfont.eot');
      src: url('fonts/thsarabunnew_bold-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/thsarabunnew_bold-webfont.woff') format('woff'),
          url('fonts/thsarabunnew_bold-webfont.ttf') format('truetype');
      font-weight: bold;
      font-style: normal;
  }

  @page {
      margin: 0cm 0cm;
  }

  body {
      /* font-family: 'THSarabunNew', sans-serif;
                  font-size: 13px;
              line-height: 0.9;
              margin-top:    0.2cm;
              margin-bottom: 0.2cm;
              margin-left:   1cm;
              margin-right:  1cm;  */
      font-family: "THSarabunNew";
      font-size: 13px;
      line-height: 0.8;
      margin-top: 1.5cm;
      margin-bottom: 0.2cm;
      margin-left: 1.5cm;
      margin-right: 1.5cm;
  }

  #watermark {
      position: fixed;
      bottom: 0px;
      left: 0px;
      width: 29.5cm;
      height: 21cm;
      z-index: -1000;
  }

  table,
  td {
      /* border: 1px solid rgb(255, 255, 255); */
  }

  .text-pedding {
      /* padding-left:10px;
              padding-right:10px; */
  }

  table {
      border-collapse: collapse; //กรอบด้านในหายไป
  }

  table.one {
      border: 0.2px solid rgb(5, 5, 5);
      /* height: 800px; */
      /* padding: 15px; */
  }

  td {
      margin: .2rem;
      /* height: 3px; */
      /* padding: 5px; */
      /* text-align: left; */
  }

  td.o {
      border: 0.2px solid rgb(5, 5, 5);
  }

  td.b {
      border: 0.2px solid rgb(255, 255, 255);
  }

  td.d {
      border: 0.2px solid rgb(5, 5, 5);
      height: 170px;
  }

  td.e {
      border: 0.2px solid rgb(255, 255, 255);

  }

  td.h {
      border: 0.2px solid rgb(5, 5, 5);
      height: 10px;
  }

  .page-break {
      page-break-after: always;
  }

  input {
      margin: .3rem;
  }

  .unterline-dotted {
      border-bottom: 1px dotted;
  }
</style>
{{-- <style type="text/css">
  /* @font-face { */
      /* font-family: 'THSarabunNew';   */
      /* src: url({{ storage_path('fonts/THSarabunNew.ttf') }}) format('truetype'); */
      /* font-weight: 100; // use the matching font-weight here ( 100, 200, 300, 400, etc). */
      /* font-style: normal; // use the matching font-style here */
  /* }         */
  /* body{
      font-family: "THSarabunNew",  //set your font name u can set custom font name also which u set in @font-face css rule
      
    } */
      /* header {
            position: fixed;
            top: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

         
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        } */
        /* .pagenum:before {
                content: counter(page);
        }
        header {
             
        } */

        .pagenum:before {
            content: counter(page);
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        .bottom-date {
            position: relative;
        }

        .bottom-date-text {
            position: absolute;
            top: -3;
            left: 70;
            width: 140px;
            text-align: center;
        }

        table,
          td {
              border-collapse: collapse; //กรอบด้านในหายไป
          }

          td.o {
              border: 0.1px solid rgb(5, 5, 5);
          }

          table.one {
              border: 0.1px solid rgb(5, 5, 5);
          }
    /* .page-break {
        page-break-after: always;
    } */
    /* .pagenum:before {
        content: counter(page);
    } */
    @media print {
      footer {page-break-after: always;}
    }
    
    .page-break {
        page-break-after: always;
    }
</style> --}}
{{-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1> --}}
<body>

  <div class="container-fluid text-center">
    {{-- <span class="pagenum"></span> --}}
    {{-- <header>
      <span class="pagenum"></span>
    </header> --}}
    @php
      $row_in_table = 13;
    @endphp
    @forelse ($request_sub as $item)
          @if ($loop->iteration % $row_in_table == 1) 
              <div class="row"> 
                <div class="col-md-12">   
                  <label for="" style="font-size:15px;"><b>ใบเบิกวัสดุ</b></label> 
                    <table>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">ชื่อหน่วยงาน</b> {{$wh_request->DEPARTMENT_SUB_SUB_NAME}}</td>
                        <td style="font-size: 13px;width: 250px"> </td> 
                        <td style="font-size: 13px"><b class="me-2">ใบเบิกวัสดุเลขที่</b> {{$wh_request->request_no}}</td> 
                      </tr>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">เรื่อง</b> ขออนุมัติเบิก</td>
                        <td style="font-size: 13px;width: 250px"></td> 
                        <td style="font-size: 13px"><b class="me-2">วันที่</b> {{DateThai($wh_request->request_date)}}</td> 
                      </tr>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">เรียน</b> หัวหน้าหน่วยพัสดุ</td>
                        <td style="font-size: 13px;width: 250px"></td> 
                        <td style="font-size: 13px"></td> 
                      </tr>
                    
                    </table>
                    <table>
                        <tr style="height: 10px">
                            <td style="font-size: 13px;width: 90px"></td> 
                            <td style="font-size: 13px;width: auto">ข้าพเจ้าขอเบิกพัสดุตามรายการข้างล่างนี้ เพื่อใช้ในราชการ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</td> 
                        </tr>
                    </table>
                    <table>
                      <tr style="height: 10px"> 
                          <td style="font-size: 13px;width: auto">และมอบให้...........................................................................ตำแหน่ง.................................................................เป็นผู้รับ ตามใบเบิกนี้</td> 
                      </tr>
                    </table> 
                </div>
              </div>
              <div class="row"> 
                  <div class="col-xl-12">  
                    {{-- <table class="table table-sm table-bordered mb-4" style="width: 100%;">  --}}
                          <table class="mb-4" style="width: 100%;"> 
                              <thead>
                                  <tr style="font-size: 11px;height: 11px;" class="text-center">
                                      <th rowspan="2" style="border: 1px solid black;width: 5%;">ลำดับ</th>
                                      <th rowspan="2" style="border: 1px solid black;width: 45%;">รายการ</th> 
                                      <th colspan="4" style="border: 1px solid black;width: 15%;">จำนวน</th> 
                                      <th rowspan="2" style="border: 1px solid black;width: 10%;">ราคา/<br>หน่วย</th> 
                                      <th rowspan="2" style="border: 1px solid black;width: 10%;">ราคารวม</th> 
                                      <th rowspan="2" style="border: 1px solid black;width: 10%;">หมายเหตุ</th> 
                                  </tr>
                                  <tr style="font-size: 11px;height: 11px;" class="text-center">
                                      <th style="border: 1px solid black;">หน่วย</th>
                                      <th style="border: 1px solid black;">คลังย่อย</th>
                                      <th style="border: 1px solid black;">เบิก</th>
                                      <th style="border: 1px solid black;">อนุมัติ</th> 
                                  </tr>
                              </thead>
                              <tbody> 
          @endif

          @php
                              $data_rep = DB::select(
                                  'SELECT SUM(qty_pay) as qty_rep 
                                      FROM wh_stock_dep_sub
                                      WHERE pro_id = "'.$item->pro_id.'"
                                      AND stock_list_subid = "'.$item->stock_list_subid.'"
                              ');
                              foreach ($data_rep as $key => $val) {
                                  $rep_qty  = $val->qty_rep;
                              }
                              $data_pay = DB::select(
                                  'SELECT SUM(qty) as qty_pay 
                                      FROM wh_pay_sub
                                      WHERE pro_id = "'.$item->pro_id.'"
                                      AND stock_list_subid = "'.$item->stock_list_subid.'"
                              ');
                              foreach ($data_pay as $key => $valpay) {
                                  $pay_qty  = $valpay->qty_pay;
                              }
          @endphp
                                    <tr style="font-size: 11px;height: 11px;">
                                        <th style="border: 1px solid black;width: 5%;" class="text-center">{{$loop->iteration}}</th>
                                        <td style="border: 1px solid black;width: 10%;" class="text-start">&nbsp;{{$item->pro_name}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->unit_name}}</td>
                                        <td style="border: 1px solid black;width: 5%;" class="text-center">&nbsp;{{$rep_qty-$pay_qty}}</td>
                                        <td style="border: 1px solid black;width: 5%;" class="text-center">&nbsp;{{$item->qty}}</td>
                                        <td style="border: 1px solid black;" class="text-start">&nbsp;</td>
                                        <td style="border: 1px solid black;width: 10%;" class="text-start">&nbsp;</td>
                                        <td style="border: 1px solid black;width: 10%;" class="text-center"></td>
                                        <td style="border: 1px solid black;width: 10%;" class="text-center"></td>
                                    </tr> 

          @if ($loop->last || $loop->iteration % $row_in_table == 0) 
                              
                            </tbody>
                        </table>   

                        <table class="mt-4">
                              <tr>
                                <td style="font-size: 12px;width:100px"><b></b></td>   
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้เบิก<br> 
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >หัวหน้ากลุ่มงาน.....................................................</label>
                                </td> 
                                <td style="font-size: 12px;width:100px"></td>  
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้สั่งจ่าย<br>  
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >ตำแหน่ง.....................................................</label>
                                </td> 
                              </tr>  
                        </table>  
                        <table  class="mt-2">
                            <tr>
                              <td style="font-size: 12px;width:130px"><b></b></td>   
                              <td style="font-size: 12px;width:200px;height: 10px;">ได้รับพัสดุถูกต้องครบถ้วน </td> 
                              <td style="font-size: 12px;width:130px"><b></b></td>   
                              <td style="font-size: 12px;width:200px;height: 10px;">ได้จ่ายและลงบัญชีแล้ว </td> 
                            </tr>
                        </table>
                        <table class="mt-3">
                              <tr>
                                <td style="font-size: 12px;width:100px"><b></b></td>   
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้รับ<br> 
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >วันที่ .........................................................</label>
                                </td> 
                                <td style="font-size: 12px;width:100px"></td>  
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้จ่าย<br>  
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >วันที่ .........................................................</label>
                                </td> 
                              </tr>  
                        </table>  
 

                    </div>
                </div> 

                
              @if (!$loop->last)
            
                  {{-- <p style="page-break-after: always;"></p>  --}}
                <p class="page-break"></p>
              @endif
              
          @endif 
      @empty 

      
    @endforelse
   
    {{-- @php
       if ( isset($pdf) ) {
          $font = Font_Metrics::get_font("helvetica", "bold");
          $pdf->page_text(510, 12, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255, 0, 0));
      } 
    @endphp --}}
  
    {{-- <span class="pagenum mb-0"></span> --}}
    {{-- <table class="mt-4">
      <tr>
        <td style="font-size: 12px;width:100px"><b></b></td>   
        <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้เบิก<br> 
          <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
          <label style="font-size: 12px;;height: 10px;" >หัวหน้ากลุ่มงาน.....................................................</label>
        </td> 
        <td style="font-size: 12px;width:100px"></td>  
        <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้สั่งจ่าย<br>  
          <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
          <label style="font-size: 12px;;height: 10px;" >ตำแหน่ง.....................................................</label>
        </td> 
      </tr>  
    </table>  
    <table  class="mt-2">
        <tr>
          <td style="font-size: 12px;width:130px"><b></b></td>   
          <td style="font-size: 12px;width:200px;height: 10px;">ได้รับพัสดุถูกต้องครบถ้วน </td> 
          <td style="font-size: 12px;width:130px"><b></b></td>   
          <td style="font-size: 12px;width:200px;height: 10px;">ได้จ่ายและลงบัญชีแล้ว </td> 
        </tr>
    </table>
    <table class="mt-4">
          <tr>
            <td style="font-size: 12px;width:100px"><b></b></td>   
            <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้รับ<br> 
              <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
              <label style="font-size: 12px;;height: 10px;" >วันที่ .......................................................</label>
            </td> 
            <td style="font-size: 12px;width:100px"></td>  
            <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้จ่าย<br>  
              <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
              <label style="font-size: 12px;;height: 10px;" >วันที่ .......................................................</label>
            </td> 
          </tr>  
    </table>  --}}
      
 









 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
<script type="text/php">
  if ( isset($pdf) ) {    
      $pdf->page_text(510, 5, "Page: {PAGE_NUM} of {PAGE_COUNT}",null, 10, array(255,0,0));
  }
</script>
</body>

</html>
{{-- $font = Font_Metrics::get_font("helvetica", "bold"); --}}