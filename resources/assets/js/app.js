require('./bootstrap');
window.Vue = require('vue');


import { Form, HasError, AlertError } from 'vform';
import BootstrapVue, { BCarousel, BCarouselSlide } from 'bootstrap-vue';
import BootstrapVueCSS from 'bootstrap-vue/dist/bootstrap-vue.css';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import './bootstrap'
import Vue from 'vue'
import Vuex from 'vuex'
import 'es6-promise/auto'

//Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
import VueRouter from 'vue-router';
Vue.use(VueRouter)

Vue.use(Vuex)

import vueDebounce from 'vue-debounce';
Vue.use(vueDebounce)

import VueQrcodeReader from "vue-qrcode-reader";
Vue.use(VueQrcodeReader);

Vue.use(BootstrapVue);
Vue.use(BootstrapVueCSS);

import VueQRCodeComponent from 'vue-qrcode-component'

Vue.component('qr-code', VueQRCodeComponent)
Vue.component('inventar', require('./pages/Inventar/Inventar.vue'));

Vue.component('b-carousel', BCarousel, 'b-carousel-slide', BCarouselSlide);

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));


import router from './routes';
const route = new VueRouter({
    router,
    mode:'history',
});

Vue.filter('myDate',function(created){
    return moment(created).format('DD.MM.YYYY');
});

Vue.component('spinner', require('vue-simple-spinner'));


window.Fire =  new Vue();


import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret,faTrashAlt,faEdit,faPlusSquare,faBell,faFlag, faEnvelope, faUsers, faClock, faHome, faLink, faAngleLeft, faBars, faSignOutAlt, faBoxes, faQrcode, faBuilding, faSearch, faPrint, } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUserSecret,faTrashAlt,faEdit,faPlusSquare,faBell,faUsers,faFlag,faEnvelope,faClock,faHome,faLink,faAngleLeft,faBars,faSignOutAlt,faBoxes,faQrcode,faBuilding,faSearch,faPrint)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

import Print from 'vue-print-nb'
Vue.use(Print);

import App from './App.vue';

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')