<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Exports\RefercrossExport;
use PDF;
use Excel;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use App\Models\Refer_cross;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class ReportFontController extends Controller
{
    public function reportauthen_getbar(Request $request)
    {
        $y = date('Y');
        $date = date('Y-m-d');
        $year_ = DB::connection('mysql')->select('
            SELECT * FROM budget_year WHERE active = "True"
        ');
        foreach ($year_ as $key => $value) {
            $startdate = $value->date_begin;
            $enddate = $value->date_end;
        }
        $chart = DB::connection('mysql')->select('
            SELECT * FROM db_year WHERE year = "'.$y.'"
        ');
        $labels = [
          1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        ];
         $countvn = $countan = $authen_opd = $noauthen_opd = $authen_ipd = [];

        foreach ($chart as $key => $chartitems) {
            $countvn[$chartitems->month] = $chartitems->countvn;
            $authen_opd[$chartitems->month] = $chartitems->authen_opd;
            $noauthen_opd[$chartitems->month] = $chartitems->countvn - $chartitems->authen_opd;
        }
        foreach ($labels as $month => $name) {
           if (!array_key_exists($month,$countvn)) {
            $countvn[$month] = 0;
           }
           if (!array_key_exists($month,$authen_opd)) {
            $authen_opd[$month] = 0;
           }
           if (!array_key_exists($month,$noauthen_opd)) {
            $noauthen_opd[$month] = 0;
           }
        }
        ksort($countvn);
        ksort($authen_opd);
        ksort($noauthen_opd);
        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [
                    'label'           =>  'จำนวนคนไข้ที่มารับบริการ OPD',
                    'borderColor'     => 'rgba(255, 205, 86 , 1)',
                    'backgroundColor' => 'rgba(255, 205, 86 , 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            =>  array_values($countvn)
                ],
                [
                    'label'           =>  'Authen Code',
                    'borderColor'     => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($authen_opd)
                ],
                [
                    'label'           =>  'ไม่ Authen',
                    'borderColor'     => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($noauthen_opd)
                ],
            ],
        ];
        // 255, 26, 104 ชมพู
        // 255, 205, 86
    }
    public function reportauthen_getbaripd(Request $request)
    {
        $y = date('Y');
        $date = date('Y-m-d');

        $chart = DB::connection('mysql')->select('
            SELECT * FROM db_year WHERE year = "'.$y.'"
        ');
        $labels = [
          1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        ];
        // $labels2 = [
        //     1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        //   ];
         $countvn = $countan = $authen_opd = $authen_ipd = $noauthen_ipd= [];

        foreach ($chart as $key => $chartitems) {
            $countan[$chartitems->month] = $chartitems->countan;
            $authen_ipd[$chartitems->month] = $chartitems->authen_ipd;
            $noauthen_ipd[$chartitems->month] = $chartitems->countan - $chartitems->authen_ipd;
        }

        foreach ($labels as $month => $name) {
           if (!array_key_exists($month,$countan)) {
            $countan[$month] = 0;
           }
           if (!array_key_exists($month,$authen_ipd)) {
            $authen_ipd[$month] = 0;
           }
           if (!array_key_exists($month,$noauthen_ipd)) {
            $noauthen_ipd[$month] = 0;
           }
        }
        ksort($countan);
        ksort($authen_ipd);
        ksort($noauthen_ipd);

        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [
                    'label'           =>  'จำนวนคนไข้ที่มารับบริการ IPD',
                    'borderColor'     => 'rgba(0,0,139, 1)',
                    'backgroundColor' => 'rgba(0,0,139, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            =>  array_values($countan)
                ],
                // 54, 162, 235 ฟ้า
                [
                    'label'           =>  'Authen Code',
                    'borderColor'     => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($authen_ipd)
                ],
                [
                    'label'           =>  'ไม่ Authen',
                    'borderColor'     => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($noauthen_ipd)
                ],

            ],
        ];


    }
    public function report_dashboard(Request $request)
    {
        $datenow = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        // $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($date);
        $dataopd_ = DB::connection('mysql3')->select('
            select COUNT(ro.hn) as OHN
                from referout ro
                where ro.department = "OPD" and ro.refer_date=CURDATE()
        ');
        $dataipd_ = DB::connection('mysql3')->select('
                select COUNT(ro.hn) as IPH
                from referout ro
                where ro.department = "IPD" and ro.refer_date=CURDATE()
        ');
        foreach ($dataopd_ as $key => $value1) {
            $dataopd_ = $value1->OHN;
        }
        foreach ($dataipd_ as $key => $value2) {
            $dataipd_ = $value2->IPH;
        }
        $total_refer = $dataopd_ + $dataipd_;

        $refer_ = DB::connection('mysql8')->select('
            SELECT COUNT(hn) as HN FROM referout
            WHERE loads_id="02"
            AND refer_date BETWEEN "'.$newDate.'" AND "'.$datenow.'"
        ');
        foreach ($refer_ as $key => $value3) {
            $refer = $value3->HN;
        }
        $dataknee_ = DB::connection('mysql3')->select('
                SELECT COUNT(e.an) as AN
                from an_stat e
                left outer join patient pt on pt.hn = e.hn
                left outer join pttype p on p.pttype = e.pttype
                left outer join iptdiag im on im.an=e.an
                left join ipt ip on ip.an = e.an
                left join ipt_pttype it2 on it2.an=e.an
                left join hos.ipdrent ir on ir.an =e.an
                left outer join hos.opitemrece oo on oo.an = e.an
                LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                left join hos.nondrugitems n1 on n1.icode = oo.icode
                left join hos.s_drugitems sd on sd.icode = oo.icode
                where e.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3009737","3010372","3010569");
        ');
        foreach ($dataknee_ as $value4) {
            $dataknee = $value4->AN;
        }
        $Opdknee_ = DB::connection('mysql3')->select('
                SELECT COUNT(v.vn) as VN
                from vn_stat v
                left outer join hos.opitemrece oo on oo.vn = v.vn
                left join hos.nondrugitems n1 on n1.icode = oo.icode
                left join hos.s_drugitems sd on sd.icode = oo.icode
                where v.vstdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3009737","3010372","3010569");
        ');
        foreach ($Opdknee_ as $value5) {
            $Opdknee = $value5->VN;
        }
        $countsaphok_ = DB::connection('mysql3')->select('
                SELECT COUNT(DISTINCT a.an) as AN
                from an_stat a
                left outer join hos.opitemrece oo on oo.an = a.an
                where a.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3009738","3009739","3010896","3009740","3010228");
        ');
        foreach ($countsaphok_ as $value6) {
            $countsaphok = $value6->AN;
        }
        $countkradook_ = DB::connection('mysql3')->select('
                SELECT COUNT(DISTINCT a.an) as AN
                from an_stat a
                left join ipt ip on ip.an = a.an
                left outer join hos.opitemrece oo on oo.an = a.an
                where a.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3011002","3009749");
        ');

        foreach ($countkradook_ as $value7) {
            $countkradook = $value7->AN;
        }
        // dd($datenow);
        return view('dashboard.report_dashboard', [
            'dataknee'          =>  $dataknee,
            'refer'             =>  $refer,
            'total_refer'       =>  $total_refer,
            'Opdknee'           =>  $Opdknee,
            'newDate'           =>  $newDate,
            'datenow'           =>  $datenow,
            'countsaphok'       =>  $countsaphok,
            'countkradook'      =>  $countkradook,
        ]);
    }
    public function report_authen(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y');
        $data_year = DB::connection('mysql3')->select('
            SELECT COUNT(DISTINCT o.vn) as countvn,COUNT(DISTINCT ra.VN) as authenOPD
                ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year
            FROM ovst o
            LEFT JOIN vn_stat v on v.vn = o.vn
            LEFT JOIN patient p on p.hn = o.hn
            LEFT JOIN rcmdb.authencode ra ON ra.VN = o.vn
                WHERE YEAR(o.vstdate) = "'.$y.'" AND o.an is null
                GROUP BY month
			    ORDER BY month ASC
        ');
        $data_yearipd = DB::connection('mysql3')->select('

                SELECT COUNT(DISTINCT o.vn) as countvn,COUNT(DISTINCT o.an) as countan,COUNT(DISTINCT ra.AN) as authenIPD
                ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year
                FROM ovst o
                LEFT JOIN an_stat a on a.an = o.an
                LEFT JOIN patient p on p.hn = o.hn
                LEFT JOIN rcmdb.authencode ra ON ra.AN = o.an
                WHERE YEAR(o.vstdate) = "'.$y.'"
                AND o.an is not null
                GROUP BY month
                ORDER BY year,month DESC
        ');
        // AND COUNT(DISTINCT o.an) <> 0
        return view('dashboard.report_authen',[
            'data_year'               => $data_year,
            'data_yearipd'               => $data_yearipd,
        ] );
    }
    public function report_authen_sub(Request $request,$month,$year)
    {
        $date = date('Y-m-d');
        $y = date('Y');
        $data_year = DB::connection('mysql')->select(' 
                SELECT d.vn,d.hn,d.cid,d.vstdate,d.ptname,d.staff,d.debit,ca.claimcode,ca.claimtype 
                FROM db_authen_detail d
                LEFT JOIN check_sit_auto cs ON cs.vn = d.vn
                LEFT JOIN check_authen ca ON ca.cid = d.cid and d.vstdate = ca.vstdate 
                WHERE YEAR(d.vstdate) = "'.$year.'" AND MONTH(d.vstdate) = "'.$month.'" 
                AND cs.main_dep NOT IN("011","036","107")
                AND cs.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                AND ca.claimcode IS NULL
                GROUP BY d.vn
              
        ');
        // ,SUM(v.income)-SUM(v.discount_money)-SUM(v.rcpt_money) sumdebit
        return view('dashboard.report_authen_sub',[
            'data_year'               => $data_year,
            'month'                   => $month,
            'year'                    => $year,
        ] );
    }
    public function report_authen_subsub(Request $request,$month,$year,$staff)
    {
        $date = date('Y-m-d');
        $y = date('Y');
        $datashow_ = DB::connection('mysql3')->select('
        SELECT v.vstdate,o.vn,o.hn,p.cid,o.an,concat(p.pname,p.fname,"  ",p.lname) as Fullname,v.pttype,v.pdx
                ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year,o.staff
                ,SUM(op.sum_price) as debit
                FROM ovst o
                LEFT JOIN vn_stat v on v.vn = o.vn
                LEFT JOIN visit_pttype vs on vs.vn = o.vn
                LEFT JOIN patient p on p.hn = o.hn
                LEFT JOIN opitemrece op ON op.vn = o.vn
                LEFT JOIN rcmdb.authencode ra ON ra.VN = o.vn
                WHERE YEAR(o.vstdate) = "'.$year.'" AND MONTH(o.vstdate) = "'.$month.'" AND o.staff = "'.$staff.'" AND ra.VN IS NULL
                AND o.an is null
                GROUP BY v.vn
        ');
        // ,v.income-v.discount_money-v.rcpt_money as debit
        return view('dashboard.report_authen_subsub',[
            'datashow_'               => $datashow_,
        ] );
    }

    public function report_authen_subipd(Request $request,$month,$year)
    {
        $date = date('Y-m-d');
        $y = date('Y');
        $data_yearipd = DB::connection('mysql3')->select('
                SELECT COUNT(DISTINCT o.vn) as countvn,COUNT(DISTINCT o.an) as countan,COUNT(DISTINCT ra.AN) as authenIPD
                ,COUNT(DISTINCT o.an)-COUNT(DISTINCT ra.AN) as noAuthen
                ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year,o.staff,ou.name as fullstaff

                ,SUM(op.sum_price) as sumdebit
                FROM ovst o
                LEFT JOIN an_stat a on a.an = o.an
                LEFT JOIN visit_pttype vs on vs.vn = o.an
                LEFT JOIN patient p on p.hn = o.hn
                LEFT JOIN opduser ou ON ou.loginname = o.staff
                LEFT JOIN opitemrece op ON op.an = o.an
                LEFT JOIN rcmdb.authencode ra ON ra.aN = o.an
                WHERE YEAR(o.vstdate) = "'.$year.'" AND MONTH(o.vstdate) = "'.$month.'" AND o.staff <> "" AND ra.AN is null
                GROUP BY o.staff
		        ORDER BY noAuthen DESC
        ');
        // ,SUM(v.income)-SUM(v.discount_money)-SUM(v.rcpt_money) sumdebit
        return view('dashboard.report_authen_subipd',[
            'data_yearipd'               => $data_yearipd,
        ] );
    }
    public function check_knee_ipddetail(Request $request,$newDate,$datenow)
    {
        $dataknee_ = DB::connection('mysql3')->select('
                SELECT ip.vn,e.hn,e.an,e.regdate,e.dchdate,group_concat(distinct it2.pttype) as pttype
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname,oo.icode,e.pdx,e.dx0,e.dx1,e.dx2,e.dx3,e.dx4
                ,sd.name as s_name,e.inc08 as INCOMEKNEE,e.income as INCOME,e.paid_money as PAY,sum(distinct oo.sum_price) as Priceknee
                ,group_concat(distinct n1.name) as Nameknee,e.uc_money,ip.pttype,pt.cid
                from an_stat e
                    left outer join patient pt on pt.hn = e.hn
                    left outer join pttype p on p.pttype = e.pttype
                    left outer join iptdiag im on im.an=e.an
                    left join ipt ip on ip.an = e.an
                    left join ipt_pttype it2 on it2.an=e.an
                    left join hos.ipdrent ir on ir.an =e.an
                    left outer join hos.opitemrece oo on oo.an = e.an
                    LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                    left join hos.nondrugitems n1 on n1.icode = oo.icode
                    left join hos.s_drugitems sd on sd.icode = oo.icode
                    where e.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                    and oo.icode IN("3009737","3010372","3010569")
                    group by e.an;
        ');


        return view('dashboard.check_knee_detail', [
            'dataknee_'      =>  $dataknee_,
            'newDate'        =>  $newDate,
            'datenow'        =>  $datenow,
        ]);
    }
    public function report_or(Request $request)
    {
        $year_id = $request->year_id;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        // $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน
        // $newDate = date('Y-m-d') ; //
        // dd($date);
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $datashow_ = DB::connection('mysql3')->select('
                SELECT
                    month(a.dchdate) as months,count(o.vn) as cvn
                    ,o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) ptname
                    ,ce2be(o.vstdate) vstdate ,a.dchdate ,ptt.pttype inscl,a.pdx
                    ,w.name as ward ,oo.icode ,oit.name as ERCP ,a.uc_money
                    ,a.income-a.discount_money-a.rcpt_money debit
                    ,a.rcpno_list rcpno,s.AMOUNTPAY as "ชดเชย"

                    from ovst o
                    LEFT JOIN an_stat a on a.an=o.an
                    LEFT JOIN patient pt on pt.hn=o.hn
                    LEFT JOIN pttype ptt on ptt.pttype=o.pttype
                    LEFT JOIN operation_list ol ON a.an = ol.an
                    LEFT JOIN operation_detail od ON od.operation_id=ol.operation_id
                    LEFT JOIN opitemrece oo on oo.an=o.an
                    LEFT JOIN operation_item oit on oit.icode=oo.icode
                    LEFT JOIN drugitems d on d.icode=oo.icode
                    LEFT JOIN ward w on w.ward=a.ward
                    LEFT JOIN eclaimdb.m_registerdata m on m.opdseq = o.an
                    left outer join hshooterdb.m_rep_ucs s1 on s1.an=o.an and s1.error_code ="P" and s1.nhso_pay >"0"
                    LEFT JOIN hshooterdb.m_color_ref mc ON mc.an=o.an
                    LEFT JOIN hshooterdb.claim_status c on c.status_id=m.`STATUS` or  c.status_id=mc.`STATUS`
                    left join hshooterdb.m_stm s on s.an = o.an

                    where a.dchdate between "2022-10-01" and "2023-09-30"
                    AND oo.icode ="3010777"
                    group by month(a.dchdate)
        ');
        // month(a.dchdate) as months,count(o.vn) as cvn
        // ,o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) ptname
        // ,ce2be(o.vstdate) vstdate ,a.dchdate ,ptt.pttype inscl,a.pdx
        // ,w.name as ward ,oo.icode ,oit.name as ERCP ,a.uc_money
        // ,a.income-a.discount_money-a.rcpt_money debit
        // ,a.rcpno_list rcpno,s.AMOUNTPAY as "ชดเชย"

        // where a.dchdate between "' . $newweek . '" and "' . $date . '"
        //             AND oo.icode ="3010777"
        // $datashow_count = DB::connection('mysql3')->select('
        //         SELECT
        //             count(o.vn) as vn
        //             from ovst o
        //             LEFT JOIN an_stat a on a.an=o.an
        //             LEFT JOIN patient pt on pt.hn=o.hn
        //             LEFT JOIN pttype ptt on ptt.pttype=o.pttype
        //             LEFT JOIN operation_list ol ON a.an = ol.an
        //             LEFT JOIN operation_detail od ON od.operation_id=ol.operation_id
        //             LEFT JOIN opitemrece oo on oo.an=o.an
        //             LEFT JOIN operation_item oit on oit.icode=oo.icode
        //             LEFT JOIN drugitems d on d.icode=oo.icode
        //             LEFT JOIN ward w on w.ward=a.ward
        //             LEFT JOIN eclaimdb.m_registerdata m on m.opdseq = o.an
        //             left outer join hshooterdb.m_rep_ucs s1 on s1.an=o.an and s1.error_code ="P" and s1.nhso_pay >"0"
        //             LEFT JOIN hshooterdb.m_color_ref mc ON mc.an=o.an
        //             LEFT JOIN hshooterdb.claim_status c on c.status_id=m.`STATUS` or  c.status_id=mc.`STATUS`
        //             left join hshooterdb.m_stm s on s.an = o.an

        //             where oo.icode ="3010777"
        // ');
        $datashow_count = DB::connection('mysql3')->select('
                SELECT
                    month(a.dchdate),
                    count(o.vn) as vn
                    from ovst o
                    LEFT JOIN an_stat a on a.an=o.an
                    LEFT JOIN patient pt on pt.hn=o.hn
                    LEFT JOIN pttype ptt on ptt.pttype=o.pttype
                    LEFT JOIN operation_list ol ON a.an = ol.an
                    LEFT JOIN operation_detail od ON od.operation_id=ol.operation_id
                    LEFT JOIN opitemrece oo on oo.an=o.an
                    LEFT JOIN operation_item oit on oit.icode=oo.icode
                    LEFT JOIN drugitems d on d.icode=oo.icode
                    LEFT JOIN ward w on w.ward=a.ward
                    LEFT JOIN eclaimdb.m_registerdata m on m.opdseq = o.an
                    left outer join hshooterdb.m_rep_ucs s1 on s1.an=o.an and s1.error_code ="P" and s1.nhso_pay >"0"
                    LEFT JOIN hshooterdb.m_color_ref mc ON mc.an=o.an
                    LEFT JOIN hshooterdb.claim_status c on c.status_id=m.`STATUS` or  c.status_id=mc.`STATUS`
                    left join hshooterdb.m_stm s on s.an = o.an

                    where a.dchdate between "2022-10-01" and "2023-09-30"
                    AND oo.icode ="3010777"
                    group by month(a.dchdate)
        ');
        // where a.dchdate between "' . $newweek . '" and "' . $date . '"
        //             AND oo.icode ="3010777"
        foreach ($datashow_count as $key => $value) {
            $count = $value->vn;
        }
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $leave_month_year = DB::table('leave_month_year')->get();
        // $count = DB::connection('mysql3')->DB::table('budget_year')->count();

        return view('dashboard.report_or', [
            'datashow_'      =>  $datashow_,
            'year'           =>  $year,
            'year_ids'       =>  $year_id,
            'leave_month_year' =>  $leave_month_year,
            'count'          =>  $count
        ]);
    }
    public function report_ormonth(Request $request,$month)
    {
        $year_id = $request->year_id;
        $date = date('Y-m-d');

        $datashow_ = DB::connection('mysql3')->select('
            SELECT
                o.vn
                ,o.hn,o.an,pt.cid,ptname(o.hn,1) ptname
                ,ce2be(o.vstdate) vstdate
                ,a.dchdate
                ,ptt.pttype inscl
                ,a.pdx
                ,w.name as ward
                ,oo.icode
                ,oit.name as ERCP
                ,a.uc_money
                ,a.income-a.discount_money-a.rcpt_money debit
                ,a.rcpno_list rcpno
                ,s.AMOUNTPAY as "ชดเชย"

                from ovst o
                LEFT JOIN an_stat a on a.an=o.an
                LEFT JOIN patient pt on pt.hn=o.hn
                LEFT JOIN pttype ptt on ptt.pttype=o.pttype
                LEFT JOIN operation_list ol ON a.an = ol.an
                LEFT JOIN operation_detail od ON od.operation_id=ol.operation_id
                LEFT JOIN opitemrece oo on oo.an=o.an
                LEFT JOIN operation_item oit on oit.icode=oo.icode
                LEFT JOIN drugitems d on d.icode=oo.icode
                LEFT JOIN ward w on w.ward=a.ward
                LEFT JOIN eclaimdb.m_registerdata m on m.opdseq = o.an
                LEFT JOIN hshooterdb.m_stm s on s.an = o.an

                where a.dchdate between "2022-10-01" and "2023-09-30"
                AND oo.icode ="3010777"
                AND month(a.dchdate) ="'.$month.'"
        ');
        // month(a.dchdate) as months,count(o.vn) as cvn
        // ,o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) ptname
        // ,ce2be(o.vstdate) vstdate ,a.dchdate ,ptt.pttype inscl,a.pdx
        // ,w.name as ward ,oo.icode ,oit.name as ERCP ,a.uc_money
        // ,a.income-a.discount_money-a.rcpt_money debit
        // ,a.rcpno_list rcpno,s.AMOUNTPAY as "ชดเชย"

        return view('dashboard.report_ormonth', [
            'datashow_'      =>  $datashow_,
            'year_ids'       =>  $year_id,
        ]);
    }
    public function report_refer(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql6')->select('
                SELECT ID,STATUS as REFER,CAR_GO_MILE,CAR_BACK_MILE ,OUT_DATE,OUT_TIME,BACK_DATE,BACK_TIME,DRIVER_NAME,USER_REQUEST_NAME,ADD_OIL_BATH,COMMENT,CAR_REG,REFER_TYPE_ID
                FROM vehicle_car_refer v
                LEFT JOIN vehicle_car_index vc ON vc.CAR_ID = v.CAR_ID
                WHERE REFER_TYPE_ID = "1"
                AND OUT_DATE BETWEEN "'.$startdate.'" and "'.$enddate.'"
        ');

        // dd($total_refer);
        return view('dashboard.report_refer',[
            'start'        => $startdate,
            'end'          => $enddate ,
            // 'total_refer'  => $total_refer ,
            'datashow_'    => $datashow_
        ]);
    }
    public function report_refer_thairefer_detail(Request $request,$newDate,$datenow)
    {
        $datashow_ = DB::connection('mysql8')->select('
                SELECT * FROM referout r
                LEFT JOIN hospcode h on h.hospcode = r.refer_hospcode
                WHERE r.loads_id="02"
                and r.refer_date BETWEEN "'.$newDate.'" AND "'.$datenow.'"
        ');

        return view('dashboard.report_refer_thairefer_detail', [
            'datashow_'      =>  $datashow_,
            'newDate'        =>  $newDate,
            'datenow'        =>  $datenow,
        ]);
    }
    public function report_refer_opds(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
                SELECT m1.doc,count(DISTINCT m1.TRAN_ID) as tran
                from eclaimdb.r9opch m1
                where m1.HCODE ="10978"
                group by m1.doc
        ');
        $datashow_2 = DB::connection('mysql3')->select('
            SELECT year(v.vstdate) as year,month(v.vstdate) as months,count(distinct v.hn) as hn,count(distinct v.vn) as vn,round(sum(o.sum_price),2) as sum_price,
            round(sum(IF(v.income<600,"600","")),2) as total from vn_stat v
            LEFT OUTER JOIN patient p ON p.hn=v.hn
            left outer join pttype pt on pt.pttype = v.pttype
            left outer join hospcode h on h.hospcode = v.hospmain
            left outer join opitemrece o on o.vn = v.vn
            left outer join ovstdiag vp on vp.vn = v.vn
            left join ipt i on i.vn = v.vn
            where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            and v.hospmain in ("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007")
            and v.pttype not in ("co","xo","m3","x1","p1","su","si")
            and pt.hipdata_code ="ucs"
            and (v.pdx not in("u119","n185","z115","u071","b24") and v.pdx not like "c%")
            and v.uc_money >"0"
            and i.an is null
            group by year(v.vstdate),month(v.vstdate)
        ');

        // dd($total_refer);
        return view('dashboard.report_refer_opds',[
            'startdate'        => $startdate,
            'enddate'          => $enddate ,
            'datashow_'        => $datashow_,
            'datashow_2'       => $datashow_2
        ]);
    }
    public function report_refer_opds_sub(Request $request,$months,$startdate,$enddate)
    {
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
            SELECT month(v.vstdate) as months,h.hospcode,h.name as hname,count(distinct v.vn) as vn
            ,count(distinct o5.vn) as o5vn
            from hos.vn_stat v
            left join hos.ovst ov on ov.vn = v.vn
            LEFT OUTER JOIN eclaimdb.opitemrece_refer o ON o.vn=v.vn
            LEFT OUTER JOIN eclaimdb.opitemrece_refer o5 ON o5.vn=v.vn and o5.icode in
            (3009140,3009139,3010044,3009193,3009148,3009147,3010634,3009178,3010633,3009183,3009171,3009170,3009194,3009157,3009158,3009146,3009162,3009161,3009191
            ,3009176,3009187,3009156,3009164,3009165,3009173,3009175,3009169,3009159,3009172,3009190,3009163,3009166,3009167,3009168,3009155,3009150,3009151,3009160
            ,3009177,3010113,3009186,3009188,3009144,3010635,3009180,3009181,3009184,3009196,3009149,3009189,3009174,3009145,3009192,3009185)
            LEFT OUTER JOIN hos.nondrugitems n5 ON n5.icode=o.icode
            LEFT OUTER JOIN patient p ON p.hn=v.hn
            left outer join pttype pt on pt.pttype = v.pttype

            left outer join eclaimdb.vn_stat_ncd vv on vv.vn = v.vn
            left outer join hospcode h on h.hospcode = v.hospmain
            where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            and month(v.vstdate) = "'.$months.'"
            and v.hospmain in ("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007")
            and v.uc_money >"0"
            and pt.hipdata_code ="ucs"
            and (v.pdx not in("u119","n185","z115","u071","b24") and v.pdx not like "c%")
            and v.pttype not in ("co","xo","m3","x1","p1","su","si")
            group by h.name
            order by count(distinct v.hn) desc
        ');

        // dd($total_refer);
        return view('dashboard.report_refer_opds_sub',[
            'startdate'        => $startdate,
            'enddate'          => $enddate ,
            'datashow_'        => $datashow_,
            // 'datashow_2'       => $datashow_2
        ]);
    }
    public function report_refer_opds_subvn(Request $request,$months,$hospcode,$startdate,$enddate)
    {
        $datashow_ = DB::connection('mysql3')->select('
            SELECT v.vn,v.hn,v.vstdate
                from vn_stat v
                left outer join hospcode h on h.hospcode = v.hospmain
                left join eclaimdb.m_registerdata m on m.opdseq = v.vn
                left outer join pttype pt on pt.pttype = v.pttype

                where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"
                and v.hospmain  = "'.$hospcode.'"
                and v.hospmain in ("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007")
                and v.pttype not in ("co","xo","m3","x1","p1","su","si")
                and pt.hipdata_code ="ucs"

                group by v.vstdate,v.hn HAVING count(v.vn) > "1"
                ORDER BY v.hn,v.vstdate,v.vn
        ');
        // $ct = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo LEFT JOIN nondrugitems n on n.icode = oo.icode where oo.vn = o.vn and n.name like "ct%" limit 1');
        // $mri = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo LEFT JOIN nondrugitems n on n.icode = oo.icode where oo.vn = o.vn and n.name like "mri%" limit 1');
        // $ins = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode in(select icode from hos.nondrugitems where income="02")  limit 1');
        // $hd = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode = "3010058" limit 1');
        // $labhd = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode = "3000034" and v.pdx ="n185"limit 1');
        // $b = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode in("1460073","1000085","1000084","1530009","1500094","1540010") limit 1');
        // $covid = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406","3000407","3010640","3010641","3010697","3010698","3010677")  limit 1');
        // $ivp = DB::connection('mysql3')->select('select sum(oo.sum_price) from eclaimdb.opitemrece_refer oo where oo.vn = o.vn and oo.icode = "3000616" limit 1');
        // $refer = DB::connection('mysql3')->select('
        //         select sum((select case(r.refer_hospcode)
        //         when "10702" then "1220"
        //         when "10666" then "1300"
        //         when "10972" then "660"
        //         when "10981" then "908"
        //         when "10979" then "780"
        //         when "10980" then "804"
        //         when "10670" then "1300"
        //         when "13777" then "1300"
        //         when "10666" then "1300" else null end)) from vn_stat vv
        //         left outer join referout r on r.vn = vv.vn where vv.vn = v.vn and vv.inc15 > "1000"
        // ');
        // $cctotal = DB::connection('mysql3')->select('
        //         if($cc is null,if(vv.vn is null,if(v.uc_money > 700,700,v.uc_money),if(v.uc_money > 1000,1000,v.uc_money))
        //         ,if($cc > 700,if(vv.vn is null,if($cc > 700,700,$cc),1000),$cc))');

        $datashow_2 = DB::connection('mysql3')->select('
                SELECT v.vn,v.vstdate,v.hn,v.pdx,group_concat(distinct o9.icd10) as icd10
                ,v.pttype,c.check_sit_subinscl,c.check_sit_hmain,concat(p.pname,p.fname,"",p.lname) as fullname,v.cid
                ,round((v.inc16),0) as inc16,round((v.inc01),0) as inc01
                ,round(v.inc04,0) as inc04,round(v.inc05,0) as inc05
                ,round(v.inc06,0) as inc06 ,round(v.inc08,0) as inc08
                ,round(v.inc09,0) as inc09 ,round(v.inc10,0) as inc10
                ,round(v.inc12,0) as inc12 ,round(v.inc13,0) as inc13
                ,round(v.inc14,0) as inc14,round(v.inc17,0) as inc17
                ,round(v.inc11,0) as inc11,round((v.income-v.paid_money),0) as paid_money
                ,if(o9.vn is not null,"1000","") as E11






                from hos.vn_stat v
                left join hos.ovst ov on ov.vn = v.vn
                left join hos.ovstdiag o5 on o5.vn = v.vn
                LEFT OUTER JOIN patient p ON p.hn=v.hn
                left outer join pttype pt on pt.pttype = v.pttype
                LEFT OUTER JOIN eclaimdb.opitemrece_refer o ON o.vn=v.vn
                left outer join eclaimdb.vn_stat_ncd vv on vv.vn = v.vn
                left join hos.ovstdiag o9 on o9.vn = vv.vn
                and (o9.icd10  between "e110" and "e149"
                or o9.icd10  between "i10" and "i150"
                or o9.icd10  between "j44" and "j46")
                left outer join hospcode h on h.hospcode = v.hospmain
                left outer join money_pk.check_sit c on c.check_sit_vn = v.vn
                where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"
                and v.hospmain  = "'.$hospcode.'"
                and v.uc_money > "0"
                and v.pttype not in ("co","xo","m3","x1","p1","su","si")
                and (v.pdx not in("u119","n185","z115","u071","b24") and v.pdx not like "c%")
                and pt.hipdata_code ="ucs"
                group by v.vn
                order by p.fname,v.vstdate

        ');
        // "'.$ct.'" as ct,
        // "'.$mri.'" as mri,
        // "'.$ins.'" as ins,
        // "'.$hd.'" as hd,
        // "'.$labhd.'" as labhd,
        // "'.$b.'" as b,
        // "'.$covid.'" as covid,
        // "'.$ivp.'" as ivp,
        // "'.$refer.'" as refer,
        // "'.$cctotal.'" as cctotal

        // dd($total_refer);
        return view('dashboard.report_refer_opds_subvn',[
            // 'startdate'        => $startdate,
            // 'enddate'          => $enddate ,
            'datashow_'        => $datashow_,
            'datashow_2'       => $datashow_2
        ]);
    }
    public function report_refer_hos(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
            SELECT
                ro.department,ro.hn,ro.vn,concat(p.pname,p.fname," ",p.lname) as ptname,
                ro.refer_date,o.vstdate,o.vsttime,d.name as doctor_name,o.hospmain,
                concat(h.hosptype," ",h.name) as hospname,h.province_name,h.area_code,
                ro.with_ambulance,ro.with_nurse,pe.name as pttype_name,r.name as refername,
                ro.refer_point,concat(ro.pdx," : ",ic.name) as icd_name,ot.unitprice,ot.qty,ot.sum_price,s.nhso_adp_code
                ,sum(if(s.icode IN ("3010829","3010830","3010861","3010862","3010863","3010864","3011012","3011068","3011069","3011070","3011071","3011072","3011073","3011074","3011075","3011076","3011077","3011078","3011078"),sum_price,0)) as PriceRefer 
                FROM referout ro
                LEFT OUTER JOIN ovst o on o.vn = ro.vn
                LEFT OUTER JOIN patient p on p.hn=ro.hn
                LEFT OUTER JOIN hospcode h on h.hospcode = ro.refer_hospcode
                LEFT OUTER JOIN rfrcs r on r.rfrcs = ro.rfrcs
                LEFT OUTER JOIN doctor d on d.code = ro.doctor
                LEFT OUTER JOIN pttype pe on pe.pttype = o.pttype
                LEFT OUTER JOIN icd101 ic on ic.code = ro.pdx
                left outer join opitemrece ot ON ot.vn = ro.vn
                left outer join s_drugitems s on s.icode=ot.icode
                left outer join drugusage du on du.drugusage=ot.drugusage
                left outer join sp_use u on u.sp_use = ot.sp_use
                left outer join drugitems i on i.icode=ot.icode
                WHERE ro.refer_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND ro.department = "OPD"
                GROUP BY ro.vn


                UNION

            SELECT
                ro.department,ro.hn,ro.vn,concat(p.pname,p.fname," ",p.lname) as ptname,
                ro.refer_date,o.regdate as vstdate,o.regtime as vsttime,d.name as doctor_name,"" as hospmain
                ,concat(h.hosptype," ",h.name) as hospname,h.province_name,h.area_code,
                ro.with_ambulance,ro.with_nurse,pe.name as pttype_name,
                r.name as refername,ro.refer_point,concat(ro.pdx," : ",ic.name) as icd_name,ot.unitprice,ot.qty,ot.sum_price,s.nhso_adp_code
                ,sum(if(s.icode IN ("3010829","3010830","3010861","3010862","3010863","3010864","3011012","3011068","3011069","3011070","3011071","3011072","3011073","3011074","3011075","3011076","3011077","3011078","3011078"),sum_price,0)) as PriceRefer 
                from referout ro
                LEFT OUTER JOIN ipt o on o.an = ro.vn
                LEFT OUTER JOIN patient p on p.hn=ro.hn
                LEFT OUTER JOIN hospcode h on h.hospcode = ro.refer_hospcode
                LEFT OUTER JOIN rfrcs r on r.rfrcs = ro.rfrcs
                LEFT OUTER JOIN doctor d on d.code = ro.doctor
                LEFT OUTER JOIN pttype pe on pe.pttype = o.pttype
                LEFT OUTER JOIN icd101 ic on ic.code = ro.pdx
                left outer join opitemrece ot ON ot.vn = ro.vn
                left outer join s_drugitems s on s.icode=ot.icode
                left outer join drugusage du on du.drugusage=ot.drugusage
                left outer join sp_use u on u.sp_use = ot.sp_use
                left outer join drugitems i on i.icode=ot.icode
                WHERE ro.refer_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND ro.department = "IPD"
                GROUP BY ro.vn

        ');

        return view('dashboard.report_refer_hos',[
            'start'        => $startdate,
            'end'          => $enddate ,
            // 'total_refer'  => $total_refer ,
            'datashow_'    => $datashow_
        ]);
    }
    public function check_knee_ipd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
                SELECT ip.vn,e.hn,e.an,e.regdate,e.dchdate,group_concat(distinct it2.pttype) as pttype
                        ,concat(pt.pname,pt.fname," ",pt.lname) as fullname,oo.icode,e.pdx,e.dx0,e.dx1,e.dx2,e.dx3,e.dx4
                        ,sd.name as s_name
                        ,e.inc08 as INCOMEKNEE
                        ,e.income as INCOME
                        ,e.paid_money as PAY
                        ,sum(distinct oo.sum_price) as Priceknee
                        ,group_concat(distinct n1.name) as Nameknee
                        ,e.uc_money
                        ,ip.pttype
                        ,pt.cid
                        from an_stat e
                        left outer join patient pt on pt.hn = e.hn
                        left outer join pttype p on p.pttype = e.pttype
                        left outer join iptdiag im on im.an=e.an
                        left join ipt ip on ip.an = e.an
                        left join ipt_pttype it2 on it2.an=e.an
                        left join hos.ipdrent ir on ir.an =e.an
                        left outer join hos.opitemrece oo on oo.an = e.an
                        LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                        left join hos.nondrugitems n1 on n1.icode = oo.icode
                        left join hos.s_drugitems sd on sd.icode = oo.icode
                        where e.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        and oo.icode IN("3009737","3010372","3010569")
                        group by e.an;
        ');

        return view('dashboard.check_knee_ipd',[
            'start'     => $startdate,
            'end'       => $enddate ,
            'datashow_' => $datashow_
        ]);
    }
    public function check_knee_opd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
                SELECT ip.vn,e.hn,e.an,e.regdate,e.dchdate,group_concat(distinct it2.pttype) as pttype
                        ,concat(pt.pname,pt.fname," ",pt.lname) as fullname,oo.icode,e.pdx,e.dx0,e.dx1,e.dx2,e.dx3,e.dx4
                        ,sd.name as s_name
                        ,e.inc08 as INCOMEKNEE
                        ,e.income as INCOME
                        ,e.paid_money as PAY
                        ,sum(distinct oo.sum_price) as Priceknee
                        ,group_concat(distinct n1.name) as Nameknee
                        ,e.uc_money
                        ,ip.pttype
                        ,pt.cid
                        from an_stat e
                        left outer join patient pt on pt.hn = e.hn
                        left outer join pttype p on p.pttype = e.pttype
                        left outer join iptdiag im on im.an=e.an
                        left join ipt ip on ip.an = e.an
                        left join ipt_pttype it2 on it2.an=e.an
                        left join hos.ipdrent ir on ir.an =e.an
                        left outer join hos.opitemrece oo on oo.an = e.an
                        LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                        left join hos.nondrugitems n1 on n1.icode = oo.icode
                        left join hos.s_drugitems sd on sd.icode = oo.icode
                        where e.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        and oo.icode IN("3009737","3010372","3010569")
                        group by e.an;
        ');

        return view('dashboard.check_knee_opd',[
            'start'     => $startdate,
            'end'       => $enddate ,
            'datashow_' => $datashow_
        ]);
    }
    public function check_kradook(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
                SELECT ip.vn,a.hn,a.an,pt.cid ,a.regdate,a.dchdate,a.pttype
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname
                ,oo.icode,sum(distinct oo.sum_price) as Price
                ,group_concat(distinct n1.name) as ListName
                ,a.inc08,a.income,a.paid_money,a.uc_money
                from an_stat a
                left outer join patient pt on pt.hn = a.hn
                left outer join pttype p on p.pttype = a.pttype
                left join ipt ip on ip.an = a.an
                left join hos.ipdrent ir on ir.an =a.an
                left outer join hos.opitemrece oo on oo.an = a.an
                left join hos.nondrugitems n1 on n1.icode = oo.icode
                left join hos.s_drugitems sd on sd.icode = oo.icode
                where a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                and oo.icode IN("3011002","3009749")
                group by a.an;
        ');

        return view('dashboard.check_kradook',[
            'start'     => $startdate,
            'end'       => $enddate ,
            'datashow_' => $datashow_
        ]);
    }
    public function check_khosaphok(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow_ = DB::connection('mysql3')->select('
            SELECT ip.vn,a.hn,a.an,pt.cid ,a.regdate,a.dchdate,group_concat(distinct it2.pttype) as pttype
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname
                ,oo.icode ,sum(distinct oo.sum_price) as Price
                ,group_concat(distinct n1.name) as ListName
                ,a.inc08 ,a.income,a.paid_money,a.uc_money
                from an_stat a
                left outer join patient pt on pt.hn = a.hn
                left outer join pttype p on p.pttype = a.pttype
                left outer join iptdiag im on im.an=a.an
                left join ipt ip on ip.an = a.an
                left join ipt_pttype it2 on it2.an=a.an
                left join hos.ipdrent ir on ir.an =a.an
                left outer join hos.opitemrece oo on oo.an = a.an
                LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                left join hos.nondrugitems n1 on n1.icode = oo.icode
                left join hos.s_drugitems sd on sd.icode = oo.icode
                where a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                and oo.icode IN("3009738","3009739","3010896","3009740","3010228")
                group by a.an;
        ');

        return view('dashboard.check_khosaphok',[
            'start'     => $startdate,
            'end'       => $enddate ,
            'datashow_' => $datashow_
        ]);
    }
    public function check_khosaphokdetail(Request $request,$newDate,$datenow)
    {
        $datashow_ = DB::connection('mysql3')->select('
                SELECT ip.vn,a.hn,a.an,pt.cid ,a.regdate,a.dchdate,group_concat(distinct it2.pttype) as pttype
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname
                ,oo.icode
                ,sum(distinct oo.sum_price) as Price
                ,group_concat(distinct n1.name) as ListName
                ,a.inc08
                ,a.income
                ,a.paid_money
                ,a.uc_money

                from an_stat a
                left outer join patient pt on pt.hn = a.hn
                left outer join pttype p on p.pttype = a.pttype
                left outer join iptdiag im on im.an=a.an
                left join ipt ip on ip.an = a.an
                left join ipt_pttype it2 on it2.an=a.an
                left join hos.ipdrent ir on ir.an =a.an
                left outer join hos.opitemrece oo on oo.an = a.an
                LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id
                left join hos.nondrugitems n1 on n1.icode = oo.icode
                left join hos.s_drugitems sd on sd.icode = oo.icode
                where a.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3009738","3009739","3010896","3009740","3010228")
                group by a.an;
        ');

        return view('dashboard.check_khosaphokdetail', [
            'datashow_'      =>  $datashow_,
            'newDate'        =>  $newDate,
            'datenow'        =>  $datenow,
        ]);
    }
    public function check_kradookdetail(Request $request,$newDate,$datenow)
    {
        $datashow_ = DB::connection('mysql3')->select('
                SELECT ip.vn,a.hn,a.an,pt.cid ,a.regdate,a.dchdate,group_concat(distinct it2.pttype) as pttype
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname
                ,oo.icode
                ,sum(distinct oo.sum_price) as Price
                ,group_concat(distinct n1.name) as ListName
                ,a.inc08
                ,a.income
                ,a.paid_money
                ,a.uc_money

                from an_stat a
                left outer join patient pt on pt.hn = a.hn
                left outer join pttype p on p.pttype = a.pttype
                left outer join iptdiag im on im.an=a.an
                left join ipt ip on ip.an = a.an
                left join ipt_pttype it2 on it2.an=a.an

                left outer join hos.opitemrece oo on oo.an = a.an

                left join hos.nondrugitems n1 on n1.icode = oo.icode
                where a.dchdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                and oo.icode IN("3011002","3009749")
                and oo.an
                group by a.an;
        ');
        // left join hos.ipdrent ir on ir.an =a.an

        // LEFT JOIN hos.rent_reason r on r.id = ir.rent_reason_id

        return view('dashboard.check_kradookdetail', [
            'datashow_'      =>  $datashow_,
            'newDate'        =>  $newDate,
            'datenow'        =>  $datenow,
        ]);
    }
    public function refer_opds_cross(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $hospcode = $request->hospcode;
        Refer_cross::truncate();
        if ($hospcode != '') {
            $datashow_ = DB::connection('mysql3')->select('
            SELECT * FROM
            (
                        SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name,ee.er_emergency_level_id
                        ,sum(if(op.income = "02",sum_price,0)) as sum_inst
                        ,case
                        when v.income < 1000 then v.income
                        else "1000"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join icd101 oo on oo.code IN(v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5 )
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                       
                        and v.hospmain = "'.$hospcode.'"
                        and v.pttype in("50","98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                        
                        and (oo.code  BETWEEN "E110" and "E149" or oo.code  BETWEEN "I10" and "I150" or oo.code  BETWEEN "J440" and "J449")
                        group by v.vn

                        UNION

                        SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name,ee.er_emergency_level_id
                        ,sum(if(op.income = "02",sum_price,0)) as sum_inst
                        ,case
                        when v.income < 700 then v.income
                        else "700"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join ovstdiag oo on oo.vn = v.vn
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                        
                        and v.hospmain = "'.$hospcode.'"
                        and v.pttype in("50","98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                        
                        AND v.pdx NOT BETWEEN "E110" AND "E149" AND v.pdx NOT BETWEEN "J440" AND "J449" AND v.pdx NOT BETWEEN "I10" AND "I159"
                        AND v.dx0 NOT BETWEEN "E110" AND "E149" AND v.dx0 NOT BETWEEN "J440" AND "J449" AND v.dx0 NOT BETWEEN "I10" AND "I159"
                        AND v.dx1 NOT BETWEEN "E110" AND "E149" AND v.dx1 NOT BETWEEN "J440" AND "J449" AND v.dx1 NOT BETWEEN "I10" AND "I159"
                        AND v.dx2 NOT BETWEEN "E110" AND "E149" AND v.dx2 NOT BETWEEN "J440" AND "J449" AND v.dx2 NOT BETWEEN "I10" AND "I159"
                        AND v.dx3 NOT BETWEEN "E110" AND "E149" AND v.dx3 NOT BETWEEN "J440" AND "J449" AND v.dx3 NOT BETWEEN "I10" AND "I159"
                        AND v.dx4 NOT BETWEEN "E110" AND "E149" AND v.dx4 NOT BETWEEN "J440" AND "J449" AND v.dx4 NOT BETWEEN "I10" AND "I159"
                        AND v.dx5 NOT BETWEEN "E110" AND "E149" AND v.dx5 NOT BETWEEN "J440" AND "J449" AND v.dx5 NOT BETWEEN "I10" AND "I159"
                        group by v.vn
                    ) As Refer
            ');
           
           
           foreach ($datashow_ as $key => $va2) {
                Refer_cross::insert([
                    'hn'                 => $va2->hn,
                    'an'                 => $va2->an,
                    'vn'                 => $va2->vn,
                    'cid'                => $va2->cid,
                    'vstdate'            => $va2->vstdate,
                    'vsttime'            => $va2->vsttime,
                    'ptname'             => $va2->ptname,
                    'pttype'             => $va2->pttype,
                    'hospcode'           => $va2->hospcode,
                    'hospmain'           => $va2->hospmain,
                    'pdx'                => $va2->pdx,
                    'dx0'                => $va2->dx0,
                    'dx1'                => $va2->dx1,
                    'income'             => $va2->income,
                    'refer'              => $va2->refer,
                    'Total'              => $va2->total
                ]);
           }
        } else {
            $datashow_ = DB::connection('mysql3')->select('
                    SELECT * FROM
                        (
                            SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name
                        ,case
                        when v.income < 1000 then v.income
                        else "1000"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join icd101 oo on oo.code IN(v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5 )
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                        AND g.er_emergency_level_id NOT IN("1","2")
                        and v.hospmain IN("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007","14425","24684")
                        and v.pttype in("50","98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                      
                        and (oo.code  BETWEEN "E110" and "E149" or oo.code  BETWEEN "I10" and "I150" or oo.code  BETWEEN "J440" and "J449")
                        group by v.vn

                        UNION

                        SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name
                        ,case
                        when v.income < 700 then v.income
                        else "700"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join ovstdiag oo on oo.vn = v.vn
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                        AND g.er_emergency_level_id NOT IN("1","2")
                        and v.hospmain IN("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007","14425","24684")
                        and v.pttype in("50","98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                       
                        AND v.pdx NOT BETWEEN "E110" AND "E149" AND v.pdx NOT BETWEEN "J440" AND "J449" AND v.pdx NOT BETWEEN "I10" AND "I159"
                        AND v.dx0 NOT BETWEEN "E110" AND "E149" AND v.dx0 NOT BETWEEN "J440" AND "J449" AND v.dx0 NOT BETWEEN "I10" AND "I159"
                        AND v.dx1 NOT BETWEEN "E110" AND "E149" AND v.dx1 NOT BETWEEN "J440" AND "J449" AND v.dx1 NOT BETWEEN "I10" AND "I159"
                        AND v.dx2 NOT BETWEEN "E110" AND "E149" AND v.dx2 NOT BETWEEN "J440" AND "J449" AND v.dx2 NOT BETWEEN "I10" AND "I159"
                        AND v.dx3 NOT BETWEEN "E110" AND "E149" AND v.dx3 NOT BETWEEN "J440" AND "J449" AND v.dx3 NOT BETWEEN "I10" AND "I159"
                        AND v.dx4 NOT BETWEEN "E110" AND "E149" AND v.dx4 NOT BETWEEN "J440" AND "J449" AND v.dx4 NOT BETWEEN "I10" AND "I159"
                        AND v.dx5 NOT BETWEEN "E110" AND "E149" AND v.dx5 NOT BETWEEN "J440" AND "J449" AND v.dx5 NOT BETWEEN "I10" AND "I159"
                        group by v.vn
                    ) As Refer
            ');
           
            foreach ($datashow_ as $key => $va2) {
                Refer_cross::insert([
                    'hn'                 => $va2->hn,
                    'an'                 => $va2->an,
                    'vn'                 => $va2->vn,
                    'cid'                => $va2->cid,
                    'vstdate'            => $va2->vstdate,
                    'vsttime'            => $va2->vsttime,
                    'ptname'             => $va2->ptname,
                    'pttype'             => $va2->pttype,
                    'hospcode'           => $va2->hospcode,
                    'hospmain'           => $va2->hospmain,
                    'pdx'                => $va2->pdx,
                    'dx0'                => $va2->dx0,
                    'dx1'                => $va2->dx1,
                    'income'             => $va2->income,
                    'refer'              => $va2->refer,
                    'Total'              => $va2->total
                ]);
           }
        }

        $data['hosshow'] = DB::connection('mysql3')->select('
            SELECT hospcode,name as hosname FROM hospcode WHERE hospcode IN("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007","14425","24684")
        ');

        return view('report.refer_opds_cross',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate ,
            'datashow_'        => $datashow_,
            'hospcode'         => $hospcode,
        ]);
    }
    public function refer_opds_cross_excel(Request $request,$startdate,$enddate,$hospcode)
    {
        $org_ = DB::connection('mysql')->table('orginfo')->where('orginfo_id', '=', 1)->first();
        $org = $org_->orginfo_name;
        // $hospcode = $request->hospcode;

            $export = DB::connection('mysql3')->select('
            SELECT * FROM
            (
                        SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name,ee.er_emergency_level_id
                        ,case
                        when v.income < 1000 then v.income
                        else "1000"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join icd101 oo on oo.code IN(v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5 )
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                        AND g.er_emergency_level_id NOT IN("1","2")
                        and v.hospmain = "'.$hospcode.'"
                        and v.pttype in("98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                        and pt.hipdata_code ="ucs"
                        and (oo.code  BETWEEN "E110" and "E149" or oo.code  BETWEEN "I10" and "I150" or oo.code  BETWEEN "J440" and "J449")
                        group by v.vn

                        UNION

                        SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,h.name as hospmain,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.income
                        ,sum(if(op.icode IN ("3010829","3010400","3010401","3010539","3010726"),sum_price,0)) as refer,ee.er_emergency_level_name,ee.er_emergency_level_id
                        ,case
                        when v.income < 700 then v.income
                        else "700"
                        end as total
                        from vn_stat v
                        left join ipt i on i.vn = v.vn
                        left join patient p on p.hn = v.hn
                        left join hos.pttype pt on pt.pttype =v.pttype
                        left join opitemrece op ON op.vn = v.vn
                        left join ovstdiag oo on oo.vn = v.vn
                        left join opdscreen d on d.vn = v.vn
                        left join hospcode h on h.hospcode = v.hospmain
                        left join ovst ov on ov.vn = v.vn
                        left outer join er_regist g on g.vn=v.vn 
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left join eclaimdb.m_registerdata m on m.hn = v.hn
                        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = v.vstdate
                        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5)
                        where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and i.an is null
                        AND g.er_emergency_level_id NOT IN("1","2")
                        and v.hospmain = "'.$hospcode.'"
                        and v.pttype in("98","99")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )
                        and pt.hipdata_code ="ucs"
                        AND v.pdx NOT BETWEEN "E110" AND "E149" AND v.pdx NOT BETWEEN "J440" AND "J449" AND v.pdx NOT BETWEEN "I10" AND "I159"
                        AND v.dx0 NOT BETWEEN "E110" AND "E149" AND v.dx0 NOT BETWEEN "J440" AND "J449" AND v.dx0 NOT BETWEEN "I10" AND "I159"
                        AND v.dx1 NOT BETWEEN "E110" AND "E149" AND v.dx1 NOT BETWEEN "J440" AND "J449" AND v.dx1 NOT BETWEEN "I10" AND "I159"
                        AND v.dx2 NOT BETWEEN "E110" AND "E149" AND v.dx2 NOT BETWEEN "J440" AND "J449" AND v.dx2 NOT BETWEEN "I10" AND "I159"
                        AND v.dx3 NOT BETWEEN "E110" AND "E149" AND v.dx3 NOT BETWEEN "J440" AND "J449" AND v.dx3 NOT BETWEEN "I10" AND "I159"
                        AND v.dx4 NOT BETWEEN "E110" AND "E149" AND v.dx4 NOT BETWEEN "J440" AND "J449" AND v.dx4 NOT BETWEEN "I10" AND "I159"
                        AND v.dx5 NOT BETWEEN "E110" AND "E149" AND v.dx5 NOT BETWEEN "J440" AND "J449" AND v.dx5 NOT BETWEEN "I10" AND "I159"
                        group by v.vn
                    ) As Refer
            ');
            // $export = DB::connection('mysql')->select('
            //     SELECT * FROM refer_cross
            // ');

        return view('report.refer_opds_cross_excel', [
            'org'              => $org,
            'export'           =>  $export,
        ]);
    }
    public function report_ct(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $hospcode = $request->hospcode;

        $datashow_ = DB::connection('mysql3')->select('
            SELECT
                v.hn,v.vn,v.vstdate,ov.vsttime,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.cid,v.pttype,v.pdx,group_concat(distinct oo.icd10) as icd10,v.pttype
                ,h.hospcode,h.name as hospmain ,v.income,v.paid_money,v.uc_money
                ,SUM(op.sum_price),n.name As nameCT

                from vn_stat v
                left outer join opitemrece op on op.vn = v.vn
                LEFT JOIN oapp o on o.visit_vn = v.vn
                left join ipt i on i.vn = v.vn
                left join patient p on p.hn = v.hn
                left join ovstdiag oo on oo.vn = v.vn
                left join opdscreen d on d.vn = v.vn
                left join hospcode h on h.hospcode = v.hospmain
                left join ovst ov on ov.vn = v.vn
                left outer join nondrugitems n on n.icode = op.icode
                left join visit_pttype vv on vv.vn = v.vn
                left join hshooterdb.m_stm s on s.vn = v.vn
                left outer join hos.pttype pt on pt.pttype =v.pttype
                left outer join eclaimdb.opitemrece_refer o1 on o1.vn = v.vn

                where v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                and i.an is null
                and v.hospmain = "'.$hospcode.'"
                and v.pttype in("98","99","74","50","89","71","88","82","76","72","73","77","75","87","90","91","81","A7")
                and op.icode in("3009186","3009187","3009147","3009188","3010113","3009176","3009158","3009148","3009173","3009178","3009160","3009157"
                ,"3009191","3009139","3009155","3009193","3009180","3009159","3009167","3009162","3009140","3010044","3009172","3009165","3009166","3009161")
                and pt.hipdata_code IN("UCS","SSS") 
                and v.vn not in(select vn from eclaimdb.opitemrece_refer where vn = o1.vn)
                group by op.vn,op.icode
        ');
        $hosshow = DB::connection('mysql3')->select('
            SELECT hospcode,name as hosname FROM hospcode WHERE hospcode IN("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007","14425","24684")
        ');
        return view('report.report_ct',[
            'startdate'        => $startdate,
            'enddate'          => $enddate ,
            'datashow_'        => $datashow_,
            'hosshow'          => $hosshow,
            'hospcode'         => $hospcode,
        ]);
    }

    public function cross_exportexcel(Request $request)
    {
        return Excel::download(new RefercrossExport,'Refer_export.xlsx');
    }


    // Check_sit_auto::where('claimcode', $claimCode)
    // ->update([ 
    //     'claimcode'       => $value->claimcode, 
    //     'claimtype'       => $value->claimtype,  
    // ]);
    // Check_sit_auto::create([
    //     'cid'                        => $personalId,
    //     'fullname'                   => $patientName,
    //     'hosname'                    => $hname,
    //     'hcode'                      => $hmain,
    //     'vstdate'                    => $checkdate,
    //     'regdate'                    => $checkdate,
    //     'claimcode'                  => $claimCode,
    //     'claimtype'                  => $claimType,
    //     'birthday'                   => $birthdate,
    //     'homtel'                     => $tel,
    //     'repcode'                    => $claimStatus,
    //     'hncode'                     => $hnCode,
    //     'servicerep'                 => $patientType,
    //     'servicename'                => $claimTypeName,
    //     'mainpttype'                 => $mainInsclWithName,
    //     'subpttype'                  => $subInsclName,
    //     'requestauthen'              => $sourceChannel,
    //     'authentication'             => $claimAuthen,

    // ]);
    // Db_authen_detail::where('claimcode', $claimCode)->update([
    //     'claimcode'       => $claimCode, 
    //     'claimtype'       => $claimType, 
    // ]);

    // Db_authen_detail::where('vn', $value->vn)->update([ 
    //     'an'           => $value->an,
    //     'hn'           => $value->hn,
    //     'cid'          => $value->cid,
    //     'vstdate'      => $value->vstdate,
    //     'ptname'       => $value->ptname,
    //     'staff'        => $value->staff,
    //     'debit'        => $value->debit,
    // ]);
}
