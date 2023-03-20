<template>
  <div>
    <div class="text-center">
      <v-overlay :value="loadOverlay"></v-overlay>
      <v-dialog v-model="loadOverlay" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="pt-2">
            <span>Please wait . . .</span>
            <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>

    <div class="text-center">
      <v-overlay :value="loadPDF"></v-overlay>
      <v-dialog v-model="loadPDF" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="pt-2">
            <span>Generating PDF . . .</span>
            <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>

    <v-app-bar id="grad1" clipped-left app fixed extended extension-height="60px">
      <v-app-bar-nav-icon @click="drawer = !drawer" style="color: white;"></v-app-bar-nav-icon>

      <v-toolbar-title style="color: white; font-size: 16px;">Gaiheki Tile Computation</v-toolbar-title>  &nbsp;&nbsp;&nbsp;<span class="mt-1" style="font-size:12px; color: white;">Ver 1.0.0</span>
      <v-spacer></v-spacer>

      <div class="vl"></div>

      <v-list dense style="background-color: transparent;">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title style="font-size: 12px; text-transform: uppercase; color: white; text-align: right;">Total Option</v-list-item-title>
            <v-list-item-title style="font-size: 18px; color: white; text-align: right;">{{ optionPoints }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list dense style="background-color: transparent;">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title style="font-size: 12px; text-transform: uppercase; color: white; text-align: right;">Total Service</v-list-item-title>
            <v-list-item-title style="font-size: 18px; color: white; text-align: right;">{{ servicePoints }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <template v-slot:extension>
        <v-toolbar class="mt-7" dense flat color="transparent">
          <v-text-field
            autofocus
            color="#00355e"
            light
            dense
            outlined
            maxlength="12"
            :disabled="disableControlNumber"
            style="width: 15%; font-size: 13px;"
            label="Control Number"
            class="px-1"
            v-model="customerCode"
            @keyup="getPlanNo()"
          >
          </v-text-field>

          <v-text-field
            color="#00355e"
            light
            dense
            outlined
            style="width: 12%; font-size: 13px; display: none;"
            label="Estimation No"
            class="px-1"
          >
          </v-text-field>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="width: 12%; font-size: 13px;"
            label="Plan No"
            class="px-1"
            :items="planNo"
            :disabled="planNo.length == 0"
            v-model="selectedPlanNo"
            :loading="loadPlanNo"
            @change="getShioNo()"
          >
          </v-select>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="width: 9%; font-size: 13px;"
            label="Shio No"
            class="px-1"
            :items="shioNumberData"
            v-model="shioNo"
            @change="getShioData(), getMaster(), getTileData()"
            :disabled="selectedPlanNo == ''"
          >
          </v-select>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="font-size: 13px;"
            label="House Type"
            class="px-1"
            :items="houseTypes"
            :readonly="disableHouseType"
            :loading="loadData"
            v-model="selectedHouseType"
            @change="setShioData()"
          >
          </v-select>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="width: 12%; font-size: 13px;"
            label="Kanabakari"
            class="px-1"
            :items="kanabakari"
            :loading="loadData"
            v-model="selectedKanabakari"
            @change="setShioData()"
          >
          </v-select>

          <v-text-field
            color="#00355e"
            light
            dense
            readonly
            outlined
            style="width: 8%; font-size: 13px;"
            label="Module"
            class="px-1"
            v-model="moduleSize"
          >
          </v-text-field>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="width: 9%; font-size: 13px;"
            label="I-Head"
            class="px-1"
            :items="iheadSticker"
            :readonly="disableIHead"
            :loading="loadData"
            v-model="selectedIHeadSticker"
            @change="setShioData()"
          >
          </v-select>

          <v-select
            color="#00355e"
            light
            dense
            outlined
            style="width: 10%; font-size: 13px;"
            label="Tile Kind"
            class="px-1"
            :items="tileKinds"
            :loading="loadData"
            v-model="selectedTileKind"
            @change="setShioData()"
          >
          </v-select>

          <clear-button></clear-button>
          <save-all-button></save-all-button>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn style="margin-left: 8%; font-size: 13px;" v-bind="attrs" v-on="on" class="mr-3 mb-7" @click="clearStorage()"><v-icon color="#3ab792">mdi-refresh</v-icon></v-btn>
            </template>
            <span>Reload</span>
          </v-tooltip>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn :disabled="selectedPlanNo == ''" @click="printPdf()" v-bind="attrs" v-on="on" class="mr-3 mb-7"><v-icon color="red">mdi-file-pdf-outline</v-icon></v-btn>
            </template>
            <span>Preview</span>
          </v-tooltip>

        </v-toolbar>
      </template>
    </v-app-bar>

    <v-navigation-drawer
      clipped
      color="#f1f3f4"
      height="100%"
      app
      v-model="drawer"
    >
      <v-list dense nav>
        <v-list-item active-class="active" style="text-decoration: none;" link to="/gaiheki_area">
          <v-list-item-title>Gaiheki Area</v-list-item-title>
        </v-list-item>

        <v-list-item v-show="this.selectedIHeadSticker == 'Yes'" active-class="active" style="text-decoration: none;" link to="/unit_demado">
          <v-list-item-title>Unit Demado</v-list-item-title>
        </v-list-item>

        <v-list-item active-class="active" style="text-decoration: none;" link to="/balcony">
          <v-list-item-title>Balcony</v-list-item-title>
        </v-list-item>

        <v-list-item active-class="active" style="text-decoration: none;" link to="/column">
          <v-list-item-title>Columns</v-list-item-title>
        </v-list-item>

        <!-- <v-list-item v-show="this.selectedIHeadSticker == 'Yes'" active-class="active" style="text-decoration: none;" link to="/second_floor_jiku">
          <v-list-item-title>2nd Floor (Jikugumi)</v-list-item-title>
        </v-list-item>

        <v-list-item v-show="this.selectedIHeadSticker == 'No' && this.selectedIHeadSticker !== ''" active-class="active" style="text-decoration: none;" link to="/second_floor_waku">
          <v-list-item-title>2nd Floor (Wakugumi)</v-list-item-title>
        </v-list-item> -->

        <v-list-item active-class="active" style="text-decoration: none;" link to="/second_floor_jiku">
          <v-list-item-title>2nd Floor (Jikugumi)</v-list-item-title>
        </v-list-item>

        <v-list-item active-class="active" style="text-decoration: none;" link to="/second_floor_waku">
          <v-list-item-title>2nd Floor (Wakugumi)</v-list-item-title>
        </v-list-item>

        <v-list-item active-class="active" style="text-decoration: none;" link to="/special_computations">
          <v-list-item-title>Special Computations</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { mapState } from 'vuex'
import printPdf from './pdfTemplate.js'

import clearButton from '../views/components/clearButton.vue'
import saveAllButton from '../views/components/saveAllButton.vue'

export default {
  components: { clearButton, saveAllButton },
  data(){
    return{
      loadPDF: false,
      loadPlanNo: false,
      loadOverlay: false,
      loadData: false,
      drawer: true,
      disableControlNumber: false,
      disableHouseType: true,
      disableKanabakari: true,
      disableIHead: true,

      customerCode: "",
      planNo: [],
      planShioNo: [],
      selectedPlanNo: "",
      shioNumberData: [],
      shioNo: "",
      houseTypes: [
        "和風百年Ｆ２",
        "洋風セゾンＦ２",
        "３階建ファミーユＦ２",
        "３階建ファミーユＶ３",
        "洋風セゾンＡ３",
        "洋風セゾンＡ３ムク",
        "３階建ファミーユＡ３",
        "３階建ファミーユＡ３ムク",
        "洋風セゾンＦ２‐ＴＤ",
        "グラン･セゾン(GRAND SAISON)",
        "洋風ブリアール",
        "i-cube",
        "i-cube(３階建)",
        "i-cube [WEB限定]",
        "i-cube(３階建) [WEB限定]",
        "i-smart",
        "i-smart S",
        "i-smart(３階建)",
        "i-smile＋",
        "i-smile(2×6)",
        "i-palette",
        "GRAND SMART(グラン･スマート)",
        "セゾンアシュレ(４寸仕様)"
      ],
      selectedHouseType: "",
      kanabakari: [ "240", "265", "260+" ],
      selectedKanabakari: "",
      moduleSize: 910,
      iheadSticker: [ "Yes", "No" ],
      selectedIHeadSticker: "",
      tileKinds: ["TC", "TD", "TF", "TE"],
      selectedTileKind: "",
      customerName: "",
      contractDate: "",
      yumeno: "",
      tempShioData: {
        customerCode: "",
        planNo: "",
        shioNo: "",
        houseType: "",
        ihead: "",
        tileKind: "",
        kanabakari: "",
        customerName: "",
        customerRoman: "",
        contractDate: "",
        joutoDate: "",
        yumeno: ""
      },
      tempGaihekiAreaData: [
        { direction: 'east', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: null },
        { direction: 'south', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: null },
        { direction: 'west', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: null },
        { direction: 'north', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: null }
      ],
      today: ''
    }
  },

  created() {
    this.today = new Date().getFullYear() + '年' + (new Date().getMonth() + 1) + '月' + new Date().getDate() + '日'
  },

  mounted(){
    this.getMaster()

    if(typeof(this.shioData.customerCode) !== 'undefined'){
      this.customerCode = this.shioData.customerCode
      this.selectedPlanNo = this.shioData.planNo
      this.planNo = this.shioData.planData
      this.shioNumberData = this.shioData.shioNoData
      this.shioNo = this.shioData.shioNo
      this.selectedHouseType = this.shioData.houseType
      this.selectedKanabakari = this.shioData.kanabakari
      this.selectedIHeadSticker = this.shioData.ihead
      this.selectedTileKind = this.shioData.tileKind
      this.disableControlNumber = this.controlNumberDisable
      this.customerName = this.shioData.customerName
      this.customerRoman = this.shioData.customerRoman
      this.contractDate = this.shioData.contractDate
      this.joutoDate = this.shioData.joutoDate
      this.yumeno = this.shioData.yumeno

      if(this.isClear == false){
        this.getTileData()
      }else{
        Swal.fire({
          toast: true,
          position: 'center',
          icon: 'success',
          iconColor: '#3ab792',
          title: 'Successfully Cleared',
          text: 'Please proceed to estimation.',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500
        })
      }
    }
  },

  computed: {
    ...mapState(
      [
        "shioData",
        "gaihekiAreaData",
        "demadoData",
        "balconyData",
        "columnData",
        "controlNumberDisable",
        "sashSize",
        "brickPoints",
        "isClear"
      ]
    ),

    servicePoints(){
      var servicePoints = 0

      servicePoints = this.$store.getters.getGaihekiAreaPoints.servicePoints +
              this.$store.getters.getDemadoPoints.servicePoints +
              this.$store.getters.getBalconyPoints.servicePoints +
              this.$store.getters.getColumnPoints.servicePoints

      this.$store.commit('getTotalServicePoints', parseFloat(servicePoints.toFixed(2)))
      return parseFloat(servicePoints.toFixed(2))
    },

    optionPoints(){
      var optionPoints = 0

      optionPoints = this.$store.getters.getGaihekiAreaPoints.optionPoints +
              this.$store.getters.getDemadoPoints.optionPoints +
              this.$store.getters.getBalconyPoints.optionPoints +
              this.$store.getters.getColumnPoints.optionPoints +
              this.$store.getters.get2FJikuPoints +
              this.$store.getters.get2FWakuPoints +
              this.$store.getters.getSpecialComputationPoints.additional -
              this.$store.getters.getSpecialComputationPoints.deduction
      
      this.$store.commit('getTotalOptionPoints', parseFloat(optionPoints.toFixed(2)))
      return parseFloat(optionPoints.toFixed(2))
    }
  },

  methods:{

    async printPdf(){
      this.loadPDF = true
      let x = new printPdf(
        this.shioData,
        this.gaihekiAreaData,
        this.today,
        this.selectedTileKind,
        this.optionPoints,
        this.servicePoints,
        this.$store.getters.getDemadoPoints,
        this.$store.getters.getBalconyPoints,
        this.$store.getters.getColumnPoints,
        this.$store.getters.getColumnData,
        this.$store.getters.getBalconyData,
        this.$store.getters.getDemadoData,
        this.$store.getters.getGaihekiDoorData,
        this.$store.getters.getGaihekiSashData,
        this.$store.getters.get2FJikuPoints,
        this.$store.getters.get2FWakuPoints
      )

      const asyncFunc = [x.print()]
      let result = await Promise.race(asyncFunc)

      const blob = this.save(result);
      const testURL = URL.createObjectURL(blob);
      this.loadPDF = false
      window.open(testURL);
    },

    save(dataURI) {
      const blob = new Blob([dataURI], { type: "application/pdf" });
      return blob;
    },

    getMaster(){
      axios.get('api/getMaster')
      .then(res => {
        this.$store.commit('getSashSize', res.data.sashSize)
        this.$store.commit('getBrickPoints', res.data.brickPoints)
      })
    },

    setShioData(){
      this.tempShioData.customerCode = this.customerCode
      this.tempShioData.planNo = this.selectedPlanNo
      this.tempShioData.shioNo = this.shioNo
      this.tempShioData.houseType = this.selectedHouseType
      this.tempShioData.kanabakari = this.selectedKanabakari
      this.tempShioData.ihead = this.selectedIHeadSticker
      this.tempShioData.tileKind = this.selectedTileKind
      this.tempShioData.customerName = this.customerName
      this.tempShioData.customerRoman = this.customerRoman
      this.tempShioData.contractDate = this.contractDate
      this.tempShioData.joutoDate = this.joutoDate
      this.tempShioData.yumeno = this.yumeno

      this.$store.commit('getShioData', this.tempShioData)
    },

    getPlanNo(){
      if(this.customerCode.length == 12){
        let a = this.customerCode.split("").filter((r) => {
          if (r == "," || r == "'" || r == `"`) {
            return r;
          }
        });

        if (a.length > 0) {
          Swal.fire({
            toast: true,
            position: 'center',
            icon: 'error',
            title: 'Error!',
            text: 'No Special Character Allowed.',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
          })
          return false;
        }else{
          this.disableControlNumber = true
          this.$store.commit('controlNumberDisable', this.disableControlNumber)
        }
        
        this.loadPlanNo = true
        this.planNo = []
        this.shioNo = ""
        this.selectedHouseType = ""
        this.selectedKanabakari = ""
        this.selectedIHeadSticker = ""

        axios.post('api/getPlanNumber', {
          customerCode: this.customerCode
        }).then(response => {
          this.planShioNo = response.data
          for(var i = 0; i < response.data.length; i++){
            this.planNo.push(response.data[i].plan_number)
          }
          this.loadPlanNo = false
        })
      }
    },

    getShioNo(){
      this.shioNumberData = this.planShioNo.filter(r => r.plan_number == this.selectedPlanNo).map(r=>{
        return r.shio_number
      })

      this.shioNumberData.sort()
    },

    getShioData(){
      this.loadData = true
      const shio = {
        customerCode: this.customerCode,
        planNo: this.selectedPlanNo,
        planData: this.planNo,
        shioNoData: this.shioNumberData,
        shioNo: this.shioNo,
        houseType: "",
        kanabakari: "",
        ihead: "",
        tileKind: "",
        customerName: "",
        customerRoman: "",
        contractDate: "",
        joutoDate: "",
        yumeno: ""
      }

      axios.post('api/getShioData', {
        customerCode: this.customerCode,
        planNo: this.selectedPlanNo,
        shioNo: this.shioNo
      }).then(response => {

        //house type
        if(response.data.houseType.length == 0){
          this.selectedHouseType = ""
          this.disableHouseType = false
          this.loadData = false

          Swal.fire({
            toast: true,
            position: 'center',
            icon: 'warning',
            iconColor: '#FFB300',
            title: 'Without Shiyousho Data',
            text: 'Please input data manually.',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2000
          })
        }else{
          this.selectedHouseType = response.data.houseType[0].printType
          shio.houseType = response.data.houseType[0].printType

          Swal.fire({
            position: 'center',
            icon: 'success',
            iconColor: '#3ab792',
            title: 'Shiyousho Data Extracted',
            text: 'Please proceed to estimation.',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500
          })
        }

        //kanabakari
        if(response.data.kanabakari.length == 0){
          this.selectedKanabakari = ""
          // this.disableKanabakari = false
          this.loadData = false
        }else{
          if(response.data.kanabakari[0].siyoDetailName.includes("２４")){
            this.selectedKanabakari = "240"
            shio.kanabakari = "240"
          }
          else if(response.data.kanabakari[0].siyoDetailName.includes("２６０＋") || response.data.kanabakari[0].siyoDetailName.includes("２６０+□")){
            this.selectedKanabakari = "260+"
            shio.kanabakari = "260+"
          }
          else if(response.data.kanabakari[0].siyoDetailName.includes("２６")){
            this.selectedKanabakari = "265"
            shio.kanabakari = "265"
          }
        }

        //i-head sticker
        if(response.data.ihead.length == 0){
          this.selectedIHeadSticker = ""
          this.disableIHead = false
          this.loadData = false
        }else{
          if(response.data.ihead[0].siyoDetailName == '夢の家Ⅳ' || response.data.ihead[0].siyoDetailName == '夢の家Ⅲ' || response.data.ihead[0].siyoDetailName == 'あり'){
            this.selectedIHeadSticker = "Yes"
            this.yumeno = "あり"
            shio.ihead = "Yes"
            shio.yumeno = "あり"
          }
          else if(response.data.ihead[0].siyoDetailName == ''){
            this.selectedIHeadSticker = ""
            this.yumeno = ""
            shio.ihead = ""
            shio.yumeno = ""
          }else{
            this.selectedIHeadSticker = "No"
            this.yumeno = "なし"
            shio.ihead = "No"
            shio.yumeno = "なし"
          }
          this.loadData = false
        }

        if(response.data.tileKind == "TE + TD"){
          this.selectedTileKind = "TD"
        }else if(response.data.tileKind == "TD + TF"){
          this.selectedTileKind = "TF"
        }else{
          this.selectedTileKind = response.data.tileKind
        }
        shio.tileKind = this.selectedTileKind

        //customer name
        if(response.data.customerName.length == 0){
          this.customerName = ""
          this.customerRoman = ""
          this.loadData = false
        }else{
          this.customerName = response.data.customerName[0].ConstructionName
          this.customerRoman = response.data.customerName[0].ConstructionNameRoma
          shio.customerName = this.customerName
          shio.customerRoman = this.customerRoman
        }

        //contract date
        if(response.data.contractDate.length == 0){
          this.contractDate = ""
        }else{
          if(response.data.contractDate[0].ProvisionalContractDate !== null){
            const removeZero = response.data.contractDate[0].ProvisionalContractDate.replace(' 00:00:00.000', '')
            const replaceDash = removeZero.replace(/-/g, '/')
            this.contractDate = replaceDash
            shio.contractDate = this.contractDate
          }
        }

        //jouto date
        if(response.data.joutoDate.length == 0){
          this.joutoDate = ""
        }else{
          if(response.data.joutoDate[0].ExpectedHouseRaisingDate == null){
            this.joutoDate = ""
          }else{
            const removeZero = response.data.joutoDate[0].ExpectedHouseRaisingDate.replace(' 00:00:00.000', '')
            const replaceDash = removeZero.replace(/-/g, '/')
            this.joutoDate = replaceDash
            shio.joutoDate = this.joutoDate
          }
        }

        this.$store.commit('getShioData', shio)
      })
    },

    getAllData(){
      axios.post('api/getAllData', {
        customer_code: this.customerCode,
        plan_no: this.selectedPlanNo
      }).then(res => {
        this.$store.commit('getDemadoData', res.data.demado_data)
        this.$store.commit('getBalconyData', res.data.balcony_data)
        this.$store.commit('getColumnData', res.data.column_data)
        this.$store.commit('getAdditionalData', res.data.special.filter(r => r.category == 'additional'))
        this.$store.commit('getDeductionData', res.data.special.filter(r => r.category == 'deduction'))
      })
    },

    getTileData(){
      if(Object.keys(this.gaihekiAreaData).length === 0){
        this.$store.commit(('getGaihekiAreaData'), this.tempGaihekiAreaData)
      }

      axios.post('api/getGaihekiData', {
        customer_code: this.customerCode,
        plan_no: this.selectedPlanNo
      })
      .then(async res => {

        //gaiheki area
        if(res.data.gaiheki_area.length > 0){
          const east = res.data.gaiheki_area.filter(r => r.direction == 'east')
          const south = res.data.gaiheki_area.filter(r => r.direction == 'south')
          const west = res.data.gaiheki_area.filter(r => r.direction == 'west')
          const north = res.data.gaiheki_area.filter(r => r.direction == 'north')

          if(east.length > 0){
            this.gaihekiAreaData[0] = east[0]
          }else{
            this.gaihekiAreaData[0] = this.tempGaihekiAreaData[0]
          }

          if(south.length > 0){
            this.gaihekiAreaData[1] = south[0]
          }else{
            this.gaihekiAreaData[1] = this.tempGaihekiAreaData[1]
          }

          if(west.length > 0){
            this.gaihekiAreaData[2] = west[0]
          }else{
            this.gaihekiAreaData[2] = this.tempGaihekiAreaData[2]
          }

          if(north.length > 0){
            this.gaihekiAreaData[3] = north[0]
          }else{
            this.gaihekiAreaData[3] = this.tempGaihekiAreaData[3]
          }
        }

        if(res.data.gaiheki_stc.length > 0){
          const east = res.data.gaiheki_stc.filter(r => r.direction == 'east')
          const south = res.data.gaiheki_stc.filter(r => r.direction == 'south')
          const west = res.data.gaiheki_stc.filter(r => r.direction == 'west')
          const north = res.data.gaiheki_stc.filter(r => r.direction == 'north')

          if(east.length > 0){
            this.gaihekiAreaData[0].STCsummaryData = east
          }else{
            this.gaihekiAreaData[0].STCsummaryData = []
          }

          if(south.length > 0){
            this.gaihekiAreaData[1].STCsummaryData = south
          }else{
            this.gaihekiAreaData[1].STCsummaryData = []
          }

          if(west.length > 0){
            this.gaihekiAreaData[2].STCsummaryData = west
          }else{
            this.gaihekiAreaData[2].STCsummaryData = []
          }

          if(north.length > 0){
            this.gaihekiAreaData[3].STCsummaryData = north
          }else{
            this.gaihekiAreaData[3].STCsummaryData = []
          }
        }else{
          this.gaihekiAreaData[0].STCsummaryData = []
          this.gaihekiAreaData[1].STCsummaryData = []
          this.gaihekiAreaData[2].STCsummaryData = []
          this.gaihekiAreaData[3].STCsummaryData = []
        }

        //sash
        if(res.data.sash_data.length > 0){
          let tempSashData = {
            eastSashData: res.data.sash_data.filter(r => r.direction == 'east'),
            southSashData: res.data.sash_data.filter(r => r.direction == 'south'),
            westSashData: res.data.sash_data.filter(r => r.direction == 'west'),
            northSashData: res.data.sash_data.filter(r => r.direction == 'north')
          }

          this.$store.commit('getGaihekiSashData', tempSashData)
        }

        //entrance
        if(res.data.door_data.length > 0){
          let tempDoorData = {
            eastDoorData: res.data.door_data.filter(r => r.direction == 'east'),
            southDoorData: res.data.door_data.filter(r => r.direction == 'south'),
            westDoorData: res.data.door_data.filter(r => r.direction == 'west'),
            northDoorData: res.data.door_data.filter(r => r.direction == 'north')
          }

          this.$store.commit('getGaihekiDoorData', tempDoorData)
        }

        await this.getAllData()

        axios.post('api/getTilePoints', { customer_code: this.customerCode, plan_no: this.selectedPlanNo })
        .then(res => {
          if((res.data.filter(r => r.item == 'unit demado')).length > 0){
            this.$store.commit('getDemadoPoints', res.data.filter(r => r.item == 'unit demado')[0])
          }else{
            this.$store.commit('getDemadoPoints', { 'servicePoints': 0, 'optionPoints': 0, })
          }

          if((res.data.filter(r => r.item == 'balcony')).length > 0){
            this.$store.commit('getBalconyPoints', res.data.filter(r => r.item == 'balcony')[0])
          }else{
            this.$store.commit('getBalconyPoints', { 'servicePoints': 0, 'optionPoints': 0, })
          }

          if((res.data.filter(r => r.item == 'column')).length > 0){
            this.$store.commit('getColumnPoints', res.data.filter(r => r.item == 'column')[0])
          }else{
            this.$store.commit('getColumnPoints', { 'servicePoints': 0, 'optionPoints': 0, })
          }

          if((res.data.filter(r => r.item == '2f jiku')).length > 0){
            this.$store.commit('get2FJikuPoints', res.data.filter(r => r.item == '2f jiku')[0].optionPoints)
          }else{
            this.$store.commit('get2FJikuPoints', 0)
          }

          if((res.data.filter(r => r.item == '2f waku')).length > 0){
            this.$store.commit('get2FWakuPoints', res.data.filter(r => r.item == '2f waku')[0].optionPoints)
          }else{
            this.$store.commit('get2FWakuPoints', 0)
          }

          let specialComp = { additional: 0, deduction: 0 }
          if((res.data.filter(r => r.item == 'additional')).length > 0){
            specialComp.additional = res.data.filter(r => r.item == 'additional')[0].optionPoints
          }

          if((res.data.filter(r => r.item == 'deduction')).length > 0){
            specialComp.deduction = res.data.filter(r => r.item == 'deduction')[0].optionPoints
          }

          this.$store.commit('getSpecialComputationPoints', specialComp)
        })
      })
    },

    clearStorage(){
      localStorage.removeItem("Gaiheki");
      window.location.assign("/gaiheki_area"); 
    }
  }
}
</script>

<style>
  div.v-toolbar__extension{
    background: #f1f3f4;
    align-items: center;
    display: flex;
    position: relative;
    z-index: 0;
  }

  .v-toolbar {
    width: 100% !important;
  }

  .active {
    background-color: #E3F2FD;
  }

  .v-label {
    font-size: 13px !important;
  }

  .v-tooltip__content {
    font-size: 11px !important;
    color: #0548b3;
    background-color: #cfe4fc !important;
  }

  .swal2-popup {
    font-size: 12px !important;
    font-family: 'Poppins';
  }

  .vl {
    border-left: 2px solid white;
    height: 50px;
    opacity: 0.5;
    margin-right: 10px;
  }

  #grad1 {
    background-color: #00355E;
    background-image: linear-gradient(to right, #00355E , #2A78B3);
  }
</style>