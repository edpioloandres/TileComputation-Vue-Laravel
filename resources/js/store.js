import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persistedstate';
const createPersistedState = new VuexPersist({
    key: 'Gaiheki',
    storage: localStorage
})

Vue.use(Vuex)
export default new Vuex.Store({
    state:{
        isClear: false,
        loadWaku: 0,
        loadJiku: 0,
        //master
        shioData: {},
        controlNumberDisable: false,
        sashSize: [],
        brickPoints: [],

        //overall points
        totalOptionPoints: null,
        totalServicePoints: null,

        //gaiheki area
        gaihekiAreaPoints: { servicePoints: 0, optionPoints: 0 },
        gaihekiAreaData: {},

        sashData: {
            eastSashData: [],
            southSashData: [],
            westSashData: [],
            northSashData: []
        },

        doorData: {
            eastDoorData: [],
            southDoorData: [],
            westDoorData: [],
            northDoorData: []
        },

        //unit demado
        demadoData: [],
        demadoPoints: { servicePoints: 0, optionPoints: 0 },

        //balcony
        balconyData: [],
        balconyPoints: { servicePoints: 0, optionPoints: 0 },

        //columns
        columnData: [],
        columnPoints: { servicePoints: 0, optionPoints: 0 },

        //waku data
        housePerimeterWaku: {
            lowWaist2F: null,
            highWaist2F: null,
            belowBalcony2F: null,
            betweenHW: null,
            thirdFloor: null,
            belowBalcony3F: null,
            total3FArea: null
        },

        sashDataWaku: [],
        fukiageDataWaku: [],
        fukisageDataWaku: [],
        roofDeductionDataWaku: [],
        designLouverWaku: {
            louverQuantity1: null,
            louverQuantity2: null,
            louverQuantity3: null,
            louverTotal1: null,
            louverTotal2: null,
            louverTotal3: null
        },
        hangingWall2FWaku: [],
        hangingWall3FWaku: [],
        roofGardenDataWaku: [],
        pentHouseDataWaku: [],
        roofGardenDeducWaku: {
            roofGardenDeducQuantity1: null,
            roofGardenDeducQuantity2: null,
            roofGardenDeducQuantity3: null,
            roofGardenDeducTotal1: null,
            roofGardenDeducTotal2: null,
            roofGardenDeducTotal3: null
        },
        hwVerticalWaku: {
            verticalHW: null,
            horizontalHW: null,
            hwQuantity: null,
            totalVerticalHW: 0,
            totalHorizontalHW: 0
        },
        parapetWaku: {
            parapet1: null,
            parapet2: null,
            parapet3: null,
            parapet4: null,
            parapet5: null,
            totalParapet1: null,
            totalParapet2: null,
            totalParapet3: null,
            totalParapet4: null,
            totalParapet5: null,
        },
        sodekabeWaku: {
            sodeKabe1: null,
            sodeKabe2: null,
            totalSode1: null,
            totalSode2: null
        },
        overhangWaku: {
            overHang1: null,
            overHang2: null,
            totalOverhang1: null,
            totalOverhang2: null
        },

        //jiku data
        partialCurved: {
            outsideD2: null,
            insideD1: null,
            totalPartialCurved: null
        },
        wholeCurved: {
            heightOfTarekabe: null,
            lengthOfTarekabe: null,
            outerPartOfDiameter: null,
            totalWholeCurvedTarekabe: null
        },
        belowBands: {
            belowBands1: null,
            belowBands2: null,
            totalBands: null
        },
        sashDataJiku: [],
        perimeter2F: {
            secondFloorLowWaist265: null,
            secondFloorHighWaist265: null,
            belowBalcony265: null,
            betweenHWBB265: null,
            total2FLPerimeter: null
        },
        perimeter3F: {
            secondFloorLowWaist245: null,
            secondFloorHighWaist245: null,
            belowBalcony245: null,
            belowHwBB245: null,
            thirdFloor245: null,
            thirdFloorBelowBalcony245: null,
            total3FLPerimeter: null
        },
        hangingWall2FJiku: [],
        hangingWall3FJiku: [],
        pentHouseDataJiku: [],
        fukiageDataJiku: [],
        fukisageDataJiku: [],
        roofDeductionDataJiku: [],
        parapetJiku: {
            parapet1: null,
            parapet2: null,
            parapet3: null,
            parapet4: null,
            parapet5: null,
            totalParapet1: null,
            totalParapet2: null,
            totalParapet3: null,
            totalParapet4: null,
            totalParapet5: null,
        },

        //special computations
        additionalData: [],
        deductionData: [],
        specialComputationPoints: { additional: 0, deduction: 0 },

        //2F points
        option2FJiku: 0,
        option2FWaku: 0
    },

    actions:{},

    mutations:{
        changeClearState(state, val){
            state.isClear = val
        },

        //master
        changeWakuState(state, val){
            state.loadWaku = val
        },
        changeJikuState(state, val){
            state.loadJiku = val
        },
        getShioData(state, val){
            state.shioData = val
        },
        controlNumberDisable(state, val){
            state.controlNumberDisable = val
        },
        getSashSize(state, val){
            state.sashSize = val
        },
        getBrickPoints(state, val){
            state.brickPoints = val
        },

        //overall points
        getTotalOptionPoints(state, val){
            state.totalOptionPoints = val
        },
        getTotalServicePoints(state, val){
            state.totalServicePoints = val
        },

        //gaiheki area
        getGaihekiAreaPoints(state, val){
            state.gaihekiAreaPoints = val
        },
        getGaihekiAreaData(state, val){
            state.gaihekiAreaData = val
        },

        getGaihekiSashData(state, val){
            state.sashData = val
        },
        getGaihekiDoorData(state, val){
            state.doorData = val
        },

        //unit demado
        getDemadoData(state, val){
            state.demadoData = val
        },
        getDemadoPoints(state, val){
            state.demadoPoints = val
        },

        //balcony
        getBalconyData(state, val){
            state.balconyData = val
        },
        getBalconyPoints(state, val){
            state.balconyPoints = val
        },

        //column
        getColumnData(state, val){
            state.columnData = val
        },
        getColumnPoints(state, val){
            state.columnPoints = val
        },

        //waku data
        getHousePerimeterWaku(state, val){
            state.housePerimeterWaku = val
        },
        getSashDataWaku(state, val){
            state.sashDataWaku = val
        },
        getFukiageDataWaku(state, val){
            state.fukiageDataWaku = val
        },
        getFukisageDataWaku(state, val){
            state.fukisageDataWaku = val
        },
        getRoofDeductionDataWaku(state, val){
            state.roofDeductionDataWaku = val
        },
        getDesignLouverWaku(state, val){
            state.designLouverWaku = val
        },
        getHangingWall2FWaku(state, val){
            state.hangingWall2FWaku = val
        },
        getHangingWall3FWaku(state, val){
            state.hangingWall3FWaku = val
        },
        getRoofGardenDataWaku(state, val){
            state.roofGardenDataWaku = val
        },
        getPentHouseDataWaku(state, val){
            state.pentHouseDataWaku = val
        },
        getRoofGardenDeducWaku(state, val){
            state.roofGardenDeducWaku = val
        },
        getHwVerticalWaku(state, val){
            state.hwVerticalWaku = val
        },
        getParapetWaku(state, val){
            state.parapetWaku = val
        },
        getSodekabeWaku(state, val){
            state.sodekabeWaku = val
        },
        getOverhangWaku(state, val){
            state.overhangWaku = val
        },

        //jiku data
        getPartialCurved(state, val){
            state.partialCurved = val
        },
        getWholeCurved(state, val){
            state.wholeCurved = val
        },
        getBelowBands(state, val){
            state.belowBands = val
        },
        getSashDataJiku(state, val){
            state.sashDataJiku = val
        },
        getPerimeter2F(state, val){
            state.perimeter2F = val
        },
        getPerimeter3F(state, val){
            state.perimeter3F = val
        },
        getHangingWall2FJiku(state, val){
            state.hangingWall2FJiku = val
        },
        getHangingWall3FJiku(state, val){
            state.hangingWall3FJiku = val
        },
        getPentHouseDataJiku(state, val){
            state.pentHouseDataJiku = val
        },
        getFukiageDataJiku(state, val){
            state.fukiageDataJiku = val
        },
        getFukisageDataJiku(state, val){
            state.fukisageDataJiku = val
        },
        getRoofDeductionDataJiku(state, val){
            state.roofDeductionDataJiku = val
        },
        getParapetJiku(state, val){
            state.parapetJiku = val
        },

        //special computations
        getAdditionalData(state, val){
            state.additionalData = val
        },
        getDeductionData(state, val){
            state.deductionData = val
        },
        getSpecialComputationPoints(state, val){
            state.specialComputationPoints = val
        },

        //2F points
        get2FJikuPoints(state, val){
            state.option2FJiku = val
        },
        get2FWakuPoints(state, val){
            state.option2FWaku = val
        }
    },

    getters:{
        getShioData: state => state.shioData,
        getSashSize: state => state.sashSize,
        getBrickPoints: state => state.brickPoints,

        getGaihekiAreaPoints: state => state.gaihekiAreaPoints,
        getGaihekiAreaData: state => state.gaihekiAreaData,
        getGaihekiSashData: state => state.sashData,
        getGaihekiDoorData: state => state.doorData,

        getDemadoData: state => state.demadoData,
        getDemadoPoints: state => state.demadoPoints,

        getBalconyData: state => state.balconyData,
        getBalconyPoints: state => state.balconyPoints,

        getColumnData: state => state.columnData,
        getColumnPoints: state => state.columnPoints,

        get2FJikuPoints: state => state.option2FJiku,
        get2FWakuPoints: state => state.option2FWaku,

        getAdditionalData: state => state.additionalData,
        getDeductionData: state => state.deductionData,
        getSpecialComputationPoints: state => state.specialComputationPoints
    },
    plugins: [createPersistedState]
});