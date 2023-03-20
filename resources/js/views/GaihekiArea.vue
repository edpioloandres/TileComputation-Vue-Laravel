<template>
  <div>
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

    <span style="display: none;">{{ totalOption }} {{ totalService }}</span>
    <span style="display: none;">{{ doorDataSummary }}</span>
    <span style="display: none;">{{ sashDataSummary }}</span>

    <v-row>
      <v-col cols="8">
        <!-- <v-btn ripple class="ml-5 mt-5" dark color="#3ab792" @click="saveGaihekiData()">Save</v-btn> -->
      </v-col>
      <v-col cols="4">
        <v-card elevation="1" class="pa-2 ma-5">
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
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <v-row style="margin-bottom: -50px;">
      <v-col cols="4">
        <v-card flat tile style="background-color: transparent;">
          <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px;">Gaiheki Area</v-card-title>
        </v-card>
      </v-col>

      <v-col cols="5">
        <v-card flat tile style="background-color: transparent;">
          <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px;">Sashes</v-card-title>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card flat tile style="background-color: transparent;">
          <v-card-title style="font-weight: bold; color: #00355e; font-size: 15px;">Entrance</v-card-title>
        </v-card>
      </v-col>
    </v-row>

    <!--------------------------------- EAST SIDE------------------------------------->
    <v-row class="mx-2">
      <!-- Gaiheki -->
      <v-col cols="4">
        <v-checkbox :disabled="disableBox" v-model="gaihekiAreaData[0].serviceCheck" @change="checkArr(gaihekiAreaData[0])" color="#00355e" style="width: 100px;" hide-details>
          <template v-slot:label>
            <span id="checkboxLabel">East Side</span>
          </template>
        </v-checkbox>

        <v-card elevation="1" class="my-4">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Height
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Grid
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Meter
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Points
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">High Waist</td>
                    <td><input :disabled="disableHighWaist" onwheel="return false;" @blur="computeEastPoints()" v-model="gaihekiAreaData[0].HWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[0].HWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[0].HWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Low Waist</td>
                    <td><input onwheel="return false;" @keyup="computeEastPoints()" v-model="gaihekiAreaData[0].LWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[0].LWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[0].LWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Others</td>
                    <td colspan="2">
                      <button @click="stcSummaryDialog = true, direction = 'east', STCsummaryData = gaihekiAreaData[0].STCsummaryData" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">STC</button>
                    </td>
                    <td><input id="stctotal" v-model="gaihekiAreaData[0].totalSTC" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                    <td colspan="2">
                      <input style="display: none;" v-model="gaihekiAreaData[0].totalPoint" disabled type="number" class="form-control text-center">
                      <input v-model="gaihekiAreaData[0].finalPoint" disabled type="number" class="form-control text-center">
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Sash -->
      <v-col cols="5">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addEastSashRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in eastSashData" :key="index">
                    <td><input onwheel="return false;" @blur="getEastSash(data), validateSashInput(data)" v-model="data.width" type="number" class="form-control text-center"></td>
                    <td><input onwheel="return false;" @blur="getEastSash(data), validateSashInput(data)" v-model="data.height" type="number" class="form-control text-center"></td>
                    <td>
                      <select @change="getEastSash(data)" v-model="data.withAmado" class="custom-select" style="width:100px">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </td>
                    <td>
                      <select @change="getEastSash(data)" v-model="data.inclusion" class="custom-select" style="width:100px">
                        <option value="Full">Full</option>
                        <option value="Half">Half</option>
                      </select>
                    </td>
                    <td><input v-model="data.sashPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteEastSashRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ eastSash }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Entrance -->
      <v-col cols="3">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addEastDoorRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in eastDoorData" :key="index">
                    <td>
                      <select v-model="data.doorType" @change="getEastDoor(data)" id="selectedDoorEast" class="custom-select" style="width:100px">
                        <option value="0"></option>
                        <option value="1.54">Door 3.0</option>
                        <option value="2.64">Door 4.5</option>
                        <option value="3.74">Door 6.0</option>
                        <option value="5.28">Door 9.0</option>
                      </select>
                    </td>
                    <td><input :disabled="data.doorType == '0'" onwheel="return false;" @blur="computeEastDoor(), validateDoorInput(data)" @keyup="getEastDoor(data)" v-model="data.doorQty" type="number" class="form-control text-center"></td>
                    <td><input v-model="data.doorPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteEastDoorRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ eastDoor }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <!--------------------------------- SOUTH SIDE------------------------------------->
    <v-row class="mx-2">
      <!-- Gaiheki -->
      <v-col cols="4">
        <v-checkbox :disabled="disableBox" v-model="gaihekiAreaData[1].serviceCheck" @change="checkArr(gaihekiAreaData[1])" color="#00355e" style="width: 100px;" hide-details>
          <template v-slot:label>
            <span id="checkboxLabel">South Side</span>
          </template>
        </v-checkbox>

        <v-card elevation="1" class="mr-3 my-4">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Height
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Grid
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Meter
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Points
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">High Waist</td>
                    <td><input :disabled="disableHighWaist" onwheel="return false;" @blur="computeSouthPoints()" v-model="gaihekiAreaData[1].HWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[1].HWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[1].HWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Low Waist</td>
                    <td><input onwheel="return false;" @blur="computeSouthPoints()" v-model="gaihekiAreaData[1].LWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[1].LWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[1].LWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Others</td>
                    <td colspan="2">
                      <button @click="stcSummaryDialog = true, direction = 'south', STCsummaryData = gaihekiAreaData[1].STCsummaryData" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">STC</button>
                    </td>
                    <td><input v-model="gaihekiAreaData[1].totalSTC" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                    <td colspan="2">
                      <input style="display: none;" v-model="gaihekiAreaData[1].totalPoint" disabled type="number" class="form-control text-center">
                      <input v-model="gaihekiAreaData[1].finalPoint" disabled type="number" class="form-control text-center">
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Sash -->
      <v-col cols="5">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addSouthSashRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in southSashData" :key="index">
                    <td><input onwheel="return false;" @blur="getSouthSash(data), validateSashInput(data)" v-model="data.width" type="number" class="form-control text-center"></td>
                    <td><input onwheel="return false;" @blur="getSouthSash(data), validateSashInput(data)" v-model="data.height" type="number" class="form-control text-center"></td>
                    <td>
                      <select @change="getSouthSash(data)" v-model="data.withAmado" class="custom-select" style="width:100px">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </td>
                    <td>
                      <select @change="getSouthSash(data)" v-model="data.inclusion" class="custom-select" style="width:100px">
                        <option value="Full">Full</option>
                        <option value="Half">Half</option>
                      </select>
                    </td>
                    <td><input v-model="data.sashPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteSouthSashRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ southSash }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Entrance -->
      <v-col cols="3">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addSouthDoorRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in southDoorData" :key="index">
                    <td>
                      <select v-model="data.doorType" @change="getSouthDoor(data)" id="selectedDoorSouth" class="custom-select" style="width:100px">
                        <option value="0"></option>
                        <option value="1.54">Door 3.0</option>
                        <option value="2.64">Door 4.5</option>
                        <option value="3.74">Door 6.0</option>
                        <option value="5.28">Door 9.0</option>
                      </select>
                    </td>
                    <td><input :disabled="data.doorType == '0'" onwheel="return false;" @blur="computeSouthDoor(), validateDoorInput(data)" @keyup="getSouthDoor(data)" v-model="data.doorQty" type="number" class="form-control text-center"></td>
                    <td><input v-model="data.doorPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteSouthDoorRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ southDoor }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <!--------------------------------- WEST SIDE------------------------------------->
    <v-row class="mx-2">
      <!-- Gaiheki -->
      <v-col cols="4">
        <v-checkbox :disabled="disableBox" v-model="gaihekiAreaData[2].serviceCheck" @change="checkArr(gaihekiAreaData[2])" color="#00355e" style="width: 100px;" hide-details>
          <template v-slot:label>
            <span id="checkboxLabel">West Side</span>
          </template>
        </v-checkbox>

        <v-card elevation="1" class="mr-3 my-4">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Height
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Grid
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Meter
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Points
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">High Waist</td>
                    <td><input :disabled="disableHighWaist" onwheel="return false;" @blur="computeWestPoints()" v-model="gaihekiAreaData[2].HWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[2].HWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[2].HWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Low Waist</td>
                    <td><input onwheel="return false;" @blur="computeWestPoints()" v-model="gaihekiAreaData[2].LWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[2].LWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[2].LWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Others</td>
                    <td colspan="2">
                      <button @click="stcSummaryDialog = true, direction = 'west', STCsummaryData = gaihekiAreaData[2].STCsummaryData" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">STC</button>
                    </td>
                    <td><input v-model="gaihekiAreaData[2].totalSTC" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                    <td colspan="2">
                      <input style="display: none;" v-model="gaihekiAreaData[2].totalPoint" disabled type="number" class="form-control text-center">
                      <input v-model="gaihekiAreaData[2].finalPoint" disabled type="number" class="form-control text-center">
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Sash -->
      <v-col cols="5">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addWestSashRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in westSashData" :key="index">
                    <td><input onwheel="return false;" @blur="getWestSash(data), validateSashInput(data)" v-model="data.width" type="number" class="form-control text-center"></td>
                    <td><input onwheel="return false;" @blur="getWestSash(data), validateSashInput(data)" v-model="data.height" type="number" class="form-control text-center"></td>
                    <td>
                      <select @change="getWestSash(data)" v-model="data.withAmado" class="custom-select" style="width:100px">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </td>
                    <td>
                      <select @change="getWestSash(data)" v-model="data.inclusion" class="custom-select" style="width:100px">
                        <option value="Full">Full</option>
                        <option value="Half">Half</option>
                      </select>
                    </td>
                    <td><input v-model="data.sashPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteWestSashRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ westSash }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Entrance -->
      <v-col cols="3">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addWestDoorRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in westDoorData" :key="index">
                    <td>
                      <select v-model="data.doorType" @change="getWestDoor(data)" id="selectedDoorWest" class="custom-select" style="width:100px">
                        <option value="0"></option>
                        <option value="1.54">Door 3.0</option>
                        <option value="2.64">Door 4.5</option>
                        <option value="3.74">Door 6.0</option>
                        <option value="5.28">Door 9.0</option>
                      </select>
                    </td>
                    <td><input :disabled="data.doorType == '0'" onwheel="return false;" @blur="computeWestDoor(), validateDoorInput(data)" @keyup="getWestDoor(data)" v-model="data.doorQty" type="number" class="form-control text-center"></td>
                    <td><input v-model="data.doorPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteWestDoorRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ westDoor }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <v-divider></v-divider>

    <!--------------------------------- NORTH SIDE------------------------------------->
    <v-row class="pb-8 mx-2">
      <!-- Gaiheki -->
      <v-col cols="4">
        <v-checkbox :disabled="disableBox" v-model="gaihekiAreaData[3].serviceCheck" @change="checkArr(gaihekiAreaData[3])" color="#00355e" style="width: 100px;" hide-details>
          <template v-slot:label>
            <span id="checkboxLabel">North Side</span>
          </template>
        </v-checkbox>

        <v-card elevation="1" class="mr-3 my-4">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
                <thead>
                  <tr>
                    <th style="font-size: 12px;" class="text-center">
                      Height
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Grid
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Meter
                    </th>
                    <th style="font-size: 12px;" class="text-center">
                      Points
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">High Waist</td>
                    <td><input :disabled="disableHighWaist" onwheel="return false;" @blur="computeNorthPoints()" v-model="gaihekiAreaData[3].HWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[3].HWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[3].HWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Low Waist</td>
                    <td><input onwheel="return false;" @blur="computeNorthPoints()" v-model="gaihekiAreaData[3].LWgrid" type="number" class="form-control text-center"></td>
                    <td><input disabled :value="gaihekiAreaData[3].LWgrid * 0.91" type="number" class="form-control text-center"></td>
                    <td><input v-model="gaihekiAreaData[3].LWpoint" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 12px;" class="text-center">Others</td>
                    <td colspan="2">
                      <button @click="stcSummaryDialog = true, direction = 'north', STCsummaryData = gaihekiAreaData[3].STCsummaryData" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">STC</button>
                    </td>
                    <td><input v-model="gaihekiAreaData[3].totalSTC" disabled type="number" class="form-control text-center"></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total Points =</td>
                    <td colspan="2">
                      <input style="display: none;" v-model="gaihekiAreaData[3].totalPoint" disabled type="number" class="form-control text-center">
                      <input v-model="gaihekiAreaData[3].finalPoint" disabled type="number" class="form-control text-center">
                    </td>
                  </tr>
                </tbody>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Sash -->
      <v-col cols="5">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addNorthSashRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in northSashData" :key="index">
                    <td><input onwheel="return false;" @blur="getNorthSash(data), validateSashInput(data)" v-model="data.width" type="number" class="form-control text-center"></td>
                    <td><input onwheel="return false;" @blur="getNorthSash(data), validateSashInput(data)" v-model="data.height" type="number" class="form-control text-center"></td>
                    <td>
                      <select @change="getNorthSash(data)" v-model="data.withAmado" class="custom-select" style="width:100px">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </td>
                    <td>
                      <select @change="getNorthSash(data)" v-model="data.inclusion" class="custom-select" style="width:100px">
                        <option value="Full">Full</option>
                        <option value="Half">Half</option>
                      </select>
                    </td>
                    <td><input v-model="data.sashPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteNorthSashRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ northSash }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <!-- Entrance -->
      <v-col cols="3">
        <v-card elevation="1" style="margin-top: 75px;">
          <v-row class="pl-3 pr-3">
            <v-col cols="12">
              <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
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
                    <th>
                      <v-icon small color="primary" @click="addNorthDoorRow()">mdi-plus-circle</v-icon>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in northDoorData" :key="index">
                    <td>
                      <select v-model="data.doorType" @change="getNorthDoor(data)" id="selectedDoorNorth" class="custom-select" style="width:100px">
                        <option value="0"></option>
                        <option value="1.54">Door 3.0</option>
                        <option value="2.64">Door 4.5</option>
                        <option value="3.74">Door 6.0</option>
                        <option value="5.28">Door 9.0</option>
                      </select>
                    </td>
                    <td><input :disabled="data.doorType == '0'" onwheel="return false;" @blur="computeNorthDoor(), validateDoorInput(data)" @keyup="getNorthDoor(data)" v-model="data.doorQty" type="number" class="form-control text-center"></td>
                    <td><input v-model="data.doorPoint" disabled type="number" class="form-control text-center"></td>
                    <td>
                      <v-icon tabindex="-1" small color="red" @click="deleteNorthDoorRow(index)">mdi-close-circle</v-icon>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" style="font-size: 12px;" class="text-center">Total</td>
                    <td style="font-size: 13px; color: #00355e;" class="text-center">{{ northDoor }}</td>
                  </tr>
                </tfoot>
              </table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <!------------------------------------------------------ FUKISAGE ------------------------------------------------------------->
    <v-dialog
      v-model="stcSummaryDialog"
      max-width="500px"
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
        >Special Type of Computation
        <v-spacer></v-spacer>
          <v-btn
            icon
            dense
            @click="stcSummaryDialog = false"
          >
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-divider></v-divider>
        <v-row class="pt-1 pl-6" style="width: 500px;">
          <v-col cols="12">
            <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
              <thead>
                <tr>
                  <th style="font-size: 12px; width: 60%;" class="text-center">
                    Type
                  </th>
                  <th style="font-size: 12px; width: 40%;" class="text-center">
                    Points
                  </th>
                  <th>
                    <v-icon small color="primary" @click="stcSummaryDialog = false, stcDialog = true, imgstc = above_demado">mdi-plus-circle</v-icon>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data, index) in STCsummaryData" :key="index">
                  <td>
                    <input readonly v-model="data.compType" type="text" class="form-control text-center">
                  </td>
                  <td>
                    <input v-model="data.compPoints" disabled type="number" class="form-control text-center">
                  </td>
                  <td>
                    <v-icon small @click="deleteSTCColumn(data)" color="red">mdi-close-circle</v-icon>
                  </td>
                </tr>
              </tbody>
            </table>
          </v-col>
        </v-row>

        <v-card-actions class="mt-3">
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="stcDialog"
      max-width="500px"
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
        >Special Type of Computations
        <v-spacer></v-spacer>
          <v-btn
            icon
            dense
            @click="stcDialog = false, stcSummaryDialog = true"
          >
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-divider></v-divider>
        <v-row class="pt-3 pb-3 pr-3 pl-6" style="width: 500px;">
          <v-col cols="5">
            <button v-show="showSTC" style="display: block;" @click="unitDemadoDialog = true, stcDialog = false, imgdemado = bay_window75, imgstc = above_demado" class="btn btn-sm btn-block btn btn-secondary" type="button">Above Unit Demado</button>
            <button v-show="showSTC" style="display: block;" @click="roofTypeDialog = true, stcDialog = false, imgstc = excess_bricks" class="btn btn-sm btn-block btn btn-secondary" type="button">Excess Bricks</button>
            <button v-show="this.shioData.houseType == 'グラン･セゾン(GRAND SAISON)' || this.shioData.ihead == 'No'" style="display: block;" @click="fukiage1fDialog = true, stcDialog = false, imgstc = fukiage1f" class="btn btn-sm btn-block btn btn-secondary" type="button">First Floor Fukiage</button>
            <button v-show="showSTC" style="display: block;" @click="tarekabe1Dialog = true, stcDialog = false, imgstc = tarekabe1" class="btn btn-sm btn-block btn btn-secondary" type="button">Tarekabe 1</button>
            <button v-show="showTarekabe2" style="display: block;" @click="tarekabe2Dialog = true, stcDialog = false, imgstc = tarekabe2" class="btn btn-sm btn-block btn btn-secondary" type="button">Tarekabe 2</button>
            <button style="display: block;" @click="openRoofDialog = true, stcDialog = false, imgstc = open_roof" class="btn btn-sm btn-block btn btn-secondary" type="button">Open Roof</button>
            <button style="display: block;" @click="hwBricksDialog = true, stcDialog = false, imgstc = hw_bricks" class="btn btn-sm btn-block btn btn-secondary" type="button">Hanging Wall with Bricks</button>
          </v-col>

          <v-col cols="7">
            <v-img
              :src="imgstc"
            ></v-img>
          </v-col>
        </v-row>

        <v-card-actions class="mt-3">
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="unitDemadoDialog"
      max-width="500px"
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
        >Above Unit Demado
        </v-toolbar>

        <v-divider></v-divider>
        <v-row class="pt-3 pb-3 pr-3 pl-6" style="width: 500px;">
          <v-col cols="5">
            <button style="display: block;" @click="imgdemado = bay_window75, demadoName = 'Bay Window', demadoSize = 75" class="btn btn-sm btn-block btn btn-secondary" type="button">Bay Window 7.5</button>
            <button style="display: block;" @click="imgdemado = bay_window90, demadoName = 'Bay Window', demadoSize = 90" class="btn btn-sm btn-block btn btn-secondary" type="button">Bay Window 9.0</button>
            <button style="display: block;" @click="imgdemado = precious_window60, demadoName = 'Precious Window', demadoSize = 60" class="btn btn-sm btn-block btn btn-secondary" type="button">Precious Window 6.0</button>
            <button style="display: block;" @click="imgdemado = precious_window90, demadoName = 'Precious Window', demadoSize = 90" class="btn btn-sm btn-block btn btn-secondary" type="button">Precious Window 9.0</button>
            <button style="display: block;" @click="imgdemado = furniture_window60, demadoName = 'Furniture Window', demadoSize = 60" class="btn btn-sm btn-block btn btn-secondary" type="button">Furniture Window 6.0</button>
            <button style="display: block;" @click="imgdemado = furniture_window90, demadoName = 'Furniture Window', demadoSize = 90" class="btn btn-sm btn-block btn btn-secondary" type="button">Furniture Window 9.0</button>
            <button style="display: block;" @click="imgdemado = rhythm_window30, demadoName = 'Rhythm Window', demadoSize = 30" class="btn btn-sm btn-block btn btn-secondary" type="button">Rhythm Window 3.0</button>
            <button style="display: block;" @click="imgdemado = washitsu_demado, demadoName = 'Jibukuro Washitsu', demadoSize = 90" class="btn btn-sm btn-block btn btn-secondary" type="button">Jibukuro Washitsu Demado 9.0</button>
          </v-col>

          <v-col cols="7">
            <v-img
              :src="imgdemado"
            ></v-img>
          </v-col>
        </v-row>

        <v-card-actions class="mt-3">
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="unitDemadoDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="computeUnitDemado(), unitDemadoDialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="roofTypeDialog"
      max-width="500px"
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
        >Type of Roof
        </v-toolbar>

        <v-divider></v-divider>
        <v-row class="pl-6" style="width: 500px;">
          <v-col cols="6">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-img
                  style="cursor: pointer;"
                  :src="kanagu_roof"
                  v-bind="attrs"
                  v-on="on"
                  @dblclick="excessBricksDialog = true, roofTypeDialog = false, imgroof = kanagu_roof, brickPitch = kanaguPitch, selectedRoofType = 'kanagu'"
                ></v-img>
              </template>
              <span>Kanagu</span>
            </v-tooltip>
          </v-col>

          <v-col cols="6">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-img
                  style="cursor: pointer;"
                  :src="kawara_roof"
                  v-bind="attrs"
                  v-on="on"
                  @dblclick="excessBricksDialog = true, roofTypeDialog = false, imgroof = kawara_roof, brickPitch = kawaraPitch, selectedRoofType = 'kawara'"
                ></v-img>
              </template>
              <span>Kawara</span>
            </v-tooltip>
          </v-col>
        </v-row>

        <v-card-actions class="mt-3">
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="roofTypeDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="excessBricksDialog"
      max-width="500px"
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
        >Excess Bricks
        </v-toolbar>

        <v-divider></v-divider>
        <v-row style="width: 500px;">
          <v-col cols="6" class="mt-1">
            <v-img
              class="ml-2"
              style="cursor: pointer;;"
              :src="imgroof"
            ></v-img>
          </v-col>

          <v-col cols="3">
            <v-select
              class="mt-2"
              color="#00355e"
              style="font-size: 12px;"
              :items="brickPitch"
              v-model="selectedBrickPitch"
              dense
              outlined
              label="Pitch"
            ></v-select>
          </v-col>

          <v-col cols="3">
            <v-text-field
              type="number"
              class="mt-2"
              color="#00355e"
              style="font-size: 12px;"
              dense
              outlined
              label="Quantity"
              v-model="excessBricksQty"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions class="mt-3">
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="excessBricksDialog = false, roofTypeDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="computeExcessBricks(), excessBricksDialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="fukiage1fDialog"
      max-width="500px"
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
          First Floor Fukiage
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 500px;">
          <v-col cols="6">
            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-top: 20px; margin-left: 40px; margin-bottom: -10px;"
              dense
              outlined
              label="Length (grid)"
              v-model="fukiage1fLength"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 40px; margin-bottom: -10px;"
              dense
              outlined
              label="Width (grid)"
              v-model="fukiage1fWidth"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 40px;"
              dense
              outlined
              label="Pitch"
              hint="as seen on plan ex: 3.5"
              @blur="restrictPitch(fukiage1fPitch)"
              v-model="fukiage1fPitch"
            ></v-text-field>
          </v-col>

          <v-col cols="6">
            <v-img
              class="mx-3"
              :src="fukiage1f"
            ></v-img>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="fukiage1fDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            :disabled="fukiage1fPitch < 1"
            @click="computeFukiage1F(), fukiage1fDialog = false, stcSummaryDialog = true"
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
            @click="tarekabe1Dialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            :disabled="tarekabe1Input < 1"
            @click="computeTarekabe1(), tarekabe1Dialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="tarekabe2Dialog"
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
          Tarekabe 2
        </v-toolbar>

        <v-divider></v-divider>

        <v-img
          class="pa-0"
          :src="tarekabe2"
          style="transform: scale(0.7); margin-top: -70px; margin-bottom: -50px;"
        ></v-img>

        <v-text-field
          autofocus
          color="#00355e"
          class="pl-11"
          style="font-size: 13px; width: 50%;"
          dense
          outlined
          label="Width"
          hint="Input in grid"
          v-model="tarekabe2Input"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="tarekabe2Dialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="computeTarekabe2(), tarekabe2Dialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="openRoofDialog"
      max-width="350px"
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
          Open Roof
        </v-toolbar>

        <v-divider></v-divider>

        <v-img 
          class="mx-3 mb-5"
          :src="open_roof"
        ></v-img>

        <v-toolbar tile dense flat color="transparent">
          <v-text-field
            autofocus
            color="#00355e"
            class="pr-2"
            style="font-size: 13px; width: 50%;"
            dense
            outlined
            label="Pitch"
            hint="Input as seen on plan"
            @blur="restrictPitch(openRoofPitch)"
            v-model="openRoofPitch"
          ></v-text-field>

          <v-text-field
            color="#00355e"
            class="pl-2"
            style="font-size: 13px; width: 50%;"
            dense
            outlined
            label="Width"
            hint="Input in grid"
            v-model="openRoofWidth"
          ></v-text-field>
        </v-toolbar>

        <v-card-actions class="mt-5">
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="openRoofDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            :disabled="openRoofPitch < 1"
            @click="computeOpenRoof(), openRoofDialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="hwBricksDialog"
      max-width="500px"
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
          Hanging Wall with Bricks
        </v-toolbar>

        <v-divider></v-divider>

        <v-row style="width: 450px; margin-left: 10px;">
          <v-col cols="12">
            <span style="color: #00355e; margin-left: 60px;">Horizontal Bricks</span>
            <span v-show="shioData.tileKind !== 'TF'" style="color: #00355e; margin-left: 110px;">Vertical Bricks</span>
            <v-img
              class="ml-6"
              :src="hw_horizontal"
              v-if="shioData.tileKind !== 'TF'"
            ></v-img>

            <v-img
              class="ml-6"
              :src="hw_horizontal1"
              v-else
            ></v-img>
          </v-col>

          <v-col cols="6">
            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 38px;"
              dense
              outlined
              label="No. of Horizontal Bricks"
              v-model="hwHorizontalBricks"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 38px; margin-top: -10px;"
              dense
              outlined
              label="Std. Height"
              :disabled="withTileKind"
              v-model="hwHorizontalHeight"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 38px; margin-top: -10px;"
              dense
              outlined
              label="Width (grid)"
              v-model="hwHorizontalWidth"
            ></v-text-field>
          </v-col>

          <v-col cols="6">
            <v-text-field
              color="#00355e"
              style="font-size: 13px; width: 80%; margin-left: 25px;"
              dense
              outlined
              label="Width (grid)"
              v-model="hwVerticalBricks"
              v-show="shioData.tileKind !== 'TF'"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="hwBricksDialog = false, stcDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="computeHWBricks(), hwBricksDialog = false, stcSummaryDialog = true"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
