<template>
  <div>
    <v-overlay v-model="overlay">
      <v-progress-circular size="75" indeterminate></v-progress-circular>
    </v-overlay>

    <v-row class="ma-2">
      <v-col cols="3">
        <span style="font-weight: bold; color: #00355e; font-size: 14px">Tarekabe</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
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
          <v-spacer />
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
                    @keyup.enter="heightOfTarekabeComputation()"
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
                    @keyup.enter="lengthOfTarekabeComputation()"
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
                    @keyup.enter="outerPartOfDiameterComputation()"
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

        <v-card class="pa-2 mb-5">
          <table class="table-sm table-bordered">
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Bands 3.9</td>
                <td>
                  <input
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

        <span style="font-weight: bold; color: #00355e; font-size: 14px">Sashes</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px" class="text-center">Width</th>
                <th style="font-size: 12px" class="text-center">Height</th>
                <th style="font-size: 12px" class="text-center">Total</th>
                <th>
                  <v-icon small @click="addSashData()" color="primary"
                    >mdi-plus-circle</v-icon
                  >
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in sashesData" :key="index">
                <td>
                  <input
                    @change="sashesComputation(data)"
                    v-model="data.sashWidth"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="sashesComputation(data)"
                    v-model="data.sashHeight"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="sashesComputation(data)"
                    v-model="data.tempTotal"
                    type="number"
                    class="form-control text-center"
                    :disabled="true"
                  />
                </td>
                <td>
                  <v-icon small @click="deleteSashData(index)" color="red"
                    >mdi-close-circle</v-icon
                  >
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
        <span style="font-weight: bold; color: #00355e; font-size: 14px">House Perimeter</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
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
                    @change="secondFloorHousePerimeterComputation()"
                    type="number"
                    v-model="secondFloorHighWaist265"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Balcony</td>
                <td><input type="number" class="form-control text-center" /></td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Between HW & BB</td>
                <td><input type="number" class="form-control text-center" /></td>
              </tr>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">Total:</td>
                <td>
                  <input
                    v-model="totalSecondHousePerimeter"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px" class="text-center">3FL House Perimeter (245)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">2nd FL (LW)</td>
                <td>
                  <input
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
                    type="number"
                    @change="thirdFloorHousePerimeterComputation()"
                    v-model="secondFloorHighWaist245"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Below Balcony</td>
                <td>
                  <input
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
                    v-model="totalThirdHousePerimeter"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <span style="font-weight: bold; color: #00355e; font-size: 14px">Hanging Wall</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table v-show="showTable" class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="8" style="font-size: 12px" class="text-center">Hanging Wall (2F House)</th>
              </tr>
              <tr>
                <th style="font-size: 12px" class="text-center">2FL House</th>
                <th style="font-size: 12px" class="text-center">2nd FL</th>
                <th style="font-size: 12px" class="text-center">2nd FL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- 2F -->
                <td style="font-size: 12px" class="text-center">Outside</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOutside1"
                    type="number"
                    class="form-control text-center"
                    :disabled="disableHangingWall2F()"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOutside2"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <!-- 2F -->
                <td style="font-size: 12px" class="text-center">Opening</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOpening1"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOpening2"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <!-- 3F -->
              </tr>
              <tr>
                <!-- 2F -->
                <td style="font-size: 12px" class="text-center">HW</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallHW1"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallHW2"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <!-- 3F -->
              </tr>
              <tr>
                <!-- 2F -->
                <td style="font-size: 12px" class="text-center">Inside</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallInside1"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallInside2"
                    :disabled="disableHangingWall2F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <!-- 3F -->
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
                    v-model="finalTotalHangingWall2F"
                    style="font-size: 12px; font-weight: bold"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
            </tfoot>
          </table>
          <!-- **************************************************** -->
          <!-- ******************Third Floor ******************* -->
          <!-- **************************************************** -->
          <table v-show="showTable2" class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="8" style="font-size: 12px" class="text-center">Hanging Wall (2F House)</th>
              </tr>
              <th style="font-size: 12px" class="text-center">3FL House</th>
              <th style="font-size: 12px" class="text-center">2nd FL</th>
              <th style="font-size: 12px" class="text-center">2nd FL</th>
              <th style="font-size: 12px" class="text-center">3rd FL</th>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px" class="text-center">Outside</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    :disabled="disableHangingWall3F()"
                    v-model="hangingWallOutside3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOutside5"
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Opening</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    :disabled="disableHangingWall3F()"
                    v-model="hangingWallOpening3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallOpening5"
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">HW</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    :disabled="disableHangingWall3F()"
                    v-model="hangingWallHW3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallHW5"
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
              </tr>
              <tr>
                <td style="font-size: 12px" class="text-center">Inside</td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    :disabled="disableHangingWall3F()"
                    v-model="hangingWallInside3"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
                </td>
                <td>
                  <input
                    @change="hangingWallComputation()"
                    v-model="hangingWallInside5"
                    :disabled="disableHangingWall3F()"
                    type="number"
                    class="form-control text-center"
                  />
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
                    v-model="finalTotalHangingWall3F"
                    :disabled="true"
                    style="font-size: 12px; font-weight: bold"
                    type="number"
                    class="form-control text-center"
                  />
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
                <th colspan="2" style="font-size: 12px" class="text-center">Pent House</th>
                <th>
                  <v-icon small @click="addPentHouseData" color="primary">mdi-plus-circle</v-icon>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data, index) in pentHouseData" :key="index">
                <td>
                  <input
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
                  <v-icon small @click="deletePentHouseData(index)" color="red"
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
                <td style="font-size: 12px; font-weight: bold" class="text-center">
                  {{ totalPentHouse }}
                </td>
              </tr>
            </tfoot>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px; width: 30%" class="text-center">Fukiage (+)</th>
                <th colspan="2">
                  <button
                    @click="toggleFukiageDialog()"
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
                  <v-icon small @click="deleteFukiageData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">Total:</td>
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
                <th style="font-size: 12px; width: 30%" class="text-center">Fukisage (-)</th>
                <th colspan="2">
                  <button
                    @click="toggleFukisageDialog()"
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
                  <v-icon small @click="deleteFukisageData(index)" color="red"
                    >mdi-close-circle</v-icon
                  >
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-size: 12px; font-weight: bold" class="text-center">Total:</td>
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
                    @click="toggleRoofDeductionDialog()"
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
                  <v-icon small @click="deleteRoofDeductionData(index)" color="red">mdi-close-circle</v-icon>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <td style="font-size: 12px; font-weight: bold" class="text-center">Total:</td>
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

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <table class="table-sm table-bordered">
            <thead>
              <th colspan="2" style="font-size: 12px" class="text-center">All Total Points</th>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px; font-weight: bold">Other Points Above</td>
                <td>
                  <input
                    v-model="totalAllPoints2"
                    class="form-control text-center"
                    style="font-size: 12px; font-weight: bold"
                    :disabled="true"
                  />
                </td>
              </tr>
              <td style="font-size: 12px; font-weight: bold">Other Points Below</td>
              <td>
                <input
                  v-model="totalAllPoints"
                  class="form-control text-center"
                  style="font-size: 12px; font-weight: bold"
                  :disabled="true"
                />
              </td>
              <tr></tr>
            </tbody>
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
          >Others + Fukiage
          <v-spacer></v-spacer>
          <v-btn @click="closeFukiageDialog()" icon dense>
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-divider></v-divider>
        <div class="px-5 pb-5">
          <button
            v-show="showTarekabe2"
            @click="toggleTarekabe2()"
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
            @click="toggleWholeTriangleDialog()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Whole Triangle
          </button>
          <button
            @click="toggleTrapezoid()"
            class="btn btn-sm btn-block btn btn-secondary"
            type="button"
          >
            Trapezoid
          </button>
          <button
            @click="toggleHalfTriangle()"
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
          <v-spacer></v-spacer>
          <v-btn icon dense>
            <v-icon small @click="tarekabeDialog = false" color="#00355e">mdi-close</v-icon>
          </v-btn>
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
            @click="tarekabe2Computation()"
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
              label="Height"
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
              label="Width"
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
            @click="rectangleComputation()"
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
              label="Height"
            ></v-text-field>

            <v-text-field
              @keyup.enter="wholeTriangleComputation()"
              v-model="wholeTriangleWidth"
              class="inputPrice"
              type="number"
              autofocus
              color="#00355e"
              style="font-size: 13px"
              dense
              outlined
              label="Width"
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
            @click="wholeTriangleComputation()"
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
              label="Height 1"
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
              label="Height 2"
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
              label="Width"
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
            @click="trapezoidComputation()"
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
              label="Height"
            />
            <!-- class="form-control text-center" -->

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
              label="Width"
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
            @click="halfTriangleComputation()"
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
import tarekabe from "./images/tarekabe2.jpg";
import tarekabe2 from "./images/tarekabe2.jpg";
import rectangle from "./images/rectangle.jpg";
import whole_triangle from "./images/whole_triangle.jpg";
import trapezoid from "./images/trapezoid.jpg";
import half_triangle from "./images/half_triangle.jpg";
import { mapState, mapActions } from "vuex";

