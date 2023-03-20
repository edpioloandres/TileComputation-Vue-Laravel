<template>
    <div>
        <v-dialog v-model="clearOverlay" persistent width="300">
            <v-card>
                <v-card-text class="pt-2">
                    <span>Clearing fields. Please wait . . .</span>
                    <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-btn :disabled="disableClearBtn" style="font-size: 12px; color: white;" color="red" class="mx-3 mb-7" @click="clearForm()">Clear</v-btn>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import { mapState } from 'vuex'
export default {
    data() {
        return {
            clearOverlay: false
        }
    },

    computed: {
        ...mapState(["shioData"]),

        disableClearBtn(){
            if(Object.keys(this.shioData).length == 0){
                return true
            }else{
                return false
            }
        }
    },

    methods: {
        clearForm(){
            Swal.fire({
                icon: "question",
                title: "Clear All",
                text: "Do you want to clear all data?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Clear",
                denyButtonText: "Cancel"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.clearOverlay = true
                    // clear categories
                    let gaihekiAreaData = [
                        { direction: 'east', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
                        { direction: 'south', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
                        { direction: 'west', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
                        { direction: 'north', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 }
                    ]

                    this.$store.commit('changeClearState', true)
                    this.$store.commit('getGaihekiAreaData', gaihekiAreaData)
                    this.$store.commit('getGaihekiSashData', {})
                    this.$store.commit('getGaihekiDoorData', {})
                    this.$store.commit('getGaihekiAreaPoints', {})

                    this.$store.commit('getBalconyData', [])
                    this.$store.commit('getBalconyPoints', {})

                    this.$store.commit('getColumnData', [])
                    this.$store.commit('getColumnPoints', {})

                    this.$store.commit('getDemadoData', [])
                    this.$store.commit('getDemadoPoints', {})

                    if(this.shioData.ihead == "No"){ // waku
                        this.$store.commit('changeWakuState', 1)
                        this.$store.commit('getHousePerimeterWaku', {})
                        this.$store.commit('getSashDataWaku', [])
                        this.$store.commit('getFukiageDataWaku', [])
                        this.$store.commit('getFukisageDataWaku', [])
                        this.$store.commit('getRoofDeductionDataWaku', [])
                        this.$store.commit('getDesignLouverWaku', {})
                        this.$store.commit('getHangingWall2FWaku', [])
                        this.$store.commit('getHangingWall3FWaku', [])
                        this.$store.commit('getRoofGardenDataWaku', [])
                        this.$store.commit('getPentHouseDataWaku', [])
                        this.$store.commit('getRoofGardenDeducWaku', {})
                        this.$store.commit('getHwVerticalWaku', {})
                        this.$store.commit('getParapetWaku', {})
                        this.$store.commit('getSodekabeWaku', {})
                        this.$store.commit('getOverhangWaku', {})
                    }else if(this.shioData.ihead == "Yes"){ // jiku
                        this.$store.commit('changeJikuState', 1)
                        this.$store.commit('getSashDataJiku', [])
                        this.$store.commit('getPentHouseDataJiku', [])
                        this.$store.commit('getFukiageDataJiku', [])
                        this.$store.commit('getFukisageDataJiku', [])
                        this.$store.commit('getRoofDeductionDataJiku', [])
                        this.$store.commit('getHangingWall2FJiku', [])
                        this.$store.commit('getHangingWall3FJiku', [])
                        this.$store.commit('get2FJikuPoints', null)
                        this.$store.commit('getPartialCurved', {})
                        this.$store.commit('getWholeCurved', {})
                        this.$store.commit('getWholeCurved', {})
                        this.$store.commit('getBelowBands', {})
                        this.$store.commit('getPerimeter2F', {})
                        this.$store.commit('getPerimeter3F', {})
                        this.$store.commit('getParapetJiku', {})
                    }

                    this.$store.commit('getAdditionalData', [])
                    this.$store.commit('getDeductionData', [])
                    this.$store.commit('getSpecialComputationPoints', {})

                    this.$store.commit('get2FJikuPoints', 0)
                    this.$store.commit('get2FWakuPoints', 0)

                    // reload
                    window.location.assign("/gaiheki_area");
                }
            })
        }
    },
}
</script>

<style>
    .swal2-popup {
        font-size: 12px !important;
        font-family: 'Poppins';
    }
</style>