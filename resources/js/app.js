require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import Vuetify from 'vuetify'
import Routes from './routes'
import store from './store'
import App from './template/App';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    store,
    router:Routes,
    vuetify: new Vuetify(),
    render: h=>h(App)
});