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
use App\Models\Acc_stm_ucs_excel;
use App\Models\Patient;
use App\Models\Oapp;
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
use App\Models\Dent_appointment;
use App\Models\Dent_appointment_type;
use App\Models\P4p_workgroupset;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Output\Output;

date_default_timezone_set("Asia/Bangkok");


class DentalController extends Controller
 {
    // ***************** 301********************************

    public function dental(Request $request)
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


        $data_doctor = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $event = array();
        $data_nad = DB::connection('mysql10')->select('
            SELECT oa.oapp_id,oa.vn,concat(p.fname," ",p.lname) as ptname,showcid(p.cid) as cid,oa.hn,oa.nextdate as doctor_nad,oa.nexttime,d.shortname as doctor
            FROM oapp oa
            LEFT OUTER JOIN patient p on p.hn=oa.hn
            LEFT OUTER JOIN doctor d on d.code=oa.doctor
            WHERE oa.nextdate BETWEEN "2023-07-01" AND "2023-08-31"
            AND oa.clinic ="018"
            AND d.position_id = "2"
            AND d.active = "Y"
        ');
        // $carservicess = Car_service::all();
        foreach ($data_nad as $item) {

            

            $dateend = $item->doctor_nad;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            
            $starttime = substr($item->nexttime, 0, 5);
            
          
            $showtitle = $item->hn.'-'.$item->ptname.'-'.$starttime;

            $event[] = [
                'id'            => $item->oapp_id,
                'title'         => $showtitle,
                'start'         => $dateend,
                'end'           => $dateend,
           
            ];
        }

        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_doctor'      => $data_doctor,
            'events'           =>  $event,
        ]);
    }

    public function dental_detail(Request $request,$id)
    {
        // $id = $request->vn;
        // $datanad = Oapp::find($id);
        $datanad = Oapp::leftjoin('patient','patient.hn','=','oapp.hn')
        // ->leftjoin('ovst','ovst.vn','=','oapp.vn')
        ->leftjoin('doctor','doctor.code','=','oapp.doctor')
        ->find($id);
        // $datanad = DB::connection('mysql3')->select('
        //     SELECT oa.oapp_id,oa.vn,concat(p.fname," ",p.lname) as ptname,showcid(p.cid) as cid,oa.hn,oa.nextdate as doctor_nad,d.shortname as doctor
        //     FROM oapp oa
        //     LEFT OUTER JOIN patient p on p.hn=oa.hn
        //     LEFT OUTER JOIN doctor d on d.code=oa.doctor
        //     WHERE oa.oapp_id ="'.$id.'"
        // ');
        // WHERE oa.vn ="660725102434"
        // WHERE oa.vn ="'.$vn.'"
        // 660725102434
        return response()->json([
            'status'        => '200',
            'datanad'       =>  $datanad,
            ]);
    }

    public function dental_assistant(Request $request,$id)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;

        $iduser        = Auth::user()->id;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_show = DB::connection('mysql2')->select(
            'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
            from dtmain d  
            left outer join doctor dt on dt.code = d.doctor_helper  
            left outer join dttm dm on dm.code = d.tmcode 
            where d.vstdate between "'.$startdate.'" and "'.$enddate.'"
            and dt.code = "'.$id.'"  
            order by d.vstdate
        ');
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental_assistant',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_show'        => $data_show, 
        ]);
    }
    public function dental_assis(Request $request,$id)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $data_show = DB::connection('mysql2')->select(
                'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
                from dtmain d  
                left outer join doctor dt on dt.code = d.doctor_helper  
                left outer join dttm dm on dm.code = d.tmcode 
                where d.vstdate between "'.$newweek.'" and "'.$date.'"
                and dt.code = "'.$id.'"  
                order by d.vstdate
            ');
        } else {
            $data_show = DB::connection('mysql2')->select(
                'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
                from dtmain d  
                left outer join doctor dt on dt.code = d.doctor_helper  
                left outer join dttm dm on dm.code = d.tmcode 
                where d.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and dt.code = "'.$id.'"  
                order by d.vstdate
            ');
        }        
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental_assis',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_show'        => $data_show, 
            'id'               => $id, 
        ]);
    }

    public function dental_doctor(Request $request,$id)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $iduser        = Auth::user()->id;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $data_show = DB::connection('mysql2')->select(
                'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
                from dtmain d  
                left outer join doctor dt on dt.code = d.doctor  
                left outer join dttm dm on dm.code = d.tmcode 
                where d.vstdate between "'.$newweek.'" and "'.$date.'"
                and dt.code = "'.$id.'"  
                order by d.vstdate
            ');
        } else {
            $data_show = DB::connection('mysql2')->select(
                'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
                from dtmain d  
                left outer join doctor dt on dt.code = d.doctor  
                left outer join dttm dm on dm.code = d.tmcode 
                where d.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and dt.code = "'.$id.'"  
                order by d.vstdate
            ');
        }        
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental_doctor',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_show'        => $data_show, 
            'id'               => $id, 
        ]);
    }

    public function dental_db(Request $request)
    {
        // $startdate     = $request->startdate;
        // $enddate       = $request->enddate;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี    
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow                 = $bgs_year->leave_year_id;  
        $startdate                  = $bgs_year->date_begin;   
        $enddate                    = $bgs_year->date_end;   
        
        $data_show = DB::connection('mysql2')->select(
            'select d.vstdate,d.hn,dm.name as dmname,d.ttcode,d.staff,dt.code as dtcode,dt.name as dtname 
            from dtmain d  
            left outer join doctor dt on dt.code = d.doctor_helper  
            left outer join dttm dm on dm.code = d.tmcode 
            where d.vstdate between "'.$newweek.'" and "'.$date.'" 
            order by d.vstdate
        ');
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');
      

        $count_visit = DB::connection('mysql2')->select(
            'SELECT MONTH(d.vstdate) as months, COUNT(DISTINCT d.hn) as chn
            FROM dtmain d
            LEFT JOIN vn_stat v ON v.vn = d.vn 
            WHERE d.vstdate between "'.$newyear.'" and "'.$date.'" 
            
            AND v.pt_subtype <> "2"
            GROUP BY MONTH(d.vstdate)
            ORDER BY months;
           
            
        '); 
        //    WHERE YEAR(d.vstdate) = YEAR(CURDATE())
        foreach ($count_visit as $key => $value) {
          
            if ($value->months == 1) { 
                $data['den_01'] = $value->chn; 
            }elseif ($value->months == 2) {
                $data['den_02'] = $value->chn;
            }elseif ($value->months == 3) {
                $data['den_03'] = $value->chn;
            }elseif ($value->months == 4) {
                $data['den_04'] = $value->chn;
            }elseif ($value->months == 5) {
                $data['den_05'] = $value->chn;
            }elseif ($value->months == 6) {
                $data['den_06'] = $value->chn;
            }elseif ($value->months == 7) {
                $data['den_07'] = $value->chn;
            }elseif ($value->months == 8) {
                $data['den_08'] = $value->chn;
            }elseif ($value->months == 9) {
                $data['den_09'] = $value->chn;
            }elseif ($value->months == 10) {
                $data['den_10'] = $value->chn;
            }elseif ($value->months == 11) {
                $data['den_11'] = $value->chn;
            } else {
                $data['den_12'] = $value->chn;
            }
           
        }        

        return view('dent.dental_db',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_show'        => $data_show,  
        ]);


        
    }
                 
    public function dental_calendar(Request $request)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;

        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี          
        
        $data_show = DB::connection('mysql2')->select(            
            'select count(distinct d.hn) 
            from dtmain d
            left outer join vn_stat v on v.vn=d.vn
            where d.vstdate between "'.$newweek.'" and "'.$date.'"
            and v.pt_subtype <> "2"
        ');
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        // ******************** Calenda *******************************

        $iddep =  Auth::user()->dep_subsubtrueid;
        $iduser = Auth::user()->id;
        $event = array();
        $otservicess = DB::table('ot_one')
        ->leftjoin('users','users.id','=','ot_one.ot_one_nameid')
        ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','users.dep_subsubtrueid')
        ->where('users.dep_subsubtrueid','=',$iddep)
        ->where('users.id','=',$iduser)
        ->get();

        $datashow = DB::connection('mysql15')->select(            
            'SELECT * FROM car
        ');

        foreach ($otservicess as $item) {            
            // $dateend = $item->car_service_length_backdate;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            $dateend = $item->ot_one_date;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            // $NewendDate = date("Y-m-d", strtotime($dateend) - 1);  //ลบออก 1 วัน  เพื่อโชว์ปฎิทิน
            // $datestart=date('H:m');
            $timestart = $item->ot_one_starttime;
            $timeend = $item->ot_one_endtime;

            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);
            $showtitle = $item->ot_one_fullname. ' => ' . $starttime . '-' . $endtime;
            
            // if ($item->ot_one_nameid == $iduser) {
                $color = $item->color_ot;             

            $event[] = [
                'id' => $item->ot_one_id,
                'title' => $showtitle, 
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        }



        return view('dent.dental_calendar',$data,[
                'events'     =>  $event,
            // 'startdate'        => $startdate,
            // 'enddate'          => $enddate,
            // 'data_show'        => $data_show,  
        ]);
    }

    public function dental_calendarsave (Request $request)
    {
        $datebigin = $request->start_date;
        $dateend = $request->end_date;
        $iduser = $request->user_id;
        $starttime = $request->ot_one_starttime;
        $endtime = $request->ot_one_endtime;

        $checkdate = Ot_one::where('ot_one_date','=',$datebigin)->where('ot_one_nameid','=',$iduser)->count();

        if ($checkdate > 0) {
            return response()->json([
                'status'     => '100',
            ]);
        } else {
            $add = new Ot_one();
            $add->ot_one_date = $datebigin;
            $add->ot_one_starttime = $starttime;
            $add->ot_one_endtime = $endtime;
            $add->ot_one_detail = $request->input('ot_one_detail');

            $start = strtotime($starttime);
            $end = strtotime($endtime);
            $tot = ($end - $start) / 3600; 
            $add->ot_one_total = $tot;

            
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first(); 
                $add->ot_one_nameid = $usersave->id;
                $add->ot_one_fullname = $usersave->pnamelong . ' '.$usersave->fname . '  ' . $usersave->lname;
                $add->dep_subsubtrueid = $usersave->dep_subsubtrueid;
            } else {
                $add->ot_one_nameid = ''; 
                $add->ot_one_fullname = '';
                $add->dep_subsubtrueid = '';
            }

            $add->save();

            return response()->json([
                'status'     => '200',
            ]);
        }  
    }

    public function dental_appointment_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $data['m']           = date('H');
        $data['mm']          = date('H:m:s');
        
        $iduser = Auth::user()->id;        
        
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        
        // $data['dent_appointment_type'] = DB::table('dent_appointment_type')->where('status','=','Y')->get();

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี  

        $data_appointment = DB::table('dent_appointment_type')->where('status','=','Y')->get();

                
        $data_show = DB::connection('mysql2')->select(            
            'select count(distinct d.hn) 
            from dtmain d
            left outer join vn_stat v on v.vn=d.vn
            where d.vstdate between "'.$newweek.'" and "'.$date.'"
            and v.pt_subtype <> "2"
        ');
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        $data['hn'] = DB::connection('mysql10')->select('SELECT hn,CONCAT(pname,fname," ",lname) as ptname FROM patient GROUP BY hn limit 1000');
        
               

        return view('dent.dental_appointment_add', $data,[
            'startdate'         => $datestart,
            'enddate'           => $dateend, 
            'users'             => $data,
            'appointment'       => $data_appointment,
            // 'datenow'           => $datenow,
            // 'data_trash_type'  => $data_trash_type,
            // 'billNos'          => $billNo,
        ]);       

        
    }

    public function dental_detail_patient(Request $request)
    {
        $hn                 =  $request->denthn;
       
        $data_show          = Patient::where('hn',$hn)->first();
        $data_cid           = $data_show->cid;
        $data_ptname        = $data_show->pname.''.$data_show->fname.'  '.$data_show->lname;
        $data_hometel       = $data_show->hometel;
        
        $output='<label for="">เลขบัตรประชาชน  :   '.$data_cid. '&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;  ชื่อ-นามสกุล  :    ' .$data_ptname.'&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;  เบอร์โทร  :    ' .$data_hometel.'</label>' ; 
        

        echo $output;        
    }
                  
    public function dental_appointment_save (Request $request) 
    {
        $hn                 =  $request->dent_hn;
        
        if ($hn != '') {
            $data_show          = Patient::where('hn',$hn)->first();        
            $data_cid           = $data_show->cid;
            if ($data_cid =='') {
                $data_cid_ = '';
            } else {
                $data_cid_ = $data_cid;
            }
    
            $data_type          = Dent_appointment_type::where('appointment_id',$request->appointment)->first();
            $appointment_id     = $data_type->appointment_id;
            $appointment_name   = $data_type->appointment_name;

            $data_users         = User::where('id','=',$request->dent_doctor)->first();
            $dent_doctor_name   = $data_users->fname.'  '.$data_users->lname;
           
            
            $data_ptname        = $data_show->pname.''.$data_show->fname.'  '.$data_show->lname;
            $data_hometel       = $data_show->hometel;

            if ($data_hometel =='') {
                $data_hometel_  = '';
            } else {
                $data_hometel_  = $data_hometel ;
            }
            
            Dent_appointment::insert([
                'dent_hn'               => $hn,
                'dent_patient_cid'      => $data_cid_,
                'dent_patient_name'     => $data_ptname, 
                'dent_tel'              => $data_hometel_,
                'dent_work'             => $request->dent_work,
                'dent_date'             => $request->dent_date,
                'dent_time'             => $request->dent_time,
                'appointment_id'        => $appointment_id,
                'appointment_name'      => $appointment_name, 
                'dent_doctor'           => $request->dent_doctor,
                'dent_doctor_name'      => $dent_doctor_name, 
                'user_save'             => Auth::user()->id
            ]);
            return response()->json([ 
                'status'    => '200'
            ]);
        } else {
            return response()->json([ 
                'status'    => '100'
            ]);
        }

      
    }

    public function dental_setting_type (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี   
 
        $dent_appointment_type = DB::table('dent_appointment_type')->get();  
        
        $data_show = DB::connection('mysql2')->select(            
            'select count(distinct d.hn) 
            from dtmain d
            left outer join vn_stat v on v.vn=d.vn
            where d.vstdate between "'.$newweek.'" and "'.$date.'"
            and v.pt_subtype <> "2"
        ');
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental_setting_type', $data,[
            'startdate'              => $datestart,
            'enddate'                => $dateend,
            'dent_appointment_type'  => $dent_appointment_type, 
        ]);
    }

    public function dental_setting_type_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี   
 
        $dent_appointment_type = DB::table('dent_appointment_type')->get();  
        
        $data_show = DB::connection('mysql2')->select(            
            'select count(distinct d.hn) 
            from dtmain d
            left outer join vn_stat v on v.vn=d.vn
            where d.vstdate between "'.$newweek.'" and "'.$date.'"
            and v.pt_subtype <> "2"
        ');
        
        $data['doctor'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "2"
            AND active = "Y"
        ');
        $data['helper'] = DB::connection('mysql10')->select('
            SELECT code,CONCAT(pname,fname," ",lname) dentname
            FROM doctor
            WHERE position_id = "6" 
            AND active = "Y"
        ');

        return view('dent.dental_setting_type_add', $data,[
            'startdate'              => $datestart,
            'enddate'                => $dateend,
            'dent_appointment_type'  => $dent_appointment_type, 
        ]);
    }

    public function dental_setting_type_save (Request $request)
    {  
        $datenow = date('Y-m-d H:m:s');

        Dent_appointment_type::insert([
            // 'trash_parameter_id'                    => $request->trash_parameter_id,
            'appointment_name'                   => $request->appointment_name,
            // 'trash_parameter_unit'                   => $request->trash_parameter_unit,
            'created_at'                         => $datenow
        ]);
        $data_parameter_list = DB::table('dent_appointment_type')->get();
    
        return redirect()->route('den.dental_setting_type');

    }

    public function dental_setting_type_update (Request $request)
    { 
        $datenow = date('Y-m-d H:m:s');
        $id = $request->appointment_id;
        
        Dent_appointment_type::where('appointment_id','=',$id)
        ->update([
            'appointment_name'                           => $request->appointment_name,
            // 'trash_parameter_unit'                       => $request->trash_parameter_unit,
            'updated_at'                                 => $datenow
        ]);

        $data_parameter_list = DB::table('dent_appointment_type')->get();
        // return redirect()->back();
        return redirect()->route('dent.dental_setting_type');
        
    }

    public function dental_setting_type_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี  
 
        $data_edit = DB::table('dent_appointment_type')->where('appointment_id','=',$id)->first();

        return view('den.dental_setting_type_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'data_edit'        => $data_edit, 
        ]);
    }

    public function dental_setting_type_delete (Request $request,$id)
    {
       $del = Dent_appointment_type::find($id);  
       $del->delete(); 

        return redirect()->back();
    }

    function dental_switchactive(Request $request)
    {  
        $id = $request->idfunc; 
        $active = Dent_appointment_type::find($id);
        $active->status = $request->onoff;
        $active->save();
    }

    // ************************* Report  *************************
    public function dental_report_appointment(Request $request)
    {
        $startdate               = $request->startdate;
        $enddate                 = $request->enddate;
        $appointment_id          = $request->appointment_id;
        $datenow                 = date('Y-m-d');
        $data['date_now']        = date('Y-m-d');
        $data['m']               = date('H');
        $data['mm']              = date('H:m:s');
        
        
        $iduser = Auth::user()->id;        
        
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -2 week')); //ย้อนหลัง 2 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี  

        $data_appointment = DB::table('dent_appointment_type')->where('status','=','Y')->get();

        if ($startdate != '') {
            $datashow = DB::connection('mysql')->select(            
                'SELECT * FROM dent_appointment 
                    WHERE dent_date BETWEEN "'.$startdate.'"  AND  "'.$enddate.'"  AND appointment_id ="'.$appointment_id.'"
            ');
        } else {
            $datashow = DB::connection('mysql')->select(            
                'SELECT * FROM dent_appointment 
                    WHERE dent_date = "'.$datenow.'"   
                  
            ');
        }

        $data['dent_appointment_type']  = DB::table('dent_appointment_type')->get();
            
        
        return view('dent.dental_report_appointment',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'den_app'       => $data_appointment,
        ]);
    }



    




 }
