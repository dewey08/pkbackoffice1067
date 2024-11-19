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
use App\Models\Wh_stock_card;
use App\Models\Wh_request_subpay;
use App\Models\Wh_stock_sub;
use App\Models\Wh_stock_dep;
use App\Models\Wh_stock_dep_sub;
use App\Models\Wh_request;
use App\Models\Wh_log;
use App\Models\Wh_stock_export_sub;
use App\Models\Wh_stock_export;
use App\Models\Article_status;
use App\Models\Air_supplies;
use App\Models\Wh_recieve_sub;
use App\Models\Wh_stock;
use App\Models\Wh_recieve;
use App\Models\Wh_pay;
use App\Models\Wh_pay_sub;
use App\Models\Wh_request_sub;
use App\Models\Wh_stock_list;
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
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $maxnumber = DB::table('wh_recieve')->max('wh_recieve_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('wh_recieve')->where('wh_recieve_id', '=', $maxnumber)->first();
            if ($refmax->recieve_no != '' ||  $refmax->recieve_no != null) {
                $maxref = substr($refmax->recieve_no, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -4);
        $ynew   = substr($bg_yearnow,2,2); 
        $refnumber = $ynew.''.$ref;
        return $refnumber;


    }
    public static function ref_nonumber()
    {
        $year = date('Y');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $maxnumber = DB::table('wh_recieve')->max('wh_recieve_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('wh_recieve')->where('wh_recieve_id', '=', $maxnumber)->first();
            if ($refmax->recieve_no != '' ||  $refmax->recieve_no != null) {
                $maxref = substr($refmax->recieve_no, -7) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 8, "0", STR_PAD_LEFT);
        } else {
            $ref = '00000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $ynew   = substr($bg_yearnow,2,2); 
        $ref_nonumber = $ynew.''.$ref;
        return $ref_nonumber;


    }
   

    // 
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
    public function wh_plan(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
        
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
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy3.'" AND plan_store = "'. $id.'") plan_65
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy2.'" AND plan_store = "'. $id.'") plan_66
                ,(SELECT total_plan FROM wh_plan WHERE pro_id = a.pro_id AND wh_plan_year = "'. $yy1.'" AND plan_store = "'. $id.'") plan_67
                FROM wh_product a
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_plan e ON e.pro_id = a.pro_id
            WHERE e.plan_store = "'.$id.'"
            GROUP BY a.pro_id
        ');
        // a.active ="Y" 
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $planname_             = DB::table('wh_stock_list')->where('stock_list_id','=',$id)->first();
        $data['planname']      = $planname_ ->stock_list_name;

        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']         = $bgs_year->leave_year_id;
        
        return view('wh.wh_plan', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }
    public function wh_main_index(Request $request)
    {
        $budget_year                = $request->budget_year;
        $acc_trimart_id             = $request->acc_trimart_id;
        $dabudget_year              = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year           = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date                       = date('Y-m-d');
        $y                          = date('Y') + 543;
        $newweek                    = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate                    = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear                    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']         = $bgs_year->leave_year_id;
        $bg_yearnow                  = $bgs_year->leave_year_id;
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_stock_list_only'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        if ($budget_year == '') {
            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.stock_list_id,a.stock_list_name
                ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_qty 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_price
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_price     
                FROM wh_stock_list a
                LEFT JOIN wh_stock b ON b.stock_list_id = a.stock_list_id
                WHERE b.stock_year ="'.$bg_yearnow.'"
                GROUP BY a.stock_list_id
            ');
        } else {
            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.stock_list_id,a.stock_list_name
                ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_qty 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_price
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_price     
                FROM wh_stock_list a
                LEFT JOIN wh_stock b ON b.stock_list_id = a.stock_list_id
                WHERE b.stock_year ="'.$budget_year.'"
                GROUP BY a.stock_list_id
            ');
        }
                
        return view('wh.wh_main_index', $data,[
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y, 
        ]);
    }
    public function wh_main(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
         
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_product']         = Wh_product::get();
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow                 = $bgs_year->leave_year_id;
        $data['bgyearnow']          = $bgs_year->leave_year_id;

        $data['wh_product']         = DB::select(
            'SELECT e.wh_stock_id,a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name 
            ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS stock_rep
            ,(SELECT SUM(one_price) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS sum_one_price
            ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE pro_id = e.pro_id AND recieve_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") AS sum_stock_price
           
            ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = e.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") as stock_pay
             ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE pro_id = e.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$id.'") as sum_stock_pricepay
                        
            ,a.active ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name
                FROM wh_stock e
                LEFT JOIN wh_product a ON a.pro_id = e.pro_id
                LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
                LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
                LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
                LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE a.active ="Y" AND e.stock_list_id ="'.$id.'" AND e.stock_year ="'.$bg_yearnow.'"
            GROUP BY e.pro_id ORDER BY e.pro_id ASC 
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
    public function wh_stock_card(Request $request,$idstore,$idpro)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
         
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
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
 
        $data_main_stc         = DB::table('wh_stock')->where('wh_stock_id','=',$idstore)->first();
        $stock_year            = $data_main_stc->stock_year;
        $stock_list_id         = $data_main_stc->stock_list_id;
        $stock_list_name       = $data_main_stc->stock_list_name;
        $pro_id                = $data_main_stc->pro_id;
        $data['pro_code']      = $data_main_stc->pro_code;
        $data['pro_name']      = $data_main_stc->pro_name;

        $data_main             = DB::table('wh_stock_list')->where('stock_list_id','=',$stock_list_id)->first();
        $data['stock_name']    = $data_main->stock_list_name;

        // $data['stock_card']         = DB::select(
        //     'SELECT a.stock_list_id,a.lot_no,a.unit_name
        //     ,(SELECT recieve_date FROM wh_stock_card WHERE TYPE ="RECIEVE" AND pro_id = a.pro_id AND wh_recieve_sub_id = a.wh_recieve_sub_id) as recieve_date
        //     ,(SELECT pro_code FROM wh_stock_card WHERE TYPE ="RECIEVE" AND pro_id = a.pro_id AND wh_recieve_sub_id = a.wh_recieve_sub_id) as pro_code
        //     ,(SELECT pro_name FROM wh_stock_card WHERE TYPE ="RECIEVE" AND pro_id = a.pro_id AND wh_recieve_sub_id = a.wh_recieve_sub_id) as pro_name
        //     ,(SELECT qty FROM wh_stock_card WHERE TYPE ="RECIEVE" AND pro_id = a.pro_id AND wh_recieve_sub_id = a.wh_recieve_sub_id) as rep_qty
            
        //     ,(SELECT export_date FROM wh_stock_card WHERE TYPE ="PAY" AND pro_id = a.pro_id AND lot_no = a.lot_no AND wh_stock_card_id=a.wh_stock_card_id) as export_date
        //     ,(SELECT pro_code FROM wh_stock_card WHERE TYPE ="PAY" AND pro_id = a.pro_id AND lot_no = a.lot_no AND wh_stock_card_id=a.wh_stock_card_id) as pay_pro_code
        //     ,(SELECT pro_name FROM wh_stock_card WHERE TYPE ="PAY" AND pro_id = a.pro_id AND lot_no = a.lot_no AND wh_stock_card_id=a.wh_stock_card_id) as pay_pro_name
        //     ,(SELECT SUM(qty) FROM wh_stock_card WHERE TYPE ="PAY" AND pro_id = a.pro_id AND lot_no = a.lot_no AND wh_stock_card_id=a.wh_stock_card_id) as pay_qty
        //     ,a.one_price,a.total_price,a.type
        //     FROM wh_stock_card a
        //     WHERE a.pro_id = "'.$id.'"  
        //     GROUP BY a.wh_stock_card_id,a.lot_no 
        //     ORDER BY a.lot_no ASC 
        // ');
        $data['stock_card_recieve']         = DB::select(
            'SELECT a.pro_id,a.pro_code,a.pro_name,d.wh_unit_name,b.qty,b.lot_no,c.recieve_date,b.one_price
            
            FROM wh_stock a
            LEFT JOIN wh_recieve_sub b ON b.pro_id = a.pro_id
            LEFT JOIN wh_recieve c ON c.wh_recieve_id = b.wh_recieve_id
            LEFT JOIN wh_unit d ON d.wh_unit_id = a.unit_id
            WHERE a.pro_id = "'.$idpro.'"  
            GROUP BY b.lot_no ASC
            ORDER BY b.lot_no ASC 
        ');
        $data['stock_card_pay']         = DB::select(
            'SELECT a.pro_id,a.pro_code,a.pro_name,d.wh_unit_name,b.qty_pay,b.lot_no,c.export_date,b.one_price            
            FROM wh_stock a
            LEFT JOIN wh_stock_export_sub b ON b.pro_id = a.pro_id
            LEFT JOIN wh_stock_export c ON c.wh_stock_export_id = b.wh_stock_export_id
            LEFT JOIN wh_unit d ON d.wh_unit_id = a.unit_id
            WHERE a.pro_id = "'.$idpro.'"  
            ORDER BY b.wh_stock_export_sub_id ASC 
        ');
        $data_qty_  = DB::select(
            'SELECT SUM(b.qty) as qty_rep,b.one_price  
            FROM wh_stock a
            LEFT JOIN wh_recieve_sub b ON b.pro_id = a.pro_id 
            WHERE a.pro_id = "'.$idpro.'"  
        ');
        foreach ($data_qty_ as $key => $value) {
            $qty_rep         = $value->qty_rep;
            $price_rep       = $value->one_price;
            $total_price_rep = $qty_rep * $price_rep;
        }
        $data_qty_pay  = DB::select(
            'SELECT SUM(b.qty_pay) as qty_pay,b.one_price  
            FROM wh_stock a
            LEFT JOIN wh_stock_export_sub b ON b.pro_id = a.pro_id 
            WHERE a.pro_id = "'.$idpro.'"  
        ');
        foreach ($data_qty_pay as $key => $value2) {
            $qty_pay         = $value2->qty_pay;
            $price_pay       = $value2->one_price;
            $total_price_pay = $qty_pay * $price_pay;
        }
        $data['total_qty']   = $qty_rep - $qty_pay;
        $data['total_price'] = $total_price_rep - $total_price_pay;
        
        return view('wh.wh_stock_card', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }
    public function wh_recieve(Request $request)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
        $stock_listid        = $request->stock_list_id;
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
        if ($startdate =='') {
            $data['wh_recieve']         = DB::select(
                'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
                ,a.supplies_name,r.recieve_po_sup,s.stock_list_name,concat(u.fname," ",u.lname) as ptname 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
                FROM wh_recieve r 
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
                LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
                LEFT JOIN users u ON u.id = r.user_recieve           
                ORDER BY wh_recieve_id DESC LIMIT 50
            ');
        } else {
            $data['wh_recieve']         = DB::select(
                'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
                ,a.supplies_name,r.recieve_po_sup,s.stock_list_name,concat(u.fname," ",u.lname) as ptname 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
                FROM wh_recieve r 
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
                LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
                LEFT JOIN users u ON u.id = r.user_recieve  
                WHERE r.recieve_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND r.stock_list_id = "'.$stock_listid.'"         
                ORDER BY wh_recieve_id DESC
            ');
        }
        
       
       
        return view('wh.wh_recieve',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
            'stock_listid'  => $stock_listid
        ]);
    }
    public function wh_recieve_add(Request $request)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
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
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        // $data_main             = DB::table('wh_stock_list')->where('stock_list_id','=',$id)->first();
        // $data['stock_name']    = $data_main->stock_list_name;

        return view('wh.wh_recieve_add', $data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate,
            'bg_yearnow'  => $bg_yearnow,
        ]);
    }
    public function wh_recieve_save(Request $request)
    {
        // $year                = date('Y')+ 543;
        // $ynew          = substr($request->bg_yearnow,2,2); 
        Wh_recieve::insert([
            'dent_hn'              => $request->dent_hn,
            'recieve_date'         => $request->recieve_date,
            'recieve_time'         => $request->recieve_time, 
            'recieve_no'           => $request->recieve_no,
            'stock_list_id'        => $request->stock_list_id,
            'vendor_id'            => $request->vendor_id,
            'recieve_po_sup'       => $request->recieve_po_sup,
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
            'recieve_po_sup'       => $request->recieve_po_sup,
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
        $data['product_unit']       = Product_unit::get();
        $data['wh_unit']            = Wh_unit::get();
        // $data['product_category']   = Products_category::get();
        $data['product_category']   = DB::table('wh_type')->get();
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
        $data['wh_recieve_sub']      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'" ORDER BY wh_recieve_sub_id DESC');
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
    // public function load_data_table(Request $request)
    // {
    //     $id  = $request->wh_recieve_id; 
       
    //     $data['wh_recieve_sub']      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'" ORDER BY wh_recieve_sub_id DESC');
        

    //     return response()->json([ 
    //         'status'    => '200'
    //     ]);
    // }
    public function load_data_lot_no(Request $request)
    {
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");  
        $lot_no                      = $year.''.$mounts.''.$day.''.$time;
        // $output = "'.$lot_no.'"; 
        // $output.=' "'.$lot_no.'"';
        // echo $output;  
        return response()->json([ 
            'status'    => '200',
             'lot_no'    => $lot_no
        ]);       
    }
    public function load_data_table(Request $request)
    {
        $id  = $request->wh_recieve_id;  
        $wh_recieve_sub      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'" ORDER BY wh_recieve_sub_id DESC');  
        // $data_sub            = DB::select( 
        //     'SELECT a.air_repaire_id,a.repaire_date,a.repaire_time,a.air_repaire_no,a.air_list_num,a.air_list_name,a.btu,a.air_location_name
        //             FROM air_repaire a 
        //             LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id 
        //             LEFT JOIN air_maintenance_list c ON c.maintenance_list_id = b.air_repaire_ploblem_id  
        //             LEFT JOIN air_list al ON al.air_list_id = a.air_list_id 
        //             WHERE b.air_repaire_type_code ="04" AND al.air_year = "'.$years_now.'"
        //         GROUP BY a.air_list_num
        // ');      
        $output='                    
                <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">                                               
                        <thead> 
                            <tr>
                                <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th> 
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th> 
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>  
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th> 
                                <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">LOT</th> 
                                <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">จำนวน</th> 
                                <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="10%">ราคา</th> 
                                <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="10%">ราคารวม</th>                                                       
                                <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th> 
                            </tr> 
                        </thead>
                    <tbody>
                        ';
                
                        $i = 1;
                        foreach ($wh_recieve_sub as $key => $value) {
                            
                            $output.=' 
                              <tr id="tr_'.$value->wh_recieve_sub_id.'">
                                <td>'.$i++.'</td> 
                                <td>'.$value->wh_recieve_sub_id.'</td>
                                <td>'.$value->pro_name.'</td>
                                <td>'.$value->unit_name.'</td>
                                <td>'.$value->lot_no.'</td>
                                <td>'.$value->qty.'</td>                           
                                <td>'.number_format($value->one_price, 2).'</td>
                                <td>'.number_format($value->total_price, 2).'</td>
                                <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="'.$value->wh_recieve_sub_id.'"> </td>                                                         
                            </tr>';
                        }
                    
                        $output.='
                    </tbody> 
                </table> 
                
        ';
        echo $output;        
    }
    public function load_data_sum(Request $request)
    {
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");  
        $lot_no                      = $year.''.$mounts.''.$day.''.$time;
        $id                          = $request->wh_recieve_id;  
        $wh_recieve_sub              = DB::select('SELECT SUM(total_price) as total_price FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'"'); 
        foreach ($wh_recieve_sub as $key => $value) {
            $total   = $value->total_price;
        } 
     
        return response()->json([ 
            'status'    => '200',
             'total'    => $total
        ]);       
    }
    function add_product(Request $request)
    {
            if($request->pros_name!= null || $request->pros_name != ''){
                $stock_list_id  = $request->stock_list_id;
                $data_year      = $request->data_year;
                $pro_type       = $request->pro_type;
                $unit_id        = $request->wh_unit_id;
                $count_check    = Wh_product::where('pro_name','=',$request->pros_name)->count();
                $maxprocode     = DB::table('wh_product')->max('pro_code');
                $procode        = ($maxprocode)+1;
                $date           = date('Y-m-d');
                if($count_check == 0){
                        $add               = new Wh_product();
                        $add->pro_year     = $data_year;
                        $add->recieve_date = $date;
                        $add->pro_code     = $procode;
                        $add->pro_name     = $request->pros_name;
                        $add->pro_type     = $pro_type;
                        $add->unit_id      = $unit_id;
                        $add->user_id      = Auth::user()->id;
                        $add->save();
                }
            }
                $query =  DB::table('wh_product')->get();
                $output='<option value="">--เลือก--</option>';
                foreach ($query as $row){
                    if($request->pros_name == $row->pro_name){
                        $output.= '<option value="'.$row->pro_id.'" selected>'.$row->pro_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->pro_id.'">'.$row->pro_name.'</option>';
                    }
            }
        echo $output;
    }
    function addwh_unitt(Request $request)
    {
        if($request->unitnew!= null || $request->unitnew != ''){
            $count_check = Wh_unit::where('wh_unit_name','=',$request->unitnew)->count();
                if($count_check == 0){
                        $add = new Wh_unit();
                        $add->wh_unit_name = $request->unitnew;
                        $add->save();
                }
                }
                    $query =  DB::table('wh_unit')->get();
                    $output='<option value="">--เลือก--</option>';
                    foreach ($query as $row){
                        if($request->unitnew == $row->wh_unit_name){
                            $output.= '<option value="'.$row->wh_unit_id.'" selected>'.$row->wh_unit_name.'</option>';
                        }else{
                            $output.= '<option value="'.$row->wh_unit_id.'">'.$row->wh_unit_name.'</option>';
                        }
                }
        echo $output;
    }
    function addwh_supplies(Request $request)
    {
            if($request->supplies_name!= null || $request->supplies_name != ''){
                $supplies_tax  = $request->supplies_tax;
                $supplies_tel      = $request->supplies_tel;
                $fax       = $request->fax;
                $account_no        = $request->account_no;
                $bank_name        = $request->bank_name;
                $account_name        = $request->account_name;
                $bank_location        = $request->bank_location;
                $supplies_address        = $request->supplies_address;
                $count_check    = Air_supplies::where('supplies_name','=',$request->supplies_name)->count();
                // $maxprocode     = DB::table('air_supplies')->max('pro_code');
                // $procode        = ($maxprocode)+1;
                $date           = date('Y-m-d');
                if($count_check == 0){
                        $add                    = new Air_supplies();
                        $add->supplies_name     = $request->supplies_name;
                        $add->supplies_tax      = $supplies_tax;
                        $add->supplies_tel      = $supplies_tel;
                        $add->fax               = $fax;
                        $add->account_no        = $account_no;
                        $add->bank_name         = $bank_name;
                        $add->account_name      = $account_name;
                        $add->bank_location     = $bank_location;
                        $add->supplies_address  = $supplies_address; 
                        $add->air_user_id      = Auth::user()->id;
                        $add->save();
                }
            }
                $query =  DB::table('air_supplies')->get();
                $output='<option value="">--เลือก--</option>';
                foreach ($query as $row){
                    if($request->supplies_name == $row->supplies_name){
                        $output.= '<option value="'.$row->air_supplies_id.'" selected>'.$row->supplies_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->air_supplies_id.'">'.$row->supplies_name.'</option>';
                    }
            }
        echo $output;
    }
    public function wh_recieve_addsub_save(Request $request)
    { 
        // $validation = Validator::make($request->all(), [
        //     'BarcodeQrImage' => 'required'
        // ]);
        $ynew          = substr($request->bg_yearnow,2,2); 
        $idpro         = $request->pro_id;
        if ($idpro == '') {
            return back();
        } else {
           
            $pro           = Wh_product::where('pro_id',$idpro)->first();
            $proid         = $pro->pro_id;
            $pro_code      = $pro->pro_code;
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
                    'pro_code'             => $pro_code, 
                    'qty'                  => $request->qty, 
                    // 'stock_list_id'        => $request->stock_list_id,
                    // 'recieve_year'         => $request->data_year,  
                    'one_price'            => $request->one_price, 
                    'total_price'          => $request->one_price*$request->qty, 
                    // 'lot_no'               => $request->lot_no, 
                    'user_id'              => Auth::user()->id
                ]);
            } else {
                Wh_recieve_sub::insert([
                    'wh_recieve_id'        => $request->wh_recieve_id,
                    'stock_list_id'        => $request->stock_list_id,
                    'recieve_year'         => $request->data_year,   
                    'pro_id'               => $proid,
                    'pro_code'             => $pro_code, 
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
            $maxid   = Wh_recieve_sub::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('recieve_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->max('wh_recieve_sub_id');
            // $maxid    = $maxid_;
            $pro_check_stockcard  = Wh_stock_card::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('stock_card_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->count();
            if ($pro_check_stockcard > 0) {
                Wh_stock_card::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('stock_card_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->update([ 
                    // 'pro_code'             => $pro_code, 
                    'qty'                  => $request->qty,  
                    'one_price'            => $request->one_price, 
                    'total_price'          => $request->one_price*$request->qty,  
                    'user_id'              => Auth::user()->id,
                    'type'                 => 'RECIEVE'
                ]);
            } else {
                Wh_stock_card::insert([
                    'wh_recieve_id'        => $request->wh_recieve_id,
                    'wh_recieve_sub_id'    => $maxid, 
                    'stock_list_id'        => $request->stock_list_id,
                    'stock_card_year'      => $request->data_year,   
                    'pro_id'               => $proid,
                    'pro_code'             => $pro_code, 
                    'pro_name'             => $proname, 
                    'unit_id'              => $idunit,
                    'unit_name'            => $nameunit,
                    'qty'                  => $request->qty, 
                    'one_price'            => $request->one_price, 
                    'total_price'          => $request->one_price*$request->qty, 
                    'lot_no'               => $request->lot_no, 
                    'user_id'              => Auth::user()->id,
                    'type'                 => 'RECIEVE'
                ]);
            }
        }

        // return back();
        return response()->json([ 
            'status'    => '200'
        ]);         
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
        Wh_stock_card::whereIn('wh_recieve_sub_id',explode(",",$id))->delete(); 

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function wh_recieve_updatestock(Request $request)
    {   
        $id              = $request->wh_recieve_id;
        $data_year       = $request->data_year;
        $stock_list_id   = $request->stock_list_id;
        $stock_name_     = Wh_stock_list::where('stock_list_id',$stock_list_id)->first();
        $stock_name      = $stock_name_->stock_list_name;
        
        $getdate         = Wh_recieve_sub::where('wh_recieve_id',$id)->get();
        foreach ($getdate as $key => $value) {
            $stock_check   = Wh_stock::where('stock_year',$data_year)->where('stock_list_id',$stock_list_id)->where('pro_id',$value->pro_id)->count();
            $pro_          = Wh_product::where('pro_id',$value->pro_id)->first();
            $pro_id        = $pro_->pro_id;
            $pro_code      = $pro_->pro_code;
            $pro_name      = $pro_->pro_name;

            if ($stock_check > 0) {
                # code...
            } else {
                Wh_stock::insert([
                    'stock_year'       => $data_year,
                    'stock_list_id'    => $stock_list_id,
                    'stock_list_name'  => $stock_name,
                    'pro_id'           => $pro_id,
                    'pro_code'         => $pro_code,
                    'pro_name'         => $pro_name,
                    'unit_id'          => $value->unit_id,
                    'stock_price'      => $value->one_price,
                    'stock_qty'        => $value->qty,
                ]);
            }            
            // $stock       = Wh_stock::where('stock_year',$data_year)->where('pro_id',$value->pro_id)->first();
            // $stock_new   = $stock->stock_rep; 
            // $stock_qty   = $stock->stock_qty; 
            // $stock_total = $stock->stock_qty; 
            // Wh_stock::where('stock_year',$data_year)->where('pro_id',$value->pro_id)->update([
            //     'stock_qty'    => $stock_qty + $value->qty,
            //     'stock_rep'    => $stock_new + $value->qty,
            //     'stock_total'  => $stock_total + $value->qty
            // ]);
        }

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
                // $data2  = array(  
                //     'lot_no'        => $request->lot_no,  
                //     'qty'           => $request->qty,
                //     'one_price'     => $request->one_price,
                //     'total_price'   => $request->qty * $request->one_price,
                // );
                DB::connection('mysql')->table('wh_stock_card')->where('wh_recieve_sub_id', $request->wh_recieve_sub_id)->update($data);
            }  
            return response()->json([
                'status'     => '200'
            ]);
        }
    }

    // ********************* PAY ************************************
    public function wh_pay(Request $request)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
        $stock_listid        = $request->stock_list_id;
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
 
     
        if ($startdate =='') {
            $data['wh_request']         = DB::select(
                'SELECT r.wh_request_id,r.year,r.request_date,r.request_time,r.repin_date,r.request_no,r.stock_list_id,r.active
                ,s.stock_list_name
                ,(SELECT DEPARTMENT_SUB_SUB_NAME FROM department_sub_sub WHERE DEPARTMENT_SUB_SUB_ID = r.stock_list_subid) as DEPARTMENT_SUB_SUB_NAME
                ,r.total_price
                ,r.request_po,concat(u.fname," ",u.lname) as ptname 
                ,(SELECT concat(uu.fname," ",uu.lname) FROM users uu LEFT JOIN wh_stock_export w ON w.user_export_send = uu.id WHERE wh_request_id = r.wh_request_id) as ptname_send
                ,(SELECT concat(uuu.fname," ",uuu.lname) FROM users uuu LEFT JOIN wh_stock_export ww ON ww.user_export_rep = uuu.id WHERE wh_request_id = r.wh_request_id) as ptname_rep           
                FROM wh_request r 
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id 
                LEFT JOIN users u ON u.id = r.user_request  
                WHERE r.year ="'.$bg_yearnow.'"        
                ORDER BY r.wh_request_id DESC LIMIT 50
            ');
        } else {
            $data['wh_request']         = DB::select(
                'SELECT r.wh_request_id,r.year,r.request_date,r.request_time,r.repin_date,r.request_no,r.stock_list_id,r.active
                ,s.stock_list_name
                ,(SELECT DEPARTMENT_SUB_SUB_NAME FROM department_sub_sub WHERE DEPARTMENT_SUB_SUB_ID = r.stock_list_subid) as DEPARTMENT_SUB_SUB_NAME
                ,r.total_price
                ,r.request_po,concat(u.fname," ",u.lname) as ptname 
                ,(SELECT concat(uu.fname," ",uu.lname) FROM users uu LEFT JOIN wh_stock_export w ON w.user_export_send = uu.id WHERE wh_request_id = r.wh_request_id) as ptname_send
                ,(SELECT concat(uuu.fname," ",uuu.lname) FROM users uuu LEFT JOIN wh_stock_export ww ON ww.user_export_rep = uuu.id WHERE wh_request_id = r.wh_request_id) as ptname_rep           
                FROM wh_request r 
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id 
                LEFT JOIN users u ON u.id = r.user_request  
                WHERE r.year ="'.$bg_yearnow.'" AND r.request_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND r.stock_list_id  = "'.$stock_listid.'"   
                ORDER BY r.wh_request_id DESC
            ');
        } 
       
        return view('wh.wh_pay',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
            'stock_listid'  => $stock_listid
        ]);
    }
    public function wh_pay_addsub(Request $request,$id)
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
        // wh_request_id
        $data_edit                  = DB::table('wh_request')->where('wh_request_id','=',$id)->first();
        // $data_edit                  = DB::table('wh_request_sub')->where('wh_request_sub_id','=',$id)->first();
        $data['wh_request_id']      = $data_edit->wh_request_id;
        $data['data_year']          = $data_edit->year;
        $data['stock_list_id']      = $data_edit->stock_list_id;
        $data['request_date']       = $data_edit->request_date;
        $data['request_time']       = $data_edit->request_time;
        $data['request_no']         = $data_edit->request_no;

        $subsubid                   = $data_edit->stock_list_subid;
        // $data_wh_stock_list         = DB::table('wh_stock_list')->where('stock_list_id',$data_edit->stock_list_id)->first();
        // $data['stock_name']         = $data_wh_stock_list->stock_list_name;

        $data_debsubsub             = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$subsubid)->first();
        $data['supsup_id']          = $data_debsubsub->DEPARTMENT_SUB_SUB_ID;
        $data['supsup_name']        = $data_debsubsub->DEPARTMENT_SUB_SUB_NAME;
        // $dep_subsubtrueid           =  Auth::user()->dep_subsubtrueid;
        // $data_supplies              = DB::table('air_supplies')->where('air_supplies_id','=',$data_edit->vendor_id)->first();
        // $data['supplies_name']      = $data_supplies->supplies_name;
        // $data['supplies_tax']       = $data_supplies->supplies_tax;
        // $data['wh_request']         = DB::select(
        //     'SELECT r.wh_request_id,r.year,r.request_date,r.request_time,r.request_no,r.stock_list_id,r.active
        //     ,s.stock_list_name
        //     ,(SELECT DEPARTMENT_SUB_SUB_NAME FROM department_sub_sub WHERE DEPARTMENT_SUB_SUB_ID = r.stock_list_subid) as DEPARTMENT_SUB_SUB_NAME
        //     ,r.request_po,concat(u.fname," ",u.lname) as ptname 
        //     ,(SELECT SUM(total_price) FROM wh_request_sub WHERE wh_request_id = r.wh_request_id) as total_price
        //     FROM wh_request r 
        //     LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id 
        //     LEFT JOIN users u ON u.id = r.user_request  
        //     WHERE r.stock_list_subid ="'.$dep_subsubtrueid.'"         
        //     ORDER BY r.wh_request_id DESC
        // ');
        // $data['wh_request_sub']      = DB::select(
        //     'SELECT a.*,b.pro_code 
        //     ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = a.pro_id AND stock_list_id = a.stock_list_id) AS stock_rep
        //     ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = a.pro_id AND stock_list_id = a.stock_list_id) AS stock_pay
        //     FROM wh_request_sub a
        //     LEFT JOIN wh_product b ON b.pro_id = a.pro_id
        //     WHERE wh_request_id = "'.$id.'"
        //     GROUP BY a.pro_id
        // ');
        $data['wh_request_sub']      = DB::select(
            'SELECT a.*,b.pro_code 
            ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = a.pro_id) AS stock_rep
            ,(SELECT SUM(qty_pay) FROM wh_request_subpay WHERE pro_id = a.pro_id) AS stock_pay
            FROM wh_request_sub a
            LEFT JOIN wh_product b ON b.pro_id = a.pro_id
            WHERE wh_request_id = "'.$id.'"
             
        ');
        // ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = a.pro_id) AS stock_pay
            // $data['wh_request_sub']      = DB::select(
            //     'SELECT a.*,b.pro_code 
            //     ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE pro_id = a.pro_id AND request_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$datastock_list_id.'") AS stock_rep
            //     ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = a.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_id ="'.$datastock_list_id.'") as stock_pay
            //     FROM wh_request_sub a
            //     LEFT JOIN wh_product b ON b.pro_id = a.pro_id
            //     WHERE wh_request_id = "'.$id.'"
            //     GROUP BY a.pro_id
            //     ');

        // $data['wh_product']         = DB::select(
        //     'SELECT a.pro_id,a.pro_code,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price,a.active
        //         ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

        //         FROM wh_stock e
        //         LEFT JOIN wh_product a ON a.pro_id = e.pro_id
        //         LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
        //         LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
        //         LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
        //         LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
        //     WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
        //     GROUP BY e.pro_id
        // ');
        // $data['wh_recieve_sub']      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'"');
        $data['wh_request_subpay']      = DB::select('SELECT * FROM wh_request_subpay WHERE wh_request_id = "'.$id.'"');
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");  
        $data['lot_no']              = $year.''.$mounts.''.$day.''.$time;

        return view('wh.wh_pay_addsub', $data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'data_edit'     => $data_edit,
            'wh_request_id' => $id
        ]);
    }
    public function wh_pay_addsub_save(Request $request)
    { 
        $ynew          = substr($request->bg_yearnow,2,2); 
        // $idpro         = $request->pro_id;
        // $getdata       = Wh_request_sub::where('wh_request_id',$request->wh_request_id)->get();
        $getdata       = Wh_request_subpay::where('wh_request_id',$request->wh_request_id)->get();
        foreach ($getdata as $key => $value) { 
                $pro           = Wh_product::where('pro_id',$value->pro_id)->first();
                $proid         = $pro->pro_id;
                $pro_code      = $pro->pro_code;
                $proname       = $pro->pro_name;
                $unitid        = $pro->unit_id;
        
                $unit          = Wh_unit::where('wh_unit_id',$unitid)->first();
                $idunit        = $unit->wh_unit_id;
                $nameunit      = $unit->wh_unit_name;
       
                $export_check     = Wh_stock_export::where('export_no',$request->request_no)->count();
                if ($export_check > 0) {
                    Wh_stock_export::where('export_no',$request->request_no)->update([
                        'wh_request_id'      => $request->wh_request_id,
                        'year'               => $request->data_year,
                        'export_date'        => $request->request_date,
                        'export_time'        => $request->request_time,
                        'export_no'          => $request->request_no,   
                        'stock_list_id'      => $value->stock_list_id,
                        'stock_list_subid'   => $request->supsup_id,  
                        'user_export_send'   => Auth::user()->id
                    ]);
                } else {
                    Wh_stock_export::insert([
                        'wh_request_id'      => $request->wh_request_id,
                        'year'               => $request->data_year,
                        'export_date'        => $request->request_date,
                        'export_time'        => $request->request_time,
                        'export_no'          => $request->request_no,   
                        'stock_list_id'      => $value->stock_list_id,
                        'stock_list_subid'   => $request->supsup_id,  
                        'user_export_send'   => Auth::user()->id
                    ]);
                }                 

                $idexport            = Wh_stock_export::where('wh_request_id',$request->wh_request_id)->first();
                $wh_stock_export_id  = $idexport->wh_stock_export_id;
                $export_date         = $idexport->export_date;
                $pro_check           = Wh_stock_export_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$value->pro_id)->where('export_sub_year',$request->data_year)->where('stock_list_subid',$request->supsup_id)->where('lot_no',$value->lot_no)->count();
                if ($pro_check > 0) {
                    Wh_stock_export_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$value->pro_id)->where('export_sub_year',$request->data_year)->where('stock_list_subid',$request->supsup_id)->where('lot_no',$value->lot_no)->update([ 
                        'wh_stock_export_id'   => $wh_stock_export_id,
                        'wh_request_subpay_id' => $value->wh_request_subpay_id,
                        'qty'                  => $value->qty, 
                        'qty_pay'              => $value->qty_pay, 
                        'wh_request_id'        => $request->wh_request_id,
                        'stock_list_id'        => $value->stock_list_id,
                        'stock_list_subid'     => $request->supsup_id,
                        'export_sub_year'      => $value->request_year,  
                        'one_price'            => $value->one_price, 
                        'total_price'          => $value->one_price*$value->qty_pay, 
                        'lot_no'               => $value->lot_no, 
                        'user_id'              => Auth::user()->id
                    ]);
                } else {
                    Wh_stock_export_sub::insert([
                        'wh_request_subpay_id' => $value->wh_request_subpay_id,
                        'wh_stock_export_id'   => $wh_stock_export_id,
                        'wh_request_id'        => $request->wh_request_id,
                        'stock_list_id'        => $value->stock_list_id,
                        'stock_list_subid'     => $request->supsup_id,
                        'export_sub_year'      => $value->request_year,   
                        'pro_id'               => $value->pro_id,
                        'pro_code'             => $value->pro_code,
                        'pro_name'             => $value->pro_name,
                        'unit_id'              => $value->unit_id,
                        'unit_name'            => $value->unit_name,
                        'qty'                  => $value->qty, 
                        'qty_pay'              => $value->qty_pay, 
                        'one_price'            => $value->one_price, 
                        'total_price'          => $value->one_price*$value->qty_pay, 
                        'lot_no'               => $value->lot_no, 
                        'user_id'              => Auth::user()->id
                    ]);
                }
 
                $idexport_export         = Wh_stock_export_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$value->pro_id)->where('lot_no',$value->lot_no)->first();
                $wh_stock_export_sub_id  = $idexport_export->wh_stock_export_sub_id;
                $qty_pay                 = $idexport_export->qty_pay;
                $one_price               = $idexport_export->one_price;
                $total_price             = $idexport_export->total_price;

                $maxid   = Wh_stock_export_sub::where('wh_request_id',$request->wh_request_id)->where('pro_id',$value->pro_id)->where('export_sub_year',$request->data_year)->where('stock_list_subid',$request->supsup_id)->max('wh_stock_export_sub_id');
          
                // $pro_check_stockcard  = Wh_stock_card::where('wh_stock_export_sub_id',$wh_stock_export_sub_id)->where('pro_id',$value->pro_id)->where('stock_card_year',$request->data_year)->where('stock_list_subid',$request->supsup_id)->count();
                $pro_check_stockcard  = Wh_stock_card::where('wh_stock_export_sub_id',$wh_stock_export_sub_id)->where('pro_id',$value->pro_id)->count();
                if ($pro_check_stockcard > 0) {
                    Wh_stock_card::where('wh_stock_export_sub_id',$wh_stock_export_sub_id)->where('pro_id',$value->pro_id)->update([ 
    
                        'qty'                  => $qty_pay,  
                        'one_price'            => $one_price, 
                        'total_price'          => $one_price*$qty_pay,  
                        'user_id'              => Auth::user()->id,
                        'export_date'          => $export_date,
                        'type'                 => 'PAY',
                        'stock_list_id'        => $value->stock_list_id,
                    ]);
                } else {
                    Wh_stock_card::insert([
                        'wh_stock_export_id'       => $wh_stock_export_id,
                        'wh_stock_export_sub_id'   => $wh_stock_export_sub_id, 
                        'stock_list_id'            => $value->stock_list_id,
                        'stock_list_subid'         => $request->supsup_id,
                        'stock_card_year'          => $request->data_year,  
                        'export_date'              => $export_date, 
                        'pro_id'                   => $proid,
                        'pro_code'                 => $pro_code, 
                        'pro_name'                 => $proname, 
                        'unit_id'                  => $idunit,
                        'unit_name'                => $nameunit,
                        'qty'                      => $qty_pay, 
                        'one_price'                => $one_price, 
                        'total_price'              => $one_price*$qty_pay, 
                        'lot_no'                   => $value->lot_no, 
                        'user_id'                  => Auth::user()->id,
                        'type'                     => 'PAY'
                    ]);
                }

                
        }

        $total = Wh_stock_export_sub::where('wh_request_id',$request->wh_request_id)->sum('total_price');
                
        Wh_stock_export::where('wh_request_id',$request->wh_request_id)->update([
            'total_price'   => $total
        ]);

        Wh_request::where('wh_request_id',$request->wh_request_id)->update([
            'active'        => 'CONFIRM',
            'total_price'   => $total
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
            'comment'    => 'ตัดจ่ายเพื่อรอยืนยันการจ่ายพัสดุ'
        ]);

        return response()->json([
            'status'     => '200'
        ]);
         
    }
    public function wh_pay_subdestroy(Request $request)
    {
        $id             = $request->ids;        

        Wh_request_subpay::whereIn('wh_request_subpay_id',explode(",",$id))->delete(); 

        return response()->json([
            'status'    => '200'
        ]);
    }

    function wh_pay_select_lot(Request $request)
    {
        $wh_request_id   = $request->get('wh_request_id');
        $stock_          = DB::table('wh_request')->where('wh_request_id', '=', $wh_request_id)->first();
        $stock_list_id   = $stock_->stock_list_id;
        $count           = $request->get('count');
        // $detailstocks = DB::table('warehouse_stock')->where('warehouse_inven_id', '=', $id_inven)->get();
        // $detailstocks = DB::table('wh_recieve_sub')->where('stock_list_id', '=', $stocklistid)->get();
        $detailstocks  = DB::select(
            'SELECT *,(SELECT SUM(qty_pay) FROM wh_request_subpay WHERE pro_id = a.pro_id AND lot_no = a.lot_no) as pay
            FROM wh_recieve_sub a
            
            GROUP BY a.pro_id,a.lot_no ORDER BY a.pro_id ASC
        '); 
        // WHERE a.stock_list_id ="'.$stock_list_id.'"
        $output = '
                <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                <thead style="background-color: rgb(43, 86, 136)">
                    <tr>
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="20%">รหัส</td>                
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" >รายการวัสดุ</td>
                          <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" >ราคา</td>
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" >LOT</td>
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="12%">คงเหลือ</td>        
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="12%">จ่าย</td>                  
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="6%">เลือก</td>
                    </tr>
                </thead>
                <tbody id="myTable">';
                        foreach ($detailstocks as $item) {
                                
                    $output .= '  
                        <tr height="20">
                            <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;">' . $item->pro_code . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;" align="left" >' . $item->pro_name . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;" align="center" >' . $item->one_price . '</td>
                              <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;" align="center" >' . $item->lot_no . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-right:10px;font-size: 13px;" align="right" >' . $item->qty-$item->pay . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-right:10px;font-size: 13px;" align="right" ><input class="form-control form-control-sm" name="qty_pay'.$item->wh_recieve_sub_id.'" id="qty_pay'.$item->wh_recieve_sub_id.'" type="text"></td>
                            <td class="text-font" style="border: 1px solid black;" align="center" >
                            <button type="button" class="btn btn-outline-primary btn-sm"  style="font-family: \'Kanit\', sans-serif; font-size: 13px;font-weight:normal;" onclick="selectsupreq('.$item->wh_recieve_sub_id.','.$count.')">เลือก</button></td> 
                        </tr>';
                     }
                    $output .= '</tbody>
                    </table>';
        echo $output;
    }
    public function wh_pay_sublot_save(Request $request)
    { 
        $wh_request_id     = $request->wh_request_id;
        $iddeb             = Wh_request::where('wh_request_id',$wh_request_id)->first();
    
        $idrecieve_sub     = Wh_recieve_sub::where('wh_recieve_sub_id',$request->wh_recieve_sub_id)->first();
        $id_pro            = Wh_request_sub::where('wh_request_id',$wh_request_id)->where('pro_id',$idrecieve_sub->pro_id)->first();
        $qty_req           = $id_pro->qty;
        $count             = Wh_request_subpay::where('wh_recieve_sub_id',$request->wh_recieve_sub_id)->where('wh_request_id',$wh_request_id)->count();
        if ($count > 0) {
            # code...
        } else {
            Wh_request_subpay::insert([
                'wh_recieve_sub_id'  => $request->wh_recieve_sub_id,
                'wh_request_id'      => $wh_request_id,
                'request_year'       => $idrecieve_sub->recieve_year,
                'stock_list_id'      => $idrecieve_sub->stock_list_id,
                'stock_list_subid'   => $iddeb->stock_list_subid,
                'pro_id'             => $idrecieve_sub->pro_id,
                'qty'                => $qty_req,
                'qty_pay'            => $request->qty_pay,                 
                'pro_code'           => $idrecieve_sub->pro_code,
                'pro_name'           => $idrecieve_sub->pro_name,
                'unit_id'            => $idrecieve_sub->unit_id,
                'unit_name'          => $idrecieve_sub->unit_name,
                'one_price'          => $idrecieve_sub->one_price, 
                'lot_no'             => $idrecieve_sub->lot_no, 
                'user_id'            => Auth::user()->id
            ]);
        }
        
        return response()->json([
            'status'     => '200'
        ]);
         
    }
    public function wh_pay_updatetable(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $pro             = Wh_request_subpay::where('wh_request_subpay_id',$request->wh_request_subpay_id)->first();
                $proid           = $pro->pro_id; 
                $one_price       = $pro->one_price;
                $wh_request_id   = $pro->wh_request_id;
                $data_req        = Wh_request_sub::where('wh_request_id',$wh_request_id)->where('pro_id',$proid)->first();
                $qty             = $data_req->qty;
                    $data  = array(    
                        'qty'          => $qty,                           
                        'qty_pay'      => $request->qty_pay, 
                        'one_price'    => $one_price, 
                        'total_price'  => $one_price*$request->qty_pay, 
                    );
                    DB::connection('mysql')->table('wh_request_subpay')->where('wh_request_subpay_id', $request->wh_request_subpay_id)->update($data);

                    Wh_request::where('wh_request_id',$wh_request_id)->update([
                        'active'   => 'ALLOCATE'
                    ]); 
                    
                    $datenow               = date('Y-m-d');
                    $data['m']             = date('H');
                    $mm                    = date('H:m:s');
                    Wh_log::insert([
                        'datesave'   => $datenow,
                        'timesave'   => $mm,
                        'userid'     => Auth::user()->id,
                        'comment'    => 'ตัดจ่าย(EDITTable)'
                    ]);
                    return response()->json([
                        'status'     => '200'
                    ]);

            }  
 
        }
    }
    public function wh_pay_edittable(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $pro             = Wh_request_sub::where('wh_request_sub_id',$request->wh_request_sub_id)->first();
                $proid           = $pro->pro_id; 
                $wh_request_id   = $pro->wh_request_id;
                // $pro           = Wh_request_sub::where('wh_request_sub_id',$request->wh_request_sub_id)->first();
                // $proid         = $pro->pro_id;
                $count = wh_recieve_sub::where('pro_id',$proid)->count();
                // dd($count);
                if ($count < 1 ) {
                    return response()->json([
                        'status'     => '100'
                    ]);
                } else { 
                
                        $price_new_    = DB::select(
                            'SELECT a.pro_id,a.qty,a.one_price,a.lot_no
                                FROM wh_recieve_sub a
                                WHERE a.pro_id = "'.$proid.'"
                                GROUP BY a.pro_id
                        ');
                        //  LEFT JOIN wh_request_sub b ON b.pro_id = a.pro_id
                        foreach ($price_new_ as $key => $value) {
                            $price_news_    = $value->one_price;
                        }
                       
                            $price_new  =  $price_news_ ;
                            $data  = array(  
                            
                                'qty_pay'      => $request->qty_pay, 
                                'one_price'    => $price_new, 
                                'total_price'  => $price_new*$request->qty_pay, 
                            );
                            DB::connection('mysql')->table('wh_request_sub')->where('wh_request_sub_id', $request->wh_request_sub_id)->update($data);

                            Wh_request::where('wh_request_id',$wh_request_id)->update([
                                'active'   => 'ALLOCATE'
                            ]); 

                            $ip = $request->ip();
                            $datenow               = date('Y-m-d');
                            $data['m']             = date('H');
                            $mm                    = date('H:m:s');
                            Wh_log::insert([
                                'ip'         => $ip,
                                'datesave'   => $datenow,
                                'timesave'   => $mm,
                                'userid'     => Auth::user()->id,
                                'comment'    => 'ตัดจ่าย(EDITTable)'
                            ]);
                            return response()->json([
                                'status'     => '200'
                            ]);
 
                }
                // $data  = array(  
                    
                //     'qty_pay'      => $request->qty_pay, 
                //     'one_price'    => $price_new, 
                //     'total_price'  => $price_new*$request->qty_pay, 
                // );
                // DB::connection('mysql')->table('wh_request_sub')->where('wh_request_sub_id', $request->wh_request_sub_id)->update($data);


            }  


            // $datenow               = date('Y-m-d');
            // $data['m']             = date('H');
            // $mm                    = date('H:m:s');
            // Wh_log::insert([
            //     'datesave'   => $datenow,
            //     'timesave'   => $mm,
            //     'userid'     => Auth::user()->id,
            //     'comment'    => 'ตัดจ่าย(EDITTable)'
            // ]);
            // return response()->json([
            //     'status'     => '200'
            // ]);
        }
    }
    public function wh_pay_approve(Request $request,$id)
    {
      
            $count_main       = Wh_stock_dep::where('wh_request_id',$id)->count();
            $pro_rep_m        = Wh_stock_export::where('wh_request_id',$id)->first();
            if ($count_main > 0) {
                $pro_rep_deb      = Wh_stock_export::where('wh_request_id',$id)->get();
                foreach ($pro_rep_deb as $key => $values) {
                    Wh_stock_dep::where('wh_request_id',$id)->update([                             
                        'total_price'   => $values->total_price, 
                        'active'        => 'SENDEXPORT'  
                    ]);
                    wh_request::where('wh_request_id',$id)->update([
                       'total_price'   => $values->total_price,
                       'active'        => 'CONFIRMSEND'
                    ]);
                }
            } else {
                $pro_rep_deb      = Wh_stock_export::where('wh_request_id',$id)->get();
                foreach ($pro_rep_deb as $key => $value) {
                    $count_sub_ssm       = Wh_stock_dep::where('wh_request_id',$id)->count();
                    if ($count_sub_ssm > 0) { 
                    } else {
                        Wh_stock_dep::insert([
                            'wh_request_id'      => $value->wh_request_id,
                            'year'               => $value->year,
                            'stock_date'         => $value->export_date,
                            'stock_time'         => $value->export_time,
                            'export_no'          => $value->export_no,   
                            'stock_list_id'      => $value->stock_list_id,
                            'stock_list_subid'   => $value->stock_list_subid,   
                            'export_po'          => $value->export_po, 
                            'total_price'        => $value->total_price, 
                            'user_export_send'   => $value->user_export_send, 
                            'user_export_rep'    => $value->user_export_rep,  
                            'active'             => 'SENDEXPORT' 
                        ]);
                        wh_request::where('wh_request_id',$id)->update([ 
                            'total_price'   => $value->total_price,
                            'active'        => 'CONFIRMSEND'
                         ]);
                    } 
                }
            }
        
            $pro_rep_debsub      = wh_stock_export_sub::where('wh_request_id',$id)->get();
            $id_deb_             = Wh_stock_dep::where('wh_request_id',$id)->first();
            $id_deb              = $id_deb_->wh_stock_dep_id;
              
            // $stockname_  = Departmentsubsub::where('DEPARTMENT_SUB_SUB_ID',$id_deb)->first();
            // $stockid     = $stockname_->DEPARTMENT_SUB_SUB_ID;
            // $stockname   = $stockname_->DEPARTMENT_SUB_SUB_NAME;
            foreach ($pro_rep_debsub as $key => $valuesub) {  
                $count_sub_s     = Wh_stock_dep_sub::where('wh_stock_export_sub_id',$valuesub->wh_stock_export_sub_id)->count();
                    if ( $count_sub_s > 0) {
                        Wh_stock_dep_sub::where('wh_stock_export_sub_id',$valuesub->wh_stock_export_sub_id)->update([ 
                            'wh_stock_dep_id'           => $id_deb,
                            'wh_stock_export_sub_id'    => $valuesub->wh_stock_export_sub_id,
                            'wh_stock_export_id'        => $valuesub->wh_stock_export_id,
                            'wh_request_id'             => $valuesub->wh_request_id,
                            'stock_list_id'             => $valuesub->stock_list_id,
                            'stock_list_subid'          => $valuesub->stock_list_subid,                            
                            'stock_sub_year'            => $valuesub->export_sub_year,
                            'pro_id'                    => $valuesub->pro_id,
                            'pro_code'                  => $valuesub->pro_code,
                            'pro_name'                  => $valuesub->pro_name,
                            'qty'                       => $valuesub->qty,
                            'qty_pay'                   => $valuesub->qty_pay,
                            'unit_id'                   => $valuesub->unit_id,
                            'unit_name'                 => $valuesub->unit_name,
                            'one_price'                 => $valuesub->one_price,
                            'total_price'               => $valuesub->total_price,
                            'user_id'                   => $valuesub->user_id,
                            'lot_no'                    => $valuesub->lot_no,
                            'date_start'                => $valuesub->date_start,
                            'date_enddate'              => $valuesub->date_enddate,  
                        ]);
                    } else {
                        Wh_stock_dep_sub::insert([ 
                            'wh_stock_dep_id'           => $id_deb,
                            'wh_stock_export_sub_id'    => $valuesub->wh_stock_export_sub_id,
                            'wh_stock_export_id'        => $valuesub->wh_stock_export_id,
                            'wh_request_id'             => $valuesub->wh_request_id,
                            'stock_list_id'             => $valuesub->stock_list_id,
                            'stock_list_subid'          => $valuesub->stock_list_subid,                            
                            'stock_sub_year'            => $valuesub->export_sub_year,
                            'pro_id'                    => $valuesub->pro_id,
                            'pro_code'                  => $valuesub->pro_code,
                            'pro_name'                  => $valuesub->pro_name,
                            'qty'                       => $valuesub->qty,
                            'qty_pay'                   => $valuesub->qty_pay,
                            'unit_id'                   => $valuesub->unit_id,
                            'unit_name'                 => $valuesub->unit_name,
                            'one_price'                 => $valuesub->one_price,
                            'total_price'               => $valuesub->total_price,
                            'user_id'                   => $valuesub->user_id,
                            'lot_no'                    => $valuesub->lot_no,
                            'date_start'                => $valuesub->date_start,
                            'date_enddate'              => $valuesub->date_enddate,  
                        ]);
                    } 

                $count_stock_sub    = Wh_stock_sub::where('stock_list_subid',$valuesub->stock_list_subid)->where('pro_id',$valuesub->pro_id)->count();
                if ($count_stock_sub >0) {
                    # code...
                } else {
                    $stockname_  = Departmentsubsub::where('DEPARTMENT_SUB_SUB_ID',$valuesub->stock_list_subid)->first();
                    $stockid     = $stockname_->DEPARTMENT_SUB_SUB_ID;
                    $stockname   = $stockname_->DEPARTMENT_SUB_SUB_NAME;

                    $pros           = Wh_product::where('pro_id',$valuesub->pro_id)->first();
                    $proidnew       = $pros->pro_id;
                    $procode        = $pros->pro_code;
                    $pronamename    = $pros->pro_name; 

                    $count_stocksub     = Wh_stock_sub::where('stock_list_subid',$stockid)->where('pro_id',$proidnew)->count();
                    if ($count_stocksub > 0) {
                        Wh_stock_sub::where('stock_list_subid',$stockid)->where('pro_id',$proidnew)->update([  
                            'stock_list_subid'          => $stockid, 
                            'stock_list_subname'        => $stockname,                            
                            'stock_year'                => $valuesub->export_sub_year,
                            'pro_id'                    => $proidnew,
                            'pro_code'                  => $procode,
                            'pro_name'                  => $pronamename, 
                            'unit_id'                   => $valuesub->unit_id,
                            'unit_name'                 => $valuesub->unit_name,
                            'one_price'                 => $valuesub->one_price, 
                        ]);
                    } else {
                        Wh_stock_sub::insert([  
                            'stock_list_subid'          => $stockid, 
                            'stock_list_subname'        => $stockname,                            
                            'stock_year'                => $valuesub->export_sub_year,
                            'pro_id'                    => $proidnew,
                            'pro_code'                  => $procode,
                            'pro_name'                  => $pronamename, 
                            'unit_id'                   => $valuesub->unit_id,
                            'unit_name'                 => $valuesub->unit_name,
                            'one_price'                 => $valuesub->one_price, 
                        ]);
                    }
                    
                    
                }
                  
            }

            // wh_request::where('wh_request_id',$id)->update([
            //     'active'       => 'CONFIRMSEND'
            // ]);
            wh_stock_export::where('wh_request_id',$id)->update([
                'active'       => 'SENDEXPORT'
            ]); 

            $ip = $request->ip();
                $datenow               = date('Y-m-d');
                $data['m']             = date('H');
                $mm                    = date('H:m:s'); 
                Wh_log::insert([
                    'datesave'           => $datenow,
                    'ip'                 => $ip,
                    'wh_request_id'      => $id,
                    'wh_stock_export_id' => $pro_rep_m->wh_stock_export_id,
                    'wh_stock_dep_id'    => $id_deb,
                    'timesave'           => $mm,
                    'userid'             => Auth::user()->id,
                    'comment'            => 'ยืนยันการตัดจ่าย(ขั้นตอนสุดท้าย)'
                ]);


            
                
            return response()->json([
                'status'     => '200'
            ]);
        
    }
    

     // ********************* คลังย่อย ************************************
     public function wh_sub(Request $request)
    {
        $budget_year                = $request->budget_year;
        $acc_trimart_id             = $request->acc_trimart_id;
        $dabudget_year              = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year           = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date                       = date('Y-m-d');
        $y                          = date('Y') + 543;
        $newweek                    = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate                    = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear                    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_stock_list_only'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        if ($budget_year == '') {
            $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
            $data['bg_yearnow']         = $bgs_year->leave_year_id;
            $bg_yearnow                  = $bgs_year->leave_year_id;

            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.DEPARTMENT_SUB_SUB_ID,a.DEPARTMENT_SUB_SUB_NAME 
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as rec_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as rec_total_price 
                ,(SELECT SUM(qty) FROM wh_pay_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_pay_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as pay_total_price
                FROM department_sub_sub a
                LEFT JOIN wh_stock_sub b ON b.stock_list_subid = a.DEPARTMENT_SUB_SUB_ID
                WHERE b.stock_year = "'.$bg_yearnow.'"
                GROUP BY a.DEPARTMENT_SUB_SUB_ID 
            ');
        } else {
            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.DEPARTMENT_SUB_SUB_ID,a.DEPARTMENT_SUB_SUB_NAME 
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as rec_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as rec_total_price 
                ,(SELECT SUM(qty) FROM wh_pay_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_pay_sub WHERE stock_list_subid = a.DEPARTMENT_SUB_SUB_ID) as pay_total_price
                FROM department_sub_sub a
                LEFT JOIN wh_stock_sub b ON b.stock_list_subid = a.DEPARTMENT_SUB_SUB_ID
                WHERE b.stock_year = "'.$budget_year.'"
                GROUP BY a.DEPARTMENT_SUB_SUB_ID  
            ');
        }
                
        return view('wh.wh_sub', $data,[
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y, 
        ]); 
    }
    public function wh_sub_dep(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;
         
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_product']         = Wh_product::get();
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow                 = $bgs_year->leave_year_id;
        $data['bgyearnow']          = $bgs_year->leave_year_id;

        $data['wh_product']         = DB::select(
            'SELECT e.stock_list_subid,a.pro_id,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name  
            ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE pro_id = e.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_subid ="'.$id.'") as stock_rep
            ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE pro_id = e.pro_id AND export_sub_year ="'.$bg_yearnow.'" AND stock_list_subid ="'.$id.'") as sum_stock_price
            ,(SELECT SUM(qty) FROM wh_pay_sub WHERE pro_id = e.pro_id AND pay_year ="'.$bg_yearnow.'" AND stock_list_subid ="'.$id.'") as stock_pay
            ,(SELECT SUM(total_price) FROM wh_pay_sub WHERE pro_id = e.pro_id AND pay_year ="'.$bg_yearnow.'" AND stock_list_subid ="'.$id.'") as sum_stock_pricepay
            ,a.active ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.DEPARTMENT_SUB_SUB_NAME
            FROM wh_stock_sub e
            LEFT JOIN wh_product a ON a.pro_id = e.pro_id
            LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
            LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
            LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
            LEFT JOIN department_sub_sub f ON f.DEPARTMENT_SUB_SUB_ID = e.stock_list_subid 
            WHERE a.active ="Y" AND e.stock_list_subid ="33" 
            AND e.stock_year = "'.$bg_yearnow.'"
            GROUP BY e.pro_id ORDER BY e.pro_id ASC  
        ');

       
   
        $data['wh_stock_list'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_main             = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$id)->first();
        $data['stock_name']    = $data_main->DEPARTMENT_SUB_SUB_NAME; 
        return view('wh.wh_sub_dep', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
        ]);
    }


    // ************************  Report ************************************
    public function wh_report_month(Request $request)
    {
        $startdate                  = $request->startdate;
        $enddate                    = $request->enddate;
        $budget_year                = $request->budget_year;
        $acc_trimart_id             = $request->acc_trimart_id;
        $dabudget_year              = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year           = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date                       = date('Y-m-d');
        $y                          = date('Y') + 543;
        $newweek                    = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate                    = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear                    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']         = $bgs_year->leave_year_id;
        $bg_yearnow                  = $bgs_year->leave_year_id;
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        // $data['wh_stock_list_only'] = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        if ($budget_year == '') {
            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.stock_list_id,a.stock_list_name
                ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_qty 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_price
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_price     
                FROM wh_stock_list a
                LEFT JOIN wh_stock b ON b.stock_list_id = a.stock_list_id
                WHERE b.stock_year ="'.$bg_yearnow.'"
                GROUP BY a.stock_list_id
            ');
        } else {
            $data['wh_stock_list']         = DB::select(
                'SELECT b.stock_year,a.stock_list_id,a.stock_list_name
                ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_qty 
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_price
                ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_qty
                ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_price     
                FROM wh_stock_list a
                LEFT JOIN wh_stock b ON b.stock_list_id = a.stock_list_id
                WHERE b.stock_year ="'.$budget_year.'"
                GROUP BY a.stock_list_id
            ');
        }
                
        return view('wh.wh_report_month', $data,[
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y, 
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
        ]);
    }


    //******************************* ตั้งค่า **********************************/
    public function wh_product(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
       
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();
        // $data['wh_product'] = DB::table('wh_product')->where('active','=','Y') ->orderBy('pro_id', 'DESC')->get();
        $data['wh_product']    = DB::select(
            'SELECT a.*,b.wh_unit_name,c.wh_type_name 
                FROM wh_product a
                LEFT JOIN wh_unit b ON b.wh_unit_id = a.unit_id
                LEFT JOIN wh_type c ON c.wh_type_id = a.pro_type
                GROUP BY a.pro_id ORDER BY pro_id DESC
        ');
        return view('wh.wh_product', $data);
    }
    public function wh_subplies(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
       
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();
        $data['air_supplies'] = DB::table('air_supplies')->where('active','=','Y') ->orderBy('air_supplies_id', 'DESC')->get();

        return view('wh.wh_subplies', $data);
    }
    public function wh_supplies_save(Request $request)
    { 
     
        $count             = Air_supplies::where('supplies_name',$request->supplies_name)->count();
        if ($count > 0) {
            # code...
        } else {
            Air_supplies::insert([
                'supplies_name'           => $request->supplies_name,
                'supplies_tax'            => $request->supplies_tax,
                'supplies_tel'            => $request->supplies_tel,
                'fax'                     => $request->fax,
                'account_no'              => $request->account_no,
                'account_name'            => $request->account_name,
                'bank_name'               => $request->bank_name,
                'bank_location'           => $request->bank_location,
                'supplies_address'        => $request->supplies_address, 
                // 'user_id'            => Auth::user()->id
            ]);
        }
        
        return response()->json([
            'status'     => '200'
        ]);
         
    }
 
}
