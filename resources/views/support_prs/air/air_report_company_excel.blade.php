 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามบริษัท.xls"');//ชื่อไฟล์
   
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
    <br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานการบำรุงรักษาเครื่องปรับอากาศแยกตามบริษัท โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</b></label><br>
 
</center>
   <br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;">
        <thead>
          
            <tr style="font-size:13px">  
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">วันที่ซ่อม</th>   
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">เวลา</th>  
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">เลขที่แจ้งซ่อม</th> 
                {{-- <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">รหัส</th>  --}}
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">รายการ</th>  
                {{-- <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ขนาด(btu)</th>   --}}
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">อาคารที่ตั้ง</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">หน่วยงาน</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ซ่อม/บำรุงรักษา</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">เจ้าหน้าที่</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ช่างซ่อม(รพ)</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">ช่างแอร์</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">บริษัท</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($datashow as $item) 
            <?php $i++ ?> 
                     
                <tr> 
                    <td class="text-center" style="font-size: 13px;width: 7%;border: 1px solid black;">{{ dateThaifromFull($item->repaire_date )}}</td>  
                    <td class="text-center" style="font-size: 13px;width: 5%;border: 1px solid black;">{{ $item->repaire_time }}</td>   
                    <td class="text-center" style="font-size: 13px;width: 5%;border: 1px solid black;">{{ $item->air_repaire_no }}</td> 
                    {{-- <td class="text-center" style="width: 5%;border: 1px solid black;">{{ $item->air_list_num }}</td>  --}}
                    <td class="p-2" style="font-size: 13px;border: 1px solid black;">{{ $item->air_list_name }} - {{ $item->btu }} btu</td>  
                    {{-- <td class="p-2" style="width: 5%;border: 1px solid black;">{{ $item->btu }}</td>   --}}
                    <td class="p-2" style="font-size: 13px;width: 10%;border: 1px solid black;">{{ $item->air_location_name }}</td>  
                    <td class="p-2" style="font-size: 13px;width: 10%;border: 1px solid black;">{{ $item->debsubsub }}</td>  
                    <td class="p-2" style="font-size: 13px;width: 10%;border: 1px solid black;"> 
                         
               
                        <p class="mt-2" style="font-size: 13px;color:rgb(21, 22, 22)">
                             {{$item->repaire_sub_name}}  
                        </p>
                       
                    </td>  
                    <td class="p-2" style="font-size: 13px;width: 7%;border: 1px solid black;">{{ $item->staff_name }}</td> 
                    <td class="p-2" style="font-size: 13px;width: 7%;border: 1px solid black;">{{ $item->tect_name }}</td> 
                    <td class="p-2" style="font-size: 13px;width: 7%;border: 1px solid black;">{{ $item->air_techout_name }}</td>  
                    <td class="p-2" style="font-size: 13px;width: 7%;border: 1px solid black;">{{ $item->supplies_name }}</td>  
                </tr> 
            @endforeach
        </tbody>
    </table>
   <table class="table" style="width: 100%">
       
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr>   
        <td></td>
        <td colspan="2"> 
            <center>
            <label for="" style="font-size:10px;"> ลงชื่อ………………………………….ผู้ตรวจสอบ</label><br>
            <label for="" style="font-size:10px;"> ( นายประภัทร์  ขจัดพาล )</label><br>
            <label for="" style="font-size:10px;"> ตำแหน่ง วิศวกร</label>  
            </center>
        </td>
    <td></td>
        <td colspan="2"> 
            <center>
            <label for="" style="font-size:10px;"> ลงชื่อ………………………………….ผู้รับรอง</label><br>
            <label for="" style="font-size:10px;"> ( นางสุวิตรี  กำลังเหลือ )</label><br>
            <label for="" style="font-size:10px;"> ตำแหน่ง นักวิชาการพัสดุปฎิบัติการ</label>  
            </center>
        </td>
        <td></td>
        <td colspan="2"> 
            <center>
            <label for="" style="font-size:10px;"> ลงชื่อ………………………………….ผู้เห็นชอบ</label><br>
            <label for="" style="font-size:10px;"> ( นายสถาพร  ป้อมสุวรรณ )</label><br>
            <label for="" style="font-size:10px;"> ตำแหน่ง นักจัดการทั่วไปชำนาญการพิเศษ </label>  
            </center>
        </td>
{{--     
        <td colspan="2"> 
        <center>
            <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ………………………………….ผู้อนุมัติ</label><br>
            <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายสุภาพ  สำราญวงษ์ )</label><br>
            <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</label> 
        </center>
        </td> --}}
    </tr>    
        
   </table>
</center>
 

   