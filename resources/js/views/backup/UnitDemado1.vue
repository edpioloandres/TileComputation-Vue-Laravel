<template>
  <div>
    <v-overlay v-model="overlay">
      <v-progress-circular
        size="75"
        indeterminate
      ></v-progress-circular>
    </v-overlay>

    <v-row>
      <v-col cols="7">
        <v-card-title style="font-weight: bold; color: #00355e; font-size: 16px;">Unit Demado</v-card-title>

        <v-card elevation="1" class="ma-5">
          <v-row class="pl-5 pr-5">
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
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select class="custom-select" style="width:280px">
                        <option></option>
                      </select>
                    </td>
                    <td><input type="number" class="form-control text-center"></td>
                    <td>
                      <select class="custom-select" style="width:100px">
                        <option></option>
                      </select>
                    </td>
                    <td><input disabled type="number" class="form-control text-center"></td>
                    <td><input disabled type="number" class="form-control text-center"></td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <v-col cols="5">
        <v-card-title style="font-weight: bold; font-size: 16px; color: #00355e;" class="mb-5">Summary</v-card-title>

        <v-card elevation="1" class="ma-5">
          <v-row class="pl-5 pr-5">
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
                    <td><input disabled type="number" class="form-control text-center"></td>
                    <td><input disabled type="number" class="form-control text-center"></td>
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

export default {
  data(){
    return{
      overlay: false
    }
  },
  
  mounted(){
    
  },

  methods:{

  }
}
</script>

<style scoped>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance:textfield;
  }

  table {
    width: 100%;
  }
</style>