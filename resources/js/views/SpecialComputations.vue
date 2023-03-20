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
            <v-col cols="6">
                <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px">Additional
                    <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-2" x-small>+</v-chip>
                </v-card-title>

                <v-card elevation="1" class="ma-5">
                    <v-row class="pl-3 pr-3">
                        <v-col cols="12">
                            <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                                <thead>
                                    <th style="font-size: 12px; width: 70%;" class="text-center">Input</th>
                                    <th style="font-size: 12px;" class="text-center">Answer</th>
                                    <th><v-icon small color="primary" @click="addAdditionalData()">mdi-plus-circle</v-icon></th>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in additionalData" :key="index">
                                        <td><input v-model="item.input" @blur="evaluateAdditional(item)" type="text" class="form-control text-center"></td>
                                        <td><input v-model="item.answer" disabled type="text" class="form-control text-center"></td>
                                        <td><v-icon tabindex="-1" small color="red" @click="deleteAdditionalData(index)">mdi-close-circle</v-icon></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="font-size: 12px;" class="text-center">Total</td>
                                        <td style="font-size: 13px; color: #00355e;" class="text-center">{{ totalAdditional }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </v-col>
                    </v-row>
                </v-card>

                <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveData()">Save</v-btn> -->
            </v-col>
    
            <v-col cols="6">
                <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px">Deduction
                    <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-2" x-small>-</v-chip>
                </v-card-title>

                <v-card elevation="1" class="ma-5">
                    <v-row class="pl-3 pr-3">
                        <v-col cols="12">
                            <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                                <thead>
                                    <th style="font-size: 12px; width: 70%;" class="text-center">Input</th>
                                    <th style="font-size: 12px;" class="text-center">Answer</th>
                                    <th><v-icon small color="primary" @click="addDeductionData(), identifier = 'deduction'">mdi-plus-circle</v-icon></th>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in deductionData" :key="index">
                                        <td><input v-model="item.input" @blur="evaluateDeduction(item)" type="text" class="form-control text-center"></td>
                                        <td><input v-model="item.answer" disabled type="text" class="form-control text-center"></td>
                                        <td><v-icon tabindex="-1" small color="red" @click="deleteDeductionData(index), identifier = 'deduction'">mdi-close-circle</v-icon></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="font-size: 12px;" class="text-center">Total</td>
                                        <td style="font-size: 13px; color: #00355e;" class="text-center">{{ totalDeduction }}</td>
                                    </tr>
                                </tfoot>
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
  import { evaluate } from 'mathjs'
  export default {
    data() {
      return{
        loadData: false,
        savingData: false,
        identifier: "",
        additionalData: [
            { input: "", answer: null }
        ],
        deductionData: [
            { input: "", answer: null }
        ],
        totalPoints: { additional: 0, deduction: 0 }
      }
    },
  
    watch:{
        shioData(val){
            if(typeof(val.customerCode) !== 'undefined'){
                this.getData()
            }
        }
    },
  
    created(){
        if(this.$store.getters.getAdditionalData.length > 0)
            this.additionalData = this.$store.getters.getAdditionalData

        if(this.$store.getters.getDeductionData.length > 0)
            this.deductionData = this.$store.getters.getDeductionData
    },
  
    methods:{
        evaluateAdditional(item){
            if(this.additionalData[this.additionalData.length - 1].input !== ""){
                let arr = { input: "", answer: null }
                this.additionalData.push(arr)
            }

            item.answer = evaluate(item.input)
            this.$store.commit('getAdditionalData', this.additionalData)
        },

        evaluateDeduction(item){
            if(this.deductionData[this.deductionData.length - 1].input !== ""){
                let arr = { input: "", answer: null }
                this.deductionData.push(arr)
            }

            item.answer = evaluate(item.input)
            this.$store.commit('getDeductionData', this.deductionData)
        },

        addAdditionalData(){
            if(this.additionalData.length == 0){
                let data = { input: "", answer: null }
                this.additionalData.push(data);
            }
            else if(this.additionalData[this.additionalData.length - 1].input !== ""){
                let data = { input: "", answer: null }
                this.additionalData.push(data);
            }
        },

        addDeductionData(){
            if(this.deductionData.length == 0){
                let data = { input: "", answer: null }
                this.deductionData.push(data);
            }
            else if(this.deductionData[this.deductionData.length - 1].input !== ""){
                let data = { input: "", answer: null }
                this.deductionData.push(data);
            }
        },

        deleteAdditionalData(index) {
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
                    this.additionalData.splice(index, 1);
                    this.$store.commit('getAdditionalData', this.additionalData)
                }
            })
        },

        deleteDeductionData(index){
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
                    this.deductionData.splice(index, 1);
                    this.$store.commit('getDeductionData', this.deductionData)
                }
            })
        },

        getData(){
            this.loadData = true
            
            axios.post('api/getSpecialComputations', {
                customer_code: this.shioData.customerCode,
                plan_no: this.shioData.planNo
            }).then(res => {
                if(res.data.computations.length > 0){
                    this.additionalData = res.data.computations.filter(r => r.category == 'additional')
                    this.deductionData = res.data.computations.filter(r => r.category == 'deduction')
                    this.$store.commit('getAdditionalData', this.additionalData)
                    this.$store.commit('getDeductionData', this.deductionData)
                }

                if(res.data.points.length > 0){
                    this.totalPoints.additional = res.data.points.filter(r => r.item == 'additional')[0].option_point
                    this.totalPoints.deduction = res.data.points.filter(r => r.item == 'deduction')[0].option_point
                    this.$store.commit('getSpecialComputationPoints', this.totalPoints)
                }

                this.loadData = false
            })
        },

        saveData(){
            this.savingData = true

            axios.post('api/saveSpecialComputations', {
                additionalData: this.additionalData,
                deductionData: this.deductionData,
                totalAdditional: this.totalAdditional,
                totalDeduction: this.totalDeduction,
                customer_code: this.shioData.customerCode,
                plan_no: this.shioData.planNo
            }).then(res => {
                this.savingData = false

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    iconColor: '#3ab792',
                    title: 'Success!',
                    text: 'Data has been saved.',
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 2500
                })
            })
        }
    },
  
    computed: {
        ...mapState(["shioData"]),
        
        totalAdditional(){
            let total = 0;
            this.additionalData.filter((rec) => {
                total += rec.answer;
            });

            if(Number.isNaN(total)){
                total = 0
            }

            this.totalPoints.additional = total
            this.$store.commit('getSpecialComputationPoints', this.totalPoints)

            return total;
        },

        totalDeduction() {
            let total = 0;
            this.deductionData.filter((rec) => {
                total += rec.answer;
            });

            if(Number.isNaN(total)){
                total = 0
            }

            this.totalPoints.deduction = total
            this.$store.commit('getSpecialComputationPoints', this.totalPoints)
            
            return total;
        }
    }
  };
</script>
  
<style scoped>
    input{
        font-size: 12px;
    }

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
</style>