import { mapState } from 'vuex'
import Swal from 'sweetalert2'
import above_demado from "./images/above_demado.jpg"
import excess_bricks from "./images/excess_bricks.jpg"
import tarekabe1 from "./images/tarekabe1.jpg"
import tarekabe2 from "./images/tarekabe2.jpg"
import open_roof from "./images/open_roof.jpg"
import hw_bricks from "./images/hw_bricks_new.png"
import hw_horizontal from "./images/hw_horizontal.jpg"
import hw_horizontal1 from "./images/hw_horizontal1.jpg"
import bay_window75 from "./images/bay_window75.jpg"
import bay_window90 from "./images/bay_window90.jpg"
import precious_window60 from "./images/precious_window60.jpg"
import precious_window90 from "./images/precious_window90.jpg"
import furniture_window60 from "./images/furniture_window60.jpg"
import furniture_window90 from "./images/furniture_window90.jpg"
import rhythm_window30 from "./images/rhythm_window30.jpg"
import washitsu_demado from "./images/washitsu_demado.jpg"
import kanagu_roof from "./images/kanagu_roof.jpg"
import kawara_roof from "./images/kawara_roof.jpg"
import fukiage1f from "./images/fukiage1f.png"

export default {
  data(){
    return{
      savingData: false,
      direction: "", //to make STC tables dynamic,
      disableBox: false,
      checkboxCtr: 0,
      checkedArr: [],

      //images
      imgstc: null,
      imgdemado: null,
      imgroof: null,
      kanagu_roof: kanagu_roof,
      kawara_roof: kawara_roof,
      above_demado: above_demado,
      excess_bricks: excess_bricks,
      tarekabe1: tarekabe1,
      tarekabe2: tarekabe2,
      open_roof: open_roof,
      hw_bricks: hw_bricks,
      hw_horizontal: hw_horizontal,
      hw_horizontal1: hw_horizontal1,
      bay_window75: bay_window75,
      bay_window90: bay_window90,
      precious_window60: precious_window60,
      precious_window90: precious_window90,
      furniture_window60: furniture_window60,
      furniture_window90: furniture_window90,
      rhythm_window30: rhythm_window30,
      washitsu_demado: washitsu_demado,
      fukiage1f: fukiage1f,

      //dialogs
      stcSummaryDialog: false,
      stcDialog: false,
      unitDemadoDialog: false,
      roofTypeDialog: false,
      excessBricksDialog: false,
      fukiage1fDialog: false,
      tarekabe1Dialog: false,
      tarekabe2Dialog: false,
      openRoofDialog: false,
      hwBricksDialog: false,

      //gaiheki area
      gaihekiAreaData: [
        { direction: 'east', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
        { direction: 'south', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
        { direction: 'west', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 },
        { direction: 'north', HWgrid: null, HWpoint: null, LWgrid: null, LWpoint: null, STCsummaryData: [], totalSTC: null, totalPoint: null, serviceCheck: false, finalPoint: 0 }
      ],

      //standard height gaiheki
      LWheight: 0,
      HWheight: 0,

      //stc summary
      STCsummaryData: [],

      //sashes
      sashData: [],
      eastSashData: [
        {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
      ],

      southSashData: [
        {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
      ],

      westSashData: [
        {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
      ],

      northSashData: [
        {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
      ],
      totalEastSash: null,
      totalSouthSash: null,
      totalWestSash: null,
      totalNorthSash: null,

      //entrance door
      doorData: [],
      eastDoorData: [
        {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        }
      ],

      southDoorData: [
        {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        }
      ],

      westDoorData: [
        {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        }
      ],

      northDoorData: [
        {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        }
      ],
      totalEastDoor: null,
      totalSouthDoor: null,
      totalWestDoor: null,
      totalNorthDoor: null,

      //unit demado
      demadoName: "",
      demadoSize: null,

      //excess bricks
      brickPitch: [],
      kawaraPitch: [ 0.6, 0.55, 0.5, 0.45, 0.4 ],
      kanaguPitch: [ 0.55, 0.5, 0.45, 0.4, 0.35, 0.3 ],
      selectedRoofType: "",
      selectedBrickPitch: null,
      excessBricksQty: null,

      //fukiage 1f
      fukiage1fLength: null,
      fukiage1fWidth: null,
      fukiage1fPitch: null,

      //tarekabe
      tarekabe1Input: null,
      tarekabe2Input: null,

      //open roof
      openRoofPitch: null,
      openRoofWidth: null,

      //hw with bricks
      hwHorizontalBricks: null,
      hwHorizontalHeight: null,
      hwHorizontalWidth: null,
      hwVerticalBricks: null,

      tempTotalPoints: { servicePoints: 0, optionPoints: 0 }
    }
  },

  watch: {
    shioData(val){
      if(val){
        if(typeof(val.customerCode) !== 'undefined'){
          this.getGaihekiData()
          if(val.houseType.includes('i-cube') ||
            val.houseType.includes('Ａ３') ||
            val.houseType == 'GRAND SMART(グラン･スマート)'
          ){
            this.disableBox = true
          }else{
            this.disableBox = false
          }

          if(val.tileKind == 'TC'){
            this.hwHorizontalHeight = 0.109
          }else if(val.tileKind == 'TF'){
            this.hwHorizontalHeight = 0.298
            this.disableBox = true
          }else if(val.tileKind == 'TD'){
            this.hwHorizontalHeight = 0.049
          }else{
            this.hwHorizontalHeight = null
          }
        }
      }
    }
  },

  computed: {
    ...mapState(['shioData']),

    disableHighWaist(){
      if(this.shioData.ihead == 'Yes'){
        if(this.shioData.houseType == 'グラン･セゾン(GRAND SAISON)'){
          return true
        }else{
          return false
        }
      }else{
        return true
      }
    },

    withTileKind(){
      if(this.shioData.tileKind !== ''){
        return true
      }else{
        return false
      }
    },

    showSTC(){
      if(this.shioData.ihead == 'Yes'){
        if(this.shioData.houseType == 'グラン･セゾン(GRAND SAISON)'){
          return false
        }else{
          return true
        }
      }else{
        return false
      }
    },

    showTarekabe2(){
      if(this.shioData.ihead == 'No'){
        if(this.shioData.tileKind == 'TD' || this.shioData.tileKind == 'TF'){
          return false
        }else{
          return true
        }
      }else{
        return true
      }
    },

    doorDataSummary(){
      this.eastDoorData.forEach(object => {
        object.direction = 'east'
      });

      this.southDoorData.forEach(object => {
        object.direction = 'south'
      });

      this.westDoorData.forEach(object => {
        object.direction = 'west'
      });

      this.northDoorData.forEach(object => {
        object.direction = 'north'
      });

      const doorData = this.eastDoorData.concat(this.southDoorData, this.westDoorData, this.northDoorData)
      const empty = doorData.filter(r => r.doorType == "0")
      
      if(empty.length > 0){
        for (let i = 0; i < empty.length; i++) {
          const id = doorData.indexOf(empty[i]);
          doorData.splice(id, 1);
        }
      }

      this.doorData = doorData
    },

    sashDataSummary(){
      this.eastSashData.forEach(object => {
        object.direction = 'east'
      });

      this.southSashData.forEach(object => {
        object.direction = 'south'
      });

      this.westSashData.forEach(object => {
        object.direction = 'west'
      });

      this.northSashData.forEach(object => {
        object.direction = 'north'
      });

      const sashData = this.eastSashData.concat(this.southSashData, this.westSashData, this.northSashData)
      const empty = sashData.filter(r => r.width == null && r.height == null)
      
      if(empty.length > 0){
        for (let i = 0; i < empty.length; i++) {
          const id = sashData.indexOf(empty[i]);
          sashData.splice(id, 1);
        }
      }

      this.sashData = sashData
    },

    totalOption(){
      if(Object.keys(this.gaihekiAreaData).length > 0){
        // console.log(this.gaihekiAreaData)
        // var east = (this.gaihekiAreaData[0].totalPoint - this.totalEastSash) - this.totalEastDoor
        // var south = (this.gaihekiAreaData[1].totalPoint - this.totalSouthSash) - this.totalSouthDoor
        // var west = (this.gaihekiAreaData[2].totalPoint - this.totalWestSash) - this.totalWestDoor
        // var north = (this.gaihekiAreaData[3].totalPoint - this.totalNorthSash) - this.totalNorthDoor

        // this.gaihekiAreaData[0].finalPoint = parseFloat(east.toFixed(2)) * 1
        // this.gaihekiAreaData[1].finalPoint = parseFloat(south.toFixed(2)) * 1
        // this.gaihekiAreaData[2].finalPoint = parseFloat(west.toFixed(2)) * 1
        // this.gaihekiAreaData[3].finalPoint = parseFloat(north.toFixed(2)) * 1

        // this.gaihekiAreaData[0].finalPoint = east
        // this.gaihekiAreaData[1].finalPoint = south
        // this.gaihekiAreaData[2].finalPoint = west
        // this.gaihekiAreaData[3].finalPoint = north

        var option_points = 0
        var option = this.gaihekiAreaData.filter(r => r.serviceCheck == false) //gaihekiareadata
        option.forEach(r => {
          option_points += r.finalPoint;
        });

        this.tempTotalPoints.optionPoints = option_points
        this.$store.commit('getGaihekiAreaPoints', this.tempTotalPoints)
        return option_points;
      }
    },

    totalService(){
      if(Object.keys(this.gaihekiAreaData).length > 0){
        // var east = (this.gaihekiAreaData[0].totalPoint - this.totalEastSash) - this.totalEastDoor
        // var south = (this.gaihekiAreaData[1].totalPoint - this.totalSouthSash) - this.totalSouthDoor
        // var west = (this.gaihekiAreaData[2].totalPoint - this.totalWestSash) - this.totalWestDoor
        // var north = (this.gaihekiAreaData[3].totalPoint - this.totalNorthSash) - this.totalNorthDoor

        // this.gaihekiAreaData[0].finalPoint = parseFloat(east.toFixed(2)) * 1
        // this.gaihekiAreaData[1].finalPoint = parseFloat(south.toFixed(2)) * 1
        // this.gaihekiAreaData[2].finalPoint = parseFloat(west.toFixed(2)) * 1
        // this.gaihekiAreaData[3].finalPoint = parseFloat(north.toFixed(2)) * 1

        var service_points = 0
        var service = this.gaihekiAreaData.filter(r => r.serviceCheck == true)
        service.forEach(r => {
          service_points += r.finalPoint;
        });

        this.tempTotalPoints.servicePoints = service_points
        this.$store.commit('getGaihekiAreaPoints', this.tempTotalPoints)
        return service_points;
      }
    },

    ///////////////////////////////////////////////// sashes ////////////////////////////////////////////////////////

    eastSash(){
      let total1 = 0;
      this.eastSashData.filter((rec) => {
        total1 += rec.sashPoint;
      });
      this.totalEastSash = total1
      return total1;
    },

    southSash(){
      let total1 = 0;
      this.southSashData.filter((rec) => {
        total1 += rec.sashPoint;
      });
      this.totalSouthSash = total1
      return total1;
    },

    westSash(){
      let total1 = 0;
      this.westSashData.filter((rec) => {
        total1 += rec.sashPoint;
      });
      this.totalWestSash = total1
      return total1;
    },

    northSash(){
      let total1 = 0;
      this.northSashData.filter((rec) => {
        total1 += rec.sashPoint;
      });
      this.totalNorthSash = total1
      return total1;
    },

    ///////////////////////////////////////////////// entrance door ////////////////////////////////////////////////////////

    eastDoor(){
      let total = 0;
      this.eastDoorData.filter((rec) => {
        total += rec.doorPoint;
      });
      this.totalEastDoor = total
      return total;
    },

    southDoor(){
      let total = 0;
      this.southDoorData.filter((rec) => {
        total += rec.doorPoint;
      });
      this.totalSouthDoor = total
      return total;
    },

    westDoor(){
      let total = 0;
      this.westDoorData.filter((rec) => {
        total += rec.doorPoint;
      });
      this.totalWestDoor = total
      return total;
    },

    northDoor(){
      let total = 0;
      this.northDoorData.filter((rec) => {
        total += rec.doorPoint;
      });
      this.totalNorthDoor = total
      return total;
    }
  },

  created(){
    //gaiheki area
    if(Object.keys(this.$store.getters.getShioData).length !== 0 && Object.keys(this.$store.getters.getGaihekiAreaData).length !== 0){
      this.gaihekiAreaData = this.$store.getters.getGaihekiAreaData
    }

    //sash
    if(this.$store.getters.getGaihekiSashData.eastSashData.length > 0){
      this.eastSashData = this.$store.getters.getGaihekiSashData.eastSashData
    }
    if(this.$store.getters.getGaihekiSashData.southSashData.length > 0){
      this.southSashData = this.$store.getters.getGaihekiSashData.southSashData
    }
    if(this.$store.getters.getGaihekiSashData.westSashData.length > 0){
      this.westSashData = this.$store.getters.getGaihekiSashData.westSashData
    }
    if(this.$store.getters.getGaihekiSashData.northSashData.length > 0){
      this.northSashData = this.$store.getters.getGaihekiSashData.northSashData
    }

    //entrance door
    if(this.$store.getters.getGaihekiDoorData.eastDoorData.length > 0){
      this.eastDoorData = this.$store.getters.getGaihekiDoorData.eastDoorData
    }
    if(this.$store.getters.getGaihekiDoorData.southDoorData.length > 0){
      this.southDoorData = this.$store.getters.getGaihekiDoorData.southDoorData
    }
    if(this.$store.getters.getGaihekiDoorData.westDoorData.length > 0){
      this.westDoorData = this.$store.getters.getGaihekiDoorData.westDoorData
    }
    if(this.$store.getters.getGaihekiDoorData.northDoorData.length > 0){
      this.northDoorData = this.$store.getters.getGaihekiDoorData.northDoorData
    }
  },

  methods:{

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

    storeSashData(){
      let tempSashData = {
        eastSashData: this.eastSashData,
        southSashData: this.southSashData,
        westSashData: this.westSashData,
        northSashData: this.northSashData
      }

      this.$store.commit('getGaihekiSashData', tempSashData)
    },

    storeDoorData(){
      let tempDoorData = {
        eastDoorData: this.eastDoorData,
        southDoorData: this.southDoorData,
        westDoorData: this.westDoorData,
        northDoorData: this.northDoorData
      }

      this.$store.commit('getGaihekiDoorData', tempDoorData)
    },

    storeGaihekiAreaData(){
      this.$store.commit('getGaihekiAreaData', this.gaihekiAreaData)
    },

    ///////////////////////////////////////////////// service box restrictions ////////////////////////////////////////////////////////

    checkArr(val){
      if(Object.keys(this.$store.getters.getShioData).length !== 0){
        if(this.$store.getters.getShioData.houseType.includes('Ｆ２')){
          let checked = this.gaihekiAreaData.filter(r => r.direction !== val.direction) //gaihekiareadata
          checked[0].serviceCheck = false
          checked[1].serviceCheck = false
          checked[2].serviceCheck = false
        }
        else if(this.$store.getters.getShioData.houseType.includes('Ｖ３')){
          if(this.checkedArr.length < 2){
            this.checkedArr.push(val)
          }
          else if(this.checkedArr.length == 2){
            this.checkedArr.splice(0, 1);
            this.checkedArr.push(val)
            let checked = this.gaihekiAreaData.filter(r => r.direction !== this.checkedArr[0].direction && r.direction !== this.checkedArr[1].direction)
            checked[0].serviceCheck = false
            checked[1].serviceCheck = false
          }
        }
      }
    },

    ///////////////////////////////////////////////// gaiheki area ////////////////////////////////////////////////////////

    computeEastPoints(){
      console.log(this.$store.getters.getShioData)
      if(this.$store.getters.getShioData.kanabakari == "265"){
        this.LWheight = 3
        this.HWheight = 3.7
      }
      else if(this.$store.getters.getShioData.kanabakari == "260+"){
        this.LWheight = 2.9
        this.HWheight = 3.4
      }
      else{
        this.LWheight = 2.7
        this.HWheight = 3.4
      }

      if(this.shioData.hasOwnProperty('kanabakari')){
        if(this.gaihekiAreaData[0].HWgrid !== null){
          const a = (((parseFloat(this.gaihekiAreaData[0].HWgrid) || 0) * 0.91) * this.HWheight)
          // this.gaihekiAreaData[0].HWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[0].HWpoint = a
        }else{
          this.gaihekiAreaData[0].HWpoint = 0
        }

        if(this.gaihekiAreaData[0].LWgrid !== null){
          const a = (((parseFloat(this.gaihekiAreaData[0].LWgrid) || 0) * 0.91) * this.LWheight)
          // this.gaihekiAreaData[0].LWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[0].LWpoint = a
        }else{
          this.gaihekiAreaData[0].LWpoint = 0
        }
        
        if(this.gaihekiAreaData[0].STCsummaryData.length > 0){
          Array.prototype.sum = function (prop) {
            var total = 0
            for ( var i = 0, _len = this.length; i < _len; i++ ) {
              total += this[i][prop]
            }
            return total
          }
          this.gaihekiAreaData[0].totalSTC = this.gaihekiAreaData[0].STCsummaryData.sum("compPoints")
          // this.gaihekiAreaData[0].totalSTC = parseFloat(this.gaihekiAreaData[0].totalSTC.toFixed(3)) * 1
        }else{
          this.gaihekiAreaData[0].totalSTC = 0
        }

        const total = this.gaihekiAreaData[0].HWpoint + this.gaihekiAreaData[0].LWpoint + this.gaihekiAreaData[0].totalSTC
        console.log(total)
        this.gaihekiAreaData[0].totalPoint = total

        var east = (this.gaihekiAreaData[0].totalPoint - this.totalEastSash) - this.totalEastDoor
        // this.gaihekiAreaData[0].finalPoint = parseFloat(east.toFixed(2)) * 1
        this.gaihekiAreaData[0].finalPoint = east

        this.storeGaihekiAreaData()
      }else{
        if(this.gaihekiAreaData[0].HWgrid !== null || this.gaihekiAreaData[0].LWgrid !== null){
          Swal.fire({
            toast: false,
            position: 'center',
            icon: 'error',
            title: 'Invalid.',
            text: 'Without kanabakari data yet.',
            showConfirmButton: false,
            timer: 2800
          })
          this.gaihekiAreaData[0].HWgrid = null
          this.gaihekiAreaData[0].LWgrid = null
        }
      }
    },

    computeSouthPoints(){
      if(this.$store.getters.getShioData.kanabakari == "265"){
        this.LWheight = 3
        this.HWheight = 3.7
      }
      else if(this.$store.getters.getShioData.kanabakari == "260+"){
        this.LWheight = 2.9
        this.HWheight = 3.4
      }
      else{
        this.LWheight = 2.7
        this.HWheight = 3.4
      }

      if(this.shioData.hasOwnProperty('kanabakari')){
        if(this.gaihekiAreaData[1].HWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[1].HWgrid) || 0) * 0.91) * this.HWheight)
          // this.gaihekiAreaData[1].HWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[1].HWpoint = a
        }else{
          this.gaihekiAreaData[1].HWpoint = 0
        }

        if(this.gaihekiAreaData[1].LWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[1].LWgrid) || 0) * 0.91) * this.LWheight)
          // this.gaihekiAreaData[1].LWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[1].LWpoint = a
        }else{
          this.gaihekiAreaData[1].LWpoint = 0
        }

        if(this.gaihekiAreaData[1].STCsummaryData.length > 0){
          Array.prototype.sum = function (prop) {
            var total = 0
            for ( var i = 0, _len = this.length; i < _len; i++ ) {
              total += this[i][prop]
            }
            return total
          }

          this.gaihekiAreaData[1].totalSTC = this.gaihekiAreaData[1].STCsummaryData.sum("compPoints")
          // this.gaihekiAreaData[1].totalSTC = parseFloat(this.gaihekiAreaData[1].totalSTC.toFixed(3)) * 1
        }else{
          this.gaihekiAreaData[1].totalSTC = 0
        }

        const total = this.gaihekiAreaData[1].HWpoint + this.gaihekiAreaData[1].LWpoint + this.gaihekiAreaData[1].totalSTC
        this.gaihekiAreaData[1].totalPoint = total

        var south = (this.gaihekiAreaData[1].totalPoint - this.totalSouthSash) - this.totalSouthDoor
        // this.gaihekiAreaData[1].finalPoint = parseFloat(south.toFixed(2)) * 1
        this.gaihekiAreaData[1].finalPoint = south

        this.storeGaihekiAreaData()
      }else{
        if(this.gaihekiAreaData[1].HWgrid !== null || this.gaihekiAreaData[1].LWgrid !== null){
          Swal.fire({
            toast: false,
            position: 'center',
            icon: 'error',
            title: 'Invalid.',
            text: 'Without kanabakari data yet.',
            showConfirmButton: false,
            timer: 2800
          })
          this.gaihekiAreaData[1].HWgrid = null
          this.gaihekiAreaData[1].LWgrid = null
        }
      }
    },

    computeWestPoints(){
      if(this.$store.getters.getShioData.kanabakari == "265"){
        this.LWheight = 3
        this.HWheight = 3.7
      }
      else if(this.$store.getters.getShioData.kanabakari == "260+"){
        this.LWheight = 2.9
        this.HWheight = 3.4
      }
      else{
        this.LWheight = 2.7
        this.HWheight = 3.4
      }

      if(this.shioData.hasOwnProperty('kanabakari')){
        if(this.gaihekiAreaData[2].HWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[2].HWgrid) || 0) * 0.91) * this.HWheight)
          // this.gaihekiAreaData[2].HWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[2].HWpoint = a
        }else{
          this.gaihekiAreaData[2].HWpoint = 0
        }

        if(this.gaihekiAreaData[2].LWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[2].LWgrid) || 0) * 0.91) * this.LWheight)
          // this.gaihekiAreaData[2].LWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[2].LWpoint = a
        }else{
          this.gaihekiAreaData[2].LWpoint = 0
        }

        if(this.gaihekiAreaData[2].STCsummaryData.length > 0){
          Array.prototype.sum = function (prop) {
            var total = 0
            for ( var i = 0, _len = this.length; i < _len; i++ ) {
              total += this[i][prop]
            }
            return total
          }

          this.gaihekiAreaData[2].totalSTC = this.gaihekiAreaData[2].STCsummaryData.sum("compPoints")
          // this.gaihekiAreaData[2].totalSTC = parseFloat(this.gaihekiAreaData[2].totalSTC.toFixed(3)) * 1
        }else{
          this.gaihekiAreaData[2].totalSTC = 0
        }

        const total = this.gaihekiAreaData[2].HWpoint + this.gaihekiAreaData[2].LWpoint + this.gaihekiAreaData[2].totalSTC
        this.gaihekiAreaData[2].totalPoint = total

        var west = (this.gaihekiAreaData[2].totalPoint - this.totalWestSash) - this.totalWestDoor
        // this.gaihekiAreaData[2].finalPoint = parseFloat(west.toFixed(2)) * 1
        this.gaihekiAreaData[2].finalPoint = west

        this.storeGaihekiAreaData()
      }else{
        if(this.gaihekiAreaData[2].HWgrid !== null || this.gaihekiAreaData[2].LWgrid !== null){
          Swal.fire({
            toast: false,
            position: 'center',
            icon: 'error',
            title: 'Invalid.',
            text: 'Without kanabakari data yet.',
            showConfirmButton: false,
            timer: 2800
          })
          this.gaihekiAreaData[2].HWgrid = null
          this.gaihekiAreaData[2].LWgrid = null
        }
      }
    },

    computeNorthPoints(){
      if(this.$store.getters.getShioData.kanabakari == "265"){
        this.LWheight = 3
        this.HWheight = 3.7
      }
      else if(this.$store.getters.getShioData.kanabakari == "260+"){
        this.LWheight = 2.9
        this.HWheight = 3.4
      }
      else{
        this.LWheight = 2.7
        this.HWheight = 3.4
      }
      
      if(this.shioData.hasOwnProperty('kanabakari')){
        if(this.gaihekiAreaData[3].HWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[3].HWgrid) || 0) * 0.91) * this.HWheight)
          // this.gaihekiAreaData[3].HWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[3].HWpoint = a
        }else{
          this.gaihekiAreaData[3].HWpoint = 0
        }

        if(this.gaihekiAreaData[3].LWgrid != null){
          const a = (((parseFloat(this.gaihekiAreaData[3].LWgrid) || 0) * 0.91) * this.LWheight)
          // this.gaihekiAreaData[3].LWpoint = parseFloat(a.toFixed(2)) * 1
          this.gaihekiAreaData[3].LWpoint = a
        }else{
          this.gaihekiAreaData[3].LWpoint = 0
        }
        
        if(this.gaihekiAreaData[3].STCsummaryData.length > 0){
          Array.prototype.sum = function (prop) {
            var total = 0
            for ( var i = 0, _len = this.length; i < _len; i++ ) {
              total += this[i][prop]
            }
            return total
          }

          this.gaihekiAreaData[3].totalSTC = this.gaihekiAreaData[3].STCsummaryData.sum("compPoints")
          // this.gaihekiAreaData[3].totalSTC = parseFloat(this.gaihekiAreaData[3].totalSTC.toFixed(3)) * 1
        }else{
          this.gaihekiAreaData[3].totalSTC = 0
        }

        const total = this.gaihekiAreaData[3].HWpoint + this.gaihekiAreaData[3].LWpoint + this.gaihekiAreaData[3].totalSTC
        this.gaihekiAreaData[3].totalPoint = total

        var north = (this.gaihekiAreaData[3].totalPoint - this.totalNorthSash) - this.totalNorthDoor
        // this.gaihekiAreaData[3].finalPoint = parseFloat(north.toFixed(2)) * 1
        this.gaihekiAreaData[3].finalPoint = north

        this.storeGaihekiAreaData()
      }else{
        if(this.gaihekiAreaData[3].HWgrid !== null || this.gaihekiAreaData[3].LWgrid !== null){
          Swal.fire({
            toast: false,
            position: 'center',
            icon: 'error',
            title: 'Invalid.',
            text: 'Without kanabakari data yet.',
            showConfirmButton: false,
            timer: 2800
          })
          this.gaihekiAreaData[3].HWgrid = null
          this.gaihekiAreaData[3].LWgrid = null
        }
      }
    },

    ///////////////////////////////////////////////// sashes ////////////////////////////////////////////////////////

    validateSashInput(data){
      if(data.width !== null){
        const getWidth = this.$store.getters.getSashSize.filter(rec => rec.width == data.width)
        if(getWidth.length == 0){
          Swal.fire({
            toast: true,
            position: 'center',
            icon: 'error',
            title: 'Invalid Sash Width',
            text: 'Please input correct value.',
            showConfirmButton: false,
            timer: 2800
          })

          data.width = null
        }
      }

      if(data.height !== null){
        const getHeight = this.$store.getters.getSashSize.filter(rec => rec.height == data.height)
        if(getHeight.length == 0){
          Swal.fire({
            toast: true,
            position: 'center',
            icon: 'error',
            title: 'Invalid Sash Height',
            text: 'Please input correct value.',
            showConfirmButton: false,
            timer: 2800
          })

          data.height = null
        }
      }
    },

    computeEastSash(){
      this.computeEastPoints()
    },

    computeSouthSash(){
      this.computeSouthPoints()
    },

    computeWestSash(){
      this.computeWestPoints()
    },

    computeNorthSash(){
      this.computeNorthPoints()
    },

    addEastSashRow(){
      if(this.eastSashData.length == 0) {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.eastSashData.push(row)
      }else if(this.eastSashData[this.eastSashData.length - 1].width !== null &&
        this.eastSashData[this.eastSashData.length - 1].height !== null &&
        this.eastSashData[this.eastSashData.length - 1].withAmado !== "" &&
        this.eastSashData[this.eastSashData.length - 1].inclusion !== "") {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
        this.computeEastPoints()
        this.eastSashData.push(row)
      }else{
        return false;
      }
    },

    addSouthSashRow(){
      if(this.southSashData.length == 0) {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.southSashData.push(row)
      }else if(this.southSashData[this.southSashData.length - 1].width !== null &&
        this.southSashData[this.southSashData.length - 1].height !== null &&
        this.southSashData[this.southSashData.length - 1].withAmado !== "" &&
        this.southSashData[this.southSashData.length - 1].inclusion !== "") {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
        this.computeSouthPoints()
        this.southSashData.push(row)
      }else{
        return false;
      }
    },

    addWestSashRow(){
      if(this.westSashData.length == 0) {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.westSashData.push(row)
      }else if(this.westSashData[this.westSashData.length - 1].width !== null &&
        this.westSashData[this.westSashData.length - 1].height !== null &&
        this.westSashData[this.westSashData.length - 1].withAmado !== "" &&
        this.westSashData[this.westSashData.length - 1].inclusion !== "") {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
        this.computeWestPoints()
        this.westSashData.push(row)
      }else{
        return false;
      }
    },

    addNorthSashRow(){
      if(this.northSashData.length == 0) {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.northSashData.push(row)
      }else if(this.northSashData[this.northSashData.length - 1].width !== null &&
        this.northSashData[this.northSashData.length - 1].height !== null &&
        this.northSashData[this.northSashData.length - 1].withAmado !== "" &&
        this.northSashData[this.northSashData.length - 1].inclusion !== "") {
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        }
        this.computeNorthPoints()
        this.northSashData.push(row)
      }else{
        return false;
      }
    },

    getEastSash(data){
      if(this.eastSashData[this.eastSashData.length - 1].width !== null &&
        this.eastSashData[this.eastSashData.length - 1].height !== null &&
        this.eastSashData[this.eastSashData.length - 1].withAmado !== "" &&
        this.eastSashData[this.eastSashData.length - 1].inclusion !== ""){
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.eastSashData.push(row);
      }

      if(data.width !== null && data.height !== null && data.withAmado !== "" && data.inclusion !== ""){
        const getWidth = this.$store.getters.getSashSize.filter(rec => rec.width == data.width)
        if(getWidth.length == 0){
          Swal.fire({
            toast: true,
            position: 'bottom',
            icon: 'error',
            title: 'Invalid Sash Width',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2800
          })
        }
        const getHeight = this.$store.getters.getSashSize.filter(rec => rec.height == data.height)

        if(data.inclusion == "Full"){
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) + amadopoint
          }else{
            data.sashPoint = (getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)
          }
        }else{
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = (((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2) + amadopoint
          }else{
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2
          }
        }

        this.computeEastPoints()
      }
      this.computeEastPoints()
      this.storeSashData()
    },

    getSouthSash(data){
      if(this.southSashData[this.southSashData.length - 1].width !== null &&
        this.southSashData[this.southSashData.length - 1].height !== null &&
        this.southSashData[this.southSashData.length - 1].withAmado !== "" &&
        this.southSashData[this.southSashData.length - 1].inclusion !== ""){
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.southSashData.push(row);
      }

      if(data.width !== null && data.height !== null && data.withAmado !== "" && data.inclusion !== ""){
        const getWidth = this.$store.getters.getSashSize.filter(rec => rec.width == data.width)
        if(getWidth.length == 0){
          Swal.fire({
            toast: true,
            position: 'bottom',
            icon: 'error',
            title: 'Invalid Sash Width',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2800
          })
        }
        const getHeight = this.$store.getters.getSashSize.filter(rec => rec.height == data.height)

        if(data.inclusion == "Full"){
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) + amadopoint
          }else{
            data.sashPoint = (getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)
          }
        }else{
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = (((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2) + amadopoint
          }else{
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2
          }
        }

        this.computeSouthPoints()
      }

      this.storeSashData()
    },

    getWestSash(data){
      if(this.westSashData[this.westSashData.length - 1].width !== null &&
        this.westSashData[this.westSashData.length - 1].height !== null &&
        this.westSashData[this.westSashData.length - 1].withAmado !== "" &&
        this.westSashData[this.westSashData.length - 1].inclusion !== ""){
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.westSashData.push(row);
      }

      if(data.width !== null && data.height !== null && data.withAmado !== "" && data.inclusion !== ""){
        const getWidth = this.$store.getters.getSashSize.filter(rec => rec.width == data.width)
        if(getWidth.length == 0){
          Swal.fire({
            toast: true,
            position: 'bottom',
            icon: 'error',
            title: 'Invalid Sash Width',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2800
          })
        }
        const getHeight = this.$store.getters.getSashSize.filter(rec => rec.height == data.height)

        if(data.inclusion == "Full"){
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) + amadopoint
          }else{
            data.sashPoint = (getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)
          }
        }else{
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = (((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2) + amadopoint
          }else{
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2
          }
        }

        this.computeWestPoints()
      }

      this.storeSashData()
    },

    getNorthSash(data){
      if(this.northSashData[this.northSashData.length - 1].width !== null &&
        this.northSashData[this.northSashData.length - 1].height !== null &&
        this.northSashData[this.northSashData.length - 1].withAmado !== "" &&
        this.northSashData[this.northSashData.length - 1].inclusion !== ""){
        let row = {
          width: null,
          height: null,
          withAmado: "No",
          inclusion: "Full",
          sashPoint: null
        };
        this.northSashData.push(row);
      }

      if(data.width !== null && data.height !== null && data.withAmado !== "" && data.inclusion !== ""){
        const getWidth = this.$store.getters.getSashSize.filter(rec => rec.width == data.width)
        if(getWidth.length == 0){
          Swal.fire({
            toast: true,
            position: 'bottom',
            icon: 'error',
            title: 'Invalid Sash Width',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 2800
          })
        }
        const getHeight = this.$store.getters.getSashSize.filter(rec => rec.height == data.height)

        if(data.inclusion == "Full"){
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) + amadopoint
          }else{
            data.sashPoint = (getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)
          }
        }else{
          if(data.withAmado == "Yes"){
            var amadopoint = 1.98
            data.sashPoint = (((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2) + amadopoint
          }else{
            data.sashPoint = ((getWidth[0].width_value / 1000) * (getHeight[0].height_value / 1000)) / 2
          }
        }

        this.computeNorthPoints()
      }

      this.storeSashData()
    },

    deleteEastSashRow(index){
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
          this.eastSashData.splice(index, 1);
          this.computeEastPoints()
          this.storeSashData()
        }
      })
    },

    deleteSouthSashRow(index){
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
          this.southSashData.splice(index, 1);
          this.computeSouthPoints()
          this.storeSashData()
        }
      })
    },

    deleteWestSashRow(index){
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
          this.westSashData.splice(index, 1);
          this.computeWestPoints()
          this.storeSashData()
        }
      })
    },

    deleteNorthSashRow(index){
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
          this.northSashData.splice(index, 1);
          this.computeNorthPoints()
          this.storeSashData()
        }
      })
    },

    ///////////////////////////////////////////////// entrance door ////////////////////////////////////////////////////////

    validateDoorInput(data){
      if(data.doorQty == null){
        Swal.fire({
          toast: true,
          position: 'center',
          icon: 'error',
          title: 'Invalid Door Quantity',
          text: 'Please input correct value.',
          showConfirmButton: false,
          timer: 2800
        })
      }else if(data.doorQty <= 0){
        Swal.fire({
          toast: true,
          position: 'center',
          icon: 'error',
          title: 'Invalid Door Quantity',
          text: 'Please input correct value.',
          showConfirmButton: false,
          timer: 2800
        })
      }
    },

    addEastDoorRow() {
      if(this.eastDoorData.length == 0) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.eastDoorData.push(row);
      }else if(this.eastDoorData[this.eastDoorData.length - 1].doorType != 0 && this.eastDoorData[this.eastDoorData.length - 1].quantity != 0){
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.eastDoorData.push(row)
        this.computeEastPoints()
      }else{
        return false;
      }
    },

    addSouthDoorRow() {
      if(this.southDoorData.length == 0) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.southDoorData.push(row);
      }else if(this.southDoorData[this.southDoorData.length - 1].doorType != 0 && this.southDoorData[this.southDoorData.length - 1].quantity != 0){
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.southDoorData.push(row)
        this.computeSouthPoints()
      }else{
        return false;
      }
    },

    addWestDoorRow() {
      if(this.westDoorData.length == 0) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.westDoorData.push(row);
      }else if(this.westDoorData[this.westDoorData.length - 1].doorType != 0 && this.westDoorData[this.westDoorData.length - 1].quantity != 0){
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.westDoorData.push(row)
        this.computeWestPoints()
      }else{
        return false;
      }
    },

    addNorthDoorRow() {
      if(this.northDoorData.length == 0) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.northDoorData.push(row);
      }else if(this.northDoorData[this.northDoorData.length - 1].doorType != 0 && this.northDoorData[this.northDoorData.length - 1].quantity != 0){
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.northDoorData.push(row)
        this.computeNorthPoints()
      }else{
        return false;
      }
    },

    deleteEastDoorRow(index){
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
          this.eastDoorData.splice(index, 1)
          this.computeEastPoints()
          this.storeDoorData()
        }
      })
    },

    deleteSouthDoorRow(index){
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
          this.southDoorData.splice(index, 1)
          this.computeSouthPoints()
          this.storeDoorData()
        }
      })
    },

    deleteWestDoorRow(index){
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
          this.westDoorData.splice(index, 1)
          this.computeWestPoints()
          this.storeDoorData()
        }
      })
    },

    deleteNorthDoorRow(index){
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
          this.northDoorData.splice(index, 1)
          this.computeNorthPoints()
          this.storeDoorData()
        }
      })
    },

    computeEastDoor(){
      this.computeEastPoints()
    },

    computeSouthDoor(){
      this.computeSouthPoints()
    },

    computeWestDoor(){
      this.computeWestPoints()
    },

    computeNorthDoor(){
      this.computeNorthPoints()
    },

    getEastDoor(data){
      if(this.eastDoorData[this.eastDoorData.length - 1].doorType !== "" && this.eastDoorData[this.eastDoorData.length - 1].doorQty !== null) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.eastDoorData.push(row);
      }

      if(data.doorQty !== null){
        data.doorPoint = parseFloat(data.doorType) * data.doorQty
      }

      this.storeDoorData()
    },

    getSouthDoor(data){
      if(this.southDoorData[this.southDoorData.length - 1].doorType !== "" && this.southDoorData[this.southDoorData.length - 1].doorQty !== null) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.southDoorData.push(row);
      }

      if(data.doorQty !== null){
        data.doorPoint = parseFloat(data.doorType) * data.doorQty
      }

      this.storeDoorData()
    },

    getWestDoor(data){
      if(this.westDoorData[this.westDoorData.length - 1].doorType !== "" && this.westDoorData[this.westDoorData.length - 1].doorQty !== null) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.westDoorData.push(row);
      }

      if(data.doorQty !== null){
        data.doorPoint = parseFloat(data.doorType) * data.doorQty
      }

      this.storeDoorData()
    },

    getNorthDoor(data){
      if(this.northDoorData[this.northDoorData.length - 1].doorType !== "" && this.northDoorData[this.northDoorData.length - 1].doorQty !== null) {
        let row = {
          doorType: "0",
          doorQty: null,
          doorPoint: null
        };
        this.northDoorData.push(row);
      }

      if(data.doorQty !== null){
        data.doorPoint = parseFloat(data.doorType) * data.doorQty
      }

      this.storeDoorData()
    },

    ///////////////////////////////////////////////// special type computation ////////////////////////////////////////////////////////

    deleteSTCColumn(data){
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
          const index = this.STCsummaryData.indexOf(data);
      
          if(this.direction == "east"){
            this.gaihekiAreaData[0].totalPoint = this.gaihekiAreaData[0].totalPoint - data.compPoints
            this.gaihekiAreaData[0].STCsummaryData.splice(index, 1);
            this.computeEastPoints()
          }
          else if(this.direction == "south"){
            this.gaihekiAreaData[1].totalPoint = this.gaihekiAreaData[1].totalPoint - data.compPoints
            this.gaihekiAreaData[1].STCsummaryData.splice(index, 1);
            this.computeSouthPoints()
          }
          else if(this.direction == "west"){
            this.gaihekiAreaData[2].totalPoint = this.gaihekiAreaData[2].totalPoint - data.compPoints
            this.gaihekiAreaData[2].STCsummaryData.splice(index, 1);
            this.computeWestPoints()
          }
          else if(this.direction == "north"){
            this.gaihekiAreaData[3].totalPoint = this.gaihekiAreaData[3].totalPoint - data.compPoints
            this.gaihekiAreaData[3].STCsummaryData.splice(index, 1);
            this.computeNorthPoints()
          }
        }
      })
    },

    computeUnitDemado(){
      axios.post('api/getDemadoMaster', {
        kanabakari: this.$store.getters.getShioData.kanabakari,
        demado_name: this.demadoName,
        demado_size: this.demadoSize
      }).then(res => {
        let demado = {
          direction: this.direction,
          compType: "Above Unit Demado",
          compPoints: res.data[0].demado_points
        }

        if(this.direction == "east"){
          this.gaihekiAreaData[0].STCsummaryData.push(demado);
          this.computeEastPoints()
        }
        else if(this.direction == "south"){
          this.gaihekiAreaData[1].STCsummaryData.push(demado);
          this.computeSouthPoints()
        }
        else if(this.direction == "west"){
          this.gaihekiAreaData[2].STCsummaryData.push(demado);
          this.computeWestPoints()
        }
        else if(this.direction == "north"){
          this.gaihekiAreaData[3].STCsummaryData.push(demado);
          this.computeNorthPoints()
        }
      })
    },

    computeExcessBricks(){
      if(this.excessBricksQty !== null && this.selectedBrickPitch !== null){
        const brickpoint = this.$store.getters.getBrickPoints.filter(rec => rec.roof_type == this.selectedRoofType && rec.pitch == this.selectedBrickPitch)
        brickpoint[0].brick_point

        const totalpt = brickpoint[0].brick_point * this.excessBricksQty

        let excessbrickpt = {
          direction: this.direction,
          compType: "Excess Bricks",
          compPoints: totalpt
        }

        if(this.direction == "east"){
          this.gaihekiAreaData[0].STCsummaryData.push(excessbrickpt);
          this.computeEastPoints()
        }
        else if(this.direction == "south"){
          this.gaihekiAreaData[1].STCsummaryData.push(excessbrickpt);
          this.computeSouthPoints()
        }
        else if(this.direction == "west"){
          this.gaihekiAreaData[2].STCsummaryData.push(excessbrickpt);
          this.computeWestPoints()
        }
        else if(this.direction == "north"){
          this.gaihekiAreaData[3].STCsummaryData.push(excessbrickpt);
          this.computeNorthPoints()
        }

        this.selectedBrickPitch = null
        this.excessBricksQty = null
      }
    },

    computeFukiage1F(){
      const l = this.fukiage1fLength * 0.91
      const w = this.fukiage1fWidth * 0.91
      const p = this.fukiage1fPitch / 10

      const total = l * w * p
      const fukiage1fPoint = parseFloat(total)

      let fukiage1floor = {
        direction: this.direction,
        compType: "First Floor Fukiage",
        compPoints: fukiage1fPoint
      }

      if(this.direction == "east"){
        this.gaihekiAreaData[0].STCsummaryData.push(fukiage1floor);
        this.computeEastPoints()
      }
      else if(this.direction == "south"){
        this.gaihekiAreaData[1].STCsummaryData.push(fukiage1floor);
        this.computeSouthPoints()
      }
      else if(this.direction == "west"){
        this.gaihekiAreaData[2].STCsummaryData.push(fukiage1floor);
        this.computeWestPoints()
      }
      else if(this.direction == "north"){
        this.gaihekiAreaData[3].STCsummaryData.push(fukiage1floor);
        this.computeNorthPoints()
      }

      this.fukiage1fLength = null
      this.fukiage1fWidth = null
      this.fukiage1fPitch = null
    },

    computeTarekabe1(){
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

      let tarekabe1 = {
        direction: this.direction,
        compType: "Tarekabe 1",
        compPoints: tarekabe1Point
      }

      if(this.direction == "east"){
        this.gaihekiAreaData[0].STCsummaryData.push(tarekabe1);
        this.computeEastPoints()
      }
      else if(this.direction == "south"){
        this.gaihekiAreaData[1].STCsummaryData.push(tarekabe1);
        this.computeSouthPoints()
      }
      else if(this.direction == "west"){
        this.gaihekiAreaData[2].STCsummaryData.push(tarekabe1);
        this.computeWestPoints()
      }
      else if(this.direction == "north"){
        this.gaihekiAreaData[3].STCsummaryData.push(tarekabe1);
        this.computeNorthPoints()
      }

      this.tarekabe1Input = null
    },

    computeTarekabe2(){
      if(this.$store.getters.getShioData.kanabakari == "240"){
        var outside = 1.175
      }
      else if(this.$store.getters.getShioData.kanabakari == "265"){
        var outside = 1.1
      }

      const HW1 = (this.tarekabe2Input * 0.91) * outside
      const HW2 = (this.tarekabe2Input * 0.91) * 0.268
      // const AH = 0.303 * 0.7 -> if with column

      const point = HW1 + HW2
      const tarekabe2Point = parseFloat(point)

      let tarekabe2 = {
        direction: this.direction,
        compType: "Tarekabe 2",
        compPoints: tarekabe2Point
      }

      if(this.direction == "east"){
        this.gaihekiAreaData[0].STCsummaryData.push(tarekabe2);
        this.computeEastPoints()
      }
      else if(this.direction == "south"){
        this.gaihekiAreaData[1].STCsummaryData.push(tarekabe2);
        this.computeSouthPoints()
      }
      else if(this.direction == "west"){
        this.gaihekiAreaData[2].STCsummaryData.push(tarekabe2);
        this.computeWestPoints()
      }
      else if(this.direction == "north"){
        this.gaihekiAreaData[3].STCsummaryData.push(tarekabe2);
        this.computeNorthPoints()
      }

      this.tarekabe2Input = null
    },

    computeOpenRoof(){
      const area1 = ((this.openRoofWidth * 0.91) * (this.openRoofWidth * 0.91) * (this.openRoofPitch / 10)) / 2
      const area = parseFloat(area1)

      let openroof = {
        direction: this.direction,
        compType: "Open Roof",
        compPoints: area
      }

      if(this.direction == "east"){
        this.gaihekiAreaData[0].STCsummaryData.push(openroof);
        this.computeEastPoints()
      }
      else if(this.direction == "south"){
        this.gaihekiAreaData[1].STCsummaryData.push(openroof);
        this.computeSouthPoints()
      }
      else if(this.direction == "west"){
        this.gaihekiAreaData[2].STCsummaryData.push(openroof);
        this.computeWestPoints()
      }
      else if(this.direction == "north"){
        this.gaihekiAreaData[3].STCsummaryData.push(openroof);
        this.computeNorthPoints()
      }

      this.openRoofPitch = null
      this.openRoofWidth = null
    },

    computeHWBricks(){
      if(this.shioData.ihead == 'Yes'){
        if(this.shioData.houseType == 'グラン･セゾン(GRAND SAISON)'){
          var multiplier = 0.147
        }else{
          var multiplier = 0.2
        }
      }else{
        var multiplier = 0.147
      }

      const hw_horizontal = ((this.hwHorizontalBricks || 0) * this.hwHorizontalHeight) * (this.hwHorizontalWidth * 0.91)
      const hw_vertical = (this.hwVerticalBricks * 0.91) * multiplier

      const total = hw_horizontal + hw_vertical

      let hwbricks = {
        direction: this.direction,
        compType: "Hanging Wall with Bricks",
        compPoints: total
      }

      if(this.direction == "east"){
        this.gaihekiAreaData[0].STCsummaryData.push(hwbricks);
        this.computeEastPoints()
      }
      else if(this.direction == "south"){
        this.gaihekiAreaData[1].STCsummaryData.push(hwbricks);
        this.computeSouthPoints()
      }
      else if(this.direction == "west"){
        this.gaihekiAreaData[2].STCsummaryData.push(hwbricks);
        this.computeWestPoints()
      }
      else if(this.direction == "north"){
        this.gaihekiAreaData[3].STCsummaryData.push(hwbricks);
        this.computeNorthPoints()
      }

      this.hwHorizontalBricks = null
      // this.hwHorizontalHeight = null
      this.hwHorizontalWidth = null
      this.hwVerticalBricks = null
    },

    getGaihekiData(){
      axios.post('api/getGaihekiData', {
        customer_code: this.shioData.customerCode,
        plan_no: this.shioData.planNo
      })
      .then(res => {

        if(res.data.gaiheki_area.length > 0){
          const east = res.data.gaiheki_area.filter(r => r.direction == 'east')
          const south = res.data.gaiheki_area.filter(r => r.direction == 'south')
          const west = res.data.gaiheki_area.filter(r => r.direction == 'west')
          const north = res.data.gaiheki_area.filter(r => r.direction == 'north')

          if(east.length > 0){
            this.gaihekiAreaData[0] = east[0]
          }else{
            
          }

          if(south.length > 0){
            this.gaihekiAreaData[1] = south[0]
          }

          if(west.length > 0){
            this.gaihekiAreaData[2] = west[0]
          }

          if(north.length > 0){
            this.gaihekiAreaData[3] = north[0]
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

        this.storeGaihekiAreaData()

        if(res.data.door_data.length > 0){
          this.eastDoorData = res.data.door_data.filter(r => r.direction == 'east')
          this.southDoorData = res.data.door_data.filter(r => r.direction == 'south')
          this.westDoorData = res.data.door_data.filter(r => r.direction == 'west')
          this.northDoorData = res.data.door_data.filter(r => r.direction == 'north')

          this.storeDoorData()
        }

        if(res.data.sash_data.length > 0){
          this.eastSashData = res.data.sash_data.filter(r => r.direction == 'east')
          this.southSashData = res.data.sash_data.filter(r => r.direction == 'south')
          this.westSashData = res.data.sash_data.filter(r => r.direction == 'west')
          this.northSashData = res.data.sash_data.filter(r => r.direction == 'north')

          this.storeSashData()
        }
      })
    },

    saveGaihekiData(){
      this.savingData = true
      this.gaihekiAreaData[0].customer_code = this.shioData.customerCode
      this.gaihekiAreaData[0].plan_no = this.shioData.planNo

      this.gaihekiAreaData[1].customer_code = this.shioData.customerCode
      this.gaihekiAreaData[1].plan_no = this.shioData.planNo
      
      this.gaihekiAreaData[2].customer_code = this.shioData.customerCode
      this.gaihekiAreaData[2].plan_no = this.shioData.planNo

      this.gaihekiAreaData[3].customer_code = this.shioData.customerCode
      this.gaihekiAreaData[3].plan_no = this.shioData.planNo

      // let doorArr = this.doorData
      // const empty = doorArr.filter(r => r.doorPoint == null)
      // if(empty.length > 0){
      //   for(let i = 0; i < empty.length; i++){
      //     const id = empty.findIndex(r => r.doorPoint == null)
      //     doorArr.splice(id, 1);
      //   }
      // }

      // let sashArr = this.sashData
      // const empty1 = sashArr.filter(r => r.sashPoint == null)
      // if(empty1.length > 0){
      //   for(let i = 0; i < empty1.length; i++){
      //     const id1 = empty1.findIndex(r => r.sashPoint == null)
      //     sashArr.splice(id1, 1);
      //   }
      // }

      axios.post('api/saveGaihekiArea', this.gaihekiAreaData)
      .then(res => {
        console.log(res.data.message)

        axios.post('api/saveSash', {
          sashData: this.sashData,
          customer_code: this.shioData.customerCode,
          plan_no: this.shioData.planNo
        })
        .then(res => {
          console.log(res.data.message)

          axios.post('api/saveEntrance', {
            doorData: this.doorData,
            customer_code: this.shioData.customerCode,
            plan_no: this.shioData.planNo
          })
          .then(res => {
            console.log(res.data.message)
            this.savingData = false

            Swal.fire({
              position: 'center',
              icon: 'success',
              iconColor: '#3ab792',
              title: 'Success!',
              text: 'Gaiheki Area data has been saved.',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 2500
            })
          })
        })
      })
    }
  }
}
</script>

<style scoped>
  #checkboxLabel {
    margin-top: 10px;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }

  table {
    width: 100%;
  }

  input{
    font-size: 12px;
  }

  select{
    font-size: 12px;
  }

  ::v-deep .v-label {
    font-size: 10px;
  }

  ::v-deep .v-label--active {
    font-size: 1em;
  }
</style>