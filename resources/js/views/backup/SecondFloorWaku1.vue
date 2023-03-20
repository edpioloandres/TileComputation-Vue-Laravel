<template>
  <div>
    <v-overlay v-model="overlay">
      <v-progress-circular
        size="75"
        indeterminate
      ></v-progress-circular>
    </v-overlay>

    <v-row class="ma-2">

      <v-col cols="3">
        <span style="font-weight: bold; color: #00355e; font-size: 14px;">3FL House</span>
        <v-card elevation="1" class="mt-2 mb-8 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 12px;" class="text-center">
                  FOR 3FL HOUSE PERIMETER (245) / 240 / 260
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">2nd FL (LW)</td>
                <td><input @blur="compute3FLhouse()" v-model="lowWaist2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">2nd FL (HW)</td>
                <td><input @blur="compute3FLhouse()" v-model="highWaist2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Below Balcony</td>
                <td><input @blur="compute3FLhouse()" v-model="belowBalcony2F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Between HW & BB</td>
                <td><input @blur="compute3FLhouse()" v-model="betweenHW" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">3rd FL</td>
                <td><input @blur="compute3FLhouse()" v-model="thirdFloor" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Below Balcony</td>
                <td><input @blur="compute3FLhouse()" v-model="belowBalcony3F" type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Total</td>
                <td><input disabled v-model="total3FArea" type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <span style="font-weight: bold; color: #00355e; font-size: 14px;">Sashes</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Width
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
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Fukiage (+)
                </th>
                <th style="font-size: 12px;" class="text-center">
                  <button @click="fukiageDialog = true" style="display: block; margin: auto; width: 95%;" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">Others</button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2"><input type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Fukisage (-)
                </th>
                <th style="font-size: 12px;" class="text-center">
                  <button style="display: block; margin: auto; width: 95%;" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">Others</button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2"><input type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px;" class="text-center">
                  <button style="display: block; margin: auto; width: 95%;" class="btn btn-sm btn-block btn-outline-success mt-1 mb-1" type="button">Roof Deduction</button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px;" class="text-center">
                  Design Louver (-)
                </th>
              </tr>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Deduction
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Quantity
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Total
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">1.82</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">1.365</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">0.91</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>

      <v-col cols="4">
        <span style="font-weight: bold; color: #00355e; font-size: 14px;">Roof Garden</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Roof Garden
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Total
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Pent House
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Total
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px;" class="text-center">
                  Deduction of Roof Garden
                </th>
              </tr>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Deduction
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Quantity
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Total
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">1.82</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">1.365</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">0.91</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <v-card elevation="1" class="mt-2 mb-8 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th colspan="3" style="font-size: 12px;" class="text-center">
                  H.W VERTICAL FOR ROOF GARDEN
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">Vertical</td>
                <td style="font-size: 12px;" class="text-center">Grids</td>
                <td style="font-size: 12px;" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">0.147</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>

              <tr>
                <td style="font-size: 12px;" class="text-center">Horizontal</td>
                <td style="font-size: 12px;" class="text-center">Grids</td>
                <td style="font-size: 12px;" class="text-center">Total</td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">0.049</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input disabled type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>

        <span style="font-weight: bold; color: #00355e; font-size: 14px;">Hanging Wall</span>
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered" cellspacing="0" cellpadding="2">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  3FL House
                </th>
                <th style="font-size: 12px;" class="text-center">
                  2nd FL
                </th>
                <th style="font-size: 12px;" class="text-center">
                  2nd FL
                </th>
                <th style="font-size: 12px;" class="text-center">
                  3rd FL
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="font-size: 12px;" class="text-center">Outside</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Opening</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">HW</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
              </tr>
              <tr>
                <td style="font-size: 12px;" class="text-center">Inside</td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
                <td><input type="number" class="form-control text-center"></td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>

      <v-col cols="2">
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Parapet
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Height
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.41</td>
              </tr>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.46</td>
              </tr>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.605</td>
              </tr>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.274</td>
              </tr>
            </tbody>
          </table>
        </v-card>
        
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Sode Kabe
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Height
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">EWL</td>
              </tr>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">EWH</td>
              </tr>
            </tbody>
          </table>
        </v-card>
        
        <v-card elevation="1" class="mt-2 mb-5 pa-2">
          <v-spacer />
          <table class="table-sm table-bordered">
            <thead>
              <tr>
                <th style="font-size: 12px;" class="text-center">
                  Overhang
                </th>
                <th style="font-size: 12px;" class="text-center">
                  Height
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.395</td>
              </tr>
              <tr>
                <td><input type="number" class="form-control text-center"></td>
                <td style="font-size: 12px;" class="text-center">0.64</td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>
    </v-row>

    <!------------------------------------------------------ OTHERS + FUKIAGE ------------------------------------------------------------->
    <v-dialog
      v-model="fukiageDialog"
      max-width="300px"
      persistent
    >
      <v-card class="pa-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >Others + Fukiage
        <v-spacer></v-spacer>
          <v-btn
            icon
            dense
            @click="fukiageDialog = false"
          >
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-divider></v-divider>
          <div class="px-5 pb-5">
            <button class="btn btn-sm btn-block btn btn-secondary" @click="tarekabe2Dialog = true, fukiageDialog = false" type="button">Tarekabe 2</button>
            <button class="btn btn-sm btn-block btn btn-secondary" @click="rectangleDialog = true, fukiageDialog = false" type="button">Rectangle</button>
            <button class="btn btn-sm btn-block btn btn-secondary" @click="wholeTriangleDialog = true, fukiageDialog = false" type="button">Whole Triangle</button>
            <button class="btn btn-sm btn-block btn btn-secondary" @click="trapezoidDialog = true, fukiageDialog = false" type="button">Trapezoid</button>
            <button class="btn btn-sm btn-block btn btn-secondary" @click="halfTriangleDialog = true, fukiageDialog = false" type="button">Half Triangle</button>
          </div>
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
        >Tarekabe 2
        <v-spacer></v-spacer>
          <v-btn
            icon
            dense
            @click="tarekabe2Dialog = false"
          >
            <v-icon small color="#00355e">mdi-close</v-icon>
          </v-btn>
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
          v-model="tarekabeWidth"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="tarekabe2Dialog = false, fukiageDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="tarekabe2Dialog = false, computeTarekabe()"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="rectangleDialog"
      max-width="370px"
      persistent
    >
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >Rectangle
        </v-toolbar>

        <v-divider></v-divider>
        <v-row style="width: 370px;">
          <v-col>
            <v-img
              style="transform: scale(0.9);"
              :src="rectangle"
            ></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Height"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Width"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Pitch"
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
            @click="rectangleDialog = false, fukiageDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="rectangleDialog = false"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="wholeTriangleDialog"
      max-width="370px"
      persistent
    >
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >Whole Triangle
        </v-toolbar>

        <v-divider></v-divider>
        <v-row style="width: 370px;">
          <v-col>
            <v-img
              class="mt-5"
              :src="whole_triangle"
            ></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Height"
            ></v-text-field>

            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              disabled
              label="Width"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Pitch"
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
            @click="wholeTriangleDialog = false, fukiageDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="wholeTriangleDialog = false"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="trapezoidDialog"
      max-width="370px"
      persistent
    >
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >Trapezoid
        </v-toolbar>

        <v-divider></v-divider>
        <v-row style="width: 370px;">
          <v-col>
            <v-img
              style="transform: scale(0.9);"
              :src="trapezoid"
            ></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              disabled
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Height 1"
            ></v-text-field>

            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Height 2"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Width"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Pitch"
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
            @click="trapezoidDialog = false, fukiageDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="trapezoidDialog = false"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="halfTriangleDialog"
      max-width="370px"
      persistent
    >
      <v-card class="px-3 py-2">
        <v-toolbar
          flat
          tile
          color="white"
          class="mt-2"
          dense
          style="font-size: 14px; color: #00355e; font-weight: bold;"
        >Half Triangle
        </v-toolbar>

        <v-divider></v-divider>
        <v-row style="width: 370px;">
          <v-col>
            <v-img
              style="transform: scale(0.9);"
              :src="half_triangle"
            ></v-img>
          </v-col>
          <v-col class="mt-4">
            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Height"
            ></v-text-field>

            <v-text-field
              autofocus
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              disabled
              label="Width"
            ></v-text-field>

            <v-text-field
              color="#00355e"
              style="font-size: 13px;"
              dense
              outlined
              label="Pitch"
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
            @click="halfTriangleDialog = false, fukiageDialog = true"
          >
            Cancel
          </v-btn>
          <v-btn
            color="#00355e"
            style="font-size: 12px;"
            text
            plain
            @click="halfTriangleDialog = false"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>

