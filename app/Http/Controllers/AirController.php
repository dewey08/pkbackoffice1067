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
use App\Models\Gas_list; 
use App\Models\Air_report_dep;
use App\Models\Air_report_depexcel;
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
use App\Models\Air_list;
use App\Models\Product_buy;
use App\Models\Air_repaire_sub;
use App\Models\Air_repaire_ploblem;
use App\Models\Air_repaire_ploblemsub;
use App\Models\Air_maintenance;
use App\Models\Water_filter;
use App\Models\Product_budget;
use App\Models\Air_plan_month;
use App\Models\Air_temp_ploblem;
use App\Models\Air_edit_log;
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


class AirController extends Controller
 { 
    public function home_supplies(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $repaire_type   = $request->air_repaire_type;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $idsup               = Auth::user()->air_supplies_id;
        $idtype               = Auth::user()->type;
        // dd($idtype);
        if ($idtype == 'ADMIN') {
            return view('admin',[
                'startdate'     => $startdate,
                'enddate'       => $enddate,  
                'repaire_type'  => $repaire_type,
            ]);
        } else if ($idtype == 'USER'){
            return view('user.home',[
                'startdate'     => $startdate,
                'enddate'       => $enddate,  
                'repaire_type'  => $repaire_type,
            ]); 
        } else {
            if ( $idsup != '') {
                $sup_                = DB::table('air_supplies')->where('air_supplies_id','=',$idsup)->first();
                $data['sup_name']    = $sup_->supplies_name;
                $data['sup_tel']     = $sup_->supplies_tel;
                $data['sup_address'] = $sup_->supplies_address;
            } else { 
                $data['sup_name']    = '';
                $data['sup_tel']     = '';
                $data['sup_address'] = '';
            } 
            Air_repaire_supexcel::truncate();
            if ($repaire_type == '') {
                $datashow  = DB::select(
                    'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                    ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                    ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name,"" "|")) as repaire_sub_name ,a.air_problems_orthersub
                    ,b.repaire_no,s.supplies_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_supplies_id = "'.$idsup.'"  
                    GROUP BY a.air_repaire_id 
                    ORDER BY a.air_repaire_id DESC  
                ');   
                foreach ($datashow as $key => $value) {
                    
                        Air_repaire_supexcel::insert([
                            'air_repaire_id'     => $value->air_repaire_id,
                            'repaire_date'       => $value->repaire_date,
                            'repaire_time'       => $value->repaire_time,
                            'air_repaire_no'     => $value->air_repaire_no,
                            'air_repaire_num'    => $value->air_repaire_num,
                            'air_list_num'       => $value->air_list_num,
                            'air_list_name'      => $value->air_list_name,
                            'btu'                => $value->btu,
                            'air_location_name'  => $value->air_location_name,
                            'debsubsub'          => $value->debsubsub, 
                            'repaire_sub_name'   => $value->repaire_sub_name, 
                            'staff_name'         => $value->staff_name,
                            'tect_name'          => $value->tect_name,
                            'air_techout_name'   => $value->air_techout_name,
                            'supplies_name'      => $value->supplies_name,
                        ]);
                    
                
                }
                
            } else { 
                

                if ($repaire_type == '04') {
                    $datashow  = DB::select(
                        'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                        ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                        ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                        ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                        ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name,"" "|")) as repaire_sub_name  ,a.air_problems_orthersub
                        ,b.repaire_no,s.supplies_name
                        FROM air_repaire a 
                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                        LEFT JOIN users p ON p.id = a.air_staff_id  
                        LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                        LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND b.air_repaire_type_code = "'.$repaire_type.'" AND a.air_supplies_id = "'.$idsup.'"
                        GROUP BY a.air_repaire_id 
                        ORDER BY a.air_repaire_id DESC  
                    '); 
                    foreach ($datashow as $key => $value) {
                        
                        Air_repaire_supexcel::insert([
                                'air_repaire_id'     => $value->air_repaire_id,
                                'repaire_date'       => $value->repaire_date,
                                'repaire_time'       => $value->repaire_time,
                                'air_repaire_no'     => $value->air_repaire_no,
                                'air_repaire_num'    => $value->air_repaire_num,
                                'air_list_num'       => $value->air_list_num,
                                'air_list_name'      => $value->air_list_name,
                                'btu'                => $value->btu,
                                'air_location_name'  => $value->air_location_name,
                                'debsubsub'          => $value->debsubsub, 
                                'repaire_sub_name'   => $value->repaire_sub_name, 
                                'staff_name'         => $value->staff_name,
                                'tect_name'          => $value->tect_name,
                                'air_techout_name'   => $value->air_techout_name,
                                'supplies_name'      => $value->supplies_name,
                            ]);
                        
                    }
                } else {
                    $datashow  = DB::select(
                        'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                        ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                        ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                        ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                        ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name
                        ,(select GROUP_CONCAT(distinct b.repaire_sub_name," ครั้งที่ " ,b.repaire_no, "|")) as repaire_sub_name2 
                        ,b.repaire_no,s.supplies_name
                        FROM air_repaire a 
                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                        LEFT JOIN users p ON p.id = a.air_staff_id  
                        LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                        LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                        WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND b.air_repaire_type_code = "'.$repaire_type.'" AND a.air_supplies_id = "'.$idsup.'"
                        GROUP BY a.air_repaire_id 
                        ORDER BY a.air_repaire_id DESC  
                    '); 
                    foreach ($datashow as $key => $value) { 
                        
                        Air_repaire_supexcel::insert([
                                'air_repaire_id'     => $value->air_repaire_id,
                                'repaire_date'       => $value->repaire_date,
                                'repaire_time'       => $value->repaire_time,
                                'air_repaire_no'     => $value->air_repaire_no,
                                'air_repaire_num'    => $value->air_repaire_num,
                                'air_list_num'       => $value->air_list_num,
                                'air_list_name'      => $value->air_list_name,
                                'btu'                => $value->btu,
                                'air_location_name'  => $value->air_location_name,
                                'debsubsub'          => $value->debsubsub, 
                                'repaire_sub_name'   => $value->repaire_sub_name2, 
                                'staff_name'         => $value->staff_name,
                                'tect_name'          => $value->tect_name,
                                'air_techout_name'   => $value->air_techout_name,
                                'supplies_name'      => $value->supplies_name,
                            ]);
                
                        
                        
                    }
                }            
            }
            $data['air_repaire_type']      = DB::table('air_repaire_type')->get();
            return view('supplies_tech.main_index',$data,[
                'startdate'     => $startdate,
                'enddate'       => $enddate, 
                'datashow'      => $datashow,
                'repaire_type'  => $repaire_type,
            ]);
        }
    }
    public function home_supplies_mobile(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $repaire_type   = $request->air_repaire_type;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        $idsup               = Auth::user()->air_supplies_id;
        $sup_                = DB::table('air_supplies')->where('air_supplies_id','=',$idsup)->first();
        $data['sup_name']    = $sup_->supplies_name;
        $data['sup_tel']     = $sup_->supplies_tel;
        $data['sup_address'] = $sup_->supplies_address;
       
        Air_repaire_supexcel::truncate();
        if ($repaire_type == '') {
            $datashow  = DB::select(
                'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name,"" "|")) as repaire_sub_name 
                ,b.repaire_no,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                -- WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                WHERE a.air_supplies_id = "'.$idsup.'"  
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC  LIMIT 30
            ');   
            foreach ($datashow as $key => $value) {               
                    Air_repaire_supexcel::insert([
                        'air_repaire_id'     => $value->air_repaire_id,
                        'repaire_date'       => $value->repaire_date,
                        'repaire_time'       => $value->repaire_time,
                        'air_repaire_no'     => $value->air_repaire_no,
                        'air_repaire_num'    => $value->air_repaire_num,
                        'air_list_num'       => $value->air_list_num,
                        'air_list_name'      => $value->air_list_name,
                        'btu'                => $value->btu,
                        'air_location_name'  => $value->air_location_name,
                        'debsubsub'          => $value->debsubsub, 
                        'repaire_sub_name'   => $value->repaire_sub_name, 
                        'staff_name'         => $value->staff_name,
                        'tect_name'          => $value->tect_name,
                        'air_techout_name'   => $value->air_techout_name,
                        'supplies_name'      => $value->supplies_name,
                    ]); 
            }
            
        } else { 
            
            if ($repaire_type == '04') {
                $datashow  = DB::select(
                    'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                    ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                    ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name,"" "|")) as repaire_sub_name 
                    ,b.repaire_no,s.supplies_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND b.air_repaire_type_code = "'.$repaire_type.'" AND a.air_supplies_id = "'.$idsup.'"
                    GROUP BY a.air_repaire_id 
                    ORDER BY a.air_repaire_id DESC  
                '); 
                foreach ($datashow as $key => $value) {
                    
                    Air_repaire_supexcel::insert([
                            'air_repaire_id'     => $value->air_repaire_id,
                            'repaire_date'       => $value->repaire_date,
                            'repaire_time'       => $value->repaire_time,
                            'air_repaire_no'     => $value->air_repaire_no,
                            'air_repaire_num'    => $value->air_repaire_num,
                            'air_list_num'       => $value->air_list_num,
                            'air_list_name'      => $value->air_list_name,
                            'btu'                => $value->btu,
                            'air_location_name'  => $value->air_location_name,
                            'debsubsub'          => $value->debsubsub, 
                            'repaire_sub_name'   => $value->repaire_sub_name, 
                            'staff_name'         => $value->staff_name,
                            'tect_name'          => $value->tect_name,
                            'air_techout_name'   => $value->air_techout_name,
                            'supplies_name'      => $value->supplies_name,
                        ]);
                     
                }
            } else {
                $datashow  = DB::select(
                    'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                    ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                    ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name
                    ,(select GROUP_CONCAT(distinct b.repaire_sub_name," ครั้งที่ " ,b.repaire_no, "|")) as repaire_sub_name2 
                    ,b.repaire_no,s.supplies_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND b.air_repaire_type_code = "'.$repaire_type.'" AND a.air_supplies_id = "'.$idsup.'"
                    GROUP BY a.air_repaire_id 
                    ORDER BY a.air_repaire_id DESC  
                '); 
                foreach ($datashow as $key => $value) { 
                    
                    Air_repaire_supexcel::insert([
                            'air_repaire_id'     => $value->air_repaire_id,
                            'repaire_date'       => $value->repaire_date,
                            'repaire_time'       => $value->repaire_time,
                            'air_repaire_no'     => $value->air_repaire_no,
                            'air_repaire_num'    => $value->air_repaire_num,
                            'air_list_num'       => $value->air_list_num,
                            'air_list_name'      => $value->air_list_name,
                            'btu'                => $value->btu,
                            'air_location_name'  => $value->air_location_name,
                            'debsubsub'          => $value->debsubsub, 
                            'repaire_sub_name'   => $value->repaire_sub_name2, 
                            'staff_name'         => $value->staff_name,
                            'tect_name'          => $value->tect_name,
                            'air_techout_name'   => $value->air_techout_name,
                            'supplies_name'      => $value->supplies_name,
                        ]);
              
                    
                    
                }
            }
            
        }
        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();
        return view('supplies_tech.home_supplies_mobile',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $repaire_type,
        ]);
    }
    public function home_supplies_excel(Request $request)
    {
        $date                = date('Y-m-d');
        $y                   = date('Y') + 543;
        $months              = date('m');
        $year                = date('Y'); 
        $startdate           = $request->datepicker;
        $enddate             = $request->datepicker2;
        $repaire_type        = $request->air_repaire_type;
        $idsup               = Auth::user()->air_supplies_id;
        $sup_                = DB::table('air_supplies')->where('air_supplies_id','=',$idsup)->first();
        $data['sup_name']    = $sup_->supplies_name;
        $data['sup_tel']     = $sup_->supplies_tel;
        $data['sup_address'] = $sup_->supplies_address;
        $datashow            = DB::select('SELECT * FROM air_repaire_supexcel'); 
      
      
               
        //    WHERE a.repaire_date BETWEEN "2024-07-01" AND "2024-07-08"

        return view('supplies_tech.home_supplies_excel',$data,[
            'startdate'     =>$startdate,
            'enddate'       =>$enddate,
            'datashow'      =>$datashow, 
        ]);
    }

    public function support_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        // $year_s = date('Y'); 
        // dd($y);
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        $datashow = DB::select('SELECT COUNT(DISTINCT air_list_num) as count_air FROM air_list WHERE active = "Y"'); 
        $data['count_air']             = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count();
        $data['fire']                  = Fire::where('active','Y')->count();
        $data['cctv_list']             = Cctv_list::where('cctv_status','0')->count();
        $data['water_filter']          = Water_filter::where('active','Y')->count();

        // $data['gas_list']              = Gas_list::where('active','Ready')->where('gas_type',[3,4,5])->count(); 
        $data_gas_list = DB::select('SELECT COUNT(gas_list_id) as gas_list_id FROM gas_list WHERE gas_type in("3","4","5")');  
        foreach ($data_gas_list as $key => $value) {
            $data['gas_list'] = $value->gas_list_id;
        }    
        return view('support_prs.support_main',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate,  
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all, 
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive, 
        ]);
    }
    public function air_dashboard(Request $request)
    {        
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $edit_yeardb    = $request->edit_yeardb;
        $bg_year        = DB::table('budget_year')->where('leave_year_id',$edit_yeardb)->first();
        $startdate_new  = $request->date_begin;
        $enddate_new    = $request->date_end;
        $date_now     = date('Y-m-d');
        $y            = date('Y') + 543;  
        $data['budget_year'] = DB::table('budget_year')->where('active','True')->orderByDesc('leave_year_id')->get();
        $newdays     = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew     = date('Y');
        $year_old    = date('Y')-1; 
        $startdate   = (''.$year_old.'-10-01');
        $enddate     = (''.$yearnew.'-09-30'); 
        $iduser      = Auth::user()->id;
        // dd($enddate);
        if ($edit_yeardb != '') { 
            // dd($edit_yeardb);
                $datashow = DB::select(
                    'SELECT s.air_supplies_id,s.supplies_name,COUNT(air_repaire_id) as c_repaire           
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id
                        WHERE al.air_year = "'.$edit_yeardb.'"
                        GROUP BY a.air_supplies_id
                '); 
                $maintenance_1 = DB::select(
                    'SELECT COUNT(DISTINCT a.air_list_num) as air_qty 
                    ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
                    ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE air_year = "'.$edit_yeardb.'")*COUNT(DISTINCT a.air_list_num)) as percent
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id 
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="04" AND al.air_year = "'.$edit_yeardb.'"
                '); 
                foreach ($maintenance_1 as $key => $value) {
                    $data['air_qty']  = $value->air_qty;
                    $data['percent']  = $value->percent;
                }
                $maintenance_2 = DB::select(
                    'SELECT COUNT(DISTINCT a.air_list_num) as air_qty 
                    ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
                    ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE air_year = "'.$edit_yeardb.'")*COUNT(DISTINCT a.air_list_num)) as percent
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="01" AND al.air_year = "'.$edit_yeardb.'"
                '); 
                foreach ($maintenance_2 as $key => $value2) {
                    $data['main_qty']      = $value2->air_qty;
                    $data['main_percent']  = $value2->percent;
                } 
                $data['count_air_all']     = Air_list::where('air_year',$edit_yeardb)->count();
                $data['count_air_yes']     = Air_list::where('active','Y')->where('air_year',$edit_yeardb)->count();
                $data['count_air_no']      = Air_list::where('active','N')->where('air_year',$edit_yeardb)->count();
                // $data['count_air'] = Air_list::where('active','Y')->where('air_year',$edit_yeardb)->count();
                $years_now = $edit_yeardb;
        } else {
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;
                // dd($bg_yearnow);
                $datashow = DB::select(
                    'SELECT s.air_supplies_id,s.supplies_name,COUNT(air_repaire_id) as c_repaire           
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id
                        WHERE al.air_year = "'.$bg_yearnow.'"
                        GROUP BY a.air_supplies_id
                '); 
                $maintenance_1 = DB::select(
                    'SELECT COUNT(DISTINCT a.air_list_num) as air_qty 
                    ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
                    ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE air_year = "'.$bg_yearnow.'")*COUNT(DISTINCT a.air_list_num)) as percent
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="04" AND al.air_year = "'.$bg_yearnow.'"
                '); 
                foreach ($maintenance_1 as $key => $value) {
                    $data['air_qty']  = $value->air_qty;
                    $data['percent']  = $value->percent;
                }
                $maintenance_2 = DB::select(
                    'SELECT COUNT(DISTINCT a.air_list_num) as main_qty 
                    ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
                    ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE air_year = "'.$bg_yearnow.'")*COUNT(DISTINCT a.air_list_num)) as percent
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="01" AND al.air_year = "'.$bg_yearnow.'"
                '); 
                foreach ($maintenance_2 as $key => $value2) {
                    $data['main_qty']      = $value2->main_qty;
                    $data['main_percent']  = $value2->percent;
                } 
                $data['count_air_all']     = Air_list::where('air_year',$bg_yearnow)->count();
                $data['count_air_yes']     = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count();
                $data['count_air_no']      = Air_list::where('active','N')->where('air_year',$bg_yearnow)->count();
                $years_now = $bg_yearnow;
        }        
        return view('support_prs.air.air_dashboard',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'edit_yeardb'   => $edit_yeardb,
            'years_now'     => $years_now,
        ]);
    }
    public function air_dashboard_new(Request $request,$years)
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
        dd($years);
        $datashow = DB::select(
            'SELECT s.air_supplies_id,s.supplies_name,COUNT(air_repaire_id) as c_repaire           
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = a.air_staff_id 
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id
                GROUP BY a.air_supplies_id
        '); 
  
        $data['count_air'] = Air_list::where('active','Y')->count();
        $maintenance_1 = DB::select(
            'SELECT COUNT(DISTINCT a.air_list_num) as air_qty 
            ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
            ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y")*COUNT(DISTINCT a.air_list_num)) as percent
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
            WHERE b.air_repaire_type_code ="04"  
        '); 
        foreach ($maintenance_1 as $key => $value) {
            $data['air_qty']  = $value->air_qty;
            $data['percent']  = $value->percent;
        }

        $maintenance_2 = DB::select(
            'SELECT COUNT(DISTINCT a.air_list_num) as air_qty 
            ,(SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y") as Count_air
            ,(100 / (SELECT COUNT(DISTINCT air_list_num) air_list_num FROM air_list WHERE active = "Y")*COUNT(DISTINCT a.air_list_num)) as percent
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
            WHERE b.air_repaire_type_code ="01"  
        '); 
        foreach ($maintenance_2 as $key => $value2) {
            $data['main_qty']      = $value2->air_qty;
            $data['main_percent']  = $value2->percent;
        }

        // return view('support_prs.air.air_dashboard_new',$data,[
        //     'startdate'     => $startdate,
        //     'enddate'       => $enddate, 
        //     'datashow'      => $datashow,
        // ]);
    }
    public function air_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $datashow = DB::select('SELECT air_list_id,active,air_imgname,air_list_num,air_list_name,btu,air_location_id,air_location_name,detail,air_room_class FROM air_list WHERE air_year = "'.$bg_yearnow.'" ORDER BY air_list_id DESC'); 
        // WHERE active="Y"
        return view('support_prs.air.air_main',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function air_repaire_ok(Request $request, $id)
    {  
        if (Auth::check()) {
            $type      = Auth::user()->type;
            $iduser    = Auth::user()->id;
            $iddep     = Auth::user()->dep_subsubtrueid;
            $idsup     = Auth::user()->air_supplies_id; 

              if ($idsup == '1' || $idsup == '2' || $idsup == 'on') {
                    $datenow   = date('Y-m-d');
                    $months    = date('m');
                    $year      = date('Y'); 
                    $startdate = $request->startdate;
                    $enddate   = $request->enddate;
                    $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
                    $newDate   = date('Y-m-d', strtotime($datenow . ' -5 months')); //ย้อนหลัง 5 เดือน
                    // $iduser    = Auth::user()->id;
                
                    $data_detail = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
                    ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
                    ->where('air_list.air_list_id', '=', $id)
                    ->get();

                    $users_tech_out_                 = DB::table('users')->where('id','=',$iduser)->first();
                    $data['users_tech_out']          = $users_tech_out_->fname.'  '.$users_tech_out_->lname; 
                    $data['users_tech_out_id']       = $users_tech_out_->id;   
                    $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
                    $data['air_maintenance_list']     = DB::table('air_maintenance_list')->get();
                    $data['users']                   = DB::table('users')->get();
                    $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get();
                    $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
                    $data_detail_ = Air_list::where('air_list_id', '=', $id)->first();
                   
                    $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 
                    return view('support_prs.air.air_repaire',$data, [ 
                    'data_detail'   => $data_detail,
                    'data_detail_'  => $data_detail_,
                    'air_no'        => $air_no,
                    'id'            => $id
                ]); 
            } else {
                return view('support_prs.air.air_repaire_null'); 
            }

         
        } else {
            // echo "<body onload=\"TypeAdmin()\"></body>";
            // exit();
                      return view('support_prs.air.air_repaire_null'); 
        }
             
    }
    public function air_repaire(Request $request, $id)
    {   
                    $datenow   = date('Y-m-d');
                    $months    = date('m');
                    $year      = date('Y'); 
                    $startdate = $request->startdate;
                    $enddate   = $request->enddate;
                    $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
                    $newDate   = date('Y-m-d', strtotime($datenow . ' -5 months')); //ย้อนหลัง 5 เดือน
                    // $iduser    = Auth::user()->id;
                
                    $data_detail = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
                    ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
                    ->where('air_list.air_list_id', '=', $id)
                    ->get();
   
                    $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
                    $data['air_maintenance_list']     = DB::table('air_maintenance_list')->get();
                    $data['users']                   = DB::table('users')->get();
                    $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get();
                    $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
                    $data_detail_                    = Air_list::where('air_list_id', '=', $id)->first();
                    
                    $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 
                    return view('support_prs.air.air_repaire',$data, [ 
                    'data_detail'   => $data_detail,
                    'data_detail_'  => $data_detail_,
                    'air_no'        => $air_no,
                    'id'            => $id
                ]); 
            
            
            
    }
    public function air_repaire_add(Request $request, $id)
    {  
        if (Auth::check()) {
            $type      = Auth::user()->type;
            $iduser    = Auth::user()->id;
            $iddep     = Auth::user()->dep_subsubtrueid;
            $idsup     = Auth::user()->air_supplies_id; 

            if ($idsup == '1' || $idsup == '2' || $idsup == 'on') {
                    $datenow   = date('Y-m-d');
                    $months    = date('m');
                    $year      = date('Y'); 
                    $startdate = $request->startdate;
                    $enddate   = $request->enddate;
                    $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
                    $newDate   = date('Y-m-d', strtotime($datenow . ' -5 months')); //ย้อนหลัง 5 เดือน
                    // $iduser    = Auth::user()->id;
                
                    $data_detail = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
                    ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
                    ->where('air_list.air_list_id', '=', $id)
                    ->get();

                    $users_tech_out_                 = DB::table('users')->where('id','=',$iduser)->first();
                    $data['users_tech_out']          = $users_tech_out_->fname.'  '.$users_tech_out_->lname; 
                    $data['users_tech_out_id']       = $users_tech_out_->id;   
                    $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
                    $data['air_maintenance_list']     = DB::table('air_maintenance_list')->get();
                    $data['users']                   = DB::table('users')->get();
                    $data['air_type']                = DB::table('air_type')->get();
                    $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get();
                    $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
                    $data_detail_                    = Air_list::where('air_list_id', '=', $id)->first();
                    // $signat = $data_detail_->air_img_base;
                    // $pic_fire = base64_encode(file_get_contents($signat)); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_STATUS ="RECEIVE" AND TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_NAME LIKE "%แอร์%" ORDER BY REPAIR_ID ASC');
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_NAME LIKE "%แอร์%" ORDER BY REPAIR_ID ASC');  
                    $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
                    // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 
                    return view('support_prs.air.air_repaire_add',$data, [ 
                    'data_detail'   => $data_detail,
                    'data_detail_'  => $data_detail_,
                    'air_no'        => $air_no,
                    'id'            => $id
                ]); 
            } else {
                return view('support_prs.air.air_repaire_null'); 
            }
 
        } else {
          
                return view('support_prs.air.air_repaire_null'); 
        }
         
    }
    public function air_repaire_edit(Request $request,$id)
    {  
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -3 months')); //ย้อนหลัง 3 เดือน
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get();
        $data['users_tech']         = DB::table('users')->where('dep_id','=','1')->get(); 
        $data['air_tech']           = DB::table('air_tech')->where('air_type','=','IN')->get();
        $data['users_techs']         = DB::table('users')->whereIn('air_supplies_id',[1, 2])->get(); 

        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();
        $data['building_data']      = DB::table('building_data')->get(); 
        $data_detail_ = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
        ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
        // ->leftJoin('air_repaire_sub', 'air_repaire_sub.air_repaire_id', '=', 'air_repaire.air_repaire_id') 
        ->where('air_repaire.air_repaire_id', '=', $id)
        ->first();
        $data_edit                       = Air_repaire::where('air_repaire_id', '=', $id)->first();
        // $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
        $data['air_maintenance_list']    = DB::table('air_maintenance_list')->get();
        // $data['data_detail_sub_plo']     = Air_repaire_sub::where('air_repaire_id', '=', $id)->where('air_repaire_type_code','=','04')->get();
        $data['data_detail_sub_mai']     = Air_repaire_sub::where('air_repaire_id', '=', $id)->whereIn('air_repaire_type_code',['01','02','03'])->get();
        // $signat                     = $data_edit->signature; 
        // $signature                  = base64_encode(file_get_contents($signat));
        // $signat2                    = $data_edit->signature2; 
        // $signature2                 = base64_encode(file_get_contents($signat2));
        // $signat3                    = $data_edit->signature3; 
        $data['data_detail_sub_plo'] = DB::connection('mysql')->select('SELECT * from air_repaire_sub WHERE air_repaire_type_code ="04" AND air_repaire_id ="'.$id.'"');
        $data['air_repaire_ploblem'] = DB::connection('mysql')->select('SELECT * from air_repaire_ploblem');  
        // dd($air_data_detail_sub_plo);
        // dd($data['air_repaire_ploblem']);
        if ($data_edit->signature != '') {
            $signature            = base64_encode(file_get_contents($data_edit->signature));
        }else {
            $signature            = '';
        }
        if ($data_edit->signature2 != '') {
            $signature2            = base64_encode(file_get_contents($data_edit->signature2));
        }else {
            $signature2            = '';
        }
        if ($data_edit->signature3 != '') {
            $signature3            = base64_encode(file_get_contents($data_edit->signature3));
        }else {
            $signature3            = '';
        }             

        // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 
        // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_STATUS ="RECEIVE" AND TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
        // $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_NAME LIKE "%แอร์%" ORDER BY REPAIR_ID ASC'); 
        $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
        return view('support_prs.air.air_repaire_edit', $data,[
            'data_detail_'     => $data_detail_,
            'data_edit'        => $data_edit,
            'signature'        => $signature,
            'signature2'       => $signature2,
            'signature3'       => $signature3,
            'air_no'           => $air_no,
        ]);
    }
    public function air_repiare_update_old(Request $request)
    {
        $date_now    = date('Y-m-d');
        $add_img     = $request->input('signature');
        $add_img2    = $request->input('signature2');
        $add_img3    = $request->input('signature3');
        $id          = $request->input('air_repaire_id');

        $data_edit       = Air_repaire::where('air_repaire_id', '=', $id)->first();
        $idarticle       = $request->air_repaire_no; 
        $air_no          = DB::connection('mysql6')->table('informrepair_index')->where('ID', '=', $idarticle)->first();
        // foreach ($air_no as $key => $value) {
            $repaire_id  = $air_no->REPAIR_ID;
            $repaire_num = $air_no->ARTICLE_ID;
        // }
        $data_2          = $request->air_2; 
        $idsup           = Auth::user()->air_supplies_id;
        $tech_out_       = User::where('id', '=',$request->air_techout_name)->first();
        $tech_sup_out    = $tech_out_->air_supplies_id;

        if ($data_2 == 'on') {
            $update = Air_repaire::find($id);
            $update->repaire_date        = $date_now;
            $update->air_repaire_no      = $repaire_id;
            $update->air_repaire_num     = $repaire_num;
            $update->air_list_id         = $request->air_list_id;
            $update->air_list_num        = $request->air_list_num;
            $update->air_list_name       = $request->air_list_name;
            $update->btu                 = $request->btu;
            $update->serial_no           = $request->serial_no;
            $update->air_location_id     = $request->air_location_id;
            $update->air_location_name   = $request->air_location_name;

            $update->air_problems_1      = $request->input('air_problems_1'); 
            $update->air_problems_2      = $request->air_problems_2;
            $update->air_problems_3      = $request->air_problems_3;
            $update->air_problems_4      = $request->air_problems_4;
            $update->air_problems_5      = $request->air_problems_5;
            $update->air_problems_6      = $request->air_problems_6;
            $update->air_problems_7      = $request->air_problems_7;
            $update->air_problems_8      = $request->air_problems_8;
            $update->air_problems_9      = $request->air_problems_9;
            $update->air_problems_10     = $request->air_problems_10;
            $update->air_problems_11     = $request->air_problems_11;
            $update->air_problems_12     = $request->air_problems_12;
            $update->air_problems_13     = $request->air_problems_13;
            $update->air_problems_14     = $request->air_problems_14;
            $update->air_problems_15     = $request->air_problems_15;
            $update->air_problems_16     = $request->air_problems_16;
            $update->air_problems_17     = $request->air_problems_17;
            $update->air_problems_18     = $request->air_problems_18;
            $update->air_problems_19     = $request->air_problems_19;
            $update->air_problems_20     = $request->air_problems_20;
            $update->air_problems_orther     = $request->air_problems_orther;
            $update->air_problems_orthersub  = $request->air_problems_orthersub;
            $update->signature           = $add_img;  
            // $update->air_status_techout  = $request->air_status_techout; 
            $update->air_techout_name    = $request->air_techout_name;   
            $update->air_supplies_id      = $tech_sup_out; 

            $update->save();   
        
            if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
            } else {
                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
            }
        } else {
            if ($add_img =='') {
                // $checkcount   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature', '=', '')->count();
                // if ($checkcount > 0) { 
                    return response()->json([
                        'status'     => '50'
                    ]);              
                // }            
            } else if ($add_img2 =='') {
                // $checkcount2   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature2', '=', '')->count();
                // if ($checkcount2 > 0) { 
                    return response()->json([
                        'status'     => '60'
                    ]);  
                // }    
            } else if ($add_img3 =='') {
                // $checkcount3   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature3', '=', '')->count();
                // if ($checkcount3 > 0) { 
                    return response()->json([
                        'status'     => '70'
                    ]);      
                // }  
            } else {       
                  
                    $update = Air_repaire::find($id);
                    $update->repaire_date        = $date_now;
                    $update->air_repaire_no      = $repaire_id;
                    $update->air_repaire_num     = $repaire_num;
                    $update->air_list_id         = $request->air_list_id;
                    $update->air_list_num        = $request->air_list_num;
                    $update->air_list_name       = $request->air_list_name;
                    $update->btu                 = $request->btu;
                    $update->serial_no           = $request->serial_no;
                    $update->air_location_id     = $request->air_location_id;
                    $update->air_location_name   = $request->air_location_name;

                    $update->air_problems_1      = $request->input('air_problems_1'); 
                    $update->air_problems_2      = $request->air_problems_2;
                    $update->air_problems_3      = $request->air_problems_3;
                    $update->air_problems_4      = $request->air_problems_4;
                    $update->air_problems_5      = $request->air_problems_5;
                    $update->air_problems_6      = $request->air_problems_6;
                    $update->air_problems_7      = $request->air_problems_7;
                    $update->air_problems_8      = $request->air_problems_8;
                    $update->air_problems_9      = $request->air_problems_9;
                    $update->air_problems_10     = $request->air_problems_10;
                    $update->air_problems_11     = $request->air_problems_11;
                    $update->air_problems_12     = $request->air_problems_12;
                    $update->air_problems_13     = $request->air_problems_13;
                    $update->air_problems_14     = $request->air_problems_14;
                    $update->air_problems_15     = $request->air_problems_15;
                    $update->air_problems_16     = $request->air_problems_16;
                    $update->air_problems_17     = $request->air_problems_17;
                    $update->air_problems_18     = $request->air_problems_18;
                    $update->air_problems_19     = $request->air_problems_19;
                    $update->air_problems_20     = $request->air_problems_20;
                    $update->air_problems_orther     = $request->air_problems_orther;
                    $update->air_problems_orthersub  = $request->air_problems_orthersub;
                    $update->signature           = $add_img;
                    $update->signature2          = $add_img2;
                    $update->signature3          = $add_img3;

                    $update->air_status_techout  = $request->air_status_techout; 
                    $update->air_techout_name    = $request->air_techout_name;  
                    $update->air_status_staff    = $request->air_status_staff;   
                    $update->air_staff_id        = $request->air_staff_id; 
                    $update->air_status_tech     = $request->air_status_tech; 
                    $update->air_tech_id         = $request->air_tech_id; 
                    $update->air_supplies_id     = $tech_sup_out; 
                    $update->save();   
                
                    if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                        Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                    } else {
                        Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                    }
                }
        }
        
        return response()->json([
            'status'     => '200'
        ]);      
    }
    public function air_repiare_update(Request $request)
    {
        $date_now        = date('Y-m-d');
        $add_img         = $request->input('signature');
        $add_img2        = $request->input('signature2');
        $add_img3        = $request->input('signature3'); 
        $id              = $request->input('air_repaire_id');
        $data_edit       = Air_repaire::where('air_repaire_id', '=', $id)->first();
        $idarticle       = $request->air_repaire_no; 
        $air_no          = DB::connection('mysql6')->table('informrepair_index')->where('ID', '=', $idarticle)->first(); 
        $repaire_id      = $air_no->REPAIR_ID;
        $repaire_num     = $air_no->ARTICLE_ID; 
        $data_2          = $request->air_2; 
        $idsup           = Auth::user()->air_supplies_id;
        $tech_out_       = User::where('id', '=',$request->air_techout_name)->first();
        $tech_sup_out    = $tech_out_->air_supplies_id;
        $iduser           = Auth::user()->id;
        $name_            = User::where('id', '=',$iduser)->first();
        $name_edit        = $name_->fname. '  '.$name_->lname;
        $m = date('H');
        $mm = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        // dd( $data_2);
        if ($data_2 == 'on') {
            if ($add_img =='') {
                // return response()->json([
                //     'status'     => '50'
                // ]); 
                $update                          = Air_repaire::find($id); 
                $update->air_repaire_no          = $repaire_id;
                $update->air_repaire_num         = $repaire_num;
                $update->air_list_id             = $request->air_list_id;
                $update->air_list_num            = $request->air_list_num;
                $update->air_list_name           = $request->air_list_name;
                $update->btu                     = $request->btu;
                $update->serial_no               = $request->serial_no;
                $update->air_location_id         = $request->air_location_id;
                $update->air_location_name       = $request->air_location_name; 
                $update->air_problems_orther     = $request->air_problems_orther;
                $update->air_problems_orthersub  = $request->air_problems_orthersub;
                // $update->signature               = $add_img;  
                $update->air_status_techout      = $request->air_status_techout; 
                // $update->air_status_staff        = $request->air_status_staff;  
                // $update->air_status_tech         = $request->air_status_tech; 

                $update->air_techout_name        = $request->air_techout_name;   
                $update->air_supplies_id         = $tech_sup_out; 
                $update->save();   
            
                Air_repaire_sub::where('air_repaire_id',$id)->delete();

                // $air_repaire_id = Air_repaire::max('air_repaire_id');

                if ($request->air_problems != '' || $request->air_problems != null) {
                    $air_problems = $request->air_problems;
                    $number = count($air_problems);
                    $count = 0;                   
                    for ($count = 0; $count < $number; $count++) {
                        $id_problems = DB::table('air_repaire_ploblem')->where('air_repaire_ploblem_id','=', $air_problems[$count])->first();   
                        $count_num_  = DB::table('air_repaire_sub')->where('air_list_num','=', $request->air_list_num)->where('repaire_sub_name','=', $id_problems->air_repaire_ploblemname)->count();   
                        $count_num   = $count_num_+1;
                        $add2                          = new Air_repaire_sub();
                        $add2->air_repaire_id          = $id;
                        $add2->air_list_num            = $request->air_list_num;
                        $add2->air_repaire_ploblem_id  = $id_problems->air_repaire_ploblem_id;
                        $add2->repaire_sub_name        = $id_problems->air_repaire_ploblemname;
                        $add2->repaire_no              = $count_num;
                        $add2->air_repaire_type_code   = $id_problems->air_repaire_type_code;
                        $add2->save();        
                    }
                }
                if ($request->maintenance_list_id != '' || $request->maintenance_list_id != null) {
                    $maintenance_list_id = $request->maintenance_list_id;
                    $number3 = count($maintenance_list_id);
                    $count3 = 0;                   
                    for ($count3 = 0; $count3 < $number3; $count3++) {
                        $id_main = DB::table('air_maintenance_list')->where('maintenance_list_id','=', $maintenance_list_id[$count3])->first(); 
                        $add3                         = new Air_repaire_sub();
                        $add3->air_repaire_id         = $id;
                        $add3->air_list_num           = $request->air_list_num;
                        $add3->air_repaire_ploblem_id = $id_main->maintenance_list_id;
                        $add3->repaire_sub_name       = $id_main->maintenance_list_name;
                        $add3->repaire_no             = $id_main->maintenance_list_num;
                        $add3->air_repaire_type_code  = $id_main->air_repaire_type_code;
                        $add3->save();        
                    }
                }

                if ($request->air_status_techout == 'N') {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                } else {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                }
                Air_edit_log::insert([
                    'user_id'     =>$iduser,
                    'user_name'   =>$name_edit,
                    'date_edit'   =>$date_now,
                    'time_edit'   =>$mm,
                    'status'      =>'EDIT',
                    'detail'      =>'air_repaire_id'.'-'.$id
                ]);
                return response()->json([
                    'status'     => '200'
                ]);
            } else {
                $update                          = Air_repaire::find($id); 
                $update->air_repaire_no          = $repaire_id;
                $update->air_repaire_num         = $repaire_num;
                $update->air_list_id             = $request->air_list_id;
                $update->air_list_num            = $request->air_list_num;
                $update->air_list_name           = $request->air_list_name;
                $update->btu                     = $request->btu;
                $update->serial_no               = $request->serial_no;
                $update->air_location_id         = $request->air_location_id;
                $update->air_location_name       = $request->air_location_name; 
                $update->air_problems_orther     = $request->air_problems_orther;
                $update->air_problems_orthersub  = $request->air_problems_orthersub;
                $update->signature               = $add_img;  
                // $update->air_status_techout      = $request->air_status_techout; 
                $update->air_techout_name        = $request->air_techout_name;   
                $update->air_supplies_id         = $tech_sup_out; 
                $update->save();   
            
                Air_repaire_sub::where('air_repaire_id',$id)->delete();

                // $air_repaire_id = Air_repaire::max('air_repaire_id');

                if ($request->air_problems != '' || $request->air_problems != null) {
                    $air_problems = $request->air_problems;
                    $number = count($air_problems);
                    $count = 0;                   
                    for ($count = 0; $count < $number; $count++) {
                        $id_problems = DB::table('air_repaire_ploblem')->where('air_repaire_ploblem_id','=', $air_problems[$count])->first();   
                        $count_num_  = DB::table('air_repaire_sub')->where('air_list_num','=', $request->air_list_num)->where('repaire_sub_name','=', $id_problems->air_repaire_ploblemname)->count();   
                        $count_num   = $count_num_+1;
                        $add2                          = new Air_repaire_sub();
                        $add2->air_repaire_id          = $id;
                        $add2->air_list_num            = $request->air_list_num;
                        $add2->air_repaire_ploblem_id  = $id_problems->air_repaire_ploblem_id;
                        $add2->repaire_sub_name        = $id_problems->air_repaire_ploblemname;
                        $add2->repaire_no              = $count_num;
                        $add2->air_repaire_type_code   = $id_problems->air_repaire_type_code;
                        $add2->save();        
                    }
                }
                if ($request->maintenance_list_id != '' || $request->maintenance_list_id != null) {
                    $maintenance_list_id = $request->maintenance_list_id;
                    $number3 = count($maintenance_list_id);
                    $count3 = 0;                   
                    for ($count3 = 0; $count3 < $number3; $count3++) {
                        $id_main = DB::table('air_maintenance_list')->where('maintenance_list_id','=', $maintenance_list_id[$count3])->first(); 
                        $add3                         = new Air_repaire_sub();
                        $add3->air_repaire_id         = $id;
                        $add3->air_list_num           = $request->air_list_num;
                        $add3->air_repaire_ploblem_id = $id_main->maintenance_list_id;
                        $add3->repaire_sub_name       = $id_main->maintenance_list_name;
                        $add3->repaire_no             = $id_main->maintenance_list_num;
                        $add3->air_repaire_type_code  = $id_main->air_repaire_type_code;
                        $add3->save();        
                    }
                }

                if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                } else {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                }
                Air_edit_log::insert([
                    'user_id'     =>$iduser,
                    'user_name'   =>$name_edit,
                    'date_edit'   =>$date_now,
                    'time_edit'   =>$mm,
                    'status'      =>'EDIT',
                    'detail'      =>'air_repaire_id'.'-'.$id
                ]);
                return response()->json([
                    'status'     => '200'
                ]);
            }
             

        } else {
            if ($add_img =='') { 
                    return response()->json([
                        'status'     => '50'
                    ]);         
            } else if ($add_img2 =='') { 
                    return response()->json([
                        'status'     => '60'
                    ]);  
            } else if ($add_img3 =='') { 
                    return response()->json([
                        'status'     => '70'
                    ]); 
            } else { 
                $update                          = Air_repaire::find($id);
                // $update->repaire_date            = $date_now;
                $update->air_repaire_no          = $repaire_id;
                $update->air_repaire_num         = $repaire_num;
                $update->air_list_id             = $request->air_list_id;
                $update->air_list_num            = $request->air_list_num;
                $update->air_list_name           = $request->air_list_name;
                $update->btu                     = $request->btu;
                $update->serial_no               = $request->serial_no;
                $update->air_location_id         = $request->air_location_id;
                $update->air_location_name       = $request->air_location_name; 
                $update->air_problems_orther     = $request->air_problems_orther;
                $update->air_problems_orthersub  = $request->air_problems_orthersub;
                $update->signature               = $add_img;  
                $update->signature2              = $add_img2;
                $update->signature3              = $add_img3; 

                $update->air_status_techout      = $request->air_status_techout; 
                $update->air_status_staff        = $request->air_status_staff;  
                $update->air_status_tech         = $request->air_status_tech; 

                $update->air_techout_name        = $request->air_techout_name; 
                $update->air_staff_id            = $request->air_staff_id; 
                $update->air_tech_id             = $request->air_tech_id; 
                $update->air_supplies_id         = $tech_sup_out;   
                $update->save(); 
                
                Air_repaire_sub::where('air_repaire_id',$id)->delete();
                // $air_repaire_id = Air_repaire::max('air_repaire_id');

                if ($request->air_problems != '' || $request->air_problems != null) {
                    $air_problems = $request->air_problems;
                    $number = count($air_problems);
                    $count = 0;                   
                    for ($count = 0; $count < $number; $count++) {
                        $id_problems = DB::table('air_repaire_ploblem')->where('air_repaire_ploblem_id','=', $air_problems[$count])->first();   
                        $count_num_  = DB::table('air_repaire_sub')->where('air_list_num','=', $request->air_list_num)->where('repaire_sub_name','=', $id_problems->air_repaire_ploblemname)->count();   
                        $count_num   = $count_num_+1;
                        $add2                          = new Air_repaire_sub();
                        $add2->air_repaire_id          = $id;
                        $add2->air_list_num            = $request->air_list_num;
                        $add2->air_repaire_ploblem_id  = $id_problems->air_repaire_ploblem_id;
                        $add2->repaire_sub_name        = $id_problems->air_repaire_ploblemname;
                        $add2->repaire_no              = $count_num;
                        $add2->air_repaire_type_code   = $id_problems->air_repaire_type_code;
                        $add2->save();        
                    }
                }
                if ($request->maintenance_list_id != '' || $request->maintenance_list_id != null) {
                    $maintenance_list_id = $request->maintenance_list_id;
                    $number3 = count($maintenance_list_id);
                    $count3 = 0;                   
                    for ($count3 = 0; $count3 < $number3; $count3++) {
                        $id_main = DB::table('air_maintenance_list')->where('maintenance_list_id','=', $maintenance_list_id[$count3])->first(); 
                        $add3                         = new Air_repaire_sub();
                        $add3->air_repaire_id         = $id;
                        $add3->air_list_num           = $request->air_list_num;
                        $add3->air_repaire_ploblem_id = $id_main->maintenance_list_id;
                        $add3->repaire_sub_name       = $id_main->maintenance_list_name;
                        $add3->repaire_no             = $id_main->maintenance_list_num;
                        $add3->air_repaire_type_code  = $id_main->air_repaire_type_code;
                        $add3->save();        
                    }
                }

                if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                } else {
                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                }
                Air_edit_log::insert([
                    'user_id'     =>$iduser,
                    'user_name'   =>$name_edit,
                    'date_edit'   =>$date_now,
                    'time_edit'   =>$mm,
                    'status'      =>'EDIT',
                    'detail'      =>'air_repaire_id'.'-'.$id
                ]);

                return response()->json([
                    'status'     => '200'
                ]);
            }
        }
        
       
    }    
    public function air_detail(Request $request, $id)
    {  
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data_detail_                    = Air_list::where('air_list_num', '=', $id)->first();
        $data['data_detail_sub_mai']     = Air_repaire_sub::leftjoin('air_repaire','air_repaire.air_repaire_id','=','air_repaire_sub.air_repaire_id')
                                            ->leftjoin('air_maintenance_list','air_maintenance_list.maintenance_list_id','=','air_repaire_sub.air_repaire_ploblem_id')
                                            ->where('air_repaire_sub.air_list_num', '=', $id)->whereIn('air_repaire_sub.air_repaire_type_code',['01','02','03'])
                                            ->get();
        // $data['data_detail_sub_plo']     = DB::connection('mysql')->select('SELECT * from air_repaire_sub WHERE air_repaire_type_code ="04" AND air_list_num ="'.$id.'"');
        $data['data_detail_sub_plo']     = Air_repaire_sub::leftjoin('air_repaire','air_repaire.air_repaire_id','=','air_repaire_sub.air_repaire_id')
                                            ->where('air_repaire_sub.air_list_num', '=', $id)->whereIn('air_repaire_sub.air_repaire_type_code',['04'])
                                            ->get();
        // $data['plan']                       = DB::select(
        //     'SELECT a.air_plan_year,a.air_list_num,b.air_plan_name,b.air_repaire_type_id,c.air_repaire_typename
        //     FROM air_plan a
        //     LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
        //     LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id
        //     WHERE a.air_list_num = "'.$id.'" AND a.air_plan_year ="'.$bg_yearnow.'"'); 
        $data['plan']                       = DB::select(
            'SELECT a.air_plan_year,a.air_list_num,b.air_plan_month,b.air_plan_name,d.maintenance_list_id ,d.maintenance_list_name
            ,c.air_repaire_type_id ,c.air_repaire_type_code ,c.air_repaire_typename
            ,((b.air_plan_year)+543) as years_en,b.years,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_type_code = c.air_repaire_type_code) as count_mt
                FROM air_plan a
                LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = a.air_repaire_type_id
                LEFT JOIN air_maintenance_list d On d.maintenance_list_num = c.air_repaire_type_id
            WHERE a.air_list_num = "'.$id.'" AND a.air_plan_year = "'.$bg_yearnow.'"
            
            GROUP BY b.air_plan_month ORDER BY b.air_plan_month_id ASC'); 
            // AND a.air_plan_year ="2568"
        return view('support_prs.air.air_detail',$data,[  
            'data_detail_'  => $data_detail_,
        ]);  
    }     
    public function air_main_repaire_destroy(Request $request,$id)
    {
        $del = Air_repaire::find($id);  
        $del->delete();  

        Air_repaire_sub::where('air_repaire_id',$id)->delete();

        $date_now = date('Y-m-d');
        $iduser           = Auth::user()->id;
        $name_            = User::where('id', '=',$iduser)->first();
        $name_edit        = $name_->fname. ''.$name_->lname;
        $m = date('H');
        $mm = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');

        Air_edit_log::insert([
            'user_id'     =>$iduser,
            'user_name'   =>$name_edit,
            'date_edit'   =>$date_now,
            'time_edit'   =>$mm,
            'status'      =>'DEL',
            'detail'      =>'air_repaire_id'.'-'.$id
        ]);

        return response()->json(['status' => '200']);
    }
    public function air_repiare_save(Request $request)
    {
        $date_now         = date('Y-m-d');
        $add_img          = $request->input('signature');
        $add_img2         = $request->input('signature2');
        $add_img3         = $request->input('signature3');
        $idsup            = Auth::user()->air_supplies_id;
        $iduser           = Auth::user()->id;
        $name_            = User::where('id', '=',$iduser)->first();
        $name_edit        = $name_->fname. '  '.$name_->lname;
        $m = date('H');
        $mm = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
         
            if ($add_img =='') {
                return response()->json([
                    'status'     => '50'
                ]);
            } else if ($add_img2 =='') {
                return response()->json([
                    'status'     => '60'
                ]);
            } else { 
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;       

                    $check_nos = Air_repaire::where('budget_year',$bg_yearnow)->where('air_repaire_no',$request->air_repaire_no)->where('air_list_num',$request->air_list_num)->count();                
                    if ($check_nos > 0) {
                        $edit_repaire = $request->air_pro_edit;

                        if ($edit_repaire =='on') {
                            // Air_repaire::where('air_repaire_no',$request->air_repaire_no)->where('air_list_num',$request->air_list_num)->update([
                            //     'repaire_type'  => 'EDITREPAIRE'
                            // ]); 
                            $adds                          = new Air_repaire();
                            $adds->repaire_date            = $date_now;
                            $adds->repaire_time            = $mm;
                            $adds->budget_year             = $bg_yearnow;
                            $adds->air_num                 = $request->air_num;
                            $adds->air_type_id             = $request->air_type_id;
                            $adds->air_repaire_no          = $request->air_repaire_no;
                            $adds->air_list_id             = $request->air_list_id;
                            $adds->air_list_num            = $request->air_list_num;
                            $adds->air_list_name           = $request->air_list_name;
                            $adds->btu                     = $request->btu;
                            $adds->serial_no               = $request->serial_no;
                            $adds->air_location_id         = $request->air_location_id;
                            $adds->air_location_name       = $request->air_location_name; 
                            $adds->air_problems_orthersub  = $request->air_problems_orthersub;
                            $adds->signature               = $add_img;
                            $adds->signature2              = $add_img2;
                            $adds->signature3              = $add_img3;
                            $adds->air_status_techout      = $request->air_status_techout; 
                            $adds->air_techout_name        = $request->air_techout_name;  
                            $adds->air_status_staff        = $request->air_status_staff;   
                            $adds->air_staff_id            = $request->air_staff_id; 
                            $adds->air_status_tech         = $request->air_status_tech; 
                            $adds->air_tech_id             = $request->air_tech_id; 
                            $adds->air_supplies_id         = $idsup;   
                            $adds->repaire_type            = 'EDITREPAIRE';                                
                            $adds->save();

                            if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                            } else {
                                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                            }
                            if ($request->air_type_id =='') {
                                # code...
                            } else {
                                Air_list::where('air_list_id',$request->air_list_id)->update([
                                    'air_type_id'  => $request->air_type_id
                                ]);
                            }
                            
                       

                                $air_repaire_id = Air_repaire::max('air_repaire_id');

                                if ($request->air_problems != '' || $request->air_problems != null) {
                                    $air_problems = $request->air_problems;
                                    $number = count($air_problems);
                                    $count = 0;                   
                                    for ($count = 0; $count < $number; $count++) {
                                        $id_problems = DB::table('air_repaire_ploblem')->where('air_repaire_ploblem_id','=', $air_problems[$count])->first();   
                                        $count_num_  = DB::table('air_repaire_sub')->where('air_list_num','=', $request->air_list_num)->where('repaire_sub_name','=', $id_problems->air_repaire_ploblemname)->count();   
                                        $count_num   = $count_num_+1;
                                        $add2                          = new Air_repaire_sub();
                                        $add2->air_repaire_id          = $air_repaire_id;
                                        $add2->air_list_num            = $request->air_list_num;
                                        $add2->air_repaire_ploblem_id  = $id_problems->air_repaire_ploblem_id;
                                        $add2->repaire_sub_name        = $id_problems->air_repaire_ploblemname;
                                        if ($id_problems->air_repaire_ploblem_id == '6') {
                                            $add2->repaire_no              = '0';
                                        } else {
                                            $add2->repaire_no              = $count_num;
                                        }                                                       
                                        $add2->air_repaire_type_code   = $id_problems->air_repaire_type_code;
                                        $add2->save();        
                                    }
                                }
                                if ($request->maintenance_list_id != '' || $request->maintenance_list_id != null) {
                                    $maintenance_list_id = $request->maintenance_list_id;
                                    $number3 = count($maintenance_list_id);
                                    $count3 = 0;                   
                                    for ($count3 = 0; $count3 < $number3; $count3++) {
                                        $id_main = DB::table('air_maintenance_list')->where('maintenance_list_id','=', $maintenance_list_id[$count3])->first();        
                                        // $add3                         = new Air_maintenance();
                                        $add3                         = new Air_repaire_sub();
                                        $add3->air_repaire_id         = $air_repaire_id;
                                        $add3->air_list_num           = $request->air_list_num;
                                        $add3->air_repaire_ploblem_id = $id_main->maintenance_list_id;
                                        $add3->repaire_sub_name       = $id_main->maintenance_list_name;
                                        $add3->repaire_no             = $id_main->maintenance_list_num;
                                        $add3->air_repaire_type_code  = $id_main->air_repaire_type_code;
                                        $add3->save();        
                                    }
                                }


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
            
                                $datesend = date('Y-m-d');
                                $sendate = DateThailine($datesend);
                                $data_users = DB::table('users')->where('id', '=', $request->air_techout_name)->first();
                                $techoutname = $data_users->fname.' '.$data_users->lname;

                                $data_staff = DB::table('users')->where('id', '=', $request->air_staff_id)->first();
                                $staffname = $data_staff->fname.' '.$data_staff->lname;

                                $data_tech = DB::table('users')->where('id', '=', $request->air_tech_id)->first();
                                $techname = $data_tech->fname.' '.$data_tech->lname;

                                if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                                    $active_status = 'ไม่พร้อมใช้';
                                } else {
                                    $active_status = 'พร้อมใช้';
                                }
                
                                // *************************************
                                $data_loob = Air_repaire_sub::where('air_repaire_id','=',$air_repaire_id)->get();
                                $mMessage = array();
                                foreach ($data_loob as $key => $value) { 

                                    $mMessage[] = [
                                            'air_list_num'            => $value->air_list_num,
                                            'repaire_sub_name'        => $value->repaire_sub_name, 
                                            'air_repaire_type_code'   => $value->air_repaire_type_code,
                                            'repaire_no'              => $value->repaire_no,           
                                        ];   
                                    }   
                            
                                    // $linetoken = "WjIv0Lz17olawMA0cERmglC7IljvUz3virCbq9Wzuaj"; //ใส่ token line ENV แล้ว         
                                
                                    // $smessage = [];
                                    $header = "แก้รายการซ่อมเดิม";
                                    // $header_sub = "แก้รายการซ่อมเดิม";
                                    $message =  $header. 
                                            "\n" . "วันที่ซ่อม: " . $sendate.
                                            "\n" . "เวลา : " . $mm ."". 
                                            "\n" . "เลขที่แจ้งซ่อม : " . $request->air_repaire_no ."". 
                                            "\n" . "รหัส : " . $request->air_list_num ."". 
                                            "\n" . "ชื่อ  : " . $request->air_list_name . "".
                                            "\n" . "Btu  : " . $request->btu ."". 
                                            "\n" . "serial_no  : " . $request->serial_no ."".
                                            "\n" . "ที่ตั้ง : " .$request->air_location_name."".
                                            "\n" . "หน่วยงาน : " . $request->detail.
                                            "\n" . "ช่างซ่อม(นอก รพ.) : " . $techoutname.
                                            "\n" . "เจ้าหน้าที่ : " . $staffname.
                                            "\n" . "ช่างซ่อม(รพ.) : " . $techname.
                                            "\n" . "สถานะ : " . $active_status;
                                            
                                    foreach ($mMessage as $key => $smes) {
                                        // $num_mesage           = $smes['air_list_num'];
                                        
                                        if ($smes['air_repaire_type_code'] =='04') {
                                            $list_mesage           = $smes['repaire_sub_name']; 
                                            $message.="\n"."รายการซ่อม(ตามปัญหา): " . $list_mesage;  
                                        } else {
                                            $list_mesage           = $smes['repaire_sub_name']; 
                                            $repaire_no            = $smes['repaire_no']; 
                                            $message.="\n"."การบำรุงรักษาประจำปี: " . $list_mesage." ครั้งที่ ".$repaire_no; 
                                        }
                                        
                                        // (ตามปัญหา)
                                        // $message.="\n"."รายการซ่อม : " . $list_mesage;
                                                // "\n"."ปริมาณ : " . $list_mesage.
                                                // "\n"."หน่วย : "   . $unit_mesage;
                                                
                                } 
                                $linesend = "YNWHjzi9EA6mr5myMrcTvTaSlfOMPHMOiCyOfeSJTHr";
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

                                if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                                } else {
                                    Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                                }
                                
                                Air_edit_log::insert([
                                    'user_id'     =>$iduser,
                                    'user_name'   =>$name_edit,
                                    'date_edit'   =>$date_now,
                                    'time_edit'   =>$mm,
                                    'status'      =>'EDITREPAIRE',
                                    'detail'      =>'air_repaire_id'.'-'.$air_repaire_id
                                ]); 

                        } else { 
                        }

                    } else {
                        
                        $add                          = new Air_repaire();
                        $add->repaire_date            = $date_now;
                        $add->repaire_time            = $mm;
                        $add->budget_year             = $bg_yearnow;
                        $add->air_num                 = $request->air_num;
                        $add->air_type_id             = $request->air_type_id;
                        $add->air_repaire_no          = $request->air_repaire_no;
                        $add->air_list_id             = $request->air_list_id;
                        $add->air_list_num            = $request->air_list_num;
                        $add->air_list_name           = $request->air_list_name;
                        $add->btu                     = $request->btu;
                        $add->serial_no               = $request->serial_no;
                        $add->air_location_id         = $request->air_location_id;
                        $add->air_location_name       = $request->air_location_name; 
                        $add->air_problems_orthersub  = $request->air_problems_orthersub;
                        $add->signature               = $add_img;
                        $add->signature2              = $add_img2;
                        $add->signature3              = $add_img3;
                        $add->air_status_techout      = $request->air_status_techout; 
                        $add->air_techout_name        = $request->air_techout_name;  
                        $add->air_status_staff        = $request->air_status_staff;   
                        $add->air_staff_id            = $request->air_staff_id; 
                        $add->air_status_tech         = $request->air_status_tech; 
                        $add->air_tech_id             = $request->air_tech_id; 
                        $add->air_supplies_id         = $idsup;                                   
                        $add->save();

                        if ($request->air_type_id =='') {
                            # code...
                        } else {
                            Air_list::where('air_list_id',$request->air_list_id)->update([
                                'air_type_id'  => $request->air_type_id
                            ]);
                        }

                        $air_repaire_id = Air_repaire::max('air_repaire_id');

                        if ($request->air_problems != '' || $request->air_problems != null) {
                            $air_problems = $request->air_problems;
                            $number = count($air_problems);
                            $count = 0;                   
                            for ($count = 0; $count < $number; $count++) {
                                $id_problems = DB::table('air_repaire_ploblem')->where('air_repaire_ploblem_id','=', $air_problems[$count])->first();   
                                $count_num_  = DB::table('air_repaire_sub')->where('air_list_num','=', $request->air_list_num)->where('repaire_sub_name','=', $id_problems->air_repaire_ploblemname)->count();   
                                $count_num   = $count_num_+1;
                                $add2                          = new Air_repaire_sub();
                                $add2->air_repaire_id          = $air_repaire_id;
                                $add2->air_list_num            = $request->air_list_num;
                                $add2->air_repaire_ploblem_id  = $id_problems->air_repaire_ploblem_id;
                                $add2->repaire_sub_name        = $id_problems->air_repaire_ploblemname;
                                if ($id_problems->air_repaire_ploblem_id == '6') {
                                    $add2->repaire_no              = '0';
                                } else {
                                    $add2->repaire_no              = $count_num;
                                }                                                       
                                $add2->air_repaire_type_code   = $id_problems->air_repaire_type_code;
                                $add2->save();        
                            }
                        }
                        if ($request->maintenance_list_id != '' || $request->maintenance_list_id != null) {
                            $maintenance_list_id = $request->maintenance_list_id;
                            $number3 = count($maintenance_list_id);
                            $count3 = 0;                   
                            for ($count3 = 0; $count3 < $number3; $count3++) {
                                $id_main = DB::table('air_maintenance_list')->where('maintenance_list_id','=', $maintenance_list_id[$count3])->first();        
                                // $add3                         = new Air_maintenance();
                                $add3                         = new Air_repaire_sub();
                                $add3->air_repaire_id         = $air_repaire_id;
                                $add3->air_list_num           = $request->air_list_num;
                                $add3->air_repaire_ploblem_id = $id_main->maintenance_list_id;
                                $add3->repaire_sub_name       = $id_main->maintenance_list_name;
                                $add3->repaire_no             = $id_main->maintenance_list_num;
                                $add3->air_repaire_type_code  = $id_main->air_repaire_type_code;
                                $add3->save();        
                            }
                        }


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
    
                        $datesend = date('Y-m-d');
                        $sendate = DateThailine($datesend);
                        $data_users = DB::table('users')->where('id', '=', $request->air_techout_name)->first();
                        $techoutname = $data_users->fname.' '.$data_users->lname;

                        $data_staff = DB::table('users')->where('id', '=', $request->air_staff_id)->first();
                        $staffname = $data_staff->fname.' '.$data_staff->lname;

                        $data_tech = DB::table('users')->where('id', '=', $request->air_tech_id)->first();
                        $techname = $data_tech->fname.' '.$data_tech->lname;

                        if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                            $active_status = 'ไม่พร้อมใช้';
                        } else {
                            $active_status = 'พร้อมใช้';
                        }
        
                        // *************************************
                        $data_loob = Air_repaire_sub::where('air_repaire_id','=',$air_repaire_id)->get();
                        $mMessage = array();
                        foreach ($data_loob as $key => $value) { 

                            $mMessage[] = [
                                    'air_list_num'            => $value->air_list_num,
                                    'repaire_sub_name'        => $value->repaire_sub_name, 
                                    'air_repaire_type_code'   => $value->air_repaire_type_code,
                                    'repaire_no'              => $value->repaire_no,           
                                ];   
                            }   
                    
                            // $linetoken = "WjIv0Lz17olawMA0cERmglC7IljvUz3virCbq9Wzuaj"; //ใส่ token line ENV แล้ว         
                        
                            // $smessage = [];
                            $header = "ซ่อมเครื่องปรับอากาศ";
                            $header_sub = "รายการซ่อม";
                            $message =  $header. 
                                    "\n" . "วันที่ซ่อม: " . $sendate.
                                    "\n" . "เวลา : " . $mm ."". 
                                    "\n" . "เลขที่แจ้งซ่อม : " . $request->air_repaire_no ."". 
                                    "\n" . "รหัส : " . $request->air_list_num ."". 
                                    "\n" . "ชื่อ  : " . $request->air_list_name . "".
                                    "\n" . "Btu  : " . $request->btu ."". 
                                    "\n" . "serial_no  : " . $request->serial_no ."".
                                    "\n" . "ที่ตั้ง : " .$request->air_location_name."".
                                    "\n" . "หน่วยงาน : " . $request->detail.
                                    "\n" . "ช่างซ่อม(นอก รพ.) : " . $techoutname.
                                    "\n" . "เจ้าหน้าที่ : " . $staffname.
                                    "\n" . "ช่างซ่อม(รพ.) : " . $techname.
                                    "\n" . "สถานะ : " . $active_status;
                                    
                            foreach ($mMessage as $key => $smes) {
                                // $num_mesage           = $smes['air_list_num'];
                                
                                if ($smes['air_repaire_type_code'] =='04') {
                                    $list_mesage           = $smes['repaire_sub_name']; 
                                    $message.="\n"."รายการซ่อม(ตามปัญหา): " . $list_mesage;  
                                } else {
                                    $list_mesage           = $smes['repaire_sub_name']; 
                                    $repaire_no            = $smes['repaire_no']; 
                                    $message.="\n"."การบำรุงรักษาประจำปี: " . $list_mesage." ครั้งที่ ".$repaire_no; 
                                }
                                
                                // (ตามปัญหา)
                                // $message.="\n"."รายการซ่อม : " . $list_mesage;
                                        // "\n"."ปริมาณ : " . $list_mesage.
                                        // "\n"."หน่วย : "   . $unit_mesage;
                                        
                        } 
                        $linesend = "YNWHjzi9EA6mr5myMrcTvTaSlfOMPHMOiCyOfeSJTHr";
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

                        if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                            Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                        } else {
                            Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                        }
                        
                        Air_edit_log::insert([
                            'user_id'     =>$iduser,
                            'user_name'   =>$name_edit,
                            'date_edit'   =>$date_now,
                            'time_edit'   =>$mm,
                            'status'      =>'SAVE',
                            'detail'      =>'air_repaire_id'.'-'.$air_repaire_id
                        ]);
            

                    }
               
            }

           

            return response()->json([
                'status'     => '200'
            ]);
            
        
    }
    public function air_main_repaire(Request $request)
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
                'SELECT a.* ,al.air_imgname,al.active,al.detail,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname,al.air_room_class
                ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                 LEFT JOIN users p ON p.id = a.air_staff_id 
                 WHERE a.repaire_date BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                ORDER BY air_repaire_id DESC
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.* ,al.air_imgname,al.active,al.detail,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname,al.air_room_class
                ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = a.air_staff_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                ORDER BY air_repaire_id DESC
            '); 
        }
        
       
        // WHERE active="Y"
        return view('support_prs.air.air_main_repaire',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function air_report_type(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $repaire_type   = $request->air_repaire_type;
       
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        Air_repaire_excel::truncate();

        if ($repaire_type == '') {
            $datashow  = DB::select(
                'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                ,m.air_repaire_type_code
                ,(select GROUP_CONCAT(distinct b.repaire_sub_name,"|")) as repaire_sub_name 
                ,b.repaire_no,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            ');   
            foreach ($datashow as $key => $value) {
                // if ( $value->air_repaire_type_code == '04') {
                    Air_repaire_excel::insert([
                        'air_repaire_id'     => $value->air_repaire_id,
                        'repaire_date'       => $value->repaire_date,
                        'repaire_time'       => $value->repaire_time,
                        'air_repaire_no'     => $value->air_repaire_no,
                        'air_repaire_num'    => $value->air_repaire_num,
                        'air_list_num'       => $value->air_list_num,
                        'air_list_name'      => $value->air_list_name,
                        'btu'                => $value->btu,
                        'air_location_name'  => $value->air_location_name,
                        'debsubsub'          => $value->debsubsub, 
                        'repaire_sub_name'   => $value->repaire_sub_name, 
                        'staff_name'         => $value->staff_name,
                        'tect_name'          => $value->tect_name,
                        'air_techout_name'   => $value->air_techout_name,
                        'supplies_name'      => $value->supplies_name,
                    ]);
                // } else {
                //     Air_repaire_excel::insert([
                //         'air_repaire_id'     => $value->air_repaire_id,
                //         'repaire_date'       => $value->repaire_date,
                //         'repaire_time'       => $value->repaire_time,
                //         'air_repaire_no'     => $value->air_repaire_no,
                //         'air_repaire_num'    => $value->air_repaire_num,
                //         'air_list_num'       => $value->air_list_num,
                //         'air_list_name'      => $value->air_list_name,
                //         'btu'                => $value->btu,
                //         'air_location_name'  => $value->air_location_name,
                //         'debsubsub'          => $value->debsubsub, 
                //         'repaire_sub_name'   => $value->repaire_sub_name2, 
                //         'staff_name'         => $value->staff_name,
                //         'tect_name'          => $value->tect_name,
                //         'air_techout_name'   => $value->air_techout_name,
                //     ]);
                // }
                
               
            }
        } else { 
            if ($repaire_type == '04') {
                $datashow  = DB::select(
                    'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                    ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                    ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name 
                    ,b.repaire_no,s.supplies_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND b.air_repaire_type_code = "'.$repaire_type.'"
                    GROUP BY a.air_repaire_id 
                    ORDER BY a.air_repaire_id DESC  
                '); 
                foreach ($datashow as $key => $value) {
                    
                        Air_repaire_excel::insert([
                            'air_repaire_id'     => $value->air_repaire_id,
                            'repaire_date'       => $value->repaire_date,
                            'repaire_time'       => $value->repaire_time,
                            'air_repaire_no'     => $value->air_repaire_no,
                            'air_repaire_num'    => $value->air_repaire_num,
                            'air_list_num'       => $value->air_list_num,
                            'air_list_name'      => $value->air_list_name,
                            'btu'                => $value->btu,
                            'air_location_name'  => $value->air_location_name,
                            'debsubsub'          => $value->debsubsub, 
                            'repaire_sub_name'   => $value->repaire_sub_name, 
                            'staff_name'         => $value->staff_name,
                            'tect_name'          => $value->tect_name,
                            'air_techout_name'   => $value->air_techout_name,
                            'supplies_name'      => $value->supplies_name,
                        ]);
                     
                }
            } else {
                $datashow  = DB::select(
                    'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                    ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                    ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name
                    ,(select GROUP_CONCAT(distinct b.repaire_sub_name," ครั้งที่ " ,b.repaire_no, "|")) as repaire_sub_name2 
                    ,b.repaire_no,s.supplies_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND b.air_repaire_type_code = "'.$repaire_type.'"
                    GROUP BY a.air_repaire_id 
                    ORDER BY a.air_repaire_id DESC  
                '); 
                foreach ($datashow as $key => $value) { 
                    
                        Air_repaire_excel::insert([
                            'air_repaire_id'     => $value->air_repaire_id,
                            'repaire_date'       => $value->repaire_date,
                            'repaire_time'       => $value->repaire_time,
                            'air_repaire_no'     => $value->air_repaire_no,
                            'air_repaire_num'    => $value->air_repaire_num,
                            'air_list_num'       => $value->air_list_num,
                            'air_list_name'      => $value->air_list_name,
                            'btu'                => $value->btu,
                            'air_location_name'  => $value->air_location_name,
                            'debsubsub'          => $value->debsubsub, 
                            'repaire_sub_name'   => $value->repaire_sub_name2, 
                            'staff_name'         => $value->staff_name,
                            'tect_name'          => $value->tect_name,
                            'air_techout_name'   => $value->air_techout_name,
                            'supplies_name'      => $value->supplies_name,
                        ]);
              
                    
                    
                }
            }
            
           
        }
         

        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();

        return view('support_prs.air.air_report_type',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $repaire_type,
            
        ]);
    }
    public function air_report_type_excel(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->datepicker;
        $enddate        = $request->datepicker2;
        // $repaire_type   = $request->air_repaire_type;
       
        $datashow  = DB::select(
            'SELECT *
            FROM air_repaire_excel 
        '); 
                // $datashow  = DB::select(
                //     'SELECT a.*,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|" " ")) as repaire_sub_name,c.detail
                //     FROM air_repaire a 
                //     LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                //     LEFT JOIN air_list c ON c.air_list_id = a.air_list_id
                //     GROUP BY a.air_repaire_id
                // '); 
        //    WHERE a.repaire_date BETWEEN "2024-07-01" AND "2024-07-08"

        return view('support_prs.air.air_report_type_excel',[
            'startdate'     =>$startdate,
            'enddate'       =>$enddate,
            'datashow'      =>$datashow, 
        ]);
    }
    public function air_report_company(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $supplies_id   = $request->air_supplies_id;
       
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        Air_repaire_excel::truncate();

        if ($supplies_id == '') {
            $datashow  = DB::select(
                'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu,a.air_problems_orthersub
                ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                ,m.air_repaire_type_code
                ,(select GROUP_CONCAT(distinct b.repaire_sub_name,"|")) as repaire_sub_name 
                ,b.repaire_no,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            ');   
            foreach ($datashow as $key => $value) {
                // if ( $value->air_repaire_type_code == '04') {
                    Air_repaire_excel::insert([
                        'air_repaire_id'     => $value->air_repaire_id,
                        'repaire_date'       => $value->repaire_date,
                        'repaire_time'       => $value->repaire_time,
                        'air_repaire_no'     => $value->air_repaire_no,
                        'air_repaire_num'    => $value->air_repaire_num,
                        'air_list_num'       => $value->air_list_num,
                        'air_list_name'      => $value->air_list_name,
                        'btu'                => $value->btu,
                        'air_location_name'  => $value->air_location_name,
                        'debsubsub'          => $value->debsubsub, 
                        'repaire_sub_name'   => $value->repaire_sub_name, 
                        'staff_name'         => $value->staff_name,
                        'tect_name'          => $value->tect_name,
                        'air_techout_name'   => $value->air_techout_name,
                        'supplies_name'      => $value->supplies_name,
                    ]);
               
            }
        } else { 
            $datashow  = DB::select(
                'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
                ,a.air_problems_orthersub,b.air_repaire_ploblem_id
                ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                ,m.air_repaire_type_code
                ,(select GROUP_CONCAT(distinct b.repaire_sub_name,"|")) as repaire_sub_name 
                ,b.repaire_no,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                AND a.air_supplies_id = "'.$supplies_id.'"
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            ');   
            foreach ($datashow as $key => $value) { 
                if ($value->air_repaire_ploblem_id == '6') {
                    $repaire_subname = $value->repaire_sub_name.','.$value->air_problems_orthersub;
                } else {
                    $repaire_subname = $value->repaire_sub_name;
                }
                
                    Air_repaire_excel::insert([
                        'air_repaire_id'     => $value->air_repaire_id,
                        'repaire_date'       => $value->repaire_date,
                        'repaire_time'       => $value->repaire_time,
                        'air_repaire_no'     => $value->air_repaire_no,
                        'air_repaire_num'    => $value->air_repaire_num,
                        'air_list_num'       => $value->air_list_num,
                        'air_list_name'      => $value->air_list_name,
                        'btu'                => $value->btu,
                        'air_location_name'  => $value->air_location_name,
                        'debsubsub'          => $value->debsubsub, 
                        'repaire_sub_name'   => $repaire_subname, 
                        'staff_name'         => $value->staff_name,
                        'tect_name'          => $value->tect_name,
                        'air_techout_name'   => $value->air_techout_name,
                        'supplies_name'      => $value->supplies_name,
                    ]);
               
            }
            // if ($supplies_id == '04') {
            //     $datashow  = DB::select(
            //         'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
            //         ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
            //         ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
            //         ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
            //         ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name 
            //         ,b.repaire_no,s.supplies_name
            //         FROM air_repaire a 
            //         LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            //         LEFT JOIN users p ON p.id = a.air_staff_id  
            //         LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            //         LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            //         WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //         AND b.air_repaire_type_code = "'.$repaire_type.'"
            //         GROUP BY a.air_repaire_id 
            //         ORDER BY a.air_repaire_id DESC  
            //     '); 
            //     foreach ($datashow as $key => $value) {
                    
            //             Air_repaire_excel::insert([
            //                 'air_repaire_id'     => $value->air_repaire_id,
            //                 'repaire_date'       => $value->repaire_date,
            //                 'repaire_time'       => $value->repaire_time,
            //                 'air_repaire_no'     => $value->air_repaire_no,
            //                 'air_repaire_num'    => $value->air_repaire_num,
            //                 'air_list_num'       => $value->air_list_num,
            //                 'air_list_name'      => $value->air_list_name,
            //                 'btu'                => $value->btu,
            //                 'air_location_name'  => $value->air_location_name,
            //                 'debsubsub'          => $value->debsubsub, 
            //                 'repaire_sub_name'   => $value->repaire_sub_name, 
            //                 'staff_name'         => $value->staff_name,
            //                 'tect_name'          => $value->tect_name,
            //                 'air_techout_name'   => $value->air_techout_name,
            //                 'supplies_name'      => $value->supplies_name,
            //             ]);
                     
            //     }
            // } else {
            //     $datashow  = DB::select(
            //         'SELECT a.repaire_date,a.repaire_time,a.air_repaire_id,a.air_repaire_num,a.air_repaire_no,a.air_list_num,concat(a.air_list_num," ",a.air_list_name) as air_list_name,a.btu as btu
            //         ,a.air_location_name,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
            //         ,concat(p.fname," ",p.lname) as staff_name,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
            //         ,a.air_list_num,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
            //         ,m.air_repaire_type_code,(select GROUP_CONCAT(distinct b.repaire_sub_name," " "|")) as repaire_sub_name
            //         ,(select GROUP_CONCAT(distinct b.repaire_sub_name," ครั้งที่ " ,b.repaire_no, "|")) as repaire_sub_name2 
            //         ,b.repaire_no,s.supplies_name
            //         FROM air_repaire a 
            //         LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            //         LEFT JOIN users p ON p.id = a.air_staff_id  
            //         LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            //         LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            //         WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //         AND b.air_repaire_type_code = "'.$repaire_type.'"
            //         GROUP BY a.air_repaire_id 
            //         ORDER BY a.air_repaire_id DESC  
            //     '); 
            //     foreach ($datashow as $key => $value) { 
                    
            //             Air_repaire_excel::insert([
            //                 'air_repaire_id'     => $value->air_repaire_id,
            //                 'repaire_date'       => $value->repaire_date,
            //                 'repaire_time'       => $value->repaire_time,
            //                 'air_repaire_no'     => $value->air_repaire_no,
            //                 'air_repaire_num'    => $value->air_repaire_num,
            //                 'air_list_num'       => $value->air_list_num,
            //                 'air_list_name'      => $value->air_list_name,
            //                 'btu'                => $value->btu,
            //                 'air_location_name'  => $value->air_location_name,
            //                 'debsubsub'          => $value->debsubsub, 
            //                 'repaire_sub_name'   => $value->repaire_sub_name2, 
            //                 'staff_name'         => $value->staff_name,
            //                 'tect_name'          => $value->tect_name,
            //                 'air_techout_name'   => $value->air_techout_name,
            //                 'supplies_name'      => $value->supplies_name,
            //             ]);
              
                    
                    
            //     }
            // }
            
           
        }
         

        $data['air_supplies']      = DB::table('air_supplies')->get();

        return view('support_prs.air.air_report_company',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'supplies_id'   => $supplies_id,
            
        ]);
    }
    public function air_report_company_excel(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->datepicker;
        $enddate        = $request->datepicker2;
        // $repaire_type   = $request->air_repaire_type;
       
        $datashow  = DB::select(
            'SELECT *
            FROM air_repaire_excel 
        '); 
               

        return view('support_prs.air.air_report_company_excel',[
            'startdate'     =>$startdate,
            'enddate'       =>$enddate,
            'datashow'      =>$datashow, 
        ]);
    }
    public function air_report_type_old(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $repaire_type   = $request->air_repaire_type;
       
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        if ($repaire_type == '1') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            
            // นับปัญหา
              // $datas_count_1= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_1 ="on"');
              // foreach ($datas_count_1 as $key => $value) {
              //     $count_p1 = $value->c_air_list_num; 
              // }
              // $datas_count_1= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_1 ="on"');
              // foreach ($datas_count_1 as $key => $value) {
              //     $count_p1 = $value->c_air_list_num; 
              // }
 
        }else if ($repaire_type == '2') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($repaire_type == '3') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($repaire_type == '4') {
                $datashow  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                    ORDER BY air_repaire_id DESC
                '); 
        } else {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }
         

        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();

        return view('support_prs.air.air_report_type',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $repaire_type,
            
        ]);
    }
    public function air_report_typesub(Request $request,$id,$air_repaire_type,$startdate,$enddate)
    {
        $date = date('Y-m-d'); 
        $data_edit         = Air_repaire::where('air_repaire_id', '=', $id)->first();
        $air_list_id       = $data_edit->air_list_id;
        $air_list          = $data_edit->air_list_num.'   '.$data_edit->air_list_name;
        
        if ($air_repaire_type == '1') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            ');  
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            ');  
 
        }else if ($air_repaire_type == '2') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($air_repaire_type == '3') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($air_repaire_type == '4') {
                $datashow  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                    ORDER BY air_repaire_id DESC
                '); 
                $datashow_sub  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                       ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                       ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                        ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                        ,a.air_techout_name,a.air_list_num
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                    ORDER BY air_repaire_id DESC
                '); 
        } else {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                  ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            ');
        }
         

        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();

        return view('support_prs.air.air_report_typesub',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $air_repaire_type,
            'datashow_sub'  => $datashow_sub,
            'air_list'      => $air_list
            
        ]);
    }
    public function air_report_department(Request $request)
    {
        $date              = date('Y-m-d');
        $y                 = date('Y') + 543;
        $months            = date('m');
        $year              = date('Y'); 
        
        $monthsnew          = substr($months,1,2); 
        $startdate         = $request->startdate;
        $enddate           = $request->enddate;
        $air_location_id   = $request->air_location_id; 
        $air_plan_month    = $request->air_plan_month;       
        $newweek           = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate           = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear           = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 
        $bgs_year          = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow        = $bgs_year->leave_year_id;
        // dd($air_plan_month );
       

        if ($air_plan_month == ''  ) {
            // dd($monthsnew );
            Air_report_dep::truncate();
            Air_report_depexcel::truncate();
            $air_plan_month_   = DB::table('air_plan_month')->where('air_plan_month',$monthsnew)->where('air_plan_year',$year)->first();
            $air_planmonth     = $air_plan_month_->air_plan_month;
            $air_planyears     = $air_plan_month_->air_plan_year;
            $air_plan_name     = $air_plan_month_->air_plan_name;
            // dd($air_planmonth );
            $datashow  = DB::select(
                'SELECT a.repaire_date                 
                ,(SELECT concat(air_list_num,"-",air_list_name,"-",btu) FROM air_list WHERE air_list_id = a.air_list_id) as air_list_name    
                ,(SELECT concat(air_location_name,"-อาคาร",air_location_id,"-ชั้น",air_room_class) FROM air_list WHERE air_list_id = a.air_list_id) as air_location_name          
                ,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "1" AND aa.air_list_num = a.air_list_num) as plan_one
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "2" AND aa.air_list_num = a.air_list_num) as plan_two 
                ,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE month(a.repaire_date) = "'.$air_planmonth.'" AND year(a.repaire_date) = "'.$air_planyears.'"   
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            '); 
             
            Air_report_dep::insert([
                'years'            => $bg_yearnow,
                'air_plan_month'   => $air_planmonth,
                 'air_plan_year'   => $air_planyears,
                'air_plan_name'    => $air_plan_name,
             ]);
             foreach ($datashow as $key => $value) { 
               
                Air_report_depexcel::insert([
                    'air_list_name'      => $value->air_list_name,
                    'air_location_name'  => $value->air_location_name,
                    'debsubsub'          => $value->debsubsub,
                    'plan_one'           => $value->plan_one,
                    'plan_two'           => $value->plan_two, 
                    'supplies_name'      => $value->supplies_name 
                ]); 
            }  
            
        }elseif($air_location_id == '' &&  $air_plan_month != ''){
            Air_report_dep::truncate();
            Air_report_depexcel::truncate();
            // dd($air_plan_month );
            $air_plan_month_   = DB::table('air_plan_month')->where('air_plan_month_id',$air_plan_month)->first();
            $air_planmonth     = $air_plan_month_->air_plan_month;
            $air_planyears     = $air_plan_month_->air_plan_year;
            $air_plan_name     = $air_plan_month_->air_plan_name;
            
            $datashow  = DB::select(
                'SELECT a.repaire_date                 
                ,(SELECT concat(air_list_num,"-",air_list_name,"-",btu) FROM air_list WHERE air_list_id = a.air_list_id) as air_list_name    
                ,(SELECT concat(air_location_name,"-อาคาร",air_location_id,"-ชั้น",air_room_class) FROM air_list WHERE air_list_id = a.air_list_id) as air_location_name          
                ,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "1" AND aa.air_list_num = a.air_list_num) as plan_one
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "2" AND aa.air_list_num = a.air_list_num) as plan_two 
                ,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE month(a.repaire_date) = "'.$air_planmonth.'" AND year(a.repaire_date) = "'.$air_planyears.'"   
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            '); 
            Air_report_dep::insert([
                'years'            => $bg_yearnow,
                'air_plan_month'   => $air_planmonth,
                'air_plan_year'    => $air_planyears,
                'air_plan_name'    => $air_plan_name,
             ]);
            foreach ($datashow as $key => $value) {  
                Air_report_depexcel::insert([
                    'air_list_name'      => $value->air_list_name,
                    'air_location_name'  => $value->air_location_name,
                    'debsubsub'          => $value->debsubsub,
                    'plan_one'           => $value->plan_one,
                    'plan_two'           => $value->plan_two, 
                    'supplies_name'      => $value->supplies_name 
                ]); 
            }

        }elseif($air_location_id != '' &&  $air_plan_month != ''){
            Air_report_dep::truncate();
            Air_report_depexcel::truncate();
            $air_plan_month_   = DB::table('air_plan_month')->where('air_plan_month_id',$air_plan_month)->first();
            $air_planmonth     = $air_plan_month_->air_plan_month;
            $air_planyears     = $air_plan_month_->air_plan_year;
            $air_plan_name     = $air_plan_month_->air_plan_name;
            // dd($air_planyears );
            $datashow  = DB::select(
                'SELECT a.repaire_date                 
                ,(SELECT concat(air_list_num,"-",air_list_name,"-",btu) FROM air_list WHERE air_list_id = a.air_list_id) as air_list_name    
                ,(SELECT concat(air_location_name,"-อาคาร",air_location_id,"-ชั้น",air_room_class) FROM air_list WHERE air_list_id = a.air_list_id) as air_location_name          
                ,(SELECT detail FROM air_list WHERE air_list_id = a.air_list_id) as debsubsub 
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "1" AND aa.air_list_num = a.air_list_num) as plan_one
                ,(SELECT CONCAT(bb.air_plan_name," ",bb.years) 
                FROM air_plan aa
                LEFT JOIN air_plan_month bb ON bb.air_plan_month_id = aa.air_plan_month_id
                WHERE aa.air_plan_year ="'.$bg_yearnow.'" AND aa.air_repaire_type_id = "2" AND aa.air_list_num = a.air_list_num) as plan_two 
                ,s.supplies_name
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE month(a.repaire_date) = "'.$air_planmonth.'" AND year(a.repaire_date) = "'.$air_planyears.'"  
                AND a.air_location_id ="'.$air_location_id.'"
                GROUP BY a.air_repaire_id 
                ORDER BY a.air_repaire_id DESC 
            ');   
            Air_report_dep::insert([
                'years'            => $bg_yearnow,
                'air_plan_month'   => $air_planmonth,
                 'air_plan_year'    => $air_planyears,
                'air_plan_name'    => $air_plan_name,
             ]);
            foreach ($datashow as $key => $value) { 
               
                Air_report_depexcel::insert([
                    'air_list_name'      => $value->air_list_name,
                    'air_location_name'  => $value->air_location_name,
                    'debsubsub'          => $value->debsubsub,
                    'plan_one'           => $value->plan_one,
                    'plan_two'           => $value->plan_two, 
                    'supplies_name'      => $value->supplies_name 
                ]); 
            }    
        } else { 
           
        }
        $data['air_location']      = DB::select('SELECT * FROM air_list GROUP BY air_location_id'); 
        $data['air_plan_month']    = DB::select('SELECT * FROM air_plan_month WHERE years ="'.$bg_yearnow.'"'); 
        
        $air_report_dep    = DB::select('SELECT * FROM air_report_dep'); 
        foreach ($air_report_dep as $key => $va) {
            $data['rep_month'] = $va->air_plan_name;
            $data['rep_years'] = $va->years;
        }
        
        // $data['air_plan_month']    = DB::select('SELECT * FROM air_plan_month'); 
        // $data['air_plan_month']    = DB::select('SELECT * FROM air_plan_month WHERE active ="ํY"');
        // dd($rep_month );
        return view('support_prs.air.air_report_department',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow,
            'air_location_id'  => $air_location_id,
            'air_planmonth'    => $air_planmonth,
            'air_planyears'    => $air_planyears,
            
        ]);
    }
    public function air_report_department_excel(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->datepicker;
        $enddate        = $request->datepicker2; 
        $bgs_year          = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow        = $bgs_year->leave_year_id;

        $datashow  = DB::select('SELECT * FROM air_report_depexcel'); 
        $air_report_dep    = DB::select('SELECT * FROM air_report_dep'); 
        foreach ($air_report_dep as $key => $va) {
            $data['rep_month'] = $va->air_plan_name;
            $data['rep_years'] = $va->years;
        }
        return view('support_prs.air.air_report_department_excel',$data,[
            'startdate'     =>$startdate,
            'enddate'       =>$enddate,
            'datashow'      =>$datashow, 
            'bg_yearnow'    =>$bg_yearnow, 
        ]);
    }
   
    // *******************************************************************

    public function air_add(Request $request)
    { 
        $data['article_data']       = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id desc'); 
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get();
        // $data['land_data']      = Land::get();
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get();
        // $data['product_method']     = Product_method::get();
        $data['building_data']      = DB::table('building_data')->get();
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get();
        // $data['product_brand']   = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.air.air_add', $data);
    }
    public function air_save(Request $request)
    {
        $air_list_num = $request->air_list_num;
        $add = new Air_list();
        $add->air_year            = $request->air_year;
        $add->air_recive_date     = $request->air_recive_date;
        $add->air_list_num        = $air_list_num;
        $add->air_list_name       = $request->air_list_name;
        $add->air_price           = $request->air_price;
        $add->active              = $request->active;
        $add->serial_no           = $request->serial_no;
        $add->detail              = $request->detail; 
        $add->btu                 = $request->btu;  
        $add->air_room_class      = $request->air_room_class;   
    
        $locationid = $request->input('air_location_id');
        if ($locationid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $locationid)->first(); 
            $add->air_location_id = $losave->building_id;
            $add->air_location_name = $losave->building_name;
        } else { 
            $add->air_location_id = '';
            $add->air_location_name = '';
        }
        // brand_id
        $branid = $request->input('bran_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->bran_id = $bransave->brand_id;
            $add->brand_name = $bransave->brand_name;
        } else { 
            $add->bran_id = '';
            $add->brand_name = '';
        }
 
        if ($request->hasfile('air_imgname')) {
            $image_64 = $request->file('air_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $air_list_num. '.' . $extention;
            $request->air_imgname->storeAs('air', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $add->air_img            = $filename;
            $add->air_imgname        = $filename;
            // $add->fire_imgname        = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }                       
  
            $add->air_img_base       = $file64;
            // $add->fire_img_base_name  = $file65;
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function air_edit(Request $request,$id)
    {  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();
        $data['building_data']      = DB::table('building_data')->get();
        // $data_edit                  = Fire::where('fire_id', '=', $id)->first();
        $data_edit                  = Air_list::where('air_list_id', '=', $id)->first();
        
        // $signat                     = $data_edit->fire_img_base;
        // dd($signat); 
        // $pic_fire = base64_encode(file_get_contents($signat)); 
        // dd($pic_fire); 
        return view('support_prs.air.air_edit', $data,[
            'data_edit'    => $data_edit,
            // 'pic_fire'     => $pic_fire
        ]);
    }
    public function air_edit_mobile(Request $request,$id)
    {  
        if (Auth::check()) {
            $type      = Auth::user()->type;
            $iduser    = Auth::user()->id;
            $iddep     = Auth::user()->dep_subsubtrueid;
            $idsup     = Auth::user()->air_supplies_id; 
            if ($idsup == '1' || $idsup == '2') {
                return view('support_prs.air.air_repaire_null'); 
            } else {
                $data['department_sub_sub'] = Department_sub_sub::get();
                $data['article_status']     = Article_status::get();
                $data['product_decline']    = Product_decline::get();
                $data['product_prop']       = Product_prop::get();
                $data['supplies_prop']      = DB::table('supplies_prop')->get();
                $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
                $data['product_data']       = Products::get();
                $data['product_category']   = Products_category::get();
                $data['product_type']       = Products_type::get();
                $data['product_spyprice']   = Product_spyprice::get();
                $data['product_group']      = Product_group::get();
                $data['product_unit']       = Product_unit::get();
                $data['data_province']      = DB::table('data_province')->get();
                $data['data_amphur']        = DB::table('data_amphur')->get();
                $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
                $data['land_data']          = DB::table('land_data')->get();
                $data['product_budget']     = Product_budget::get(); 
                $data['product_buy']        = Product_buy::get();
                $data['users']              = User::get(); 
                $data['products_vendor']    = Products_vendor::get(); 
                $data['product_brand']      = DB::table('product_brand')->get();
                $data['medical_typecat']    = DB::table('medical_typecat')->get();
                $data['building_data']      = DB::table('building_data')->get(); 
                $data_edit                  = Air_list::where('air_list_id', '=', $id)->first();
                
                return view('support_prs.air.air_edit_mobile', $data,[
                    'data_edit'    => $data_edit,
                    // 'pic_fire'     => $pic_fire
                ]);
            } 
        } 
    }
    public function air_update_mobile(Request $request)
    { 
        $id = $request->air_list_id; 
        $air_list_num = $request->air_list_num;
        $update = Air_list::find($id);
        $update->air_year            = $request->air_year;
        $update->air_recive_date     = $request->air_recive_date;
        $update->air_list_num        = $air_list_num;
        $update->air_list_name       = $request->air_list_name;
        $update->air_price           = $request->air_price;
        $update->active              = $request->active;
        $update->serial_no           = $request->serial_no;
        $update->detail              = $request->detail; 
        $update->btu                 = $request->btu;  
        $update->air_room_class      = $request->air_room_class;  

        $locationid = $request->input('air_location_id');
        if ($locationid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $locationid)->first(); 
            $update->air_location_id = $losave->building_id;
            $update->air_location_name = $losave->building_name;
        } else { 
            $update->air_location_id = '';
            $update->air_location_name = '';
        } 
        $branid = $request->input('bran_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->bran_id = $bransave->brand_id;
            $update->brand_name = $bransave->brand_name;
        } else { 
            $update->bran_id = '';
            $update->brand_name = '';
        } 
        if ($request->hasfile('air_imgname')) {

            $description = 'storage/air/' . $update->air_imgname;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('air_imgname');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $air_list_num. '.' . $extention;
            $request->air_imgname->storeAs('air', $filename, 'public');   
            $update->air_img            = $filename;
            $update->air_imgname        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('air_imgname'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('air_imgname'))); 
            } 
            $update->air_img_base       = $file64; ;
        } 
        $update->save();

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function air_update(Request $request)
    { 
        $id = $request->air_list_id; 
        $air_list_num = $request->air_list_num;
        $update = Air_list::find($id);
        $update->air_year            = $request->air_year;
        $update->air_recive_date     = $request->air_recive_date;
        $update->air_list_num        = $air_list_num;
        $update->air_list_name       = $request->air_list_name;
        $update->air_price           = $request->air_price;
        $update->active              = $request->active;
        $update->serial_no           = $request->serial_no;
        $update->detail              = $request->detail; 
        $update->btu                 = $request->btu;  
        $update->air_room_class      = $request->air_room_class;  

        $locationid = $request->input('air_location_id');
        if ($locationid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $locationid)->first(); 
            $update->air_location_id = $losave->building_id;
            $update->air_location_name = $losave->building_name;
        } else { 
            $update->air_location_id = '';
            $update->air_location_name = '';
        }
        // brand_id
        $branid = $request->input('bran_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->bran_id = $bransave->brand_id;
            $update->brand_name = $bransave->brand_name;
        } else { 
            $update->bran_id = '';
            $update->brand_name = '';
        }
 
        if ($request->hasfile('air_imgname')) {

            $description = 'storage/air/' . $update->air_imgname;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('air_imgname');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $air_list_num. '.' . $extention;
            $request->air_imgname->storeAs('air', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $update->air_img            = $filename;
            $update->air_imgname        = $filename;
            // $update->fire_imgname = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }
            // $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
            // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
  
            $update->air_img_base       = $file64;
            // $update->fire_img_base_name  = $file65;
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function air_destroy(Request $request,$id)
    {
        $del = Air_list::find($id);  
        $description = 'storage/air/'.$del->air_imgname;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete(); 
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    }    
    public function fire_report_day(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$newDate.'" AND "'.$date.'"
                GROUP BY c.check_date,c.fire_num                
                '); 
        } else {
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY c.check_date,c.fire_num                
            ');  
        }
         
        return view('support_prs.fire.fire_report_day',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    } 
    public function air_qrcode(Request $request, $id)
    {

            $dataprint = Air_list::where('air_list_id', '=', $id)->first();
            // $dataprint = Fire::where('fire_id', '=', $id)->get();

        return view('support_prs.air.air_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function air_qrcode_all(Request $request)
    {  
            $dataprint = Air_list::get();

        return view('support_prs.air.air_qrcode_all', [
            'dataprint'  =>  $dataprint
        ]);

    }   
    public function air_qrcode_detail_all(Request $request)
    {  
            $dataprint_main = Air_list::get();
           
        return view('support_prs.air.air_qrcode_detail_all', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function air_qrcode_repaire(Request $request)
    {  
            $dataprint_main = Air_list::get();
           
        return view('support_prs.air.air_qrcode_repaire', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function air_report_building(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'") as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" AND air_year = "'.$bg_yearnow.'")	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" AND air_year = "'.$bg_yearnow.'")	as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" AND air_year = "'.$bg_yearnow.'")	as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" AND air_year = "'.$bg_yearnow.'")	as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" AND air_year = "'.$bg_yearnow.'")	as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" AND air_year = "'.$bg_yearnow.'")	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');
        // if ($startdate == '') {
        //     $yearnew     = date('Y');
        //     $year_old    = date('Y')-1; 
        //     $startdate   = (''.$year_old.'-10-01');
        //     $enddate     = (''.$yearnew.'-09-30'); 
            // $datashow = DB::select(
            //     'SELECT a.air_location_name,a.air_location_id,al.detail as debsubsub 
            //         FROM air_repaire a
            //         LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
            //         LEFT JOIN users p ON p.id = a.air_staff_id 
            //         WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //         GROUP BY a.air_location_id
            //         ORDER BY air_location_id ASC 
            // '); 
        // } else {
        //     $datashow = DB::select(
        //         'SELECT a.air_location_name,a.air_location_id,al.detail as debsubsub 
        //             FROM air_repaire a
        //             LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
        //             LEFT JOIN users p ON p.id = a.air_staff_id 
        //             WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        //             GROUP BY a.air_location_id
        //             ORDER BY air_location_id ASC           
        //     ');  
        // }
         
        return view('support_prs.air.air_report_building',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_building_sub(Request $request,$id)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id) as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" )	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" )	as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" )	as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" )	as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" )	as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" )	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');

        $datashow_sub = DB::select('SELECT * FROM air_list WHERE air_location_id = "'.$id.'" AND air_year = "'.$bg_yearnow.'" ORDER BY air_list_id DESC'); 
  
        return view('support_prs.air.air_report_building_sub',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'datashow_sub'  => $datashow_sub,
        ]);
    }
    public function air_report_building_excel(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->where('years_now','=','Y')->first();
        $data['ynow'] =  $dabudget_year->leave_year_id;
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'") as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" AND air_year = "'.$bg_yearnow.'")	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" AND air_year = "'.$bg_yearnow.'") as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" AND air_year = "'.$bg_yearnow.'") as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" AND air_year = "'.$bg_yearnow.'") as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" AND air_year = "'.$bg_yearnow.'") as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" AND air_year = "'.$bg_yearnow.'")	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
                       
        '); 
        //     SELECT a.building_id,a.building_name 
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id) as qtyall
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" )	as less_10000
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" )	as one_two 
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" )	as two_tree
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" )	as tree_four
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" )	as four_five
        //     ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" )	as more_five
        // FROM air_list al 
        // LEFT JOIN building_data a ON a.building_id = al.air_location_id 
        // GROUP BY a.building_id
        // ORDER BY building_id ASC
        return view('support_prs.air.air_report_building_excel',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_problems_old(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser       = Auth::user()->id;
        $datashow     = DB::select('SELECT * FROM air_repaire_ploblem ORDER BY air_repaire_ploblem_id ASC');
        
        if ($startdate =='') { 
        } else {
                Air_repaire_ploblemsub::truncate();
                $data_process_1 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_1 FROM air_repaire WHERE air_problems_1 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_1 as $key => $value) { 
                    $check_1 = Air_repaire_ploblemsub::where('air_list_num',$value->air_list_num)->count();
                    if ($check_1 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value->air_list_num)->update(['air_problems_1'=> $value->air_problems_1]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '1';
                        $add->air_list_num            = $value->air_list_num;
                        $add->air_problems_1          = $value->air_problems_1;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_2 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_2 FROM air_repaire WHERE air_problems_2 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_2 as $key => $value2) { 
                    $check_2 = Air_repaire_ploblemsub::where('air_list_num',$value2->air_list_num)->count();
                    if ( $check_2 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value2->air_list_num)->update(['air_problems_2'=> $value2->air_problems_2]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '2';
                        $add->air_list_num            = $value2->air_list_num;
                        $add->air_problems_2          = $value2->air_problems_2;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_3 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_3 FROM air_repaire WHERE air_problems_3 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_3 as $key => $value3) { 
                    $check_3 = Air_repaire_ploblemsub::where('air_list_num',$value3->air_list_num)->count();
                    if ( $check_3 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value3->air_list_num)->update(['air_problems_3'=> $value3->air_problems_3]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '3';
                        $add->air_list_num            = $value3->air_list_num;
                        $add->air_problems_3          = $value3->air_problems_3;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_4 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_4 FROM air_repaire WHERE air_problems_4 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_4 as $key => $value4) { 
                    $check_4 = Air_repaire_ploblemsub::where('air_list_num',$value4->air_list_num)->count();
                    if ( $check_4 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value4->air_list_num)->update(['air_problems_4'=> $value4->air_problems_4]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '4';
                        $add->air_list_num            = $value4->air_list_num;
                        $add->air_problems_4          = $value4->air_problems_4;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_5 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_5 FROM air_repaire WHERE air_problems_5 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_5 as $key => $value5) { 
                    $check_5 = Air_repaire_ploblemsub::where('air_list_num',$value5->air_list_num)->count();
                    if ( $check_5 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value5->air_list_num)->update(['air_problems_5'=> $value5->air_problems_5]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '5';
                        $add->air_list_num            = $value5->air_list_num;
                        $add->air_problems_5          = $value5->air_problems_5;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_6 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_orther FROM air_repaire WHERE air_problems_orther = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_6 as $key => $value6) { 
                    $check_6 = Air_repaire_ploblemsub::where('air_list_num',$value6->air_list_num)->count();
                    if ( $check_6 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value6->air_list_num)->update(['air_problems_orther'=> $value6->air_problems_orther]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '6';
                        $add->air_list_num            = $value6->air_list_num;
                        $add->air_problems_orther     = $value6->air_problems_orther;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
        }
         
      
        return view('support_prs.air.air_report_problems',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_problems(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date_now    = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        // $newDate     = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $year_old = date('Y')-1;
        $months_old  = ('10');
        $startdate_b = (''.$year_old.'-10-01');
        $enddate_b = (''.$yearnew.'-09-30'); 
        $iduser       = Auth::user()->id;
        
        // if ($startdate =='') { 
        //     $datashow     = DB::select(
        //         'SELECT ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
        //         ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
        //         ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
        //             FROM air_repaire a 
        //             LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
        //             LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
        //             LEFT JOIN users p ON p.id = a.air_staff_id  
        //             LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
        //             LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
        //             WHERE a.repaire_date BETWEEN "'.$startdate_b.'" AND "'.$enddate_b.'"
        //             AND ap.air_repaire_ploblemname IS NOT NULL
        //             GROUP BY ap.air_repaire_ploblem_id
        //         ');

        // } else {
        //     $datashow     = DB::select(
        //         'SELECT ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
        //         ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
        //         ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
        //             FROM air_repaire a 
        //             LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
        //             LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
        //             LEFT JOIN users p ON p.id = a.air_staff_id  
        //             LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
        //             LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
        //             WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        //             AND ap.air_repaire_ploblemname IS NOT NULL
        //             GROUP BY ap.air_repaire_ploblem_id
        //         ');
   
                 
        // }
        $datashow     = DB::select('SELECT * FROM air_report_ploblems ORDER BY air_report_ploblems_id ASC');
      
        return view('support_prs.air.air_report_problems',[
            // 'startdate'     =>     $startdate,
            // 'enddate'       =>     $enddate,
            'datashow'      =>     $datashow, 
            // 'startdate_b'   =>     $startdate_b,
            // 'enddate_b'     =>     $enddate_b,
        ]);
    }
    public function air_report_problem_process(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        Air_report_ploblems::truncate();
        Air_report_ploblems_sub::truncate();

            $datashow     = DB::select(
            'SELECT ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
                ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id  AND air_repaire_type_code ="04") as count_ploblems
                ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND air_list_num = a.air_list_num) as more_one
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND ap.air_repaire_ploblemname IS NOT NULL
                GROUP BY ap.air_repaire_ploblem_id
            ');
            foreach ($datashow as $key => $value) {
                if ($value->more_one > 1) {
                    Air_report_ploblems::insert([
                        'repaire_date_start'        => $startdate,
                        'repaire_date_end'          => $enddate,
                        'air_repaire_ploblem_id'    => $value->air_repaire_ploblem_id,
                        'air_repaire_ploblemname'   => $value->air_repaire_ploblemname,
                        'count_ploblems'            => $value->count_ploblems,
                        'more_one'                  => $value->more_one,
                    ]);
                  
                } else {      
                    Air_report_ploblems::insert([
                        'repaire_date_start'        => $startdate,
                        'repaire_date_end'          => $enddate,
                        'air_repaire_ploblem_id'    => $value->air_repaire_ploblem_id,
                        'air_repaire_ploblemname'   => $value->air_repaire_ploblemname,
                        'count_ploblems'            => $value->count_ploblems,
                        // 'more_one'                  => $value->more_one,
                    ]);              
                }  
            } 
            $datashow_sub  = DB::select(
                'SELECT b.air_repaire_ploblem_id,a.air_list_num,b.repaire_no
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND b.repaire_no > 1 AND b.air_repaire_ploblem_id IN("1","2","3","4","5")
                    GROUP BY a.air_list_id
                ');
                foreach ($datashow_sub as $key => $value2) {
                      Air_report_ploblems_sub::insert([
                        'repaire_date_start'        => $startdate,
                        'repaire_date_end'          => $enddate,
                        'air_repaire_ploblem_id'    => $value2->air_repaire_ploblem_id,
                        'air_list_num'              => $value2->air_list_num, 
                        'more_one'                  => $value2->repaire_no,
                    ]);
                }
        
        return response()->json([
            'status'        => '200',
            // 'startdate'     =>  $startdate,
            // 'enddate'       =>  $enddate,
        ]);
    }
    public function air_report_problem_group(Request $request,$startdate,$enddate,$id)
    {
        // $startdate   = $request->startdate;
        // $enddate     = $request->enddate;
        $date_now      = date('Y-m-d');
        $y             = date('Y') + 543;
        $months        = date('m');   
        $newdays       = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek       = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        // $newDate     = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear       = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew       = date('Y');
        $year_old      = date('Y')-1;
        $months_old    = ('10');
        $startdate_b   = (''.$year_old.'-10-01');
        $enddate_b     = (''.$yearnew.'-09-30'); 
        $iduser        = Auth::user()->id;
        $data_name_     = Air_repaire_ploblem::where('air_repaire_ploblem_id',$id)->first();
        $data['dataname'] = $data_name_->air_repaire_ploblemname;

        if ($startdate =='') { 
            $datashow     = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname,ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
                ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
                ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate_b.'" AND "'.$enddate_b.'"
                    AND b.air_repaire_type_code ="04" AND b.air_repaire_ploblem_id = "'.$id.'"
                    GROUP BY a.air_list_num
                ');
                // AND ap.air_repaire_ploblemname IS NOT NULL
        } else {
            $datashow     = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname,ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
                ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
                ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                    LEFT JOIN users p ON p.id = a.air_staff_id  
                    LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                    LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                    WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                     AND b.air_repaire_type_code ="04" AND b.air_repaire_ploblem_id = "'.$id.'"
                    GROUP BY a.air_list_num
                '); 
        }
         
      
        return view('support_prs.air.air_report_problem_group',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow, 
            'startdate_b'   =>     $startdate_b,
            'enddate_b'     =>     $enddate_b,
        ]);
    }
    public function air_report_problem_morone(Request $request,$startdate,$enddate,$id)
    {    
        $iduser = Auth::user()->id; 
        Air_temp_ploblem::truncate();
        // $datashow = DB::select('SELECT * FROM air_report_ploblems WHERE air_repaire_ploblem_id = "'.$id.'" ORDER BY air_repaire_ploblem_id DESC'); 
        $datashow_     = DB::select(
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
            ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname
            ,ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
            -- ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
            -- ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "'.$id.'"
                AND b.air_repaire_type_code ="04" 
                AND b.repaire_no > 1 
                GROUP BY a.air_list_num;
        ');

        foreach ($datashow_ as $key => $value) { 
            Air_temp_ploblem::insert([ 
                'air_list_num'    =>$value->air_list_num, 
            ]);
        }
        $datashow     = DB::select(
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
            ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname
            ,ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname
            -- ,(SELECT COUNT(DISTINCT air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04") as count_ploblems
            -- ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_repaire_ploblem_id = ap.air_repaire_ploblem_id AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                INNER JOIN air_temp_ploblem t ON t.air_list_num = a.air_list_num
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "'.$id.'"
                AND b.air_repaire_type_code ="04" 
                AND a.air_list_num IN(SELECT air_list_num FROM air_report_ploblems_sub) 
                GROUP BY a.air_list_num;
        ');
        // GROUP BY a.air_list_num;

        // AND ap.air_repaire_ploblemname IS NOT NULL
        // GROUP BY ap.air_repaire_ploblem_id
        return view('support_prs.air.air_report_problem_morone',[
            'startdate'               => $startdate,
            'enddate'                 => $enddate,
            'air_repaire_ploblem_id'  => $id,
            'datashow'                => $datashow,  
        ]);
    }
    public function air_report_problem_detail_old(Request $request,$id)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;      
        $iduser = Auth::user()->id;
        if ($id == '1') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_1 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '2') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
               ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_2 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '3') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_3 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '4') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_4 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '5') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_5 = "on")
                ORDER BY air_list_num ASC
            ');
         
        } else {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_orther = "on")
                ORDER BY air_list_num ASC
            ');
        }
        
        

        $datashow_sub = DB::select('SELECT * FROM air_list WHERE air_location_id = "'.$id.'" ORDER BY air_list_id DESC'); 
  
        return view('support_prs.air.air_report_problem_detail',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'datashow_sub'  => $datashow_sub,
            'id'            => $id,
        ]);
    }
    public function air_report_problemsub(Request $request,$id)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;      
        $iduser = Auth::user()->id;
        if ($id == '1') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_1 = "on"
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '2') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
               ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_2 = "on"
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '3') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_3 = "on"
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '4') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_4 = "on"
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '5') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_5 = "on"
                ORDER BY air_list_num ASC
            ');
         
        } else {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire c  
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE c.air_problems_6 = "on"
                ORDER BY air_list_num ASC
            ');
        }
        
        

        $datashow_sub = DB::select('SELECT * FROM air_list WHERE air_location_id = "'.$id.'" ORDER BY air_list_id DESC'); 
  
        return view('support_prs.air.air_report_problemsub',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'datashow_sub'  => $datashow_sub,
            'id'            => $id,
        ]);
    }
    public function air_report_month(Request $request)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $date_now      = date('Y-m-d');
        $y             = date('Y') + 543;
        $months        = date('m'); 
        $newdays       = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek       = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate       = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear       = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew       = date('Y');
        $year_old      = date('Y')-1;
        $months_old    = ('10');
        $startdate_b   = (''.$year_old.'-10-01');
        $enddate_b     = (''.$yearnew.'-09-30'); 
        $iduser        = Auth::user()->id;
        $month_id_      = $request->month_id;
        // $months_       = DB::table('months')->where('month_id',$month_id)->first();
        // $month_no      = $months_->month_no;    

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();      
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($month_id_ != '') {            
                $months_         = DB::table('air_plan_month')->where('air_plan_month_id',$month_id_)->first();
                $month_year      = $months_->years;
                $month_s         = $months_->air_plan_month;           
                $data['count_air'] = Air_stock_month::where('months','Y')->where('years_th',$bg_yearnow)->count(); 
                $datashow = DB::select(
                    'SELECT a.months,a.total_qty,a.years,a.years_th as years_ps,l.month_name as MONTH_NAME,a.bg_yearnow 
                    FROM air_stock_month a 
                    LEFT JOIN months l on l.month_no = a.months 
                    WHERE a.years_th = "'.$month_year.'" AND a.months = "'.$month_s.'"
                ');
        } else {
            $datashow  = DB::select(
                'SELECT a.months,a.total_qty 
                ,l.month_name as MONTH_NAME  
                ,a.years  
                ,a.years_th as years_ps ,a.bg_yearnow
                FROM air_stock_month a
                LEFT JOIN months l on l.month_no = a.months 
                WHERE a.bg_yearnow = "'.$bg_yearnow.'" 
            '); 
              $data['count_air'] = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count();
        }
        
        $data['month_show']          = DB::table('months')->get();  
        $data['air_plan_month']      = DB::table('air_plan_month')->where('active','Y')->get(); 
      
        return view('support_prs.air.air_report_month',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,  
            'month_id_'     => $month_id_, 
        ]);
    }
    public function air_plan_year(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name,al.air_year
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="Y") as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="N") as qty_noall
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"  
                ) as tula_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2" 
                ) as tula_bt

                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plusji_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plusji_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as tanwa_saha
                  ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as tanwa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as makkara_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as makkara_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as gumpa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as gumpa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mena_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mena_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mesa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mesa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plussapa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plussapa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mituna_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mituna_bt 
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as karakada_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as karakada_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as singha_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as singha_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as kanya_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as kanya_bt
                
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');
        
        $data['air_supplies']      = DB::table('air_supplies')->get();
        $data['air_location']      = DB::select('SELECT * FROM air_list GROUP BY air_location_id'); 
        $data['air_plan_month']    = DB::select('SELECT * FROM air_plan_month WHERE years ="'.$bg_yearnow.'"'); 

        return view('support_prs.air.air_plan_year',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }

    public function air_plan_yearexcel(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name,al.air_year
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="Y") as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="N") as qty_noall
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"  
                ) as tula_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2" 
                ) as tula_bt

                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plusji_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plusji_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as tanwa_saha
                  ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as tanwa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as makkara_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as makkara_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as gumpa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as gumpa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mena_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mena_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mesa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mesa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plussapa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plussapa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mituna_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mituna_bt 
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as karakada_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as karakada_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as singha_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as singha_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as kanya_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as kanya_bt
                
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');
        
         
        return view('support_prs.air.air_plan_yearexcel',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }
   
    // ***************** Detail Dashboard *************************
    public function detail_companyall(Request $request)
    {
        $id       = $request->air_supplies_id;
       
        $data_sub = Air_repaire::where('air_supplies_id',$id)->get();       
        $output=' 
            <div class="row">  
             <div class="col-md-12">         
                 <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th>
                            <th width="8%">serial_no</th>
                            <th>สถานที่ตั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                     ';
                     $i = 1;
                     foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td>'.$i++.'</td>
                            <td>'.DateThai($value->repaire_date).'</td>
                            <td>'.$value->repaire_time.'</td>
                            <td>'.$value->air_repaire_no.'</td>
                            <td>'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td>'.$value->btu.'</td>
                            <td>'.$value->serial_no.'</td>
                            <td>'.$value->air_location_name.'</td>
                        </tr>';
                     }
                       
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_maintenance(Request $request)
    {
        $id                =  $request->air_supplies_id;
        $maintenance_num   = $request->maintenance_list_num;
        // $data_sub = Air_repaire::where('air_supplies_id',$id)->get();  
        $data_sub = DB::select('SELECT b.* 
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id
                WHERE a.air_supplies_id = "'.$id.'" AND c.maintenance_list_num = "'.$maintenance_num.'" AND b.air_repaire_type_code ="01"  
        ');     
        // a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_name 
        $output=' 
            <div class="row">  
             <div class="col-md-12">         
                 <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th> 
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">ครั้งที่</th> 
                        </tr>
                    </thead>
                    <tbody>
                     ';
                     $i = 1;
                     foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td>'.$i++.'</td> 
                            <td>'.$value->air_list_num.'</td>
                            <td>'.$value->repaire_sub_name.'</td>
                            <td>'.$value->repaire_no.'</td> 
                        </tr>';
                     }
                       
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_maintenance_qty(Request $request)
    {
        $id                =  $request->air_supplies_id;
        $maintenance_num   = $request->maintenance_list_num;  
        $data_sub = DB::select('SELECT a.* 
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id
                WHERE a.air_supplies_id = "'.$id.'" AND c.maintenance_list_num = "'.$maintenance_num.'" AND b.air_repaire_type_code ="01" 
                GROUP BY a.air_list_num 
        ');   
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th>
                            <th width="8%">serial_no</th>
                            <th>สถานที่ตั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td>'.$i++.'</td>
                            <td>'.DateThai($value->repaire_date).'</td>
                            <td>'.$value->repaire_time.'</td>
                            <td>'.$value->air_repaire_no.'</td>
                            <td>'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td>'.$value->btu.'</td>
                            <td>'.$value->serial_no.'</td>
                            <td>'.$value->air_location_name.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_namyod(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT 
            a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="1" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "1" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_men(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="3" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "3" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_volumn(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="4" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "4" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_lom(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="2" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "2" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_dap(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="5" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "5" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_orther(Request $request)
    {
        $id             =  $request->air_supplies_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $data_sub       = DB::select(
            'SELECT a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_id,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_id,a.air_location_name,a.air_problems_orthersub
            ,a.air_techout_name,a.air_staff_id,a.air_tech_id,a.air_supplies_id 
             ,(SELECT COUNT(air_list_num) FROM air_repaire_sub WHERE air_list_num = a.air_list_num AND air_repaire_ploblem_id="6" AND air_repaire_type_code ="04" AND repaire_no > 1) as more_one             
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
            LEFT JOIN users p ON p.id = a.air_staff_id  
            LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
            LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
            WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND a.air_supplies_id = "'.$id.'"  
            AND b.air_repaire_ploblem_id = "6" AND b.air_repaire_type_code ="04"
            GROUP BY a.air_list_num 
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">มากกว่า 1ครั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td width="5%">'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->more_one.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }    
    public function detail_moreModal(Request $request)
    {
        $id             =  $request->air_repaire_ploblem_id;
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;  
        $air_list_num   = $request->air_list_num; 
        $data_sub       = DB::select(
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
            ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_staff_id) as staffname
            ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname
            ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_techout_name) as air_techout_name
            ,ap.air_repaire_ploblem_id,ap.air_repaire_ploblemname 
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_repaire_ploblem ap ON ap.air_repaire_ploblem_id = b.air_repaire_ploblem_id
                LEFT JOIN users p ON p.id = a.air_staff_id  
                LEFT JOIN air_maintenance m ON m.air_repaire_id = a.air_repaire_id
                LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id 
                INNER JOIN air_temp_ploblem t ON t.air_list_num = a.air_list_num
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.air_repaire_ploblem_id = "'.$id.'"
                AND b.air_repaire_type_code ="04" 
                AND a.air_list_num = "'.$air_list_num.'"  
        ');  
      
        $output=' 
            <div class="row">  
            <div class="col-md-12">         
                <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th> 
                            <th>สถานที่ตั้ง</th>
                            <th width="8%">เจ้าหน้าที่</th>
                            <th width="8%">ช่าง รพ.</th>
                            <th width="8%">ช่าง นอก</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $i = 1;
                    foreach ($data_sub as $key => $value) {
                        $output.=' 
                        <tr>
                            <td width="5%">'.$i++.'</td>
                            <td width="8%">'.DateThai($value->repaire_date).'</td>
                            <td width="8%">'.$value->repaire_time.'</td>
                            <td width="8%">'.$value->air_repaire_no.'</td>
                            <td width="8%">'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'-'.$value->btu.'</td> 
                            <td>'.$value->air_location_name.'</td>
                            <td width="10%">'.$value->staffname.'</td>
                            <td width="10%">'.$value->tectname.'</td>
                            <td width="10%">'.$value->air_techout_name.'</td>
                        </tr>';
                    }
                    
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_repaire_sup(Request $request)
    {
        $id                =  $request->air_repaire_id;
        // $maintenance_num   = $request->maintenance_list_num;
        // $data_sub = Air_repaire::where('air_supplies_id',$id)->get();  
        $data_sub = DB::select('SELECT a.air_problems_orthersub,b.* 
                FROM air_repaire a 
                LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id
                WHERE a.air_repaire_id = "'.$id.'"    
        ');     
        // a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.serial_no,a.air_location_name 
        $output=' 
            <div class="row">  
             <div class="col-md-12">         
                 <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            
                            <th width="20%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="20%">ครั้งที่</th> 
                        </tr>
                    </thead>
                    <tbody>
                     ';
                     $i = 1;
                     foreach ($data_sub as $key => $value) {
                        
                            $output.=' 
                                <tr> 
                                    <td width="20%">'.$value->air_list_num.'</td>';

                                        if ($value->air_repaire_ploblem_id != '6') {
                                    
                                            $output.=' 
                                                <td>'.$value->repaire_sub_name.'</td>
                                                 <td width="20%">'.$value->repaire_no.'</td> 
                                            ';
                                        } else {
                                                $output.=' 
                                                <td>'.$value->repaire_sub_name.' / '.$value->air_problems_orthersub.'</td>
                                                <td width="20%"></td>';
                                            
                                        }
                            $output.=' 
                                </tr>
                            ';
 
                       
                     }
                       
                    $output.='
                    </tbody> 
                </table> 
            </div>
        </div>
        ';
        echo $output;        
    }
    public function detail_company_typeall(Request $request)
    {
        $id                 = $request->air_supplies_id;
        $enddate_news       = $request->enddate_news;
        $startdate_news     = $request->startdate_news;
    
        $data_sub           = DB::select(
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
            WHERE a.air_supplies_id = "'.$id.'" AND b.air_repaire_type_code ="04" 
            AND a.repaire_date BETWEEN "'.$startdate_news.'" AND "'.$enddate_news.'"
            GROUP BY a.air_repaire_id ORDER BY a.repaire_date ASC
        ');      
        $output=' 
            <div class="row">  
             <div class="col-md-12">         
                 <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                     ';
                    //  <th width="15%">รายการซ่อม</th>
                     $i = 1;
                     foreach ($data_sub as $key => $value) {
                        // $sub_ = DB::select('SELECT air_repaire_id,air_list_num,repaire_sub_name FROM air_repaire_sub WHERE air_repaire_id = "'.$value->air_repaire_id.'"');
                        // foreach ($sub_ as $key => $v_sub) {
                        //     $repaire_sub_name = $v_sub->repaire_sub_name;
                        // }
                        $output.=' 
                        <tr>
                            <td>'.$i++.'</td>
                            <td>'.DateThai($value->repaire_date).'</td>
                            <td>'.$value->repaire_time.'</td>
                            <td>'.$value->air_repaire_no.'</td>
                            <td>'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td>'.$value->btu.'</td>                           
                            <td>'.$value->air_location_name.'</td>
                           
                        </tr>';
                     }
                    //  <td width="15%">'.$repaire_sub_name.'</td>  
                    $output.='
                    </tbody> 
                </table> 
            </div>
            </div>
        ';
        echo $output;        
    }
    public function detail_typeall(Request $request)
    {
        $years_now                 = $request->years_now;
        // $enddate_news       = $request->enddate_news;
        // $startdate_news     = $request->startdate_news;    
        $data_sub           = DB::select( 
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="04" AND al.air_year = "'.$years_now.'"
                GROUP BY a.air_list_num
        ');      
        $output=' 
            <div class="row">  
                <div class="col-md-12">         
                    <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="10%">วันที่</th>
                                <th width="7%">เวลา</th>
                                <th width="10%">เลขที่แจ้งซ่อม</th>
                                <th width="10%">รหัสแอร์</th>
                                <th>รายการ</th>
                                <th width="7%">btu</th> 
                                <th>สถานที่ตั้ง</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            ';
                    
                            $i = 1;
                            foreach ($data_sub as $key => $value) {
                                
                                $output.=' 
                                <tr>
                                    <td>'.$i++.'</td>
                                    <td>'.DateThai($value->repaire_date).'</td>
                                    <td>'.$value->repaire_time.'</td>
                                    <td>'.$value->air_repaire_no.'</td>
                                    <td>'.$value->air_list_num.'</td>
                                    <td>'.$value->air_list_name.'</td>
                                    <td>'.$value->btu.'</td>                           
                                    <td>'.$value->air_location_name.'</td>
                                
                                </tr>';
                            }
                        
                            $output.='
                        </tbody> 
                    </table> 
                </div>
            </div>
        ';
        echo $output;        
    }
    public function detail_mainyear(Request $request)
    {
        $years_now                 = $request->years_now;  
        $data_sub           = DB::select( 
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
                    FROM air_repaire a 
                    LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
                    LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
                    WHERE b.air_repaire_type_code ="01" AND al.air_year = "'.$years_now.'"
                GROUP BY a.air_list_num
        ');      
        $output=' 
            <div class="row">  
                <div class="col-md-12">         
                    <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="10%">วันที่</th>
                                <th width="7%">เวลา</th>
                                <th width="10%">เลขที่แจ้งซ่อม</th>
                                <th width="10%">รหัสแอร์</th>
                                <th>รายการ</th>
                                <th width="7%">btu</th> 
                                <th>สถานที่ตั้ง</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            ';
                    
                            $i = 1;
                            foreach ($data_sub as $key => $value) {
                                
                                $output.=' 
                                <tr>
                                    <td>'.$i++.'</td>
                                    <td>'.DateThai($value->repaire_date).'</td>
                                    <td>'.$value->repaire_time.'</td>
                                    <td>'.$value->air_repaire_no.'</td>
                                    <td>'.$value->air_list_num.'</td>
                                    <td>'.$value->air_list_name.'</td>
                                    <td>'.$value->btu.'</td>                           
                                    <td>'.$value->air_location_name.'</td>
                                
                                </tr>';
                            }
                        
                            $output.='
                        </tbody> 
                    </table> 
                </div>
            </div>
        ';
        echo $output;        
    }
    public function detail_companymaintanant(Request $request)
    {
        $id                 = $request->air_supplies_id;
        $enddate_news       = $request->enddate_news;
        $startdate_news     = $request->startdate_news;
    
        $data_sub           = DB::select(
            'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
            FROM air_repaire a 
            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
            WHERE a.air_supplies_id = "'.$id.'" AND b.air_repaire_type_code ="01" 
            AND a.repaire_date BETWEEN "'.$startdate_news.'" AND "'.$enddate_news.'"
            GROUP BY a.air_repaire_id ORDER BY a.repaire_date ASC
        ');      
        $output=' 
            <div class="row">  
             <div class="col-md-12">         
                 <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="10%">วันที่</th>
                            <th width="7%">เวลา</th>
                            <th width="10%">เลขที่แจ้งซ่อม</th>
                            <th width="10%">รหัสแอร์</th>
                            <th>รายการ</th>
                            <th width="7%">btu</th> 
                            <th>สถานที่ตั้ง</th> 
                        </tr>
                    </thead>
                    <tbody>
                     ';
                   
                     $i = 1;
                     foreach ($data_sub as $key => $value) {
                        
                        $output.=' 
                        <tr>
                            <td>'.$i++.'</td>
                            <td>'.DateThai($value->repaire_date).'</td>
                            <td>'.$value->repaire_time.'</td>
                            <td>'.$value->air_repaire_no.'</td>
                            <td>'.$value->air_list_num.'</td>
                            <td>'.$value->air_list_name.'</td>
                            <td>'.$value->btu.'</td>                           
                            <td>'.$value->air_location_name.'</td>
                           
                        </tr>';
                     }
                     
                    $output.='
                    </tbody> 
                </table> 
            </div>
            </div>
        ';
        echo $output;        
    }



    public function air_report_monthpdf(Request $request)
    {
      
        $dataprint = Fire::get();
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $date_now      = date('Y-m-d');
        $y             = date('Y') + 543;
        $months        = date('m'); 
        $newdays       = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek       = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate       = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear       = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew       = date('Y');
        $year_old      = date('Y')-1;
        $months_old    = ('10');
        $startdate_b   = (''.$year_old.'-10-01');
        $enddate_b     = (''.$yearnew.'-09-30'); 
        $iduser        = Auth::user()->id;
        $month_id_      = $request->month_id;
        // $months_       = DB::table('months')->where('month_id',$month_id)->first();
        // $month_no      = $months_->month_no;    

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();      
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($month_id_ != '') {            
                $months_         = DB::table('air_plan_month')->where('air_plan_month_id',$month_id_)->first();
                $month_year      = $months_->years;
                $month_s         = $months_->air_plan_month;           
                $data['count_air'] = Air_stock_month::where('months','Y')->where('years_th',$bg_yearnow)->count(); 
                $datashow = DB::select(
                    'SELECT a.months,a.total_qty,a.years,a.years_th as years_ps,l.month_name as MONTH_NAME,a.bg_yearnow 
                    FROM air_stock_month a 
                    LEFT JOIN months l on l.month_no = a.months 
                    WHERE a.years_th = "'.$month_year.'" AND a.months = "'.$month_s.'"
                ');
        } else {
            $datashow  = DB::select(
                'SELECT a.months,a.total_qty 
                ,l.month_name as MONTH_NAME  
                ,a.years  
                ,a.years_th as years_ps ,a.bg_yearnow
                FROM air_stock_month a
                LEFT JOIN months l on l.month_no = a.months 
                WHERE a.bg_yearnow = "'.$bg_yearnow.'" 
            '); 
              $data['count_air'] = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count();
        }
        
        $data['month_show']          = DB::table('months')->get();  
        $data['air_plan_month']      = DB::table('air_plan_month')->where('active','Y')->get(); 
    
        $pdf = PDF::loadView('support_prs.air.air_report_monthpdf',['datashow'  =>  $datashow])
        ->setPaper('a4', 'landscape');
  
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(510, 12, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(255, 0, 0));
        return @$pdf->stream();
    }
    // **************  แผน **********************
    public function air_setting(Request $request)
    {
        $startdate          = $request->startdate;
        $enddate            = $request->enddate;
        $air_plan_month_id  = $request->air_plan_month_id;
        $date_now           = date('Y-m-d');
        $years              = date('Y') + 543; 
        $monthsnew_         = date('m'); 
        $monthsnew          = substr($monthsnew_,1,2);    
        $newdays            = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek            = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate            = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear            = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew            = date('Y');
        $year_old           = date('Y')-1;
        $months_old         = ('10');
        $startdate_b        = (''.$year_old.'-10-01');
        $enddate_b          = (''.$yearnew.'-09-30'); 
        $iduser             = Auth::user()->id;
        // dd($monthsnew);
        $data['years_show'] = DB::select('SELECT * FROM air_plan_month WHERE active = "Y" ORDER BY air_plan_month_id ASC');        
       
        if ($air_plan_month_id != '') {
            $data_searchs       = DB::table('air_plan_month')->where('air_plan_month_id','=',$air_plan_month_id)->first();
            $data_months        = $data_searchs->air_plan_month;
            $data_years         = $data_searchs->air_plan_year;
            $datashow  = DB::select(
                'SELECT a.air_plan_id,a.air_list_num,a.air_plan_month_id,a.active,b.years,a.supplies_id
                ,b.air_plan_month,b.air_plan_year,b.air_plan_name,b.start_date,b.end_date,a.air_repaire_type_id,c.air_repaire_typename 
                FROM air_plan a
                LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = a.air_repaire_type_id
                WHERE b.air_plan_month = "'.$data_months.'" AND b.air_plan_year = "'.$data_years.'" 
            ');             
        } else {
            $datashow  = DB::select(
                'SELECT a.air_plan_id,a.air_list_num,a.air_plan_month_id,a.active,b.years,a.supplies_id
                ,b.air_plan_month,b.air_plan_year,b.air_plan_name,b.start_date,b.end_date,a.air_repaire_type_id,c.air_repaire_typename 
                FROM air_plan a
                LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = a.air_repaire_type_id
                WHERE b.air_plan_month = "'.$monthsnew.'" AND b.air_plan_year = "'.$yearnew.'"
            ');
            $data_months        = $monthsnew;
            $data_years         = $yearnew;            
        }
        $data['air_plan_excel'] = DB::connection('mysql')->select(
            'SELECT a.*,b.air_plan_name,c.air_repaire_typename 
                FROM air_plan_excel a 
                LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id 
                LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id
            ');

        return view('support_prs.air.air_setting',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'data_months'   => $data_months,
            'data_years'    => $data_years, 
        ]);
    }
    function importplan_excel(Request $request)
    { 
        // $this->validate($request, [
        //     'file' => 'required|file|mimes:xls,xlsx'
        // ]);
                $the_file = $request->file('PlanDOC'); 
                $file_ = $request->file('PlanDOC')->getClientOriginalName(); //ชื่อไฟล์

   
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                // $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range('2',$row_limit ); 
                $startcount = '2';
                $data = array();
                foreach ($row_range as $row ) {
                    // $vst = $sheet->getCell( 'H' . $row )->getValue();  
                    // $day = substr($vst,0,2);
                    // $mo = substr($vst,3,2);
                    // $year = substr($vst,6,4);
                    // $vstdate = $year.'-'.$mo.'-'.$day;

                    // $reg = $sheet->getCell( 'I' . $row )->getValue(); 
                    // $regday = substr($reg, 0, 2);
                    // $regmo = substr($reg, 3, 2);
                    // $regyear = substr($reg, 6, 4);
                    // $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    // $l = $sheet->getCell( 'L' . $row )->getValue();
                    // $del_l = str_replace(",","",$l);
                 
                    $data[] = [
                        'air_plan_year'          =>$sheet->getCell( 'B' . $row )->getValue(),
                        'air_list_num'           =>$sheet->getCell( 'C' . $row )->getValue(),
                        'air_plan_month_id'      =>$sheet->getCell( 'D' . $row )->getValue(), 
                        'PlanDOC'                =>$file_ 
                    ];
                    $startcount++;  
                } 
                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $datasert) {
                    Air_plan_excel::insert($datasert); 
                } 
                return response()->json([
                    'status'     => '200'
                ]); 
  
            // return redirect()->back();
          
    }
    public function importplan_send(Request $request)
    {
        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM air_plan_excel');
            foreach ($data_ as $key => $value) {
              
                    $check = Air_plan::where('air_plan_year','=',$value->air_plan_year)->where('air_list_num','=',$value->air_list_num)->where('air_plan_month_id','=',$value->air_plan_month_id)->count();
                    if ($check > 0) {
                    } else {
                        $add = new Air_plan();
                        $add->air_plan_year         = $value->air_plan_year;
                        $add->air_list_num          = $value->air_list_num;
                        $add->air_plan_month_id     = $value->air_plan_month_id;
                        $add->PlanDOC               = $value->PlanDOC; 
                        $add->save(); 
                    } 
                
            }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            Air_plan_excel::truncate();

            return response()->json([
                'status'     => '200'
            ]); 
        // return redirect()->back();
    }
    public function air_setting_type(Request $request)
    {
        $startdate          = $request->startdate;
        $enddate            = $request->enddate;
        $air_plan_month_id  = $request->air_plan_month_id;
        $date_now           = date('Y-m-d');
        $years              = date('Y') + 543;
        $yearnew_plus       = date('Y') + 544;
        $monthsnew_         = date('m'); 
        $monthsnew          = substr($monthsnew_,1,2);  
        $newdays            = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek            = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate            = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear            = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew            = date('Y'); 
        $year_old           = date('Y')-1;
        $months_old         = ('10');
        $startdate_b        = (''.$year_old.'-10-01');
        $enddate_b          = (''.$yearnew.'-09-30'); 
        $iduser             = Auth::user()->id;
        // dd($yearnew);
        $data['years_show'] = DB::select('SELECT * FROM air_plan_month WHERE active = "Y" ORDER BY air_plan_month_id ASC');        
        $data['yearsshow'] = DB::select('SELECT * FROM air_plan_month GROUP BY years ORDER BY air_plan_month_id DESC LIMIT 1'); 
        // if ($air_plan_month_id != '') {
        //     $data_searchs       = DB::table('air_plan_month')->where('air_plan_month_id','=',$air_plan_month_id)->first();
        //     $data_months        = $data_searchs->air_plan_month;
        //     $data_years         = $data_searchs->air_plan_year; 
        //     $datashow  = DB::select(
        //         'SELECT b.*,c.air_repaire_typename 
        //             FROM air_plan_month b 
        //             LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id 
        //             WHERE b.active = "Y"
        //     ');
        // } else {
            $datashow  = DB::select(
                'SELECT b.*,c.air_repaire_typename 
                    FROM air_plan_month b 
                    LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id 
                    WHERE b.years BETWEEN "'.$years.'" AND "'.$yearnew_plus.'"
            '); 
        // } 
        return view('support_prs.air.air_setting_type',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,  
        ]);
    }
    function air_setting_typeswith(Request $request)
    {  
        $id = $request->idfunc; 
        $active = Air_plan_month::find($id);
        $active->active = $request->onoff;
        $active->save();
    }
    function air_setting_typecopy(Request $request)
    {   
        $air_plan_month_id = $request->air_plan_month_id;
        $datamain_         = Air_plan_month::where('air_plan_month_id',$air_plan_month_id)->first();
        $datamain          = $datamain_->years;
        $dataget           = Air_plan_month::where('years',$datamain)->get();
                foreach ($dataget as $row ) {
                        // $day         = substr($row->start_date,0,2);
                        // $mo          = substr($row->start_date,3,2);
                        // $year       = substr($row->start_date,6,4); 
                        // $start_date = $year.'-'.$mo.'-'.$day;
                        if ($row->years == '10' || $row->years == '11' || $row->years == '12' ) {
                            Air_plan_month::insert([
                                'years'                  => ($row->years),
                                'air_plan_month'         => $row->air_plan_month,
                                'air_plan_year'          => ($row->air_plan_year),
                                'air_plan_name'          => $row->air_plan_name,
                                'active'                 => $row->active,
                                'air_repaire_type_id'    => $row->air_repaire_type_id,
                                'start_date'             => $row->start_date,   
                            ]);
                        } else {
                            Air_plan_month::insert([
                                'years'                  => ($row->years)+1,
                                'air_plan_month'         => $row->air_plan_month,
                                'air_plan_year'          => ($row->air_plan_year)+1,
                                'air_plan_name'          => $row->air_plan_name,
                                'active'                 => $row->active,
                                'air_repaire_type_id'    => $row->air_repaire_type_id, 
                            ]);
                        }
                         
                } 
                
                return response()->json([
                    'status'     => '200'
                ]); 
  
            // return redirect()->back();
          
    }
    public function air_setting_year(Request $request)
    {
        $startdate          = $request->startdate;
        $enddate            = $request->enddate;
        $air_plan_month_id  = $request->air_plan_month_id;
        $date_now           = date('Y-m-d');
        $years              = date('Y') + 543;
        $yearnew_plus       = date('Y') + 544;
        $monthsnew_         = date('m'); 
        $monthsnew          = substr($monthsnew_,1,2);  
        $newdays            = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek            = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate            = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear            = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew            = date('Y'); 
        $year_old           = date('Y')-1;
        $months_old         = ('10');
        $startdate_b        = (''.$year_old.'-10-01');
        $enddate_b          = (''.$yearnew.'-09-30'); 
        $iduser             = Auth::user()->id;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['datashow'] = DB::select('SELECT * FROM air_list WHERE active = "Y" AND air_year = "'.$bg_yearnow.'" ORDER BY air_list_id ASC');        
        $data['yearsshow'] = DB::select('SELECT * FROM air_list WHERE active = "Y" AND air_year = "'.$years.'" ORDER BY air_year DESC LIMIT 1'); 
        // AIR0101OPD05
        // WHERE active = "Y" AND air_year = "'.$bg_yearnow.'"
            // $datashow  = DB::select(
            //     'SELECT b.*,c.air_repaire_typename 
            //         FROM air_plan_month b 
            //         LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id 
            //         WHERE b.years BETWEEN "'.$years.'" AND "'.$yearnew_plus.'"
            // '); 
        // } 
        return view('support_prs.air.air_setting_year',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            // 'datashow'      =>     $datashow,  
        ]);
    }
    function air_setting_yearcopy(Request $request)
    {   
        $air_year_old  = $request->air_year; 
        $air_year      = $air_year_old+1;
        // $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        // $bg_yearnow    = $bgs_year->leave_year_id;

        $dataget       = Air_list::where('air_year',$air_year_old)->get();
                foreach ($dataget as $row ) {
                         $check = Air_list::where('air_list_num',$row->air_list_num)->where('air_year',$air_year)->count();
                        if ($check > 0) {  
                        } else {
                            Air_list::insert([
                                'air_list_num'         => $row->air_list_num,
                                'air_list_name'        => $row->air_list_name,
                                'detail'               => $row->detail,
                                'bran_id'              => $row->bran_id,
                                'brand_name'           => $row->brand_name,
                                'btu'                  => $row->btu, 
                                'serial_no'            => $row->serial_no, 
                                'air_location_id'      => $row->air_location_id, 
                                'air_location_name'    => $row->air_location_name, 
                                'air_price'            => $row->air_price, 
                                'air_room_class'       => $row->air_room_class, 
                                'air_img'              => $row->air_img, 
                                'air_imgname'          => $row->air_imgname, 
                                'air_img_base'         => $row->air_img_base, 
                                'air_recive_date'      => $row->air_recive_date, 
                                'active'               => $row->active, 
                                'air_edit'             => $row->air_edit, 
                                'air_backup'           => $row->air_backup, 
                                'air_date_pdd'         => $row->air_date_pdd, 
                                'air_date_exp'         => $row->air_date_exp, 
                                'air_for_check'        => $row->air_for_check, 
                                'user_id'              => $row->user_id, 
                                'air_year'             => $air_year, 
                                'air_type_id'          => $row->air_type_id,
                            ]);
                        }
                         
                } 
                
                return response()->json([
                    'status'     => '200'
                ]);  
    }
    public function air_setting_yearnow(Request $request)
    {
        $startdate          = $request->startdate;
        $enddate            = $request->enddate;
        $air_plan_month_id  = $request->air_plan_month_id;
        $date_now           = date('Y-m-d');
        $years              = date('Y') + 543;
        $yearnew_plus       = date('Y') + 544;
        $monthsnew_         = date('m'); 
        $monthsnew          = substr($monthsnew_,1,2);  
        $newdays            = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek            = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate            = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear            = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew            = date('Y'); 
        $year_old           = date('Y')-1;
        $months_old         = ('10');
        $startdate_b        = (''.$year_old.'-10-01');
        $enddate_b          = (''.$yearnew.'-09-30'); 
        $iduser             = Auth::user()->id;
        // dd($years);
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        // $bg_yearnow    = $bgs_year->leave_year_id;
        // $data['datashow'] = DB::select('SELECT * FROM air_list WHERE active = "Y" ORDER BY air_list_id ASC');        
        $data['datashow'] = DB::select('SELECT * FROM budget_year ORDER BY leave_year_id DESC'); 
        // WHERE years_now = "Y" 
        return view('support_prs.air.air_setting_yearnow',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            // 'datashow'      =>     $datashow,  
        ]);
    }
    function air_setting_yearnowswith(Request $request)
    {  
        $id = $request->idfunc; 
        $active = Budget_year::find($id);
        $active->years_now = $request->onoff;
        $active->save();
    }
    function switch_air_active(Request $request)
    {  
        $id = $request->idfunc; 
        $active = Air_list::find($id);
        $active->active = $request->onoff;
        $active->save();
    }
    public function air_setting_month(Request $request)
    {
        $startdate          = $request->startdate;
        $enddate            = $request->enddate;
        $air_plan_month_id  = $request->air_plan_month_id;
        $date_now           = date('Y-m-d');
        $years              = date('Y') + 543;
        $yearnew_plus       = date('Y') + 544;
        $monthsnew_         = date('m'); 
        $monthsnew          = substr($monthsnew_,1,2);  
        $newdays            = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek            = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate            = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear            = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew            = date('Y'); 
        $year_old           = date('Y')-1;
        $months_old         = ('10');
        $startdate_b        = (''.$year_old.'-10-01');
        $enddate_b              = (''.$yearnew.'-09-30'); 
        $iduser                = Auth::user()->id;
        $bgs_year              = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']    = $bgs_year->leave_year_id;
        $data['datashow']      = DB::select('SELECT * FROM air_stock_month a LEFT JOIN months b ON b.month_no = a.months ORDER BY air_stock_month_id DESC');        
        $data['months_data']   = DB::select('SELECT a.* FROM months a ORDER BY month_no ASC'); 
        $data['yearsshow']     = DB::select('SELECT * FROM budget_year WHERE active = "True" ORDER BY leave_year_id ASC'); 
         
        return view('support_prs.air.air_setting_month',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            // 'datashow'      =>     $datashow,  
        ]);
    }
    public function air_setting_monthcopy(Request $request)
    {   
        $date_now        = date('Y-m-d');
        $iduser          = Auth::user()->id;
        $month_no1       = $request->month_no1; 
        // $month_no2       = $request->month_no2; 
        $leave_year_id1  = $request->leave_year_id1; 
        // $leave_year_id2  = $request->leave_year_id2; 
        $bgs_year        = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow      = $bgs_year->leave_year_id;
        // $data['count_air'] = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count();
        $dataget         = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_list_num FROM air_list WHERE active = "Y" AND air_year = "'.$bg_yearnow.'"'); 
     
                foreach ($dataget as $row ) {
                         $check = Air_stock_month::where('months',$month_no1)->where('years',$leave_year_id1)->count();
                        if ($check > 0) {  
                        } else {
                            Air_stock_month::insert([
                                'bg_yearnow'     => $bg_yearnow,
                                'months'         => $month_no1,
                                'years'          => $leave_year_id1-543,
                                'years_th'       => $leave_year_id1,
                                'total_qty'      => $row->air_list_num,
                                'datesave'       => $date_now,
                                'userid'         => $iduser,  
                            ]);
                        }
                         
                } 
                
                return response()->json([
                    'status'     => '200'
                ]);  
    }

    // *-******************************* Print *********************************
    public function air_plan_print(Request $request,$years)
    {
        
        $org = DB::table('orginfo')->where('orginfo_id', '=', 1)
        ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
        ->first();
        $rong = $org->prefix_name . ' ' . $org->fname . '  ' . $org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        $rong = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $rong_bo  = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $sigrong_ = $rong->signature; //หัวหน้าบริหาร

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        // $iduser = '1037';
        $count_ = DB::table('users')->where('id', '=', $iduser)->count();
        if ($count_ != 0) {
            $signa = DB::table('users')->where('id', '=', $iduser)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
                // ->orwhere('com_repaire_no','=',$dataedit->com_repaire_no)
            $ptname   = $signa->prefix_name . '' . $signa->fname . '  ' . $signa->lname;
            $position = $signa->position_name;
            $siguser  = $signa->signature; //ผู้รองขอ
            // $sigstaff = $signature->signature_name_stafftext; //เจ้าหน้าที่
            // $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            // $sighn = $signature->signature_name_hntext; //หัวหน้า
            $sigrong = $sigrong_; //หัวหน้าบริหาร
            // $sigpo = $signature->signature_name_potext; //ผอ
            // $sigrong = ''; 
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        } else {
            $sigrong = '';
            $siguser = '';
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        }
        // $data_air     = DB::select(
        //     'SELECT a.air_plan_year,a.air_list_num,c.detail,c.brand_name,c.btu,c.air_location_name,b.air_plan_month,b.air_plan_name,a.supplies_id,d.supplies_name,c.air_room_class
        //     FROM air_plan a 
        //     LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
        //     LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
        //     LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
        //     WHERE a.air_plan_year = "'.$years.'"
        //     GROUP BY a.air_list_num
        // '); 
 
        $data_air = DB::select(
            'SELECT a.building_id,a.building_name,al.air_year,al.air_room_class
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="Y") as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND air_year = "'.$bg_yearnow.'" AND active ="N") as qty_noall
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"  
                ) as tula_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "10" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2" 
                ) as tula_bt

                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plusji_saha
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "11" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plusji_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as tanwa_saha
                  ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "12" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as tanwa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as makkara_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "1" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as makkara_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as gumpa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "2" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as gumpa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mena_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "3" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mena_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mesa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "4" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mesa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as plussapa_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "5" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as plussapa_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as mituna_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "6" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as mituna_bt 
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as karakada_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "7" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as karakada_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as singha_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "8" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as singha_bt
                ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "1"
                ) as kanya_saha
                 ,(SELECT COUNT(DISTINCT aa.air_list_num) FROM air_plan aa
                    LEFT JOIN air_list bb ON bb.air_list_num = aa.air_list_num  
                    LEFT JOIN air_plan_month cc ON cc.air_plan_month_id = aa.air_plan_month_id
                    WHERE bb.air_location_id = a.building_id AND cc.air_plan_month = "9" AND cc.years = "'.$bg_yearnow.'" AND bb.air_year = "'.$bg_yearnow.'" AND aa.supplies_id = "2"
                ) as kanya_bt
                
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            WHERE al.air_year = "'.$bg_yearnow.'"
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');
        $count_plan     = DB::select(
            'SELECT COUNT(a.air_list_num) as cplan
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.air_plan_year = "'.$years.'" 
        '); 
        foreach ($count_plan as $key => $value) {
            $data['count'] = $value->cplan;
        }
        $ye            = DB::table('air_plan_month')->where('years',$years)->first();
        $ye_name       = $ye->air_plan_name;
 
        $pdf = PDF::loadView('support_prs.air.air_plan_print',$data,[            
            'data_air' => $data_air, 'bg_yearnow' => $bg_yearnow,'siguser' => $siguser,'sigrong' => $sigrong, 'position' => $position,'ptname' => $ptname,'po' => $po,'rong_bo'=>$rong_bo,'ye_name'=>$ye_name           
            ])->setPaper('a4', 'landscape');
            return @$pdf->stream(); 
    }

    public function air_plan_year_print(Request $request, $idsup,$month,$years)
    {
        
        $org = DB::table('orginfo')->where('orginfo_id', '=', 1)
        ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
        ->first();
        $rong = $org->prefix_name . ' ' . $org->fname . '  ' . $org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        $rong = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $rong_bo = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $sigrong_ = $rong->signature; //หัวหน้าบริหาร

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $count_ = DB::table('users')->where('id', '=', $iduser)->count();
        if ($count_ != 0) {
            $signa = DB::table('users')->where('id', '=', $iduser)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
                // ->orwhere('com_repaire_no','=',$dataedit->com_repaire_no)
            $ptname   = $signa->prefix_name . '' . $signa->fname . '  ' . $signa->lname;
            $position = $signa->position_name;
            $siguser  = $signa->signature; //ผู้รองขอ
            // $sigstaff = $signature->signature_name_stafftext; //เจ้าหน้าที่
            // $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            // $sighn = $signature->signature_name_hntext; //หัวหน้า
            // $sigrong = $signature->signature_name_rongtext; //หัวหน้าบริหาร
            // $sigpo = $signature->signature_name_potext; //ผอ
            $sigrong = $sigrong_; 
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        } else {
            $sigrong = '';
            $siguser = '';
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        }
        $data_air     = DB::select(
            'SELECT a.air_plan_year,a.air_list_num,c.detail,c.brand_name,c.btu,c.air_location_name,b.air_plan_month,b.air_plan_name,a.supplies_id,d.supplies_name,c.air_room_class
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.supplies_id = "'.$idsup.'" AND b.air_plan_month = "'.$month.'" AND a.air_plan_year = "'.$years.'"
            GROUP BY a.air_list_num
        '); 
        $count_plan     = DB::select(
            'SELECT COUNT(a.air_list_num) as cplan
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.supplies_id = "'.$idsup.'" AND b.air_plan_month = "'.$month.'" AND a.air_plan_year = "'.$years.'" 
        '); 
        foreach ($count_plan as $key => $value) {
            $data['count'] = $value->cplan;
        }
        $mo            = DB::table('air_plan_month')->where('air_plan_month',$month)->first();
        $mo_name       = $mo->air_plan_name;

        // $customPaper = [0, 0, 297.00, 210.80];
        $pdf = PDF::loadView('support_prs.air.air_plan_year_print',$data,[            
            'data_air' => $data_air, 'bg_yearnow' => $bg_yearnow,'siguser' => $siguser,'sigrong' => $sigrong, 'position' => $position,'ptname' => $ptname,'po' => $po,'rong_bo'=>$rong_bo,'mo_name'=>$mo_name           
            ])->setPaper('a4', 'landscape');
            // ])->setPaper($customPaper, 'landscape');

            return @$pdf->stream(); 
    }

    public function air_plan_year_print_sup(Request $request, $idsup,$years)
    {
        
        $org = DB::table('orginfo')->where('orginfo_id', '=', 1)
        ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
        ->first();
        $rong = $org->prefix_name . ' ' . $org->fname . '  ' . $org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        $rong = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $rong_bo = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $sigrong_ = $rong->signature; //หัวหน้าบริหาร

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $count_ = DB::table('users')->where('id', '=', $iduser)->count();
        if ($count_ != 0) {
            $signa = DB::table('users')->where('id', '=', $iduser)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
                // ->orwhere('com_repaire_no','=',$dataedit->com_repaire_no)
            $ptname   = $signa->prefix_name . '' . $signa->fname . '  ' . $signa->lname;
            $position = $signa->position_name;
            $siguser  = $signa->signature; //ผู้รองขอ
            // $sigstaff = $signature->signature_name_stafftext; //เจ้าหน้าที่
            // $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            // $sighn = $signature->signature_name_hntext; //หัวหน้า
            // $sigrong = $signature->signature_name_rongtext; //หัวหน้าบริหาร
            // $sigpo = $signature->signature_name_potext; //ผอ
            $sigrong = $sigrong_;
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        } else {
            $sigrong = '';
            $siguser = '';
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        }
        $data_air     = DB::select(
            'SELECT a.air_plan_year,a.air_list_num,c.detail,c.brand_name,c.btu,c.air_location_name,b.air_plan_month,b.air_plan_name,a.supplies_id,d.supplies_name,c.air_room_class
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.supplies_id = "'.$idsup.'" AND a.air_plan_year = "'.$years.'"
            GROUP BY a.air_list_num
        '); 
        // ,b.air_plan_month
        $count_plan     = DB::select(
            'SELECT COUNT(a.air_list_num) as cplan
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.supplies_id = "'.$idsup.'" AND a.air_plan_year = "'.$years.'" 
        '); 
        foreach ($count_plan as $key => $value) {
            $data['count'] = $value->cplan;
        }
        $ye            = DB::table('air_plan_month')->where('years',$years)->first();
        $ye_name       = $ye->air_plan_name;





        $pdf = PDF::loadView('support_prs.air.air_plan_year_print_sup',$data,[            
            'data_air' => $data_air, 'bg_yearnow' => $bg_yearnow,'siguser' => $siguser,'sigrong' => $sigrong, 'position' => $position,'ptname' => $ptname,'po' => $po,'rong_bo'=>$rong_bo,'ye_name'=>$ye_name           
            ])->setPaper('a4', 'landscape');
            return @$pdf->stream(); 
    }


    public function air_plan_year_print๘๘๘๘(Request $request, $idsup,$month,$years)
    {
        $org = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $rong = $org->prefix_name . ' ' . $org->fname . '  ' . $org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $iduser = Auth::user()->id;
        $count = DB::table('users')->where('id', '=', $iduser)->count();
            // ->orwhere('com_repaire_no', '=', $dataedit->com_repaire_no)
            
        if ($count != 0) {
            $signa = DB::table('users')->where('id', '=', $iduser)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
                // ->orwhere('com_repaire_no','=',$dataedit->com_repaire_no)
            $ptname   = $signa->prefix_name . '' . $signa->fname . '  ' . $signa->lname;
            $position = $signa->position_name;
            $siguser  = $signa->signature; //ผู้รองขอ
            // $sigstaff = $signature->signature_name_stafftext; //เจ้าหน้าที่
            // $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            // $sighn = $signature->signature_name_hntext; //หัวหน้า
            // $sigrong = $signature->signature_name_rongtext; //หัวหน้าบริหาร
            // $sigpo = $signature->signature_name_potext; //ผอ
            $sigrong = ''; 
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        } else {
            $sigrong = '';
            $siguser = '';
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        }
        $data_air     = DB::select(
            'SELECT a.air_plan_year,a.air_list_num,c.detail,c.brand_name,c.btu,c.air_location_name,b.air_plan_month,b.air_plan_name,a.supplies_id,d.supplies_name
            FROM air_plan a 
            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
            LEFT JOIN air_list c ON c.air_list_num = a.air_list_num
            LEFT JOIN air_supplies d ON d.air_supplies_id = a.supplies_id 
            WHERE a.supplies_id = "1"
            GROUP BY a.air_list_num
        '); 
        define('FPDF_FONTPATH', 'font/');
        require(base_path('public') . "/fpdf/WriteHTML.php");

            $pdf = new Fpdi(); // Instantiation   start-up Fpdi
            // get the page count
            // $pageCount = $pdf->setSourceFile('Laboratory-Report.pdf');
            // iterate through all pages
            // for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                // $templateId = $pdf->importPage($pageNo);

                // function dayThai($strDate)
                // {
                //     $strDay = date("j", strtotime($strDate));
                //     return $strDay;
                // }
                // function monthThai($strDate)
                // {
                //     $strMonth = date("n", strtotime($strDate));
                //     $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                //     $strMonthThai = $strMonthCut[$strMonth];
                //     return $strMonthThai;
                // }
                // function yearThai($strDate)
                // {
                //     $strYear = date("Y", strtotime($strDate)) + 543;
                //     return $strYear;
                // }
                // function time($strtime)
                // {
                //     $H = substr($strtime, 0, 5);
                //     return $H;
                // }
                // function DateThai($strDate)
                // {
                //     if ($strDate == '' || $strDate == null || $strDate == '0000-00-00') {
                //         $datethai = '';
                //     } else {
                //         $strYear = date("Y", strtotime($strDate)) + 543;
                //         $strMonth = date("n", strtotime($strDate));
                //         $strDay = date("j", strtotime($strDate));
                //         $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                //         $strMonthThai = $strMonthCut[$strMonth];
                //         $datethai = $strDate ? ($strDay . ' ' . $strMonthThai . ' ' . $strYear) : '-';
                //     }
                //     return $datethai;
                // }

                $pdf->SetLeftMargin(22);
                $pdf->SetRightMargin(5);
                $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
                $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
                $pdf->SetFont('THSarabunNew Bold', '', 19);
                // $pdf->AddPage("L", ['100', '100']);
                $pdf->AliasNbPages();
                $pdf->AddPage("L");
                // $pdf->Image('assets/images/crut.png', 22, 15, 16, 16);
                $pdf->SetFont('THSarabunNew Bold', '', 17);
                $pdf->Text(15, 25, iconv('UTF-8', 'TIS-620', 'แผนการบำรุงรักษาเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ ปีงบประมาณ '.$bg_yearnow));
                $pdf->SetFont('THSarabunNew', '', 17);
                // $pdf->Text(75, 33, iconv('UTF-8', 'TIS-620', 'โรงพยาบาล ' ));
                // $pdf->Text(75, 33, iconv('UTF-8', 'TIS-620', 'โรงพยาบาล ' . $org->orginfo_name));
                $pdf->SetFont('THSarabunNew', '', 14);
                $i = 1;
                foreach ($data_air as $key => $value) {
                    $current_y = $pdf->GetY();
                    $current_x = $pdf->GetX();
                    $pdf->MultiCell(1, 0.5, $i, 1, 'L');
                    $end_y = $pdf->GetY();

                    $current_x = $current_x + 1;
                    $pdf->SetXY($current_x, $current_y);
                    $pdf->MultiCell(4, 0.5, $value->air_list_num, 1, 'L');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 4;
                    $pdf->SetXY($current_x, $current_y); 
                    $pdf->MultiCell(4, 0.5, $value->detail, 1, 'L');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 4;
                    $pdf->SetXY($current_x, $current_y);
                    $pdf->MultiCell(4, 0.5, $value->air_location_name, 1, 'L');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $i++;
                    $pdf->SetY($end_y);
                }
                // $pdf->Text(25, 41, iconv('UTF-8', 'TIS-620', 'หน่วยงานที่แจ้งซ่อม : '));
                // $pdf->Text(25, 41, iconv('UTF-8', 'TIS-620', 'หน่วยงานที่แจ้งซ่อม :   ' . $dataedit->com_repaire_debsubsub_name));
          

                //ผู้ดูแลอนุญาต
                if ($siguser != null) {
                    $pdf->Image($siguser, 18, 261, 30, 15, "png");
                    $pdf->SetFont('THSarabunNew', '', 14);
                    $pdf->Text(10, 272, iconv('UTF-8', 'TIS-620', 'ลงชื่อ                              ผู้เสนอแผน'));
                    $pdf->Text(18, 278, iconv('UTF-8', 'TIS-620', '' . $ptname . ''));
                    $pdf->Text(10, 284, iconv('UTF-8', 'TIS-620', 'ตำแหน่ง ' . $position . ''));
                    
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                            ผู้อนุญาต')); 
                    // $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', '(                                   )')); 
                    // $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
                } else {
                    // $pdf->Image($siguser, 105,173, 50, 17,"png"); 
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(100, 180, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) ............................... ผู้อนุญาต'));
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(108, 189, iconv('UTF-8', 'TIS-620', '( .................................... )'));
                }
        
                if ($siguser != null) { 
                    $pdf->Image($siguser, 83, 261, 30, 15, "png");
                    $pdf->SetFont('THSarabunNew', '', 14);
                    $pdf->Text(75, 272, iconv('UTF-8', 'TIS-620', 'ลงชื่อ                              ผู้เห็นชอบ'));
                    $pdf->Text(82, 278, iconv('UTF-8', 'TIS-620', '' . $ptname . ''));
                    $pdf->Text(75, 284, iconv('UTF-8', 'TIS-620', 'หัวหน้ากลุ่มภารกิจด้านอำนวยการ '));
                    // if ($dataedit->car_service_status == "noallow") {
                    //     $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
                    //     $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 140, 217, 4, 4);
                    // } else {
                    //     $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4.5, 4.5);
                    //     $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 105, 217, 4.5, 4.5); 
                    // }
                    // $pdf->Image($sigpo, 109, 225, 50, 17, "png");
                    // $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', $po));
                    // // $pdf->Text(150,288,iconv( 'UTF-8','TIS-620','ผู้อำนวยการ'.$orgpo->orginfo_name  ));
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                            ผู้เสนอแผน')); 
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
                } else {
                    // $pdf->Image($siguser, 105,225, 50, 17,"png");
                    // $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
                    // $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4, 4);
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                            ผู้อนุญาต'));
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', '(                                   )'));
                    // $pdf->SetFont('THSarabunNew', '', 15);
                    // $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
                }
                if ($siguser != null) { 
                    $pdf->Image($siguser, 152, 261, 30, 15, "png");
                    $pdf->SetFont('THSarabunNew', '', 14);
                    $pdf->Text(142, 272, iconv('UTF-8', 'TIS-620', 'ลงชื่อ                              ผู้อนุมัติ'));
                    $pdf->Text(147, 278, iconv('UTF-8', 'TIS-620', '' . $ptname . ''));
                    $pdf->Text(137, 284, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ ' ));
                
                } else { 
                }

                // $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

                // $pdf->SetFont('Helvetica');
                // $pdf->SetXY(5, 5);
                // $pdf->Write(8, 'A complete document imported with FPDI');
            // }
        $pdf->Output();
        exit;
    }



 }