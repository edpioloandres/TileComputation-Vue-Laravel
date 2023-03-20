<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    public function getColumn(Request $req){
        $column_data = DB::connection('hrdapps61')->table('gt_column')
        ->select('column_type as columnName', 'kind', 'quantity', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();
        
        $column_point = DB::connection('hrdapps61')->table('gt_category_points')
        ->select('option_point', 'service_point')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'column_point')
        ->get();
        
        return json_encode(array(
            "column_data" => $column_data,
            "column_point" => $column_point
        ));
    }

    public function saveColumn(Request $req){
        DB::connection('hrdapps61')->table('gt_column')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        if(count($req->columnArr) > 0){
            for ($i = 0; $i < count($req->columnArr); $i++) {
                DB::connection('hrdapps61')->table('gt_column')
                ->insert([
                    'customer_code' => $req->columnArr[$i]["customer_code"],
                    'plan_no' => $req->columnArr[$i]["plan_no"],
                    'column_type' => $req->columnArr[$i]["columnName"],
                    'kind' => $req->columnArr[$i]["kind"],
                    'quantity' => $req->columnArr[$i]["quantity"],
                    'option_points' => $req->columnArr[$i]["tempOption"],
                    'service_points' => $req->columnArr[$i]["tempService"]
                ]);
            }

            $this->saveColumnPoint($req);

            return json_encode(array(
                "message" => "Column data successfully saved!"
            ));
        }else{
            return json_encode(array(
                "message" => "Column data is empty."
            ));
        }
    }

    public function saveColumnPoint($req){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->columnArr[0]["customer_code"])
        ->where('plan_no', $req->columnArr[0]["plan_no"])
        ->where('item', 'column')
        ->delete();
        
        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $req->columnArr[0]["customer_code"],
            'plan_no' => $req->columnArr[0]["plan_no"],
            'item' => 'column',
            'option_point' => floatval($req->optionPoint),
            'service_point' => floatval($req->servicePoint)
        ]);
    }
}
