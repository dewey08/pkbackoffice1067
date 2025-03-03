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
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
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
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use App\Models\Article;
use App\Models\Land;
use App\Models\Building;
use App\Models\User_permiss;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_room_status;
use App\Models\Building_room_list;
use App\Models\Food_list;
use App\Models\Meeting_list;
use App\Models\Meeting_objective;
use App\Models\Budget_year;
use App\Models\Meeting_service;
use App\Models\Meeting_service_list;
use App\Models\Meeting_service_food;
use App\Models\Orginfo;
use App\Models\Market_product;
use App\Models\Market_product_category;
use App\Models\Market_product_rep;
use App\Models\Market_product_repsub;
use DataTables;
use App\Models\Market_basket;
use App\Models\Market_basket_bill;
use App\Models\Car_service;
use App\Models\Car_location;
use App\Models\Carservice_signature;
use App\Models\Car_service_personjoin;

class StaticController extends Controller
{
  public static function idselect($id)
  {
    $idselect =  Car_service::where('car_service_id','=',$id)->first();
    $locate_list = $idselect->car_service_location;

    return $locate_list;
  }
  public static function count_car_service_po()
  {
    $count =  Car_service::where('car_service_status','=','allocate')->orwhere('car_service_status','=','allocateall')->count();
    return $count;
  }
  public static function count_car_service()
  {
    $count =  Car_service::leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')->where('article_data.article_car_type_id','!=',2)->where('car_service_status','=','request')->count();
    return $count;
  }
  public static function count_car_service_ambu()
  {
    $count =  Car_service::leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')->where('article_data.article_car_type_id','=',2)->where('car_service_status','=','request')->count();
    return $count;
  }


