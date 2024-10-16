<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Visit_import_date;
use App\Models\Visit_pttype;
use App\Models\Visit_pttype_import_excel;
use App\Models\Visit_pttype_import; 
use App\Models\D_apiwalkin_ins;  
use App\Models\D_apiwalkin_adp;
use App\Models\D_apiwalkin_aer;
use App\Models\D_apiwalkin_orf;
use App\Models\D_apiwalkin_odx;
use App\Models\D_apiwalkin_cht;
use App\Models\D_apiwalkin_cha;
use App\Models\D_apiwalkin_oop;
use App\Models\D_claim; 
use App\Models\D_apiwalkin_dru;
use App\Models\D_apiwalkin_idx;
use App\Models\D_apiwalkin_iop;
use App\Models\D_apiwalkin_ipd;
use App\Models\D_apiwalkin_pat;
use App\Models\D_apiwalkin_opd;
use App\Models\D_walkin;
use App\Models\Authen_date;
use App\Models\Audit_approve_code;
use App\Models\Ovstdiag;
use App\Models\Ovst;
use App\Models\Vn_stat;

use App\Models\Fdh_sesion;
use App\Models\Fdh_ins;
use App\Models\Fdh_pat;
use App\Models\Fdh_opd;
use App\Models\Fdh_orf;
use App\Models\Fdh_odx;
use App\Models\Fdh_cht;
use App\Models\Fdh_cha;
use App\Models\Fdh_oop; 
use App\Models\Fdh_adp;
use App\Models\Fdh_dru;
use App\Models\Fdh_idx;
use App\Models\Fdh_iop;
use App\Models\Fdh_ipd;
use App\Models\Fdh_aer;
use App\Models\Fdh_irf;
use App\Models\Fdh_lvd;
use App\Models\D_ofc_401;
use App\Models\D_dru_out;
use App\Models\Audit_217;
use App\Models\D_fdh;

use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr;   
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

use Mail;
use Illuminate\Support\Facades\Storage;
  
 
date_default_timezone_set("Asia/Bangkok");

