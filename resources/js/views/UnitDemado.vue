<template>
  <div>
    <div class="text-center">
      <v-overlay :value="loadData"></v-overlay>
      <v-dialog v-model="loadData" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="pt-2">
            <span>Fetching Data . . .</span>
            <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>

    <div class="text-center">
      <v-overlay :value="savingData"></v-overlay>
      <v-dialog v-model="savingData" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="pt-2">
            <span>Please wait . . .</span>
            <v-progress-linear indeterminate color="#2A78B3" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
    
    <v-row>
      <v-col cols="9">
        <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px">Unit Demado</v-card-title>
        <v-card elevation="1" class="ma-5">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Unit Demado
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Quantity
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      U or A
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Option
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Service
                    </th>
                    <th>
                      <v-icon small color="primary" @click="addDemadoRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in demadoData" :key="index">
                    <td>
                      <select @change="demadoComputation(data), (data.id = index)" v-model="data.kinds" class="custom-select" style="width:280px">
                        <option value="0"></option>
                        <option value="Bay Window 75U">Bay Window 75U</option>
                        <option value="Bay Window 90U">Bay Window 90U</option>
                        <option value="Harmony Bay Window 75U">Harmony Bay Window 75U</option>
                        <option value="Harmony Bay Window 90U">Harmony Bay Window 90U</option>
                        <option value="Precious Window 60U">Precious Window 60U</option>
                        <option value="Precious Window 90U">Precious Window 90U</option>
                        <option value="Furniture Window 60U">Furniture Window 60U</option>
                        <option value="Furniture Window 90U">Furniture Window 90U</option>
                        <option value="Harmony PF Window 60U">Harmony PF Window 60U</option>
                        <option value="Harmony PF Window 90U">Harmony PF Window 90U</option>
                        <option value="Harmony Rhythm Window 30U">Harmony Rhythm Window 30U</option>
                        <option value="Harmony Rhythm Window 60U">Harmony Rhythm Window 60U</option>
                        <option value="Harmony Royal Window 75U">Harmony Royal Window 75U</option>
                        <option value="Harmony Royal Window 90U">Harmony Royal Window 90U</option>
                        <option value="Rhythm Window 30U">Rhythm Window 30U</option>
                        <option value="Jibukuro Washitsu Demado 90U">Jibukuro Washitsu Demado 90U</option>
                      </select>
                    </td>
                    <td>
                      <input onwheel="return false;" @change="demadoComputation(data)" @focus="$event.target.select()" v-model="data.quantity" type="number" class="form-control text-center">
                    </td>
                    <td>
                      <select @change="demadoComputation(data)" v-model="data.unitAssembly" class="custom-select" style="width:120px">
                        <option value="Unit">Unit</option>
                        <option value="Assembly">Assembly</option>
                      </select>
                    </td>
                    <td><input v-model="data.tempOption" disabled type="number" class="form-control text-center"></td>
                    <td><input v-model="data.tempService" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteDemadoRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>

        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveUnitDemado()">Save</v-btn> -->
      </v-col>

      <v-col cols="3">
        <v-card-title style="font-weight: bold; font-size: 16px; color: #00355e" class="mb-5">Summary</v-card-title>
        <v-card elevation="1" class="ma-5">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Total Option
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Total Service
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input v-model="totalOption" disabled type="number" class="form-control text-center"></td>
                    <td><input v-model="totalService" disabled type="number" class="form-control text-center"></td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
        
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { mapState } from 'vuex'
import { getType } from 'pdf-lib';
export default {
  data(){
    return {
      loadData: false,
      savingData: false,
      overlay: false,
      demadoData: [
        {
          id: null,
          kinds: "",
          quantity: null,
          unitAssembly: "Unit",
          service: 0,
          option: 0,
          tempService: 0,
          tempOption: 0
        }
      ],
      demadoKinds: [
        "Bay Window 75U",
        "Bay Window 90U",
        "Harmony Bay Window 75U",
        "Harmony Bay Window 90U",
        "Precious Window 60U",
        "Precious Window 90U",
        "Furniture Window 60U",
        "Furniture Window 90U",
        "Harmony PF Window 60U",
        "Harmony PF Window 90U",
        "Harmony Rhythm Window 30U",
        "Harmony Rhythm Window 60U",
        "Harmony Royal Window 75U",
        "Harmony Royal Window 90U",
        "Rhythm Window 30U",
        "Jibukuro Washitsu Demado 90U"
      ],
      unitOrAssembly: [ "Unit", "Assembly" ],
      tempTotalPoints: { servicePoints: 0, optionPoints: 0 }
    }
  },

  watch:{
    shioData(val){
      if(typeof(val.customerCode) !== 'undefined'){
        this.getUnitDemado()
      }
    }
  },

  mounted(){
    this.demadoData = this.$store.getters.getDemadoData
    // else{
    //   if(typeof(this.shioData.customerCode) !== 'undefined'){
    //     this.getUnitDemado()
    //   }
    // }
  },

  methods:{

    addDemadoRow(){
      if(this.demadoData.length == 0){
        let row = {
          kinds: "",
          quantity: null,
          unitAssembly: "Unit",
          service: null,
          option: null,
          tempService: 0,
          tempOption: 0,
        };
        this.demadoData.push(row);
      }
      else if(this.demadoData[this.demadoData.length - 1].tempService != 0 && this.demadoData[this.demadoData.length - 1].tempOption != 0){
        let row = {
          kinds: "",
          quantity: null,
          unitAssembly: "Unit",
          service: null,
          option: null,
          tempService: 0,
          tempOption: 0,
        };
        this.demadoData.push(row);
      }
    },

    deleteDemadoRow(index) {
      Swal.fire({
        icon: "question",
        text: "Do you want to delete this data?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: "Delete",
        denyButtonText: "Cancel"
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.demadoData.splice(index, 1);
          this.$store.commit('getDemadoData', this.demadoData)
        }
      })
    },

    demadoComputation(item){
      if(this.demadoData[this.demadoData.length - 1].kinds != ""){
        let row = {
          kinds: "",
          quantity: null,
          unitAssembly: "Unit",
          service: null,
          option: null,
          tempService: 0,
          tempOption: 0,
        };
        this.demadoData.push(row);
      }

      if(item.kinds == "Bay Window 75U"){
        let tilepoint = 2.16;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Bay Window 90U"){
        let tilepoint = 2.29;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Bay Window 75U") {
        let tilepoint = 8.16;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Bay Window 90U"){
        let tilepoint = 9.2;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if (item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Precious Window 60U"){
        let tilepoint = 5.5;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Precious Window 90U"){
        let tilepoint = 6.35;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Furniture Window 60U"){
        let tilepoint = 3.32;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Furniture Window 90U"){
        let tilepoint = 4.24;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony PF Window 60U"){
        let tilepoint = 11.25;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony PF Window 90U"){
        let tilepoint = 15.45;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Rhythm Window 30U"){
        let tilepoint = 6.82;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Rhythm Window 60U"){
        let tilepoint = 9.99;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Royal Window 75U"){
        let tilepoint = 12.16;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Harmony Royal Window 90U"){
        let tilepoint = 13.14;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Rhythm Window 30U"){
        let tilepoint = 2.63;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if (item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else if(item.kinds == "Jibukuro Washitsu Demado 90U"){
        let tilepoint = 4.13;
        if(item.unitAssembly == "Assembly"){
          item.option = item.quantity * tilepoint;
          item.tempOption = parseFloat(item.option);
          item.tempService = null;
          item.service = null;
        }
        else if(item.unitAssembly == "Unit"){
          item.service = item.quantity * tilepoint;
          item.tempService = parseFloat(item.service);
          item.tempOption = null;
          item.option = null;
        }
      }
      else{
        return false;
      }

      this.$store.commit('getDemadoData', this.demadoData)
    },

    getUnitDemado(){
      this.loadData = true
      axios.post('api/getUnitDemado', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo
      })
      .then(res => {
        let demadoArr = res.data.demado_data
        demadoArr.forEach(object => {
          object.option = object.tempOption
          object.service = object.tempService
        });

        this.demadoData = demadoArr
        this.$store.commit('getDemadoData', this.demadoData)

        if(res.data.demado_point.length > 0){
          this.tempTotalPoints.optionPoints = res.data.demado_point.option_point
          this.tempTotalPoints.servicePoints = res.data.demado_point.service_point
          this.$store.commit('getDemadoPoints', this.tempTotalPoints)
        }

        this.loadData = false
      })
    },

    saveUnitDemado(){
      this.savingData = true
      let demadoArr = this.demadoData

      const empty = demadoArr.filter(r => r.kinds == "")
      if(empty.length > 0){
        const id = demadoArr.findIndex(r => r.kinds == "")
        demadoArr.splice(id, 1);
      }
      
      demadoArr.forEach(object => {
        object.customer_code = this.shioData.customerCode
        object.plan_no = this.shioData.planNo
      });

      axios.post('api/saveUnitDemado', {
        demadoArr,
        optionPoint: this.totalOption,
        servicePoint: this.totalService,
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo
      })
      .then(res => {
        this.savingData = false

        Swal.fire({
          position: 'center',
          icon: 'success',
          iconColor: '#3ab792',
          title: 'Success!',
          text: 'Unit Demado data has been saved.',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2500
        })
      })
    }
  },

  computed: {
    ...mapState(["shioData"]),

    totalOption() {
      let total = 0;
      this.demadoData.filter((rec) => {
        total += rec.tempOption;
      });
     
      this.tempTotalPoints.optionPoints = total;
      this.$store.commit('getDemadoPoints', this.tempTotalPoints)
      return total;
    },

    totalService() {
      let total = 0;
      this.demadoData.filter((rec) => {
        total += rec.tempService;
      });

      this.tempTotalPoints.servicePoints = total;
      this.$store.commit('getDemadoPoints', this.tempTotalPoints)
      return total;
    }
  }
};

</script>

<style scoped>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button{
    -webkit-appearance: none;
    margin: 0;
  }

  input[type="number"]{
    -moz-appearance: textfield;
  }
  
  table{
    width: 100%;
  }

  input {
    font-size: 12px;
  }

  select {
    font-size: 12px;
  }
</style>