<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WakugumiController extends Controller
{
    public function saveWakugumiData(Request $req){
        $perimeter_3f = $this->save3FPerimeter($req->perimeter3F, $req->customer_code, $req->plan_no);
        $sash = $this->saveWakuSash($req->sashArr, $req->customer_code, $req->plan_no);
        $fukiage = $this->saveFukiage($req->fukiageArr, $req->customer_code, $req->plan_no);
        $fukisage = $this->saveFukisage($req->fukisageArr, $req->customer_code, $req->plan_no);
        $roof_deduction = $this->saveRoofDeduction($req->roofDeductionArr, $req->customer_code, $req->plan_no);
        $design_louver = $this->saveDesignLouver($req->designLouver, $req->customer_code, $req->plan_no);
        $hw_2f = $this->save2FHangingWall($req->hangingWall2F, $req->customer_code, $req->plan_no);
        $hw_3f = $this->save3FHangingWall($req->hangingWall3F, $req->customer_code, $req->plan_no);
        $roof_garden = $this->saveRoofGarden($req->roofGardenArr, $req->customer_code, $req->plan_no);
        $pent_house = $this->savePentHouse($req->pentArr, $req->customer_code, $req->plan_no);
        $roof_garden_deduction = $this->saveRoofGardenDeduction($req->roofGardenDeduction, $req->customer_code, $req->plan_no);
        $hw_roof_garden = $this->saveHWRoofGarden($req->hwRoofGarden, $req->customer_code, $req->plan_no);
        $parapet = $this->saveParapet($req->parapet, $req->customer_code, $req->plan_no);
        $sodekabe = $this->saveSodekabe($req->sodekabe, $req->customer_code, $req->plan_no);
        $overhang = $this->saveOverhang($req->overhang, $req->customer_code, $req->plan_no);
        
        $total_points = $this->saveTotal2FWaku($req->totalOptionPoints, $req->customer_code, $req->plan_no);

        $waku_data = Array(
            "perimeter_3f" => $perimeter_3f,
            "sash" => $sash,
            "fukiage" => $fukiage,
            "fukisage" => $fukisage,
            "roof_deduction" => $roof_deduction,
            "design_louver" => $design_louver,
            "hw_2f" => $hw_2f,
            "hw_3f" => $hw_3f,
            "roof_garden" => $roof_garden,
            "pent_house" => $pent_house,
            "roof_garden_deduction" => $roof_garden_deduction,
            "hw_roof_garden" => $hw_roof_garden,
            "parapet" => $parapet,
            "sodekabe" => $sodekabe,
            "overhang" => $overhang,
            "total_points" => $total_points
        );

        return $waku_data;
    }

    public function save3FPerimeter($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_waku_perimeter')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_waku_perimeter')
            ->update([
                'low_waist' => $req['low_waist'],
                'high_waist' => $req['high_waist'],
                'below_balcony_2f' => $req['below_balcony'],
                'between_hw' => $req['between_hw'],
                'floor_3' => $req['floor_3'],
                'below_balcony_3f' => $req['below_balcony_3f'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "3F Perimeter updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_waku_perimeter')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'low_waist' => $req['low_waist'],
                'high_waist' => $req['high_waist'],
                'below_balcony_2f' => $req['below_balcony'],
                'between_hw' => $req['between_hw'],
                'floor_3' => $req['floor_3'],
                'below_balcony_3f' => $req['below_balcony_3f'],
                'total_points' => $req['total_points']
            ]);

            return "3F Perimeter saved.";
        }
    }

    public function saveWakuSash($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_waku_sash')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                if($req[$i]["total"] !== null){
                    DB::connection('hrdapps61')->table('gt_waku_sash')
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

    public function saveFukiage($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_waku_fukiage')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_waku_fukiage')
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
        DB::connection('hrdapps61')->table('gt_waku_fukisage')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_waku_fukisage')
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
        DB::connection('hrdapps61')->table('gt_waku_roof_deduction')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                DB::connection('hrdapps61')->table('gt_waku_roof_deduction')
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

    public function saveDesignLouver($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_design_louver')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_design_louver')
            ->update([
                'deduction_182' => $req['deduction_182'],
                'points_182' => $req['points_182'],
                'deduction_1365' => $req['deduction_1365'],
                'points_1365' => $req['points_1365'],
                'deduction_091' => $req['deduction_091'],
                'points_091' => $req['points_091'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Design Louver updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_design_louver')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'deduction_182' => $req['deduction_182'],
                'points_182' => $req['points_182'],
                'deduction_1365' => $req['deduction_1365'],
                'points_1365' => $req['points_1365'],
                'deduction_091' => $req['deduction_091'],
                'points_091' => $req['points_091'],
                'total_points' => $req['total_points']
            ]);

            return "Design Louver saved.";
        }
    }

    public function save2FHangingWall($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        if(count($req) > 0){
            if($req[0]['outside'] == null){
                return "No 2F Hanging Wall data.";
            }else{
                DB::connection('hrdapps61')->table('gt_outside_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_opening_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_hangingwall_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_inside_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();
                DB::connection('hrdapps61')->table('gt_hw_total_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 2)->delete();

                foreach($req as $key => $value){
                    //outside
                    DB::connection('hrdapps61')->table('gt_outside_waku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 2,
                        'length' => $value['outside']
                    ]);

                    //total
                    DB::connection('hrdapps61')->table('gt_hw_total_waku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 2,
                        'total' => $value['total']
                    ]);

                    //opening
                    foreach($value['opening'] as $key1 => $value1){
                        DB::connection('hrdapps61')->table('gt_opening_waku')
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
                        DB::connection('hrdapps61')->table('gt_hangingwall_waku')
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
                        DB::connection('hrdapps61')->table('gt_inside_waku')
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
                DB::connection('hrdapps61')->table('gt_outside_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_opening_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_hangingwall_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_inside_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();
                DB::connection('hrdapps61')->table('gt_hw_total_waku')->where('customer_code', $customer_code)->where('plan_no', $plan_no)->where('floor', 3)->delete();

                foreach($req as $key => $value){
                    //outside
                    DB::connection('hrdapps61')->table('gt_outside_waku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 3,
                        'length' => $value['outside']
                    ]);

                    //total
                    DB::connection('hrdapps61')->table('gt_hw_total_waku')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'hw_id' => $value['id'],
                        'floor' => 3,
                        'total' => $value['total']
                    ]);

                    //opening
                    foreach($value['opening'] as $key1 => $value1){
                        DB::connection('hrdapps61')->table('gt_opening_waku')
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
                        DB::connection('hrdapps61')->table('gt_hangingwall_waku')
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
                        DB::connection('hrdapps61')->table('gt_inside_waku')
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

    public function saveRoofGarden($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_waku_roof_garden')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                if($req[$i]["value"] !== null){
                    DB::connection('hrdapps61')->table('gt_waku_roof_garden')
                    ->insert([
                        'customer_code' => $customer_code,
                        'plan_no' => $plan_no,
                        'length' => $req[$i]["value"],
                        'points' => $req[$i]["total"]
                    ]);
                }
            }

            return "Roof Garden data saved.";
        }else{
            return "Roof Garden data is empty.";
        }
    }

    public function savePentHouse($req, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_waku_penthouse')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->delete();

        if(count($req) > 0){
            for ($i = 0; $i < count($req); $i++) {
                if($req[$i]["value"] !== null){
                    DB::connection('hrdapps61')->table('gt_waku_penthouse')
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

    public function saveRoofGardenDeduction($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_roof_garden_deduction')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_roof_garden_deduction')
            ->update([
                'deduction_182' => $req['deduction_182'],
                'points_182' => $req['points_182'],
                'deduction_1365' => $req['deduction_1365'],
                'points_1365' => $req['points_1365'],
                'deduction_091' => $req['deduction_091'],
                'points_091' => $req['points_091'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Roof Garden Deduction updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_roof_garden_deduction')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'deduction_182' => $req['deduction_182'],
                'points_182' => $req['points_182'],
                'deduction_1365' => $req['deduction_1365'],
                'points_1365' => $req['points_1365'],
                'deduction_091' => $req['deduction_091'],
                'points_091' => $req['points_091'],
                'total_points' => $req['total_points']
            ]);

            return "Roof Garden Deduction saved.";
        }
    }

    public function saveHWRoofGarden($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_hw_roof_garden')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_hw_roof_garden')
            ->update([
                'quantity' => $req['quantity'],
                'vertical' => $req['vertical'],
                'vertical_points' => $req['vertical_points'],
                'horizontal' => $req['horizontal'],
                'horizontal_points' => $req['horizontal_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "HW Vertical for Roof Garden updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_hw_roof_garden')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'quantity' => $req['quantity'],
                'vertical' => $req['vertical'],
                'vertical_points' => $req['vertical_points'],
                'horizontal' => $req['horizontal'],
                'horizontal_points' => $req['horizontal_points']
            ]);

            return "HW Vertical for Roof Garden saved.";
        }
    }

    public function saveParapet($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_parapet')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_parapet')
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
            DB::connection('hrdapps61')->table('gt_parapet')
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

    public function saveSodekabe($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_sodekabe')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_sodekabe')
            ->update([
                'ewl' => $req['ewl'],
                'ewh' => $req['ewh'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Sode Kabe updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_sodekabe')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'ewl' => $req['ewl'],
                'ewh' => $req['ewh'],
                'total_points' => $req['total_points']
            ]);

            return "Sode Kabe saved.";
        }
    }

    public function saveOverhang($req, $customer_code, $plan_no){
        date_default_timezone_set('Asia/Manila');

        $existing = DB::connection('hrdapps61')->table('gt_overhang')
                    ->where('customer_code', $customer_code)
                    ->where('plan_no', $plan_no)
                    ->get();

        if(count($existing) > 0){
            DB::connection('hrdapps61')->table('gt_overhang')
            ->update([
                'overhang_0395' => $req['overhang_0395'],
                'overhang_064' => $req['overhang_064'],
                'total_points' => $req['total_points'],
                'updated_date' => date("Y-m-d h:i:s")
            ]);

            return "Overhang updated.";
        }else{
            DB::connection('hrdapps61')->table('gt_overhang')
            ->insert([
                'customer_code' => $customer_code,
                'plan_no' => $plan_no,
                'overhang_0395' => $req['overhang_0395'],
                'overhang_064' => $req['overhang_064'],
                'total_points' => $req['total_points']
            ]);

            return "Overhang saved.";
        }
    }

    public function saveTotal2FWaku($totalOptionPoints, $customer_code, $plan_no){
        DB::connection('hrdapps61')->table('gt_category_points')
        ->where('customer_code', $customer_code)
        ->where('plan_no', $plan_no)
        ->where('item', '2f waku')
        ->delete();
                    
        DB::connection('hrdapps61')->table('gt_category_points')
        ->insert([
            'customer_code' => $customer_code,
            'plan_no' => $plan_no,
            'item' => '2f waku',
            'option_point' => floatval($totalOptionPoints),
            'service_point' => 0
        ]);

        return "2F Waku Points saved.";
    }

    ///////////////////////////////////////////////// FETCHING ////////////////////////////////////////////////////////

    public function getWakugumiData(Request $req){
        $perimeter_3f = $this->get3FPerimeter($req);
        $sash = $this->getWakuSash($req);
        $fukiage = $this->getFukiage($req);
        $fukisage = $this->getFukisage($req);
        $roof_deduction = $this->getRoofDeduction($req);
        $design_louver = $this->getDesignLouver($req);
        $hw_2f = $this->get2FHangingWall($req);
        $hw_3f = $this->get3FHangingWall($req);
        $roof_garden = $this->getRoofGarden($req);
        $pent_house = $this->getPentHouse($req);
        $roof_garden_deduction = $this->getRoofGardenDeduction($req);
        $hw_roof_garden = $this->getHWRoofGarden($req);
        $parapet = $this->getParapet($req);
        $sodekabe = $this->getSodekabe($req);
        $overhang = $this->getOverhang($req);

        $waku_data = Array(
            "perimeter_3f" => $perimeter_3f,
            "sash" => $sash,
            "fukiage" => $fukiage,
            "fukisage" => $fukisage,
            "roof_deduction" => $roof_deduction,
            "design_louver" => $design_louver,
            "hw_2f" => $hw_2f,
            "hw_3f" => $hw_3f,
            "roof_garden" => $roof_garden,
            "pent_house" => $pent_house,
            "roof_garden_deduction" => $roof_garden_deduction,
            "hw_roof_garden" => $hw_roof_garden,
            "parapet" => $parapet,
            "sodekabe" => $sodekabe,
            "overhang" => $overhang
        );

        return $waku_data;
    }

    public function get3FPerimeter($req){
        return DB::connection('hrdapps61')->table('gt_waku_perimeter')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getWakuSash($req){
        return DB::connection('hrdapps61')->table('gt_waku_sash')
                ->select('width as sashWidth', 'height as sashHeight', 'sash_point as total')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getFukiage($req){
        $fukiage = DB::connection('hrdapps61')
            ->select(DB::raw("select computation, points as total, json_unquote(inputs) as inputs
                from gt_waku_fukiage
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
                from gt_waku_fukisage
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
                from gt_waku_roof_deduction
                where customer_code = '$req->customer_code'
                and plan_no = '$req->plan_no'
            "));

            foreach($roof_deduction as $key) {
                $key->inputs = json_decode($key->inputs);
            }
            return $roof_deduction;
    }

    public function getDesignLouver($req){
        return DB::connection('hrdapps61')->table('gt_design_louver')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function get2FHangingWall($req){
        $hangingwall_2f = [];
        //outside
        $outside = DB::connection('hrdapps61')->table('gt_outside_waku')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('floor', 2)
        ->select('hw_id as id', 'length')
        ->get();

        if(count($outside) > 0){
            foreach($outside as $key => $value){
                $total = DB::connection('hrdapps61')->table('gt_hw_total_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('total')
                ->get();

                $opening = DB::connection('hrdapps61')->table('gt_opening_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw = DB::connection('hrdapps61')->table('gt_hangingwall_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 2)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $inside = DB::connection('hrdapps61')->table('gt_inside_waku')
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
        $outside = DB::connection('hrdapps61')->table('gt_outside_waku')
        ->where('customer_code', $req->customer_code)
        ->where('plan_no', $req->plan_no)
        ->where('floor', 3)
        ->select('hw_id as id', 'length')
        ->get();

        if(count($outside) > 0){
            foreach($outside as $key => $value){
                $total = DB::connection('hrdapps61')->table('gt_hw_total_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('total')
                ->get();

                $opening = DB::connection('hrdapps61')->table('gt_opening_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $hw = DB::connection('hrdapps61')->table('gt_hangingwall_waku')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->where('hw_id', $value->id)
                ->where('floor', 3)
                ->select('length', 'columns as column', 'thickness')
                ->get();

                $inside = DB::connection('hrdapps61')->table('gt_inside_waku')
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

    public function getRoofGarden($req){
        return DB::connection('hrdapps61')->table('gt_waku_roof_garden')
                ->select('length as value', 'points as total')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getPentHouse($req){
        return DB::connection('hrdapps61')->table('gt_waku_penthouse')
                ->select('length as value', 'points as total')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getRoofGardenDeduction($req){
        return DB::connection('hrdapps61')->table('gt_roof_garden_deduction')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getHWRoofGarden($req){
        return DB::connection('hrdapps61')->table('gt_hw_roof_garden')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }
    
    public function getParapet($req){
        return DB::connection('hrdapps61')->table('gt_parapet')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getSodekabe($req){
        return DB::connection('hrdapps61')->table('gt_sodekabe')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }

    public function getOverhang($req){
        return DB::connection('hrdapps61')->table('gt_overhang')
                ->where('customer_code', $req->customer_code)
                ->where('plan_no', $req->plan_no)
                ->get();
    }
}
