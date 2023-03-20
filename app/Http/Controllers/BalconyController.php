<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalconyController extends Controller
{
    public function getBalcony(Request $req){
        $balcony_data = DB::connection('hrdapps61')->table('gt_balcony')
        ->select('balcony_type as type', 'kind as kinds', 'left_side as left', 'center_side as center',
                'right_side as right', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $balcony_point = DB::connection('hrdapps61')->table('gt_category_points')
        ->select('option_point', 'service_point')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'balcony_point')
        ->get();
        
        return json_encode(array(
            "balcony_data" => $balcony_data,
            "balcony_point" => $balcony_point
        ));
    }

    public function saveBalcony(Request $req){
        DB::connection('hrdapps61')->table('gt_balcony')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        if(count($req->balconyArr) > 0){
            for ($i = 0; $i < count($req->balconyArr); $i++) {
                DB::connection('hrdapps61')->table('gt_balcony')
                ->insert([
                    'customer_code' => $req->balconyArr[$i]["customer_code"],
                    'plan_no' => $req->balconyArr[$i]["plan_no"],
                    'balcony_type' => $req->balconyArr[$i]["type"],
                    'kind' => $req->balconyArr[$i]["kinds"],
                    'left_side' => $req->balconyArr[$i]["left"],
                    'center_side' => $req->balconyArr[$i]["center"],
                    'right_side' => $req->balconyArr[$i]["right"],
                    'option_points' => $req->balconyArr[$i]["tempOption"],
                    'service_points' => $req->balconyArr[$i]["tempService"]
                ]);
            }

            $this->saveBalconyPoint($req);

            return json_encode(array(
                "message" => "Balcony data successfully saved!"
            ));
        }else{
            return json_encode(array(
                "message" => "Balcony data is empty."
            ));
        }
    }

    public function saveBalconyPoint($req){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->balconyArr[0]["customer_code"])
        ->where('plan_no', $req->balconyArr[0]["plan_no"])
        ->where('item', 'balcony')
        ->delete();

        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $req->balconyArr[0]["customer_code"],
            'plan_no' => $req->balconyArr[0]["plan_no"],
            'item' => 'balcony',
            'option_point' => floatval($req->optionPoint),
            'service_point' => floatval($req->servicePoint)
        ]);
    }
}