  public static function countpesmiss_per($iduser)
  {
    $percount =  User::where('id','=',$iduser)->where('permiss_person','=','on')->count();
    return $percount;
  }
  public static function countpesmiss_book($iduser)
  {
    $bookcount =  User::where('id','=',$iduser)->where('permiss_book','=','on')->count();
    return $bookcount;
  }
  public static function countpesmiss_car($iduser)
  {
    $bookcount =  User::where('id','=',$iduser)->where('permiss_car','=','on')->count();
    return $bookcount;
  }
  public static function countpesmiss_meetting($iduser)
  {
    $meettingcount =  User::where('id','=',$iduser)->where('permiss_meetting','=','on')->count();
    return $meettingcount;
  }
  public static function countpesmiss_repair($iduser)
  {
    $repaircount =  User::where('id','=',$iduser)->where('permiss_repair','=','on')->count();
    return $repaircount;
  }
  public static function countpesmiss_com($iduser)
  {
    $comcount =  User::where('id','=',$iduser)->where('permiss_com','=','on')->count();
    return $comcount;
  }
  public static function countpesmiss_medical($iduser)
  {
    $medicalcount =  User::where('id','=',$iduser)->where('permiss_medical','=','on')->count();
    return $medicalcount;
  }
  public static function countpesmiss_hosing($iduser)
  {
    $hosingcount =  User::where('id','=',$iduser)->where('permiss_hosing','=','on')->count();
    return $hosingcount;
  }
  public static function countpesmiss_plan($iduser)
  {
    $plancount =  User::where('id','=',$iduser)->where('permiss_plan','=','on')->count();
    return $plancount;
  }
  public static function countpesmiss_asset($iduser)
  {
    $assetcount =  User::where('id','=',$iduser)->where('permiss_asset','=','on')->count();
    return $assetcount;
  }
  public static function countpesmiss_supplies($iduser)
  {
    $suppliescount =  User::where('id','=',$iduser)->where('permiss_supplies','=','on')->count();
    return $suppliescount;
  }
  public static function countpesmiss_store($iduser)
  {
    $storecount =  User::where('id','=',$iduser)->where('permiss_store','=','on')->count();
    return $storecount;
  }
  public static function countpesmiss_store_dug($iduser)
  {
    $store_dugcount =  User::where('id','=',$iduser)->where('permiss_store_dug','=','on')->count();
    return $store_dugcount;
  }
  public static function countpesmiss_pay($iduser)
  {
    $paycount =  User::where('id','=',$iduser)->where('permiss_pay','=','on')->count();
    return $paycount;
  }
  public static function countadmin($iduser)
  {
    $adcount =  User::where('id','=',$iduser)->where('type','=','ADMIN')->count();
    return $adcount;
  }
  public static function countpesmiss_money($iduser)
  {
    $paycount =  User::where('id','=',$iduser)->where('permiss_money','=','on')->count();
    return $paycount;
  }
  public static function permiss_report_all($iduser)
  {
    $reportcount =  User::where('id','=',$iduser)->where('permiss_report_all','=','on')->count();
    return $reportcount;
  }
  public static function permiss_sot($iduser)
  {
    $permiss_sotcount =  User::where('id','=',$iduser)->where('permiss_sot','=','on')->count();
    return $permiss_sotcount;
  }
  public static function permiss_clinic_tb($iduser)
  {
    $permiss_clinic_tbcount =  User::where('id','=',$iduser)->where('permiss_clinic_tb','=','on')->count();
    return $permiss_clinic_tbcount;
  }
  public static function permiss_medicine_salt($iduser)
  {
    $permiss_medicine_saltcount =  User::where('id','=',$iduser)->where('permiss_medicine_salt','=','on')->count();
    return $permiss_medicine_saltcount;
  }
  public static function pesmiss_ct($iduser)
  {
    $pesmiss_ctcount =  User::where('id','=',$iduser)->where('pesmiss_ct','=','on')->count();
    return $pesmiss_ctcount;
  }
  public static function per_prs($iduser)
  {
    $per_prscount =  User::where('id','=',$iduser)->where('per_prs','=','on')->count();
    return $per_prscount;
  }
  public static function per_cctv($iduser)
  {
    $per_cctvcount =  User::where('id','=',$iduser)->where('per_cctv','=','on')->count();
    return $per_cctvcount;
  }
  public static function per_fire($iduser)
  {
    $per_firecount =  User::where('id','=',$iduser)->where('per_fire','=','on')->count();
    return $per_firecount;
  }
  public static function per_air($iduser)
  {
    $per_aircount =  User::where('id','=',$iduser)->where('per_air','=','on')->count();
    return $per_aircount;
  }
  public static function per_nurse($iduser)
  {
    // $per_nurse =  User::where('id','=',$iduser)->where('per_nurse','=','on')->count();
    $per_nurse =  User::where('id','=',$iduser)->where('dep_id','=','5')->count();
    return $per_nurse;
  }
  public static function per_config($iduser)
  {
    $per_config =  User::where('id','=',$iduser)->where('per_config','=','on')->count();
    return $per_config;
  }
  public static function per_fdh($iduser)
  {
    $per_fdh =  User::where('id','=',$iduser)->where('per_fdh','=','on')->count();
    return $per_fdh;
  }
  public static function per_den($iduser)
  {
    $per_den =  User::where('id','=',$iduser)->where('permiss_dental','=','on')->count();
    return $per_den;
  }
  public static function per_accb01($iduser)
  {
    $per_accb01 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACCB01')->count();
    return $per_accb01;
  }
  public static function pre_audit($iduser)
  {
    $pre_audit =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','AUDITVET01')->count();
    return $pre_audit;
  }
  public static function timeot($iduser)
  {
    $timeot =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','TIMEOT01')->count();
    return $timeot;
  }
  public static function pediatrics($iduser)
  {
    $pediatrics =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','PEDIA01')->count();
    return $pediatrics;
  }

  public static function reportacc($iduser)
  {
    $pediatrics =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','PEDIA01')->count();
    return $pediatrics;
  }
  // public static function pediatrics($iduser)
  // {
  //   $pediatrics =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','PEDIA01')->count();
  //   return $pediatrics;
  // }
  public static function account_ar($iduser)
  {
    $account_ar =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACCOUNTAR')->count();
    return $account_ar;
  }
  public static function fdh_new($iduser)
  {
    $fdh_new =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','FDH')->count();
    return $fdh_new;
  }
  public static function settting_admin($iduser)
  {
    $settting_admin =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ADMIN')->count();
    return $settting_admin;
  }

