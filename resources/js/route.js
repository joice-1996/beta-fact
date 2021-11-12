window.Vue = require("vue");


import LoginIndex from "../.././app/Modules/Login/Vue/Index.vue";
import LeaveIndex from "../.././app/Modules/Leave/Vue/Index.vue";
import OrderIndex from "../.././app/Modules/Order/Vue/Index.vue";
import DashboardIndex from "../.././app/Modules/Dashboard/Vue/Index.vue";



export const routes = [{
    path: "/",
    name: 'login',
    components: {
        Index: LoginIndex
    }
}, {
    path: "/leave",
    name: 'leave',
    components: {
        Index: LeaveIndex
    }
}, {
    path: "/order",
    name: 'order',
    components: {
        Index: OrderIndex
    }
}, {
    path: "/dashboard",
    name: 'dashboard',
    components: {
        Index: DashboardIndex
    }
}];