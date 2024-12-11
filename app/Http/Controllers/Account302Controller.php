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
use App\Models\Acc_1102050101_302;
use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;

use App\Models\Dapi_ins;
use App\Models\Dapi_pat;
use App\Models\Dapi_opd;
use App\Models\Dapi_orf;
use App\Models\Dapi_odx;
use App\Models\Dapi_cht;
use App\Models\Dapi_cha;
use App\Models\Dapi_oop;
use App\Models\Dapi_adp;
use App\Models\Dapi_dru;
use App\Models\Dapi_idx;
use App\Models\Dapi_iop;
use App\Models\Dapi_ipd;
use App\Models\Dapi_aer;
use App\Models\Dapi_irf;
use App\Models\Dapi_lvd;

use App\Models\Acc_function;

use App\Models\D_apiofc_ins;
use App\Models\D_apiofc_iop;
use App\Models\D_apiofc_adp;
use App\Models\D_apiofc_aer;
use App\Models\D_apiofc_cha;
use App\Models\D_apiofc_cht;
use App\Models\D_apiofc_dru;
use App\Models\D_apiofc_idx;
use App\Models\D_apiofc_pat;
use App\Models\D_apiofc_ipd;
use App\Models\D_apiofc_irf;
use App\Models\D_apiofc_ldv;
use App\Models\D_apiofc_odx;
use App\Models\D_apiofc_oop;
use App\Models\D_apiofc_opd;
use App\Models\D_apiofc_orf;

use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;

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
use App\Models\Acc_ofc_dateconfig;
use App\Models\Aipn_stm;
use App\Models\Status;
use App\Models\Aipn_ipdx;
use App\Models\Aipn_ipop;
use App\Models\Aipn_session;
use App\Models\Aipn_billitems;
use App\Models\Aipn_ipadt;
use App\Models\Check_sit;
use App\Models\Stm;
use App\Models\D_aipn_main;
use App\Models\D_claim;
use App\Models\D_aipadt;
use App\Models\D_aipdx;
use App\Models\D_aipop;
use App\Models\D_abillitems;
use App\Models\D_aipn_session;

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
use CURLFILE;
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
use App\Models\D_ofc_repexcel;
use App\Models\D_ofc_rep;
use ZipArchive;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location;
use Illuminate\Filesystem\Filesystem;

date_default_timezone_set("Asia/Bangkok");


