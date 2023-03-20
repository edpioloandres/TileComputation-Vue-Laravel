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
        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveJikugumiData()">Save</v-btn> -->
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
                <td><input v-model="totalAllPointsAbove" disabled type="number" class="form-control text-center"></td>
                <td><input v-model="totalAllPointsBelow" disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <v-row class="ma-2">
      <v-col cols="3">
        
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Tarekabe</span>
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  Partial Curved Tarekabe
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Outside (D2)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="partialCurvedComputation()"
                    v-model="outsideD2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Inside (D1)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="partialCurvedComputation()"
                    v-model="insideD1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td>
                  <input
                    v-model="totalPartialCurved"
                    class="form-control text-center"
                    style="font-size: 12px; font-weight: bold"
                    :disabled="true"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Tarekabe</span>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  Whole Curved Tarekabe
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Height of Tarekabe</td>
                <td>
                  <input
                    @change="wholeCurvedComputation()"
                    id="heightOfTarekabe"
                    v-model="heightOfTarekabe"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Length of Tarekabe</td>
                <td>
                  <input
                    @change="wholeCurvedComputation()"
                    id="lengthOfTarekabe"
                    v-model="lengthOfTarekabe"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">
                  Outer Part of Diameter
                </td>
                <td>
                  <input
                    @change="wholeCurvedComputation()"
                    id="outerPartOfDiameter"
                    v-model="outerPartOfDiameter"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total
                </td>
                <td>
                  <input
                    v-model="totalWholeCurvedTarekabe"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Sashes</span>
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Width</th>
                <th style="font-size: 12px" class="text-center">Height</th>
                <th style="font-size: 12px" class="text-center">Total</th>
                <th>
                  <v-icon small @click="addSashData()" color="primary">mdi-plus-circle</v-icon>
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
        
        <v-card v-show="this.shioData.kanabakari == '265'" elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">House Perimeter</span>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  2FL House Perimeter (265)
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">2nd FL (LW)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="secondFloorHousePerimeterComputation()"
                    type="number"
                    v-model="secondFloorLowWaist265"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">2nd FL (HW)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="secondFloorHousePerimeterComputation()"
                    type="number"
                    v-model="secondFloorHighWaist265"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Balcony</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="secondFloorHousePerimeterComputation()"
                    v-model="belowBalcony265"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Between HW & BB</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="secondFloorHousePerimeterComputation()"
                    v-model="betweenHWBB265"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total:
                </td>
                <td>
                  <input
                    v-model="total2FLPerimeter"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card v-show="this.shioData.kanabakari == '240'" elevation="1" class="mt-2 mb-5 pa-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">House Perimeter</span>
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  3FL House Perimeter (245)
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">2nd FL (LW)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="secondFloorLowWaist245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">2nd FL (HW)</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="secondFloorHighWaist245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Balcony</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="belowBalcony245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Between HW & BB</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="belowHwBB245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">3rd FL</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="thirdFloor245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Balcony</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="thirdFloorHousePerimeterComputation()"
                    type="number"
                    v-model="thirdFloorBelowBalcony245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total
                </td>
                <td>
                  <input
                    v-model="total3FLPerimeter"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card class="pa-2 mt-2">
          <span style="font-weight: bold; color: #00355e; font-size: 14px">Below Bands</span>
          <table class="table-sm table-bordered">
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Bands 3.9</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="bandsComputation()"
                    v-model="belowBands1"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Bands 3.7</td>
                <td>
                  <input
                    onwheel="return false;"
                    @change="bandsComputation()"
                    v-model="belowBands2"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  Total
                </td>
                <td>
                  <input
                    v-model="totalBands"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
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
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">
                  Pent House
                </th>
                <th>
                  <v-icon small @click="addPentHouseData" color="primary">mdi-plus-circle</v-icon>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in pentHouseData" :key="index">
                <td>
                  <input
                    onwheel="return false;"
                    @change="pentHouseComputation(data)"
                    v-model="data.value"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    v-model="data.total"
                    disabled
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <v-icon small @click="deletePentHouseData(index)" color="red">mdi-close-circle</v-icon>
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

        <v-card v-show="this.shioData.houseType == 'グラン･セゾン(GRAND SAISON)'" elevation="1" class="mt-2 mb-5 pa-2">
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
                <th colspan="3">
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
                  <v-icon small @click="deleteFukisageData(index)" color="red"
                    >mdi-close-circle</v-icon
                  >
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

    <!----------------------------------------- Dialog for Fukiage ------------------------------------------>
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
            v-show="identifier.name == 'Fukiage'"
            @click="toggleBelowDemadoDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Below Demado
          </button>
          <button
            :hidden="identifier.name == 'Fukisage'"
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

          <button
            v-show="identifier.name == 'Fukiage'"
            @click="toggleTarekabe1Dialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Tarekabe 1
          </button>
        </div>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="belowDemadoDialog"
      max-width="300px"
      persistent
    >
      <v-card class="pa-1">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >
          Below Demado
        </v-toolbar>

        <v-divider></v-divider>

        <v-img 
          class="mx-3"
          :src="below_demado"
        ></v-img>

        <v-text-field
          autofocus
          color="#00355e"
          class="pl-3 mt-5"
          style="font-size: 13px; width: 50%;"
          dense
          outlined
          label="Length (grid)"
          v-model="belowDemadoLength"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="belowDemadoDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="belowDemadoComputation(), belowDemadoDialog = false"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="tarekabe2Dialog" max-width="300px" persistent>
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
            @click="tarekabe2Dialog = false"
            color="#00355e"
            style="font-size: 12px"
            text
            plain
          >
            Cancel
          </v-btn>
          <v-btn
            @click="tarekabe2Computation(), tarekabe2Dialog = false"
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

    <v-dialog
      v-model="tarekabe1Dialog"
      max-width="300px"
      persistent
    >
      <v-card class="pa-1">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >
          Tarekabe 1
        </v-toolbar>

        <v-divider></v-divider>

        <v-img 
          class="mx-3"
          :src="tarekabe1"
        ></v-img>

        <v-text-field
          autofocus
          color="#00355e"
          class="pl-3 mt-5"
          style="font-size: 13px; width: 50%;"
          dense
          outlined
          label="Pitch"
          hint="Input as seen on plan"
          @blur="restrictPitch(tarekabe1Input)"
          v-model="tarekabe1Input"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="tarekabe1Dialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            :disabled="tarekabe1Input < 1"
            @click="tarekabe1Computation(), tarekabe1Dialog = false"
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
import tarekabe from "./images/tarekabe2.jpg";
import tarekabe1 from "./images/tarekabe1.jpg"
import tarekabe2 from "./images/tarekabe2.jpg";
import rectangle from "./images/rectangle.jpg";
import whole_triangle from "./images/whole_triangle.jpg";
import trapezoid from "./images/trapezoid.jpg";
import half_triangle from "./images/half_triangle.jpg";
import below_demado from "./images/below_demado.jpg"
import { mapState, mapActions } from "vuex";

