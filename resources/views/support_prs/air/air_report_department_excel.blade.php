 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามหน่วยงานรายเดือน.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามหน่วยงานรายเดือนโรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ {{$bg_yearnow}}</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำเดือน {{$rep_month}}  พ.ศ. {{$rep_years}}</b></label>
</center>
   <br> 
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;">
        <thead>
          
            <tr style="font-size:13px">  
                <th class="text-center" width="5%" style="border: 1px solid black;background-color: #8be2df">ลำดับ</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">รายการ (รหัส : ยี่ห้อ : BTU)</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">อาคารที่ตั้ง (ชื่ออาคาร : เลขอาคาร : ชั้นอาคาร)</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">หน่วยงาน</th>  
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">แผนบำรุงรักษาครั้ง 1</th>   
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">แผนบำรุงรักษาครั้ง 2</th>
                <th class="text-center" style="border: 1px solid black;background-color: #8be2df">บริษัทผู้ดำเนินการ</th> 
            </tr> 
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($datashow as $item) 
                                  
                <tr> 
                    <td class="text-center" style="width: 7%;border: 1px solid black;">{{ $i++ }}</td>   
                    <td class="p-2" style="border: 1px solid black;">{{ $item->air_list_name }} BTU</td>  
                    <td class="p-2" style="border: 1px solid black;">{{ $item->air_location_name }}</td>  
                    <td class="p-2" style="border: 1px solid black;">{{ $item->debsubsub }}</td>                      
                    <td class="text-center" style="width: 7%;border: 1px solid black;">{{ $item->plan_one }}</td> 
                    <td class="text-center" style="width: 7%;border: 1px solid black;">{{ $item->plan_two }}</td>  
                    <td class="p-2" style="width: 7%;border: 1px solid black;">{{ $item->supplies_name }}</td>   
                </tr> 
            @endforeach
        </tbody>
    </table>
   <table class="table" style="width: 100%">
       
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
        <tr>   
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ………………………………….ผู้เสนอแผน</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายประภัทร์  ขจัดพาล )</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง วิศวกร</label>  
                </center>
            </td>
        
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ………………………………….ผู้เห็นชอบ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายสถาพร  ป้อมสุวรรณ )</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มภารกิจด้านอำนวยการ</label>  
                </center>
            </td>
        
            <td colspan="2"> 
            <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ………………………………….ผู้อนุมัติ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายสุภาพ  สำราญวงษ์ )</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</label> 
            </center>
            </td>
        </tr>    
        
   </table>
</center>
 

   