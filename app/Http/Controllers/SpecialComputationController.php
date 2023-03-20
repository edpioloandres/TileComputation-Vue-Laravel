<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialComputationController extends Controller
{
    public function getSpecialComputations(Request $req){
        $computations = DB::connection('hrdapps61')->table('gt_special_computations')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        $points = DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'additional')
        ->where('item', 'deduction')
        ->get();

        return Array(
            "computations" => $computations,
            "points" => $points
        );
    }

    public function saveSpecialComputations(Request $req){
        DB::connection('hrdapps61')->table('gt_special_computations')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        for ($i = 0; $i < count($req->additionalData); $i++) {
            if($req->additionalData[$i]["input"] == ""){
                $i++;
            }else{
                DB::connection('hrdapps61')->table('gt_special_computations')
                ->insert([
                    'customer_code' => $req->customer_code,
                    'plan_no' => $req->plan_no,
                    'input' => $req->additionalData[$i]["input"],
                    'answer' => $req->additionalData[$i]["answer"],
                    'category' => "additional"
                ]);
            }
            
        }

        for ($i = 0; $i < count($req->deductionData); $i++) {
            if($req->deductionData[$i]["input"] == ""){
                $i++;
            }else{
                DB::connection('hrdapps61')->table('gt_special_computations')
                ->insert([
                    'customer_code' => $req->customer_code,
                    'plan_no' => $req->plan_no,
                    'input' => $req->deductionData[$i]["input"],
                    'answer' => $req->deductionData[$i]["answer"],
                    'category' => "deduction"
                ]);
            }
        }

        $this->saveSpecialComputationPoint($req);

        return json_encode(array(
            "message" => "Special computations successfully saved!"
        ));
    }

    public function saveSpecialComputationPoint($req){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'additional')
        ->delete();

        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('item', 'deduction')
        ->delete();

        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $req->customer_code,
            'plan_no' => $req->plan_no,
            'item' => 'additional',
            'option_point' => floatval($req->totalAdditional),
            'service_point' => 0
        ]);

        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $req->customer_code,
            'plan_no' => $req->plan_no,
            'item' => 'deduction',
            'option_point' => floatval($req->totalDeduction),
            'service_point' => 0
        ]);
    }
}
