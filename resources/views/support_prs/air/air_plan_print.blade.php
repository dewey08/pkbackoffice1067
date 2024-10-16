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
 
<body>
  <div class="container-fluid text-center p-0">
  @php
    $row_in_table = 16; 
    $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;$total13 = 0;  
    $total14 = 0; $total15 = 0; $total16 = 0;$total17 = 0; $total18 = 0; $total19 = 0; $total20 = 0;$total21 = 0;$total22 = 0;$total23 = 0;$total24 = 0;$total25 = 0;
  @endphp
    @forelse ($data_air as $item)
          @if ($loop->iteration % $row_in_table == 1) 
              <div class="row"> 
                <div class="col-md-12">   
                  <label for="" style="font-size:15px;">
                    <b>แผนการบำรุงรักษาเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ {{$bg_yearnow}}</b>
                  </label>
                   
                </div>
              </div>
              <div class="row"> 
                  <div class="col-md-12">  
                          <table class="table table-sm itemstable" style="width: 100%;"> 
                              <thead>
                                <tr style="font-size: 11px;" class="text-center">
                                  <th rowspan="2" style="border: 1px solid black;">ลำดับ</th> 
                                  <th rowspan="2" class="text-center" style="border: 1px solid black;background-color: rgb(255, 156, 110);color:#FFFFFF" >อาคาร</th> 
                                  <th rowspan="2" class="text-center" style="border: 1px solid black;background-color: #06b78b;color:#FFFFFF;">จำนวน (เครื่อง)</th> 
                                  <th colspan="12" class="text-center" style="border: 1px solid black;background-color: rgb(154, 86, 255);color:#FFFFFF">ระยะเวลาการดำเนินงาน/ครั้ง (บำรุงรักษาปีละ 2 ครั้ง)</th> 
                                
                                </tr>
                                <tr style="font-size:11px">  
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ต.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ย</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ธ.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ม.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ก.พ</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">มี.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">เม.ย</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">มิ.ย</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ส.ค</th> 
                                  <th width="5%" class="text-center" style="border: 1px solid black;background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ย</th> 
                                </tr>
                              </thead>
                              <tbody> 
          @endif
                          @php  
                            $total1 = $total1 + $item->qtyall; 
                            $total2 = $total2 + $item->tula_saha;
                            $total14 = $total14 + $item->tula_bt;
                            $total3 = $total3 + $item->plusji_saha; 
                            $total15 = $total15 + $item->plusji_bt; 
                            $total4 = $total4 + $item->tanwa_saha; 
                            $total16 = $total16 + $item->tanwa_bt; 
                            $total5 = $total5 + $item->makkara_saha; 
                            $total17 = $total17 + $item->makkara_bt; 
                            $total6 = $total6 + $item->gumpa_saha; 
                            $total18 = $total18 + $item->gumpa_bt; 
                            $total7 = $total7 + $item->mena_saha; 
                            $total19 = $total19 + $item->mena_bt; 
                            $total8 = $total8 + $item->mesa_saha; 
                            $total20 = $total20 + $item->mesa_bt;
                            $total9 = $total9 + $item->plussapa_saha; 
                            $total21 = $total21 + $item->plussapa_bt; 
                            $total10 = $total10 + $item->mituna_saha; 
                            $total22 = $total22 + $item->mituna_bt;
                            $total11 = $total11 + $item->karakada_saha; 
                            $total23 = $total23 + $item->karakada_bt; 
                            $total12 = $total12 + $item->singha_saha; 
                            $total24 = $total24 + $item->singha_bt;                                            
                            $total13 = $total13 + $item->kanya_saha; 
                            $total25 = $total25 + $item->kanya_bt;
                            $Total_saha = $total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9+$total10+$total11+$total12+$total13;
                            $Total_bt   = $total14+$total15+$total16+$total17+$total18+$total19+$total20+$total21+$total22+$total23+$total24+$total25;
                                                      
                          @endphp
                                    <tr style="font-size: 11px;" height="7px;">
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center">{{$loop->iteration}}</th> 
                                      <td style="border: 1px solid black;color: #54046d" class="text-start">&nbsp;{{$item->building_name}} ชั้น {{$item->air_room_class}}</td> 
                                      <th style="border: 1px solid black;width: 8%;color: #54046d" class="text-center"><span style="color: #046d6d"> {{$item->qtyall}}</span> </th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->tula_saha+$item->tula_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->plusji_saha+$item->plusji_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->tanwa_saha+$item->tanwa_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->makkara_saha+$item->makkara_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->gumpa_saha+$item->gumpa_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->mena_saha+$item->mena_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->mesa_saha+$item->mesa_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->plussapa_saha+$item->plussapa_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->mituna_saha+$item->mituna_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->karakada_saha+$item->karakada_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->singha_saha+$item->singha_bt}}</span></th>
                                      <th style="border: 1px solid black;width: 5%;color: #54046d" class="text-center"><span style="color: #54046d"> {{$item->kanya_saha+$item->kanya_bt}}</span></th>
                                  
                                    </tr> 

          @if ($loop->last || $loop->iteration % $row_in_table == 0) 
          
                            </tbody>
                            <tr style="font-size: 11px;" height="7px;">
                              <th colspan="2" style="border: 1px solid black;" class="text-center">รวม</th> 
                              {{-- <th style="border: 1px solid black;color: #a10654" class="text-center">{{$Total_saha+$Total_bt}}</th> --}}
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total1}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total2+$total14}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total3+$total15}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total4+$total16}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total5+$total17}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total6+$total18}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total7+$total19}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total8+$total20}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total9+$total21}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total10+$total22}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total11+$total23}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total12+$total24}}</th>
                              <th style="border: 1px solid black;color: #a10654" class="text-center">{{$total13+$total25}}</th>
                            </tr> 



                        </table>   
                        <table>
                            <tr>
                              <td style="font-size: 12px;width:18px"><b></b></td> 
                              {{-- <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $siguser }}" class="ms-4 me-4" alt="" height="40px" width="auto">ผู้เสนอแผน<br> 
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ......................................... ผู้เสนอแผน<br> 
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td>
                              
                              {{-- <td style="font-size: 12px;width:50px"></td>  
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $sigrong }}" class="ms-4 me-4" alt="" height="35px" width="auto">ผู้เห็นชอบ<br>  
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:50px"></td>  
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ......................................... ผู้เห็นชอบ<br>  
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td>
                                                          
                              <td style="font-size: 12px;width:50px"></td> 
                              <td style="font-size: 12px;width:250px;height: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ ......................................... ผู้อนุมัติ<br>  
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$po}}</label>
                              </td>
                        
                            </tr>                       
                            <tr>
                              <td style="font-size: 12px;width:18px"><b></b></td> 
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$position}}</p></td>
                              <td style="font-size: 12px;width:120px;height: 10px;"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                              <td style="font-size: 12px;width:100px;height: 10px;"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</p></td>
                            </tr>
                        </table> 
                    {{-- </div>
                </div>  --}}
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
