<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JikugumiController extends Controller
{
    ///////////////////////////////////////////////// SAVING ////////////////////////////////////////////////////////

    public function saveJikugumiData(Request $req){
        $partial_tarekabe = $this->savePartialTarekabe($req->partialCurved, $req->customer_code, $req->plan_no);
        $whole_tarekabe = $this->saveWholeTarekabe($req->wholeCurved, $req->customer_code, $req->plan_no);
        $below_bands = $this->saveBelowBands($req->belowBands, $req->customer_code, $req->plan_no);
        $perimeter_2f = $this->save2FPerimeter($req->perimeter2F, $req->customer_code, $req->plan_no);
        $perimeter_3f = $this->save3FPerimeter($req->perimeter3F, $req->customer_code, $req->plan_no);
        $hw_2f = $this->save2FHangingWall($req->hangingWall2F, $req->customer_code, $req->plan_no);
        $hw_3f = $this->save3FHangingWall($req->hangingWall3F, $req->customer_code, $req->plan_no);
        $sash = $this->saveJikuSash($req->sashArr, $req->customer_code, $req->plan_no);
        $pent_house = $this->savePentHouse($req->pentArr, $req->customer_code, $req->plan_no);
        $fukiage = $this->saveFukiage($req->fukiageArr, $req->customer_code, $req->plan_no);
        $fukisage = $this->saveFukisage($req->fukisageArr, $req->customer_code, $req->plan_no);
        $roof_deduction = $this->saveRoofDeduction($req->roofDeductionArr, $req->customer_code, $req->plan_no);
        $parapet = $this->saveParapet($req->parapet, $req->customer_code, $req->plan_no);
        $total_points = $this->saveTotal2FJiku($req->totalOptionPoints, $req->customer_code, $req->plan_no);

        $jiku_data = Array(
            "partial_tarekabe" => $partial_tarekabe,
            "whole_tarekabe" => $whole_tarekabe,
            "below_bands" => $below_bands,
            "perimeter_2f" => $perimeter_2f,
            "perimeter_3f" => $perimeter_3f,
            "hw_2f" => $hw_2f,
            "hw_3f" => $hw_3f,
            "sash" => $sash,
            "pent_house" => $pent_house,
            "fukiage" => $fukiage,
            "fukisage" => $fukisage,
            "roof_deduction" => $roof_deduction,
            "parapet" => $parapet,
            "total_points" => $total_points
        );

        return $jiku_data;
    }

    public function savePartialTarekabe($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_partial_curved_tarekabe')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_partial_curved_tarekabe')
            ->update([
                'outside' => $req['outside'],
                'inside' => $req['inside'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Partial Tarekabe updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_partial_curved_tarekabe')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'outside' => $req['outside'],
                'inside' => $req['inside'],
                'total_points' => $req['total_points']
            ]);

            return "Partial Tarekabe saved.";
        }
    }

    public function saveWholeTarekabe($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_whole_curved_tarekabe')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_whole_curved_tarekabe')
            ->update([
                'height' => $req['height'],
                'length' => $req['length'],
                'diameter' => $req['diameter'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Whole Tarekabe updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_whole_curved_tarekabe')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'height' => $req['height'],
                'length' => $req['length'],
                'diameter' => $req['diameter'],
                'total_points' => $req['total_points']
            ]);

            return "Whole Tarekabe saved.";
        }
    }

    public function saveBelowBands($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_below_bands')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_below_bands')
            ->update([
                'below_bands39' => $req['below_bands39'],
                'below_bands37' => $req['below_bands37'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Below Bands updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_below_bands')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'below_bands39' => $req['below_bands39'],
                'below_bands37' => $req['below_bands37'],
                'total_points' => $req['total_points']
            ]);

            return "Below Bands saved.";
        }
    }

    public function save2FPerimeter($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_jiku_perimeter_2f')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_jiku_perimeter_2f')
            ->update([
                'low_waist' => $req['low_waist_2f'],
                'high_waist' => $req['high_waist_2f'],
                'below_balcony' => $req['below_balcony_2f'],
                'between_hw' => $req['between_hw_2f'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "2F Perimeter updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_jiku_perimeter_2f')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'low_waist' => $req['low_waist_2f'],
                'high_waist' => $req['high_waist_2f'],
                'below_balcony' => $req['below_balcony_2f'],
                'between_hw' => $req['between_hw_2f'],
                'total_points' => $req['total_points']
            ]);

            return "2F Perimeter saved.";
        }
    }

    public function save3FPerimeter($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_jiku_perimeter_3f')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_jiku_perimeter_3f')
            ->update([
                'low_waist' => $req['low_waist_3f'],
                'high_waist' => $req['high_waist_3f'],
                'below_balcony_2f' => $req['below_balcony'],
                'between_hw' => $req['between_hw_3f'],
                'floor_3' => $req['perimeter_3f'],
                'below_balcony_3f' => $req['below_balcony_3f'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "3F Perimeter updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_jiku_perimeter_3f')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'low_waist' => $req['low_waist_3f'],
                'high_waist' => $req['high_waist_3f'],
                'below_balcony_2f' => $req['below_balcony'],
                'between_hw' => $req['between_hw_3f'],
                'floor_3' => $req['perimeter_3f'],
                'below_balcony_3f' => $req['below_balcony_3f'],
                'total_points' => $req['total_points']
            ]);

            return "3F Perimeter saved.";
        }
    }

    public function save2FHangingWall($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        if(count($req) > 0){
            if($req[0]['outside'] == null){
                return "No 2F Hanging Wall data.";
            }else{
                DB::connection('hrdapps61')->table('gt_outside_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_opening_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_hangingwall_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_inside_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_hw_total_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();

                foreach($req as $key => $value){
                    //outside
                    DB::connection('hrdapps61')->table('gt_outside_jiku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 2,
                        'length' => $value['outside']
                    ]);

                    //total
                    DB::connection('hrdapps61')->table('gt_hw_total_jiku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 2,
                        'total' => $value['total']
                    ]);

                    //opening
                    foreach($value['opening'] as $key1 => $value1){
                        DB::connection('hrdapps61')->table('gt_opening_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 2,
                            'length' => $value1['length'],
                            'columns' => $value1['column'],
                            'thickness' => $value1['thickness']
                        ]);
                    }

                    //hw
                    foreach($value['hw'] as $key2 => $value2){
                        DB::connection('hrdapps61')->table('gt_hangingwall_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 2,
                            'length' => $value1['length'],
                            'columns' => $value1['column'],
                            'thickness' => $value1['thickness']
                        ]);
                    }

                    //inside
                    foreach($value['inside'] as $key3 => $value3){
                        DB::connection('hrdapps61')->table('gt_inside_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 2,
                            'length' => $value3['length'],
                            'columns' => $value3['column'],
                            'thickness' => $value3['thickness']
                        ]);
                    }
                }

                return "2F Hanging Wall saved.";
            }
        }else{
            return "2F Hanging Wall saved.";
        }
    }

    public function save3FHangingWall($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        if(count($req) > 0){
            if($req[0]['outside'] == null){
                return "No 3F Hanging Wall data.";
            }else{
                DB::connection('hrdapps61')->table('gt_outside_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_opening_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_hangingwall_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_inside_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_hw_total_jiku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();

                foreach($req as $key => $value){
                    //outside
                    DB::connection('hrdapps61')->table('gt_outside_jiku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 3,
                        'length' => $value['outside']
                    ]);

                    //total
                    DB::connection('hrdapps61')->table('gt_hw_total_jiku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 3,
                        'total' => $value['total']
                    ]);

                    //opening
                    foreach($value['opening'] as $key1 => $value1){
                        DB::connection('hrdapps61')->table('gt_opening_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 3,
                            'length' => $value1['length'],
                            'columns' => $value1['column'],
                            'thickness' => $value1['thickness']
                        ]);
                    }

                    //hw
                    foreach($value['hw'] as $key2 => $value2){
                        DB::connection('hrdapps61')->table('gt_hangingwall_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 3,
                            'length' => $value1['length'],
                            'columns' => $value1['column'],
                            'thickness' => $value1['thickness']
                        ]);
                    }

                    //inside
                    foreach($value['inside'] as $key3 => $value3){
                        DB::connection('hrdapps61')->table('gt_inside_jiku')
                        ->insert([
                            'customer_code' => $customer_code,
                            'plan_no' => $plan_no,
                            'hw_id' => $value['id'],
                            'floor' => 3,
                            'length' => $value3['length'],
                            'columns' => $value3['column'],
                            'thickness' => $value3['thickness']
                        ]);
                    }
                }

                return "3F Hanging Wall saved.";
            }
        }else{
            return "3F Hanging Wall saved.";
        }
    }


    public function saveJikuSash($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_jiku_sash')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                if($req[$i]["total"] !== null){
                    DB::connection('hrdapps61')->table('gt_jiku_sash')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'width' => $req[$i]["sashWidth"],
                        'height' => $req[$i]["sashHeight"],
                        'sash_point' => $req[$i]["total"]
                    ]);
                }
            }

            return "Sash data saved.";
        }else{
            return "Sash data is empty.";
        }
    }

    public function savePentHouse($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_jiku_penthouse')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                if($req[$i]["value"] !== null){
                    DB::connection('hrdapps61')->table('gt_jiku_penthouse')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'length' => $req[$i]["value"],
                        'points' => $req[$i]["total"]
                    ]);
                }
            }

            return "Pent House data saved.";
        }else{
            return "Pent House data is empty.";
        }
    }

    public function saveFukiage($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_jiku_fukiage')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_jiku_fukiage')
                ->insert([
                    'customer_code' => $customer_code,
                    'plan_no' => $plan_no,
                    'computation' => $req[$i]["computation"],
                    'points' => $req[$i]["total"],
                    'inputs' => json_encode($req[$i]["inputs"])
                ]);
            }

            return "Fukiage data saved.";
        }else{
            return "Fukiage data is empty.";
        }
    }

    public function saveFukisage($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_jiku_fukisage')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_jiku_fukisage')
                ->insert([
                    'customer_code' => $customer_code,
                    'plan_no' => $plan_no,
                    'computation' => $req[$i]["computation"],
                    'points' => $req[$i]["total"],
                    'inputs' => json_encode($req[$i]["inputs"])
                ]);
            }

            return "Fukisage data saved.";
        }else{
            return "Fukisage data is empty.";
        }
    }
    
    public function saveRoofDeduction($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_jiku_roof_deduction')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_jiku_roof_deduction')
                ->insert([
                    'customer_code' => $customer_code,
                    'plan_no' => $plan_no,
                    'computation' => $req[$i]["computation"],
                    'points' => $req[$i]["total"],
                    'inputs' => json_encode($req[$i]["inputs"])
                ]);
            }

            return "Roof Deduction data saved.";
        }else{
            return "Roof Deduction data is empty.";
        }
    }

    public function saveParapet($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_parapet_jiku')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_parapet_jiku')
            ->update([
                'parapet_041' => $req['parapet_041'],
                'parapet_046' => $req['parapet_046'],
                'parapet_0605' => $req['parapet_0605'],
                'parapet_0274' => $req['parapet_0274'],
                'parapet_0271' => $req['parapet_0271'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Parapet updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_parapet_jiku')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'parapet_041' => $req['parapet_041'],
                'parapet_046' => $req['parapet_046'],
                'parapet_0605' => $req['parapet_0605'],
                'parapet_0274' => $req['parapet_0274'],
                'parapet_0271' => $req['parapet_0271'],
                'total_points' => $req['total_points']
            ]);

            return "Parapet saved.";
        }
    }

    public function saveTotal2FJiku($totalOptionPoints, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->where('item', '2f jiku')
        ->delete();

        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $customer_code,
            'plan_no' => $plan_no,
            'item' => '2f jiku',
            'option_point' => floatval($totalOptionPoints),
            'service_point' => 0
        ]);

        return "2F Jiku Points saved.";
    }

    ///////////////////////////////////////////////// FETCHING ////////////////////////////////////////////////////////

    public function getJikugumiData(Request $req){
        $partial_tarekabe = $this->getPartialTarekabe($req);
        $whole_tarekabe = $this->getWholeTarekabe($req);
        $below_bands = $this->getBelowBands($req);
        $perimeter_2f = $this->get2FPerimeter($req);
        $perimeter_3f = $this->get3FPerimeter($req);
        $hw_2f = $this->get2FHangingWall($req);
        $hw_3f = $this->get3FHangingWall($req);
        $sash = $this->getJikuSash($req);
        $pent_house = $this->getPentHouse($req);
        $fukiage = $this->getFukiage($req);
        $fukisage = $this->getFukisage($req);
        $roof_deduction = $this->getRoofDeduction($req);
        $parapet = $this->getParapet($req);

        $jiku_data = Array(
            "partial_tarekabe" => $partial_tarekabe,
            "whole_tarekabe" => $whole_tarekabe,
            "below_bands" => $below_bands,
            "perimeter_2f" => $perimeter_2f,
            "perimeter_3f" => $perimeter_3f,
            "hw_2f" => $hw_2f,
            "hw_3f" => $hw_3f,
            "sash" => $sash,
            "pent_house" => $pent_house,
            "fukiage" => $fukiage,
            "fukisage" => $fukisage,
            "roof_deduction" => $roof_deduction,
            "parapet" => $parapet
        );

        return $jiku_data;
    }

    public function getPartialTarekabe($req){
        return DB::connection('hrdapps61')->table('gt_partial_curved_tarekabe')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getWholeTarekabe($req){
        return DB::connection('hrdapps61')->table('gt_whole_curved_tarekabe')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getBelowBands($req){
        return DB::connection('hrdapps61')->table('gt_below_bands')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function get2FPerimeter($req){
        return DB::connection('hrdapps61')->table('gt_jiku_perimeter_2f')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function get3FPerimeter($req){
        return DB::connection('hrdapps61')->table('gt_jiku_perimeter_3f')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function get2FHangingWall($req){
        $hangingwall_2f = [];
        //outside
        $outside = DB::connection('hrdapps61')->table('gt_outside_jiku')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('floor', 2)
        ->select('hw_id as id', 'length')
        ->get();

        if(count($outside) > 0){
            foreach($outside as $key => $value){
                $total = DB::connection('hrdapps61')->table('gt_hw_total_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('total')
                ->get();

                $opening = DB::connection('hrdapps61')->table('gt_opening_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw = DB::connection('hrdapps61')->table('gt_hangingwall_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $inside = DB::connection('hrdapps61')->table('gt_inside_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw_obj = array();
                $hw_obj[] = (object) [
                    "id" => $value->id,
                    "outside" => $value->length,
                    "opening" => $opening,
                    "hw" => $hw,
                    "inside" => $inside,
                    "total" => $total[0]->total
                ];

                array_push($hangingwall_2f, $hw_obj[0]);
            }

            return $hangingwall_2f;
        }else{
            return $hangingwall_2f;
        }
    }

    public function get3FHangingWall($req){
        $hangingwall_3f = [];
        //outside
        $outside = DB::connection('hrdapps61')->table('gt_outside_jiku')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('floor', 3)
        ->select('hw_id as id', 'length')
        ->get();

        if(count($outside) > 0){
            foreach($outside as $key => $value){
                $total = DB::connection('hrdapps61')->table('gt_hw_total_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('total')
                ->get();

                $opening = DB::connection('hrdapps61')->table('gt_opening_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw = DB::connection('hrdapps61')->table('gt_hangingwall_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $inside = DB::connection('hrdapps61')->table('gt_inside_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw_obj = array();
                $hw_obj[] = (object) [
                    "id" => $value->id,
                    "outside" => $value->length,
                    "opening" => $opening,
                    "hw" => $hw,
                    "inside" => $inside,
                    "total" => $total[0]->total
                ];

                array_push($hangingwall_3f, $hw_obj[0]);
            }

            return $hangingwall_3f;
        }else{
            return $hangingwall_3f;
        }
    }

    public function getJikuSash($req){
        return DB::connection('hrdapps61')->table('gt_jiku_sash')
                ->select('width as sashWidth', 'height as sashHeight', 'sash_point as total')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getPentHouse($req){
        return DB::connection('hrdapps61')->table('gt_jiku_penthouse')
                ->select('length as value', 'points as total')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getFukiage($req){
        $fukiage = DB::connection('hrdapps61')
            ->select(DB::raw("select computation, points as total, json_unquote(inputs) as inputs
                from gt_jiku_fukiage
                where customer_code = '$req->customer_code'
                and plan_no = '$req->plan_no'
            "));

            foreach($fukiage as $key) {
                $key->inputs = json_decode($key->inputs);
            }
            return $fukiage;
    }

    public function getFukisage($req){
        $fukisage = DB::connection('hrdapps61')
            ->select(DB::raw("select computation, points as total, json_unquote(inputs) as inputs
                from gt_jiku_fukisage
                where customer_code = '$req->customer_code'
                and plan_no = '$req->plan_no'
            "));

            foreach($fukisage as $key) {
                $key->inputs = json_decode($key->inputs);
            }
            return $fukisage;
    }

    public function getRoofDeduction($req){
        $roof_deduction = DB::connection('hrdapps61')
            ->select(DB::raw("select computation, points as total, json_unquote(inputs) as inputs
                from gt_jiku_roof_deduction
                where customer_code = '$req->customer_code'
                and plan_no = '$req->plan_no'
            "));

            foreach($roof_deduction as $key) {
                $key->inputs = json_decode($key->inputs);
            }
            return $roof_deduction;
    }

    public function getParapet($req){
        return DB::connection('hrdapps61')->table('gt_parapet_jiku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }
}
