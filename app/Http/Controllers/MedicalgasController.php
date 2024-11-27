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
use App\Models\Air_stock_month;
use App\Models\Fire;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Air_report_ploblems_sub;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Air_plan_excel;
use App\Models\Air_plan;
use App\Models\Cctv_list;
use App\Models\Air_report_ploblems;
use App\Models\Air_repaire_supexcel;
use App\Models\Air_repaire_excel;
use App\Models\Article_status;
use App\Models\Air_repaire;
use App\Models\Gas_list;
use App\Models\Gas_check;
use App\Models\Air_repaire_sub;
use App\Models\Air_repaire_ploblem;
use App\Models\Air_repaire_ploblemsub;
use App\Models\Air_maintenance;
use App\Models\Air_maintenance_list;
use App\Models\Product_budget;
use App\Models\Air_plan_month;
use App\Models\Air_temp_ploblem;
use App\Models\Gas_dot_control;
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
use Str;
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


class MedicalgasController extends Controller
 {  
    public function medicalgas_db(Request $request)
    {        
        $months = date('m');
        $year = date('Y'); 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date_now    = date('Y-m-d');
        $y           = date('Y') + 543;  
        $data['budget_year'] = DB::table('budget_year')->get();
        $newdays     = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew     = date('Y');
        $year_old    = date('Y')-1; 
        $startdate   = (''.$year_old.'-10-01');
        $enddate     = (''.$yearnew.'-09-30'); 
        $iduser      = Auth::user()->id;
        // dd($years);
        $datashow = DB::select(
            'SELECT s.air_supplies_id,s.supplies_name,COUNT(air_repaire_id) as c_repaire           
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = a.air_staff_id 
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id
                GROUP BY a.air_supplies_id
        '); 
  
        // $data['count_air'] = Air_list::where('active','Y')->count();
        

        return view('support_prs.gas.medicalgas_db',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function medicalgas_list(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $datashow = DB::select('SELECT * FROM gas_list WHERE gas_year = "'.$bg_yearnow.'" AND active ="Ready" ORDER BY gas_list_id DESC'); 
        // WHERE active="Y"
        return view('support_prs.gas.medicalgas_list',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_list(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }
     
        return view('support_prs.gas.gas_check_list',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
          
        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_unit']       = Product_unit::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['building_data']      = DB::table('building_data')->get();

        return view('support_prs.gas.gas_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            // 'data_edit'     => $data_edit,
        ]);
    }
    public function gas_save(Request $request)
    {
        $gas_listnum = $request->gas_list_num;
        $add                     = new Gas_list();
        $add->gas_year           = $request->gas_year;
        $add->gas_recieve_date   = $request->gas_recieve_date;
        $add->gas_list_num       = $gas_listnum;
        $add->gas_list_name      = $request->gas_list_name;
        $add->gas_price          = $request->gas_price;
        $add->active             = $request->active; 
        $add->size               = $request->size; 
        $add->class              = $request->class;   
        $add->detail             = $request->detail; 
        
        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first(); 
            $add->location_id   = $losave->building_id;
            $add->location_name = $losave->building_name;
        } else { 
            $add->location_id   = '';
            $add->location_name = '';
        }

        $branid = $request->input('gas_brand');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->gas_brand = $bransave->brand_id;
        } else { 
            $add->gas_brand = '';
        }

        $uniid = $request->input('gas_unit');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $add->gas_unit = $unisave->unit_id;
        } else {         
            $add->gas_unit = '';
        }
 
        if ($request->hasfile('gas_img')) {
            $image_64 = $request->file('gas_img');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $gas_listnum. '.' . $extention;
            $request->gas_img->storeAs('gas', $filename, 'public');    
            $add->gas_img            = $filename;
            $add->gas_imgname        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('gas_img'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('gas_img'))); 
            } 
            $add->gas_img_base       = $file64; 
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function gas_edit(Request $request,$id)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
          
        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_unit']       = Product_unit::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['building_data']      = DB::table('building_data')->get();
     
        $data_edit              = DB::table('gas_list')->where('gas_list_id',$id)->first();

        return view('support_prs.gas.gas_edit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'data_edit'     => $data_edit,
        ]);
    }
    public function gas_update(Request $request)
    {
        $id = $request->gas_list_id;
        $gas_listnum = $request->gas_list_num;
        $update                     = Gas_list::find($id);
        $update->gas_year           = $request->gas_year;
        $update->gas_recieve_date   = $request->gas_recieve_date;
        $update->gas_list_num       = $gas_listnum;
        $update->gas_list_name      = $request->gas_list_name;
        $update->gas_price          = $request->gas_price;
        $update->active             = $request->active; 
        $update->size               = $request->size; 
        $update->class              = $request->class;   
        $update->detail             = $request->detail; 
        
        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first(); 
            $update->location_id   = $losave->building_id;
            $update->location_name = $losave->building_name;
        } else { 
            $update->location_id   = '';
            $update->location_name = '';
        }

        $branid = $request->input('gas_brand');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->gas_brand = $bransave->brand_id;
        } else { 
            $update->gas_brand = '';
        }

        $uniid = $request->input('gas_unit');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $update->gas_unit = $unisave->unit_id;
        } else {         
            $update->gas_unit = '';
        }
 
        if ($request->hasfile('gas_img')) {
            $description = 'storage/gas/' . $update->gas_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('gas_img');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $gas_listnum. '.' . $extention;
            $request->gas_img->storeAs('gas', $filename, 'public');    
            $update->gas_img            = $filename;
            $update->gas_imgname        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('gas_img'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('gas_img'))); 
            } 
            $update->gas_img_base       = $file64; 
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }



    // Tank Main
    public function gas_check_tank(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="1" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="1" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }

        // $data_                  = DB::table('gas_list')->where('gas_type','1')->where('gas_year',$bg_yearnow)->first();
        // $data['gas_list_id']    = $data_->gas_list_id;
        // $data['gas_type']       = $data_->gas_type;
     
        return view('support_prs.gas.gas_check_tank',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tankadd(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC  
            '); 
        }

        $data_                  = DB::table('gas_list')->where('gas_type','1')->where('gas_year',$bg_yearnow)->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
     
        return view('support_prs.gas.gas_check_tankadd',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tank_save(Request $request)
    {
        $datenow       = date('Y-m-d');
        $months        = date('m');
        $year          = date('Y'); 
        $m             = date('H');
        $mm            = date('H:m:s');
        $datefull      = date('Y-m-d H:m:s');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $iduser        = Auth::user()->id;
        $name_         = User::where('id', '=',$iduser)->first();
        $name_check    = $name_->fname. '  '.$name_->lname;
        $list      = DB::table('gas_list')->where('gas_list_id',$request->gas_list_id)->where('gas_year',$bg_yearnow)->first();

        Gas_check::insert([
            'check_year'           =>  $bg_yearnow,
            'check_date'           =>  $request->check_date,
            'check_time'           =>  $mm,
            'gas_list_id'          =>  $request->gas_list_id,
            'gas_list_num'         =>  $list->gas_list_num,
            'gas_list_name'        =>  $list->gas_list_name,
            'size'                 =>  $list->size,
            'gas_type'             =>  $request->gas_type,
            'standard_value'       =>  $request->standard_value,
            'standard_value_min'   =>  $request->standard_value_min,
            'pressure_value'       =>  $request->pressure_value,
            'pariman_value'        =>  $request->pariman_value,
            'user_id'              =>  $iduser
        ]);
         
                //แจ้งเตือนไลน์
                // if ($request->pariman_value < '50') {
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
                $header = "ตรวจสอบออกซิเจนเหลว(Main)";                                    
                $message =  $header. 
                "\n" . "วันที่ตรวจสอบ: " . DateThailine($request->check_date).
                "\n" . "เวลา : " . $mm ."". 
                "\n" . "ปริมาณมาตรฐาน : 124 inH2O". 
                "\n" . "ปริมาณวัดได้ : " . $request->pariman_value . 
                "\n" . "แรงดันมาตรฐาน : 5-12 bar". 
                "\n" . "ค่าแรงดันวัดได้ : " . $request->pressure_value.
                "\n" . "ผู้ตรวจสอบ : " . $name_check;

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

                if ($linesend_tech == null) {
                    $test2 = '';
                } else {
                    $test2 = $linesend_tech;
                }
                if ($test2 !== '' && $test2 !== null) {
                    $chOne_tech = curl_init();
                    curl_setopt($chOne_tech, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($chOne_tech, CURLOPT_POST, 1);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt($chOne_tech, CURLOPT_FOLLOWLOCATION, 1);
                    $headers2 = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test2 . '',);
                    curl_setopt($chOne_tech, CURLOPT_HTTPHEADER, $headers2);
                    curl_setopt($chOne_tech, CURLOPT_RETURNTRANSFER, 1);
                    $result2 = curl_exec($chOne_tech);
                    if (curl_error($chOne_tech)) {
                        echo 'error:' . curl_error($chOne_tech);
                    } else {
                        $result_2 = json_decode($result2, true);                        
                    }
                    curl_close($chOne_tech); 
                }

                // }
                //แจ้งเตือนไลน์
                // if ($request->pressure_value < '5') {                    
                // }
        

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function gas_check_tankedit(Request $request,$id)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
          
        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
     
        $data_edit              = DB::table('gas_check')->where('gas_check_id',$id)->first();

        return view('support_prs.gas.gas_check_tankedit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'data_edit'     => $data_edit,
        ]);
    }
    public function gas_check_tank_update(Request $request)
    { 
        $gas_check_id  = $request->gas_check_id;
        
        Gas_check::where('gas_check_id',$gas_check_id)->update([ 
            'pressure_value'       =>  $request->pressure_value,
            'pariman_value'        =>  $request->pariman_value, 
        ]);
         
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function gas_qrcode(Request $request)
    {  
            $dataprint_main = Gas_list::get();
           
        return view('support_prs.gas.gas_qrcode', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function gas_check_destroy(Request $request,$id)
    {
        $del = Gas_check::find($id);  
        // $description = 'storage/air/'.$del->air_imgname;
        // if (File::exists($description)) {
        //     File::delete($description);
        // }
        $del->delete(); 
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    } 

    //Thank Sub 
    public function gas_check_tanksub(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }

        // $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        // $data['gas_list_id']    = $data_->gas_list_id;
        // $data['gas_type']       = $data_->gas_type;
     
        return view('support_prs.gas.gas_check_tanksub',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tanksub_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        // $datashow = DB::select(
        //     'SELECT a.*,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name,b.gas_check_pressure,b.gas_check_pressure_name,month(b.check_date) as months,b.check_date
        //     FROM gas_list a
        //     LEFT JOIN gas_check b ON b.gas_list_id = a.gas_list_id
        //     WHERE a.active = "Ready" AND a.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'" 
        //     GROUP BY a.gas_list_id
        //     ORDER BY a.gas_list_id ASC
        // '); 
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size 
       
            ,(SELECT month(check_date) FROM gas_check WHERE month(check_date) ="'.$months.'" LIMIT 1) as months
            ,(SELECT gas_check_body FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body
            ,(SELECT gas_check_body_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body_name
            ,(SELECT gas_check_valve FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve 
            ,(SELECT gas_check_valve_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve_name 
            ,(SELECT gas_check_pressure FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure
            ,(SELECT gas_check_pressure_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure_name
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
            FROM gas_list a 
            WHERE a.gas_type IN("2") AND a.gas_year = "'.$bg_yearnow.'" 
            GROUP BY a.gas_list_num
            ORDER BY a.gas_list_id ASC 
        ');              
        // AND month(b.check_date) = "'.$month.'"
        // $datashow = DB::select(
        //     'SELECT a.*
        //     FROM gas_list a         
        //     WHERE a.active = "Ready" AND a.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'" 
        //     GROUP BY a.gas_list_id
        //     ORDER BY a.gas_list_id ASC
        // ');  
        return view('support_prs.gas.gas_check_tanksub_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }

    public function gas_check_tanksub_save(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;

                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->where('gas_year',$bg_yearnow)->first();
                $gas_list_id   = $idgas->gas_list_id; 
                $gas_list_num  = $idgas->gas_list_num; 
                $gas_list_name = $idgas->gas_list_name; 
                $size          = $idgas->size; 
                $gas_type      = $idgas->gas_type; 
                 
                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;

               

                $body_    = $request->gas_check_body;
                if ($body_ == '0') {
                    $body  = 'พร้อมใช้';
                } else {
                    $body  = 'ไม่พร้อมใช้';
                }

                $check_valve_     = $request->gas_check_valve;
                if ($check_valve_ == '0') {
                    $check_valve  = 'พร้อมใช้';
                } else {
                    $check_valve  = 'ไม่พร้อมใช้';
                }

                $pressure_        = $request->gas_check_pressure;
                if ($pressure_ == '0') {
                    $pressure  = 'พร้อมใช้';
                } else {
                    $pressure  = 'ไม่พร้อมใช้';
                }
                
                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([ 
                        // 'check_year'               => $y,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_, 
                        'gas_check_pressure_name'  => $pressure, 
                        'user_id'                  => $iduser, 
                    ]);
                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                } else {
                    Gas_check::insert([
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_, 
                        'gas_check_pressure_name'  => $pressure, 
                        'user_id'                  => $iduser, 
                    ]);

                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                }
                
                // $data  = array(
                //     // 'cctv_check_date'            => $date,
                //     'gas_check_body'        => $request->gas_check_body,
                //     'gas_check_valve'       => $request->gas_check_valve,
                //     'gas_check_pressure'    => $request->gas_check_pressure, 
                // );
                // DB::connection('mysql')->table('cctv_list')
                //     ->where('cctv_list_num', $request->cctv_list_num)
                //     ->update($data);
            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }
    // public function gas_check_tanksub_saveall(Request $request)
    // {
    //     $check_date = $request->check_date;
    //     $gas_insert = Gas_check::where('check_date', '=',$check_date)->get();

    //     foreach ($gas_insert as $key => $value) {
    //         # code...
    //     }
    //     return response()->json([
    //         'status'     => '200'
    //     ]);
    // }

    //ไนตรัสออกไซด์ (N2O-6Q)
    public function gas_check_nitrus(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="5" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="5" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }
 
        return view('support_prs.gas.gas_check_nitrus',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_nitrus_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size 
            ,(SELECT gas_check_body FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body
            ,(SELECT gas_check_body_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body_name
            ,(SELECT gas_check_valve FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve 
            ,(SELECT gas_check_valve_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve_name 
            ,(SELECT gas_check_pressure FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure
            ,(SELECT gas_check_pressure_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure_name
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
            FROM gas_list a 
            WHERE a.gas_type IN("5") AND a.gas_year = "'.$bg_yearnow.'" 
            GROUP BY a.gas_list_num
            ORDER BY a.gas_list_id ASC 
        ');          
        // ,b.check_date
        return view('support_prs.gas.gas_check_nitrus_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'datenow'       => $datenow,
        ]);
    }
    public function gas_check_nitrus_save(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->action);
            if ($request->action == 'Edit') {
                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->first();
                $gas_list_id   = $idgas->gas_list_id; 
                $gas_list_num  = $idgas->gas_list_num; 
                $gas_list_name = $idgas->gas_list_name; 
                $size          = $idgas->size; 
                $gas_type      = $idgas->gas_type; 
                 
                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                // dd($gas_list_id);

                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;
                // dd($check);
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;
                // $active    = $request->active;
                $body_    = $request->gas_check_body;
                if ($body_ == '0') {
                    $body  = 'พร้อมใช้';
                } else {
                    $body  = 'ไม่พร้อมใช้';
                }

                $check_valve_     = $request->gas_check_valve;
                if ($check_valve_ == '0') {
                    $check_valve  = 'พร้อมใช้';
                } else {
                    $check_valve  = 'ไม่พร้อมใช้';
                }

                $pressure_        = $request->gas_check_pressure;
                if ($pressure_ == '0') {
                    $pressure  = 'พร้อมใช้';
                } else {
                    $pressure  = 'ไม่พร้อมใช้';
                }
                

                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([ 
                        'check_date'         => $date,
                        // 'active'             => $active, 
                        'user_id'            => $iduser, 
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_, 
                        'gas_check_pressure_name'  => $pressure, 
                        'user_id'                  => $iduser, 
                    ]);
                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                } else {
                    Gas_check::insert([ 
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_, 
                        'gas_check_pressure_name'  => $pressure, 
                        'user_id'                  => $iduser,
                        // 'active'                   => $active, 
                    ]);

                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                }
                


                // if ($check > 0) {
                //     // Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([  
                //     //     'check_date'         => $date,
                //     //     'active'             => $active, 
                //     //     'user_id'            => $iduser, 
                //     // ]);
                //     // Gas_list::where('gas_list_id', $gas_list_id)->update([  
                //     //     'active'             => $active, 
                //     //     'user_id'            => $iduser, 
                //     // ]);
                // } else {
                //     Gas_check::insert([
                //         'check_year'               => $y,
                //         'check_date'               => $date,
                //         'check_time'               => $mm,
                //         'gas_list_id'              => $gas_list_id,
                //         'gas_list_num'             => $gas_list_num,
                //         'gas_list_name'            => $gas_list_name,
                //         'size'                     => $size,
                //         'gas_type'                 => $gas_type,
                //         'active'                   => $active, 
                //         // 'gas_check_body'           => $body_,
                //         // 'gas_check_body_name'      => $body,
                //         // 'gas_check_valve'          => $check_valve_,
                //         // 'gas_check_valve_name'     => $check_valve,
                //         // 'gas_check_pressure'       => $pressure_, 
                //         // 'gas_check_pressure_name'  => $pressure, 
                //         'user_id'                  => $iduser, 
                //     ]);
                //     Gas_list::where('gas_list_id', $gas_list_id)->update([  
                //         'active'             => $active, 
                //         'user_id'            => $iduser, 
                //     ]);
                //     // if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                //     //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                //     // } else {
                //     //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                //     // }
                // }
              
            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }
    

    //ก๊าซอ๊อกซิเจน (2Q-6Q)
    public function gas_check_o2(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value,a.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$newweek.'" AND "'.$datenow.'" AND b.gas_type IN("3","4") AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value,a.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("3","4") AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }
 
        return view('support_prs.gas.gas_check_o2',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_o2_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        // $datashow = DB::select(
        //     'SELECT a.*,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name,b.gas_check_pressure,b.gas_check_pressure_name,b.check_date
        //     ,(SELECT check_date FROM gas_check WHERE gas_list_id = a.gas_list_id AND check_date ="'.$datenow.'") as check_date_b
        //     FROM gas_list a
        //     LEFT JOIN gas_check b ON b.gas_list_id = a.gas_list_id
        //     WHERE a.gas_type IN("3","4") AND a.gas_year = "'.$bg_yearnow.'"  
        //     GROUP BY a.gas_list_num
        //     ORDER BY a.gas_list_id ASC
        // ');    
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size
            ,(SELECT active FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as active 
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
                FROM gas_list a 
                WHERE a.gas_type IN("3","4") AND a.gas_year = "'.$bg_yearnow.'" 
                GROUP BY a.gas_list_num
                ORDER BY a.gas_list_id ASC 
        ');            
        // ,b.check_date
        return view('support_prs.gas.gas_check_o2_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'datenow'       => $datenow,
        ]);
    }
    public function gas_check_o2_save(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->first();
                $gas_list_id   = $idgas->gas_list_id; 
                $gas_list_num  = $idgas->gas_list_num; 
                $gas_list_name = $idgas->gas_list_name; 
                $size          = $idgas->size; 
                $gas_type      = $idgas->gas_type; 
                 
                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;
                // dd($gas_list_id);
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;

                $active    = $request->active;
                // if ($active_ == '0') {
                //     $active  = 'พร้อมใช้';
                // } elseif($active_ == '1') {
                //     $active  = 'NotReady';
                // } elseif($active_ == '2') {
                //     $active  = 'รอเติม';
                // } elseif($active_ == '3') {
                //     $active  = 'ยืมคืน';
                // } else {
                //     $active  = 'จำหน่าย';
                // }               
                
                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([  
                        'check_date'         => $date,
                        'active'             => $active, 
                        'user_id'            => $iduser, 
                    ]);
                    Gas_list::where('gas_list_id', $gas_list_id)->update([  
                        'active'             => $active, 
                        'user_id'            => $iduser, 
                    ]);
                } else {
                    Gas_check::insert([
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'active'                   => $active, 
                        // 'gas_check_body'           => $body_,
                        // 'gas_check_body_name'      => $body,
                        // 'gas_check_valve'          => $check_valve_,
                        // 'gas_check_valve_name'     => $check_valve,
                        // 'gas_check_pressure'       => $pressure_, 
                        // 'gas_check_pressure_name'  => $pressure, 
                        'user_id'                  => $iduser, 
                    ]);
                    Gas_list::where('gas_list_id', $gas_list_id)->update([  
                        'active'             => $active, 
                        'user_id'            => $iduser, 
                    ]);
                    // if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                    //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    // } else {
                    //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    // }
                }
              
            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }

    public function gas_control(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value,a.active
                ,b.oxygen_check,b.nitrous_oxide_check,b.pneumatic_air_check,b.vacuum_check
                ,c.location_name,c.detail,c.class
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN gas_dot_control c ON c.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$newweek.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9") AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value,a.active
                ,b.oxygen_check,b.nitrous_oxide_check,b.pneumatic_air_check,b.vacuum_check
                ,c.location_name,c.detail,c.class
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN gas_dot_control c ON c.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9") AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC  
            '); 
        }
 
        return view('support_prs.gas.gas_control',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC  
            '); 
        }

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $data['gas_list_group'] = $datashow = DB::select('SELECT gas_list_id,dot,dot_name,location_name,detail,class FROM gas_list WHERE dot IS NOT NULL AND gas_year ="'.$bg_yearnow.'" GROUP BY dot');
     
        return view('support_prs.gas.gas_control_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_addsave(Request $request)
    {
        Gas_dot_control::truncate();
        $id = $request->dot;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data_  = DB::table('gas_list')->where('gas_list_id',$id)->where('gas_year',$bg_yearnow)->first();
                
            Gas_dot_control::insert([
                'dot'               => $data_->dot,
                'gas_list_id'       => $id,
                'gas_list_num'      => $data_->gas_list_num,
                'gas_list_name'     => $data_->gas_list_name,
                'gas_type'          => $data_->gas_type,
                'dot_name'          => $data_->dot_name,
                'location_id'       => $data_->location_id,
                'location_name'     => $data_->location_name,
                'detail'            => $data_->detail,
                'class'             => $data_->class, 
            ]);
             
            return response()->json([
                'status'     => '200'
            ]);
            
    }
    public function gas_control_addsub(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC 
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname 
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id 
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC  
            '); 
        }

        $data_                  = DB::table('gas_dot_control')->where('gas_dot_control_id','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_list_num']   = $data_->gas_list_num;
        $data['gas_list_name']  = $data_->gas_list_name;
        $data['gas_type']       = $data_->gas_type;
        $data['dot']            = $data_->dot;
        $data['dot_name']       = $data_->dot_name;
        $data['location_id']    = $data_->location_id;
        $data['location_name']  = $data_->location_name;
        $data['detail']         = $data_->detail;
        $data['class']          = $data_->class;
       
        

        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $data['gas_list_group'] = $datashow = DB::select('SELECT gas_list_id,dot,dot_name,location_name,detail,class FROM gas_list WHERE dot IS NOT NULL GROUP BY dot');
     
        return view('support_prs.gas.gas_control_addsub',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_addsub_save(Request $request)
    {
         
                $idgas         = Gas_list::where('gas_list_id', $request->gas_list_id)->first();
                $gas_list_id   = $idgas->gas_list_id; 
                $gas_list_num  = $idgas->gas_list_num; 
                $gas_list_name = $idgas->gas_list_name; 
                $size          = $idgas->size; 
                $gas_type      = $idgas->gas_type; 
                 
                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;
                $name_         = User::where('id', '=',$iduser)->first();
                $name_check    = $name_->fname. '  '.$name_->lname;
                if ($check > 0) {
                    // Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([  
                    //     'check_date'         => $date,
                    //     'active'             => $active, 
                    //     'user_id'            => $iduser, 
                    // ]);
                    // Gas_list::where('gas_list_id', $gas_list_id)->update([  
                    //     'active'             => $active, 
                    //     'user_id'            => $iduser, 
                    // ]);
                } else {
                    Gas_check::insert([
                        'check_year'               => $y,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'active'                   => $request->active_edit,  
                        'user_id'                  => $iduser, 

                        'oxygen_check'            => $request->oxygen_check,
                        'nitrous_oxide_check'     => $request->nitrous_oxide_check,
                        'pneumatic_air_check'     => $request->pneumatic_air_check,
                        'vacuum_check'            => $request->vacuum_check,
                    ]);
                    // Gas_list::where('gas_list_id', $gas_list_id)->update([  
                        // 'active'             => $active, 
                        // 'user_id'            => $iduser, 
                    // ]);

                    if ( $request->active_edit == 'Ready') {
                        $active = 'พร้อมใช้งาน';
                    } else {
                        $active = 'ไม่พร้อมใช้งาน';
                    }
                    

                    //แจ้งเตือนไลน์
                    // if ($request->pariman_value < '50') {
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
                    $header = "ตรวจสอบ Control Gas";                                    
                    $message =  $header. 
                    "\n" . "วันที่ตรวจสอบ: " . DateThailine($date).
                    "\n" . "เวลา : " . $mm ."". 
                    "\n" . "อาคาร : " . $request->location_name .  
                    "\n" . "ชั้น : " . $request->class_edit .  
                    "\n" . "จุดตรวจเช็ค : " . $request->dot_name .  
                    "\n" . "Oxygen Control : " . $request->oxygen_check .  
                    "\n" . "Nitrous oxide Control : " . $request->nitrous_oxide_check . 
                    "\n" . "Pneumatic Air Control : " . $request->pneumatic_air_check . 
                    "\n" . "Vacuum Control : " . $request->vacuum_check.
                    "\n" . "ผู้ตรวจสอบ : " . $name_check.
                    "\n" . "สถานะ : " . $active;

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

                    if ($linesend_tech == null) {
                        $test2 = '';
                    } else {
                        $test2 = $linesend_tech;
                    }
                    if ($test2 !== '' && $test2 !== null) {
                        $chOne_tech = curl_init();
                        curl_setopt($chOne_tech, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($chOne_tech, CURLOPT_POST, 1);
                        curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, $message);
                        curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, "message=$message");
                        curl_setopt($chOne_tech, CURLOPT_FOLLOWLOCATION, 1);
                        $headers2 = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test2 . '',);
                        curl_setopt($chOne_tech, CURLOPT_HTTPHEADER, $headers2);
                        curl_setopt($chOne_tech, CURLOPT_RETURNTRANSFER, 1);
                        $result2 = curl_exec($chOne_tech);
                        if (curl_error($chOne_tech)) {
                            echo 'error:' . curl_error($chOne_tech);
                        } else {
                            $result_2 = json_decode($result2, true);                        
                        }
                        curl_close($chOne_tech); 
                    }
                  
                    return response()->json([
                        'status'     => '200'
                    ]); 

                }
              
                return response()->json([
                    'status'     => '100'
                ]); 
           
        
        }

 }