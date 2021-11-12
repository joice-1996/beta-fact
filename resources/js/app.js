require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import { ValidationProvider, extend, ValidationObserver } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import { required } from 'vee-validate/dist/rules';
import VueApexCharts from 'vue-apexcharts';
import axios from 'axios';
Vue.prototype.$hostname = 'http://localhost/beta-fact/public';
Vue.prototype.$axios = axios;
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)


//var csrf_token = $('meta[name="csrf-token"]').attr('content');
Vue.config.productionTip = false




Vue.use(ElementUI, { locale });
extend('required', {
    ...required,
    message: 'This field is required'
});

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

// with typescript
for (let [rule, validation] of Object.entries(rules)) {
    extend(rule, {
        ...validation
    });
}

// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

window.Vue.use(VueRouter);
import {
    routes
} from './route'




const router = new VueRouter({
    routes
})
const app = new Vue({
    router
}).$mount('#app')