import tarekabe2 from "./images/tarekabe2.jpg"
import rectangle from "./images/rectangle.jpg"
import whole_triangle from "./images/whole_triangle.jpg"
import trapezoid from "./images/trapezoid.jpg"
import half_triangle from "./images/half_triangle.jpg"

export default {
  data(){
    return{
      overlay: false,

      //images
      tarekabe2: tarekabe2,
      rectangle: rectangle,
      whole_triangle: whole_triangle,
      trapezoid: trapezoid,
      half_triangle: half_triangle,

      //dialogs
      fukiageDialog: false,
      tarekabe2Dialog: false,
      rectangleDialog: false,
      wholeTriangleDialog: false,
      trapezoidDialog: false,
      halfTriangleDialog: false,

      //standard height
      lowWaistHeight2F: 0,
      highWaistHeight2F: 0,
      lowWaistHeight3F: 2.55,
      belowBalconyHeight2F: 2.2,
      betweenHWHeight: 1.5,
      belowBalconyHeight3F: 2.12,

      //tarekabe 2
      tarekabeWidth: null,
      tarekabePoint: null,
      outsideHWheight: 0,
      insideHWheight: 0.268,

      //3FL house
      lowWaist2F: null,
      highWaist2F: null,
      belowBalcony2F: null,
      betweenHW: null,
      thirdFloor: null,
      belowBalcony3F: null,
      total3FArea: null
    }
  },
  
  mounted(){
    if(this.$store.getters.getShioData.kanabakari == "265"){
      this.outsideHWheight = 1.1
      this.lowWaistHeight2F = 2.82
      this.highWaistHeight2F = 2.12
    }else{
      this.outsideHWheight = 1.175
      this.lowWaistHeight2F = 2.63
      this.highWaistHeight2F = 1.93
    }
  },

  methods:{
    computeTarekabe(){
      const HW1 = parseFloat(this.tarekabeWidth) * this.outsideHWheight
      const HW2 = parseFloat(this.tarekabeWidth) * this.insideHWheight
      this.tarekabePoint = HW1 + HW2

      this.tarekabeWidth = null
    },

    compute3FLhouse(){
      const highWaistArea2F = ((parseFloat(this.highWaist2F) || 0) * 0.91) * this.highWaistHeight2F
      const lowWaistArea2F = ((parseFloat(this.lowWaist2F) || 0) * 0.91) * this.lowWaistHeight2F
      const balconyArea2F = ((parseFloat(this.belowBalcony2F) || 0) * 0.91) * this.belowBalconyHeight2F
      const betweenHWArea = ((parseFloat(this.betweenHW) || 0) * 0.91) * this.betweenHWHeight
      const area3F = ((parseFloat(this.thirdFloor) || 0) * 0.91) * this.lowWaistHeight3F
      const balconyArea3F = ((parseFloat(this.belowBalcony3F) || 0) * 0.91) * this.belowBalconyHeight3F

      const totalArea = highWaistArea2F + lowWaistArea2F + balconyArea2F + betweenHWArea + area3F + balconyArea3F
      this.total3FArea = Math.round(totalArea * 100) / 100
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

  input[type=number] {
    -moz-appearance:textfield;
  }

  table {
    width: 100%;
  }
</style>