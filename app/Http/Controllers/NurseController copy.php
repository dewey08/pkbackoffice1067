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
use App\Models\Nurse_ksk;
use App\Models\Document;
use App\Models\Nurse;
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


class NurseController extends Controller
{
    // ***************** NurseController********************************

    public function nurse_dashboard(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data['datashow'] = DB::connection('mysql')->select('SELECT * FROM document WHERE active = "Y" AND (user_id <> "581" OR user_id ="" OR user_id IS NULL)');

        return view('nurse.nurse_dashboard', $data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            // 'data_doctor'      => $data_doctor,

        ]);
    }
    public function nurse_index(Request $request)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $data_insert   = $request->data_insert;
        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($data_insert == '') {
            # code...
        } else {
            // Nurse::truncate();
            // $datashow_ = DB::connection('mysql2')->select(
            //     'SELECT w.ward,w.name as ward_name,
            //     COUNT(DISTINCT a.an) as total_an,
            //     ROUND(COUNT(DISTINCT a.an) * 1.6 / 8, 2) as soot_a_total,
            //     ROUND(COUNT(DISTINCT a.an) * 1.44 / 8, 2) as soot_b_total,
            //     ROUND(COUNT(DISTINCT a.an) * 0.96 / 8, 2) as soot_c_total
            //     FROM an_stat a
            //     LEFT OUTER JOIN ward w on w.ward = a.ward
            //     WHERE a.dchdate is null AND w.ward is not null
            //     GROUP BY a.ward ORDER BY w.name
            // '
            // );
            // foreach ($datashow_ as $key => $value) {
            //     $add = new Nurse();
            //     $add->datesave         = $date;
            //     $add->ward             = $value->ward;
            //     $add->ward_name        = $value->ward_name;
            //     $add->count_an         = $value->total_an;
            //     $add->soot_a     = $value->soot_a_total;
            //     $add->soot_b    = $value->soot_b_total;
            //     $add->soot_c     = $value->soot_c_total;
            //     $add->save();
            // }
        }




        $datashow = DB::connection('mysql')->select('SELECT * FROM nurse WHERE datesave = "'.$date.'"');

        return view('nurse.nurse_index', [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'datashow'         => $datashow,

        ]);
    }

    public function nurse_index_process(Request $request)
    {
        $data_insert   = $request->data_insert;
        $date = date('Y-m-d');
        $m = date('H');
        $mm = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        // dd($m);

        if ($data_insert == '1') {

            // Nurse::truncate();
            // Nurse::where('datesave',$date)->delete();

            $datashow_ = DB::connection('mysql2')->select(
                'SELECT w.ward,w.name as ward_name,
                        COUNT(DISTINCT a.an) as total_an,
                        ROUND(
                            CASE
                                WHEN w.ward = "01" THEN COUNT(DISTINCT a.an) * 1.14 / 8  # ตึกสูติ-นรีเวช
                                            WHEN w.ward = "03" THEN COUNT(DISTINCT a.an) * 1.6 / 8
                                            WHEN w.ward = "04" THEN COUNT(DISTINCT a.an) * 16 / 8
                                WHEN w.ward = "05" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "06" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "07" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "08" THEN COUNT(DISTINCT a.an) * 4 / 8
                                WHEN w.ward = "10" THEN COUNT(DISTINCT a.an) * 1.6 / 8
                                            WHEN w.ward = "11" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "13" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "14" THEN COUNT(DISTINCT a.an) * 4 / 8
                                            WHEN w.ward = "15" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                            WHEN w.ward = "32" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                WHEN w.ward = "35" THEN COUNT(DISTINCT a.an) * 1.33 / 8
                                                
                                ELSE COUNT(DISTINCT a.an) * 1.33 / 8 #  ค่าพื้นฐานสำหรับวอร์ดที่ไม่ตรงกับเงื่อนไขใด ๆ   #  เพิ่มเงื่อนไขอื่น ๆ ที่ต้องการสำหรับค่าวอร์ดอื่น ๆ ที่นี่
                            END, 0
                        ) as soot_a,
                        ROUND(
                            CASE 
                                    WHEN w.ward = "01" THEN COUNT(DISTINCT a.an) * 1.03 / 8  # ตึกสูติ-นรีเวช
                                                WHEN w.ward = "03" THEN COUNT(DISTINCT a.an) * 1.44 / 8
                                                WHEN w.ward = "04" THEN COUNT(DISTINCT a.an) * 16 / 8
                                                WHEN w.ward = "05" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "06" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "07" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "08" THEN COUNT(DISTINCT a.an) * 4 / 8
                                    WHEN w.ward = "10" THEN COUNT(DISTINCT a.an) * 1.44 / 8
                                                WHEN w.ward = "11" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "13" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "14" THEN COUNT(DISTINCT a.an) * 4 / 8
                                                WHEN w.ward = "15" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                                WHEN w.ward = "32" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                    WHEN w.ward = "35" THEN COUNT(DISTINCT a.an) * 1.2 / 8
                                
                                    ELSE COUNT(DISTINCT a.an) * 1.2 / 8 #  ค่าพื้นฐานสำหรับวอร์ดที่ไม่ตรงกับเงื่อนไขใด ๆ    # เพิ่มเงื่อนไขอื่น ๆ ที่ต้องการสำหรับค่าวอร์ดอื่น ๆ ที่นี่
                                END, 0
                        ) as soot_b,
                        ROUND(
                            CASE 
                                    WHEN w.ward = "01" THEN COUNT(DISTINCT a.an) * 0.69 / 8  # ตึกสูติ-นรีเวช
                                                WHEN w.ward = "03" THEN COUNT(DISTINCT a.an) * 0.96 / 8  # ตึกอายุรกรรมชาย
                                                WHEN w.ward = "04" THEN COUNT(DISTINCT a.an) * 16 / 8   # ตึกคลอด
                                    WHEN w.ward = "05" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกศัลยกรรมชาย
                                                WHEN w.ward = "06" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกศัลยกรรมหญิงและศัลยกรรมเด็ก
                                                WHEN w.ward = "07" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกกุมารเวชกรรม
                                                WHEN w.ward = "08" THEN COUNT(DISTINCT a.an) * 4 / 8   # ICU1
                                    WHEN w.ward = "10" THEN COUNT(DISTINCT a.an) * 0.96 / 8  # ตึกอายุรกรรมหญิง
                                                WHEN w.ward = "11" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกสงฆ์อาพาธและพิเศษทั่วไป
                                                WHEN w.ward = "13" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกศัลยกรรมกระดูกและข้อ
                                                WHEN w.ward = "14" THEN COUNT(DISTINCT a.an) * 4 / 8   # ICU 2
                                                WHEN w.ward = "15" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกพิเศษอายุรกรรม
                                                WHEN w.ward = "32" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกผู้ป่วยจิตเวช-ยาเสพติด
                                    WHEN w.ward = "35" THEN COUNT(DISTINCT a.an) * 0.8 / 8  # ตึกพิเศษอายุรกรรมชั้น5
                                                    
                                    ELSE COUNT(DISTINCT a.an) * 0.8 / 8 #  ค่าพื้นฐานสำหรับวอร์ดที่ไม่ตรงกับเงื่อนไขใด ๆ   ## เพิ่มเงื่อนไขอื่น ๆ ที่ต้องการสำหรับค่าวอร์ดอื่น ๆ ที่นี่
                                END, 0
                        ) as soot_c 
                FROM an_stat a
                LEFT OUTER JOIN ward w on w.ward = a.ward
                WHERE a.dchdate is null AND w.ward is not null AND w.ward not in ("33")
                GROUP BY a.ward
                ORDER BY w.ward;
            ');
            foreach ($datashow_ as $key => $value) {

                if ($m < '8') {
                    $check = Nurse::where('datesave', $date)->where('ward', $value->ward)->count();
                    if ($check > 0) {
                        Nurse::where('datesave', $date)->where('ward', $value->ward)->update([
                            'datesave'    => $date,
                            'ward'        => $value->ward,
                            'ward_name'   => $value->ward_name,
                            'count_an1'   => $value->total_an,
                            'soot_a'      => $value->soot_a,
                            'soot_b'      => $value->soot_b,
                            'soot_c'      => $value->soot_c,
                        ]);
                    } else {
                        $add = new Nurse();
                        $add->datesave         = $date;
                        $add->ward             = $value->ward;
                        $add->ward_name        = $value->ward_name;
                        $add->count_an1        = $value->total_an;
                        $add->soot_a           = $value->soot_a;
                        $add->soot_b           = $value->soot_b;
                        $add->soot_c           = $value->soot_c;
                        $add->save();
                    }
                } else if ($m > '8' && $m < '16') {
                        $check = Nurse::where('datesave', $date)->where('ward', $value->ward)->count();
                        if ($check > 0) {
                            Nurse::where('datesave', $date)->where('ward', $value->ward)->update([
                                'datesave'    => $date,
                                'ward'        => $value->ward,
                                'ward_name'   => $value->ward_name,
                                'count_an2'   => $value->total_an,
                                'soot_a'      => $value->soot_a,
                                'soot_b'      => $value->soot_b,
                                'soot_c'      => $value->soot_c,
                            ]);
                        } else {
                            $add = new Nurse();
                            $add->datesave         = $date;
                            $add->ward             = $value->ward;
                            $add->ward_name        = $value->ward_name;
                            $add->count_an2        = $value->total_an;
                            $add->soot_a           = $value->soot_a;
                            $add->soot_b           = $value->soot_b;
                            $add->soot_c           = $value->soot_c;
                            $add->save();
                        }
                } else {
                    $check = Nurse::where('datesave', $date)->where('ward', $value->ward)->count();
                        if ($check > 0) {
                            Nurse::where('datesave', $date)->where('ward', $value->ward)->update([
                                'datesave'    => $date,
                                'ward'        => $value->ward,
                                'ward_name'   => $value->ward_name,
                                'count_an3'   => $value->total_an,
                                'soot_a'      => $value->soot_a,
                                'soot_b'      => $value->soot_b,
                                'soot_c'      => $value->soot_c,
                            ]);
                        } else {
                            $add = new Nurse();
                            $add->datesave         = $date;
                            $add->ward             = $value->ward;
                            $add->ward_name        = $value->ward_name;
                            $add->count_an3        = $value->total_an;
                            $add->soot_a           = $value->soot_a;
                            $add->soot_b           = $value->soot_b;
                            $add->soot_c           = $value->soot_c;
                            $add->save();
                        }
                }
                


                
            }
        }
        return response()->json([
            'status'     => '200'
        ]);
    }

    public function nurse_index_editable(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $c_an_ = Nurse::where('ward', $request->ward)->first();
                $an1    = $c_an_->count_an1;
                $an2    = $c_an_->count_an2;
                $an3    = $c_an_->count_an3;
                $a     = $c_an_->soot_a;
                $b     = $c_an_->soot_b;
                $c     = $c_an_->soot_c;
                // $nursing_ = Nurse_ksk::where('ward',$request->ward)->first();
                $date = date('Y-m-d');
                $m = date('H');
                $mm = date('H:m:s');
                $datefull = date('Y-m-d H:m:s');

                if ($m < '8') {
                } else if ($m > '8' && $m < '16') {
                } else {
                    if ($request->ward == '01') {
                        # code...
                    } else {
                        # code...
                    }
                }

                $data  = array(
                    'np_a'          => $request->np_a,
                    'soot_a_total'  => ($an1 * 1.6 * 100 / $a) * $request->np_a,
                    'np_b'          => $request->np_b,

                    'soot_b_total'  => ($an2 * 1.6 * 100 / $b) * $request->np_b,
                    'np_c'          => $request->np_c,

                    'soot_c_total'  => ($an3 * 1.6 * 100 / $c) * $request->np_c,
                );
                DB::connection('mysql')->table('nurse')
                    ->where('ward', $request->ward)
                    ->update($data);
            }
            // if($request->action == 'delete')
            // {
            // 	DB::table('sample_datas')
            // 		->where('id', $request->id)
            // 		->delete();
            // }
            return request()->json($request);
        }
    }
}
