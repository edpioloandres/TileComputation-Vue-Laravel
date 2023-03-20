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
        <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px">Balcony
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ml-2" x-small>
            in Meter
          </v-chip>
        </v-card-title>
        <v-card elevation="1" class="ma-5">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Balcony Type
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Kind
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Left
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Center
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Right
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Option
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Service
                    </th>
                    <th>
                      <v-icon small color="primary" @click="addBalconyData()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in balconyData" :key="index">
                    <td>
                      <select @change="setBalconyKind(data)" v-model="data.type" class="custom-select" style="width:200px">
                        <option value="0"></option>
                        <option value="JY 型 (JY Gata) Original type">JY 型 (JY Gata) Original type</option>
                        <option value="Kasagi Balcony">Kasagi Balcony</option>
                        <option value="Fine Balcony">Fine Balcony</option>
                      </select>
                    </td>
                    <td>
                      <select @change="balconyComputation(data)" v-model="data.kinds" :disabled="disableKind(data)" class="custom-select" style="width:150px">
                        <option value="Service">Service</option>
                        <option value="Option">Option</option>
                      </select>
                    </td>
                    <td>
                      <input onwheel="return false;" :disabled="data.type == ''" @change="balconyComputation(data)" v-model="data.left" @focus="$event.target.select()" type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input onwheel="return false;" :disabled="data.type == ''" @change="balconyComputation(data)" v-model="data.center" @focus="$event.target.select()" type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input onwheel="return false;" :disabled="data.type == ''" @change="balconyComputation(data)" v-model="data.right" @focus="$event.target.select()" type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input @change="balconyComputation(data)" v-model="data.tempOption" disabled type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input @change="balconyComputation(data)" v-model="data.tempService" disabled type="number" class="form-control text-center">
                    </td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteBalconyData(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>

        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveBalcony()">Save</v-btn> -->
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
export default {
  data() {
    return{
      loadData: false,
      savingData: false,
      overlay: false,
      balconyKinds: [ "Service", "Option" ],
      balconyTypes: [ "JY 型 (JY Gata) Original type", "Kasagi Balcony", "Fine Balcony" ],
      balconyData: [
        {
          type: "",
          kinds: "",
          left: null,
          center: null,
          right: null,
          option: 0,
          service: 0,
          tempOption: 0,
          tempService: 0
        }
      ],
      tempTotalPoints: { servicePoints: 0, optionPoints: 0 }
    };
  },

  watch:{
    shioData(val){
      if(typeof(val.customerCode) !== 'undefined'){
        this.getBalcony()
      }
    }
  },

  created(){
    if(this.$store.getters.getBalconyData.length > 0)
      this.balconyData = this.$store.getters.getBalconyData
  },

  methods:{

    disableKind(data) {
      if(data.type == "Kasagi Balcony" || data.type == ""){
        return true;
      }
      else if(data.type == "JY 型 (JY Gata) Original type"){
        if(this.shioData.tileKind == 'TF'){
          return true;
        }else{
          return false;
        }
      }else if(data.type == "Fine Balcony"){
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          return true;
        }else{
          return false;
        }
      }
    },

    addBalconyData() {
      if(this.balconyData.length == 0){
        let arr = {
          type: "",
          kinds: "",
          left: null,
          center: null,
          right: null,
          option: 0,
          service: 0,
        };
        this.balconyData.push(arr);
      }
      else if(this.balconyData[this.balconyData.length - 1].option != 0 && this.balconyData[this.balconyData.length - 1].service != 0){
        let arr = {
          type: "",
          kinds: "",
          left: null,
          center: null,
          right: null,
          option: 0,
          service: 0,
          tempOption: 0,
          tempService: 0,
        };
        this.balconyData.push(arr);
      }
    },

    deleteBalconyData(index) {
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
          this.balconyData.splice(index, 1);
          this.$store.commit('getBalconyData', this.balconyData)
        }
      })
    },

    setBalconyKind(data){
      // without default if Fine Balcony
      if(data.type == "JY 型 (JY Gata) Original type"){
        if(this.shioData.tileKind == 'TF'){
          data.kinds = "Option"
        }else{
          data.kinds = "Service"
        }
      }
      else if(data.type == "Kasagi Balcony"){
        data.kinds = "Option"
      }
      else if(data.type == "Fine Balcony"){
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          data.kinds = "Option"
        }else{
          return false;
        }
      }

      this.$store.commit('getBalconyData', this.balconyData)
    },

    balconyComputation(data) {
      if(this.balconyData[this.balconyData.length - 1].type != ""){
        let arr = {
          type: "",
          kinds: "",
          left: null,
          center: null,
          right: null,
          option: 0,
          service: 0,
          tempOption: 0,
          tempService: 0,
        };
        this.balconyData.push(arr);
      }

      if(data.type == "JY 型 (JY Gata) Original type"){
        let standardHeight = 1.3;
        
        if(data.kinds == "Service"){
          data.service = (parseFloat(data.left || 0) + parseFloat(data.center || 0) + parseFloat(data.right || 0)) * standardHeight;
          console.log(data.service)
          data.tempService = parseFloat(data.service);
          data.tempOption = 0;
          data.option = null;
        }
        else if(data.kinds == "Option"){
          data.option = (parseFloat(data.left || 0) + parseFloat(data.center || 0) + parseFloat(data.right || 0)) * standardHeight;
          data.tempOption = parseFloat(data.option);
          data.tempService = 0;
          data.service = null;
        }
      }
      else if(data.type == "Kasagi Balcony"){
        let standardHeight = 1.7;
        data.option = (parseFloat(data.left || 0) + parseFloat(data.center || 0) + parseFloat(data.right || 0)) * standardHeight;
        data.tempOption = parseFloat(data.option);
        data.tempService = 0;
        data.service = null;
      }
      else if(data.type == "Fine Balcony"){
        let standardHeight = 0.988;
        
        if(data.kinds == "Service"){
          data.service = (parseFloat(data.left || 0) + parseFloat(data.center || 0) + parseFloat(data.right || 0)) * standardHeight;
          console.log(data.service)
          data.tempService = parseFloat(data.service);
          data.tempOption = 0;
          data.option = null;
        }
        else if(data.kinds == "Option"){
          data.option = (parseFloat(data.left || 0) + parseFloat(data.center || 0) + parseFloat(data.right || 0)) * standardHeight;
          data.tempOption = parseFloat(data.option);
          data.tempService = 0;
          data.service = null;
        }
      }
      else{
        return false;
      }

      this.$store.commit('getBalconyData', this.balconyData)
    },

    getBalcony(){
      this.loadData = true
      
      axios.post('api/getBalcony', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo
      })
      .then(res => {
        let balconyArr = res.data.balcony_data
        balconyArr.forEach(object => {
          object.option = object.tempOption
          object.service = object.tempService
        });

        this.balconyData = balconyArr
        this.$store.commit('getBalconyData', this.balconyData)

        if(res.data.balcony_point.length > 0){
          this.tempTotalPoints.optionPoints = res.data.balcony_point.option_point
          this.tempTotalPoints.servicePoints = res.data.balcony_point.service_point
          this.$store.commit('getBalconyPoints', this.tempTotalPoints)
        }

        this.loadData = false
      })
    },

    saveBalcony(){
      this.savingData = true
      let balconyArr = this.balconyData

      const empty = balconyArr.filter(r => r.type == "")
      if(empty.length > 0){
        const id = balconyArr.findIndex(r => r.type == "")
        balconyArr.splice(id, 1);
      }
      
      balconyArr.forEach(object => {
        object.customer_code = this.shioData.customerCode
        object.plan_no = this.shioData.planNo
      });

      axios.post('api/saveBalcony', {
        balconyArr,
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
          text: 'Balcony data has been saved.',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2500
        })
      })
    }
  },

  computed: {
    ...mapState(["shioData"]),

    totalOption(){
      let total = 0;
      this.balconyData.filter((rec) => {
        if(rec.hasOwnProperty('tempOption') == false || rec.tempOption !== null){
          total += rec.tempOption;
        }
      });

      if(Number.isNaN(total)){
        total = 0
      }

      this.tempTotalPoints.optionPoints = total;
      this.$store.commit('getBalconyPoints', this.tempTotalPoints)
      return total;
    },

    totalService() {
      let total = 0;
      this.balconyData.filter((rec) => {
        if(rec.hasOwnProperty('tempService') == false || rec.tempService !== null){
          total += rec.tempService;
        }
      });

      if(Number.isNaN(total)){
        total = 0
      }
      
      this.tempTotalPoints.servicePoints = total;
      this.$store.commit('getBalconyPoints', this.tempTotalPoints)
      return total;
    }
  }
};
</script>

<style scoped>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type="number"] {
    -moz-appearance: textfield;
  }

  table {
    width: 100%;
  }

  input {
    font-size: 12px;
  }

  select {
    font-size: 12px;
  }
</style>