class PreauditController extends Controller
{  
    public function authen_excel(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $newdays     = date('Y-m-d', strtotime($date . ' -2 days')); //ย้อนหลัง 2 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        if ($startdate == '') {
          
            // $data['fdh_mini_dataset'] = DB::connection('mysql10')->select(
            //     'SELECT c.vn,c.hn,p.cid,c.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,c.pttype,"" as subinscl,v.income as debit,vp.claim_code,"" as claimtype,v.hospmain
            //     ,p.hometel,c.hospsub,c.main_dep,"" as hmain,"" as hsub,"" as subinscl_name,c.staff,k.department,v.pdx
            //     from ovst c
            //     LEFT JOIN visit_pttype vp ON vp.vn = c.vn
            //     LEFT JOIN vn_stat v ON v.vn = c.vn
            //     LEFT JOIN patient p ON p.hn = v.hn
            //     LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
            //     WHERE c.vstdate BETWEEN "'.$date.'" AND "'.$date.'" 
            //     AND vp.claim_code is null
            //     AND c.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
                
            //     AND v.pdx NOT IN("Z000") AND p.cid IS NOT NULL
            //     GROUP BY c.vn 
            // ');
            // $date_old      = DB::table('visit_import_date')->where('visit_import_date_id','1')->first();
            // if ($date_old == null || $date_old == '') {
            //     $startdate_    = '';
            //     $enddate_      = '';
            // } else {
            //     $startdate_    = $date_old->startdate;
            //     $enddate_      = $date_old->enddate;
            // }    
                               

            $data['authen_excel'] = DB::connection('mysql10')->select(
                'SELECT vp.vn,v.hn,v.cid,v.vstdate,v.pttype ,concat(p.pname,p.fname," ",p.lname) as ptname,IFNULL(vp.claim_code,vp.auth_code) as claim_code,v.income
                ,v.income-v.discount_money-v.rcpt_money as debit
                FROM vn_stat v
                LEFT JOIN visit_pttype vp ON vp.vn = v.vn
                LEFT JOIN patient p ON p.hn = v.hn
                WHERE v.vstdate = "'.$date.'" AND (vp.auth_code IS NULL OR vp.auth_code ="") 
          
                AND v.pttype NOT IN("10","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","l5","l6")  
                GROUP BY v.vn  
            ');
            // AND v.pttype NOT IN("10","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")  
            // WHERE v.vstdate = "'.$date.'" AND (vp.auth_code IS NULL OR vp.auth_code ="") 

            // $data['authen_excel_date'] = DB::connection('mysql2')->select(
            //     'SELECT vp.vn,v.hn,v.cid,v.vstdate,v.pttype ,concat(p.pname,p.fname," ",p.lname) as ptname,vp.claim_code
            //     FROM vn_stat v
            //     JOIN visit_pttype vp
            //     JOIN patient p on p.hn=v.hn
            //     WHERE v.vstdate BETWEEN "'.$startdate_.'" AND "'.$enddate_.'" AND (vp.claim_code IS NULL OR vp.claim_code ="")  
            //     GROUP BY v.vn  
            // ');
        } else {
          
            // Visit_import_date::insert([
            //     'startdate'  => $startdate,
            //     'enddate'    => $enddate,
            // ]);

            $date_befir  = Authen_date::where('authen_id','=','1')->first();
            $startdate   = $date_befir->startdate;
            $enddate     = $date_befir->enddate;
            
            $data_vn_1 = DB::connection('mysql2')->select(
                'SELECT v.vn,p.hn,p.cid,v.vstdate,o.pttype,p.birthday,p.hometel,p.citizenship,p.nationality,v.pdx,o.hospmain,o.hospsub
                ,concat(p.pname,p.fname," ",p.lname) as ptname
                ,o.staff,op.name as sname,v.income-v.discount_money-v.rcpt_money as debit,v.income
                FROM vn_stat v
                LEFT JOIN visit_pttype vs on vs.vn = v.vn
                LEFT JOIN ovst o on o.vn = v.vn 
                LEFT JOIN patient p on p.hn=v.hn
                LEFT JOIN pttype pt on pt.pttype=v.pttype
                LEFT JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND v.pttype NOT IN("10","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","l5","l6")   
                AND p.cid IS NOT NULL AND (vs.auth_code IS NULL OR vs.auth_code ="")   
                
                GROUP BY o.vn 
            ');
            // AND p.nationality ="99"
            // AND v.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
            // AND p.birthday <> "'.$startdate.'" 
            // AND v.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
            // AND (vp.claim_code IS NULL OR vp.claim_code ="")
            foreach ($data_vn_1 as $key => $value_1) {                
                $check = Visit_pttype_import::where('vn', $value_1->vn)->count();
                    if ($check > 0) {   
                        // Check_sit_auto::where('vn', $value_1->vn)->update([  
                        //     'vstdate'    => $value_1->vstdate,
                        //     'pttype'     => $value_1->pttype,
                        //     'debit'      => $value_1->debit, 
                        //     'debit'      => $value_1->income,
                        // ]);              
                    } else {
                        Visit_pttype_import::insert([
                            'vn'         => $value_1->vn, 
                            'hn'         => $value_1->hn,
                            'pid'        => $value_1->cid,
                            'vstdate'    => $value_1->vstdate,
                            'hometel'    => $value_1->hometel, 
                            'ptname'     => $value_1->ptname,
                            'pttype'     => $value_1->pttype,
                            'hcode'      => $value_1->hospmain, 
                        ]);
                    }
               
            }
            
      
            // $data['authen_excel'] = DB::connection('mysql')->select(
            //     'SELECT *
            //     FROM visit_pttype_import 
            //     WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND claimcode IS NULL
            //     GROUP BY vn 
            //     ORDER BY claimcode DESC 
            // ');
            $data['authen_excel'] = DB::connection('mysql10')->select(
                'SELECT vp.vn,v.hn,v.cid,v.vstdate,v.pttype ,concat(p.pname,p.fname," ",p.lname) as ptname,IFNULL(vp.claim_code,vp.auth_code) as claim_code
                FROM vn_stat v
                JOIN visit_pttype vp
                JOIN patient p on p.hn=v.hn
                WHERE v.vstdate = "'.$date.'" AND (vp.auth_code IS NULL OR vp.auth_code ="") AND v.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7") 
                GROUP BY v.vn  
            ');
            $data['authen_excel_date'] = DB::connection('mysql10')->select(
                'SELECT vp.vn,v.hn,v.cid,v.vstdate,v.pttype ,concat(p.pname,p.fname," ",p.lname) as ptname,IFNULL(vp.claim_code,vp.auth_code) as claim_code
                FROM vn_stat v
                JOIN visit_pttype vp
                JOIN patient p on p.hn=v.hn
                WHERE v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND (vp.auth_code IS NULL OR vp.auth_code ="")  
                GROUP BY v.vn  
            ');
        }

     

        return view('audit.authen_excel',$data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
        ]);
    }
    public function authen_excel_process(Request $request)
    { 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        Authen_date::truncate();

        $data_vn_1 = DB::connection('mysql2')->select(
            'SELECT v.vn,p.hn,p.cid,v.vstdate,o.pttype,p.birthday,p.hometel,p.citizenship,p.nationality,v.pdx,o.hospmain,o.hospsub
            ,concat(p.pname,p.fname," ",p.lname) as ptname
            ,o.staff,op.name as sname,v.income-v.discount_money-v.rcpt_money as debit,v.income
            FROM vn_stat v
            LEFT JOIN visit_pttype vs on vs.vn = v.vn
            LEFT JOIN ovst o on o.vn = v.vn 
            LEFT JOIN patient p on p.hn=v.hn
            LEFT JOIN pttype pt on pt.pttype=v.pttype
            LEFT JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"           
            AND p.cid IS NOT NULL   
           
            GROUP BY o.vn 
        '); 
        // AND (vs.auth_code IS NULL OR vs.auth_code ="")  
        // AND v.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")    
        // AND v.income > 0 
        Visit_pttype_import::truncate();     
        foreach ($data_vn_1 as $key => $value_1) {    
            Visit_pttype_import::insert([
                'vn'         => $value_1->vn, 
                'hn'         => $value_1->hn,
                'pid'        => $value_1->cid,
                'vstdate'    => $value_1->vstdate,
                'hometel'    => $value_1->hometel, 
                'ptname'     => $value_1->ptname,
                'pttype'     => $value_1->pttype,
                'hcode'      => $value_1->hospmain, 
            ]);  
        }

        $months                     = date('H');
        $authen_time                = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $data['monthsnew']          = substr($months,1,2); 
        $datenow        = date('Y-m-d');
        Authen_date::insert([
            'authen_date'     => $datenow, 
            'authen_time'     => $authen_time,
            'startdate'       => $startdate,
            'enddate'         => $enddate, 
        ]); 

        return response()->json([
            'status'    => '200',
        ]);
    }
    public function authen_excel_save(Request $request)
    { 
            $this->validate($request, [
                'file' => 'required|file|mimes:xls,xlsx'
            ]);
            $the_file = $request->file('file');
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                // $sheet        = $spreadsheet->getActiveSheet();
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                // $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( '2', $row_limit );
                // $row_range    = range( "!", $row_limit );
                // $column_range = range( 'T', $column_limit );
                $startcount = '2';
                // $row_range_namefile  = range( 9, $sheet->getCell( 'A' . $row )->getValue() );                    
                $data = array();
                foreach ($row_range as $row ) {

                    $vst = $sheet->getCell( 'P' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4)-543;
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'Q' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $vsttime = substr($reg,12,8);
                    $hm = substr($reg,12,2);
                    $mm = substr($reg,15,2);
                    $ss = substr($reg,18,2);
                    $datesave = $regyear.'-'.$regmo.'-'.$regday.'-'.$vsttime;  
                    $data[] = [
                            'hcode'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                            'hosname'                  =>$sheet->getCell( 'B' . $row )->getValue(),
                            'cid'                      =>$sheet->getCell( 'C' . $row )->getValue(),
                            'ptname'                   =>$sheet->getCell( 'D' . $row )->getValue(),
                            'birthday'                 =>$sheet->getCell( 'E' . $row )->getValue(),
                            'hometel'                  =>$sheet->getCell( 'F' . $row )->getValue(), 
                            'mainpttype'               =>$sheet->getCell( 'G' . $row )->getValue(),
                            'subpttype'                =>$sheet->getCell( 'H' . $row )->getValue(), 
                            'repcode'                  =>$sheet->getCell( 'I' . $row )->getValue(),
                            'claimcode'                =>$sheet->getCell( 'J' . $row )->getValue(),
                            'servicerep'               =>$sheet->getCell( 'K' . $row )->getValue(),
                            'claimtype'                =>$sheet->getCell( 'L' . $row )->getValue(),
                            'servicename'              =>$sheet->getCell( 'M' . $row )->getValue(),
                            'hncode'                   =>$sheet->getCell( 'N' . $row )->getValue(),
                            'ancode'                   =>$sheet->getCell( 'O' . $row )->getValue(), 
                            'vstdate'                  =>$vstdate,
                            'regdate'                  =>$datesave, 
                            // 'regdate'                     =>$sheet->getCell( 'Q' . $row )->getValue(),
                            'status'                   =>$sheet->getCell( 'R' . $row )->getValue(),
                            'repauthen'                =>$sheet->getCell( 'S' . $row )->getValue(),
                            'authentication'           =>$sheet->getCell( 'T' . $row )->getValue(),
                            'staffservice'             =>$sheet->getCell( 'U' . $row )->getValue(),
                            'dateeditauthen'           =>$sheet->getCell( 'V' . $row )->getValue(),
                            'nameeditauthen'           =>$sheet->getCell( 'W' . $row )->getValue(), 
                            'comment'                  =>$sheet->getCell( 'X' . $row )->getValue(), 
                            // 'STMdoc'                  =>$file_
                    ];                             
                    $startcount++;                            
                }
                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {                   
                    Visit_pttype_import_excel::insert($data_);  
                } 
                // DB::table('acc_stm_ofcexcel')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }  

            $data_authen_excel = DB::connection('mysql')->select('SELECT * FROM visit_pttype_import_excel WHERE claimtype = "PG0060001" AND repauthen <> "ENDPOINT"');
            // AND (mainpttype LIKE "%WEL%" OR mainpttype LIKE "%UCS%")
            // AND repauthen <> "ENDPOINT"  
            foreach ($data_authen_excel as $key => $value) {
                $check = Visit_pttype_import::where('pid', $value->cid)->where('vstdate', $value->vstdate)->whereNotIn('pttype', ['M1','M2','M3','M4','M5','O1','O2','O3','O4','O5','L1','L2','L3','L4','L5'])->count();
                if ($check > 0) {
                    Visit_pttype_import::where('pid', $value->cid)->where('vstdate', $value->vstdate)->whereNotIn('pttype',['M1','M2','M3','M4','M5','O1','O2','O3','O4','O5','L1','L2','L3','L4','L5'])->update([  
                        'cid'           => $value->cid,
                        'claimcode'     => $value->claimcode,
                        'claimtype'     => $value->claimtype,  
                    ]); 
                } 
            } 
            $data_authen_excel_ti = DB::connection('mysql')->select('SELECT * FROM Visit_pttype_import_excel WHERE claimtype = "PG0130001" AND repauthen <> "ENDPOINT"');
            // AND (mainpttype LIKE "%WEL%" OR mainpttype LIKE "%UCS%") 
            // AND repauthen <> "ENDPOINT"
            foreach ($data_authen_excel_ti as $key => $value_ti) {
                $checkti = Visit_pttype_import::where('pid', $value_ti->cid)->where('vstdate', $value_ti->vstdate)->whereIn('pttype', ['M1','M2','M3','M4','M5'])->count();
                if ($checkti > 0) {
                    Visit_pttype_import::where('pid', $value_ti->cid)->where('vstdate', $value_ti->vstdate)->whereIn('pttype',['M1','M2','M3','M4','M5'])->update([  
                        'cid'           => $value_ti->cid,
                        'claimcode'     => $value_ti->claimcode,
                        'claimtype'     => $value_ti->claimtype,  
                    ]);  
                } 
            }  
            return back();           
          
    }
    public function authen_update(Request $request)
    {
        $date        = date('Y-m-d');
        $date_befir  = Authen_date::where('authen_id','=','1')->first();
        $startdate   = $date_befir->startdate;
        $enddate     = $date_befir->enddate;

        $data_authen_excel = DB::connection('mysql')->select('SELECT * FROM visit_pttype_import WHERE claimtype = "PG0060001" AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
        foreach ($data_authen_excel as $key => $value) {
            Visit_pttype::where('vn', $value->vn)->whereNotIn('pttype',['O1','O2','O3','O4','O5','L1','L2','L3','L4','L5'])->update([   
                'claim_code'     => $value->claimcode,  
                'auth_code'      => $value->claimcode, 
            ]);  
        }
        $data_authen_excel_ti = DB::connection('mysql')->select(
            'SELECT * FROM
            Visit_pttype_import
            WHERE claimtype = "PG0130001" AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
        ');
        foreach ($data_authen_excel_ti as $key => $valueti) {
            Visit_pttype::where('vn', $valueti->vn)->whereIn('pttype',['M1','M2','M3','M4','M5'])->update([   
                'claim_code'     => $valueti->claimcode,  
                'auth_code'      => $valueti->claimcode, 
            ]);  
        }
        Visit_pttype_import::truncate();
        Visit_pttype_import_excel::truncate();

        // AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")
            return response()->json([
                'status'    => '200',
            ]);
    }
   

    public function pre_audit(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate == '') { 
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn
                    ,count(DISTINCT authen) as countauthen
                    ,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve,sum(debit) as sum_total 
                    FROM d_fdh WHERE vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                    AND projectcode ="OFC" AND debit > 0
                    AND an IS NULL
                    GROUP BY month(vstdate)
            ');  
            $data['fdh_ofc_m']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) ="'.$m.'" AND projectcode ="OFC" AND debit > 0 AND authen IS NULL AND an IS NULL GROUP BY vn'); 
            // ,(SELECT sum(debit) FROM d_fdh WHERE month(vstdate)= "'.$newDate.'" AND "'.$date.'" AND authen IS NULL AND projectcode ="OFC") as no_total
            // ,(SELECT sum(debit) FROM d_fdh WHERE vstdate BETWEEN "'.$newDate.'" AND "'.$date.'" AND authen IS NOT NULL AND projectcode ="OFC") as sum_total            
            
        } else {
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn,count(DISTINCT authen) as countauthen,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve ,sum(debit) as sum_total  
                    FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND projectcode ="OFC" AND debit > 0 
                    AND an IS NULL
                    GROUP BY month(vstdate)
            '); 
            // ,(SELECT sum(debit) FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND authen IS NULL AND projectcode ="OFC") as no_total
            // ,(SELECT sum(debit) FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND authen IS NOT NULL AND projectcode ="OFC") as sum_total  
                       
                
            }   
                     
        return view('audit.pre_audit',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }  
    public function audit_approve_codenew(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
                    
        // $data['ofc_data']  = DB::connection('mysql')->select(
        //     'SELECT * FROM audit_approve_code  
        // ');   
        $data['ofc_data'] = DB::connection('mysql2')->select(
            'SELECT v.vn,o.an,v.hn,v.cid,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.pttype,v.vstdate,v.age_y,(v.income-v.discount_money-v.rcpt_money) as debit,rd.*  
                                   
                    FROM vn_stat v
                    LEFT OUTER JOIN patient pt ON v.hn=pt.hn
                    LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                    LEFT OUTER JOIN ovst o ON v.vn=o.vn
                    LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain
                    LEFT OUTER JOIN opdscreen op ON v.vn = op.vn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                    LEFT OUTER JOIN rcpt_print r on r.vn =v.vn
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                    LEFT OUTER JOIN hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate                        
                    LEFT OUTER JOIN ktb_edc_transaction k on k.vn = v.vn  
                    LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                    LEFT OUTER JOIN ovstost ovv on ovv.ovstost = ot.ovstost

                WHERE o.vstdate ="'.$date.'"
                AND v.pttype in("O1","O2","O3","O4","O5")                    
                AND v.pttype not in ("OF","FO") AND rd.sss_approval_code IS NOT NULL                         
                AND o.an is null 
                GROUP BY o.vn
        '); 
           
                
        return view('audit.audit_approve_codenew',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }   
    public function audit_approve_codenew_process(Request $request)
    {
        $startdate = $request->startdate;
        $enddate   = $request->enddate; 
        $date = date('Y-m-d');
  
        if ($startdate == '') { 
            return response()->json([
                'status'    => '100'
           ]);
        } else {
            Audit_approve_code::truncate();
                $iduser = Auth::user()->id;  
                $data_main_ = DB::connection('mysql2')->select(
                    'SELECT concat(p.pname,p.fname," ",p.lname) as ptname,  r.*,o.vstdate,o.vsttime,t.name as pttype_name   
                    FROM rcpt_debt r  
                    left outer join ovst o on o.vn=r.vn  
                    left outer join patient p on p.hn=o.hn  
                    left outer join pttype t on t.pttype = r.pttype  
                    where r.pt_type="OPD" and r.debt_date 
                     BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND r.pttype IN("O1","O2","O3","O4","O5")
                    order by r.debt_id 
                ');  
                       
                foreach ($data_main_ as $key => $value) {    
                    
                    Audit_approve_code::insert([
                            'vn'                  => $value->vn,
                            'hn'                  => $value->hn, 
                            'ptname'              => $value->ptname,
                            'staff'               => $value->staff, 
                            'debt_date'           => $value->debt_date,
                            'debt_time'           => $value->debt_time,
                            'amount'              => $value->amount,
                            'total_amount'        => $value->total_amount,
                            'sss_approval_code'   => $value->sss_approval_code,
                            'sss_amount'          => $value->sss_amount,
                            
                        ]);
                    
                }   
            }   
                     
            return response()->json([
                'status'    => '200'
           ]);
    }   
    function audit_approve_codenew_excel(Request $request)
    {  
        Audit_approve_code::truncate();
                $the_file = $request->file('files'); 
                // $file_ = $request->file('files')->getClientOriginalName(); //ชื่อไฟล์ 
   
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow(); 
                $row_range    = range('1',$row_limit ); 
                $startcount = '1';
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'G' . $row )->getValue();  
                    // $day = substr($vst,0,2);
                    // $mo = substr($vst,3,2);
                    // $year = substr($vst,6,4);
                    // $vstdate = $year.'-'.$mo.'-'.$day;
                  
                    // $timestamp = strtotime($vst);
                    // $originalDate = "2023-05-31"; 
                    // Unix time = 1685491200
                    // $unixTime = strtotime($originalDate);
                    // Pass the new date format as a string and the original date in Unix time
                    $newDate = date("Y-m-d", strtotime($vst));
                    // echo $newDate;
                    // date($format,strtotime($vst));

                    // dd($newDate);
                    $data[] = [
                        'ECLAIM_NO'         =>$sheet->getCell( 'B' . $row )->getValue(),
                        'CID_SPSCH'         =>$sheet->getCell( 'D' . $row )->getValue(),
                        'PTNAME_SPSCH'      =>$sheet->getCell( 'E' . $row )->getValue(), 
                        // 'HN_SPSCH'          =>$sheet->getCell( 'F' . $row )->getValue(), 
                        'VSTDATE_SPSCH'     =>$newDate,
                        'VSTTIME_SPSCH'     =>$sheet->getCell( 'H' . $row )->getValue(), 
                        'STATUS_SPSCH'      =>$sheet->getCell( 'I' . $row )->getValue(), 
                        'Tran_ID'           =>$sheet->getCell( 'K' . $row )->getValue(), 
                        'CLAIM'             =>$sheet->getCell( 'L' . $row )->getValue(), 
                        'REP'               =>$sheet->getCell( 'M' . $row )->getValue(), 
                        'ERROR_C'           =>$sheet->getCell( 'N' . $row )->getValue(), 
                        'Deny'              =>$sheet->getCell( 'O' . $row )->getValue(), 
                        'Channel'           =>$sheet->getCell( 'P' . $row )->getValue()  
                    ];
                    $startcount++;  
                } 
                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $datasert) {
                    Audit_approve_code::insert($datasert); 
                } 
                return response()->json([
                    'status'     => '200'
                ]);  
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
    public function audit_approve_code(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate == '') { 
    
            // $data['fdh_ofc']    = DB::connection('mysql')->select(
            //     'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
            //         ,count(DISTINCT vn) as countvn  
            //         ,sum(debit) as sum_total 
            //         FROM d_fdh   
            //         WHERE projectcode ="OFC" AND debit > 0 
            //         AND (an IS NULL OR an ="") 
                   
            //         AND vstdate BETWEEN "'.$start.'" AND "'.$end.'"  
            //         GROUP BY month(vstdate)
            // '); 
            
            $data['fdh_ofc_all']  = DB::connection('mysql')->select(
                'SELECT * FROM d_fdh 
                    WHERE projectcode ="OFC"  
                    AND hn <>"" 
                    AND (authen IS NULL OR authen ="") 
                    AND (an IS NULL OR an ="") AND debit > 0
                    AND vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                   
            '); 
                
            $data['fdh_ofc_momth']    = DB::connection('mysql')->select(
                'SELECT * FROM d_fdh 
                WHERE projectcode ="OFC" 
                AND hn <>""
                AND (authen IS NULL OR authen ="") 
                AND (an IS NULL OR an ="")
                AND month(vstdate) ="'.$m.'" AND year(vstdate) ="'.$yy.'" AND debit > 0
    
            '); 
              
            $data['fdh_ofc'] = DB::connection('mysql2')->select(
                'SELECT year(o.vstdate) as years ,month(o.vstdate) as months,year(o.vstdate) as days ,count(DISTINCT o.vn) as countvn ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as sum_total
                        FROM vn_stat v
                        LEFT OUTER JOIN patient pt ON v.hn=pt.hn
                        LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                        LEFT OUTER JOIN ovst o ON v.vn=o.vn
                        LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain
                        LEFT OUTER JOIN opdscreen op ON v.vn = op.vn
                        LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                        LEFT OUTER JOIN rcpt_print r on r.vn =v.vn
                        LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                        LEFT OUTER JOIN hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate                        
                        LEFT OUTER JOIN ktb_edc_transaction k on k.vn = v.vn  
                        LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                        LEFT OUTER JOIN ovstost ovv on ovv.ovstost = ot.ovstost

                    WHERE o.vstdate BETWEEN "'.$start.'" and "'.$end.'"
                    AND v.pttype in("O1","O2","O3","O4","O5")                    
                    AND v.pttype not in ("OF","FO")                          
                    AND o.an is null 
                    GROUP BY month(o.vstdate)
            '); 
            $data['fdh_ofc_day'] = DB::connection('mysql2')->select(
                'SELECT v.vn,o.an,v.hn,v.cid,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.pttype,v.vstdate,v.age_y,(v.income-v.discount_money-v.rcpt_money) as debit,rd.*  
                                       
                        FROM vn_stat v
                        LEFT OUTER JOIN patient pt ON v.hn=pt.hn
                        LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                        LEFT OUTER JOIN ovst o ON v.vn=o.vn
                        LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain
                        LEFT OUTER JOIN opdscreen op ON v.vn = op.vn
                        LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                        LEFT OUTER JOIN rcpt_print r on r.vn =v.vn
                        LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                        LEFT OUTER JOIN hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate                        
                        LEFT OUTER JOIN ktb_edc_transaction k on k.vn = v.vn  
                        LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                        LEFT OUTER JOIN ovstost ovv on ovv.ovstost = ot.ovstost

                    WHERE o.vstdate ="'.$date.'"
                    AND v.pttype in("O1","O2","O3","O4","O5")                    
                    AND v.pttype not in ("OF","FO") AND rd.sss_approval_code IS NULL                         
                    AND o.an is null 
                    GROUP BY o.vn
            '); 
            

            
        } else {
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn,count(DISTINCT authen) as countauthen,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve ,sum(debit) as sum_total  
                    FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND projectcode ="OFC" 
                    AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"") AND debit > 0
                    GROUP BY month(vstdate)
            '); 
            // ,(SELECT sum(debit) FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND authen IS NULL AND projectcode ="OFC") as no_total
            // ,(SELECT sum(debit) FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND authen IS NOT NULL AND projectcode ="OFC") as sum_total  
                       
                
            }   
                     
        return view('audit.audit_approve_code',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 
    public function audit_approve_detail(Request $request,$month,$year)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        // $y = date('Y') + 543;
        // $yy = date('Y');
        // $m = date('m');
 
        // $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        // $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        // $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') { 
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn
                    ,count(DISTINCT authen) as countauthen
                    ,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve,sum(debit) as sum_total 
                    FROM d_fdh WHERE vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                    AND projectcode ="OFC" AND debit > 0 AND hn<>""
                    AND an IS NULL
                    GROUP BY month(vstdate)
            ');  
            // $data['fdh_ofc_m']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) BETWEEN "'.$newDate.'" AND "'.$m.'" AND projectcode ="OFC" AND authen IS NULL AND an IS NULL GROUP BY vn'); 
            $data['fdh_ofc_m']       = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE projectcode ="OFC" AND debit > 0 AND hn<>"" AND authen IS NULL AND an IS NULL GROUP BY vn'); 
            $data['fdh_ofc_momth']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) ="'.$month.'" AND year(vstdate) ="'.$year.'" AND projectcode ="OFC" AND debit > 0 AND hn<>"" AND authen IS NULL AND an IS NULL GROUP BY vn'); 
           
        // } else {
        //     $data['fdh_ofc']    = DB::connection('mysql')->select(
        //         'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
        //             ,count(DISTINCT vn) as countvn,count(DISTINCT authen) as countauthen,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve ,sum(debit) as sum_total  
        //             FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND projectcode ="OFC" 
        //             AND an IS NULL
        //             GROUP BY month(vstdate)
        //     '); 
                      
                
        //     }   
                     
        return view('audit.audit_approve_detail',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'month'         => $month,
            'year'          => $year, 
        ]);
    } 
    public function approve_destroy(Request $request,$id)
    {
        $del = D_fdh::find($id);   
        $del->delete();  
        return response()->json(['status' => '200']);
    }    
    public function pre_audit_process_a(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $date = date('Y-m-d');
  
        if ($startdate == '') { 
            return response()->json([
                'status'    => '100'
           ]);
        } else {
                $iduser = Auth::user()->id;  
                $data_main_ = DB::connection('mysql2')->select(
                    'SELECT v.vn,o.an,v.cid,v.hn,concat(pt.pname,pt.fname," ",pt.lname) ptname
                            ,v.vstdate,v.pttype,IFNULL(rd.sss_approval_code,k.approval_code) as Apphos,v.inc04 as xray,h.hospcode,h.name as hospcode_name
                            ,rd.amount AS price_ofc,v.income,ptt.hipdata_code,group_concat(distinct k.amount) as edc,r.rcpno,rd.amount as rramont,v.paid_money,op.cc
                            ,group_concat(DISTINCT hh.appr_code,":",hh.transaction_amount,"/") AS AppKTB 
                            ,GROUP_CONCAT(DISTINCT ov.icd10 order by ov.diagtype) AS icd10,v.pdx,ovv.name as active_status,v.income-v.discount_money-v.rcpt_money as debit
                            FROM vn_stat v
                            LEFT OUTER JOIN patient pt ON v.hn=pt.hn
                            LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                            LEFT OUTER JOIN ovst o ON v.vn=o.vn
                            LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain
                            LEFT OUTER JOIN opdscreen op ON v.vn = op.vn
                            LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                            LEFT OUTER JOIN rcpt_print r on r.vn =v.vn
                            LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                            LEFT OUTER JOIN hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate                        
                            LEFT OUTER JOIN ktb_edc_transaction k on k.vn = v.vn  
                            LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                            LEFT OUTER JOIN ovstost ovv on ovv.ovstost = ot.ovstost

                        WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND v.pttype in("O1","O2","O3","O4","O5")                    
                        AND v.pttype not in ("OF","FO")                          
                        AND o.an is null 
                        GROUP BY v.vn 
                ');  
                       
                foreach ($data_main_ as $key => $value) {    
                    $check_ofc = D_fdh::where('vn',$value->vn)->where('projectcode','OFC')->count(); 
                    if ($check_ofc > 0) { 
                        D_fdh::where('vn',$value->vn)->where('projectcode','OFC')->update([ 
                            'an'             => $value->an,    
                            'pdx'            => $value->pdx,  
                            'icd10'          => $value->icd10, 
                            'debit'          => $value->debit,
                            'pttype'         => $value->pttype,
                            'price_ofc'      => $value->price_ofc,
                            'active_status'  => $value->active_status,
                            'authen'         => $value->Apphos,
                            'AppKTB'         => $value->AppKTB,
                            'edc'            => $value->edc,
                            'rcpno'          => $value->rcpno,
                            'paid_money'     => $value->paid_money,
                            'cc'             => $value->cc
                        ]);
                    } else { 
                        D_fdh::insert([
                            'vn'           => $value->vn,
                            'hn'           => $value->hn,
                            'an'           => $value->an, 
                            'cid'          => $value->cid,
                            'pttype'       => $value->pttype,                           
                            'ptname'       => $value->ptname,
                            'vstdate'      => $value->vstdate,
                            'authen'       => $value->Apphos,
                            'AppKTB'       => $value->AppKTB,
                            'edc'          => $value->edc,
                            'rcpno'        => $value->rcpno,
                            'paid_money'   => $value->paid_money,
                            'projectcode'  => 'OFC', 
                            'pdx'          => $value->pdx,  
                            'icd10'        => $value->icd10,
                            'hospcode'     => $value->hospcode, 
                            'debit'        => $value->debit,
                            'price_ofc'      => $value->price_ofc,
                            'active_status'  => $value->active_status,
                            'cc'             => $value->cc
                        ]);
                    }  
                }   
            }   
                     
            return response()->json([
                'status'    => '200'
           ]);
    } 
    public function pre_audit_chart(Request $request)
    {
        $date = date("Y-m-d"); 
        $y = date('Y');
        
        $labels = [
            1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
          ];
        $chart = DB::connection('mysql')->select(' 
            SELECT
            MONTH(c.vstdate) as month
            ,YEAR(c.vstdate) as year
            ,DAY(c.vstdate) as day
            ,COUNT(DISTINCT c.vn) as countvn
            ,COUNT(c.claimcode) as Authen
            ,COUNT(c.vn)-COUNT(c.claimcode) as Noauthen
            from check_sit_auto c
            LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
            WHERE year(c.vstdate) = "'.$y.'" 
            AND c.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7")
            AND c.main_dep NOT IN("011","036","107")
            GROUP BY month
        ');
        foreach ($chart as $key => $value) {
            
            if ($value->countvn > 0) {
                $dataset[] = [
                    'label'     => $labels,
                    'count'     => $value->countvn,
                    'Authen'    => $value->Authen,
                    'Noauthen'  => $value->Noauthen
                ];
            }
        }
 
        $Dataset1 = $dataset;
        // $Dataset2 = $dataset_2; 
        return response()->json([
            'status'                    => '200', 
            'Dataset1'                  => $Dataset1,
            // 'Dataset2'                  => $Dataset2
        ]);
    }
    public function audit_pdx(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30');
        // dd($end);
        if ($startdate == '') { 
            $data['fdh_ofc']    = DB::connection('mysql10')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                ,count(DISTINCT v.vn) as countvn ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as sum_total 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn  
                LEFT JOIN rcpt_debt rr on rr.vn = o.vn
                LEFT JOIN ktb_edc_transaction k on k.vn = o.vn
                WHERE o.pttype IN("O1","O2","O3","O4","O5") 
                AND (o.an IS NULL OR o.an ="")
                AND o.vstdate BETWEEN "'.$start.'" AND "'.$end.'"    
                GROUP BY month(o.vstdate) 
            ');             
            // $data['fdh_ofc_all']       = DB::connection('mysql')->select(
            //     'SELECT * FROM d_fdh 
            //         WHERE projectcode ="OFC" AND debit > 0 
            //         AND hn <>"" AND (pdx IS NULL OR pdx ="") 
            //         AND (an IS NULL OR an ="") 
            //         AND vstdate BETWEEN "'.$start.'" AND "'.$end.'"                    
            // '); 
            // $data['fdh_ofc_m']        = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"") GROUP BY vn'); 
            $data['fdh_ofc_momth']    = DB::connection('mysql10')->select(
                'SELECT v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pdx
               ,(v.income-v.discount_money-v.rcpt_money) as debit,v.income 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient p ON p.hn = v.hn  
                LEFT JOIN rcpt_debt rr on rr.vn = o.vn
                LEFT JOIN ktb_edc_transaction k on k.vn = o.vn
                WHERE o.pttype IN("O1","O2","O3","O4","O5") 
                AND (o.an IS NULL OR o.an ="") AND (v.pdx IS NULL OR v.pdx ="") 
                AND month(o.vstdate) ="'.$m.'" AND year(o.vstdate) ="'.$yy.'"    
                GROUP BY o.vn ORDER BY v.vn DESC
            ');                    
            // SELECT * FROM d_fdh 
            // WHERE projectcode ="OFC" AND debit > 0
            // AND hn <>"" AND (pdx IS NULL OR pdx ="") 
            // AND (an IS NULL OR an ="")
            // AND month(vstdate) ="'.$m.'" AND year(vstdate) ="'.$yy.'"             
        } else {
            // $data['fdh_ofc']    = DB::connection('mysql')->select(
            //     'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
            //         ,count(DISTINCT vn) as countvn,count(pdx) as countpdx,count(DISTINCT vn)-count(pdx) as count_no_diag ,sum(debit) as sum_total  
            //         FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND projectcode ="OFC" 
            //         AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"")
            //         GROUP BY month(vstdate)
            // ');                 
            }   
            // AND (pdx IS NULL OR pdx ="")        
        return view('audit.audit_pdx',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 
    public function audit_pdx_detail(Request $request,$month,$year)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $yy = date('Y');
        $m = date('m');
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') { 
            // $data['fdh_ofc']    = DB::connection('mysql')->select(
            //     'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
            //         ,count(DISTINCT vn) as countvn
            //         ,count(DISTINCT authen) as countauthen
            //         ,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve,sum(debit) as sum_total 
            //         FROM d_fdh WHERE vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
            //         AND projectcode ="OFC" AND debit > 0
            //         AND (an IS NULL OR an ="")
            //         GROUP BY month(vstdate)
            // ');  
            $data['fdh_ofc']    = DB::connection('mysql10')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                ,count(DISTINCT v.vn) as countvn  ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as sum_total 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn 
                LEFT JOIN rcpt_debt rr on rr.vn = o.vn
                LEFT JOIN ktb_edc_transaction k on k.vn = o.vn 
                WHERE o.pttype IN("O1","O2","O3","O4","O5") 
                AND (o.an IS NULL OR o.an ="")
                AND o.vstdate BETWEEN "'.$start.'" AND "'.$end.'"    
                GROUP BY month(o.vstdate) 
            ');  
            $data['fdh_ofc_momth']    = DB::connection('mysql10')->select(
                'SELECT v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pdx
               ,(v.income-v.discount_money-v.rcpt_money) as debit,v.income 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient p ON p.hn = v.hn  
                LEFT JOIN rcpt_debt rr on rr.vn = o.vn
                LEFT JOIN ktb_edc_transaction k on k.vn = o.vn
                WHERE o.pttype IN("O1","O2","O3","O4","O5") 
                AND (o.an IS NULL OR o.an ="") AND (v.pdx IS NULL OR v.pdx ="") 
                AND month(o.vstdate) ="'.$month.'" AND year(o.vstdate) ="'.$year.'"    
                GROUP BY o.vn ORDER BY o.vn DESC
            '); 
            // $data['fdh_ofc_m']       = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") AND debit > 0 GROUP BY vn'); 
            // $data['fdh_ofc_momth']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) ="'.$month.'" AND debit > 0 AND year(vstdate) ="'.$year.'" AND projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") GROUP BY vn'); 
                            
        return view('audit.audit_pdx_detail',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'month'         => $month,
            'year'          => $year, 
        ]);
    } 
    public function audit_pdx_detail_print(Request $request,$month,$year)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
    
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') { 
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn
                    ,count(DISTINCT authen) as countauthen
                    ,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve,sum(debit) as sum_total 
                    FROM d_fdh WHERE vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                    AND projectcode ="OFC" AND debit > 0
                    AND (an IS NULL OR an ="")
                    GROUP BY month(vstdate)
            ');  
         
            $data['fdh_ofc_m']       = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") AND debit > 0 GROUP BY vn'); 
            $data['fdh_ofc_momth']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) ="'.$month.'" AND debit > 0 AND year(vstdate) ="'.$year.'" AND projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") GROUP BY vn'); 
       
                     
        return view('audit.audit_pdx_detail_print',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'month'         => $month,
            'year'          => $year, 
        ]);
    } 
    public function talassemaie(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $budget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $by_startnew = $budget_year->date_begin;
        $by_endnew = $budget_year->date_end;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') { 
            $data['datashow']    = DB::connection('mysql2')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                    ,count(DISTINCT v.vn) as countvn 
                    ,(SELECT SUM(qty) qty FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_qty
                    ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as sum_total                    
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vs on vs.vn = v.vn
                    LEFT JOIN ovst o on o.vn = v.vn
                    LEFT JOIN opdscreen s ON s.vn = v.vn
                    LEFT JOIN opitemrece ot ON ot.vn = v.vn
                    LEFT JOIN drugitems d ON d.icode = ot.icode
                    LEFT JOIN patient p on p.hn=v.hn
                    LEFT JOIN pttype pt on pt.pttype = v.pttype  
                    LEFT JOIN opduser op on op.loginname = o.staff
                    WHERE v.vstdate BETWEEN "'.$by_startnew.'" AND "'.$by_endnew.'" 
                    AND pt.hipdata_code ="UCS" AND ot.icode IN("1590015","1520001")  
                    AND (o.an IS NULL OR o.an = "")
                    GROUP BY month(v.vstdate)
            ');   
            $data['datashow_m']    = DB::connection('mysql2')->select(
                'SELECT v.vn,ot.an,v.hn,v.cid,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,v.vstdate,v.age_y,l.lab_items_name AS lab_name,d.name as drugname 
                    ,(SELECT SUM(qty) qty FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_qty
                    ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_drug                    
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vs on vs.vn = v.vn  
                    LEFT JOIN opitemrece ot ON ot.vn = v.vn 
                    LEFT JOIN drugitems d ON d.icode = ot.icode
                    LEFT JOIN patient p on p.hn=v.hn
                    LEFT JOIN pttype pt on pt.pttype = v.pttype   
                    LEFT OUTER JOIN lab_head lh ON lh.vn = v.vn  
                    LEFT OUTER JOIN lab_order lo on lo.lab_order_number=lh.lab_order_number 
                    LEFT OUTER JOIN lab_order lo1 on lo1.lab_order_number=lh.lab_order_number  
                    LEFT OUTER JOIN lab_items l on l.lab_items_code=lo.lab_items_code  
                    LEFT OUTER JOIN lab_items l1 on l1.lab_items_code=lo1.lab_items_code  
                    WHERE month(v.vstdate) ="'.$m.'" AND year(v.vstdate) ="'.$yy.'"
                    AND pt.hipdata_code ="UCS" AND ot.icode IN("1590015","1520001")   
                    AND (ot.an IS NULL OR ot.an = "")
                    GROUP BY v.vn ORDER BY v.age_y ASC
            ');  
            // -- and v.age_y between "35" and "59"  
            // $data['fdh_ofc_m']        = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"") GROUP BY vn'); 
            // $data['fdh_ofc_momth']    = DB::connection('mysql')->select('SELECT * FROM d_fdh WHERE month(vstdate) ="'.$m.'" AND projectcode ="OFC" AND (pdx IS NULL OR pdx ="") AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"") GROUP BY vn'); 
          
              
        return view('audit.talassemaie',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 
    public function talassemaie_detail(Request $request,$month,$year)
    {
        $startdate              = $request->startdate;
        $enddate                = $request->enddate;
        $budget_year            = DB::table('budget_year')->where('active','=',true)->first();
        $month_year             = DB::table('leave_month')->where('MONTH_ID', $month)->first();
        $by_startnew            = $budget_year->date_begin;
        $by_endnew              = $budget_year->date_end;
        $data['month_year']     = $month_year->MONTH_NAME;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') { 
            $data['datashow']    = DB::connection('mysql2')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                    ,count(DISTINCT v.vn) as countvn
                    ,(SELECT SUM(qty) qty FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_qty
                    ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as sum_total                      
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vs on vs.vn = v.vn
                    LEFT JOIN ovst o on o.vn = v.vn
                    LEFT JOIN opdscreen s ON s.vn = v.vn
                    LEFT JOIN opitemrece ot ON ot.vn = v.vn
                    LEFT JOIN drugitems d ON d.icode = ot.icode
                    LEFT JOIN patient p on p.hn=v.hn
                    LEFT JOIN pttype pt on pt.pttype = v.pttype  
                    LEFT JOIN opduser op on op.loginname = o.staff
                    WHERE v.vstdate BETWEEN "'.$by_startnew.'" AND "'.$by_endnew.'" 
                    AND pt.hipdata_code ="UCS" AND ot.icode IN("1590015","1520001")  
                    AND (o.an IS NULL OR o.an = "")
                    GROUP BY month(v.vstdate)
            ');   
            $data['datashow_m']    = DB::connection('mysql2')->select(
                'SELECT v.vn,ot.an,v.hn,v.cid,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,v.vstdate,v.age_y,l.lab_items_name AS lab_name,d.name as drugname 
                 
                    ,(SELECT SUM(qty) qty FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_qty
                    ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE vn = v.vn AND icode IN("1590015","1520001")) as total_drug                       
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vs on vs.vn = v.vn  
                    LEFT JOIN opitemrece ot ON ot.vn = v.vn 
                    LEFT JOIN drugitems d ON d.icode = ot.icode
                    LEFT JOIN patient p on p.hn=v.hn
                    LEFT JOIN pttype pt on pt.pttype = v.pttype   
                    LEFT OUTER JOIN lab_head lh ON lh.vn = v.vn  
                    LEFT OUTER JOIN lab_order lo on lo.lab_order_number=lh.lab_order_number 
                    LEFT OUTER JOIN lab_order lo1 on lo1.lab_order_number=lh.lab_order_number  
                    LEFT OUTER JOIN lab_items l on l.lab_items_code=lo.lab_items_code  
                    LEFT OUTER JOIN lab_items l1 on l1.lab_items_code=lo1.lab_items_code  
                    WHERE month(v.vstdate) ="'.$month.'" AND year(v.vstdate) ="'.$year.'"
                    AND pt.hipdata_code ="UCS" AND ot.icode IN("1590015","1520001")   
                    AND (ot.an IS NULL OR ot.an = "")
                    GROUP BY v.vn ORDER BY v.age_y ASC
            ');  
          
              
        return view('audit.talassemaie_detail',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }  
    public function audit_only(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate == '') { 
            
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn  
                    ,sum(debit) as sum_total 
                    FROM d_fdh   
                    WHERE projectcode ="OFC" AND debit > 0 
                    AND (an IS NULL OR an ="") 
                   
                    AND vstdate BETWEEN "'.$start.'" AND "'.$end.'"  
                    GROUP BY month(vstdate)
            '); 
           
            $data['fdh_ofc_all']  = DB::connection('mysql')->select(
                'SELECT * FROM d_fdh 
                    WHERE projectcode ="OFC"  
                    AND hn <>"" 
                    AND (authen IS NULL OR authen ="") 
                    AND (an IS NULL OR an ="") AND debit > 0
                    AND vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                   
            '); 
                
                $data['fdh_ofc_momth']    = DB::connection('mysql')->select(
                    'SELECT * FROM d_fdh 
                    WHERE projectcode ="OFC" 
                    AND hn <>""
                    AND (authen IS NULL OR authen ="") 
                    AND (an IS NULL OR an ="")
                    AND month(vstdate) ="'.$m.'" AND year(vstdate) ="'.$yy.'" AND debit > 0
     
                '); 
           
        } else {
            $data['fdh_ofc']    = DB::connection('mysql')->select(
                'SELECT year(vstdate) as years ,month(vstdate) as months,year(vstdate) as days 
                    ,count(DISTINCT vn) as countvn,count(DISTINCT authen) as countauthen,count(DISTINCT vn)-count(DISTINCT authen) as count_no_approve ,sum(debit) as sum_total  
                    FROM d_fdh WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND projectcode ="OFC" 
                    AND (an IS NULL OR an ="") AND (hn IS NOT NULL OR hn <>"") AND debit > 0
                    GROUP BY month(vstdate)
            '); 
               
            }   
                     
        return view('audit.audit_only',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 
    public function audit_pdx_walkin(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');

        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30');
      
            $data['walkin']    = DB::connection('mysql10')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                ,count(DISTINCT v.vn) as countvn ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as sum_total 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn 
                LEFT JOIN visit_pttype vp ON vp.vn = o.vn
                WHERE o.pttype IN("W1") AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")   
                AND (o.an IS NULL OR o.an ="")
                AND o.vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                GROUP BY month(o.vstdate) 
            ');            
         
            $data['walkin_momth']    = DB::connection('mysql10')->select(
                'SELECT v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pdx
               ,(v.income-v.discount_money-v.rcpt_money) as debit,v.income,vp.claim_code
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient p ON p.hn = v.hn
                LEFT JOIN visit_pttype vp ON vp.vn = o.vn  
                WHERE o.pttype IN("W1") AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")
                AND (o.an IS NULL OR o.an ="") AND (v.pdx IS NULL OR v.pdx ="") 
                AND month(o.vstdate) ="'.$m.'" AND year(o.vstdate) ="'.$yy.'"    
                GROUP BY o.vn ORDER BY v.vn DESC
            ');     
            $data['walkin_today']    = DB::connection('mysql10')->select(
                'SELECT v.hn,v.vstdate,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname,v.pdx
               ,(v.income-v.discount_money-v.rcpt_money) as debit,v.income,vp.claim_code
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient p ON p.hn = v.hn
                LEFT JOIN visit_pttype vp ON vp.vn = o.vn  
                WHERE o.pttype IN("W1") AND v.income > 0
                AND (o.an IS NULL OR o.an ="") AND (v.pdx IS NULL OR v.pdx ="")  
                AND o.vstdate ="'.$date.'"     
                GROUP BY o.vn ORDER BY v.vn DESC
            ');                       
            // AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")    
  
            // AND (pdx IS NULL OR pdx ="")        
        return view('audit.audit_pdx_walkin',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 
    public function audit_pdx_walkindetail(Request $request,$month,$year)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $yy = date('Y');
        $m = date('m');
        // dd($m);
        $newweek = date('Y-m-d', strtotime($date . ' -3 week')); //ย้อนหลัง 3 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30');
      
            $data['walkin']    = DB::connection('mysql10')->select(
                'SELECT year(v.vstdate) as years ,month(v.vstdate) as months,year(v.vstdate) as days 
                ,count(DISTINCT v.vn) as countvn ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as sum_total 
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn 
                LEFT JOIN visit_pttype vp ON vp.vn = o.vn
                WHERE o.pttype IN("W1") AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")   
                AND (o.an IS NULL OR o.an ="")
                AND o.vstdate BETWEEN "'.$start.'" AND "'.$end.'" 
                GROUP BY month(o.vstdate) 
            ');            
         
            $data['walkin_momth']    = DB::connection('mysql10')->select(
                'SELECT v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pdx
               ,(v.income-v.discount_money-v.rcpt_money) as debit,v.income,vp.claim_code
                FROM ovst o
                LEFT JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient p ON p.hn = v.hn
                LEFT JOIN visit_pttype vp ON vp.vn = o.vn  
                WHERE o.pttype IN("W1") AND (vp.claim_code IS NOT NULL OR vp.claim_code <>"")
                AND (o.an IS NULL OR o.an ="") AND (v.pdx IS NULL OR v.pdx ="") 
                AND month(o.vstdate) ="'.$month.'" AND year(o.vstdate) ="'.$year.'"    
                GROUP BY o.vn ORDER BY v.vn DESC
            ');                    
                  
  
            // AND (pdx IS NULL OR pdx ="")        
        return view('audit.audit_pdx_walkindetail',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    } 

    public function diag_z017(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $newdays     = date('Y-m-d', strtotime($date . ' -2 days')); //ย้อนหลัง 2 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        if ($startdate == '') {
            
            $data_z017 = DB::connection('mysql10')->select(
                'SELECT ov.vn,odx.icd10 as icd10,ov.hn,ov.vstdate,ov.vsttime,"1" as diagtype,ov.hcode,"0060" as doctor,"1" as episode,"pichamon" as staff
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                 from ovst ov 
                    left outer join patient pt on pt.hn=ov.hn 
                    left outer join ovstdiag odx on odx.vn=ov.vn and odx.diagtype="1" 
                    left outer join kskdepartment sp on sp.depcode=ov.cur_dep 
                    left outer join ovstost oost on oost.ovstost=ov.ovstost 
                    left outer join icd101 icd1 on icd1.code=odx.icd10 
                    left outer join icd101 ix on ix.code=substring(odx.icd10,1,3)  
                    left outer join pttype pty on pty.pttype=ov.pttype 
                    left outer join vn_lock vk on vk.vn = ov.vn 
                    left outer join ovstist st on st.ovstist = ov.ovstist  
                    left outer join vn_stat vt on vt.vn=ov.vn  
                    left outer join ovst_drgs od on od.vn = ov.vn 
                    left outer join oapp on oapp.vn=ov.vn and oapp.app_no=1 
                    left outer join vn_opd_complete c on c.vn=ov.vn  
                    left outer join ovst_seq ovq on ovq.vn = ov.vn  
                    where (ov.vstdate="'.$date.'") AND ov.spclty = "16"
                    AND odx.icd10 IS NULL 
                    order by ov.vsttime  
            ');
            // AND odx.icd10 IS NULL 
        } else {
           
            $data_z017 = DB::connection('mysql10')->select(
                'SELECT ov.vn,odx.icd10 as icd10,ov.hn,ov.vstdate,ov.vsttime,"1" as diagtype,ov.hcode,"0060" as doctor,"1" as episode,"pichamon" as staff
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                 from ovst ov 
                    left outer join patient pt on pt.hn=ov.hn 
                    left outer join ovstdiag odx on odx.vn=ov.vn and odx.diagtype="1" 
                    left outer join kskdepartment sp on sp.depcode=ov.cur_dep 
                    left outer join ovstost oost on oost.ovstost=ov.ovstost 
                    left outer join icd101 icd1 on icd1.code=odx.icd10 
                    left outer join icd101 ix on ix.code=substring(odx.icd10,1,3)  
                    left outer join pttype pty on pty.pttype=ov.pttype 
                    left outer join vn_lock vk on vk.vn = ov.vn 
                    left outer join ovstist st on st.ovstist = ov.ovstist  
                    left outer join vn_stat vt on vt.vn=ov.vn  
                    left outer join ovst_drgs od on od.vn = ov.vn 
                    left outer join oapp on oapp.vn=ov.vn and oapp.app_no=1 
                    left outer join vn_opd_complete c on c.vn=ov.vn  
                    left outer join ovst_seq ovq on ovq.vn = ov.vn  
                    where ov.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND ov.spclty = "16"
                    AND odx.icd10 IS NULL 
                    order by ov.vsttime 
                  
            ');
            // AND odx.icd10 IS NULL 
            // Audit_217::truncate();
            foreach ($data_z017 as $key => $value_1) {                
                $check = Audit_217::where('vn', $value_1->vn)->count();
                    if ($check > 0) {   
                    } else {
                        Audit_217::insert([
                            'vn'         => $value_1->vn, 
                            'icd10'      => 'Z017',
                            'hn'         => $value_1->hn,
                            'vstdate'    => $value_1->vstdate,
                            'vsttime'    => $value_1->vsttime, 
                            'diagtype'   => $value_1->diagtype,
                            'hcode'      => $value_1->hcode,
                            'doctor'     => $value_1->doctor, 
                            'episode'    => $value_1->episode, 
                            'staff'      => $value_1->staff, 
                            'ptname'     => $value_1->ptname, 
                        ]);
                    }
               
            }
           
        }

        $data_z017_new = Audit_217::get();

        return view('audit.diag_z017', [
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'data_z017'     => $data_z017,
            'data_z017_new' => $data_z017_new
        ]);
    }

    public function diag_z017_process(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        // dd($vn);
        $data_z017 = Audit_217::whereIn('audit_217_id',explode(",",$id))->get();
        // $data_z017 = DB::connection('mysql10')->select(
        //     'SELECT ov.vn,"Z017" as icd10,ov.hn,ov.vstdate,ov.vsttime,"1" as diagtype,ov.hcode,"0060" as doctor,"1" as episode,"pichamon" as staff
        //     ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
        //      from ovst ov 
        //         left outer join patient pt on pt.hn=ov.hn 
        //         left outer join ovstdiag odx on odx.vn=ov.vn and odx.diagtype="1"  
        //         where ov.vn IN("'.$vn.'") 
        //         GROUP BY ov.vn 
        // ');
            
        foreach ($data_z017 as $key => $value_1) { 
                $check = Ovstdiag::where('vn', $value_1->vn)->count();               
                if ($check > 0) { 
                } else { 
                    $maxid     = Ovstdiag::max('ovst_diag_id');
                    $maxid_new = $maxid+1;
                    Ovstdiag::insert([
                        'ovst_diag_id' => $maxid_new,
                        'vn'           => $value_1->vn, 
                        'icd10'        => $value_1->icd10,
                        'hn'           => $value_1->hn,
                        'vstdate'      => $value_1->vstdate,
                        'vsttime'      => $value_1->vsttime, 
                        'diagtype'     => $value_1->diagtype,
                        'hcode'        => $value_1->hcode,
                        'doctor'       => $value_1->doctor, 
                        'episode'      => $value_1->episode, 
                        'staff'        => $value_1->staff, 
                    ]);
                }
                // 4250123456

                $check_vn_stat = Vn_stat::where('vn', $value_1->vn)->count();
                if ($check_vn_stat > 0) {
                    Vn_stat::where('vn', $value_1->vn)->update([
                        'pdx'         => $value_1->icd10,
                        'dx_doctor'   => $value_1->doctor
                    ]);
                }
                $check_ov = Vn_stat::where('vn', $value_1->vn)->count();
                if ($check_ov > 0) {
                    Ovst::where('vn', $value_1->vn)->update([ 
                        'doctor'   => $value_1->doctor
                    ]);
                }
                Audit_217::where('audit_217_id', $value_1->audit_217_id)->update([
                    'active'   => 'Y'
                ]);
               
        }
        return response()->json([
            'status'    => '200'
        ]);
    }

   
   
     
}
