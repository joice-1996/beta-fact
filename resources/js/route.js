window.Vue = require("vue");


import LoginIndex from "../.././app/Modules/Login/Vue/Index.vue";
import LeaveIndex from "../.././app/Modules/Leave/Vue/Index.vue";



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
}, ];