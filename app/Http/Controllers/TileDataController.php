<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TileDataController extends Controller
{
    public function getMaster(){
        $sashSize = DB::connection('hrdapps61')->table('gm_sashsize')
        ->select('width', 'width_value', 'height', 'height_value')
        ->get();

        $brickPoints = DB::connection('hrdapps61')->table('gm_excessbrickpoints')
        ->select('roof_type', 'pitch', 'brick_point')
        ->get();

        $master = Array(
            "sashSize" => $sashSize,
            "brickPoints" => $brickPoints
        );

        return $master;
    }

    public function getDemadoMaster(Request $req){ // corresponding point per demado type
        return DB::connection('hrdapps61')->table('gm_demadopoints')
        ->select('demado_points')
        ->where('kanabakari', $req->kanabakari)
        ->where('demado_name', $req->demado_name)
        ->where('demado_size', $req->demado_size)
        ->get();
    }

    public function getTilePoints(Request $req){ // total computed tile points
        $tile_data = DB::connection('hrdapps61')->table('gt_category_points')
        ->select('item', 'service_point as servicePoints', 'option_point as optionPoints')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();
        
        return $tile_data;
    }

    public function getAllData(Request $req){
        $demado_data = DB::connection('hrdapps61')->table('gt_unitdemado')
        ->select('demado_kind as kinds', 'quantity', 'unit_assembly as unitAssembly', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $balcony_data = DB::connection('hrdapps61')->table('gt_balcony')
        ->select('balcony_type as type', 'kind as kinds', 'left_side as left', 'center_side as center',
                'right_side as right', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $column_data = DB::connection('hrdapps61')->table('gt_column')
        ->select('column_type as columnName', 'kind', 'quantity', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $special = DB::connection('hrdapps61')->table('gt_special_computations')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        return json_encode(array(
            "demado_data" => $demado_data,
            "balcony_data" => $balcony_data,
            "column_data" => $column_data,
            "special" => $special
        ));
    }

    public function saveTotalPoints(Request $req){
        DB::connection('hrdapps61')->table('gt_points_summary')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        DB::connection('hrdapps61')->table('gt_points_summary')
        ->insert([
            'customer_code' => $req->customer_code,
            'plan_no' => $req->plan_no,
            'option_point' => floatval($req->totalOption),
            'service_point' => floatval($req->totalService)
        ]);
    }
}
