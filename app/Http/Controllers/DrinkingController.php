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
use App\Models\Water_check;
use App\Models\Water_filter;
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


class DrinkingController extends Controller
 {  
    public function drinking_water_db(Request $request)
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
            'SELECT * FROM water_filter 
        '); 
  
        // $data['count_air'] = Air_list::where('active','Y')->count();
        

        return view('support_prs.water.drinking_water_db',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function drinking_water_list(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $datashow = DB::select('SELECT * FROM water_filter WHERE water_year = "'.$bg_yearnow.'" AND active ="Y" ORDER BY water_filter_id ASC'); 
        // WHERE active="Y"
        return view('support_prs.water.drinking_water_list',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function drinking_qrcode(Request $request)
    {  
            $dataprint = Water_filter::get();

        return view('support_prs.water.drinking_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }  
    public function drinking_water_check(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        // $datashow = DB::select('SELECT * FROM water_check WHERE water_year = "'.$bg_yearnow.'" ORDER BY water_check_id ASC'); 
        $datashow = DB::select(
            'SELECT a.*
              ,(SELECT location_name FROM water_filter WHERE water_filter_id = a.water_filter_id AND water_year ="'.$bg_yearnow.'") as location_name
              ,(SELECT class FROM water_filter WHERE water_filter_id = a.water_filter_id AND water_year ="'.$bg_yearnow.'") as class
              ,(SELECT detail FROM water_filter WHERE water_filter_id = a.water_filter_id AND water_year ="'.$bg_yearnow.'") as detail

              
            FROM water_check a 
            WHERE a.check_year = "'.$bg_yearnow.'" AND a.check_date BETWEEN "'.$newweek.'" AND "'.$datenow.'"
            GROUP BY a.water_code
            ORDER BY a.water_check_id ASC 
        ');    
        // WHERE active="Y"
        return view('support_prs.water.drinking_water_check',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function drinking_mobilecheck(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $data['date_now']   = date('Y-m-d');
        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_unit']       = Product_unit::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['building_data']      = DB::table('building_data')->get();
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
        return view('support_prs.water.drinking_mobilecheck',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            // 'data_edit'     => $data_edit,
        ]);
    }
    public function drinking_water_add(Request $request)
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

        return view('support_prs.water.drinking_water_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            // 'data_edit'     => $data_edit,
        ]);
    }
    public function drinking_water_mobileadd(Request $request)
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

        return view('support_prs.water.drinking_water_mobileadd',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            // 'data_edit'     => $data_edit,
        ]);
    }
    public function drinking_water_save(Request $request)
    {
        $water_code = $request->water_code;
        $add                       = new Water_filter();
        $add->water_year           = $request->water_year;
        $add->water_recieve_date   = $request->water_recieve_date;
        $add->water_code           = $water_code;
        $add->water_name           = $request->water_name;
        $add->water_num            = $request->water_num;
        $add->water_price          = $request->water_price;
        $add->active               = $request->active; 
        $add->size                 = $request->size; 
        $add->class                = $request->class;   
        $add->detail               = $request->detail; 
        
        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first(); 
            $add->location_id   = $losave->building_id;
            $add->location_name = $losave->building_name;
        } else { 
            $add->location_id   = '';
            $add->location_name = '';
        }

        $branid = $request->input('brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->brand_id = $bransave->brand_id;
        } else { 
            $add->brand_id = '';
        }

        $uniid = $request->input('unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $add->unit_id = $unisave->unit_id;
        } else {         
            $add->unit_id = '';
        }
 
        if ($request->hasfile('water_img')) {
            $image_64 = $request->file('water_img');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $water_code. '.' . $extention;
            $request->water_img->storeAs('water', $filename, 'public');    
            $add->water_img            = $filename;
            $add->water_imgname        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('water_img'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('water_img'))); 
            } 
            $add->water_img_base       = $file64; 
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function drinking_water_edit(Request $request,$id)
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
     
        $data_edit              = DB::table('water_filter')->where('water_filter_id',$id)->first();

        return view('support_prs.water.drinking_water_edit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'data_edit'     => $data_edit,
        ]);
    }
    public function drinking_water_mobileedit(Request $request,$id)
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
     
        $data_edit              = DB::table('water_filter')->where('water_filter_id',$id)->first();

        return view('support_prs.water.drinking_water_mobileedit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'data_edit'     => $data_edit,
        ]);
    }
    public function drinking_water_update(Request $request)
    {
        $id = $request->water_filter_id;
        $water_code = $request->water_code;
        $update                     = Water_filter::find($id);
        $update->water_year           = $request->water_year;
        $update->water_recieve_date   = $request->water_recieve_date;
        $update->water_code           = $water_code;
        $update->water_name           = $request->water_name;
        $update->water_num            = $request->water_num;
        $update->water_price          = $request->water_price;
        $update->active               = $request->active; 
        $update->size                 = $request->size; 
        $update->class                = $request->class;   
        $update->detail               = $request->detail; 

        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first(); 
            $update->location_id   = $losave->building_id;
            $update->location_name = $losave->building_name;
        } else { 
            $update->location_id   = '';
            $update->location_name = '';
        }

        $branid = $request->input('brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->brand_id = $bransave->brand_id;
        } else { 
            $update->brand_id = '';
        }

        $uniid = $request->input('unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $update->unit_id = $unisave->unit_id;
        } else {         
            $update->unit_id = '';
        }
 
        if ($request->hasfile('water_img')) {
            $description = 'storage/water/' . $update->water_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('water_img');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $water_code. '.' . $extention;
            $request->water_img->storeAs('water', $filename, 'public');    
            $update->water_img            = $filename;
            $update->water_imgname        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('water_img'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('water_img'))); 
            } 
            $update->water_img_base       = $file64; 
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function drinking_check_add(Request $request, $id)
    {  
        if (Auth::check()) {
            $type      = Auth::user()->type;
            $iduser    = Auth::user()->id;
            $iddep     = Auth::user()->dep_subsubtrueid;
            $wt     = Auth::user()->per_water; 

            if ($wt == 'on') {
                    $datenow      = date('Y-m-d');
                    $months       = date('m');
                    $year         = date('Y'); 
                    $data['mm']   = date('H:m:s');
                    $startdate    = $request->startdate;
                    $enddate      = $request->enddate;
                    $newweek      = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
                    $newDate      = date('Y-m-d', strtotime($datenow . ' -5 months')); //ย้อนหลัง 5 เดือน 
                
                    $data_detail = Water_check::leftJoin('users', 'water_check.user_id', '=', 'users.id') 
                    ->leftJoin('water_filter', 'water_filter.water_filter_id', '=', 'water_check.water_filter_id') 
                    ->where('water_check.water_filter_id', '=', $id)
                    ->get();

                    $data['date_now']                = date('Y-m-d');
                    $users_tech_out_                 = DB::table('users')->where('id','=',$iduser)->first();
                    $data['users_tech_out']          = $users_tech_out_->fname.'  '.$users_tech_out_->lname; 
                    $data['users_tech_out_id']       = $users_tech_out_->id;   
                    $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
                    $data['air_maintenance_list']    = DB::table('air_maintenance_list')->get();
                    $data['users']                   = DB::table('users')->get();
                    $data['air_type']                = DB::table('air_type')->get();
                    $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get();
                    $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
                    // $data_detail_                    = Water_filter::where('water_filter_id', '=', $id)->first();
                    $data_detail_                    = Water_filter::where('water_filter_id', '=', $id)->first();
                    $data['water_filter_id']         = $data_detail_->water_filter_id;
                    $data['water_code']              = $data_detail_->water_code;
                    $data['water_name']              = $data_detail_->water_name;
                    $data['location_name']           = $data_detail_->location_name;
                    $data['class']                   = $data_detail_->class;
                    $data['detail']                  = $data_detail_->detail;

                    $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 
                    return view('support_prs.water.drinking_check_add',$data, [ 
                    'data_detail'   => $data_detail,
                    'data_detail_'  => $data_detail_,
                    'air_no'        => $air_no,
                    'id'            => $id
                ]); 
            } else {
                return view('support_prs.water.drinking_check_null'); 
            }
 
        } else { 
                return view('support_prs.water.air_repaire_null'); 
        } 
    }
    public function drinking_check_save(Request $request)
    {
        $date          = date('Y-m-d');
        $y             = date('Y')+543;
        $m             = date('H');
        $mm            = date('H:m:s');
        $datefull      = date('Y-m-d H:m:s');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $water_filter_id           = $request->water_filter_id;
        $data_detail_              = Water_filter::where('water_filter_id', '=', $water_filter_id)->first();
        $water_filterid            = $data_detail_->water_filter_id;
        $water_code                = $data_detail_->water_code;
        $water_name                = $data_detail_->water_name;
        $location_name             = $data_detail_->location_name;
        $class                     = $data_detail_->class;
        $detail                    = $data_detail_->detail;

        if ($request->filter == 'Y') {
            $filter_name   ='พร้อมใช้งาน';
        } else {
            $filter_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->filter_tank == 'Y') {
            $filter_tank_name   ='พร้อมใช้งาน';
        } else {
            $filter_tank_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->tube == 'Y') {
            $tube_name     ='พร้อมใช้งาน';
        } else {
            $tube_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->solinoi_vaw == 'Y') {
            $solinoi_vaw_name     ='พร้อมใช้งาน';
        } else {
            $solinoi_vaw_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->lowplessor_swith == 'Y') {
            $lowplessor_swith_name     ='พร้อมใช้งาน';
        } else {
            $lowplessor_swith_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->hiplessor_swith == 'Y') {
            $hiplessor_swith_name     ='พร้อมใช้งาน';
        } else {
            $hiplessor_swith_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->water_in == 'Y') {
            $water_in_name     ='พร้อมใช้งาน';
        } else {
            $water_in_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->hot_clod == 'Y') {
            $hot_clod_name     ='พร้อมใช้งาน';
        } else {
            $hot_clod_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->pipes == 'Y') {
            $pipes_name     ='พร้อมใช้งาน';
        } else {
            $pipes_name   ='ไม่พร้อมใช้งาน';
        }
        if ($request->storage_tank == 'Y') {
            $storage_tank_name     ='พร้อมใช้งาน';
        } else {
            $storage_tank_name   ='ไม่พร้อมใช้งาน';
        }
        
            $iduser    = Auth::user()->id;
            $name_         = User::where('id', '=',$iduser)->first();
            $name_check    = $name_->fname. '  '.$name_->lname;

            $add                       = new Water_check();
            $add->check_year           = $bg_yearnow;
            $add->check_date           = $date;
            $add->check_time           = $mm;
            $add->water_filter_id      = $water_filterid;
            $add->water_code           = $water_code;
            $add->water_name           = $water_name; 
            $add->filter                = $request->filter; 
            $add->filter_name           = $filter_name; 
            $add->filter_tank           = $request->filter_tank;  
            $add->filter_tank_name      = $filter_tank_name;  
            $add->tube                  = $request->tube; 
            $add->tube_name             = $tube_name; 
            $add->solinoi_vaw           = $request->solinoi_vaw; 
            $add->solinoi_vaw_name      = $solinoi_vaw_name; 
            $add->lowplessor_swith      = $request->lowplessor_swith; 
            $add->lowplessor_swith_name = $lowplessor_swith_name; 
            $add->hiplessor_swith       = $request->hiplessor_swith;
            $add->hiplessor_swith_name  = $hiplessor_swith_name;  
            $add->water_in              = $request->water_in; 
            $add->water_in_name         = $water_in_name; 
            $add->hot_clod              = $request->hot_clod; 
            $add->hot_clod_name         = $hot_clod_name; 
            $add->pipes                 = $request->pipes;  
            $add->pipes_name            = $pipes_name;  
            $add->storage_tank          = $request->storage_tank;  
            $add->storage_tank_name     = $storage_tank_name;  
            $add->user_id               = $iduser;
            $add->save();

            if ($request->filter == 'Y' || $request->filter_tank == 'Y' || $request->tube == 'Y' || $request->solinoi_vaw == 'Y' || $request->lowplessor_swith == 'Y' || $request->hiplessor_swith == 'Y' || $request->water_in == 'Y' || $request->hot_clod == 'Y' || $request->pipes == 'Y' || $request->storage_tank == 'Y') {
                $active = 'Y';
                $active_show = 'พร้อมใช้งาน';
                Water_filter::where('water_filter_id', '=', $water_filterid)->update(['active' => $active]);
            } else {
                $active = 'N';
                $active_show = 'ไม่พร้อมใช้งาน';
                Water_filter::where('water_filter_id', '=', $water_filterid)->update(['active' => $active]);
            }
         
                    function DateThailine($strDate)
                    {
                        $strYear = date("Y", strtotime($strDate)) + 543;
                        $strMonth = date("n", strtotime($strDate));
                        $strDay = date("j", strtotime($strDate));
                        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                        $strMonthThai = $strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                    }
                    $header = "ตรวจสอบเครื่องผลิตน้ำดื่ม";                                    
                    $message =  $header. 
                    "\n" . "วันที่ตรวจสอบ: " . DateThailine($date).
                    "\n" . "เวลา : " . $mm ."". 
                    "\n" . "อาคาร : " . $location_name .  
                    "\n" . "ชั้น : " . $class .  
                    "\n" . "จุดตรวจเช็ค : " . $detail .  
                    "\n" . "ไส้กรอง : " . $filter_name .  
                    "\n" . "ถังกรองน้ำ : " . $filter_tank_name . 
                    "\n" . "หลอด UV : " . $tube_name . 
                    "\n" . "โซลินอยวาล์ว : " . $solinoi_vaw_name.
                    "\n" . "โลเพรสเซอร์สวิส : " . $lowplessor_swith_name.
                    "\n" . "ไฮเพรสเซอร์สวิส : " . $hiplessor_swith_name.
                    "\n" . "สายน้ำเข้า : " . $water_in_name.
                    "\n" . "ก๊อกน้ำร้อน-เย็น : " . $hot_clod_name.
                    "\n" . "ข้อต่อและท่อ : " . $pipes_name.
                    "\n" . "ถังเก็บน้ำกรอง : " . $storage_tank_name.
                    "\n" . "ผู้ตรวจสอบ : " . $name_check;
                    // "\n" . "สถานะ : " . $active_show;

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

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
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
        $list      = DB::table('gas_list')->where('gas_list_id',$request->gas_list_id)->first();

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
        $datashow = DB::select(
            'SELECT a.*,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name,b.gas_check_pressure,b.gas_check_pressure_name,month(b.check_date) as months,b.check_date
            FROM gas_list a
            LEFT JOIN gas_check b ON b.gas_list_id = a.gas_list_id
            WHERE a.active = "Ready" AND a.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'" 
            GROUP BY a.gas_list_id
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
                        'check_year'               => $y,
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
 

 }