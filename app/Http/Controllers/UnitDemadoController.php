<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitDemadoController extends Controller
{
    public function getUnitDemado(Request $req){
        $demado_data = DB::connection('hrdapps61')->table('gt_unitdemado')
        ->select('demado_kind as kinds', 'quantity', 'unit_assembly as unitAssembly', 'option_points as tempOption', 'service_points as tempService')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $demado_point = DB::connection('hrdapps61')->table('gt_category_points')
        ->select('option_point', 'service_point')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'unit demado')
        ->get();
        
        return json_encode(array(
            "demado_data" => $demado_data,
            "demado_point" => $demado_point
        ));
    }

    public function saveUnitDemado(Request $req){
        DB::connection('hrdapps61')->table('gt_unitdemado')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        if(count($req->demadoArr) > 0){
            for ($i = 0; $i < count($req->demadoArr); $i++) {
                DB::connection('hrdapps61')->table('gt_unitdemado')
                ->insert([
                    'customer_code' => $req->demadoArr[$i]["customer_code"],
                    'plan_no' => $req->demadoArr[$i]["plan_no"],
                    'demado_kind' => $req->demadoArr[$i]["kinds"],
                    'quantity' => intval($req->demadoArr[$i]["quantity"]),
                    'unit_assembly' => $req->demadoArr[$i]["unitAssembly"],
                    'option_points' => $req->demadoArr[$i]["tempOption"],
                    'service_points' => $req->demadoArr[$i]["tempService"]
                ]);
            }

            $this->saveUnitDemadoPoint($req);

            return json_encode(array(
                "message" => "Unit Demado data successfully saved!"
            ));
        }else{
            return json_encode(array(
                "message" => "Unit Demado data is empty."
            ));
        }
    }

    public function saveUnitDemadoPoint($req){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'unit demado')
        ->delete();
        
        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $req->customer_code,
            'plan_no' => $req->plan_no,
            'item' => 'unit demado',
            'option_point' => floatval($req->optionPoint),
            'service_point' => floatval($req->servicePoint)
        ]);
    }
}