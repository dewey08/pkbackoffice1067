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


class AccountPKController extends Controller
{
     // ดึงข้อมูลมาไว้เช็คสิทธิ์
     public function sit_accpull_auto(Request $request)
     {
             $data_sits = DB::connection('mysql3')->select('
                 SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,pt.nhso_code,o.hospmain,o.hospsub
                 FROM ovst o
                 join patient p on p.hn=o.hn
                 JOIN pttype pt on pt.pttype=o.pttype
                 JOIN opduser op on op.loginname = o.staff
                 WHERE o.vstdate BETWEEN "2023-07-01" AND "2023-07-05"
                 group by p.cid
                 limit 1500
             ');
            //  BETWEEN "2023-07-01" AND "2023-07-05"
             // CURDATE()
             foreach ($data_sits as $key => $value) {
                 $check = Check_sit_auto::where('vn', $value->vn)->count();
                 if ($check == 0) {
                     Check_sit_auto::insert([
                         'vn' => $value->vn,
                         'an' => $value->an,
                         'hn' => $value->hn,
                         'cid' => $value->cid,
                         'vstdate' => $value->vstdate,
                         'vsttime' => $value->vsttime,
                         'fullname' => $value->fullname,
                         'pttype' => $value->pttype,
                         'hospmain' => $value->hospmain,
                         'hospsub' => $value->hospsub,
                         'staff' => $value->staff
                     ]);
                 }
             }
             $data_sits_ipd = DB::connection('mysql3')->select('
                     SELECT a.an,a.vn,p.hn,p.cid,a.dchdate,a.pttype
                     from hos.opitemrece op
                     LEFT JOIN hos.ipt ip ON ip.an = op.an
                     LEFT JOIN hos.an_stat a ON ip.an = a.an
                     LEFT JOIN hos.vn_stat v on v.vn = a.vn
                     LEFT JOIN patient p on p.hn=a.hn
                     WHERE a.dchdate BETWEEN "2023-07-01" AND "2023-07-05"
                     group by p.cid
                     limit 1500

             ');
            //  BETWEEN "2023-06-11" AND "2023-06-30"
             // CURDATE()
             foreach ($data_sits_ipd as $key => $value2) {
                 $check = Check_sit_auto::where('an', $value2->an)->count();
                 if ($check == 0) {
                     Check_sit_auto::insert([
                         'vn' => $value2->vn,
                         'an' => $value2->an,
                         'hn' => $value2->hn,
                         'cid' => $value2->cid,
                         'pttype' => $value2->pttype,
                         'dchdate' => $value2->dchdate
                     ]);
                 }
             }
             return view('authen.sit_pull_auto');
     }
    public function sit_acc_debtorauto(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        $token_data = DB::connection('mysql')->select('
            SELECT cid,token FROM ssop_token
        ');

        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        $data_sitss = DB::connection('mysql')->select('
        SELECT cid,vn,an
		FROM acc_debtor
		WHERE vstdate BETWEEN "2023-07-01" AND "2023-07-05"
		AND subinscl IS NULL AND subinscl IS NULL AND status IS NULL
		LIMIT 100
        ');
        // BETWEEN "2023-01-05" AND "2023-05-16"       CURDATE()
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $an = $item->an;
            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        // "person_id" => "$pids"
                        "person_id" => "3450101451327"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);

            // $contents = $client->__soapCall('nhsoDataSetC1',$params);
            // dd( $contents);
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

                // dd( @$subinscl);
                IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                    $date = date("Y-m-d");
                    Check_sit_auto::where('vn', $vn)
                        ->update([
                            'status' => 'จำหน่าย/เสียชีวิต',
                            'maininscl' => @$maininscl,
                            'startdate' => @$startdate,
                            'hmain' => @$hmain,
                            'subinscl' => @$subinscl,
                            'person_id_nhso' => @$person_id_nhso,
                            'hmain_op' => @$hmain_op,
                            'hmain_op_name' => @$hmain_op_name,
                            'hsub' => @$hsub,
                            'hsub_name' => @$hsub_name,
                            'subinscl_name' => @$subinscl_name,
                            'upsit_date'    => $date
                    ]);

                    Acc_debtor::where('vn', $vn)
                        ->update([
                            'status' => 'จำหน่าย/เสียชีวิต',
                            'maininscl' => @$maininscl,
                            'hmain' => @$hmain,
                            'subinscl' => @$subinscl,
                            'pttype_spsch' => @$subinscl,
                            'hsub' => @$hsub,

                    ]);
                }elseif(@$maininscl !="" || @$subinscl !=""){

                    // dd( $vn);
                        $date2 = date("Y-m-d");
                            Check_sit_auto::where('vn', $vn)
                            ->update([
                                'status' => @$status,
                                'maininscl' => @$maininscl,
                                'startdate' => @$startdate,
                                'hmain' => @$hmain,
                                'subinscl' => @$subinscl,
                                'person_id_nhso' => @$person_id_nhso,
                                'hmain_op' => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub' => @$hsub,
                                'hsub_name' => @$hsub_name,
                                'subinscl_name' => @$subinscl_name,
                                'upsit_date'    => $date2
                            ]);

                            Acc_debtor::where('vn', $vn)
                                ->update([
                                    'status' => 'จำหน่าย/เสียชีวิต',
                                    'maininscl' => @$maininscl,
                                    'hmain' => @$hmain,
                                    'subinscl' => @$subinscl,
                                    'pttype_spsch' => @$subinscl,
                                    'hsub' => @$hsub,
                                ]);

                // }else{

                //     Acc_debtor::where('vn', $vn)
                //     ->update([
                //         'status' => @$status,
                //         'maininscl' => @$maininscl,
                //         'hmain' => @$hmain,
                //         'subinscl' => @$subinscl,
                //         'pttype_spsch' => @$subinscl,
                //         'hsub' => @$hsub,
                //     ]);
                }

            }
        }

        return view('account_pk.sit_acc_debtorauto');

    }
    public function account_pk_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.217"
                    group by month(a.dchdate) desc;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
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
                    and account_code="1102050101.217"
                    group by month(a.dchdate) desc;
            ');
        }

        return view('account_pk.account_pk_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow,
            'leave_month_year' =>  $leave_month_year,
        ]);
    }
    public function account_pk(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($enddate);
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        $check = Acc_debtor::count();

        if ($startdate == '') {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('vstdate', [$datenow, $datenow])->get();
        } else {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('vstdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_pk', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            // 'datashow'       =>     $datashow
        ]);
    }
    public function account_pksave(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $datashow = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                    ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                    ,v.hospmain
                    ,o.vstdate as vstdatesave
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                    ,ptt.pttype_eclaim_id
                    ,o.pttype
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code
                    ,e.name as account_name
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
                from ovst o
                left join vn_stat v on v.vn=o.vn
                left join patient pt on pt.hn=o.hn
                LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                LEFT JOIN opitemrece op ON op.vn = o.vn

            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"

            group by o.vn
        ');
        // and o.an IS NULL
            foreach ($datashow as $key => $value) {
                $check = Acc_debtor::where('vn', $value->vn)->count();
                // $check = Acc_debtor::where('vn', $value->vn)->whereBetween('vstdate', [$startdate, $enddate])->count();
                if ($check > 0) {
                    // Acc_debtor::where('vn', $value->vn)
                    // ->update([
                    //     'hn'                => $value->hn,
                    //     'an'                => $value->an,
                    //     'cid'               => $value->cid,
                    //     'ptname'            => $value->ptname,
                    //     'ptsubtype'         => $value->ptsubtype,
                    //     'pttype_eclaim_id'  => $value->pttype_acc_eclaimid,
                    //     'hospmain'          => $value->hospmain,
                    //     'pttype'            => $value->pttype,
                    //     'pttypename'        => $value->pttype_acc_name,
                    //     'vstdate'           => $value->vstdatesave,
                    //     'vsttime'           => $value->vsttime,
                    //     'gfmis'             => $value->gfmis,
                    //     'acc_code'          => $value->acc_code,
                    //     'account_code'      => $value->account_code,
                    //     'account_name'      => $value->account_name,
                    //     'income'            => $value->income,
                    //     'uc_money'          => $value->uc_money,
                    //     'discount_money'    => $value->discount_money,
                    //     'paid_money'        => $value->paid_money,
                    //     'rcpt_money'        => $value->rcpt_money,
                    //     'rcpno'             => $value->rcpno,
                    //     'debit'             => $value->debit
                    // ]);
                } else {
                    // if ($check == 0) {
                    Acc_debtor::insert([
                        'hn'                 => $value->hn,
                        'an'                 => $value->an,
                        'vn'                 => $value->vn,
                        'cid'                => $value->cid,
                        'ptname'             => $value->ptname,
                        'ptsubtype'          => $value->ptsubtype,
                        'pttype_eclaim_id'   => $value->pttype_eclaim_id,
                        'hospmain'           => $value->hospmain,
                        'pttype'             => $value->pttype,
                        'vstdate'            => $value->vstdatesave,
                        'vsttime'            => $value->vsttime,
                        'acc_code'           => $value->acc_code,
                        'account_code'       => $value->account_code,
                        'account_name'       => $value->account_name,
                        'income'             => $value->income,
                        'uc_money'           => $value->uc_money,
                        'discount_money'     => $value->discount_money,
                        'paid_money'         => $value->paid_money,
                        'rcpt_money'         => $value->rcpt_money,
                        'rcpno'              => $value->rcpno,
                        'debit'              => $value->debit,
                        'debit_drug'         => $value->debit_drug,
                        'debit_instument'    => $value->debit_instument,
                        'debit_toa'          => $value->debit_toa,
                        'debit_refer'        => $value->debit_refer,
                        'max_debt_amount'    => $value->max_debt_money
                    ]);

                $acc_opitemrece_ = DB::connection('mysql3')->select('
                    SELECT o.vn,o.an,o.hn,o.vstdate,o.rxdate,o.income as income_group,o.pttype,o.paidst
                    ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                    FROM opitemrece o
                    LEFT JOIN vn_stat v ON v.vn = o.vn
                    left outer join s_drugitems s on s.icode = o.icode
                    WHERE o.vn ="'.$value->vn.'"

                ');
                foreach ($acc_opitemrece_ as $key => $va2) {
                    Acc_opitemrece::insert([
                        'hn'                 => $va2->hn,
                        'an'                 => $va2->an,
                        'vn'                 => $va2->vn,
                        'pttype'             => $va2->pttype,
                        'paidst'             => $va2->paidst,
                        'rxdate'             => $va2->rxdate,
                        'vstdate'            => $va2->vstdate,
                        'income'             => $va2->income_group,
                        'icode'              => $va2->icode,
                        'name'               => $va2->iname,
                        'qty'                => $va2->qty,
                        'cost'               => $va2->cost,
                        'finance_number'     => $va2->finance_number,
                        'unitprice'          => $va2->unitprice,
                        'discount'           => $va2->discount,
                        'sum_price'          => $va2->sum_price,
                    ]);
                }
            }
            }

        return response()->json([
            'status'        => '200'
        ]);
    }
    public function account_pkCheck_sit(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $date = date('Y-m-d');

        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token
        ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        // $data_sitss = DB::connection('mysql')->select('
        //     SELECT *
        //     FROM acc_debtor
        //     WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        //     AND pttype_spsch IS NULL
        // ');
        $data_sitss = Acc_debtor::whereBetween('vstdate', [$startdate, $enddate])
        ->whereNull('pttype_spsch')
        ->get();
        //   dd($data_sitss);
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $hn = $item->hn;
            $vsttime = $item->vsttime;
            $vstdate = $item->vstdate;
            $ptname = $item->ptname;

            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);
        //    dd($contents);
            foreach ($contents as $key => $v) {
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
                IF(@$maininscl =="" || @$maininscl==null || @$status =="003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                        $date_now = date('Y-m-d');
                        Acc_debtor::where('vn', $vn)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'      => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl,
                                'hmain_op'       => @$hmain_op,
                                'hmain_op_name'  => @$hmain_op_name,
                                'hsub'           => @$hsub,
                                'hsub_name'      => @$hsub_name,
                                'subinscl_name'  => @$subinscl_name
                            ]);
                  }elseif(@$maininscl !="" || @$subinscl !=""){
                        $date_now2 = date('Y-m-d');
                        Acc_debtor::where('vn', $vn)
                            ->update([
                                'status'        => @$status,
                                'maininscl'     => @$maininscl,
                                'pttype_spsch'     => @$subinscl,
                                'hmain'         => @$hmain,
                                'subinscl'      => @$subinscl,
                                'hmain_op'      => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub'          => @$hsub,
                                'hsub_name'     => @$hsub_name,
                                'subinscl_name' => @$subinscl_name
                            ]);

                  }

            }
        }
        $acc_debtor = Acc_debtor::whereBetween('vstdate', [$startdate, $enddate])->get();

        return response()->json([
            'status'     => '200',
            'acc_debtor'    => $acc_debtor,
            'start'     => $startdate,
            'end'        => $enddate,
        ]);
    }
    public function account_pkCheck_sitipd(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $date = date('Y-m-d');

        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token
        ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        // $data_sitss = DB::connection('mysql')->select('
        //     SELECT *
        //     FROM acc_debtor
        //     WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        //     AND pttype_spsch IS NULL
        // ');
        $data_sitss = Acc_debtor::whereBetween('dchdate', [$startdate, $enddate])
        ->whereNull('pttype_spsch')
        ->get();
        //   dd($data_sitss);
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $an = $item->an;
            $vn = $item->vn;
            $hn = $item->hn;
            $vsttime = $item->vsttime;
            $vstdate = $item->vstdate;
            $ptname = $item->ptname;

            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);

            foreach ($contents as $key => $v) {
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
                IF(@$maininscl =="" || @$maininscl==null || @$status =="003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                        $date_now = date('Y-m-d');
                        Acc_debtor::where('an', $an)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'      => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl,
                                'hmain_op'       => @$hmain_op,
                                'hmain_op_name'  => @$hmain_op_name,
                                'hsub'           => @$hsub,
                                'hsub_name'      => @$hsub_name,
                                'subinscl_name'  => @$subinscl_name
                            ]);
                  }elseif(@$maininscl !="" || @$subinscl !=""){
                        $date_now2 = date('Y-m-d');
                        Acc_debtor::where('an', $an)
                            ->update([
                                'status'        => @$status,
                                'maininscl'     => @$maininscl,
                                'pttype_spsch'     => @$subinscl,
                                'hmain'         => @$hmain,
                                'subinscl'      => @$subinscl,
                                'hmain_op'      => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub'          => @$hsub,
                                'hsub_name'     => @$hsub_name,
                                'subinscl_name' => @$subinscl_name
                            ]);
                // }elseif(@$maininscl !="" || @$subinscl !=""){
                //             $date_now2 = date('Y-m-d');
                //             Acc_debtor::where('an', $an)
                //                 ->update([
                //                     'status'        => @$status,
                //                     'maininscl'     => @$maininscl,
                //                     'pttype_spsch'     => @$subinscl,
                //                     'hmain'         => @$hmain,
                //                     'subinscl'      => @$subinscl,
                //                     'hmain_op'      => @$hmain_op,
                //                     'hmain_op_name' => @$hmain_op_name,
                //                     'hsub'          => @$hsub,
                //                     'hsub_name'     => @$hsub_name,
                //                     'subinscl_name' => @$subinscl_name
                //                 ]);
                    }else{
                        $date_now2 = date('Y-m-d');
                        Acc_debtor::where('an', $an)
                            ->update([
                                'status'        => @$status,
                                'maininscl'     => @$maininscl,
                                'pttype_spsch'     => @$subinscl,
                                'hmain'         => @$hmain,
                                'subinscl'      => @$subinscl,
                                'hmain_op'      => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub'          => @$hsub,
                                'hsub_name'     => @$hsub_name,
                                'subinscl_name' => @$subinscl_name
                            ]);

                  }

            }
        }
        $acc_debtor = Acc_debtor::whereBetween('vstdate', [$startdate, $enddate])->get();

        return response()->json([
            'status'     => '200',
            'acc_debtor'    => $acc_debtor,
            'start'     => $startdate,
            'end'        => $enddate,
        ]);
    }

    // ***************** และ stam OPD********************************
    public function account_pk_debtor(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);

        foreach ($data as $key => $value) {
            $check = Acc_debtor_stamp::where('stamp_vn', $value->vn)->count();
            if ($check > 0) {
                Acc_debtor_stamp::where('stamp_vn', $value->vn)
                ->update([
                    // 'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime,
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code,
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'acc_debtor_userid' => $iduser
                ]);
            } else {
                $date = date('Y-m-d H:m:s');
                Acc_debtor_stamp::insert([
                    'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime,
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code,
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'created_at'=> $date,
                    'acc_debtor_userid' => $iduser

                ]);
            }
        }

        return response()->json([
            'status'    => '200'
        ]);
    }

    // ***************** Send การเงิน ********************************
    public function acc_debtor_send(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

            // Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
            //         ->update([
            //             'stamp' => 'Y'
            //         ]);

        foreach ($data as $key => $value) {
            $check = Acc_debtor_sendmoney::where('send_vn', $value->vn)->count();
            if ($check > 0) {
                Acc_debtor_stamp::where('send_vn', $value->vn)
                ->update([
                    'send_vn' => $value->vn,
                    'send_hn' => $value->hn,
                    'send_an' => $value->an,
                    'send_cid' => $value->cid,
                    'send_ptname' => $value->ptname,
                    'send_vstdate' => $value->vstdate,
                    'send_vsttime' => $value->vsttime,
                    'send_dchdate' => $value->dchdate,
                    'send_pttype' => $value->pttype,
                    'send_pttype_nhso' => $value->pttype_spsch,
                    'send_acc_code' => $value->acc_code,
                    'send_account_code' => $value->account_code,
                    'send_income' => $value->income,
                    'send_uc_money' => $value->uc_money,
                    'send_discount_money' => $value->discount_money,
                    'send_paid_money' => $value->paid_money,
                    'send_rcpt_money' => $value->rcpt_money,
                    'send_rcpno' => $value->rcpno,
                    'send_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'acc_debtor_userid' => $iduser
                ]);
            } else {
                $date = date('Y-m-d H:m:s');
                Acc_debtor_sendmoney::insert([
                    'send_vn' => $value->vn,
                    'send_hn' => $value->hn,
                    'send_an' => $value->an,
                    'send_cid' => $value->cid,
                    'send_ptname' => $value->ptname,
                    'send_vstdate' => $value->vstdate,
                    'send_vsttime' => $value->vsttime,
                    'send_dchdate' => $value->dchdate,
                    'send_pttype' => $value->pttype,
                    'send_pttype_nhso' => $value->pttype_spsch,
                    'send_acc_code' => $value->acc_code,
                    'send_account_code' => $value->account_code,
                    'send_income' => $value->income,
                    'send_uc_money' => $value->uc_money,
                    'send_discount_money' => $value->discount_money,
                    'send_paid_money' => $value->paid_money,
                    'send_rcpt_money' => $value->rcpt_money,
                    'send_rcpno' => $value->rcpno,
                    'send_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'created_at'=> $date,
                    'acc_debtor_userid' => $iduser
                ]);
            }
        }

        return response()->json([
            'status'    => '200'
        ]);
    }

    // *************************** IPD *******************************************

    public function account_pk_ipd(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
        } else {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_pk_ipd',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_pk_ipdsave(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            GROUP BY a.an;
        ');
        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->fullname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'regdate'            => $value->admdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->code,
                            'account_code'       => $value->pang_debit,
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
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money
                        ]);
                    }

                    if ($value->debit_toa > 0) {
                            Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                            ->update([
                                'acc_code'         => "03",
                                'account_code'     => "1102050101.217",
                                'account_name'     => "บริการเฉพาะ(CR)"
                            ]);
                    }
                    if ($value->debit_instument > 0 && $value->pang_debit =='1102050101.202') {
                            $checkins = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->count();

                            if ($checkins == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '02',
                                    'debit'              => $value->debit_instument,
                                    'debit_ipd_total'    => $value->debit_instument
                                ]);
                            }
                    }
                    if ($value->debit_drug > 0 && $value->pang_debit =='1102050101.202') {
                            $checkindrug = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_drug)->count();
                            if ($checkindrug == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '03',
                                    'debit'              => $value->debit_drug,
                                    'debit_ipd_total'    => $value->debit_drug
                                ]);
                            }
                    }
                    if ($value->debit_refer > 0 && $value->pang_debit =='1102050101.202') {
                        $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_refer)->count();
                        if ($checkinrefer == 0) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->fullname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate,
                                'regdate'            => $value->admdate,
                                'dchdate'            => $value->dchdate,
                                'acc_code'           => "03",
                                'account_code'       => '1102050101.217',
                                'account_name'       => 'บริการเฉพาะ(CR)',
                                'income_group'       => '20',
                                'debit'              => $value->debit_refer,
                                'debit_ipd_total'    => $value->debit_refer
                            ]);
                        }
                    }

                    $acc_opitemrece_ = DB::connection('mysql3')->select('
                            SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                            ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                            FROM opitemrece o
                            LEFT JOIN an_stat a ON o.an = a.an
                            left outer join s_drugitems s on s.icode = o.icode
                            WHERE o.an ="'.$value->an.'"

                    ');
                    foreach ($acc_opitemrece_ as $key => $va2) {
                        Acc_opitemrece::insert([
                            'hn'                 => $va2->hn,
                            'an'                 => $va2->an,
                            'vn'                 => $va2->vn,
                            'pttype'             => $va2->pttype,
                            'paidst'             => $va2->paidst,
                            'rxdate'             => $va2->rxdate,
                            'vstdate'            => $va2->vstdate,
                            'dchdate'            => $va2->dchdate,
                            'income'             => $va2->income_group,
                            'icode'              => $va2->icode,
                            'name'               => $va2->iname,
                            'qty'                => $va2->qty,
                            'cost'               => $va2->cost,
                            'finance_number'     => $va2->finance_number,
                            'unitprice'          => $va2->unitprice,
                            'discount'           => $va2->discount,
                            'sum_price'          => $va2->sum_price,
                        ]);
                    }
        }
        return response()->json([
            'status'    => '200'
        ]);
    }

    // *************************** 217 ********************************************

    public function account_pkucs217_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate asc;
            ');
            // AND a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

            // SELECT a.*,c.subinscl from acc_debtor a
            // left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate
            // WHERE a.account_code="1102050101.217"
            // AND a.stamp = "N"
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
            // order by a.dchdate asc;
        } else {
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate asc;
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }
        return view('account_pk.account_pkucs217_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkucs217_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                    ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                    ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                    ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                    ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                    ,a.income-a.rcpt_money-a.discount_money as looknee_money
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    from ipt ip
                    LEFT JOIN hos.an_stat a ON ip.an = a.an
                    LEFT JOIN patient pt on pt.hn=a.hn
                    LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN hos.opitemrece op ON ip.an = op.an
                    LEFT JOIN hos.vn_stat v on v.vn = a.vn
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND ec.ar_ipd IN("1102050101.217","1102050101.202")
                GROUP BY a.an;
        ');
        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->fullname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'regdate'            => $value->admdate,
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
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }
                    if ($value->debit_toa > 0) {
                            Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                            ->update([
                                'acc_code'         => "03",
                                'account_code'     => "1102050101.217",
                                'account_name'     => "บริการเฉพาะ(CR)"
                            ]);
                    }
                    if ($value->debit_instument > 0 && $value->pang_debit =='1102050101.202') {
                            $checkins = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->count();
                            if ($checkins == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '02',
                                    'debit'              => $value->debit_instument,
                                    'debit_total'        => $value->debit_instument
                                ]);
                            }
                    }
                    if ($value->debit_drug > 0 && $value->pang_debit =='1102050101.202') {
                            $checkindrug = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_drug)->count();
                            if ($checkindrug == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '03',
                                    'debit'              => $value->debit_drug,
                                    'debit_total'    => $value->debit_drug
                                ]);
                            }
                    }
                    if ($value->debit_refer > 0 && $value->pang_debit =='1102050101.202') {
                        $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_refer)->count();
                        if ($checkinrefer == 0) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->fullname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate,
                                'regdate'            => $value->admdate,
                                'dchdate'            => $value->dchdate,
                                'acc_code'           => "03",
                                'account_code'       => '1102050101.217',
                                'account_name'       => 'บริการเฉพาะ(CR)',
                                'income_group'       => '20',
                                'debit'              => $value->debit_refer,
                                'debit_total'        => $value->debit_refer
                            ]);
                        }
                    }

                    // Acc_opitemrece::where('an', '=', $value->an)->delete();

                    // $acc_opitemrece_ = DB::connection('mysql3')->select('
                    //         SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                    //         ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                    //         FROM opitemrece o
                    //         LEFT JOIN an_stat a ON o.an = a.an
                    //         left outer join s_drugitems s on s.icode = o.icode
                    //         WHERE o.an ="'.$value->an.'"
                    // ');
                    // foreach ($acc_opitemrece_ as $key => $va2) {
                    //     Acc_opitemrece::insert([
                    //         'hn'                 => $va2->hn,
                    //         'an'                 => $va2->an,
                    //         'vn'                 => $va2->vn,
                    //         'pttype'             => $va2->pttype,
                    //         'paidst'             => $va2->paidst,
                    //         'rxdate'             => $va2->rxdate,
                    //         'vstdate'            => $va2->vstdate,
                    //         'dchdate'            => $va2->dchdate,
                    //         'income'             => $va2->income_group,
                    //         'icode'              => $va2->icode,
                    //         'name'               => $va2->iname,
                    //         'qty'                => $va2->qty,
                    //         'cost'               => $va2->cost,
                    //         'finance_number'     => $va2->finance_number,
                    //         'unitprice'          => $va2->unitprice,
                    //         'discount'           => $va2->discount,
                    //         'sum_price'          => $va2->sum_price,
                    //     ]);
                    // }
        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs217_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.217"
                    group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
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
                    and account_code="1102050101.217"
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
        }

        return view('account_pk.account_pkucs217_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow,
            'leave_month_year' =>  $leave_month_year,
        ]);
    }
    public function account_pkucs217(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
            SELECT * from acc_debtor
            WHERE account_code="1102050101.217"
            AND stamp = "N"
            and account_code="1102050101.217"
            and month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"
            order by dchdate asc;
        ');

        return view('account_pk.account_pkucs217', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs217_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_217
            WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"
            AND status = "N"
        ');

        return view('account_pk.account_pkucs217_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs217_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        Acc_1102050101_217_stam::truncate();
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);

        foreach ($data as $key => $value) {
            Acc_1102050101_217_stam::insert([
                'vn'                => $value->vn,
                'hn'                => $value->hn,
                'an'                => $value->an,
                'cid'               => $value->cid,
                'ptname'            => $value->ptname,
                'vstdate'           => $value->vstdate,
                'regdate'           => $value->regdate,
                'dchdate'           => $value->dchdate,
                'pttype'            => $value->pttype,
                'income_group'      => $value->income_group,
                'account_code'      => $value->account_code,
                'debit'             => $value->debit,
                'debit_total'       => $value->debit_total,
                'acc_debtor_userid' => $iduser
            ]);
        }
        $acc_217_stam = DB::connection('mysql')->select('
            SELECT vn,an,hn,cid,ptname,vstdate,dchdate,pttype,income_group,account_code,sum(debit) as debit,sum(debit_total) as debit_total,acc_debtor_userid
            from acc_1102050101_217_stam
            GROUP BY an;
        ');
        foreach ($acc_217_stam as $key => $value2) {
                Acc_1102050101_217::insert([
                'vn'                => $value2->vn,
                'hn'                => $value2->hn,
                'an'                => $value2->an,
                'cid'               => $value2->cid,
                'ptname'            => $value2->ptname,
                'vstdate'           => $value2->vstdate,
                'dchdate'           => $value2->dchdate,
                'pttype'            => $value2->pttype,
                'income_group'      => $value2->income_group,
                'account_code'      => $value2->account_code,
                'debit'             => $value2->debit,
                'debit_total'       => $value2->debit_total,
                'acc_debtor_userid' => $value2->acc_debtor_userid
            ]);

        }
        $acc_opitemrece_ = DB::connection('mysql')->select('
                SELECT * from

                (SELECT ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                FROM acc_opitemrece ao
                LEFT JOIN acc_1102050101_217_stam a On ao.an = a.an
                WHERE income ="02"

                union

                SELECT ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                FROM acc_opitemrece ao
                LEFT JOIN acc_1102050101_217_stam a On ao.an = a.an
                WHERE icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015","3001412","3001417","3010829","3010726")

                ) as tmp

        ');
        foreach ($acc_opitemrece_ as $va2) {
            Acc_opitemrece_stm::insert([
                'hn'                 => $va2->hn,
                'an'                 => $va2->an,
                'vn'                 => $va2->vn,
                'vstdate'            => $va2->vstdate,
                'pttype'             => $va2->pttype,
                'paidst'             => $va2->paidst,
                'finance_number'     => $va2->finance_number,
                'income'             => $va2->income,
                'icode'              => $va2->icode,
                'name'               => $va2->dname,
                'qty'                => $va2->qty,
                'cost'               => $va2->cost,
                'unitprice'          => $va2->unitprice,
                'discount'           => $va2->discount,
                'sum_price'          => $va2->sum_price
            ]);

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs217_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
            ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue,s.STMdoc
            ,s.inst+s.hc+s.hc_drug+s.ae+s.ae_drug as stm217
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs s ON s.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" 
            AND (s.hc_drug >0 or s.hc >0 or s.ae >0 or s.ae_drug >0 or s.inst >0)
            group by a.an 
        ');
        // AND s.rep IS NOT NULL

        $sum_money_ = DB::connection('mysql')->select('
            SELECT SUM(a.debit_total) as total
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        ');
        foreach ($sum_money_ as $key => $value) {
            $sum_debit_total = $value->total;
        }
            $sum_stm_ = DB::connection('mysql')->select('
            SELECT SUM(au.inst) as stmtotal
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        ');
        foreach ($sum_stm_ as $key => $value) {
            $sum_stm_total = $value->stmtotal;
        }
        // $sum_stm_ = DB::connection('mysql')->select('
        //     SELECT SUM(au.total_approve) as total
        //     from acc_1102050101_217 a
        //     LEFT JOIN acc_stm_ucs au ON au.an = a.an
        //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        // ');
        // foreach ($sum_stm_ as $key => $value) {
        //     $sum_debit_total = $value->total;
        // }

            return view('account_pk.account_pkucs217_stm', $data, [
                'startdate'         =>     $startdate,
                'enddate'           =>     $enddate,
                'datashow'          =>     $datashow,
                'months'            =>     $months,
                'year'              =>     $year,
                'sum_debit_total'   =>     $sum_debit_total,
                'sum_stm_total'     =>     $sum_stm_total
            ]);
    }
    public function account_pkucs217_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue
                from acc_1102050101_217 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE a.status ="N"
                AND month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
                GROUP BY a.an
        ');

        $sum_money_ = DB::connection('mysql')->select('
            SELECT SUM(a.debit_total) as total
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
        ');
        foreach ($sum_money_ as $key => $value) {
            $sum_debit_total = $value->total;
        }
        $sum_stm_ = DB::connection('mysql')->select('
            SELECT SUM(au.inst) as stmtotal
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
        ');
        foreach ($sum_stm_ as $key => $value) {
            $sum_stm_total = $value->stmtotal;
        }

        return view('account_pk.account_pkucs217_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_pkucs217_stmnull_all(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();
        $mototal = $months + 1;
        $datashow = DB::connection('mysql')->select('
                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue,au.STMdoc
                    from acc_1102050101_217 a
                    LEFT JOIN acc_stm_ucs au ON au.an = a.an
                    WHERE a.status ="N"
                    AND month(a.dchdate) < "'.$mototal.'"
                    and year(a.dchdate) = "'.$year.'"
                    AND au.ip_paytrue IS NULL
                    GROUP BY a.an

            ');
        return view('account_pk.account_pkucs217_stmnull_all', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }

    // *************************** 202 ********************************************
    public function account_pkucs202_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT *  from acc_debtor
                WHERE account_code="1102050101.202"
                AND stamp = "N"
                group by an
                order by vstdate asc;

            ');
            // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
            // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
            // AND a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            // SELECT a.*,c.subinscl from acc_debtor a
            // left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate

            // WHERE a.account_code="1102050101.202"
            // AND a.stamp = "N"
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
            // order by a.dchdate asc;
        } else {
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl  from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.202"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate asc;

            ');
            // ,c.subinscl
            // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }


        return view('account_pk.account_pkucs202_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_pkucs202_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ec.ar_ipd = "1102050101.202"
            GROUP BY a.an;
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->fullname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'regdate'            => $value->admdate,
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
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

                    if ($value->debit_toa > 0) {
                            Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                            ->update([
                                'acc_code'         => "03",
                                'account_code'     => "1102050101.217",
                                'account_name'     => "บริการเฉพาะ(CR)"
                            ]);
                    }
                    if ($value->debit_instument > 0 && $value->pang_debit =='1102050101.202') {
                            $checkins = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->count();

                            if ($checkins == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '02',
                                    'debit'              => $value->debit_instument,
                                    'debit_total'    => $value->debit_instument
                                ]);
                            }
                    }
                    if ($value->debit_drug > 0 && $value->pang_debit =='1102050101.202') {
                            $checkindrug = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_drug)->count();
                            if ($checkindrug == 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '03',
                                    'debit'              => $value->debit_drug,
                                    'debit_total'        => $value->debit_drug
                                ]);
                            }
                    }
                    if ($value->debit_refer > 0 && $value->pang_debit =='1102050101.202') {
                        $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_refer)->count();
                        if ($checkinrefer == 0) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->fullname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate,
                                'regdate'            => $value->admdate,
                                'dchdate'            => $value->dchdate,
                                'acc_code'           => "03",
                                'account_code'       => '1102050101.217',
                                'account_name'       => 'บริการเฉพาะ(CR)',
                                'income_group'       => '20',
                                'debit'              => $value->debit_refer,
                                'debit_total'        => $value->debit_refer
                            ]);
                        }
                    }
                    // Acc_opitemrece::where('an', '=', $value->an)->delete();

                    // $acc_opitemrece_ = DB::connection('mysql3')->select('
                    //         SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                    //         ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                    //         FROM opitemrece o
                    //         LEFT JOIN an_stat a ON o.an = a.an
                    //         left outer join s_drugitems s on s.icode = o.icode
                    //         WHERE o.an ="'.$value->an.'"

                    // ');

                    // foreach ($acc_opitemrece_ as $key => $va2) {
                    //     Acc_opitemrece::insert([
                    //         'hn'                 => $va2->hn,
                    //         'an'                 => $va2->an,
                    //         'vn'                 => $va2->vn,
                    //         'pttype'             => $va2->pttype,
                    //         'paidst'             => $va2->paidst,
                    //         'rxdate'             => $va2->rxdate,
                    //         'vstdate'            => $va2->vstdate,
                    //         'dchdate'            => $va2->dchdate,
                    //         'income'             => $va2->income_group,
                    //         'icode'              => $va2->icode,
                    //         'name'               => $va2->iname,
                    //         'qty'                => $va2->qty,
                    //         'cost'               => $va2->cost,
                    //         'finance_number'     => $va2->finance_number,
                    //         'unitprice'          => $va2->unitprice,
                    //         'discount'           => $va2->discount,
                    //         'sum_price'          => $va2->sum_price,
                    //     ]);
                    // }
        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_pkucs202_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total

                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.202"

                    group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total

                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.202"

                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
        }

            return view('account_pk.account_pkucs202_dash',[
                'startdate'     =>     $startdate,
                'enddate'       =>     $enddate,
                'datashow'    =>     $datashow,
                'leave_month_year' =>  $leave_month_year,
            ]);
    }
    public function account_pkucs202(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a
            left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate

            WHERE a.account_code="1102050101.202"
            AND a.stamp = "N"
            and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
            order by a.dchdate asc;

        ');

        return view('account_pk.account_pkucs202', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs202_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('

            SELECT *  from acc_1102050101_202
            WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"
            AND status = "N"
        ');
        // SELECT *,au.subinscl  from acc_1102050101_202 a
        //     LEFT JOIN acc_debtor au ON au.an = a.an
        //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";

        return view('account_pk.account_pkucs202_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs202_stam(Request $request)
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
                    Acc_1102050101_202::insert([
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
                        'debit_total'       => $value->debit - $value->debit_drug - $value->debit_instument - $value->debit_refer - $value->debit_toa,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                    ]);
                    $acc_opitemrece_ = DB::connection('mysql')->select('
                            SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                            FROM acc_opitemrece ao
                            LEFT JOIN acc_debtor a ON ao.an = a.an
                            WHERE a.account_code ="1102050101.202" AND a.stamp ="Y"
                            AND ao.an ="'.$value->an.'"
                    ');
                    foreach ($acc_opitemrece_ as $va2) {
                        Acc_opitemrece_stm::insert([
                            'hn'                 => $va2->hn,
                            'an'                 => $va2->an,
                            'vn'                 => $va2->vn,
                            'vstdate'            => $va2->vstdate,
                            'pttype'             => $va2->pttype,
                            'paidst'             => $va2->paidst,
                            'finance_number'     => $va2->finance_number,
                            'income'             => $va2->income,
                            'icode'              => $va2->icode,
                            'name'               => $va2->dname,
                            'qty'                => $va2->qty,
                            'cost'               => $va2->cost,
                            'unitprice'          => $va2->unitprice,
                            'discount'           => $va2->discount,
                            'sum_price'          => $va2->sum_price
                        ]);

                    }
        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs202_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
               SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
               ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue,s.STMdoc
               from acc_1102050101_202 a
            LEFT JOIN acc_stm_ucs s ON s.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND s.rep IS NOT NULL

        ');
        $sum_money_ = DB::connection('mysql')->select('
           SELECT SUM(a.debit_total) as total
           from acc_1102050101_202 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_money_ as $key => $value) {
           $sum_debit_total = $value->total;
       }
        $sum_stm_ = DB::connection('mysql')->select('
           SELECT SUM(au.inst) as stmtotal
           from acc_1102050101_202 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_stm_ as $key => $value) {
           $sum_stm_total = $value->stmtotal;
       }

        return view('account_pk.account_pkucs202_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_pkucs202_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

           $data = DB::connection('mysql')->select('
           SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue
           from acc_1102050101_202 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE status ="N"
           AND month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";


            ');
            // SELECT vn,an,hn,cid,ptname,dchdate,income_group,debit_total
            // ,inst
            // FROM acc_1102050101_202
            // WHERE status ="N"
           $sum_money_ = DB::connection('mysql')->select('
               SELECT SUM(a.debit_total) as total
               from acc_1102050101_202 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_money_ as $key => $value) {
               $sum_debit_total = $value->total;
           }
           $sum_stm_ = DB::connection('mysql')->select('
               SELECT SUM(au.inst) as stmtotal
               from acc_1102050101_202 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_stm_ as $key => $value) {
               $sum_stm_total = $value->stmtotal;
           }

        return view('account_pk.account_pkucs202_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_pkucs202_stmnull_all(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();
        $mototal = $months + 1;
        $datashow = DB::connection('mysql')->select('


                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue,au.STMdoc
                    from acc_1102050101_202 a
                    LEFT JOIN acc_stm_ucs au ON au.an = a.an
                    WHERE a.status ="N"
                    AND month(a.dchdate) < "'.$mototal.'"
                    and year(a.dchdate) = "'.$year.'"
                    AND au.ip_paytrue IS NULL
                    GROUP BY a.an



            ');
        return view('account_pk.account_pkucs202_stmnull_all', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }

    
     // ***************** 302********************************
     public function account_302_dash(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
 
         $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
         $date = date('Y-m-d');
         $y = date('Y') + 543;
         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
 
         if ($startdate == '') {
             $datashow = DB::select('
                     SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,count(distinct a.an) as an
                     ,sum(a.income) as income
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
 
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050101.302"
 
                     group by month(a.dchdate) desc;
             ');
             // and stamp = "N"
         } else {
             $datashow = DB::select('
                     SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,count(distinct a.an) as an
                     ,sum(a.income) as income
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
 
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050101.302"
 
                     group by month(a.dchdate) desc;
             ');
         }
 
             return view('account_pk.account_302_dash',[
                 'startdate'     =>     $startdate,
                 'enddate'       =>     $enddate,
                 'datashow'    =>     $datashow,
                 'leave_month_year' =>  $leave_month_year,
             ]);
     }
     public function account_302_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate

                WHERE a.account_code="1102050101.302"
                AND a.stamp = "N"
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_302_pull',[
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
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money
                ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype = "A7"
            GROUP BY a.an;
        ');

        // foreach ($acc_debtor as $key => $value) {
        //             $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.304')->whereBetween('dchdate', [$startdate, $enddate])->count();
        //             if ($check == 0) {
        //                 Acc_debtor::insert([
        //                     'hn'                 => $value->hn,
        //                     'an'                 => $value->an,
        //                     'vn'                 => $value->vn,
        //                     'cid'                => $value->cid,
        //                     'ptname'             => $value->fullname,
        //                     'pttype'             => $value->pttype,
        //                     'vstdate'            => $value->vstdate,
        //                     'regdate'            => $value->admdate,
        //                     'dchdate'            => $value->dchdate,
        //                     'acc_code'           => $value->code,
        //                     'account_code'       => $value->pang_debit,
        //                     'account_name'       => $value->account_name,
        //                     'income_group'       => $value->income_group,
        //                     'income'             => $value->income,
        //                     'uc_money'           => $value->uc_money,
        //                     'discount_money'     => $value->discount_money,
        //                     'paid_money'         => $value->cash_money,
        //                     'rcpt_money'         => $value->cash_money,
        //                     'debit'              => $value->looknee_money,
        //                     'debit_drug'         => $value->debit_drug,
        //                     'debit_instument'    => $value->debit_instument,
        //                     'debit_toa'          => $value->debit_toa,
        //                     'debit_refer'        => $value->debit_refer,
        //                     'fokliad'            => $value->fokliad,
        //                     'debit_total'        => $value->looknee_money,
        //                     'max_debt_amount'    => $value->max_debt_money,
        //                     'acc_debtor_userid'  => Auth::user()->id
        //                 ]);
        //             }

        //             if ($value->fokliad > 0 && $value->pang_debit =='1102050101.304') {
        //                 $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.302')->where('fokliad','=',$value->fokliad)->count();
        //                 if ($checkinrefer == 0) {
        //                     Acc_debtor::insert([
        //                         'hn'                 => $value->hn,
        //                         'an'                 => $value->an,
        //                         'vn'                 => $value->vn,
        //                         'cid'                => $value->cid,
        //                         'ptname'             => $value->fullname,
        //                         'pttype'             => $value->pttype,
        //                         'vstdate'            => $value->vstdate,
        //                         'regdate'            => $value->admdate,
        //                         'dchdate'            => $value->dchdate,
        //                         'acc_code'           => "38",
        //                         'account_code'       => '1102050101.3099',
        //                         'account_name'       => 'ประกันสังคม-ค่าใช้จ่ายสูง OP(ฟอกไต)',
        //                         'income_group'       => '11',
        //                         'debit'              => $value->debit_refer,
        //                         'debit_total'    => $value->debit_refer
        //                     ]);
        //                 }
        //             }
   
        // }

            return response()->json([

                'status'    => '200'
            ]);
    }

    // ***************** 304********************************
    public function account_304_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total

                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.304"

                    group by month(a.dchdate) desc;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total

                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.304"

                    group by month(a.dchdate) desc;
            ');
        }

            return view('account_pk.account_304_dash',[
                'startdate'     =>     $startdate,
                'enddate'       =>     $enddate,
                'datashow'    =>     $datashow,
                'leave_month_year' =>  $leave_month_year,
            ]);
    }
    public function account_304_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate

                WHERE a.account_code="1102050101.304"
                AND a.stamp = "N"
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_304_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_304_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money
                ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype = "s7"
            GROUP BY a.an;
        ');

        foreach ($acc_debtor as $key => $value) {
                    // $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.304')->whereBetween('dchdate', [$startdate, $enddate])->count();
                    // if ($check == 0) {
                    //     Acc_debtor::insert([
                    //         'hn'                 => $value->hn,
                    //         'an'                 => $value->an,
                    //         'vn'                 => $value->vn,
                    //         'cid'                => $value->cid,
                    //         'ptname'             => $value->fullname,
                    //         'pttype'             => $value->pttype,
                    //         'vstdate'            => $value->vstdate,
                    //         'regdate'            => $value->admdate,
                    //         'dchdate'            => $value->dchdate,
                    //         'acc_code'           => $value->code,
                    //         'account_code'       => $value->pang_debit,
                    //         'account_name'       => $value->account_name,
                    //         'income_group'       => $value->income_group,
                    //         'income'             => $value->income,
                    //         'uc_money'           => $value->uc_money,
                    //         'discount_money'     => $value->discount_money,
                    //         'paid_money'         => $value->cash_money,
                    //         'rcpt_money'         => $value->cash_money,
                    //         'debit'              => $value->looknee_money,
                    //         'debit_drug'         => $value->debit_drug,
                    //         'debit_instument'    => $value->debit_instument,
                    //         'debit_toa'          => $value->debit_toa,
                    //         'debit_refer'        => $value->debit_refer,
                    //         'debit_total'        => $value->looknee_money,
                    //         'max_debt_amount'    => $value->max_debt_money,
                    //         'acc_debtor_userid'  => Auth::user()->id
                    //     ]);
                    // }
                    // if ($value->fokliad > 0 && $value->pang_debit =='1102050101.304') {
                    // $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.302')->where('fokliad','=',$value->fokliad)->count();
                    // if ($checkinrefer == 0) {
                    //     Acc_debtor::insert([
                    //         'hn'                 => $value->hn,
                    //         'an'                 => $value->an,
                    //         'vn'                 => $value->vn,
                    //         'cid'                => $value->cid,
                    //         'ptname'             => $value->fullname,
                    //         'pttype'             => $value->pttype,
                    //         'vstdate'            => $value->vstdate,
                    //         'regdate'            => $value->admdate,
                    //         'dchdate'            => $value->dchdate,
                    //         'acc_code'           => "38",
                    //         'account_code'       => '1102050101.3099',
                    //         'account_name'       => 'ประกันสังคม-ค่าใช้จ่ายสูง OP(ฟอกไต)',
                    //         'income_group'       => '11',
                    //         'debit'              => $value->debit_refer,
                    //         'debit_total'    => $value->debit_refer
                    //     ]);
                    // }
                    // }
 
                     
        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_304_stam(Request $request)
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
                Acc_1102050101_304::insert([
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
                        'debit_total'       => $value->debit,
                        // 'debit_total'       => $value->debit - $value->debit_drug - $value->debit_instument - $value->debit_refer - $value->debit_toa,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                    ]);
                    $acc_opitemrece_ = DB::connection('mysql')->select('
                            SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                            FROM acc_opitemrece ao
                            LEFT JOIN acc_debtor a ON ao.an = a.an
                            WHERE a.account_code ="1102050101.304" AND a.stamp ="Y"
                            AND ao.an ="'.$value->an.'"
                    ');
                    foreach ($acc_opitemrece_ as $va2) {
                        Acc_opitemrece_stm::insert([
                            'hn'                 => $va2->hn,
                            'an'                 => $va2->an,
                            'vn'                 => $va2->vn,
                            'vstdate'            => $va2->vstdate,
                            'pttype'             => $va2->pttype,
                            'paidst'             => $va2->paidst,
                            'finance_number'     => $va2->finance_number,
                            'income'             => $va2->income,
                            'icode'              => $va2->icode,
                            'name'               => $va2->dname,
                            'qty'                => $va2->qty,
                            'cost'               => $va2->cost,
                            'unitprice'          => $va2->unitprice,
                            'discount'           => $va2->discount,
                            'sum_price'          => $va2->sum_price
                        ]);

                    }
        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_304_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from Acc_1102050101_304
            WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'";
        ');

        return view('account_pk.account_304_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_304_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
               SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
               ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue
               from Acc_1102050101_304 a
            LEFT JOIN acc_stm_ucs s ON s.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND s.rep IS NOT NULL

        ');


        $sum_money_ = DB::connection('mysql')->select('
           SELECT SUM(a.debit_total) as total
           from Acc_1102050101_304 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_money_ as $key => $value) {
           $sum_debit_total = $value->total;
       }
        $sum_stm_ = DB::connection('mysql')->select('
           SELECT SUM(au.inst) as stmtotal
           from Acc_1102050101_304 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_stm_ as $key => $value) {
           $sum_stm_total = $value->stmtotal;
       }

        return view('account_pk.account_304_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_304_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

           $data = DB::connection('mysql')->select('
           SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue
           from Acc_1102050101_304 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE status ="N" ;


            ');
           $sum_money_ = DB::connection('mysql')->select('
               SELECT SUM(a.debit_total) as total
               from Acc_1102050101_304 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_money_ as $key => $value) {
               $sum_debit_total = $value->total;
           }
           $sum_stm_ = DB::connection('mysql')->select('
               SELECT SUM(au.inst) as stmtotal
               from Acc_1102050101_304 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_stm_ as $key => $value) {
               $sum_stm_total = $value->stmtotal;
           }

        return view('account_pk.account_304_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }


    // ***************** 308********************************
    public function account_308_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.308"
                    group by month(a.dchdate) desc;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.308"
                    group by month(a.dchdate) desc;
            ');
        }

            return view('account_pk.account_308_dash',[
                'startdate'     =>     $startdate,
                'enddate'       =>     $enddate,
                'datashow'    =>     $datashow,
                'leave_month_year' =>  $leave_month_year,
            ]);
    }
    public function account_308_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.308"
                AND a.stamp = "N"
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_308_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_308_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype IN("14","34","35","45")
            GROUP BY a.an;
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.308')->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->fullname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'regdate'            => $value->admdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->code,
                            'account_code'       => $value->pang_debit,
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
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

                    Acc_opitemrece::where('an', '=', $value->an)->delete();

                    $acc_opitemrece_ = DB::connection('mysql3')->select('
                            SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                            ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                            FROM opitemrece o
                            LEFT JOIN an_stat a ON o.an = a.an
                            left outer join s_drugitems s on s.icode = o.icode
                            WHERE o.an ="'.$value->an.'"

                    ');

                    foreach ($acc_opitemrece_ as $key => $va2) {
                        Acc_opitemrece::insert([
                            'hn'                 => $va2->hn,
                            'an'                 => $va2->an,
                            'vn'                 => $va2->vn,
                            'pttype'             => $va2->pttype,
                            'paidst'             => $va2->paidst,
                            'rxdate'             => $va2->rxdate,
                            'vstdate'            => $va2->vstdate,
                            'dchdate'            => $va2->dchdate,
                            'income'             => $va2->income_group,
                            'icode'              => $va2->icode,
                            'name'               => $va2->iname,
                            'qty'                => $va2->qty,
                            'cost'               => $va2->cost,
                            'finance_number'     => $va2->finance_number,
                            'unitprice'          => $va2->unitprice,
                            'discount'           => $va2->discount,
                            'sum_price'          => $va2->sum_price,
                        ]);
                    }
        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_308_stam(Request $request)
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
                Acc_1102050101_308::insert([
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
                        'debit_total'       => $value->debit,
                        // 'debit_total'       => $value->debit - $value->debit_drug - $value->debit_instument - $value->debit_refer - $value->debit_toa,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                    ]);
                    $acc_opitemrece_ = DB::connection('mysql')->select('
                            SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                            FROM acc_opitemrece ao
                            LEFT JOIN acc_debtor a ON ao.an = a.an
                            WHERE a.account_code ="1102050101.308" AND a.stamp ="Y"
                            AND ao.an ="'.$value->an.'"
                    ');
                    foreach ($acc_opitemrece_ as $va2) {
                        Acc_opitemrece_stm::insert([
                            'hn'                 => $va2->hn,
                            'an'                 => $va2->an,
                            'vn'                 => $va2->vn,
                            'vstdate'            => $va2->vstdate,
                            'pttype'             => $va2->pttype,
                            'paidst'             => $va2->paidst,
                            'finance_number'     => $va2->finance_number,
                            'income'             => $va2->income,
                            'icode'              => $va2->icode,
                            'name'               => $va2->dname,
                            'qty'                => $va2->qty,
                            'cost'               => $va2->cost,
                            'unitprice'          => $va2->unitprice,
                            'discount'           => $va2->discount,
                            'sum_price'          => $va2->sum_price
                        ]);

                    }
        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_308_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from Acc_1102050101_308
            WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'";
        ');

        return view('account_pk.account_308_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_308_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
               SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
               ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue
               from Acc_1102050101_308 a
            LEFT JOIN acc_stm_ucs s ON s.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND s.rep IS NOT NULL

        ');


        $sum_money_ = DB::connection('mysql')->select('
           SELECT SUM(a.debit_total) as total
           from Acc_1102050101_308 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_money_ as $key => $value) {
           $sum_debit_total = $value->total;
       }
        $sum_stm_ = DB::connection('mysql')->select('
           SELECT SUM(au.inst) as stmtotal
           from Acc_1102050101_308 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
       ');
       foreach ($sum_stm_ as $key => $value) {
           $sum_stm_total = $value->stmtotal;
       }

        return view('account_pk.account_308_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_308_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

           $data = DB::connection('mysql')->select('
           SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue
           from Acc_1102050101_308 a
           LEFT JOIN acc_stm_ucs au ON au.an = a.an
           WHERE status ="N" ;


            ');
           $sum_money_ = DB::connection('mysql')->select('
               SELECT SUM(a.debit_total) as total
               from Acc_1102050101_308 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_money_ as $key => $value) {
               $sum_debit_total = $value->total;
           }
           $sum_stm_ = DB::connection('mysql')->select('
               SELECT SUM(au.inst) as stmtotal
               from Acc_1102050101_308 a
               LEFT JOIN acc_stm_ucs au ON au.an = a.an
               WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
           ');
           foreach ($sum_stm_ as $key => $value) {
               $sum_stm_total = $value->stmtotal;
           }

        return view('account_pk.account_308_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }

    // ***************** และ stam IPD********************************
    public function account_pk_debtor_ipd(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);

        foreach ($data as $key => $value) {
            $check = Acc_debtor_stamp::where('stamp_an', $value->an)->count();
            if ($check > 0) {
                Acc_debtor_stamp::where('stamp_an', $value->an)
                ->update([
                    'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    // 'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime,
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code,
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'acc_debtor_userid' => $iduser
                ]);
            } else {
                $date = date('Y-m-d H:m:s');
                Acc_debtor_stamp::insert([
                    'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime,
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code,
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'created_at'=> $date,
                    'acc_debtor_userid' => $iduser

                ]);
            }
        }

        return response()->json([
            'status'    => '200'
        ]);
    }

    // *************************** 401 ********************************************
    public function account_pkofc401_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();

        // foreach ($data_eave_month_year as $key => $value) {
            $acc_debtors = DB::select('
                SELECT count(vn) as VN from acc_debtor
                WHERE stamp="N"
                and account_code="1102050101.401" ;
            ');
            foreach ($acc_debtors as $key => $value) {
                $acc_debtor = $value->VN;
            }

        return view('account_pk.account_pkofc401_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'leave_month_year' =>  $leave_month_year,
            // 'acc_stam_'     =>     $acc_stam_
        ]);
    }
    public function account_pkofc401(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($id);
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['pang'] = DB::connection('mysql5')->table('pang')->get();

            $acc_debtor = DB::select('
                SELECT * from acc_debtor a

                WHERE stamp="N" and pttype_eclaim_id = "17"
                and account_code="1102050101.401"
                and month(vstdate) = "'.$id.'";
            ');

            // left join acc_debtor_stamp ad on ad.stamp_vn=a.vn
        return view('account_pk.account_pkofc401', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'id'       =>     $id
        ]);
    }

    // *************************** 801 ********************************************

    public function account_pklgo801_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.801"
                    group by month(a.vstdate) desc;
            ');
        } else {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.801"
                    group by month(a.vstdate) desc;
            ');

        }

        return view('account_pk.account_pklgo801_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pk801(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a
            left outer join check_sit_auto c on c.vn = a.vn
            WHERE a.account_code="1102050102.801"
            AND a.stamp = "N" and a.income <>0
            and a.account_code="1102050102.801"
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'";

        ');

        return view('account_pk.account_pk801',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pklgo801(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($startdate);
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        // $check = Acc_debtor::count();
        // if ($check > 0) {
        //     if ($startdate == '') {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->where('pttype_eclaim_id','=',18)->where('account_code','=',1102050102.801)->limit(1000)->get();
        //     } else {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->where('pttype_eclaim_id','=',18)->where('account_code','=',1102050102.801)->whereBetween('vstdate', [$startdate, $enddate])->get();
        //     }
        // } else {

        // }

        $acc_debtor = DB::select('
                SELECT * from acc_debtor
                WHERE stamp="N" and pttype_eclaim_id = "18"
                and account_code="1102050102.801"
                and month(vstdate) = "'.$id.'";
            ');
        // $data['acc_debtor'] = Acc_debtor::get();
        return view('account_pk.account_pklgo801', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            // 'pang_id'       =>     $pang_id
        ]);
    }

    public function acc_stm(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filename = $request->filename;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();


        $acc_stm = DB::connection('mysql9')->select('
            SELECT IF(ps.pang_stamp_vn IS NULL,"","Y")AS Stamp
                ,ps.pang_stamp_vn AS "vn"
                ,ps.pang_stamp_hn AS "hn"
                ,ps.pang_stamp_an AS "an"
                ,ps.pang_stamp_vstdate
                ,ps.pang_stamp_nhso
                ,ps.pang_stamp_uc_money ,ps.pang_stamp_uc_money_kor_tok
                ,ps.pang_stamp_stm_money AS stm
                ,ps.pang_stamp_uc_money_minut_stm_money
                ,ps.pang_stamp_send
                ,ps.pang_stamp_id
                ,ps.pang_stamp
                ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
                ,ps.pang_stamp_edit_send_id
                ,CONCAT(rn.receipt_book_id,"/",rn.receipt_number_id) AS receipt_n
                ,rn.receipt_date
                ,ps.pang_stamp_rcpt
                ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname," ",ps.pang_stamp_lname) AS pt_name

                FROM pang_stamp ps
                LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name = rn.receipt_number_stm_file_name


                WHERE ps.pang_stamp_stm_file_name ="'.$filename.'";
        ');
        // WHERE ps.pang_stamp = "1102050101.202"
        // AND ps.pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

        $filen_ = DB::connection('mysql9')->select('SELECT pang_stamp_stm_file_name FROM pang_stamp group by pang_stamp_stm_file_name');

        $sum_uc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money) as sumuc_money
            FROM pang_stamp
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_uc_money_ as $key => $value) {
            $sum_uc_money = $value->sumuc_money;
        }

        $sum_stmuc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_stm_money) as sumstmuc_money
            FROM pang_stamp
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_stmuc_money_ as $key => $value2) {
            $sum_stmuc_money = $value2->sumstmuc_money;
        }

        $sum_hiegt_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money_minut_stm_money) as sumsthieg_money
            FROM pang_stamp
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_hiegt_money_ as $key => $value3) {
            $sum_hiegt_money = $value3->sumsthieg_money;
        }


        // $data_file_ = DB::connection('mysql9')->table('pang_stamp')
        // ->leftjoin('stm','stm.stm_file_name','=','pang_stamp.pang_stamp_stm_file_name')
        // ->where('pang_stamp_stm_file_name','=',$filename)->first();
        // $file_n = $data_file_->stm_file_name;


        // $file_n = $data_file_->pang_stamp_stm_file_name;

        // $data_file_ = DB::connection('mysql9')->select('
        //     SELECT * FROM stm s
        //     LEFT JOIN pang_stamp p ON p.pang_stamp_stm_file_name = s.stm_file_name
        //     WHERE pang_stamp_stm_file_name ="'.$filename.'"
        // ');

        return view('account_pk.acc_stm',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_stm'       =>     $acc_stm,
            'filen_'        =>     $filen_,
            'sum_uc_money'  =>     $sum_uc_money,
            'sum_stmuc_money'  =>  $sum_stmuc_money,
            'sum_hiegt_money'  =>  $sum_hiegt_money,
            // 'file_n'  =>  $file_n
        ]);
    }

    public function acc_repstm(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filename = $request->filename;
        $pang_stamp = $request->pang_stamp;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
        $pang = DB::connection('mysql9')->table('pang')->get();

        $acc_stm = DB::connection('mysql9')->select('
            SELECT IF(ps.pang_stamp_vn IS NULL,"","Y")AS Stamp
                ,ps.pang_stamp_vn AS "vn"
                ,ps.pang_stamp_hn AS "hn"
                ,ps.pang_stamp_an AS "an"
                ,ps.pang_stamp_vstdate
                ,ps.pang_stamp_nhso
                ,ps.pang_stamp_uc_money ,ps.pang_stamp_uc_money_kor_tok
                ,ps.pang_stamp_stm_money AS stm
                ,ps.pang_stamp_uc_money_minut_stm_money
                ,ps.pang_stamp_send
                ,ps.pang_stamp_id
                ,ps.pang_stamp
                ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
                ,ps.pang_stamp_edit_send_id
                ,CONCAT(rn.receipt_book_id,"/",rn.receipt_number_id) AS receipt_n
                ,rn.receipt_date
                ,ps.pang_stamp_rcpt
                ,SUM(ati.price_approve) as price_approve
                ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname," ",ps.pang_stamp_lname) AS pt_name

                FROM pang_stamp ps
                LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name = rn.receipt_number_stm_file_name
                LEFT JOIN acc_stm_ti ati ON ati.hn = ps.pang_stamp_hn and ati.vstdate = ps.pang_stamp_vstdate
                WHERE ati.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

                AND pang_stamp = "'.$pang_stamp.'"
                GROUP BY ati.cid,ati.vstdate
                ORDER BY ps.pang_stamp_hn ;
        ');
        $filen_ = DB::connection('mysql9')->select('SELECT pang_stamp_stm_file_name FROM pang_stamp group by pang_stamp_stm_file_name');
        $sum_uc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money) as sumuc_money
            FROM pang_stamp
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND pang_stamp_send IS NOT NULL
            AND pang_stamp_uc_money <> 0
            AND pang_stamp = "'.$pang_stamp.'"
        ');
        foreach ($sum_uc_money_ as $key => $value) {
            $sum_uc_money = $value->sumuc_money;

        }

        $sum_stmuc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(ps.pang_stamp_stm_money) as sumstmuc_money ,SUM(ati.price_approve) as price_approve
            FROM pang_stamp ps
            LEFT JOIN acc_stm_ti ati ON ati.hn = ps.pang_stamp_hn and ati.vstdate = ps.pang_stamp_vstdate
            WHERE ati.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND ps.pang_stamp_send IS NOT NULL
            AND ps.pang_stamp_uc_money <> 0
            AND ps.pang_stamp = "'.$pang_stamp.'"

        ');
        foreach ($sum_stmuc_money_ as $key => $value2) {
            $sum_stmuc_money = $value2->sumstmuc_money;
            $price_approve = $value2->price_approve;
        }

        $sum_hiegt_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money_minut_stm_money) as sumsthieg_money
            FROM pang_stamp
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND pang_stamp_send IS NOT NULL
            AND pang_stamp_uc_money <> 0
            AND pang_stamp = "'.$pang_stamp.'"
        ');
        foreach ($sum_hiegt_money_ as $key => $value3) {
            $sum_hiegt_money = $value3->sumsthieg_money;
        }
        // $data_file_ = DB::connection('mysql9')->table('pang_stamp')->where('pang_stamp_stm_file_name','=',$filename)->first();
        // $file_n = $data_file_->pang_stamp_stm_file_name;

        return view('account_pk.acc_repstm',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_stm'       =>     $acc_stm,
            'filen_'        =>     $filen_,
            'sum_uc_money'  =>     $sum_uc_money,
            'sum_stmuc_money'  =>  $sum_stmuc_money,
            'price_approve'    =>  $price_approve,
            'sum_hiegt_money'  =>  $sum_hiegt_money,
            'pang'             =>  $pang,
            'pang_stamp'       =>  $pang_stamp
        ]);
    }

    public function upstm(Request $request)
    {
         return view('account_pk.upstm');
    }
    public function upstm_save(Request $request)
    {
        if ($request->hasfile('file')) {

            $image = $request->file('file');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('Stm'),$imageName);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Hello World !');

            $writer = new Xlsx($spreadsheet);
            $writer->save('hello world.xlsx');

        }

        // I have a table and therefore model to list all excels
        // $excelfile = ExcelFile::fromForm($request->file('file'));

        return response()->json(['success'=>$imageName]);
    }
    public function upstm_import(Request $request)
    {

        if ($request->hasfile('file')) {
            $inputFileName = time().'.'.$image->extension();
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);

            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '') && (is_numeric($dataRow[$row]['A'])) && (empty($dataRow[$row]['X'])) ) { //ตรวจคอลัมน์ Excel
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        //$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                        foreach (range('A', 'W') as $column){
                            $namedDataArray[$r][$column] = $dataRow[$row][$column];
                        }
                    }
                }elseif( isset($dataRow[$row]['X']) ){
                    $show_error = "<font style='background-color: red'>ไม่ใช่ STM ข้าราชการ</font>";
                }
            }
        }
        // dd( $namedDataArray);

     return view('account_pk.upstm');
    }

    // *************************** account_pk 401*******************************************

    public function account_401_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.401"
                    and income <> 0
                    group by month(a.vstdate) order by month(a.vstdate) desc limit 3;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.401"
                    and income <>0
                    group by month(a.vstdate) order by month(a.vstdate) desc;
            ');
        }

        return view('account_pk.account_401_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_401_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.401"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_401_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_401_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                    ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                    ,v.hospmain,op.income as income_group
                    ,o.vstdate as vstdatesave
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                    ,ptt.pttype_eclaim_id
                    ,o.pttype
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code
                    ,e.name as account_name
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
            from ovst o
            left join vn_stat v on v.vn=o.vn
            left join patient pt on pt.hn=o.hn
            LEFT JOIN pttype ptt on o.pttype=ptt.pttype
            LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
            LEFT JOIN opitemrece op ON op.vn = o.vn
            WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND v.pttype IN("O1","O2","O3","O4","O5")
            and (o.an="" or o.an is null)
            GROUP BY o.vn
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.401')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdatesave,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_401_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050101_401::insert([
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
    public function account_401_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
            from acc_1102050101_401 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
            GROUP BY U1.vn
        ');

        return view('account_pk.account_401_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_401_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
        SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,SUM(U2.pricereq_all) as pricereq_all,U2.STMdoc
            from acc_1102050101_401 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'"
            and year(U1.vstdate) = "'.$year.'"
            AND U2.pricereq_all IS NOT NULL
            GROUP BY U1.vn
        ');
        return view('account_pk.account_401_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,

        ]);
    }
    public function account_401_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select('
                SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
                from acc_1102050101_401 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
                AND U1.status ="N"
            ');


        return view('account_pk.account_401_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }

    public function account_401_stmnull_all(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();
        $mototal = $months + 1;
        $datashow = DB::connection('mysql')->select('
                SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,SUM(U2.pricereq_all) as pricereq_all,U2.STMdoc
                from acc_1102050101_401 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                WHERE U1.status ="N"
                AND U2.pricereq_all IS NULL
                GROUP BY U1.vn
            ');
        return view('account_pk.account_401_stmnull_all', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }

     // *************************** account_pk 402*******************************************

     public function account_402_dash(Request $request)
     {
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
         $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
         $date = date('Y-m-d');
         $y = date('Y') + 543;
         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

         if ($startdate == '') {
             $datashow = DB::select('
                 SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050101.402"
                     and income <> 0
                     group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
             ');

         } else {
             $datashow = DB::select('
                 SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050101.402"
                     and income <>0
                     group by month(a.dchdate) order by month(a.dchdate) desc;
             ');
         }

         return view('account_pk.account_402_dash',[
             'startdate'        => $startdate,
             'enddate'          => $enddate,
             'leave_month_year' => $leave_month_year,
             'datashow'         => $datashow,
             'newyear'          => $newyear,
             'date'             => $date,
         ]);
     }
     public function account_402_pull(Request $request)
     {
         $datenow = date('Y-m-d');
         $months = date('m');
         $year = date('Y');
         // dd($year);
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         if ($startdate == '') {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
             $acc_debtor = DB::select('
                 SELECT a.*,c.subinscl from acc_debtor a
                 left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                 WHERE a.account_code="1102050101.402"
                 AND a.stamp = "N"
                 group by a.an
                 order by a.dchdate asc;

             ');
             // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
         } else {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
         }

         return view('account_pk.account_402_pull',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
         ]);
     }
     public function account_402_pulldata(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
         // Acc_opitemrece::truncate();
         $acc_debtor = DB::connection('mysql3')->select('
                SELECT o.vn,i.an,pt.hn,showcid(pt.cid) as cid
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,pt.hcode,op.income as income_group
                ,o.vstdate ,totime(o.vsttime) as vsttime
                ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                ,a.dchdate
                ,ptt.pttype_eclaim_id
                ,a.pttype,ptt.name as namelist
                ,e.code as acc_code
                ,e.ar_ipd as account_code
                ,e.name as account_name
                ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                ,a.rcpno_list as rcpno
                ,a.income-a.discount_money-a.rcpt_money as debit
                ,if(op.icode IN("3010058"),sum_price,0) as fokliad
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                ,ptt.max_debt_money
                from ipt i
                LEFT JOIN ovst o on o.an = i.an
                left join an_stat a on a.an=i.an
                left join patient pt on pt.hn=o.hn
                LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                LEFT JOIN opitemrece op ON op.an = i.an
                LEFT JOIN drugitems d on d.icode=op.icode
             WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
             AND ptt.pttype IN("O1","O2","O3","O4","O5")
			GROUP BY i.an
         ');

         foreach ($acc_debtor as $key => $value) {
                     $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.402')->whereBetween('dchdate', [$startdate, $enddate])->count();
                     if ($check == 0) {
                         Acc_debtor::insert([
                             'hn'                 => $value->hn,
                             'an'                 => $value->an,
                             'vn'                 => $value->vn,
                             'cid'                => $value->cid,
                             'ptname'             => $value->ptname,
                             'pttype'             => $value->pttype,
                             'vstdate'            => $value->vstdate,
                             'dchdate'            => $value->dchdate,
                             'acc_code'           => $value->acc_code,
                             'account_code'       => $value->account_code,
                             'account_name'       => $value->account_name,
                             'income_group'       => $value->income_group,
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
                             'debit_total'        => $value->debit,
                             'max_debt_amount'    => $value->max_debt_money,
                             'acc_debtor_userid'  => Auth::user()->id
                         ]);
                     }

         }

             return response()->json([

                 'status'    => '200'
             ]);
     }
     public function account_402_stam(Request $request)
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
             //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                 $check = Acc_debtor::where('an', $value->an)->where('debit_total','=','0')->count();
                 if ($check > 0) {
                 # code...
                 } else {
                    Acc_1102050101_402::insert([
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
     public function account_402_detail(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $data = DB::select('
         SELECT U2.repno,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
             from acc_1102050101_402 U1
             LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate
             WHERE month(U1.dchdate) = "'.$months.'" and year(U1.dchdate) = "'.$year.'"
             GROUP BY U1.an
         ');

         return view('account_pk.account_402_detail', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'data'          =>     $data,
             'months'        =>     $months,
             'year'          =>     $year
         ]);
     }
     public function account_402_stm(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $datashow = DB::select('
         SELECT U2.repno,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,SUM(U2.pricereq_all) as pricereq_all,U2.STMdoc
             from acc_1102050101_402 U1
             LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate
             WHERE month(U1.dchdate) = "'.$months.'"
             and year(U1.dchdate) = "'.$year.'"
             AND U2.pricereq_all IS NOT NULL
             GROUP BY U1.an
         ');
         return view('account_pk.account_402_stm', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,

         ]);
     }
     public function account_402_stmnull(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $datashow = DB::connection('mysql')->select('
                 SELECT U2.repno,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
                 from acc_1102050101_402 U1
                 LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate
                 WHERE month(U1.dchdate) = "'.$months.'" and year(U1.dchdate) = "'.$year.'"
                 AND U1.status ="N"
             ');


         return view('account_pk.account_402_stmnull', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,
         ]);
     }

     public function account_402_stmnull_all(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
         $mototal = $months + 1;
         $datashow = DB::connection('mysql')->select('
                 SELECT U2.repno,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,SUM(U2.pricereq_all) as pricereq_all,U2.STMdoc
                 from acc_1102050101_402 U1
                 LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                 WHERE U1.status ="N"
                 AND U2.pricereq_all IS NULL
                 GROUP BY U1.an
             ');
         return view('account_pk.account_402_stmnull_all', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,
         ]);
     }

    // *************************** account_pk 602*******************************************

    public function account_602_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.602"
                    and income <> 0
                    group by month(a.vstdate) order by month(a.vstdate) desc limit 3;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.602"
                    and income <>0
                    group by month(a.vstdate) order by month(a.vstdate) desc;
            ');
        }

        return view('account_pk.account_602_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_602_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT * from acc_debtor a
                WHERE a.account_code="1102050102.602"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc
            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_602_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_602_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,o.vstdate,totime(o.vsttime) as vsttime
                ,v.hospmain,op.income as income_group
                ,o.vstdate as vstdatesave
                ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                ,ptt.pttype_eclaim_id
                ,v.pttype,ptt.name as namelist
                ,e.gf_opd as gfmis,e.code as acc_code
                ,e.ar_opd as account_code
                ,e.name as account_name
                ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                ,v.rcpno_list as rcpno
                ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                ,v.income-v.discount_money-v.rcpt_money as debit
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                ,ptt.max_debt_money
            from vn_stat v
            left join ovst o on v.vn=o.vn
            left join patient pt on pt.hn=v.hn
            LEFT JOIN pttype ptt on v.pttype=ptt.pttype
            LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
            LEFT JOIN opitemrece op ON op.vn = o.vn
            WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND v.pttype IN("31","36","37","38","39")
            and (o.an="" or o.an is null)
            GROUP BY v.vn
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.602')->whereBetween('vstdate', [$startdate, $enddate])->count();
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
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_602_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050102_602::insert([
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
    public function account_602_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.acc_1102050102_602_id,U2.req_no,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.money_billno,U2.payprice
            from acc_1102050102_602 U1
            LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
            WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
            GROUP BY U1.vn
        ');

        return view('account_pk.account_602_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_602_edit(Request $request, $id)
    {
        $acc602 = Acc_1102050102_602::LEFTJOIN('acc_stm_prb','acc_stm_prb.acc_1102050102_602_sid','=','acc_1102050102_602.acc_1102050102_602_id')
        ->find($id);

        return response()->json([
            'status'      => '200',
            'acc602'      =>  $acc602,
        ]);
    }
    public function account_602_update(Request $request)
    {
        $id = $request->acc_1102050102_602_id;

        Acc_1102050102_602::whereIn('acc_1102050102_602_id',explode(",",$id))
        ->update([
            'status' => 'Y'
        ]);

        Acc_stm_prb::whereIn('acc_1102050102_602_sid',explode(",",$id))->delete();

        $add = new Acc_stm_prb();
        $add->acc_1102050102_602_sid = $id;
        $add->req_no           = $request->req_no;
        $add->pid              = $request->cid;
        $add->fullname           = $request->ptname;
        $add->claim_no         = $request->claim_no;
        $add->vendor           = $request->vendor;
        $add->money_billno     = $request->money_billno;
        $add->paytype          = $request->paytype;
        $add->no               = $request->no;
        $add->payprice         = $request->payprice;
        $add->paydate          = $request->paydate;
        $add->savedate         = $request->savedate;
        $add->save();
        return response()->json([
            'status'      => '200'
        ]);
    }
    public function account_602_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select('
                SELECT U2.req_no,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.money_billno,U2.payprice
                from acc_1102050102_602 U1
                LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
                WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
                AND U1.status ="N"
            ');


        return view('account_pk.account_602_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }
    public function account_602_stmnull_all(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select('
                SELECT U2.req_no,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.money_billno,U2.payprice
                from acc_1102050102_602 U1
                LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
                WHERE U1.status ="N"
                AND U2.acc_1102050102_602_sid IS NULL

            ');

            // AND month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_pk.account_602_stmnull_all', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }
    public function account_602_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
        SELECT U2.req_no,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,SUM(U2.payprice) as payprice,U2.money_billno
            from acc_1102050102_602 U1
            LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
            WHERE month(U1.vstdate) = "'.$months.'"
            and year(U1.vstdate) = "'.$year.'"
            AND U2.acc_1102050102_602_sid IS NOT NULL
            GROUP BY U1.vn
        ');
        return view('account_pk.account_602_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,

        ]);
    }

    // *************************** account_pk 602*******************************************

    public function account_603_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.603"
                    and income <> 0
                    group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.603"
                    and income <>0
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
        }

        return view('account_pk.account_603_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_603_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT * from acc_debtor
                WHERE account_code="1102050102.603"
                AND stamp = "N"
                group by an
                order by dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_603_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_603_pulldata(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
         // Acc_opitemrece::truncate();
         $acc_debtor = DB::connection('mysql3')->select('
                select
                o.vn,a.hn,i.an,showcid(p.cid) as cid,i.pttype,o.vstdate,a.dchdate,i.pttype_number,i.max_debt_amount,pt.name as pttype_name
                ,concat(p.pname,p.fname," ",p.lname) as ptname,a.income ,format(a.paid_money,2) as paid_money,e.code as acc_code
                ,e.ar_ipd as account_code,e.name as account_name
                ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                ,a.rcpno_list as rcpno

                ,ifnull(case
                when i.max_debt_amount ="" then a.income
                else i.max_debt_amount end,a.income) debit

                from ipt_pttype i
                left outer join pttype pt on pt.pttype = i.pttype
                left outer join pttype_eclaim e on e.code=pt.pttype_eclaim_id
                left outer join an_stat a on a.an = i.an
                LEFT OUTER JOIN patient p ON p.hn=a.hn
                LEFT JOIN ovst o on o.an = i.an

             WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
             and e.ar_ipd = "1102050102.603"
            GROUP BY i.an
            order by i.pttype_number
         ');

         foreach ($acc_debtor as $key => $value) {
                     $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050102.603')->whereBetween('dchdate', [$startdate, $enddate])->count();
                     if ($check == 0) {
                         Acc_debtor::insert([
                             'hn'                 => $value->hn,
                             'an'                 => $value->an,
                             'vn'                 => $value->vn,
                             'cid'                => $value->cid,
                             'ptname'             => $value->ptname,
                             'pttype'             => $value->pttype,
                             'vstdate'            => $value->vstdate,
                             'dchdate'            => $value->dchdate,
                             'acc_code'           => $value->acc_code,
                             'account_code'       => $value->account_code,
                             'account_name'       => $value->account_name,
                            //  'income_group'       => $value->income_group,
                             'income'             => $value->income,
                             'uc_money'           => $value->uc_money,
                             'discount_money'     => $value->discount_money,
                             'paid_money'         => $value->paid_money,
                             'rcpt_money'         => $value->rcpt_money,
                             'debit'              => $value->debit,
                            //  'debit_drug'         => $value->debit_drug,
                            //  'debit_instument'    => $value->debit_instument,
                            //  'debit_toa'          => $value->debit_toa,
                            //  'debit_refer'        => $value->debit_refer,
                             'debit_total'        => $value->debit,
                             'max_debt_amount'    => $value->max_debt_amount,
                             'acc_debtor_userid'  => Auth::user()->id
                         ]);
                     }

         }

             return response()->json([

                 'status'    => '200'
             ]);
     }
     public function account_603_stam(Request $request)
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
             //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                 $check = Acc_debtor::where('an', $value->an)->where('debit_total','=','0')->count();
                 if ($check > 0) {
                 # code...
                 } else {
                    Acc_1102050102_603::insert([
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

     // *************************** account_pk 801 OPD L1-L7*******************************************

    public function account_801_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.801"
                    and income <> 0
                    group by month(a.vstdate) order by month(a.vstdate) desc limit 3;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.801"
                    and income <>0
                    group by month(a.vstdate) order by month(a.vstdate) desc;
            ');
        }

        return view('account_pk.account_801_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_801_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050102.801"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc
            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_801_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_801_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                     ,totime(o.vsttime) as vsttime
                    ,v.hospmain,op.income as income_group
                    ,o.vstdate
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                    ,ptt.pttype_eclaim_id
                    ,o.pttype
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code
                    ,e.name as account_name
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
            from ovst o
            left join vn_stat v on v.vn=o.vn
            left join patient pt on pt.hn=o.hn
            LEFT JOIN pttype ptt on o.pttype=ptt.pttype
            LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
            LEFT JOIN opitemrece op ON op.vn = o.vn
            WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype IN("L1","L2","L3","L4","L5","L6","L7")
            and (o.an="" or o.an is null)
            AND v.income <> 0
            GROUP BY o.vn
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.801')->whereBetween('vstdate', [$startdate, $enddate])->count();
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
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_801_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050102_801::insert([
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
    public function account_801_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
            from acc_1102050102_801 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
            GROUP BY U1.vn
        ');

        return view('account_pk.account_801_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_801_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
        SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,SUM(U2.pricereq_all) as pricereq_all,U2.STMdoc
            from acc_1102050102_801 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'"
            and year(U1.vstdate) = "'.$year.'"
            AND U2.pricereq_all IS NOT NULL
            GROUP BY U1.vn
        ');
        return view('account_pk.account_801_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,

        ]);
    }
    public function account_801_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select('
                SELECT U2.repno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
                from acc_1102050102_801 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
                AND U1.status ="N"
            ');


        return view('account_pk.account_801_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }

    // *************************** account_pk 802 IPD L1-L7*******************************************

    public function account_802_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.802"
                    and income <> 0
                    group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.802"
                    and income <>0
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
        }

        return view('account_pk.account_802_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_802_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050102.802"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_802_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_802_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
               SELECT o.vn,i.an,pt.hn,showcid(pt.cid) as cid
               ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
               ,pt.hcode,op.income as income_group
               ,o.vstdate,totime(o.vsttime) as vsttime
               ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
               ,a.dchdate
               ,ptt.pttype_eclaim_id
               ,a.pttype,ptt.name as namelist
               ,e.code as acc_code
               ,e.ar_ipd as account_code
               ,e.name as account_name
               ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
               ,a.rcpno_list as rcpno
               ,a.income-a.discount_money-a.rcpt_money as debit
               ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
               ,sum(if(op.income="02",sum_price,0)) as debit_instument
               ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
               ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
               ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
               ,ptt.max_debt_money
               from ipt i
               LEFT JOIN ovst o on o.an = i.an
               left join an_stat a on a.an=i.an
               left join patient pt on pt.hn=o.hn
               LEFT JOIN pttype ptt on o.pttype=ptt.pttype
               LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
               LEFT JOIN opitemrece op ON op.an = i.an
               LEFT JOIN drugitems d on d.icode=op.icode
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype IN("L1","L2","L3","L4","L5","L6","L7")
           GROUP BY i.an
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050102.802')->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }
        }
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_802_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('an', $value->an)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050102_802::insert([
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


    // *************************** account_pk 803 B1-B5*******************************************

     public function account_803_dash(Request $request)
     {
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
         $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
         $date = date('Y-m-d');
         $y = date('Y') + 543;
         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

         if ($startdate == '') {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050102.803"
                     and income <> 0
                     group by month(a.vstdate) order by month(a.vstdate) desc limit 3;
             ');

         } else {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050102.803"
                     and income <>0
                     group by month(a.vstdate) order by month(a.vstdate) desc;
             ');
         }

         return view('account_pk.account_803_dash',[
             'startdate'        => $startdate,
             'enddate'          => $enddate,
             'leave_month_year' => $leave_month_year,
             'datashow'         => $datashow,
             'newyear'          => $newyear,
             'date'             => $date,
         ]);
     }
     public function account_803_pull(Request $request)
     {
         $datenow = date('Y-m-d');
         $months = date('m');
         $year = date('Y');
         // dd($year);
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         if ($startdate == '') {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
             $acc_debtor = DB::select('
                 SELECT a.*,c.subinscl from acc_debtor a
                 left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                 WHERE a.account_code="1102050102.803"
                 AND a.stamp = "N"
                 group by a.vn
                 order by a.vstdate asc;

             ');
             // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
         } else {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
         }

         return view('account_pk.account_803_pull',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
         ]);
     }
     public function account_803_pulldata(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
         // Acc_opitemrece::truncate();
         $acc_debtor = DB::connection('mysql3')->select('
             SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                     ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                      ,totime(o.vsttime) as vsttime
                     ,v.hospmain,op.income as income_group
                     ,o.vstdate
                     ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                     ,ptt.pttype_eclaim_id
                     ,o.pttype
                     ,e.gf_opd as gfmis,e.code as acc_code
                     ,e.ar_opd as account_code
                     ,e.name as account_name
                     ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                     ,v.rcpno_list as rcpno
                     ,v.income-v.discount_money-v.rcpt_money as debit
                     ,sum(if(op.income="02",sum_price,0)) as debit_instument
                     ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                     ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                     ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                     ,ptt.max_debt_money
             from ovst o
             left join vn_stat v on v.vn=o.vn
             left join patient pt on pt.hn=o.hn
             LEFT JOIN pttype ptt on o.pttype=ptt.pttype
             LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
             LEFT JOIN opitemrece op ON op.vn = o.vn
             WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
             AND ptt.pttype IN("B1","B2","B3","B4","B5")
             and (o.an="" or o.an is null)
             AND v.income <> 0
             GROUP BY o.vn
         ');

         foreach ($acc_debtor as $key => $value) {
                     $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.803')->whereBetween('vstdate', [$startdate, $enddate])->count();
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
                             'income_group'       => $value->income_group,
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
                             'debit_total'        => $value->debit,
                             'max_debt_amount'    => $value->max_debt_money,
                             'acc_debtor_userid'  => Auth::user()->id
                         ]);
                     }

         }

             return response()->json([

                 'status'    => '200'
             ]);
     }
     public function account_803_stam(Request $request)
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
             //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                 $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                 if ($check > 0) {
                 # code...
                 } else {
                     Acc_1102050102_803::insert([
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

     // *************************** account_pk 804 OPD*******************************************

     public function account_804_dash(Request $request)
     {
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
         $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
         $date = date('Y-m-d');
         $y = date('Y') + 543;
         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

         if ($startdate == '') {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050102.804"
                     and income <> 0
                     group by month(a.vstdate) order by month(a.vstdate) desc limit 3;
             ');

         } else {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050102.804"
                     and income <>0
                     group by month(a.vstdate) order by month(a.vstdate) desc;
             ');
         }

         return view('account_pk.account_804_dash',[
             'startdate'        => $startdate,
             'enddate'          => $enddate,
             'leave_month_year' => $leave_month_year,
             'datashow'         => $datashow,
             'newyear'          => $newyear,
             'date'             => $date,
         ]);
     }


    // *************************** account_pkti 4022*******************************************
    public function account_pkti4022_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.4022"
                    and income <> 0
                    group by month(a.dchdate) desc;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.4022"
                    and income <>0
                    group by month(a.dchdate) desc;
            ');
        }

        return view('account_pk.account_pkti4022_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pkti4022_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.dchdate = a.dchdate
                WHERE a.account_code="1102050101.4022"
                AND a.stamp = "N"
                group by a.an
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_pkti4022_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkti4022_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
            SELECT o.vn,i.an,pt.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                    ,pt.hcode,op.income as income_group
                    ,o.vstdate ,totime(o.vsttime) as vsttime
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                    ,a.dchdate
                    ,ptt.pttype_eclaim_id
                    ,a.pttype,ptt.name as namelist
                    ,"37" as acc_code
					,"1102050101.4022" as account_code
                    ,e.name as account_name
                    ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                    ,a.rcpno_list as rcpno
                    ,a.income-a.discount_money-a.rcpt_money as debit
                    ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
                from ipt i
                LEFT JOIN ovst o on o.an = i.an
                left join an_stat a on a.an=i.an
                left join patient pt on pt.hn=o.hn
                LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                LEFT JOIN opitemrece op ON op.an = i.an
                LEFT JOIN drugitems d on d.icode=op.icode

            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype IN("O1","O2","O3","O4","O5")
			AND op.icode ="3010058"
            GROUP BY i.an
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050101.4022')->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->fokliad,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_pkti4022_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('an', $value->an)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                        Acc_1102050101_4022::insert([
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
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                ]);
                }


        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkti4022_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U2.repno,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
            from acc_1102050101_4022 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate
            WHERE month(U1.dchdate) = "'.$months.'" and year(U1.dchdate) = "'.$year.'"
            AND U1.status = "N";
        ');
        // LEFT JOIN acc_stm_ofc au ON au.cid = a.cid AND au.vstdate = a.vstdate
        return view('account_pk.account_pkti4022_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkti4022_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U2.repno,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc
            from acc_1102050101_4022 U1
            LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate
            WHERE month(U1.dchdate) = "'.$months.'" and year(U1.dchdate) = "'.$year.'"
            AND U1.status = "Y";
        ');
        // LEFT JOIN acc_stm_ofc au ON au.cid = a.cid AND au.vstdate = a.vstdate
        return view('account_pk.account_pkti4022_stm', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }


    // *************************** account_pkti 4011*******************************************

    public function account_pkti4011_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.4011"
                    and income <> 0
                    group by month(a.vstdate) desc;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.4011"
                    and income <>0
                    group by month(a.vstdate) desc;
            ');
        }

        return view('account_pk.account_pkti4011_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pkti4011_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.4011"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_pkti4011_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkti4011_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
        $acc_debtor = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                    ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                    ,v.hospmain,op.income as income_group
                    ,o.vstdate as vstdatesave
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                    ,ptt.pttype_eclaim_id
                    ,o.pttype
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code
                    ,e.name as account_name
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
            from ovst o
            left join vn_stat v on v.vn=o.vn
            left join patient pt on pt.hn=o.hn
            LEFT JOIN pttype ptt on o.pttype=ptt.pttype
            LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
            LEFT JOIN opitemrece op ON op.vn = o.vn
            WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND ptt.pttype ="M1"
            GROUP BY o.vn
        ');

        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdatesave,
                        //  'regdate'            => $value->admdate,
                        //  'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
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
                            'debit_total'        => $value->debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

                //  Acc_opitemrece::where('vn', '=', $value->vn)->delete();

                //  $acc_opitemrece_ = DB::connection('mysql3')->select('
                //          SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                //          ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                //          FROM opitemrece o
                //          LEFT JOIN an_stat a ON o.an = a.an
                //          left outer join s_drugitems s on s.icode = o.icode
                //          WHERE o.an ="'.$value->vn.'"

                //  ');

                //  foreach ($acc_opitemrece_ as $key => $va2) {
                //      Acc_opitemrece::insert([
                //          'hn'                 => $va2->hn,
                //          'an'                 => $va2->an,
                //          'vn'                 => $va2->vn,
                //          'pttype'             => $va2->pttype,
                //          'paidst'             => $va2->paidst,
                //          'rxdate'             => $va2->rxdate,
                //          'vstdate'            => $va2->vstdate,
                //          'dchdate'            => $va2->dchdate,
                //          'income'             => $va2->income_group,
                //          'icode'              => $va2->icode,
                //          'name'               => $va2->iname,
                //          'qty'                => $va2->qty,
                //          'cost'               => $va2->cost,
                //          'finance_number'     => $va2->finance_number,
                //          'unitprice'          => $va2->unitprice,
                //          'discount'           => $va2->discount,
                //          'sum_price'          => $va2->sum_price,
                //      ]);
                //  }
        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_pkti4011_stam(Request $request)
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
            //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                if ($check > 0) {
                # code...
                } else {
                Acc_1102050101_4011::insert([
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

                //  $acc_opitemrece_ = DB::connection('mysql')->select('
                //          SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                //          FROM acc_opitemrece ao
                //          LEFT JOIN acc_debtor a ON ao.an = a.an
                //          WHERE a.account_code ="1102050101.4011" AND a.stamp ="Y"
                //          AND ao.an ="'.$value->an.'"
                //  ');
                //  foreach ($acc_opitemrece_ as $va2) {
                //      Acc_opitemrece_stm::insert([
                //          'hn'                 => $va2->hn,
                //          'an'                 => $va2->an,
                //          'vn'                 => $va2->vn,
                //          'vstdate'            => $va2->vstdate,
                //          'pttype'             => $va2->pttype,
                //          'paidst'             => $va2->paidst,
                //          'finance_number'     => $va2->finance_number,
                //          'income'             => $va2->income,
                //          'icode'              => $va2->icode,
                //          'name'               => $va2->dname,
                //          'qty'                => $va2->qty,
                //          'cost'               => $va2->cost,
                //          'unitprice'          => $va2->unitprice,
                //          'discount'           => $va2->discount,
                //          'sum_price'          => $va2->sum_price
                //      ]);

                //  }
        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkti4011_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U2.invno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.amount,U2.STMdoc
            from acc_1102050101_4011 U1
            LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'";
        ');

        return view('account_pk.account_pkti4011_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkti4011_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
        SELECT U2.invno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.amount,U2.STMdoc
        FROM acc_1102050101_4011 U1
        LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
            WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
            AND U2.amount IS NOT NULL
        ');
        return view('account_pk.account_pkti4011_stm', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,

        ]);
    }
    public function account_pkti4011_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::connection('mysql')->select('
            SELECT U2.invno,U1.vn,U1.hn,U1.ptname,U1.vstdate,U1.debit_total,U2.amount,U1.debit_total-U2.amount as total_yokma,U2.STMdoc
                FROM acc_1102050101_4011 U1
                LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
                AND U1.status ="N"
            ');


        return view('account_pk.account_pkti4011_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }
    public function account_pkti4011(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a
            left outer join check_sit_auto c on c.vn = a.vn

            WHERE a.account_code="1102050101.4011"
            AND a.stamp = "N" and a.income <>0
            and a.account_code="1102050101.4011"
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'";

        ');

        return view('account_pk.account_pkti4011',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }

     // *************************** account_pkti 3099*******************************************

     public function account_pkti3099_dash(Request $request)
     {
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
         $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
         $date = date('Y-m-d');
         $y = date('Y') + 543;
         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

         if ($startdate == '') {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050101.3099"
                     and income <> 0
                     group by month(a.vstdate) desc;
             ');

         } else {
             $datashow = DB::select('
                 SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income) as income
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                     WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050101.3099"
                     and income <>0
                     group by month(a.vstdate) desc;
             ');
         }

         return view('account_pk.account_pkti3099_dash',[
             'startdate'        => $startdate,
             'enddate'          => $enddate,
             'leave_month_year' => $leave_month_year,
             'datashow'         => $datashow,
             'newyear'          => $newyear,
             'date'             => $date,
         ]);
     }
     public function account_pkti3099_pull(Request $request)
     {
         $datenow = date('Y-m-d');
         $months = date('m');
         $year = date('Y');
         // dd($year);
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         if ($startdate == '') {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
             $acc_debtor = DB::select('
                 SELECT a.*,c.subinscl from acc_debtor a
                 left outer join check_sit_auto c on c.an = a.an
                 WHERE a.account_code="1102050101.3099"
                 AND a.stamp = "N"
                 group by a.vn
                 order by a.vstdate asc;

             ');
             // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
         } else {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
         }

         return view('account_pk.account_pkti3099_pull',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
         ]);
     }
     public function account_pkti3099_pulldata(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
         // Acc_opitemrece::truncate();
         $acc_debtor = DB::connection('mysql3')->select('
             SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                     ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                     ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                     ,v.hospmain,op.income as income_group
                     ,o.vstdate as vstdatesave
                     ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                     ,ptt.pttype_eclaim_id
                     ,o.pttype
                     ,e.gf_opd as gfmis,e.code as acc_code
                     ,e.ar_opd as account_code
                     ,e.name as account_name
                     ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                     ,v.rcpno_list as rcpno
                     ,v.income-v.discount_money-v.rcpt_money as debit
                     ,sum(if(op.income="02",sum_price,0)) as debit_instument
                     ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                     ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                     ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                     ,ptt.max_debt_money
             from ovst o
             left join vn_stat v on v.vn=o.vn
             left join patient pt on pt.hn=o.hn
             LEFT JOIN pttype ptt on o.pttype=ptt.pttype
             LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
             LEFT JOIN opitemrece op ON op.vn = o.vn
             WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
             AND ptt.pttype IN("M2","M5")
             GROUP BY o.vn
         ');

         foreach ($acc_debtor as $key => $value) {
                     $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.3099')->whereBetween('vstdate', [$startdate, $enddate])->count();
                     if ($check == 0) {
                        Acc_debtor::insert([
                             'hn'                 => $value->hn,
                             'an'                 => $value->an,
                             'vn'                 => $value->vn,
                             'cid'                => $value->cid,
                             'ptname'             => $value->ptname,
                             'pttype'             => $value->pttype,
                             'vstdate'            => $value->vstdatesave,
                         //  'regdate'            => $value->admdate,
                         //  'dchdate'            => $value->dchdate,
                             'acc_code'           => $value->acc_code,
                             'account_code'       => $value->account_code,
                             'account_name'       => $value->account_name,
                             'income_group'       => $value->income_group,
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
                             'debit_total'        => $value->debit,
                             'max_debt_amount'    => $value->max_debt_money,
                             'acc_debtor_userid'  => Auth::user()->id
                         ]);
                     }
         }

             return response()->json([

                 'status'    => '200'
             ]);
     }
     public function account_pkti3099_stam(Request $request)
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
                    //  $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.4011')->where('account_code','1102050101.4011')->count();
                 $check = Acc_debtor::where('vn', $value->vn)->where('debit_total','=','0')->count();
                 if ($check > 0) {
                 # code...
                 } else {
                    Acc_1102050101_3099::insert([
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
     public function account_pkti3099_detail(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $data = DB::select('
         SELECT U2.invno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.amount,U2.EPOpay,U2.STMdoc ,U2.amount+U2.EPOpay as rep_money
             from acc_1102050101_3099 U1
             LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
             WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'";
         ');

         return view('account_pk.account_pkti3099_detail', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'data'          =>     $data,
             'months'        =>     $months,
             'year'          =>     $year
         ]);
     }
     public function account_pkti3099_stm(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $datashow = DB::select('
         SELECT U2.invno,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U2.amount,U2.STMdoc,U2.EPOpay,U2.amount+U2.EPOpay as rep_money
         FROM acc_1102050101_3099 U1
         LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
             WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
             AND U2.amount IS NOT NULL
         ');
         return view('account_pk.account_pkti3099_stm', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,

         ]);
     }
     public function account_pkti3099_stmnull(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();

         $datashow = DB::connection('mysql')->select('
             SELECT U2.invno,U1.vn,U1.hn,U1.ptname,U1.vstdate,U1.debit_total,U2.amount
                 FROM acc_1102050101_3099 U1
                 LEFT JOIN acc_stm_ti_total U2 ON U2.hn = U1.hn AND U2.vstdate = U1.vstdate
                 WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
                 AND U1.status ="N" GROUP BY U1.vn
             ');


         return view('account_pk.account_pkti3099_stmnull', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,
         ]);
     }

    public function account_pkti8011_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.8011"
                    and income <> 0
                    group by month(a.vstdate) asc;
            ');

        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.8011"
                    and income <>0
                    group by month(a.vstdate) asc;
            ');
        }

        return view('account_pk.account_pkti8011_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,

        ]);
    }

    // *************************** account_pkti2166 ********************************************
    public function account_pkti2166_dash(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.2166"

                    group by month(a.vstdate) desc;
            ');
            // and stamp = "N"
        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.2166"

                    group by month(a.vstdate) desc;
            ');
        }
        return view('account_pk.account_pkti2166_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pkti2166_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
                WHERE a.account_code="1102050101.2166"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_pk.account_pkti2166_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkti2166_pulldata(Request $request)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
         // Acc_opitemrece::truncate();
         $acc_debtor = DB::connection('mysql3')->select('
             SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                     ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                     ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                     ,v.hospmain,op.income as income_group
                     ,o.vstdate as vstdatesave
                     ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                     ,ptt.pttype_eclaim_id
                     ,o.pttype
                     ,e.gf_opd as gfmis,e.code as acc_code
                     ,e.ar_opd as account_code
                     ,e.name as account_name
                     ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                     ,v.rcpno_list as rcpno
                     ,v.income-v.discount_money-v.rcpt_money as debit
                     ,sum(if(op.income="02",sum_price,0)) as debit_instument
                     ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                     ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                     ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                     ,ptt.max_debt_money
             from ovst o
             left join vn_stat v on v.vn=o.vn
             left join patient pt on pt.hn=o.hn
             LEFT JOIN pttype ptt on o.pttype=ptt.pttype
             LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
             LEFT JOIN opitemrece op ON op.vn = o.vn
             WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
             AND ptt.pttype IN("M3","M4")
             GROUP BY o.vn
         ');

         foreach ($acc_debtor as $key => $value) {
                     $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.2166')->whereBetween('vstdate', [$startdate, $enddate])->count();
                     if ($check == 0) {
                        Acc_debtor::insert([
                             'hn'                 => $value->hn,
                             'an'                 => $value->an,
                             'vn'                 => $value->vn,
                             'cid'                => $value->cid,
                             'ptname'             => $value->ptname,
                             'pttype'             => $value->pttype,
                             'vstdate'            => $value->vstdatesave,
                             'acc_code'           => $value->acc_code,
                             'account_code'       => $value->account_code,
                             'account_name'       => $value->account_name,
                             'income_group'       => $value->income_group,
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
                             'debit_total'        => $value->debit,
                             'max_debt_amount'    => $value->max_debt_money,
                             'acc_debtor_userid'  => Auth::user()->id
                         ]);
                     }
         }

             return response()->json([

                 'status'    => '200'
             ]);
     }
    public function account_pkti2166(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('

            SELECT a.*,c.subinscl from acc_debtor a
            left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate

            WHERE a.account_code="1102050101.2166"
            AND a.stamp = "N"
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"
            order by a.vstdate asc;

        ');

        return view('account_pk.account_pkti2166', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkti2166_stmtang(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;

           $data = DB::connection('mysql')->select('
                SELECT a.an,a.vn,a.hn,a.cid,a.ptname,a.vstdate,a.pttype,a.acc_code,a.account_code,a.income,a.debit_total,au.repno,au.type_req,au.price_approve
                from acc_1102050101_2166 a
                LEFT JOIN acc_stm_ti au ON au.cid = a.cid AND au.vstdate = a.vstdate
                WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'" AND au.repno IS NULL;
            ');
           $sum_money_ = DB::connection('mysql')->select('
               SELECT SUM(a.debit_total) as total
               from acc_1102050101_2166 a
               LEFT JOIN acc_stm_ti au ON au.cid = a.cid AND au.vstdate = a.vstdate
               WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'" AND au.repno IS NULL;
           ');
           foreach ($sum_money_ as $key => $value) {
               $sum_debit_total = $value->total;
           }
           $sum_stm_ = DB::connection('mysql')->select('
               SELECT SUM(au.price_approve) as stmtotal
               from acc_1102050101_2166 a
               LEFT JOIN acc_stm_ti au ON au.cid = a.cid AND au.vstdate = a.vstdate
               WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'" AND au.repno IS NULL;
           ');
           foreach ($sum_stm_ as $key => $value) {
               $sum_stm_total = $value->stmtotal;
           }

        return view('account_pk.account_pkti2166_stmtang',[
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_pkti2166_stam(Request $request)
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
                    Acc_1102050101_2166::insert([
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
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                    ]);
                    // 'debit_total'       => $value->debit - $value->debit_drug - $value->debit_instument - $value->debit_refer - $value->debit_toa,
                    // $acc_opitemrece_ = DB::connection('mysql')->select('
                    //         SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                    //         FROM acc_opitemrece ao
                    //         LEFT JOIN acc_debtor a ON ao.vn = a.vn
                    //         WHERE a.account_code ="acc_1102050101_2166" AND a.stamp ="Y"
                    //         AND ao.vn ="'.$value->vn.'"
                    // ');
                    // foreach ($acc_opitemrece_ as $va2) {
                    //     Acc_opitemrece_stm::insert([
                    //         'hn'                 => $va2->hn,
                    //         'an'                 => $va2->an,
                    //         'vn'                 => $va2->vn,
                    //         'vstdate'            => $va2->vstdate,
                    //         'pttype'             => $va2->pttype,
                    //         'paidst'             => $va2->paidst,
                    //         'finance_number'     => $va2->finance_number,
                    //         'income'             => $va2->income,
                    //         'icode'              => $va2->icode,
                    //         'name'               => $va2->dname,
                    //         'qty'                => $va2->qty,
                    //         'cost'               => $va2->cost,
                    //         'unitprice'          => $va2->unitprice,
                    //         'discount'           => $va2->discount,
                    //         'sum_price'          => $va2->sum_price
                    //     ]);

                    // }
        }


        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkti2166_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
        SELECT a.vn,a.hn,a.cid,a.vstdate,a.ptname,a.pttype,a.account_code,a.income,a.debit,a.debit_total,ai.repno,SUM(ai.sum_price_approve) as price_approve
        FROM acc_1102050101_2166 a
        LEFT JOIN acc_stm_ti_total ai ON ai.cid = a.cid AND ai.vstdate = a.vstdate
        WHERE a.account_code="1102050101.2166"
            and month(a.vstdate) = "'.$months.'"
            and year(a.vstdate) = "'.$year.'"
            AND ai.repno IS NOT NULL
			GROUP BY a.vn
        ');
        // SELECT a.acc_debtor_id,a.vn,a.an,a.hn,a.vstdate,a.ptname,a.pttype,a.subinscl
        // ,a.income,a.uc_money
        // FROM acc_debtor a
        // left join acc_stm_ti ac ON ac.cid = a.cid and ac.vstdate = a.vstdate

        return view('account_pk.account_pkti2166_stm', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function ti2166_send(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
                SELECT * from acc_debtor a
                WHERE stamp="Y"
                and account_code="1102050101.2166"
                and month(vstdate) = "'.$id.'";
            ');
            // left join acc_debtor_stamp ad on ad.stamp_vn=a.vn
        return view('account_pk.ti2166_send', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'id'       =>     $id
        ]);
    }

    public function ti2166_detail(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
                SELECT * from acc_debtor a
                WHERE account_code="1102050101.2166"
                and income <> 0
                and month(vstdate) = "'.$id.'";
            ');

        return view('account_pk.ti2166_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'leave_month_year' =>  $leave_month_year,
            'id'       =>     $id
        ]);
    }

    public function upstm_ofcexcel(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
                SELECT repno,vstdate,SUM(pricereq_all) as Sumprice,STMdoc,month(vstdate) as months
                FROM acc_stm_ofcexcel
                GROUP BY repno
            ');
        $countc = DB::table('acc_stm_ofcexcel')->count();
        // dd($countc );
        return view('account_pk.upstm_ofcexcel',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function upstm_ofcexcel_save(Request $request)
    {
            Excel::import(new ImportAcc_stm_ofcexcel_import, $request->file('file')->store('files'));

             return response()->json([
                'status'    => '200',
            ]);
    }
    public function upstm_ofcexcel_senddata(Request $request)
    {
        $data_ = DB::connection('mysql')->select('
            SELECT *
            FROM acc_stm_ofcexcel
        ');
        // GROUP BY cid,vstdate
        foreach ($data_ as $key => $value) {
                Acc_stm_ofc::create([
                    'repno'             => $value->repno,
                    'no'                => $value->no,
                    'hn'                => $value->hn,
                    'an'                => $value->an,
                    'cid'               => $value->cid,
                    'fullname'          => $value->fullname,
                    'vstdate'           => $value->vstdate,
                    'dchdate'           => $value->dchdate,
                    'PROJCODE'          => $value->PROJCODE,
                    'AdjRW'             => $value->AdjRW,
                    'price_req'         => $value->price_req,
                    'prb'               => $value->prb,
                    'room'              => $value->room,
                    'inst'              => $value->inst,
                    'drug'              => $value->drug,
                    'income'            => $value->income,
                    'refer'             => $value->refer,
                    'waitdch'           => $value->waitdch,
                    'service'           => $value->service,
                    'pricereq_all'      => $value->pricereq_all,
                    'STMdoc'            => $value->STMdoc,
                    'HDflag'            => 'OFC'
                ]);
                acc_1102050101_4022::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                ->update([
                    'status'   => 'Y'
                ]);
        }
        Acc_stm_ofcexcel::truncate();
        // return response()->json([
        //     'status'    => '200',
        // ]);
        return redirect()->back();
    }

    public function upstm_lgoexcel(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
                SELECT rep,vstdate,SUM(claim_true) as Sumprice,STMdoc,month(vstdate) as months
                FROM acc_stm_lgoexcel
                GROUP BY rep
            ');
        $countc = DB::table('acc_stm_lgoexcel')->count();
        // dd($countc );
        return view('account_pk.upstm_lgoexcel',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function upstm_lgoexcel_save(Request $request)
    {
            Excel::import(new ImportAcc_stm_lgoexcel_import, $request->file('file')->store('files'));

             return response()->json([
                'status'    => '200',
            ]);
    }
    public function upstm_lgoexcel_senddata(Request $request)
    {
        $data_ = DB::connection('mysql')->select('
            SELECT *
            FROM acc_stm_lgoexcel
        ');
        // GROUP BY cid,vstdate
        foreach ($data_ as $key => $value) {
                Acc_stm_lgo::create([
                        'rep'         => $value->rep,
                        'no'          => $value->no,
                        'tranid'      => $value->tranid,
                        'hn'          => $value->hn,
                        'an'          => $value->an,
                        'cid'         => $value->cid,
                        'fullname'    => $value->fullname,
                        'type'        => $value->type,
                        'vstdate'     => $value->vstdate,
                        'dchdate'     => $value->dchdate,
                        'price1'      => $value->price1,
                        'pp_spsch'    => $value->pp_spsch,
                        'errorcode'   => $value->errorcode,
                        'kongtoon'    => $value->kongtoon,
                        'typeservice' => $value->typeservice,
                        'refer'       => $value->refer,
                        'pttype_have' => $value->pttype_have,
                        'pttype_true' => $value->pttype_true,
                        'mian_pttype' => $value->mian_pttype,
                        'secon_pttype' =>$value->secon_pttype,
                        'href'        => $value->href,
                        'HCODE'       => $value->HCODE,
                        'prov1'       => $value->prov1,
                        'code_dep'    => $value->code_dep,
                        'name_dep'    => $value->name_dep,
                        'proj'        => $value->proj,
                        'pa'          => $value->pa,
                        'drg'         => $value->drg,
                        'rw'          => $value->rw,
                        'income'      => $value->income,
                        'pp_gep'      => $value->pp_gep,
                        'claim_true'  => $value->claim_true,
                        'claim_false' => $value->claim_false,
                        'cash_money'  => $value->cash_money,
                        'pay'         => $value->pay,
                        'ps'          => $value->ps,
                        'ps_percent'  => $value->ps_percent,
                        'ccuf'        => $value->ccuf,
                        'AdjRW'       => $value->AdjRW,
                        'plb'         => $value->plb,
                        'IPLG'        => $value->IPLG,
                        'OPLG'        => $value->OPLG,
                        'PALG'        => $value->PALG,
                        'INSTLG'      => $value->INSTLG,
                        'OTLG'        => $value->OTLG,
                        'PP'          => $value->PP,
                        'DRUG'        => $value->DRUG,
                        'IPLG2'       => $value->IPLG2,
                        'OPLG2'       => $value->OPLG2,
                        'PALG2'       => $value->PALG2,
                        'INSTLG2'     => $value->INSTLG2,
                        'OTLG2'       => $value->OTLG2,
                        'ORS'         => $value->ORS,
                        'VA'          => $value->VA,
                        'STMdoc'      => $value->STMdoc
                ]);
                acc_1102050102_801::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                ->update([
                    'status'   => 'Y'
                ]);
        }
        Acc_stm_lgoexcel::truncate();
        // return response()->json([
        //     'status'    => '200',
        // ]);
        return redirect()->back();
    }

    public function upstm_ucs(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
            SELECT rep,vstdate,SUM(ip_paytrue) as Sumprice,STMdoc,month(vstdate) as months
            FROM acc_stm_ucs_excel
            GROUP BY rep
            ');
        $countc = DB::table('acc_stm_ucs_excel')->count();
        // dd($countc );
        return view('account_pk.upstm_ucs',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    function upstm_ucs_excel(Request $request){
        // Acc_stm_ucs_excel::truncate();

        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file');
        // dd($the_file);
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                // $sheet        = $spreadsheet->getActiveSheet();
                $sheet        = $spreadsheet->setActiveSheetIndex(2);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 15, $row_limit );
                $column_range = range( 'AP', $column_limit );
                $startcount = 15;
                // $nobook =  range( 7, $row_limit );
                // $nobook = range( 7, $column_limit );
                $data = array();
                foreach ( $row_range as $row ) {
  
                    // $match_stm=$result["C"].(str_replace(" ","",str_replace("/","",str_replace(":","",$result["G"]))));
           
                    $data[] = [
                        'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                        'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                        'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                        'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                        'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                        'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(),

                        // $sheet->getActiveSheet()->setCellValue('H', 39813)
                        // 'vstdate'               =>$sheet->setCellValue('H', 39813),
                        // 'dchdate'               =>$sheet->setCellValue('I', 39813),
                        // 'vstdate'               =>$sheet->getCell( 'H' . $row ,39813)->getValue(),
                        // 'dchdate'               =>$sheet->getCell( 'I' . $row ,39813)->getValue(),
                        // ->setCellValue('D1', 39813)

                        // 'vstdate'               =>$vstdate,
                        // 'dchdate'               =>$dchdate,

                        'vstdate'               =>$sheet->getCell( 'H' . $row )->getValue(),
                        'dchdate'               =>$sheet->getCell( 'I' . $row )->getValue(),

                        'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
                        'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
                        'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
                        'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
                        'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                        'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
                        'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
                        'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
                        'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(),
                        'pay_money'             =>$sheet->getCell( 'S' . $row )->getValue(),
                        'pay_slip'              =>$sheet->getCell( 'T' . $row )->getValue(),
                        'pay_after'             =>$sheet->getCell( 'U' . $row )->getValue(),
                        'op'                    =>$sheet->getCell( 'V' . $row )->getValue(),
                        'ip_pay1'               =>$sheet->getCell( 'W' . $row )->getValue(),
                        'ip_paytrue'            =>$sheet->getCell( 'X' . $row )->getValue(),
                        'hc'                    =>$sheet->getCell( 'Y' . $row )->getValue(),
                        'hc_drug'               =>$sheet->getCell( 'Z' . $row )->getValue(),
                        'ae'                    =>$sheet->getCell( 'AA' . $row )->getValue(),
                        'ae_drug'               =>$sheet->getCell( 'AB' . $row )->getValue(),
                        'inst'                  =>$sheet->getCell( 'AC' . $row )->getValue(),
                        'dmis_money1'           =>$sheet->getCell( 'AD' . $row )->getValue(),
                        'dmis_money2'           =>$sheet->getCell( 'AE' . $row )->getValue(),
                        'dmis_drug'             =>$sheet->getCell( 'AF' . $row )->getValue(),
                        'palliative_care'       =>$sheet->getCell( 'AG' . $row )->getValue(),
                        'dmishd'                =>$sheet->getCell( 'AH' . $row )->getValue(),
                        'pp'                    =>$sheet->getCell( 'AI' . $row )->getValue(),
                        'fs'                    =>$sheet->getCell( 'AJ' . $row )->getValue(),
                        'opbkk'                 =>$sheet->getCell( 'AK' . $row )->getValue(),
                        'total_approve'         =>$sheet->getCell( 'AL' . $row )->getValue(),
                        'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
                        'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
                        'STMdoc'                =>$sheet->getCell( 'AO' . $row )->getValue(),
                    ];
 
                    $startcount++;
                }
                // $check_ = DB::table('acc_stm_ucs_excel')->where('tranid','=',$sheet->getCell( 'C' . $row )->getValue())->count();
                // if ($check_ > 0) {
                //     # code...
                // } else {
                    DB::table('acc_stm_ucs_excel')->insert($data);
                // }
                
                
                // DB::table('acc_stm_ucs')->insert($data);

            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
           
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            return response()->json([
            'status'    => '200',
        ]);

    }

    public function upstm_ucs_sendexcel(Request $request)
    {
      
        try{
            $data_ = DB::connection('mysql')->select('
                SELECT *
                FROM acc_stm_ucs_excel
            ');
            $count = 1;
            $data = array();
            foreach ($data_ as $key => $row) {
                $data[] = [
                    'rep'                   =>$row->rep,
                    'repno'                 =>$row->repno,
                    'tranid'                =>$row->tranid,
                    'hn'                    =>$row->hn,
                    'an'                    =>$row->an,
                    'cid'                   =>$row->cid,
                    'fullname'              =>$row->fullname,
                    'vstdate'               =>$row->vstdate,
                    'dchdate'               =>$row->dchdate,
                    'maininscl'             =>$row->maininscl,
                    'projectcode'           =>$row->projectcode,
                    'debit'                 =>$row->debit,
                    'debit_prb'             =>$row->debit_prb,
                    'adjrw'                 =>$row->adjrw,
                    'ps1'                   =>$row->ps1,
                    'ps2'                   =>$row->ps2,
                    'ccuf'                  =>$row->ccuf,
                    'adjrw2'                =>$row->adjrw2,
                    'pay_money'             =>$row->pay_money,
                    'pay_slip'              =>$row->pay_slip,
                    'pay_after'             =>$row->pay_after,
                    'op'                    =>$row->op,
                    'ip_pay1'               =>$row->ip_pay1,
                    'ip_paytrue'            =>$row->ip_paytrue,
                    'hc'                    =>$row->hc,
                    'hc_drug'               =>$row->hc_drug,
                    'ae'                    =>$row->ae,
                    'ae_drug'               =>$row->ae_drug,
                    'inst'                  =>$row->inst,
                    'dmis_money1'           =>$row->dmis_money1,
                    'dmis_money2'           =>$row->dmis_money2,
                    'dmis_drug'             =>$row->dmis_drug,
                    'palliative_care'       =>$row->palliative_care,
                    'dmishd'                =>$row->dmishd,
                    'pp'                    =>$row->pp,
                    'fs'                    =>$row->fs,
                    'opbkk'                 =>$row->opbkk,
                    'total_approve'         =>$row->total_approve,
                    'va'                    =>$row->va,
                    'covid'                 =>$row->covid,
                    'STMdoc'                =>$row->STMdoc,
                ];
                $count++;
            }
            $check_ = DB::table('acc_stm_ucs')->where('tranid','=',$row->tranid)->count();
            if ($check_ > 0) {
                # code...
            } else {
                DB::table('acc_stm_ucs')->insert($data);
            }
            // DB::table('acc_stm_ucs')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
       
        // foreach ($data_ as $key => $value) {
        //         Acc_stm_ucs::create([
        //             'rep'               => $value->rep,
        //             'repno'             => $value->repno,
        //             'tranid'            => $value->tranid,
        //             'hn'                => $value->hn,
        //             'an'                => $value->an,
        //             'cid'               => $value->cid,
        //             'fullname'          => $value->fullname,
        //             'vstdate'           => $value->vstdate,
        //             'dchdate'           => $value->dchdate,
        //             'maininscl'         => $value->maininscl,
        //             'projectcode'       => $value->projectcode,
        //             'debit'             => $value->debit,
        //             'debit_prb'         => $value->debit_prb,
        //             'adjrw'             => $value->adjrw,
        //             'ps1'               => $value->ps1,
        //             'ps2'               => $value->ps2,
        //             'ccuf'              => $value->ccuf,
        //             'adjrw2'            => $value->adjrw2,
        //             'pay_money'         => $value->pay_money,
        //             'pay_slip'          => $value->pay_slip,
        //             'pay_after'         => $value->pay_after,
        //             'op'                => $value->op,
        //             'ip_pay1'           => $value->ip_pay1,
        //             'ip_paytrue'        => $value->ip_paytrue,
        //             'hc'                => $value->hc,
        //             'hc_drug'           => $value->hc_drug,
        //             'ae'                => $value->ae,
        //             'ae_drug'           => $value->ae_drug,
        //             'inst'              => $value->inst,
        //             'dmis_money1'       => $value->dmis_money1,
        //             'dmis_money2'       => $value->dmis_money2,
        //             'dmis_drug'         => $value->dmis_drug,
        //             'palliative_care'   => $value->palliative_care,
        //             'dmishd'            => $value->dmishd,
        //             'pp'                => $value->pp,
        //             'fs'                => $value->fs,
        //             'opbkk'             => $value->opbkk,
        //             'total_approve'     => $value->total_approve,
        //             'va'                => $value->va,
        //             'covid'             => $value->covid,
        //             'date_save'         => $value->date_save,
        //             'STMdoc'            => $value->STMdoc
        //         ]);
        //         Acc_1102050101_202::where('an',$value->an)
        //         ->update([
        //             'status'   => 'Y'
        //         ]);
        // }
        Acc_stm_ucs_excel::truncate();
        // return response()->json([
        //     'status'    => '200',
        // ]);
        return redirect()->back();
    }

    // Acc_stm_ti
    public function upstm_ti(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
                SELECT repno,vstdate,SUM(pay_amount) as Sumprice,filename,month(vstdate) as months
                FROM acc_stm_ti_excel
                GROUP BY repno
            ');
        $countc = DB::table('acc_stm_ti_excel')->count();
        // dd($countc );
        return view('account_pk.upstm_ti',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function upstm_hn(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;

        $acc_debtor = DB::select('
            SELECT tranid,hn,cid,vstdate from acc_stm_ti
            WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND hn is null;
        ');
        // AND hn is null;
        foreach ($acc_debtor as $key => $value) {

            $data_ = DB::table('acc_stm_ti')->where('hn','<>','')->where('cid','=',$value->cid)->first();
            $datahn = $data_->hn;

            Acc_stm_ti::where('cid', $value->cid)
            // ->where('vstdate', $value->vstdate)
            // ->where('hn','=',$datahn)
                    ->update([
                            'hn'   => $datahn
                ]);
        }
        return view('account_pk.upstm_ti',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
        // return response()->json([
        //     'status'    => '200'
        // ]);
    }

    public function upstm_ti_import(Request $request)
    {
        // dd($request->file('file'));
        // Excel::import(new ImportAcc_stm_ti, $request->file('file')->store('files'));
        // Acc_stm_ti_excel::truncate();

            Excel::import(new ImportAcc_stm_tiexcel_import, $request->file('file')->store('files'));
             return response()->json([
                'status'    => '200',
            ]);

        // return response()->json([
        //     'status'    => '200',
        // ]);
    }
    public function upstm_ti_importtotal(Request $request)
    {
        $data_ = DB::connection('mysql')->select('
                SELECT repno,hn,cid,fullname,vstdate,filename,hipdata_code,sum(pay_amount) as Sumprice
                FROM acc_stm_ti_excel
                GROUP BY cid,vstdate
        ');
        foreach ($data_ as $key => $value) {
            $check = Acc_stm_ti_total::where('cid',$value->cid)->where('vstdate',$value->vstdate)->count();
            if ($check > 0) {
                Acc_stm_ti_total::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                    ->update([
                        // 'repno'             => $value->repno,
                        // 'hn'                => $value->hn,
                        // 'cid'               => $value->cid,
                        // 'fullname'          => $value->fullname,
                        // 'vstdate'           => $value->vstdate,
                        // 'sum_price_approve' => $value->Sumprice,
                        'Total_amount'      => $value->Sumprice,
                        'STMdoc'            => $value->filename,
                        'HDflag'            => $value->hipdata_code
                ]);
            } else {
                Acc_stm_ti_total::create([
                    'repno'             => $value->repno,
                    'hn'                => $value->hn,
                    'cid'               => $value->cid,
                    'fullname'          => $value->fullname,
                    'vstdate'           => $value->vstdate,
                    'sum_price_approve' => $value->Sumprice,
                    'Total_amount'      => $value->Sumprice,
                    'STMdoc'            => $value->filename,
                    'HDflag'            => $value->hipdata_code
                ]);
            }
            Acc_1102050101_2166::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                ->update([
                    'status'   => 'Y'
                ]);
        }


        Acc_stm_ti_excel::truncate();
        return redirect()->back();
    }
    function upstm_ti_importexcel(Request $request){
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 9, $row_limit );
            $column_range = range( 'F', $column_limit );
            $startcount = 9;
            $data = array();
            foreach ( $row_range as $row ) {

                $reg = $sheet->getCell( 'J' . $row )->getValue();

                $starttime = substr($reg, 0, 5);
                $regday = substr($reg, 0, 2);
                $regmo = substr($reg, 3, 2);
                $regyear = substr($reg, 6, 10);
                $regdate = $regyear.'-'.$regmo.'-'.$regday;

                $vst = $sheet->getCell( 'K' . $row )->getValue();
                $starttime = substr($vst, 0, 5);
                $day = substr($vst, 0, 2);
                $mo = substr($vst, 3, 2);
                $year = substr($vst, 6, 10);
                $vstdate = $year.'-'.$mo.'-'.$day;

                $data[] = [
                    // 'hcode'                 =>$sheet->getCell( 'A' . $row )->getValue(),
                    'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                    'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
                    'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                    'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                    'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                    'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(),
                    'hipdata_code'          =>$sheet->getCell( 'H' . $row )->getValue(),

                    'regdate'               =>$regdate,
                    'vstdate'               =>$vstdate,

                    // 'regdate'               =>$sheet->getCell( 'J' . $row )->getValue(),
                    // 'vstdate'               =>$sheet->getCell( 'K' . $row )->getValue(),
                    'no'                    =>$sheet->getCell( 'L' . $row )->getValue(),
                    'list'                  =>$sheet->getCell( 'M' . $row )->getValue(),
                    'qty'                   =>$sheet->getCell( 'N' . $row )->getValue(),
                    'unitprice'             =>$sheet->getCell( 'O' . $row )->getValue(),
                    'unitprice_max'         =>$sheet->getCell( 'P' . $row )->getValue(),
                    'price_request'         =>$sheet->getCell( 'Q' . $row )->getValue(),
                    'pscode'                =>$sheet->getCell( 'R' . $row )->getValue(),
                    'percent'               =>$sheet->getCell( 'S' . $row )->getValue(),
                    'pay_amount'            =>$sheet->getCell( 'T' . $row )->getValue(),
                    'nonpay_amount'         =>$sheet->getCell( 'U' . $row )->getValue(),
                    'payplus_amount'        =>$sheet->getCell( 'V' . $row )->getValue(),
                    'payback_amount'        =>$sheet->getCell( 'W' . $row )->getValue(),
                    'filename'              =>$sheet->getCell( 'Y' . $row )->getValue(),
                ];
                $startcount++;
            }
            DB::table('acc_stm_ti_excel')->insert($data);
            // DB::table('check_authen')->insert($data);
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
        }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
                    return response()->json([
                    'status'    => '200',
                ]);

    }
    public function upstm_tixml(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        return view('account_pk.upstm_tixml',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function upstm_tixml_import(Request $request)
    {
            $tar_file_ = $request->file;
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
            $filename = pathinfo($file_, PATHINFO_FILENAME);
            $extension = pathinfo($file_, PATHINFO_EXTENSION);
            $xmlString = file_get_contents(($tar_file_));
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $result = json_decode($json, true);

            // dd($result);
            @$stmAccountID = $result['stmAccountID'];
            @$hcode = $result['hcode'];
            @$hname = $result['hname'];
            @$AccPeriod = $result['AccPeriod'];
            @$STMdoc = $result['STMdoc'];
            @$dateStart = $result['dateStart'];
            @$dateEnd = $result['dateEnd'];
            @$datedue = $result['datedue'];
            @$dateIssue = $result['dateIssue'];
            @$amount = $result['amount'];
            @$thamount = $result['thamount'];
            @$TBills = $result['TBills']['TBill'];
            // @$TBills = $result['TBills']['HDBills']['TBill']; //sss
            $bills_       = @$TBills;
            // dd($bills_ );
            $checkchead = Acc_stm_ti_totalhead::where('AccPeriod', @$AccPeriod)->count();
            if ($checkchead > 0) {
                # code...
            } else {
                Acc_stm_ti_totalhead::insert([
                    'stmAccountID'    => @$stmAccountID,
                    'hcode'           => @$hcode,
                    'hname'           => @$hname,
                    'AccPeriod'       => @$AccPeriod,
                    'STMdoc'          => @$STMdoc,
                    'dateStart'       => @$dateStart,
                    'dateEnd'         => @$dateEnd,
                    'datedue'        => @$datedue,
                    'dateIssue'       => @$dateIssue,
                    'amount'          => @$amount,
                    'thamount'        => @$thamount
                ]);
            }
                foreach ($bills_ as $value) {
                    $hreg = $value['hreg'];
                    $station = $value['station'];
                    $invno = $value['invno'];
                    $hn = $value['hn'];
                    $amount = $value['amount'];
                    $paid = $value['paid'];
                    $rid = $value['rid'];
                    $HDflag = $value['HDflag'];
                    $dttran = $value['dttran'];
                    $dttranDate = explode("T",$value['dttran']);
                    $dttdate = $dttranDate[0];
                    $dtttime = $dttranDate[1];
                    $checkc = Acc_stm_ti_total::where('hn', $hn)->where('vstdate', $dttdate)->count();

                    if ( $checkc > 0) {
                        Acc_stm_ti_total::where('hn',$hn)->where('vstdate',$dttdate)
                            ->update([
                                'invno'             => $invno,
                                'hn'                => $hn,
                                'station'           => $station,
                                'STMdoc'            => @$STMdoc,
                                'vstdate'           => $dttdate,
                                'paid'              => $paid,
                                'rid'               => $rid,
                                'HDflag'            => $HDflag,
                                'amount'            => $amount,
                                'Total_amount'      => $amount
                            ]);
                            Acc_1102050101_4011::where('hn',$hn)->where('vstdate',$dttdate)
                            ->update([
                                'status'            => 'Y'
                            ]);

                    } else {
                            Acc_stm_ti_total::insert([
                                'invno'             => $invno,
                                'hn'                => $hn,
                                'station'           => $station,
                                'STMdoc'            => @$STMdoc,
                                'vstdate'           => $dttdate,
                                'paid'              => $paid,
                                'rid'               => $rid,
                                'HDflag'            => $HDflag,
                                'amount'            => $amount,
                                'Total_amount'      => $amount
                            ]);

                            Acc_1102050101_4011::where('hn',$hn)->where('vstdate',$dttdate)
                            ->update([
                                'status'            => 'Y'
                            ]);
                    }
                }
                // return redirect()->back();
                return response()->json([
                    'status'    => '200'
                ]);

    }
    public function upstm_tixml_sss(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        return view('account_pk.upstm_tixml_sss',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function upstm_tixml_sssimport(Request $request)
    {
            $tar_file_ = $request->file;
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
            $filename = pathinfo($file_, PATHINFO_FILENAME);
            $extension = pathinfo($file_, PATHINFO_EXTENSION);
            $xmlString = file_get_contents(($tar_file_));
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $result = json_decode($json, true);

            // dd($result);
            @$stmAccountID = $result['stmAccountID'];
            @$hcode = $result['hcode'];
            @$hname = $result['hname'];
            @$AccPeriod = $result['AccPeriod'];
            @$STMdoc = $result['STMdoc'];
            @$dateStart = $result['dateStart'];
            @$dateEnd = $result['dateEnd'];
            @$dateData = $result['dateData'];
            @$dateIssue = $result['dateIssue'];
            @$acount = $result['acount'];
            @$amount = $result['amount'];
            @$thamount = $result['thamount'];
            @$STMdat = $result['STMdat'];
            @$HDBills = $result['HDBills'];
            // @$TBills = $result['HDBills']['HDBill']['TBill']; //sss

            $checkchead = Acc_stm_ti_totalhead::where('stmAccountID', @$stmAccountID)->where('AccPeriod', @$AccPeriod)->count();
            if ($checkchead > 0) {
                # code...
            } else {
                Acc_stm_ti_totalhead::insert([
                    'stmAccountID'    => @$stmAccountID,
                    'hcode'           => @$hcode,
                    'hname'           => @$hname,
                    'AccPeriod'       => @$AccPeriod,
                    'STMdoc'          => @$STMdoc,
                    'dateStart'       => @$dateStart,
                    'dateEnd'         => @$dateEnd,
                    'datedue'         => @$dateData,
                    'dateIssue'       => @$dateIssue,
                    'acount'          => @$acount,
                    'amount'          => @$amount,
                    'thamount'        => @$thamount
                ]);
            }
            $bills_       = @$HDBills;
            // dd($bills_ );
                $tbill_ = $bills_['HDBill'];
                // dd($tbill_ );
                foreach ($tbill_ as $key => $value) {
                    // $hn           = $value['hn'];
                    $fullname     = $value['name'];
                    $cid          = $value['pid'];
                    // $quota        = $value['quota'];
                    // $hdcharge     = $value['hdcharge'];
                    // $payable      = $value['payable'];
                    
                    $tbill        = $value['TBill'];
                    foreach ($tbill as $key => $value2) {
                            $hcode = $value2['hreg'];
                            // dd($hcode );
                            $station    = $value2['station'];
                            $hn         = $value2['hn'];
                            $invno      = $value2['invno'];
                            $amount     = $value2['amount'];
                            $paid       = $value2['paid'];
                            $rid        = $value2['rid'];
                            $hdrate     = $value2['hdrate'];
                            $hdcharge   = $value2['hdcharge'];
                            $HDflag     = $value2['HDflag'];
                            $dttran     = $value2['dttran'];
                            $dttranDate = explode("T",$value2['dttran']);
                            $dttdate    = $dttranDate[0];
                            $dtttime    = $dttranDate[1];
                            // $EPOpay     = $value2['EPOpay'];

                            if (isset($value2['EPOpay'])) {
                                // $EPO_tt = $value2['EPOs']['EPO']['epoPay'];
                                // $EPO_tt = $value2['EPOs']['EPOpay'];
                                $EPO_tt = $value2['EPOpay'];
                                $Total = $amount + $EPO_tt;
                            } elseif (isset($value2['EPOs']['EPO']['epoPay'])){
                                $EPO_tt = $value2['EPOs']['EPO']['epoPay'];
                                $Total = $amount + $EPO_tt;
                            } else {
                                // $EPO_tt = $value2['EPOpay'];
                                // $EPO_tt = $value2['EPO']['epoPay'];
                                // $EPO_tt = $value2['EPOs']['EPO']['epoPay'];
                                $EPO_tt = '';
                                $Total = '';
                            }


                        // if (isset($value2['EPOs']['EPOpay'])) {
                            // if (isset($value2['EPOs']['EPO']['epoPay'])) {
                            //     $EPO_tt = $value2['EPOs']['EPO']['epoPay'];
                            //     // $EPO_tt = $value2['EPOs']['EPOpay'];
                            //     $Total = $amount + $EPO_tt;
                            // } else {
                            //     $EPO_tt = '';
                            //     $Total = '';
                            // }
                            // dd($EPO_tt );  EPOpay
                            $checkc     = Acc_stm_ti_total::where('hn', $hn)->where('vstdate', $dttdate)->count();
                            $datenow = date('Y-m-d');
                            if ( $checkc > 0) {
                                Acc_stm_ti_total::where('hn',$hn)->where('vstdate',$dttdate)
                                    ->update([
                                        'station'           => $station,
                                        'invno'             => $invno,
                                        'hn'                => $hn,
                                        'STMdoc'            => @$STMdoc,
                                        'dttran'            => $dttran,
                                        'vstdate'           => $dttdate,
                                        'paid'              => $paid,
                                        'rid'               => $rid,
                                        'cid'               => $cid,
                                        'fullname'          => $fullname,
                                        'EPOpay'            => $EPO_tt,
                                        // 'EPOpay'            => $EPOpay,
                                        'hdrate'            => $hdrate,
                                        'hdcharge'          => $hdcharge,
                                        'amount'            => $amount,
                                        'HDflag'            => $HDflag,
                                        'Total_amount'      => $Total,
                                        'date_save'         => $datenow
                                    ]);
                                    Acc_1102050101_3099::where('hn',$hn)->where('vstdate',$dttdate)
                                    ->update([
                                        'status'            => 'Y'
                                    ]);
                            } else {
                                Acc_stm_ti_total::insert([
                                    'station'           => $station,
                                    'invno'             => $invno,
                                    'hn'                => $hn,
                                    'STMdoc'            => @$STMdoc,
                                    'dttran'            => $dttran,
                                    'vstdate'           => $dttdate,
                                    'paid'              => $paid,
                                    'rid'               => $rid,
                                    'cid'               => $cid,
                                    'fullname'          => $fullname,
                                    'EPOpay'            => $EPO_tt,
                                    // 'EPOpay'            => $EPOpay,
                                    'hdrate'            => $hdrate,
                                    'hdcharge'          => $hdcharge,
                                    'amount'            => $amount,
                                    'HDflag'            => $HDflag,
                                    'Total_amount'      => $Total,
                                    'date_save'         => $datenow
                                ]);
                                Acc_1102050101_3099::where('hn',$hn)->where('vstdate',$dttdate)
                                ->update([
                                    'status'            => 'Y'
                                ]);
                            }
                    }
                }
                // return redirect()->back();
                return response()->json([
                    'status'    => '200'
                ]);
    }

    public function acc_setting(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql3')->select('
            SELECT pt.pttype_acc_id,pt.pttype_acc_code,pt.pttype_acc_name as ptname
            ,pt.pttype_acc_eclaimid,e.name as eclaimname
            ,e.ar_opd,e.ar_ipd
            from pttype_acc pt
            left join pttype_eclaim e on e.code = pt.pttype_acc_eclaimid
        ');
        // ,pt.pcode,pt.paidst,pt.hipdata_code,pt.max_debt_money,pt.nhso_code
        $aropd = Pttype_eclaim::where('pttype_eclaim.ar_opd','<>',NULL)->groupBy('pttype_eclaim.ar_opd')->get();
        $aripd = Pttype_eclaim::where('pttype_eclaim.ar_ipd','<>',NULL)->groupBy('pttype_eclaim.ar_ipd')->get();
        // left join pttype_eclaim e on e.code = ptt.pttype_eclaim_id
         return view('account_pk.acc_setting',[
            'datashow'      =>     $datashow,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'aropd'         =>     $aropd,
            'aripd'         =>     $aripd,
         ]);
    }
    public function acc_setting_edit(Request $request,$id)
    {
        $type = Pttype_acc::find($id);

        return response()->json([
            'status'     => '200',
            'type'       =>  $type,
        ]);
    }
    public function acc_setting_update(Request $request)
    {
        $accid = $request->input('acc_id');
        $code = $request->input('ar_opd');

        $update = pttype_acc::find($accid);
        $update->pttype_acc_eclaimid = $code;
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function acc_setting_save(Request $request)
    {
        $accid = $request->input('insertpttype');
        $code = $request->input('insertar_opd');

        $add = pttype_acc::find($accid);
        $add->pttype_acc_eclaimid = $code;
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }


}