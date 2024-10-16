 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานการข้อมูลเครื่องปรับอากาศ.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานการข้อมูลเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ปีงบประมาณ {{$ynow}}</b></label><br> 
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;border: 1px;color:black;">
        <thead>
          
            <tr style="font-size:13px">  
                <th class="text-center" width="5%" style="border: 1px;color:black;background-color: #8be2df">วันที่ซ่อม</th>   
                <th class="text-center" width="5%" style="border: 1px;color:black;background-color: #8be2df">เวลา</th>  
                <th class="text-center" width="5%" style="border: 1px;color:black;background-color: #8be2df">เลขที่แจ้งซ่อม</th> 
                <th class="text-center" width="5%" style="border: 1px;color:black;background-color: #8be2df">รหัส</th> 
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">รายการ</th>  
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">ขนาด(btu)</th>  
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">อาคารที่ตั้ง</th>  
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">หน่วยงาน</th>  
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">ซ่อม/บำรุงรักษา</th>   
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">เจ้าหน้าที่</th>
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">ช่างซ่อม(รพ)</th>
                <th class="text-center" style="border: 1px;color:black;background-color: #8be2df">ช่างแอร์</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($datashow as $item) 
            <?php $i++ ?> 
                     
                <tr> 
                    <td class="text-center" style="width: 7%;border: 1px;color:black">{{ DateThai($item->repaire_date )}}</td>  
                    <td class="text-center" style="width: 5%;border: 1px;color:black">{{ $item->repaire_time }}</td>   
                    <td class="text-center" style="width: 5%;border: 1px;color:black">{{ $item->air_repaire_no }}</td> 
                    <td class="text-center" style="width: 5%;border: 1px;color:black">{{ $item->air_list_num }}</td> 
                    <td class="p-2" style="border: 1px;color:black">{{ $item->air_list_name }} </td>  
                    <td class="p-2" style="width: 5%;border: 1px;color:black">{{ $item->btu }}</td>  
                    <td class="p-2" style="width: 10%;border: 1px;color:black">{{ $item->air_location_name }}</td>  
                    <td class="p-2" style="width: 10%;border: 1px;color:black">{{ $item->debsubsub }}</td>  
                    <td class="p-2" style="width: 10%;border: 1px;color:black"> 
                        <?php $datas_sub_= DB::select('SELECT * FROM air_repaire_sub WHERE air_repaire_id = "'.$item->air_repaire_id.'"');?>
                        @foreach ($datas_sub_ as $v_1)
                        <p class="mt-2" style="font-size: 13px;color:rgb(6, 149, 168)">
                            - {{$v_1->repaire_sub_name}}
                        </p>
                        @endforeach 
                    </td>  
                    <td class="p-2" style="width: 7%;border: 1px;color:black">{{ $item->staff_name }}</td> 
                    <td class="p-2" style="width: 7%;border: 1px;color:black">{{ $item->tect_name }}</td> 
                    <td class="p-2" style="width: 7%;border: 1px;color:black">{{ $item->air_techout_name }}</td>  
                </tr> 
            @endforeach
        </tbody>
    </table>
   <table class="table" style="width: 100%">
       
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       
        {{-- <tr>
            <td></td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..........................................ผู้ตรวจสอบ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> (   นายจตุพร   มิ่งศิริ   )<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง พนักงานบริการ</label><br>
                </center>
            </td> 
            <td colspan="2"> 
            </td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..........................................ผู้ควบคุม</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายพงศ์วิจักษณ์   พรมทอง)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง นักจัดการงานทั่วไป </label><br>
                </center>
            </td> 
            <td colspan="2"> 
            </td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ............................................</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายสถาพร   ป้อมสุวรรณ)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มภารกิจด้านอำนวยการ </label><br>
                </center>
            </td> 
        </tr>  --}}
   </table>
</center>
 

   