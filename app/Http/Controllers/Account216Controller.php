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
use App\Models\Acc_1102050101_216;
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
use App\Models\Acc_function;
use App\Models\D_walkin_drug;
use App\Models\Fdh_sesion;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Fdh_mini_dataset;

use App\Models\Fdh_api_ins;
use App\Models\Fdh_api_adp;
use App\Models\Fdh_api_aer;
use App\Models\Fdh_api_orf;
use App\Models\Fdh_api_odx;
use App\Models\Fdh_api_cht;
use App\Models\Fdh_api_cha;
use App\Models\Fdh_api_oop;
use App\Models\Fdh_api_dru;
use App\Models\Fdh_api_idx;
use App\Models\Fdh_api_iop;
use App\Models\Fdh_api_pat;
use App\Models\Fdh_api_opd;
use App\Models\Fdh_api_lvd;
use App\Models\Fdh_api_irf;
use App\Models\Fdh_api_ipd;

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
use App\Models\D_fdh;
use App\Models\D_walkin_report;



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
// use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Utils;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client;

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
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;
date_default_timezone_set("Asia/Bangkok");


class Account216Controller extends Controller
 { 
    public function account_pkucs216_dash_old(Request $request)
    {
        // $datenow = date('Y-m-d');
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        // $dabudget_year = DB::table('budget_year')->where('active','=',true)->first(); 
        // $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        // $date = date('Y-m-d');
        // $y = date('Y') + 543;
        // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        // $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        // $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        // $yearnew = date('Y')+1;
        // $yearold = date('Y')-1;
        // $start = (''.$yearold.'-10-01');
        // $end = (''.$yearnew.'-09-30'); 
        $budget_year   = $request->budget_year;
    
        $datenow       = date("Y-m-d");
        $y             = date('Y') + 543;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->get(); 
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d'); 
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        
        $months_now = date('m');
        $year_now = date('Y');

        if ($budget_year == '') {
            $yearnew     = date('Y');
            $year_old    = date('Y')-1;
            $months_old  = ('10');
            $startdate   = (''.$year_old.'-10-01');
            $enddate     = (''.$yearnew.'-09-30'); 
            $datashow = DB::select(' 
                    SELECT MONTH(a.vstdate) as months,YEAR(a.vstdate) as years
                    ,count(DISTINCT a.vn) as total_vn,l.MONTH_NAME
                    ,sum(a.debit_total) as tung_looknee  
                    FROM acc_1102050101_216 a 
                    LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND a.account_code ="1102050101.216"
                    GROUP BY months ORDER BY a.vstdate DESC
            ');          
        } else {
            $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end;
            $datashow     = DB::select(' 
                   SELECT MONTH(a.vstdate) as months,YEAR(a.vstdate) as years
                   ,count(DISTINCT a.vn) as total_vn,l.MONTH_NAME
                   ,sum(a.debit_total) as tung_looknee  
                   FROM acc_1102050101_216 a 
                   LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.vstdate)
                   WHERE a.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                   AND a.account_code ="1102050101.216"
                   GROUP BY months ORDER BY a.vstdate DESC 
           ');               
        }

        return view('account_216.account_pkucs216_dash',[
            'startdate'        =>  $startdate,
            'enddate'          =>  $enddate,
            'datashow'         =>  $datashow,
            'leave_month_year' =>  $leave_month_year,
            'dabudget_year'    =>  $dabudget_year,
            'budget_year'      =>  $budget_year,
            'y'                =>  $y,
        ]);
    }
    public function account_pkucs216_dash(Request $request)
    { 
        // $startdate          = $request->startdate;
        // $enddate            = $request->enddate; 
        $budget_year        = $request->budget_year;
        $dabudget_year      = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year   = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        // $yearnew = date('Y');
        // $yearold = date('Y')-1;
        // $start = (''.$yearold.'-10-01');
        // $end = (''.$yearnew.'-09-30');  
        // dd($budget_year);
        if ($budget_year == '') {
            $yearnew     = date('Y');
            $year_old    = date('Y')-1; 
            $startdate   = (''.$year_old.'-10-01');
            $enddate     = (''.$yearnew.'-09-30'); 
            // dd($startdate);
            $datashow = DB::select(
                'SELECT month(U1.vstdate) as months,year(U1.vstdate) as year,l.MONTH_NAME
                from acc_1102050101_216 U1      
                left outer join leave_month l on l.MONTH_ID = month(U1.vstdate)       
                WHERE U1.vstdate between "'.$startdate.'" and "'.$enddate.'"
                group by month(U1.vstdate)  
            '); 
            // $datashow = DB::select(
            //     ' SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
            //         ,count(distinct a.hn) as hn ,count(distinct a.vn) as vn ,count(distinct a.an) as an
            //         ,sum(a.income) as income ,sum(a.paid_money) as paid_money
            //         ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total ,sum(a.debit) as debit
            //         FROM acc_debtor a
            //         left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
            //         WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
            //         and account_code="1102050101.216"
            //         group by month(a.vstdate)                     
            //         order by a.vstdate desc;
            // '); 
             
        } else {
          
            $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end; 
            // dd($startdate);
            $datashow = DB::select(
                'SELECT month(U1.vstdate) as months,year(U1.vstdate) as year,l.MONTH_NAME
                from acc_1102050101_216 U1      
                left outer join leave_month l on l.MONTH_ID = month(U1.vstdate)       
                WHERE U1.vstdate between "'.$startdate.'" and "'.$enddate.'"
                group by month(U1.vstdate) 
            ');
        }
        // dd($startdate);
        return view('account_216.account_pkucs216_dash',[
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate, 
            'leave_month_year'  =>  $leave_month_year, 
            'datashow'          =>  $datashow,
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y,
        ]);
    }
    public function account_pkucs216_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $newday     = date('Y-m-d', strtotime($datenow . ' -1 Day')); //ย้อนหลัง 1  
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT *
                from acc_debtor a 
                WHERE a.account_code="1102050101.216"
                AND vstdate BETWEEN "'.$newday.'" AND "'.$datenow.'"
                AND a.debit_total > 0
                group by a.vn
                order by a.hn ASC;
            ');
            // AND a.stamp = "N" 
            $data['data_opd'] = DB::connection('mysql')->select('SELECT * from fdh_opd WHERE d_anaconda_id ="WALKIN"');
            $data['data_orf'] = DB::connection('mysql')->select('SELECT * from fdh_orf WHERE d_anaconda_id ="WALKIN"');
            $data['data_oop'] = DB::connection('mysql')->select('SELECT * from fdh_oop WHERE d_anaconda_id ="WALKIN"');
            $data['data_odx'] = DB::connection('mysql')->select('SELECT * from fdh_odx WHERE d_anaconda_id ="WALKIN"');
            $data['data_idx'] = DB::connection('mysql')->select('SELECT * from fdh_idx WHERE d_anaconda_id ="WALKIN"');
            $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from fdh_ipd WHERE d_anaconda_id ="WALKIN"');
            $data['data_irf'] = DB::connection('mysql')->select('SELECT * from fdh_irf WHERE d_anaconda_id ="WALKIN"');
            $data['data_aer'] = DB::connection('mysql')->select('SELECT * from fdh_aer WHERE d_anaconda_id ="WALKIN"');
            $data['data_iop'] = DB::connection('mysql')->select('SELECT * from fdh_iop WHERE d_anaconda_id ="WALKIN"');
            $data['data_adp'] = DB::connection('mysql')->select('SELECT * from fdh_adp WHERE d_anaconda_id ="WALKIN"');
            $data['data_pat'] = DB::connection('mysql')->select('SELECT * from fdh_pat WHERE d_anaconda_id ="WALKIN"');
            $data['data_cht'] = DB::connection('mysql')->select('SELECT * from fdh_cht WHERE d_anaconda_id ="WALKIN"');
            $data['data_cha'] = DB::connection('mysql')->select('SELECT * from fdh_cha WHERE d_anaconda_id ="WALKIN"');
            $data['data_ins'] = DB::connection('mysql')->select('SELECT * from fdh_ins WHERE d_anaconda_id ="WALKIN"');
            $data['data_dru'] = DB::connection('mysql')->select('SELECT * from fdh_dru WHERE d_anaconda_id ="WALKIN"');
            $data['count_no'] = Acc_debtor::where('claim_code','<>','')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$newday, $datenow])->count();
            $data['count_null'] = Acc_debtor::where('claim_code','=',Null)->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$newday, $datenow])->count();
            $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$newday, $datenow])->count();
            $data['count_noclaim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$newday, $datenow])->count();
        } else {
            $acc_debtor = DB::select('
            SELECT * 
             from acc_debtor a 
                WHERE a.account_code="1102050101.216"
                 AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.debit_total > 0
                group by a.vn
                order by a.hn ASC;
            ');
            $data['data_opd'] = DB::connection('mysql')->select('SELECT * from fdh_opd WHERE d_anaconda_id ="WALKIN"');
            $data['data_orf'] = DB::connection('mysql')->select('SELECT * from fdh_orf WHERE d_anaconda_id ="WALKIN"');
            $data['data_oop'] = DB::connection('mysql')->select('SELECT * from fdh_oop WHERE d_anaconda_id ="WALKIN"');
            $data['data_odx'] = DB::connection('mysql')->select('SELECT * from fdh_odx WHERE d_anaconda_id ="WALKIN"');
            $data['data_idx'] = DB::connection('mysql')->select('SELECT * from fdh_idx WHERE d_anaconda_id ="WALKIN"');
            $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from fdh_ipd WHERE d_anaconda_id ="WALKIN"');
            $data['data_irf'] = DB::connection('mysql')->select('SELECT * from fdh_irf WHERE d_anaconda_id ="WALKIN"');
            $data['data_aer'] = DB::connection('mysql')->select('SELECT * from fdh_aer WHERE d_anaconda_id ="WALKIN"');
            $data['data_iop'] = DB::connection('mysql')->select('SELECT * from fdh_iop WHERE d_anaconda_id ="WALKIN"');
            $data['data_adp'] = DB::connection('mysql')->select('SELECT * from fdh_adp WHERE d_anaconda_id ="WALKIN"');
            $data['data_pat'] = DB::connection('mysql')->select('SELECT * from fdh_pat WHERE d_anaconda_id ="WALKIN"');
            $data['data_cht'] = DB::connection('mysql')->select('SELECT * from fdh_cht WHERE d_anaconda_id ="WALKIN"');
            $data['data_cha'] = DB::connection('mysql')->select('SELECT * from fdh_cha WHERE d_anaconda_id ="WALKIN"');
            $data['data_ins'] = DB::connection('mysql')->select('SELECT * from fdh_ins WHERE d_anaconda_id ="WALKIN"');
            $data['data_dru'] = DB::connection('mysql')->select('SELECT * from fdh_dru WHERE d_anaconda_id ="WALKIN"');
            $data['count_no'] = Acc_debtor::where('claim_code','<>','')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->count();
            $data['count_null'] = Acc_debtor::where('claim_code','=',Null)->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->count();
            $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->count();
            $data['count_noclaim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->count();
        }

       

        $data_activeclaim        = Acc_function::where('pang','1102050101.216')->first();
        $data['activeclaim']     = $data_activeclaim->claim_active;
        $data['acc_function_id'] = $data_activeclaim->acc_function_id;

        return view('account_216.account_pkucs216_pull',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    function account_pkucs216_claimswitch(Request $request)
    {   
        Acc_function::where('pang','1102050101.216')->update(['claim_active'=> $request->onoff]); 
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs216_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        
        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.216" AND stamp = "N" GROUP BY vn');
       //  AND subinscl IS NULL
           //  LIMIT 30
        // WHERE vstdate = CURDATE()
        // BETWEEN "2024-02-03" AND "2024-02-15"
        // $token_data = DB::connection('mysql')->select('SELECT cid,token FROM ssop_token');
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) { 
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn; 
            $an   = $item->an; 
                // $token_data = DB::connection('mysql10')->select('SELECT cid,token FROM hos.nhso_token where token <> ""');
                // foreach ($token_data as $key => $value) { 
                    $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                        array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',"trace" => 1,"exceptions" => 0,"cache_wsdl" => 0)
                        );
                        $params = array(
                            'sequence' => array(
                                "user_person_id"   => "$cid_",
                                "smctoken"         => "$token_",
                                // "user_person_id" => "$value->cid",
                                // "smctoken"       => "$value->token",
                                "person_id"        => "$pids"
                        )
                    );
                    $contents = $client->__soapCall('searchCurrentByPID',$params);
                    foreach ($contents as $v) {
                        @$status = $v->status ;
                        @$maininscl = $v->maininscl;
                        @$startdate = $v->startdate;
                        @$hmain = $v->hmain ;
                        @$subinscl = $v->subinscl ;
                        @$person_id_nhso = $v->person_id;

                        @$hmain_op = $v->hmain_op;  //"10978"
                        @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                        @$hsub = $v->hsub;    //"04047"
                        @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                        @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"

                        IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                            $date = date("Y-m-d");
                          
                            Acc_debtor::where('vn', $vn)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'   => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl, 
                            ]);
                            
                        }elseif(@$maininscl !="" || @$subinscl !=""){
                           Acc_debtor::where('vn', $vn)
                           ->update([
                               'status'         => @$status,
                               'maininscl'      => @$maininscl,
                               'pttype_spsch'   => @$subinscl,
                               'hmain'          => @$hmain,
                               'subinscl'       => @$subinscl,
                           
                           ]); 
                                    
                        }

                    }
           
        }

        return response()->json([

           'status'    => '200'
       ]);

    }
    public function account_pkucs216_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        D_walkin_drug::truncate(); 
            $data_main_drug = DB::connection('mysql2')->select('SELECT vn  FROM opitemrece WHERE vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" AND icode in ("3010755","3003179","3011264") AND an is null');
            foreach ($data_main_drug as $key => $val_drug) {
                D_walkin_drug::insert([
                    'VN'    => $val_drug->vn,
                ]);
            }
        $acc_debtor = DB::connection('mysql2')->select( 
                'SELECT v.vn,ifnull(o.an,"") as an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.vstdate,v.hospmain,vp.max_debt_amount,v.pdx,vp.claim_code                
                ,vp.pttype,"03" as acc_code,"1102050101.216" as account_code ,"ลูกหนี้ค่ารักษา UC-OP บริการเฉพาะ (CR)" as account_name,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money                 
                ,CASE 
                WHEN vp.pttype = "49" THEN v.income-v.discount_money-v.rcpt_money
                WHEN sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) > 0 THEN v.income	
                WHEN  vp.pttype_number ="2" AND vp.pttype NOT IN ("31","33","36","39") AND vp.max_debt_amount = "" OR sum(if(op.income="02",sum_price,0)) > 0 THEN 
                (sum(if(op.income="02",sum_price,0))) +
                (sum(if(op.icode IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0))) -
                (sum(if(s.nhso_adp_code like "82%",sum_price,0)))     
                WHEN vp.pttype_number ="2" AND vp.pttype NOT IN ("31","33","36","39") AND vp.max_debt_amount <> "" THEN vp.max_debt_amount  		
                ELSE                 
                (sum(if(op.income="02",sum_price,0))) +
                (sum(if(vp.pttype="W1",sum_price,0))) +
                (sum(if(op.icode IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0))) -
                (sum(if(s.nhso_adp_code like "82%",sum_price,0))) - v.rcpt_money 
                END as debit
                                                
                ,v.income-v.discount_money-v.rcpt_money as debit2
                 
                ,sum(if(s.nhso_adp_code like "82%",sum_price,0)) as debit_pikan
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                ,sum(if(vp.pttype="W1",sum_price,0)) as debit_walkin 

                FROM ovst o
                LEFT OUTER JOIN vn_stat v on v.vn=o.vn
                LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                LEFT OUTER JOIN patient pt on pt.hn=o.hn
                LEFT OUTER JOIN pttype ptt on o.pttype=ptt.pttype
                LEFT OUTER JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                LEFT OUTER JOIN opitemrece op ON op.vn = o.vn
                LEFT OUTER JOIN s_drugitems s on s.icode = op.icode
               
                WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND v.income-v.discount_money-v.rcpt_money <> 0 AND v.pdx <> "B24"
                AND vp.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.216" AND pttype IS NOT NULL)                
                AND NOT(s.name like "Portex tube%") AND NOT(v.pdx LIKE "C%")        
                AND op.icode NOT IN("3003661","3003662","3003336","3002896","3002897","3002898","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002917","3002918","3003608","3010102","3010353")                                
                AND (o.an="" or o.an is null)
                GROUP BY v.vn'
        ); 
        // AND NOT(s.nhso_adp_code like "82%")
        // LEFT OUTER JOIN nondrugitems nn on nn.icode = op.icode
        //      AND NOT(nn.nhso_adp_code like "82%")
        // AND NOT(s.name like "CT%" OR s.name like "Portex tube%")AND NOT(s.nhso_adp_code like "82%" AND s.nhso_adp_type_id = "2")
        // AND op.icode NOT IN(SELECT no_icode FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.216" AND no_icode <> "")
        // AND op.icode NOT IN("3003661","3003662","3003336","3002896","3002897","3002898","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002917","3002918","3003608","3010102","3010353")
        // AND op.icode NOT like "c%"
        // AND s.nhso_adp_code NOT IN("3001","3002","2501","2502","3001","3002","9214","8901","8902","8904","8608","9001","8903","9211","9212","020700")
        // AND op.icode NOT IN("3003661","3003662","3010272","3003663","3002896","3002897","3002898","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002917","3002918","3009702","3010348")
        // AND op.icode IN(SELECT icode from pkbackoffice.acc_setpang_type WHERE icode IN(SELECT icode FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.217"))
        foreach ($acc_debtor as $key => $value) {
            if ($value->debit_refer > 0 ) {
                # code...
            } else { 
                if ($value->debit > 0 && $value->cid != '') {
                    // $check = Acc_debtor::where('vn', $value->vn)->where('account_code', '1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    if ($value->debit_walkin > '0') {
                        $check = Acc_debtor::where('vn', $value->vn)->where('account_code', '1102050101.216')->count();
                        if ($check > 0) {
                            Acc_debtor::where('vn', $value->vn)->where('account_code', '1102050101.216')->update([ 
                                'projectcode'        => 'WALKIN', 
                                'claim_code'         => $value->claim_code,
                                'pdx'                => $value->pdx,
                                'income'             => $value->income,
                                'debit_total'        => $value->debit,
                                'debit_walkin'       => $value->debit_walkin,

                            ]);
                            // Acc_1102050101_216::where('vn', $value->vn)->where('account_code', '1102050101.216')->update([ 
                            //     'projectcode'        => 'WALKIN', 
                            // ]);
                        }else{
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->ptname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate, 
                                'acc_code'           => $value->acc_code,
                                'account_code'       => $value->account_code,
                                'account_name'       => $value->account_name, 
                                'projectcode'        => 'WALKIN',
                                'claim_code'         => $value->claim_code,
                                'pdx'                => $value->pdx,
                                'income'             => $value->income,
                                'uc_money'           => $value->uc_money,
                                'discount_money'     => $value->discount_money, 
                                'rcpt_money'         => $value->rcpt_money,
                                'debit'              => $value->debit,
                                'debit_drug'         => $value->debit_drug,
                                'debit_instument'    => $value->debit_instument,
                                'debit_toa'          => $value->debit_toa,
                                'debit_refer'        => $value->debit_refer,
                                'debit_walkin'       => $value->debit_walkin,
                                'debit_total'        => $value->debit,
                                'max_debt_amount'    => $value->max_debt_amount, 
                                'acc_debtor_userid'  => Auth::user()->id
                            ]);
                        }
                    } else {
                        $check = Acc_debtor::where('vn', $value->vn)->where('account_code', '1102050101.216')->count();
                        if ($check == 0) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->ptname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate, 
                                'acc_code'           => $value->acc_code,
                                'account_code'       => $value->account_code,
                                'account_name'       => $value->account_name, 
                                'pdx'                => $value->pdx,
                                'claim_code'         => $value->claim_code,
                                'income'             => $value->income,
                                'uc_money'           => $value->uc_money,
                                'discount_money'     => $value->discount_money, 
                                'rcpt_money'         => $value->rcpt_money,
                                'debit'              => $value->debit,
                                'debit_drug'         => $value->debit_drug,
                                'debit_instument'    => $value->debit_instument,
                                'debit_toa'          => $value->debit_toa,
                                'debit_refer'        => $value->debit_refer,
                                'debit_walkin'       => $value->debit_walkin,
                                'debit_total'        => $value->debit,
                                'max_debt_amount'    => $value->max_debt_amount, 
                                'acc_debtor_userid'  => Auth::user()->id
                            ]);
                        }
                    }
                    
                   
                } else {
                    # code...
                }  
            }
        }
        // SELECT  
        // COUNT(vn), vn,hn,sum(debit_total)
        // FROM acc_debtor
        //  WHERE vstdate BETWEEN "2024-10-01" AND "2024-10-01" AND account_code ="1102050101.216"
        // GROUP BY hn
        // HAVING COUNT(hn) > 1;
        $getdata =  DB::connection('mysql')->select('SELECT COUNT(vn), vn,hn,sum(debit_total) FROM acc_debtor WHERE vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" AND account_code ="1102050101.216" GROUP BY hn HAVING COUNT(hn) > 1;');
        // Acc_debtor::where('account_code', '1102050101.216')->whereBetween('vstdate', [$startdate, $enddate])->get();
        
        return response()->json([
            'status'    => '200'
        ]);
    } 
    public function account_pkucs216_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        // Acc_1102050101_217_stam::truncate();
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) {
            $check = Acc_1102050101_216::where('vn', $value->vn)->count();
           if ($check > 0) {
            # code...
           } else {
                Acc_1102050101_216::insert([
                    'vn'                => $value->vn,
                    'hn'                => $value->hn,
                    'an'                => $value->an,
                    'cid'               => $value->cid,
                    'ptname'            => $value->ptname,
                    'vstdate'           => $value->vstdate,
                    'regdate'           => $value->regdate,
                    'dchdate'           => $value->dchdate,
                    'pttype'            => $value->pttype,
                    'acc_code'          => $value->acc_code,
                    'account_code'      => $value->account_code,
                    'rw'                 => $value->rw,
                    'adjrw'              => $value->adjrw,
                    'total_adjrw_income' => $value->total_adjrw_income,
                    'debit_drug'         => $value->debit_drug,
                    'debit_instument'    => $value->debit_instument,
                    'debit_toa'          => $value->debit_toa,
                    'debit_refer'        => $value->debit_refer,
                    'debit_walkin'       => $value->debit_walkin,
                    'income'             => $value->income,
                    'uc_money'           => $value->uc_money,
                    'discount_money'     => $value->discount_money,
                    'rcpt_money'         => $value->rcpt_money, 
                    'debit'              => $value->debit,
                    'debit_total'        => $value->debit_total,
                    'acc_debtor_userid'  => $value->acc_debtor_userid
                ]);
           }
           
           


        }
        
        return response()->json([
            'status'    => '200'
        ]);
    } 
    
    public function account_pkucs216_detail_old(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_216 
            WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'"

            
            
        ');
        // SELECT *  from acc_1102050101_216 a
            // left outer join acc_opitemrece ao ON ao.vn = a.vn
            // WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"
        // AND status = "N"
        return view('account_216.account_pkucs216_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs216_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');      
        $data['users'] = User::get(); 
        $data = DB::select('
                SELECT U1.debit_walkin,U1.uc_money,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.debit_total,U1.dchdate
                from acc_1102050101_216 U1             
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'" 
                group by U1.vn
        ');
   
        $datashow = DB::select(
            'SELECT month(U1.vstdate) as months,year(U1.vstdate) as year,l.MONTH_NAME,SUM(debit_total) debit_total
          
                from acc_1102050101_216 U1      
                left outer join leave_month l on l.MONTH_ID = month(U1.vstdate)
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"  
        ');
      
        // ,(SELECT SUM(debit_total) FROM acc_1102050101_216 WHERE month(vstdate) = month(U1.vstdate) AND year(vstdate) = year(U1.vstdate) AND (stm_money IS NOT NULL OR stm_money <> "")) as stm_Total
        return view('account_216.account_pkucs216_detail', $data, [ 
            'data'            => $data,
            'datashow'        => $datashow,
            // 'data_hospcode'   => $data_hospcode,
            'months'          => $months,
            'year'            => $year
        ]);
    }

    public function account_pkucs216_search(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d'); 
        $new_day = date('Y-m-d', strtotime($date . ' -5 day')); //ย้อนหลัง 1 วัน
        $data['users'] = User::get();
        if ($startdate =='') {
           $datashow = DB::select(' 
                
               SELECT a.*,b.pp,b.fs 
               from acc_1102050101_216 a
               LEFT JOIN acc_stm_ucs b ON b.hn = a.hn AND b.vstdate = a.vstdate
               WHERE a.vstdate BETWEEN "'.$new_day.'" AND  "'.$date.'" 
               GROUP BY a.vn
           ');
        } else {
           $datashow = DB::select(' 
               SELECT a.*,b.pp,b.fs 
               from acc_1102050101_216 a
               LEFT JOIN acc_stm_ucs b ON b.hn = a.hn AND b.vstdate = a.vstdate
               WHERE a.vstdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
               GROUP BY a.vn 
           ');
        } 
        return view('account_216.account_pkucs216_search', $data, [
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'startdate'     => $startdate,
            'enddate'       => $enddate
        ]);
    }
    
    public function account_pkucs216_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT *             
            FROM acc_1102050101_216            
            WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'" 
            AND stm_money IS NOT NULL
            GROUP BY vn

           
        ');
        // SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,s.dmis_money2
        // ,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.STMdoc,a.debit_total,s.ip_paytrue as STM202
        // ,s.hc_drug + s.hc + s.ae_drug + s.inst + s.ae as stm216
        // ,s.total_approve STM_TOTAL
        // from acc_1102050101_216 a
        // LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
        // WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"        
        // AND (s.hc_drug+ s.hc+s.ae_drug+s.inst+s.ae <> 0 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae <> "")
        // group by a.vn

        // AND s.rep IS NOT NULL
       
            return view('account_216.account_pkucs216_stm', $data, [
                'startdate'         =>     $startdate,
                'enddate'           =>     $enddate,
                'datashow'          =>     $datashow,
                'months'            =>     $months,
                'year'              =>     $year, 
            ]);
    }
    public function account_pkucs216_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::connection('mysql')->select('  
            SELECT *             
            FROM acc_1102050101_216            
            WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'" 
            AND stm_money IS NULL
            GROUP BY vn
        ');

        // $data = DB::select('
        //         SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2,s.total_approve,a.income_group,s.inst,s.ip_paytrue
        //         ,s.hc_drug + s.hc + s.ae_drug + s.inst + s.ae  as stm216
        //         from acc_1102050101_216 a
        //         LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
        //         WHERE a.status ="N"
        //         AND month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"
        //         AND (s.hc_drug+ s.hc+s.ae_drug+s.inst+s.ae < 1 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae is null)
                
        //         group by a.vn
        // ');
        // AND (s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug = 0 OR s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug is null)

        return view('account_216.account_pkucs216_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year, 
        ]);
    }

    public function account_pkucs216_stm_date(Request $request,$startdate,$enddate)
    {
        $data['users'] = User::get();

        $datashow = DB::select('
        

            SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,s.dmis_money2
            ,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.STMdoc,a.debit_total,s.ip_paytrue as STM202
            ,s.hc_drug+ s.hc+ s.ae_drug+s.inst + s.ae as stm216
            ,s.total_approve STM_TOTAL
            from acc_1102050101_216 a
            LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
            WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
            AND (s.hc_drug+ s.hc+s.ae_drug+s.inst+s.ae <> 0 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae <> "")
           
            group by a.vn
        ');
        // AND (s.hc_drug+ s.hc+s.ae_drug+s.inst+s.ae <> 0 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae <> "") 
        // AND (s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> 0 OR s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> "") 
        // AND s.rep IS NOT NULL
       
            return view('account_216.account_pkucs216_stm_date', $data, [
                'startdate'         =>     $startdate,
                'enddate'           =>     $enddate,
                'datashow'          =>     $datashow, 
            ]);
    }
    public function account_pkucs216_detail_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_216 
            WHERE vstdate between "'.$startdate.'" and  "'.$enddate.'" 
        '); 
        return view('account_216.account_pkucs216_detail_date', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data, 
        ]);
    }
    public function account_pkucs216_stmnull_date(Request $request,$startdate,$enddate)
    { 
        $data['users'] = User::get();

        $data = DB::select('
                SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2,s.total_approve,a.income_group,s.inst,s.ip_paytrue
                ,s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae as stm216
                from acc_1102050101_216 a
                LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
                WHERE a.status ="N"
                AND a.vstdate between "'.$startdate.'" and  "'.$enddate.'" 
                AND (s.hc_drug+ s.hc+s.ae_drug+s.inst+s.ae <> 0 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.ae is null)
                
                group by a.vn
        '); 
          
        // AND (s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug = 0 OR s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug is null)
        return view('account_216.account_pkucs216_stmnull_date', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data, 
        ]);
    }
    public function account_216_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs216_yokpai(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select(
            'SELECT *             
            FROM acc_1102050101_216            
            WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'" 
            AND (stm_money IS NULL OR stm_money = "")
           
        ');
  
        return view('account_216.account_pkucs216_yokpai', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year, 
        ]);
    }

    // ************ Claim ******************************
    public function account_pkucs216_claim(Request $request)
    {         
        Fdh_ins::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_pat::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_opd::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_orf::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_odx::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_oop::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_ipd::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_irf::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_idx::where('d_anaconda_id','=','WALKIN')->delete(); 
        Fdh_iop::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_cht::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_cha::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_aer::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_adp::where('d_anaconda_id','=','WALKIN')->delete();
        Fdh_dru::where('d_anaconda_id','=','WALKIN')->delete();            
        Fdh_lvd::where('d_anaconda_id','=','WALKIN')->delete(); 
 
      
        Fdh_sesion::where('d_anaconda_id', '=', 'WALKIN')->delete(); 
        $s_date_now = date("Y-m-d");
        $s_time_now = date("H:i:s");
        $id = $request->ids;
        $iduser = Auth::user()->id;

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $s_date_now_preg = preg_replace($pattern_date, '', $s_date_now);
        $pattern_time = '/:/i';
        $s_time_now_preg = preg_replace($pattern_time, '', $s_time_now);
        #ตัดขีด, ตัด : ออก
        $folder_name = 'WALKIN_' . $s_date_now_preg . '_' . $s_time_now_preg;
        Fdh_sesion::insert([
            'folder_name'      => $folder_name,
            'd_anaconda_id'    => 'WALKIN',
            'date_save'        => $s_date_now,
            'time_save'        => $s_time_now,
            'userid'           => $iduser
        ]);  

        $data_vn_1 = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
        // $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
       
        // $data_vn_1 = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->where('account_code','=',"1102050101.401")->where('stamp','=',"N")->get();
        // $data_vn_1 = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->where('account_code','=',"1102050101.401")->where('stamp','=',"N")->where('approval_code','<>',"")->get();
         foreach ($data_vn_1 as $key => $va1) {
                //D_ins OK
                $data_ins_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN
                    ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE,v.cid CID,v.hcode AS HCODE
                    ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d") DATEIN
                    ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d") DATEEXP
                    ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB,"" GOVCODE ,"" GOVNAME                    
                    ,IFNULL(vp.claim_code,vp.auth_code) as PERMITNO
                    ,"" DOCNO ,"" OWNRPID,"" OWNNAME ,i.an AN ,v.vn SEQ ,"" SUBINSCL,"" RELINSCL
                    ,"" HTYPE
                    FROM vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN pttype pp on pp.pttype = i.pttype
                    LEFT OUTER JOIN ipt_pttype ap on ap.an = i.an
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                    LEFT OUTER JOIN rcpt_debt r on r.vn = v.vn
                    LEFT OUTER JOIN patient px on px.hn = v.hn     
                          
                    WHERE v.vn IN("'.$va1->vn.'")  
                    GROUP BY v.vn 
                ');
                // ,ifnull(if(i.an is null,r.sss_approval_code,ap.claim_code),vp.claimcode) PERMITNO
                // ,"2" HTYPE
                foreach ($data_ins_ as $va_01) { 
                    foreach ($data_ins_ as $va_01) {
                        Fdh_ins::insert([
                            'HN'                => $va_01->HN,
                            'INSCL'             => $va_01->INSCL,
                            'SUBTYPE'           => $va_01->SUBTYPE,
                            'CID'               => $va_01->CID,
                            'HCODE'             => $va_01->HCODE,
                            'DATEEXP'           => $va_01->DATEEXP,
                            'HOSPMAIN'          => $va_01->HOSPMAIN,
                            'HOSPSUB'           => $va_01->HOSPSUB,
                            'GOVCODE'           => $va_01->GOVCODE,
                            'GOVNAME'           => $va_01->GOVNAME,
                            'PERMITNO'          => $va_01->PERMITNO,
                            'DOCNO'             => $va_01->DOCNO,
                            'OWNRPID'           => $va_01->OWNRPID,
                            'OWNNAME'           => $va_01->OWNNAME,
                            'AN'                => $va_01->AN,
                            'SEQ'               => $va_01->SEQ,
                            'SUBINSCL'          => $va_01->SUBINSCL,
                            'RELINSCL'          => $va_01->RELINSCL,
                            'HTYPE'             => $va_01->HTYPE,
            
                            'user_id'           => $iduser,
                            'd_anaconda_id'     => 'WALKIN'
                        ]);
                    }
                }
                //D_pat OK
                $data_pat_ = DB::connection('mysql2')->select(
                    'SELECT v.hcode HCODE,v.hn HN
                    ,pt.chwpart CHANGWAT,pt.amppart AMPHUR,DATE_FORMAT(pt.birthday,"%Y%m%d") DOB
                    ,pt.sex SEX,pt.marrystatus MARRIAGE ,pt.occupation OCCUPA,lpad(pt.nationality,3,0) NATION,pt.cid PERSON_ID
                    ,concat(pt.fname," ",pt.lname,",",pt.pname) NAMEPAT
                    ,pt.pname TITLE,pt.fname FNAME,pt.lname LNAME,"1" IDTYPE
                    FROM vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn 
                    WHERE v.vn IN("'.$va1->vn.'")
                ');            
                foreach ($data_pat_ as $va_02) {                   
                    $check_hn = Fdh_pat::where('hn', $va_02->HN)->where('d_anaconda_id', '=', 'WALKIN')->count();
                    if ($check_hn > 0) {
                    } else {
                        Fdh_pat::insert([
                            'HCODE'              => $va_02->HCODE,
                            'HN'                 => $va_02->HN,
                            'CHANGWAT'           => $va_02->CHANGWAT,
                            'AMPHUR'             => $va_02->AMPHUR,
                            'DOB'                => $va_02->DOB,
                            'SEX'                => $va_02->SEX,
                            'MARRIAGE'           => $va_02->MARRIAGE,
                            'OCCUPA'             => $va_02->OCCUPA,
                            'NATION'             => $va_02->NATION,
                            'PERSON_ID'          => $va_02->PERSON_ID,
                            'NAMEPAT'            => $va_02->NAMEPAT,
                            'TITLE'              => $va_02->TITLE,
                            'FNAME'              => $va_02->FNAME,
                            'LNAME'              => $va_02->LNAME,
                            'IDTYPE'             => $va_02->IDTYPE,
                            'user_id'            => $iduser,
                            'd_anaconda_id'      => 'WALKIN'
                        ]);
                    }
                }
                //D_opd OK
                $data_opd = DB::connection('mysql2')->select(
                    'SELECT  v.hn HN,v.spclty CLINIC,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD,v.vn SEQ
                        ,"1" UUC ,"" DETAIL,oc.temperature as BTEMP,oc.bps as SBP,oc.bpd as DBP,""PR,""RR,""OPTYPE,ot.export_code as TYPEIN,st.export_code as TYPEOUT
                        from vn_stat v
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN opdscreen oc  on oc.vn = o.vn 
                        LEFT OUTER JOIN pttype p on p.pttype = v.pttype                       
                        LEFT OUTER JOIN patient pt on pt.hn = v.hn
                        LEFT OUTER JOIN ovstist ot on ot.ovstist = o.ovstist  
                        LEFT OUTER JOIN ovstost st on st.ovstost = o.ovstost 
                        WHERE v.vn IN("'.$va1->vn.'")                  
                '); 
                // LEFT OUTER JOIN ipt i on i.vn = v.vn
                foreach ($data_opd as $val3) {   
                    $count_hn = Fdh_opd::where('SEQ',$val3->SEQ)->count(); 
                    // if ($count_hn > 0) {
                    //     # code...
                    // } else {
                        Fdh_opd::insert([
                            'HN'                => $val3->HN,
                            'CLINIC'            => $val3->CLINIC,
                            'DATEOPD'           => $val3->DATEOPD,
                            'TIMEOPD'           => $val3->TIMEOPD,
                            'SEQ'               => $val3->SEQ,
                            'UUC'               => $val3->UUC,
                            'DETAIL'            => $val3->DETAIL,
                            'BTEMP'             => $val3->BTEMP,
                            'SBP'               => $val3->SBP,
                            'DBP'               => $val3->DBP,
                            'PR'                => $val3->PR,
                            'RR'                => $val3->RR,
                            'OPTYPE'            => $val3->OPTYPE,
                            'TYPEIN'            => $val3->TYPEIN,
                            'TYPEOUT'           => $val3->TYPEOUT,
                            'user_id'           => $iduser,
                            'd_anaconda_id'     => 'WALKIN'
                        ]);
                    // }
                                        
                    
                }
                //D_orf _OK
                $data_orf_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,v.spclty CLINIC,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                        ,"0100" REFERTYPE,v.vn SEQ,if(r1.refer_date ="",r2.refer_date,r1.refer_date) as REFERDATE
                        FROM vn_stat v
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN referin r1 on r1.vn = v.vn 
                        LEFT OUTER JOIN referout r2 on r2.vn = v.vn
                        WHERE v.vn IN("'.$va1->vn.'") 
                        AND (r1.vn is not null or r2.vn is not null);
                ');                
                foreach ($data_orf_ as $va_03) {    
                    Fdh_orf::insert([
                        'HN'                => $va_03->HN,
                        'DATEOPD'           => $va_03->DATEOPD,
                        'CLINIC'            => $va_03->CLINIC,
                        'REFER'             => $va_03->REFER,
                        'REFERTYPE'         => $va_03->REFERTYPE,
                        'SEQ'               => $va_03->SEQ,
                        'REFERDATE'         => $va_03->REFERDATE,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]);
                }
                 // D_odx OK
                 $data_odx_ = DB::connection('mysql2')->select(
                    'SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEDX,v.spclty as CLINIC,o.icd10 as DIAG,o.diagtype as DXTYPE
                        ,if(d.licenseno="","-99999",d.licenseno) as DRDX,v.cid as PERSON_ID ,v.vn as SEQ
                        FROM vn_stat v
                        LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE v.vn IN("'.$va1->vn.'") 
                ');             
                foreach ($data_odx_ as $va_04) { 
                    if ($va_04->DIAG == 'U779') {
                        $diag_new = 'U77';
                    } else {
                        $diag_new = $va_04->DIAG;
                    }
                    Fdh_odx::insert([
                        'HN'                => $va_04->HN,
                        'DATEDX'            => $va_04->DATEDX,
                        'CLINIC'            => $va_04->CLINIC,
                        'DIAG'              => $diag_new,
                        'DXTYPE'            => $va_04->DXTYPE,
                        'DRDX'              => $va_04->DRDX,
                        'PERSON_ID'         => $va_04->PERSON_ID,
                        'SEQ'               => $va_04->SEQ,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]);                
                }
                 //D_oop OK
                 $data_oop_ = DB::connection('mysql2')->select(
                    'SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEOPD,v.spclty as CLINIC,o.icd10 as OPER
                        ,if(d.licenseno="","-99999",d.licenseno) as DROPID,pt.cid as PERSON_ID ,v.vn as SEQ ,""SERVPRICE
                        FROM vn_stat v
                        LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                        LEFT OUTER JOIN patient pt on v.hn=pt.hn
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd9cm1 i on i.code = o.icd10
                        WHERE v.vn IN("'.$va1->vn.'")
                        AND substring(o.icd10,1,1) in ("0","1","2","3","4","5","6","7","8","9") 
                ');
                foreach ($data_oop_ as $va_05) { 
                    Fdh_oop::insert([
                        'HN'                => $va_05->HN,
                        'DATEOPD'           => $va_05->DATEOPD,
                        'CLINIC'            => $va_05->CLINIC,
                        'OPER'              => $va_05->OPER,
                        'DROPID'            => $va_05->DROPID,
                        'PERSON_ID'         => $va_05->PERSON_ID,
                        'SEQ'               => $va_05->SEQ,
                        'SERVPRICE'         => $va_05->SERVPRICE,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]);
                     
                    
                }
                //D_ipd OK
                $data_ipd_ = DB::connection('mysql2')->select(
                    'SELECT a.hn HN,a.an AN,DATE_FORMAT(i.regdate,"%Y%m%d") DATEADM,Time_format(i.regtime,"%H%i") TIMEADM
                        ,DATE_FORMAT(i.dchdate,"%Y%m%d") DATEDSC,Time_format(i.dchtime,"%H%i")  TIMEDSC,right(i.dchstts,1) DISCHS
                        ,right(i.dchtype,1) DISCHT,i.ward WARDDSC,i.spclty DEPT,format(i.bw/1000,3) ADM_W,"1" UUC ,"I" SVCTYPE 
                        FROM an_stat a
                        LEFT OUTER JOIN ipt i on i.an = a.an
                        LEFT OUTER JOIN pttype p on p.pttype = a.pttype
                        LEFT OUTER JOIN patient pt on pt.hn = a.hn
                        WHERE i.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_ipd_ as $va_06) {   
                    Fdh_ipd::insert([
                        'HN'                => $va_06->HN,
                        'AN'                => $va_06->AN,
                        'DATEADM'           => $va_06->DATEADM,
                        'TIMEADM'           => $va_06->TIMEADM,
                        'DATEDSC'           => $va_06->DATEDSC,
                        'TIMEDSC'           => $va_06->TIMEDSC,
                        'DISCHS'            => $va_06->DISCHS,
                        'DISCHT'            => $va_06->DISCHT,
                        'WARDDSC'           => $va_06->WARDDSC,
                        'DEPT'              => $va_06->DEPT,
                        'ADM_W'             => $va_06->ADM_W,
                        'UUC'               => $va_06->UUC,
                        'SVCTYPE'           => $va_06->SVCTYPE,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]);   
                }                
                //D_irf OK
                 $data_irf_ = DB::connection('mysql2')->select(
                    'SELECT a.an AN,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER,"0100" REFERTYPE
                        FROM an_stat a
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        LEFT OUTER JOIN referout o on o.vn = a.an
                        LEFT OUTER JOIN referin oo on oo.vn = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        AND (a.an in(SELECT vn FROM referin WHERE vn = oo.vn) or a.an in(SELECT vn FROM referout WHERE vn = o.vn));
                ');
                foreach ($data_irf_ as $va_07) {
                    Fdh_irf::insert([
                        'AN'                 => $va_07->AN,
                        'REFER'              => $va_07->REFER,
                        'REFERTYPE'          => $va_07->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'WALKIN',
                    ]);                  
                }                 
                //D_idx OK 
                $data_idx_ = DB::connection('mysql2')->select(
                    'SELECT v.an AN,o.icd10 DIAG,o.diagtype DXTYPE,if(d.licenseno="","-99999",d.licenseno) DRDX
                        FROM an_stat v
                        LEFT OUTER JOIN iptdiag o on o.an = v.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_idx_ as $va_08) {  
                    Fdh_idx::insert([
                        'AN'                => $va_08->AN,
                        'DIAG'              => $va_08->DIAG,
                        'DXTYPE'            => $va_08->DXTYPE,
                        'DRDX'              => $va_08->DRDX,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]);
                            
                }
                //D_iop OK
                $data_iop_ = DB::connection('mysql2')->select(
                    'SELECT a.an AN,o.icd9 OPER,o.oper_type as OPTYPE,if(d.licenseno="","-99999",d.licenseno) DROPID,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN,Time_format(o.optime,"%H%i") TIMEIN
                        ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT,Time_format(o.endtime,"%H%i") TIMEOUT
                        FROM an_stat a
                        LEFT OUTER JOIN iptoprt o on o.an = a.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd9cm1 i on i.code = o.icd9
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_iop_ as $va_09) {
                    Fdh_iop::insert([
                        'AN'                => $va_09->AN,
                        'OPER'              => $va_09->OPER,
                        'OPTYPE'            => $va_09->OPTYPE,
                        'DROPID'            => $va_09->DROPID,
                        'DATEIN'            => $va_09->DATEIN,
                        'TIMEIN'            => $va_09->TIMEIN,
                        'DATEOUT'           => $va_09->DATEOUT,
                        'TIMEOUT'           => $va_09->TIMEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]); 
                }
                //D_cht OK
                $data_cht_ = DB::connection('mysql2')->select(
                    'SELECT o.hn HN,o.an AN,DATE_FORMAT(if(a.an is null,o.vstdate,a.dchdate),"%Y%m%d") DATE,round(if(a.an is null,vv.income,a.income),2) TOTAL,""OPD_MEMO,""INVOICE_NO,""INVOICE_LT
                    ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE,pp.cid PERSON_ID ,o.vn SEQ
                    FROM ovst o
                    LEFT OUTER JOIN vn_stat vv on vv.vn = o.vn
                    LEFT OUTER JOIN an_stat a on a.an = o.an
                    LEFT OUTER JOIN patient pp on pp.hn = o.hn
                    LEFT OUTER JOIN pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                    LEFT OUTER JOIN pttype p on p.pttype = a.pttype 
                    WHERE o.vn IN("'.$va1->vn.'")  
                    
                ');
                foreach ($data_cht_ as $va_10) {
                    Fdh_cht::insert([
                        'HN'                => $va_10->HN,
                        'AN'                => $va_10->AN,
                        'DATE'              => $va_10->DATE,
                        'TOTAL'             => $va_10->TOTAL,
                        'PAID'              => $va_10->PAID,
                        'PTTYPE'            => $va_10->PTTYPE,
                        'PERSON_ID'         => $va_10->PERSON_ID,
                        'SEQ'               => $va_10->SEQ,
                        'OPD_MEMO'          => $va_10->OPD_MEMO,
                        'INVOICE_NO'        => $va_10->INVOICE_NO,
                        'INVOICE_LT'        => $va_10->INVOICE_LT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]); 
                }
                //D_cha OK
                $data_cha_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN,if(v1.an is null,"",v1.an) AN ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                        FROM opitemrece v
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN patient p on p.hn = v.hn
                        LEFT OUTER JOIN ipt v1 on v1.an = v.an
                        LEFT OUTER JOIN income i on v.income=i.income
                        LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                        WHERE v.vn IN("'.$va1->vn.'") 
                        GROUP BY v.vn,CHRGITEM

                        UNION ALL

                        SELECT v.hn HN,ip.an AN ,if(ip.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(ip.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                        FROM opitemrece v
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN patient p on p.hn = v.hn
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        LEFT OUTER JOIN income i on v.income=i.income
                        LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        GROUP BY v.an,CHRGITEM; 
                ');
                foreach ($data_cha_ as $va_11) {
                    Fdh_cha::insert([
                        'HN'                => $va_11->HN,
                        'AN'                => $va_11->AN,
                        'DATE'              => $va_11->DATE,
                        'CHRGITEM'          => $va_11->CHRGITEM,
                        'AMOUNT'            => $va_11->AMOUNT,
                        'PERSON_ID'         => $va_11->PERSON_ID,
                        'SEQ'               => $va_11->SEQ,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]); 
                } 
                //D_aer OK
                $data_aer_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN ,i.an AN ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD 
                         ,vv.claim_code AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM vn_stat v
                        LEFT OUTER JOIN ipt i on i.vn = v.vn
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN visit_pttype vv on vv.vn = v.vn
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        
                        WHERE v.vn IN("'.$va1->vn.'") and i.an is null
                        AND i.an is null
                        GROUP BY v.vn
                         UNION ALL
                        SELECT a.hn HN,a.an AN,DATE_FORMAT(vs.vstdate,"%Y%m%d") DATEOPD,"" AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM an_stat a
                        LEFT OUTER JOIN ipt_pttype vv on vv.an = a.an
                        LEFT OUTER JOIN pttype pt on pt.pttype =a.pttype  
                        LEFT OUTER JOIN vn_stat vs on vs.vn =a.vn
                        
                        WHERE a.vn IN("'.$va1->vn.'")
                        GROUP BY a.an;
                ');
                foreach ($data_aer_ as $va_12) {
                    Fdh_aer::insert([
                        'HN'                => $va_12->HN,
                        'AN'                => $va_12->AN,
                        'DATEOPD'           => $va_12->DATEOPD,
                        'AUTHAE'            => $va_12->AUTHAE,
                        'AEDATE'            => $va_12->AEDATE,
                        'AETIME'            => $va_12->AETIME,
                        'AETYPE'            => $va_12->AETYPE,
                        'REFER_NO'          => $va_12->REFER_NO,
                        'REFMAINI'          => $va_12->REFMAINI,
                        'IREFTYPE'          => $va_12->IREFTYPE,
                        'REFMAINO'          => $va_12->REFMAINO,
                        'OREFTYPE'          => $va_12->OREFTYPE,
                        'UCAE'              => "N",
                        'EMTYPE'            => $va_12->EMTYPE,
                        'SEQ'               => $va_12->SEQ,
                        'AESTATUS'          => $va_12->AESTATUS,
                        'DALERT'            => $va_12->DALERT,
                        'TALERT'            => $va_12->TALERT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'WALKIN'
                    ]); 
                } 
                // 'UCAE'              => $va_12->UCAE,
                //D_adp ทั่วไป
                $data_adp_ = DB::connection('mysql2')->select(
                    'SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                            ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = i.vn AND income ="14") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN ipt i on i.an = v.an
                        AND i.an is not NULL 
                        WHERE i.vn IN("'.$va1->vn.'") AND v.income NOT IN("13","14")
                        GROUP BY i.vn,n.nhso_adp_code,rate) a 
                        GROUP BY an,CODE,rate
                            UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP 
                            ,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = vv.vn AND income ="14") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("'.$va1->vn.'") AND v.income NOT IN("13","14")
                        AND v.an is NULL
                        GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                        GROUP BY seq,CODE,rate;
                '); 
                // and n.nhso_adp_code is not null 
                // ,n.nhso_adp_type_id TYPE
                // ,ic.drg_chrgitem_id TYPE
                                
                foreach ($data_adp_ as $va_13) {  
                        Fdh_adp::insert([
                            'HN'                   => $va_13->HN,
                            'AN'                   => $va_13->AN,
                            'DATEOPD'              => $va_13->DATEOPD,
                            'TYPE'                 => $va_13->TYPE,
                            'CODE'                 => $va_13->CODE,
                            'QTY'                  => $va_13->QTY,
                            'RATE'                 => $va_13->RATE,
                            'SEQ'                  => $va_13->SEQ,
                            'CAGCODE'              => $va_13->CAGCODE,
                            'DOSE'                 => $va_13->DOSE,
                            'CA_TYPE'              => $va_13->CA_TYPE,
                            'SERIALNO'             => $va_13->SERIALNO,
                            'TOTCOPAY'             => $va_13->TOTCOPAY,
                            'USE_STATUS'           => $va_13->USE_STATUS,
                            'TOTAL'                => $va_13->TOTAL,
                            'QTYDAY'               => $va_13->QTYDAY,
                            'TMLTCODE'             => $va_13->TMLTCODE,
                            'STATUS1'              => $va_13->STATUS1,
                            'BI'                   => $va_13->BI,
                            'CLINIC'               => $va_13->CLINIC,
                            'ITEMSRC'              => $va_13->ITEMSRC,
                            'PROVIDER'             => $va_13->PROVIDER,
                            'GRAVIDA'              => $va_13->GRAVIDA,
                            'GA_WEEK'              => $va_13->GA_WEEK,
                            'DCIP'                 => $va_13->DCIP,
                            'LMP'                  => $va_13->LMP,
                            'SP_ITEM'              => $va_13->SP_ITEM,
                            'icode'                => $va_13->icode,
                            'vstdate'              => $va_13->vstdate,
                            'user_id'              => $iduser,
                            'd_anaconda_id'        => 'WALKIN'
                        ]);                  
                } 
                //D_adp กายภาพ
                $data_adp_kay = DB::connection('mysql2')->select(
                    'SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                            ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = i.vn AND income ="14") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN ipt i on i.an = v.an
                        AND i.an is not NULL 
                        WHERE i.vn IN("'.$va1->vn.'") AND v.income IN("14")
                        GROUP BY i.vn) a 
                        GROUP BY an,CODE,rate
                            UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP 
                            ,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = vv.vn AND income ="14") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("'.$va1->vn.'") AND v.income IN("14")
                        AND v.an is NULL
                        GROUP BY vv.vn) b 
                        GROUP BY seq,CODE,rate;
                '); 
                foreach ($data_adp_kay as $va_20) { 
                    Fdh_adp::insert([
                        'HN'                   => $va_20->HN,
                        'AN'                   => $va_20->AN,
                        'DATEOPD'              => $va_20->DATEOPD,
                        'TYPE'                 => '20',
                        'CODE'                 => 'XXX14',
                        'QTY'                  => '1',
                        'RATE'                 => $va_20->rate_new,
                        'SEQ'                  => $va_20->SEQ,
                        'CAGCODE'              => $va_20->CAGCODE,
                        'DOSE'                 => $va_20->DOSE,
                        'CA_TYPE'              => $va_20->CA_TYPE,
                        'SERIALNO'             => $va_20->SERIALNO,
                        'TOTCOPAY'             => $va_20->TOTCOPAY,
                        'USE_STATUS'           => $va_20->USE_STATUS,
                        'TOTAL'                => $va_20->TOTAL,
                        'QTYDAY'               => $va_20->QTYDAY,
                        'TMLTCODE'             => $va_20->TMLTCODE,
                        'STATUS1'              => $va_20->STATUS1,
                        'BI'                   => $va_20->BI,
                        'CLINIC'               => $va_20->CLINIC,
                        'ITEMSRC'              => $va_20->ITEMSRC,
                        'PROVIDER'             => $va_20->PROVIDER,
                        'GRAVIDA'              => $va_20->GRAVIDA,
                        'GA_WEEK'              => $va_20->GA_WEEK,
                        'DCIP'                 => $va_20->DCIP,
                        'LMP'                  => $va_20->LMP,
                        'SP_ITEM'              => $va_20->SP_ITEM,
                        'icode'                => $va_20->icode,
                        'vstdate'              => $va_20->vstdate,
                        'user_id'              => $iduser,
                        'd_anaconda_id'        => 'WALKIN'
                    ]);   
                }
                 //D_adp ทันตกรรม
                 $data_adp_dent = DB::connection('mysql2')->select(
                    'SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                            ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = i.vn AND income ="13") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN ipt i on i.an = v.an
                        AND i.an is not NULL 
                        WHERE i.vn IN("'.$va1->vn.'") AND v.income IN("13")
                        GROUP BY i.vn,n.nhso_adp_code,rate) a 
                        GROUP BY an,CODE,rate
                            UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,icode ,vstdate,income,rate_new
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP 
                            ,""SP_ITEM,v.icode,v.vstdate,v.income
                            ,(SELECT SUM(sum_price) FROM opitemrece WHERE vn = vv.vn AND income ="13") as rate_new
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode 
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("'.$va1->vn.'") AND v.income IN("13")
                        AND v.an is NULL
                        GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                        GROUP BY seq,CODE,rate;
                '); 
                foreach ($data_adp_dent as $va_21) {   
                    Fdh_adp::insert([
                        'HN'                   => $va_21->HN,
                        'AN'                   => $va_21->AN,
                        'DATEOPD'              => $va_21->DATEOPD,
                        'TYPE'                 => $va_21->TYPE,
                        'CODE'                 => $va_21->CODE,
                        'QTY'                  => $va_21->QTY,
                        'RATE'                 => $va_21->RATE,
                        'SEQ'                  => $va_21->SEQ, 
                        'CAGCODE'              => $va_21->CAGCODE,
                        'DOSE'                 => $va_21->DOSE,
                        'CA_TYPE'              => $va_21->CA_TYPE,
                        'SERIALNO'             => $va_21->SERIALNO,
                        'TOTCOPAY'             => $va_21->TOTCOPAY,
                        'USE_STATUS'           => $va_21->USE_STATUS,
                        'TOTAL'                => $va_21->TOTAL,
                        'QTYDAY'               => $va_21->QTYDAY,
                        'TMLTCODE'             => $va_21->TMLTCODE,
                        'STATUS1'              => $va_21->STATUS1,
                        'BI'                   => $va_21->BI,
                        'CLINIC'               => $va_21->CLINIC,
                        'ITEMSRC'              => $va_21->ITEMSRC,
                        'PROVIDER'             => $va_21->PROVIDER,
                        'GRAVIDA'              => $va_21->GRAVIDA,
                        'GA_WEEK'              => $va_21->GA_WEEK,
                        'DCIP'                 => $va_21->DCIP,
                        'LMP'                  => $va_21->LMP,
                        'SP_ITEM'              => $va_21->SP_ITEM,
                        'icode'                => $va_21->icode,
                        'vstdate'              => $va_21->vstdate,
                        'user_id'              => $iduser,
                        'd_anaconda_id'        => 'WALKIN'
                    ]);        
                } 
                //D_dru OK
                 $data_dru_ = DB::connection('mysql2')->select(
                    'SELECT vv.hcode HCODE ,v.hn HN ,v.an AN ,vv.spclty CLINIC ,vv.cid PERSON_ID ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                    ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,v.qty AMOUNT ,round(v.unitprice,2) DRUGPRICE
                    ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                    ,if(v.income="17",oo.presc_reason,"") as DRUGREMARK,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                    ,"" TOTAL ,"" as SIGCODE ,"" as SIGTEXT ,"" PROVIDER,v.vstdate
                    FROM opitemrece v
                    LEFT OUTER JOIN drugitems d on d.icode = v.icode
                    LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                    LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode  
                    LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode               
                    WHERE v.vn IN("'.$va1->vn.'")
                    AND d.did is not null 
                    GROUP BY v.vn,did

                    UNION all

                    SELECT pt.hcode HCODE ,v.hn HN ,v.an AN ,v1.spclty CLINIC ,pt.cid PERSON_ID ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                    ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,sum(v.qty) AMOUNT ,round(v.unitprice,2) DRUGPRICE
                    ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                    ,if(v.income="17",oo.presc_reason,"") as DRUGREMARK,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                    ,"" TOTAL,"" as SIGCODE,"" as SIGTEXT,""  PROVIDER,v.vstdate
                    FROM opitemrece v
                    LEFT OUTER JOIN drugitems d on d.icode = v.icode
                    LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                    INNER JOIN ipt v1 on v1.an = v.an
                    LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
                    LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode               
                    WHERE v1.vn IN("'.$va1->vn.'")
                    AND d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS;              
                ');               
                foreach ($data_dru_ as $va_14) {
                    if ($va_14->AMOUNT < 1) {
                        # code...
                    } else {
                        Fdh_dru::insert([
                            'HCODE'          => $va_14->HCODE,
                            'HN'             => $va_14->HN,
                            'AN'             => $va_14->AN,
                            'CLINIC'         => $va_14->CLINIC,
                            'PERSON_ID'      => $va_14->PERSON_ID,
                            'DATE_SERV'      => $va_14->DATE_SERV,
                            'DID'            => $va_14->DID,
                            'DIDNAME'        => $va_14->DIDNAME,
                            'AMOUNT'         => $va_14->AMOUNT,
                            'DRUGPRIC'      => $va_14->DRUGPRICE,
                            'DRUGCOST'       => $va_14->DRUGCOST,
                            'DIDSTD'         => $va_14->DIDSTD,
                            'UNIT'           => $va_14->UNIT,
                            'UNIT_PACK'      => $va_14->UNIT_PACK,
                            'SEQ'            => $va_14->SEQ,
                            'DRUGREMARK'     => $va_14->DRUGREMARK,
                            'PA_NO'          => $va_14->PA_NO,
                            'TOTCOPAY'       => $va_14->TOTCOPAY,
                            'USE_STATUS'     => $va_14->USE_STATUS,
                            'TOTAL'          => $va_14->TOTAL,
                            'SIGCODE'        => $va_14->SIGCODE,
                            'SIGTEXT'        => $va_14->SIGTEXT,
                            'PROVIDER'       => $va_14->PROVIDER,
                            'vstdate'        => $va_14->vstdate,
                            'user_id'        => $iduser,
                            'd_anaconda_id'  => 'WALKIN'
                        ]); 
                    } 
                } 
                $walk_ = DB::connection('mysql')->select('SELECT * FROM fdh_adp WHERE d_anaconda_id = "WALKIN" GROUP BY HN');
                foreach ($walk_ as $key => $va_w) {
                    $chect_proj  = Fdh_adp::where('SEQ',$va_w->SEQ)->where('CODE','WALKIN')->count();
                     
                    if ($chect_proj > 0) {
                        # code...
                    } else {
                        Fdh_adp::insert([
                            'HN'                   => $va_w->HN,
                            'AN'                   => $va_w->AN,
                            'DATEOPD'              => $va_w->DATEOPD,
                            'TYPE'                 => '5',
                            'CODE'                 => 'WALKIN',
                            'QTY'                  => '1',
                            'RATE'                 => '0.00',
                            'SEQ'                  => $va_w->SEQ,
                            'CAGCODE'              => $va_w->CAGCODE,
                            'DOSE'                 => $va_w->DOSE,
                            'CA_TYPE'              => $va_w->CA_TYPE,
                            'SERIALNO'             => $va_w->SERIALNO,
                            'TOTCOPAY'             => $va_w->TOTCOPAY,
                            'USE_STATUS'           => $va_w->USE_STATUS,
                            'TOTAL'                => $va_w->TOTAL,
                            'QTYDAY'               => $va_w->QTYDAY,
                            'TMLTCODE'             => $va_w->TMLTCODE,
                            'STATUS1'              => $va_w->STATUS1,
                            'BI'                   => $va_w->BI,
                            'CLINIC'               => $va_w->CLINIC,
                            'ITEMSRC'              => $va_w->ITEMSRC,
                            'PROVIDER'             => $va_w->PROVIDER,
                            'GRAVIDA'              => $va_w->GRAVIDA,
                            'GA_WEEK'              => $va_w->GA_WEEK,
                            'DCIP'                 => $va_w->DCIP,
                            'LMP'                  => $va_w->LMP,
                            'SP_ITEM'              => $va_w->SP_ITEM,
                            'icode'                => $va_w->icode,
                            'vstdate'              => $va_w->vstdate,
                            'user_id'              => $iduser,
                            'd_anaconda_id'        => 'WALKIN'
                        ]);
                    }
                                       
                }
                 
         }

        Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
        ->update([
             'active_claim' => 'Y'
        ]);
        //  D_adp::where('CODE','=','XXXXXX')->delete();


        //  #delete file in folder ทั้งหมด
         $file = new Filesystem;
         $file->cleanDirectory('EXPORT_WALKIN'); //ทั้งหมด 
         $file->cleanDirectory('EXPORT_WALKIN_API'); //ทั้งหมด 
         $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "WALKIN"');
         foreach ($dataexport_ as $key => $v_export) {
             $folder_ = $v_export->folder_name;
         }
         $folder = $folder_;
          mkdir ('EXPORT_WALKIN/'.$folder, 0777, true);  //Web
          mkdir ('EXPORT_WALKIN_API/'.$folder, 0777, true);  //Web
         //  mkdir ('C:Export/'.$folder, 0777, true); //localhost
 
         header("Content-type: text/txt");
         header("Cache-Control: no-store, no-cache");
         header('Content-Disposition: attachment; filename="content.txt"; charset=tis-620″ ;');
 
          //********** 1 ins.txt *****************//
         $file_d_ins         = "EXPORT_WALKIN/".$folder."/INS.txt";
         $file_fdh_ins       = "EXPORT_WALKIN_API/".$folder."/INS.txt";
         $objFopen_opd_ins   = fopen($file_d_ins, 'w');
         $fdh_ins            = fopen($file_fdh_ins, 'w');
         // $opd_head_ins = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';  // สปสช
         $opd_head_ins       = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';   // FDH
         fwrite($objFopen_opd_ins, $opd_head_ins);
         fwrite($fdh_ins, $opd_head_ins);
         $ins = DB::connection('mysql')->select('SELECT * from fdh_ins where d_anaconda_id = "WALKIN"');
         foreach ($ins as $key => $value1) {
             $a1 = $value1->HN;
             $a2 = $value1->INSCL;
             $a3 = $value1->SUBTYPE;
             $a4 = $value1->CID;
             // $a5 = $value1->DATEIN;
             $a5 = $value1->HCODE;
             $a6 = $value1->DATEEXP;
             $a7 = $value1->HOSPMAIN;
             $a8 = $value1->HOSPSUB;
             $a9 = $value1->GOVCODE;
             $a10 = $value1->GOVNAME;
             $a11 = $value1->PERMITNO;
             $a12 = $value1->DOCNO;
             $a13 = $value1->OWNRPID;
             $a14 = $value1->OWNNAME;
             $a15 = $value1->AN;
             $a16 = $value1->SEQ;
             $a17 = $value1->SUBINSCL;
             $a18 = $value1->RELINSCL;
             $a19 = $value1->HTYPE;
             $strText_ins  ="\r\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
             $ansitxt_ins  = iconv('UTF-8', 'TIS-620', $strText_ins);
             $apifdh_ins   = iconv('UTF-8', 'UTF-8', $strText_ins); 
             fwrite($objFopen_opd_ins, $ansitxt_ins);
             fwrite($fdh_ins, $apifdh_ins);
         }
         fclose($objFopen_opd_ins);
         fclose($fdh_ins);
 
         //**********2 pat.txt ******************//
         $file_pat         = "EXPORT_WALKIN/".$folder."/PAT.txt";
         $file_fdh_pat     = "EXPORT_WALKIN_API/".$folder."/PAT.txt";
         $objFopen_opd_pat = fopen($file_pat, 'w');
         $fdh_pat          = fopen($file_fdh_pat, 'w');
         $opd_head_pat     = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
         fwrite($objFopen_opd_pat, $opd_head_pat);
         fwrite($fdh_pat, $opd_head_pat);
         $pat = DB::connection('mysql')->select('SELECT * from fdh_pat where d_anaconda_id = "WALKIN"');
         foreach ($pat as $key => $value2) {
             $i1 = $value2->HCODE;
             $i2 = $value2->HN;
             $i3 = $value2->CHANGWAT;
             $i4 = $value2->AMPHUR;
             $i5 = $value2->DOB;
             $i6 = $value2->SEX;
             $i7 = $value2->MARRIAGE;
             $i8 = $value2->OCCUPA;
             $i9 = $value2->NATION;
             $i10 = $value2->PERSON_ID;
             $i11 = $value2->NAMEPAT;
             $i12 = $value2->TITLE;
             $i13 = $value2->FNAME;
             $i14 = $value2->LNAME;
             $i15 = $value2->IDTYPE;     
             $strText_pat     ="\r\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            //  $ansitxt_pat     = iconv('UTF-8', 'TIS-620', $strText_pat);
             $ansitxt_pat     = iconv('UTF-8', 'UTF-8', $strText_pat);
             $apifdh_opdpat   = iconv('UTF-8', 'UTF-8', $strText_pat);
             fwrite($objFopen_opd_pat, $ansitxt_pat);
             fwrite($fdh_pat, $apifdh_opdpat);
         }
         fclose($objFopen_opd_pat);
         fclose($fdh_pat);
 
         //************ 3 opd.txt *****************//
         $file_d_opd       = "EXPORT_WALKIN/".$folder."/OPD.txt";
         $file_fdh_opd     = "EXPORT_WALKIN_API/".$folder."/OPD.txt";
         $objFopen_opd_opd = fopen($file_d_opd, 'w');
         $fdh_opd          = fopen($file_fdh_opd, 'w');
         $opd_head_opd     = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
         fwrite($objFopen_opd_opd, $opd_head_opd);
         fwrite($fdh_opd, $opd_head_opd);
         $opd = DB::connection('mysql')->select('SELECT * from fdh_opd where d_anaconda_id = "WALKIN" GROUP BY SEQ');
         foreach ($opd as $key => $value3) {
             $o1 = $value3->HN;
             $o2 = $value3->CLINIC;
             $o3 = $value3->DATEOPD; 
             $o4 = $value3->TIMEOPD; 
             $o5 = $value3->SEQ; 
             $o6 = $value3->UUC;  
             $o7 = $value3->DETAIL; 
             $o8 = $value3->BTEMP; 
             $o9 = $value3->SBP; 
             $o10 = $value3->DBP; 
             $o11 = $value3->PR; 
             $o12 = $value3->RR; 
             $o13 = $value3->OPTYPE; 
             $o14 = $value3->TYPEIN;
             $o15 = $value3->TYPEOUT;
             $strText_opd ="\r\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6."|".$o7."|".$o8."|".$o9."|".$o10."|".$o11."|".$o12."|".$o13."|".$o14."|".$o15;
             $ansitxt_opd = iconv('UTF-8', 'TIS-620', $strText_opd);
             $apifdh_opd  = iconv('UTF-8', 'UTF-8', $strText_opd);
             fwrite($objFopen_opd_opd, $ansitxt_opd);
             fwrite($fdh_opd, $apifdh_opd);
         }
         fclose($objFopen_opd_opd);
         fclose($fdh_opd);
 
         //****************** 4 orf.txt **************************//
         $file_d_orf       = "EXPORT_WALKIN/".$folder."/ORF.txt";
         $file_fdh_orf     = "EXPORT_WALKIN_API/".$folder."/ORF.txt";
         $objFopen_opd_orf = fopen($file_d_orf, 'w');
         $fdh_orf          = fopen($file_fdh_orf, 'w');
         $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
         fwrite($objFopen_opd_orf, $opd_head_orf);
         fwrite($fdh_orf, $opd_head_orf);
         $orf = DB::connection('mysql')->select('SELECT * from fdh_orf where d_anaconda_id = "WALKIN"');
         foreach ($orf as $key => $value4) {
             $p1 = $value4->HN;
             $p2 = $value4->DATEOPD;
             $p3 = $value4->CLINIC; 
             $p4 = $value4->REFER; 
             $p5 = $value4->REFERTYPE; 
             $p6 = $value4->SEQ;  
             $strText_orf  ="\r\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
             $ansitxt_orf  = iconv('UTF-8', 'TIS-620', $strText_orf);
             $apifdh_orf   = iconv('UTF-8', 'UTF-8', $strText_orf);
             fwrite($objFopen_opd_orf, $ansitxt_orf);
             fwrite($fdh_orf, $apifdh_orf);
         }
         fclose($objFopen_opd_orf);
         fclose($fdh_orf);
 
         //****************** 5 odx.txt **************************//
         $file_d_odx       = "EXPORT_WALKIN/".$folder."/ODX.txt";
         $file_fdh_odx     = "EXPORT_WALKIN_API/".$folder."/ODX.txt";
         $objFopen_opd_odx = fopen($file_d_odx, 'w');
         $fdh_odx          = fopen($file_fdh_odx, 'w');
         $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
         fwrite($objFopen_opd_odx, $opd_head_odx);
         fwrite($fdh_odx, $opd_head_odx);
         $odx = DB::connection('mysql')->select('SELECT * from fdh_odx where d_anaconda_id = "WALKIN"');
         foreach ($odx as $key => $value5) {
             $m1 = $value5->HN;
             $m2 = $value5->DATEDX;
             $m3 = $value5->CLINIC; 
             $m4 = $value5->DIAG; 
             $m5 = $value5->DXTYPE; 
             $m6 = $value5->DRDX; 
             $m7 = $value5->PERSON_ID; 
             $m8 = $value5->SEQ; 
             $strText_odx  ="\r\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
             $ansitxt_odx  = iconv('UTF-8', 'TIS-620', $strText_odx);
             $apifdh_odx   = iconv('UTF-8', 'UTF-8', $strText_odx);
             fwrite($objFopen_opd_odx, $ansitxt_odx);
             fwrite($fdh_odx, $apifdh_odx);
         }
         fclose($objFopen_opd_odx);
         fclose($fdh_odx);
 
         //****************** 6.oop.txt ******************************//
         $file_d_oop       = "EXPORT_WALKIN/".$folder."/OOP.txt";
         $file_fdh_oop     = "EXPORT_WALKIN_API/".$folder."/OOP.txt";
         $objFopen_opd_oop = fopen($file_d_oop, 'w');
         $fdh_oop          = fopen($file_fdh_oop, 'w');
         $opd_head_oop     = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
         fwrite($objFopen_opd_oop, $opd_head_oop);
         fwrite($fdh_oop, $opd_head_oop);
         $oop = DB::connection('mysql')->select('SELECT * from fdh_oop where d_anaconda_id = "WALKIN"');
         foreach ($oop as $key => $value6) {
             $n1 = $value6->HN;
             $n2 = $value6->DATEOPD;
             $n3 = $value6->CLINIC; 
             $n4 = $value6->OPER; 
             $n5 = $value6->DROPID; 
             $n6 = $value6->PERSON_ID; 
             $n7 = $value6->SEQ;  
             $strText_oop  ="\r\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
             $ansitxt_oop  = iconv('UTF-8', 'TIS-620', $strText_oop);
             $apifdh_oop   = iconv('UTF-8', 'UTF-8', $strText_oop);
             fwrite($objFopen_opd_oop, $ansitxt_oop);
             fwrite($fdh_oop, $apifdh_oop);
         }
         fclose($objFopen_opd_oop);
         fclose($fdh_oop);
 
         //******************** 7.ipd.txt **************************//
         $file_d_ipd       = "EXPORT_WALKIN/".$folder."/IPD.txt";
         $file_fdh_ipd     = "EXPORT_WALKIN_API/".$folder."/IPD.txt";
         $objFopen_opd_ipd = fopen($file_d_ipd, 'w');
         $fdh_ipd          = fopen($file_fdh_ipd, 'w');
         $opd_head_ipd     = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
         fwrite($objFopen_opd_ipd, $opd_head_ipd);
         fwrite($fdh_ipd, $opd_head_ipd);
         $ipd = DB::connection('mysql')->select('SELECT * from fdh_ipd where d_anaconda_id = "WALKIN"');
         foreach ($ipd as $key => $value7) {
             $j1  = $value7->HN;
             $j2  = $value7->AN;
             $j3  = $value7->DATEADM;
             $j4  = $value7->TIMEADM;
             $j5  = $value7->DATEDSC;
             $j6  = $value7->TIMEDSC;
             $j7  = $value7->DISCHS;
             $j8  = $value7->DISCHT;
             $j9  = $value7->WARDDSC;
             $j10 = $value7->DEPT;
             $j11 = $value7->ADM_W;
             $j12 = $value7->UUC;
             $j13 = $value7->SVCTYPE;    
             $strText_ipd     ="\r\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
             $ansitxt_pat_ipd = iconv('UTF-8', 'TIS-620', $strText_ipd);
             $apifdh_ipd      = iconv('UTF-8', 'UTF-8', $strText_ipd);
             fwrite($objFopen_opd_ipd, $ansitxt_pat_ipd);
             fwrite($fdh_ipd, $apifdh_ipd);
         }
         fclose($objFopen_opd_ipd);
         fclose($fdh_ipd);
 
          //********************* 8.irf.txt ***************************//
          $file_d_irf       = "EXPORT_WALKIN/".$folder."/IRF.txt";
          $file_fdh_irf     = "EXPORT_WALKIN_API/".$folder."/IRF.txt";
          $objFopen_opd_irf = fopen($file_d_irf, 'w');
          $fdh_irf          = fopen($file_fdh_irf, 'w');
          $opd_head_irf     = 'AN|REFER|REFERTYPE';
          fwrite($objFopen_opd_irf, $opd_head_irf);
          fwrite($fdh_irf, $opd_head_irf);
          $irf = DB::connection('mysql')->select('SELECT * from fdh_irf where d_anaconda_id = "WALKIN"');
          foreach ($irf as $key => $value8) {
              $k1 = $value8->AN;
              $k2 = $value8->REFER;
              $k3 = $value8->REFERTYPE; 
              $strText_irf     ="\r\n".$k1."|".$k2."|".$k3;
              $ansitxt_pat_irf = iconv('UTF-8', 'TIS-620', $strText_irf);
              $apifdh_ipd      = iconv('UTF-8', 'UTF-8', $strText_irf);
              fwrite($objFopen_opd_irf, $ansitxt_pat_irf);
              fwrite($fdh_irf, $apifdh_ipd);
          }
          fclose($objFopen_opd_irf);
          fclose($fdh_irf);
 
         //********************** 9.idx.txt ***************************//
         $file_d_idx       = "EXPORT_WALKIN/".$folder."/IDX.txt";
         $file_fdh_idx     = "EXPORT_WALKIN_API/".$folder."/IDX.txt";
         $objFopen_opd_idx = fopen($file_d_idx, 'w');
         $fdh_idx          = fopen($file_fdh_idx, 'w');
         $opd_head_idx     = 'AN|DIAG|DXTYPE|DRDX';
         fwrite($objFopen_opd_idx, $opd_head_idx);
         fwrite($fdh_idx, $opd_head_idx);
         $idx = DB::connection('mysql')->select('SELECT * from fdh_idx where d_anaconda_id = "WALKIN"');
         foreach ($idx as $key => $value9) {
             $h1 = $value9->AN;
             $h2 = $value9->DIAG;
             $h3 = $value9->DXTYPE;
             $h4 = $value9->DRDX; 
             $strText_idx     ="\r\n".$h1."|".$h2."|".$h3."|".$h4;
             $ansitxt_pat_idx = iconv('UTF-8', 'TIS-620', $strText_idx);
             $apifdh_ipd      = iconv('UTF-8', 'UTF-8', $strText_idx);
             fwrite($objFopen_opd_idx, $ansitxt_pat_idx);
             fwrite($fdh_idx, $apifdh_ipd);
         }
         fclose($objFopen_opd_idx);
         fclose($fdh_idx);
 
         //********************** 10 iop.txt ***************************//
         $file_d_iop       = "EXPORT_WALKIN/".$folder."/IOP.txt";
         $file_fdh_iop     = "EXPORT_WALKIN_API/".$folder."/IOP.txt";
         $objFopen_opd_iop = fopen($file_d_iop, 'w');
         $fdh_iop          = fopen($file_fdh_iop, 'w');
         $opd_head_iop     = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
         fwrite($objFopen_opd_iop, $opd_head_iop);
         fwrite($fdh_iop, $opd_head_iop);
         $iop = DB::connection('mysql')->select('SELECT * from fdh_iop where d_anaconda_id = "WALKIN"');
         foreach ($iop as $key => $value10) {
             $b1 = $value10->AN;
             $b2 = $value10->OPER;
             $b3 = $value10->OPTYPE;
             $b4 = $value10->DROPID;
             $b5 = $value10->DATEIN;
             $b6 = $value10->TIMEIN;
             $b7 = $value10->DATEOUT;
             $b8 = $value10->TIMEOUT;           
             $strText_iop     ="\r\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
             $ansitxt_pat_iop = iconv('UTF-8', 'TIS-620', $strText_iop);
             $apifdh_iop      = iconv('UTF-8', 'UTF-8', $strText_iop);
             fwrite($objFopen_opd_iop, $ansitxt_pat_iop);
             fwrite($fdh_iop, $apifdh_iop);
         }
         fclose($objFopen_opd_iop);
         fclose($fdh_iop);
 
         //********************** .11 cht.txt *****************************//
         $file_d_cht       = "EXPORT_WALKIN/".$folder."/CHT.txt";
         $file_fdh_cht     = "EXPORT_WALKIN_API/".$folder."/CHT.txt";
         $objFopen_opd_cht = fopen($file_d_cht, 'w');
         $fdh_cht          = fopen($file_fdh_cht, 'w');
         $opd_head_cht     = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ|OPD_MEMO|INVOICE_NO|INVOICE_LT';
         fwrite($objFopen_opd_cht, $opd_head_cht);
         fwrite($fdh_cht, $opd_head_cht);
         $cht = DB::connection('mysql')->select('SELECT * from fdh_cht where d_anaconda_id = "WALKIN"');
         foreach ($cht as $key => $value11) {
             $f1  = $value11->HN;
             $f2  = $value11->AN;
             $f3  = $value11->DATE;
             $f4  = $value11->TOTAL;
             $f5  = $value11->PAID;
             $f6  = $value11->PTTYPE;
             $f7  = $value11->PERSON_ID; 
             $f8  = $value11->SEQ;
             $f9  = $value11->OPD_MEMO;
             $f10 = $value11->INVOICE_NO;
             $f11 = $value11->INVOICE_LT;
             $strText_cht     ="\r\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8."|".$f9."|".$f10."|".$f11;
             $ansitxt_pat_cht = iconv('UTF-8', 'TIS-620', $strText_cht);
             $apifdh_cht      = iconv('UTF-8', 'UTF-8', $strText_cht);
             fwrite($objFopen_opd_cht, $ansitxt_pat_cht);
             fwrite($fdh_cht, $apifdh_cht);
         }
         fclose($objFopen_opd_cht);
         fclose($fdh_cht);
 
         //********************** .12 cha.txt *****************************//
         $file_d_cha       = "EXPORT_WALKIN/".$folder."/CHA.txt";
         $file_fdh_cha     = "EXPORT_WALKIN_API/".$folder."/CHA.txt";
         $objFopen_opd_cha = fopen($file_d_cha, 'w');
         $fdh_cha          = fopen($file_fdh_cha, 'w');
         $opd_head_cha     = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
         fwrite($objFopen_opd_cha, $opd_head_cha);
         fwrite($fdh_cha, $opd_head_cha);
         $cha = DB::connection('mysql')->select('SELECT * from fdh_cha where d_anaconda_id = "WALKIN"');
         foreach ($cha as $key => $value12) {
             $e1 = $value12->HN;
             $e2 = $value12->AN;
             $e3 = $value12->DATE;
             $e4 = $value12->CHRGITEM;
             $e5 = $value12->AMOUNT;
             $e6 = $value12->PERSON_ID;
             $e7 = $value12->SEQ; 
             $strText_cha     ="\r\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
             $ansitxt_pat_cha = iconv('UTF-8', 'TIS-620', $strText_cha);
             $apifdh_cha      = iconv('UTF-8', 'UTF-8', $strText_cha);
             fwrite($objFopen_opd_cha, $ansitxt_pat_cha);
             fwrite($fdh_cha, $apifdh_cha);
         }
         fclose($objFopen_opd_cha);
         fclose($fdh_cha);
 
         //************************ .13 aer.txt **********************************//
         $file_d_aer       = "EXPORT_WALKIN/".$folder."/AER.txt";
         $file_fdh_aer     = "EXPORT_WALKIN_API/".$folder."/AER.txt";
         $objFopen_opd_aer = fopen($file_d_aer, 'w');
         $fdh_aer          = fopen($file_fdh_aer, 'w');
         $opd_head_aer     = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
         fwrite($objFopen_opd_aer, $opd_head_aer);
         fwrite($fdh_aer, $opd_head_aer);
         $aer = DB::connection('mysql')->select('SELECT * from fdh_aer where d_anaconda_id = "WALKIN"');
         foreach ($aer as $key => $value13) {
             $d1 = $value13->HN;
             $d2 = $value13->AN;
             $d3 = $value13->DATEOPD;
             $d4 = $value13->AUTHAE;
             $d5 = $value13->AEDATE;
             $d6 = $value13->AETIME;
             $d7 = $value13->AETYPE;
             $d8 = $value13->REFER_NO;
             $d9 = $value13->REFMAINI;
             $d10 = $value13->IREFTYPE;
             $d11 = $value13->REFMAINO;
             $d12 = $value13->OREFTYPE;
             $d13 = $value13->UCAE;
             $d14 = $value13->EMTYPE;
             $d15 = $value13->SEQ;
             $d16 = $value13->AESTATUS;
             $d17 = $value13->DALERT;
             $d18 = $value13->TALERT;        
             $strText_aer     ="\r\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
             $ansitxt_pat_aer = iconv('UTF-8', 'TIS-620', $strText_aer);
             $apifdh_aer      = iconv('UTF-8', 'UTF-8', $strText_aer);
             fwrite($objFopen_opd_aer, $ansitxt_pat_aer);
             fwrite($fdh_aer, $apifdh_aer);
         }
         fclose($objFopen_opd_aer);
         fclose($fdh_aer);
 
         //************************ .14 adp.txt **********************************//
         $file_d_adp       = "EXPORT_WALKIN/".$folder."/ADP.txt";
         $file_fdh_adp     = "EXPORT_WALKIN_API/".$folder."/ADP.txt";
         $objFopen_opd_adp = fopen($file_d_adp, 'w');
         $fdh_adp          = fopen($file_fdh_adp, 'w');
         $opd_head_adp     = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
         fwrite($objFopen_opd_adp, $opd_head_adp);
         fwrite($fdh_adp, $opd_head_adp);
         $adp = DB::connection('mysql')->select('SELECT * from fdh_adp where d_anaconda_id = "WALKIN"');
         foreach ($adp as $key => $value14) {
             $c1 = $value14->HN;
             $c2 = $value14->AN;
             $c3 = $value14->DATEOPD;
             $c4 = $value14->TYPE;
             $c5 = $value14->CODE;
             $c6 = $value14->QTY;
             $c7 = $value14->RATE;
             $c8 = $value14->SEQ;
             $c9 = $value14->CAGCODE;
             $c10 = $value14->DOSE;
             $c11 = $value14->CA_TYPE;
             $c12 = $value14->SERIALNO;
             $c13 = $value14->TOTCOPAY;
             $c14 = $value14->USE_STATUS;
             $c15 = $value14->TOTAL;
             $c16 = $value14->QTYDAY;
             $c17 = $value14->TMLTCODE;
             $c18 = $value14->STATUS1;
             $c19 = $value14->BI;
             $c20 = $value14->CLINIC;
             $c21 = $value14->ITEMSRC;
             $c22 = $value14->PROVIDER;
             $c23 = $value14->GRAVIDA;
             $c24 = $value14->GA_WEEK;
             $c25 = $value14->DCIP;
             $c26 = $value14->LMP;
             $c27 = $value14->SP_ITEM;           
             $strText_adp ="\r\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
             $ansitxt_adp = iconv('UTF-8', 'TIS-620', $strText_adp);
             $apifdh_adp  = iconv('UTF-8', 'UTF-8', $strText_adp);
             fwrite($objFopen_opd_adp, $ansitxt_adp);
             fwrite($fdh_adp, $apifdh_adp);
         }
         fclose($objFopen_opd_adp); 
         fclose($fdh_adp); 
         //*********************** 15.dru.txt ****************************//
         $file_d_dru       = "EXPORT_WALKIN/".$folder."/DRU.txt";
         $file_fdh_dru     = "EXPORT_WALKIN_API/".$folder."/DRU.txt";
         $objFopen_opd_dru = fopen($file_d_dru, 'w');
         $fdh_dru          = fopen($file_fdh_dru, 'w');
         $opd_head_dru     = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
         fwrite($objFopen_opd_dru, $opd_head_dru);
         fwrite($fdh_dru, $opd_head_dru);
         $dru = DB::connection('mysql')->select('SELECT * from fdh_dru where d_anaconda_id = "WALKIN"');
         foreach ($dru as $key => $value15) {
             $g1 = $value15->HCODE;
             $g2 = $value15->HN;
             $g3 = $value15->AN;
             $g4 = $value15->CLINIC;
             $g5 = $value15->PERSON_ID;
             $g6 = $value15->DATE_SERV;
             $g7 = $value15->DID;
             $g8 = $value15->DIDNAME;
             $g9 = $value15->AMOUNT;
             $g10 = $value15->DRUGPRIC;
             $g11 = $value15->DRUGCOST;
             $g12 = $value15->DIDSTD;
             $g13 = $value15->UNIT;
             $g14 = $value15->UNIT_PACK;
             $g15 = $value15->SEQ;
             $g16 = $value15->DRUGREMARK;
             $g17 = $value15->PA_NO;
             $g18 = $value15->TOTCOPAY;
             $g19 = $value15->USE_STATUS;
             $g20 = $value15->TOTAL;
             $g21 = $value15->SIGCODE;
             $g22 = $value15->SIGTEXT;  
             $g23 = $value15->PROVIDER;   
             $g24 = $value15->SP_ITEM;   
             $strText_dru ="\r\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24;
             $ansitxt_dru = iconv('UTF-8', 'TIS-620', $strText_dru);
             $apifdh_dru  = iconv('UTF-8', 'UTF-8', $strText_dru);
             fwrite($objFopen_opd_dru, $ansitxt_dru);
             fwrite($fdh_dru, $apifdh_dru);
         }
         fclose($objFopen_opd_dru);
         fclose($fdh_dru);
         
         //************************* 16.lvd.txt *****************************//
         $file_d_lvd       = "EXPORT_WALKIN/".$folder."/LVD.txt";
         $file_fdh_lvd     = "EXPORT_WALKIN_API/".$folder."/LVD.txt";
         $objFopen_opd_lvd = fopen($file_d_lvd, 'w');
         $fdh_lvd          = fopen($file_fdh_lvd, 'w');
         $opd_head_lvd     = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
         fwrite($objFopen_opd_lvd, $opd_head_lvd);
         fwrite($fdh_lvd, $opd_head_lvd);
         $lvd = DB::connection('mysql')->select('SELECT * from fdh_lvd where d_anaconda_id = "WALKIN"');
         foreach ($lvd as $key => $value16) {
             $L1 = $value16->SEQLVD;
             $L2 = $value16->AN;
             $L3 = $value16->DATEOUT; 
             $L4 = $value16->TIMEOUT; 
             $L5 = $value16->DATEIN; 
             $L6 = $value16->TIMEIN; 
             $L7 = $value16->QTYDAY; 
             $strText_lvd ="\r\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
             $ansitxt_pat_lvd = iconv('UTF-8', 'TIS-620', $strText_lvd);
             $apifdh_lvd  = iconv('UTF-8', 'UTF-8', $strText_lvd);
             fwrite($objFopen_opd_lvd, $ansitxt_pat_lvd);
             fwrite($fdh_lvd, $apifdh_lvd);
         }
         fclose($objFopen_opd_lvd); 
         fclose($fdh_lvd);
 
         //*********************** 17.lab.txt **********************************//
        //  $file_d_lab = "EXPORT_WALKIN/".$folder."/LVD.txt";
        //  $file_fdh_lab = "EXPORT_WALKIN_API/".$folder."/LVD.txt";
        //  $objFopen_opd_lab = fopen($file_d_lab, 'w');
        //  $fdh_lab = fopen($file_fdh_lab, 'w');
        //  $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
        //  fwrite($objFopen_opd_lab, $opd_head_lab);
        //  fwrite($fdh_lab, $opd_head_lab);
        //  fclose($objFopen_opd_lab);
        //  fclose($fdh_lab);

        // $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "WALKIN"');
        // foreach ($dataexport_ as $key => $v_export) {
        //     $folder = $v_export->folder_name;
        // }
        // $filename = $folder . ".zip";
        // $zip = new ZipArchive;
        // if ($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE) {
        //     $files = File::files(public_path("EXPORT_WALKIN/" . $folder . "/"));
        //     foreach ($files as $key => $value) {
        //         $relativenameInZipFile = basename($value);
        //         $zip->addFile($value, $relativenameInZipFile);
        //     }
        //     $zip->close();
        // }
        // return response()->download(public_path($filename));
  
         return response()->json([
             'status'    => '200'
         ]);
    } 
    public function account_pkucs216_export(Request $request)
    { 
         #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('EXPORT_WALKIN'); //ทั้งหมด 
        $file->cleanDirectory('EXPORT_WALKIN_API'); //ทั้งหมด 
        $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "WALKIN"');
        foreach ($dataexport_ as $key => $v_export) {
            $folder_ = $v_export->folder_name;
        }
        $folder = $folder_;
         mkdir ('EXPORT_WALKIN/'.$folder, 0777, true);  //Web
         mkdir ('EXPORT_WALKIN_API/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"; charset=tis-620″ ;');

         //********** 1 ins.txt *****************//
        $file_d_ins       = "EXPORT_WALKIN/".$folder."/INS.txt";
        $file_fdh_ins       = "EXPORT_WALKIN_API/".$folder."/INS.txt";
        $objFopen_opd_ins = fopen($file_d_ins, 'w');
        $fdh_opd_ins      = fopen($file_fdh_ins, 'w');
        // $opd_head_ins = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';  // สปสช
        $opd_head_ins     = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';   // FDH
        fwrite($objFopen_opd_ins, $opd_head_ins);
        fwrite($fdh_opd_ins, $opd_head_ins);
        $ins = DB::connection('mysql')->select('SELECT * from fdh_ins where d_anaconda_id = "WALKIN"');
        foreach ($ins as $key => $value1) {
            $a1 = $value1->HN;
            $a2 = $value1->INSCL;
            $a3 = $value1->SUBTYPE;
            $a4 = $value1->CID;
            // $a5 = $value1->DATEIN;
            $a5 = $value1->HCODE;
            $a6 = $value1->DATEEXP;
            $a7 = $value1->HOSPMAIN;
            $a8 = $value1->HOSPSUB;
            $a9 = $value1->GOVCODE;
            $a10 = $value1->GOVNAME;
            $a11 = $value1->PERMITNO;
            $a12 = $value1->DOCNO;
            $a13 = $value1->OWNRPID;
            $a14 = $value1->OWNNAME;
            $a15 = $value1->AN;
            $a16 = $value1->SEQ;
            $a17 = $value1->SUBINSCL;
            $a18 = $value1->RELINSCL;
            $a19 = $value1->HTYPE;
            $strText_ins ="\r\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
            $ansitxt_ins = iconv('UTF-8', 'TIS-620', $strText_ins);
            $apifdh_ins = iconv('UTF-8', 'UTF-8', $strText_ins);

            fwrite($objFopen_opd_ins, $ansitxt_ins);
            fwrite($fdh_opd_ins, $apifdh_ins);
        }
        fclose($objFopen_opd_ins);
        fclose($fdh_opd_ins);

        //**********2 pat.txt ******************//
        $file_pat         = "EXPORT_WALKIN/".$folder."/PAT.txt";
        $file_fdh_pat     = "EXPORT_WALKIN_API/".$folder."/PAT.txt";
        $objFopen_opd_pat = fopen($file_pat, 'w');
        $fdh_opd_pat      = fopen($file_fdh_pat, 'w');
        $opd_head_pat     = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_opd_pat, $opd_head_pat);
        fwrite($fdh_opd_pat, $opd_head_pat);
        $pat = DB::connection('mysql')->select('SELECT * from fdh_pat where d_anaconda_id = "WALKIN"');
        foreach ($pat as $key => $value2) {
            $i1 = $value2->HCODE;
            $i2 = $value2->HN;
            $i3 = $value2->CHANGWAT;
            $i4 = $value2->AMPHUR;
            $i5 = $value2->DOB;
            $i6 = $value2->SEX;
            $i7 = $value2->MARRIAGE;
            $i8 = $value2->OCCUPA;
            $i9 = $value2->NATION;
            $i10 = $value2->PERSON_ID;
            $i11 = $value2->NAMEPAT;
            $i12 = $value2->TITLE;
            $i13 = $value2->FNAME;
            $i14 = $value2->LNAME;
            $i15 = $value2->IDTYPE;      
            $strText_pat="\r\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            $ansitxt_pat = iconv('UTF-8', 'UTF-8', $strText_pat);
            $apifdh_pat = iconv('UTF-8', 'UTF-8', $strText_pat);
            fwrite($objFopen_opd_pat, $ansitxt_pat);
            fwrite($fdh_opd_pat, $apifdh_pat);
        }
        fclose($objFopen_opd_pat);
        fclose($fdh_opd_pat);

        //************ 3 opd.txt *****************//
        $file_d_opd       = "EXPORT_WALKIN/".$folder."/OPD.txt";
        $file_fdh_opd     = "EXPORT_WALKIN_API/".$folder."/OPD.txt";
        $objFopen_opd_opd = fopen($file_d_opd, 'w');
        $fdh_opd          = fopen($file_fdh_opd, 'w');
        $opd_head_opd     = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        fwrite($objFopen_opd_opd, $opd_head_opd);
        fwrite($fdh_opd, $opd_head_opd);
        $opd = DB::connection('mysql')->select('SELECT * from fdh_opd where d_anaconda_id = "WALKIN"');
        foreach ($opd as $key => $value3) {
            $o1 = $value3->HN;
            $o2 = $value3->CLINIC;
            $o3 = $value3->DATEOPD; 
            $o4 = $value3->TIMEOPD; 
            $o5 = $value3->SEQ; 
            $o6 = $value3->UUC;  
            $o7 = $value3->DETAIL; 
            $o8 = $value3->BTEMP; 
            $o9 = $value3->SBP; 
            $o10 = $value3->DBP; 
            $o11 = $value3->PR; 
            $o12 = $value3->RR; 
            $o13 = $value3->OPTYPE; 
            $o14 = $value3->TYPEIN;
            $o15 = $value3->TYPEOUT;
            $strText_opd ="\r\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6."|".$o7."|".$o8."|".$o9."|".$o10."|".$o11."|".$o12."|".$o13."|".$o14."|".$o15;
            // $strText_opd="\r\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            $ansitxt_opd = iconv('UTF-8', 'TIS-620', $strText_opd);
            $apifdh_opd = iconv('UTF-8', 'UTF-8', $strText_opd);
            fwrite($objFopen_opd_opd, $ansitxt_opd);
            fwrite($fdh_opd, $apifdh_opd);
        }
        fclose($objFopen_opd_opd);
        fclose($fdh_opd);

        //****************** 4 orf.txt **************************//
        $file_d_orf       = "EXPORT_WALKIN/".$folder."/ORF.txt";
        $file_fdh_orf     = "EXPORT_WALKIN_API/".$folder."/ORF.txt";
        $objFopen_opd_orf = fopen($file_d_orf, 'w');
        $fdh_orf          = fopen($file_fdh_orf, 'w');
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
        fwrite($objFopen_opd_orf, $opd_head_orf);
        fwrite($fdh_orf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('SELECT * from fdh_orf where d_anaconda_id = "WALKIN"');
        foreach ($orf as $key => $value4) {
            $p1 = $value4->HN;
            $p2 = $value4->DATEOPD;
            $p3 = $value4->CLINIC; 
            $p4 = $value4->REFER; 
            $p5 = $value4->REFERTYPE; 
            $p6 = $value4->SEQ;  
            $strText_orf ="\r\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
            $ansitxt_orf = iconv('UTF-8', 'TIS-620', $strText_orf);
            $apifdh_orf = iconv('UTF-8', 'UTF-8', $strText_orf);
            fwrite($objFopen_opd_orf, $ansitxt_orf);
            fwrite($fdh_orf, $apifdh_orf);
        }
        fclose($objFopen_opd_orf);
        fclose($fdh_orf);

        //****************** 5 odx.txt **************************//
        $file_d_odx = "EXPORT_WALKIN/".$folder."/ODX.txt";
        $file_fdh_odx = "EXPORT_WALKIN_API/".$folder."/ODX.txt";
        $objFopen_opd_odx = fopen($file_d_odx, 'w');
        $objFopen_fdh_odx = fopen($file_fdh_odx, 'w');
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_opd_odx, $opd_head_odx);
        fwrite($objFopen_fdh_odx, $opd_head_odx);
        $odx = DB::connection('mysql')->select('SELECT * from fdh_odx where d_anaconda_id = "WALKIN"');
        foreach ($odx as $key => $value5) {
            $m1 = $value5->HN;
            $m2 = $value5->DATEDX;
            $m3 = $value5->CLINIC; 
            $m4 = $value5->DIAG; 
            $m5 = $value5->DXTYPE; 
            $m6 = $value5->DRDX; 
            $m7 = $value5->PERSON_ID; 
            $m8 = $value5->SEQ; 
            $strText_odx="\r\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            $ansitxt_odx = iconv('UTF-8', 'TIS-620', $strText_odx);
            $apifdh_odx = iconv('UTF-8', 'UTF-8', $strText_odx);
            fwrite($objFopen_opd_odx, $ansitxt_odx);
            fwrite($objFopen_fdh_odx, $apifdh_odx);
        }
        fclose($objFopen_opd_odx);
        fclose($objFopen_fdh_odx);

        //****************** 6.oop.txt ******************************//
        $file_d_oop = "EXPORT_WALKIN/".$folder."/OOP.txt";
        $file_fdh_oop = "EXPORT_WALKIN_API/".$folder."/OOP.txt";
        $objFopen_opd_oop = fopen($file_d_oop, 'w');
        $fdh_oop = fopen($file_fdh_oop, 'w');
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
        fwrite($objFopen_opd_oop, $opd_head_oop);
        fwrite($fdh_oop, $opd_head_oop);
        $oop = DB::connection('mysql')->select('SELECT * from fdh_oop where d_anaconda_id = "WALKIN"');
        foreach ($oop as $key => $value6) {
            $n1 = $value6->HN;
            $n2 = $value6->DATEOPD;
            $n3 = $value6->CLINIC; 
            $n4 = $value6->OPER; 
            $n5 = $value6->DROPID; 
            $n6 = $value6->PERSON_ID; 
            $n7 = $value6->SEQ;  
            $strText_oop="\r\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
            $ansitxt_oop = iconv('UTF-8', 'TIS-620', $strText_oop);
            $apifdh_oop = iconv('UTF-8', 'UTF-8', $strText_oop);
            fwrite($objFopen_opd_oop, $ansitxt_oop);
            fwrite($fdh_oop, $apifdh_oop);
        }
        fclose($objFopen_opd_oop);
        fclose($fdh_oop);

        //******************** 7.ipd.txt **************************//
        $file_d_ipd = "EXPORT_WALKIN/".$folder."/IPD.txt";
        $file_fdh_ipd = "EXPORT_WALKIN_API/".$folder."/IPD.txt";
        $objFopen_opd_ipd = fopen($file_d_ipd, 'w');
        $fdh_ipd = fopen($file_fdh_ipd, 'w');
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        fwrite($objFopen_opd_ipd, $opd_head_ipd);
        fwrite($fdh_ipd, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('SELECT * from fdh_ipd where d_anaconda_id = "WALKIN"');
        foreach ($ipd as $key => $value7) {
            $j1 = $value7->HN;
            $j2 = $value7->AN;
            $j3 = $value7->DATEADM;
            $j4 = $value7->TIMEADM;
            $j5 = $value7->DATEDSC;
            $j6 = $value7->TIMEDSC;
            $j7 = $value7->DISCHS;
            $j8 = $value7->DISCHT;
            $j9 = $value7->WARDDSC;
            $j10 = $value7->DEPT;
            $j11 = $value7->ADM_W;
            $j12 = $value7->UUC;
            $j13 = $value7->SVCTYPE;    
            $strText_ipd="\r\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            $ansitxt_pat_ipd = iconv('UTF-8', 'TIS-620', $strText_ipd);
            $apifdh_ipd = iconv('UTF-8', 'UTF-8', $strText_ipd);
            fwrite($objFopen_opd_ipd, $ansitxt_pat_ipd);
            fwrite($fdh_ipd, $apifdh_ipd);
        }
        fclose($objFopen_opd_ipd);
        fclose($fdh_ipd);

         //********************* 8.irf.txt ***************************//
         $file_d_irf = "EXPORT_WALKIN/".$folder."/IRF.txt";
         $file_fdh_irf = "EXPORT_WALKIN_API/".$folder."/IRF.txt";
         $objFopen_opd_irf = fopen($file_d_irf, 'w');
         $fdh_irf = fopen($file_fdh_irf, 'w');
         $opd_head_irf = 'AN|REFER|REFERTYPE';
         fwrite($objFopen_opd_irf, $opd_head_irf);
         fwrite($fdh_irf, $opd_head_irf);
         $irf = DB::connection('mysql')->select('SELECT * from fdh_irf where d_anaconda_id = "WALKIN"');
         foreach ($irf as $key => $value8) {
             $k1 = $value8->AN;
             $k2 = $value8->REFER;
             $k3 = $value8->REFERTYPE; 
             $strText_irf="\r\n".$k1."|".$k2."|".$k3;
             $ansitxt_pat_irf = iconv('UTF-8', 'TIS-620', $strText_irf);
             $apifdh_ipd = iconv('UTF-8', 'UTF-8', $strText_irf);
             fwrite($objFopen_opd_irf, $ansitxt_pat_irf);
             fwrite($fdh_irf, $apifdh_ipd);
         }
         fclose($objFopen_opd_irf);
         fclose($fdh_irf);

        //********************** 9.idx.txt ***************************//
        $file_d_idx = "EXPORT_WALKIN/".$folder."/IDX.txt";
        $file_fdh_idx = "EXPORT_WALKIN_API/".$folder."/IDX.txt";
        $objFopen_opd_idx = fopen($file_d_idx, 'w');
        $fdh_idx = fopen($file_fdh_idx, 'w');
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_opd_idx, $opd_head_idx);
        fwrite($fdh_idx, $opd_head_idx);
        $idx = DB::connection('mysql')->select('SELECT * from fdh_idx where d_anaconda_id = "WALKIN"');
        foreach ($idx as $key => $value9) {
            $h1 = $value9->AN;
            $h2 = $value9->DIAG;
            $h3 = $value9->DXTYPE;
            $h4 = $value9->DRDX; 
            $strText_idx="\r\n".$h1."|".$h2."|".$h3."|".$h4;
            $ansitxt_pat_idx = iconv('UTF-8', 'TIS-620', $strText_idx);
            $apifdh_ipd = iconv('UTF-8', 'UTF-8', $strText_idx);
            fwrite($objFopen_opd_idx, $ansitxt_pat_idx);
            fwrite($fdh_idx, $apifdh_ipd);
        }
        fclose($objFopen_opd_idx);
        fclose($fdh_idx);

        //********************** 10 iop.txt ***************************//
        $file_d_iop = "EXPORT_WALKIN/".$folder."/IOP.txt";
        $file_fdh_iop = "EXPORT_WALKIN_API/".$folder."/IOP.txt";
        $objFopen_opd_iop = fopen($file_d_iop, 'w');
        $fdh_iop = fopen($file_fdh_iop, 'w');
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        fwrite($objFopen_opd_iop, $opd_head_iop);
        fwrite($fdh_iop, $opd_head_iop);
        $iop = DB::connection('mysql')->select('SELECT * from fdh_iop where d_anaconda_id = "WALKIN"');
        foreach ($iop as $key => $value10) {
            $b1 = $value10->AN;
            $b2 = $value10->OPER;
            $b3 = $value10->OPTYPE;
            $b4 = $value10->DROPID;
            $b5 = $value10->DATEIN;
            $b6 = $value10->TIMEIN;
            $b7 = $value10->DATEOUT;
            $b8 = $value10->TIMEOUT;           
            $strText_iop ="\r\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
            $ansitxt_pat_iop = iconv('UTF-8', 'TIS-620', $strText_iop);
            $apifdh_iop = iconv('UTF-8', 'UTF-8', $strText_iop);
            fwrite($objFopen_opd_iop, $ansitxt_pat_iop);
            fwrite($fdh_iop, $apifdh_iop);
        }
        fclose($objFopen_opd_iop);
        fclose($fdh_iop);

        //********************** .11 cht.txt *****************************//
        $file_d_cht = "EXPORT_WALKIN/".$folder."/CHT.txt";
        $file_fdh_cht = "EXPORT_WALKIN_API/".$folder."/CHT.txt";
        $objFopen_opd_cht = fopen($file_d_cht, 'w');
        $fdh_cht = fopen($file_fdh_cht, 'w');
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ|OPD_MEMO|INVOICE_NO|INVOICE_LT';
        fwrite($objFopen_opd_cht, $opd_head_cht);
        fwrite($fdh_cht, $opd_head_cht);
        $cht = DB::connection('mysql')->select('SELECT * from fdh_cht where d_anaconda_id = "WALKIN"');
        foreach ($cht as $key => $value11) {
            $f1 = $value11->HN;
            $f2 = $value11->AN;
            $f3 = $value11->DATE;
            $f4 = $value11->TOTAL;
            $f5 = $value11->PAID;
            $f6 = $value11->PTTYPE;
            $f7 = $value11->PERSON_ID; 
            $f8 = $value11->SEQ;
            $f9 = $value11->OPD_MEMO;
            $f10 = $value11->INVOICE_NO;
            $f11 = $value11->INVOICE_LT;
            $strText_cht="\r\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8."|".$f9."|".$f10."|".$f11;
            $ansitxt_pat_cht = iconv('UTF-8', 'TIS-620', $strText_cht);
            $apifdh_cht = iconv('UTF-8', 'UTF-8', $strText_cht);
            fwrite($objFopen_opd_cht, $ansitxt_pat_cht);
            fwrite($fdh_cht, $apifdh_cht);
        }
        fclose($objFopen_opd_cht);
        fclose($fdh_cht);

        //********************** .12 cha.txt *****************************//
        $file_d_cha = "EXPORT_WALKIN/".$folder."/CHA.txt";
        $file_fdh_cha = "EXPORT_WALKIN_API/".$folder."/CHA.txt";
        $objFopen_opd_cha = fopen($file_d_cha, 'w');
        $fdh_cha = fopen($file_fdh_cha, 'w');
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        fwrite($objFopen_opd_cha, $opd_head_cha);
        fwrite($fdh_cha, $opd_head_cha);
        $cha = DB::connection('mysql')->select('SELECT * from fdh_cha where d_anaconda_id = "WALKIN"');
        foreach ($cha as $key => $value12) {
            $e1 = $value12->HN;
            $e2 = $value12->AN;
            $e3 = $value12->DATE;
            $e4 = $value12->CHRGITEM;
            $e5 = $value12->AMOUNT;
            $e6 = $value12->PERSON_ID;
            $e7 = $value12->SEQ; 
            $strText_cha="\r\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
            $ansitxt_pat_cha = iconv('UTF-8', 'TIS-620', $strText_cha);
            $apifdh_cha = iconv('UTF-8', 'UTF-8', $strText_cha);
            fwrite($objFopen_opd_cha, $ansitxt_pat_cha);
            fwrite($fdh_cha, $apifdh_cha);
        }
        fclose($objFopen_opd_cha);
        fclose($fdh_cha);

        //************************ .13 aer.txt **********************************//
        $file_d_aer = "EXPORT_WALKIN/".$folder."/AER.txt";
        $file_fdh_aer = "EXPORT_WALKIN_API/".$folder."/AER.txt";
        $objFopen_opd_aer = fopen($file_d_aer, 'w');
        $fdh_aer = fopen($file_fdh_aer, 'w');
        $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        fwrite($objFopen_opd_aer, $opd_head_aer);
        fwrite($fdh_aer, $opd_head_aer);
        $aer = DB::connection('mysql')->select('SELECT * from fdh_aer where d_anaconda_id = "WALKIN"');
        foreach ($aer as $key => $value13) {
            $d1 = $value13->HN;
            $d2 = $value13->AN;
            $d3 = $value13->DATEOPD;
            $d4 = $value13->AUTHAE;
            $d5 = $value13->AEDATE;
            $d6 = $value13->AETIME;
            $d7 = $value13->AETYPE;
            $d8 = $value13->REFER_NO;
            $d9 = $value13->REFMAINI;
            $d10 = $value13->IREFTYPE;
            $d11 = $value13->REFMAINO;
            $d12 = $value13->OREFTYPE;
            $d13 = $value13->UCAE;
            $d14 = $value13->EMTYPE;
            $d15 = $value13->SEQ;
            $d16 = $value13->AESTATUS;
            $d17 = $value13->DALERT;
            $d18 = $value13->TALERT;        
            $strText_aer="\r\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
            $ansitxt_pat_aer = iconv('UTF-8', 'TIS-620', $strText_aer);
            $apifdh_aer = iconv('UTF-8', 'UTF-8', $strText_aer);
            fwrite($objFopen_opd_aer, $ansitxt_pat_aer);
            fwrite($fdh_aer, $apifdh_aer);
        }
        fclose($objFopen_opd_aer);
        fclose($fdh_aer);

        //************************ .14 adp.txt **********************************//
        $file_d_adp = "EXPORT_WALKIN/".$folder."/ADP.txt";
        $file_fdh_adp = "EXPORT_WALKIN_API/".$folder."/ADP.txt";
        $objFopen_opd_adp = fopen($file_d_adp, 'w');
        $fdh_adp = fopen($file_fdh_adp, 'w');
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        fwrite($objFopen_opd_adp, $opd_head_adp);
        fwrite($fdh_adp, $opd_head_adp);
        $adp = DB::connection('mysql')->select('SELECT * from fdh_adp where d_anaconda_id = "WALKIN"');
        foreach ($adp as $key => $value14) {
            $c1 = $value14->HN;
            $c2 = $value14->AN;
            $c3 = $value14->DATEOPD;
            $c4 = $value14->TYPE;
            $c5 = $value14->CODE;
            $c6 = $value14->QTY;
            $c7 = $value14->RATE;
            $c8 = $value14->SEQ;
            $c9 = $value14->CAGCODE;
            $c10 = $value14->DOSE;
            $c11 = $value14->CA_TYPE;
            $c12 = $value14->SERIALNO;
            $c13 = $value14->TOTCOPAY;
            $c14 = $value14->USE_STATUS;
            $c15 = $value14->TOTAL;
            $c16 = $value14->QTYDAY;
            $c17 = $value14->TMLTCODE;
            $c18 = $value14->STATUS1;
            $c19 = $value14->BI;
            $c20 = $value14->CLINIC;
            $c21 = $value14->ITEMSRC;
            $c22 = $value14->PROVIDER;
            $c23 = $value14->GRAVIDA;
            $c24 = $value14->GA_WEEK;
            $c25 = $value14->DCIP;
            $c26 = $value14->LMP;
            $c27 = $value14->SP_ITEM;           
            $strText_adp ="\r\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            $ansitxt_adp = iconv('UTF-8', 'TIS-620', $strText_adp);
            $apifdh_adp = iconv('UTF-8', 'UTF-8', $strText_adp);
            fwrite($objFopen_opd_adp, $ansitxt_adp);
            fwrite($fdh_adp, $apifdh_adp);
        }
        fclose($objFopen_opd_adp); 
        fclose($fdh_adp); 
        //*********************** 15.dru.txt ****************************//
        $file_d_dru       = "EXPORT_WALKIN/".$folder."/DRU.txt";
        $file_fdh_dru     = "EXPORT_WALKIN_API/".$folder."/DRU.txt";
        $objFopen_opd_dru = fopen($file_d_dru, 'w');
        $fdh_dru          = fopen($file_fdh_dru, 'w');
        $opd_head_dru     = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        fwrite($objFopen_opd_dru, $opd_head_dru);
        fwrite($fdh_dru, $opd_head_dru);
        $dru = DB::connection('mysql')->select('SELECT * from fdh_dru where d_anaconda_id = "WALKIN"');
        foreach ($dru as $key => $value15) {
            $g1 = $value15->HCODE;
            $g2 = $value15->HN;
            $g3 = $value15->AN;
            $g4 = $value15->CLINIC;
            $g5 = $value15->PERSON_ID;
            $g6 = $value15->DATE_SERV;
            $g7 = $value15->DID;
            $g8 = $value15->DIDNAME;
            $g9 = $value15->AMOUNT;
            $g10 = $value15->DRUGPRIC;
            $g11 = $value15->DRUGCOST;
            $g12 = $value15->DIDSTD;
            $g13 = $value15->UNIT;
            $g14 = $value15->UNIT_PACK;
            $g15 = $value15->SEQ;
            $g16 = $value15->DRUGREMARK;
            $g17 = $value15->PA_NO;
            $g18 = $value15->TOTCOPAY;
            $g19 = $value15->USE_STATUS;
            $g20 = $value15->TOTAL;
            $g21 = $value15->SIGCODE;
            $g22 = $value15->SIGTEXT;  
            $g23 = $value15->PROVIDER;   
            $g24 = $value15->SP_ITEM;   
            $strText_dru ="\r\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24;
            $ansitxt_dru = iconv('UTF-8', 'TIS-620', $strText_dru);
            $apifdh_dru  = iconv('UTF-8', 'UTF-8', $strText_dru);
            fwrite($objFopen_opd_dru, $ansitxt_dru);
            fwrite($fdh_dru, $apifdh_dru);
        }
        fclose($objFopen_opd_dru);
        fclose($fdh_dru);
        
        //16 dru.txt
        // $file_d_dru = "Export_OFC_API/".$folder."/DRU.txt";
        // // $objFopen_dru = fopen($file_d_dru, 'w');
        // $objFopen_dru_utf = fopen($file_d_dru, 'w');
        // $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRICE|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER';
        // // fwrite($objFopen_dru, $opd_head_dru);
        // fwrite($objFopen_dru_utf, $opd_head_dru);
        // $dru = DB::connection('mysql')->select('
        //     SELECT * from d_dru where d_anaconda_id = "OFC_401"
        // ');
        // foreach ($dru as $key => $value7) {
        //     $g1 = $value7->HCODE;
        //     $g2 = $value7->HN;
        //     $g3 = $value7->AN;
        //     $g4 = $value7->CLINIC;
        //     $g5 = $value7->PERSON_ID;
        //     $g6 = $value7->DATE_SERV;
        //     $g7 = $value7->DID;
        //     $g8 = $value7->DIDNAME;
        //     $g9 = $value7->AMOUNT;
        //     $g10 = $value7->DRUGPRICE;
        //     $g11 = $value7->DRUGCOST;
        //     $g12 = $value7->DIDSTD;
        //     $g13 = $value7->UNIT;
        //     $g14 = $value7->UNIT_PACK;
        //     $g15 = $value7->SEQ;
        //     // $g16 = $value7->DRUGTYPE;
        //     $g16 = $value7->DRUGREMARK;
        //     $g17 = $value7->PA_NO;
        //     $g18 = $value7->TOTCOPAY;
        //     $g19 = $value7->USE_STATUS;
        //     $g20 = $value7->TOTAL;
        //     $g21 = $value7->SIGCODE;
        //     $g22 = $value7->SIGTEXT;  
        //     $g23 = $value7->PROVIDER; 
        //     // $g25 = $value7->SP_ITEM;      
        //     $str_dru="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23;
        //     // $ansitxt_dru = iconv('UTF-8', 'TIS-620', $str_dru);
        //     $ansitxt_dru_utf = iconv('UTF-8', 'UTF-8', $str_dru);
        //     // fwrite($objFopen_dru, $ansitxt_dru);
        //     fwrite($objFopen_dru_utf, $ansitxt_dru_utf);
        // }

        //************************* 16.lvd.txt *****************************//
        $file_d_lvd       = "EXPORT_WALKIN/".$folder."/LVD.txt";
        $file_fdh_lvd     = "EXPORT_WALKIN_API/".$folder."/LVD.txt";
        $objFopen_opd_lvd = fopen($file_d_lvd, 'w');
        $fdh_lvd          = fopen($file_fdh_lvd, 'w');
        $opd_head_lvd     = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        fwrite($objFopen_opd_lvd, $opd_head_lvd);
        fwrite($fdh_lvd, $opd_head_lvd);
        $lvd = DB::connection('mysql')->select('SELECT * from fdh_lvd where d_anaconda_id = "WALKIN"');
        foreach ($lvd as $key => $value16) {
            $L1 = $value16->SEQLVD;
            $L2 = $value16->AN;
            $L3 = $value16->DATEOUT; 
            $L4 = $value16->TIMEOUT; 
            $L5 = $value16->DATEIN; 
            $L6 = $value16->TIMEIN; 
            $L7 = $value16->QTYDAY; 
            $strText_lvd ="\r\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
            $ansitxt_pat_lvd = iconv('UTF-8', 'TIS-620', $strText_lvd);
            $apifdh_lvd  = iconv('UTF-8', 'UTF-8', $strText_lvd);
            fwrite($objFopen_opd_lvd, $ansitxt_pat_lvd);
            fwrite($fdh_lvd, $apifdh_lvd);
        }
        fclose($objFopen_opd_lvd); 
        fclose($fdh_lvd);

        //*********************** 17.lab.txt **********************************//
        $file_d_lab = "EXPORT_WALKIN/".$folder."/LAB.txt";
        $file_fdh_lab = "EXPORT_WALKIN_API/".$folder."/LAB.txt";
        $objFopen_opd_lab = fopen($file_d_lab, 'w');
        $fdh_lab = fopen($file_fdh_lab, 'w');
        $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
        fwrite($objFopen_opd_lab, $opd_head_lab);
        fwrite($fdh_lab, $opd_head_lab);
        fclose($objFopen_opd_lab);
        fclose($fdh_lab);


        $pathdir =  "Export_WALKIN/".$folder."/";
        $zipcreated = $folder.".zip";

        $newzip = new ZipArchive;
        if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
        $dir = opendir($pathdir);
        
        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
                $newzip -> addFile($pathdir.$file, $file);
            }
        }
        $newzip ->close();
                if (file_exists($zipcreated)) {
                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="'.basename($zipcreated).'"');
                    header('Content-Length: ' . filesize($zipcreated));
                    flush();
                    readfile($zipcreated); 
                    unlink($zipcreated);   
                    $files = glob($pathdir . '/*');   
                    foreach($files as $file) {   
                        if(is_file($file)) {      
                            // unlink($file); 
                        } 
                    }                      
                    return redirect()->route('acc.account_pkucs216_pull');                    
                }
        } 

        return redirect()->route('acc.account_pkucs216_pull');

    }
    public function account_pkucs216_zip (Request $request)
    {
        $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "WALKIN"');
        foreach ($dataexport_ as $key => $v_export) {
            $folder = $v_export->folder_name;
        }
        $filename = $folder . ".zip";
        $zip = new ZipArchive;
        if ($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path("EXPORT_WALKIN/" . $folder . "/"));
            foreach ($files as $key => $value) {
                $relativenameInZipFile = basename($value);
                $zip->addFile($value, $relativenameInZipFile);
            }
            $zip->close();
        }
        return response()->download(public_path($filename));
      
    }
    public function account_pkucs216_sendapi_(Request $request)
    {  
        // $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" AND user_id = "'.Auth::user()->id.'"');
        // foreach ($data_token_ as $key => $val_to) {
        //     $token_   = $val_to->api_neweclaim_token;
        // }
        $username        = 'pradit.10978';
        $password        = '8Uk&8Fr&';
        $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));
        $basic_auth = base64_encode("$username:$password");
        $context = stream_context_create(array(
            'http' => array(
                'header' => "Authorization: Basic ".base64_encode("$username:$password")
            )
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
            ),
        ));
        $token = curl_exec($curl);
        // dd($token); 
        // $fdh_jwt = $token;
        $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "WALKIN"');
        foreach ($dataexport_ as $key => $v_export) {
            $folder = $v_export->folder_name;
        }
        // $pathdir_fdh_utf8 = "EXPORT_WALKIN_API/".$folder."_fdh_utf8/";
        $pathdir_fdh_utf8 = "EXPORT_WALKIN_API/".$folder. "/";
        // $pathdir_fdh_utf8 = "EXPORT_WALKIN_API/".$folder."/";
        // $files_fdh_utf8 = glob($pathdir_fdh_utf8 . '/*'); 
       
            // $client = new Client(); //GuzzleHttp\Client
            // $headers = [
            //     'Authorization' => 'Bearer '.$fdh_jwt
            // ];
            // dd($pathdir_fdh_utf8);
            //Create Client object to deal with
            // $client = new Client();
                
            $options = [
                'multipart' => [
                        [
                            'name' => 'type',
                            'contents' => 'txt'
                        ],                             
                        [
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'OPD.txt'),
                            'filename' => 'OPD.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],
                        [
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ORF.txt'),
                            'filename' => 'ORF.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ODX.txt'),
                            'filename' => 'ODX.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'OOP.txt'),
                            'filename' => 'OOP.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'CHA.txt'),
                            'filename' => 'CHA.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ADP.txt'),
                            'filename' => 'ADP.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'INS.txt'),
                            'filename' => 'INS.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'PAT.txt'),
                            'filename' => 'PAT.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'CHT.txt'),
                            'filename' => 'CHT.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'AER.txt'),
                            'filename' => 'AER.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'DRU.txt'),
                            'filename' => 'DRU.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ]
                     ]
                ];
            // dd($options);
            // Define the request parameters  API นำเข้า 16 แฟ้ม แบบมีหัวคอลัมน์
            $url = "https://fdh.moph.go.th/api/v2/data_hub/16_files";
            // $headers = [
            //     'Content-Type' => 'application/json',
            // ];
            $headers = [ 
                "Authorization" => "Bearer " . $token
            ];            
            // POST request using the created object
            // $response = $client->post($url, [
            //     'headers' => $headers,
            //     'json'    => $options,
            // ]);
            // dd($response);

            // $client = new Client(); //GuzzleHttp\Client
            // $response = $client->post('https://fdh.moph.go.th/api/v2/data_hub/16_files', $headers ,[
            //     'multipart' => [
            //         [
            //             'name' => 'type',
            //             'contents' => 'txt'
            //         ],                             
            //         [
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'OPD.txt'),
            //             'filename' => 'OPD.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],
            //         [
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'ORF.txt'),
            //             'filename' => 'ORF.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'ODX.txt'),
            //             'filename' => 'ODX.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'OOP.txt'),
            //             'filename' => 'OOP.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'CHA.txt'),
            //             'filename' => 'CHA.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'ADP.txt'),
            //             'filename' => 'ADP.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'INS.txt'),
            //             'filename' => 'INS.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'PAT.txt'),
            //             'filename' => 'PAT.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'CHT.txt'),
            //             'filename' => 'CHT.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'AER.txt'),
            //             'filename' => 'AER.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ],[
            //             'name' => 'file',
            //             'contents' => file_get_contents($pathdir_fdh_utf8.'DRU.txt'),
            //             'filename' => 'DRU.txt',
            //             'headers' => [
            //                 'Content-Type' => 'text/plain'
            //             ]
            //         ]
            //     ]
            // ]);
            // $responseCode = $response->getStatusCode();
            // dd($responseCode);
            $response = Http::withHeaders([ 
                // 'Authorization' => 'Bearer' . $token
                'Authorization' => 'Bearer' . $token
            ])->post("https://fdh.moph.go.th/api/v2/data_hub/16_files",
                [ 
                    'multipart' => [
                        [
                            'name' => 'type',
                            'contents' => 'txt'
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'OPD.txt'),
                            'filename' => 'OPD.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ORF.txt'),
                            'filename' => 'ORF.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ODX.txt'),
                            'filename' => 'ODX.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'OOP.txt'),
                            'filename' => 'OOP.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'CHA.txt'),
                            'filename' => 'CHA.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'ADP.txt'),
                            'filename' => 'ADP.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'INS.txt'),
                            'filename' => 'INS.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'PAT.txt'),
                            'filename' => 'PAT.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'CHT.txt'),
                            'filename' => 'CHT.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'AER.txt'),
                            'filename' => 'AER.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ],[
                            'name' => 'file',
                            'contents' => file_get_contents($pathdir_fdh_utf8.'DRU.txt'),
                            'filename' => 'DRU.txt',
                            'headers' => [
                                'Content-Type' => 'text/plain'
                            ]
                        ]
                     ]
            ]);
            dd($response);
            $responseCode = $response->getStatusCode();
            dd($responseCode);
            // $response = $client->request('POST', $url, [
            //     // 'form_params' => [
            //     //     'field_name' => 'abc',
            //     //     'other_field' => '123',
            //     //     'nested_field' => [
            //     //         'nested' => 'hello'
            //     //     ]
            //     // ]
            //     'multipart' => [
            //         [
            //              'name' => 'type',
            //              'contents' => 'txt'
            //         ],                         
            //              [
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'OPD.txt'),
            //                   'filename' => 'OPD.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],
            //              [
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'ORF.txt'),
            //                   'filename' => 'ORF.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'ODX.txt'),
            //                   'filename' => 'ODX.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'OOP.txt'),
            //                   'filename' => 'OOP.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'CHA.txt'),
            //                   'filename' => 'CHA.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'ADP.txt'),
            //                   'filename' => 'ADP.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'INS.txt'),
            //                   'filename' => 'INS.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'PAT.txt'),
            //                   'filename' => 'PAT.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'CHT.txt'),
            //                   'filename' => 'CHT.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'AER.txt'),
            //                   'filename' => 'AER.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ],[
            //                   'name' => 'file',
            //                   'contents' => file_get_contents($pathdir_fdh_utf8.'DRU.txt'),
            //                   'filename' => 'DRU.txt',
            //                   'headers' => [
            //                        'Content-Type' => 'text/plain'
            //                   ]
            //              ]
            //         ]
            // ]);
            // dd($response);
            // // Get the response code
            // $responseCode = $response->getStatusCode();
            // dd($responseCode);
            // return response()->json(['response_code' => $responseCode]);
            #สำหรับทดสอบ  https://uat-fdh.inet.co.th/api/v1/data_hub/16_files
            #Product      https://fdh.moph.go.th/api/v1/data_hub/16_files
            #v1 = API นำเข้า 16 แฟ้ม แบบไม่มีหัวคอลัมน์
            #v2 = API นำเข้า 16 แฟ้ม แบบมีหัวคอลัมน์
            #$request = new Request('POST', 'https://uat-fdh.inet.co.th/api/v1/data_hub/16_files', $headers);
            // $request = new Request('POST', $url, $headers);

            // try {
            //     $response = $client->send($request, $options); 
            //     $response_gb = $response->getBody();
            //     $result_send_fame_outp = json_decode($response_gb, true);
            //     #echo "try";
            // } catch (\GuzzleHttp\Exception\RequestException $e) {
            //     if ($e->hasResponse()) {
            //         $errorResponse = json_decode($e->getResponse()->getBody(), true);
            //         json_encode($errorResponse, JSON_PRETTY_PRINT);
            //         #echo "if";
            //     } else {
            //         json_encode(['error' => 'Unknown error occurred'], JSON_PRETTY_PRINT);
            //         #echo "else";
            //     }
            // }
            // #ส่ง api
            // if (@$result_send_fame_outp['status']=='200') {
            //     return response()->json([
            //         'status'    => '200'
            //     ]);
            // } else {
            //     # code...
            // }
            
 
        // return response()->json([
        //     'status'    => '200'
        // ]);
   } 
 }