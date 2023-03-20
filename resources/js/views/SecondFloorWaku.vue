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
      <v-col cols="8">
        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveWakugumiData()">Save</v-btn> -->
      </v-col>

      <v-col cols="4">
        <v-card elevation="1" class="ma-5 pa-2">
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Other Points Above
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Other Points Below
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input v-model="totalPointsAbove" disabled type="number" class="form-control text-center"></td>
                <td><input v-model="totalPointsBelow" disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <v-row class="ma-2">
      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-8 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">3FL House</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  FOR 3FL HOUSE PERIMETER (245) / 240 / 260
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">2nd FL (LW)</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="lowWaist2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr v-if="shioData.ihead == 'Yes'">
                <td style="font-size: 12px;" class="text-center">2nd FL (HW)</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="highWaist2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Below Balcony</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="belowBalcony2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Between HW & BB</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="betweenHW" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">3rd FL</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="thirdFloor" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Below Balcony</td>
                <td><input onwheel="return false;" @blur="compute3FLhouse()" v-model="belowBalcony3F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Total</td>
                <td><input onwheel="return false;" disabled v-model="total3FArea" type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Sashes</span>
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Width</th>
                <th style="font-size: 12px" class="text-center">Height</th>
                <th style="font-size: 12px" class="text-center">Total</th>
                <th>
                  <v-icon small @click="addSashRow()" color="primary">mdi-plus-circle</v-icon>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in sashesData" :key="index">
                <td>
                  <input
                    onwheel="return false;"
                    @change="sashesComputation(data)"
                    v-model="data.sashWidth"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sashesComputation(data)"
                    v-model="data.sashHeight"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="sashesComputation(data)"
                    v-model="data.total"
                    type="number"
                    class="form-control text-center"
                    :disabled="true"
                  />
                </td>
                <td>
                  <v-icon tabindex="-1" small @click="deleteSashData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td
                  colspan="2"
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  Total:
                </td>
                <td
                  colspan="1"
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalSash }}
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px; width: 30%" class="text-center">
                  Fukiage (+)
                </th>
                <th colspan="2">
                  <button
                    @click="toggleFukiageDialog(), identifier.name = 'Fukiage'"
                    style="display: block; margin: auto; width: 85%"
                    class="btn btn-sm btn-block btn-outline-success mt-1 mb-1"
                    type="button"
                  >
                    Others
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in fukiageData" :key="index">
                <td class="text-center">
                  <span style="font-size: 12px"> {{ data.computation }}</span>
                </td>
                <td>
                  <input
                    :disabled="true"
                    v-model="data.total"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon small @click="viewFukiageData(data)" color="primary">mdi-eye</v-icon>
                </td>
                <td>
                  <v-icon small @click="deleteFukiageData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td
                  colspan="2"
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalFukiage }}
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px; width: 30%" class="text-center">
                  Fukisage (-)
                </th>
                <th colspan="2">
                  <button
                    @click="toggleFukisageDialog(), identifier.name = 'Fukisage'"
                    style="display: block; margin: auto; width: 85%"
                    class="btn btn-sm btn-block btn-outline-success mt-1 mb-1"
                    type="button"
                  >
                    Others
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in fukisageData" :key="index">
                <td class="text-center">
                  <span style="font-size: 12px"> {{ data.computation }}</span>
                </td>
                <td>
                  <input
                    :disabled="true"
                    v-model="data.total"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon small @click="viewFukiageData(data)" color="primary">mdi-eye</v-icon>
                </td>
                <td>
                  <v-icon small @click="deleteFukisageData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td
                  colspan="2"
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalFukisage }}
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="3">
                  <button
                    @click="toggleRoofDeductionDialog(), identifier.name = 'Roof Deduction'"
                    style="display: block; margin: auto; width: 95%"
                    class="btn btn-sm btn-block btn-outline-success mt-1 mb-1"
                    type="button"
                  >
                    Roof Deduction
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in roofDeductionData" :key="index">
                <td style="font-size: 12px; width: 35%" class="text-center">
                  <span>{{ data.computation }}</span>
                </td>
                <td>
                  <input
                    :disabled="true"
                    v-model="data.total"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon small @click="viewFukiageData(data)" color="primary">mdi-eye</v-icon>
                </td>
                <td>
                  <v-icon small @click="deleteRoofDeductionData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <td style="font-size: 12px; font-weight: bold" class="text-center">
                Total:
              </td>
              <td
                style="font-size: 12px; font-weight: bold"
                class="text-center"
                colspan="3"
              >
                {{ totalRoofDeduction }}
              </td>
            </tfoot>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Pent House</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Pent House</th>
                <th style="font-size: 12px" class="text-center">Total</th>
                <th class="text-center"><v-icon small @click="addPentHouseRow()" color="primary">mdi-plus-circle</v-icon></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, i) in pentHouseData" :key="i" class="text-field-row">
                <td><input onwheel="return false;" @change="pentHouseComputation(data)" v-model="data.value" type="number" class="form-control text-center" /></td>
                <td><input v-model="data.total" disabled type="number" class="form-control text-center" /></td>
                <td class="text-center">
                  <v-icon small @click="removePentHouseRow(i)" color="error">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
             <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  {{ totalPentHouse }}
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Parapet</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Parapet</th>
                <th style="font-size: 12px" class="text-center">Height</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumParapet()"
                    v-model="parapet1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.41</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumParapet()"
                    v-model="parapet2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.46</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumParapet()"
                    v-model="parapet3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.605</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumParapet()"
                    v-model="parapet4"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.274</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumParapet()"
                    v-model="parapet5"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.271</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalParapet }}
                </td>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  Total
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Sode Kabe</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Sode Kabe</th>
                <th style="font-size: 12px" class="text-center">Height</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumSodeKabe()"
                    v-model="sodeKabe1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">EWL</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumSodeKabe()"
                    v-model="sodeKabe2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">EWH</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalSodeKabe }}
                </td>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  Total
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Overhang</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Overhang</th>
                <th style="font-size: 12px" class="text-center">Height</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumOverhang()"
                    v-model="overHang1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.395</td>
              </tr>
              <tr>
                <td>
                  <input
                    onwheel="return false;"
                    @change="sumOverhang()"
                    v-model="overHang2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td style="font-size: 12px" class="text-center">0.64</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  {{ totalOverhang }}
                </td>
                <td
                  style="font-size: 12px; font-weight: bold"
                  class="text-center"
                >
                  Total
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Roof Garden</span>
          <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
            in Grid
          </v-chip>
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Roof Garden</th>
                <th style="font-size: 12px" class="text-center">Total</th>
                <th class="text-center">
                  <v-icon small @click="addRoofGardenRow()" color="primary">mdi-plus-circle</v-icon>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, i) in roofGardenData" :key="i" class="text-field-row">
                <td><input onwheel="return false;" @change="roofGardenComputation(data)" v-model="data.value" type="number" class="form-control text-center" /></td>
                <td><input v-model=" data.total" disabled type="number" class="form-control text-center"/></td>
                <td class="text-center">
                  <v-icon small @click="removeRoofGardenRow(i)" color="error">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  {{ totalRoofGarden }}
                </td>
              </tr>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px" class="text-center">Deduction of Roof Garden</th>
              </tr>
              <tr>
                <th style="font-size: 12px" class="text-center">Deduction</th>
                <th style="font-size: 12px" class="text-center">Quantity</th>
                <th style="font-size: 12px" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">1.82</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="roofGardenDeduction()"
                    v-model="roofGardenDeducQuantity1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="roofGardenDeducTotal1"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">1.365</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="roofGardenDeduction()"
                    v-model="roofGardenDeducQuantity2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="roofGardenDeducTotal2"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.91</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="roofGardenDeduction()"
                    v-model="roofGardenDeducQuantity3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="roofGardenDeducTotal3"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total Deduction
                </td>
                <td colspan="2">
                  <input
                    style="font-size: 12px; font-weight: bold"
                    v-model="totalGardenDeduc"
                    :disabled="true"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px" class="text-center">Design Louver (-)</th>
              </tr>
              <tr>
                <th style="font-size: 12px" class="text-center">Deduction</th>
                <th style="font-size: 12px" class="text-center">Quantity</th>
                <th style="font-size: 12px" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">1.82</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="louverDeduction()"
                    v-model="louverQuantity1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="louverTotal1"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">1.365</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="louverDeduction()"
                    v-model="louverQuantity2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="louverTotal2"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.91</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="louverDeduction()"
                    v-model="louverQuantity3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="louverTotal3"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <td style="font-size: 12px; font-weight: bold" class="text-center">
                Total Deduction
              </td>
              <td colspan="2">
                <input
                  style="font-size: 12px; font-weight: bold"
                  v-model="totalLouverDeduc"
                  :disabled="true"
                  class="form-control text-center"
                />
              </td>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <table v-if="this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'" class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="4" style="font-size: 12px" class="text-center">Hanging Wall With Bricks</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px; width: 25%;" class="text-center">Vertical</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Grids</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Quantity</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.147</td>
                <td><input onwheel="return false;" @change="sumHWVertical()" v-model="verticalHW" type="number" class="form-control text-center" /></td>
                <td><input onwheel="return false;" @change="sumHWVertical()" v-model="hwQuantity" type="number" class="form-control text-center" /></td>
                <td><input v-model="totalVerticalHW" disabled type="number" class="form-control text-center" /></td>
              </tr>

              <tr>
                <td style="font-size: 12px; width: 25%;" class="text-center">Horizontal</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Grids</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Quantity</td>
                <td style="font-size: 12px; width: 25%;" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.049</td>
                <td><input onwheel="return false;" disabled v-model="horizontalHW" type="number" class="form-control text-center" /></td>
                <td><input onwheel="return false;" disabled v-model="hwQuantity" type="number" class="form-control text-center" /></td>
                <td><input v-model="totalHorizontalHW" disabled type="number" class="form-control text-center" /></td>
              </tr>
            </tbody>
          </table>

          <table v-else class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px" class="text-center">H.W. VERTICAL FOR ROOF GARDEN</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Vertical</td>
                <td style="font-size: 12px" class="text-center">Grids</td>
                <td style="font-size: 12px" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.147</td>
                <td><input onwheel="return false;" @change="sumHWVertical()" v-model="verticalHW" type="number" class="form-control text-center" /></td>
                <td><input v-model="totalVerticalHW" disabled type="number" class="form-control text-center" /></td>
              </tr>

              <tr>
                <td style="font-size: 12px" class="text-center">Horizontal</td>
                <td style="font-size: 12px" class="text-center">Grids</td>
                <td style="font-size: 12px" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">0.049</td>
                <td><input onwheel="return false;" disabled v-model="horizontalHW" type="number" class="form-control text-center" /></td>
                <td><input v-model="totalHorizontalHW" disabled type="number" class="form-control text-center" /></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <v-row>
      <v-col>
        <v-btn
          class="mt-5 ml-5"
          color="#00355e"
          style="font-size: 12px;"
          elevation="0"
          dark
        >
          Hanging Wall (2F)
        </v-btn>
        <v-btn
          class="mt-5 ml-3"
          color="#00355e"
          style="font-size: 12px;"
          elevation="0"
          dark
          outlined
        >
          Total: {{ this.total2FHangingWall }}
        </v-btn>

        <v-tooltip top>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" ripple class="mt-5 ml-3" style="width: 10px;" dark color="#3ab792" @click="addHangingWall2F()"><v-icon small>mdi-plus</v-icon></v-btn>
          </template>
          <span>Add</span>
        </v-tooltip>

        <v-tooltip top>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" ripple class="mt-5 ml-3" dark color="primary" @click="resetHangingWall2F()"><v-icon small>mdi-reload</v-icon></v-btn>
          </template>
          <span>Clear</span>
        </v-tooltip>

      </v-col>
    </v-row>

    <v-row class="ma-2">
      <v-col cols="4" v-for="(item, index) in hangingWallArray2F" :key="index">
        <v-card elevation="1" class="pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Hanging Wall {{ item.id }}</span>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="5" style="font-size: 12px" class="text-center">
                  Hanging Wall (2F House)
                  <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
                    in Meter
                  </v-chip>
                </th>
              </tr>
              <tr>
                <th style="font-size: 12px" class="text-center">2FL House</th>
                <th style="font-size: 12px" class="text-center">2nd FL</th>
                <th style="font-size: 12px" class="text-center">Column</th>
                <th style="font-size: 12px" class="text-center">Thickness</th>
                <th style="font-size: 12px" class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px; width: 25%;" class="text-center">Outside</td>
                <td style="width: 25%;">
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="item.outside"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td></td>
              </tr>

              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.opening" :key="'O' + i">
                <td style="font-size: 12px" class="text-center">Opening</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness2F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addOpeningData2F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteOpeningData2F(index, i), hangingWallComputation2F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
              
              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.hw" :key="'H' + i">
                <td style="font-size: 12px" class="text-center">HW</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness2F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addHWData2F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteHWData2F(index, i), hangingWallComputation2F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>

              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.inside" :key="'I' + i">
                <td style="font-size: 12px" class="text-center">Inside</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation2F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness2F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addInsideData2F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteInsideData2F(index, i), hangingWallComputation2F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td colspan="3">
                  <input
                    :disabled="true"
                    v-model="item.total"
                    style="font-size: 12px; font-weight: bold"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <v-row v-show="this.shioData.kanabakari == '240'">
      <v-col>
        <v-btn
          class="mt-5 ml-5"
          color="#00355e"
          style="font-size: 12px;"
          elevation="0"
          dark
        >
          Hanging Wall (3F)
        </v-btn>
        <v-btn
          class="mt-5 ml-3"
          color="#00355e"
          style="font-size: 12px;"
          elevation="0"
          dark
          outlined
        >
          Total: {{ this.total3FHangingWall }}
        </v-btn>

        <v-tooltip top>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" ripple class="mt-5 ml-3" style="width: 10px;" dark color="#3ab792" @click="addHangingWall3F()"><v-icon small>mdi-plus</v-icon></v-btn>
          </template>
          <span>Add</span>
        </v-tooltip>

        <v-tooltip top>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" ripple class="mt-5 ml-3" dark color="primary" @click="resetHangingWall3F()"><v-icon small>mdi-reload</v-icon></v-btn>
          </template>
          <span>Clear</span>
        </v-tooltip>
      </v-col>
    </v-row>

    <v-row v-show="this.shioData.kanabakari == '240'" class="ma-2">
      <v-col cols="4" v-for="(item, index) in hangingWallArray3F" :key="index">
        <v-card elevation="1" class="pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Hanging Wall {{ item.id }}</span>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="5" style="font-size: 12px" class="text-center">
                  Hanging Wall (3F House)
                  <v-chip color="#3ab792" style="height: 20px; color: white; font-weight: normal;" class="ma-1" x-small>
                    in Meter
                  </v-chip>
                </th>
              </tr>
              <tr>
                <th style="font-size: 12px" class="text-center">3FL House</th>
                <th style="font-size: 12px" class="text-center">3rd FL</th>
                <th style="font-size: 12px" class="text-center">Column</th>
                <th style="font-size: 12px" class="text-center">Thickness</th>
                <th style="font-size: 12px" class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px; width: 25%;" class="text-center">Outside</td>
                <td style="width: 25%;">
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="item.outside"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td></td>
              </tr>

              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.opening" :key="'O' + i">
                <td style="font-size: 12px" class="text-center">Opening</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness3F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addOpeningData3F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteOpeningData3F(index, i), hangingWallComputation3F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
              
              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.hw" :key="'H' + i">
                <td style="font-size: 12px" class="text-center">HW</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness3F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addHWData3F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteHWData3F(index, i), hangingWallComputation3F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>

              <tr><td colspan="5"></td></tr>

              <tr v-for="(data, i) in item.inside" :key="'I' + i">
                <td style="font-size: 12px" class="text-center">Inside</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.length"
                    :disabled="i > 0"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="hangingWallComputation3F(item)"
                    v-model="data.column"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="restrictThickness3F(item, data)"
                    v-model="data.thickness"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon v-if="i == 0" tabindex="-1" small @click="addInsideData3F(index)" color="primary">mdi-plus-circle</v-icon>
                  <v-icon v-else tabindex="-1" small @click="deleteInsideData3F(index, i), hangingWallComputation3F(item)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td colspan="3">
                  <input
                    onwheel="return false;"
                    :disabled="true"
                    v-model="item.total"
                    style="font-size: 12px; font-weight: bold"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <!-- Dialog for Fukiage -->
    <v-dialog v-model="fukiageDialog" max-width="300px" persistent>
      <v-card class="pa-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
          >
            {{ identifier.name }}
          <v-spacer></v-spacer>

          <v-btn @click="closeFukiageDialog()" icon dense>
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-divider></v-divider>

        <div class="px-5 pb-5">
          <button
            v-show="showTarekabe2"
            @click="toggleTarekabe2Dialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Tarekabe 2
          </button>
          <button
            @click="toggleRectangleDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Rectangle
          </button>
          <button
            :hidden="identifier.name == 'Fukisage'"
            @click="toggleWholeTriangleDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Whole Triangle
          </button>
          <button
            :hidden="identifier.name == 'Fukisage'"
            @click="toggleTrapezoidDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Trapezoid
          </button>
          <button
            @click="toggleHalfTriangleDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Half Triangle
          </button>
        </div>
      </v-card>
    </v-dialog>

    <v-dialog v-model="tarekabeDialog" max-width="300px" persistent>
      <v-card class="pa-1">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
          >Tarekabe 2
        </v-toolbar>

        <v-divider></v-divider>

        <v-img
          class="pa-0"
          :src="tarekabe2"
          style="transform: scale(0.7); margin-top: -70px; margin-bottom: -50px"
        ></v-img>

        <v-text-field
          @keyup.enter="tarekabe2Computation()"
          v-model="tarekabeWidth"
          type="number"
          autofocus
          color="#00355e"
          class="inputPrice ; pl-11"
          style="font-size: 13px; width: 50%"
          dense
          outlined
          label="Width"
          hint="Input in grid"
          onwheel="return false;"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="tarekabeDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="tarekabe2Computation(), tarekabeDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="rectangleDialog" max-width="370px" persistent>
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
        >Rectangle
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 370px">
          <v-col>
            <v-img style="transform: scale(0.9)" :src="rectangle"></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              @keyup.enter="rectangleComputation()"
              v-model="rectangleHeight"
              class="inputPrice"
              type="number"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Height (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @keyup.enter="rectangleComputation()"
              v-model="rectangleWidth"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Width (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @keyup.enter="rectangleComputation()"
              v-model="rectanglePitch"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Pitch"
              hint="Input as seen on plan"
              onwheel="return false;"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="rectangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="rectangleComputation(), rectangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="wholeTriangleDialog" max-width="370px" persistent>
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
        >Whole Triangle
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 370px">
          <v-col>
            <v-img class="mt-5" :src="whole_triangle"></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              @keyup.enter="wholeTriangleComputation()"
              v-model="wholeTriangleHeight"
              class="inputPrice"
              type="number"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Height (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @keyup.enter="wholeTriangleComputation()"
              v-model="wholeTriangleWidth"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Width (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @keyup.enter="wholeTriangleComputation()"
              v-model="wholeTrianglePitch"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Pitch"
              hint="Input as seen on plan"
              onwheel="return false;"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="wholeTriangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="wholeTriangleComputation(), wholeTriangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="trapezoidDialog" max-width="370px" persistent>
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
        >Trapezoid
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 370px">
          <v-col>
            <v-img style="transform: scale(0.9)" :src="trapezoid"></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              v-model="traperzoidHeight1"
              disabled
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Height 1 (grid)"
            ></v-text-field>

            <v-text-field
              @change="trapezoidHeight1Computation()"
              v-model="traperzoidHeight2"
              class="inputPrice"
              type="number"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Height 2 (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @change="trapezoidHeight1Computation()"
              v-model="trapezoidWidth"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Width (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              @keyup.enter="trapezoidComputation()"
              v-model="trapezoidPitch"
              class="inputPrice"
              type="number"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Pitch"
              hint="Input as seen on plan"
              onwheel="return false;"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="trapezoidDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="trapezoidComputation(), trapezoidDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="halfTriangleDialog" max-width="370px" persistent>
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold"
        >Half Triangle
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 370px">
          <v-col>
            <v-img style="transform: scale(0.9)" :src="half_triangle"></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              type="number"
              class="inputPrice"
              @keyup.enter="halfTriangleComputation()"
              v-model="halfTriangleHeight"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Height (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              class="inputPrice"
              type="number"
              @keyup.enter="halfTriangleComputation()"
              v-model="halfTriangleWidth"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Width (grid)"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              class="inputPrice"
              type="number"
              @keyup.enter="halfTriangleComputation()"
              v-model="halfTrianglePitch"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Pitch"
              hint="Input as seen on plan"
              onwheel="return false;"
            ></v-text-field>

            <v-text-field
              class="inputPrice"
              type="number"
              @keyup.enter="halfTriangleComputation()"
              v-model="halfTriangleQuantity"
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Quantity"
              onwheel="return false;"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="halfTriangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="halfTriangleComputation(), halfTriangleDialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>

import Swal from "sweetalert2";
import tarekabe from "./images/tarekabe2.jpg"
import tarekabe2 from "./images/tarekabe2.jpg"
import rectangle from "./images/rectangle.jpg"
import whole_triangle from "./images/whole_triangle.jpg"
import trapezoid from "./images/trapezoid.jpg"
import half_triangle from "./images/half_triangle.jpg"
import { mapState, mapActions } from "vuex";
import { getType } from 'pdf-lib';
export default {
  data() {
    return {
      loadData: false,
      savingData: false,
      //images
      tarekabe: tarekabe,
      tarekabe2: tarekabe2,
      rectangle: rectangle,
      whole_triangle: whole_triangle,
      trapezoid: trapezoid,
      half_triangle: half_triangle,

      //dialog for fukiage, fukisage, and roof deduction
      identifier: { name: "" },
      roofDeductionData: [{ total: null, computation: null, inputs: {} }],
      fukiageData: [{ total: null, computation: null, inputs: {} }],
      fukisageData: [{ total: null, computation: null, inputs: {} }],

      //tarekabe 2
      tarekabeWidth: null,

      //half triangle
      halfTriangleHeight: null,
      halfTrianglePitch: null,
      halfTriangleWidth: null,
      halfTriangleQuantity: null,

      //trapezoid
      traperzoidHeight1: null,
      traperzoidHeight2: null,
      trapezoidWidth: null,
      trapezoidPitch: null,

      //whole triangle
      wholeTriangleHeight: null,
      wholeTriangleWidth: null,
      wholeTrianglePitch: null,
      
      //rectangle dialog textfield
      rectangleHeight: null,
      rectangleWidth: null,
      rectanglePitch: null,

      //dialog for fukiage
      halfTriangleDialog: false,
      trapezoidDialog: false,
      wholeTriangleDialog: false,
      rectangleDialog: false,
      tarekabeDialog: false,
      fukiageDialog: false,

      //parapet
      parapet1: null,
      parapet2: null,
      parapet3: null,
      parapet4: null,
      parapet5: null,
      totalParapet1: 0,
      totalParapet2: 0,
      totalParapet3: 0,
      totalParapet4: 0,
      totalParapet5: 0,

      //sodekabe
      sodeKabe1: null,
      sodeKabe2: null,
      totalSode1: 0,
      totalSode2: 0,

      //overhang
      overHang1: null,
      overHang2: null,
      totalOverhang1: 0,
      totalOverhang2: 0,

      roofGardenData: [{ value: null, total: null }],
      pentHouseData: [{ value: null, total: null }],

      //sashes
      sashesData: [
        {
          sashWidth: null,
          sashHeight: null,
          sashWidthValue: null,
          sashHeightValue: null,
          total: null,
          tempTotal: null
        }
      ],
      widthObj: {},
      heightObj: {},
      sashWidth: null,
      
      verticalHW: null,
      horizontalHW: null,
      hwQuantity: null,
      totalVerticalHW: 0,
      totalHorizontalHW: 0,

      //standard height
      lowWaistHeight2F: 0,
      highWaistHeight2F: 0,
      lowWaistHeight3F: 2.55,
      belowBalconyHeight2F: 2.2,
      betweenHWHeight: 1.5,
      belowBalconyHeight3F: 2.12,

      //3FL house
      lowWaist2F: null,
      highWaist2F: null,
      belowBalcony2F: null,
      betweenHW: null,
      thirdFloor: null,
      belowBalcony3F: null,
      total3FArea: null,

      //design louver
      louverQuantity1: null,
      louverQuantity2: null,
      louverQuantity3: null,
      louverTotal1: null,
      louverTotal2: null,
      louverTotal3: null,

      //roof garden deduction
      roofGardenDeducQuantity1: null,
      roofGardenDeducQuantity2: null,
      roofGardenDeducQuantity3: null,
      roofGardenDeducTotal1: null,
      roofGardenDeducTotal2: null,
      roofGardenDeducTotal3: null,

      totalOptionPoints: null,

      hangingWallArray2F: [
        { 
          "id": 1,
          "outside": null,
          "opening": [{ "length": null, "column": null, "thickness": null }],
          "hw": [{ "length": null, "column": null, "thickness": null }],
          "inside": [{ "length": null, "column": null, "thickness": null }],
          "total": null
        }
      ],

      hangingWallArray3F: [
        {
          "id": 1,
          "outside": null,
          "opening": [{ "length": null, "column": null, "thickness": null }],
          "hw": [{ "length": null, "column": null, "thickness": null }],
          "inside": [{ "length": null, "column": null, "thickness": null }],
          "total": null
        }
      ],
      total2FHangingWall: 0,
      total3FHangingWall: 0
    }
  },

  mounted(){
    this.disableTyping()
    if(this.shioData.kanabakari == "265"){
      this.outsideHWheight = 1.1
      this.lowWaistHeight2F = 2.82
      this.highWaistHeight2F = 2.12
    }else{
      this.outsideHWheight = 1.175
      this.lowWaistHeight2F = 2.63
      this.highWaistHeight2F = 1.93
    }
  },

  watch:{
    shioData(val){
      if(typeof(val.customerCode) !== 'undefined'){
        this.getWakugumiData()
      }
    }
  },

  created(){
    if(typeof(this.shioData.customerCode) !== 'undefined'){
      if(this.loadWaku == 0){
        this.$store.commit('changeWakuState', 1)
        this.getWakugumiData()
      }else{
        if(this.isClear == false){
          this.getStoredWakugumiData()
        }
      }
    }
  },

  methods: {

    getStoredWakugumiData(){
      this.lowWaist2F = this.housePerimeterWaku.lowWaist2F
      this.highWaist2F = this.housePerimeterWaku.highWaist2F
      this.belowBalcony2F = this.housePerimeterWaku.belowBalcony2F
      this.betweenHW = this.housePerimeterWaku.betweenHW
      this.thirdFloor = this.housePerimeterWaku.thirdFloor
      this.belowBalcony3F = this.housePerimeterWaku.belowBalcony3F
      this.total3FArea = this.housePerimeterWaku.total3FArea

      if(this.sashDataWaku.length > 0){
        this.sashesData = this.sashDataWaku
      }

      if(this.fukiageDataWaku.length > 0){
        this.fukiageData = this.fukiageDataWaku
      }

      if(this.fukisageDataWaku.length > 0){
        this.fukisageData = this.fukisageDataWaku
      }
      
      if(this.roofDeductionDataWaku.length > 0){
        this.roofDeductionData = this.roofDeductionDataWaku
      }

      if(this.hangingWall2FWaku.length > 0){
        this.hangingWallArray2F = this.hangingWall2FWaku
        this.totalHangingWallComputation2F()
      }

      if(this.hangingWall3FWaku.length > 0){
        this.hangingWallArray3F = this.hangingWall3FWaku
        this.totalHangingWallComputation3F()
      }

      this.louverQuantity1 = this.designLouverWaku.louverQuantity1
      this.louverQuantity2 = this.designLouverWaku.louverQuantity2
      this.louverQuantity3 = this.designLouverWaku.louverQuantity3
      this.louverTotal1 = this.designLouverWaku.louverTotal1
      this.louverTotal2 = this.designLouverWaku.louverTotal2
      this.louverTotal3 = this.designLouverWaku.louverTotal3

      if(this.roofGardenDataWaku.length > 0){
        this.roofGardenData = this.roofGardenDataWaku
      }

      if(this.pentHouseDataWaku.length > 0){
        this.pentHouseData = this.pentHouseDataWaku
      }

      this.roofGardenDeducQuantity1 = this.roofGardenDeducWaku.roofGardenDeducQuantity1
      this.roofGardenDeducQuantity2 = this.roofGardenDeducWaku.roofGardenDeducQuantity2
      this.roofGardenDeducQuantity3 = this.roofGardenDeducWaku.roofGardenDeducQuantity3
      this.roofGardenDeducTotal1 = this.roofGardenDeducWaku.roofGardenDeducTotal1
      this.roofGardenDeducTotal2 = this.roofGardenDeducWaku.roofGardenDeducTotal2
      this.roofGardenDeducTotal3 = this.roofGardenDeducWaku.roofGardenDeducTotal3

      this.hwQuantity = this.hwVerticalWaku.hwQuantity
      this.verticalHW = this.hwVerticalWaku.verticalHW
      this.horizontalHW = this.hwVerticalWaku.horizontalHW
      this.totalVerticalHW = this.hwVerticalWaku.totalVerticalHW
      this.totalHorizontalHW = this.hwVerticalWaku.totalHorizontalHW

      this.parapet1 = this.parapetWaku.parapet1
      this.parapet2 = this.parapetWaku.parapet2
      this.parapet3 = this.parapetWaku.parapet3
      this.parapet4 = this.parapetWaku.parapet4
      this.parapet5 = this.parapetWaku.parapet5
      this.totalParapet1 = this.parapetWaku.totalParapet1
      this.totalParapet2 = this.parapetWaku.totalParapet2
      this.totalParapet3 = this.parapetWaku.totalParapet3
      this.totalParapet4 = this.parapetWaku.totalParapet4
      this.totalParapet5 = this.parapetWaku.totalParapet5
      
      this.sodeKabe1 = this.sodekabeWaku.sodeKabe1
      this.sodeKabe2 = this.sodekabeWaku.sodeKabe2
      this.totalSode1 = this.sodekabeWaku.totalSode1
      this.totalSode2 = this.sodekabeWaku.totalSode2

      this.overHang1 = this.overhangWaku.overHang1
      this.overHang2 = this.overhangWaku.overHang2
      this.totalOverhang1 = this.overhangWaku.totalOverhang1
      this.totalOverhang2 = this.overhangWaku.totalOverhang2
    },

    storeWakugumiData(){
      this.housePerimeterWaku.lowWaist2F = this.lowWaist2F
      this.housePerimeterWaku.highWaist2F = this.highWaist2F
      this.housePerimeterWaku.belowBalcony2F = this.belowBalcony2F
      this.housePerimeterWaku.betweenHW = this.betweenHW
      this.housePerimeterWaku.thirdFloor = this.thirdFloor
      this.housePerimeterWaku.belowBalcony3F = this.belowBalcony3F
      this.housePerimeterWaku.total3FArea = this.total3FArea

      this.$store.commit('getSashDataWaku', this.sashesData)
      this.$store.commit('getFukiageDataWaku', this.fukiageData)
      this.$store.commit('getFukisageDataWaku', this.fukisageData)
      this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)

      this.designLouverWaku.louverQuantity1 = this.louverQuantity1
      this.designLouverWaku.louverQuantity2 = this.louverQuantity2
      this.designLouverWaku.louverQuantity3 = this.louverQuantity3
      this.designLouverWaku.louverTotal1 = this.louverTotal1
      this.designLouverWaku.louverTotal2 = this.louverTotal2
      this.designLouverWaku.louverTotal3 = this.louverTotal3

      this.$store.commit('getRoofGardenDataWaku', this.roofGardenData)
      this.$store.commit('getPentHouseDataWaku', this.pentHouseData)

      this.roofGardenDeducWaku.roofGardenDeducQuantity1 = this.roofGardenDeducQuantity1
      this.roofGardenDeducWaku.roofGardenDeducQuantity2 = this.roofGardenDeducQuantity2
      this.roofGardenDeducWaku.roofGardenDeducQuantity3 = this.roofGardenDeducQuantity3
      this.roofGardenDeducWaku.roofGardenDeducTotal1 = this.roofGardenDeducTotal1
      this.roofGardenDeducWaku.roofGardenDeducTotal2 = this.roofGardenDeducTotal2
      this.roofGardenDeducWaku.roofGardenDeducTotal3 = this.roofGardenDeducTotal3

      this.hwVerticalWaku.hwQuantity = this.hwQuantity
      this.hwVerticalWaku.verticalHW = this.verticalHW
      this.hwVerticalWaku.horizontalHW = this.horizontalHW
      this.hwVerticalWaku.totalVerticalHW = this.totalVerticalHW
      this.hwVerticalWaku.totalHorizontalHW = this.totalHorizontalHW

      this.parapetWaku.parapet1 = this.parapet1
      this.parapetWaku.parapet2 = this.parapet2
      this.parapetWaku.parapet3 = this.parapet3
      this.parapetWaku.parapet4 = this.parapet4
      this.parapetWaku.parapet5 = this.parapet5
      this.parapetWaku.totalParapet1 = this.totalParapet1
      this.parapetWaku.totalParapet2 = this.totalParapet2
      this.parapetWaku.totalParapet3 = this.totalParapet3
      this.parapetWaku.totalParapet4 = this.totalParapet4
      this.parapetWaku.totalParapet5 = this.totalParapet5
      
      this.sodekabeWaku.sodeKabe1 = this.sodeKabe1
      this.sodekabeWaku.sodeKabe2 = this.sodeKabe2
      this.sodekabeWaku.totalSode1 = this.totalSode1
      this.sodekabeWaku.totalSode2 = this.totalSode2

      this.overhangWaku.overHang1 = this.overHang1
      this.overhangWaku.overHang2 = this.overHang2
      this.overhangWaku.totalOverhang1 = this.totalOverhang1
      this.overhangWaku.totalOverhang2 = this.totalOverhang2
    },

    nullPitch() {
      Swal.fire({
        toast: true,
        position: "center",
        icon: "error",
        text: "Please enter field Pitch",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1500,
      });
    },

    nullHeight() {
      Swal.fire({
        toast: true,
        position: "center",
        icon: "error",
        text: "Please enter field Height",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1500,
      });
    },

    nullWidth() {
      Swal.fire({
        toast: true,
        position: "center",
        icon: "error",
        text: "Please enter field Width",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1500,
      });
    },

    ///////////////////////////////////////////////// dialogs ////////////////////////////////////////////////////////

    toggleRectangleDialog() {
      this.rectangleDialog = true;
      this.rectangleHeight = null;
      this.rectangleWidth = null;
      this.rectanglePitch = null;
    },

    toggleTarekabe2Dialog() {
      this.tarekabeDialog = true;
      this.tarekabeWidth = null;
    },

    toggleWholeTriangleDialog() {
      this.wholeTriangleDialog = true;
      this.wholeTriangleWidth = null;
      this.wholeTriangleHeight = null;
      this.wholeTrianglePitch = null;
    },

    toggleTrapezoidDialog() {
      this.trapezoidDialog = true;
      this.traperzoidHeight1 = null;
      this.traperzoidHeight2 = null;
      this.trapezoidWidth = null;
      this.trapezoidPitch = null;
    },

    toggleHalfTriangleDialog() {
      this.halfTriangleDialog = true;
      this.halfTriangleHeight = null;
      this.halfTrianglePitch = null;
      this.halfTriangleWidth = null;
      this.halfTriangleQuantity = null;
    },

    toggleRoofDeductionDialog() {
      this.identifier.name = "Roof Deduction";
      this.fukiageDialog = true;
      let arr = { total: null, computation: null };
      if (this.roofDeductionData.length == 0) {
        this.roofDeductionData.push(arr);
      }
      if (this.roofDeductionData[this.roofDeductionData.length - 1].total != null) {
        this.roofDeductionData.push(arr);
      } else {
        return false;
      }
    },

    toggleFukisageDialog() {
      this.identifier.name = "Fukisage";

      this.fukiageDialog = true;
      let arr = { total: null, computation: null };
      if (this.fukisageData.length == 0) {
        this.fukisageData.push(arr);
      }
      if (this.fukisageData[this.fukisageData.length - 1].total != null) {
        this.fukisageData.push(arr);
      } else {
        return false;
      }
    },

    toggleFukiageDialog() {
      this.identifier.name = "Fukiage";

      this.fukiageDialog = true;
      let arr = { total: null, computation: null };
      if (this.fukiageData.length == 0) {
        this.fukiageData.push(arr);
      }
      if (this.fukiageData[this.fukiageData.length - 1].total != null) {
        this.fukiageData.push(arr);
      } else {
        return false;
      }
    },

    closeFukiageDialog() {
      if (this.identifier.name == "Fukiage") {
        if (this.fukiageData.length == 1) {
          this.fukiageDialog = false;
        } else if (this.fukiageData.length > 1) {
          if (this.fukiageData[this.fukiageData.length - 1].total == null) {
            this.fukiageData.pop();
          }
        }
        this.fukiageDialog = false;
      } else if (this.identifier.name == "Roof Deduction") {
        if (this.roofDeductionData.length == 1) {
          this.fukiageDialog = false;
          return false;
        }
        else if (this.roofDeductionData.length > 1) {
          if (this.roofDeductionData[this.roofDeductionData.length - 1].total == null) {
            this.roofDeductionData.pop();
          }
          this.fukiageDialog = false;
        }
      } else if (this.identifier.name == "Fukisage") {
        if (this.fukisageData.length == 1) {
          this.fukiageDialog = false;
        }
        else if (this.fukisageData.length > 1) {
          if (this.fukisageData[this.fukisageData.length - 1].total == null) {
            this.fukisageData.pop();
            this.fukiageDialog = false;
          }
        }
      }
    },

    deleteRoofDeductionData(index) {
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
          this.roofDeductionData.splice(index, 1);
        }
      })
    },

    deleteFukiageData(index) {
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
          this.fukiageData.splice(index, 1);
        }
      })
    },

    deleteFukisageData(index) {
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
          this.fukisageData.splice(index, 1);
        }
      })
    },

    viewFukiageData(data){
      if(data.computation == "Tarekabe 2"){
        this.tarekabeWidth = data.inputs.width
        this.tarekabeDialog = true
      }else if(data.computation == "Rectangle"){
        this.rectangleHeight = data.inputs.height
        this.rectangleWidth = data.inputs.width
        this.rectanglePitch = data.inputs.pitch

        this.rectangleDialog = true
      }else if(data.computation == "Whole Triangle"){
        this.wholeTriangleHeight = data.inputs.height
        this.wholeTriangleWidth = data.inputs.width
        this.wholeTrianglePitch = data.inputs.pitch

        this.wholeTriangleDialog = true
      }else if(data.computation == "Trapezoid"){
        this.traperzoidHeight1 = data.inputs.height1
        this.traperzoidHeight2 = data.inputs.height2
        this.trapezoidWidth = data.inputs.width
        this.trapezoidPitch = data.inputs.pitch

        this.trapezoidDialog = true
      }else if(data.computation == "Half Triangle"){
        this.halfTriangleHeight = data.inputs.height
        this.halfTriangleWidth = data.inputs.width
        this.halfTrianglePitch = data.inputs.pitch
        this.halfTriangleQuantity = data.inputs.quantity

        this.halfTriangleDialog = true
      }
    },

    ///////////////////////////////////////////////// tarekabe 2 ////////////////////////////////////////////////////////

    tarekabe2Computation() {
      if (this.identifier.name == "Fukiage") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if(this.shioData.hasOwnProperty('kanabakari')){
            if (this.shioData.kanabakari == "265") {
              let outside = 1.1;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;

              this.fukiageData[this.fukiageData.length - 1].total = total;
              this.fukiageData[this.fukiageData.length - 1].computation = "Tarekabe 2";
              this.fukiageData[this.fukiageData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getFukiageDataWaku', this.fukiageData)
            }
            else if (this.shioData.kanabakari == "240") {
              let outside = 1.175;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;

              this.fukiageData[this.fukiageData.length - 1].total = total;
              this.fukiageData[this.fukiageData.length - 1].computation = "Tarekabe 2";
              this.fukiageData[this.fukiageData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getFukiageDataWaku', this.fukiageData)
            }
          }
          else{
            Swal.fire({
              toast: true,
              position: "center",
              icon: "error",
              title: "Error!",
              text: "No Kanabakari data.",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 1500,
            });
          }
        }
      } else if (this.identifier.name == "Roof Deduction") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if(this.shioData.hasOwnProperty('kanabakari')){
            if (this.shioData.kanabakari == "265") {
              let outside = 1.1;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;

              this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
              this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Tarekabe 2";
              this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
            }
            else if (this.shioData.kanabakari == "240") {
              let outside = 1.175;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;

              this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
              this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Tarekabe 2";
              this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
            }
          }
          else{
            Swal.fire({
              toast: true,
              position: "center",
              icon: "error",
              title: "Error!",
              text: "No Kanabakari data.",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 1500,
            });
          }
        }
      } else if (this.identifier.name == "Fukisage") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if(this.shioData.hasOwnProperty('kanabakari')){
            if (this.shioData.kanabakari == "265") {
              let outside = 1.1;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;

              this.fukisageData[this.fukisageData.length - 1].total = Math.trunc(total * 1000) / 1000;
              this.fukisageData[this.fukisageData.length - 1].computation = "Tarekabe 2";
              this.fukisageData[this.fukisageData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getFukisageDataWaku', this.fukisageData)
            }
            else if (this.shioData.kanabakari == "240") {
              let outside = 1.175;
              let inside = 0.268;
              let total = 0;
              let total1 = 0;
              let total2 = 0;
              total1 = (this.tarekabeWidth * 0.91) * outside;
              total2 = (this.tarekabeWidth * 0.91) * inside;
              total = total1 + total2;
              
              this.fukisageData[this.fukisageData.length - 1].total = Math.trunc(total * 1000) / 1000;
              this.fukisageData[this.fukisageData.length - 1].computation = "Tarekabe 2";
              this.fukisageData[this.fukisageData.length - 1].inputs = { width: this.tarekabeWidth };
              this.fukiageDialog = false;
              this.tarekabeDialog = false;

              this.$store.commit('getFukisageDataWaku', this.fukisageData)
            }
          }
          else{
            Swal.fire({
              toast: true,
              position: "center",
              icon: "error",
              title: "Error!",
              text: "No Kanabakari data.",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 1500,
            });
          }
        }
      }
    },

    ///////////////////////////////////////////////// half triangle ////////////////////////////////////////////////////////

    halfTriangleComputation() {
      if (this.halfTriangleHeight == null || this.halfTriangleHeight == "") {
        this.nullHeight();
      } else if (this.halfTriangleWidth == null || this.halfTriangleWidth == "") {
        this.nullWidth();
      } else if (this.halfTrianglePitch == null || this.halfTrianglePitch == "") {
        this.nullPitch();
      } else {
        if (this.identifier.name == "Fukiage") {
          let total = 0;
          // total = (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) / 2; old
          total = ((this.halfTriangleHeight * 0.91) * (this.halfTriangleWidth * 0.91) * (this.halfTrianglePitch / 10)) / 2;

          if(this.halfTriangleQuantity !== null){
            total = total * this.halfTriangleQuantity
          }else{
            total = total
          }

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Half Triangle";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height: this.halfTriangleHeight, width: this.halfTriangleWidth, pitch: this.halfTrianglePitch, quantity: this.halfTriangleQuantity };
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;

          this.$store.commit('getFukiageDataWaku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          let total = 0;
          // total = (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) / 2;
          total = ((this.halfTriangleHeight * 0.91) * (this.halfTriangleWidth * 0.91) * (this.halfTrianglePitch / 10)) / 2;

          if(this.halfTriangleQuantity !== null){
            total = total * this.halfTriangleQuantity
          }else{
            total = total
          }

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Half Triangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.halfTriangleHeight, width: this.halfTriangleWidth, pitch: this.halfTrianglePitch, quantity: this.halfTriangleQuantity };
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;

          this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          let total = 0;
          // total = (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) / 2;
          total = ((this.halfTriangleHeight * 0.91) * (this.halfTriangleWidth * 0.91) * (this.halfTrianglePitch / 10)) / 2;

          if(this.halfTriangleQuantity !== null){
            total = total * this.halfTriangleQuantity
          }else{
            total = total
          }

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Half Triangle";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height: this.halfTriangleHeight, width: this.halfTriangleWidth, pitch: this.halfTrianglePitch, quantity: this.halfTriangleQuantity };
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;

          this.$store.commit('getFukisageDataWaku', this.fukisageData)
        }
      }
    },

    ///////////////////////////////////////////////// trapezoid ////////////////////////////////////////////////////////

    trapezoidHeight1Computation() {
      if (this.traperzoidHeight2 != null && this.trapezoidWidth != null) {
        this.traperzoidHeight1 = +this.traperzoidHeight2 + +this.trapezoidWidth;
      } else {
        return false;
      }
    },

    trapezoidComputation() {
      if (this.traperzoidHeight1 == null || this.traperzoidHeight1 == "") {
        this.nullHeight();
      } else if (this.traperzoidHeight2 == null || this.traperzoidHeight2 == "") {
        this.nullHeight();
      } else if (this.trapezoidWidth == null || this.trapezoidWidth == "") {
        this.nullWidth();
      } else if (this.trapezoidPitch == null || this.trapezoidPitch == "") {
        this.nullPitch();
      } else {
        if (this.identifier.name == "Fukiage") {
          // let total = ((+this.traperzoidHeight1 + +this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2; old
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Trapezoid";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukiageDataWaku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          // let total = ((+this.traperzoidHeight1 + +this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2;
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Trapezoid";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          // let total = ((+this.traperzoidHeight1 + +this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2;
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Trapezoid";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukisageDataWaku', this.fukisageData)
        }
      }
    },

    ///////////////////////////////////////////////// whole triangle ////////////////////////////////////////////////////////

    wholeTriangleComputation() {
      if (this.wholeTriangleHeight == null || this.wholeTriangleHeight == "") {
        this.nullHeight();
      } else if (this.wholeTriangleWidth == null || this.wholeTriangleWidth == "") {
        this.nullWidth();
      } else if (this.wholeTrianglePitch == null || this.wholeTrianglePitch == "") {
        this.nullPitch();
      } else {
        if (this.identifier.name == "Fukiage") {
          // let total = (this.wholeTriangleHeight * this.wholeTriangleWidth * this.wholeTrianglePitch) / 4; old
          let total = ((this.wholeTriangleHeight * 0.91) * (this.wholeTriangleWidth * 0.91) * (this.wholeTrianglePitch / 10)) / 4;

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Whole Triangle";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height: this.wholeTriangleHeight, width: this.wholeTriangleWidth, pitch: this.wholeTrianglePitch };
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;

          this.$store.commit('getFukiageDataWaku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          // let total = (this.wholeTriangleHeight * this.wholeTriangleWidth * this.wholeTrianglePitch) / 4;
          let total = ((this.wholeTriangleHeight * 0.91) * (this.wholeTriangleWidth * 0.91) * (this.wholeTrianglePitch / 10)) / 4;

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Whole Triangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.wholeTriangleHeight, width: this.wholeTriangleWidth, pitch: this.wholeTrianglePitch };
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;

          this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          // let total = (this.wholeTriangleHeight * this.wholeTriangleWidth * this.wholeTrianglePitch) / 4;
          let total = ((this.wholeTriangleHeight * 0.91) * (this.wholeTriangleWidth * 0.91) * (this.wholeTrianglePitch / 10)) / 4;
          
          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Whole Triangle";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height: this.wholeTriangleHeight, width: this.wholeTriangleWidth, pitch: this.wholeTrianglePitch };
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;

          this.$store.commit('getFukisageDataWaku', this.fukisageData)
        }
      }
    },
    
    ///////////////////////////////////////////////// rectangle ////////////////////////////////////////////////////////

    rectangleComputation() {
      if (this.rectangleHeight == null || this.rectangleHeight == "") {
        this.nullHeight();
      } else if (this.rectangleWidth == null || this.rectangleWidth == "") {
        this.nullWidth();
      } else if (this.rectanglePitch == null || this.rectanglePitch == "") {
        this.nullPitch();
      } else {
        if (this.identifier.name == "Fukiage") {
          let total = 0;
          // total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch; old
          total = (this.rectangleHeight * 0.91) * (this.rectangleWidth * 0.91) * (this.rectanglePitch / 10)

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Rectangle";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height: this.rectangleHeight, width: this.rectangleWidth, pitch: this.rectanglePitch };
          this.rectangleDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukiageDataWaku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction"){
          let total = 0;
          // total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          total = (this.rectangleHeight * 0.91) * (this.rectangleWidth * 0.91) * (this.rectanglePitch / 10)

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Rectangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.rectangleHeight, width: this.rectangleWidth, pitch: this.rectanglePitch };
          this.rectangleDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getRoofDeductionDataWaku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          let total = 0;
          // total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          total = (this.rectangleHeight * 0.91) * (this.rectangleWidth * 0.91) * (this.rectanglePitch / 10)

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Rectangle";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height: this.rectangleHeight, width: this.rectangleWidth, pitch: this.rectanglePitch };
          this.rectangleDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukisageDataWaku', this.fukisageData)
        }
      }
    },

    ///////////////////////////////////////////////// 3FL house perimeter ////////////////////////////////////////////////////////

    compute3FLhouse(){
      const highWaistArea2F = ((parseFloat(this.highWaist2F) || 0) * 0.91) * this.highWaistHeight2F
      const lowWaistArea2F = ((parseFloat(this.lowWaist2F) || 0) * 0.91) * this.lowWaistHeight2F
      const balconyArea2F = ((parseFloat(this.belowBalcony2F) || 0) * 0.91) * this.belowBalconyHeight2F
      const betweenHWArea = ((parseFloat(this.betweenHW) || 0) * 0.91) * this.betweenHWHeight
      const area3F = ((parseFloat(this.thirdFloor) || 0) * 0.91) * this.lowWaistHeight3F
      const balconyArea3F = ((parseFloat(this.belowBalcony3F) || 0) * 0.91) * this.belowBalconyHeight3F

      const totalArea = highWaistArea2F + lowWaistArea2F + balconyArea2F + betweenHWArea + area3F + balconyArea3F
      // this.total3FArea = Math.round(totalArea * 100) / 100
      this.total3FArea = totalArea

      this.housePerimeterWaku.lowWaist2F = this.lowWaist2F
      this.housePerimeterWaku.highWaist2F = this.highWaist2F
      this.housePerimeterWaku.belowBalcony2F = this.belowBalcony2F
      this.housePerimeterWaku.betweenHW = this.betweenHW
      this.housePerimeterWaku.thirdFloor = this.thirdFloor
      this.housePerimeterWaku.belowBalcony3F = this.belowBalcony3F
      this.housePerimeterWaku.total3FArea = this.total3FArea
    },

    ///////////////////////////////////////////////// sashes ////////////////////////////////////////////////////////

    deleteSashData(index) {
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
          this.sashesData.splice(index, 1);
        }
      })
    },

    addSashRow() {
      let row = {
        sashWidth: null,
        sashHeight: null,
        sashWidthValue: null,
        sashHeightValue: null,
        total: null,
      };

      if (this.sashesData.length == 0) {
        this.sashesData.push(row);
      } else if (this.sashesData[this.sashesData.length - 1].total != null) {
        this.sashesData.push(row);
      }
    },

    sashesComputation(data) {
      let arrSashWidthValue = this.$store.getters.getSashSize.filter((r) => {
        return r.width == data.sashWidth;
      });

      let arrSashHeightValue = this.$store.getters.getSashSize.filter((r) => {
        return r.height == data.sashHeight;
      });

      if (arrSashWidthValue.length > 0) {
        this.widthObj = Object.assign({}, arrSashWidthValue[0]);
        data.sashWidthValue = this.widthObj.width_value;
      } else {
        data.sashWidthValue = 0;
      }

      if (arrSashHeightValue.length > 0) {
        this.heightObj = Object.assign({}, arrSashHeightValue[0]);
        data.sashHeightValue = this.heightObj.height_value;
      } else if (!arrSashHeightValue.length) {
        data.sashHeightValue = 0;
      }

      if (data.sashWidthValue == 0) {
        Swal.fire({
          toast: true,
          position: 'center',
          icon: 'error',
          title: 'Invalid Sash Width',
          text: 'Please input correct value.',
          showConfirmButton: false,
          timer: 2800
        });

        data.sashWidth = null;
        data.total = 0;
      } else if (data.sashHeight != null) {
        if (data.sashHeightValue == 0) {
          Swal.fire({
            toast: true,
            position: 'center',
            icon: 'error',
            title: 'Invalid Sash Height',
            text: 'Please input correct value.',
            showConfirmButton: false,
            timer: 2800
          });

          data.sashHeight = null;
          data.total = 0;
        }
      }

      data.total = (data.sashHeightValue / 1000) * (data.sashWidthValue / 1000);
      data.tempTotal = Math.trunc(data.total * 1000) / 1000;

      this.$store.commit('getSashDataWaku', this.sashesData)

      // if (this.sashesData[this.sashesData.length - 1].total != 0 && this.sashesData[this.sashesData.length - 1].total != null) {
      if (this.sashesData[this.sashesData.length - 1].sashWidth !== null) {
        let row = {
          sashWidth: null,
          sashHeight: null,
          sashWidthValue: null,
          sashHeightValue: null,
          tempTotal: null,
          total: null,
        };

        this.sashesData.push(row);
      } else {
        return false;
      }
    },

    ///////////////////////////////////////////////// roof garden ////////////////////////////////////////////////////////

    addRoofGardenRow(){
      if (this.roofGardenData.length == 0){
        let row = { value: null, total: null }
        this.roofGardenData.push(row)
      }
      else if (this.roofGardenData[this.roofGardenData.length -1].total != 0){
        let row = { value: null, total: null }
        this.roofGardenData.push(row)
      }
    },

    removeRoofGardenRow(index) {
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
          this.roofGardenData.splice(index, 1)
        }
      })
    },

    ///////////////////////////////////////////////// penthouse ////////////////////////////////////////////////////////

    addPentHouseRow() {
      if (this.pentHouseData.length == 0){
        let row = { value: null, total: null }
        this.pentHouseData.push(row)
      }
      else if (this.pentHouseData[this.pentHouseData.length -1].total != 0){
        let row = { value: null, total: null }
        this.pentHouseData.push(row)
      }
    },

    removePentHouseRow(index) {
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
          this.pentHouseData.splice(index, 1)
        }
      })
    },

    ///////////////////////////////////////////////// hw vertical for roof garden ////////////////////////////////////////////////////////

    sumHWVertical(){
      this.horizontalHW = this.verticalHW
      if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
        this.totalVerticalHW = ((this.verticalHW * 0.91) * 0.147 * this.hwQuantity)
        this.totalHorizontalHW = ((this.horizontalHW * 0.91) * 0.049 * this.hwQuantity)
      }else{
        this.totalVerticalHW = ((this.verticalHW * 0.91) * 0.147)
        this.totalHorizontalHW = ((this.horizontalHW * 0.91) * 0.049)
      }
      

      this.hwVerticalWaku.verticalHW = this.verticalHW
      this.hwVerticalWaku.horizontalHW = this.horizontalHW
      this.hwVerticalWaku.hwQuantity = this.hwQuantity
      this.hwVerticalWaku.totalVerticalHW = this.totalVerticalHW
      this.hwVerticalWaku.totalHorizontalHW = this.totalHorizontalHW
    },

    ///////////////////////////////////////////////// parapet + sodekabe + overhang ////////////////////////////////////////////////////////

    sumParapet(){
      this.totalParapet1 = (this.parapet1 * 0.91) * 0.41
      this.totalParapet2 = (this.parapet2 * 0.91) * 0.46
      this.totalParapet3 = (this.parapet3 * 0.91) * 0.605
      this.totalParapet4 = (this.parapet4 * 0.91) * 0.274
      this.totalParapet5 = (this.parapet5 * 0.91) * 0.271

      this.parapetWaku.parapet1 = this.parapet1
      this.parapetWaku.parapet2 = this.parapet2
      this.parapetWaku.parapet3 = this.parapet3
      this.parapetWaku.parapet4 = this.parapet4
      this.parapetWaku.parapet5 = this.parapet5
      this.parapetWaku.totalParapet1 = this.totalParapet1
      this.parapetWaku.totalParapet2 = this.totalParapet2
      this.parapetWaku.totalParapet3 = this.totalParapet3
      this.parapetWaku.totalParapet4 = this.totalParapet4
      this.parapetWaku.totalParapet5 = this.totalParapet5
    },

    sumSodeKabe(){
      this.totalSode1 = (this.sodeKabe1 * 0.91) * 1.925
      this.totalSode2 = (this.sodeKabe2 * 0.91) * 2.121

      this.sodekabeWaku.sodeKabe1 = this.sodeKabe1
      this.sodekabeWaku.sodeKabe2 = this.sodeKabe2
      this.sodekabeWaku.totalSode1 = this.totalSode1
      this.sodekabeWaku.totalSode2 = this.totalSode2
    },

    sumOverhang(){
      this.totalOverhang1 = (this.overHang1 * 0.91) * 0.395
      this.totalOverhang2 = (this.overHang2 * 0.91) * 0.64

      this.overhangWaku.overHang1 = this.overHang1
      this.overhangWaku.overHang2 = this.overHang2
      this.overhangWaku.totalOverhang1 = this.totalOverhang1
      this.overhangWaku.totalOverhang2 = this.totalOverhang2
    },

    ///////////////////////////////////////////////// design louver ////////////////////////////////////////////////////////

    louverDeduction() {
      let height = 1.8515;
      if (this.louverQuantity1 != null) {
        let width = 1.591;
        this.louverTotal1 = this.louverQuantity1 * height * width;
      }
      if (this.louverQuantity2 != null) {
        let width = 1.136;
        this.louverTotal2 = this.louverQuantity2 * height * width;
      }
      if (this.louverQuantity3 != null) {
        let width = 0.681;
        this.louverTotal3 = this.louverQuantity3 * height * width;
      }

      this.designLouverWaku.louverQuantity1 = this.louverQuantity1
      this.designLouverWaku.louverQuantity2 = this.louverQuantity2
      this.designLouverWaku.louverQuantity3 = this.louverQuantity3
      this.designLouverWaku.louverTotal1 = this.louverTotal1
      this.designLouverWaku.louverTotal2 = this.louverTotal2
      this.designLouverWaku.louverTotal3 = this.louverTotal3
    },

    ///////////////////////////////////////////////// roof garden deduction ////////////////////////////////////////////////////////

    roofGardenDeduction() {
      let height = 0.943;
      if (this.roofGardenDeducQuantity1 != null) {
        let width = 1.591;
        this.roofGardenDeducTotal1 = (
          this.roofGardenDeducQuantity1 *
          width *
          height
        );
      }

      if (this.roofGardenDeducQuantity2 != null) {
        let width = 1.136;
        this.roofGardenDeducTotal2 = (
          this.roofGardenDeducQuantity2 *
          width *
          height
        );
      }
      
      if (this.roofGardenDeducQuantity3 != null) {
        let width = 0.681;
        this.roofGardenDeducTotal3 = (
          this.roofGardenDeducQuantity3 *
          width *
          height
        );
      }

      this.roofGardenDeducWaku.roofGardenDeducQuantity1 = this.roofGardenDeducQuantity1
      this.roofGardenDeducWaku.roofGardenDeducQuantity2 = this.roofGardenDeducQuantity2
      this.roofGardenDeducWaku.roofGardenDeducQuantity3 = this.roofGardenDeducQuantity3
      this.roofGardenDeducWaku.roofGardenDeducTotal1 = this.roofGardenDeducTotal1
      this.roofGardenDeducWaku.roofGardenDeducTotal2 = this.roofGardenDeducTotal2
      this.roofGardenDeducWaku.roofGardenDeducTotal3 = this.roofGardenDeducTotal3
    },

    ///////////////////////////////////////////////// roof garden + penthouse ////////////////////////////////////////////////////////

    roofGardenComputation(data) {
      if (data.value != null) {
        // data.total = ((data.value * 0.91) * 2.477) * 2; old, changed 11162022
        data.total = ((data.value * 0.91) * 2.477);
        if (data.total != null) {
          let row = {
            value: null,
            total: null,
          };
          this.roofGardenData.push(row);
        }

        this.$store.commit('getRoofGardenDataWaku', this.roofGardenData)
      }
    },

    pentHouseComputation(data) {
      if (data.value != null) {
        data.total = (data.value * 0.91) * 2.731;
        if (data.total != null) {
          let row = {
            value: null,
            total: null,
          };
          this.pentHouseData.push(row);
        }

        this.$store.commit('getPentHouseDataWaku', this.pentHouseData)
      }
    },

    ///////////////////////////////////////////////// hanging wall 2F ////////////////////////////////////////////////////////

    resetHangingWall2F(){
      Swal.fire({
        icon: "question",
        text: "Do you want to clear all Hanging Wall 2F?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: "Delete",
        denyButtonText: "Cancel"
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.hangingWallArray2F = [
            { 
              "id": 1,
              "outside": null,
              "opening": [{ "length": null, "column": null, "thickness": null }],
              "hw": [{ "length": null, "column": null, "thickness": null }],
              "inside": [{ "length": null, "column": null, "thickness": null }],
              "total": null
            }
          ]

          this.total2FHangingWall = 0
        }
      })
    },

    addHangingWall2F(){
      let data = { 
        "id": this.hangingWallArray2F.length + 1,
        "outside": null,
        "opening": [{ "length": null, "column": null, "thickness": null }],
        "hw": [{ "length": null, "column": null, "thickness": null }],
        "inside": [{ "length": null, "column": null, "thickness": null }],
        "total": null
      }
      this.hangingWallArray2F.push(data)
      this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
    },

    addOpeningData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].opening.push(data)
      this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
    },

    deleteOpeningData2F(index, index_o){
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
          this.hangingWallArray2F[index].opening.splice(index_o, 1)
          this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
        }
      })
    },

    addHWData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].hw.push(data)
      this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
    },

    deleteHWData2F(index, index_o){
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
          this.hangingWallArray2F[index].hw.splice(index_o, 1)
          this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
        }
      })
    },

    addInsideData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].inside.push(data)
      this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
    },

    deleteInsideData2F(index, index_o){
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
          this.hangingWallArray2F[index].inside.splice(index_o, 1)
          this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
        }
      })
    },

    hangingWallComputation2F(item){
      item.total = null //reset item.total every input

      //outside
      if(item.outside !== null && item.outside !== ""){
        if(this.shioData.kanabakari == '265'){
          item.total = item.outside * 2.82
        }else if(this.shioData.kanabakari == '240'){
          item.total = item.outside * 2.63
        }
      }

      //opening
      if(item.opening[0].length !== null && item.opening[0].length !== ""){
        let length = parseFloat(item.opening[0].length)
        let total = 0

        item.opening.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        item.total = item.total - ((length - total) * 2.3)
      }

      //hw
      if(item.hw[0].length !== null  && item.hw[0].length !== ""){
        let length = parseFloat(item.hw[0].length)
        let total = 0

        item.hw.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        item.total = item.total + ((length - total) * 0.268)
      }

      //inside
      if(item.inside[0].length !== null  && item.inside[0].length !== ""){
        let length = parseFloat(item.inside[0].length)
        let total = 0

        item.inside.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        if(this.shioData.kanabakari == '265'){
          item.total = item.total + ((length + total) * 2.73)
        }else if(this.shioData.kanabakari == '240'){
          item.total = item.total + ((length + total) * 2.385)
        }
      }

      if(item.total !== null){
        item.total = parseFloat(item.total)
      }

      this.totalHangingWallComputation2F()
    },

    totalHangingWallComputation2F(){
      let total = 0;
      this.hangingWallArray2F.forEach(rec => {
        total += rec.total;
      })
      
      this.total2FHangingWall = Math.trunc(total * 1000) / 1000
      this.$store.commit('getHangingWall2FWaku', this.hangingWallArray2F)
    },

    restrictThickness2F(item, data){
      if(data.thickness == null || data.thickness == "" || data.thickness == 0.168){
        this.hangingWallComputation2F(item)
      }else if(data.thickness > 0.168 || data.thickness < 0.168){
        Swal.fire({
          toast: true,
          position: "center",
          icon: "error",
          title: "Invalid Value",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        });
        
        data.thickness = null
        this.hangingWallComputation2F(item)
      }
    },

    ///////////////////////////////////////////////// hanging wall 3F ////////////////////////////////////////////////////////

    resetHangingWall3F(){
      Swal.fire({
        icon: "question",
        text: "Do you want to clear all Hanging Wall 3F?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: "Delete",
        denyButtonText: "Cancel"
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.hangingWallArray3F = [
            {
              "id": 1,
              "outside": null,
              "opening": [{ "length": null, "column": null, "thickness": null }],
              "hw": [{ "length": null, "column": null, "thickness": null }],
              "inside": [{ "length": null, "column": null, "thickness": null }],
              "total": null
            }
          ]

          this.total3FHangingWall = 0
        }
      })
    },

    addHangingWall3F(){
      let data = {
        "id": this.hangingWallArray3F.length + 1,
        "outside": null,
        "opening": [{ "length": null, "column": null, "thickness": null }],
        "hw": [{ "length": null, "column": null, "thickness": null }],
        "inside": [{ "length": null, "column": null, "thickness": null }],
        "total": null
      }
      this.hangingWallArray3F.push(data)
      this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
    },

    addOpeningData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].opening.push(data)
      this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
    },

    deleteOpeningData3F(index, index_o){
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
          this.hangingWallArray3F[index].opening.splice(index_o, 1)
          this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
        }
      })
    },

    addHWData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].hw.push(data)
      this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
    },

    deleteHWData3F(index, index_o){
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
          this.hangingWallArray3F[index].hw.splice(index_o, 1)
          this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
        }
      })
    },

    addInsideData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].inside.push(data)
      this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
    },

    deleteInsideData3F(index, index_o){
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
          this.hangingWallArray3F[index].inside.splice(index_o, 1)
          this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
        }
      })
    },

    hangingWallComputation3F(item){
      item.total = null //reset item.total every input

      if(item.outside !== null && item.outside !== ""){
        if(this.shioData.kanabakari == '265'){
          item.total = item.outside * 2.82
        }else if(this.shioData.kanabakari == '240'){
          item.total = item.outside * 2.55
        }
      }

      if(item.opening[0].length !== null && item.opening[0].length !== ""){
        let length = parseFloat(item.opening[0].length)
        let total = 0

        item.opening.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        item.total = item.total - ((length - total) * 2.3)
      }

      if(item.hw[0].length !== null && item.hw[0].length !== ""){
        let length = parseFloat(item.hw[0].length)
        let total = 0

        item.hw.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        item.total = item.total + ((length - total) * 0.268)
      }

      if(item.inside[0].length !== null && item.inside[0].length !== ""){
        let length = parseFloat(item.inside[0].length)
        let total = 0

        item.inside.forEach(data => {
          // if(data.column !== null && data.column !== ""){
            if(data.thickness == null || data.thickness == ""){
              data.thickness = null
            }
            total = total + (parseFloat(data.column || 0) + parseFloat(data.thickness || 0))
          // }
        })

        if(this.shioData.kanabakari == '265'){
          item.total = item.total + ((length + total) * 2.73)
        }else if(this.shioData.kanabakari == '240'){
          item.total = item.total + ((length + total) * 2.385)
        }
      }

      if(item.total !== null){
        item.total = parseFloat(item.total)
      }
        
      this.totalHangingWallComputation3F()
    },

    totalHangingWallComputation3F(){
      let total = 0;
      this.hangingWallArray3F.forEach(rec => {
        total += rec.total;
      })
      
      this.total3FHangingWall = Math.trunc(total * 1000) / 1000
      this.$store.commit('getHangingWall3FWaku', this.hangingWallArray3F)
    },

    restrictThickness3F(item, data){
      if(data.thickness == null || data.thickness == "" || data.thickness == 0.168){
        this.hangingWallComputation3F(item)
      }else if(data.thickness > 0.168 || data.thickness < 0.168){
        Swal.fire({
          toast: true,
          position: "center",
          icon: "error",
          title: "Invalid Value",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        });
        
        data.thickness = null
        this.hangingWallComputation3F(item)
      }
    },

    ///////////////////////////////////////////////// SAVING ////////////////////////////////////////////////////////

    saveWakugumiData(){
      this.savingData = true
      let perimeter3F = {
        low_waist: this.lowWaist2F,
        high_waist: this.highWaist2F,
        below_balcony: this.belowBalcony2F,
        between_hw: this.betweenHW,
        floor_3: this.thirdFloor,
        below_balcony_3f: this.belowBalcony3F,
        total_points: this.total3FArea
      }

      let designLouver = {
        deduction_182: this.louverQuantity1,
        points_182: this.louverTotal1,
        deduction_1365: this.louverQuantity2,
        points_1365: this.louverTotal2,
        deduction_091: this.louverQuantity3,
        points_091: this.louverTotal3,
        total_points: this.totalLouverDeduc
      }

      let roofGardenDeduction = {
        deduction_182: this.roofGardenDeducQuantity1,
        points_182: this.roofGardenDeducTotal1,
        deduction_1365: this.roofGardenDeducQuantity2,
        points_1365: this.roofGardenDeducTotal2,
        deduction_091: this.roofGardenDeducQuantity3,
        points_091: this.roofGardenDeducTotal3,
        total_points: this.totalGardenDeduc
      }

      let hwRoofGarden = {
        quantity: this.hwQuantity,
        vertical: this.verticalHW,
        vertical_points: this.totalVerticalHW,
        horizontal: this.horizontalHW,
        horizontal_points: this.totalHorizontalHW
      }

      let parapet = {
        parapet_041: this.parapet1,
        parapet_046: this.parapet2,
        parapet_0605: this.parapet3,
        parapet_0274: this.parapet4,
        parapet_0271: this.parapet5,
        total_points: this.totalParapet
      }

      let sodekabe = {
        ewl: this.sodeKabe1,
        ewh: this.sodeKabe2,
        total_points: this.totalSodeKabe
      }

      let overhang = {
        overhang_0395: this.overHang1,
        overhang_064: this.overHang2,
        total_points: this.totalOverhang
      }

      let sashArr = this.sashesData
      const empty = sashArr.filter(r => r.total == null)
      if(empty.length > 0){
        const id = sashArr.findIndex(r => r.total == null)
        sashArr.splice(id, 1);
      }

      let roofGardenArr = this.roofGardenData
      const empty1 = roofGardenArr.filter(r => r.value == null)
      if(empty1.length > 0){0  
        const id1 = roofGardenArr.findIndex(r => r.value == null)
        roofGardenArr.splice(id1, 1);
      }

      let pentArr = this.pentHouseData
      const empty2 = pentArr.filter(r => r.value == null)
      if(empty2.length > 0){
        const id2 = pentArr.findIndex(r => r.value == null)
        pentArr.splice(id2, 1);
      }

      if(typeof(this.shioData.customerCode) !== 'undefined'){
        axios.post('api/saveWakugumiData', {
          customer_code: this.shioData.customerCode,
          plan_no: this.shioData.planNo,
          perimeter3F,
          sashArr,
          fukiageArr: this.fukiageData,
          fukisageArr: this.fukisageData,
          roofDeductionArr: this.roofDeductionData,
          designLouver,
          hangingWall2F: this.hangingWallArray2F,
          hangingWall3F: this.hangingWallArray3F,
          roofGardenArr,
          pentArr,
          roofGardenDeduction,
          hwRoofGarden,
          parapet,
          sodekabe,
          overhang,
          totalOptionPoints: this.totalOptionPoints
        }).then(res => {
          this.savingData = false

          Swal.fire({
            position: 'center',
            icon: 'success',
            iconColor: '#3ab792',
            title: 'Success!',
            text: '2F Wakugumi has been saved.',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2500
          })
        })
      }
    },

    ///////////////////////////////////////////////// FETCHING ////////////////////////////////////////////////////////

    getWakugumiData(){
      this.loadData = true
      axios.post('api/getWakugumiData', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo,
      }).then(async res => {
        
        if(res.data.perimeter_3f.length > 0){
          this.lowWaist2F = res.data.perimeter_3f[0].low_waist
          this.highWaist2F = res.data.perimeter_3f[0].high_waist
          this.belowBalcony2F = res.data.perimeter_3f[0].below_balcony_2f
          this.betweenHW = res.data.perimeter_3f[0].between_hw
          this.thirdFloor = res.data.perimeter_3f[0].floor_3
          this.belowBalcony3F = res.data.perimeter_3f[0].below_balcony_3f
          this.total3FArea = res.data.perimeter_3f[0].total_points
        }

        if(res.data.sash.length > 0){
          this.sashesData = res.data.sash
        }
        if(res.data.fukiage.length > 0){
          this.fukiageData = res.data.fukiage
        }
        if(res.data.fukisage.length > 0){
          this.fukisageData = res.data.fukisage
        }
        if(res.data.roof_deduction.length > 0){
          this.roofDeductionData = res.data.roof_deduction
        }

        if(res.data.hw_2f.length > 0){
          this.hangingWallArray2F = res.data.hw_2f
          this.totalHangingWallComputation2F()
        }

        if(res.data.hw_3f.length > 0){
          this.hangingWallArray3F = res.data.hw_3f
          this.totalHangingWallComputation3F()
        }

        if(res.data.design_louver.length > 0){
          this.louverQuantity1 = res.data.design_louver[0].deduction_182
          this.louverTotal1 = res.data.design_louver[0].points_182
          this.louverQuantity2 = res.data.design_louver[0].deduction_1365
          this.louverTotal2 = res.data.design_louver[0].points_1365
          this.louverQuantity3 = res.data.design_louver[0].deduction_091
          this.louverTotal3 = res.data.design_louver[0].points_091
        }

        if(res.data.roof_garden.length > 0){
          this.roofGardenData = res.data.roof_garden
        }
        if(res.data.pent_house.length > 0){
          this.pentHouseData = res.data.pent_house
        }

        if(res.data.roof_garden_deduction.length > 0){
          this.roofGardenDeducQuantity1 = res.data.roof_garden_deduction[0].deduction_182
          this.roofGardenDeducTotal1 = res.data.roof_garden_deduction[0].points_182
          this.roofGardenDeducQuantity2 = res.data.roof_garden_deduction[0].deduction_1365
          this.roofGardenDeducTotal2 = res.data.roof_garden_deduction[0].points_1365
          this.roofGardenDeducQuantity3 = res.data.roof_garden_deduction[0].deduction_091
          this.roofGardenDeducTotal3 = res.data.roof_garden_deduction[0].points_091
        }

        if(res.data.hw_roof_garden.length > 0){
          this.hwQuantity = res.data.hw_roof_garden[0].quantity
          this.verticalHW = res.data.hw_roof_garden[0].vertical
          this.totalVerticalHW = res.data.hw_roof_garden[0].vertical_points
          this.horizontalHW = res.data.hw_roof_garden[0].horizontal
          this.totalHorizontalHW = res.data.hw_roof_garden[0].horizontal_points
        }

        if(res.data.parapet.length > 0){
          this.parapet1 = res.data.parapet[0].parapet_041
          this.totalParapet1 = ((res.data.parapet[0].parapet_041 * 0.91) * 0.41)
          this.parapet2 = res.data.parapet[0].parapet_046
          this.totalParapet2 = ((res.data.parapet[0].parapet_046 * 0.91) * 0.46)
          this.parapet3 = res.data.parapet[0].parapet_0605
          this.totalParapet3 = ((res.data.parapet[0].parapet_0605 * 0.91) * 0.605)
          this.parapet4 = res.data.parapet[0].parapet_0274
          this.totalParapet4 = ((res.data.parapet[0].parapet_0274 * 0.91) * 0.274)
          this.parapet5 = res.data.parapet[0].parapet_0271
          this.totalParapet5 = ((res.data.parapet[0].parapet_0271 * 0.91) * 0.271)
        }

        if(res.data.sodekabe.length > 0){
          this.sodeKabe1 = res.data.sodekabe[0].ewl
          this.totalSode1 = ((res.data.sodekabe[0].ewl * 0.91) * 1.925)
          this.sodeKabe2 = res.data.sodekabe[0].ewh
          this.totalSode2 = ((res.data.sodekabe[0].ewh * 0.91) * 2.121)
        }

        if(res.data.overhang.length > 0){
          this.overHang1 = res.data.overhang[0].overhang_0395
          this.totalOverhang1 = ((res.data.overhang[0].overhang_0395 * 0.91) * 0.395)
          this.overHang2 = res.data.overhang[0].overhang_064
          this.totalOverhang2 = ((res.data.overhang[0].overhang_064 * 0.91) * 0.64)
        }

        this.loadData = false
        await this.storeWakugumiData()
      })
    },

    disableTyping(){
      $('input:disabled').keypress(function(e){
        e.preventDefault();
        return false;
      });
    },
  },

  computed:{
    ...mapState(
      [
        'shioData',
        'housePerimeterWaku',
        'sashDataWaku',
        'fukiageDataWaku',
        'fukisageDataWaku',
        'roofDeductionDataWaku',
        'designLouverWaku',
        'roofGardenDataWaku',
        'hangingWall2FWaku',
        'hangingWall3FWaku',
        'pentHouseDataWaku',
        'roofGardenDeducWaku',
        'hwVerticalWaku',
        'parapetWaku',
        'sodekabeWaku',
        'overhangWaku',
        'loadWaku',
        'isClear'
      ]
    ),

    showTarekabe2() {
      if (this.identifier.name == "Roof Deduction" || this.identifier.name == "Fukisage") {
        return false;
      } else {
        if(this.shioData.tileKind == 'TF' || this.shioData.tileKind == 'TD'){
          return false;
        }else{
          return true;
        }
      }
    },

    totalRoofDeduction() {
      let total = 0;
      this.roofDeductionData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalFukisage() {
      let total = 0;
      this.fukisageData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalFukiage() {
      let total = 0;
      this.fukiageData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalSash() {
      let total = 0;
      this.sashesData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalLouverDeduc() {
      let total = null;
      total = +this.louverTotal1 + +this.louverTotal2 + +this.louverTotal3;
      return Math.trunc(total * 1000) / 1000;
    },

    totalRoofGarden() {
      let total = 0;
      this.roofGardenData.filter((rec) => {
        total += rec.total;
      });

      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalPentHouse() {
      let total = 0;
      this.pentHouseData.filter((rec) => {
        total += rec.total;
      });

      return total;
    },

    totalGardenDeduc() {
      let total = null;
      total =
        +this.roofGardenDeducTotal1 +
        +this.roofGardenDeducTotal2 +
        +this.roofGardenDeducTotal3;
      return Math.trunc(total * 1000) / 1000;
    },

    totalParapet(){
      let total = 0;
      total = this.totalParapet1 + this.totalParapet2 + this.totalParapet3 + this.totalParapet4 + this.totalParapet5
      // return (total = Math.trunc(total * 1000) / 1000);
      return total;
    },

    totalSodeKabe(){
      let total = 0;
      total = this.totalSode1 + this.totalSode2
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalOverhang(){
      let total = 0;
      total = this.totalOverhang1 + this.totalOverhang2
      return (total = Math.trunc(total * 1000) / 1000);
    },

    fukiageDataTotal(){
      let total = 0;
      this.fukiageData.filter(rec => {
        total += rec.total
      })
      return total
    },

    fukisageDataTotal(){
      let total = 0;
      this.fukisageData.filter(rec => {
        total += rec.total
      })
      return total
    },

    roofDeductionTotal() {
      let total = 0;
      this.roofDeductionData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },
        
    totalRoof(){
      let total = 0
      this.roofGardenData.filter(rec=>{
        total = + rec.totalRoof +               
          +this.total1
          +this.total2
          +this.total3
          +this.total4
          +this.totalSode1
          +this.totalSode2
          +this.totalHang1
          +this.totalHang2
          +this.totalSash
          + parseFloat(this.totalHorizontalHW)
          + parseFloat(this.totalVerticalHW)
          +this.fukiageDataTotal
          +this.total3FArea
          -this.roofDeductionTotal
          -this.fukisageDataTotal
          -this.totalLouverDeduc
          -this.totalGardenDeduc
      })
      return total
    },

    totalPointsBelow() {
      let total = 0;
      total =
        this.total3FArea -
        this.totalSash +
        this.totalFukiage -
        this.totalFukisage -
        this.totalRoofDeduction -
        this.totalLouverDeduc +
        this.totalRoofGarden +
        this.total2FHangingWall +
        this.total3FHangingWall +
        this.totalPentHouse -
        this.totalGardenDeduc +
        this.totalVerticalHW +
        this.totalHorizontalHW +
        this.totalParapet +
        this.totalSodeKabe +
        this.totalOverhang

        this.totalOptionPoints = Math.floor(total * 1000) / 1000
        this.$store.commit('get2FWakuPoints', this.totalOptionPoints)

        // return Math.floor(total * 1000) / 1000;
        return total;
    },

    totalPointsAbove() {
      let total =
        this.total3FArea -
        this.totalSash +
        this.totalFukiage -
        this.totalFukisage -
        this.totalRoofDeduction -
        this.totalLouverDeduc +
        this.totalRoofGarden +
        this.total2FHangingWall +
        this.total3FHangingWall +
        this.totalPentHouse -
        this.totalGardenDeduc +
        this.totalVerticalHW +
        this.totalHorizontalHW +
        this.totalParapet +
        this.totalSodeKabe +
        this.totalOverhang
        
      return Math.round(total * 100) / 100;
    }
  }
}
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

  input {
    font-size: 12px ;
  }

  table {
    width: 100%;
  }
</style>