<template>
  <div>
    <v-overlay v-model="overlay">
      <v-progress-circular
        size="75"
        indeterminate
      ></v-progress-circular>
    </v-overlay>

    <v-tabs
      class="mt-3 mx-3"
      dense
      color="#00355e"
      background-color="transparent"
    >
      <v-tab style="font-size: 13px;">
        Gaiheki Area
      </v-tab>

      <v-tab-item style="background-color: #f1f3f4;" class="mt-3 mr-3">
        <v-row class="ml-2">

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">East Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" style="width: 85%;" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Length
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">High Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Low Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Others</td>
                        <td>
                          <v-btn color="#3ab792" style="width: 100%;" outlined>STC</v-btn>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">South Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" style="width: 85%;" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Length
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">High Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Low Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Others</td>
                        <td>
                          <v-btn color="#3ab792" style="width: 100%;" outlined>STC</v-btn>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6" class="mb-8">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">West Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" style="width: 85%;" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Length
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">High Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Low Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Others</td>
                        <td>
                          <v-btn color="#3ab792" style="width: 100%;" outlined>STC</v-btn>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6" class="mb-8">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">North Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" style="width: 85%;" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Length
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">High Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Low Waist</td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;" class="text-center">Others</td>
                        <td>
                          <v-btn color="#3ab792" style="width: 100%;" outlined>STC</v-btn>
                        </td>
                        <td><input disabled class="form-control text-center"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
          
        </v-row>
      </v-tab-item>

      <v-tab style="font-size: 13px;">
        Sash (-)
      </v-tab>

      <v-tab-item style="background-color: #f1f3f4;" class="mt-3 mr-3">
        <v-row class="ml-2">

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">East Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Width
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          W/ Amado
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Inclusion
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">South Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Width
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          W/ Amado
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Inclusion
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">West Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Width
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          W/ Amado
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Inclusion
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">North Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Width
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Height
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          W/ Amado
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Inclusion
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
          
        </v-row>
      </v-tab-item>

      <v-tab style="font-size: 13px;">
        Entrance (-)
      </v-tab>

      <v-tab-item style="background-color: #f1f3f4;" class="mt-3 mr-3">
        <v-row class="ml-2">

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">East Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Door
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Quantity
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">South Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Door
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Quantity
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">West Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Door
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Quantity
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-checkbox color="#00355e" style="width: 100px;" hide-details>
              <template v-slot:label>
                <span id="checkboxLabel">North Side</span>
              </template>
            </v-checkbox>

            <v-card elevation="1" class="mr-3 my-4">
              <v-row class="pl-5 pr-5">
                <v-col cols="12">
                  <table class="table-sm table-responsive" cellspacing="0" cellpadding="2">
                    <thead>
                      <tr>
                        <th style="font-size: 12px;" class="text-center">
                          Door
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Quantity
                        </th>
                        <th style="font-size: 12px;" class="text-center">
                          Points
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="custom-select" style="width:100px">
                            <option></option>
                          </select>
                        </td>
                        <td><input type="number" class="form-control text-center"></td>
                        <td><input disabled type="number" class="form-control text-center"></td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
          
        </v-row>
      </v-tab-item>
    </v-tabs>

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
  #checkboxLabel {
    margin-top: 10px;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }

  input[type=number] {
      -moz-appearance:textfield; /* Firefox */
  }
</style>