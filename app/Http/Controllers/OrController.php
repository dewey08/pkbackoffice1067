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
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position; 
use App\Models\D_apiwalkin_ins;  
use App\Models\D_apiwalkin_adp;
use App\Models\D_apiwalkin_aer;
use App\Models\D_apiwalkin_orf;
use App\Models\D_apiwalkin_odx;
use App\Models\D_apiwalkin_cht;
use App\Models\D_apiwalkin_cha;
use App\Models\D_apiwalkin_oop;
use App\Models\Vaccine_big; 
use App\Models\D_apiwalkin_dru;
use App\Models\D_apiwalkin_idx;
use App\Models\D_apiwalkin_iop;
use App\Models\D_apiwalkin_ipd;
use App\Models\D_apiwalkin_pat;
use App\Models\D_apiwalkin_opd;
use App\Models\D_walkin;
use App\Models\Vaccine_big_excel;
use App\Models\Vaccine_big_excel_rep;
use App\Models\D_hpv_report;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
 
use App\Models\D_ofc_repexcel;
use App\Models\D_ofc_rep;
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

class OrController extends Controller
{  
       
    public function or_mis(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {                 
                $datashow = DB::connection('mysql2')->select(
                    'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                        ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income
                        ,case 
                        when u2.inst is null then c.inst
                        else u2.inst
                        end as inst
                        ,case 
                        when u2.total_approve is null then c.pricereq_all
                        else u2.total_approve
                        end as total_approve
                        ,case 
                        when u2.STMdoc is null then c.STMdoc
                        else u2.STMdoc
                        end as STMdoc

                        FROM iptoprt i
                        LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                        LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                        LEFT OUTER JOIN ipt ii on ii.an = i.an
                        LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                        LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                        LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                        LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                        WHERE (i.icd9 IN("5110","5185","5184","5187","5188") OR a.pdx IN("K800","K801","K802","K803","K804","K805","K808","K810","K811","K818","K819"))
                        AND a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND op.income = "02"  
                        GROUP BY i.an   
                    ');
                    
        } else { 
            $datashow = DB::connection('mysql2')->select(
                'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                    ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income
                    ,case 
                    when u2.inst is null then c.inst
                    else u2.inst
                    end as inst
                    ,case 
                    when u2.total_approve is null then c.pricereq_all
                    else u2.total_approve
                    end as total_approve
                    ,case 
                    when u2.STMdoc is null then c.STMdoc
                    else u2.STMdoc
                    end as STMdoc

                    FROM iptoprt i
                    LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                    LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                    LEFT OUTER JOIN ipt ii on ii.an = i.an
                    LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                    LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                    LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                    LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                    WHERE (i.icd9 IN("5110","5185","5184","5187","5188") OR a.pdx IN("K800","K801","K802","K803","K804","K805","K808","K810","K811","K818","K819"))
                    AND a.dchdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND op.income = "02"  
                    GROUP BY i.an   
                ');
        } 
        $countc     = DB::table('vaccine_big_excel_rep')->count(); 
        $data_import = DB::table('vaccine_big_excel_rep')->get(); 
        return view('or.or_mis',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'countc'           => $countc,
            'data_import'      => $data_import,
        ]);
    } 
    public function or_ercp(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {                 
                $datashow = DB::connection('mysql2')->select(
                    'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                        ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income,a.admdate
                        ,case 
                        when u2.inst is null then c.inst
                        else u2.inst
                        end as inst
                        ,case 
                        when u2.total_approve is null then c.pricereq_all
                        else u2.total_approve
                        end as total_approve
                        ,case 
                        when u2.STMdoc is null then c.STMdoc
                        else u2.STMdoc
                        end as STMdoc

                        FROM iptoprt i
                        LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                        LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                        LEFT OUTER JOIN ipt ii on ii.an = i.an
                        LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                        LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                        LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                        LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                        WHERE i.icd9 IN("5110")
                        AND a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND op.income = "02"  
                        GROUP BY i.an   
                    ');
                    
        } else { 
            $datashow = DB::connection('mysql2')->select(
                'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                    ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income,a.admdate
                    ,case 
                    when u2.inst is null then c.inst
                    else u2.inst
                    end as inst
                    ,case 
                    when u2.total_approve is null then c.pricereq_all
                    else u2.total_approve
                    end as total_approve
                    ,case 
                    when u2.STMdoc is null then c.STMdoc
                    else u2.STMdoc
                    end as STMdoc

                    FROM iptoprt i
                    LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                    LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                    LEFT OUTER JOIN ipt ii on ii.an = i.an
                    LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                    LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                    LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                    LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                    WHERE i.icd9 IN("5110")
                    AND a.dchdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND op.income = "02"  
                    GROUP BY i.an   
                ');
        } 
        $countc     = DB::table('vaccine_big_excel_rep')->count(); 
        $data_import = DB::table('vaccine_big_excel_rep')->get(); 
        return view('or.or_ercp',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'countc'           => $countc,
            'data_import'      => $data_import,
        ]);
    } 

    public function or_ercp_new(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {                 
                $datashow = DB::connection('mysql2')->select(
                    'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                        ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income,a.admdate
                        ,case 
                        when u2.inst is null then c.inst
                        else u2.inst
                        end as inst
                        ,case 
                        when u2.total_approve is null then c.pricereq_all
                        else u2.total_approve
                        end as total_approve
                        ,case 
                        when u2.STMdoc is null then c.STMdoc
                        else u2.STMdoc
                        end as STMdoc

                        FROM iptoprt i
                        LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                        LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                        LEFT OUTER JOIN ipt ii on ii.an = i.an
                        LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                        LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                        LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                        LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                        WHERE i.icd9 IN("5110")
                        AND a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND op.income = "02"  
                        GROUP BY i.an   
                    ');
                    
        } else { 
            $datashow = DB::connection('mysql2')->select(
                'SELECT i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,a.pdx,i.icd9,i.doctor,ol.enter_date,a.dchdate
                    ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw,group_concat(distinct n.name) as nameknee,a.inc08,a.income,a.admdate
                    ,case 
                    when u2.inst is null then c.inst
                    else u2.inst
                    end as inst
                    ,case 
                    when u2.total_approve is null then c.pricereq_all
                    else u2.total_approve
                    end as total_approve
                    ,case 
                    when u2.STMdoc is null then c.STMdoc
                    else u2.STMdoc
                    end as STMdoc

                    FROM iptoprt i
                    LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                    LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                    LEFT OUTER JOIN ipt ii on ii.an = i.an
                    LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                    LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                    LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                    LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                    LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an
                    WHERE i.icd9 IN("5110")
                    AND a.dchdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND op.income = "02"  
                    GROUP BY i.an   
                ');
        } 
        $countc     = DB::table('vaccine_big_excel_rep')->count(); 
        $data_import = DB::table('vaccine_big_excel_rep')->get(); 
        return view('or.or_ercp_new',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'countc'           => $countc,
            'data_import'      => $data_import,
        ]);
    } 
    // public function vaccine_big_process(Request $request)
    // {
    //     $startdate = $request->datepicker;
    //     $enddate = $request->datepicker2;
  
    //     if ($startdate != '') {                 
    //             $datashow_ = DB::connection('mysql2')->select(
    //                 'SELECT v.vn,p.cid,p.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) ptname,o.staff,op.icode,v.income,op.sum_price
    //                     FROM vn_stat v
    //                     LEFT JOIN ovst o ON o.vn = v.vn
    //                     LEFT JOIN opitemrece op ON op.vn = v.vn
    //                     LEFT JOIN patient p ON p.hn = v.hn
    //                     WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
    //                     AND op.icode ="1640032" 
    //                 ');
    //                 foreach ($datashow_ as $key => $value) {
    //                     $check = Vaccine_big::where('vn',$value->vn)->count();
    //                     if ($check > 0) { 
    //                     } else {
    //                         Vaccine_big::insert([
    //                             'vn'         =>  $value->vn,
    //                             'cid'        =>  $value->cid,
    //                             'hn'         =>  $value->hn,
    //                             'vstdate'    =>  $value->vstdate,
    //                             'ptname'     =>  $value->ptname,
    //                             'staff'      =>  $value->staff,
    //                             'icode'      =>  $value->icode,
    //                             'income'     =>  $value->income,
    //                             'sumprice'   =>  $value->sum_price,
    //                         ]);
    //                     } 
    //                 } 
    //     }   
         
    //     return response()->json([ 
    //         'status'    => '200'
    //     ]);
    // } 
    public function check_icd9_ipd(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $icd9       = $request->icd9;
        $datashow_  = DB::connection('mysql2')->select(
            'SELECT 
                i.an,op.hn,pt.cid,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,a.pttype,i.icd9,i.doctor,ol.enter_date,a.dchdate
                ,op.icode,op.qty,op.unitprice ,a.rw,ii.adjrw 
                ,group_concat(distinct n.name) as nameknee,a.inc08
                ,case 
                when u2.inst is null then c.inst
                else u2.inst
                end as inst
                ,case 
                when u2.total_approve is null then c.pricereq_all
                else u2.total_approve
                end as total_approve
                ,case 
                when u2.STMdoc is null then c.STMdoc
                else u2.STMdoc
                end as STMdoc
                
                FROM iptoprt i
                LEFT OUTER JOIN operation_list ol ON ol.an = i.an
                LEFT OUTER JOIN an_stat a on a.an = ol.an and a.an is not null 
                LEFT OUTER JOIN ipt ii on ii.an = i.an
                LEFT OUTER JOIN patient pt on pt.hn = ol.hn 
                LEFT OUTER JOIN operation_detail od ON od.operation_id = ol.operation_id
                LEFT OUTER JOIN opitemrece op ON op.an = i.an 
                LEFT OUTER JOIN nondrugitems n on n.icode = op.icode
                LEFT OUTER JOIN pkbackoffice.acc_stm_ucs u2 on u2.an = i.an 
                LEFT OUTER JOIN pkbackoffice.acc_stm_ofc c on c.an = i.an 
                WHERE i.icd9 = "'.$icd9.'" 
                AND a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND op.income = "02" AND a.pttype NOT IN("O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6")
                GROUP BY i.an  
        ');
        // AND ol.enter_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        return view('dashboard.check_icd9_ipd',[
            'startdate'     => $startdate,
            'enddate'       => $enddate ,
            'icd9'          => $icd9 ,
            'datashow_'     => $datashow_
        ]);
    }
     
}
