 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="แผนการบำรุงรักษาเครื่องปรับอากาศโรงพยาบาลภูเขียวเฉลิมพะเกียรติ.xls"');//ชื่อไฟล์
   
   function DateThais($strDate)
   {
     $strYear = date("Y",strtotime($strDate))+543;
     $strMonth= date("n",strtotime($strDate));
     $strDay= date("j",strtotime($strDate));
   
     $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
     $strMonthThai=$strMonthCut[$strMonth];
     return "$strDay $strMonthThai $strYear";
     }
   
     function getAges($birthday) {
       $then = strtotime($birthday);
       return(floor((time()-$then)/31556926));
   }

   $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $m_ = date('m');

    if ( $m_ == '1') {
        $m = 'มกราคม';
    } else if( $m_ == '2'){
        $m = 'กุมภาพันธ์';
    } else if( $m_ == '3'){
        $m = 'มีนาคม';
    } else if( $m_ == '4'){
        $m = 'เมษายน';
    } else if( $m_ == '5'){
        $m = 'พฤษภาคม';
    } else if( $m_ == '6'){
        $m = 'มิถุนายน';
    } else if( $m_ == '7'){
        $m = 'กรกฎาคม';
    } else if( $m_ == '8'){
        $m = 'สิงหาคม';
    } else if( $m_ == '9'){
        $m = 'กันยายน';
    } else if( $m_ == '10'){
        $m = 'ตุลาคม';
    } else if( $m_ == '11'){
        $m = 'พฤษจิกายน';
    } else{
        $m = 'ธันวาคม';  
    }
    
    
   ?>
<center>
    <br><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามประเภทการซ่อมและบำรุงรักษาประจำปี โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</b></label><br>
 
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;">
        <thead>
          
            {{-- <tr style="font-size:13px">  
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">วันที่ซ่อม</th>   
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">เวลา</th>  
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">เลขที่แจ้งซ่อม</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">รายการ</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">อาคารที่ตั้ง</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">หน่วยงาน</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ซ่อม/บำรุงรักษา</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">เจ้าหน้าที่</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ช่างซ่อม(รพ)</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ช่างแอร์</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">บริษัท</th>
            </tr> --}}

            <tr style="font-size:13px">  
                <th rowspan="2" class="text-center" style="background-color: rgb(255, 156, 110);color:#FFFFFF" width= "12%">อาคาร</th>   
                <th rowspan="2" class="text-center" style="background-color: #06b78b;color:#FFFFFF;" width= "5%">จำนวน</th>  
                <th colspan="12" class="text-center" style="background-color: rgb(154, 86, 255);color:#FFFFFF">ระยะเวลาการดำเนินงาน</th>   
            </tr> 
            <tr style="font-size:11px">  
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ต.ค</th> 
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ย</th>   
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ธ.ค</th> 
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ม.ค</th>
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ก.พ</th>
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">มี.ค</th> 
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">เม.ย</th>
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ค</th>
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">มิ.ย</th>
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ค</th>
                <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ส.ค</th>
                <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ย</th>
            </tr> 

        </thead>
        <tbody>
            <?php $i = 0;
                $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;$total13 = 0;  
                $total14 = 0; $total15 = 0; $total16 = 0;$total17 = 0; $total18 = 0; $total19 = 0; $total20 = 0;$total21 = 0;$total22 = 0;$total23 = 0;$total24 = 0;$total25 = 0;
            ?>
            @foreach ($datashow as $item) 
            <?php $i++ ?>               
                <tr>     
                    <td class="text-start" style="font-size:13px;color: rgb(2, 95, 182)">{{$item->building_name}}</td>
                    {{-- <td class="text-center" style="font-size:13px;color: rgb(4, 117, 117)">{{$item->building_id}}</td> --}}
                    <td class="text-center" style="font-size:13px;color: rgb(228, 15, 86)">
                       {{-- <a href="{{url('air_report_building_sub/'.$item->building_id)}}" target="_blank">  --}}
                            <span class="badge bg-success me-2"> {{$item->qtyall}}</span> <span class="badge bg-danger"> {{$item->qty_noall}}</span>
                        {{-- </a>  --}}
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->tula_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->tula_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                     <span class="badge bg-info me-2"> {{$item->plusji_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->plusji_bt}}</span>
                     
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->tanwa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->tanwa_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                         <span class="badge bg-info me-2"> {{$item->makkara_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->makkara_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->gumpa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->gumpa_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->mena_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mena_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->mesa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mesa_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                         <span class="badge bg-info me-2"> {{$item->plussapa_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->plussapa_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                         <span class="badge bg-info me-2"> {{$item->mituna_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->mituna_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                         <span class="badge bg-info me-2"> {{$item->karakada_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->karakada_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                        <span class="badge bg-info me-2"> {{$item->singha_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->singha_bt}}</span>
                    </td>
                    <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)">
                         <span class="badge bg-info me-2"> {{$item->kanya_saha}}</span> <span class="badge" style="background: #ba0890"> {{$item->kanya_bt}}</span>
                    </td>
                </tr>
                <?php
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
                ?>
            @endforeach
        </tbody>
        <tr>
            <td colspan="1" class="text-end" style="background-color: #fabcd7;font-size:16px">รวม</td>
            <td class="text-center" style="background-color: #fcd3e5"><label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha+$Total_bt }}</label></td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total2+$total14}}</span> 
                </label>  
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total3+$total15}}</span>  
                </label></td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total4+$total16}}</span>   
                </label>
                </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total5+$total17}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total6+$total18}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total7+$total19}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total8+$total20}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total9+$total21}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total10+$total22}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total11+$total23}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total12+$total24}}</span>  
                </label>
            </td>
            <td class="text-center" style="background-color: #fabcd7" >
                <label for="" style="color: #FFFFFF;font-size:16px">
                    <span class="badge bg-primary me-2"> {{$total13+$total25}}</span>  
                </label>
            </td>
            
        </tr>  
        <tr>
            <td colspan="1" class="text-end" style="background-color: #fc2783;color:#FFFFFF;font-size:16px"> 
                บริษัทบีทีแอร์
            </td>
            <td class="text-center" style="background-color: #fc85b9"> 
                <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_bt }}</label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px">{{$total14}}</label>  
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px">{{$total15}}</label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px">{{$total16}}</label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total17}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total18}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total19}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total20}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total21}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total22}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total23}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total24}} </label>
            </td>
            <td class="text-center" style="background-color: #fc2783" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total25}} </label>
            </td> 
        </tr> 
        <tr>
            <td colspan="1" class="text-end" style="background-color: #06b78b;color:#FFFFFF;font-size:16px"> 
                บริษัทสหรัตน์แอร์
            </td>  
            <td class="text-center" style="background-color: #68eecc">
                <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha }}</label>  
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total2}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total3}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total4}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total5}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total6}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total7}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total8}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total9}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total10}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total11}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total12}} </label>
            </td>
            <td class="text-center" style="background-color: #06b78b" >
                <label for="" style="color: #FFFFFF;font-size:16px"> {{$total13}} </label>
            </td> 
        </tr> 
    </table>
   <table class="table" style="width: 100%">
       
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       
        
   </table>
</center>
 

   