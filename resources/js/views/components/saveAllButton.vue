<template>
    <div>
        <v-dialog v-model="saveOverlay" persistent width="300">
            <v-card>
                <v-card-text class="pt-2">
                    <span>Saving all data . . .</span>
                    <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
  
        <v-btn :disabled="disableSaveBtn" style="font-size: 13px; color: white;" color="primary" class="mb-7" @click="saveAllData()">Save</v-btn>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import { mapState } from 'vuex'
export default {
    data() {
        return {
            saveOverlay: false
        }
    },

    computed: {
        ...mapState(
            [
                "shioData",
                "totalOptionPoints",
                "totalServicePoints",

                "gaihekiAreaData",
                "sashData",
                "doorData",

                "demadoData",
                "demadoPoints",
                "balconyData",
                "balconyPoints",
                "columnData",
                "columnPoints",

                "housePerimeterWaku",
                "designLouverWaku",
                "hwVerticalWaku",
                "parapetWaku",
                "sodekabeWaku",
                "overhangWaku",
                "sashDataWaku",
                "roofGardenDeducWaku", // deduction of roof garden
                "roofGardenDataWaku", // roof garden
                "roofDeductionDataWaku", // roof deduction
                "pentHouseDataWaku",
                "fukiageDataWaku",
                "fukisageDataWaku",
                "hangingWall2FWaku",
                "hangingWall3FWaku",
                "option2FWaku",

                "partialCurved",
                "wholeCurved",
                "belowBands",
                "perimeter2F",
                "perimeter3F",
                "parapetJiku",
                "sashDataJiku",
                "pentHouseDataJiku",
                "fukiageDataJiku",
                "fukisageDataJiku",
                "hangingWall2FJiku",
                "hangingWall3FJiku",
                "option2FJiku",
                "roofDeductionDataJiku",

                "additionalData",
                "deductionData",
                "specialComputationPoints",
            ]
        ),

        disableSaveBtn(){
            if(Object.keys(this.shioData).length == 0){
                return true
            }else{
                return false
            }
        }
    },

    methods: {
        saveAllData(){
            this.saveOverlay = true

            //////////////////////// gaiheki area ////////////////////////
            this.gaihekiAreaData[0].customer_code = this.shioData.customerCode
            this.gaihekiAreaData[0].plan_no = this.shioData.planNo

            this.gaihekiAreaData[1].customer_code = this.shioData.customerCode
            this.gaihekiAreaData[1].plan_no = this.shioData.planNo
            
            this.gaihekiAreaData[2].customer_code = this.shioData.customerCode
            this.gaihekiAreaData[2].plan_no = this.shioData.planNo

            this.gaihekiAreaData[3].customer_code = this.shioData.customerCode
            this.gaihekiAreaData[3].plan_no = this.shioData.planNo

            const sashData = this.sashData.eastSashData.concat(this.sashData.southSashData, this.sashData.westSashData, this.sashData.northSashData)
            const doorData = this.doorData.eastDoorData.concat(this.doorData.southDoorData, this.doorData.westDoorData, this.doorData.northDoorData)

            //////////////////////// demado ////////////////////////
            let demadoArr = this.demadoData
            const empty1 = demadoArr.filter(r => r.kinds == "")
            if(empty1.length > 0){
                const id = demadoArr.findIndex(r => r.kinds == "")
                demadoArr.splice(id, 1);
            }
            
            demadoArr.forEach(object => {
                object.customer_code = this.shioData.customerCode,
                object.plan_no = this.shioData.planNo
            });

            //////////////////////// balcony ////////////////////////
            let balconyArr = this.balconyData
            const empty2 = balconyArr.filter(r => r.type == "")
            if(empty2.length > 0){
                const id = balconyArr.findIndex(r => r.type == "")
                balconyArr.splice(id, 1);
            }
            
            balconyArr.forEach(object => {
                object.customer_code = this.shioData.customerCode,
                object.plan_no = this.shioData.planNo
            });

            //////////////////////// column ////////////////////////
            let columnArr = this.columnData
            const empty3 = columnArr.filter(r => r.columnName == "")
            if(empty3.length > 0){
                const id = columnArr.findIndex(r => r.columnName == "")
                columnArr.splice(id, 1);
            }
            
            columnArr.forEach(object => {
                object.customer_code = this.shioData.customerCode,
                object.plan_no = this.shioData.planNo
            });
        
            axios.post('api/saveGaihekiArea', this.gaihekiAreaData)
            .then(res => {
                console.log(res.data.message)

                axios.post('api/saveSash', {
                    sashData: sashData,
                    customer_code: this.shioData.customerCode,
                    plan_no: this.shioData.planNo
                }).then(res => {
                    console.log(res.data.message)

                    axios.post('api/saveEntrance', {
                        doorData: doorData,
                        customer_code: this.shioData.customerCode,
                        plan_no: this.shioData.planNo
                    }).then(res => {
                        console.log(res.data.message)

                        axios.post('api/saveUnitDemado', {
                            customer_code: this.shioData.customerCode,
                            plan_no: this.shioData.planNo,
                            demadoArr: demadoArr,
                            optionPoint: this.demadoPoints.optionPoints,
                            servicePoint: this.demadoPoints.servicePoints
                        })
                        .then(res => {
                            console.log(res.data.message)

                            axios.post('api/saveBalcony', {
                                customer_code: this.shioData.customerCode,
                                plan_no: this.shioData.planNo,
                                balconyArr: balconyArr,
                                optionPoint: this.balconyPoints.optionPoints,
                                servicePoint: this.balconyPoints.servicePoints
                            })
                            .then(res => {
                                console.log(res.data.message)
                                
                                axios.post('api/saveColumn', {
                                    customer_code: this.shioData.customerCode,
                                    plan_no: this.shioData.planNo,
                                    columnArr: columnArr,
                                    optionPoint: this.columnPoints.optionPoints,
                                    servicePoint: this.columnPoints.servicePoints
                                })
                                .then(res => {
                                    console.log(res.data.message)

                                    if(this.shioData.ihead == "No"){
                                        this.saveWaku2FData()
                                    }else if(this.shioData.ihead == "Yes"){
                                        this.saveJiku2FData()
                                    }
                                })
                            })
                        })
                    })
                })
            })
        },

        saveWaku2FData(){
            let perimeter3F = {
                low_waist: this.housePerimeterWaku.lowWaist2F,
                high_waist: this.housePerimeterWaku.highWaist2F,
                below_balcony: this.housePerimeterWaku.belowBalcony2F,
                between_hw: this.housePerimeterWaku.betweenHW,
                floor_3: this.housePerimeterWaku.thirdFloor,
                below_balcony_3f: this.housePerimeterWaku.belowBalcony3F,
                total_points: this.housePerimeterWaku.total3FArea
            }

            let designLouver = {
                deduction_182: this.designLouverWaku.louverQuantity1,
                points_182: this.designLouverWaku.louverTotal1,
                deduction_1365: this.designLouverWaku.louverQuantity2,
                points_1365: this.designLouverWaku.louverTotal2,
                deduction_091: this.designLouverWaku.louverQuantity3,
                points_091: this.designLouverWaku.louverTotal3,
                total_points: this.designLouverWaku.louverTotal1 + this.designLouverWaku.louverTotal2 + this.designLouverWaku.louverTotal3
            }

            let roofGardenDeduction = {
                deduction_182: this.roofGardenDeducWaku.roofGardenDeducQuantity1,
                points_182: this.roofGardenDeducWaku.roofGardenDeducTotal1,
                deduction_1365: this.roofGardenDeducWaku.roofGardenDeducQuantity2,
                points_1365: this.roofGardenDeducWaku.roofGardenDeducTotal2,
                deduction_091: this.roofGardenDeducWaku.roofGardenDeducQuantity3,
                points_091: this.roofGardenDeducWaku.roofGardenDeducTotal3,
                total_points: this.roofGardenDeducWaku.roofGardenDeducTotal1 + this.roofGardenDeducWaku.roofGardenDeducTotal2 + this.roofGardenDeducWaku.roofGardenDeducTotal3
            }

            let hwRoofGarden = {
                quantity: this.hwVerticalWaku.hwQuantity,
                vertical: this.hwVerticalWaku.verticalHW,
                vertical_points: this.hwVerticalWaku.totalVerticalHW,
                horizontal: this.hwVerticalWaku.horizontalHW,
                horizontal_points: this.hwVerticalWaku.totalHorizontalHW
            }

            let parapet = {
                parapet_041: this.parapetWaku.parapet1,
                parapet_046: this.parapetWaku.parapet2,
                parapet_0605: this.parapetWaku.parapet3,
                parapet_0274: this.parapetWaku.parapet4,
                parapet_0271: this.parapetWaku.parapet5,
                total_points: this.parapetWaku.totalParapet1 + this.parapetWaku.totalParapet2 + this.parapetWaku.totalParapet3 + this.parapetWaku.totalParapet4 + this.parapetWaku.totalParapet5
            }

            let sodekabe = {
                ewl: this.sodekabeWaku.sodeKabe1,
                ewh: this.sodekabeWaku.sodeKabe2,
                total_points: this.sodekabeWaku.totalSode1 + this.sodekabeWaku.totalSode2
            }

            let overhang = {
                overhang_0395: this.overhangWaku.overHang1,
                overhang_064: this.overhangWaku.overHang2,
                total_points: this.overhangWaku.totalOverhang1 + this.overhangWaku.totalOverhang2
            }

            let sashArr = this.sashDataWaku
            let roofGardenArr = this.roofGardenDataWaku
            let pentArr = this.pentHouseDataWaku

            axios.post('api/saveWakugumiData', {
                customer_code: this.shioData.customerCode,
                plan_no: this.shioData.planNo,
                perimeter3F,
                sashArr,
                fukiageArr: this.fukiageDataWaku,
                fukisageArr: this.fukisageDataWaku,
                roofDeductionArr: this.roofDeductionDataWaku,
                designLouver,
                hangingWall2F: this.hangingWall2FWaku,
                hangingWall3F: this.hangingWall3FWaku,
                roofGardenArr,
                pentArr,
                roofGardenDeduction,
                hwRoofGarden,
                parapet,
                sodekabe,
                overhang,
                totalOptionPoints: this.option2FWaku
            }).then(res => {
                console.log(res.data)

                this.saveSpecialComputations()
            })
        },

        saveJiku2FData(){
            let partialCurved = {
                outside: this.partialCurved.outsideD2,
                inside: this.partialCurved.insideD1,
                total_points: this.partialCurved.totalPartialCurved
            }

            let wholeCurved = {
                height: this.wholeCurved.heightOfTarekabe,
                length: this.wholeCurved.lengthOfTarekabe,
                diameter: this.wholeCurved.outerPartOfDiameter,
                total_points: this.wholeCurved.totalWholeCurvedTarekabe
            }

            let belowBands = {
                below_bands39: this.belowBands.belowBands1,
                below_bands37: this.belowBands.belowBands2,
                total_points: this.belowBands.totalBands
            }

            let perimeter2F = {
                low_waist_2f: this.perimeter2F.secondFloorLowWaist265,
                high_waist_2f: this.perimeter2F.secondFloorHighWaist265,
                below_balcony_2f: this.perimeter2F.belowBalcony265,
                between_hw_2f: this.perimeter2F.betweenHWBB265,
                total_points: this.perimeter2F.total2FLPerimeter
            }

            let perimeter3F = {
                low_waist_3f: this.perimeter3F.secondFloorLowWaist245,
                high_waist_3f: this.perimeter3F.secondFloorHighWaist245,
                below_balcony: this.perimeter3F.belowBalcony245,
                between_hw_3f: this.perimeter3F.belowHwBB245,
                perimeter_3f: this.perimeter3F.thirdFloor245,
                below_balcony_3f: this.perimeter3F.thirdFloorBelowBalcony245,
                total_points: this.perimeter3F.total3FLPerimeter
            }

            let parapet = {
                parapet_041: this.parapetJiku.parapet1,
                parapet_046: this.parapetJiku.parapet2,
                parapet_0605: this.parapetJiku.parapet3,
                parapet_0274: this.parapetJiku.parapet4,
                parapet_0271: this.parapetJiku.parapet5,
                total_points: this.parapetJiku.totalParapet1 + this.parapetJiku.totalParapet2 + this.parapetJiku.totalParapet3 + this.parapetJiku.totalParapet4 + this.parapetJiku.totalParapet5
            }

            let sashArr = this.sashDataJiku
            let pentArr = this.pentHouseDataJiku

            axios.post('api/saveJikugumiData', {
                customer_code: this.shioData.customerCode,
                plan_no: this.shioData.planNo,
                partialCurved,
                wholeCurved,
                belowBands,
                perimeter2F,
                perimeter3F,
                hangingWall2F: this.hangingWall2FJiku,
                hangingWall3F: this.hangingWall3FJiku,
                sashArr,
                pentArr,
                parapet,
                fukiageArr: this.fukiageDataJiku,
                fukisageArr: this.fukisageDataJiku,
                roofDeductionArr: this.roofDeductionDataJiku,
                totalOptionPoints: this.option2FJiku
            }).then(res => {
                console.log(res.data)

                this.saveSpecialComputations()
            })
        },

        saveSpecialComputations(){
            axios.post('api/saveSpecialComputations', {
                additionalData: this.additionalData,
                deductionData: this.deductionData,
                totalAdditional: this.specialComputationPoints.additional,
                totalDeduction: this.specialComputationPoints.deduction,
                customer_code: this.shioData.customerCode,
                plan_no: this.shioData.planNo
            }).then(res => {
                console.log(res.data.message)

                axios.post('api/saveTotalPoints', {
                    customer_code: this.shioData.customerCode,
                    plan_no: this.shioData.planNo,
                    totalOption: this.totalOptionPoints,
                    totalService: this.totalServicePoints
                }).then(res => {
                    console.log(res.data.message)
                    this.saveOverlay = false

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        iconColor: '#3ab792',
                        title: 'Success!',
                        text: 'Tile data successfully saved.',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 2500
                    })
                })
            })
        }
    }
}
</script>
  
<style>
    .swal2-popup {
        font-size: 12px !important;
        font-family: 'Poppins';
    }
</style>