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
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Cctv_list;
use App\Models\Cctv_check;
use App\Models\Article_status;
use App\Models\Land;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
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


class CCtvController extends Controller
 { 
    public function cctv_dashboard(Request $request)
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
                SELECT a.*,c.subinscl 
                from acc_debtor a
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N" AND a.debit_total > 0
                AND a.dchdate IS NOT NULL
                group by a.an
                order by a.dchdate desc;
            ');
            
        } else {
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                AND a.dchdate IS NOT NULL
                group by a.an
                order by a.dchdate desc;
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }
        return view('support_prs.cctv.cctv_dashboard',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function cctv(Request $request)
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
                SELECT a.*,c.subinscl 
                from acc_debtor a
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N" AND a.debit_total > 0
                AND a.dchdate IS NOT NULL
                group by a.an
                order by a.dchdate desc;
            ');
            
        } else {
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                AND a.dchdate IS NOT NULL
                group by a.an
                order by a.dchdate desc;
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }
        return view('support_prs.cctv.cctv',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function cctv_list_old(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $id = $request->id;
        if ($id == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $datashow = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id ASC'); 
            // $qrCodes = [];
            // $qrCodes['simple'] = QrCode::size(150)->generate('https://minhazulmin.github.io/');

        } else {
            $datashow = DB::select('SELECT * from article_data WHERE cctv="Y" AND article_id ="'.$id.'" order by article_id ASC'); 
        }
        return view('support_prs.cctv.cctv_list',[
            'startdate'   =>     $startdate,
            'enddate'     =>     $enddate,
            'datashow'    =>     $datashow,
        ]);
    }
    public function cctv_list(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
    
        $datashow = DB::select('SELECT * from cctv_list ORDER BY cctv_list_id ASC'); 
      
        return view('support_prs.cctv.cctv_list',[
            'startdate'   =>     $startdate,
            'enddate'     =>     $enddate,
            'datashow'    =>     $datashow,
        ]);
    }
    public function cctv_add(Request $request)
    {
        // $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
        //     ->orderBy('article_id', 'DESC')
        //     ->get();
        $data['article_data']       = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id desc'); 
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get();
        // $data['land_data']      = Land::get();
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get();
        $data['product_method']     = Product_method::get();
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get();
        // $data['product_brand']   = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.cctv.cctv_add', $data);
    }
    public function cctv_save(Request $request)
    {
        $add = new Cctv_list();
        $add->cctv_list_num               = $request->input('cctv_list_num');
        $add->cctv_list_name              = $request->input('cctv_list_name');
        $add->cctv_list_year              = $request->input('cctv_list_year');
        $add->cctv_recive_date            = $request->input('cctv_recive_date');
        $add->cctv_location               = $request->input('cctv_location');
        $add->cctv_location_detail        = $request->input('cctv_location_detail');
        $add->cctv_type                   = $request->input('cctv_type');
        $add->cctv_monitor                = $request->input('cctv_monitor');
        $add->cctv_status                 = $request->input('cctv_status'); 
        $add->cctv_status                 = '0';
         
        if ($request->hasfile('cctv_img')) {
            $file = $request->file('cctv_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extention; 
            $request->cctv_img->storeAs('cctv', $filename, 'public'); 
            $add->cctv_img = $filename;
            $add->cctv_img_name = $filename;
        }
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function cctv_save_old(Request $request)
    {
        $add = new Article();
        $add->article_year         = $request->input('article_year');
        $add->article_recieve_date = $request->input('article_recieve_date');
        $add->article_price        = $request->input('article_price');
        $add->medical_typecat_id   = $request->input('medical_typecat_id');
        $add->article_num          = $request->input('article_num');
        $add->article_name         = $request->input('article_name');
        $add->article_attribute    = $request->input('article_attribute');
        $add->store_id             = $request->input('store_id');
        $add->article_claim        = $request->input('article_claim');
        $add->article_used         = $request->input('article_used');
        $add->cctv_status          = $request->input('cctv_status');
        $add->cctv                 = 'Y';
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $add->article_brand_id = $bransave->brand_id;
            $add->article_brand_name = $bransave->brand_name;
        } else {
            $add->article_brand_id = '';
            $add->article_brand_name = '';
        }


        $venid = $request->input('vendor_id');
        if ($venid != '') {
            $vensave = DB::table('products_vendor')->where('vendor_id', '=', $venid)->first();
            $add->article_vendor_id = $vensave->vendor_id;
            $add->article_vendor_name = $vensave->vendor_name;
        } else {
            $add->article_vendor_id = '';
            $add->article_vendor_name = '';
        }

        $buid = $request->input('article_buy_id');
        if ($buid != '') {
            $buysave = DB::table('product_buy')->where('buy_id', '=', $buid)->first();
            $add->article_buy_id = $buysave->buy_id;
            $add->article_buy_name = $buysave->buy_name;
        } else {
            $add->article_buy_id = '';
            $add->article_buy_name = '';
        }

        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id', '=', $decliid)->first();
            $add->article_decline_id = $decsave->decline_id;
            $add->article_decline_name = $decsave->decline_name;
        } else {
            $add->article_decline_id = '';
            $add->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $debid)->first();
            $add->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
            $add->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
        } else {
            $add->article_deb_subsub_id = '';
            $add->article_deb_subsub_name = '';
        }
  
        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $add->article_unit_id = $unisave->unit_id;
            $add->article_unit_name = $unisave->unit_name;
        } else {
            $add->article_unit_id = '';
            $add->article_unit_name = '';
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id', '=', $groupid)->first();
            $add->article_groupid = $groupsave->product_group_id;
            $add->article_groupname = $groupsave->product_group_name;
        } else {
            $add->article_groupid = '';
            $add->article_groupname = '';
        }

        $typeid = $request->input('article_typeid');
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id', '=', $typeid)->first();
            $add->article_typeid = $typesave->sub_type_id;
            $add->article_typename = $typesave->sub_type_name;
        } else {
            $add->article_typeid = '';
            $add->article_typename = '';
        }

        $catid = $request->input('article_categoryid');
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id', '=', $catid)->first();
            $add->article_categoryid = $catsave->category_id;
            $add->article_categoryname = $catsave->category_name;
        } else {
            $add->article_categoryid = '';
            $add->article_categoryname = '';
        }

        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article', $filename, 'public');
            // $file->storeAs('article/',$filename);
            $add->article_img = $filename;
            $add->article_img_name = $filename;
        }
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function cctv_edit(Request $request, $id)
    {
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data'] = Products::get();
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_spyprice'] = Product_spyprice::get();
        $data['product_group'] = Product_group::get();
        $data['product_unit'] = Product_unit::get();
        $data['article_data'] = Article::orderBy('article_id', 'DESC')->get();
        $data['products_vendor'] = Products_vendor::get();
        $data['product_buy'] = Product_buy::get();
        $data['article_status'] = Article_status::get();
        $data['products_vendor'] = Products_vendor::get();
        // $data['product_brand'] = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $dataedit = Cctv_list::where('cctv_list_id', '=', $id)->first();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        return view('support_prs.cctv.cctv_edit', $data, [
            'dataedits' => $dataedit
        ]);
    }
    public function cctv_update_old(Request $request)
    {
        $idarticle = $request->article_id;
        $update = Article::find($idarticle);
        $update->article_year = $request->input('article_year');
        $update->article_recieve_date = $request->input('article_recieve_date');
        $update->article_price = $request->input('article_price');
        $update->article_fsn = $request->input('article_fsn');
        $update->article_num = $request->input('article_num');
        $update->article_name = $request->input('article_name');
        $update->article_attribute = $request->input('article_attribute');
        $update->medical_typecat_id = $request->input('medical_typecat_id');
        $update->store_id = $request->input('store_id');
        $update->article_claim = $request->input('article_claim');
        $update->article_used = $request->input('article_used');
        // $update->article_status_id = $request->input('article_status_id');
        $update->cctv_status          = $request->input('cctv_status');
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $update->article_brand_id = $bransave->brand_id;
            $update->article_brand_name = $bransave->brand_name;
        } else {
            $update->article_brand_id = '';
            $update->article_brand_name = '';
        }

        $venid = $request->input('vendor_id');
        if ($venid != '') {
            $vensave = DB::table('products_vendor')->where('vendor_id', '=', $venid)->first();
            $update->article_vendor_id = $vensave->vendor_id;
            $update->article_vendor_name = $vensave->vendor_name;
        } else {
            $update->article_vendor_id = '';
            $update->article_vendor_name = '';
        }

        $buid = $request->input('article_buy_id');
        if ($buid != '') {
            $buysave = DB::table('product_buy')->where('buy_id', '=', $buid)->first();
            $update->article_buy_id = $buysave->buy_id;
            $update->article_buy_name = $buysave->buy_name;
        } else {
            $update->article_buy_id = '';
            $update->article_buy_name = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $update->article_unit_id = $unisave->unit_id;
            $update->article_unit_name = $unisave->unit_name;
        } else {
            $update->article_unit_id = '';
            $update->article_unit_name = '';
        }


        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id', '=', $decliid)->first();
            $update->article_decline_id = $decsave->decline_id;
            $update->article_decline_name = $decsave->decline_name;
        } else {
            $update->article_decline_id = '';
            $update->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $debid)->first();
            $update->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
            $update->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
        } else {
            $update->article_deb_subsub_id = '';
            $update->article_deb_subsub_name = '';
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id', '=', $groupid)->first();
            $update->article_groupid = $groupsave->product_group_id;
            $update->article_groupname = $groupsave->product_group_name;
        } else {
            $update->article_groupid = '';
            $update->article_groupname = '';
        }

        $typeid = $request->input('article_typeid');
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id', '=', $typeid)->first();
            $update->article_typeid = $typesave->sub_type_id;
            $update->article_typename = $typesave->sub_type_name;
        } else {
            $update->article_typeid = '';
            $update->article_typename = '';
        }

        $catid = $request->input('article_categoryid');
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id', '=', $catid)->first();
            $update->article_categoryid = $catsave->category_id;
            $update->article_categoryname = $catsave->category_name;
        } else {
            $update->article_categoryid = '';
            $update->article_categoryname = '';
        }

        if ($request->hasfile('article_img')) {
            $description = 'storage/article/' . $update->article_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article', $filename, 'public');
            $update->article_img = $filename;
            $update->article_img_name = $filename;
        }

        $update->save();

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function cctv_update(Request $request)
    { 
        $id  = $request->cctv_list_id;
        $num = $request->input('cctv_list_num');
        
        $update = Cctv_list::find($id);
        $update->cctv_list_num               = $num;
        $update->cctv_list_name              = $request->input('cctv_list_name');
        $update->cctv_list_year              = $request->input('cctv_list_year');
        $update->cctv_recive_date            = $request->input('cctv_recive_date');
        $update->cctv_location               = $request->input('cctv_location');
        $update->cctv_location_detail        = $request->input('cctv_location_detail');
        $update->cctv_type                   = $request->input('cctv_type');
        $update->cctv_monitor                = $request->input('cctv_monitor');
        $update->cctv_status                 = $request->input('cctv_status'); 
        $update->cctv_status                 = '0';
         
        // if ($request->hasfile('cctv_img')) {
        //     $description = 'storage/cctv/' . $update->cctv_img;
        //     if (File::exists($description)) {
        //         File::delete($description);
        //     }
        //     $file = $request->file('cctv_img');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time(). '.' . $extention; 
        //     $request->cctv_img->storeAs('cctv', $filename, 'public'); 
        //     $update->cctv_img = $filename;
        //     $update->cctv_img_name = $filename;
        // }
        // $update->save();
        if ($request->hasfile('cctv_img')) {

            $description = 'storage/cctv/' . $update->cctv_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            
            $image_64 = $request->file('cctv_img');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $num. '.' . $extention;
            $request->cctv_img->storeAs('cctv', $filename, 'public');  
            $update->cctv_img            = $filename;
            $update->cctv_img_name        = $filename; 
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('cctv_img'))); 
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('cctv_img'))); 
            } 
            $update->cctv_img_base       = $file64;
        }
        $update->save();
       
        return response()->json([
            'status'     => '200'
        ]);
          
         
    }
    public function cctv_destroy(Request $request,$id)
    {
        // $del = Article::find($id);  
        // $description = 'storage/article/'.$del->img;
        // if (File::exists($description)) {
        //     File::delete($description);
        // }
        // $del->delete(); 

        $del = Cctv_list::find($id);  
        $description = 'storage/cctv/'.$del->img;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete();
            return response()->json(['status' => '200']);
    }
 

    public function cctv_report(Request $request)
    { 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $datashow = DB::select(
                'SELECT c.cctv_check_date,c.article_num,c.cctv_camera_screen,c.cctv_camera_corner,c.cctv_camera_drawback,c.cctv_camera_save,c.cctv_camera_power_backup,concat(s.fname," ",s.lname) ptname 
                FROM cctv_check c
                LEFT JOIN users s ON s.id = c.cctv_user_id
                WHERE c.cctv_check_date BETWEEN "'.$newDate.'" AND "'.$date.'"
                GROUP BY c.cctv_check_date,c.article_num                
                '); 
        } else {
            $datashow = DB::select(
                'SELECT c.cctv_check_date,c.article_num,c.cctv_camera_screen,c.cctv_camera_corner,c.cctv_camera_drawback,c.cctv_camera_save,c.cctv_camera_power_backup,concat(s.fname," ",s.lname) ptname 
                FROM cctv_check c
                LEFT JOIN users s ON s.id = c.cctv_user_id
                WHERE c.cctv_check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY c.cctv_check_date,c.article_num                
            ');  
        }
        return view('support_prs.cctv.cctv_report',[
            'startdate'   =>     $startdate,
            'enddate'     =>     $enddate,
            'datashow'    =>     $datashow,
        ]);
    }
    public function cctv_report_process(Request $request)
    { 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $iduser = Auth::user()->id;
        if ( $startdate != '') {
            Cctv_report_months::whereBetween('cctv_check_date', [$startdate, $enddate])->delete();
            $data_ = DB::connection('mysql')->select(
                'SELECT c.cctv_check_date,c.article_num 
                    ,COUNT(c.cctv_camera_screen) as screen_all,COUNT(c.cctv_camera_corner) as corner_all
                    ,COUNT(c.cctv_camera_drawback) as drawback_all,COUNT(c.cctv_camera_save) as csave_all,COUNT(c.cctv_camera_power_backup) as power_all
                    FROM cctv_check c                    
                    WHERE c.cctv_check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    GROUP BY c.cctv_check_date,c.article_num 
            '); 
            // LEFT JOIN article_data a ON a.article_num = c.article_num   
            foreach ($data_ as $val) {       
                Cctv_report_months::insert([
                    'cctv_check_date'       => $val->cctv_check_date,
                    'article_num'           => $val->article_num,
                    'screen_all'            => $val->screen_all, 
                    'corner_all'            => $val->corner_all,
                    'drawback_all'          => $val->drawback_all, 
                    'csave_all'             => $val->csave_all, 
                    'power_all'             => $val->power_all,  
                    'user_id'               => $iduser,                    
                ]);
                // $data_arr = DB::table('article_data')->where('article_num',$val->article_num)->first();
                // if ($data_arr->cctv_location != '') {
                //     Cctv_report_months::where('article_num', $val->article_num)->update([ 
                //         'cctv_location'    => $data_arr->cctv_location, 
                //         'cctv_type'        => $data_arr->cctv_type, 
                //     ]);
                // }
               

                $data_s = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_screen) as screen_narmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_screen = "0"');
                foreach ($data_s as $val_s) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'screen_narmal'    => $val_s->screen_narmal, 
                    ]);
                }
                $data_ss = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_screen) as screen_abnarmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_screen = "1"');
                foreach ($data_ss as $val_ss) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'screen_abnarmal'    => $val_ss->screen_abnarmal, 
                    ]);
                }
                $data_c = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_corner) as corner_narmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_corner = "0"');
                foreach ($data_c as $val_c) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'corner_narmal'    => $val_c->corner_narmal, 
                    ]);
                }
                $data_cc = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_corner) as corner_abnarmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_corner = "1"');
                foreach ($data_cc as $val_cc) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'corner_abnarmal'    => $val_cc->corner_abnarmal, 
                    ]);
                }
                $data_dr = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_drawback) as drawback_narmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_drawback = "0"');
                foreach ($data_dr as $val_dr) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'drawback_narmal'    => $val_dr->drawback_narmal, 
                    ]);
                }
                $data_dra = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_drawback) as drawback_abnarmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_drawback = "1"');
                foreach ($data_dra as $val_dra) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'drawback_abnarmal'    => $val_dra->drawback_abnarmal, 
                    ]);
                }
                $data_cs = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_save) as csave_narmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_save = "0"');
                foreach ($data_cs as $val_cs) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'csave_narmal'    => $val_cs->csave_narmal, 
                    ]);
                }
                $data_css = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_save) as csave_abnarmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_save = "1"');
                foreach ($data_css as $val_css) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'csave_abnarmal'    => $val_css->csave_abnarmal, 
                    ]);
                }
                $data_po = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_power_backup) as power_narmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_power_backup = "0"');
                foreach ($data_po as $val_po) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'power_narmal'    => $val_po->power_narmal, 
                    ]);
                }
                $data_pos = DB::connection('mysql')->select('SELECT cctv_check_date,article_num,COUNT(cctv_camera_power_backup) as power_abnarmal FROM cctv_check WHERE cctv_check_date = "'.$val->cctv_check_date.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_power_backup = "1"');
                foreach ($data_pos as $val_pos) { 
                    Cctv_report_months::where('cctv_check_date', $val->cctv_check_date)->where('article_num', $val->article_num)->update([ 
                        'power_abnarmal'    => $val_pos->power_abnarmal, 
                    ]);
                } 
                
            }
            // $data_ar = DB::table('article_data')->where('cctv','=','Y')->where('article_num','<>',NULL)->get();
            // $data_lo = $data_ar->cctv_location;
            // $data_ty = $data_ar->cctv_type;
            // Cctv_report_months::where('article_num', $val->article_num)->update([ 
            //     'cctv_location'    => $data_lo, 
            //     'cctv_type'        => $data_ty, 
            // ]);
            // $data_check = DB::connection('mysql')->select('SELECT * FROM cctv_check cctv_check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND article_num ="'.$val->article_num.'" AND cctv_camera_screen = "0"');
                
            return response()->json([
                'status'    => '200'
            ]);
        } else {
            return response()->json([
                'status'    => '100'
            ]);
        } 
    }
    public function cctvqrcode(Request $request, $id)
    {

            $cctvprint = Article::where('article_id', '=', $id)->first();

        return view('support_prs.cctv.cctvqrcode', [
            'cctvprint'  =>  $cctvprint
        ]);

    }

    public function cctv_list_check(Request $request)
    { 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
 
        // $datashow = DB::select(
        //     'SELECT * from cctv_list 
        //     WHERE cctv_status = "0" AND month(cctv_check_date) = "'.$months.'"
        //     order by cctv_list_id ASC
        // '); 
        $datashow = Cctv_check::leftJoin('cctv_list', 'cctv_check.article_num', '=', 'cctv_list.cctv_list_num')
        ->whereMonth('cctv_check.cctv_check_date', '=', $months)
        ->groupBy('cctv_list.cctv_list_num')->orderBy('cctv_monitor','ASC')
        ->get(); 
      
        return view('support_prs.cctv.cctv_list_check',[
            'startdate'   =>     $startdate,
            'enddate'     =>     $enddate,
            'datashow'    =>     $datashow,
        ]);
    }
    public function cctv_list_check_add(Request $request)
    { 
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays      = date('Y-m-d', strtotime($date . ' -1 days'));//ย้อนหลัง 1 วัน
        $newweek_plus = date('Y-m-d', strtotime($date . ' +1 week')); //ไปหน้า 1 สัปดาห์
        $newweek      = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate      = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear      = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $datashow = DB::select(
            'SELECT * from cctv_list 
            WHERE cctv_list_year = "'.$bg_yearnow.'"
            ORDER BY cctv_list_id ASC
        '); 
        //  WHERE cctv_check = "N"
        //  WHERE cctv_status = "0" 
        //   AND cctv_check = "N"
        return view('support_prs.cctv.cctv_list_check_add',[
            'startdate'   =>     $startdate,
            'enddate'     =>     $enddate,
            'datashow'    =>     $datashow,
        ]);
    }

    public function cctv_list_editcheck(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $c_an_ = Cctv_list::where('cctv_list_num', $request->cctv_list_num)->first();
                // $an1    = $c_an_->count_an1;
                // $an2    = $c_an_->count_an2;
                // $an3    = $c_an_->count_an3;
                
                // $nursing_ = Nurse_ksk::where('ward',$request->ward)->first();
                $date = date('Y-m-d');
                $m = date('H');
                $mm = date('H:m:s');
                $datefull = date('Y-m-d H:m:s');

                if ($request->cctv_camera_screen =='1' || $request->cctv_camera_corner =='1' || $request->cctv_camera_drawback =='1') {
                    $cctv_status = '1';
                } else {
                    $cctv_status = '0';
                    // $cctv_check = 'N';
                }
                
 
                $data  = array(
                    // 'cctv_check_date'            => $date,
                    'cctv_camera_screen'         => $request->cctv_camera_screen,
                    'cctv_camera_corner'         => $request->cctv_camera_corner,
                    'cctv_camera_drawback'       => $request->cctv_camera_drawback,
                    'cctv_status'                => $cctv_status,
                    'cctv_check'                 => 'Y',
                    // 'cctv_camera_save'           => $request->cctv_camera_save,
                    // 'cctv_camera_power_backup'   => $request->cctv_camera_power_backup,
                );
                DB::connection('mysql')->table('cctv_list')
                    ->where('cctv_list_num', $request->cctv_list_num)
                    ->update($data);


            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }
    public function cctv_list_check_save(Request $request)
    {
     
            $cctv_insert = Cctv_list::where('cctv_check', '=','N')->get();
            $date        = date('Y-m-d'); 
            $m           = date('m');   
            $iduser      = Auth::user()->id;
            foreach ($cctv_insert as $key => $value) {
                $check = Cctv_check::where('article_num', $value->cctv_list_num)->whereMonth('cctv_check_date', '=', $m)->count(); 
                $cctv_detail = Cctv_list::where('cctv_list_num',$value->cctv_list_num)->first();

                if ($check > 0) {
                    Cctv_check::where('article_num', $value->cctv_list_num)->whereMonth('cctv_check_date', '=', $m)->update([ 
                        // 'cctv_check_date'           => $value->cctv_check_date,
                        'cctv_camera_screen'        => $value->cctv_camera_screen,
                        'cctv_camera_corner'        => $value->cctv_camera_corner,
                        'cctv_camera_drawback'      => $value->cctv_camera_drawback,
                        'cctv_camera_save'          => $value->cctv_camera_save,
                        'cctv_camera_power_backup'  => $value->cctv_camera_power_backup,
                        'cctv_type'                 => $cctv_detail->cctv_type,
                        'cctv_location'             => $cctv_detail->cctv_location,
                        'cctv_user_id'              => $iduser,
                        'cctv_check_date'           => $date
                    ]);
                    Cctv_list::where('cctv_list_num', $value->cctv_list_num)->update([ 
                        'cctv_check_date'           => $date, 
                    ]);
                } else {
                    Cctv_check::insert([
                        'article_num'               => $value->cctv_list_num,
                        // 'cctv_check_date'           => $value->cctv_check_date,
                        'cctv_camera_screen'        => $value->cctv_camera_screen,
                        'cctv_camera_corner'        => $value->cctv_camera_corner,
                        'cctv_camera_drawback'      => $value->cctv_camera_drawback,
                        'cctv_camera_save'          => $value->cctv_camera_save,
                        'cctv_camera_power_backup'  => $value->cctv_camera_power_backup,
                        'cctv_type'                 => $cctv_detail->cctv_type,
                        'cctv_location'             => $cctv_detail->cctv_location,
                        'cctv_user_id'              => $iduser,
                        'cctv_check_date'           => $date
                    ]);
                    Cctv_list::where('cctv_list_num', $value->cctv_list_num)->update([ 
                        'cctv_check_date'           => $date, 
                    ]);
                }
                if ($value->cctv_camera_screen == '1' || $value->cctv_camera_corner == '1' || $value->cctv_camera_drawback == '1' || $value->cctv_camera_save == '1' || $value->cctv_camera_power_backup == '1') {
                    Cctv_list::where('cctv_list_num',$value->cctv_list_num)->update(['cctv_status' => '1']);
                } else {
                    Cctv_list::where('cctv_list_num',$value->cctv_list_num)->update(['cctv_status' => '0']);
                }
                 
            }
                
            

            // $data  = array(
            //     'cctv_camera_screen'         => $request->cctv_camera_screen,
            //     'cctv_camera_corner'         => $request->cctv_camera_corner,
            //     'cctv_camera_drawback'       => $request->cctv_camera_drawback,
            //     'cctv_camera_save'           => $request->cctv_camera_save,
            //     'cctv_camera_power_backup'   => $request->cctv_camera_power_backup,
            // );
            // DB::connection('mysql')->table('cctv_list')
            //     ->where('cctv_list_num', $request->cctv_list_num)
            //     ->update($data);
        
        return response()->json([
            'status'     => '200'
        ]);
            
    }
     
 
 }