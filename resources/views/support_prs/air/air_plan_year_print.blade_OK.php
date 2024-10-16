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
      font-family: "THSarabunNew",  //set your font name u can set custom font name also which u set in @font-face css rule
      
    }
    /* .page-break {
        page-break-after: always;
    } */

    @media print {
      footer {page-break-after: always;}
    }
</style>
{{-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1> --}}
<body>

  <div class="container-fluid text-center">
      <div class="row"> 
        <div class="col-xl-12">  
          {{-- <h4>แผนการบำรุงรักษาเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ {{$bg_yearnow}}</h4> --}}
          <label for="" style="font-size:15px;">
            <b>แผนการบำรุงรักษาเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ {{$bg_yearnow}}</b>
          </label>
        </div>
      </div>
      <div class="row"> 
          <div class="col-xl-12"> 
             
                  <table class="table table-sm" style="width: 100%;"> 
                      <thead>
                        <tr style="font-size: 13px;" class="text-center">
                          <th style="border: 1px solid black;">ลำดับ</th>
                          <th style="border: 1px solid black;">รหัส</th>
                          <th style="border: 1px solid black;">อาคาร</th>
                          <th style="border: 1px solid black;">ชั้น</th>
                          <th style="border: 1px solid black;">หน่วยงาน</th>
                          <th style="border: 1px solid black;">ยี่ห้อ</th>
                          <th style="border: 1px solid black;">btu</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                          @foreach ($data_air as $item) 
                          <?php $i++; ?>
                            @if ($i % 15 == 0)
                              <tr style="font-size: 12px;">
                                <th style="border: 1px solid black;width: 5%;" class="text-center">{{$i}}</th>
                                <td style="border: 1px solid black;width: 10%;" class="text-center">{{$item->air_list_num}}</td>
                                <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->air_location_name}}</td>
                                <td style="border: 1px solid black;width: 5%;" class="text-center">{{$item->air_room_class}}</td>
                                <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->detail}}</td>
                                <td style="border: 1px solid black;width: 10%;" class="text-start">&nbsp;{{$item->brand_name}}</td>
                                <td style="border: 1px solid black;width: 10%;" class="text-center">{{$item->btu}}</td>
                              </tr> 

                              <?php break; ?>
                              
                            @else
                              <tr style="font-size: 12px;">
                                <th style="border: 1px solid black;width: 5%;" class="text-center">{{$i}}</th>
                                <td style="border: 1px solid black;width: 10%;" class="text-center">{{$item->air_list_num}}</td>
                                <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->air_location_name}}</td>
                                <td style="border: 1px solid black;width: 5%;" class="text-center">{{$item->air_room_class}}</td>
                                <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->detail}}</td>
                                <td style="border: 1px solid black;width: 10%;" class="text-start">&nbsp;{{$item->brand_name}}</td>
                                <td style="border: 1px solid black;width: 10%;" class="text-center">{{$item->btu}}</td>
                              </tr> 
                            @endif
                               
                          @endforeach 
                      </tbody>
                  </table>                   
                 
                  <table>
                      <tr>
                        <td style="font-size: 12px;width:30px"><b></b></td> 
                        <td style="font-size: 12px;width:250px">ลงชื่อ....................................ผู้เสนอแผน<br> 
                          <label style="font-size: 12px;" class="ms-4">{{$ptname}}</label>
                        </td>
                        <td style="font-size: 12px;width:50px"></td>  
                        <td style="font-size: 12px;width:230px">ลงชื่อ....................................ผู้เห็นชอบ<br>  
                          <label style="font-size: 12px;" class="ms-4">{{$rong_bo}}</label>
                        </td>
                        <td style="font-size: 12px;width:100px"></td> 
                        <td style="font-size: 12px;width:250px">ลงชื่อ....................................ผู้อนุมัติ<br>  
                          <label style="font-size: 12px;" class="ms-4">{{$po}}</label>
                        </td>
                      </tr>                       
                      <tr>
                        <td style="font-size: 12px;width:50px"><b></b></td> 
                        <td style="font-size: 12px;width:150px"> <p style="font-size: 13px;" class="ms-2">{{$position}}</p></td>
                        <td style="font-size: 12px;width:120px"></td>
                        <td style="font-size: 12px;width:150px"> <p style="font-size: 13px;" class="ms-2">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                        <td style="font-size: 12px;width:100px"></td>
                        <td style="font-size: 12px;width:150px"> <p style="font-size: 13px;" class="ms-2">ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</p></td>
                      </tr>
                  </table>
                 
                  
          </div>
      </div>
       

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</body>

</html>
