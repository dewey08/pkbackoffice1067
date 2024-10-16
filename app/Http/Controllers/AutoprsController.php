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
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Cctv_list;
use App\Models\Cctv_check;
use App\Models\Article_status;
use App\Models\Land;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
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
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class AutoprsController extends Controller
 { 
    public function line_cctvcheck(Request $request)
    {
        $date         = date('Y-m-d');
        $y            = date('Y') + 543;
        $months       = date('m');
        $year         = date('Y'); 
        $newdays      = date('Y-m-d', strtotime($date . ' -1 days'));//ย้อนหลัง 1 วัน
        $newweek_plus = date('Y-m-d', strtotime($date . ' +1 week')); //ไปหน้า 1 สัปดาห์
        $newweek      = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate      = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear      = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser       = Auth::user()->id;
        $bgs_year     = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow   = $bgs_year->leave_year_id;
        
         //แจ้งเตือน 
         function DateThailine($strDate)
         {
             $strYear = date("Y", strtotime($strDate)) + 543;
             $strMonth = date("n", strtotime($strDate));
             $strDay = date("j", strtotime($strDate));

             $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
             $strMonthThai = $strMonthCut[$strMonth];
             return "$strDay $strMonthThai $strYear";
         }

        $lastday_     = DB::table('cctv_check')->orderBy('cctv_check_date', 'DESC')->latest()->first();
        $lastday      = $lastday_->cctv_check_date; 
        $usercheck    = $lastday_->cctv_user_id;
        $newweek      = date('Y-m-d', strtotime($lastday . ' +1 week')); //เพิ่ม 1 สัปดาห์
        $sendate_last = DateThailine($lastday);
        $datesend    = date('Y-m-d');
        $sendate     = DateThailine($datesend);

        $data_users  = DB::table('users')->where('id', '=', $usercheck)->first();
        $checkname  = $data_users->fname.' '.$data_users->lname;
 
        $header     = "ถึงเวลาตรวจสอบกล้องวงจรปิด";
        $header_sub = "รายการซ่อม";
        $message    =  $header. 
                "\n" . "วันที่เช็คล่าสุด: " . $sendate_last. 
                "\n" . "ผู้ตรวจสอบ : " . $checkname."";

        $linesend_tech = "YNWHjzi9EA6mr5myMrcTvTaSlfOMPHMOiCyOfeSJTHr"; //ช่างซ่อม
        $linesend      = "u0prMwfXLUod8Go1E0fJUxmMaLUmC40tBgcHgbHFgNG";  // พรส   
        if ($linesend == null) {
            $test = '';
        } else {
            $test = $linesend;
        }
        if ($test !== '' && $test !== null) {
            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {
                $result_ = json_decode($result, true);                        
            }
            curl_close($chOne); 
        }
        
        // return response()->json([
        //     'status'     => '200'
        // ]);
        
    }
      

 }