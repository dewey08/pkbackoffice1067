<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc;
use App\Models\Acc_stm_ti;
use App\Models\Acc_stm_ti_total;
use App\Models\Acc_opitemrece;
use App\Models\Acc_1102050101_202;
use App\Models\Acc_1102050101_217;
use App\Models\Acc_1102050101_2166;
use App\Models\Acc_stm_ucs;
use App\Models\Acc_1102050101_301;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_4011;
use App\Models\Acc_1102050101_3099;
use App\Models\Acc_1102050101_401;
use App\Models\Acc_1102050101_402;
use App\Models\Acc_1102050102_801;
use App\Models\Acc_1102050102_802;
use App\Models\Acc_1102050102_803;
use App\Models\Acc_1102050102_804;
use App\Models\Acc_1102050101_4022;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050102_603;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Patient;
use App\Models\Oapp;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
// use File;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Dent_appointment;
use App\Models\Dent_appointment_type;
use App\Models\P4p_workgroupset;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Output\Output;

date_default_timezone_set("Asia/Bangkok");


class CheckupController extends Controller
 {
    // ***************** 301********************************

    public function checkup_main(Request $request)
    {
        $startdate        = $request->startdate;
        $enddate          = $request->enddate;
        $dabudget_year    = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date             = date('Y-m-d');
        $y                = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data['users']    = DB::table('users')->get();
        $data_doctor      = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');

        return view('checkup.checkup_main',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_doctor'      => $data_doctor,
        ]);
    }

    public function checkup_report(Request $request)
    {
        $startdate        = $request->startdate;
        $enddate          = $request->enddate;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $dabudget_year    = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date             = date('Y-m-d');
        $y                = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data['users']    = DB::table('users')->get();
        $data['hn'] = DB::connection('mysql10')->select('SELECT hn,CONCAT(pname,fname," ",lname) as ptname FROM patient GROUP BY hn limit 1000' );

        return view('checkup.checkup_report',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            // 'data_doctor'      => $data_doctor,
        ]);
    }

    public function checkup_report_detail(Request $request,$hn,$vstdate)
    {
        // $hn                 = $request->chackup_hn;
        // $vstdate            = $request->datepicker;
        // $data_show          = Patient::where('hn',$hn)->first();

        $data_show2 = DB::connection('mysql10')->select(
            'SELECT v.vn ,o.hn ,o.vstdate , o.vsttime ,k.department, CONCAT(p.pname,p.fname," ",p.lname) as ptname , p.cid ,pt.`name`, s.`name` as sex , v.age_y, os.bw , os.height , os.waist 
            ,os.temperature , os.rr , os.pulse , os.bmi , os.bps , os.bpd,p.hometel
            FROM ovst o
            LEFT JOIN patient p ON p.hn = o.hn
            LEFT JOIN opdscreen os ON os.vn = o.vn
            LEFT JOIN vn_stat v ON v.vn = o.vn
            LEFT JOIN person pp ON pp.cid = v.cid
            LEFT JOIN pttype pt ON pt.pttype = o.pttype
            LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
            LEFT JOIN sex s ON s.`code` = pp.sex
            WHERE o.hn = "'.$hn.'"
            AND o.vstdate = "'.$vstdate.'"  
            AND o.main_dep = "078"
            LIMIT 1           
            
        ');
        // WHERE o.hn = "'.$hn.'" AND o.vstdate = "'.$vstdate.'" 
        foreach ($data_show2 as $key => $value) {
            $vn            = $value->vn;
            $hn            = $value->hn;
            $ptname        = $value->ptname;
            $name          = $value->name;
            $sex           = $value->sex;
            $age_y         = $value->age_y;            
            $cid           = $value->cid;
            $bw            = $value->bw;
            $height        = $value->height;
            $waist         = $value->waist;
            $temperature   = $value->temperature;
            $rr            = $value->rr;
            $pulse         = $value->pulse;
            $bmi           = $value->bmi;
            $bps           = $value->bps;
            $bpd           = $value->bpd;
            $hometel       = $value->hometel;
            
        }
       
        // $output='<label for="">เลขบัตรประชาชน  :   '.$cid. '&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;  ชื่อ-นามสกุล  :    ' .$ptname.'&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;  เบอร์โทร  :    ' .$hometel.'</label>' ; 
        $output='
        <div class="row">
            <div class ="col-md-1">HN :</div>    
            <div class ="col-md-1">
                <label for=""> '.$hn. '</label>
             </div> 
              <div class ="col-md-1">ชื่อ-สกุล :</div>    
            <div class ="col-md-2">
                <label for=""> '.$ptname. '</label>
             </div>
             <div class ="col-md-1">เพศ :</div>    
            <div class ="col-md-1">
                <label for=""> '.$sex. '</label>
             </div>
             <div class ="col-md-1">อายุ :</div>    
            <div class ="col-md-1">
                <label for=""> '.$age_y. ' &nbsp; ปี</label>
             </div>
             <div class ="col-md-1">เลขบัตร :</div>    
            <div class ="col-md-2">
                <label for=""> '.$cid. '</label>
             </div>  
        </div>
        
        <div class="row">
            <div class ="col-md-1">น้ำหนัก :</div>    
            <div class ="col-md-1">
                <label for=""> '.$bw. ' &nbsp;Kg.</label>
             </div> 
              <div class ="col-md-1">ส่วนสูง :</div>    
            <div class ="col-md-2">
                <label for=""> '.$height. ' &nbsp;Cm.</label>
             </div>
             <div class ="col-md-1">รอบเอว :</div>    
            <div class ="col-md-1">
                <label for=""> '.$waist. ' &nbsp;Cm.</label>
             </div>
             <div class ="col-md-1">อุณหภูมิ :</div>    
            <div class ="col-md-1">
                <label for=""> '.$temperature. ' &nbsp;C</label>
             </div>
             <div class ="col-md-1">อัตราการหายใจ :</div>    
            <div class ="col-md-2">
                <label for=""> '.$rr. ' &nbsp; / m</label>
             </div>  
        </div>

        <div class="row">
            <div class ="col-md-1">BMI :</div>    
            <div class ="col-md-1">
                <label for=""> '.$bmi. ' </label>
             </div> 
              <div class ="col-md-1">ความดันโลหิต :</div>    
            <div class ="col-md-2">
                <label for=""> '.$bps. ' &nbsp;/ '.$bpd. '</label>
             </div>
              
        </div>
        
        ';
        echo $output;   
        // return response()->json([
        //     'status'     => '200'
        // ]);   
        // dd($data_show2);
        
        // return response()->json([
        //     // 'status'                => '200',
        //     'data_shows'             =>  $data_show2
        // ]);
    }

   


 }
