 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานผลการแก้ไขปัญหาถังดับเพลิงชำรุด.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานผลการแก้ไขปัญหาถังดับเพลิง ชำรุด โรงพระยาบาลภูเขียว</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ปีงบประมาณ {{$y}}</b></label><br> 
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;">
        <thead>
         
            <tr style="font-size:13px">  
                <th class="text-center" style="border: 1px solid black;">ลำดับ</th> 
                <th class="text-center" style="border: 1px solid black;">วันที่ตรวจ</th>   
                <th class="text-center" style="border: 1px solid black;">รหัส</th> 
                <th class="text-center" style="border: 1px solid black;">รายการ/ชื่อ</th>
                <th class="text-center" style="border: 1px solid black;">ที่ตั้ง/อาคาร</th>
                <th class="text-center" style="border: 1px solid black;">รายการที่เปลี่ยน</th>
                <th class="text-center" style="border: 1px solid black;">การแก้ไข</th>
                <th class="text-center" style="border: 1px solid black;">วันที่แก้ไข</th>
            </tr> 
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($datashow as $item) 
            <?php $i++ ?> 
                     
                <tr> 
                    <td class="text-center" style="width: 5%;border: 1px solid black;">{{$i}}</td>
                    <td class="text-center;" style="border: 1px solid black;"> {{DateThai($item->check_date)}}</td>
                    <td class="text-center;" style="border: 1px solid black;width: 10%;"> {{$item->fire_num}} </td>
                    <td class="text-start;" style="border: 1px solid black;width: 10%;"> {{$item->fire_name}}</td>
                    <td class="text-start;" style="border: 1px solid black;"> {{$item->fire_location}} </td>
                    <td class="text-center;" style="border: 1px solid black;width: 10%;"> {{$item->fire_chang_new}} </td>
                    <td class="text-start;" style="border: 1px solid black;width: 10%;"> {{$item->fire_chang_comment}} </td> 
                    <td class="text-start;" style="border: 1px solid black;width: 10%;">{{DateThai($item->fire_chang_date)}}</td> 
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
 

   