  public static function kongthoon($iduser)
  {
    $kongthoon =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','KONGTOON')->count();
    return $kongthoon;
  }
  public static function acc_106($iduser)
  {
    $acc_106 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','OVERSUE_OP')->count();
    return $acc_106;
  }
  public static function acc_107($iduser)
  {
    $acc_107 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','OVERSUE_IP')->count();
    return $acc_107;
  }
  public static function acc_report($iduser)
  {
    $acc_report =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_REPORT')->count();
    return $acc_report;
  }
  public static function acc_50x($iduser)
  {
    $acc_50x =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_50X')->count();
    return $acc_50x;
  }
  public static function acc_70x($iduser)
  {
    $acc_70x =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_70X')->count();
    return $acc_70x;
  }

  public static function acc_201($iduser)
  {
    $acc_201 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_201')->count();
    return $acc_201;
  }
  public static function acc_202($iduser)
  {
    $acc_202 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_202')->count();
    return $acc_202;
  }
  public static function acc_203($iduser)
  {
    $acc_203 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_203')->count();
    return $acc_203;
  }
  public static function acc_209($iduser)
  {
    $acc_209 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_209')->count();
    return $acc_209;
  }
  public static function acc_216($iduser)
  {
    $acc_216 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_216')->count();
    return $acc_216;
  }
  public static function acc_217($iduser)
  {
    $acc_217 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_217')->count();
    return $acc_217;
  }

  public static function acc_301($iduser)
  {
    $acc_301 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_301')->count();
    return $acc_301;
  }
  public static function acc_302($iduser)
  {
    $acc_302 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_302')->count();
    return $acc_302;
  }
  public static function acc_303($iduser)
  {
    $acc_303 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_303')->count();
    return $acc_303;
  }
  public static function acc_304($iduser)
  {
    $acc_304 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_304')->count();
    return $acc_304;
  }
  public static function acc_307($iduser)
  {
    $acc_307 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_307')->count();
    return $acc_307;
  }
  public static function acc_308($iduser)
  {
    $acc_308 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_308')->count();
    return $acc_308;
  }
  public static function acc_309($iduser)
  {
    $acc_309 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_309')->count();
    return $acc_309;
  }
  public static function acc_310($iduser)
  {
    $acc_310 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACC_310')->count();
    return $acc_310;
  }
  // public static function acc_310($iduser)
  // {
  //   $acc_310 =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','ACCB01')->count();
  //   return $acc_310;
  // }



  public static function store_normal($iduser)
  {
    $store_normal =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','STORE_NORMAL')->count();
    return $store_normal;
  }
  public static function store_vip($iduser)
  {
    $store_vip =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','STORE_VIP')->count();
    return $store_vip;
  }
  public static function store_rep($iduser)
  {
    $store_rep =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','STORE_REP')->count();
    return $store_rep;
  }
  public static function checkup($iduser)
  {
    $checkup =  User_permiss::where('user_id','=',$iduser)->where('user_permiss_num','=','CHECKUP')->count();
    return $checkup;
  }









  public static function countpesmiss_claim($iduser)
  {
    $claimcount =  User::where('id','=',$iduser)->where('permiss_claim','=','on')->count();
    return $claimcount;
  }

  public static function countpermiss_gleave($iduser)
  {
    $countgleave =  User::where('id','=',$iduser)->where('permiss_gleave','=','on')->count();
    return $countgleave;
  }
  public static function countpermiss_ot($iduser)
  {
    $countot =  User::where('id','=',$iduser)->where('permiss_ot','=','on')->count();
    return $countot;
  }
  public static function countpermiss_medicine($iduser)
  {
    $countmedicine =  User::where('id','=',$iduser)->where('permiss_medicine','=','on')->count();
    return $countmedicine;
  }
  public static function countpermiss_p4p($iduser)
  {
    $comcountp4p =  User::where('id','=',$iduser)->where('permiss_p4p','=','on')->count();
    return $comcountp4p;
  }
  public static function countpermiss_time($iduser)
  {
    $comcounttime =  User::where('id','=',$iduser)->where('permiss_time','=','on')->count();
    return $comcounttime;
  }

