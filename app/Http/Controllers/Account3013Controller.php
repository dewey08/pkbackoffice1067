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
use App\Models\Acc_1102050101_3013;

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


class Account3013Controller extends Controller
 {
    // ***************** 3013********************************
     
    public function account_3011_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $acc_trimart_id = $request->acc_trimart_id;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 
       
        $data_ = DB::table('acc_trimart')->where('acc_trimart_id','=',$acc_trimart_id)->first();
        
       if ($acc_trimart_id == '') {
            $data_trimart = DB::table('acc_trimart')->where('active','Y')->limit(12)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
       } else {
            // $data_trimart = DB::table('acc_trimart')->whereBetween('dchdate', [$startdate, $enddate])->orderBy('acc_trimart_id','desc')->get();
            $data_trimart = DB::table('acc_trimart')->where('active','Y')->where('acc_trimart_id','=',$acc_trimart_id)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
       }       

        return view('account_3011.account_3011_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'data_trimart'     => $data_trimart,
            'newyear'          => $newyear,
            'date'             => $date,
            'trimart'          => $trimart,
        ]);
    }
       
    public function account_3013_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // if ($startdate == '') { 
        //     $acc_debtor = DB::select('
        //         SELECT a.*,c.subinscl from acc_debtor a 
        //         left join checksit_hos c on c.vn = a.vn
        //         WHERE a.account_code="1102050101.3013"
        //         AND a.stamp = "N"
        //         group by a.vn
        //         order by a.vstdate desc
        //     ');
        //     // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        // } else {
            $acc_debtor = DB::select('
                SELECT a.* FROM acc_debtor a
            
                WHERE a.account_code="1102050101.3013"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate desc
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        // }

        return view('account_3013.account_3013_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_3013_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;

        $type = DB::connection('mysql')->select('
            SELECT pttype from acc_setpang_type WHERE pttype IN (SELECT pttype FROM acc_setpang_type WHERE pang ="1102050101.301")
        ');
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql2')->select(
            'SELECT v.vn,o.hn,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
            ,v.vstdate ,o.vsttime ,v.hospmain,op.income as income_group ,pt.pttype_eclaim_id ,vp.pttype,pt.max_debt_money,v.pdx
            ,"" as acc_code ,"1102050101.3013" as account_code,"ลูกหนี้ค่ารักษาประกันสังคม - OP CT" as account_name ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money ,v.rcpno_list as rcpno
            ,v.income-v.discount_money-v.rcpt_money as debit
            ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
            ,sum(if(op.income="02",sum_price,0)) as debit_instument
            ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
            ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
            ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
            ,(SELECT SUM(o.sum_price) FROM opitemrece o LEFT JOIN nondrugitems n on n.icode = o.icode WHERE o.vn=v.vn AND o.pttype="A7" AND (n.billcode like "8%" OR n.billcode ="2509") and n.billcode not in ("8608","8307") and o.an is null) as debit_ins_sss
            
            ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3009142") AND vn = v.vn) as ct_Addi3d
            ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3009143") AND vn = v.vn) as ct_Addi
            
            ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3009148","3009147") AND vn = v.vn) THEN "1200" 
            ELSE "0.00" 
            END as ct_brain

            ,CASE WHEN (SELECT SUM(ot.sum_price) as sum_price FROM opitemrece ot WHERE ot.vn =v.vn AND ot.icode IN(SELECT icode FROM xray_items WHERE xray_items_group ="3" AND icode <> "") AND icode NOT IN("3009148","3009147","3009143")) THEN 
            (SELECT COUNT(ot.icode) as ovn FROM opitemrece ot WHERE ot.vn =v.vn AND ot.icode IN(SELECT icode FROM xray_items WHERE xray_items_group ="3" AND icode <> "") AND icode NOT IN("3009148","3009147","3009143","3011265","3009197","3011266")) * 2500 
            ELSE "0.00" 
            END as ct_orther

            ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3011265","3009197","3011266") AND vn = v.vn) THEN "1100" 
            ELSE "0.00" 
            END as debit_drug_ct 

            ,CASE WHEN (SELECT COUNT(DISTINCT oi.vn) as ovn FROM opitemrece oi 
            LEFT JOIN s_drugitems nd ON nd.icode = oi.icode 
            WHERE nd.name LIKE "%CT%" AND oi.income = "08" AND oi.vn = v.vn) 
            THEN SUM(sum_price)
            ELSE "0.00" 
            END as debit_ct_price

            -- ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3011265","3011266","3009197") AND vn = v.vn) THEN "1100" 
            -- ELSE "0.00" 
            -- END as debit_drug100_50

            -- ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3011266" AND vn = v.vn) THEN "1100" 
            -- ELSE "0.00" 
            -- END as debit_drug150

            ,(SELECT SUM(ot.sum_price) FROM opitemrece ot WHERE EXISTS (SELECT icode FROM xray_items WHERE icode = ot.icode AND xray_items_group ="3") AND vn =v.vn) as debit_ct_sss
            ,CASE
                WHEN (v.uc_money-(SELECT SUM(ot.sum_price) FROM opitemrece ot WHERE ot.vn =v.vn AND ot.icode IN(SELECT icode FROM xray_items WHERE xray_items_group ="3" AND icode <> ""))) < 700 
                THEN (v.uc_money-(SELECT SUM(ot.sum_price) FROM opitemrece ot WHERE ot.vn =v.vn AND ot.icode IN(SELECT icode FROM xray_items WHERE xray_items_group ="3" AND icode <> "")))
                WHEN v.uc_money < 700 then v.uc_money
                ELSE "700"
            END as toklong

            FROM ovst o
            LEFT JOIN vn_stat v on v.vn=o.vn
            LEFT JOIN visit_pttype vp on vp.vn = v.vn
            LEFT JOIN patient p on p.hn = o.hn
            LEFT JOIN pttype pt on o.pttype=pt.pttype
            LEFT JOIN pttype_eclaim e on e.code = pt.pttype_eclaim_id
            LEFT JOIN opitemrece op ON op.vn = o.vn
            WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND vp.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.3013" AND pttype IS NOT NULL)               
            AND op.icode NOT IN("3011265","3011266","3009819","3009820","3009182","3009152")
            AND op.income = "08"
            AND (o.an="" or o.an is null) 
            GROUP BY v.vn
        ');
        

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.3013')->count(); 
                    if ($check > 0) {
                                                          
                    } else {
                        
                            if ($value->debit_ct_sss > 0) { 
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    // 'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->ptname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate, 
                                    'hospmain'           => $value->hospmain, 
                                    'pdx'                => $value->pdx,  
                                    'account_code'       => $value->account_code, 
                                    'account_name'       => $value->account_name, 
                                    'income'             => $value->income,
                                    'uc_money'           => $value->uc_money,
                                    'discount_money'     => $value->discount_money,
                                    'paid_money'         => $value->paid_money,
                                    'rcpt_money'         => $value->rcpt_money,
                                    'debit'              => $value->debit,
                                    'debit_drug'         => $value->debit_drug,
                                    'debit_instument'    => $value->debit_instument,
                                    'debit_toa'          => $value->debit_toa,
                                    'debit_refer'        => $value->debit_refer, 
                                    'fokliad'            => $value->fokliad, 
                                    'debit_total'        => $value->debit_ct_sss,
                                    'debit_ins_sss'      => $value->debit_ins_sss,
                                    'debit_ct_sss'       => $value->debit_ct_sss, 

                                    'debit_drug_ct'      => $value->debit_drug_ct, 
                                    'toklong'            => $value->ct_brain + $value->debit_drug_ct + $value->ct_orther,

                                    'acc_debtor_userid'  => Auth::user()->id
                                ]);  
                            } 
                    }  
                    
                  
        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_3013_pulldata_old(Request $request)
    {
        $datenow = date('Y-m-d');
        $datetimenow = date('Y-m-d H:i:s');
        
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
            $acc_debtor = DB::connection('mysql2')->select(
                'SELECT v.vn,ifnull(o.an,"") as an,o.hn,v.cid,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,v.vstdate ,o.vsttime ,v.hospmain,op.income as income_group ,ptt.pttype_eclaim_id ,vp.pttype,ptt.max_debt_money
                ,e.code as acc_code ,e.ar_opd as account_code,e.name as account_name ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money ,v.rcpno_list as rcpno
                ,v.income-v.discount_money-v.rcpt_money as debit
                ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                ,(SELECT SUM(o.sum_price) FROM opitemrece o LEFT JOIN nondrugitems n on n.icode = o.icode WHERE o.vn=v.vn AND o.pttype="A7" AND (n.billcode like "8%" OR n.billcode ="2509") and n.billcode not in ("8608","8307") and o.an is null) as debit_ins_sss
                ,(SELECT SUM(ot.sum_price) FROM opitemrece ot WHERE EXISTS (SELECT icode FROM xray_items WHERE icode = ot.icode AND xray_items_group ="3") AND vn =v.vn) as debit_ct_sss
                            from ovst o
                            left join vn_stat v on v.vn=o.vn
                            LEFT JOIN visit_pttype vp on vp.vn = v.vn
                            left join patient pt on pt.hn=o.hn
                            LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                            LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                            LEFT JOIN opitemrece op ON op.vn = o.vn
                            WHERE v.vstdate BETWEEN "2024-09-01" and "2024-09-05" 
                            AND vp.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.3013" AND pttype IS NOT NULL)             
                            AND v.income-v.discount_money-v.rcpt_money <> 0 
                            AND (v.cid IS NOT NULL or v.cid <>"")
                            and (o.an="" or o.an is null)
                            GROUP BY v.vn
            ');         
            // ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode NOT IN("3009147","3009148","3010860","3009187","3009143","3011265","3011266") AND vn = v.vn) as pricenoct           
            foreach ($acc_debtor as $key => $value) { 
                $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.3013')->count();

                if ($check > 0 ) { 
                } else {
                    if ($value->debit_ct_sss > 0 ) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->ptname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate, 
                                'account_code'       => "1102050101.3013", 
                                'account_name'       => $value->account_name, 
                                'income'             => $value->income,
                                'uc_money'           => $value->uc_money,
                                'discount_money'     => $value->discount_money,
                                'paid_money'         => $value->paid_money,
                                'rcpt_money'         => $value->rcpt_money,
                                'debit'              => $value->debit,
                                'debit_drug'         => $value->debit_drug,
                                'debit_instument'    => $value->debit_instument,
                                'debit_toa'          => $value->debit_toa,
                                'debit_refer'        => $value->debit_refer, 
                                'fokliad'            => $value->fokliad, 
                                'debit_total'        => $value->debit_ct_sss, 
                                'debit_ins_sss'      => $value->debit_ins_sss,
                                'debit_ct_sss'       => $value->debit_ct_sss, 
                                'max_debt_amount'    => $value->max_debt_money,
                                'acc_debtor_userid'  => Auth::user()->id
                            ]); 
                    } 
                }                
            }      
            return response()->json([ 
                'status'    => '200'
            ]);
    }       
    public function account_3013_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) {
                $date = date('Y-m-d H:m:s');
             
                $check = Acc_1102050101_3013::where('vn', $value->vn)->count();
                if ($check > 0) {
                # code...
                } else {
                                      
                    Acc_1102050101_3013::insert([ 
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income, 
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total, 
                        'debit_ins_sss'     => $value->debit_ins_sss,
                        'debit_ct_sss'      => $value->debit_ct_sss,  
                        'max_debt_amount'   => $value->max_debt_amount,
                        'toklong'           => $value->toklong,
                        'debit_drug_ct'     => $value->debit_drug_ct,
                        'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_3013_detail(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d'); 
        $data['users'] = User::get();

        $data = DB::select(
            'SELECT *
                FROM acc_1102050101_3013 U1 
                WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_3013.account_3013_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_3013_destroy(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                   
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function account_3013_search(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d'); 
        $new_day = date('Y-m-d', strtotime($date . ' -5 day')); //ย้อนหลัง 1 วัน
        $data['users'] = User::get();
        if ($startdate =='') {
           $datashow = DB::select(' 
               SELECT * from acc_1102050101_3013 
               WHERE vstdate BETWEEN "'.$new_day.'" AND  "'.$date.'"  
           ');
        } else {
           $datashow = DB::select(' 
               SELECT * from acc_1102050101_3013
               WHERE vstdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"  
           ');
        } 
        return view('account_3013.account_3013_search', $data, [
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
        ]);
    }

    public function account_3013_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        
        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.3013" AND stamp = "N" GROUP BY vn');
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











    public function account_301_detail(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
            from acc_1102050101_301 U1
        
            WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_301.account_301_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }

    public function account_301_detail_date(Request $request)
    { 
        $data['users'] = User::get();
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $data = DB::select('
        SELECT U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
            from acc_1102050101_301 U1
        
            WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        return view('account_301.account_301_detail_date', $data, [ 
            'data'           =>     $data,
            'startdate'      =>     $startdate,
            'enddate'        =>     $enddate
        ]);
    }
    
   
 

 }