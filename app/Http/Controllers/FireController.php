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
use App\Models\Fire_stock_month;
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
use App\Models\Fire_temp;
use App\Models\Fire_report;
use App\Models\Fire_count_nocheck;
use App\Models\Product_buy;
use App\Models\Fire_countcheck;
use App\Models\Article_status;
use App\Models\Fire_pramuan_sub;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Fire_check;
use App\Models\Fire;
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
use Str;
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


class FireController extends Controller
 { 
    public function support_system_dashboard(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        // $year_s = date('Y'); 
        // dd($y);
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        // Narmal
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                    // $dataset_s[] = [ 
                        // $count_color_qty         = $value->count_color;
                        // $count_color_percent     = 100 / $count_red * $value->count_color;
                        $count_red_percent          = 100 / $count_red_all * $value->count_red; 
                        $count_color_red_qty        = $value->count_red;
                        $count_red_alls             = $count_red_all;

                        $count_green_percent        = 100 / $count_green_all * $value->count_greens; 
                        $count_color_green_qty      = $value->count_greens;
                        $count_green_alls           = $count_green_all;
                    // ];
                }else {
                    $count_red_percent = '';
                    $count_color_red_qty = '';
                    $count_red_alls = '';
                    $count_green_percent = '';
                    $count_color_green_qty = '';
                    $count_green_alls = '';
                }
            }
            $datareport = DB::connection('mysql')->select(
                'SELECT
                    YEAR(f.check_date) as years,(YEAR(f.check_date)+543) as yearsthai,MONTH(f.check_date) as months,l.MONTH_NAME

                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as redten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N") as redfifteen
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N") as redtwenty 
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as greenten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") total_all
                    
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10") as Check_redten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15") as Check_redfifteen
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20") as Check_redtwenty
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Check_greenten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Checktotal_all

                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                FROM fire_check f
                LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(f.check_date)
                GROUP BY MONTH(f.check_date) 
            '); 

            $chart_location = DB::connection('mysql')->select(
                'SELECT a.air_location_id,a.air_location_name
              ,COUNT(DISTINCT al.air_list_id) as air_count_qty
                ,COUNT(a.air_location_id) as air_count_rep 
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_1 = "on")+
                -- (SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_2 = "on")+
                -- (SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_3 = "on")+
                -- (SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_4 = "on")+
                -- (SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_5 = "on")+ 
                -- (SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_orther = "on") as c_air_1  
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_1 = "on") as air_problems_1
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_2 = "on") as air_problems_2
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_3 = "on") as air_problems_3
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_4 = "on") as air_problems_4
                -- ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_5 = "on") as air_problems_5
                --  ,(SELECT COUNT(air_list_id) FROM air_repaire WHERE air_location_id = a.air_location_id AND air_problems_orther = "on") as air_problems_orther
                FROM air_list a 
                LEFT JOIN air_repaire al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = al.air_staff_id 
                WHERE al.repaire_date BETWEEN "'.$start.'" AND "'.$end.'" 
                GROUP BY a.air_location_id
                ORDER BY a.air_list_id DESC
            '); 
            
        return view('support_prs.fire.support_system_dashboard',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
            'count_color_red_qty'     =>  $count_color_red_qty,
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all,
            'count_red_percent'       =>  $count_red_percent,
            'datareport'              =>  $datareport,
            'count_green_percent'     =>  $count_green_percent,
            'count_color_green_qty'   =>  $count_color_green_qty,
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive,
            'chart_location'          =>  $chart_location,
        ]);
    }
    public function fire_dashboard(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire WHERE active="Y" ORDER BY fire_id DESC'); 

        return view('support_prs.fire.fire_dashboard',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function fire_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire ORDER BY fire_id ASC'); 
        // WHERE active="Y"
        return view('support_prs.fire.fire_main',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function fire_detail(Request $request, $id)
    {

        // $dataprint = Fire::where('fire_id', '=', $id)->first();
        // dd($dataprint->fire_num);
        // $data_count = Fire_check::where('fire_num','=', $id)->count();
        $data_count = Fire::where('fire_num','=', $id)->count();
        // dd($data_count);
        if ($data_count < 1) {

            $arnum = $id;
            $data_detail = Fire::where('fire_num', '=', $id)->first();

            $data_detail2 = Fire::where('fire_num', '=', 'F9999999')->first();
            $signat = $data_detail2->fire_img_base;
            // dd($signat);          
            $pic_fire = base64_encode(file_get_contents($signat));  
            
            return view('support_prs.fire.fire_detail_null', [
                // 'dataprint'    => $dataprint,
                'arnum'        => $arnum,
                'data_detail'  => $data_detail,
                'pic_fire'     => $pic_fire
            ]);
        } else {
            // $data_detail = Fire_check::leftJoin('users', 'fire_check.user_id', '=', 'users.id') 
            // ->leftJoin('fire', 'fire.fire_num', '=', 'fire_check.fire_num') 
            // ->where('fire_check.fire_num', '=', $id)
            // ->get();
            $data['data_detail'] = DB::connection('mysql')->select(
                'SELECT * from fire_check fc
                LEFT JOIN fire f ON f.fire_num = fc.fire_num
                LEFT JOIN users s ON s.id = fc.user_id 
                WHERE fc.fire_num ="'.$id.'" ORDER BY fire_check_id DESC LIMIT 5
                ');
            // dd($id);
            $data_detail_ = Fire::where('fire_num', '=', $id)->first();
            $data['signat'] = $data_detail_->fire_img_base;
            // $pic_fire = base64_encode(file_get_contents($signat));  
            // dd($signat);
            if ($data_detail_->fire_img_base != '') {
                $pic_fire            = base64_encode(file_get_contents($data_detail_->fire_img_base));
            }else {
                $pic_fire            = '';
            }

            // dd($pic_fire);
            return view('support_prs.fire.fire_detail',$data, [
                // 'dataprint'    => $dataprint,
                // 'data_detail'   => $data_detail,
                'data_detail_'  => $data_detail_,
                'pic_fire'      => $pic_fire,
                'id'            => $id
            ]);
        }
        
    }

    public function fire_add(Request $request)
    { 
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
        // $data['product_method']     = Product_method::get();
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get();
        // $data['product_brand']   = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.fire.fire_add', $data);
    }
    public function fire_save(Request $request)
    {
        $fire_num = $request->fire_num;
        $add = new Fire();
        $add->fire_year           = $request->fire_year;
        $add->fire_date           = $request->fire_date;
        $add->fire_num            = $fire_num;
        $add->fire_name           = $request->fire_name;
        $add->fire_price          = $request->fire_price;
        $add->active              = $request->active;
        $add->fire_location       = $request->fire_location; 
        $add->fire_size           = $request->fire_size;  
        $add->fire_color          = $request->fire_color; 
        $add->fire_date_pdd       = $request->fire_date_pdd; 
        $add->fire_date_exp       = $request->fire_date_exp; 

        $add->fire_qty            = '1'; 
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->fire_brand = $bransave->brand_name;
        } else { 
            $add->fire_brand = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $add->fire_unit = $unisave->unit_name;
        } else {         
            $add->fire_unit = '';
        }
 
        if ($request->hasfile('fire_imgname')) {
            $image_64 = $request->file('fire_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $fire_num. '.' . $extention;
            $request->fire_imgname->storeAs('fire', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $add->fire_img            = $filename;
            $add->fire_imgname        = $filename;
            // $add->fire_imgname        = $destinationPath . $filename;

            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } 
            $add->fire_img_base       = $file64;
            // $add->fire_img_base_name  = $file65;
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function fire_edit(Request $request,$id)
    {  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();
        $data_edit                  = Fire::where('fire_id', '=', $id)->first();
        // $signat                     = $data_edit->fire_img_base;
        // dd($signat); 
        // $pic_fire = base64_encode(file_get_contents($signat)); 
        // dd($pic_fire); 
        return view('support_prs.fire.fire_edit', $data,[
            'data_edit'    => $data_edit,
            // 'pic_fire'     => $pic_fire
        ]);
    }
    public function fire_update(Request $request)
    { 
        $id = $request->fire_id;
        // $update_base = Fire::find($id); 
        // $update_base->fire_img_base   = '';
        // $update_base->save();

        $fire_num = $request->fire_num;
       
        $update = Fire::find($id); 
        $update->fire_year           = $request->fire_year;
        $update->fire_date           = $request->fire_date;
        $update->fire_num            = $fire_num;
        $update->fire_name           = $request->fire_name;
        $update->fire_price          = $request->fire_price;
        $update->active              = $request->active;
        $update->fire_location       = $request->fire_location; 
        $update->fire_size           = $request->fire_size;  
        $update->fire_color          = $request->fire_color; 
        $update->fire_date_pdd       = $request->fire_date_pdd; 
        $update->fire_date_exp       = $request->fire_date_exp; 

        $update->fire_qty            = '1'; 
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->fire_brand = $bransave->brand_name;
        } else { 
            $update->fire_brand = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $update->fire_unit = $unisave->unit_name;
        } else {         
            $update->fire_unit = '';
        }
 
        if ($request->hasfile('fire_imgname')) {

            $description = 'storage/fire/' . $update->fire_imgname;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('fire_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $fire_num. '.' . $extention;
            $request->fire_imgname->storeAs('fire', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $update->fire_img            = $filename;
            $update->fire_imgname        = $filename;
            // $update->fire_imgname = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }
            // $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
            // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
  
            $update->fire_img_base       = $file64;
            // $update->fire_img_base_name  = $file65;
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }

    public function fire_destroy(Request $request,$id)
    {
        $del = Fire::find($id);  
        $description = 'storage/fire/'.$del->fire_imgname;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete(); 
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    }
    
    public function fire_report_day(Request $request)
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
                'SELECT c.fire_num,c.check_time,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$newDate.'" AND "'.$date.'"
                GROUP BY c.check_date,c.fire_num     
                ORDER BY c.check_date DESC         
                '); 
        } else {
            $datashow = DB::select(
                'SELECT c.fire_num,c.check_time,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY c.check_date,c.fire_num  
                ORDER BY c.check_date DESC               
            ');  
        }
         
        return view('support_prs.fire.fire_report_day',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
 
    public function fire_qrcode(Request $request, $id)
    {

            $dataprint = Fire::where('fire_id', '=', $id)->first();
            // $dataprint = Fire::where('fire_id', '=', $id)->get();

        return view('support_prs.fire.fire_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function fire_qrcode_all(Request $request)
    {  
            $dataprint = Fire::get();

        return view('support_prs.fire.fire_qrcode_all', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function fire_qrcode_detail(Request $request, $id)
    {

        $dataprint = Fire::where('fire_id', '=', $id)->first();
        $data_detail = Fire_check::where('fire_num', '=', $dataprint->fire_num) 
        // ->leftJoin('users', 'fire_check.user_id', '=', 'users.id')
        ->get(); 
        return view('support_prs.fire.fire_qrcode_detail', [
            'dataprint'    => $dataprint,
            'data_detail'  => $data_detail,
            'id'           => $id
        ]); 
    }
    public function fire_qrcode_detail_all(Request $request)
    {  
            $dataprint_main = Fire::get();
            // $dataprint_main = Fire::paginate();
            // $dataprint_main = Fire::paginate(12);
            // $dataprint = Fire::where('fire_id', '=', $id)->first();
            // foreach ($dataprint_main as $key => $value) {
            //     $data_detail  = Fire_check::where('fire_num', '=', $value->fire_num)->get();
            // }
            // $data_detail_ = $data_detail;
        // dd($dataprint_main);
        return view('support_prs.fire.fire_qrcode_detail_all', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function fire_pramuan_admin(Request $request)
    {  
        $dataprint_main = Fire::get();
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire WHERE active="Y" ORDER BY fire_id DESC'); 
            
        return view('support_prs.fire.fire_pramuan_admin', [
            'startdate'       => $startdate,
            'enddate'         => $enddate, 
            'datashow'        => $datashow,
        ]);

    }
    public function fire_pramuan(Request $request)
    {  
            $dataprint_main = Fire::get();
            $datashow = DB::select('SELECT * from fire_pramuan ORDER BY fire_pramuan_id ASC'); 

        return view('support_prs.fire.fire_pramuan', [
            'dataprint_main'  =>  $dataprint_main, 
            'datashow'        =>  $datashow, 
        ]);

    }
    public function fire_pramuan_save(Request $request)
    {
        // $this->validate($request, [
        //     'student_id'   => 'required',
        //     'book_id'      => 'required',
        //     'quantity'     => 'required',
        // ]);

        // $student_id    = $request->input('student[]');
        // $book_id       = $request->input('book[]');
        // $quantity      = $request->input('quantity[]');  

        // for ($i = 0; $i < count($student_id); $i++) {
        //     $data = [
        //         'student_id' => $student_id[$i],
        //         'book_id' => $book_id[$i],
        //         'quantity' => $quantity[$i], 
        //     ];
        //     Fire_pramuan_sub::create($data);
        // }
        dd($request->all());
        $checked_array = $request->fire_pramuan_id;
        foreach ($request->fire_pramuan_name as $key => $value) {
            if (in_array($request->fire_pramuan_name[$key],$checked_array)) {
                $add                    = new Fire_pramuan_sub;
                $add->fire_pramuan_name = $request->fire_pramuan_name[$key];
                $add->pramuan_5         = $request->pramuan_5[$key];
                $add->pramuan_4         = $request->pramuan_4[$key];
                $add->pramuan_3         = $request->pramuan_3[$key];
                $add->pramuan_2         = $request->pramuan_2[$key];
                $add->pramuan_1         = $request->pramuan_1[$key];
                $add->pramuan_0         = $request->pramuan_0[$key];
                $add->save();
            }
            // return response()->json([
            //     'status'    => '200'
            // ]);
        }


        // $id      = $request->join_selected_values;
        // $name      = $request->join_selected_name;        
        // $startcount = '1'; 
        // $row_range = Fire_pramuan::whereIn('fire_pramuan_id',explode(",",$id))->get();
        // $data = array();
        // foreach ($row_range as $row ) {
        //     $data[] = [
        //         'fire_pramuan_id'            =>$row->fire_pramuan_id,
        //         'fire_pramuan_name'          =>$row->fire_pramuan_name,
        //         'fire_pramuan_name_number'   =>$name,
        //     ]; 
        //     $startcount++;
        // }
        // $for_insert = array_chunk($data, length:1000);
        // foreach ($for_insert as $key => $data_) { 
        //     Fire_pramuan_sub::insert($data_);  
        // }



        // $subs = [];
        // $id      = $request->ids;
        // $data = Fire_pramuan::where('fire_pramuan_id',$id)->get();
        // foreach ($data as $index => $unit) {
        //     $subs[] = [ 
        //         "fire_pramuan_id" => $fire_pramuan_id[$index], 
        //         "unit_title" => $unit_title[$index]
        //     ];
        // }
        
        // $created = Fire_pramuan_sub::insert($subs);

        // dd($id);
        // $name    = $request->join_selected_name;
        // $iduser = Auth::user()->id;
        // $data = Fire_pramuan::where('fire_pramuan_id',$id)->get();
            // Fire_pramuan::whereIn('acc_debtor_id',explode(",",$id))
            //         ->update([
            //             'stamp' => 'Y'
            //         ]);
        // foreach ($data as $key => $value) {
        // //         $date = date('Y-m-d H:m:s'); 
        //         Fire_pramuan_sub::insert([
        //             'fire_pramuan_id'                 => $value->fire_pramuan_id,
        //             'fire_pramuan_sub_name'           => $value->fire_pramuan_name,
        //             // 'fire_pramuan_name_number'        => $name, 
        //         ]);
        
        // }
        // dd($data);
        // return response()->json([
        //     'status'    => '200'
        // ]);
    }

    public function fire_report_building(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,b.building_name 
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="10" AND fire_color = "red" AND active ="Y")	as red_10
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="15" AND fire_color = "red" AND active ="Y")	as red_15 
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="20" AND fire_color = "red" AND active ="Y")	as red_20
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="10" AND fire_color = "green" AND active ="Y")	as green_10
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND active ="Y") as total_all
                FROM fire a 
                LEFT JOIN building_data b ON b.building_id = a.building_id 
                WHERE active ="Y"
                GROUP BY a.building_id
                ORDER BY a.building_id ASC
        ');
         
        return view('support_prs.fire.fire_report_building',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
        ]);
    }
    public function fire_report_building_excel(Request $request)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $date          = date('Y-m-d');
        $data['ynow']  = date('Y') + 543;
        $months        = date('m'); 
        $newdays       = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek       = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate       = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear       = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,b.building_name 
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="10" AND fire_color = "red" AND active ="Y")	as red_10
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="15" AND fire_color = "red" AND active ="Y")	as red_15 
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="20" AND fire_color = "red" AND active ="Y")	as red_20
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND fire_size ="10" AND fire_color = "green" AND active ="Y") as green_10
                ,(SELECT COUNT(fire_id) FROM fire WHERE building_id = a.building_id AND active ="Y") as total_all
                FROM fire a 
                LEFT JOIN building_data b ON b.building_id = a.building_id 
                WHERE active ="Y"
                GROUP BY a.building_id
                ORDER BY a.building_id ASC
        ');
         
        return view('support_prs.fire.fire_report_building_excel',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
        ]);
    }
    public function fire_report_ploblems(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี      
        $iduser = Auth::user()->id;
        $yearnew = date('Y');
        $year_old = date('Y')-1;
        $months_old  = ('10');
        $startdate_b = (''.$year_old.'-10-01');
        $enddate_b = (''.$yearnew.'-09-30'); 

        if ($startdate != '') {
            $datashow = DB::select(
                'SELECT c.check_date,a.fire_num,a.fire_name,a.fire_location 
                    ,(SELECT fire_num FROM fire WHERE fire_id = b.fire_num_chang )as fire_chang_new,b.fire_chang_comment,b.fire_chang_date 
                    FROM fire a 
                    INNER JOIN fire_chang b ON b.fire_id = a.fire_id
                    LEFT JOIN fire_check c ON c.fire_id = a.fire_id 
                    WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.fire_num_chang IS NOT NULL
                    AND (c.fire_check_injection = "1" OR c.fire_check_joystick = "1" OR c.fire_check_body = "1" OR c.fire_check_gauge = "1" OR c.fire_check_drawback = "1")
                    GROUP BY a.fire_num
                    ORDER BY a.fire_id ASC
            ');
        } else {
            $datashow = DB::select(
                'SELECT c.check_date,a.fire_num,a.fire_name,a.fire_location 
                    ,(SELECT fire_num FROM fire WHERE fire_id = b.fire_num_chang )as fire_chang_new,b.fire_chang_comment,b.fire_chang_date 
                    FROM fire a 
                    INNER JOIN fire_chang b ON b.fire_id = a.fire_id
                    LEFT JOIN fire_check c ON c.fire_id = a.fire_id 
                    WHERE c.check_date BETWEEN "'.$startdate_b.'" AND "'.$enddate_b.'" AND b.fire_num_chang IS NOT NULL
                    AND (c.fire_check_injection = "1" OR c.fire_check_joystick = "1" OR c.fire_check_body = "1" OR c.fire_check_gauge = "1" OR c.fire_check_drawback = "1")
                    GROUP BY a.fire_num
                    ORDER BY a.fire_id ASC
            ');
        }
        
       
         
        return view('support_prs.fire.fire_report_ploblems',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
        ]);
    }
    public function fire_report_ploblems_excel(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $year_old = date('Y')-1;
        $months_old  = ('10');
        $startdate_b = (''.$year_old.'-10-01');
        $enddate_b = (''.$yearnew.'-09-30'); 
        $iduser = Auth::user()->id;
        // $datashow = DB::select(
        //     'SELECT c.check_date,a.fire_num,a.fire_name,a.fire_location 
        //         ,(SELECT fire_num FROM fire WHERE fire_id = b.fire_num_chang )as fire_chang_new,b.fire_chang_comment,b.fire_chang_date 
        //         FROM fire a 
        //         INNER JOIN fire_chang b ON b.fire_id = a.fire_id
        //         LEFT JOIN fire_check c ON c.fire_id = a.fire_id 
        //         GROUP BY a.fire_id
        //         ORDER BY a.fire_id ASC
        // ');
        if ($startdate != '') {
            $datashow = DB::select(
                'SELECT c.check_date,a.fire_num,a.fire_name,a.fire_location 
                    ,(SELECT fire_num FROM fire WHERE fire_id = b.fire_num_chang )as fire_chang_new,b.fire_chang_comment,b.fire_chang_date 
                    FROM fire a 
                    INNER JOIN fire_chang b ON b.fire_id = a.fire_id
                    LEFT JOIN fire_check c ON c.fire_id = a.fire_id 
                    WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.fire_num_chang IS NOT NULL
                    AND (c.fire_check_injection = "1" OR c.fire_check_joystick = "1" OR c.fire_check_body = "1" OR c.fire_check_gauge = "1" OR c.fire_check_drawback = "1")
                    GROUP BY a.fire_num
                    ORDER BY a.fire_id ASC
            ');
        } else {
            $datashow = DB::select(
                'SELECT c.check_date,a.fire_num,a.fire_name,a.fire_location 
                    ,(SELECT fire_num FROM fire WHERE fire_id = b.fire_num_chang )as fire_chang_new,b.fire_chang_comment,b.fire_chang_date 
                    FROM fire a 
                    INNER JOIN fire_chang b ON b.fire_id = a.fire_id
                    LEFT JOIN fire_check c ON c.fire_id = a.fire_id 
                    WHERE c.check_date BETWEEN "'.$startdate_b.'" AND "'.$enddate_b.'" AND b.fire_num_chang IS NOT NULL
                    AND (c.fire_check_injection = "1" OR c.fire_check_joystick = "1" OR c.fire_check_body = "1" OR c.fire_check_gauge = "1" OR c.fire_check_drawback = "1")
                    GROUP BY a.fire_num
                    ORDER BY a.fire_id ASC
            ');
        }
         
        return view('support_prs.fire.fire_report_ploblems_excel',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
        ]);
    }
    public function fire_report_month_old(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        // $year_s = date('Y'); 
        // dd($y);
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        // Narmal
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                    // $dataset_s[] = [ 
                        // $count_color_qty         = $value->count_color;
                        // $count_color_percent     = 100 / $count_red * $value->count_color;
                        $count_red_percent          = 100 / $count_red_all * $value->count_red; 
                        $count_color_red_qty        = $value->count_red;
                        $count_red_alls             = $count_red_all;

                        $count_green_percent        = 100 / $count_green_all * $value->count_greens; 
                        $count_color_green_qty      = $value->count_greens;
                        $count_green_alls           = $count_green_all;
                    // ];
                }else {
                    $count_red_percent = '';
                    $count_color_red_qty = '';
                    $count_red_alls = '';
                    $count_green_percent = '';
                    $count_color_green_qty = '';
                    $count_green_alls = '';
                }
            }
            $datareport = DB::connection('mysql')->select(
                'SELECT
                    YEAR(f.check_date) as years,(YEAR(f.check_date)+543) as yearsthai,MONTH(f.check_date) as months,l.MONTH_NAME

                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as redten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N") as redfifteen
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N") as redtwenty 
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as greenten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") total_all
                    
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10") as Check_redten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15") as Check_redfifteen
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20") as Check_redtwenty
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Check_greenten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Checktotal_all

                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                FROM fire_check f
                LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(f.check_date)
                GROUP BY MONTH(f.check_date) 
            '); 

            $chart_location = DB::connection('mysql')->select(
                'SELECT a.air_location_id,a.air_location_name
                    ,COUNT(DISTINCT al.air_list_id) as air_count_qty
                    ,COUNT(a.air_location_id) as air_count_rep 
                FROM air_list a 
                LEFT JOIN air_repaire al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = al.air_staff_id 
                WHERE al.repaire_date BETWEEN "'.$start.'" AND "'.$end.'" 
                GROUP BY a.air_location_id
                ORDER BY a.air_list_id DESC
            '); 
            
        return view('support_prs.fire.fire_report_month',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
            'count_color_red_qty'     =>  $count_color_red_qty,
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all,
            'count_red_percent'       =>  $count_red_percent,
            'datareport'              =>  $datareport,
            'count_green_percent'     =>  $count_green_percent,
            'count_color_green_qty'   =>  $count_color_green_qty,
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive,
            'chart_location'          =>  $chart_location,
        ]);
    }
    public function fire_report_month(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        // $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

     
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        // Narmal
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                   
                        $count_red_percent          = 100 / $count_red_all * $value->count_red; 
                        $count_color_red_qty        = $value->count_red;
                        $count_red_alls             = $count_red_all;
                        $count_green_percent        = 100 / $count_green_all * $value->count_greens; 
                        $count_color_green_qty      = $value->count_greens;
                        $count_green_alls           = $count_green_all;
                    // ];
                }else {
                    $count_red_percent = '';
                    $count_color_red_qty = '';
                    $count_red_alls = '';
                    $count_green_percent = '';
                    $count_color_green_qty = '';
                    $count_green_alls = '';
                }
            }
            
            // $datareport = DB::connection('mysql')->select(
            //     'SELECT a.months,a.years,a.years_th as yearsthai,b.month_name
            //     ,a.total_backup_r10,a.total_backup_r15,a.total_backup_r20
            //     ,a.total_red10,a.total_red15,a.total_red20,a.total_green10,a.total_all_qty
            //     FROM fire_stock_month a
            //     LEFT JOIN months b ON b.month_id = a.months
            //     GROUP BY a.months 
            // '); 
             $datareport = DB::connection('mysql')->select(
                'SELECT a.months,a.years,a.years_th as yearsthai,b.month_name
                ,a.total_backup_r10,a.total_backup_r15,a.total_backup_r20
                ,a.total_red10,a.total_red15,a.total_red20,a.total_green10,a.total_all_qty
                FROM fire_stock_month a
                LEFT JOIN months b ON b.month_id = a.months
                WHERE a.years_th = "'.$bg_yearnow.'"
                GROUP BY a.months 
            '); 

            $chart_location = DB::connection('mysql')->select(
                'SELECT a.air_location_id,a.air_location_name
                    ,COUNT(DISTINCT al.air_list_id) as air_count_qty
                    ,COUNT(a.air_location_id) as air_count_rep 
                FROM air_list a 
                LEFT JOIN air_repaire al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = al.air_staff_id 
                WHERE al.repaire_date BETWEEN "'.$start.'" AND "'.$end.'" 
                GROUP BY a.air_location_id
                ORDER BY a.air_list_id DESC
            '); 
            
        return view('support_prs.fire.fire_report_month',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
            'count_color_red_qty'     =>  $count_color_red_qty,
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all,
            'count_red_percent'       =>  $count_red_percent,
            'datareport'              =>  $datareport,
            'count_green_percent'     =>  $count_green_percent,
            'count_color_green_qty'   =>  $count_color_green_qty,
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive,
            'chart_location'          =>  $chart_location,
            'y'                       =>  $y,
        ]);
    }
    public function fire_stock_month(Request $request)
    {
        $startdate                = $request->startdate;
        $enddate                  = $request->enddate;
        $air_plan_month_id        = $request->air_plan_month_id;
        $date_now                 = date('Y-m-d');
        $years                    = date('Y') + 543;
        $yearnew_plus             = date('Y') + 544;
        $monthsnew_               = date('m'); 
        $monthsnew                = substr($monthsnew_,1,2);  
        $newdays                  = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek                  = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate                  = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 3 เดือน
        $newyear                  = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew                  = date('Y'); 
        $year_old                 = date('Y')-1;
        $months_old               = ('10');
        $startdate_b              = (''.$year_old.'-10-01');
        $enddate_b                = (''.$yearnew.'-09-30'); 
        $iduser                   = Auth::user()->id;
        $bgs_year                 = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow               = $bgs_year->leave_year_id;
       
        $data['datashow']         = DB::select('SELECT * FROM fire WHERE active = "Y" AND fire_year = "'.$bg_yearnow.'" ORDER BY fire_id ASC'); 
  
        $data['yearsshow']     = DB::select('SELECT * FROM budget_year WHERE active = "True" ORDER BY leave_year_id ASC'); 
        $data['data_stock']       = DB::select('SELECT * FROM fire_stock WHERE fire_year = "'.$bg_yearnow.'" ORDER BY fire_stock_id ASC'); 
        $data['fire_stock_month'] = DB::select('SELECT * FROM fire_stock_month a LEFT JOIN months b ON b.month_no = a.months ORDER BY fire_stock_month_id DESC'); 
        $data['months_data']   = DB::select('SELECT a.* FROM months a ORDER BY month_no ASC'); 
  
        // WHERE active = "Y" AND air_year = "'.$bg_yearnow.'"
            // $datashow  = DB::select(
            //     'SELECT b.*,c.air_repaire_typename 
            //         FROM air_plan_month b 
            //         LEFT JOIN air_repaire_type c ON c.air_repaire_type_id = b.air_repaire_type_id 
            //         WHERE b.years BETWEEN "'.$years.'" AND "'.$yearnew_plus.'"
            // '); 
        // } 
        return view('support_prs.fire.fire_stock_month',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'bg_yearnow'       => $bg_yearnow, 
        ]);
    }
     public function fire_report_month_chang(Request $request,$months,$years)
    {  
        $datafire = DB::select(
            'SELECT f.fire_id,fc.fire_num,fc.fire_chang_date,f.fire_num as chang,f.fire_size,f.fire_color,f.fire_location,f.building_name,CONCAT(s.fname," ",s.lname) as ptname
            FROM fire f
            INNER JOIN fire_chang fc ON fc.fire_num_chang = f.fire_id
            INNER JOIN users s ON s.id = fc.userid
            WHERE MONTH(fc.fire_chang_date) = "'.$months.'" AND year(fc.fire_chang_date) = "'.$years.'"  
        '); 
        
        return view('support_prs.fire.fire_report_month_chang',[
            // 'datareport'     => $datareport,
            'datafire'       => $datafire, 
        ]);
    }  
    public function fire_stock_month_save(Request $request)
    {   
        $date_now        = date('Y-m-d');
        $iduser          = Auth::user()->id;
        $month_no1       = $request->month_no1;  
        $leave_year_id1  = $request->leave_year_id1;  
        $bgs_year        = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow      = $bgs_year->leave_year_id;
    
        $dataget         = DB::select(
            'SELECT COUNT(DISTINCT fire_num) as total_all_qty
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "red" AND fire_size = "10" AND fire_year = "'.$bg_yearnow.'") as total_backup_r10
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "red" AND fire_size = "15" AND fire_year = "'.$bg_yearnow.'") as total_backup_r15
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "red" AND fire_size = "20" AND fire_year = "'.$bg_yearnow.'") as total_backup_r20
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "green" AND fire_size = "10" AND fire_year = "'.$bg_yearnow.'") as total_backup_g10
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "green" AND fire_size = "15" AND fire_year = "'.$bg_yearnow.'") as total_backup_g15
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "Y" AND fire_color = "green" AND fire_size = "20" AND fire_year = "'.$bg_yearnow.'") as total_backup_g20
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "red" AND fire_size = "10" AND fire_year = "'.$bg_yearnow.'") as total_red10
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "red" AND fire_size = "15" AND fire_year = "'.$bg_yearnow.'") as total_red15
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "red" AND fire_size = "20" AND fire_year = "'.$bg_yearnow.'") as total_red20
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "green" AND fire_size = "10" AND fire_year = "'.$bg_yearnow.'") as total_green10
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "green" AND fire_size = "15" AND fire_year = "'.$bg_yearnow.'") as total_green15
            ,(SELECT COUNT(DISTINCT fire_num) FROM fire WHERE active = "Y" AND fire_backup = "N" AND fire_color = "green" AND fire_size = "20" AND fire_year = "'.$bg_yearnow.'") as total_green20
            FROM fire WHERE active = "Y" AND fire_year = "'.$bg_yearnow.'"  
        ');     
        foreach ($dataget as $row ) {
                $check = Fire_stock_month::where('months',$month_no1)->where('years',$leave_year_id1-543)->count();
                if ($check > 0) {  
                } else {
                    Fire_stock_month::insert([
                        'months'            => $month_no1,
                        'years'             => $leave_year_id1-543,
                        'years_th'          => $leave_year_id1,
                        'total_all_qty'     => $row->total_all_qty,

                        'total_backup_r10'  => $row->total_backup_r10,
                        'total_backup_r15'  => $row->total_backup_r15,
                        'total_backup_r20'  => $row->total_backup_r20,

                        'total_backup_g10'  => $row->total_backup_g10,
                        'total_backup_g15'  => $row->total_backup_g15,
                        'total_backup_g20'  => $row->total_backup_g20,

                        'total_red10'       => $row->total_red10,
                        'total_red15'       => $row->total_red15,
                        'total_red20'       => $row->total_red20,

                        'total_green10'     => $row->total_green10,
                        'total_green15'     => $row->total_green15,
                        'total_green20'     => $row->total_green20,
                        'datesave'          => $date_now,
                        'userid'            => $iduser,  
                    ]);
                }  
        } 
       
        return response()->json([
            'status'     => '200'
        ]);  
    }
    public function support_system_check_old(Request $request,$months,$years)
    {
        $datenow = date('Y-m-d'); 
        Fire_countcheck::truncate();
        $check_d = DB::connection('mysql')->select('SELECT COUNT(DISTINCT fire_num) as fire_num FROM fire_report WHERE months = "'.$months.'" AND years = "'.$years.'"');
        foreach ($check_d as $key => $va_re) {
            $ddt  = $va_re->fire_num;
        }

        if ($ddt > 0) {
            # code...
        } else { 
            // $monthsnew          = substr($months,1,2); 
            // dd($months);
            $datareport = DB::connection('mysql')->select('SELECT fire_id,fire_num,fire_name,check_date FROM fire_check WHERE month(check_date) = "'.$months.'" AND year(check_date) = "'.$years.'"');      
            foreach ($datareport as $key => $value) {    
                // $check1 = Fire_countcheck::where('fire_id',$value->fire_id)->where('check_date',$value->check_date)->count();
                // if ($check1 >0) { 
                // } else {
                   
                    Fire_countcheck::insert([
                        'fire_id'     => $value->fire_id,
                        'fire_num'    => $value->fire_num,
                        'fire_name'   => $value->fire_name,
                        'check_date'  => $value->check_date,
                        'months'      => $months,
                        'years'       => $years
                    ]); 
                // } 
            } 
            // dd($months);
            $insert_1 = Fire_countcheck::get();
            foreach ($insert_1 as $key => $val) {
                $check_insert = Fire_report::where('fire_id',$val->fire_id)->where('check_date',$val->check_date)->count();
                if ($check_insert > 0) { 
                } else {
                    Fire_report::insert([
                        'fire_id'       => $val->fire_id,
                        'fire_num'      => $val->fire_num, 
                        'check_date'    => $val->check_date,
                        'months'        => $months,
                        'years'         => $years,
                        'check_status'  => 'Y'
                    ]); 
                } 
            } 
            // dd($months);
            Fire_count_nocheck::truncate();
            $datanocheck = DB::select(
                'SELECT f.fire_id,f.fire_num,f.fire_name,f.fire_size,f.fire_color,f.fire_location 
                    FROM fire f 
                    LEFT JOIN fire_countcheck fcc ON fcc.fire_num = f.fire_num 
                    WHERE fcc.fire_num IS NULL AND f.active = "Y"
                    GROUP BY f.fire_num 
                '); 
            foreach ($datanocheck as $key => $value2) {   
                    Fire_count_nocheck::insert([
                        'fire_id'     => $value2->fire_id,
                        'fire_num'    => $value2->fire_num,
                        'months'      => $months,
                        'years'       => $years
                    ]);  
            } 
            $insert_2 = Fire_count_nocheck::get();
            foreach ($insert_2 as $key => $val2) {
                $check_insert2 = Fire_report::where('fire_id',$val2->fire_id)->where('months',$months)->where('years',$years)->count();
                if ($check_insert2 > 0) { 
                } else {
                    Fire_report::insert([
                        'fire_id'        => $val2->fire_id,
                        'fire_num'       => $val2->fire_num,  
                        'months'         => $months,
                        'years'          => $years,
                        'check_status'   => 'N'
                    ]); 
                } 
            }      
        
        }
        // $datafire = DB::select(
        //     'SELECT f.fire_num,f.fire_name,f.fire_size,f.fire_color,f.fire_location,fc.check_date,u.fname,u.lname
        //         FROM fire f
        //         LEFT JOIN fire_check fc ON fc.fire_id = f.fire_id
        //         LEFT JOIN users u ON u.id = fc.user_id
        //         LEFT JOIN fire_countcheck fcc ON fcc.fire_num = f.fire_num 
        //         WHERE fcc.fire_num IS NOT NULL AND f.active = "Y"
        //         GROUP BY f.fire_num 
        // '); 
        $datafire = DB::select(
            'SELECT fc.fire_id,fc.fire_num,fc.fire_name,fc.check_date,f.fire_size,f.fire_color,f.fire_location ,u.fname,u.lname,m.month_name
            FROM fire_report r 
            LEFT JOIN fire_check fc ON fc.fire_id = r.fire_id
            LEFT JOIN users u ON u.id = fc.user_id
            INNER JOIN fire f ON f.fire_id = r.fire_id
            INNER JOIN months m ON m.month_id = r.months
            WHERE r.check_status = "Y" 
            AND r.months = "'.$months.'" 
            AND r.years = "'.$years.'" 
            GROUP BY r.fire_id 
        '); 
        $data_months_ = DB::select('SELECT * FROM months WHERE month_id = "'.$months.'"'); 
        foreach ($data_months_ as $key => $value_m) {
            $data['month_name'] = $value_m->month_name;
        }
        
        return view('support_prs.support_system_check',$data,[
            // 'datareport'     => $datareport,
            'datafire'       => $datafire, 
        ]);
    }  
    public function support_system_check(Request $request,$months,$years)
    {
        $datenow = date('Y-m-d'); 
         
        $datafire = DB::select(
            'SELECT fc.fire_id,fc.fire_year,fc.fire_num,fc.fire_name,fc.check_date,f.fire_size,f.fire_color,f.fire_location ,u.fname,u.lname
 
            FROM fire_check fc  
            LEFT JOIN users u ON u.id = fc.user_id
            INNER JOIN fire f ON f.fire_id = fc.fire_id 
            WHERE MONTH(fc.check_date)= "'.$months.'"
            AND fc.fire_year = "'.$years.'"  AND f.fire_backup = "N"
            GROUP BY fc.fire_id 
        '); 
        $data_months_ = DB::select('SELECT * FROM months WHERE month_id = "'.$months.'"'); 
        foreach ($data_months_ as $key => $value_m) {
            $data['month_name'] = $value_m->month_name;
        }
        
        return view('support_prs.support_system_check',$data,[ 
            'datafire'       => $datafire, 
        ]);
    }   
    public function support_system_nocheck(Request $request,$months,$years)
    {
        Fire_temp::truncate();
        $datenow = date('Y-m-d'); 
        $datafire_check = DB::select(
            'SELECT fc.fire_id,fc.fire_year,fc.fire_num,fc.fire_name,fc.check_date,f.fire_size,f.fire_color,f.fire_location ,u.fname,u.lname 
            FROM fire_check fc  
            LEFT JOIN users u ON u.id = fc.user_id
            LEFT JOIN fire f ON f.fire_id = fc.fire_id 
            WHERE MONTH(fc.check_date)= "'.$months.'"
            AND f.fire_year = "'.$years.'" 
            GROUP BY f.fire_id 
        '); 
        // AND f.fire_backup = "N"
        foreach ($datafire_check as $key => $value) {
            Fire_temp::insert([
                'check_date'   => $value->check_date,
                'fire_id'      => $value->fire_id,
                'fire_num'     => $value->fire_num,
                'fire_name'    => $value->fire_name,
                'fire_size'    => $value->fire_size, 
            ]);
        }
          
        $datafire = DB::select(
                'SELECT fc.fire_id,f.fire_num,f.fire_name,f.fire_size,f.fire_color,f.fire_location,fc.check_date 
                FROM fire f  
                LEFT JOIN fire_temp fc ON fc.fire_id = f.fire_id 
                WHERE f.fire_year ="'.$years.'"  AND fc.fire_id IS NULL
              
             
                GROUP BY f.fire_id 
        '); 
        // AND f.active ="Y" 
        // AND f.fire_backup = "N"
        $data_months_ = DB::select('SELECT * FROM months WHERE month_id = "'.$months.'"'); 
        foreach ($data_months_ as $key => $value_m) {
            $data['month_name'] = $value_m->month_name;
        }
        return view('support_prs.support_system_nocheck',$data,[
            // 'datareport'     => $datareport,
            'datafire'       => $datafire, 
        ]);
    }
    public function fire_insert_all(Request $request)
    {  
            $date                       = date('Y-m-d'); 
            $newweek                    = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
            $newDate                    = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
            $newyear                    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
            $yearnew                    = date('Y')+1;
            $yearold                    = date('Y')-1;
            $start                      = (''.$yearold.'-10-01');
            $end                        = (''.$yearnew.'-09-30'); 
            $years                      = date('Y');
            $months                     = date('m'); 
            $monthsnew                  = substr($months,1,2);
            $data['fire_main']          = Fire::get();
            $datashow                   = DB::select('SELECT * from fire_pramuan ORDER BY fire_pramuan_id ASC'); 
            $data['product_brand']      = DB::table('product_brand')->get();
            $data['medical_typecat']    = DB::table('medical_typecat')->get();
            $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
            $bg_yearnow                 = $bgs_year->leave_year_id;
            // dd($months);
            // Fire_countcheck::truncate();
            // $check_d = DB::connection('mysql')->select('SELECT COUNT(DISTINCT fire_num) as fire_num FROM fire_report WHERE months = "'.$months.'" AND years = "'.$years.'"');
            // foreach ($check_d as $key => $va_re) {
            //     $ddt  = $va_re->fire_num;
            // }

            // if ($ddt > 0) {
            //     # code...
            // } else {         
            //     $datareport = DB::connection('mysql')->select('SELECT fire_id,fire_num,fire_name,check_date FROM fire_check WHERE month(check_date) = "'.$months.'" AND year(check_date) = "'.$years.'"');      
            //     foreach ($datareport as $key => $value) {    
            //             Fire_countcheck::insert([
            //                 'fire_id'     => $value->fire_id,
            //                 'fire_num'    => $value->fire_num,
            //                 'fire_name'   => $value->fire_name,
            //                 'check_date'  => $value->check_date,
            //                 'months'      => $months,
            //                 'years'       => $years
            //             ]); 
            //         // } 
            //     }             
            //     $insert_1 = Fire_countcheck::get();
            //     foreach ($insert_1 as $key => $val) {
            //         $check_insert = Fire_report::where('fire_id',$val->fire_id)->where('check_date',$val->check_date)->count();
            //         if ($check_insert > 0) { 
            //         } else {
            //             Fire_report::insert([
            //                 'fire_id'       => $val->fire_id,
            //                 'fire_num'      => $val->fire_num, 
            //                 'check_date'    => $val->check_date,
            //                 'months'        => $months,
            //                 'years'         => $years,
            //                 'check_status'  => 'Y'
            //             ]); 
            //         } 
            //     }     
            //     Fire_count_nocheck::truncate();
            //     $datanocheck = DB::select(
            //         'SELECT f.fire_id,f.fire_num,f.fire_name,f.fire_size,f.fire_color,f.fire_location 
            //             FROM fire f 
            //             LEFT JOIN fire_countcheck fcc ON fcc.fire_num = f.fire_num 
            //             WHERE fcc.fire_num IS NULL AND f.active = "Y"
            //             GROUP BY f.fire_num 
            //         '); 
            //     foreach ($datanocheck as $key => $value2) {   
            //             Fire_count_nocheck::insert([
            //                 'fire_id'     => $value2->fire_id,
            //                 'fire_num'    => $value2->fire_num,
            //                 'months'      => $months,
            //                 'years'       => $years
            //             ]);  
            //     } 
            //     $insert_2 = Fire_count_nocheck::get();
            //     foreach ($insert_2 as $key => $val2) {
            //         $check_insert2 = Fire_report::where('fire_id',$val2->fire_id)->where('months',$months)->where('years',$years)->count();
            //         if ($check_insert2 > 0) { 
            //         } else {
            //             Fire_report::insert([
            //                 'fire_id'        => $val2->fire_id,
            //                 'fire_num'       => $val2->fire_num,  
            //                 'months'         => $months,
            //                 'years'          => $years,
            //                 'check_status'   => 'N'
            //             ]); 
            //         } 
            //     }      
            
            // }
            // $data['data_show']          = DB::select('SELECT * from fire_check WHERE MONTH(check_date) = "'.$months.'"'); 
            // $check_d = DB::connection('mysql')->select('SELECT COUNT(DISTINCT fire_num) as fire_num FROM fire_report WHERE months = "'.$months.'" AND years = "'.$years.'"');
            // foreach ($check_d as $key => $va_re) {
            //     $ddt  = $va_re->fire_num;
            // }
            // $insert_2 = Fire_count_nocheck::get();
            // foreach ($insert_2 as $key => $val2) {
            //     $check_insert2 = Fire_report::where('fire_id',$val2->fire_id)->where('months',$months)->where('years',$years)->count();
            //     if ($check_insert2 > 0) { 
            //     } else {
            //         // Fire_report::insert([
            //         //     'fire_id'        => $val2->fire_id,
            //         //     'fire_num'       => $val2->fire_num,  
            //         //     'months'         => $months,
            //         //     'years'          => $years,
            //         //     'check_status'   => 'N'
            //         // ]); 
            //     } 
            // }   
            // dd($months);
            // $data['data_show'] = DB::select(
            //     'SELECT r.fire_report_id,fc.fire_id,f.fire_num,f.fire_name,fc.check_date,f.fire_size,f.fire_color,f.fire_location ,u.fname,u.lname,m.month_name
            //     FROM fire_report r 
            //     LEFT JOIN fire_check fc ON fc.fire_id = r.fire_id
            //     LEFT JOIN users u ON u.id = fc.user_id
            //     INNER JOIN fire f ON f.fire_id = r.fire_id
            //     INNER JOIN months m ON m.month_id = r.months
            //     WHERE r.check_status = "N" 
            //     AND r.months = "'.$monthsnew.'" 
            //     AND r.years = "'.$years.'" 
            //     GROUP BY r.fire_id ORDER BY r.fire_num ASC
            // ');    
            $data_date         = DB::select('SELECT * FROM fire_check ORDER BY check_date DESC LIMIT 1');  
            foreach ($data_date as $key => $value) {
                $data['last_date'] = $value->check_date;
                $data['check_time'] = $value->check_time;
            }
            $data['data_show'] = DB::select(
                'SELECT f.fire_id,f.fire_num,f.fire_size,f.fire_color,f.fire_location,f.fire_name,fc.check_date 
                FROM fire f  
                LEFT JOIN fire_check fc ON fc.fire_id = f.fire_id 
                
                WHERE f.fire_year = "'.$bg_yearnow.'"
                GROUP BY f.fire_num
               ORDER BY f.fire_id ASC 
            ');   
            // fc.check_date,
            // WHERE MONTH(fc.check_date) = "'.$months.'" AND 
            // ORDER BY f.fire_id ASC
            // WHERE fc.check_date IS NULL 
            // f.active = "N"
        return view('support_prs.fire.fire_insert_all',$data, [
            // 'dataprint_main'  =>  $dataprint_main, 
            'datashow'        =>  $datashow, 
        ]); 
    }
    public function fire_insert_stamall(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Fire::whereIn('fire_id',explode(",",$id))->get(); 
        foreach ($data as $key => $value) {
                $date                       = date('Y-m-d');
                $datetime                   = date('Y-m-d H:m:s');
                $years                      = date('Y');
                $months                     = date('m'); 
                $m = date('H');
                $mm = date('H:m:s');
                $datefull = date('Y-m-d H:m:s');
                $monthsnew                  = substr($months,1,2); 
                // $fires_                     = Fire_report::where('fire_report_id',$id)->first();
                // $fireids                    = $fires_->fire_id;
                $check_                     = DB::select('SELECT COUNT(fire_id) as fire_id FROM Fire_check WHERE fire_id = "'.$value->fire_id.'" AND MONTH(check_date) = "'.$months.'"'); 
                foreach ($check_ as $key => $val) {
                    $check  = $val->fire_id;
                }
                if ($check > 0) { 
                } else {
                    $fire_         = Fire::where('fire_id',$value->fire_id)->first();
                    $fireid        = $fire_->fire_id;
                    $firenum       = $fire_->fire_num;

                    $fire_data_       = Fire::where('fire_id',$fireid)->first();
                    $fire_year        = $fire_data_->fire_year;
                    $fire_name        = $fire_data_->fire_name;
                    $fire_size        = $fire_data_->fire_size;
                    $fire_color       = $fire_data_->fire_color;
                    $fire_location    = $fire_data_->fire_location;
                    $fire_backup      = $fire_data_->fire_backup;

                    Fire_check::insert([
                            'fire_id'                    => $fireid,
                            'fire_year'                  => $fire_year,
                            'fire_num'                   => $firenum,
                            'fire_name'                  => $fire_name,
                            'fire_size'                  => $fire_size,
                            'fire_backup'                => $fire_backup,
                            'fire_check_color'           => $fire_color,
                            'fire_check_location'        => $fire_location,
                            'check_date'                 => $date,
                            'check_time'                 => $mm,
                            'fire_check_injection'       => '0',
                            'fire_check_injection_name'  => 'ปกติ',
                            'fire_check_joystick'        => '0',
                            'fire_check_joystick_name'   => 'ปกติ',
                            'fire_check_body'            => '0',
                            'fire_check_body_name'       => 'ปกติ',
                            'fire_check_gauge'           => '0',
                            'fire_check_gauge_name'      => 'ปกติ',
                            'fire_check_drawback'        => '0',
                            'fire_check_drawback_name'   => 'ปกติ',
                            'fire_active'                => 'Y',
                            'user_id'                    => $iduser 
                    ]);


                    Fire_report::where('fire_report_id',$value->fire_report_id)->delete();

                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function fire_qrcode_all๘๘๘๘(Request $request)
    {
      
        $dataprint = Fire::get();

        // $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate('string'));
        // $pdf = PDF::loadView('main.inventory.view_pdf', compact('qrcode'));
        // return $pdf->stream();
    
        $pdf = PDF::loadView('support_prs.fire.fire_qrcode_all',['dataprint'  =>  $dataprint]);
        return @$pdf->stream();
    }
    

 }