export default {
  data() {
    return {
      outsideD2number: null,

      //DialogForFukiage&RoofDeduction
      identifier: { name: "" },
      roofDeductionData: [
        { total: null, computation: null },
      ],
      fukiageData: [
        { total: null, computation: null },
      ],
      fukisageData: [
        { total: null, computation: null },
      ],

      //Bands
      belowBands1: null,
      belowBands2: null,
      totalBands1: null,
      totalBands2: null,

      //tarekabe 2
      tarekabeWidth: null,

      //halfTriangle
      halfTriangleHeight: null,
      halfTrianglePitch: null,
      halfTriangleWidth: null,

      //trapezoid
      traperzoidHeight1: null,
      traperzoidHeight2: null,
      trapezoidWidth: null,
      trapezoidPitch: null,

      //wholeTriangle
      wholeTriangleHeight: null,
      wholeTriangleWidth: null,
      wholeTrianglePitch: null,

      // rectangleDialogTextfield
      rectangleHeight: null,
      rectangleWidth: null,
      rectanglePitch: null,

      //dialogForFukiage(+)
      halfTriangleDialog: false,
      trapezoidDialog: false,
      wholeTriangleDialog: false,
      rectangleDialog: false,
      tarekabeDialog: false,
      fukiageDialog: false,

      //images
      tarekabe2: tarekabe2,
      rectangle: rectangle,
      whole_triangle: whole_triangle,
      trapezoid: trapezoid,
      half_triangle: half_triangle,

      //Hanging Wall (2F House)
      //1
      hangingWallOutside1: null,
      hangingWallOpening1: null,
      hangingWallHW1: null,
      hangingWallInside1: null,

      tempHangingWallOutside1: null,
      tempHangingWallOpening1: null,
      tempHangingWallHW1: null,
      tempHangingWallInside1: null,

      //2
      hangingWallOutside2: null,
      hangingWallOpening2: null,
      hangingWallHW2: null,
      hangingWallInside2: null,

      tempHangingWallOutside2: null,
      tempHangingWallOpening2: null,
      tempHangingWallHW2: null,
      tempHangingWallInside2: null,

      //3
      hangingWallOutside3: null,
      hangingWallOpening3: null,
      hangingWallHW3: null,
      hangingWallInside3: null,

      tempHangingWallOutside3: null,
      tempHangingWallOpening3: null,
      tempHangingWallHW3: null,
      tempHangingWallInside3: null,

      //5
      hangingWallOutside5: null,
      hangingWallOpening5: null,
      hangingWallHW5: null,
      hangingWallInside5: null,

      tempHangingWallOutside5: null,
      tempHangingWallOpening5: null,
      tempHangingWallHW5: null,
      tempHangingWallInside5: null,

      //Whole Curved Tarekabe
      heightOfTarekabe: null,
      lengthOfTarekabe: null,
      outerPartOfDiameter: null,
      area: null,
      parabolic: null,

      //3FL House Perimeter (245)
      secondFloorHighWaist245: null,
      secondFloorLowWaist245: null,
      belowBalcony245: null,
      belowHwBB245: null,
      thirdFloor245: null,
      thirdFloorBelowBalcony245: null,

      tempSecondFloorHighWaist245: null,
      tempSecondFloorLowWaist245: null,
      tempBelowBalcony245: null,
      tempBelowHwBB245: null,
      tempThirdFloor245: null,
      tempThirdFloorBelowBalcony245: null,

      //2FL House Perimeter (265)
      secondFloorLowWaist265: null,
      secondFloorHighWaist265: null,
      tempSecondFloorLowWaist: null,
      tempSecondFloorHighWaist: null,

      //Partial Curved Tarekabe
      pie: 3.14,
      insideD1: null,
      outsideD2: null,
      tempOutsideD2: null,
      tempInsideD1: null,
      tempTotalCurvedTarekabe: null,

      //Pent House
      pentHouseData: [
        { value: null, total: null },
      ],

      //Sashes
      sashesData: [
        {
          sashWidth: null,
          sashHeight: null,
          sashWidthValue: null,
          sashHeightValue: null,
          total: null,
          tempTotal: null,
        }
      ],
      widthObj: {},
      heightObj: {},
      sashWidth: null,
      overlay: false
    }
  },

  methods: {

    heightOfTarekabeComputation() {
      var input = document.getElementById("heightOfTarekabe").value;
      var [d, e] = input.split("-");
      document.getElementById("heightOfTarekabe").value = parseFloat(d) - parseFloat(e);
      this.heightOfTarekabe = document.getElementById("heightOfTarekabe").value;
      this.heightOfTarekabe = Math.round(this.heightOfTarekabe * 1000) / 1000;
      if (this.heightOfTarekabe == "NaN") {
        this.heightOfTarekabe = null;
      }
    },

    lengthOfTarekabeComputation() {
      var input1 = document.getElementById("lengthOfTarekabe").value;
      var [a, b, c] = input1.split(/[+,*]/);
      document.getElementById("lengthOfTarekabe").value =
        parseFloat(a) * parseFloat(b) + parseFloat(c);
      this.lengthOfTarekabe = document.getElementById("lengthOfTarekabe").value;
      this.lengthOfTarekabe = Math.trunc(this.lengthOfTarekabe * 1000) / 1000;
      if (this.lengthOfTarekabe == "NaN") {
        this.lengthOfTarekabe = null;
      }
    },

    outerPartOfDiameterComputation() {
      var input2 = document.getElementById("outerPartOfDiameter").value;
      var [f, e] = input2.split("*");
      document.getElementById("outerPartOfDiameter").value =
        parseFloat(f) * parseFloat(e);
      this.outerPartOfDiameter = document.getElementById("outerPartOfDiameter").value;
      if (this.outerPartOfDiameter == "NaN") {
        this.outerPartOfDiameter = null;
      }
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

    toggleRectangleDialog() {
      this.rectangleDialog = true;
      this.rectangleHeight = null;
      this.rectangleWidth = null;
      this.rectanglePitch = null;
    },

    toggleTarekabe2() {
      this.tarekabeDialog = true;
      this.tarekabeWidth = null;
    },

    toggleWholeTriangleDialog() {
      this.wholeTriangleDialog = true;
      this.wholeTriangleWidth = null;
      this.wholeTriangleHeight = null;
      this.wholeTrianglePitch = null;
    },

    toggleTrapezoid() {
      this.trapezoidDialog = true;
      this.traperzoidHeight1 = null;
      this.traperzoidHeight2 = null;
      this.trapezoidWidth = null;
      this.trapezoidPitch = null;
    },

    toggleHalfTriangle() {
      this.halfTriangleDialog = true;
      this.halfTriangleHeight = null;
      this.halfTrianglePitch = null;
      this.halfTriangleWidth = null;
    },

    deleteRoofDeductionData(index) {
      this.roofDeductionData.splice(index, 1);
    },

    deleteFukiageData(index) {
      this.fukiageData.splice(index, 1);
    },

    deleteFukisageData(index) {
      this.fukisageData.splice(index, 1);
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

    //endOfToggleRoofDeductionDialog
    bandsComputation() {
      if (this.belowBands1 != null) {
        this.totalBands1 = this.belowBands1 * 0.91 * 3.9;
      }
      if (this.belowBands2 != null) {
        this.totalBands2 = this.belowBands2 * 0.91 * 3.7;
      }
    },

    tarekabe2Computation() {
      if (this.identifier.name == "Fukiage") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if (this.$store.getters.getShioData.kanabakari == "265") {
            let outside = 1.1;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.fukiageData[this.fukiageData.length - 1].total = total;
            this.fukiageData[this.fukiageData.length - 1].computation = "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          } else if (this.$store.getters.getShioData.kanabakari == "240") {
            let outside = 1.175;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.fukiageData[this.fukiageData.length - 1].total = total;
            this.fukiageData[this.fukiageData.length - 1].computation = "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          }
        }
      } else if (this.identifier.name == "Roof Deduction") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if (this.$store.getters.getShioData.kanabakari == "265") {
            let outside = 1.1;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
            this.roofDeductionData[this.roofDeductionData.length - 1].computation =
              "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          } else if (this.$store.getters.getShioData.kanabakari == "240") {
            let outside = 1.175;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
            this.roofDeductionData[this.roofDeductionData.length - 1].computation =
              "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          }
        }
      } else if (this.identifier.name == "Fukisage") {
        if (this.tarekabeWidth == null) {
          this.nullWidth();
        } else {
          if (this.$store.getters.getShioData.kanabakari == "265") {
            let outside = 1.1;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.fukisageData[this.fukisageData.length - 1].total =
              Math.trunc(total * 1000) / 1000;
            this.fukisageData[this.fukisageData.length - 1].computation = "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          } else if (this.$store.getters.getShioData.kanabakari == "240") {
            let outside = 1.175;
            let inside = 0.268;
            let total = 0;
            let total1 = 0;
            let total2 = 0;
            total1 = this.tarekabeWidth * outside;
            total2 = this.tarekabeWidth * inside;
            total = total1 + total2;
            this.fukisageData[this.fukisageData.length - 1].total =
              Math.trunc(total * 1000) / 1000;
            this.fukisageData[this.fukisageData.length - 1].computation = "Tarekabe 2";
            this.fukiageDialog = false;
            this.tarekabeDialog = false;
          }
        }
      }
    },
    //endOfTarekabe2Computation

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
          total =
            (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) /
            2;
          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Half Triangle";
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;
        } else if (this.identifier.name == "Roof Deduction") {
          let total = 0;
          total =
            (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) /
            2;
          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation =
            "Half Triangle";
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;
        } else if (this.identifier.name == "Fukisage") {
          let total = 0;
          total =
            (this.halfTriangleHeight * this.halfTriangleWidth * this.halfTrianglePitch) /
            2;
          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Half Triangle";
          this.fukiageDialog = false;
          this.halfTriangleDialog = false;
        }
      }
    },

    trapezoidHeight1Computation() {
      if (this.traperzoidHeight2 != null && this.trapezoidWidth != null) {
        this.traperzoidHeight1 = +this.traperzoidHeight2 + +this.trapezoidWidth;
      } else {
        return false;
      }
    },
    //endOfTrapezoidHeight1Computation

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
          let total =
            ((+this.traperzoidHeight1 + +this.traperzoidHeight2) *
              this.trapezoidWidth *
              this.trapezoidPitch) /
            2;
          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Trapezoid";
          this.trapezoidDialog = false;
          this.fukiageDialog = false;
        } else if (this.identifier.name == "Roof Deduction") {
          let total =
            ((+this.traperzoidHeight1 + +this.traperzoidHeight2) *
              this.trapezoidWidth *
              this.trapezoidPitch) /
            2;
          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation =
            "Trapezoid";
          this.trapezoidDialog = false;
          this.fukiageDialog = false;
        } else if (this.identifier.name == "Fukisage") {
          let total =
            ((+this.traperzoidHeight1 + +this.traperzoidHeight2) *
              this.trapezoidWidth *
              this.trapezoidPitch) /
            2;
          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Trapezoid";
          this.trapezoidDialog = false;
          this.fukiageDialog = false;
        }
      }
    },
    //endOfTrapezoidComputation

    wholeTriangleComputation() {
      if (this.wholeTriangleHeight == null || this.wholeTriangleHeight == "") {
        this.nullHeight();
      } else if (this.wholeTriangleWidth == null || this.wholeTriangleWidth == "") {
        this.nullWidth();
      } else if (this.wholeTrianglePitch == null || this.wholeTrianglePitch == "") {
        this.nullPitch();
      } else {
        if (this.identifier.name == "Fukiage") {
          let total =
            (this.wholeTriangleHeight *
              this.wholeTriangleWidth *
              this.wholeTrianglePitch) /
            4;
          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Whole Triangle";
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;
        } else if (this.identifier.name == "Roof Deduction") {
          let total =
            (this.wholeTriangleHeight *
              this.wholeTriangleWidth *
              this.wholeTrianglePitch) /
            4;
          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation =
            "Whole Triangle";
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;
        } else if (this.identifier.name == "Fukisage") {
          let total =
            (this.wholeTriangleHeight *
              this.wholeTriangleWidth *
              this.wholeTrianglePitch) /
            4;
          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Whole Triangle";
          this.fukiageDialog = false;
          this.wholeTriangleDialog = false;
        }
      }
    },
    //endOfWholeTriangleComputation

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
          total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          this.fukiageData[this.fukiageData.length - 1].total = total;
          this.fukiageData[this.fukiageData.length - 1].computation = "Rectangle";
          this.rectangleDialog = false;
          this.fukiageDialog = false;
        } else if (this.identifier.name == "Roof Deduction") {
          let total = 0;
          total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          this.roofDeductionData[this.roofDeductionData.length - 1].total = total;
          this.roofDeductionData[this.roofDeductionData.length - 1].computation =
            "Rectangle";
          this.rectangleDialog = false;
          this.fukiageDialog = false;
        } else if (this.identifier.name == "Fukisage") {
          let total = 0;
          total = this.rectangleHeight * this.rectangleWidth * this.rectanglePitch;
          this.fukisageData[this.fukisageData.length - 1].total = total;
          this.fukisageData[this.fukisageData.length - 1].computation = "Rectangle";
          this.rectangleDialog = false;
          this.fukiageDialog = false;
        }
      }
    },
    //endOfRectangleComputation

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
    //endOfToggleFukiageDialog

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
        } else if (this.roofDeductionData.length > 1) {
          if (this.roofDeductionData[this.roofDeductionData.length - 1].total == null) {
            this.roofDeductionData.pop();
          }
          this.fukiageDialog = false;
        }
      } else if (this.identifier.name == "Fukisage") {
        if (this.fukisageData.length == 1) {
          this.fukiageDialog = false;
        } else if (this.fukisageData.length > 1) {
          if (this.fukisageData[this.fukisageData.length - 1].total == null) {
            this.fukisageData.pop();
            this.fukiageDialog = false;
          }
        }
      }
    },
    //endCloseFukiageDialog

    disableHangingWall3F() {
      if (this.$store.getters.getShioData.kanabakari == "265") {
        return true;
      } else if (this.$store.getters.getShioData.kanabakari == "") {
        return false;
      } else {
        return false;
      }
    },
    //endOfDisableHangingWall3F

    disableHangingWall2F() {
      if (this.$store.getters.getShioData.kanabakari == "240") {
        return true;
      } else if (this.$store.getters.getShioData.kanabakari == "") {
        return false;
      } else {
        return false;
      }
    },
    //endOfDisableHangingWall2F

    hangingWallComputation() {
      if (this.hangingWallOutside1 != null) {
        this.tempHangingWallOutside1 = this.hangingWallOutside1 * 2.82;
      }
      if (this.hangingWallOpening1 != null) {
        this.tempHangingWallOpening1 = this.hangingWallOpening1 * 2.3;
      }
      if (this.hangingWallHW1 != null) {
        this.tempHangingWallHW1 = this.hangingWallHW1 * 0.268;
      }
      if (this.hangingWallInside1 != null) {
        this.tempHangingWallInside1 = this.hangingWallInside1 * 2.73;
      }

      //2
      if (this.hangingWallOutside2 != null) {
        this.tempHangingWallOutside2 = this.hangingWallOutside2 * 2.82;
      }
      if (this.hangingWallOpening2 != null) {
        this.tempHangingWallOpening2 = this.hangingWallOpening2 * 2.3;
      }
      if (this.hangingWallHW2 != null) {
        this.tempHangingWallHW2 = this.hangingWallHW2 * 0.268;
      }
      if (this.hangingWallInside2 != null) {
        this.tempHangingWallInside2 = this.hangingWallInside2 * 2.73;
      }

      //3
      if (this.hangingWallOutside3 != null) {
        this.tempHangingWallOutside3 = this.hangingWallOutside3 * 2.82;
      }
      if (this.hangingWallOpening3 != null) {
        this.tempHangingWallOpening3 = this.hangingWallOpening3 * 2.3;
      }
      if (this.hangingWallHW3 != null) {
        this.tempHangingWallHW3 = this.hangingWallHW3 * 0.268;
      }
      if (this.hangingWallInside3 != null) {
        this.tempHangingWallInside3 = this.hangingWallInside3 * 2.73;
      }

      //5
      if (this.hangingWallOutside5 != null) {
        this.tempHangingWallOutside5 = this.hangingWallOutside5 * 2.55;
      }
      if (this.hangingWallOpening5 != null) {
        this.tempHangingWallOpening5 = this.hangingWallOpening5 * 2.3;
      }
      if (this.hangingWallHW5 != null) {
        this.tempHangingWallHW5 = this.hangingWallHW5 * 0.268;
      }
      if (this.hangingWallInside5 != null) {
        this.tempHangingWallInside5 = this.hangingWallInside5 * 2.385;
      }
    },
    //endOfHangingWallComputation

    //endOfWholeCurvedTarekabeComputation

    thirdFloorHousePerimeterComputation() {
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
    },
    //endOfThirdFloorHousePerimeterComputation

    secondFloorHousePerimeterComputation() {
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
    },
    //endOfSecondFloorHousePerimeterComputation

    partialCurvedComputation() {
      if (this.outsideD2 != null) {
        this.tempOutsideD2 = this.outsideD2 * this.outsideD2;
      }
      if (this.insideD1 != null) {
        this.tempInsideD1 = this.insideD1 * this.insideD1;
      }
    },
    //endOfPartialCurvedComputation

    deletePentHouseData(index) {
      this.pentHouseData.splice(index, 1);
    },
    //endOfDeletePentHouseData

    addPentHouseData() {
      let row = {
        value: null,
        total: null,
      };
      if (this.pentHouseData.length == 0) {
        this.pentHouseData.push(row);
      } else if (this.pentHouseData[this.pentHouseData.length - 1].total != null) {
        this.pentHouseData.push(row);
      }
    },
    //endOfPentHouseData

    pentHouseComputation(data) {
      if (data.value != null) {
        data.total = data.value * 2;
        if (data.total != null) {
          let row = {
            value: null,
            total: null,
          };
          this.pentHouseData.push(row);
        }
      }
    },
    //endOfPentHouseComputation

    deleteSashData(index) {
      this.sashesData.splice(index, 1);
    },
    //endofDeleteSashData

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
      } else if (this.sashesData[this.sashesData.length - 1].total != null) {
        this.sashesData.push(row);
      }
    },
    //endOfAddSashData

    sashesComputation(data) {
      let arrSashWidthValue = this.$store.getters.getSashSize.filter((r) => {
        return r.width == data.sashWidth;
      });

      let arrSashHeightValue = this.$store.getters.getSashSize.filter((r) => {
        return r.height == data.sashHeight;
      });

      if (arrSashWidthValue.length > 0) {
        this.widthObj = Object.assign({}, arrSashWidthValue[0]);
        data.sashWidthValue = this.widthObj.widthValue;
      } else {
        data.sashWidthValue = 0;
      }

      if (arrSashHeightValue.length > 0) {
        this.heightObj = Object.assign({}, arrSashHeightValue[0]);
        data.sashHeightValue = this.heightObj.heightValue;
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

      if (
        this.sashesData[this.sashesData.length - 1].total != 0 &&
        this.sashesData[this.sashesData.length - 1].total != null
      ) {
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
    //endOfSashesComputation
    ...mapActions(["SashSizeDataPage"]),
  },
  //endOfMethods

  computed: {
    totalBands() {
      let total = this.totalBands1 + +this.totalBands2;
      return Math.floor(total * 1000) / 1000;
    },

    showTarekabe2() {
      if (this.identifier.name == "Roof Deduction") {
        return false;
      } else {
        return true;
      }
    },

    showTable() {
      if (this.$store.getters.getShioData.kanabakari == "265") {
        return true;
      } else {
        return false;
      }
    },

    showTable2() {
      if (this.$store.getters.getShioData.kanabakari == "240") {
        return true;
      } else {
        return false;
      }
    },

    totalAllPoints() {
      let total = 0;
      total =
        this.totalPartialCurved +
        +this.totalSecondHousePerimeter +
        +this.finalTotalHangingWall2F +
        +this.finalTotalHangingWall3F +
        +this.totalThirdHousePerimeter +
        +this.totalWholeCurvedTarekabe +
        +this.totalSash +
        +this.totalPentHouse +
        +this.totalFukiage +
        -this.totalFukisage +
        +this.totalRoofDeduction;
      return Math.floor(total * 1000) / 1000;
    },

    totalAllPoints2() {
      let total =
        this.totalPartialCurved +
        +this.totalSecondHousePerimeter +
        +this.finalTotalHangingWall2F +
        +this.finalTotalHangingWall3F +
        +this.totalThirdHousePerimeter +
        +this.totalWholeCurvedTarekabe +
        +this.totalSash +
        +this.totalPentHouse +
        +this.totalFukiage +
        -this.totalFukisage +
        +this.totalRoofDeduction;
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

    total3FHangingWall1() {
      let total =
        this.tempHangingWallOutside5 -
        this.tempHangingWallOpening5 +
        +this.tempHangingWallHW5 +
        +this.tempHangingWallInside5;
      return Math.round(total * 1000) / 1000;
    },

    total3FHangingWall2() {
      let total =
        this.tempHangingWallOutside3 -
        this.tempHangingWallOpening3 +
        +this.tempHangingWallHW3 +
        +this.hangingWallInside3;
      return Math.round(total * 1000) / 1000;
    },

    finalTotalHangingWall3F() {
      let total = this.total3FHangingWall1 + +this.total3FHangingWall2;
      return Math.trunc(total * 1000) / 1000;
    },

    total2FHangingWall1() {
      let total = 0;
      total =
        this.tempHangingWallOutside1 -
        this.tempHangingWallOpening1 +
        +this.tempHangingWallHW1 +
        +this.tempHangingWallInside1;

      return total;
    },

    total2FHangingWall2() {
      let total = 0;
      total =
        this.tempHangingWallOutside2 -
        this.tempHangingWallOpening2 +
        +this.tempHangingWallHW2 +
        +this.tempHangingWallInside2;
      return total;
    },

    finalTotalHangingWall2F() {
      let total = 0;
      total = this.total2FHangingWall1 + this.total2FHangingWall2;
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalWholeCurvedTarekabe() {
      this.area = this.heightOfTarekabe * this.lengthOfTarekabe;
      this.parabolic = (2 * (this.lengthOfTarekabe * 0.3095)) / 3;

      let total = 0;
      total = this.area - this.parabolic;
      return (total = Math.trunc(total * 1000) / 1000);
    },

    totalThirdHousePerimeter() {
      let total = 0;
      total =
        this.tempSecondFloorHighWaist245 +
        +this.tempSecondFloorLowWaist245 +
        +this.tempBelowBalcony245 +
        +this.tempBelowHwBB245 +
        +this.tempThirdFloor245 +
        +this.tempThirdFloorBelowBalcony245;
      return (total = Math.trunc(total * 1000) / 1000);
    },

    //endOfTotalThirdHousePerimeter
    totalSecondHousePerimeter() {
      let total = 0;
      total = this.tempSecondFloorLowWaist + +this.tempSecondFloorHighWaist;
      return (total = Math.trunc(total * 1000) / 1000);
    },

    //endOfTotalSecondHousePerimeter
    totalPartialCurved() {
      let total = 0;
      total = (this.pie * (this.tempOutsideD2 - this.tempInsideD1)) / 8;
      return (total = Math.trunc(total * 1000) / 1000);
    },

    //endOfTotalPartialCurved
    totalSash() {
      let total = 0;
      this.sashesData.filter((rec) => {
        total += rec.total;
      });
      return (total = Math.trunc(total * 1000) / 1000);
    },

    //endTotalSash
    totalPentHouse() {
      let total = 0;
      this.pentHouseData.filter((rec) => {
        total += rec.total;
      });
      return total;
    }
  }
  //endOfComputed
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
