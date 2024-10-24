<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Wh_log;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective;
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Wh_stock_export;
use App\Models\Wh_stock_dep;
use App\Models\Wh_stock_sub;
use App\Models\Wh_request;
use App\Models\Wh_request_sub;
use App\Models\Article_status;
use App\Models\Air_supplies;
use App\Models\Wh_recieve_sub;
use App\Models\Wh_stock;
use App\Models\Wh_recieve;
use App\Models\Wh_pay;
use App\Models\Wh_pay_sub;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Warehouse_inven;
use App\Models\Warehouse_inven_person;
use App\Models\Warehouse_rep;
use App\Models\Warehouse_rep_sub;
use App\Models\Warehouse_recieve;
use App\Models\Warehouse_recieve_sub;
use App\Models\Warehouse_stock;
use App\Models\Wh_unit;
use App\Models\Wh_product;
use Illuminate\Support\Facades\File;
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Intervention\Image\ImageManagerStatic as Image;

class WhUserController extends Controller
{
    public static function ref_request_number()
    {
        $year = date('Y');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $maxnumber     = DB::table('wh_request')->max('wh_request_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('wh_request')->where('wh_request_id', '=', $maxnumber)->first();
            if ($refmax->request_no != '' ||  $refmax->request_no != null) {
                $maxref = substr($refmax->request_no, -7) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 8, "0", STR_PAD_LEFT);
        } else {
            $ref = '00000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -4);
        $ynew   = substr($bg_yearnow,2,2); 
        $refnumber = $ynew.''.$ref;
        return $refnumber;


    }
    public function wh_dashboard(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $data['q'] = $request->query('q');
        $query = User::select('users.*')
            ->where(function ($query) use ($data) {
                $query->where('pname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('fname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('lname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('tel', 'like', '%' . $data['q'] . '%');
                $query->orwhere('username', 'like', '%' . $data['q'] . '%');
            });
        $data['users'] = $query->orderBy('id', 'DESC')->paginate(10);
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();

        return view('wh.wh_dashboard', $data);
    }
    public function wh_plan(Request $request)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
        $data['q']  = $request->query('q');
        $query = User::select('users.*')
            ->where(function ($query) use ($data) {
                $query->where('pname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('fname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('lname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('tel', 'like', '%' . $data['q'] . '%');
                $query->orwhere('username', 'like', '%' . $data['q'] . '%');
            });
        $data['users']              = $query->orderBy('id', 'DESC')->paginate(10);
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_product']         = Wh_product::get();
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name ,a.active
                ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty
                ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name
                ,e.*
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy3.'") plan_65
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy2.'") plan_66
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy1.'") plan_67
                FROM wh_product a
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_plan e ON e.pro_id = a.pro_id
            WHERE a.active ="Y" 
            GROUP BY a.pro_id
        ');
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();

        return view('wh.wh_plan', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }
    public function wh_sub_main(Request $request)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
        $id         =  Auth::user()->dep_subsubtrueid;
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_product']         = Wh_product::get();
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data['wh_stock_sub']         = DB::select(
            'SELECT e.stock_list_subid,f.DEPARTMENT_SUB_SUB_NAME,a.pro_year,a.pro_id,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
                ,(SELECT SUM(s.qty_pay) FROM wh_stock_dep_sub s LEFT JOIN wh_stock_dep sm ON sm.wh_stock_dep_id = s.wh_stock_dep_id WHERE s.pro_id = e.pro_id AND s.stock_sub_year ="'.$bg_yearnow.'" AND s.stock_list_subid ="'.$id.'" AND sm.active ="REPEXPORT") AS stock_rep
                ,(SELECT SUM(s.one_price) FROM wh_stock_dep_sub s LEFT JOIN wh_stock_dep sm ON sm.wh_stock_dep_id = s.wh_stock_dep_id WHERE s.pro_id = e.pro_id AND s.stock_sub_year ="'.$bg_yearnow.'" AND s.stock_list_subid ="'.$id.'" AND sm.active ="REPEXPORT") AS sum_one_price
                ,(SELECT SUM(s.total_price) FROM wh_stock_dep_sub s LEFT JOIN wh_stock_dep sm ON sm.wh_stock_dep_id = s.wh_stock_dep_id WHERE s.pro_id = e.pro_id AND s.stock_sub_year ="'.$bg_yearnow.'" AND s.stock_list_subid ="'.$id.'" AND sm.active ="REPEXPORT") AS sum_stock_price  
                ,IFNULL(stock_pay,"0") as stock_pay
                ,a.active ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name
                FROM wh_stock_sub e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN department_sub_sub f ON f.DEPARTMENT_SUB_SUB_ID = e.stock_list_subid
                WHERE a.active ="Y" 
                AND e.stock_list_subid ="'.$id.'" AND e.stock_year ="'.$bg_yearnow.'"
                GROUP BY e.pro_id
        ');
        
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        // $data_main             = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$id)->first();
        $data_main             = DB::select(
            'SELECT a.DEPARTMENT_NAME,b.DEPARTMENT_SUB_NAME,c.DEPARTMENT_SUB_SUB_NAME 
            FROM department a
            LEFT JOIN department_sub b ON b.DEPARTMENT_ID = a.DEPARTMENT_ID
            LEFT JOIN department_sub_sub c ON c.DEPARTMENT_SUB_ID = b.DEPARTMENT_SUB_ID
            WHERE c.DEPARTMENT_SUB_SUB_ID = "'.$id.'"
        ');
        foreach ($data_main as $key => $value) {
            $data['stock_bigname']    = $value->DEPARTMENT_NAME;
            $data['stock_name']       = $value->DEPARTMENT_SUB_SUB_NAME;
        }
 
        return view('wh_user.wh_sub_main', $data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate,
            'bg_yearnow'  => $bg_yearnow,
        ]);
    }
    public function wh_sub_main_rp(Request $request)
    {
        $startdate           = $request->datepicker;
        $enddate             = $request->datepicker2;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $months              = date('m');
        $year                = date('Y');
        $newday              = date('Y-m-d', strtotime($datenow . ' -5 Day')); //ย้อนหลัง 1 สัปดาห์
        
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','1')->get();
        $dep_subsubtrueid           =  Auth::user()->dep_subsubtrueid;
        $data['m']                  = date('H');
        $data['mm']                 = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $data['monthsnew']          = substr($months,1,2); 
        
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
            ,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price
            ,a.active
                ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty
                ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

                FROM wh_stock e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
            GROUP BY e.pro_id
        ');
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data['wh_request']         = DB::select(
            'SELECT r.wh_request_id,r.year,r.request_date,r.request_time,r.request_no,r.stock_list_id,r.active
            ,s.stock_list_name
            ,(SELECT DEPARTMENT_SUB_SUB_NAME FROM department_sub_sub WHERE DEPARTMENT_SUB_SUB_ID = r.stock_list_subid) as DEPARTMENT_SUB_SUB_NAME
            ,r.request_po,concat(u.fname," ",u.lname) as ptname 
            ,(SELECT SUM(total_price) FROM wh_request_sub WHERE wh_request_id = r.wh_request_id) as total_price
            ,(SELECT concat(uu.fname," ",uu.lname) FROM users uu LEFT JOIN wh_stock_export w ON w.user_export_send = uu.id WHERE wh_request_id = r.wh_request_id) as ptname_send
            ,(SELECT concat(uuu.fname," ",uuu.lname) FROM users uuu LEFT JOIN wh_stock_export ww ON ww.user_export_rep = uuu.id WHERE wh_request_id = r.wh_request_id) as ptname_rep
            FROM wh_request r 
            LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id 
            LEFT JOIN users u ON u.id = r.user_request  
            WHERE r.stock_list_subid ="'.$dep_subsubtrueid.'"         
            ORDER BY r.wh_request_id DESC
        ');

        $data_main             = DB::select(
            'SELECT a.DEPARTMENT_NAME,b.DEPARTMENT_SUB_NAME,c.DEPARTMENT_SUB_SUB_NAME 
            FROM department a
            LEFT JOIN department_sub b ON b.DEPARTMENT_ID = a.DEPARTMENT_ID
            LEFT JOIN department_sub_sub c ON c.DEPARTMENT_SUB_ID = b.DEPARTMENT_SUB_ID
            WHERE c.DEPARTMENT_SUB_SUB_ID = "'.$dep_subsubtrueid.'"
        ');
        foreach ($data_main as $key => $value) {
            $data['stock_bigname']    = $value->DEPARTMENT_NAME;
            $data['stock_name']       = $value->DEPARTMENT_SUB_SUB_NAME;
        }
        
        return view('wh_user.wh_sub_main_rp',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }
     
    public function wh_request_save(Request $request)
    {
        // $year                = date('Y')+ 543;
        // $ynew             = substr($request->bg_yearnow,2,2); 
        $subsubid         =  Auth::user()->dep_subsubtrueid;
        Wh_request::insert([
            'year'                 => $request->bg_yearnow,
            'request_date'         => $request->request_date,
            'request_time'         => $request->request_time, 
            'request_no'           => $request->request_no,
            'stock_list_id'        => $request->stock_list_id,
            'stock_list_subid'     => $subsubid, 
            'user_request'         => Auth::user()->id
        ]);
        return response()->json([ 
            'status'    => '200'
        ]);
    }
    public function wh_request_edit(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
      
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get(); 
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_edit             = DB::table('wh_request')->where('wh_request_id','=',$id)->first();
        // $data['stock_name']    = $data_main->stock_list_name;

        return view('wh_user.wh_request_edit', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
            'data_edit'  => $data_edit,
        ]);
    }
    public function wh_request_update(Request $request)
    {
        $id            = $request->wh_request_id;
        // $ynew          = substr($request->bg_yearnow,2,2); 
        Wh_request::where('wh_request_id',$id)->update([
            'year'                 => $request->bg_yearnow,
            'request_date'         => $request->request_date,
            'request_time'         => $request->request_time, 
            'request_no'           => $request->request_no,
            'stock_list_id'        => $request->stock_list_id, 
            'user_request'         => Auth::user()->id
        ]);
        return response()->json([ 
            'status'    => '200'
        ]);
    }
    public function wh_request_addsub(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
      
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get(); 
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow                 = $bgs_year->leave_year_id;
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get(); 
       

        $data_edit                  = DB::table('wh_request')->where('wh_request_id','=',$id)->first();
        $data['wh_request_id']      = $data_edit->wh_request_id;
        $data['data_year']          = $data_edit->year;
        $datastock_list_id          = $data_edit->stock_list_id;
        $data['stock_list_id']      = $data_edit->stock_list_id;
        $subsubid                   =  Auth::user()->dep_subsubtrueid;
        $data_wh_stock_list         = DB::table('wh_stock_list')->where('stock_list_id',$datastock_list_id)->first();
        $data['stock_name']         = $data_wh_stock_list->stock_list_name;

        $data_debsubsub             = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$subsubid)->first();
        $data['supsup_id']          = $data_debsubsub->DEPARTMENT_SUB_SUB_ID;
        $data['supsup_name']        = $data_debsubsub->DEPARTMENT_SUB_SUB_NAME;
        // $data['supplies_tax']       = $data_debsubsub->supplies_tax;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_code,a.pro_num,a.pro_year,a.pro_name,b.wh_type_name,c.wh_unit_name,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price,a.active
                ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

                FROM wh_stock e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
            GROUP BY e.pro_id
        ');
        $data['wh_request_sub']      = DB::select(
            'SELECT a.*,b.pro_code 
            ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = a.pro_id AND request_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$datastock_list_id.'") AS stock_rep
            ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = a.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$datastock_list_id.'") as stock_pay
            FROM wh_request_sub a
            LEFT JOIN wh_product b ON b.pro_id = a.pro_id
            WHERE wh_request_id = "'.$id.'"
            GROUP BY a.pro_id
            ');
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");  
        $data['lot_no']              = $year.''.$mounts.''.$day.''.$time;

        return view('wh_user.wh_request_addsub', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
            'data_edit'  => $data_edit,
        ]);
    }
    public function wh_request_addsub_save(Request $request)
    { 
        $ynew          = substr($request->bg_yearnow,2,2); 
        $idpro         = $request->pro_id;
        $pro           = Wh_product::where('pro_id',$idpro)->first();
        $proid         = $pro->pro_id;
        $proname       = $pro->pro_name;
        $unitid        = $pro->unit_id;

        $unit          = Wh_unit::where('wh_unit_id',$unitid)->first();
        $idunit        = $unit->wh_unit_id;
        $nameunit      = $unit->wh_unit_name;

        // $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        // $bg_yearnow    = $bgs_year->leave_year_id;

        $pro_check     = Wh_request_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$proid)->where('request_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->where('stock_list_subid',$request->supsup_id)->count();
        if ($pro_check > 0) {
            Wh_request_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$proid)->where('request_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->where('stock_list_subid',$request->supsup_id)->update([ 
                'qty'                  => $request->qty, 
                'stock_list_id'        => $request->stock_list_id,
                'stock_list_subid'     => $request->supsup_id,
                'request_year'         => $request->data_year,  
                'one_price'            => $request->one_price, 
                'total_price'          => $request->one_price*$request->qty, 
                'lot_no'               => $request->lot_no, 
                'user_id'              => Auth::user()->id
            ]);
        } else {
            Wh_request_sub::insert([
                'wh_request_id'        => $request->wh_request_id,
                'stock_list_id'        => $request->stock_list_id,
                'stock_list_subid'     => $request->supsup_id,
                'request_year'         => $request->data_year,   
                'pro_id'               => $proid,
                'pro_name'             => $proname, 
                'unit_id'              => $idunit,
                'unit_name'            => $nameunit,
                'qty'                  => $request->qty, 
                'one_price'            => $request->one_price, 
                'total_price'          => $request->one_price*$request->qty, 
                'lot_no'               => $request->lot_no, 
                'user_id'              => Auth::user()->id
            ]);
        }
               
        return back();
         
    }
    public function wh_request_destroy(Request $request)
    {
        $id             = $request->ids;
        // $wh_re          = DB::table('wh_recieve_sub')->where('wh_recieve_sub_id','=',$id)->first();
        // $wh_recieve_id  = $wh_re->wh_recieve_id;       
        
        // $wh_re_sum      = DB::table('wh_recieve_sub')->where('wh_recieve_sub_id','=',$id)->sum('total_price');
        // $sum_total       = Wh_recieve_sub::where('wh_recieve_id',$wh_recieve_id)->sum('total_price');
        // Wh_recieve::where('wh_recieve_id',$wh_recieve_id)->update([
        //     'total_price'  => $sum_total 
        // ]);

        Wh_request_sub::whereIn('wh_request_sub_id',explode(",",$id))->delete(); 

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function wh_request_updatestock(Request $request)
    {   
        $id              = $request->wh_request_id;
        $data_year       = $request->data_year;
        $stock_list_id   = $request->stock_list_id;
        $supsup_id       = $request->supsup_id;
        
        $sum_total       = Wh_request_sub::where('wh_request_id',$id)->sum('total_price');
        Wh_request::where('wh_request_id',$id)->update([
            'total_price'  => $sum_total, 
            'active'       => 'APPREQUEST', 
        ]);

        // $idpro         = $request->pro_id;
        // $pro           = Wh_product::where('pro_id',$idpro)->first();
        // $proid         = $pro->pro_id;
        // $proname       = $pro->pro_name;
        // $unitid        = $pro->unit_id;

        // $unit          = Wh_unit::where('wh_unit_id',$unitid)->first();
        // $idunit        = $unit->wh_unit_id;
        // $nameunit      = $unit->wh_unit_name;

        return response()->json([
            'status'    => '200'
        ]);
         
    }
    public function wh_request_edittable(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $data  = array(  
                    // 'lot_no'        => $request->lot_no,  
                    'qty'           => $request->qty,
                    // 'one_price'     => $request->one_price,
                    // 'total_price'   => $request->qty * $request->one_price,
                );
                DB::connection('mysql')->table('wh_request_sub')->where('wh_request_sub_id', $request->wh_request_sub_id)->update($data);
            }  
            return response()->json([
                'status'     => '200'
            ]);
        }
    }
    public function wh_approve_stock(Request $request,$id)
    {
            $userid           =  Auth::user()->id;
            Wh_stock_dep::where('wh_request_id',$id)->update([ 
                'active'           => 'REPEXPORT', 
                'user_export_rep'  => $userid
            ]);

            Wh_stock_export::where('wh_request_id',$id)->update([ 
                'active'           => 'REPEXPORT', 
                'user_export_rep'  => $userid
            ]);

            

            Wh_request::where('wh_request_id',$id)->update([ 
                'active'       => 'REPEXPORT', 
            ]);

            $ip = $request->ip();
            $datenow               = date('Y-m-d');
            $data['m']             = date('H');
            $mm                    = date('H:m:s'); 
            Wh_log::insert([
                'datesave'   => $datenow,
                'ip'         => $ip,
                'timesave'   => $mm,
                'userid'     => Auth::user()->id,
                'comment'    => 'ยืนยันการรับเข้าคลังย่อย(ขั้นตอนสุดท้าย)'
            ]);

            return response()->json([
                'status'     => '200'
            ]);
         
    }

    public function wh_pay(Request $request)
    {
        $startdate           = $request->datepicker;
        $enddate             = $request->datepicker2;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $months              = date('m');
        $year                = date('Y');
        $newday              = date('Y-m-d', strtotime($datenow . ' -5 Day')); //ย้อนหลัง 1 สัปดาห์
 
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','1')->get();

        $data['m']                  = date('H');
        $data['mm']                 = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $data['monthsnew']          = substr($months,1,2);  
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
            ,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price
            ,a.active
                ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty
                ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

                FROM wh_stock e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
            GROUP BY e.pro_id
        ');
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data['wh_recieve']         = DB::select(
            'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
            ,a.supplies_name,r.recieve_po,s.stock_list_name,concat(u.fname," ",u.lname) as ptname 
            ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
            FROM wh_recieve r 
            LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
            LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
            LEFT JOIN users u ON u.id = r.user_recieve           
            ORDER BY wh_recieve_id DESC
        '); 
        $data['wh_pay']         = DB::select(
            'SELECT r.wh_pay_id,r.year,r.pay_date,r.pay_time,r.pay_no,r.stock_list_id,r.vendor_id,r.active,r.pay_po
            ,a.supplies_name,s.stock_list_name,concat(u.fname," ",u.lname) as ptname 
            ,(SELECT SUM(total_price) FROM wh_pay_sub WHERE wh_pay_id = r.wh_pay_id) as total_price
            FROM wh_pay r 
            LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
            LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
            LEFT JOIN users u ON u.id = r.user_pay           
            ORDER BY wh_pay_id DESC
        '); 
        
        return view('wh.wh_pay',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }

    

     
    
 
}
