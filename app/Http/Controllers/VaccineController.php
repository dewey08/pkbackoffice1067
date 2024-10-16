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

class VaccineController extends Controller
{  
      
    public function hpv_report(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {  
                // $hpv_report_ = DB::connection('mysql2')->select(' 
                //         SELECT 
                //         l1.vn,l1.hn,v.cid,v.vstdate,v.pttype,concat(p.pname,p.fname," ",p.lname) ptname 
                //         ,ac.debit,ac.pp,ac.fs,ac.total_approve,ac.va,ac.STMdoc,ac.va

                //         FROM lab_head l1
                //         LEFT OUTER JOIN patient p on p.hn=l1.hn 
                //         LEFT OUTER JOIN vn_stat v on v.vn = l1.vn 
                //         LEFT OUTER JOIN pkbackoffice.acc_stm_ucs ac on ac.cid = v.cid AND ac.debit IN("420.0","250.0") 
                //         WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                //         AND l1.form_name LIKE "HPV%"
 
                // ');
                // foreach ($hpv_report_ as $key => $value) {
                //     $check = D_hpv_report::where('vn',$value->vn)->count();
                //     if ($check > 0) {
                //         D_hpv_report::where('vn',$value->vn)->update([ 
                //             'debit'              => $value->debit,
                //             'pp'                 => $value->pp,
                //             'fs'                 => $value->fs,
                //             'total_approve'      => $value->total_approve,
                //             'STMdoc'             => $value->STMdoc,   
                //             'va'                 => $value->va, 
                //         ]);
                //     } else {
                //         D_hpv_report::insert([
                //             'hn'                 => $value->hn, 
                //             'vn'                 => $value->vn,
                //             'cid'                => $value->cid,
                //             'ptname'             => $value->ptname,
                //             'pttype'             => $value->pttype,
                //             'vstdate'            => $value->vstdate,  
                //             'debit'              => $value->debit,
                //             'pp'                 => $value->pp,
                //             'fs'                 => $value->fs,
                //             'total_approve'      => $value->total_approve,
                //             'STMdoc'             => $value->STMdoc,   
                //             'va'                 => $value->va, 
                //         ]);
                //     }
                     
                // } 
                $hpv_report = DB::connection('mysql')->select('SELECT * FROM d_hpv_report WHERE vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"');
        } else { 
                $hpv_report = DB::connection('mysql')->select('SELECT * FROM d_hpv_report WHERE vstdate BETWEEN "'.$newDate.'" and "'.$date.'" '); 
        } 
       
        return view('report_stm.hpv_report',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'hpv_report'       => $hpv_report, 
        ]);
    } 
    public function hpv_report_pull(Request $request)
    {
            $startdate   = $request->startdate;
            $enddate     = $request->enddate;
     
            if ($startdate != '') {  
                $hpv_report_ = DB::connection('mysql2')->select(' 
                        SELECT 
                        l1.vn,l1.hn,v.cid,v.vstdate,v.pttype,concat(p.pname,p.fname," ",p.lname) ptname 
                        ,ac.debit,ac.pp,ac.fs,ac.total_approve,ac.va,ac.STMdoc,ac.va

                        FROM lab_head l1
                        LEFT OUTER JOIN patient p on p.hn=l1.hn 
                        LEFT OUTER JOIN vn_stat v on v.vn = l1.vn 
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ucs ac on ac.cid = v.cid AND ac.debit IN("420.0","250.0") 
                        WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        AND l1.form_name LIKE "HPV%"
 
                ');
                foreach ($hpv_report_ as $key => $value) {
                    $check = D_hpv_report::where('vn',$value->vn)->count();
                    if ($check > 0) {
                        D_hpv_report::where('vn',$value->vn)->update([ 
                            'debit'              => $value->debit,
                            'pp'                 => $value->pp,
                            'fs'                 => $value->fs,
                            'total_approve'      => $value->total_approve,
                            'STMdoc'             => $value->STMdoc,   
                            'va'                 => $value->va, 
                        ]);
                    } else {
                        D_hpv_report::insert([
                            'hn'                 => $value->hn, 
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,  
                            'debit'              => $value->debit,
                            'pp'                 => $value->pp,
                            'fs'                 => $value->fs,
                            'total_approve'      => $value->total_approve,
                            'STMdoc'             => $value->STMdoc,   
                            'va'                 => $value->va, 
                        ]);
                    } 
                }  
            } else { 
                     
            } 
        return response()->json([ 
            'status'    => '200'
        ]);
    }
 
    public function vaccine_big(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {                 
                $datashow_ = DB::connection('mysql2')->select(
                    'SELECT v.vn,p.cid,p.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) ptname,o.staff,op.icode,v.income,op.sum_price
                        FROM vn_stat v
                        LEFT JOIN ovst o ON o.vn = v.vn
                        LEFT JOIN opitemrece op ON op.vn = v.vn
                        LEFT JOIN patient p ON p.hn = v.hn
                        WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND op.icode ="1640032" 
                    ');
                    foreach ($datashow_ as $key => $value) {
                        $check = Vaccine_big::where('vn',$value->vn)->count();
                        if ($check > 0) { 
                        } else {
                            Vaccine_big::insert([
                                'vn'         =>  $value->vn,
                                'cid'        =>  $value->cid,
                                'hn'         =>  $value->hn,
                                'vstdate'    =>  $value->vstdate,
                                'ptname'     =>  $value->ptname,
                                'staff'      =>  $value->staff,
                                'icode'      =>  $value->icode,
                                'income'     =>  $value->income,
                                'sumprice'   =>  $value->sum_price,
                            ]);
                        } 
                    }

                // $datashow = DB::connection('mysql')->select('SELECT * FROM vaccine_big WHERE vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" '); 
                $datashow = DB::connection('mysql')->select(
                    'SELECT a.*,b.authen,b.STMDoc
                    FROM vaccine_big a
                    LEFT JOIN vaccine_big_excel b ON b.cid = a.cid
                    WHERE a.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                    GROUP BY a.vn
                '); 
                   
        } else { 
                $datashow = DB::connection('mysql')->select(
                    'SELECT a.*,b.authen,b.STMDoc
                    FROM vaccine_big a
                    LEFT JOIN vaccine_big_excel b ON b.cid = a.cid
                    WHERE a.vstdate BETWEEN "'.$start.'" and "'.$end.'" 
                    GROUP BY a.vn
                '); 
        } 
        $countc     = DB::table('vaccine_big_excel_rep')->count(); 
        $data_import = DB::table('vaccine_big_excel_rep')->get(); 
        return view('audit.vaccine_big',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'countc'           => $countc,
            'data_import'      => $data_import,
        ]);
    } 
    public function vaccine_big_process(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
  
        if ($startdate != '') {                 
                $datashow_ = DB::connection('mysql2')->select(
                    'SELECT v.vn,p.cid,p.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) ptname,o.staff,op.icode,v.income,op.sum_price
                        FROM vn_stat v
                        LEFT JOIN ovst o ON o.vn = v.vn
                        LEFT JOIN opitemrece op ON op.vn = v.vn
                        LEFT JOIN patient p ON p.hn = v.hn
                        WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND op.icode ="1640032" 
                    ');
                    foreach ($datashow_ as $key => $value) {
                        $check = Vaccine_big::where('vn',$value->vn)->count();
                        if ($check > 0) { 
                        } else {
                            Vaccine_big::insert([
                                'vn'         =>  $value->vn,
                                'cid'        =>  $value->cid,
                                'hn'         =>  $value->hn,
                                'vstdate'    =>  $value->vstdate,
                                'ptname'     =>  $value->ptname,
                                'staff'      =>  $value->staff,
                                'icode'      =>  $value->icode,
                                'income'     =>  $value->income,
                                'sumprice'   =>  $value->sum_price,
                            ]);
                        } 
                    } 
        }   
         
        return response()->json([ 
            'status'    => '200'
        ]);
    } 
    function vaccine_big_import(Request $request)
    { 
        Vaccine_big_excel_rep::truncate();

        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file'); 
        // dd($the_file);
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์ 
       
            try{ 
                // Cheet 2
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                // $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 2, $row_limit );
                // $column_range = range( 'DM', $column_limit );
                $startcount = 2;
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'I' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year_ = substr($vst,6,4);
                    $year = $year_ - 543;
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'K' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear_ = substr($reg, 6, 4);
                    $regyear = $regyear_ - 543;
                    $enddate = $regyear.'-'.$regmo.'-'.$regday;
                    $iduser = Auth::user()->id;
                    $data[] = [ 
                        'ptname'            =>$sheet->getCell( 'B' . $row )->getValue(),
                        'cid'               =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hospname'          =>$sheet->getCell( 'D' . $row )->getValue(),
                        'vaccine'           =>$sheet->getCell( 'E' . $row )->getValue(),
                        'hipdata_code'      =>$sheet->getCell( 'F' . $row )->getValue(),
                        'hipdata_name'      =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'authen'            =>$sheet->getCell( 'H' . $row )->getValue(),
                        'vstdate_start'     =>$vstdate,             
                        'spsch'             =>$sheet->getCell( 'J' . $row )->getValue(),
                        'vstdate_end'       =>$enddate,  
                        'staff'             =>$sheet->getCell( 'L' . $row )->getValue(),
                        'n'                 =>$sheet->getCell( 'M' . $row )->getValue(),
                        'status'            =>$sheet->getCell( 'N' . $row )->getValue(),   
                        'userid'            =>$iduser, 
                        'STMDoc'            =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                    Vaccine_big_excel_rep::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data); 
 

            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            return response()->json([
                'status'    => '200',
            ]);
    }

    public function vaccine_big_send(Request $request)
    {
        // try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM vaccine_big_excel_rep WHERE cid IS NOT NULL');
            foreach ($data_ as $key => $value) {
                if ($value->cid != '') {
                    $check = Vaccine_big_excel::where('authen','=',$value->authen)->count();
                    if ($check > 0) {
                    } else {
                        // $iduser = Auth::user()->id;
                        $add = new Vaccine_big_excel();
                        $add->ptname        = $value->ptname;
                        $add->cid           = $value->cid;
                        $add->hospname      = $value->hospname;
                        $add->vaccine       = $value->vaccine;
                        $add->hipdata_code  = $value->hipdata_code;
                        $add->hipdata_name  = $value->hipdata_name;
                        $add->authen        = $value->authen;
                        $add->vstdate_start = $value->vstdate_start;
                        $add->spsch         = $value->spsch;
                        $add->vstdate_end   = $value->vstdate_end;
                        $add->staff         = $value->staff;
                        $add->n             = $value->n;
                        $add->status        = $value->status;
                        $add->no_pay        = $value->no_pay;
                        $add->STMDoc        = $value->STMDoc;
                        $add->userid        = $value->userid;  
                        $add->save();  
                    }   
                     
                    // $check_update = Vaccine_big::where('cid',$value->cid)->where('vstdate',$value->vstdate_start)->count();
                      
                }
                // $check_update = Vaccine_big::where('cid',$value->cid)->count();
                // if ($check_update > 0) {
                //     Vaccine_big::where('cid',$value->cid)->update([
                //         'authen'  => $value->authen,
                //         'STMDoc'  => $value->STMDoc
                //     ]);
                // }
            }
            // } catch (Exception $e) {
            //     $error_code = $e->errorInfo[1];
            //     return back()->withErrors('There was a problem uploading the data!');
            // }
            Vaccine_big_excel_rep::truncate();
        return redirect()->back();
    }
}