export default {
  data() {
    return {
      loadData: false,
      savingData: false,
      outsideD2number: null,

      //dialog for fukiage, fukisage, and roof deduction
      identifier: { name: "" },
      roofDeductionData: [{ total: null, computation: null, inputs: {} }],
      fukiageData: [{ total: null, computation: null, inputs: {} }],
      fukisageData: [{ total: null, computation: null, inputs: {} }],

      //bands
      belowBands1: null,
      belowBands2: null,
      totalBands1: null,
      totalBands2: null,
      totalBands: null,

      //below demado
      belowDemadoLength: null,

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

      //tarekabe 1
      tarekabe1Input: null,

      //dialog for fukiage
      halfTriangleDialog: false,
      trapezoidDialog: false,
      wholeTriangleDialog: false,
      rectangleDialog: false,
      tarekabe2Dialog: false,
      belowDemadoDialog: false,
      fukiageDialog: false,
      tarekabe1Dialog: false,

      //images
      below_demado: below_demado,
      tarekabe2: tarekabe2,
      rectangle: rectangle,
      whole_triangle: whole_triangle,
      trapezoid: trapezoid,
      half_triangle: half_triangle,
      tarekabe1: tarekabe1,

      //hanging wall
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
      total3FHangingWall: 0,

      //whole curved tarekabe
      heightOfTarekabe1: null,
      heightOfTarekabe: null,
      lengthOfTarekabe: null,
      outerPartOfDiameter: null,
      area: null,
      parabolic: null,
      totalWholeCurvedTarekabe: null,

      //3FL House Perimeter (245)
      secondFloorHighWaist245: null,
      secondFloorLowWaist245: null,
      belowBalcony245: null,
      belowHwBB245: null,
      thirdFloor245: null,
      thirdFloorBelowBalcony245: null,
      total3FLPerimeter: null,

      tempSecondFloorHighWaist245: null,
      tempSecondFloorLowWaist245: null,
      tempBelowBalcony245: null,
      tempBelowHwBB245: null,
      tempThirdFloor245: null,
      tempThirdFloorBelowBalcony245: null,

      //2FL House Perimeter (265)
      secondFloorLowWaist265: null,
      secondFloorHighWaist265: null,
      belowBalcony265: null,
      betweenHWBB265: null,
      tempBelowBalcony265: null,
      tempBetweenHWBB265: null,
      tempSecondFloorLowWaist: null,
      tempSecondFloorHighWaist: null,
      total2FLPerimeter: null,

      //partial curved tarekabe
      pi: 3.14,
      insideD1: null,
      outsideD2: null,
      tempOutsideD2: null,
      tempInsideD1: null,
      tempTotalCurvedTarekabe: null,
      totalPartialCurved: null,

      //pent house
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
      overlay: false,
      totalOptionPoints: null,

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
    }
  },

  watch:{
    shioData(val){
      if(typeof(val.customerCode) !== 'undefined'){
        this.getJikugumiData()
      }
    }
  },

  mounted(){
    this.disableTyping()
  },

  created(){
    if(typeof(this.shioData.customerCode) !== 'undefined'){
      if(this.loadJiku == 0){
        this.$store.commit('changeJikuState', 1)
        this.getJikugumiData()
      }else{
        if(this.isClear == false){
          this.getStoredJikugumiData()
        }
      }
    }
  },

  methods: {
    restrictPitch(val){
      if(val < 1 && val !== null){
        Swal.fire({
          toast: true,
          position: "center",
          icon: "error",
          title: "Invalid Value",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        });
      }
    },

    getStoredJikugumiData(){
      this.outsideD2 = this.partialCurved.outsideD2
      this.insideD1 = this.partialCurved.insideD1
      this.totalPartialCurved = this.partialCurved.totalPartialCurved

      this.heightOfTarekabe = this.wholeCurved.heightOfTarekabe
      this.lengthOfTarekabe = this.wholeCurved.lengthOfTarekabe
      this.outerPartOfDiameter = this.wholeCurved.outerPartOfDiameter
      this.totalWholeCurvedTarekabe = this.wholeCurved.totalWholeCurvedTarekabe

      this.belowBands1 = this.belowBands.belowBands1
      this.belowBands2 = this.belowBands.belowBands2
      this.totalBands = this.belowBands.totalBands

      if(this.sashDataJiku.length > 0){
        this.sashesData = this.sashDataJiku
      }

      this.secondFloorLowWaist265 = this.perimeter2F.secondFloorLowWaist265
      this.secondFloorHighWaist265 = this.perimeter2F.secondFloorHighWaist265
      this.belowBalcony265 = this.perimeter2F.belowBalcony265
      this.betweenHWBB265 = this.perimeter2F.betweenHWBB265
      this.total2FLPerimeter = this.perimeter2F.total2FLPerimeter

      this.secondFloorLowWaist245 = this.perimeter3F.secondFloorLowWaist245
      this.secondFloorHighWaist245 = this.perimeter3F.secondFloorHighWaist245
      this.belowBalcony245 = this.perimeter3F.belowBalcony245
      this.belowHwBB245 = this.perimeter3F.belowHwBB245
      this.thirdFloor245 = this.perimeter3F.thirdFloor245
      this.thirdFloorBelowBalcony245 = this.perimeter3F.thirdFloorBelowBalcony245
      this.total3FLPerimeter = this.perimeter3F.total3FLPerimeter

      if(this.hangingWall2FJiku.length > 0){
        this.hangingWallArray2F = this.hangingWall2FJiku
        this.totalHangingWallComputation2F()
      }

      if(this.hangingWall3FJiku.length > 0){
        this.hangingWallArray3F = this.hangingWall3FJiku
        this.totalHangingWallComputation3F()
      }

      if(this.pentHouseDataJiku.length > 0){
        this.pentHouseData = this.pentHouseDataJiku
      }

      if(this.fukiageDataJiku.length > 0){
        this.fukiageData = this.fukiageDataJiku
      }

      if(this.fukisageDataJiku.length > 0){
        this.fukisageData = this.fukisageDataJiku
      }

      if(this.roofDeductionDataJiku.length > 0){
        this.roofDeductionData = this.roofDeductionDataJiku
      }

      this.parapet1 = this.parapetJiku.parapet1
      this.parapet2 = this.parapetJiku.parapet2
      this.parapet3 = this.parapetJiku.parapet3
      this.parapet4 = this.parapetJiku.parapet4
      this.parapet5 = this.parapetJiku.parapet5
      this.totalParapet1 = this.parapetJiku.totalParapet1
      this.totalParapet2 = this.parapetJiku.totalParapet2
      this.totalParapet3 = this.parapetJiku.totalParapet3
      this.totalParapet4 = this.parapetJiku.totalParapet4
      this.totalParapet5 = this.parapetJiku.totalParapet5
    },

    storeJikugumiData(){
      this.partialCurved.outsideD2 = this.outsideD2
      this.partialCurved.insideD1 = this.insideD1
      this.partialCurved.totalPartialCurved = this.totalPartialCurved

      this.wholeCurved.heightOfTarekabe = this.heightOfTarekabe
      this.wholeCurved.lengthOfTarekabe = this.lengthOfTarekabe
      this.wholeCurved.outerPartOfDiameter = this.outerPartOfDiameter
      this.wholeCurved.totalWholeCurvedTarekabe = this.totalWholeCurvedTarekabe

      this.belowBands.belowBands1 = this.belowBands1
      this.belowBands.belowBands2 = this.belowBands2
      this.belowBands.totalBands = this.totalBands

      this.$store.commit('getSashDataJiku', this.sashesData)

      this.perimeter2F.secondFloorLowWaist265 = this.secondFloorLowWaist265
      this.perimeter2F.secondFloorHighWaist265 = this.secondFloorHighWaist265
      this.perimeter2F.belowBalcony265 = this.belowBalcony265
      this.perimeter2F.betweenHWBB265 = this.betweenHWBB265
      this.perimeter2F.total2FLPerimeter = this.total2FLPerimeter

      this.perimeter3F.secondFloorLowWaist245 = this.secondFloorLowWaist245
      this.perimeter3F.secondFloorHighWaist245 = this.secondFloorHighWaist245
      this.perimeter3F.belowBalcony245 = this.belowBalcony245
      this.perimeter3F.belowHwBB245 = this.belowHwBB245
      this.perimeter3F.thirdFloor245 = this.thirdFloor245
      this.perimeter3F.thirdFloorBelowBalcony245 = this.thirdFloorBelowBalcony245
      this.perimeter3F.total3FLPerimeter = this.total3FLPerimeter

      this.parapetJiku.parapet1 = this.parapet1
      this.parapetJiku.parapet2 = this.parapet2
      this.parapetJiku.parapet3 = this.parapet3
      this.parapetJiku.parapet4 = this.parapet4
      this.parapetJiku.parapet5 = this.parapet5
      this.parapetJiku.totalParapet1 = this.totalParapet1
      this.parapetJiku.totalParapet2 = this.totalParapet2
      this.parapetJiku.totalParapet3 = this.totalParapet3
      this.parapetJiku.totalParapet4 = this.totalParapet4
      this.parapetJiku.totalParapet5 = this.totalParapet5

      this.$store.commit('getPentHouseDataJiku', this.pentHouseData)
      this.$store.commit('getFukiageDataJiku', this.fukiageData)
      this.$store.commit('getFukisageDataJiku', this.fukisageData)
      this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
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

    toggleBelowDemadoDialog() {
      this.belowDemadoDialog = true;
      this.belowDemadoLength = null;
    },

    toggleRectangleDialog() {
      this.rectangleDialog = true;
      this.rectangleHeight = null;
      this.rectangleWidth = null;
      this.rectanglePitch = null;
    },

    toggleTarekabe2Dialog() {
      this.tarekabe2Dialog = true;
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

    toggleTarekabe1Dialog() {
      this.tarekabe1Dialog = true;
      this.tarekabe1Input = null;
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
      if(data.computation == "Below Demado"){
        this.belowDemadoLength = data.inputs.length
        this.belowDemadoDialog = true
      }else if(data.computation == "Tarekabe 2"){
        this.tarekabeWidth = data.inputs.width
        this.tarekabe2Dialog = true
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

    ///////////////////////////////////////////////// partial curved ////////////////////////////////////////////////////////

    partialCurvedComputation(){
      let total = 0;
      total = (this.pi * ((this.outsideD2 * this.outsideD2) - (this.insideD1 * this.insideD1))) / 8;
      this.totalPartialCurved = Math.trunc(total * 1000) / 1000

      this.partialCurved.outsideD2 = this.outsideD2
      this.partialCurved.insideD1 = this.insideD1
      this.partialCurved.totalPartialCurved = this.totalPartialCurved
    },
    
    wholeCurvedComputation(){
      this.area = this.heightOfTarekabe * this.lengthOfTarekabe;
      this.parabolic = (2 * (this.lengthOfTarekabe * 0.3095)) / 3;

      let total = 0;
      total = this.area - this.parabolic;
      this.totalWholeCurvedTarekabe = Math.trunc(total * 1000) / 1000

      this.wholeCurved.heightOfTarekabe = this.heightOfTarekabe
      this.wholeCurved.lengthOfTarekabe = this.lengthOfTarekabe
      this.wholeCurved.outerPartOfDiameter = this.outerPartOfDiameter
      this.wholeCurved.totalWholeCurvedTarekabe = this.totalWholeCurvedTarekabe
    },

    ///////////////////////////////////////////////// below bands ////////////////////////////////////////////////////////

    bandsComputation() {
      if (this.belowBands1 !== null) {
        this.totalBands1 = this.belowBands1 * 0.91 * 3.9;
      }
      if (this.belowBands2 !== null) {
        this.totalBands2 = this.belowBands2 * 0.91 * 3.7;
      }

      if  (this.belowBands1 !== null && this.belowBands2 !== null) {
        let total = (this.belowBands1 * 0.91 * 3.9) + (this.belowBands2 * 0.91 * 3.7);
        this.totalBands = Math.floor(total * 1000) / 1000
      }

      this.belowBands.belowBands1 = this.belowBands1
      this.belowBands.belowBands2 = this.belowBands2
      this.belowBands.totalBands = this.totalBands
    },

    ///////////////////////////////////////////////// house perimeter ////////////////////////////////////////////////////////

    secondFloorHousePerimeterComputation(){
      let meter = 0.91;
      let lowWaist = 2.82;
      let highWaist = 2.12;

      if (this.secondFloorLowWaist265 != null) {
        this.tempSecondFloorLowWaist = meter * this.secondFloorLowWaist265;
        this.tempSecondFloorLowWaist = lowWaist * this.tempSecondFloorLowWaist;
      }
      if (this.secondFloorHighWaist265 != null) {
        this.tempSecondFloorHighWaist = meter * this.secondFloorHighWaist265;
        this.tempSecondFloorHighWaist = highWaist * this.tempSecondFloorHighWaist;
      }
      if (this.belowBalcony265 != null) {
        this.tempBelowBalcony265 = meter * this.belowBalcony265;
        this.tempBelowBalcony265 = 2.39 * this.tempBelowBalcony265;
      }
      if (this.betweenHWBB265 != null) {
        this.tempBetweenHWBB265 = meter * this.betweenHWBB265;
        this.tempBetweenHWBB265 = 1.69 * this.tempBetweenHWBB265;
      }

      let total = 0;
      total =
        this.tempSecondFloorLowWaist +
        this.tempSecondFloorHighWaist +
        this.tempBelowBalcony265 +
        this.tempBetweenHWBB265

      this.total2FLPerimeter = Math.trunc(total * 1000) / 1000

      this.perimeter2F.secondFloorLowWaist265 = this.secondFloorLowWaist265
      this.perimeter2F.secondFloorHighWaist265 = this.secondFloorHighWaist265
      this.perimeter2F.belowBalcony265 = this.belowBalcony265
      this.perimeter2F.betweenHWBB265 = this.betweenHWBB265
      this.perimeter2F.total2FLPerimeter = this.total2FLPerimeter
    },

    thirdFloorHousePerimeterComputation(){
      let meter = 0.91;
      if (this.secondFloorLowWaist245 != null) {
        this.tempSecondFloorLowWaist245 = meter * this.secondFloorLowWaist245;
        this.tempSecondFloorLowWaist245 = 2.63 * this.tempSecondFloorLowWaist245;
      }
      if (this.secondFloorHighWaist245 != null) {
        this.tempSecondFloorHighWaist245 = meter * this.secondFloorHighWaist245;
        this.tempSecondFloorHighWaist245 = 1.93 * this.tempSecondFloorHighWaist245;
      }
      if (this.belowBalcony245 != null) {
        this.tempBelowBalcony245 = meter * this.belowBalcony245;
        this.tempBelowBalcony245 = 2.2 * this.tempBelowBalcony245;
      }
      if (this.belowHwBB245 != null) {
        this.tempBelowHwBB245 = meter * this.belowHwBB245;
        this.tempBelowHwBB245 = 1.5 * this.tempBelowHwBB245;
      }
      if (this.thirdFloor245 != null) {
        this.tempThirdFloor245 = meter * this.thirdFloor245;
        this.tempThirdFloor245 = 2.55 * this.tempThirdFloor245;
      }
      if (this.thirdFloorBelowBalcony245 != null) {
        this.tempThirdFloorBelowBalcony245 = meter * this.thirdFloorBelowBalcony245;
        this.tempThirdFloorBelowBalcony245 = 2.12 * this.tempThirdFloorBelowBalcony245;
      }

      let total = 0;
      total =
        this.tempSecondFloorHighWaist245 +
        +this.tempSecondFloorLowWaist245 +
        +this.tempBelowBalcony245 +
        +this.tempBelowHwBB245 +
        +this.tempThirdFloor245 +
        +this.tempThirdFloorBelowBalcony245;

      this.total3FLPerimeter = Math.trunc(total * 1000) / 1000

      this.perimeter3F.secondFloorLowWaist245 = this.secondFloorLowWaist245
      this.perimeter3F.secondFloorHighWaist245 = this.secondFloorHighWaist245
      this.perimeter3F.belowBalcony245 = this.belowBalcony245
      this.perimeter3F.belowHwBB245 = this.belowHwBB245
      this.perimeter3F.thirdFloor245 = this.thirdFloor245
      this.perimeter3F.thirdFloorBelowBalcony245 = this.thirdFloorBelowBalcony245
      this.perimeter3F.total3FLPerimeter = this.total3FLPerimeter
    },

    ///////////////////////////////////////////////// below demado ////////////////////////////////////////////////////////

    belowDemadoComputation(){
      // const area1 = this.belowDemadoLength * 0.9 old
      const area1 = (this.belowDemadoLength * 0.91) * 0.9
      const area = parseFloat(area1)

      this.fukiageData[this.fukiageData.length - 1].total = area;
      this.fukiageData[this.fukiageData.length - 1].computation = "Below Demado";
      this.fukiageData[this.fukiageData.length - 1].inputs = { length: this.belowDemadoLength };
      this.fukiageDialog = false
      this.tarekabe2Dialog = false

      this.$store.commit('getFukiageDataJiku', this.fukiageData)

      this.belowDemadoLength = null
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
              this.tarekabe2Dialog = false;
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
              this.tarekabe2Dialog = false;
            }

            this.$store.commit('getFukiageDataJiku', this.fukiageData)
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
              this.tarekabe2Dialog = false;
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
              this.tarekabe2Dialog = false;
            }

            this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
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
              this.tarekabe2Dialog = false;
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
              this.tarekabe2Dialog = false;
            }

            this.$store.commit('getFukisageDataJiku', this.fukisageData)
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

          this.$store.commit('getFukiageDataJiku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          let total = 0;
          // total = (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) / 2;
          total = ((this.halfTriangleHeight * 0.91) * (this.halfTriangleWidth * 0.91) * (this.halfTrianglePitch / 10)) / 2;

          if(this.halfTriangleQuantity !== null){
            total = total * halfTriangleQuantity
          }else{
            total = total
          }

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Half Triangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.halfTriangleHeight, width: this.halfTriangleWidth, pitch: this.halfTrianglePitch, quantity: this.halfTriangleQuantity };
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;

          this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          let total = 0;
          // total = (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) / 2;
          total = ((this.halfTriangleHeight * 0.91) * (this.halfTriangleWidth * 0.91) * (this.halfTrianglePitch / 10)) / 2;

          if(this.halfTriangleQuantity !== null){
            total = total * halfTriangleQuantity
          }else{
            total = total
          }

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Half Triangle";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height: this.halfTriangleHeight, width: this.halfTriangleWidth, pitch: this.halfTrianglePitch, quantity: this.halfTriangleQuantity };
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;

          this.$store.commit('getFukisageDataJiku', this.fukisageData)
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
          // let total = ((this.traperzoidHeight1 + this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2; old
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Trapezoid";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukiageDataJiku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          // let total = ((+this.traperzoidHeight1 + +this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2;
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Trapezoid";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          // let total = ((+this.traperzoidHeight1 + +this.traperzoidHeight2) * this.trapezoidWidth * this.trapezoidPitch) / 2;
          let total = (((this.traperzoidHeight1 * 0.91) + (this.traperzoidHeight2 * 0.91)) * (this.trapezoidWidth * 0.91) * (this.trapezoidPitch / 10)) / 2;

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Trapezoid";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height1: this.traperzoidHeight1, height2: this.traperzoidHeight2, width: this.trapezoidWidth, pitch: this.trapezoidPitch };
          this.trapezoidDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukisageDataJiku', this.fukisageData)
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

          this.$store.commit('getFukiageDataJiku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          // let total = (this.wholeTriangleHeight * this.wholeTriangleWidth * this.wholeTrianglePitch) / 4;
          let total = ((this.wholeTriangleHeight * 0.91) * (this.wholeTriangleWidth * 0.91) * (this.wholeTrianglePitch / 10)) / 4;

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Whole Triangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.wholeTriangleHeight, width: this.wholeTriangleWidth, pitch: this.wholeTrianglePitch };
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;

          this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
        }
        else if (this.identifier.name == "Fukisage") {
          // let total = (this.wholeTriangleHeight * this.wholeTriangleWidth * this.wholeTrianglePitch) / 4;
          let total = ((this.wholeTriangleHeight * 0.91) * (this.wholeTriangleWidth * 0.91) * (this.wholeTrianglePitch / 10)) / 4;

          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Whole Triangle";
          this.fukisageData[this.fukisageData.length - 1].inputs = { height: this.wholeTriangleHeight, width: this.wholeTriangleWidth, pitch: this.wholeTrianglePitch };
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;

          this.$store.commit('getFukisageDataJiku', this.fukisageData)
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
          total = (this.rectangleHeight * 0.91) * (this.rectangleWidth * 0.91) * (this.rectanglePitch / 10);

          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Rectangle";
          this.fukiageData[this.fukiageData.length - 1].inputs = { height: this.rectangleHeight, width: this.rectangleWidth, pitch: this.rectanglePitch };
          this.rectangleDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getFukiageDataJiku', this.fukiageData)
        }
        else if (this.identifier.name == "Roof Deduction") {
          let total = 0;
          // total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          total = (this.rectangleHeight * 0.91) * (this.rectangleWidth * 0.91) * (this.rectanglePitch / 10)
          console.log(total, 'help')

          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation = "Rectangle";
          this.roofDeductionData[this.roofDeductionData.length - 1].inputs = { height: this.rectangleHeight, width: this.rectangleWidth, pitch: this.rectanglePitch };
          this.rectangleDialog = false;
          this.fukiageDialog = false;

          this.$store.commit('getRoofDeductionDataJiku', this.roofDeductionData)
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

          this.$store.commit('getFukisageDataJiku', this.fukisageData)
        }
      }
    },

    tarekabe1Computation(){
      if (this.identifier.name == "Fukiage") {
        if(this.$store.getters.getShioData.kanabakari == "240"){
          var outside = 1.175
        }
        else if(this.$store.getters.getShioData.kanabakari == "265"){
          var outside = 1.1
        }

        const HW1 = 0.607 * outside
        const HW2 = 0.607 * 0.268
        const AH = 0.303 * 0.7

        const A1 = HW1 + HW2 + AH
        const A2 = (0.91 * 0.91 * (this.tarekabe1Input / 10)) / 2

        const point = A1 - A2
        const tarekabe1Point = parseFloat(point)

        this.fukiageData[this.fukiageData.length - 1].total = tarekabe1Point;
        this.fukiageData[this.fukiageData.length - 1].computation = "Tarekabe 1";
        this.fukiageData[this.fukiageData.length - 1].inputs = { input: this.tarekabe1Input };
        this.tarekabe1Dialog = false;
        this.fukiageDialog = false;
        this.tarekabe1Input = null

        this.$store.commit('getFukiageDataJiku', this.fukiageData)
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
      this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
    },

    addOpeningData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].opening.push(data)
      this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
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
          this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
        }
      })
    },

    addHWData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].hw.push(data)
      this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
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
          this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
        }
      })
    },

    addInsideData2F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray2F[index].inside.push(data)
      this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
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
          this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
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

        item.total = item.total - ((length - total) * 2.3) //standard height
      }

      //hw
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

      //inside
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
      
      this.totalHangingWallComputation2F()
    },

    totalHangingWallComputation2F(){
      let total = 0;
      this.hangingWallArray2F.forEach(rec => {
        total += rec.total;
      })
      
      this.total2FHangingWall = Math.trunc(total * 1000) / 1000
      this.$store.commit('getHangingWall2FJiku', this.hangingWallArray2F)
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
      this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
    },

    addOpeningData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].opening.push(data)
      this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
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
          this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
        }
      })
    },

    addHWData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].hw.push(data)
      this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
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
          this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
        }
      })
    },

    addInsideData3F(index){
      let data = { "length": null, "column": null, "thickness": null }
      this.hangingWallArray3F[index].inside.push(data)
      this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
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
          this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
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
      this.$store.commit('getHangingWall3FJiku', this.hangingWallArray3F)
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

    ///////////////////////////////////////////////// penthouse ////////////////////////////////////////////////////////

    deletePentHouseData(index) {
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
          this.pentHouseData.splice(index, 1);
        }
      })
    },

    addPentHouseData() {
      let row = {
        value: null,
        total: null,
      };
      if (this.pentHouseData.length == 0) {
        this.pentHouseData.push(row);
      }
      else if (this.pentHouseData[this.pentHouseData.length - 1].total != null) {
        this.pentHouseData.push(row);
      }
    },

    pentHouseComputation(data) {
      if (data.value != null) {
        data.total = (data.value * 0.91) * 2;
        if (data.total != null) {
          let row = {
            value: null,
            total: null,
          };
          this.pentHouseData.push(row);
        }

        this.$store.commit('getPentHouseDataJiku', this.pentHouseData)
      }
    },

    ///////////////////////////////////////////////// parapet ////////////////////////////////////////////////////////

    sumParapet(){
      this.totalParapet1 = (this.parapet1 * 0.91) * 0.41
      this.totalParapet2 = (this.parapet2 * 0.91) * 0.46
      this.totalParapet3 = (this.parapet3 * 0.91) * 0.605
      this.totalParapet4 = (this.parapet4 * 0.91) * 0.274
      this.totalParapet5 = (this.parapet5 * 0.91) * 0.271

      this.parapetJiku.parapet1 = this.parapet1
      this.parapetJiku.parapet2 = this.parapet2
      this.parapetJiku.parapet3 = this.parapet3
      this.parapetJiku.parapet4 = this.parapet4
      this.parapetJiku.parapet5 = this.parapet5
      this.parapetJiku.totalParapet1 = this.totalParapet1
      this.parapetJiku.totalParapet2 = this.totalParapet2
      this.parapetJiku.totalParapet3 = this.totalParapet3
      this.parapetJiku.totalParapet4 = this.totalParapet4
      this.parapetJiku.totalParapet5 = this.totalParapet5
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

    addSashData() {
      let row = {
        sashWidth: null,
        sashHeight: null,
        sashWidthValue: null,
        sashHeightValue: null,
        total: null,
      };
      if (this.sashesData.length == 0) {
        this.sashesData.push(row);
      }
      else if (this.sashesData[this.sashesData.length - 1].total != null) {
        this.sashesData.push(row);
      }
    },

    sashesComputation(data) {
      let arrSashWidthValue = this.sashSize.filter((r) => {
        return r.width == data.sashWidth;
      });

      let arrSashHeightValue = this.sashSize.filter((r) => {
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
          position: "center",
          icon: "error",
          title: "Invalid Input",
          text: "Width is not available",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        });

        data.sashWidth = null;
        data.total = 0;
      } else if (data.sashHeight != null) {
        if (data.sashHeightValue == 0) {
          Swal.fire({
            toast: true,
            position: "center",
            icon: "error",
            title: "Invalid Input",
            text: "Height is not available",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500,
          });

          data.sashHeight = null;
          data.total = 0;
        }
      }

      data.total = (data.sashHeightValue / 1000) * (data.sashWidthValue / 1000);
      data.tempTotal = Math.trunc(data.total * 1000) / 1000;

      this.$store.commit('getSashDataJiku', this.sashesData)

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

    ///////////////////////////////////////////////// SAVING ////////////////////////////////////////////////////////

    saveJikugumiData(){
      this.savingData = true
      let partialCurved = {
        outside: this.outsideD2,
        inside: this.insideD1,
        total_points: this.totalPartialCurved
      }

      let wholeCurved = {
        height: this.heightOfTarekabe,
        length: this.lengthOfTarekabe,
        diameter: this.outerPartOfDiameter,
        total_points: this.totalWholeCurvedTarekabe
      }

      let belowBands = {
        below_bands39: this.belowBands1,
        below_bands37: this.belowBands2,
        total_points: this.totalBands
      }

      let perimeter2F = {
        low_waist_2f: this.secondFloorLowWaist265,
        high_waist_2f: this.secondFloorHighWaist265,
        below_balcony_2f: this.belowBalcony265,
        between_hw_2f: this.betweenHWBB265,
        total_points: this.total2FLPerimeter
      }

      let perimeter3F = {
        low_waist_3f: this.secondFloorLowWaist245,
        high_waist_3f: this.secondFloorHighWaist245,
        below_balcony: this.belowBalcony245,
        between_hw_3f: this.belowHwBB245,
        perimeter_3f: this.thirdFloor245,
        below_balcony_3f: this.thirdFloorBelowBalcony245,
        total_points: this.total3FLPerimeter
      }

      let parapet = {
        parapet_041: this.parapet1,
        parapet_046: this.parapet2,
        parapet_0605: this.parapet3,
        parapet_0274: this.parapet4,
        parapet_0271: this.parapet5,
        total_points: this.totalParapet
      }

      let sashArr = this.sashesData
      const empty = sashArr.filter(r => r.total == null)
      if(empty.length > 0){
        const id = sashArr.findIndex(r => r.total == null)
        sashArr.splice(id, 1);
      }

      let pentArr = this.pentHouseData
      const empty1 = pentArr.filter(r => r.value == null)
      if(empty1.length > 0){0  
        const id1 = pentArr.findIndex(r => r.value == null)
        pentArr.splice(id1, 1);
      }

      if(typeof(this.shioData.customerCode) !== 'undefined'){
        axios.post('api/saveJikugumiData', {
          customer_code: this.shioData.customerCode,
          plan_no: this.shioData.planNo,
          partialCurved,
          wholeCurved,
          belowBands,
          perimeter2F,
          perimeter3F,
          hangingWall2F: this.hangingWallArray2F,
          hangingWall3F: this.hangingWallArray3F,
          sashArr,
          pentArr,
          parapet,
          fukiageArr: this.fukiageData,
          fukisageArr: this.fukisageData,
          roofDeductionArr: this.roofDeductionData,
          totalOptionPoints: this.totalOptionPoints
        }).then(res => {
          this.savingData = false

          Swal.fire({
            position: 'center',
            icon: 'success',
            iconColor: '#3ab792',
            title: 'Success!',
            text: '2F Jikugumi has been saved.',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2500
          })
        })
      }
    },

    ///////////////////////////////////////////////// FETCHING ////////////////////////////////////////////////////////
    
    getJikugumiData(){
      this.loadData = true
      axios.post('api/getJikugumiData', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo,
      }).then(async res => {
        if(res.data.partial_tarekabe.length > 0){
          this.outsideD2 = res.data.partial_tarekabe[0].outside
          this.insideD1 = res.data.partial_tarekabe[0].inside
          this.totalPartialCurved = res.data.partial_tarekabe[0].total_points
        }

        if(res.data.whole_tarekabe.length > 0){
          this.heightOfTarekabe = res.data.whole_tarekabe[0].height
          this.lengthOfTarekabe = res.data.whole_tarekabe[0].length
          this.outerPartOfDiameter = res.data.whole_tarekabe[0].diameter
          this.totalWholeCurvedTarekabe = res.data.whole_tarekabe[0].total_points
        }
        
        if(res.data.below_bands.length > 0){
          this.belowBands1 = res.data.below_bands[0].below_bands39
          this.belowBands2 = res.data.below_bands[0].below_bands37
          this.totalBands = res.data.below_bands[0].total_points
        }

        if(res.data.sash.length > 0){
          this.sashesData = res.data.sash
        }

        if(res.data.perimeter_2f.length > 0){
          this.secondFloorLowWaist265 = res.data.perimeter_2f[0].low_waist
          this.secondFloorHighWaist265 = res.data.perimeter_2f[0].high_waist
          this.belowBalcony265 = res.data.perimeter_2f[0].below_balcony
          this.betweenHWBB265 = res.data.perimeter_2f[0].between_hw
          this.total2FLPerimeter = res.data.perimeter_2f[0].total_points
        }

        if(res.data.perimeter_3f.length > 0){
          this.secondFloorLowWaist245 = res.data.perimeter_3f[0].low_waist
          this.secondFloorHighWaist245 = res.data.perimeter_3f[0].high_waist
          this.belowBalcony245 = res.data.perimeter_3f[0].below_balcony_2f
          this.belowHwBB245 = res.data.perimeter_3f[0].between_hw
          this.thirdFloor245 = res.data.perimeter_3f[0].floor_3
          this.thirdFloorBelowBalcony245 = res.data.perimeter_3f[0].below_balcony_3f
          this.total3FLPerimeter = res.data.perimeter_3f[0].total_points
        }

        if(res.data.hw_2f.length > 0){
          this.hangingWallArray2F = res.data.hw_2f
          this.totalHangingWallComputation2F()
        }

        if(res.data.hw_3f.length > 0){
          this.hangingWallArray3F = res.data.hw_3f
          this.totalHangingWallComputation3F()
        }

        if(res.data.pent_house.length > 0){
          this.pentHouseData = res.data.pent_house
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

        this.loadData = false
        await this.storeJikugumiData()
      })
    },

    disableTyping(){
      $('input:disabled').keypress(function(e){
        e.preventDefault();
        return false;
      });
    },

    ...mapActions(["SashSizeDataPage"])
  },

  computed: {
    ...mapState(
      [
        'shioData',
        'sashSize',
        'partialCurved',
        'wholeCurved',
        'belowBands',
        'sashDataJiku',
        'perimeter2F',
        'perimeter3F',
        'hangingWall2FJiku',
        'hangingWall3FJiku',
        'pentHouseDataJiku',
        'fukiageDataJiku',
        'fukisageDataJiku',
        'roofDeductionDataJiku',
        'loadJiku',
        'parapetJiku',
        'isClear'
      ]
    ),

    showTarekabe2() {
      if (this.identifier.name == "Roof Deduction") {
        return false;
      } else {
        return true;
      }
    },

    totalAllPointsBelow() {
      let total = 0;
      total =
        this.totalPartialCurved +
        this.total2FLPerimeter +
        this.total3FLPerimeter +
        this.total2FHangingWall +
        this.total3FHangingWall +
        this.totalWholeCurvedTarekabe -
        this.totalSash +
        this.totalPentHouse +
        this.totalFukiage -
        this.totalFukisage -
        this.totalRoofDeduction +
        this.totalParapet +
        this.totalBands

        this.totalOptionPoints = Math.floor(total * 1000) / 1000
        this.$store.commit('get2FJikuPoints', this.totalOptionPoints)

        return Math.floor(total * 1000) / 1000;
    },

    totalAllPointsAbove() {
      let total =
        this.totalPartialCurved +
        this.total2FLPerimeter +
        this.total3FLPerimeter +
        this.total2FHangingWall +
        this.total3FHangingWall +
        this.totalWholeCurvedTarekabe -
        this.totalSash +
        this.totalPentHouse +
        this.totalFukiage -
        this.totalFukisage -
        this.totalRoofDeduction +
        this.totalParapet +
        this.totalBands

      return Math.round(total * 100) / 100;
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
    
    totalPentHouse() {
      let total = 0;
      this.pentHouseData.filter((rec) => {
        total += rec.total;
      });

      return total;
    },

    totalParapet(){
      let total = 0;
      total = this.totalParapet1 + this.totalParapet2 + this.totalParapet3 + this.totalParapet4 + this.totalParapet5
      return (total = Math.trunc(total * 1000) / 1000);
    },
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

  input {
    font-size: 12px ;
  }

  .inputPrice >>> input[type="number"] {
    -moz-appearance: textfield;
  }

  .inputPrice >>> input::-webkit-outer-spin-button,
  .inputPrice >>> input::-webkit-inner-spin-button {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
  }

  table {
    width: 100%;
  }

  .swal2-popup {
    font-size: 13px !important;
    font-family: Rubik;
  }
</style>