class Account302Controller extends Controller
 {
    // ***************** 302********************************
    public function account_302_dash(Request $request)
    {
            $datenow = date('Y-m-d');
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


            // $data_trimart = DB::table('acc_trimart')->limit(3)->orderBy('acc_trimart_id','desc')->get();
            if ($acc_trimart_id == '') {
                $data_trimart = DB::table('acc_trimart')->where('active','Y')->limit(12)->orderBy('acc_trimart_id','desc')->get();
                $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
            } else {
                // $data_trimart = DB::table('acc_trimart')->whereBetween('dchdate', [$startdate, $enddate])->orderBy('acc_trimart_id','desc')->get();
                $data_trimart = DB::table('acc_trimart')->where('active','Y')->where('acc_trimart_id','=',$acc_trimart_id)->orderBy('acc_trimart_id','desc')->get();
                $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
            }
            return view('account_302.account_302_dash',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate,
                'trimart'          => $trimart,
                'leave_month_year' =>  $leave_month_year,
                'data_trimart'     =>  $data_trimart,
            ]);
    }
    public function account_302_dash_new(Request $request)
    {
        $budget_year        = $request->budget_year;
        $acc_trimart_id = $request->acc_trimart_id;
        $dabudget_year      = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year   = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($budget_year == '') {
            $yearnew     = date('Y');
            $year_old    = date('Y')-1;
            $startdate   = (''.$year_old.'-10-01');
            $enddate     = (''.$yearnew.'-09-30');
            // dd($startdate);
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn ,count(distinct a.vn) as vn ,count(distinct a.an) as an
                    ,sum(a.income) as income ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total ,sum(a.debit) as debit
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money)-sum(a.fokliad) as debit402,sum(a.fokliad) as sumfokliad
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.304"
                    group by month(a.dchdate)
                    order by a.dchdate desc;
            ');
        } else {

            $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end;
            // dd($startdate);
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an ,sum(a.income) as income ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.304"
                    group by month(a.dchdate)
                    order by a.dchdate desc;
            ');
        }
        // dd($startdate);
        return view('account_302.account_302_dash',[
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'leave_month_year'  =>  $leave_month_year,
            'datashow'          =>  $datashow,
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y,
            // 'trimart'          => $trimart,
        ]);

        // return view('account_304.account_304_dash',[
        //     'startdate'        => $startdate,
        //     'enddate'          => $enddate,
        //     'leave_month_year' => $leave_month_year,
        //     'data_trimart'     => $data_trimart,
        //     'newyear'          => $newyear,
        //     'date'             => $date,
        //     'trimart'          => $trimart,
        // ]);
    }
    public function account_302_dashsub(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        // dd($end );

            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME,l.MONTH_ID
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.302"
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');


        return view('account_302.account_302_dashsub',[
            'startdate'          =>  $startdate,
            'enddate'            =>  $enddate,
            'datashow'           =>  $datashow,
            'leave_month_year'   =>  $leave_month_year,
        ]);
    }
    public function account_302_dashsubdetail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT
            month(dchdate) as months,year(dchdate) as year
            ,an,vn,hn,cid,ptname,dchdate,pttype,debit_total
            from acc_1102050101_302

            WHERE month(dchdate) = "'.$months.'"
            AND year(dchdate) = "'.$year.'"
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_302.account_302_dashsubdetail', $data, [
            'data'          =>     $data,
            'year'          =>     $year,
            'months'        =>     $months
        ]);
    }
    public function account_302_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        $newday = date('Y-m-d', strtotime($datenow . ' -2 Day')); //ย้อนหลัง 1 สัปดาห์
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        if ($startdate == '') {
            $acc_debtor = DB::select(
                'SELECT *
                    from acc_debtor a
                    WHERE a.account_code="1102050101.302"
                    AND dchdate BETWEEN "' . $newday . '" AND "' . $datenow . '"
                    AND a.debit_total > 0
                    GROUP BY a.an
                    order by a.an DESC;
            ');
            $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.302')->whereBetween('dchdate', [$newday, $datenow])->count();
            $data['count_noclaim'] = Acc_debtor::where('active_claim','=','N')->where('account_code','=','1102050101.302')->whereBetween('dchdate', [$newday, $datenow])->count();
        } else {
            $acc_debtor = DB::select(
                'SELECT *
                    from acc_debtor a
                    WHERE a.account_code="1102050101.302"
                    AND dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    AND a.debit_total > 0
                    GROUP BY a.an
                    order by a.an DESC;
            ');
            $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','1102050101.302')->whereBetween('dchdate', [$startdate, $enddate])->count();
            $data['count_noclaim'] = Acc_debtor::where('active_claim','=','N')->where('account_code','=','1102050101.302')->whereBetween('dchdate', [$startdate, $enddate])->count();
        }

        $data_activeclaim        = Acc_function::where('pang','1102050101.302')->first();
        $data['activeclaim']     = $data_activeclaim->claim_active;
        $data['acc_function_id'] = $data_activeclaim->acc_function_id;

        $data['d_aipadt']          = DB::connection('mysql')->select('SELECT * FROM d_aipadt');
        $data['d_aipdx']           = DB::connection('mysql')->select('SELECT * FROM d_aipdx');
        $data['d_aipop']           = DB::connection('mysql')->select('SELECT * FROM d_aipop');
        $data['d_abillitems']      = DB::connection('mysql')->select('SELECT * FROM d_abillitems');
        $data['d_adispensing']     = DB::connection('mysql')->select('SELECT * FROM d_adispensing');
        $data['d_adispenseditems'] = DB::connection('mysql')->select('SELECT * FROM d_adispenseditems');
        // D_aipadt
        return view('account_302.account_302_pull',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_302_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
            $acc_debtor = DB::connection('mysql2')->select(
                'SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,ipt.pttype,ptt.max_debt_money
                ,ec.code
                ,ec.ar_ipd as account_code
                ,ec.name as account_name
                ,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money,di.icd10

                ,sum(if(op.icode ="3010058",sum_price,0)) as fokliad
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN opitemrece op ON ip.an = op.an
                LEFT OUTER JOIN iptdiag di on di.an = ip.an
                LEFT OUTER JOIN icd101 ic on ic.code = di.icd10
                LEFT JOIN vn_stat v on v.vn = a.vn
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND ipt.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.302")
                GROUP BY a.an;
            ');
            // ,ec.code
            // ,ec.ar_ipd as account_code
            // ,ec.name as account_name
            // AND ipt.pttype = "A7"
            $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
            $bg_yearnow    = $bgs_year->leave_year_id;

            D_aipadt::truncate();
            D_aipdx::truncate();
            D_aipop::truncate();
            D_abillitems::truncate();

            foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.302')->count();
                    if ($check > 0) {
                        Acc_debtor::where('vn', $value->vn)->update([
                            'pdx'                => $value->icd10,
                            'icd10'              => $value->icd10,
                            'debit_total'        => $value->looknee_money,
                            'bg_yearnow'         => $bg_yearnow,
                        ]);
                    }else{
                        Acc_debtor::insert([
                            'bg_yearnow'         => $bg_yearnow,
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->fullname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'rxdate'             => $value->admdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'paid_money'         => $value->cash_money,
                            'rcpt_money'         => $value->cash_money,
                            'debit'              => $value->looknee_money,
                            'debit_drug'         => $value->debit_drug,
                            'debit_instument'    => $value->debit_instument,
                            'debit_toa'          => $value->debit_toa,
                            'debit_refer'        => $value->debit_refer,
                            'fokliad'            => $value->fokliad,
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

                    // if ($value->fokliad > 0 && $value->account_code =='1102050101.302') {
                    //     $checkfokliad = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.3099')->count();
                    //     if ($checkfokliad == 0) {
                    //         Acc_debtor::insert([
                    //             'hn'                 => $value->hn,
                    //             'an'                 => $value->an,
                    //             'vn'                 => $value->vn,
                    //             'cid'                => $value->cid,
                    //             'ptname'             => $value->fullname,
                    //             'pttype'             => $value->pttype,
                    //             'vstdate'            => $value->vstdate,
                    //             'regdate'            => $value->admdate,
                    //             'dchdate'            => $value->dchdate,
                    //             'acc_code'           => "38",
                    //             'account_code'       => '1102050101.3099',
                    //             'account_name'       => 'ประกันสังคม-ค่าใช้จ่ายสูง OP(ฟอกไต)',
                    //             'income_group'       => '11',
                    //             'debit'              => $value->fokliad,
                    //             'debit_total'        => $value->fokliad
                    //         ]);
                    //     }
                    // }
            }
            return response()->json([

                'status'    => '200'
            ]);
    }
    // public function account_302_checksit(Request $request)
    // {
    //     $datestart = $request->datestart;
    //     $dateend = $request->dateend;
    //     $date = date('Y-m-d');

    //     $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.302" AND stamp = "N" GROUP BY an');
    //    //  AND subinscl IS NULL
    //        //  LIMIT 30
    //     // WHERE vstdate = CURDATE()
    //     // BETWEEN "2024-02-03" AND "2024-02-15"
    //     // $token_data = DB::connection('mysql')->select('SELECT cid,token FROM ssop_token');
    //     $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
    //     foreach ($token_data as $key => $value) {
    //         $cid_    = $value->cid;
    //         $token_  = $value->token;
    //     }
    //     foreach ($data_sitss as $key => $item) {
    //         $pids = $item->cid;
    //         $vn   = $item->vn;
    //         $an   = $item->an;
    //             // $token_data = DB::connection('mysql10')->select('SELECT cid,token FROM hos.nhso_token where token <> ""');
    //             // foreach ($token_data as $key => $value) {
    //                 $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
    //                     array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',"trace" => 1,"exceptions" => 0,"cache_wsdl" => 0)
    //                     );
    //                     $params = array(
    //                         'sequence' => array(
    //                             "user_person_id"   => "$cid_",
    //                             "smctoken"         => "$token_",
    //                             // "user_person_id" => "$value->cid",
    //                             // "smctoken"       => "$value->token",
    //                             "person_id"        => "$pids"
    //                     )
    //                 );
    //                 $contents = $client->__soapCall('searchCurrentByPID',$params);
    //                 foreach ($contents as $v) {
    //                     @$status = $v->status ;
    //                     @$maininscl = $v->maininscl;
    //                     @$startdate = $v->startdate;
    //                     @$hmain = $v->hmain ;
    //                     @$subinscl = $v->subinscl ;
    //                     @$person_id_nhso = $v->person_id;

    //                     @$hmain_op = $v->hmain_op;  //"10978"
    //                     @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
    //                     @$hsub = $v->hsub;    //"04047"
    //                     @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
    //                     @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"

    //                     IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
    //                         $date = date("Y-m-d");

    //                         Acc_debtor::where('an', $an)
    //                         ->update([
    //                             'status'         => 'จำหน่าย/เสียชีวิต',
    //                             'maininscl'      => @$maininscl,
    //                             'pttype_spsch'   => @$subinscl,
    //                             'hmain'          => @$hmain,
    //                             'subinscl'       => @$subinscl,
    //                         ]);

    //                     }elseif(@$maininscl !="" || @$subinscl !=""){
    //                        Acc_debtor::where('an', $an)
    //                        ->update([
    //                            'status'         => @$status,
    //                            'maininscl'      => @$maininscl,
    //                            'pttype_spsch'   => @$subinscl,
    //                            'hmain'          => @$hmain,
    //                            'subinscl'       => @$subinscl,

    //                        ]);

    //                     }

    //                 }

    //     }

    //     return response()->json([

    //        'status'    => '200'
    //    ]);

    // }
    public function account_302_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend   = $request->dateend;
        $date      = date('Y-m-d');
        $id        = $request->ids;
        // $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.401" AND stamp = "N" GROUP BY vn');
        $data_sitss = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) {
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn;
            $an   = $item->an;

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

                            Acc_debtor::where('an', $an)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'   => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl,
                            ]);

                        }elseif(@$maininscl !="" || @$subinscl !=""){
                           Acc_debtor::where('an', $an)
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
    function account_302_claimswitch(Request $request)
    {
        // $id = $request->idfunc;
        Acc_function::where('pang','1102050101.302')->update(['claim_active'=> $request->onoff]);
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_302_stam(Request $request)
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

                $check = Acc_1102050101_302::where('an', $value->an)->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050101_302::insert([
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
                            'income_group'      => $value->income_group,
                            'uc_money'          => $value->uc_money,
                            'discount_money'    => $value->discount_money,
                            'rcpt_money'        => $value->rcpt_money,
                            'debit'             => $value->debit,
                            'debit_drug'        => $value->debit_drug,
                            'debit_instument'   => $value->debit_instument,
                            'debit_refer'       => $value->debit_refer,
                            'debit_toa'         => $value->debit_toa,
                            'debit_total'       => $value->debit,
                            'max_debt_amount'   => $value->max_debt_amount,
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_302_destroy_all(Request $request)
    {
        $id = $request->ids;
        Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_302_detail(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
            from acc_1102050101_302 U1

            WHERE U1.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_302.account_302_detail', $data, [
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_302_detail_date(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
            from acc_1102050101_302 U1

            WHERE U1.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        return view('account_302.account_302_detail_date', $data, [
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }

    // ************************** CLAIM ********************


    public function account_302_claim(Request $request)
    {
        D_aipop::truncate();
        D_aipdx::truncate();
        D_aipn_main::truncate();
        D_abillitems::truncate();
        D_aipadt::truncate();

        Fdh_sesion::where('d_anaconda_id', '=', 'SSS_IP')->delete();
        $s_date_now  = date("Y-m-d");
        $s_time_now  = date("H:i:s");
        $id          = $request->ids;
        $iduser      = Auth::user()->id;

        $data_vn_1    = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

        // #ตัดขีด, ตัด : ออก
        // $pattern_date = '/-/i';
        // $s_date_now_preg = preg_replace($pattern_date, '', $s_date_now);
        // $pattern_time = '/:/i';
        // $s_time_now_preg = preg_replace($pattern_time, '', $s_time_now);
        // #ตัดขีด, ตัด : ออก
        // $folder_name = 'SSS_IP_' . $s_date_now_preg . '_' . $s_time_now_preg;
        // Fdh_sesion::insert([
        //     'folder_name'      => $folder_name,
        //     'd_anaconda_id'    => 'SSS_IP',
        //     'date_save'        => $s_date_now,
        //     'time_save'        => $s_time_now,
        //     'userid'           => $iduser
        // ]);


        foreach ($data_vn_1 as $key => $va1) {

                    D_aipn_main::insert([
                        'vn'                => $va1->vn,
                        'hn'                => $va1->hn,
                        'an'                => $va1->an,
                        'dchdate'           => $va1->dchdate,
                        'debit'             => $va1->debit
                    ]);

                    //D_aipadt
                    $aipn_data = DB::connection('mysql2')->select(
                        'SELECT i.an,i.an as AN,i.hn as HN,"0" as IDTYPE ,pt.cid as PIDPAT
                            ,pt.pname as TITLE ,concat(pt.fname," ",pt.lname) as NAMEPAT ,pt.birthday as DOB ,a.sex as SEX ,pt.marrystatus as MARRIAGE
                            ,pt.chwpart as CHANGWAT,pt.amppart as AMPHUR ,pt.citizenship as NATION ,"C" as AdmType
                            ,"O" as AdmSource ,i.regdate as DTAdm_d ,i.regtime as DTAdm_t ,i.dchdate as DTDisch_d
                            ,i.dchtime as DTDisch_t,"0" AS LeaveDay,i.dchstts as DischStat ,i.dchtype as DishType ,"" as AdmWt ,i.ward as DishWard
                            ,sp.nhso_code as Dept,ptt.hipdata_code maininscl,i.pttype ,concat(i.pttype,":",ptt.name) pttypename ,"10702" HMAIN ,"IP" as ServiceType
                            from ipt i
                            LEFT OUTER JOIN patient pt on pt.hn=i.hn
                            LEFT OUTER JOIN ptcardno pc on pc.hn=pt.hn and pc.cardtype="02"
                            LEFT OUTER JOIN an_stat a on a.an=i.an
                            LEFT OUTER JOIN spclty sp on sp.spclty=i.spclty
                            LEFT OUTER JOIN pttype ptt on ptt.pttype=i.pttype
                            LEFT OUTER JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                            LEFT OUTER JOIN opitemrece oo on oo.an=i.an
                            LEFT OUTER JOIN income inc on inc.income=oo.income
                            LEFT OUTER JOIN s_drugitems d on d.icode=oo.icode
                            WHERE i.an IN("' . $va1->an . '")
                            AND ptt.pttype IN("A7","s7","14")
                            group by i.an
                    ');
                    foreach ($aipn_data as $key => $value) {
                        D_aipadt::insert([
                            'AN'             => $value->AN,
                            'HN'             => $value->HN,
                            'IDTYPE'         => $value->IDTYPE,
                            'PIDPAT'         => $value->PIDPAT,
                            'TITLE'          => $value->TITLE,
                            'NAMEPAT'        => $value->NAMEPAT,
                            'DOB'            => $value->DOB,
                            'SEX'            => $value->SEX,
                            'MARRIAGE'       => $value->MARRIAGE,
                            'CHANGWAT'       => $value->CHANGWAT,
                            'AMPHUR'         => $value->AMPHUR,
                            'NATION'         => $value->NATION,
                            'AdmType'        => $value->AdmType,
                            'AdmSource'      => $value->AdmSource,
                            'DTAdm_d'        => $value->DTAdm_d,
                            'DTAdm_t'        => $value->DTAdm_t,
                            'DTDisch_d'      => $value->DTDisch_d,
                            'DTDisch_t'      => $value->DTDisch_t,
                            'LeaveDay'       => $value->LeaveDay,
                            'DischStat'      => $value->DischStat,
                            'DishType'       => $value->DishType,
                            'AdmWt'          => $value->AdmWt,
                            'DishWard'       => $value->DishWard,
                            'Dept'           => $value->Dept,
                            'HMAIN'          => $value->HMAIN,
                            'ServiceType'    => $value->ServiceType
                        ]);
                    }

                    //D_abillitems
                    $aipn_billitems = DB::connection('mysql2')->select(
                        'SELECT  i.an,i.an as AN,"" as sequence,i.regdate as DTAdm_d,i.regtime as DTAdm_t,i.dchdate as ServDate,i.dchtime as ServTime
                            ,case
                            when oo.item_type="H" then "04"
                            else zero(inc.income) end BillGr
                            ,inc.income as BillGrCS
                            ,ifnull(case
                            when inc.income in (02) then d.nhso_adp_code
                            when inc.income in (03,04) then dd.billcode
                            when inc.income in (06,07) then d.nhso_adp_code
                            else d.nhso_adp_code end,"") CSCode
                            ,ifnull(case
                            when inc.income in (03,04) then dd.tmt_tmlt
                            when inc.income in (06,07) then dd.tmt_tmlt
                            else "" end,"") STDCode
                            ,ifnull(case
                            when inc.income in (03,04) then "TMT"
                            when inc.income in (06,07) then "TMLT"
                            else "" end,"") CodeSys
                            ,oo.icode as LCCode,concat_ws("",d.name,d.strength) Descript,sum(oo.qty) as QTY,oo.UnitPrice as pricehos
                            ,dd.UnitPrice as pricecat,sum(oo.sum_price) ChargeAmt_,dd.tmt_tmlt,inc.income
                            ,case
                            when oo.paidst in ("01","03") then "T"
                            else "D" end ClaimCat
                            ,"0" as ClaimUP,"0" as ClaimAmt,i.dchdate,i.dchtime,sum(if(oo.paidst="04",sum_price,0)) Discount
                            from ipt i
                            left outer join opitemrece oo on oo.an=i.an
                            left outer join an_stat a on a.an=i.an
                            left outer join patient pt on i.hn=pt.hn
                            left outer join income inc on inc.income=oo.income
                            left outer join s_drugitems d on oo.icode=d.icode
                            left join claim.aipn_drugcat_labcat dd on dd.icode=oo.icode
                            left join claim.aipn_labcat_sks ls on ls.lccode=oo.icode
                            left join claim.aipn_drugcat_sks dks on dks.hospdcode=oo.icode

                            WHERE i.an IN("'. $va1->an .'") and oo.qty<>0
                            AND oo.UnitPrice<>0 AND inc.income NOT IN("02","22" )
                            group by oo.icode
                            order by i.an desc
                    ');
                    $i = 1;
                    foreach ($aipn_billitems as $key => $val_bill) {
                        // $codesys = $val_bill->BillGr;
                        $cs_ = $val_bill->BillGrCS;
                        $cs = $val_bill->CSCode;
                        // $billcs = $val_bill->BillGrCS;
                        if ($cs_ == '03') {
                            $csys = $val_bill->CodeSys;
                        } elseif ($cs_ == '02') {
                            $csys = $val_bill->CodeSys;
                        } elseif ($cs_ == '06') {
                            $csys = $val_bill->CodeSys;
                        } elseif ($cs_ == '04') {
                            $csys = $val_bill->CodeSys;
                        } elseif ($cs_ == '07') {
                            $csys = $val_bill->CodeSys;
                        } else {
                            $csys = '';
                        }
                        if ($cs == 'XXXX') {
                            $cs_code = '';
                        } elseif ($cs == 'XXXXX') {
                            $cs_code = '';
                        } elseif ($cs == 'XXXXXX') {
                            $cs_code = '';
                        } else {
                            $cs_code = $val_bill->CSCode;
                        }
                        D_abillitems::insert([
                            'AN'                => $val_bill->AN,
                            'sequence'          => $i++,
                            'ServDate'          => $val_bill->ServDate,
                            'ServTime'          => $val_bill->ServTime,
                            'BillGr'            => $val_bill->BillGr,
                            'BillGrCS'          => $cs_,
                            'CSCode'            => $cs_code,
                            'LCCode'            => $val_bill->LCCode,
                            'Descript'          => $val_bill->Descript,
                            'QTY'               => $val_bill->QTY,
                            'UnitPrice'         => $val_bill->pricehos,
                            'ChargeAmt'         => $val_bill->QTY * $val_bill->pricehos,
                            'ClaimSys'          => "SS",
                            'CodeSys'           => $csys,
                            'STDCode'           => $val_bill->STDCode,
                            'Discount'          => "0.0000",
                            'ProcedureSeq'      => "0",
                            'DiagnosisSeq'      => "0",
                            'DateRev'           => $val_bill->ServDate,
                            'ClaimCat'          => $val_bill->ClaimCat,
                            'ClaimUP'           => $val_bill->ClaimUP,
                            'ClaimAmt'          => $val_bill->ClaimAmt
                        ]);
                    }

                    //D_aipop
                    $aipn_ipop = DB::connection('mysql2')->select(
                        'SELECT i.an as AN,"" as sequence,"ICD9CM" as CodeSys,cc.icd9 as Code,icdname(cc.icd9) as Procterm,doctorlicense(cc.doctor) as DR
                            ,date_format(if(opdate is null,caldatetime(regdate,regtime),caldatetime(opdate,optime)),"%Y-%m-%dT%T") as DateIn
                            ,date_format(if(enddate is null,caldatetime(regdate,regtime),caldatetime(enddate,endtime)),"%Y-%m-%dT%T") as DateOut ," " as Location
                            from ipt i
                            join iptoprt cc on cc.an=i.an
                            WHERE i.an IN("' . $va1->an . '")
                            group by cc.icd9
                    ');
                    $i = 1;
                    foreach ($aipn_ipop as $key => $ipop) {
                        $doctop = $ipop->DR;
                        #ตัดขีด,  ออก
                        $pattern_drop = '/-/i';
                        $dr_cutop = preg_replace($pattern_drop, '', $doctop);
                        if ($dr_cutop == '') {
                            $doctop_ = 'ว47998';
                        } else {
                            $doctop_ = $dr_cutop;
                        }
                        D_aipop::insert([
                            'an'             => $ipop->AN,
                            'sequence'       => $i++,
                            'CodeSys'        => $ipop->CodeSys,
                            'Code'           => $ipop->Code,
                            'Procterm'       => $ipop->Procterm,
                            'DR'             => $doctop_,
                            'DateIn'         => $ipop->DateIn,
                            'DateOut'        => $ipop->DateOut,
                            'Location'       => $ipop->Location
                        ]);
                    }

                    $aipn_ipdx = DB::connection('mysql2')->select(
                        'SELECT i.an as AN,"" as sequence,diagtype as DxType,if(ifnull(aa.codeset,"")="TT","ICD-10-TM","ICD-10") as CodeSys,dx.icd10 as Dcode
                            ,icdname(dx.icd10) as DiagTerm,doctorlicense(cc.doctor) as DR,null datediag
                            from ipt i
                            join iptdiag dx on dx.an=i.an
                            join iptoprt cc on cc.an=i.an
                            left join icd101 aa on aa.code=dx.icd10
                            WHERE i.an IN("' . $va1->an . '")
                            group by dx.icd10
                            order by diagtype,ipt_diag_id
                    ');
                    $j = 1;
                    foreach ($aipn_ipdx as $key => $val_ipdx) {
                        $doct = $val_ipdx->DR;
                        #ตัดขีด,  ออก
                        $pattern_dr = '/-/i';
                        $dr_cut = preg_replace($pattern_dr, '', $doct);

                        if ($dr_cut == '') {
                            $doctop_s = 'ว47998';
                        } else {
                            $doctop_s = $dr_cut;
                        }

                        D_aipdx::insert([
                            'an'             => $val_ipdx->AN,
                            'sequence'       => $j++,
                            'DxType'         => $val_ipdx->DxType,
                            'CodeSys'        => $val_ipdx->CodeSys,
                            'Dcode'          => $val_ipdx->Dcode,
                            'DiagTerm'       => $val_ipdx->DiagTerm,
                            'DR'             => $doctop_s,
                            'datediag'       => $val_ipdx->datediag
                        ]);
                    }

                    $update_billitems = DB::connection('mysql')->select('SELECT * FROM d_abillitems WHERE CodeSys ="TMLT" AND STDCode ="" OR ClaimCat="T" ');
                    foreach ($update_billitems as $key => $valbil) {
                        $id = $valbil->d_abillitems_id;
                        $del = D_abillitems::find($id);
                        $del->delete();
                    }
                    $update_billitems2 = DB::connection('mysql')->select('SELECT * FROM d_abillitems WHERE CodeSys ="TMT" AND STDCode ="" OR ClaimCat="T" ');
                    foreach ($update_billitems2 as $key => $valbil2) {
                        $id = $valbil2->d_abillitems_id;
                        $del = D_abillitems::find($id);
                        $del->delete();
                    }

        }

        // Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
        // ->update([
        //     'active_claim' => 'Y'
        // ]);

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_302_destroy(Request $request)
    {
        $id = $request->ids2;
        D_abillitems::whereIn('d_abillitems_id',explode(",",$id))->delete();

        return response()->json([
            'status'    => '200'
        ]);

    }
    public function account_302_update(Request $request)
    {
        $id        = $request->input('d_aipop_id_edit');
        $DateIn    = $request->input('DateIn');
        $TimeIn    = $request->input('TimeIn');
        $DateOut   = $request->input('DateOut');
        $TimeOut   = $request->input('TimeOut');

        $update = D_aipop::find($id);
        $update->DateIn    = $DateIn.'T'.$TimeIn;
        $update->DateOut   = $DateOut.'T'.$TimeOut;
        $update->Date_In   = $DateIn;
        $update->Date_Out  = $DateOut;
        $update->Time_In   = $TimeIn;
        $update->Time_Out  = $TimeOut;
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function account_302_export(Request $request)
    {

        $aipn_date_now = date("Y-m-d");
        $aipn_time_now = date("H:i:s");

        #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export_AIPN'); //ทั้งหมด

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = D_aipn_session::max('aipn_session_no');
        $aipn_session_no = $maxid + 1;

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $aipn_date_now_preg = preg_replace($pattern_date, '', $aipn_date_now);
        $pattern_time = '/:/i';
        $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);
        #ตัดขีด, ตัด : ออก

        $folder = '10978AIPN' . $aipn_session_no;
        // $foldertxt = 'TXT' . $aipn_session_no;

        $add = new D_aipn_session();
        $add->aipn_session_no = $aipn_session_no;
        $add->aipn_session_date = $aipn_date_now;
        $add->aipn_session_time = $aipn_time_now;
        $add->aipn_session_filename = $folder;
        $add->aipn_session_ststus = "Send";
        $add->save();

        mkdir('Export_AIPN/' . $folder, 0777, true);  //Web
        // mkdir('Export_AIPN/' . $foldertxt, 0777, true);  //Web

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        $datamain = DB::connection('mysql')->select('SELECT an FROM d_aipn_main');
        // foreach ($datamain as $key => $ai) {
        //     $an = $ai->an;
        // $file_pat = "Export_aipn/" . $foldertxt . "/10978-AIPN-" . $an . '-' . $aipn_date_now_preg . '' . $aipn_time_now_preg . ".txt";
            // $file_pat = "Export_AIPN/" . $foldertxt . "/10978-AIPN-". $aipn_session_no. ".txt";
            // $objFopen_opd = fopen($file_pat, 'w');
        foreach ($datamain as $key => $value_an) {

            $file_pat = "Export_AIPN/".$folder."/10978-AIPN-".$value_an->an.'-'.$aipn_date_now_preg.'' . $aipn_time_now_preg .".xml";
            $objFopen_opd = fopen($file_pat, 'w');
         // }
            $opd_head = '<CIPN>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<Header>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<DocClass>IPClaim</DocClass>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<DocSysID version="2.1">AIPN</DocSysID>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<serviceEvent>ADT</serviceEvent>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<authorID>10978</authorID>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<authorName>รพ.ภูเขียวเฉลิมพระเกียรติ</authorName>';
            $opd_head_ansi = iconv('UTF-8', 'TIS-620', $opd_head);
            fwrite($objFopen_opd, $opd_head_ansi);
            $opd_head = "\n" . '<effectiveTime>' . $aipn_date_now . 'T' . $aipn_time_now . '</effectiveTime>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '</Header>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<ClaimAuth>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<AuthCode></AuthCode>';
            fwrite($objFopen_opd, $opd_head);
            $count_i = D_aipadt::count();
            if ($count_i < 1) {
                    $inv  = '';
                    $audt = '';
                    $indt = '';
            } else {
                $aipn_InvNumber_ = DB::connection('mysql')->select('SELECT AN,CONCAT(DTAdm_d,"T",DTAdm_t) as DTAdm,CONCAT(DTDisch_d,"T",DTDisch_t) as DTDisch FROM d_aipadt WHERE AN ="'.$value_an->an.'" GROUP BY AN');
                foreach ($aipn_InvNumber_ as $key => $val) {
                    $inv  = $val->AN;
                    $audt = $val->DTAdm;
                    $indt = $val->DTDisch;
                }
            }
            $opd_head = "\n" . '<AuthDT>' . $audt . '</AuthDT>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<UPayPlan>80</UPayPlan>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<ServiceType>IP</ServiceType>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<ProjectCode></ProjectCode>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<EventCode> </EventCode>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<UserReserve> </UserReserve>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<Hmain>10702</Hmain>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<Hcare>10978</Hcare>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<CareAs>B</CareAs>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<ServiceSubType> </ServiceSubType>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '</ClaimAuth>';
            fwrite($objFopen_opd, $opd_head);

            $opd_head = "\n" . '<IPADT>';
            fwrite($objFopen_opd, $opd_head);
            $aipn_data = DB::connection('mysql')->select(
                'SELECT AN,HN,IDTYPE,PIDPAT,TITLE,NAMEPAT,DOB,SEX,MARRIAGE,CHANGWAT,AMPHUR,NATION,AdmType,ifnull(AdmSource,"") as AdmSource
                    ,CONCAT(DTAdm_d,"T",DTAdm_t) as DTAdm,CONCAT(DTDisch_d,"T",DTDisch_t) as DTDisch ,LeaveDay,DischStat,DishType,AdmWt,DishWard,Dept
                    FROM d_aipadt WHERE AN ="'.$value_an->an.'" GROUP BY AN
                ');
            foreach ($aipn_data as $key => $value2) {
                $b1 = $value2->AN;
                $b2 = $value2->HN;
                $b3 = $value2->IDTYPE;
                $b4 = $value2->PIDPAT;
                $b5 = $value2->TITLE;
                $b6 = $value2->NAMEPAT;
                $b7 = $value2->DOB;
                $b8 = $value2->SEX;
                $b9 = $value2->MARRIAGE;
                $b10 = $value2->CHANGWAT;
                $b11 = $value2->AMPHUR;
                $b12 = $value2->NATION;
                $b13 = $value2->AdmType;
                $b14 = $value2->AdmSource;
                $b15 = $value2->DTAdm;
                $b16 = $value2->DTDisch;
                $b17 = $value2->LeaveDay;
                $b18 = $value2->DischStat;
                $b19 = $value2->DishType;
                $b20 = $value2->AdmWt;
                $b21 = $value2->DishWard;
                $b22 = $value2->Dept;
                $strText2 = "\n" . $b1 . "|" . $b2 . "|" . $b3 . "|" . $b4 . "|" . $b5 . "|" . $b6 . "|" . $b7 . "|" . $b8 . "|" . $b9 . "|" . $b10 . "|" . $b11 . "|" . $b12 . "|" . $b13 . "|" . $b14 . "|" . $b15 . "|" . $b16 . "|" . $b17 . "|" . $b18 . "|" . $b19 . "|" . $b20 . "|" . $b21 . "|" . $b22;
                $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
                fwrite($objFopen_opd, $ansitxt_pat2);
            }

            $opd_head = "\n" . '</IPADT>';
            fwrite($objFopen_opd, $opd_head);
            $ipdx_count_ = DB::connection('mysql')->select('SELECT COUNT(d_aipdx_id) as iCount FROM d_aipdx WHERE an ="'.$value_an->an.'" GROUP BY an');
            foreach ($ipdx_count_ as $key => $value_c) {
                $ipdx_count = $value_c->iCount;
            }
            $opd_head = "\n" . '<IPDx Reccount="' . $ipdx_count . '">';
            fwrite($objFopen_opd, $opd_head);
            $ipdx = DB::connection('mysql')->select('SELECT * FROM d_aipdx WHERE an ="'.$value_an->an.'" GROUP BY an');
            foreach ($ipdx as $key => $value_ip) {
                $s1 = $value_ip->sequence;
                $s2 = $value_ip->DxType;
                $s3 = $value_ip->CodeSys;
                $s4 = $value_ip->Dcode;
                $s5 = $value_ip->DiagTerm;
                $s6 = $value_ip->DR;

                $strText = "\n" . $s1 . "|" . $s2 . "|" . $s3 . "|" . $s4 . "|" . $s5 . "|" . $s6 . "|";
                $ansitxt_ipdx = iconv('UTF-8', 'TIS-620', $strText);
                fwrite($objFopen_opd, $ansitxt_ipdx);
            }
            $opd_head = "\n" . '</IPDx>';
            fwrite($objFopen_opd, $opd_head);
            $ipop_count_ = DB::connection('mysql')->select('SELECT COUNT(d_aipop_id) as iopcount FROM d_aipop WHERE an ="'.$value_an->an.'" GROUP BY an');
            foreach ($ipop_count_ as $key => $value_op) {
                $ipop_count = $value_op->iopcount;
            }
            $opd_head = "\n" . '<IPOp Reccount="' . $ipop_count . '">';
            fwrite($objFopen_opd, $opd_head);
            $ipop = DB::connection('mysql')->select('SELECT sequence,CodeSys,Code,Procterm,DR,DateIn,DateOut,Location FROM d_aipop WHERE an ="'.$value_an->an.'" GROUP BY an');

            foreach ($ipop as $key => $value_ipop) {
                $s1 = $value_ipop->sequence;
                $s2 = $value_ipop->CodeSys;
                $s3 = $value_ipop->Code;
                $s4 = $value_ipop->Procterm;
                $s5 = $value_ipop->DR;
                $s6 = $value_ipop->DateIn;
                $s7 = $value_ipop->DateOut;

                $strText = "\n" . $s1 . "|" . $s2 . "|" . $s3 . "|" . $s4 . "|" . $s5 . "|" . $s6 . "|" . $s7 . "|";
                $ansitxt_ipop = iconv('UTF-8', 'TIS-620', $strText);
                fwrite($objFopen_opd, $ansitxt_ipop);
            }
            $opd_head = "\n" . '</IPOp>';
            fwrite($objFopen_opd, $opd_head);
            $billitem_count_ = DB::connection('mysql')->select('SELECT COUNT(d_abillitems_id) as bill_count FROM d_abillitems WHERE AN ="'.$value_an->an.'" GROUP BY AN');
            foreach ($billitem_count_ as $key => $value_bill) {
                $billitem_count = $value_bill->bill_count;
            }
            $opd_head = "\n" . '<Invoices>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<InvNumber>' . $inv . '</InvNumber>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<InvDT>' . $indt . '</InvDT>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<BillItems Reccount="' . $billitem_count . '">';
            fwrite($objFopen_opd, $opd_head);
            $text_billitems_ = DB::connection('mysql')->select('SELECT * from d_abillitems WHERE AN ="'.$value_an->an.'"');
            foreach ($text_billitems_ as $key => $bitem) {
                $t1 = $bitem->sequence;
                $t2 = $bitem->ServDate;
                $t3 = $bitem->BillGr;
                $t4 = $bitem->LCCode;
                $t5 = $bitem->Descript;
                $t6 = $bitem->QTY;
                $t7 = $bitem->UnitPrice;
                $t8 = $bitem->ChargeAmt;
                $t9 = $bitem->Discount;
                $t10 = $bitem->ProcedureSeq;
                $t11 = $bitem->DiagnosisSeq;
                $t12 = $bitem->ClaimSys;
                $t13 = $bitem->BillGrCS;
                $t14 = $bitem->CSCode;
                $t15 = $bitem->CodeSys;
                $t16 = $bitem->STDCode;
                $t17 = $bitem->ClaimCat;
                $t18 = $bitem->DateRev;
                $t19 = $bitem->ClaimUP;
                $t20 = $bitem->ClaimAmt;

                $strTextbill = "\n" . $t1 . "|" . $t2 . "|" . $t3 . "|" . $t4 . "|" . $t5 . "|" . $t6 . "|" . $t7 . "|" . $t8 . "|" . $t9 . "|" . $t10 . "|" . $t11 . "|" . $t12 . "|" . $t13 . "|" . $t14 . "|" . $t15 . "|" . $t16 . "|" . $t17 . "|" . $t18 . "|" . $t19 . "|" . $t20;
                $ansitxt_bitemss = iconv('UTF-8', 'TIS-620', $strTextbill);
                fwrite($objFopen_opd, $ansitxt_bitemss);
            }
            $sum_billitems_ = DB::connection('mysql')->select('SELECT SUM(ChargeAmt) as Total from d_abillitems WHERE AN ="'.$value_an->an.'" GROUP BY AN');
            foreach ($sum_billitems_ as $key => $value_sum) {
                $sum_billitems = $value_sum->Total;
            }
            $opd_head = "\n" . '</BillItems>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<InvAddDiscount>0.00</InvAddDiscount>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<DRGCharge>' . $sum_billitems . '</DRGCharge>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<XDRGClaim>0.0000</XDRGClaim>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '</Invoices>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '<Coinsurance> </Coinsurance>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n" . '</CIPN>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n";
            fwrite($objFopen_opd, $opd_head);
            if($objFopen_opd){
                echo "File BillTran writed."."<BR>";
            }else{
                echo "File BillTran can not write";
            }
            fclose($objFopen_opd);

            $opd_head = "\n";
            $md5file = md5_file($file_pat,FALSE);
            $mdup = strtoupper($md5file);
            $objFopen_opd = fopen($file_pat, 'a');
            $opd_head = '<?EndNote HMAC="'.$mdup.'"?>';
            fwrite($objFopen_opd, $opd_head);
            $opd_head = "\n";
            fwrite($objFopen_opd, $opd_head);
            if($objFopen_opd){
                echo "File BillDisp MD5 writed."."<BR>";
            }else{
                echo "File BillDisp MD5 can not write";
            }
            fclose($objFopen_opd);


        }
            // ********************HASH MD5********************

            // $pathdir = "Export_AIPN/".$folder."/";
            // $zipcreated = $folder . ".zip";
            // $zip = new ZipArchive;
            // if ($zip->open(public_path($zipcreated), ZipArchive::CREATE) === TRUE) {
            //     $files = File::files(public_path("Export_AIPN/" . $folder . "/"));
            //     foreach ($files as $key => $value) {
            //         $relativenameInZipFile = basename($value);
            //         $zip->addFile($value, $relativenameInZipFile);
            //     }
            //     $zip->close();
            // }
            // return response()->download(public_path($zipcreated));
            // dd($zipcreated);

            // $newzip = new ZipArchive;
            // if ($newzip->open($zipcreated, ZipArchive::CREATE) === TRUE) {
            //     $dir = opendir($pathdir);
            //     while ($file = readdir($dir)) {
            //         if (is_file($pathdir . $file)) {
            //             $newzip->addFile($pathdir . $file, $file);
            //         }
            //     }
            //     // dd($newzip);
            //     $newzip->close();
            //     if (file_exists($zipcreated)) {
            //         header('Content-Type: application/zip');
            //         header('Content-Disposition: attachment; filename="' . basename($zipcreated) . '"');
            //         header('Content-Length: ' . filesize($zipcreated));
            //         flush();
            //         readfile($zipcreated);
            //         unlink($zipcreated);
            //         $files = glob($pathdir . '/*');

            //         foreach ($files as $file) {
            //             if (is_file($file)) {
            //             }
            //         }
            //         // return redirect()->back();
            //         return redirect()->route('claim.aipn');
            //         // return response()->json([
            //         //     'status'    => '200'
            //         // ]);
            //     }
            // }
    }

 }
