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
use App\Models\Acc_dashboard;

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

class AccdashboardController extends Controller
{
  public function account_pk_dash(Request $request)
  {    
          $budget_year   = $request->budget_year;
          $yearnew = date('Y');
          $year_old = date('Y')-1;
          $months_old  = ('10');
          $startdate = (''.$year_old.'-10-01');
          $enddate = (''.$yearnew.'-09-30');
            
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
              //  dd($dabudget_year);
            if ($budget_year == '') {  
               
                $datashow = DB::select(' 
                        SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                        ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                        ,sum(a.debit_total) as tung_looknee  
                        FROM acc_1102050101_202 a 
                        LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND a.account_code ="1102050101.202"
                        GROUP BY months ORDER BY a.dchdate DESC
                ');    
            } else {
                $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
                $startdate    = $bg->date_begin;
                $enddate      = $bg->date_end;
                // dd($enddate);
                $datashow = DB::select(' 
                        SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                        ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                        ,sum(a.debit_total) as tung_looknee  
                        FROM acc_1102050101_202 a 
                        LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND a.account_code ="1102050101.202"
                        GROUP BY months ORDER BY a.dchdate DESC 
                ');  
            }
        $data['pang']          =  DB::connection('mysql')->select('SELECT * FROM acc_setpang WHERE active ="TRUE" order by pang ASC'); 
        $data['sum_201']       = DB::table('acc_1102050101_201')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_202']       = DB::table('acc_1102050101_202')->whereBetween('dchdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_203']       = DB::table('acc_1102050101_203')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_209']       = DB::table('acc_1102050101_209')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_216']       = DB::table('acc_1102050101_216')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_2166']       = DB::table('acc_1102050101_2166')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_217']       = DB::table('acc_1102050101_217')->whereBetween('dchdate', [$startdate, $enddate])->sum('debit_total');

        $datashow = Acc_dashboard::where('months',' month("'. $startdate.'")')->get();
        $data['sumlooknee'] = $data['sum_201']+$data['sum_202']+$data['sum_203']+$data['sum_209']+$data['sum_216']+$data['sum_2166']+$data['sum_217']+$data['sum_201'];
      
    return view('dashboard.account_pk_dash',$data, [ 
      'datashow'          =>  $datashow,
      'startdate'         =>  $startdate,
      'enddate'           =>  $enddate,
    ]);
  }
  public function account_monitor_main(Request $request)
  {          
          $budget_year   = $request->budget_year;
          $yearnew = date('Y');
          $year_old = date('Y')-1;
          $months_old  = ('10');
          $startdate = (''.$year_old.'-10-01');
          $enddate = (''.$yearnew.'-09-30');
            
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
              //  dd($dabudget_year);
            if ($budget_year == '') {  
               
                $datashow = DB::select(' 
                        SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                        ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                        ,sum(a.debit_total) as tung_looknee  
                        FROM acc_1102050101_202 a 
                        LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND a.account_code ="1102050101.202"
                        GROUP BY months ORDER BY a.dchdate DESC
                ');    
            } else {
                $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
                $startdate    = $bg->date_begin;
                $enddate      = $bg->date_end;
                // dd($enddate);
                $datashow = DB::select(' 
                        SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                        ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                        ,sum(a.debit_total) as tung_looknee  
                        FROM acc_1102050101_202 a 
                        LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND a.account_code ="1102050101.202"
                        GROUP BY months ORDER BY a.dchdate DESC 
                ');  
            }
        $data['pang']          =  DB::connection('mysql')->select('SELECT * FROM acc_setpang WHERE active ="TRUE" order by pang ASC'); 
        $data['sum_201']       = DB::table('acc_1102050101_201')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_202']       = DB::table('acc_1102050101_202')->whereBetween('dchdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_203']       = DB::table('acc_1102050101_203')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_209']       = DB::table('acc_1102050101_209')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_216']       = DB::table('acc_1102050101_216')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_2166']       = DB::table('acc_1102050101_2166')->whereBetween('vstdate', [$startdate, $enddate])->sum('debit_total');
        $data['sum_217']       = DB::table('acc_1102050101_217')->whereBetween('dchdate', [$startdate, $enddate])->sum('debit_total');

        $datashow = Acc_dashboard::where('months',' month("'. $startdate.'")')->get();
        $data['sumlooknee'] = $data['sum_201']+$data['sum_202']+$data['sum_203']+$data['sum_209']+$data['sum_216']+$data['sum_2166']+$data['sum_217']+$data['sum_201'];
      
    return view('dashboard.account_monitor_main',$data, [ 
      'datashow'          =>  $datashow,
      'startdate'         =>  $startdate,
      'enddate'           =>  $enddate,
    ]);
  }
  public function account_monitor(Request $request)
  {          
            $startdate   = $request->startdate;
            $enddate   = $request->enddate;
            $yearnew = date('Y');
            $year_old = date('Y')-1;
            $months_old  = ('10');           
            $datenow          = date("Y-m-d");
            $y                = date('Y') + 543;
            $dabudget_year    = DB::table('budget_year')->where('active','=',true)->get();
            $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
            $date             = date('Y-m-d'); 
            $newday           = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1
            $newweek          = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
            $newDate          = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
            $newyear          = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
            $bgs_year         = DB::table('budget_year')->where('years_now','Y')->first();
            $bg_yearnow       = $bgs_year->leave_year_id; 
            $months_now       = date('m');
            $year_now         = date('Y');  

            if ($startdate == '') {       
                  $data['data_today'] = DB::connection('mysql2')->select(
                    'SELECT o.vstdate,o.vsttime,p.cid,o.hn,o.vn,v.hospmain,concat(p.pname,p.fname," ",p.lname) as ptname,t.pttype as pttype,tc.ar_opd as pang,tc.name as pangname 
                    ,o.pttypeno,v.pdx,s.name as spclty_name,sti.name as ovstist_name,k.department as department_name,st.name as ost_name,v.income,oq.promote_visit  
                    , hd.name as hospital_department_name,pw.name as pt_walk_name,o.oqueue,vt.visit_type_name,v.age_y,v.age_m,v.age_d,i3.an,ou.name as staff_name,o.pt_priority
                    , p3.name as pt_priority_name ,oq.pttype_check_status_id,pcs.pttype_check_status_name,ou1.name as pttype_check_staff_name,ps1.name as pt_subtype_name
                    , (v.count_in_day+1) as count_in_day,(v.count_in_month+1) as count_in_month,(v.count_in_year+1) as count_in_year,v.rcpt_money,v.paid_money,oc.cc as cc
                    ,oc.bps,oc.bpd,oc.temperature,oc.bw,oc.bmi,IFNULL(vpt.claim_code,vpt.auth_code) as authen,vpt.claim_code
                    
                    from ovst o  
                    left outer join vn_stat v   on v.vn = o.vn  
                    left outer join opdscreen oc  on oc.vn = o.vn  
                    left outer join patient p  on p.hn = o.hn  
                    left outer join pttype t on t.pttype = o.pttype  
                    left outer join pttype_eclaim tc on tc.code = t.pttype_eclaim_id
                    left outer join icd101 i on i.code = v.main_pdx  
                    left outer join spclty s on s.spclty = o.spclty  
                    left outer join ovstist sti on sti.ovstist = o.ovstist  
                    left outer join ovstost st on st.ovstost = o.ovstost 
                    left outer join ovst_seq oq on oq.vn = o.vn  
                    left outer join opduser ou1 on ou1.loginname = oq.pttype_check_staff 
                    left outer join ovst_nhso_send oo1 on oo1.vn = o.vn  
                    left outer join kskdepartment k on k.depcode = o.cur_dep 
                    left outer join kskdepartment k2 on k2.depcode = oq.register_depcode  
                    left outer join kskdepartment kk3 on kk3.depcode = o.main_dep 
                    left outer join hospital_department hd on hd.id = oq.hospital_department_id 
                    left outer join sub_spclty ssp on ssp.sub_spclty_id = oq.sub_spclty_id 
                    left outer join pt_walk pw on pw.walk_id = oc.walk_id  
                    left outer join patient_opd_file pf on pf.hn = o.hn  
                    left outer join kskdepartment k3 on k3.depcode = pf.last_depcode 
                    left outer join visit_type vt on vt.visit_type = o.visit_type 
                    left outer join ipt i3  on i3.vn = o.vn 
                    left outer join opduser ou on ou.loginname = o.staff 
                    left outer join pt_priority p3 on p3.id = o.pt_priority 
                    left outer join pt_subtype ps1 on ps1.pt_subtype = o.pt_subtype 
                    left outer join pttype_check_status pcs on pcs.pttype_check_status_id = oq.pttype_check_status_id  
                    left outer join ovst_eclaim oe on oe.vn = o.vn 
                    left outer join visit_pttype vpt on vpt.vn = o.vn and vpt.pttype = o.pttype 
                    where o.vstdate BETWEEN "'.$datenow.'" AND "'.$datenow.'"
                    and (o.anonymous_visit is null or o.anonymous_visit = "N") 
                    order by tc.ar_opd ASC
                  ');   
                  $data_total_        =  DB::connection('mysql2')->select('SELECT SUM(income) as income,SUM(discount_money) as discount_money,SUM(rcpt_money) as rcpt_money FROM vn_stat WHERE vstdate BETWEEN "'.$datenow.'" AND "'.$datenow.'"'); 
                  foreach ($data_total_ as $key => $val) {
                     $data['data_total']  = ($val->income)-($val->discount_money)-($val->rcpt_money);
                  }
               
            } else {
                // $bg           = DB::table('budget_year')->where('leave_year_id','=',$bg_yearnow)->first();
                // $startdate    = $bg->date_begin;
                // $enddate      = $bg->date_end; 
                $data_total_        =  DB::connection('mysql2')->select('SELECT SUM(income) as income,SUM(discount_money) as discount_money,SUM(rcpt_money) as rcpt_money FROM vn_stat WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"'); 
                  foreach ($data_total_ as $key => $val) {
                     $data['data_total']  = ($val->income)-($val->discount_money)-($val->rcpt_money);
                  }
                $data['data_today'] = DB::connection('mysql2')->select(
                  'SELECT o.vstdate,o.vsttime,p.cid,o.hn,o.vn,v.hospmain,concat(p.pname,p.fname," ",p.lname) as ptname,t.pttype as pttype,tc.ar_opd as pang,tc.name as pangname 
                  ,o.pttypeno,v.pdx,s.name as spclty_name,sti.name as ovstist_name,k.department as department_name,st.name as ost_name,v.income,oq.promote_visit  
                  , hd.name as hospital_department_name,pw.name as pt_walk_name,o.oqueue,vt.visit_type_name,v.age_y,v.age_m,v.age_d,i3.an,ou.name as staff_name,o.pt_priority
                  , p3.name as pt_priority_name ,oq.pttype_check_status_id,pcs.pttype_check_status_name,ou1.name as pttype_check_staff_name,ps1.name as pt_subtype_name
                  , (v.count_in_day+1) as count_in_day,(v.count_in_month+1) as count_in_month,(v.count_in_year+1) as count_in_year,v.rcpt_money,v.paid_money,oc.cc as cc
                  ,oc.bps,oc.bpd,oc.temperature,oc.bw,oc.bmi,IFNULL(vpt.claim_code,vpt.auth_code) as authen,vpt.claim_code
                  
                  from ovst o  
                  left outer join vn_stat v   on v.vn = o.vn  
                  left outer join opdscreen oc  on oc.vn = o.vn  
                  left outer join patient p  on p.hn = o.hn  
                  left outer join pttype t on t.pttype = o.pttype  
                  left outer join pttype_eclaim tc on tc.code = t.pttype_eclaim_id
                  left outer join icd101 i on i.code = v.main_pdx  
                  left outer join spclty s on s.spclty = o.spclty  
                  left outer join ovstist sti on sti.ovstist = o.ovstist  
                  left outer join ovstost st on st.ovstost = o.ovstost 
                  left outer join ovst_seq oq on oq.vn = o.vn  
                  left outer join opduser ou1 on ou1.loginname = oq.pttype_check_staff 
                  left outer join ovst_nhso_send oo1 on oo1.vn = o.vn  
                  left outer join kskdepartment k on k.depcode = o.cur_dep 
                  left outer join kskdepartment k2 on k2.depcode = oq.register_depcode  
                  left outer join kskdepartment kk3 on kk3.depcode = o.main_dep 
                  left outer join hospital_department hd on hd.id = oq.hospital_department_id 
                  left outer join sub_spclty ssp on ssp.sub_spclty_id = oq.sub_spclty_id 
                  left outer join pt_walk pw on pw.walk_id = oc.walk_id  
                  left outer join patient_opd_file pf on pf.hn = o.hn  
                  left outer join kskdepartment k3 on k3.depcode = pf.last_depcode 
                  left outer join visit_type vt on vt.visit_type = o.visit_type 
                  left outer join ipt i3  on i3.vn = o.vn 
                  left outer join opduser ou on ou.loginname = o.staff 
                  left outer join pt_priority p3 on p3.id = o.pt_priority 
                  left outer join pt_subtype ps1 on ps1.pt_subtype = o.pt_subtype 
                  left outer join pttype_check_status pcs on pcs.pttype_check_status_id = oq.pttype_check_status_id  
                  left outer join ovst_eclaim oe on oe.vn = o.vn 
                  left outer join visit_pttype vpt on vpt.vn = o.vn and vpt.pttype = o.pttype 
                  where o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                  and (o.anonymous_visit is null or o.anonymous_visit = "N") 
                  order by tc.ar_opd ASC
                '); 
            }
        $data['pang']          =  DB::connection('mysql')->select('SELECT * FROM acc_setpang WHERE active ="TRUE" order by pang ASC'); 
       
      
    return view('dashboard.account_monitor',$data, [  
      'startdate'         =>  $startdate,
      'enddate'           =>  $enddate,
    ]);
  }
  public function account_dashline(Request $request)
  {
    $startdate = $request->startdate;
    $enddate = $request->enddate;
    $date = date('Y-m-d');
    $y = date('Y') + 543; 
    $yearnew = date('Y');
    $yearold = date('Y')-1;
    $start = (''.$yearold.'-10-01');
    $end = (''.$yearnew.'-09-30');
      if ($startdate != '') {
            $labels = [
              1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
            ];
            $chart = DB::connection('mysql')->select(' 
                SELECT months,year,hipdata_code,count_vn,income,rcpt_money,debit 
                from acc_dashboard                 
                WHERE months BETWEEN month("'.$startdate.'") AND month("'.$enddate.'")  
                AND year BETWEEN year("'.$startdate.'") AND year("'.$enddate.'") 
                ORDER BY months desc
            ');
            // GROUP BY months,pt.hipdata_code
            foreach ($chart as $key => $value) {
                
                if ($value->count_vn > 0) {
                    $dataset[] = [
                        // 'label'               => $labels,
                        'label'               => $value->hipdata_code,
                        'count_vn'            => $value->count_vn,
                        'income'              => $value->income,
                        'rcpt_money'          => $value->rcpt_money,
                        'debit'               => $value->debit
                    ];
                }
            }

            $Dataset1 = $dataset;
            // $Dataset2 = $dataset_2; 
            // return response()->json([
            //     'status'                    => '200', 
            //     'Dataset1'                  => $Dataset1,
            //     // 'Dataset2'                  => $Dataset2
            // ]);
      } else {
            $labels = [
              1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
            ];
            $chart = DB::connection('mysql')->select(' 
                SELECT months,year,hipdata_code,count_vn,income,rcpt_money,debit 
                from acc_dashboard                 
                GROUP BY year,hipdata_code
                ORDER BY months desc
            ');
            // WHERE months BETWEEN month("'.$start.'") AND month("'.$end.'")  
            // AND year BETWEEN year("'.$start.'") AND year("'.$end.'") 
            // dd($chart);
            foreach ($chart as $key => $value) {
                
                if ($value->count_vn > 0) {
                    $dataset2[] = [
                        'label'              => $value->hipdata_code,
                        'count_vn'           => $value->count_vn,
                        'income'             => $value->income,
                        'rcpt_money'         => $value->rcpt_money,
                        'debit'              => $value->debit
                    ];
                }
            }

            $Dataset1 = $dataset2;
            // $Dataset2 = $dataset_2; 
            return response()->json([
              'status'                    => '200', 
              'Dataset1'                  => $Dataset1,
              // 'Dataset2'                  => $Dataset2
          ]);
      }
      
      
      
  }
  public function acc_stm_ct(Request $request)
  {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543; 
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30');  
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
      
      if ($startdate != '') {     
            $datashow =  DB::connection('mysql2')->select('              
                  SELECT o.vstdate,p.cid,oq.seq_id,o.hn,o.vsttime,o.vn,i3.an,v.hospmain,v.main_pdx,concat(p.pname,p.fname," ",p.lname) as ptname
                  ,t.name as pttype_name,o.pttype,v.pdx,i.name as pdx_name,s.name as spclty_name,sti.name as ovstist_name,k.department as department_name
                  ,st.name as ost_name  
                  ,v.income,v.rcpt_money,v.discount_money,v.income-v.rcpt_money-v.discount_money as debit,s.total_approve,s.ip_paytrue,s.STMdoc,s.va
                  from ovst o  
                  left outer join vn_stat v on v.vn = o.vn  
                  left outer join opdscreen oc  on oc.vn = o.vn  
                  left outer join patient p  on p.hn = o.hn  
                  left outer join pttype t on t.pttype = o.pttype 
                  left outer join icd101 i on i.code = v.main_pdx
                  left outer join spclty s on s.spclty = o.spclty  
                  left outer join ovstist sti on sti.ovstist = o.ovstist  
                  left outer join ovstost st on st.ovstost = o.ovstost  
                  left outer join ovst_seq oq on oq.vn = o.vn  
                  left outer join opduser ou1 on ou1.loginname = oq.pttype_check_staff  
                  left outer join ovst_nhso_send oo1 on oo1.vn = o.vn  
                  left outer join kskdepartment k on k.depcode = o.cur_dep  
                  left outer join kskdepartment k2 on k2.depcode = oq.register_depcode  
                  left outer join kskdepartment kk3 on kk3.depcode = o.main_dep  
                  left outer join hospital_department hd on hd.id = oq.hospital_department_id  
                  left outer join sub_spclty ssp on ssp.sub_spclty_id = oq.sub_spclty_id  
                  left outer join pt_walk pw on pw.walk_id = oc.walk_id  
                  left outer join patient_opd_file pf on pf.hn = o.hn  
                  left outer join kskdepartment k3 on k3.depcode = pf.last_depcode  
                  left outer join visit_type vt on vt.visit_type = o.visit_type  
                  left outer join ipt i3  on i3.vn = o.vn  
                  left outer join opduser ou on ou.loginname = o.staff  
                  left outer join pt_priority p3 on p3.id = o.pt_priority  
                  left outer join pt_subtype ps1 on ps1.pt_subtype = o.pt_subtype  
                  left outer join pttype_check_status pcs on pcs.pttype_check_status_id = oq.pttype_check_status_id  
                  left outer join ovst_eclaim oe on oe.vn = o.vn  
                  left outer join visit_pttype vpt on vpt.vn = o.vn and vpt.pttype = o.pttype
                  left outer join pkbackoffice.acc_stm_ucs s ON s.hn = v.hn AND s.vstdate = v.vstdate
                  WHERE o.vstdate BETWEEN "'. $startdate.'" AND "'. $enddate.'"
                   
                  AND i.code like "c%" AND t.hipdata_code = "UCS"
                  order by o.vn
            '); 
      } else {
            $datashow =  DB::connection('mysql2')->select('              
                SELECT o.vstdate,p.cid,oq.seq_id,o.hn,o.vsttime,o.vn,i3.an,v.hospmain,v.main_pdx,concat(p.pname,p.fname," ",p.lname) as ptname
                ,t.name as pttype_name,o.pttype,v.pdx,i.name as pdx_name,s.name as spclty_name,sti.name as ovstist_name,k.department as department_name
                ,st.name as ost_name  
                ,v.income,v.rcpt_money,v.discount_money,v.income-v.rcpt_money-v.discount_money as debit,s.total_approve,s.ip_paytrue,s.STMdoc,s.va
                from ovst o  
                left outer join vn_stat v on v.vn = o.vn  
                left outer join opdscreen oc  on oc.vn = o.vn  
                left outer join patient p  on p.hn = o.hn  
                left outer join pttype t on t.pttype = o.pttype 
                left outer join icd101 i on i.code = v.main_pdx
                left outer join spclty s on s.spclty = o.spclty  
                left outer join ovstist sti on sti.ovstist = o.ovstist  
                left outer join ovstost st on st.ovstost = o.ovstost  
                left outer join ovst_seq oq on oq.vn = o.vn 
               

                left outer join kskdepartment k on k.depcode = o.cur_dep 



                

                left outer join ipt i3  on i3.vn = o.vn  
                left outer join opduser ou on ou.loginname = o.staff  

               

                left outer join pkbackoffice.acc_stm_ucs s ON s.hn = v.hn AND s.vstdate = v.vstdate
                WHERE o.vstdate BETWEEN "'. $newweek.'" AND "'. $date.'"
                
                AND i.code like "c%" AND t.hipdata_code = "UCS"
                order by o.vn
          '); 
      }
      // left outer join opduser ou1 on ou1.loginname = oq.pttype_check_staff  
      // left outer join ovst_nhso_send oo1 on oo1.vn = o.vn  

      // left outer join kskdepartment k2 on k2.depcode = oq.register_depcode  
      // left outer join kskdepartment kk3 on kk3.depcode = o.main_dep  
      // left outer join hospital_department hd on hd.id = oq.hospital_department_id  
      // left outer join sub_spclty ssp on ssp.sub_spclty_id = oq.sub_spclty_id  
      // left outer join pt_walk pw on pw.walk_id = oc.walk_id  
      // left outer join patient_opd_file pf on pf.hn = o.hn  
      // left outer join kskdepartment k3 on k3.depcode = pf.last_depcode  
      // left outer join visit_type vt on vt.visit_type = o.visit_type /
       
      

      // left outer join pt_priority p3 on p3.id = o.pt_priority  
      // left outer join pt_subtype ps1 on ps1.pt_subtype = o.pt_subtype  
      // left outer join pttype_check_status pcs on pcs.pttype_check_status_id = oq.pttype_check_status_id  
      // left outer join ovst_eclaim oe on oe.vn = o.vn  
      // left outer join visit_pttype vpt on vpt.vn = o.vn and vpt.pttype = o.pttype
      
    return view('report_ct.acc_stm_ct', [ 
      'datashow'          =>  $datashow,
      'startdate'         =>  $startdate,
      'enddate'           =>  $enddate,
    ]);
  }
}