  public static function countpermiss_env($iduser)
  {
    $comcountenv =  User::where('id','=',$iduser)->where('permiss_env','=','on')->count();
    return $comcountenv;
  }
  public static function permiss_setting($iduser)
  {
    $envcount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_ENV')->count();
    return $envcount;
  }
  public static function permiss_ware($iduser)
  {
    $warecount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_WAREHOUSE')->count();
    return $warecount;
  }
  public static function permiss_account($iduser)
  {
    $permiss_account=  User::where('id','=',$iduser)->where('permiss_account','=','on')->count();
    return $permiss_account;
  }
  public static function permiss_setting_upstm($iduser)
  {
    $permiss_setting_upstm=  User::where('id','=',$iduser)->where('permiss_setting_upstm','=','on')->count();
    return $permiss_setting_upstm;
  }
  public static function permiss_setting_env($iduser)
  {
    $permiss_setting_env=  User::where('id','=',$iduser)->where('permiss_setting_env','=','on')->count();
    return $permiss_setting_env;
  }
  public static function permiss_ucs($iduser)
  {
    $permiss_ucs=  User::where('id','=',$iduser)->where('permiss_ucs','=','on')->count();
    return $permiss_ucs;
  }
  public static function permiss_sss($iduser)
  {
    $permiss_sss=  User::where('id','=',$iduser)->where('permiss_sss','=','on')->count();
    return $permiss_sss;
  }
  public static function permiss_ofc($iduser)
  {
    $permiss_ofc=  User::where('id','=',$iduser)->where('permiss_ofc','=','on')->count();
    return $permiss_ofc;
  }
  public static function permiss_lgo($iduser)
  {
    $permiss_lgo=  User::where('id','=',$iduser)->where('permiss_lgo','=','on')->count();
    return $permiss_lgo;
  }
  public static function permiss_prb($iduser)
  {
    $permiss_prb=  User::where('id','=',$iduser)->where('permiss_prb','=','on')->count();
    return $permiss_prb;
  }
  public static function permiss_ti($iduser)
  {
    $permiss_ti=  User::where('id','=',$iduser)->where('permiss_ti','=','on')->count();
    return $permiss_ti;
  }
  public static function permiss_rep_money($iduser)
  {
    $permiss_rep_money=  User::where('id','=',$iduser)->where('permiss_rep_money','=','on')->count();
    return $permiss_rep_money;
  }

  // public static function permiss_account($iduser)
  // {
  //   $accountcount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_ACCOUNT')->count();
  //   return $accountcount;
  // }
  // public static function permiss_ucs($iduser)
  // {
  //   $ucscount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_UCS')->count();
  //   return $ucscount;
  // }
  // public static function permiss_sss($iduser)
  // {
  //   $ssscount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_SSS')->count();
  //   return $ssscount;
  // }
  // public static function permiss_ofc($iduser)
  // {
  //   $ofccount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_OFC')->count();
  //   return $ofccount;
  // }
  // public static function permiss_lgo($iduser)
  // {
  //   $lgocount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_LGO')->count();
  //   return $lgocount;
  // }
  // public static function permiss_prb($iduser)
  // {
  //   $prbcount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_PRB')->count();
  //   return $prbcount;
  // }
  // public static function permiss_ti($iduser)
  // {
  //   $ticount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_TI')->count();
  //   return $ticount;
  // }

  public static function permiss_upstm($iduser)
  {
    $upstmcount=  DB::table('permiss_setting')->where('permiss_setting_userid','=',$iduser)->where('permiss_setting_name','=','SET_UPSTM')->count();
    return $upstmcount;
  }





  public static function orginfo()
  {
    $org =  Orginfo::where('orginfo_id','=',1)->first();

    return $org;
  }
  public static function orginfo_headep($iduser)
  {
    $org_headep =  Orginfo::where('orginfo_manage_id','=',$iduser)->count();
    // $org_headep = $iduser;

    return $org_headep;
  }
  public static function orginfo_po($iduser)
  {
    $org_po =  Orginfo::where('orginfo_id','=',1)->where('orginfo_po_id','=',$iduser)->count();

    return $org_po;
  }
  public static function countleader($iduser)
  {
    $leader =  Leave_leader::where('leader_id','=',$iduser)->count();
    return $leader;
  }

    public static function checkuser($iduser)
    {
        $person = User::where('id','=',$iduser)->first();

         if( $person->HR_DEPARTMENT_ID == '' ||  $person->HR_DEPARTMENT_SUB_ID == '' ||  $person->HR_DEPARTMENT_SUB_SUB_ID == ''){
            $checkinfouser=  0;
         }else{
            $checkinfouser =  1;
         }
         return $checkinfouser;
    }
      //  public static function checkpo($iduser)
      //  {
      //   $count =  Permislist::where('PERSON_ID','=',$iduser)
      //                         ->where('PERMIS_ID','=','HORG')
      //                         ->count();
      //   return $count;
      //  }
    public static function checkhn($iduser)
    {
      $count =  Leave_leader::where('leader_id','=',$iduser)->count();

      return $count;
    }

