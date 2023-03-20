<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaihekiController extends Controller
{
    public function getGaihekiData(Request $req){
        $gaiheki_area = $this->getGaihekiArea($req);
        $gaiheki_stc = $this->getGaihekiSTC($req);
        $door_data = $this->getEntrance($req);
        $sash_data = $this->getSash($req);

        $this->clearDeletedData($req);
        
        $gaiheki_data = Array(
            "gaiheki_area" => $gaiheki_area,
            "gaiheki_stc" => $gaiheki_stc,
            "door_data" => $door_data,
            "sash_data" => $sash_data
        );

        return $gaiheki_data;
    }

    public function getGaihekiArea($req){
        $gaiheki_area = DB::connection('hrdapps61')->table('gt_gaiheki_area')
        ->select('direction', 'hw_grid as HWgrid', 'hw_point as HWpoint', 'lw_grid as LWgrid', 'lw_point as LWpoint', 'other_point as totalSTC', 'total_point as totalPoint', 'service_check as serviceCheck', 'final_point as finalPoint')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();
        
        return $gaiheki_area;
    }

    public function getGaihekiSTC($req){
        $gaiheki_stc = DB::connection('hrdapps61')->table('gt_stc')
        ->select('id', 'direction', 'computation_type as compType', 'points as compPoints')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();

        return $gaiheki_stc;
    }

    public function getEntrance($req){
        $door_data = DB::connection('hrdapps61')->table('gt_gaiheki_entrance')
        ->select('id', 'direction', 'door_type as doorType', 'quantity as doorQty', 'door_point as doorPoint')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();
        
        return $door_data;
    }

    public function getSash($req){
        $sash_data = DB::connection('hrdapps61')->table('gt_gaiheki_sash')
        ->select('id', 'direction', 'width', 'height', 'with_amado as withAmado', 'inclusion', 'sash_point as sashPoint')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->get();
        
        return $sash_data;
    }

    public function saveGaihekiArea(Request $req){
        date_default_timezone_set('Asia/Manila');

        $data = [];
        array_push($data, $req[0], $req[1], $req[2], $req[3]);

        DB::connection('hrdapps61')->table('gt_gaiheki_area')
        ->where('customer_code', $data[0]['customer_code'])
        ->where('plan_no', $data[0]['plan_no'])
        ->delete();

        for ($i = 0; $i < count($data); $i++) {
            if($data[$i]['totalPoint'] == null){
                continue;
            }else{
                DB::connection('hrdapps61')->table('gt_gaiheki_area')
                ->insert([
                    'customer_code' => $data[$i]['customer_code'],
                    'plan_no' => $data[$i]['plan_no'],
                    'direction' => $data[$i]['direction'],
                    'hw_grid' => $data[$i]['HWgrid'],
                    'hw_point' => $data[$i]['HWpoint'],
                    'lw_grid' => $data[$i]['LWgrid'],
                    'lw_point' => $data[$i]['LWpoint'],
                    'other_point' => $data[$i]['totalSTC'],
                    'total_point' => $data[$i]['totalPoint'],
                    'service_check' => $data[$i]['serviceCheck'],
                    'final_point' => $data[$i]['finalPoint']
                ]);
            }
        }

        $this->saveSTC($data);

        return json_encode(array(
            "message" => "Gaiheki Area data successfully saved!"
        ));
    }

    public function saveSTC($data){
        DB::connection('hrdapps61')->table('gt_stc')
        ->where('customer_code', $data[0]['customer_code'])
        ->where('plan_no', $data[0]['plan_no'])
        ->delete();

        for ($i = 0; $i < count($data); $i++) {
            if (array_key_exists("STCsummaryData", $data[$i])){
                for ($x = 0; $x < count($data[$i]['STCsummaryData']); $x++) {
                    DB::connection('hrdapps61')->table('gt_stc')
                    ->insert([
                        'customer_code' => $data[$i]['customer_code'],
                        'plan_no' => $data[$i]['plan_no'],
                        'direction' => $data[$i]['direction'],
                        'computation_type' => $data[$i]['STCsummaryData'][$x]['compType'],
                        'points' => $data[$i]['STCsummaryData'][$x]['compPoints']
                    ]);
                }
            }
        }
    }

    public function saveEntrance(Request $req){
        DB::connection('hrdapps61')->table('gt_gaiheki_entrance')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        if(count($req->doorData) > 0){
            for ($i = 0; $i < count($req->doorData); $i++) {
                if($req->doorData[$i]["doorPoint"] !== null){
                    DB::connection('hrdapps61')->table('gt_gaiheki_entrance')
                    ->insert([
                        'customer_code' => $req->customer_code,
                        'plan_no' => $req->plan_no,
                        'direction' => $req->doorData[$i]["direction"],
                        'door_type' => $req->doorData[$i]["doorType"],
                        'quantity' => $req->doorData[$i]["doorQty"],
                        'door_point' => $req->doorData[$i]["doorPoint"]
                    ]);
                }
            }

            return json_encode(array(
                "message" => "Door data successfully saved!"
            ));
        }else{
            return json_encode(array(
                "message" => "No Door data to be saved."
            ));
        }
    }

    public function saveSash(Request $req){
        DB::connection('hrdapps61')->table('gt_gaiheki_sash')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->delete();

        if(count($req->sashData) > 0){
            for ($i = 0; $i < count($req->sashData); $i++) {
                if($req->sashData[$i]["width"] !== null){
                    DB::connection('hrdapps61')->table('gt_gaiheki_sash')
                    ->insert([
                        'customer_code' => $req->customer_code,
                        'plan_no' => $req->plan_no,
                        'direction' => $req->sashData[$i]["direction"],
                        'width' => $req->sashData[$i]["width"],
                        'height' => $req->sashData[$i]["height"],
                        'with_amado' => $req->sashData[$i]["withAmado"],
                        'inclusion' => $req->sashData[$i]["inclusion"],
                        'sash_point' => $req->sashData[$i]["sashPoint"]
                    ]);
                }
            }

            return json_encode(array(
                "message" => "Sash data successfully saved!"
            ));
        }else{
            return json_encode(array(
                "message" => "No Sash data to be saved."
            ));
        }
    }

    public function softDeleteSTC(Request $req){
        DB::connection('hrdapps61')->table('gt_stc')
        ->where('id', $req->id)
        ->update([
            'deleted_date' => date("Y-m-d h:i:s")
        ]);
    }

    public function clearDeletedData($req){
        DB::connection('hrdapps61')->table('gt_stc')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->whereNotNull('deleted_date')
        ->delete();

        DB::connection('hrdapps61')->table('gt_gaiheki_sash')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->whereNotNull('deleted_date')
        ->delete();

        DB::connection('hrdapps61')->table('gt_gaiheki_entrance')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->whereNotNull('deleted_date')
        ->delete();
    }
}