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
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Car_index;
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

class WhController extends Controller
{
    public static function ref_ponumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('wh_recieve')->max('wh_recieve_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('wh_recieve')->where('wh_recieve_id', '=', $maxnumber)->first();
            if ($refmax->recieve_po != '' ||  $refmax->recieve_po != null) {
                $maxref = substr($refmax->recieve_po, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -4);
        $refnumber = $y . '-' . $ref;
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
    public function wh_main(Request $request,$id)
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
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
            ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS stock_rep
            ,(SELECT SUM(one_price) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS sum_one_price
            ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS sum_stock_price
            ,(SELECT SUM(qty) FROM wh_pay_sub WHERE pro_id = e.pro_id AND pay_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") as stock_pay
            
             

            ,a.active ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name
                FROM wh_stock e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE a.active ="Y" AND e.stock_list_id ="'.$id.'" AND e.stock_year ="'.$bg_yearnow.'"
            GROUP BY e.pro_id
        ');
        // ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'")-
        // (SELECT SUM(qty) FROM wh_pay_sub WHERE pro_id = e.pro_id AND pay_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") as stock_total
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_main             = DB::table('wh_stock_list')->where('stock_list_id','=',$id)->first();
        $data['stock_name']    = $data_main->stock_list_name;
        // ,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price
        return view('wh.wh_main', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }
    public function wh_recieve(Request $request)
    {
        $startdate           = $request->datepicker;
        $enddate             = $request->datepicker2;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $months              = date('m');
        $year                = date('Y');
        $newday              = date('Y-m-d', strtotime($datenow . ' -5 Day')); //ย้อนหลัง 1 สัปดาห์

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
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','1')->get();

        $data['m']                  = date('H');
        $data['mm']                 = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $data['monthsnew']          = substr($months,1,2); 
        
        // $data['wh_product']         = Wh_product::get();
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
            ORDER BY wh_recieve_id DESC');
        // $data_main             = DB::table('wh_stock_list')->where('stock_list_id','=',$id)->first();
        // $data['stock_name']    = $data_main->stock_list_name;
        // WHERE active = ""
        return view('wh.wh_recieve',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }
    public function wh_recieve_add(Request $request)
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
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        // $data_main             = DB::table('wh_stock_list')->where('stock_list_id','=',$id)->first();
        // $data['stock_name']    = $data_main->stock_list_name;

        return view('wh.wh_recieve_add', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }
    public function wh_recieve_save(Request $request)
    {
        // $year                = date('Y')+ 543;
        $ynew          = substr($request->bg_yearnow,2,2); 
        Wh_recieve::insert([
            'year'                 => $request->bg_yearnow,
            'recieve_date'         => $request->recieve_date,
            'recieve_time'         => $request->recieve_time, 
            'recieve_no'           => $ynew.'-'.$request->recieve_no,
            'stock_list_id'        => $request->stock_list_id,
            'vendor_id'            => $request->vendor_id,
            // 'recieve_po'           => $request->recieve_po,
            // 'total_price'          => $request->total_price, 
            'user_recieve'         => Auth::user()->id
        ]);
        return response()->json([ 
            'status'    => '200'
        ]);
    }
    public function wh_recieve_edit(Request $request,$id)
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
        
        // $data['wh_product']         = DB::select(
        //     'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
        //     ,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price
        //     ,a.active
        //         ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty
        //         ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

        //         FROM wh_stock e
        //         LEFT JOIN wh_product a ON a.pro_id = e.pro_id
        //         LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
        //         LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
        //         LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
        //         LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
        //     WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
        //     GROUP BY e.pro_id
        // ');
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_edit             = DB::table('wh_recieve')->where('wh_recieve_id','=',$id)->first();
        // $data['stock_name']    = $data_main->stock_list_name;

        return view('wh.wh_recieve_edit', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
            'data_edit'  => $data_edit,
        ]);
    }
    public function wh_recieve_update(Request $request)
    {
        $id            = $request->wh_recieve_id;
        // $ynew          = substr($request->bg_yearnow,2,2); 
        Wh_recieve::where('wh_recieve_id',$id)->update([
            'year'                 => $request->bg_yearnow,
            'recieve_date'         => $request->recieve_date,
            'recieve_time'         => $request->recieve_time, 
            'recieve_no'           => $request->recieve_no,
            'stock_list_id'        => $request->stock_list_id,
            'vendor_id'            => $request->vendor_id, 
            'user_recieve'         => Auth::user()->id
        ]);
        return response()->json([ 
            'status'    => '200'
        ]);
    }
    public function wh_recieve_addsub(Request $request,$id)
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
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_edit                  = DB::table('wh_recieve')->where('wh_recieve_id','=',$id)->first();
        $data['wh_recieve_id']      = $data_edit->wh_recieve_id;
        $data['data_year']          = $data_edit->year;
        $data['stock_list_id']      = $data_edit->stock_list_id;

        $data_supplies              = DB::table('air_supplies')->where('air_supplies_id','=',$data_edit->vendor_id)->first();
        $data['supplies_name']      = $data_supplies->supplies_name;
        $data['supplies_tax']       = $data_supplies->supplies_tax;

        $data['wh_product']         = DB::select(
            'SELECT a.pro_id,a.pro_code,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price,a.active
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
        $data['wh_recieve_sub']      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'"');
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");  
        $data['lot_no']              = $year.''.$mounts.''.$day.''.$time;

        return view('wh.wh_recieve_addsub', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
            'data_edit'  => $data_edit,
        ]);
    }
    public function wh_recieve_addsub_save(Request $request)
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

        $pro_check     = Wh_recieve_sub::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('recieve_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->count();
        if ($pro_check > 0) {
            Wh_recieve_sub::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('recieve_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->update([ 
                'qty'                  => $request->qty, 
                'stock_list_id'        => $request->stock_list_id,
                'recieve_year'         => $request->data_year,  
                'one_price'            => $request->one_price, 
                'total_price'          => $request->one_price*$request->qty, 
                'lot_no'               => $request->lot_no, 
                'user_id'              => Auth::user()->id
            ]);
        } else {
            Wh_recieve_sub::insert([
                'wh_recieve_id'        => $request->wh_recieve_id,
                'stock_list_id'        => $request->stock_list_id,
                'recieve_year'         => $request->data_year,   
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
    public function wh_recieve_destroy(Request $request)
    {
        $id             = $request->ids;
        // $wh_re          = DB::table('wh_recieve_sub')->where('wh_recieve_sub_id','=',$id)->first();
        // $wh_recieve_id  = $wh_re->wh_recieve_id;       
        
        // $wh_re_sum      = DB::table('wh_recieve_sub')->where('wh_recieve_sub_id','=',$id)->sum('total_price');
        // $sum_total       = Wh_recieve_sub::where('wh_recieve_id',$wh_recieve_id)->sum('total_price');
        // Wh_recieve::where('wh_recieve_id',$wh_recieve_id)->update([
        //     'total_price'  => $sum_total 
        // ]);

        Wh_recieve_sub::whereIn('wh_recieve_sub_id',explode(",",$id))->delete(); 

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function wh_recieve_updatestock(Request $request)
    {   
        $id              = $request->wh_recieve_id;
        $data_year       = $request->data_year;
        $stock_list_id   = $request->stock_list_id;
        // $getdate         = Wh_recieve_sub::where('wh_recieve_id',$id)->get();
        // foreach ($getdate as $key => $value) {
        //     $stock       = Wh_stock::where('stock_year',$data_year)->where('pro_id',$value->pro_id)->first();
        //     $stock_new   = $stock->stock_rep; 
        //     $stock_qty   = $stock->stock_qty; 
        //     $stock_total = $stock->stock_qty; 
        //     Wh_stock::where('stock_year',$data_year)->where('pro_id',$value->pro_id)->update([
        //         'stock_qty'    => $stock_qty + $value->qty,
        //         'stock_rep'    => $stock_new + $value->qty,
        //         'stock_total'  => $stock_total + $value->qty
        //     ]);
        // }

        $sum_total       = Wh_recieve_sub::where('wh_recieve_id',$id)->sum('total_price');
        Wh_recieve::where('wh_recieve_id',$id)->update([
            'total_price'  => $sum_total, 
            'active'       => 'RECIVE', 
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
    public function wh_recieve_edittable(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $data  = array(  
                    'lot_no'        => $request->lot_no,  
                    'qty'           => $request->qty,
                    'one_price'     => $request->one_price,
                    'total_price'   => $request->qty * $request->one_price,
                );
                DB::connection('mysql')->table('wh_recieve_sub')->where('wh_recieve_sub_id', $request->wh_recieve_sub_id)->update($data);
            }  
            return response()->json([
                'status'     => '200'
            ]);
        }
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

        $data['wh_request']         = DB::select(
            'SELECT r.wh_request_id,r.year,r.request_date,r.request_time,r.request_no,r.stock_list_id,r.active
            ,s.stock_list_name
            ,(SELECT DEPARTMENT_SUB_SUB_NAME FROM department_sub_sub WHERE DEPARTMENT_SUB_SUB_ID = r.stock_list_subid) as DEPARTMENT_SUB_SUB_NAME
            ,r.request_po,concat(u.fname," ",u.lname) as ptname 
            ,(SELECT SUM(total_price) FROM wh_request_sub WHERE wh_request_id = r.wh_request_id) as total_price
            FROM wh_request r 
            LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id 
            LEFT JOIN users u ON u.id = r.user_request  
            WHERE r.active ="APPREQUEST" AND r.year ="'.$bg_yearnow.'"        
            ORDER BY r.wh_request_id DESC
        ');
        
        return view('wh.wh_pay',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
        ]);
    }

    

     
    
 
}