    //หัวหน้าเห็นชอบขอซื้อขอจ้าง
    public static function checkhnshow($iduser)
    {
      $count =  Leave_leader_sub::where('user_id','=',$iduser)->count();

      return $count;
    }

    public static function count_suprephn($iduser)
    {
      $count =  Products_request::where('request_hn_id','=',$iduser)->where('request_status','=','REQUEST')->count();

      return $count;
    }
    public static function count_article_car()
    {
      $count =  Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')->count();
      return $count;
    }

    public static function count_land()
    {
      $count =  Land::count();
      return $count;
    }
    public static function count_building()
    {
      $count =  Building::count();
      return $count;
    }
    public static function count_article()
    {
      $count =  Article::count();
      return $count;
    }
    public static function count_level()
    {
      $count =  Building_level::count();
      return $count;
    }
    public static function count_product()
    {
      $count =  Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->count();
      return $count;
    }
    public static function count_service()
    {
      $count =  Products::where('product_groupid','=',4)->count();
      return $count;
    }
    public static function count_meettingroom()
    {
      $count =  Building_level_room::where('room_type','!=','1')->count();
      return $count;
    }
    public static function count_hosing()
    {
      $count =  Building::where('building_type_id','!=','1')->where('building_type_id','!=','5')->count();
      return $count;
    }
    public static function count_meettinservice()
    {
      $count =  Meeting_service::where('meetting_status','=','REQUEST')->count();
      return $count;
    }
    public static function count_bookrep_rong()
    {
      $count =  Bookrep::where('bookrep_send_code','=','waitretire')->count();
      return $count;
    }
    public static function count_bookrep_po()
    {
      $count1 =  Bookrep::where('bookrep_send_code','=','retire')->count();  // เกษียณ
      $count2 =  Bookrep::where('bookrep_send_code','=','waitallows')->count();  //เสนอ ผอ.
      $count3 = $count1 + $count2;

      return $count3;
    }

    public static function countsendbook_po($id)
    {
      $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count();
      return $adcount;
    }





    public static function count_marketproducts()
    {
      $count =  Market_product::count();
      return $count;
    }
    public static function count_market_repproducts()
    {
      $count =  Market_product_rep::count();
      return $count;
    }
    public static function count_market_bill()
    {
      $count =  Market_basket_bill::count();
      return $count;
    }
     //****************** ฟังก์ชั่น sum */
     public static function sumrecieve($id)
     {
          $sumrecieve  =  Market_product_repsub::where('request_sub_product_code','=',$id)->sum('request_sub_qty');

         return $sumrecieve ;
     }
     public static function sumpay($id)
     {
          $sumpay  =  Clinic_pay_store::where('PAYDETAIL_DRUG_ID','=',$id)->sum('PAYDETAIL_DRUG_QTY');

        return $sumpay ;
     }

     public static function sumtotalqty($icode)
    {

        // $sumdrughos_qty  =  Opitemrece::where('icode','=',$icode)->sum('qty');

         $sumrecieve  =  Market_product_repsub::where('request_sub_product_code','=',$icode)->sum('request_sub_qty');

        //  $sumpay  =  Clinic_pay_store::where('PAYDETAIL_DRUG_CODE','=',$icode)->sum('PAYDETAIL_DRUG_QTY');

        //  $sumsympay  =  Clinic_sym_detail::where('SYM_DETAIL_DRUGID','=',$icode)->sum('SYM_DETAIL_DRUGQTY');

        //  $totalvalue = $sumrecieve - $sumpay ;
         $totalvalue = $sumrecieve ;

       return $totalvalue ;
    }

    public static function sumsaleindex()
    {
        //  $sumsaleindex  =  Market_basket::leftjoin('market_basket_bill','market_basket_bill.bill_id','=','market_basket.bill_id')
        //  ->where('market_basket_bill.bill_id','=',$id)->sum('basket_sum_price');

        //  $sumsaleindex  =  Market_basket::where('bill_id','=',$id)->sum('basket_sum_price');

         $sumsaleindex  =  Market_basket::sum('basket_sum_price');

       return $sumsaleindex ;
    }

}
