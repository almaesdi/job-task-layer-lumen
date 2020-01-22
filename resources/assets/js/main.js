require('./bootstrap');

import Vue from 'vue'    //window.Vue = require('vue');
import router from './router'

import App from './components/App.vue'


const app = new Vue({
    el: "#app",
    router,
    render: h => h(App),
});
