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
        <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px">Columns</v-card-title>
        <v-card elevation="1" class="ma-5">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Column Type
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Kind
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Quantity
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Option
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Service
                    </th>
                    <th>
                      <v-icon small color="primary" @click="addColumnRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in columnData" :key="index">
                    <td>
                      <select @change="columnComputation(data)" v-model="data.columnName" class="custom-select" style="width:280px">
                        <option value="0"></option>
                        <option value="1.5 Syaku Kaku Hashira (455x455)">1.5 Syaku Kaku Hashira (455x455)</option>
                        <option value="No Name 01 (455x910)">No Name 01 (455x910)</option>
                        <option value="910 x 910">910 x 910</option>
                        <option value="1 Syaku Hashira (120x303)">1 Syaku Hashira (120x303)</option>
                        <option value="Hashira Maki (120x120)">Hashira Maki (120x120)</option>
                        <option value="1.5 Syaku Hashira (120x455)">1.5 Syaku Hashira (120x455)</option>
                        <option value="2 Syaku Hashira (120x606)">2 Syaku Hashira (120x606)</option>
                        <option value="3 Syaku Hashira (120x910)">3 Syaku Hashira (120x910)</option>
                        <option value="1 Syaku Kaku Hashira (303x303)">1 Syaku Kaku Hashira (303x303)</option>
                        <option value="Kabe Kurinuki 3 Syaku Hashira">Kabe Kurinuki 3 Syaku Hashira</option>
                        <option value="L Gata Hashira">L Gata Hashira</option>
                        <option value="No Name 02">No Name 02</option>
                      </select>
                    </td>
                    <td>
                      <select @change="columnComputation(data)" v-model="data.kind" :disabled="disableKind(data)" class="custom-select" style="width:120px">
                        <option value="0"></option>
                        <option value="Service">Service</option>
                        <option value="Option">Option</option>
                      </select>
                    </td>
                    <td>
                      <input onwheel="return false;" :disabled="data.columnName == ''" @focus="$event.target.select()" @keyup="columnComputation(data)" v-model="data.quantity" type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input v-model="data.tempOption" disabled type="number" class="form-control text-center">
                    </td>
                    <td>
                      <input v-model="data.tempService" disabled type="number" class="form-control text-center">
                    </td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteColumnRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>

        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveColumn()">Save</v-btn> -->
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
  data(){
    return {
      loadData: false,
      savingData: false,
      overlay: false,
      disable: false,
      unitOrAssembly: [ "Service", "Option" ],
      columnKinds: [
        "1.5 Syaku Kaku Hashira (455x455)",
        "No Name 01 (455x910)",
        "910 x 910",
        "1 Syaku Hashira (120x303)",
        "Hashira Maki (120x120)",
        "1.5 Syaku Hashira (120x455)",
        "2 Syaku Hashira (120x606)",
        "3 Syaku Hashira (120x910)",
        "1 Syaku Kaku Hashira (303x303)",
        "Kabe Kurinuki 3 Syaku Hashira",
        "L Gata Hashira",
        "No Name 02"
      ],
      columnData: [
        {
          columnName: "",
          quantity: null,
          kind: "",
          option: 0,
          service: 0,
          tempService: 0,
          tempOption: 0
        }
      ],
      tempTotalPoints: { servicePoints: 0, optionPoints: 0 }
    }
  },

  watch:{
    shioData(val){
      if(typeof(val.customerCode) !== 'undefined'){
        this.getColumn()
      }
    }
  },

  created(){
    if(this.$store.getters.getColumnData.length > 0)
      this.columnData = this.$store.getters.getColumnData
  },
  
  methods:{
    
    disableKind(data){
      if (data.columnName == "Hashira Maki (120x120)" || data.columnName == "") {
        return true;
      } else if (data.columnName == "1.5 Syaku Hashira (120x455)") {
        return true;
      } else if (data.columnName == "2 Syaku Hashira (120x606)") {
        return true;
      } else if (data.columnName == "3 Syaku Hashira (120x910)") {
        return true;
      } else if (data.columnName == "1 Syaku Kaku Hashira (303x303)") {
        return true;
      } else if (data.columnName == "1.5 Syaku Kaku Hashira (455x455)") {
        return true;
      } else if (data.columnName == "Kabe Kurinuki 3 Syaku Hashira") {
        return true;
      } else if (data.columnName == "L Gata Hashira") {
        return true;
      } else if (data.columnName == "No Name 01 (455x910)") {
        return true;
      } else if (data.columnName == "No Name 02") {
        return true;
      } else if (data.columnName == "910 x 910") {
        return true;
      } else if (data.columnName == "1 Syaku Hashira (120x303)") {
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          return true;
        }else{
          return false;
        }
      }
    },
    
    addColumnRow(){
      if(this.columnData.length == 0){
        let row = {
          columnName: "",
          quantity: null,
          kind: "",
          option: 0,
          service: 0,
          tempService: 0,
          tempOption: 0,
        };
        this.columnData.push(row);
      }
      else if(this.columnData[this.columnData.length - 1].service != 0 && this.columnData[this.columnData.length - 1].option != 0){
        let row = {
          columnName: "",
          quantity: null,
          kind: "",
          option: 0,
          service: 0,
          tempService: 0,
          tempOption: 0,
        };
        this.columnData.push(row);
      }
      else{
        return false;
      }
    },

    deleteColumnRow(index){
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
          this.columnData.splice(index, 1);
          this.$store.commit('getColumnData', this.columnData)
        }
      })
    },

    columnComputation(data) {
      if(this.columnData[this.columnData.length - 1].columnName != ""){
        let row = {
          columnName: "",
          quantity: null,
          kind: "",
          option: 0,
          service: 0,
          tempService: 0,
          tempOption: 0,
        };
        this.columnData.push(row);
      }

      if(data.columnName == "Hashira Maki (120x120)"){
        let tilepoint = 2.02;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "1 Syaku Hashira (120x303)"){
        let tilepoint = 3.44;
        this.disable = false;
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          data.kind = "Option"
          data.option = data.quantity * tilepoint;
          data.tempOption = parseFloat(data.option);
          data.tempService = null;
          data.service = null;
        }else{
          if(data.kind == "Option"){
            data.option = data.quantity * tilepoint;
            data.tempOption = parseFloat(data.option);
            data.tempService = null;
            data.service = null;
          }
          else if (data.kind == "Service"){
            data.service = data.quantity * tilepoint;
            data.tempService = parseFloat(data.service);
            data.tempOption = null;
            data.option = null;
          }
        }
      }
      else if(data.columnName == "1.5 Syaku Hashira (120x455)"){
        let tilepoint = 4.86;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "2 Syaku Hashira (120x606)"){
        let tilepoint = 5.57;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "3 Syaku Hashira (120x910)"){
        let tilepoint = 7.58;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "1 Syaku Kaku Hashira (303x303)"){
        let tilepoint = 5.65;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "1.5 Syaku Kaku Hashira (455x455)"){
        let tilepoint = 7.48;
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          data.kind = "Option";
          data.option = data.quantity * tilepoint;
          data.tempOption = parseFloat(data.option);
          data.tempService = null;
          data.service = null;
        }else{
          data.kind = "Service";
          data.service = data.quantity * tilepoint;
          data.tempService = parseFloat(data.service);
          data.tempOption = null;
          data.option = null;
        }
      }
      else if (data.columnName == "Kabe Kurinuki 3 Syaku Hashira"){
        let tilepoint = 5.09;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "L Gata Hashira"){
        let tilepoint = 7.48;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "No Name 01 (455x910)"){
        let tilepoint = 10.21;
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          data.kind = "Option";
          data.option = data.quantity * tilepoint;
          data.tempOption = parseFloat(data.option);
          data.tempService = null;
          data.service = null;
        }else{
          data.kind = "Service";
          data.service = data.quantity * tilepoint;
          data.tempService = parseFloat(data.service);
          data.tempOption = null;
          data.option = null;
        }
      }
      else if(data.columnName == "No Name 02"){
        let tilepoint = 6.57;
        data.option = data.quantity * tilepoint;
        data.tempOption = parseFloat(data.option);
        data.tempService = null;
        data.kind = "Option";
        data.service = null;
      }
      else if(data.columnName == "910 x 910"){
        let tilepoint = 12.94;
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          data.kind = "Option";
          data.option = data.quantity * tilepoint;
          data.tempOption = parseFloat(data.option);
          data.tempService = null;
          data.service = null;
        }else{
          data.kind = "Service";
          data.service = data.quantity * tilepoint;
          data.tempService = parseFloat(data.service);
          data.tempOption = null;
          data.option = null;
        }
      }

      this.$store.commit('getColumnData', this.columnData)
    },

    getColumn(){
      this.loadData = true
      axios.post('api/getColumn', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo
      })
      .then(res => {
        let columnArr = res.data.column_data
        columnArr.forEach(object => {
          object.option = object.tempOption
          object.service = object.tempService
        });

        this.columnData = columnArr
        this.$store.commit('getColumnData', this.columnData)

        if(res.data.column_point.length > 0){
          this.tempTotalPoints.optionPoints = res.data.column_point.option_point
          this.tempTotalPoints.servicePoints = res.data.column_point.service_point
          this.$store.commit('getColumnPoints', this.tempTotalPoints)
        }

        this.loadData = false
      })
    },

    saveColumn(){
      this.savingData = true
      let columnArr = this.columnData

      const empty = columnArr.filter(r => r.columnName == "")
      if(empty.length > 0){
        const id = columnArr.findIndex(r => r.columnName == "")
        columnArr.splice(id, 1);
      }
      
      columnArr.forEach(object => {
        object.customer_code = this.shioData.customerCode
        object.plan_no = this.shioData.planNo
      });

      axios.post('api/saveColumn', {
        columnArr,
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
          text: 'Column data has been saved.',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2500
        })
      })
    }
  },

  computed:{
    ...mapState(["shioData"]),

    totalOption() {
      let total = 0;
      this.columnData.filter((rec) => {
        total += rec.tempOption;
      });

      this.tempTotalPoints.optionPoints = total;
      this.$store.commit('getColumnPoints', this.tempTotalPoints)
      return total;
    },

    totalService() {
      let total = 0;
      this.columnData.filter((rec) => {
        total += rec.tempService;
      });
      
      this.tempTotalPoints.servicePoints = total;
      this.$store.commit('getColumnPoints', this.tempTotalPoints)
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

  .fontSize {
    font-size: 15px;
  }

  input {
    font-size: 12px;
  }

  select {
    font-size: 12px;
  }
</style>
