<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>แผนการบำรุงรักษาเครื่องปรับอากาศ</title>

{{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> --}}
{{-- <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"type='text/css'>
</head>
 
<style type="text/css">
  @font-face {
      font-family: 'THSarabunNew';  
      src: url({{ storage_path('fonts/THSarabunNew.ttf') }}) format('truetype');
      font-weight: 100; // use the matching font-weight here ( 100, 200, 300, 400, etc).
      font-style: normal; // use the matching font-style here
  }        
  body{
      /* margin: 0px; */
      font-family: "THSarabunNew",  //set your font name u can set custom font name also which u set in @font-face css rule
      
    }
    /* .page-break {
        page-break-after: always;
    } */
    @page { margin:0px 10px 0px 10px; }
    @media print {
      footer {page-break-after: always;}
    }
    .itemstable {
        border-collapse: collapse;
        border-spacing: 0 0;
        -webkit-border-vertical-spacing: 0;
        width: 100%;
        /* height: 100%; */
        min-height: 100mm !important;
        position: relative;
        table-layout: fixed;
    }
</style>
{{-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1> --}}
<body>
  <div class="container-fluid text-center p-0">
  @php
    $row_in_table = 16;
  @endphp
    @forelse ($data_air as $item)
          @if ($loop->iteration % $row_in_table == 1) 
              <div class="row"> 
                <div class="col-md-12">   
                  <label for="" style="font-size:15px;">
                    <b>แผนการบำรุงรักษาเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ {{$bg_yearnow}}</b>
                  </label>
                  
                  {{-- <p style="font-size:14px;">เดือน {{$ye_name}}</p> --}}
                </div>
              </div>
              <div class="row mt-2"> 
                  <div class="col-md-12">  
                          <table class="table table-sm itemstable" style="width: 100%;"> 
                              <thead>
                                <tr style="font-size: 11px;" class="text-center">
                                  <th style="border: 1px solid black;">ลำดับ</th>
                                  <th style="border: 1px solid black;">รายการ (รหัส : ยี่ห้อ : BTU)</th>
                                  <th style="border: 1px solid black;">อาคารที่ตั้ง (ชื่ออาคาร : เลขอาคาร : ชั้นอาคาร)</th> 
                                  <th style="border: 1px solid black;">หน่วยงาน</th> 
                                  <th style="border: 1px solid black;">แผนบำรุงรักษา<br>ครั้งที่ 1</th>
                                  <th style="border: 1px solid black;">แผนบำรุงรักษา<br>ครั้งที่ 2</th>
                                  <th style="border: 1px solid black;">บริษัท<br>ผู้ดำเนินการ</th> 
                                </tr>
                              </thead>
                              <tbody> 
          @endif
                  @php  
                         $plan_one_count = DB::select(
                          'SELECT COUNT(a.air_list_num) as cnum
                            FROM air_plan a 
                              LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                              LEFT JOIN air_supplies c ON c.air_supplies_id = a.supplies_id 
                              WHERE a.air_list_num = "'.$item->air_list_num.'" AND a.air_plan_year = "'.$item->air_plan_year.'" AND a.air_repaire_type_id = "1"
                              AND a.supplies_id = "'.$item->supplies_id.'"
                         '); 
                         foreach ($plan_one_count as $key => $co) {
                            $count_sub = $co->cnum;
                         }
                         if ($count_sub > 0) {
                              $sup_plan_one = DB::select(
                                  'SELECT b.air_plan_year+543 as air_plan_year,a.air_repaire_type_id,IFNULL(b.air_plan_name,"") as air_plan_name,c.supplies_name 
                                    FROM air_plan a 
                                    LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                    LEFT JOIN air_supplies c ON c.air_supplies_id = a.supplies_id 
                                    WHERE a.air_list_num = "'.$item->air_list_num.'" AND a.air_plan_year = "'.$item->air_plan_year.'" AND a.air_repaire_type_id = "1"
                                    AND a.supplies_id = "'.$item->supplies_id.'"
                              '); 
                              foreach ($sup_plan_one as $key => $v_one) { 
                                    $plan_name_one = $v_one->air_plan_name;
                                    $air_plan_year = $v_one->air_plan_year; 
                                    $supplies_name_  = $v_one->supplies_name;
                              }
                         } else {
                            $plan_name_one = "-";
                            $air_plan_year = "-";
                         }


                         $plan_two_count = DB::select(
                            'SELECT COUNT(a.air_list_num) as cnum,c.supplies_name
                              FROM air_plan a 
                                LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                LEFT JOIN air_supplies c ON c.air_supplies_id = a.supplies_id 
                                WHERE a.air_list_num = "'.$item->air_list_num.'" AND a.air_plan_year = "'.$item->air_plan_year.'" AND a.air_repaire_type_id = "2"
                                AND a.supplies_id = "'.$item->supplies_id.'"
                         '); 
                         foreach ($plan_two_count as $key => $cotwo) {
                            $count_sub_two = $cotwo->cnum;
                            
                         }
                         if ($count_sub_two > 0) {
                              $sup_plan_two = DB::select(
                                  'SELECT b.air_plan_year+543 as air_plan_year,a.air_repaire_type_id,b.air_plan_name,c.supplies_name
                                    FROM air_plan a 
                                    LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                    LEFT JOIN air_supplies c ON c.air_supplies_id = a.supplies_id 
                                    WHERE a.air_list_num = "'.$item->air_list_num.'" AND a.air_plan_year = "'.$item->air_plan_year.'" AND a.air_repaire_type_id = "2"
                                    AND a.supplies_id = "'.$item->supplies_id.'"
                              '); 
                              foreach ($sup_plan_two as $key => $v_two) {
                                $plan_name_two  = $v_two->air_plan_name;
                                $air_plan_year2 = $v_two->air_plan_year;
                                $supplies_name  = $v_two->supplies_name;
                              } 
                         } else {
                              $plan_name_two  = "-";
                              $air_plan_year2 = "-";
                              $supplies_name  = $supplies_name_;
                         }
                          
                    @endphp
                                    <tr style="font-size: 11px;">
                                      <th style="border: 1px solid black;width: 5%;" class="text-center">{{$loop->iteration}}</th>
                                      <td style="border: 1px solid black;width: 20%;" class="text-start">&nbsp;{{$item->air_list_num}}-{{$item->brand_name}}-{{$item->btu}}</td>
                                      <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->air_location_name}} ชั้น{{$item->air_room_class}}</td> 
                                      <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->detail}}</td> 
                                      <td style="border: 1px solid black;width: 9%;" class="text-center">
                                        @if ($plan_name_one != '')
                                        {{$plan_name_one}} {{$air_plan_year}}
                                        @else
                                            
                                        @endif
                                      
                                      </td>
                                      <td style="border: 1px solid black;width: 9%;" class="text-center">{{$plan_name_two}} {{$air_plan_year2}}</td>
                                      <td style="border: 1px solid black;width: 7%;" class="text-center">{{$supplies_name}}</td>
                                    </tr> 

          @if ($loop->last || $loop->iteration % $row_in_table == 0) 
                              
                            </tbody>
                        </table>   
                        <table>
                            <tr>
                              <td style="font-size: 12px;width:200px"><b></b></td> 
                              {{-- <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ.........................................ผู้เสนอแผน<br> 
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $siguser }}" class="ms-3 me-3 mt-2" alt="" height="40px" width="auto">ผู้เสนอแผน<br> 
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td>
                              
                              <td style="font-size: 12px;width:230px"></td>  
                              {{-- <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ.........................................ผู้เห็นชอบ<br>  
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $sigrong }}" class="ms-4 me-5" alt="" height="35px" width="auto">ผู้เห็นชอบ<br>  
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td>
                              
                            </tr>                       
                            <tr>
                            
                              <td style="font-size: 12px;width:200px"><b></b></td> 
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$position}}</p></td>
                              <td style="font-size: 12px;width:120px;height: 10px;"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                             
                            </tr>
                        </table>  
              @if (!$loop->last)
                  <p style="page-break-after: always;"></p>
              @endif
            </div>
          </div> 
          @endif
      @empty
        
    @endforelse
      
 









 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</body>

</html>
