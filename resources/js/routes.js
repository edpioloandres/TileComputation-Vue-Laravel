import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter)

import GaihekiArea from './views/GaihekiArea'
import UnitDemado from './views/UnitDemado'
import Balcony from './views/Balcony'
import Column from './views/Column'
import SecondFloorJiku from './views/SecondFloorJiku'
import SecondFloorWaku from './views/SecondFloorWaku'
import SpecialComputations from './views/SpecialComputations'

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: "/gaiheki_area",
            name: "gaiheki_area",
            component: GaihekiArea
        },
        {
            path: "/unit_demado",
            name: "unit_demado",
            component: UnitDemado
        },
        {
            path: "/balcony",
            name: "balcony",
            component: Balcony
        },
        {
            path: "/column",
            name: "column",
            component: Column
        },
        {
            path: "/second_floor_jiku",
            name: "second_floor_jiku",
            component: SecondFloorJiku
        },
        {
            path: "/second_floor_waku",
            name: "second_floor_waku",
            component: SecondFloorWaku
        },
        {
            path: "/special_computations",
            name: "special_computations",
            component: SpecialComputations
        }
    ],
});

export default router