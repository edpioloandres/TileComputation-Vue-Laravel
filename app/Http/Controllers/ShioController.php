<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShioController extends Controller
{
    public function getPlanNumber(Request $request){
        // return DB::table('seki_im_v1')
        // ->select('plan_number')
        // ->where('code_number', $request->customerCode)
        // ->orderBy('created_at', 'DESC')
        // ->get();

        return DB::connection('IMANAGERSVR')
        ->table('requests')
        ->select('plan_number', 'shio_number')
        ->where('code_number', $request->customerCode)
        ->orderBy('date_requested','desc')
        ->get();
    }

    public function getShioData(Request $request){
        $houseType = DB::connection('HRDSQL2')
        ->select(DB::raw("
            SELECT
            siyoDataBroker.dbo.tbl_siyo_kanri.printType
            FROM 
            siyoDataBroker.dbo.tbl_siyo_kanri
            WHERE
            siyoDataBroker.dbo.tbl_siyo_kanri.siyoCode = (
                SELECT siyoDataBroker.dbo.tbl_siyo_boss.siyoCode FROM
                siyoDataBroker.dbo.tbl_siyo_boss
                WHERE siyoDataBroker.dbo.tbl_siyo_boss.customerCode = '$request->customerCode'
                AND siyoDataBroker.dbo.tbl_siyo_boss.zumenCode LIKE '$request->planNo'
                AND siyoDataBroker.dbo.tbl_siyo_boss.siyoNo = '$request->shioNo'
            )
            AND siyoDataBroker.dbo.tbl_siyo_kanri.customerCode = '$request->customerCode'
        "));
        
        if(count($houseType) > 0){
            $houseType = $houseType;
        }else{
            $houseType = DB::connection('HRDSQL')
            ->select(DB::raw("
                SELECT ConstructionTypeName as printType FROM
                HrdInformationService.dbo.ConstructionTypes
                LEFT JOIN
                HrdInformationService.dbo.Houses
                ON
                HrdInformationService.dbo.ConstructionTypes.ConstructionTypeCode = 
                HrdInformationService.dbo.Houses.ConstructionTypeCode
                WHERE
                HrdInformationService.dbo.Houses.ConstructionCode = '$request->customerCode'
            "));
        }

        $kanabakari = DB::connection('HRDSQL2')
        ->select(DB::raw("
            SELECT
            siyoDataBroker.dbo.tbl_siyo_kihon.siyoDetailName
            FROM
            siyoDataBroker.dbo.tbl_siyo_kihon
            WHERE
            siyoDataBroker.dbo.tbl_siyo_kihon.siyoCode = (
                SELECT siyoDataBroker.dbo.tbl_siyo_boss.siyoCode FROM
                siyoDataBroker.dbo.tbl_siyo_boss
                WHERE siyoDataBroker.dbo.tbl_siyo_boss.customerCode = '$request->customerCode'
                AND siyoDataBroker.dbo.tbl_siyo_boss.zumenCode LIKE '$request->planNo'
                AND siyoDataBroker.dbo.tbl_siyo_boss.siyoNo = '$request->shioNo'
            )
            AND siyoDataBroker.dbo.tbl_siyo_kihon.customerCode = '$request->customerCode'
            AND siyoDataBroker.dbo.tbl_siyo_kihon.kihonsiyoCd = '0070'
        "));

        if(count($kanabakari) > 0){
            $kanabakari = $kanabakari;
        }else{
            $kanabakari = DB::connection('HRDSQL2')
            ->select(DB::raw("
                SELECT
                DISTINCT(siyoDataBroker.dbo.tbl_siyo_kihon.siyoDetailName)
                FROM
                siyoDataBroker.dbo.tbl_siyo_kihon
                WHERE siyoDataBroker.dbo.tbl_siyo_kihon.customerCode = '$request->customerCode'
                AND siyoDataBroker.dbo.tbl_siyo_kihon.kihonsiyoCd = '0070'
            "));
        }

        $ihead = DB::connection('HRDSQL2')
        ->select(DB::raw("
            SELECT
            siyoDataBroker.dbo.tbl_siyo_kihon.siyoDetailName
            FROM
            siyoDataBroker.dbo.tbl_siyo_kihon
            WHERE
            siyoDataBroker.dbo.tbl_siyo_kihon.siyoCode = (
                SELECT siyoDataBroker.dbo.tbl_siyo_boss.siyoCode FROM
                siyoDataBroker.dbo.tbl_siyo_boss
                WHERE siyoDataBroker.dbo.tbl_siyo_boss.customerCode = '$request->customerCode'
                AND siyoDataBroker.dbo.tbl_siyo_boss.zumenCode LIKE '$request->planNo'
                AND siyoDataBroker.dbo.tbl_siyo_boss.siyoNo = '$request->shioNo'
            )
            AND siyoDataBroker.dbo.tbl_siyo_kihon.customerCode = '$request->customerCode'
            AND siyoDataBroker.dbo.tbl_siyo_kihon.kihonsiyoCd = '0111'
        "));

        if(count($ihead) > 0){
            $ihead = $ihead;
        }else{
            $ihead = DB::connection('HRDSQL2')
            ->select(DB::raw("
                SELECT
                DISTINCT(siyoDataBroker.dbo.tbl_siyo_kihon.siyoDetailName)
                FROM
                siyoDataBroker.dbo.tbl_siyo_kihon
                WHERE
                siyoDataBroker.dbo.tbl_siyo_kihon.customerCode = '$request->customerCode'
                AND siyoDataBroker.dbo.tbl_siyo_kihon.kihonsiyoCd = '0111'
            "));
        }

        $tileKind = $this->getTileKind($request);

        $customerName = DB::connection('HRDSQL')
        ->table('Constructions')
        ->select(
            'ConstructionName', 'ConstructionNameRoma'
        )
        ->where('ConstructionCode ',$request->customerCode)
        ->get();

        $contractDate = DB::connection('HRDSQL')
        ->table('ConstructionsView')
        ->select(
            'ProvisionalContractDate'
        )
        ->where('ConstructionCode ',$request->customerCode)
        ->get();

        $joutoDate = DB::connection('HRDSQL')
        ->table('ConstructionSchedule')
        ->select(
            'ExpectedHouseRaisingDate'
        )
        ->where('ConstructionCode ',$request->customerCode)
        ->get();

        $shio = Array(
            "houseType" => $houseType,
            "kanabakari" => $kanabakari,
            "ihead" => $ihead,
            "tileKind" => $tileKind,
            "customerName" => $customerName,
            "contractDate" => $contractDate,
            "joutoDate" => $joutoDate
        );

        return $shio;
    }

    function getTileKind($request){
        // $tileDetails = DB::connection('HRDSQL2')
        // ->select(DB::raw("
        //     SELECT shohinCd, shohinName FROM siyoDataBroker.dbo.tbl_siyo_syohin
        //     WHERE
        //     customerCode = '$request->customerCode'
        //     AND
        //     siyoCode = (
        //         SELECT MAX(siyoCode) from tbl_siyo_syohin
        //         WHERE customerCode = '$request->customerCode'
        //     )
        //     AND 
        //     siyoKbn = '1'
        //     AND
        //     ( komokuCd1 = '0210' OR komokuCd1 = '0450' )
        //     AND
        //     ( komokuCd2 = '0100' )
        //     AND
        //     notNeedsKoumoku2 = 0
        //     ORDER BY komokuCd2 ASC
        // "));

        $tileDetails = DB::connection('HRDSQL2')
        ->select(DB::raw("
            SELECT shohinCd, shohinName FROM siyoDataBroker.dbo.tbl_siyo_syohin
            WHERE
            customerCode = '$request->customerCode'
            AND
            siyoCode = (
                SELECT siyoCode from tbl_siyo_boss
                WHERE customerCode = '$request->customerCode'
                AND zumenCode = '$request->planNo'
                AND siyoNo = '$request->shioNo'
            )
            AND 
            siyoKbn = '1'
            AND
            ( komokuCd1 = '0210' OR komokuCd1 = '0450' )
            AND
            ( komokuCd2 = '0100' )
            AND
            notNeedsKoumoku2 = 0
            ORDER BY komokuCd2 ASC
        "));
        

        if(count($tileDetails) > 0){
            $tileKind = "";
            
            if( preg_match( '/0000002/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "なし";
            }
            if( preg_match( '/0500205/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "TC";
            }
            if( preg_match( '/0500206|0500207|0605320/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "TD";
            }
            if( preg_match( '/0500211|0500212|0500214/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "TE";
            }
            if( preg_match( '/0500213/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "TE + TD";
            }
            if( preg_match( '/0500215/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "TD + TF";
            }
            if( preg_match( '/8888888/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "";
                
            }else if( preg_match( '/9999999/', $tileDetails[0]->shohinCd) ) {
                $tileKind = "";				
            }

            return $tileKind;
        }else{
            $tileKind = "";
            return $tileKind;
        }
    }
}