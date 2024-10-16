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
use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\Fdh_sesion;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;
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
use Arr; 
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

class Account401Controller extends Controller
 {
    public function account_401_claim_export(Request $request)
    {
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

         #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export_OFC'); //ทั้งหมด
        // $file->cleanDirectory('UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg); 
        // $folder='OFC_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

        $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "OFC_401"');
        foreach ($dataexport_ as $key => $v_export) {
            $folder_ = $v_export->folder_name;
        }
        $folder = $folder_;

         mkdir ('Export_OFC/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"; charset=tis-620″ ;');

         //********** 1 ins.txt *****************//
        $file_d_ins = "Export_OFC/".$folder."/INS.txt";
        $objFopen_opd_ins = fopen($file_d_ins, 'w');
        $opd_head_ins = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        fwrite($objFopen_opd_ins, $opd_head_ins);
        $ins = DB::connection('mysql')->select('SELECT * from d_ins where d_anaconda_id = "OFC_401"');
        foreach ($ins as $key => $value1) {
            $a1 = $value1->HN;
            $a2 = $value1->INSCL;
            $a3 = $value1->SUBTYPE;
            $a4 = $value1->CID;
            $a5 = $value1->DATEIN;
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
            $strText_ins ="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
            $ansitxt_pat_ins = iconv('UTF-8', 'TIS-620', $strText_ins);
            fwrite($objFopen_opd_ins, $ansitxt_pat_ins);
        }
        fclose($objFopen_opd_ins);

        //**********2 pat.txt ******************//
        $file_pat = "Export_OFC/".$folder."/PAT.txt";
        $objFopen_opd_pat = fopen($file_pat, 'w');
        $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_opd_pat, $opd_head_pat);
        $pat = DB::connection('mysql')->select('SELECT * from d_pat where d_anaconda_id = "OFC_401"');
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
            $strText_pat="\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            $ansitxt_pat_pat = iconv('UTF-8', 'TIS-620', $strText_pat);
            fwrite($objFopen_opd_pat, $ansitxt_pat_pat);
        }
        fclose($objFopen_opd_pat);

        //************ 3 opd.txt *****************//
        $file_d_opd = "Export_OFC/".$folder."/OPD.txt";
        $objFopen_opd_opd = fopen($file_d_opd, 'w');
        $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        fwrite($objFopen_opd_opd, $opd_head_opd);
        $opd = DB::connection('mysql')->select('SELECT * from d_opd where d_anaconda_id = "OFC_401"');
        foreach ($opd as $key => $value3) {
            $o1 = $value3->HN;
            $o2 = $value3->CLINIC;
            $o3 = $value3->DATEOPD; 
            $o4 = $value3->TIMEOPD; 
            $o5 = $value3->SEQ; 
            $o6 = $value3->UUC;  
            $strText_opd="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            $ansitxt_pat_opd = iconv('UTF-8', 'TIS-620', $strText_opd);
            fwrite($objFopen_opd_opd, $ansitxt_pat_opd);
        }
        fclose($objFopen_opd_opd);

        //****************** 4 orf.txt **************************//
        $file_d_orf = "Export_OFC/".$folder."/ORF.txt";
        $objFopen_opd_orf = fopen($file_d_orf, 'w');
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
        fwrite($objFopen_opd_orf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('SELECT * from d_orf where d_anaconda_id = "OFC_401"');
        foreach ($orf as $key => $value4) {
            $p1 = $value4->HN;
            $p2 = $value4->DATEOPD;
            $p3 = $value4->CLINIC; 
            $p4 = $value4->REFER; 
            $p5 = $value4->REFERTYPE; 
            $p6 = $value4->SEQ;  
            $strText_orf ="\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
            $ansitxt_pat_orf = iconv('UTF-8', 'TIS-620', $strText_orf);
            fwrite($objFopen_opd_orf, $ansitxt_pat_orf);
        }
        fclose($objFopen_opd_orf);

        //****************** 5 odx.txt **************************//
        $file_d_odx = "Export_OFC/".$folder."/ODX.txt";
        $objFopen_opd_odx = fopen($file_d_odx, 'w');
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_opd_odx, $opd_head_odx);
        $odx = DB::connection('mysql')->select('SELECT * from d_odx where d_anaconda_id = "OFC_401"');
        foreach ($odx as $key => $value5) {
            $m1 = $value5->HN;
            $m2 = $value5->DATEDX;
            $m3 = $value5->CLINIC; 
            $m4 = $value5->DIAG; 
            $m5 = $value5->DXTYPE; 
            $m6 = $value5->DRDX; 
            $m7 = $value5->PERSON_ID; 
            $m8 = $value5->SEQ; 
            $strText_odx="\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            $ansitxt_pat_odx = iconv('UTF-8', 'TIS-620', $strText_odx);
            fwrite($objFopen_opd_odx, $ansitxt_pat_odx);
        }
        fclose($objFopen_opd_odx);

        //****************** 6.oop.txt ******************************//
        $file_d_oop = "Export_OFC/".$folder."/OOP.txt";
        $objFopen_opd_oop = fopen($file_d_oop, 'w');
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
        fwrite($objFopen_opd_oop, $opd_head_oop);
        $oop = DB::connection('mysql')->select('SELECT * from d_oop where d_anaconda_id = "OFC_401"');
        foreach ($oop as $key => $value6) {
            $n1 = $value6->HN;
            $n2 = $value6->DATEOPD;
            $n3 = $value6->CLINIC; 
            $n4 = $value6->OPER; 
            $n5 = $value6->DROPID; 
            $n6 = $value6->PERSON_ID; 
            $n7 = $value6->SEQ;  
            $strText_oop="\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
            $ansitxt_pat_oop = iconv('UTF-8', 'TIS-620', $strText_oop);
            fwrite($objFopen_opd_oop, $ansitxt_pat_oop);
        }
        fclose($objFopen_opd_oop);

        //******************** 7.ipd.txt **************************//
        $file_d_ipd = "Export_OFC/".$folder."/IPD.txt";
        $objFopen_opd_ipd = fopen($file_d_ipd, 'w');
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        fwrite($objFopen_opd_ipd, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('SELECT * from d_ipd where d_anaconda_id = "OFC_401"');
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
            $strText_ipd="\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            $ansitxt_pat_ipd = iconv('UTF-8', 'TIS-620', $strText_ipd);
            fwrite($objFopen_opd_ipd, $ansitxt_pat_ipd);
        }
        fclose($objFopen_opd_ipd);

         //********************* 8.irf.txt ***************************//
         $file_d_irf = "Export_OFC/".$folder."/IRF.txt";
         $objFopen_opd_irf = fopen($file_d_irf, 'w');
         $opd_head_irf = 'AN|REFER|REFERTYPE';
         fwrite($objFopen_opd_irf, $opd_head_irf);
         $irf = DB::connection('mysql')->select('SELECT * from d_irf where d_anaconda_id = "OFC_401"');
         foreach ($irf as $key => $value8) {
             $k1 = $value8->AN;
             $k2 = $value8->REFER;
             $k3 = $value8->REFERTYPE; 
             $strText_irf="\n".$k1."|".$k2."|".$k3;
             $ansitxt_pat_irf = iconv('UTF-8', 'TIS-620', $strText_irf);
             fwrite($objFopen_opd_irf, $ansitxt_pat_irf);
         }
         fclose($objFopen_opd_irf);

        //********************** 9.idx.txt ***************************//
        $file_d_idx = "Export_OFC/".$folder."/IDX.txt";
        $objFopen_opd_idx = fopen($file_d_idx, 'w');
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_opd_idx, $opd_head_idx);
        $idx = DB::connection('mysql')->select('SELECT * from d_idx where d_anaconda_id = "OFC_401"');
        foreach ($idx as $key => $value9) {
            $h1 = $value9->AN;
            $h2 = $value9->DIAG;
            $h3 = $value9->DXTYPE;
            $h4 = $value9->DRDX; 
            $strText_idx="\n".$h1."|".$h2."|".$h3."|".$h4;
            $ansitxt_pat_idx = iconv('UTF-8', 'TIS-620', $strText_idx);
            fwrite($objFopen_opd_idx, $ansitxt_pat_idx);
        }
        fclose($objFopen_opd_idx);

        //********************** 10 iop.txt ***************************//
        $file_d_iop = "Export_OFC/".$folder."/IOP.txt";
        $objFopen_opd_iop = fopen($file_d_iop, 'w');
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        fwrite($objFopen_opd_iop, $opd_head_iop);
        $iop = DB::connection('mysql')->select('SELECT * from d_iop where d_anaconda_id = "OFC_401"');
        foreach ($iop as $key => $value10) {
            $b1 = $value10->AN;
            $b2 = $value10->OPER;
            $b3 = $value10->OPTYPE;
            $b4 = $value10->DROPID;
            $b5 = $value10->DATEIN;
            $b6 = $value10->TIMEIN;
            $b7 = $value10->DATEOUT;
            $b8 = $value10->TIMEOUT;           
            $strText_iop ="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
            $ansitxt_pat_iop = iconv('UTF-8', 'TIS-620', $strText_iop);
            fwrite($objFopen_opd_iop, $ansitxt_pat_iop);
        }
        fclose($objFopen_opd_iop);

        //********************** .11 cht.txt *****************************//
        $file_d_cht = "Export_OFC/".$folder."/CHT.txt";
        $objFopen_opd_cht = fopen($file_d_cht, 'w');
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        fwrite($objFopen_opd_cht, $opd_head_cht);
        $cht = DB::connection('mysql')->select('SELECT * from d_cht where d_anaconda_id = "OFC_401"');
        foreach ($cht as $key => $value11) {
            $f1 = $value11->HN;
            $f2 = $value11->AN;
            $f3 = $value11->DATE;
            $f4 = $value11->TOTAL;
            $f5 = $value11->PAID;
            $f6 = $value11->PTTYPE;
            $f7 = $value11->PERSON_ID; 
            $f8 = $value11->SEQ;
            $strText_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8;
            $ansitxt_pat_cht = iconv('UTF-8', 'TIS-620', $strText_cht);
            fwrite($objFopen_opd_cht, $ansitxt_pat_cht);
        }
        fclose($objFopen_opd_cht);

        //********************** .12 cha.txt *****************************//
        $file_d_cha = "Export_OFC/".$folder."/CHA.txt";
        $objFopen_opd_cha = fopen($file_d_cha, 'w');
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        fwrite($objFopen_opd_cha, $opd_head_cha);
        $cha = DB::connection('mysql')->select('SELECT * from d_cha where d_anaconda_id = "OFC_401"');
        foreach ($cha as $key => $value12) {
            $e1 = $value12->HN;
            $e2 = $value12->AN;
            $e3 = $value12->DATE;
            $e4 = $value12->CHRGITEM;
            $e5 = $value12->AMOUNT;
            $e6 = $value12->PERSON_ID;
            $e7 = $value12->SEQ; 
            $strText_cha="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
            $ansitxt_pat_cha = iconv('UTF-8', 'TIS-620', $strText_cha);
            fwrite($objFopen_opd_cha, $ansitxt_pat_cha);
        }
        fclose($objFopen_opd_cha);

        //************************ .13 aer.txt **********************************//
        $file_d_aer = "Export_OFC/".$folder."/AER.txt";
        $objFopen_opd_aer = fopen($file_d_aer, 'w');
        $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        fwrite($objFopen_opd_aer, $opd_head_aer);
        $aer = DB::connection('mysql')->select('SELECT * from d_aer where d_anaconda_id = "OFC_401"');
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
            $strText_aer="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
            $ansitxt_pat_aer = iconv('UTF-8', 'TIS-620', $strText_aer);
            fwrite($objFopen_opd_aer, $ansitxt_pat_aer);
        }
        fclose($objFopen_opd_aer);

        //************************ .14 adp.txt **********************************//
        $file_d_adp = "Export_OFC/".$folder."/ADP.txt";
        $objFopen_opd_adp = fopen($file_d_adp, 'w');
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        fwrite($objFopen_opd_adp, $opd_head_adp);
        $adp = DB::connection('mysql')->select('SELECT * from d_adp where d_anaconda_id = "OFC_401"');
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
            $strText_adp ="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            $ansitxt_pat_adp = iconv('UTF-8', 'TIS-620', $strText_adp);
            fwrite($objFopen_opd_adp, $ansitxt_pat_adp);
        }
        fclose($objFopen_opd_adp); 

        //*********************** 15.dru.txt ****************************//
        $file_d_dru = "Export_OFC/".$folder."/DRU.txt";
        $objFopen_opd_dru = fopen($file_d_dru, 'w');
        $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRICE|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        fwrite($objFopen_opd_dru, $opd_head_dru);
        $dru = DB::connection('mysql')->select('SELECT * from d_dru where d_anaconda_id = "OFC_401"');
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
            $g10 = $value15->DRUGPRICE;
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
            $strText_dru ="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24;;
            $ansitxt_pat_dru = iconv('UTF-8', 'TIS-620', $strText_dru);
            fwrite($objFopen_opd_dru, $ansitxt_pat_dru);
        }
        fclose($objFopen_opd_dru);
        
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
        $file_d_lvd = "Export_OFC/".$folder."/LVD.txt";
        $objFopen_opd_lvd = fopen($file_d_lvd, 'w');
        $opd_head_lvd = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        fwrite($objFopen_opd_lvd, $opd_head_lvd);
        $lvd = DB::connection('mysql')->select('SELECT * from d_lvd where d_anaconda_id = "OFC_401"');
        foreach ($lvd as $key => $value16) {
            $L1 = $value16->SEQLVD;
            $L2 = $value16->AN;
            $L3 = $value16->DATEOUT; 
            $L4 = $value16->TIMEOUT; 
            $L5 = $value16->DATEIN; 
            $L6 = $value16->TIMEIN; 
            $L7 = $value16->QTYDAY; 
            $strText_lvd ="\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
            $ansitxt_pat_lvd = iconv('UTF-8', 'TIS-620', $strText_lvd);
            fwrite($objFopen_opd_lvd, $ansitxt_pat_lvd);
        }
        fclose($objFopen_opd_lvd); 

        //*********************** 17.lab.txt **********************************//
        $file_d_lab = "Export_OFC/".$folder."/LAB.txt";
        $objFopen_opd_lab = fopen($file_d_lab, 'w');
        $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
        fwrite($objFopen_opd_lab, $opd_head_lab);
        fclose($objFopen_opd_lab);



        $pathdir =  "Export_OFC/".$folder."/";
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
                    return redirect()->route('acc.account_401_pull');                    
                }
        } 

        return redirect()->route('acc.account_401_pull');

    }
 }
?>